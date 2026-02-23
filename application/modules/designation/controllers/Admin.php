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
		
		$this->table = 'designation_para';
		$this->title = 'Designation';
		$this->redirect = 'designation';
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
			$designation_code = $this->input->get('designation_code');
			$status = $this->input->get('status');
			$date_from = $this->input->get('date_from');
			$date_to = $this->input->get('date_to');
			if($designation_code){
				$param['designation_code'] = $designation_code;
			}
			
			if($status){
				$param['status'] = $status;
			}
			
			if($date_from && $date_to){
				$param['created_on >='] = $date_from;
				$param['created_on <='] = $date_to;
			}
			if($title){
				$like['designation_name'] = $title;
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
		$config['suffix'] = "?date_from=$date_from&date_to=$date_to&satus=$status&Title=$title&designation_code=$designation_code";

		$this->pagination->initialize($config);

		$page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
		
		$items = $this->crud_model->getData($this->table, $param, $like, $config["per_page"], $page);
		
		$data = array_merge($this->data, [
			'title' => $this->title . ' List',
			'page' => 'list',
			'items' => $items,
			'redirect' => $this->redirect,
			'pagination' =>  $this->pagination->create_links(),
			'designation' => 'designation-all',
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
			
			if($this->input->post('id')) {
                $is_unique =  '';
            } else {
                $is_unique =  '|is_unique[designation_para.designation_code]'; 
            }
            
			$this->form_validation->set_rules('designation_name', 'Designation Name', 'required|trim');
			$this->form_validation->set_rules('designation_name_np', 'Designation Name In Nepali', 'required|trim');
			$this->form_validation->set_rules('designation_code', 'Designation Code', 'required|trim'.$is_unique);
			if ($this->form_validation->run()) {
				$data = array(
					'designation_name' => $this->input->post('designation_name'),
					'designation_code' => $this->input->post('designation_code'),
					'designation_name_np' => $this->input->post('designation_name_np'),
					'remarks' => $this->input->post('remarks'),
					'status' => $this->input->post('status'),
				);

				// $designation_code = substr($data['designation_name'],0,4);
				// $data['designation_code'] = $designation_code;
				$id = $this->input->post('id');
				if ($id == '') {
				// 	$designation_code = substr($data['designation_name'], 0, 4);
				// 	$data['designation_code'] = $designation_code;
				
				    

					$data['created_on'] = date('Y-m-d');
					$data['created_by'] = $this->userId;
					$result = $this->crud_model->insert($this->table, $data);
					if ($result == true) {
						$this->session->set_flashdata('success', 'Successfully Inserted.');
						redirect($this->redirect . '/admin/all');
					} else {
					    $this->session->set_flashdata('error', 'Unable To Insert.');
						redirect($this->redirect . '/admin/form');
            //             $this->session->set_flashdata('error', $result['message']);
        			 //   redirect($this->redirect . '/admin/form'); 
					}
				} else {
					$data['updated_on'] = date('Y-m-d');
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
		$data['title'] = 'Add/Edit ' . $this->title;
		$data['page'] = 'form';
		$data['designation'] = 'designation-form';
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