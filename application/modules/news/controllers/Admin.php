<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Admin extends Auth_controller
{
    protected $userid;
    protected $table;
    protected $image_table;
    protected $redirect;
    protected $title;

    public function __construct()
    {
        parent::__construct();
        $this->table       = 'news';
        $this->image_table = 'news_images';
        $this->title       = 'news';
        $this->redirect    = 'news/admin';
        $this->userid      = $this->data['userId'];
    }

    private function upload_file($input_name, $upload_dir, $old_path = '')
    {
        if (empty($_FILES[$input_name]['name'])) return $old_path;
        if (!is_dir($upload_dir)) mkdir($upload_dir, 0777, true);

        $config = [
            'upload_path'   => $upload_dir,
            'allowed_types' => 'jpeg|jpg|png|webp',
            'encrypt_name'  => true,
            'max_size'      => '10240',
        ];

        $this->load->library('upload');
        $this->upload->initialize($config);

        if ($this->upload->do_upload($input_name)) {
            return ltrim($upload_dir, './') . $this->upload->data('file_name');
        }
        return $old_path;
    }

    public function all($page = 0)
    {
        $like = [];
        $param = ['status !=' => '2'];

        $search = $this->input->get('table_search', true);
        if ($search) {
            $like['title_en'] = $search;
        }

        $total = $this->crud_model->total($this->table, $param, $like);
        
        $config = [
            'base_url'    => base_url($this->redirect . '/all'),
            'total_rows'  => $total,
            'per_page'    => 10,
            'uri_segment' => 4,
            'reuse_query_string' => true
        ];

        $this->pagination->initialize($config);
        $items = $this->crud_model->getdata($this->table, $param, $like, $config["per_page"], $page, '*', 'id desc');

        $data = array_merge($this->data, [
            'title'       => 'Manage ' . ucfirst($this->title),
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
        if ($this->input->post()) {
            $is_new = empty($id);
            
            // Upload main image (news table)
            $main_path = $this->upload_file('docpath', './uploads/news/main/', $this->input->post('old_docpath'));

            $save_data = [
                'title_en'   => $this->input->post('title_en'),
                'title_jp'   => $this->input->post('title_jp'),
                'desc_en'    => $this->input->post('desc_en'),
                'desc_jp'    => $this->input->post('desc_jp'),
                'docpath'    => $main_path,
                'status'     => $this->input->post('status'),
                'updated_on' => date('Y-m-d H:i:s'),
                'updated_by' => $this->userid,
            ];

            if ($is_new) {
                $save_data['created_on'] = date('Y-m-d H:i:s');
                $save_data['created_by'] = $this->userid;
                $save_data['slug']       = url_title($this->input->post('title_en'), 'dash', true) . '-' . time();
                $id = $this->crud_model->insert($this->table, $save_data);
            } else {
                $this->crud_model->update($this->table, $save_data, ['id' => $id]);
            }

            // Upload related image (news_images table)
            if (!empty($_FILES['news_image']['name'])) {
                $rel_path = $this->upload_file('news_image', './uploads/news/related/');
                if ($rel_path) {
                    $existing = $this->crud_model->get_where_single($this->image_table, ['news_id' => $id]);
                    if ($existing) {
                        $this->crud_model->update($this->image_table, ['docpath' => $rel_path], ['id' => $existing->id]);
                    } else {
                        $this->crud_model->insert($this->image_table, [
                            'news_id'    => $id,
                            'docpath'    => $rel_path,
                            'status'     => 1,
                            'created_on' => date('Y-m-d H:i:s'),
                            'created_by' => $this->userid
                        ]);
                    }
                }
            }

            $this->session->set_flashdata('success', 'News saved successfully.');
            redirect($this->redirect . '/all');
        }

        $data = array_merge($this->data, [
            'title'          => (empty($id) ? 'Add ' : 'Edit ') . ucfirst($this->title),
            'page'           => 'form',
            'detail'         => $id ? $this->crud_model->get_where_single($this->table, ['id' => $id]) : null,
            'related_image'  => $id ? $this->crud_model->get_where_single($this->image_table, ['news_id' => $id, 'status !=' => 2]) : null,
            'redirect'       => $this->redirect
        ]);
        $this->load->view('layouts/admin/index', $data);
    }

    public function soft_delete($id)
    {
        $update_data = [
            'status'     => '2', 
            'updated_on' => date('Y-m-d H:i:s'), 
            'updated_by' => $this->userid
        ];
        $this->crud_model->update($this->table, $update_data, ['id' => $id]);
        $this->crud_model->update($this->image_table, ['status' => '2'], ['news_id' => $id]);
        
        $this->session->set_flashdata('success', 'News deleted successfully.');
        redirect($this->redirect . '/all');
    }
}