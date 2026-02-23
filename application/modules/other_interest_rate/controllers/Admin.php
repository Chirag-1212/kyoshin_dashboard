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
		$this->table = 'other_interest_rate';
		$this->title = 'Other Interest Rate';
		$this->redirect = 'other_interest_rate';
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
		$type = '';
		if($this->input->method() == 'get'){
			$title = $this->input->get('Title');
			$type=$this->input->get('type');
			$status = $this->input->get('status');
			$date_from = $this->input->get('date_from');
			$date_to = $this->input->get('date_to');
			if($status){
				$param['status'] = $status;
			}
			if($date_from && $date_to){
				$param['date_forex >='] = $date_from;
				$param['date_forex <='] = $date_to;
			}
			if($status){
				$like['Title'] = $title;
			}

			if($type){
				$param['type'] = $type;
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
		
		$config['suffix'] = "?date_from=$date_from&date_to=$date_to&satus=$status&Title=$title&type=$type";

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
			$this->form_validation->set_rules('Title', 'Title', 'required|trim');
			$this->form_validation->set_rules('category_id', 'Category Name', 'required|trim');
			if ($this->form_validation->run()) {
				$id = $this->input->post('id');

				// if (strlen($_FILES['DocPath']['name']) > 0) {

				// 	$config['upload_path'] = 'uploads/interest_rate/';

				// 	$config['allowed_types'] = 'jpeg|jpg|gif|png|pdf';

				// 	$config['max_size'] = '300000';





				// 	$this->load->library('upload', $config);

				// 	if (!$this->upload->do_upload('DocPath')) {

				// 		$this->session->set_flashdata('error', $this->upload->display_errors());
				// 		if ($id == '') {
				// 			redirect($this->redirect . '/admin/form');
				// 		} else {
				// 			redirect($this->redirect . '/admin/form/' . $id);
				// 		}
				// 	} else {

				// 		$file = $this->upload->data();

				// 		$file_name = $file['file_name'];
				// 	}
				// } else {
				// 	if (isset($data['detail']->DocPath) && $data['detail']->DocPath != '') {
				// 		$file_name = $data['detail']->DocPath;
				// 	} else {
				// 		$file_name = "";
				// 	}
				// }

				$data = array(
					// 'datevalue' => $this->input->post('datevalue'),
					// 'DocPath' => $file_name,
					'Title' => $this->input->post('Title'),
					'TitleNepali' => $this->input->post('TitleNepali'),
					'Description' => $this->input->post('Description'),
					'DescriptionNepali' => $this->input->post('DescriptionNepali'), 
					'category_id' => $this->input->post('category_id'),
					'rate' => $this->input->post('rate'),
					'avg_rates' => $this->input->post('avg_rates'),
					'type' => $this->input->post('type'),
					'serial' => $this->input->post('serial'),
					'status' => $this->input->post('status'),
				);

				if ($id == '') {
				    $checktext=$this->crud_model->detectTextLanguage($this->input->post('Title'));
    				 	
    			    if($checktext==true){
    			        $text=$this->input->post('Title');
    			    }else{
    			        $text=$this->title. time();
    			    }
    				$slug = $this->crud_model->createUrlSlug($text);
				// 	$slug = $this->crud_model->createUrlSlug($this->input->post('Title'));
					$check_slug = $this->crud_model->get_where_single($this->table, array('slug' => $slug));
					if (empty($check_slug)) {
						$data['slug'] = strtolower($slug);
					} else {
						$data['slug'] = strtolower($slug) . time();
					}
					$data['created_on'] = date('Y-m-d');
					$data['created_by'] = $this->userId;
					$result = $this->crud_model->insert($this->table, $data);
					if ($result == true) {
						$this->session->set_flashdata('success', 'Successfully Inserted.');
						redirect($this->redirect . '/admin/all');
					} else {
						$this->session->set_flashdata('error', 'Unable To Insert.');
						redirect($this->redirect . '/admin/form');
					}
				} else {
					$data['updated_on'] = date('Y-m-d');
					$data['updated_by'] = $this->userId;
					$result = $this->crud_model->update($this->table, $data, array('id' => $id));
					if ($result == true) {
						$this->session->set_flashdata('success', 'Successfully Updated.');
						redirect($this->redirect . '/admin/all');
					} else {
						$this->session->set_flashdata('error', 'Unable To Update.');
						redirect($this->redirect . '/admin/form/' . $id);
					}
				}
			}
		}
		if ($data['detail']) {
			$data['title'] = 'Edit ' . $this->title;
		} else {
			$data['title'] = 'Add ' . $this->title;
		}

		$data['fiscal_years'] = $this->crud_model->get_where_order_by('fiscal_year', array('status' => '1'), 'title', 'DESC');
		$data['doc_path'] = 'uploads/interest_rate/';
		$data['page'] = 'form';
		$data = array_merge($this->data, $data);

		$this->load->view('layouts/admin/index', $data);
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