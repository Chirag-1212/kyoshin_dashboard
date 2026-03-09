<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Admin extends Auth_controller
{
    protected $userId, $table, $redirect, $title;

    public function __construct()
    {
        parent::__construct();
        $this->table = 'news';
        $this->title = 'News';
        $this->redirect = 'news';
        $this->userId = $this->data['userId'];
    }

    public function all()
    {
        $search = $this->input->get('table_search');
        $param = ['status !=' => '2'];
        $like = $search ? ['title' => $search] : [];

        // Pagination Config
        $config = [
            'base_url' => base_url($this->redirect . '/admin/all'),
            'total_rows' => $this->crud_model->total($this->table, $param, $like),
            'per_page' => 10,
            'uri_segment' => 4,
            'full_tag_open' => '<ul class="pagination pagination-sm m-0 float-right">',
            'full_tag_close' => '</ul>', 
            'attributes' => ['class' => 'page-link'],
            'num_tag_open' => '<li class="page-item">',
            'num_tag_close' => '</li>',
            'cur_tag_open' => '<li class="page-item active"><a class="page-link">',
            'cur_tag_close' => '</a></li>',
            'suffix' => $search ? "?table_search=$search" : ''
        ];
        
        $this->pagination->initialize($config);
        $page = $this->uri->segment(4) ?: 0;

        $data = array_merge($this->data, [
            'title' => $this->title,
            'page' => 'list',
            'list' => $this->crud_model->getData($this->table, $param, $like, $config["per_page"], $page),
            'redirect' => $this->redirect,
            'form_link' => $this->redirect . '/admin/form/',
            'delete_link' => $this->redirect . '/admin/soft_delete/',
            'pagination' => $this->pagination->create_links(),
            'offset' => $page
        ]);
        $this->load->view('layouts/admin/index', $data);
    }

    public function form($id = '')
    {
        $detail = $this->crud_model->get_where_single($this->table, ['id' => $id]);
        $path = 'uploads/news/';

        if ($this->input->post()) {
            $this->form_validation->set_rules('title', 'Title', 'required|trim');
            
            if ($this->form_validation->run()) {
                $post_id = $this->input->post('id');
                
                // Simplified File Uploads
                $doc_path = $this->_handle_upload('docpath', $path, @$detail->docpath);
                $cover_img = $this->_handle_upload('coverimage', $path, @$detail->coverimage);

                $save_data = [
                    'datevalue' => $this->input->post('datevalue'),
                    'due_date' => $this->input->post('due_date'),
                    'coverimage' => $cover_img,
                    'docpath' => $doc_path,
                    'title' => $this->input->post('title'),
                    'title_nepali' => $this->input->post('title_nepali'),
                    'description' => $this->input->post('description'),
                    'description_nepali' => $this->input->post('description_nepali'),
                    'is_slider' => $this->input->post('is_slider') ? '1' : '2',
                    'status' => $this->input->post('status'),
                    'imp_notice' => $this->input->post('imp_notice') ? '1' : '2',
                ];

                // Slug logic (Unified for both Insert and Update)
                $slug_text = $this->crud_model->detectTextLanguage($save_data['title']) ? $save_data['title'] : $this->title . time();
                $slug = strtolower($this->crud_model->createUrlSlug($slug_text));
                $save_data['slug'] = $this->crud_model->get_where_single($this->table, ['slug' => $slug]) ? $slug . time() : $slug;

                if (empty($post_id)) {
                    $save_data['created_on'] = date('Y-m-d H:i:s');
                    $save_data['created_by'] = $this->userId;
                    $db_id = $this->crud_model->inserted($this->table, $save_data);
                } else {
                    $save_data['updated_on'] = date('Y-m-d');
                    $save_data['updated_by'] = $this->userId;
                    $this->crud_model->update($this->table, $save_data, ['id' => $post_id]);
                    $db_id = $post_id;
                }

                // Handle Multiple Gallery Images
                if ($db_id) $this->_handle_gallery($db_id, $path);

                $this->session->set_flashdata($db_id ? 'success' : 'error', $db_id ? 'Operation Successful' : 'Operation Failed');
                redirect($this->redirect . '/admin/all');
            }
        }

        $data = [
            'title' => ($detail ? 'Edit ' : 'Add ') . $this->title,
            'detail' => $detail,
            'items' => $this->crud_model->get_where('news_images', ['status !=' => '2', 'news_id' => $id]),
            'doc_path' => $path,
            'page' => 'form'
        ];
        $this->load->view('layouts/admin/index', array_merge($this->data, $data));
    }

    // --- Private Helpers to keep code clean ---

    private function _handle_upload($field, $path, $existing) {
        if (!empty($_FILES[$field]['name'])) {
            $config = ['upload_path' => $path, 'allowed_types' => 'jpeg|jpg|png|pdf', 'max_size' => '5120'];
            $this->load->library('upload');
            $this->upload->initialize($config);
            if ($this->upload->do_upload($field)) {
                $data = $this->upload->data();
                return $path . $data['file_name'];
            }
        }
        return $existing ?: "";
    }

    private function _handle_gallery($news_id, $path) {
        if (!empty($_FILES['files']['name'][0])) {
            $filesCount = count($_FILES['files']['name']);
            $uploadData = [];
            for ($i = 0; $i < $filesCount; $i++) {
                $_FILES['file']['name']     = $_FILES['files']['name'][$i];
                $_FILES['file']['type']     = $_FILES['files']['type'][$i];
                $_FILES['file']['tmp_name'] = $_FILES['files']['tmp_name'][$i];
                $_FILES['file']['error']    = $_FILES['files']['error'][$i];
                $_FILES['file']['size']     = $_FILES['files']['size'][$i];

                $config = ['upload_path' => $path, 'allowed_types' => 'jpg|jpeg|png|gif'];
                $this->upload->initialize($config);
                if ($this->upload->do_upload('file')) {
                    $fileData = $this->upload->data();
                    $uploadData[] = [
                        'docpath' => $path . $fileData['file_name'],
                        'news_id' => $news_id,
                        'status' => '1',
                        'created_on' => date("Y-m-d H:i:s")
                    ];
                }
            }
            if (!empty($uploadData)) $this->crud_model->insertarr('news_images', $uploadData);
        }
    }

    public function soft_delete($id)
    {
        if ($id == '' || $id == 0) {
            $this->session->set_flashdata('error', 'Select Atleast One');
            redirect($this->redirect . '/admin/all');
        }
        $data = array(
            'status' => '2',
        );
        $result = $this->crud_model->update($this->table, $data, array('id' => $id));
        if ($result == true) {
            $this->session->set_flashdata('success', 'Successfully Deleted.');
            redirect($this->redirect . '/admin/all');
        } else {
            $this->session->set_flashdata('error', 'Unable To Delete.');
            redirect($this->redirect . '/admin/all');
        }
    }
}