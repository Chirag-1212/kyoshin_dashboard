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
        $this->table = 'banners'; 
        $this->title = 'Banner';
        $this->redirect = 'banner'; 
        $this->userId = $this->data['userId'];
    }

public function all($page = '')
    {
        $like = [];
        $param = ['status !=' => '2'];

        // Search logic
        $search = $this->input->get('table_search');
        if ($search) {
            $like['title'] = $search;
        }

        $total = $this->crud_model->total($this->table, $param, $like);
        
        $config = [
            'base_url'    => base_url($this->redirect . '/admin/all'),
            'total_rows'  => $total,
            'per_page'    => 10,
            'uri_segment' => 4,
            'suffix'      => $search ? "?table_search=$search" : ''
        ];

        $this->pagination->initialize($config);
        
        $items = $this->crud_model->getData($this->table, $param, $like, $config["per_page"], $page, '*', 'id DESC');
        
        // Ensure this array is closed correctly with ] and );
        $data = array_merge($this->data, [
            'title'            => $this->title,
            'page'             => 'list',
            'list'             => $items,
            'redirect'         => $this->redirect,
            'form_link'        => $this->redirect . '/admin/form', 
            'form_check_value' => 'form', 
            'pagination'       => $this->pagination->create_links(),
            'offset'           => (int)$page
        ]);
        
        $this->load->view('layouts/admin/index', $data);
    }

    public function form($id = '')
    {
        $detail = $this->crud_model->get_where_single($this->table, ['id' => $id]);
        $upload_path = 'uploads/banners/';

        if ($this->input->post()) {
            $this->form_validation->set_rules('submitdt', 'Date', 'required|trim');
            $this->form_validation->set_rules('title', 'Title', 'required|trim');

            if ($this->form_validation->run()) {
                $id = $this->input->post('id');
                $file_name = $this->input->post('old_docpath'); 
                
                // Automatically generate slug from title
                $slug = url_title($this->input->post('title'), 'dash', TRUE);

                if (!empty($_FILES['docpath']['name'])) {
                    if (!is_dir($upload_path)) mkdir($upload_path, 0777, true);

                    $config = [
                        'upload_path'   => './' . $upload_path,
                        'allowed_types' => 'jpeg|jpg|gif|png|pdf|mp4|webp|webm',
                        'encrypt_name'  => TRUE,
                        'max_size'      => '30000'
                    ];

                    $this->load->library('upload', $config);
                    $this->upload->initialize($config);

                    if ($this->upload->do_upload('docpath')) {
                        $uploadData = $this->upload->data();
                        $file_name = $upload_path . $uploadData['file_name'];
                    } else {
                        $this->session->set_flashdata('error', $this->upload->display_errors());
                        redirect($this->redirect . '/admin/form/' . $id);
                    }
                }

                $saveData = [
                    'submitdt'    => $this->input->post('submitdt'),
                    'title'       => $this->input->post('title'),
                    'slug'        => $slug,
                    'docpath'     => $file_name,
                    'target'      => $this->input->post('target') ?: NULL,
                    'border'      => $this->input->post('border'),
                    'description' => $this->input->post('description'),
                    'status'      => $this->input->post('status'),
                    'type'        => 'ba',
                    'file_type'   => $this->input->post('file_type'),
                ];

                if (empty($id)) {
                    $saveData['created_on'] = date('Y-m-d');
                    $saveData['created_by'] = $this->userId;
                    $this->crud_model->insert($this->table, $saveData);
                    $this->session->set_flashdata('success', 'Inserted successfully.');
                } else {
                    $saveData['updated_on'] = date('Y-m-d');
                    $saveData['updated_by'] = $this->userId;
                    $this->crud_model->update($this->table, $saveData, ['id' => $id]);
                    $this->session->set_flashdata('success', 'Updated successfully.');
                }
                redirect($this->redirect . '/admin/all');
            }
        }

        $data = array_merge($this->data, [
            'title'    => (empty($id) ? 'Add ' : 'Edit ') . $this->title,
            'page'     => 'form',
            'detail'   => $detail,
            'redirect' => $this->redirect
        ]);
        
        $this->load->view('layouts/admin/index', $data);
    }

public function soft_delete($id)
{
    // Perform a soft delete: update status to 2 instead of deleting the row
    $data = [
        'status'     => '2',
        'updated_by' => $this->userId, 
        'updated_on' => date('Y-m-d') // Changed from 'updated' to 'updated_on' to match your form logic
    ];
    
    $this->db->where('id', $id);
    $result = $this->db->update($this->table, $data); // Use update, not delete

    if ($result) {
        $this->session->set_flashdata('success', 'Successfully Deleted.');
    } else {
        $this->session->set_flashdata('error', 'Unable To Delete.');
    }
    // Added missing slash
    redirect($this->redirect . '/admin/all');
}
}