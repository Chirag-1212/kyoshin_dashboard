<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends Auth_controller {

	public function __construct()
	{
		parent::__construct();
		// var_dump($this->current_user);exit;
		$this->load->library('form_validation');   
		$this->table = 'currency';
		$this->redirect = 'currency/admin/';
		$this->title = 'Currency';
	}
	
	public function search($page = '')
	{

		$title = $this->input->post('Title');
		$status = $this->input->post('status');
		$date_from = $this->input->post('date_from');
		$date_to = $this->input->post('date_to');
// 		print_r($Type);die;
		
		$data_filter = array(
    		    'title' => $title,
    			'status' => $status,
    			'created >=' => $date_from,
    			'created <=' => $date_to,	
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
			'pagination' =>  $this->pagination->create_links()
		); 
		// var_dump($data);
		// exit;
		$this->load->view('layouts/admin/index', $data);
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
			$this->form_validation->set_rules('name', 'Name', 'required|trim');    
			$this->form_validation->set_rules('symbol', 'Symbol', 'required|trim');    
			$this->form_validation->set_rules('code', 'Code', 'required|trim');    
			if($this->form_validation->run()){
			    
			    $id = $this->input->post('id'); 
			    
				$data = array(
							'name' => $this->input->post('name'),
				// 			'code' => $this->input->post('code'),   
							'symbol' => $this->input->post('symbol'), 
							'status' => $this->input->post('status'),  
						);   				
				 	
				if($id == ''){ 
				// 	$slug = $this->crud_model->createUrlSlug($this->input->post('title'));
				// 	$check_slug = $this->crud_model->get_where_single($this->table,array('slug'=>$slug));
				// 	if(empty($check_slug)){
				// 		$data['slug'] = strtolower ($slug);
				// 	}else{
				// 		$data['slug'] = strtolower ($slug).time();
				// 	}
				    $check_unique_code = $this->crud_model->get_where_single($this->table,array('code'=>$this->input->post('code')));
				    if(empty($check_unique_code)){
						$data['code'] = $this->input->post('code');
					}else{
						$this->session->set_flashdata('error', 'Code Should be unique');
						redirect($this->redirect.'form');
					}
					$data['created_by'] = $this->current_user->id; 
					$data['created_on'] = date('Y-m-d'); 
					$result = $this->crud_model->insert($this->table, $data);
					if($result==true){
						$this->session->set_flashdata('success','Successfully Inserted.');
						redirect($this->redirect.'all');
					}else{
						$this->session->set_flashdata('error', 'Unable To Insert.');
						redirect($this->redirect.'form');
					}
				}else{ 
				    $check_unique_code = $this->crud_model->get_where_single($this->table,array('code'=>$this->input->post('code'),'id !=' => $id));
				    if(empty($check_unique_code)){
						$data['code'] = $this->input->post('code');
					}else{
						$this->session->set_flashdata('error', 'Code Should be unique');
						redirect($this->redirect.'form');
					}
					$data['updated_on'] = date('Y-m-d');
					$data['updated_by'] = $this->current_user->id; 
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
			'updated_by' => $this->current_user->id, 
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
	
	public function import_from_excel($id = '')
	{ 
		if ($this->input->post()) {   
		    
				if (strlen($_FILES['FileName']['name']) > 0) {

					$config['upload_path'] = 'uploads/currency/';

					$config['allowed_types'] = 'csv';

					$config['max_size'] = '3000';





					$this->load->library('upload', $config);

					if (!$this->upload->do_upload('FileName')) {

						$this->session->set_flashdata('error', $this->upload->display_errors()); 
					    redirect($this->redirect . 'import_from_excel'); 
					} else {

						$file = $this->upload->data();

						$file_name = $file['file_name'];
						
				// 		$data['created_on'] = date('Y-m-d');
				//     	$data['created_by'] = $this->current_user->id; 

						if ($file_name != '') {
							$fp1 = file('uploads/currency/' . $file_name);

							for ($i = 0; $i < count($fp1); $i++) {

								$fp2 = $fp1[$i];



								$fp2 = explode(',', $fp2);



								for ($j = 0; $j < count($fp2); $j++) {

									if ($j == 0)

										$code = $fp2[$j];

									elseif ($j == 1)

										$name = $fp2[$j];

									elseif ($j == 2)

										$symbol = $fp2[$j]; 
								}    
            				        
        						$data1 = array(

									'name' => $name,

									'code' => $code,

									'symbol' => $symbol, 
									
								    'created_on' => date('Y-m-d'),
								    
			    	                'created_by' => $this->current_user->id, 

								);

								$this->crud_model->insert('currency', $data1); 
							}
							$this->session->set_flashdata('success', 'Successfully Inserted.');
						    redirect($this->redirect . 'all'); 
						}else{
						    $this->session->set_flashdata('error', 'Unable to get filename.');
						    redirect($this->redirect . 'import_from_excel'); 
						} 
					}
				} else {
					$this->session->set_flashdata('error', 'File is required.');
				    redirect($this->redirect . 'import_from_excel');
				}   
		}
		
        $data['title'] = 'Add ' . $this->title;
		$data['doc_path'] = 'uploads/currency/';
		$data['page'] = 'import_from_excel';
		$this->load->view('layouts/admin/index', $data);
	}
}
