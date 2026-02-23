<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');

class Auth
{

    private $_is_logged = FALSE;
    private $_user = NULL;
    private $_permissions = NULL;
    private $_modules = NULL;

    public function __construct()
    {
        $this->CI = & get_instance();
        $auth_code = $this->CI->session->userdata('auth_code');
        if ($auth_code)
        {
            $this->CI->db->select('*');
            $this->CI->db->from('users');
            $this->CI->db->where('auth_code', $auth_code);
            $this->_user = $this->CI->db->get()->row();
			if($this->_user){
	            $this->_is_logged = TRUE;
			}
			else{
				$this->_is_logged=FALSE;
				$this->clear_auth();  
				redirect(site_url('login/logout'));
			}
        }
    }

    public function set_auth($user_id)
    {
        # Generate a code
        $this->CI->load->helper('string');
        $auth_code = md5(random_string('unique', 9).time().$user_id);

        # Set the session as logged in
        $this->CI->session->set_userdata('auth_code', $auth_code);

        # Update the database
        $data = array('auth_code' => $auth_code);
        $this->CI->db->where('id', $user_id);
        $this->CI->db->update('users', $data);
    }

    public function clear_auth()
    {
        $this->CI->session->sess_destroy();
    }

    public function current_user()
    {
        return $this->_user;
    }

    public function is_logged(){
        return $this->_is_logged;
    }

}

/* End of file auth.php */