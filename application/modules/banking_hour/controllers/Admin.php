<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends Auth_controller {
	protected $userId;
	protected $table;
	protected $redirect;
	protected $title;
	public function __construct()
	{
		parent::__construct();
		// var_dump($this->current_user);exit;
		$this->load->library('form_validation');   
		$this->table = 'banking_hour';
		$this->redirect = 'banking_hour/admin/';
		$this->title = 'Banking Hour';
		$this->userId = $this->data['userId'];
	}

	public function all($page='')
	{ 
		
		// $data['roles'] = $this->db->get_where('user_role',array('status !='=>'2'))->result(); 

		// var_dump($this->uri->segment(3));exit;

		$config['base_url'] = base_url($this->redirect.'all');
		$config['total_rows'] = $this->crud_model->count_all($this->table,array('status !='=>'2'),'id');
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
		$data['items'] = $this->crud_model->get_where_pagination($this->table,array('status !='=>'2'),$config["per_page"], $page);
// 		var_dump($data['items']);exit;
		$data['title'] = $this->title;
        $data['page'] = 'list';
		$data['redirect'] = $this->redirect;
        $this->load->view('layouts/admin/index',$data);
	}
	
	public function form($id='')
	{ 
		
		$data['detail'] = $this->db->get_where($this->table,array('id'=>$id))->row();
		if($this->input->post()){
			$this->form_validation->set_rules('sunday_to_thursday_hour', 'Sunday-Thursday', 'required|trim');  
			$this->form_validation->set_rules('friday_hour', 'Friday', 'required|trim');  
			if($this->form_validation->run()){
				$data = array(
							'sunday_to_thursday_hour' => $this->input->post('sunday_to_thursday_hour'),
							'sunday_to_thursday_nepali_hour' => $this->input->post('sunday_to_thursday_nepali_hour'),  
							'friday_hour' => $this->input->post('friday_hour'),  
							'friday_nepali_hour' => $this->input->post('friday_nepali_hour'),  
							'status' => $this->input->post('status'),  
						);   				
				$id = $this->input->post('id');	 	
				if($id == ''){ 
					$data['created_by'] = $this->userId; 
					$data['created'] = date('Y-m-d'); 
					$result = $this->crud_model->insert($this->table, $data);
					if($result==true){
						$this->session->set_flashdata('success','Successfully Inserted.');
						redirect($this->redirect.'all');
					}else{
						$this->session->set_flashdata('error', 'Unable To Insert.');
						redirect($this->redirect.'form');
					}
				}else{ 
					$data['updated'] = date('Y-m-d');
					$data['updated_by'] = $this->userId; 
					$result = $this->crud_model->update($this->table, $data,array('id'=>$id));
					if($result==true){
						$this->session->set_flashdata('success','Successfully Updated.');
						redirect($this->redirect.'all');
					}else{
						$this->session->set_flashdata('error', 'Unable To Update.');
						redirect($this->redirect.'form/'.$id);
					}
				}   
			}
		} 
		$data['title'] = 'Add/Edit '.$this->title;
        $data['page'] = 'form';
        $this->load->view('layouts/admin/index',$data);
	}

	public function soft_delete($id){
		$data = array(
			'status' => '2',
			'updated_by' => $this->userId, 
			'updated' => date('Y-m-d'),
		);
		$result = $this->crud_model->update($this->table, $data,array('id'=>$id));
		if($result==true){
			$this->session->set_flashdata('success','Successfully Deleted.');
			redirect($this->redirect.'all');
		}else{
			$this->session->set_flashdata('error', 'Unable To Delete.');
			redirect($this->redirect.'all');
		}
	}
}