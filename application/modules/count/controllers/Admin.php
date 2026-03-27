<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Admin extends Auth_controller
{
    protected $table;
    protected $title;
    protected $redirect;
    protected $userId;

    public function __construct()
    {
        parent::__construct();
        $this->table = 'count';
        $this->title = 'Count';
        $this->redirect = 'count';
        $this->userId = $this->data['userId'];
    }

    public function all($page = '')
    {
        $like = [];
        $param = ['status !=' => '2'];

        // Search logic using GET 'table_search'
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

		$data = array_merge($this->data, [
			'title'              => $this->title,
			'page'               => 'list',
			'list'               => $items,
			'redirect'           => $this->redirect,
			'form_link'          => $this->redirect . '/admin/form',
			'delete_link'        => $this->redirect . '/admin/soft_delete/', // Ensure this exists
			'form_check_value'   => 'form',
			'delete_check_value' => 'soft_delete', // Add this
			'pagination'         => $this->pagination->create_links(),
			'offset'             => (int)$page
		]);
        $this->load->view('layouts/admin/index', $data);
    }

    public function form($id = '')
    {
        $detail = $this->crud_model->get_where_single($this->table, ['id' => $id]);

        if ($this->input->post()) {
            $this->form_validation->set_rules('title', 'Title', 'required|trim');
            
            if ($this->form_validation->run()) {
                $id = $this->input->post('id');
                
                $saveData = [
                    'title'      => $this->input->post('title'),
                    'title_jp'   => $this->input->post('title_jp'),
                    'number'     => $this->input->post('number'),
                    'number_jp'  => $this->input->post('number_jp'),
                    'status'     => $this->input->post('status')
                ];

               if (empty($post_id)) {
                    $title_en = $this->input->post('title_en');
                    
                    // Generate the base slug using your model method
                    $slug = $this->crud_model->createUrlSlug($title_en);
                    
                    // Check for unique slug in DB
                    $check_slug = $this->crud_model->get_where_single($this->table, array('slug' => $slug));
                    
                    if (empty($check_slug)) {
                        $saveData['slug'] = strtolower($slug);
                    } else {
                        // Append timestamp if slug already exists
                        $saveData['slug'] = strtolower($slug) . '-' . time();
                    }
                    
                    $saveData['created_on'] = date('Y-m-d');
                    $saveData['created_by'] = $this->userId;
                    $result = $this->crud_model->insert($this->table, $saveData);
                    $this->session->set_flashdata($result ? 'success' : 'error', 'Successfully Inserted.');
                } else {
                    $saveData['updated_on'] = date('Y-m-d');
                    $saveData['updated_by'] = $this->userId;
                    $result = $this->crud_model->update($this->table, $saveData, ['id' => $id]);
                    $this->session->set_flashdata($result ? 'success' : 'error', 'Successfully Updated.');
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
        $data = [
            'status'     => '2',
            'updated_by' => $this->userId, 
            'updated_on' => date('Y-m-d')
        ];
        
        $result = $this->crud_model->update($this->table, $data, ['id' => $id]);

        if ($result) {
            $this->session->set_flashdata('success', 'Successfully Deleted.');
        } else {
            $this->session->set_flashdata('error', 'Unable To Delete.');
        }

        redirect($this->redirect . '/admin/all');
    }
}