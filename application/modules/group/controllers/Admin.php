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
		$this->table = 'team_group';
		$this->title = 'Team Group';
		$this->redirect = 'group';
		$this->userId = $this->data['userId'];
	}

	public function search($page = '')
	{

		$title = $this->input->post('Title');
		$group_code = $this->input->post('group_code');
		$status = $this->input->post('status');
		$date_from = $this->input->post('date_from');
		$date_to = $this->input->post('date_to');
		// 		print_r($Type);die;

		$data_filter = array(
			'group_name' => $title,
			'group_code' => $group_code,
			'status' => $status,
			'created_on >=' => $date_from,
			'created_on <=' => $date_to,
			'status !=' => '2',
		);

		$all_data = $this->crud_model->count_all_data($this->table, $data_filter);
		// 		var_dump($this->db->last_query());exit;
		// 		var_dump($all_data);
		// 		exit;
		$config['base_url'] = base_url($this->redirect . '/admin/search');
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


		$data = array(
			'title' => $this->title,
			'page' => 'list',
			'items' => $items,
			'redirect' => $this->redirect,
			'form_link' => $this->redirect . '/admin/form/',
			'form_check_value' => 'form',
			'view_link' => $this->redirect . '/admin/view/',
			'view_check_value' => 'view',
			'delete_link' => $this->redirect . '/admin/soft_delete/',
			'delete_check_value' => 'soft_delete',
			'pagination' =>  $this->pagination->create_links(),
			'team' => 'team-group',
		);
		// var_dump($data);
		// exit;
		$this->load->view('layouts/admin/index', $data);
	}

	public function all($page = '')
	{
		$like = [];
		$param = [
			'status !=' => '2'
		];
		if($this->input->method() == 'get'){
			$search = $this->input->get('table_search');
			$like['group_name'] = $search;
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
		$config['suffix'] = isset($search)?"?table_search=$search":'';
		$config['full_tag_close'] = '</ul>';

		$this->pagination->initialize($config);

		$page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;

		$items = $this->crud_model->getData($this->table, $param, $like, $config["per_page"], $page);
				
		$data = array_merge($this->data, [
			'title' => $this->title . ' List',
			'page' => 'list',
			'items' => $items,
			'redirect' => $this->redirect,
			'pagination' =>  $this->pagination->create_links(),
			'team' => 'team-group',
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

			if ($this->input->post('id')) {
				$is_unique =  '';
			} else {
				$is_unique =  '|is_unique[team_group.group_code]';
			}

			$this->form_validation->set_rules('group_name', 'Group Name', 'required|trim');
			$this->form_validation->set_rules('group_code', 'Group Code', 'required|trim' . $is_unique);
			if ($this->form_validation->run()) {
				$data = array(
					'group_name' => $this->input->post('group_name'),
					'group_code' => $this->input->post('group_code'),
					'description' => $this->input->post('remarks'),
					'status' => $this->input->post('status'),
				);

				$id = $this->input->post('id');
				
				
				if ($id == '') {
				    $checktext=$this->crud_model->detectTextLanguage($this->input->post('group_name'));
					 	
				    if($checktext==true){
				        $text=$this->input->post('group_name');
				    }else{
				        $text=$this->title. time();
				    }
					$slug = $this->crud_model->createUrlSlug($text);
				// $slug = $this->crud_model->createUrlSlug($this->input->post('group_name'));
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
		$data['team'] = 'team-group';
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