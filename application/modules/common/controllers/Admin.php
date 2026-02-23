<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Admin extends Auth_controller
{
	protected $userId;
	public function __construct()
	{
		parent::__construct();
		
		$this->load->library('form_validation');
		$this->userId = $this->data['userId'];
		$this->current_user=$this->data['current_user'];
	} 
	
	public function changepasswordown()
	{
		if ($this->input->post()) {
		
		    $this->form_validation->set_rules('old_password', 'Old Password', 'required');
		    $this->form_validation->set_rules('password', 'Password', 'required');
            $this->form_validation->set_rules('password_conf', 'Confirm Password', 'required|matches[password]');

			if ($this->form_validation->run()) {
				if(md5($this->input->post('old_password')) != $this->current_user->password){
			        $this->session->set_flashdata('error', 'Old password doesnt matched');
				    redirect('dashboard');
			    }
			    $data['password'] = md5($this->input->post('password'));
			    $data['psd_changed_date'] = date('Y-m-d');
			    $data['psd_changed'] = '1';
				$id =$this->userId;
				if ($id != ''){
					$data['updated_on'] = date('Y-m-d');
					$data['updated_by'] =$this->userId;
					$result = $this->crud_model->update('users', $data, array('id' => $id));
					if ($result == true) {
						$this->session->set_flashdata('success', 'Password Changed Successfully!!!');
						redirect('login/logout');
					} else {
						$this->session->set_flashdata('error', 'Unable to change password');
						redirect('dashboard');
					}
				}
			}
		}
	
       	$data['title'] = 'Change Password';
		$data['page'] = 'form';
		$this->load->view('layouts/admin/index', array_merge($this->data, $data));
	} 
}