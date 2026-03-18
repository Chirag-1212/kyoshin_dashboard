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
        $this->table = 'feedback_message';
        $this->title = 'Feedback Message';
        $this->redirect = 'feedback';
        $this->userId = $this->data['userId'];
    }

    public function all($page = '')
    {
        $config['base_url'] = base_url($this->redirect . '/admin/all');
        $config['total_rows'] = $this->crud_model->count_all($this->table, array('status !=' => '2'), 'id');
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

        $this->pagination->initialize($config);

        $page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;

        $items = $this->crud_model->get_where_pagination($this->table, array('status !=' => '2'), $config['per_page'], $page);
        
        $data = array_merge($this->data, [
            'title' => $this->title . ' List',
            'page' => 'list',
            'items' => $items,
            'redirect' => $this->redirect,
            'pagination' =>  $this->pagination->create_links(),
            'form_link' => $this->redirect . '/admin/form/',
            'form_check_value' => 'form',
            'delete_link' => $this->redirect . '/admin/soft_delete/',
            'delete_check_value' => 'soft_delete',
            'feedback' => 'feedback-all',
            'offset' => $page
        ]);

        $this->load->view('layouts/admin/index', $data);
    } 

    public function soft_delete($id)
    {
        if ($id == '' || $id == 0) {
            $this->session->set_flashdata('error', 'Select Atleast One');
            redirect($this->redirect . '/admin/all');
        }
        $update_data = array(
            'status' => '2',
            'updated_on' => date('Y-m-d')
        );
        $result = $this->crud_model->update($this->table, $update_data, array('id' => $id));
        if ($result == true) {
            $this->session->set_flashdata('success', 'Successfully Deleted.');
        } else {
            $this->session->set_flashdata('error', 'Unable To Delete.');
        }
        redirect($this->redirect . '/admin/all');
    } 
    
    public function view($id)
    {
        $detail = $this->crud_model->get_where_single($this->table, array('id' => $id));    
        
        $data['detail'] = $detail;
        $data['title'] = 'View ' . $this->title;
        $data['page'] = 'view';
        $data['feedback'] = 'feedback-all';
        $data['redirect'] = $this->redirect;
        
        $data = array_merge($this->data, $data);
        $this->load->view('layouts/admin/index', $data);
    }
}