<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Admin extends Auth_controller
{
    protected $userId;
    protected $table;
    protected $redirect;
    protected $title;

    public function __construct()
    {
        parent::__construct();
        $this->table    = 'job_category'; 
        $this->title    = 'Job Category';
        $this->redirect = 'jobs'; 
        $this->userId   = $this->data['userId'];
    }

    public function all($page = 0)
    {
        $like  = [];
        $param = ['status !=' => '2']; 

        if ($search = $this->input->get('table_search')) {
            $like['title_en'] = $search;
            $like['title_jp'] = $search;
        }

        $total  = $this->crud_model->total($this->table, $param, $like);
        $config = [
            'base_url'    => base_url($this->redirect . '/admin/all'),
            'total_rows'  => $total,
            'per_page'    => 10,
            'uri_segment' => 4,
            'suffix'      => $search ? "?table_search=$search" : ''
        ];

        $this->pagination->initialize($config);
        $items = $this->crud_model->getData($this->table, $param, $like, $config["per_page"], (int)$page, '*', 'id DESC');
        
        $data = array_merge($this->data, [
            'title'            => $this->title,
            'page'             => 'list',
            'list'             => $items,
            'redirect'         => $this->redirect,
            'form_link'        => $this->redirect . '/admin/form',
            'form_check_value' => 'form',
            'pagination'       => $this->pagination->create_links()
        ]);
        
        $this->load->view('layouts/admin/index', $data);
    }

    public function form($id = '')
    {
        if ($this->input->post()) {
            $this->form_validation->set_rules('title_en', 'Title', 'required|trim');

            if ($this->form_validation->run()) {
                $id        = $this->input->post('id');
                $file_name = $this->input->post('old_docpath');

                if (!empty($_FILES['docpath']['name'])) {
                    $config = [
                        'upload_path'   => './uploads/jobs/', 
                        'allowed_types' => 'jpeg|jpg|png|webp',
                        'encrypt_name'  => TRUE,
                        'max_size'      => '10240'
                    ];
                    
                    if (!is_dir($config['upload_path'])) {
                        mkdir($config['upload_path'], 0777, TRUE);
                    }

                    $this->load->library('upload', $config);

                    if ($this->upload->do_upload('docpath')) {
                        $file      = $this->upload->data();
                        $file_name = 'uploads/jobs/' . $file['file_name'];
                        
                        if (!empty($this->input->post('old_docpath')) && file_exists($this->input->post('old_docpath'))) {
                            unlink($this->input->post('old_docpath'));
                        }
                    }
                }
                
                $update_data = [
                    'title_en'   => $this->input->post('title_en'),
                    'title_jp'   => $this->input->post('title_jp'),
                    'desc_en'    => $this->input->post('desc_en'),
                    'desc_jp'    => $this->input->post('desc_jp'),
                    'slug'       => url_title($this->input->post('title_en'), 'dash', TRUE),
                    'docpath'    => $file_name,
                    'status'     => (string)$this->input->post('status'),
                    'updated_on' => date('Y-m-d H:i:s'),
                    'updated_by' => $this->userId
                ];

                if (empty($id)) {
                    $update_data['created_on'] = date('Y-m-d H:i:s');
                    $update_data['created_by'] = $this->userId;
                    $this->crud_model->insert($this->table, $update_data);
                } else {
                    $this->crud_model->update($this->table, $update_data, ['id' => $id]);
                }

                $this->session->set_flashdata('success', 'Information updated successfully');
                redirect($this->redirect . '/admin/all');
            }
        }

        $data = array_merge($this->data, [
            'detail'   => $this->crud_model->get_where_single($this->table, ['id' => $id]),
            'title'    => ($id == '') ? 'Add ' . $this->title : 'Edit ' . $this->title,
            'page'     => 'form',
            'redirect' => $this->redirect
        ]);
        
        $this->load->view('layouts/admin/index', $data);
    }

    public function soft_delete($id)
    {
        $data = ['status' => '2', 'updated_by' => $this->userId, 'updated_on' => date('Y-m-d H:i:s')];
        $this->crud_model->update($this->table, $data, ['id' => $id]);
        $this->session->set_flashdata('success', 'Successfully Deleted.');
        redirect($this->redirect . '/admin/all');
    }
}