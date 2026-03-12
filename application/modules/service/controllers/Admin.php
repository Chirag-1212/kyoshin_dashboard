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
        $this->title = 'Service';
        $this->redirect = 'service';
        $this->userId = $this->data['userId'];
    }

    public function all($page = '')
    {
        $like = [];
        $param = ['service.status !=' => '2'];

        if ($search = $this->input->get('table_search')) {
            $like['service.title_en'] = $search;
            $like['service.title_jp'] = $search;
        }

        // Modified total count to account for the join structure
        $this->db->from($this->table);
        $this->db->where($param);
        if(!empty($like)) { $this->db->group_start()->like($like)->group_end(); }
        $total = $this->db->count_all_results();
        
        $config = [
            'base_url'    => base_url($this->redirect . '/admin/all'),
            'total_rows'  => $total,
            'per_page'    => 10,
            'uri_segment' => 4,
            'suffix'      => $search ? "?table_search=$search" : ''
        ];

        $this->pagination->initialize($config);
        
        // Fetching data with service_category join
        $this->db->select('service.*, service_category.title as category_name');
        $this->db->from($this->table);
        $this->db->join('service_category', 'service_category.id = service.service_category_id', 'left');
        $this->db->where($param);
        if(!empty($like)) { $this->db->group_start()->like($like)->group_end(); }
        $this->db->limit($config['per_page'], $page);
        $this->db->order_by('service.id', 'DESC');
        $items = $this->db->get()->result();
        
        $data = array_merge($this->data, [
            'title'            => $this->title,
            'page'             => 'list',
            'list'             => $items,
            'redirect'         => $this->redirect,
            'form_link'        => $this->redirect . '/admin/form', 
            'delete_link'      => $this->redirect . '/admin/soft_delete',
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
                $id = $this->input->post('id');
                
                // Handling multiple files based on your reference style
                $image = $this->input->post('old_image');
                $coverimage = $this->input->post('old_coverimage');
                $docpath = $this->input->post('old_docpath');

                $upload_path = './uploads/services/';
                if (!is_dir($upload_path)) { mkdir($upload_path, 0777, true); }

                $config = [
                    'upload_path'   => $upload_path, 
                    'allowed_types' => 'jpeg|jpg|png|webp|pdf', 
                    'encrypt_name'  => TRUE,
                    'max_size'      => '10240' 
                ];
                $this->load->library('upload', $config);

                // Upload Main Image
                if (!empty($_FILES['image']['name'])) {
                    if ($this->upload->do_upload('image')) {
                        $file = $this->upload->data();
                        $image = 'uploads/services/' . $file['file_name'];
                    }
                }
                // Upload Cover Image
                if (!empty($_FILES['coverimage']['name'])) {
                    $this->upload->initialize($config);
                    if ($this->upload->do_upload('coverimage')) {
                        $file = $this->upload->data();
                        $coverimage = 'uploads/services/' . $file['file_name'];
                    }
                }
                // Upload Docpath
                if (!empty($_FILES['docpath']['name'])) {
                    $this->upload->initialize($config);
                    if ($this->upload->do_upload('docpath')) {
                        $file = $this->upload->data();
                        $docpath = 'uploads/services/' . $file['file_name'];
                    }
                }

                $slug = url_title($this->input->post('title_en'), 'dash', TRUE);

                $update_data = [
                    'title_en'            => $this->input->post('title_en'),
                    'title_jp'            => $this->input->post('title_jp'),
                    'slug'                => $slug,
                    'desc_en'             => $this->input->post('desc_en'),
                    'desc_jp'             => $this->input->post('desc_jp'),
                    'service_category_id' => $this->input->post('service_category_id'),
                    'datevalue'           => $this->input->post('datevalue'),
                    'serial'              => $this->input->post('serial'),
                    'image'               => $image,
                    'coverimage'          => $coverimage,
                    'docpath'             => $docpath,
                    'status'              => $this->input->post('status'),
                    'updated_on'          => date('Y-m-d H:i:s'),
                    'updated_by'          => $this->userId
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

        $detail = $this->crud_model->get_where_single($this->table, ['id' => $id]);
        $selected_cat = isset($detail->service_category_id) ? $detail->service_category_id : '';

        $data = array_merge($this->data, [
            'detail'   => $detail,
            'html'     => $this->get_category_options($selected_cat),
            'title'    => ($id == '') ? 'Add ' . $this->title : 'Edit ' . $this->title,
            'page'     => 'form',
            'redirect' => $this->redirect
        ]);
        
        $this->load->view('layouts/admin/index', $data);
    }

    public function soft_delete($id)
    {
        $update_data = [
            'status'     => '2',
            'updated_by' => $this->userId, 
            'updated_on' => date('Y-m-d H:i:s'),
        ];
        $result = $this->crud_model->update($this->table, $update_data, ['id' => $id]);
        
        if($result){
            $this->session->set_flashdata('success','Successfully Deleted.');
        }else{
            $this->session->set_flashdata('error', 'Unable To Delete.');
        }
        redirect($this->redirect . '/admin/all');
    }

    private function get_category_options($selected = '') {
        $html = '<option value="">Select Category</option>';
        $categories = $this->db->get_where('service_category', ['status' => '1'])->result();
        foreach ($categories as $cat) {
            $sel = ($cat->id == $selected) ? "selected" : "";
            $html .= '<option value="' . $cat->id . '" ' . $sel . '>' . $cat->title . '</option>';
        }
        return $html;
    }
}