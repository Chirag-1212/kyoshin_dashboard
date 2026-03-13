<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Admin extends Auth_controller
{
    protected $table = 'news_images';
    protected $news_table = 'news';
    protected $redirect = 'admin';

    public function __construct()
    {
        parent::__construct();
    }

    public function all($page = 0)
    {
        $param = ['status !=' => '2'];
        $items = $this->crud_model->getData($this->table, $param, [], 50, $page, '*', 'id desc');

        $data = array_merge($this->data, [
            'title' => 'manage news images',
            'page'  => 'list', 
            'list'  => $items,
        ]);
        $this->load->view('layouts/admin/index', $data);
    }

    public function form($id = '')
    {
        if ($this->input->post()) {
            $id = $this->input->post('id');
            $news_id = $this->input->post('news_id');

            // Handle File Upload
            $file_name = $this->input->post('old_docpath');
            if (!empty($_FILES['docpath']['name'])) {
                $config = [
                    'upload_path'   => './uploads/news/',
                    'allowed_types' => 'jpg|jpeg|png|webp',
                    'encrypt_name'  => TRUE
                ];
                $this->load->library('upload', $config);
                if ($this->upload->do_upload('docpath')) {
                    $file_name = 'uploads/news/' . $this->upload->data('file_name');
                }
            }

            $save_data = [
                'news_id'    => $news_id,
                'docpath'    => $file_name,
                'status'     => $this->input->post('status') ?? 1,
                'created_on' => date('Y-m-d H:i:s'),
                'created_by' => $this->data['userId']
            ];

            if (empty($id)) {
                $this->crud_model->insert($this->table, $save_data);
            } else {
                $this->crud_model->update($this->table, $save_data, ['id' => $id]);
            }
            redirect($this->redirect . '/all');
        }

        $data = array_merge($this->data, [
            'title'  => 'add/edit image',
            'page'   => 'form', 
            'news'   => $this->crud_model->get_where($this->news_table, ['status' => '1']),
            'detail' => $this->crud_model->get_where_single($this->table, ['id' => $id])
        ]);
        $this->load->view('layouts/admin/index', $data);
    }

    public function soft_delete($id)
    {
        $this->crud_model->update($this->table, ['status' => '2'], ['id' => $id]);
        redirect($this->redirect . '/all');
    }
}