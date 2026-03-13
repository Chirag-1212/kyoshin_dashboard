<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Admin extends Auth_controller
{
    protected $userId;
    protected $table;
    protected $imageTable;
    protected $redirect;
    protected $title;

    public function __construct()
    {
        parent::__construct();
        $this->table       = 'news';
        $this->imageTable  = 'news_images';
        $this->title       = 'News';
        $this->redirect    = 'news';
        $this->userId      = $this->data['userId'];
    }

    private function detectTextLanguage(string $text): string
    {
        // Devanagari Unicode block: U+0900–U+097F
        return preg_match('/[\x{0900}-\x{097F}]/u', $text) ? 'np' : 'en';
    }

    private function uploadImage(string $inputName, string $uploadDir, string $oldPath = '')
    {
        if (empty($_FILES[$inputName]['name'])) return $oldPath;

        if (!is_dir($uploadDir)) mkdir($uploadDir, 0777, true);

        $config = [
            'upload_path'   => $uploadDir,
            'allowed_types' => 'jpeg|jpg|png|webp',
            'encrypt_name'  => TRUE,
            'max_size'      => '10240',
        ];

        $this->load->library('upload', $config);
        $this->upload->initialize($config);

        if ($this->upload->do_upload($inputName)) {
            return ltrim($uploadDir, './') . $this->upload->data('file_name');
        }

        $this->session->set_flashdata('error', 'Upload Error: ' . $this->upload->display_errors('', ''));
        return FALSE;
    }

    public function all($page = '')
    {
        $like  = [];
        $param = ['status !=' => '2'];

        if ($search = $this->input->get('table_search')) {
            $like['title_en'] = $search;
            $like['title_jp'] = $search;
        }

        $total = $this->crud_model->total($this->table, $param, $like);
        $config = [
            'base_url'    => base_url($this->redirect . '/admin/all'),
            'total_rows'  => $total,
            'per_page'    => 10,
            'uri_segment' => 4,
            'reuse_query_string' => TRUE
        ];
        $this->pagination->initialize($config);

        $items = $this->crud_model->getData($this->table, $param, $like, $config['per_page'], $page, '*', 'id DESC');

        $data = array_merge($this->data, [
            'title'    => $this->title,
            'page'     => 'list',
            'list'     => $items,
            'redirect' => $this->redirect,
            'pagination' => $this->pagination->create_links(),
        ]);

        $this->load->view('layouts/admin/index', $data);
    }

    public function form($id = '')
    {
        if ($this->input->post()) {
            $titleEn = trim($this->input->post('title_en'));
            $titleNp = trim($this->input->post('title_jp'));

            if (empty($titleEn) && empty($titleNp)) {
                $this->session->set_flashdata('error', 'At least one title is required.');
                redirect($this->redirect . '/admin/form/' . $id);
            }

            $isNew = empty($id);
            $slugSource = !empty($titleEn) ? $titleEn : $titleNp;
            
            // Logic fixed: detect 'np' correctly
            $lang = $this->detectTextLanguage($slugSource);
            $slug = ($lang === 'np') ? 'news-' . ($isNew ? time() : $id) : url_title($slugSource, 'dash', TRUE);

            $mainImagePath = $this->uploadImage('docpath', './uploads/news/main/', $this->input->post('old_docpath'));

            if ($mainImagePath === FALSE) redirect($this->redirect . '/admin/form/' . $id);

            $saveData = [
                'title_en'   => $titleEn,
                'title_jp'   => $titleNp,
                'slug'       => $slug,
                'desc_en'    => $this->input->post('desc_en'),
                'desc_jp'    => $this->input->post('desc_jp'),
                'docpath'    => $mainImagePath,
                'status'     => $this->input->post('status'),
                'updated_on' => date('Y-m-d H:i:s'),
                'updated_by' => $this->userId,
            ];

            if ($isNew) {
                $saveData['created_on'] = date('Y-m-d H:i:s');
                $saveData['created_by'] = $this->userId;
                $newsId = $this->crud_model->insert($this->table, $saveData);
            } else {
                $this->crud_model->update($this->table, $saveData, ['id' => $id]);
                $newsId = $id;
            }

            // Handle Gallery Batch
            if (!empty($_FILES['gallery_images']['name'][0])) {
                $this->load->library('upload');
                foreach ($_FILES['gallery_images']['name'] as $i => $name) {
                    if (empty($name)) continue;
                    $_FILES['gallery_item'] = [
                        'name' => $_FILES['gallery_images']['name'][$i], 'type' => $_FILES['gallery_images']['type'][$i],
                        'tmp_name' => $_FILES['gallery_images']['tmp_name'][$i], 'error' => $_FILES['gallery_images']['error'][$i],
                        'size' => $_FILES['gallery_images']['size'][$i]
                    ];
                    $path = $this->uploadImage('gallery_item', './uploads/news/gallery/');
                    if ($path) {
                        $this->crud_model->insert($this->imageTable, [
                            'news_id' => $newsId, 'docpath' => $path, 'status' => '1',
                            'created_on' => date('Y-m-d H:i:s'), 'created_by' => $this->userId
                        ]);
                    }
                }
            }
            redirect($this->redirect . '/admin/all');
        }

        $data = array_merge($this->data, [
            'title'  => empty($id) ? 'Add ' . $this->title : 'Edit ' . $this->title,
            'page'   => 'form',
            'detail' => $this->crud_model->get_where_single($this->table, ['id' => $id]),
            'gallery_images' => empty($id) ? [] : $this->crud_model->getData($this->imageTable, ['news_id' => $id, 'status !=' => '2'], [], 100, 0, '*', 'id ASC'),
        ]);
        $this->load->view('layouts/admin/index', $data);
    }

    public function soft_delete($id)
    {
        $data = ['status' => '2', 'updated_on' => date('Y-m-d H:i:s'), 'updated_by' => $this->userId];
        $this->crud_model->update($this->table, $data, ['id' => $id]);
        $this->crud_model->update($this->imageTable, $data, ['news_id' => $id]);
        redirect($this->redirect . '/admin/all');
    }
}