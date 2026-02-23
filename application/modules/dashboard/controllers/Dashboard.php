<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends Auth_controller {
	protected $userId;
	public function __construct()
	{
		parent::__construct();
		$this->userId = $this->data['userId']; 
	}
	
	public function index()
	{ 
   
		$data['title'] = 'Dashboard';
        $data['page'] = 'dashboard';
		$data['dashboard'] = 'dashboard';
		
		$data = array_merge($this->data, $data);

        $this->load->view('layouts/admin/index', $data);
	}
}