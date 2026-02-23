<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends Auth_controller {
    protected $title;
	protected $redirect;
	protected $table;
	protected $userId;
	public function __construct()
	{
		parent::__construct();
		// var_dump($this->current_user);exit;
		$this->load->library('form_validation');   
		$this->table = 'faq';
		$this->redirect = 'faq/admin/';
		$this->title = 'FAQ';
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
        $this->load->view('layouts/admin/index',array_merge($this->data,$data));
	}
	
	public function form($id='')
	{ 
		
		$data['detail'] = $this->db->get_where($this->table,array('id'=>$id))->row();
		if($this->input->post()){
			$this->form_validation->set_rules('question', 'Question', 'required|trim');   
			if($this->form_validation->run()){
				$data = array(
				            'faq_cat' => $this->input->post('faq_cat'),
							'question' => $this->input->post('question'),
							'question_nepali' => $this->input->post('question_nepali'),   
							'answer_nepali' => $this->input->post('answer_nepali'),
							'answer' => $this->input->post('answer'),
							'status' => $this->input->post('status'),  
						);   				
				$id = $this->input->post('id');	 	
				if($id == ''){ 
				// 	$slug = $this->crud_model->createUrlSlug($this->input->post('question'));
					$checktext=$this->crud_model->detectTextLanguage($this->input->post('question'));
					 	
				    if($checktext==true){
				        $text=$this->input->post('question');
				    }else{
				        $text=$this->title. time();
				    }
					$slug = $this->crud_model->createUrlSlug($text);
					$check_slug = $this->crud_model->get_where_single($this->table,array('slug'=>$slug));
					if(empty($check_slug)){
						$data['slug'] = strtolower ($slug);
					}else{
						$data['slug'] = strtolower ($slug).time();
					}
					$data['created_by'] = $this->userId; 
					$data['created'] = date('Y-m-d'); 
					
					$result = $this->crud_model->insert($this->table, $data);
					if($result){
						$this->session->set_flashdata('success','Successfully Inserted.');
						redirect($this->redirect.'all');
					}
					$this->session->set_flashdata('error', 'Unable To Insert.');
					redirect($this->redirect.'form');
					
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
		$data['faq_category'] = $this->crud_model->get_where_order_by('faq_category', array('status' => '1'), 'id', 'ASC');
		$data['title'] = 'Add/Edit '.$this->title;
        $data['page'] = 'form';
        $this->load->view('layouts/admin/index',array_merge($this->data,$data));
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
