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
        // Updated table and naming conventions
        $this->table = 'about_us'; 
        $this->title = 'About Us';
        $this->redirect = 'about'; 
        $this->userId = $this->data['userId'];
    }

    public function all($page = '')
    {
        $like = [];
        $param = [
            'status !=' => '2'
        ];

        if($this->input->method() == 'get'){
            $search = $this->input->get('table_search');
            $like['title'] = $search; // Standardized to lowercase 'title'
        }

        $total = $this->crud_model->total($this->table, $param, $like);
        
        // Pagination Config
        $config['base_url'] = base_url($this->redirect . '/admin/all');
        $config['total_rows'] = $total;
        $config['uri_segment'] = 4;
        $config['per_page'] = 10;
        $config['full_tag_open'] = '<ul class="pagination pagination-sm m-0 float-right">';
        $config['first_link'] = 'First';
        $config['first_tag_open'] = '<li class="page-item">';
        $config['first_tag_close'] = '</li>';
        $config['num_tag_open'] = '<li class="page-item">';
        $config['attributes'] = array('class' => 'page-link');
        $config['num_tag_close'] = '</li>';
        $config['next_link'] = 'Next';
        $config['next_tag_open'] = '<li class="page-item">';
        $config['next_tag_close'] = '</li>';
        $config['prev_link'] = 'Prev';
        $config['prev_tag_open'] = '<li class="page-item">';
        $config['prev_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li class="page-item active"><a class="page-link">';
        $config['cur_tag_close'] = '</a></li>';
        $config['last_link'] = 'Last';
        $config['last_tag_open'] = '<li class="page-item">';
        $config['last_tag_close'] = '</li>';
        $config['full_tag_close'] = '</ul>';
        $config['suffix'] = isset($search) ? "?table_search=$search" : '';

        $this->pagination->initialize($config);

        $page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
        $items = $this->crud_model->getData($this->table, $param, $like, $config["per_page"], $page, '*', 'id DESC');
        
        $data = array_merge($this->data, [
            'title' => $this->title,
            'page' => 'list',
            'items' => $items,
            'redirect' => $this->redirect,
            'form_link' => $this->redirect . '/admin/form/',
            'form_check_value' => 'form',
            'delete_link' => $this->redirect . '/admin/soft_delete/',
            'delete_check_value' => 'soft_delete',
            'pagination' => $this->pagination->create_links(),
            'active_menu' => 'about-all',
            'offset' => $page
        ]);
        
        $this->load->view('layouts/admin/index', $data);
    }

    public function form($id = '')
    {
        $data['detail'] = $this->crud_model->get_where_single($this->table, array('id' => $id));
        $upload_path = 'uploads/about/'; // Specific folder for About Us images

        if ($this->input->post()) {
            $this->form_validation->set_rules('title', 'Title', 'required|trim');
            $this->form_validation->set_rules('description', 'Content Description', 'required|trim');

            if ($this->form_validation->run()) {
                $id = $this->input->post('id');

                // Handle Image Upload
                if (!empty($_FILES['image']['name'])) {
                    $config['upload_path'] = $upload_path;
                    $config['allowed_types'] = 'jpeg|jpg|png|webp';
                    $config['max_size'] = '5000'; // 5MB limit for images
                    $config['encrypt_name'] = TRUE;

                    $this->load->library('upload', $config);

                    if (!$this->upload->do_upload('image')) {
                        $this->session->set_flashdata('error', $this->upload->display_errors());
                        redirect($this->redirect . '/admin/form/' . $id);
                    } else {
                        $file = $this->upload->data();
                        $file_name = $upload_path . $file['file_name'];
                    }
                } else {
                    $file_name = $this->input->post('old_image');
                }

                $update_data = array(
                    'title'       => $this->input->post('title'),
                    'description' => $this->input->post('description'),
                    'image'       => $file_name,
                    'status'      => $this->input->post('status'),
                    'updated_on'  => date('Y-m-d H:i:s'),
                    'updated_by'  => $this->userId
                );

                if ($id == '') {
                    $update_data['created_on'] = date('Y-m-d H:i:s');
                    $update_data['created_by'] = $this->userId;
                    $result = $this->crud_model->insert($this->table, $update_data);
                    $msg = 'Successfully Inserted.';
                } else {
                    $result = $this->crud_model->update($this->table, $update_data, array('id' => $id));
                    $msg = 'Successfully Updated.';
                }

                if ($result) {
                    $this->session->set_flashdata('success', $msg);
                    redirect($this->redirect . '/admin/all');
                } else {
                    $this->session->set_flashdata('error', 'Action Failed.');
                    redirect($this->redirect . '/admin/form/' . $id);
                }
            }
        }

        $data['title'] = ($id == '') ? 'Add ' . $this->title : 'Edit ' . $this->title;
        $data['active_menu'] = 'about-form';
        $data['page'] = 'form';
        $data = array_merge($this->data, $data);
        
        $this->load->view('layouts/admin/index', $data);
    }

    public function soft_delete($id)
    {
        if (!$id) {
            $this->session->set_flashdata('error', 'Invalid ID');
            redirect($this->redirect . '/admin/all');
        }

        $result = $this->crud_model->update($this->table, ['status' => '2'], ['id' => $id]);
        
        if ($result) {
            $this->session->set_flashdata('success', 'Entry removed successfully.');
        } else {
            $this->session->set_flashdata('error', 'Unable to delete.');
        }
        redirect($this->redirect . '/admin/all');
    }
}