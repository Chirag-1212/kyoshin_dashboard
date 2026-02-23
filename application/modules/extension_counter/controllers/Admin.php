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
		// $this->load->library('form_validation'); 
		$this->table = 'extension_counter';
		$this->title = 'Extension Counter';
		$this->redirect = 'extension_counter';
		$this->userId = $this->data['userId'];
	}
    
	public function all($page = '')
	{
		$like = [];
		$param = [
			'status !=' => '2'
		];
		$status = '';
		$date_from = '';
		$date_to = '';
		$title = '';
		if($this->input->method() == 'get'){
			$title = $this->input->get('table_search');
			if($title){
				$like['PageTitle'] = $title;
				$like['Manager'] = $title;
				$like['Email'] = $title;
				$like['Phone'] = $title;
				$like['Address'] = $title;
			}
		}
		$total = $this->crud_model->total($this->table, $param, $like);
		$config['base_url'] = base_url($this->redirect . '/admin/all');
		$config['total_rows'] = $total;
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
		$config['suffix'] = "?date_from=$date_from&date_to=$date_to&satus=$status&Title=$title";
		$this->pagination->initialize($config);

		$page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;

		$items = $this->crud_model->getData($this->table, $param, $like, $config["per_page"], $page);
		
		$data = array_merge($this->data, [
			'title' => $this->title,
			'page' => 'list',
			'items' => $items,
			'redirect' => $this->redirect,
			'form_link' => $this->redirect . '/admin/form/',
			'form_check_value' => 'form',
			'delete_link' => $this->redirect . '/admin/soft_delete/',
			'delete_check_value' => 'soft_delete',
			'pagination' =>  $this->pagination->create_links(),
			'branch' => 'branch-all',
			'offset' => $page
		]);
		
		$this->load->view('layouts/admin/index', $data);
	}

	public function form($id = '')
	{
		$data['detail'] = $this->crud_model->get_where_single($this->table, array('id' => $id));
		if ($this->input->post()) {
			// echo "<pre>";
			// var_dump($this->input->post());
			// exit;
			// $this->form_validation->set_rules('Date', 'Date', 'required|trim');
			$this->form_validation->set_rules('Title', 'Title', 'required|trim');
			if ($this->form_validation->run()) {
				$id = $this->input->post('id');;
				$data = array(
					'PageTitle' => $this->input->post('Title'),
					'PageTitleNepali' => $this->input->post('TitleNepali'),
					'Phone' => $this->input->post('Phone'),
					'PhoneNepali' => $this->input->post('PhoneNepali'),
					'mobile' => $this->input->post('mobile'),
					'mobile_nepali' => $this->input->post('mobile_nepali'),
					'Manager' => $this->input->post('BMName'),
					'ManagerNepali' => $this->input->post('BMNameNepali'),
					'Email' => $this->input->post('Email'),
					'Address' => $this->input->post('Address'),
					'AddressNepali' => $this->input->post('AddressNepali'),
					'district_id' => $this->input->post('district_id'),
					'latitude' => $this->input->post('latitude'),
					'longitude' => $this->input->post('longitude'),
					'Serial' => $this->input->post('Serial'),
				);
				$checktext=$this->crud_model->detectTextLanguage($this->input->post('PageTitle'));
					 	
				    if($checktext==true){
				        $text=$this->input->post('PageTitle');
				    }else{
				        $text=$this->title. time();
				    }
					$slug = $this->crud_model->createUrlSlug($text);
            // 	$slug = $this->crud_model->createUrlSlug($this->input->post('PageTitle'));
				$check_slug = $this->crud_model->get_where_single($this->table, array('slug' => $slug));
				if (empty($check_slug)) {
					$data['slug'] = strtolower($slug);
				} else {
					$data['slug'] = strtolower($slug) . time();
				}
				if ($id == '') {
				
					$data['created_on'] = date('Y-m-d H:i:s');
					$data['created_by'] = $this->userId;
					$result = $this->crud_model->insert($this->table, $data);
					
					if ($result == true) {
						$this->session->set_flashdata('success', 'Successfully Inserted.');
						redirect($this->redirect . '/admin/all');
					} 
					$this->session->set_flashdata('error', 'Unable To Insert.');
					redirect($this->redirect . '/admin/form');
					
				} else {
					$data['updated_on'] = date('Y-m-d');
					$data['updated_by'] = $this->userId;
					$result = $this->crud_model->update($this->table, $data, array('id' => $id));
					if ($result == true) {
						$this->session->set_flashdata('success', 'Successfully Updated.');
						redirect($this->redirect . '/admin/all');
					}
					$this->session->set_flashdata('error', 'Unable To Update.');
					redirect($this->redirect . '/admin/form/' . $id);
				}
			}
		}
		$title = 'Add ' . $this->title;
		if ($data['detail']) {
			$title = 'Edit ' . $this->title;
		}
		
        $data['title'] = $title;
		$data['districts'] = $this->crud_model->get_where_order_by('districts', array('status' => '1'), 'id', 'ASC');
		$data['page'] = 'form';
		$data['branch'] = 'branch-form';
		$this->load->view('layouts/admin/index', array_merge($this->data, $data));
	}

	public function soft_delete($id)
	{
		if ($id == '' || $id == 0) {
			$this->session->set_flashdata('error', 'Select Atleast One');
			redirect($this->redirect . '/admin/all');
		}
		$data = array(
			'status' => '2',
		);
		$result = $this->crud_model->update($this->table, $data, array('id' => $id));
		if ($result == true) {
			$this->session->set_flashdata('success', 'Successfully Deleted.');
			redirect($this->redirect . '/admin/all');
		} else {
			$this->session->set_flashdata('error', 'Unable To Delete.');
			redirect($this->redirect . '/admin/all');
		}
	}
}