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
		$this->table = 'branches';
		$this->title = 'Branch';
		$this->redirect = 'branch';
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
			$title = $this->input->get('Title');
			$status = $this->input->get('status');
			$date_from = $this->input->get('date_from');
			$date_to = $this->input->get('date_to');
			if($status){
				$param['status'] = $status;
			}
			
			if($date_from){
				$param['created_on >='] = $date_from;
				$param['created_on <='] = $date_to;
			}
			
			if($title){
				$like['PageTitle'] = $title;
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
				$id = $this->input->post('id');

				// if (strlen($_FILES['DocPath']['name']) > 0) {

				// 	$config['upload_path'] = 'uploads/downloads/';

				// 	$config['allowed_types'] = 'jpeg|jpg|gif|png|pdf';

				// 	$config['max_size'] = '3000';





				// 	$this->load->library('upload', $config);

				// 	if (!$this->upload->do_upload('DocPath')) {

				// 		$this->session->set_flashdata('message', $this->upload->display_errors());
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

				$valley_nepali = ($this->input->post('Valley') == 'inside') ? 'उपत्यका भित्र' : 'उपत्यका बाहिर';
				$data = array(
					// 'Date' => $this->input->post('Date'),
					'PageTitle' => $this->input->post('Title'),
					'show_career'=>$this->input->post('show_career') ? 'Y' : 'N',
					'PageTitleNepali' => $this->input->post('TitleNepali'),
					'description_nepali' => $this->input->post('description_nepali'),
					'Description' => $this->input->post('Description'),
					'Phone' => $this->input->post('Phone'),
					'PhoneNepali' => $this->input->post('PhoneNepali'),
					'mobile' => $this->input->post('mobile'),
					'mobile_nepali' => $this->input->post('mobile_nepali'),
					'toll_free_no_nepali' => $this->input->post('toll_free_no_nepali'),
					'toll_free_no' => $this->input->post('toll_free_no'),
					'Fax' => $this->input->post('Fax'),
					'FaxNepali' => $this->input->post('FaxNepali'),
					'POB' => $this->input->post('POB'),
					'POBNepali' => $this->input->post('POBNepali'),
					'Manager' => $this->input->post('BMName'),
					'ManagerNepali' => $this->input->post('BMNameNepali'),
					'Email' => $this->input->post('Email'),
					'Valley' => $this->input->post('Valley'),
					'ValleyNepali' => $valley_nepali,

					'Address' => $this->input->post('Address'),
					'AddressNepali' => $this->input->post('AddressNepali'),
					'district_id' => $this->input->post('district_id'),
					'latitude' => $this->input->post('latitude'),
					'longitude' => $this->input->post('longitude'),
					'Map' => $this->input->post('Map'),
					'google_plus' => $this->input->post('google_plus'),
					'Serial' => $this->input->post('Serial'),

					// 'Designation' => $this->input->post('Designation'),
					// 'DesignationNepali' => $this->input->post('DesignationNepali'),


					'Disabled' => 0,

				);

				if ($id == '') {
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

		// $data['doc_path'] = 'uploads/downloads/';
		$data['districts'] = $this->crud_model->get_where_order_by('districts', array('status' => '1'), 'id', 'ASC');
		$data['page'] = 'form';
		$data['branch'] = 'branch-form';
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