<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Admin extends Auth_controller
{

	public function __construct()
	{
		parent::__construct();
		// var_dump($this->current_user);exit;
		$this->load->library('form_validation');
		$this->table = 'branch_wise_officers';
		$this->redirect = 'branch_wise_officers/admin/';
		$this->title = 'Branch wise officer';
	}

	public function all($page = '')
	{
		$like = [];
		$param = [];
		if($this->input->method() == 'get'){
			$title = $this->input->get('Title');
			$type = $this->input->post('type');
			$branch = $this->input->post('branch');
			$status = $this->input->get('status');
			// $param['status'] = $status;
			if($status){
				$param['status'] = $status;
			}
			
			if($branch){
				$param['branch'] = $branch;
			}

			if($type){
				$param['type'] = $type;

			}

			if($title){
				$like['name'] = $title;

			}
		}

		$total = $this->crud_model->total($this->table, $param, $like);

		$config['base_url'] = base_url($this->redirect . 'all');
		$config['total_rows'] = $total;
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
		$config['suffix'] = "?type=$type&branch=$branch&satus=$status&Title=$title";
		$this->pagination->initialize($config);

		$page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;

		$data['pagination'] = $this->pagination->create_links();
		
		$data['items']  = $this->crud_model->getData($this->table, $param, $like, $config["per_page"], $page);
		// echo "<pre>";
		// var_dump($this->input->get(), $param, $this->db->last_query());exit;
		$data['offset'] = $page;
		$data['title'] = $this->title;
		$data['branches'] = $this->crud_model->get_where_order_by('branches', array('status' => '1'), 'id', 'DESC');
		$data['page'] = 'list';
		$data['redirect'] = $this->redirect;
		$data['branch_wise_officer'] = 'branch_wise_officer-all';
		$data = array_merge($this->data, $data);

		$this->load->view('layouts/admin/index', $data);
	}

	public function form($id = '')
	{

		$data['detail'] = $this->db->get_where($this->table, array('id' => $id))->row();
		$doc_path='uploads/branch_wise_officers/';
		// 		echo "<pre>";
		// 		var_dump($this->db->last_query());exit;
		if ($this->input->post()) {
			$this->form_validation->set_rules('name', 'Full Name', 'required|trim');

			if ($this->form_validation->run()) {
			    if (strlen($_FILES['featured_image']['name']) > 0) {

					$config['upload_path'] = $doc_path;

					$config['allowed_types'] = 'jpeg|jpg|gif|png|pdf';

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
					'featured_image' => $featured_image,
					'type'=> $this->input->post('type'),
					'mobile' => $this->input->post('mobile'),
					'contact' => $this->input->post('contact'),
					'branch'=> $this->input->post('branch'),
					'serial' => $this->input->post('serial'),
					'status' => $this->input->post('status'),
				);
				$id = $this->input->post('id');
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
				if ($id == '') {
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
		$data['title'] = 'Add/Edit ' . $this->title;
		$data['branches'] = $this->crud_model->get_where_order_by('branches', array('status' => '1'), 'id', 'DESC');
		$data['page'] = 'form';
		$data['doc_path'] = $doc_path;
		$data['branch_wise_officer'] = 'branch_wise_officer-form';
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