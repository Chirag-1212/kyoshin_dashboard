<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Admin extends Auth_controller
{
	protected $table;
	protected $userId;
	public function __construct()
	{
		parent::__construct();
		// var_dump($this->current_user);exit;
		$this->load->library('form_validation');
		$this->table = 'user_role';
		$this->userId = $this->data['userId'];
	}

	public function all($page = '')
	{

		$like = [];
		$param = [
			'status !=' => '2',
		];
		// if ($this->auth->current_user()->role_id == 1) {
		//     $config['total_rows'] = $this->crud_model->count_all('user_role', array('status !=' => '2'), 'id');
		// }else{
		//     $config['total_rows'] = $this->crud_model->count_all('user_role', array('status !=' => '2','id !=' => 1), 'id');
		// }
		if ($this->auth->current_user()->role_id != 1) {
		    $param['id !='] =1;
		}
		if($this->input->method() == 'get'){
			$search = $this->input->get('table_search');
			$like['name'] = $search;
		}

		$total = $this->crud_model->total($this->table, $param, $like);

		$config['base_url'] = base_url('user_role/admin/all');
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
		$config['suffix'] = isset($search)?"?table_search=$search":'';

		$this->pagination->initialize($config);
		$page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;

		$data['pagination'] = $this->pagination->create_links();
		// if ($this->auth->current_user()->role_id == 1) {
		//     $data['roles'] = $this->crud_model->get_where_pagination('user_role', array('status !=' => '2'), $config["per_page"], $page);
		// }else{
		//     $data['roles'] = $this->crud_model->get_where_pagination('user_role', array('status !=' => '2','id !=' => 1), $config["per_page"], $page);
		// }
		$data['roles']  = $this->crud_model->getData($this->table, $param, $like, $config["per_page"], $page);
		$data['offset'] = $page;
		$data['title'] = 'User Role';
		$data['page'] = 'list';
		$data['user_role'] = 'user_role-all';
		$data = array_merge($this->data, $data);

		$this->load->view('layouts/admin/index', $data);
	}

	public function form($id = '')
	{

		$data['detail'] = $this->db->get_where('user_role', array('id' => $id))->row();
		if ($this->input->post()) {
			$this->form_validation->set_rules('name', 'Title', 'required|trim');
			if ($this->form_validation->run()) {
				$data = array(
					'name' => $this->input->post('name'),
					'description' => $this->input->post('description'),
					'status' => $this->input->post('status'),
				);
				$id = $this->input->post('id');
				if ($id == '') {
					$data['created_by'] = $this->userId;
					$data['created'] = date('Y-m-d');
					$result = $this->crud_model->insert('user_role', $data);
					if ($result == true) {
						$this->session->set_flashdata('success', 'Successfully Inserted.');
						redirect('user_role/admin/all');
					} else {
						$this->session->set_flashdata('error', 'Unable To Insert.');
						redirect('user_role/admin/form');
					}
				} else {
					$data['updated'] = date('Y-m-d');
					$data['updated_by'] = $this->userId;
					$result = $this->crud_model->update('user_role', $data, array('id' => $id));
					if ($result == true) {
						$this->session->set_flashdata('success', 'Successfully Updated.');
						redirect('user_role/admin/all');
					} else {
						$this->session->set_flashdata('error', 'Unable To Update.');
						redirect('user_role/admin/form/' . $id);
					}
				}
			}
		}
		$data['title'] = 'Add/Edit User Role';
		$data['page'] = 'form';
		$data['user_role'] = 'user_role-form';
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
		$result = $this->crud_model->update('user_role', $data, array('id' => $id));
		if ($result == true) {
			$this->session->set_flashdata('success', 'Successfully Deleted.');
			redirect('user_role/admin/all');
		} else {
			$this->session->set_flashdata('error', 'Unable To Delete.');
			redirect('user_role/admin/all');
		}
	}
}