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
        
        $this->table = 'service'; 
        $this->redirect = $this->uri->segment(1); 
        $this->title = ucfirst(str_replace('_', ' ', $this->redirect));
        $this->userId = $this->data['userId'];
    }

    public function all($page = '')
    {
        $search = $this->input->get('table_search');
        
        // 1. Calculate Total (Manual query to avoid Model conflicts)
        $this->db->from($this->table);
        $this->db->where('status !=', '2');
        $this->db->where('category', $this->redirect);
        if($search){
            $this->db->like('title_en', $search);
        }
        $total = $this->db->count_all_results();

        // 2. Pagination Config
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
        $config['suffix'] = $search ? "?table_search=$search" : '';
        
        $this->pagination->initialize($config);
        $page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;

        // 3. FETCH DATA WITH JOIN (Bypassing Model to avoid the error)
        $this->db->select('service.*, service_category.title as category_name');
        $this->db->from('service');
        $this->db->join('service_category', 'service_category.id = service.service_category_id', 'left');
        $this->db->where('service.status !=', '2');
        $this->db->where('service.category', $this->redirect);
        
        if($search){
            $this->db->like('service.title_en', $search);
        }
        
        $this->db->limit($config['per_page'], $page);
        $this->db->order_by('service.id', 'DESC');
        $items = $this->db->get()->result();

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
        $doc_path = 'uploads/services/';
        
        if ($this->input->post()) {
            $this->form_validation->set_rules('title_en', 'Title', 'required|trim');
            if ($this->form_validation->run()) {
                $id = $this->input->post('id');
                $file_name = $this->handle_upload('docpath', $doc_path, @$detail->docpath);
                $image_name = $this->handle_upload('image', $doc_path, @$detail->image);
                $cover_name = $this->handle_upload('coverimage', $doc_path, @$detail->coverimage);

                $save_data = array(
                    'category' => $this->redirect,
                    'docpath' => $file_name,
                    'image' => $image_name,
                    'coverimage' => $cover_name,
                    'datevalue' => $this->input->post('datevalue'),
                    'title_en' => $this->input->post('title_en'),
                    'title_jp' => $this->input->post('title_jp'),
                    'desc_en' => $this->input->post('desc_en'),
                    'desc_jp' => $this->input->post('desc_jp'),
                    'link' => $this->input->post('link'),
                    'serial' => $this->input->post('serial'),
                    'service_category_id' => $this->input->post('service_category_id'),
                    'status' => $this->input->post('status'),
                );

                if ($id == '') {
                    $slug = $this->crud_model->createUrlSlug($this->input->post('title_en'));
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
                    $this->session->set_flashdata('success', 'Operation Successful.');
                    redirect($this->redirect . '/admin/all');
                } else {
                    $this->session->set_flashdata('error', 'Operation Failed.');
                    redirect($this->redirect . '/admin/form/' . $id);
                }
            }
        }

        $selected_parent = isset($detail->service_category_id) ? $detail->service_category_id : '';
        $data['detail'] = $detail;
        $data['html'] = $this->get_parents_html($selected_parent);
        $data['doc_path'] = $doc_path;
        $data['page'] = 'form';
        $view_data = array_merge($this->data, $data);
        $this->load->view('layouts/admin/index', $view_data);
    }

    private function handle_upload($field, $path, $old_value) {
        if (isset($_FILES[$field]['name']) && strlen($_FILES[$field]['name']) > 0) {
            $config['upload_path'] = $path;
            $config['allowed_types'] = 'jpeg|jpg|gif|png|pdf';
            $config['max_size'] = '5120'; 
            $this->load->library('upload');
            $this->upload->initialize($config); 
            if ($this->upload->do_upload($field)) {
                $file = $this->upload->data();
                return $path . $file['file_name'];
            }
        }
        return $old_value ? $old_value : "";
    }

    public function get_parents_html($selected_parent = '') {
        $html = '<option value="">Select Category Name</option>';
        $parents = $this->db->get_where('service_category', array('status' => '1', 'parent_id' => 0))->result();
        if ($parents) {
            foreach ($parents as $value) {
                $selected = ($value->id == $selected_parent) ? "selected" : "";
                $html .= '<option value="' . $value->id . '" ' . $selected . '>' . $value->title . '</option>';
                $childs = $this->db->get_where('service_category', array('parent_id' => $value->id, 'status' => '1'))->result();
                if (!empty($childs)) {
                    $html .= $this->get_childs($childs, $selected_parent, '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;');
                }
            }
        }
        return $html;
    }

    public function get_childs($childs, $selected_parent, $space) {
        $html = '';
        foreach ($childs as $value) {
            $selected = ($value->id == $selected_parent) ? "selected" : "";
            $html .= '<option value="' . $value->id . '" ' . $selected . '>' . $space . $value->title . '</option>';
            $new_childs = $this->db->get_where('service_category', array('parent_id' => $value->id, 'status' => '1'))->result();
            if (!empty($new_childs)) {
                $html .= $this->get_childs($new_childs, $selected_parent, $space . '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;');
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
        $result = $this->crud_model->update($this->table, array('status' => '2'), array('id' => $id));
        if ($result) {
            $this->session->set_flashdata('success', 'Successfully Deleted.');
        } else {
            $this->session->set_flashdata('error', 'Unable To Delete.');
        }
        redirect($this->redirect . '/admin/all');
    }
}