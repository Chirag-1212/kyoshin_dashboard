<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Admin extends Auth_controller
{
    protected $table;
    protected $news_table;
    protected $redirect;
    protected $userId;
    protected $title;

    public function __construct()
    {
        parent::__construct();
        $this->table      = 'news_images';
        $this->news_table = 'news';
        $this->title      = 'news images';
        $this->redirect   = 'news_image/admin'; 
        $this->userId     = isset($this->data['userId']) ? $this->data['userId'] : 0;
    }

    public function all($page = 0)
    {
        $like = [];
        $param = [$this->table . '.status !=' => '2'];

        $search = $this->input->get('table_search', TRUE);
        if ($search) {
            $like['description'] = $search;
        }

        $total = $this->crud_model->total($this->table, $param, $like);
        
        $config = [
            'base_url'    => base_url($this->redirect . '/all'),
            'total_rows'  => $total,
            'per_page'    => 20,
            'uri_segment' => 4,
            'reuse_query_string' => TRUE,
            'full_tag_open'    => '<ul class="pagination pagination-sm m-0 float-right">',
            'full_tag_close'   => '</ul>',
            'num_tag_open'     => '<li class="page-item">',
            'num_tag_close'    => '</li>',
            'cur_tag_open'     => '<li class="page-item active"><a class="page-link">',
            'cur_tag_close'    => '</a></li>',
            'attributes'       => ['class' => 'page-link'],
            'first_link'       => 'first',
            'last_link'        => 'last',
            'next_link'        => 'next',
            'prev_link'        => 'prev'
        ];

        $this->pagination->initialize($config);
        $page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;

        $items = $this->crud_model->getData($this->table, $param, $like, $config["per_page"], $page, '*', 'id desc');

        $data = array_merge($this->data, [
            'title'       => 'manage ' . $this->title,
            'page'        => 'list',
            'items'       => $items,
            'redirect'    => $this->redirect,
            'pagination'  => $this->pagination->create_links(),
            'offset'      => $page,
        ]);

        $this->load->view('layouts/admin/index', $data);
    }

    public function form($id = '')
    {
        $doc_path = 'uploads/news/';
        $detail = (!empty($id)) ? $this->crud_model->get_where_single($this->table, ['id' => $id]) : null;

        if ($this->input->post()) {
            // news_id is no longer required
            $this->form_validation->set_rules('description', 'description', 'trim');
            
            if ($this->form_validation->run()) {
                $post_id = $this->input->post('id');
                $file_name = $this->input->post('old_docpath');
                
                if (!empty($_FILES['docpath']['name'])) {
                    if (!is_dir($doc_path)) mkdir($doc_path, 0777, true);

                    $config_up = [
                        'upload_path'   => './' . $doc_path,
                        'allowed_types' => 'jpg|jpeg|png|webp',
                        'encrypt_name'  => TRUE,
                        'max_size'      => 5120 
                    ];
                    
                    $this->load->library('upload', $config_up);
                    if ($this->upload->do_upload('docpath')) {
                        if (!empty($file_name) && file_exists('./' . $file_name)) {
                            unlink('./' . $file_name);
                        }
                        $file_name = $doc_path . $this->upload->data('file_name');
                    }
                }

                $save_data = [
                    'news_id'     => $this->input->post('news_id') ?: null,
                    'description' => $this->input->post('description'),
                    'docpath'     => $file_name,
                    'status'      => ($this->input->post('status') !== null) ? $this->input->post('status') : 1,
                ];

                if (empty($post_id)) {
                    $save_data['created_on'] = date('Y-m-d H:i:s');
                    $save_data['created_by'] = $this->userId;
                    $this->crud_model->insert($this->table, $save_data);
                    $this->session->set_flashdata('success', 'added successfully.');
                } else {
                    $this->crud_model->update($this->table, $save_data, ['id' => $post_id]);
                    $this->session->set_flashdata('success', 'updated successfully.');
                }
                redirect($this->redirect . '/all');
            }
        }

        $data = array_merge($this->data, [
            'title'    => (empty($id) ? 'add ' : 'edit ') . $this->title,
            'page'     => 'form', 
            'detail'   => $detail,
            'redirect' => $this->redirect
        ]);
        
        $this->load->view('layouts/admin/index', $data);
    }

    public function soft_delete($id)
    {
        $update = [
            'status'     => '2', 
            'updated_on' => date('Y-m-d H:i:s'), 
            'updated_by' => $this->userId
        ];
        
        if ($this->crud_model->update($this->table, $update, ['id' => $id])) {
            $this->session->set_flashdata('success', 'News Item Deleted.');
        } else {
            $this->session->set_flashdata('error', 'Unable to delete item.');
        }
        redirect($this->redirect . '/all');
    }
}