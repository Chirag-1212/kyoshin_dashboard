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
		$this->table = 'grievance';
		$this->redirect = 'grievance/admin/';
		$this->title = 'Grievance';
		$this->userId = $this->data['userId'];
	}
    
   
	
	public function all($page='')
	{ 
		
		$like = [];
		$param = [
			'status !=' => '2'
		];
		$status = '';
		$date_from = '';
		$date_to = '';
		$title = '';
		$mobno = '';
		$email = '';
		if($this->input->method() == 'get'){
			$title = $this->input->get('Title');
			$status = $this->input->get('status');
			$date_from = $this->input->get('date_from');
			$date_to = $this->input->get('date_to');
			$mobno =$this->input->get('mobno');
			$email=$this->input->get('email');
			
			if($status){
				$param['status'] = $status;
			}
			if($date_from && $date_to){
				$param['date_forex >='] = $date_from;
				$param['date_forex <='] = $date_to;
			}
			if($title){
				$like['name'] = $title;
			}

			if($email){
				$like['email'] = $email;
			}

			if($mobno){
				$param['mobno'] = $mobno;
			}

		}
		$total = $this->crud_model->total($this->table, $param, $like);

		$config['base_url'] = base_url($this->redirect . '/admin/search');
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
		$config['suffix'] = "?date_from=$date_from&date_to=$date_to&satus=$status&Title=$title&mobno=$mobno&email=$email";
		$this->pagination->initialize($config);

		$page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
		
		$items = $this->crud_model->getData($this->table, $param, $like, $config["per_page"], $page);
	
		$data = array_merge($this->data, [
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
			'grievance' => 'grievance-all',
			'pagination' =>  $this->pagination->create_links(),
			'offset' => $page
			
		]); 

        $this->load->view('layouts/admin/index',$data);
	}
	
	public function form($id='')
	{ 
		
		$detail = $this->db->get_where($this->table,array('id'=>$id))->row();
		$email = $detail->email;
		$user_code = $detail->user_code;
		$data['detail'] = $detail;
		if($this->input->post()){ 
			$this->form_validation->set_rules('issue_reply', 'Issue Reply', 'required|trim');  
			if($this->form_validation->run()){
				$data = array(
							'issue_reply' => $this->input->post('issue_reply'), 
						);   				
				$id = $this->input->post('id');	 	
				if($id == ''){  
				    
				}else{ 
					$data['updated'] = date('Y-m-d');
					$data['approved_by'] = $this->userId; 
					$data['updated_by'] = $this->userId; 
					$data['status'] = '1';
					$result = $this->crud_model->update($this->table, $data,array('id'=>$id));
					if($result==true){
					    $this->load->library('email');
                        
                         $config = Array(
                            'protocol' => 'sendmail',
                            'smtp_host' => 'mi3-sr5.supercp.com',
                            'smtp_port' => '465',
                            'smtp_user' => 'UUrE7(WD6?V~', 
                            'smtp_pass' => 'lVoa1vVP;&A5', 
                            'mailtype' => 'html',
                            'charset' => 'utf-8',
                            'wordwrap' => TRUE
                        );
                        
                        $this->email->initialize($config);
                        $this->email->from('no-reply@gmbf.com.np','Guheswori Merchant Banking & Finance Ltd.');
                        $this->email->to($email);
                       
                        // $this->email->cc();
                        // $this->email->bcc();
                        $this->email->subject('Submission Code');
                        $this->email->message('Please enter the following code to see your grievance progress!!'. '<br>'. '<a href="https://alpha.gmbf.com.np/"> Click Here for your Response </a>'   .'<br>'.$user_code.'<br>'.'Regards,'.'<br>'.'Saptakoshi Development Bank Limited.');
                        
                        if($this->email->send()){
            				$this->session->set_flashdata('success','Successfully Updated.');
            				redirect($this->redirect.'all');
                        }
            			else { 
            				$this->session->set_flashdata('error','Mail Not Sent!');
            				redirect($this->redirect.'all');
            			} 
					}else{
						$this->session->set_flashdata('error', 'Unable To Update.');
						redirect($this->redirect.'form/'.$id);
					}
				}   
			}
		} 
		$data['title'] = 'Edit '.$this->title;
        $data['page'] = 'form';
		$data['grievance'] = 'grievance-form';
		$data = array_merge($this->data, $data);

        $this->load->view('layouts/admin/index',$data);
	}
	
	public function view($id='')
	{ 
		
		$detail = $this->db->get_where($this->table,array('id'=>$id))->row();
		$email = $detail->email;
		$user_code = $detail->user_code;
		$data['detail'] = $detail;  
		$data['title'] = 'View '.$this->title;
        $data['page'] = 'view';
		$data = array_merge($this->data, $data);

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