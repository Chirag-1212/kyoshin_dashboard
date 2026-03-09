<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Admin extends Auth_controller
{
	protected $userId;
	protected $table;
	protected $redirect;
	protected $title;
	protected $module;

	public function __construct()
	{
		parent::__construct();
		
		$this->table = 'news';
		$this->title = 'News';
		$this->redirect = 'news';
		$this->module = 'news';
		$this->userId = $this->data['userId'];
	}
	
	public function all($page = '')
	{
		$like = [];
		$param = [
			'status !=' => '2'
		];
		if($this->input->method() == 'get'){
			$search = $this->input->get('table_search');
			$like['Title'] = $search;
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
		$config['suffix'] = isset($search)?"?table_search=$search":'';
		$this->pagination->initialize($config);

		$page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;

		$items = $this->crud_model->getData($this->table, $param, $like, $config["per_page"], $page);
		// echo "<pre>";
		// var_dump($this->db->last_query());
		// exit;
		
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
			'news' => "news-all",
			'offset' => $page
		]);
		$this->load->view('layouts/admin/index', $data);
	}

	public function form($id = '')
	{
		$data['detail'] = $this->crud_model->get_where_single($this->table, array('id' => $id));
		$data['items'] = $this->crud_model->get_where('news_images',array('status !='=>'2','news_id'=>$id));
		$doc_path='uploads/news/';
		if ($this->input->post()) { 
			$this->form_validation->set_rules('Title', 'Title', 'required|trim');
			if ($this->form_validation->run()) {
				$id = $this->input->post('id');

				if (strlen($_FILES['DocPath']['name']) > 0) {

					$config['upload_path'] = $doc_path;

					$config['allowed_types'] = 'jpeg|jpg|gif|png|pdf';

					$config['max_size'] = '300000';
					$this->load->library('upload', $config);

					if (!$this->upload->do_upload('DocPath')) {

						$this->session->set_flashdata('error', $this->upload->display_errors());
						if ($id == '') {
							redirect($this->redirect . '/admin/form');
						} else {
							redirect($this->redirect . '/admin/form/' . $id);
						}
					} else {

						$file = $this->upload->data();

						$file_name = $doc_path.$file['file_name'];
					}
				} else {
					if (isset($data['detail']->DocPath) && $data['detail']->DocPath != '') {
						$file_name = $data['detail']->DocPath;
					} else {
						$file_name = "";
					}
				}
                
                if (strlen($_FILES['CoverImage']['name']) > 0) {

					$config['upload_path'] = $doc_path;

					$config['allowed_types'] = 'jpeg|jpg|gif|png';

					$config['max_size'] = '300000';
					$this->load->library('upload', $config);

					if (!$this->upload->do_upload('CoverImage')) {

						$this->session->set_flashdata('error', $this->upload->display_errors());
						if ($id == '') {
							redirect($this->redirect . '/admin/form');
						} else {
							redirect($this->redirect . '/admin/form/' . $id);
						}
					} else {

						$cvfile = $this->upload->data();

						$cvfile_name = $doc_path.$cvfile['file_name'];
					}
				} else {
					if (isset($data['detail']->CoverImage) && $data['detail']->CoverImage != '') {
						$cvfile_name = $data['detail']->CoverImage;
					} else {
						$cvfile_name = "";
					}
				}
				$data = array(
					'datevalue' => $this->input->post('datevalue'),
					'due_date'=> $this->input->post('due_date'),
					'CoverImage' => $cvfile_name,
					'DocPath' => $file_name,
					'Title' => $this->input->post('Title'),
					'TitleNepali' => $this->input->post('TitleNepali'),
					'Description' => $this->input->post('Description'),
					'DescriptionNepali' => $this->input->post('DescriptionNepali'),
					'is_slider' => $this->input->post('is_slider')? 'Yes' : 'No',
					'status' => $this->input->post('status'),
					'imp_notice' => $this->input->post('imp_notice') ? 'Y' : 'N',

				);
				

				if ($id == '') {
				    $checktext=$this->crud_model->detectTextLanguage($this->input->post('Title'));
    				 	
    			    if($checktext==true){
    			        $text=$this->input->post('Title');
    			    }else{
    			        $text=$this->title. time();
    			    }
    				$slug = $this->crud_model->createUrlSlug($text);
				// 	$slug = $this->crud_model->createUrlSlug($this->input->post('Title'));
					$check_slug = $this->crud_model->get_where_single($this->table, array('slug' => $slug));
					if (empty($check_slug)) {
						$data['slug'] = strtolower($slug);
					} else {
						$data['slug'] = strtolower($slug) . time();
					}
					$data['created_on'] = date('Y-m-d H:i:s');
					$data['created_by'] = $this->userId;
					
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
							$uploadPath = $doc_path; 
							$config['upload_path'] = $uploadPath; 
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
								$uploadData[$i]['news_id'] =$rid;
								$uploadData[$i]['status'] = '1';
							}else{  
								$errorUploadType .= $_FILES['file']['name'].' | ';  
							} 
						} 
						
						$errorUploadType = !empty($errorUploadType)?'<br/>File Type Error: '.trim($errorUploadType, ' | '):''; 
						if(!empty($uploadData)){ 
							// Insert files data into the database 
						
							$insert = $this->crud_model->insertarr('news_images',$uploadData); 
							
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
					
					
					if ($rid) {
						$this->session->set_flashdata('success', 'Successfully Inserted.');
						redirect($this->redirect . '/admin/all');
					} else {
						$this->session->set_flashdata('error', 'Unable To Insert.');
						redirect($this->redirect . '/admin/form');
					}
				} else {
					$data['updated_on'] = date('Y-m-d');
					$data['updated_by'] = $this->userId;
					$slug = $this->crud_model->createUrlSlug($this->input->post('Title'));
    				$check_slug = $this->crud_model->get_where_single($this->table, array('Title' => $slug));
    				if (empty($check_slug)) {
    					$data['slug'] = strtolower($slug);
    				} else {
    					$data['slug'] = strtolower($slug) . time();
    				}
					$result = $this->crud_model->update($this->table, $data, array('id' => $id));
					
					if(!empty($_FILES['files']['name']) && count(array_filter($_FILES['files']['name'])) > 0){ 
						$filesCount = count($_FILES['files']['name']); 
						for($i = 0; $i < $filesCount; $i++){ 
							$_FILES['file']['name']     = $_FILES['files']['name'][$i]; 
							$_FILES['file']['type']     = $_FILES['files']['type'][$i]; 
							$_FILES['file']['tmp_name'] = $_FILES['files']['tmp_name'][$i]; 
							$_FILES['file']['error']     = $_FILES['files']['error'][$i]; 
							$_FILES['file']['size']     = $_FILES['files']['size'][$i]; 
							
							// File upload configuration 
							$uploadPath = $doc_path; 
							$config['upload_path'] = $uploadPath; 
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
								$uploadData[$i]['news_id'] =$id;
								$uploadData[$i]['status'] = '1';
							}else{  
								$errorUploadType .= $_FILES['file']['name'].' | ';  
							} 
						} 
						
						$errorUploadType = !empty($errorUploadType)?'<br/>File Type Error: '.trim($errorUploadType, ' | '):''; 
						if(!empty($uploadData)){ 
							// Insert files data into the database 
						
							$insert = $this->crud_model->insertarr('news_images',$uploadData); 
							
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
// 		$data['redirect']='news/admin/';
		$data['news'] = $this->module."-form";
		$data['doc_path'] = $doc_path;
		$data['page'] = 'form';
		$this->load->view('layouts/admin/index', array_merge($this->data, $data));
	}
	
	
    public function detail_delete($id){
		$data = array(
			'status' => '2',
			'updated_by' => $this->current_user->id, 
			'updated_on' => date('Y-m-d'),
		);
	
		$result = $this->crud_model->update('news_images', $data,array('id'=>$id));
		$news= $this->crud_model->get_where_single('news_images',array('id'=>$id));
		
		if($result==true){
			$this->session->set_flashdata('success','Successfully Deleted.');
			redirect($this->redirect.'/admin/form/'.$news->news_id);
		}else{
			$this->session->set_flashdata('error', 'Unable To Delete.');
			redirect($this->redirect.'/admin/form/'.$news->news_id);
		}
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