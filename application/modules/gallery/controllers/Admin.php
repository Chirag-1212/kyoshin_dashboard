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
		$this->table = 'gallery';
		$this->redirect = 'gallery/admin/';
		$this->title = 'Gallery';
		$this->userId = $this->data['userId'];
	}	

	public function all($page='')
	{ 
		
		$like = [];
		$param = [
			'status !=' => '2'
		];
		$like = [];
		$param = [
			'status !=' => '2'
		];
		$status = '';
		$date_from = '';
		$date_to = '';
		$title = '';
		if($this->input->method() == 'get'){
			$search = $this->input->get('table_search');
			$like['Title'] = $search;
		}
// 		if($this->input->method() == 'get'){
// 			$title = $this->input->get('Title');
// 			$status = $this->input->get('status');
// 			$date_from = $this->input->get('date_from');
// 			$date_to = $this->input->get('date_to');
			
// 			if($status){
// 				$param['status'] = $status;
// 			}
// 			if($date_from && $date_to){
// 				$param['created >='] = $date_from;
// 				$param['created <='] = $date_to;
// 			}
// 			if($title){
// 				$like['Title'] = $title;
// 			}
			
// 		}
		
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

		$data['pagination'] = $this->pagination->create_links();
		$data['items'] = $this->crud_model->getData($this->table, $param, $like, $config["per_page"], $page);
// 		var_dump($data['items']);exit;
		$data['title'] = $this->title;
        $data['page'] = 'list';
		$data['redirect'] = $this->redirect;
		$data['offset'] = $page;
		$data['gallery'] = 'gallery-all';
		$data = array_merge($this->data, $data);
        $this->load->view('layouts/admin/index',$data);
	}
	
	public function form($id='')
	{ 
		$data['detail'] = $this->db->get_where($this->table,array('id'=>$id))->row();
		$data['items'] = $this->crud_model->get_where('gallery_images',array('status !='=>'2','gallery_id'=>$id));
		$doc_path='uploads/gallery/';
		if($this->input->post()){
			$this->form_validation->set_rules('title', 'Title', 'required|trim');    
			if($this->form_validation->run()){
				if (strlen($_FILES['CoverImage']['name']) > 0) {

					$config['upload_path'] = $doc_path;

					$config['allowed_types'] = 'jpeg|jpg|gif|png|pdf';

					$config['max_size'] = '300000';
					$this->load->library('upload', $config);

					if (!$this->upload->do_upload('CoverImage')) {

						$this->session->set_flashdata('error', $this->upload->display_errors());
						if ($id == '') {
							redirect($this->redirect . 'form');
						} else {
							redirect($this->redirect . 'form/' . $id);
						}
					} else {

						$file = $this->upload->data();

						$CoverImage= $doc_path.$file['file_name'];
					}
				} else {
					if (isset($data['detail']->CoverImage) && $data['detail']->CoverImage != '') {
						$CoverImage= $data['detail']->CoverImage;
					} else {
						$CoverImage= "";
					}
				}
				$data = array(
							'title' => $this->input->post('title'),
							'title_nepali' => $this->input->post('title_nepali'),  
							'CoverImage' => $CoverImage, 
							'description_nepali' => $this->input->post('description_nepali'),
							'description' => $this->input->post('description'),
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
				// 	$result = $this->crud_model->insert($this->table, $data);
				    $rid=$this->crud_model->inserted($this->table, $data);
    					if(!empty($_FILES['files']['name']) && count(array_filter($_FILES['files']['name'])) > 0){ 
    						$filesCount = count($_FILES['files']['name']); 
    						for($i = 0; $i < $filesCount; $i++){ 
    							$_FILES['file']['name']     = $_FILES['files']['name'][$i]; 
    							$_FILES['file']['type']     = $_FILES['files']['type'][$i]; 
    							$_FILES['file']['tmp_name'] = $_FILES['files']['tmp_name'][$i]; 
    							$_FILES['file']['error']     = $_FILES['files']['error'][$i]; 
    							$_FILES['file']['size']     = $_FILES['files']['size'][$i]; 
    							
    							// File upload configuration 
    							$config['upload_path'] = $doc_path; 
    							$config['allowed_types'] = 'jpg|jpeg|png|gif'; 
    							//$config['max_size']    = '100'; 
    							//$config['max_width'] = '1024'; 
    							//$config['max_height'] = '768'; 
    							
    							// Load and initialize upload library 
    							$this->load->library('upload', $config); 
    							$this->upload->initialize($config); 
    							
    							// Upload file to server 
    							if($this->upload->do_upload('file')){ 
    								// Uploaded file data 
    								$fileData = $this->upload->data(); 
    								$uploadData[$i]['DocPath'] = $doc_path.$fileData['file_name']; 
    								$uploadData[$i]['created_on'] = date("Y-m-d H:i:s"); 
    								$uploadData[$i]['gallery_id'] =$rid;
    								$uploadData[$i]['status'] = '1';
    							}else{  
    								$errorUploadType .= $_FILES['file']['name'].' | ';  
    							} 
    						} 
    						
    						$errorUploadType = !empty($errorUploadType)?'<br/>File Type Error: '.trim($errorUploadType, ' | '):''; 
    						if(!empty($uploadData)){ 
    							// Insert files data into the database 
    						
    							$insert = $this->crud_model->insertarr('gallery_images',$uploadData); 
    							
    							// Upload status message 
    							$statusMsg = $insert?'Files uploaded successfully!'.$errorUploadType:'Some problem occurred, please try again.'; 
    							$this->session->set_flashdata('success',$statusMsg);
    						}else{ 
    							$statusMsg = "Sorry, there was an error uploading your file.".$errorUploadType; 
    							$this->session->set_flashdata('error',$statusMsg);
    						} 
    				}
    				// else{ 
    				// 	$statusMsg = 'Please select image files to upload.'; 
    				// }
					
					if($rid){
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
					if(!empty($_FILES['files']['name']) && count(array_filter($_FILES['files']['name'])) > 0){ 
						$filesCount = count($_FILES['files']['name']); 
						for($i = 0; $i < $filesCount; $i++){ 
							$_FILES['file']['name']     = $_FILES['files']['name'][$i]; 
							$_FILES['file']['type']     = $_FILES['files']['type'][$i]; 
							$_FILES['file']['tmp_name'] = $_FILES['files']['tmp_name'][$i]; 
							$_FILES['file']['error']     = $_FILES['files']['error'][$i]; 
							$_FILES['file']['size']     = $_FILES['files']['size'][$i]; 
							
							// File upload configuration 
							$config['upload_path'] = $doc_path; 
							$config['allowed_types'] = 'jpg|jpeg|png|gif'; 
							//$config['max_size']    = '100'; 
							//$config['max_width'] = '1024'; 
							//$config['max_height'] = '768'; 
							
							// Load and initialize upload library 
							$this->load->library('upload', $config); 
							$this->upload->initialize($config); 
							
							// Upload file to server 
							if($this->upload->do_upload('file')){ 
								// Uploaded file data 
								$fileData = $this->upload->data(); 
								$uploadData[$i]['DocPath'] = $doc_path.$fileData['file_name']; 
								$uploadData[$i]['created_on'] = date("Y-m-d H:i:s"); 
								$uploadData[$i]['gallery_id'] =$id;
								$uploadData[$i]['status'] = '1';
							}else{  
								$errorUploadType .= $_FILES['file']['name'].' | ';  
							} 
						} 
						
						$errorUploadType = !empty($errorUploadType)?'<br/>File Type Error: '.trim($errorUploadType, ' | '):''; 
						if(!empty($uploadData)){ 
							// Insert files data into the database 
						
							$insert = $this->crud_model->insertarr('gallery_images',$uploadData); 
							
							// Upload status message 
							$statusMsg = $insert?'Files uploaded successfully!'.$errorUploadType:'Some problem occurred, please try again.'; 
							$this->session->set_flashdata('success',$statusMsg);
						}else{ 
							$statusMsg = "Sorry, there was an error uploading your file.".$errorUploadType; 
							$this->session->set_flashdata('error',$statusMsg);
						} 
        			}
        			// else{ 
        			// 	$statusMsg = 'Please select image files to upload.'; 
        			// }
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
		$data['gallery'] = 'gallery-form';
		$data['doc_path'] = $doc_path;
		$data = array_merge($this->data, $data);
        $this->load->view('layouts/admin/index',$data);
	}
    
    public function detail_delete($id){
		$data = array(
			'status' => '2',
			'updated_by' => $this->current_user->id, 
			'updated_on' => date('Y-m-d'),
		);
	
		$result = $this->crud_model->update('gallery_images', $data,array('id'=>$id));
		$gallery= $this->crud_model->get_where_single('gallery_images',array('id'=>$id));
		
		if($result==true){
			$this->session->set_flashdata('success','Successfully Deleted.');
			redirect($this->redirect.'form/'.$gallery->gallery_id);
		}else{
			$this->session->set_flashdata('error', 'Unable To Delete.');
			redirect($this->redirect.'form/'.$gallery->gallery_id);
		}
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