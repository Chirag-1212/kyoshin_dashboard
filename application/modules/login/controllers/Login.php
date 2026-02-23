<?php

class Login extends CI_Controller
{ 
	
	public function __construct()
	{
		parent::__construct();
		$this->load->library('form_validation'); 
       
	   
	} 
	   
	public function index()
    {
        if ($this->auth->is_logged())
        {
            redirect('dashboard');
        } 
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
        if ($this->input->post())
        {
            // echo "here";exit;
            $this->form_validation->set_rules('username', 'Username', 'required');
            $this->form_validation->set_rules('password', 'Password', 'required');
            if ($this->form_validation->run())
            {
                $username = $this->input->post('username');
                $password = md5($this->input->post('password'));
                $user = $this->db->select('id,status')->get_where('users', array('user_name' => $username, 'password' => $password, 'status !=' => '2'))->row();
                if (!empty($user))
                { 
                    if ($user->status == '0')
                    {
                        $this->session->set_flashdata('error','Your account is Dissabled. Please cantact admin.'); 
                        redirect('login');
                    }
                    else
                    {
							$this->auth->set_auth($user->id);
							$this->session->set_flashdata('sucess', 'login successful.'); 
							redirect('dashboard'); 
                    }
                }
                else
                { 
                    
                    $this->session->set_flashdata('error','Invalid Username/Password. Please try again.'); 
                    
                    redirect('login');
                }
            }
        } 
		$this->_data['page_title'] = 'Login';
        $this->_data['site_settings'] = $this->crud_model->get_where_single('site_settings', array('status' => '1'));
        $this->load->view('login', $this->_data);
    }

    public function logout() {
        $this->auth->clear_auth();
        redirect('login'); 
    }  

}

/* End of file login_controller.php */
/* Location: ./application/modules/login/controllers/login_controller.php */