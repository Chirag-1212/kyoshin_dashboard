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
		$this->table = 'csr';
		$this->title = 'Commitment To CSR';
		$this->redirect = 'csr/admin/';
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
		$config['base_url'] = base_url($this->redirect . 'all');
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

		// $data['pagination'] = $this->pagination->create_links();

		$items = $this->crud_model->getData($this->table, $param, $like, $config["per_page"], $page,'*','datevalue DESC');
	
		$data = array_merge($this->data, [
			'title' => $this->title,
			'page' => 'list',
			'items' => $items,
			'redirect' => $this->redirect,
			'form_link' => $this->redirect . 'form/',
			'form_check_value' => 'form',
			'delete_link' => $this->redirect . 'soft_delete/',
			'delete_check_value' => 'soft_delete',
			'pagination' =>  $this->pagination->create_links(),
			'csr' => 'csr-all',
			'offset' => $page
		]);
		
		$this->load->view('layouts/admin/index', $data);
	}

	public function form($id = '')
	{
		$data['detail'] = $this->crud_model->get_where_single($this->table, array('id' => $id));
		$data['items'] = $this->crud_model->get_where('csr_images',array('status !='=>'2','csr_id'=>$id));
		$doc_path='uploads/csr_Activities/';
		if ($this->input->post()) {
			// echo "<pre>";
			// var_dump($this->input->post());
			// exit; 
			$this->form_validation->set_rules('Title', 'Title', 'required|trim');
			$this->form_validation->set_rules('fiscal_id', 'Fiscal Year', 'required|trim', [
				'required' => 'This  %s Field is required'
			]);
			if ($this->form_validation->run()) {
				$id = $this->input->post('id');
                
                if (strlen($_FILES['CoverImage']['name']) > 0) {

					$config['upload_path'] = $doc_path;

					$config['allowed_types'] = 'jpeg|jpg|gif|png|pdf';

					$config['max_size'] = '50000';

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

						$CoverImage = $doc_path.$file['file_name'];
					}
				} else {
					if (isset($data['detail']->CoverImage) && $data['detail']->CoverImage != '') {
						$CoverImage = $data['detail']->CoverImage;
					} else {
						$CoverImage = "";
					}
				}


				if (strlen($_FILES['DocPath']['name']) > 0) {

					$config['upload_path'] = $doc_path;

					$config['allowed_types'] = 'jpeg|jpg|gif|png|pdf';

					$config['max_size'] = '300000';

					$this->load->library('upload', $config);

					if (!$this->upload->do_upload('DocPath')) {

						$this->session->set_flashdata('error', $this->upload->display_errors());
						if ($id == '') {
							redirect($this->redirect . 'form');
						} else {
							redirect($this->redirect . 'form/' . $id);
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

				$data = array(
				    'fiscal_id' => $this->input->post('fiscal_id'),
					'datevalue' => $this->input->post('datevalue'),
					'due_date'=> $this->input->post('due_date'),
					'DocPath' => $file_name,
					'CoverImage' => $CoverImage,
					'Title' => $this->input->post('Title'),
					'TitleNepali' => $this->input->post('TitleNepali'),
					'csr_type_id' => $this->input->post('csr_type_id'),
					'show_pop' => $this->input->post('show_pop') ? 'Y' : 'N',
					'Description' => $this->input->post('Description'),
					'DescriptionNepali' => $this->input->post('DescriptionNepali'),
					'status' => $this->input->post('status'),

				);

				if ($id == '') {
					$checktext=$this->crud_model->detectTextLanguage($this->input->post('Title'));
					 	
				    if($checktext==true){
				        $text=$this->input->post('Title');
				    }else{
				        $text=$this->title. time();
				    }
					$slug = $this->crud_model->createUrlSlug($text);
					$check_slug = $this->crud_model->get_where_single($this->table, array('slug' => $slug));
					if (empty($check_slug)) {
						$data['slug'] = strtolower($slug);
					} else {
						$data['slug'] = strtolower($slug) . time();
					}
					
					$data['created_on'] = date('Y-m-d h-i-s');
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
    								$uploadData[$i]['csr_id'] =$rid;
    								$uploadData[$i]['status'] = '1';
    							}else{  
    								$errorUploadType .= $_FILES['file']['name'].' | ';  
    							} 
    						} 
    						
    						$errorUploadType = !empty($errorUploadType)?'<br/>File Type Error: '.trim($errorUploadType, ' | '):''; 
    						if(!empty($uploadData)){ 
    							// Insert files data into the database 
    						
    							$insert = $this->crud_model->insertarr('csr_images',$uploadData); 
    							
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
						redirect($this->redirect . 'all');
					} else {
						$this->session->set_flashdata('error', 'Unable To Insert.');
						redirect($this->redirect . 'form');
					}
				} else {
					$data['updated_on'] = date('Y-m-d');
					$data['updated_by'] = $this->userId;
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
								$uploadData[$i]['csr_id'] =$id;
								$uploadData[$i]['status'] = '1';
							}else{  
								$errorUploadType .= $_FILES['file']['name'].' | ';  
							} 
						} 
						
						$errorUploadType = !empty($errorUploadType)?'<br/>File Type Error: '.trim($errorUploadType, ' | '):''; 
						if(!empty($uploadData)){ 
							// Insert files data into the database 
						
							$insert = $this->crud_model->insertarr('csr_images',$uploadData); 
							
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
						redirect($this->redirect . 'all');
					} else {
						$this->session->set_flashdata('error', 'Unable To Update.');
						redirect($this->redirect . 'form/' . $id);
					}
				}
			}
		}
		if ($data['detail']) {
			$data['title'] = 'Edit ' . $this->title;
		} else {
			$data['title'] = 'Add ' . $this->title;
		}
		if (isset($data['detail']->csr_type_id)) {
			$selected_parent = $data['detail']->csr_type_id;
		} else {
			$selected_parent = '';
		}
		$data['fiscal_years'] = $this->crud_model->get_where_order_by('fiscal_year', array('status' => '1'), 'title', 'DESC');
		$data['html'] = $this->get_parents_html($selected_parent);
        $data['categories'] = $this->crud_model->get_where_order_by('csr_type', array('status' => '1'), 'id', 'ASC');
		$data['doc_path'] = $doc_path;
		$data['page'] = 'form';
		$data['csr'] = 'csr-form';
		$data = array_merge($this->data, $data);
		
		$this->load->view('layouts/admin/index', $data);
	}
	
	public function detail_delete($id){
		$data = array(
			'status' => '2',
			'updated_by' => $this->current_user->id, 
			'updated_on' => date('Y-m-d'),
		);
	
		$result = $this->crud_model->update('csr_images', $data,array('id'=>$id));
		$csr= $this->crud_model->get_where_single('csr_images',array('id'=>$id));
		
		if($result==true){
			$this->session->set_flashdata('success','Successfully Deleted.');
			redirect($this->redirect.'form/'.$csr->csr_id);
		}else{
			$this->session->set_flashdata('error', 'Unable To Delete.');
			redirect($this->redirect.'form/'.$csr->csr_id);
		}
	}
	
	public function get_parents_html($selected_parent = '')
	{
		$html = '<option>Select Category Name</option>';
		$parents = $this->db->get_where('csr_type', array('status' => '1', 'parent_id' => 0))->result();
		if ($parents) {
			foreach ($parents as $key => $value) {
				$html  .= '<option value="' . $value->id . '" ' . (((isset($value->id)) && $value->id == $selected_parent) ? "selected" : "") . '>' . $value->Title . '</option>';
				$childs = $this->db->get_where('csr_type', array('parent_id' => $value->id, 'status' => '1'))->result();
				if (!empty($childs)) {
					$space = '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
					// var_dump($this->get_childs($html,$childs,$selected_parent,$space));exit;
					$html .= $this->get_childs($childs, $selected_parent, $space);
				}
			}
		}

		return $html;
	}

	public function get_childs($childs = array(), $selected_parent, $space)
	{
		// var_dump($html);exit;
		$html = '';
		if (!empty($childs)) {
			foreach ($childs as $key => $value) {
				// echo "here";exit;
				$html  .= '<option value="' . $value->id . '" ' . (((isset($value->id)) && $value->id == $selected_parent) ? "selected" : "") . '>' . $space . $value->Title . '</option>';
				$new_childs = $this->db->get_where('csr_type', array('parent_id' => $value->id, 'status' => '1'))->result();
				if (!empty($new_childs)) {
					$space = $space . '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
					$html .= $this->get_childs($new_childs, $selected_parent, $space);
				}
			}
		}
		return $html;
	}

	public function soft_delete($id)
	{
		if ($id == '' || $id == 0) {
			$this->session->set_flashdata('error', 'Select Atleast One');
			redirect($this->redirect . 'all');
		}
		$data = array(
			'status' => '2',
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