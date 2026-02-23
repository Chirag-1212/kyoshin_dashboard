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
		// var_dump($this->current_user);exit;
		$this->load->library('form_validation');
		$this->table = 'teams';
		$this->redirect = 'team/admin/';
		$this->title = 'Team';
		$this->userId = $this->data['userId'];
	}

	public function search($page = '')
	{

		$title = $this->input->post('Title');
		$team_group_id = $this->input->post('team_group_id');
		$department_id = $this->input->post('department_id');
		$designation = $this->input->post('designation');
		$status = $this->input->post('status');
		// 		print_r($Type);die;

		$data_filter = array(
			'name' => $title,
			'designation' => $designation,
			'team_group_id' => $team_group_id,
			'department_id' => $department_id,
			'status' => $status,
			'status !=' => '2',
		);

		$all_data = $this->crud_model->count_all_data($this->table, $data_filter);
		// 		var_dump($this->db->last_query());exit;
		// 		var_dump($all_data);
		// 		exit;
		$config['base_url'] = base_url($this->redirect . 'search');
		$config['total_rows'] = $all_data->total;
		$config['uri_segment'] = 4;
		$config['per_page'] = 10;

		$config['full_tag_open'] = '<ul class="pagination pagination-sm m-0 float-right">';

		//go to first link customize
		$config['first_link'] = 'First';
		$config['first_tag_open'] = '<li class="page-item">';
		$config['first_tag_close'] = '</li>';

		//for all list outside of the a tag that is <li></li>
		$config['num_tag_open'] = '<li class="page-item">';
		//to add class to attribute
		$config['attributes'] = array('class' => 'page-link');
		$config['num_tag_close'] = '</li>';

		$config['next_link'] = 'Next';
		$config['next_tag_open'] = '<li class="page-item">';
		$config['next_tag_close'] = '</li>';

		$config['prev_link'] = 'Prev';
		$config['prev_tag_open'] = '<li class="page-item">';
		$config['prev_tag_close'] = '</li>';

		//customize current page
		$config['cur_tag_open'] = '<li class="page-item active"><a class="page-link">';
		$config['cur_tag_close'] = '</a></li>';

		$config['last_link'] = 'Last';
		$config['last_tag_open'] = '<li class="page-item">';
		$config['last_tag_close'] = '</li>';

		$config['full_tag_close'] = '</ul>';

		$this->pagination->initialize($config);


		$page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
		$items = $this->crud_model->get_all_data($this->table, $data_filter, $config['per_page'], $page);
		$designations = $this->crud_model->get_where_order_by('designation_para', array('status' => '1'), 'designation_name', 'DESC');
		$departs = $this->crud_model->get_where_order_by('department_para', array('status' => '1'), 'department_name', 'DESC');
		$groups = $this->crud_model->get_where_order_by('team_group', array('status' => '1'), 'group_name', 'DESC');

		$data = array_merge($this->data, [
			'title' => $this->title,
			'page' => 'list',
			'items' => $items,
			'redirect' => $this->redirect,
			'form_link' => $this->redirect . 'form/',
			'form_check_value' => 'form',
			'view_link' => $this->redirect . 'view/',
			'view_check_value' => 'view',
			'delete_link' => $this->redirect . 'soft_delete/',
			'delete_check_value' => 'soft_delete',
			'pagination' =>  $this->pagination->create_links(),
			'team' => 'team-all',
			'designations' => $designations,
			'departs' => $departs,
			'groups' => $groups,

		]);
		// var_dump($data);
		// exit;
		
		$this->load->view('layouts/admin/index', $data);
	}

	public function all($page = '')
	{

		$config['base_url'] = base_url($this->redirect . 'all');
		$config['total_rows'] = $this->crud_model->count_all($this->table, array('status !=' => '2'), 'id');
		$config['uri_segment'] = 4;
		$config['per_page'] = 10;
		//outside of flist that is <ul></ul>
		$config['full_tag_open'] = '<ul class="pagination pagination-sm m-0 float-right">';

		//go to first link customize
		$config['first_link'] = 'First';
		$config['first_tag_open'] = '<li class="page-item">';
		$config['first_tag_close'] = '</li>';

		//for all list outside of the a tag that is <li></li>
		$config['num_tag_open'] = '<li class="page-item">';
		//to add class to attribute
		$config['attributes'] = array('class' => 'page-link');
		$config['num_tag_close'] = '</li>';

		$config['next_link'] = 'Next';
		$config['next_tag_open'] = '<li class="page-item">';
		$config['next_tag_close'] = '</li>';

		$config['prev_link'] = 'Prev';
		$config['prev_tag_open'] = '<li class="page-item">';
		$config['prev_tag_close'] = '</li>';

		//customize current page
		$config['cur_tag_open'] = '<li class="page-item active"><a class="page-link">';
		$config['cur_tag_close'] = '</a></li>';

		$config['last_link'] = 'Last';
		$config['last_tag_open'] = '<li class="page-item">';
		$config['last_tag_close'] = '</li>';

		$config['full_tag_close'] = '</ul>';

		$this->pagination->initialize($config);

		$page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;

		$data['pagination'] = $this->pagination->create_links();
		$data['items'] = $this->crud_model->get_where_pagination($this->table, array('status !=' => '2'), $config["per_page"], $page);
		$data['title'] = $this->title;
		$data['designations'] = $this->crud_model->get_where_order_by('designation_para', array('status' => '1'), 'designation_name', 'DESC');
		$data['departs'] = $this->crud_model->get_where_order_by('department_para', array('status' => '1'), 'department_name', 'DESC');
		$data['groups'] = $this->crud_model->get_where_order_by('team_group', array('status' => '1'), 'group_name', 'DESC');
		$data['page'] = 'list';
		$data['redirect'] = $this->redirect;
		$data['team'] = 'team-all';
		$data = array_merge($this->data, $data);
		$this->load->view('layouts/admin/index', $data);
	}

	public function form($id = '')
	{

		$data['detail'] = $this->db->get_where($this->table, array('id' => $id))->row();
		$doc_path='uploads/team/';
		// 		echo "<pre>";
		// 		var_dump($this->db->last_query());exit;
		if ($this->input->post()) {
			$this->form_validation->set_rules('name', 'Full Name', 'required|trim');

			if ($this->form_validation->run()) {
			    if (strlen($_FILES['featured_image']['name']) > 0) {

					$config['upload_path'] = $doc_path;

					$config['allowed_types'] = 'jpeg|jpg|gif|png|pdf|jfif';

					$config['max_size'] = '3000';
					$this->load->library('upload', $config);

					if (!$this->upload->do_upload('featured_image')) {

						$this->session->set_flashdata('error', $this->upload->display_errors());
						if ($id == '') {
							redirect($this->redirect . 'form');
						} else {
							redirect($this->redirect . 'form/' . $id);
						}
					} else {

						$file = $this->upload->data();

						$featured_image = $doc_path.$file['file_name'];
					}
				} else {
					if (isset($data['detail']->featured_image) && $data['detail']->featured_image != '') {
						$featured_image = $data['detail']->featured_image;
					} else {
						$featured_image = "";
					}
				}
				$data = array(
					'name' => $this->input->post('name'),
					'name_nepali' => $this->input->post('name_nepali'),
					'email' => $this->input->post('email'),
					'description' => $this->input->post('description'),
					'description_nepali' => $this->input->post('description_nepali'),
					'featured_image' => $featured_image,
					'designation' => $this->input->post('designation'),
					'sub_designation' => $this->input->post('sub_designation'),
					'team_group_id' => $this->input->post('team_group_id'),
					'department_id' => $this->input->post('department_id'),
					'address' => $this->input->post('address'),
					'address_np' => $this->input->post('address_np'),
					'contact' => $this->input->post('contact'),
					'contact_np' => $this->input->post('contact_np'),
					'rank' => $this->input->post('rank'),
					'is_block' => $this->input->post('is_block'),
					'status' => $this->input->post('status'),
					
				);
				$id = $this->input->post('id');
			
				if ($id == '') {
				    $checktext=$this->crud_model->detectTextLanguage($this->input->post('name'));
			 	
    			    if($checktext==true){
    			        $text=$this->input->post('name');
    			    }else{
    			        $text=$this->title. time();
    			    }
    				$slug = $this->crud_model->createUrlSlug($text);
    				// $slug = $this->crud_model->createUrlSlug($this->input->post('name'));
    				$check_slug = $this->crud_model->get_where_single($this->table, array('slug' => $slug));
    				if (empty($check_slug)) {
    					$data['slug'] = strtolower($slug);
    				} else {
    					$data['slug'] = strtolower($slug) . time();
    				}
					$data['created_by'] = $this->userId;
					$data['created'] = date('Y-m-d');
					$result = $this->crud_model->insert($this->table, $data);
					if ($result == true) {
						$this->session->set_flashdata('success', 'Successfully Inserted.');
						redirect($this->redirect . 'all');
					} else {
						$this->session->set_flashdata('error', 'Unable To Insert.');
						redirect($this->redirect . 'form');
					}
				} else {
					$data['updated'] = date('Y-m-d');
					$data['updated_by'] = $this->userId;
					$result = $this->crud_model->update($this->table, $data, array('id' => $id));
					if ($result == true) {
						$this->session->set_flashdata('success', 'Successfully Updated.');
						redirect($this->redirect . 'all');
					} else {
						$this->session->set_flashdata('error', 'Unable To Update.');
						redirect($this->redirect . 'form/' . $id);
					}
				}
			}
		}
		$data['designations'] = $this->crud_model->get_where_order_by('designation_para', array('status' => '1'), 'designation_name', 'DESC');
		$data['departs'] = $this->crud_model->get_where_order_by('department_para', array('status' => '1'), 'department_name', 'DESC');
		$data['groups'] = $this->crud_model->get_where_order_by('team_group', array('status' => '1'), 'group_name', 'DESC');
		$data['title'] = 'Add/Edit ' . $this->title;
		$data['page'] = 'form';
		$data['doc_path'] = $doc_path;
		$data['team'] = 'team-form';
		$data = array_merge($this->data, $data);
		$this->load->view('layouts/admin/index', $data);
	}

	public function soft_delete($id)
	{
		$data = array(
			'status' => '2',
			'updated_by' => $this->userId,
			'updated' => date('Y-m-d'),
		);
		$result = $this->crud_model->update($this->table, $data, array('id' => $id));
		if ($result == true) {
			$this->session->set_flashdata('success', 'Successfully Deleted.');
			redirect($this->redirect . 'all');
		} else {
			$this->session->set_flashdata('error', 'Unable To Delete.');
			redirect($this->redirect . 'all');
		}
	}
}