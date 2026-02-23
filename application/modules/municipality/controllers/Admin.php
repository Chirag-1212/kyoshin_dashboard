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
		$this->table = 'municipality';
		$this->redirect = 'municipality/admin/';
		$this->title = 'Municipality';
		$this->userId = $this->data['userId'];
	}
	
	public function all($page='')
	{ 
		$like = [];
		$param = [
			'status !=' => '2',
		];
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
		$data['items'] = $this->crud_model->getData($this->table, $param, $like, $config["per_page"], $page);
		
		$data['offset'] = $page;
		$data['title'] = $this->title;
        $data['page'] = 'list';
		$data['district'] = 'district-all';
		$data['redirect'] = $this->redirect;
		$data = array_merge($this->data, $data);
        $this->load->view('layouts/admin/index',$data);
	}
	
	public function form($id='')
	{ 
		
		$data['detail'] = $this->db->get_where($this->table,array('id'=>$id))->row();
		if($this->input->post()){
			$this->form_validation->set_rules('title', '', 'required|trim', [
			    'required' => "This field is required"    
			]); 
			$this->form_validation->set_rules('province_id', '', 'required|trim', [
			    'required' => "This field is required"    
			]);
			$this->form_validation->set_rules('district_id', '', 'required|trim', [
			    'required' => "This field is required"    
			]);
			if($this->form_validation->run()){
				$data = array(
					'title' => $this->input->post('title'),
					'title_nepali' => $this->input->post('title_nepali'),
					'province_id' => $this->input->post('province_id'),  
					'district_id' => $this->input->post('district_id'),
					'status' => $this->input->post('status'),  
				);   				
				$id = $this->input->post('id');	 	
				if($id == ''){ 
					$data['created_by'] = $this->userId; 
					$result = $this->crud_model->insert($this->table, $data);
					
					if($result){
						$this->session->set_flashdata('success','Successfully Inserted.');
						redirect($this->redirect.'all');
					}
					$this->session->set_flashdata('error', 'Unable To Insert.');
					redirect($this->redirect.'form');
					
				}else{ 
					$data['updated'] =  date('Y-m-d H:i:s'); 
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
		$data['provinces'] = $this->crud_model->get_where_order_by('provinces', array('status'=>'1'), 'p_no', 'DESC');
		$data['districts'] = $this->crud_model->get_where_order_by('districts', array('status'=>'1'), 'id', 'DESC');
		$data['title'] = 'Add/Edit '.$this->title;
        $data['page'] = 'form';
		$data['district'] = 'district-form';
		$data = array_merge($this->data, $data);
        $this->load->view('layouts/admin/index',$data);
	}
	
	function getDistrict(){
	    try {
    	    if (!$this->input->is_ajax_request()) {
    			$response = array(
    				'status' => 'error',
    				'status_code' => 300,
    				'status_message' => 'No direct script access allowed', 
    			);
    			header('Content-Type: application/json');
    	        echo json_encode($response);
    		}   
			
			$provinceId = $this->input->post('provinceId');
			$param = [
			    'province_id' => $provinceId,
			    'status' => '1'
			];
			$provinces = $this->crud_model->getData('districts', $param, [], 0, 0);
			$html = "<option value=''> Select Branch Name </option>";
			if($provinces){
		        
		        foreach($provinces as $key => $item){
		            $value = $item->id;
		            $label = $item->title;
		            $html .= "<option value='$value'>$label</option>";
		            
		        }
		        
                
                $response = array(
    				'status' => 'success',
    				'status_code' => 200,
    				'status_message' => 'Successfully retrive data',
    				'data' => $html
    			);
    			header('Content-Type: application/json');
    	        echo json_encode($response);exit;
		    }
           
		    $response = array(
				'status' => 'error',
				'status_code' => 500,
				'status_message' => 'Server Error', 
			);
			header('Content-Type: application/json');
	        echo json_encode($response);
			    
			
		} catch (Exception $e) {
			$response = array(
				'status' => 'error',
				'status_message' => $e->getMessage()
			);
			header('Content-Type: application/json');
		echo json_encode($response);
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