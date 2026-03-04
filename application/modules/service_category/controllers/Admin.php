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
        $this->table = 'service_category';
        $this->redirect = 'service_category';
        $this->title = 'Service Category';
        $this->userId = $this->data['userId'];
    }

    public function all($page = '')
    {
        $like = [];
        $param = ['status !=' => '2'];

        // FIXED: Using lowercase 'title' to match your DB
        if($this->input->get('table_search')){
            $search = $this->input->get('table_search');
            $like['title'] = $search; 
        }

        $total = $this->crud_model->total($this->table, $param, $like);
        
        // Pagination Config (Your custom styles kept)
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
            'delete_link' => $this->redirect . '/admin/soft_delete/',
            'pagination' => $this->pagination->create_links(),
            'offset' => $page
        ]);
        
        $this->load->view('layouts/admin/index', $data);
    }

    public function form($id = '')
    {
        $detail = $this->crud_model->get_where_single($this->table, array('id' => $id));
        
        if ($this->input->post()) {
            $this->form_validation->set_rules('title', 'Title', 'required|trim');
            if ($this->form_validation->run()) {
                $id = $this->input->post('id');

                // FIXED: Include parent_id and status in save_data
                $save_data = [
                    'title'     => $this->input->post('title'),
                    'parent_id' => $this->input->post('parent_id'),
                    'status'    => $this->input->post('status')
                ];

                if ($id == '') {
                    $slug = $this->crud_model->createUrlSlug($this->input->post('title'));
                    $check_slug = $this->crud_model->get_where_single($this->table, array('slug' => $slug));
                    $save_data['slug'] = empty($check_slug) ? strtolower($slug) : (strtolower($slug) . '-' . time());
                    
                    $save_data['created_on'] = date('Y-m-d');
                    $save_data['created_by'] = $this->userId;
                    $result = $this->crud_model->insert($this->table, $save_data);
                } else {
                    $save_data['updated_on'] = date('Y-m-d');
                    $save_data['updated_by'] = $this->userId;
                    $result = $this->crud_model->update($this->table, $save_data, array('id' => $id));
                }

                if ($result) {
                    $this->session->set_flashdata('success', 'Saved Successfully.');
                    redirect($this->redirect . '/admin/all');
                }
            }
        }

        $data['detail'] = $detail;
        $data['title'] = ($detail) ? 'Edit ' . $this->title : 'Add ' . $this->title;
        $data['page'] = 'form';
        $selected_parent = (isset($detail->parent_id)) ? $detail->parent_id : 0;
        $data['html'] = $this->get_parents_html($selected_parent);
        
        $this->load->view('layouts/admin/index', array_merge($this->data, $data));
    }

    public function get_parents_html($selected_parent = 0)
    {
        $html = '<option value="0">Main Category</option>';
        $parents = $this->db->get_where($this->table, array('status' => '1', 'parent_id' => 0))->result();
        
        if ($parents) {
            foreach ($parents as $value) {
                // FIXED: lowercase $value->title
                $sel = ($value->id == $selected_parent) ? "selected" : "";
                $html .= '<option value="' . $value->id . '" ' . $sel . '>' . $value->title . '</option>';
                
                $childs = $this->db->get_where($this->table, array('parent_id' => $value->id, 'status' => '1'))->result();
                if (!empty($childs)) {
                    $html .= $this->get_childs($childs, $selected_parent, '&nbsp;&nbsp;&nbsp;-- ');
                }
            }
        }
        return $html;
    }

    // Recursive helper for sub-categories
    public function get_childs($childs, $selected_parent, $space)
    {
        $html = '';
        foreach ($childs as $value) {
            $sel = ($value->id == $selected_parent) ? "selected" : "";
            $html .= '<option value="' . $value->id . '" ' . $sel . '>' . $space . $value->title . '</option>';
            
            $sub_childs = $this->db->get_where($this->table, array('parent_id' => $value->id, 'status' => '1'))->result();
            if (!empty($sub_childs)) {
                $html .= $this->get_childs($sub_childs, $selected_parent, $space . '&nbsp;&nbsp;');
            }
        }
        return $html;
    }

    public function soft_delete($id)
    {
        if (empty($id)) {
            $this->session->set_flashdata('error', 'Select At least One');
            redirect($this->redirect . '/admin/all');
        }
        
        $result = $this->crud_model->update($this->table, ['status' => '2'], ['id' => $id]);
        if ($result) {
            $this->session->set_flashdata('success', 'Successfully Deleted.');
        } else {
            $this->session->set_flashdata('error', 'Unable To Delete.');
        }
        redirect($this->redirect . '/admin/all');
    }
}