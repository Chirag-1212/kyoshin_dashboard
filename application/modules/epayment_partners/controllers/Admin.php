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
		$this->table = 'e_payment_partners';
		$this->redirect = 'epayment_partners/admin/';
		$this->title = 'E-Payment Partners';
		$this->userId = $this->data['userId'];
	}
	
	public function all($page='')
	{ 
		
		$like = [];
		$param = [];
		if($this->input->method() == 'get'){
			$search = $this->input->get('table_search');
			$like['title'] = $search;
		}

        $total = $this->crud_model->total($this->table, $param, $like);
		$config['base_url'] = base_url($this->redirect.'all');
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
		$data['items'] = $this->crud_model->getData($this->table, $param, $like, $config["per_page"], $page);
		$data['offset'] = $page;
		$data['epayment_partners'] = 'e-payment-all';
		$data['redirect'] = $this->redirect;
		$data['title'] = $this->title;
        $data['page'] = 'list';
		$data['redirect'] = $this->redirect;
        $this->load->view('layouts/admin/index',array_merge($this->data, $data));
	}
	
	public function form($id='')
	{ 
		
		$data['detail'] = $this->db->get_where($this->table,array('id'=>$id))->row();
		$doc_path='uploads/epayment_partners/';
		if($this->input->post()){
			$this->form_validation->set_rules('title', 'Title', 'required|trim');     
			if($this->form_validation->run()){
				if (strlen($_FILES['featured_image']['name']) > 0) {

					$config['upload_path'] = $doc_path;

					$config['allowed_types'] = 'jpeg|jpg|gif|png|pdf';

					$config['max_size'] = '3000';
					$this->load->library('upload', $config);

					if (!$this->upload->do_upload('featured_image')) {

						$this->session->set_flashdata('error', $this->upload->display_errors());
						if ($id == '') {
							redirect($this->redirect . '/admin/form');
						} else {
							redirect($this->redirect . '/admin/form/' . $id);
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
							'title' => $this->input->post('title'),
							'featured_image' => $featured_image,
							'status' => $this->input->post('status'),  
						);   				
				$id = $this->input->post('id');	 	
				if($id == ''){ 
				    $checktext=$this->crud_model->detectTextLanguage($this->input->post('title'));
					 	
				    if($checktext==true){
				        $text=$this->input->post('title');
				    }else{
				        $text=$this->title. time();
				    }
					$slug = $this->crud_model->createUrlSlug($text);
				// 	$slug = $this->crud_model->createUrlSlug($this->input->post('title'));
					$check_slug = $this->crud_model->get_where_single($this->table,array('slug'=>$slug));
					if(empty($check_slug)){
						$data['slug'] = strtolower ($slug);
					}else{
						$data['slug'] = strtolower ($slug).time();
					}
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
		$data['doc_path'] = $doc_path;
        $data['epayment_partners'] = 'e-payment-form';
        $this->load->view('layouts/admin/index',array_merge($this->data, $data));
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
	
	public function hard_delete($id){
		$this->db->where(array('id'=>$id));
		$result = $this->db->delete($this->table);
		if($result==true){
			$this->session->set_flashdata('success','Successfully Deleted.');
			redirect($this->redirect.'all');
		}else{
			$this->session->set_flashdata('error', 'Unable To Delete.');
			redirect($this->redirect.'all');
		}
	}
}