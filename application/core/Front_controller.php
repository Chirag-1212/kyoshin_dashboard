<?php
// echo "here";exit;

if (!defined('BASEPATH')) exit('No direct script access allowed');

class Front_controller extends MX_Controller
{

    protected $_data = array();

    public function __construct()
    {
        parent::__construct();
        $this->_data['base_url'] = base_url(); 
        
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<div class="error">', '</div>');
		
        $site_settings = $this->crud_model->get_where_single('site_settings',array('status'=>'1'));
        $this->session->set_userdata('site_settings',$site_settings); 
    }
	
	
	

}