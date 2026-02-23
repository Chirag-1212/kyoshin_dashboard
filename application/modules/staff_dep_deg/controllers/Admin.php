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
		 
		$this->load->library(array('my_form_validation'));
		$this->form_validation->run($this);
		$this->table = 'staff_desig_depart';
		$this->redirect = 'staff_dep_deg/admin/';
		$this->title = 'Staff Designation & Department';
		$this->userId = $this->data['userId'];
	}

	public function all($page = '')
	{
		$data['staffs'] = $this->db->get_where('staff_infos', array('status' => '1'))->result();

		// $data['roles'] = $this->db->get_where('user_role',array('status !='=>'2'))->result(); 

		if ($this->input->post('staff_id') != NULL) {

			$staff_id = $this->input->post('staff_id');
			$config['base_url'] = base_url($this->redirect . 'all');
			$config['total_rows'] = $this->crud_model->count_all($this->table, array('status !=' => '0', 'staff_id' => $staff_id), 'id');
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
			$data['items'] = $this->crud_model->get_where_pagination($this->table, array('status !=' => '0', 'staff_id' => $staff_id), $config["per_page"], $page);
			$data['input'] = 'ss';
		} else {

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
		}
		$data['title'] = $this->title;
		$data['page'] = 'list';
		$data['redirect'] = $this->redirect;
		$data['staff'] = 'staff_dep_deg';
		$data = array_merge($this->data, $data);
		$this->load->view('layouts/admin/index', $data);
	}
	public function validate_appointed_date($field_value, $old_date)
	{
		if ($old_date >= $field_value) {

			$this->form_validation->set_message('validate_appointed_date', 'The %s field is invalid.', 'required');
			return FALSE;
		} else {
			// {echo "hereesss";exit;
			return true;
		}
	}
	public function form($id = '')
	{

		$data['dep_deg'] = $this->crud_model->get_where_single('staff_desig_depart', array('status' => '1', 'id' => $id));
		if (isset($data['dep_deg'])) {
			$staff_id = $data['dep_deg']->staff_id;
			$old_date = $data['dep_deg']->from;
			// echo $old_date;
			$data['detail'] = $this->db->get_where('staff_infos', array('id' => $staff_id))->row();
		}


		if ($this->input->post()) {
			$this->form_validation->set_rules('full_name', 'Full Name', 'required|trim');
			$this->form_validation->set_rules('appointed_date', 'Appointed Date', 'required|callback_validate_appointed_date[' . $old_date . ']');





			if ($this->form_validation->run()) {
				$data1 = array(
					'to' => $this->input->post('appointed_date'),
					'status' => '2',
				);
				$data2 = array(
					'staff_id' => $staff_id,
					'designation_code' => $this->input->post('designation_code'),
					'department_code' => $this->input->post('department_code'),
					'from' => $this->input->post('appointed_date'),
					'status' => $this->input->post('status'),
				);
				// print_r($data1);
				// print_r($data2);
				// die;			

				// $id = $this->input->post('id');	 	

				$data1['updated_on'] = date('Y-m-d');
				$data1['updated_by'] = $this->userId;
				$data2['created_on'] = date('Y-m-d');
				$data2['created_by'] = $this->userId;
				$result1 = $this->crud_model->update($this->table, $data1, array('staff_id' => $staff_id));
				if ($result1) {
					$result2 = $this->crud_model->insert($this->table, $data2);
					// $result = $this->crud_model->update($this->table, $data,array('id'=>$id));
					if ($result2 == true) {
						$this->session->set_flashdata('success', 'Successfully Updated.');
						redirect($this->redirect . 'all');
					} else {
						$this->session->set_flashdata('error', 'Unable To Update.');
						redirect($this->redirect . 'form/' . $id);
					}
				}
			}
		}

		// $data['countries'] = $this->crud_model->get_where('country_para', array('status' => '1'));
		$data['designations'] = $this->crud_model->get_where('designation_para', array('status' => '1'));
		$data['departments'] = $this->crud_model->get_where('department_para', array('status' => '1'));
		$data['title'] = 'Add/Edit ' . $this->title;
		$data['page'] = 'form';
		$data['staff'] = 'staff_dep_deg';
		$data = array_merge($this->data, $data);
		$this->load->view('layouts/admin/index', $data);
	}

	public function soft_delete($id)
	{
		$data = array(
			'status' => '2',
			'updated_by' => $this->userId,
			'updated_on' => date('Y-m-d'),
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