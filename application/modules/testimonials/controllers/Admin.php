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
        $this->table = 'testimonials'; 
        $this->title = 'testimonials';
        $this->redirect = 'testimonials'; 
        $this->userId = $this->data['userId'];
    }

    public function all($page = '')
    {
        $like = [];
        $param = ['status !=' => '2'];

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

        // lowercase pagination styling
        $config['full_tag_open'] = '<ul class="pagination pagination-sm m-0 float-right">';
        $config['first_link'] = 'first';
        $config['last_link'] = 'last';
        $config['next_link'] = 'next';
        $config['prev_link'] = 'prev';
        $config['attributes'] = array('class' => 'page-link');
        $config['full_tag_close'] = '</ul>';

        $this->pagination->initialize($config);
        
        $items = $this->crud_model->getData($this->table, $param, $like, $config["per_page"], $page, '*', 'id DESC');

			$data = array_merge($this->data, [
				'title'              => $this->title,
				'page'               => 'list',
				'list'               => $items,
				'redirect'           => $this->redirect,
				'form_link'          => $this->redirect . '/admin/form',
				'pagination'         => $this->pagination->create_links(),
				'offset'             => (int)$page,
				'form_check_value'   => 'edit',   
				'delete_check_value' => 'delete'  
			]);
        
        $this->load->view('layouts/admin/index', $data);
    }

    public function form($id = '')
    {
        $detail = $this->crud_model->get_where_single($this->table, ['id' => $id]);
        $upload_path = 'uploads/testimonials/';

        if ($this->input->post()) {
            $this->form_validation->set_rules('title', 'title', 'required|trim');

            if ($this->form_validation->run()) {
                $id = $this->input->post('id');
                $file_name = $this->input->post('old_doc_path'); 
                
                // unique slug generation logic
                $slug = strtolower(url_title($this->input->post('title'), 'dash', TRUE));
                
                // check if slug exists (excluding current record for updates)
                $where_slug = ['slug' => $slug];
                if (!empty($id)) { $where_slug['id !='] = $id; }
                $check_slug = $this->crud_model->get_where_single($this->table, $where_slug);
                
                if ($check_slug) {
                    $slug = $slug . '-' . time(); // append timestamp if duplicate found
                }

                if (!empty($_FILES['doc_path']['name'])) {
                    if (!is_dir($upload_path)) mkdir($upload_path, 0777, true);

                    $config = [
                        'upload_path'   => './' . $upload_path,
                        'allowed_types' => 'jpeg|jpg|gif|png|pdf|webp',
                        'encrypt_name'  => TRUE,
                        'max_size'      => '30000'
                    ];

                    $this->load->library('upload', $config);
                    $this->upload->initialize($config);

                    if ($this->upload->do_upload('doc_path')) {
                        $upload_data = $this->upload->data();
                        $file_name = $upload_path . $upload_data['file_name'];
                    } else {
                        $this->session->set_flashdata('error', $this->upload->display_errors());
                        redirect($this->redirect . '/admin/form/' . $id);
                    }
                }

                $save_data = [
                    'title'              => $this->input->post('title'),
                    'title_jp'           => $this->input->post('title_jp'),
                    'sub_title'          => $this->input->post('sub_title'),
                    'sub_title_jp'       => $this->input->post('sub_title_jp'),
                    'slug'               => $slug,
                    'doc_path'           => $file_name,
                    'description'        => $this->input->post('description'),
                    'description_jp' => $this->input->post('description_jp'), 
                    'status'             => $this->input->post('status'),
                ];

                if (empty($id)) {
                    $save_data['created_on'] = date('Y-m-d');
                    $save_data['created_by'] = $this->userId;
                    $this->crud_model->insert($this->table, $save_data);
                    $this->session->set_flashdata('success', 'successfully inserted');
                } else {
                    $save_data['updated_on'] = date('Y-m-d');
                    $save_data['updated_by'] = $this->userId;
                    $this->crud_model->update($this->table, $save_data, ['id' => $id]);
                    $this->session->set_flashdata('success', 'successfully updated');
                }
                redirect($this->redirect . '/admin/all');
            }
        }

        $data = array_merge($this->data, [
            'title'    => (empty($id) ? 'add ' : 'edit ') . $this->title,
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
        
        $this->db->where('id', $id);
        $result = $this->db->update($this->table, $data);

        if ($result) {
            $this->session->set_flashdata('success', 'successfully deleted');
        } else {
            $this->session->set_flashdata('error', 'unable to delete');
        }
        redirect($this->redirect . '/admin/all');
    }
}