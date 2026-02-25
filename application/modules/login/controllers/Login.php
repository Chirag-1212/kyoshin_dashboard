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
        // Redirect if already logged in
        if ($this->auth->is_logged()) {
            redirect('dashboard');
        } 

        $this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');

        if ($this->input->post()) {
            $this->form_validation->set_rules('username', 'Username', 'required');
            $this->form_validation->set_rules('password', 'Password', 'required');

            if ($this->form_validation->run()) {
                $username = trim($this->input->post('username'));
                $password = md5(trim($this->input->post('password')));

                // ✅ Fetch user with role_id
                $user = $this->db->select('id, role_id, status')
                                 ->get_where('users', [
                                     'user_name' => $username,
                                     'password'  => $password,
                                     'status !=' => "2"
                                 ])
                                 ->row();

                if (!empty($user)) { 
                    if ($user->status == "0") {
                        $this->session->set_flashdata('error', 'Your account is disabled. Please contact admin.'); 
                        redirect('login');
                    }

                    // ✅ Set session data including role_id
                    $this->session->set_userdata([
                        'user_id'   => $user->id,
                        'username'  => $username,
                        'role_id'   => $user->role_id,   // Important for menus
                        'logged_in' => true
                    ]);

                    // Set auth if your auth library needs it
                    $this->auth->set_auth($user->id);

                    $this->session->set_flashdata('success', 'Login successful.'); 
                    redirect('dashboard'); 
                } else { 
                    $this->session->set_flashdata('error','Invalid Username/Password. Please try again.'); 
                    redirect('login');
                }
            }
        } 

        $this->_data['page_title'] = 'Login';
        $this->_data['site_settings'] = $this->crud_model->get_where_single('site_settings', ['status' => "1"]);
        $this->load->view('login', $this->_data);
    }

    public function logout() {
        $this->auth->clear_auth();
        $this->session->sess_destroy(); // clear all session data
        redirect('login'); 
    }  
}

/* End of file login_controller.php */
/* Location: ./application/modules/login/controllers/login_controller.php */