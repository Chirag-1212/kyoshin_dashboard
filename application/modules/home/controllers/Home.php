<?php 

class Home extends Front_controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	public function index()
	{
	    $data['slider'] = $this->crud_model->get_where_single_order_by('sliders',array('status'=>'1'),'id','DESC');
	    $data['clients'] = $this->crud_model->get_where_order_by('clients',array('status'=>'1'),'id','DESC');
	    $data['news'] = $this->crud_model->get_where_pagination('blogs',array('status'=>'1'),3,0);
	    $data['services'] = $this->crud_model->get_where_order_by('services',array('status'=>'1'),'id','DESC');
	    $data['portfolios'] = $this->crud_model->get_where_pagination('portfolio',array('status'=>'1'),8,0);
	    $data['site_settings'] = $this->session->userdata('site_settings'); 
        $data['title'] = 'Home';
        $data['page'] = 'index';
        $this->load->view('layouts/front/index',$data);
	}
	
	public function subscribe()
	{  
		if($this->input->post()){
			$this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email');  
			
			if($this->form_validation->run()){
				$data = array(
							'email' => $this->input->post('email'),
							'created' => date('Y-m-d'),
						);    
					$result = $this->crud_model->insert('subscribers', $data);
					if($result==true){
						$this->session->set_flashdata('success','Thanks For Subscription');
						redirect('home');
					}else{
						$this->session->set_flashdata('error', 'Unable To Subscribe.');
						redirect('home');
					}    
			}
		}  
	}
	
	public function save_contact_message()
	{  
		if($this->input->post()){
			$this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email');
			$this->form_validation->set_rules('name', 'Name', 'required|trim');
			$this->form_validation->set_rules('subject', 'Subject', 'required|trim');
			$this->form_validation->set_rules('message', 'Message', 'required|trim'); 
			
			if($this->form_validation->run()){
				$data = array(
							'email' => $this->input->post('email'),
							'name' => $this->input->post('name'),
							'subject' => $this->input->post('subject'),
							'message' => $this->input->post('message'), 
							'created' => date('Y-m-d'),
						);    
					$result = $this->crud_model->insert('contact_message', $data);
					if($result==true){
					   // $this->send_mail();
					   $message = $data['message'];

                        // In case any of our lines are larger than 70 characters, we should use wordwrap()
                        $message = wordwrap($message, 70, "\r\n");
                        
                        // Send
                        mail('info@shine.com.np', $data['subject'], $message);
						$this->session->set_flashdata('success','Thanks!! Message Seccessfully Sent...');
						redirect('home');
					}else{
						$this->session->set_flashdata('error', 'Unable To Send Message.');
						redirect('home');
					}    
			}
		}  
	}
	
	public function send_mail(){
	    $config = Array(
                  'protocol' => "smtp",
                  'smtp_host' => "smtp.gmail.com",
                  'smtp_port' => 587,
                  'smtp_crypto' => "tls",
                  'smtp_user' => "gurungrajesh1993@gmail.com", // change it to yours
                  'smtp_pass' => "NewRajesh@4567", // change it to yours
                  'mailtype' => "html", 
                  'charset' => "iso-8859-1",
                  'wordwrap' => TRUE
                );
                
        $message = 'Feedback Message sending test';
        $this->load->library('email');
        
        $this->email->initialize($config);
        $this->email->set_newline("\r\n");
        $this->email->from('gurungrajesh1993@gmail.com'); // change it to yours
        $this->email->to('gurungrajesh1992@gmail.com');// change it to yours
        $this->email->subject('Feedback Message');
        $this->email->message($message);
        if($this->email->send())
        {
            echo 'Email sent.';
        }
        else
        {
            show_error($this->email->print_debugger());
        }        
	}
}
