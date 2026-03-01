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
        $this->table = 'our_courses';
        $this->title = 'Our Courses';
        $this->redirect = 'courses'; 
        $this->userId = $this->data['userId'];
    }

    public function all($page = 0)
    {
        $like = [];
        $param = ['status !=' => '2']; // Hide soft-deleted items

        // 1. Handle Search Filters
        $search = $this->input->get('Title');
        $status = $this->input->get('status');
        $date_from = $this->input->get('date_from');
        $date_to   = $this->input->get('date_to');

        if ($search) {
            $like['title_en'] = $search;
            $like['title_jp'] = $search;
        }
        if ($status !== null && $status !== '') {
            $param['status'] = $status;
        }
        if ($date_from) $param['created_on >='] = $date_from . ' 00:00:00';
        if ($date_to)   $param['created_on <='] = $date_to . ' 23:59:59';

        // 2. Pagination Configuration
        $total = $this->crud_model->total($this->table, $param, $like);
        
        $get_params = $_GET;
        $search_query = http_build_query($get_params);

        $config = [
            'base_url'    => base_url($this->redirect . '/admin/all'),
            'total_rows'  => $total,
            'per_page'    => 10,
            'uri_segment' => 4,
            'suffix'      => $search_query ? '?' . $search_query : '',
            'first_url'   => base_url($this->redirect . '/admin/all') . ($search_query ? '?' . $search_query : '')
        ];

        $this->pagination->initialize($config);
        
        // 3. Fetch Data
        // IMPORTANT: Use $page as the offset
        $items = $this->crud_model->getData($this->table, $param, $like, $config["per_page"], $page, '*', 'id DESC');
        
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
                $file_name = $this->input->post('old_docpath');

                if (!empty($_FILES['docpath']['name'])) {
                    $config = [
                        'upload_path'   => 'uploads/courses/',
                        'allowed_types' => 'jpeg|jpg|png|webp',
                        'encrypt_name'  => TRUE
                    ];
                    $this->load->library('upload', $config);

                    if ($this->upload->do_upload('docpath')) {
                        $file = $this->upload->data();
                        $file_name = 'uploads/courses/' . $file['file_name'];
                    }
                }

                $slug = url_title($this->input->post('title_en'), 'dash', TRUE);

                $update_data = [
                    'title_en'    => $this->input->post('title_en'),
                    'title_jp'    => $this->input->post('title_jp'),
                    'slug'        => $slug,
                    'sub_level'   => $this->input->post('sub_level'),
                    'sub_text_en' => $this->input->post('sub_text_en'),
                    'sub_text_jp' => $this->input->post('sub_text_jp'),
                    'desc_en'     => $this->input->post('desc_en'),
                    'desc_jp'     => $this->input->post('desc_jp'),
                    'docpath'     => $file_name,
                    'status'      => $this->input->post('status'), 
                    'updated_on'  => date('Y-m-d H:i:s'),
                    'updated_by'  => $this->userId
                ];

                $post_id = $this->input->post('id');
                $final_id = !empty($id) ? $id : $post_id;

                if (empty($final_id)) {
                    $update_data['created_on'] = date('Y-m-d H:i:s');
                    $update_data['created_by'] = $this->userId;
                    $this->crud_model->insert($this->table, $update_data);
                    $this->session->set_flashdata('success', 'Information added successfully');
                } else {
                    $this->crud_model->update($this->table, $update_data, ['id' => $final_id]);
                    $this->session->set_flashdata('success', 'Information updated successfully');
                }

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

    public function delete($id)
    {
        if ($id) {
            $this->crud_model->update($this->table, ['status' => '2'], ['id' => $id]);
            $this->session->set_flashdata('success', 'Deleted successfully');
        }
        redirect($this->redirect . '/admin/all');
    }
}