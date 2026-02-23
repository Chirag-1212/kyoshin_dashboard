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
		$this->table = 'taxreceivable';
		$this->title = 'Share Divident';
		$this->redirect = 'bonustaxchecks';
		$this->userId = $this->data['userId'];
	}
    public function search($page = '')
	{

		$title = $this->input->post('Title');
		$boid= $this->input->post('boid');
		$status = $this->input->post('status');
		$date_from = $this->input->post('date_from');
		$date_to = $this->input->post('date_to');
// 		print_r($Type);die;
		
		$data_filter = array(
		    	'sh_name' => $title,
			    'boid' => $boid,
    			'status' => $status,
    			'created_on >=' => $date_from,
    			'created_on <=' => $date_to,	
    			'status !=' => '2',
    		);
		
		$all_data = $this->crud_model->count_all_data($this->table, $data_filter);
// 		var_dump($this->db->last_query());exit;
// 		var_dump($all_data);
// 		exit;
		$config['base_url'] = base_url($this->redirect . '/admin/search');
		$config['total_rows'] = $all_data->total;
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

		$this->pagination->initialize($config);


		$page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
		$items = $this->crud_model->get_all_data($this->table, $data_filter, $config['per_page'], $page);

	
		$data = array(
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
			'pagination' =>  $this->pagination->create_links()
		); 
		// var_dump($data);
		// exit;
		$this->load->view('layouts/admin/index', $data);
	}
	

	public function all($page = '')
	{
		$config['base_url'] = base_url($this->redirect . '/admin/all');
		$config['total_rows'] = $this->crud_model->count_all($this->table, array('status !=' => '2'), 'id');
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

		$this->pagination->initialize($config);

		$page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;

		// $data['pagination'] = $this->pagination->create_links();



		// $items = $this->crud_model->get_where_pagination('user_role', array('status !=' => '2'), $config["per_page"], $page);
		$items = $this->crud_model->get_where_pagination_order_by($this->table, array('status !=' => '2'), $config['per_page'], $page, 'sh_name', 'ASC');

		// echo "<pre>";
		// var_dump($this->db->last_query());
		// exit;
		$data = array(
			'title' => $this->title,
			'page' => 'list',
			'items' => $items,
			'redirect' => $this->redirect,
			'form_link' => $this->redirect . '/admin/form/',
			'form_check_value' => 'form',
			'delete_link' => $this->redirect . '/admin/soft_delete/',
			'delete_check_value' => 'soft_delete',
			'pagination' =>  $this->pagination->create_links()
		);
		// var_dump($data);
		// exit;
		$this->load->view('layouts/admin/index', $data);
	}

	public function form($id = '')
	{
		if ($this->input->post()) {
			$this->form_validation->set_rules('forex', 'File', 'required|trim');
			if ($this->form_validation->run()) {

				if (strlen($_FILES['forex']['name']) > 0) {

					$config['upload_path'] = 'uploads/forex/';

					$config['allowed_types'] = 'xlsx|xls|csv';

					$config['max_size'] = '1000000';





					$this->load->library('upload', $config);

					if (!$this->upload->do_upload('forex')) {

						$this->session->set_flashdata('error', $this->upload->display_errors());
						redirect($this->redirect . '/admin/form');
					} else {

						$file = $this->upload->data();

						$file_name = $file['file_name'];

						@ini_set('max_execution_time', 9000); //phpinfo();exit;
						$fp1 = file('uploads/forex/' . $file_name); //$fp1 = str_getcsv($fp11, ",", '"');

						if ($this->input->post()) {
							for ($i = 2; $i < count($fp1); $i++) {
								$fp2 = $fp1[$i];
								$fp2 = explode(',', $fp2);
								//var_dump($fp2); die();
								for ($j = 0; $j < count($fp2); $j++) {
									if ($j == 0) {
										$fy = $fp2[$j];
									} elseif ($j == 1) {
										$shareholder_type = $fp2[$j];
										@$shareholder_type =  str_replace('::::', ';', $shareholder_type);
										@$shareholder_type =  str_replace(':::', ',', $shareholder_type);
									} elseif ($j == 2) {
										$hold_in = ($fp2[$j]);
										@$hold_in =  str_replace('::::', ';', $hold_in);
										@$hold_in =  str_replace(':::', ',', $hold_in);
									} elseif ($j == 3) {
										$tax_exempt_type =  ($fp2[$j]);
										@$tax_exempt_type =  str_replace('::::', ';', $tax_exempt_type);
										@$tax_exempt_type =  str_replace(':::', ',', $tax_exempt_type);
									} elseif ($j == 4) {
										$boid =  ($fp2[$j]);
										@$boid =  str_replace('::::', ';', $boid);
										@$boid =  str_replace(':::', ',', $boid);
									} elseif ($j == 5) {
										$sh_name =  ($fp2[$j]);
										@$sh_name =  str_replace('::::', ';', $sh_name);
										@$sh_name =  str_replace(':::', ',', $sh_name);
									} elseif ($j == 6) {
										$share_unit_hold =  ($fp2[$j]);
										@$share_unit_hold =  str_replace('::::', ';', $share_unit_hold);
										@$share_unit_hold =  str_replace(':::', ',', $share_unit_hold);
									} elseif ($j == 7) {
										$bonus_share =  ($fp2[$j]);
										@$bonus_share =  str_replace('::::', ';', $bonus_share);
										@$bonus_share =  str_replace(':::', ',', $bonus_share);
									} elseif ($j == 8) {
										$cash_dividend =  ($fp2[$j]);
										@$cash_dividend =  str_replace('::::', ';', $cash_dividend);
										@$cash_dividend =  str_replace(':::', ',', $cash_dividend);
									} elseif ($j == 9) {
										$already_paid =  ($fp2[$j]);
										@$already_paid =  str_replace('::::', ';', $already_paid);
										@$already_paid =  str_replace(':::', ',', $already_paid);
									} elseif ($j == 10) {
										$tax_recovered =  ($fp2[$j]);
										@$tax_recovered =  str_replace('::::', ';', $tax_recovered);
										@$tax_recovered =  str_replace(':::', ',', $tax_recovered);
									} elseif ($j == 11) {
										$cd_payable =  ($fp2[$j]);
										@$cd_payable =  str_replace('::::', ';', $cd_payable);
										@$cd_payable =  str_replace(':::', ',', $cd_payable);
									} elseif ($j == 12) {
										$dividend_tax =  ($fp2[$j]);
										@$dividend_tax =  str_replace('::::', ';', $dividend_tax);
										@$dividend_tax =  str_replace(':::', ',', $dividend_tax);
									} elseif ($j == 13) {
										$received_on_p_y =  ($fp2[$j]);
										@$received_on_p_y =  str_replace('::::', ';', $received_on_p_y);
										@$received_on_p_y =  str_replace(':::', ',', $received_on_p_y);
									} elseif ($j == 14) {
										$dt_recovery_cd =  ($fp2[$j]);
										@$dt_recovery_cd =  str_replace('::::', ';', $dt_recovery_cd);
										@$dt_recovery_cd =  str_replace(':::', ',', $dt_recovery_cd);
									} elseif ($j == 15) {
										$dt_receivable =  ($fp2[$j]);
										@$dt_receivable =  str_replace('::::', ';', $dt_receivable);
										@$dt_receivable =  str_replace(':::', ',', $dt_receivable);
									} elseif ($j == 16) {
										$net_receivable =  ($fp2[$j]);
										@$net_receivable =  str_replace('::::', ';', $net_receivable);
										@$net_receivable =  str_replace(':::', ',', $net_receivable);
									}
								}
								//var_dump($j); die();
								$fy = $fy ? $fy : '2073/74';

								$data1 = array(
									'sh_name' => $sh_name,
									'boid' => $boid,
									'fy' => $fy,
									'shareholder_type' => $shareholder_type,
									'tax_exempt_type' => $tax_exempt_type,
									'hold_in' => $hold_in,
									'share_unit_hold' => $share_unit_hold,
									'bonus_share' => $bonus_share,
									'cash_dividend' => $cash_dividend,
									'already_paid' => $already_paid,
									'tax_recovered' => $tax_recovered,
									'cd_payable' => $cd_payable,
									'dividend_tax' => $dividend_tax,
									'received_on_p_y' => $received_on_p_y,
									'dt_recovery_cd' => $dt_recovery_cd,
									'dt_receivable' => $dt_receivable,
									'net_receivable' => $net_receivable,
									'status' => '1',
									'created_by' =>$this->userId,
									'created_on' => date('Y-m-d'),
								);

								// $k = $this->model->insertbonustaxcheck($data1);

								$result = $this->crud_model->insert($this->table, $data1);
							}
						}
					}
				} else {
					$this->session->set_flashdata('error', 'File Is Required');
					redirect($this->redirect . '/admin/form');
				}
			}
		}

		$data['title'] = 'Add ' . $this->title;

		$data['doc_path'] = 'uploads/forex/';
		$data['page'] = 'form';
		$this->load->view('layouts/admin/index', $data);
	}

	public function soft_delete($id)
	{
		if ($id == '' || $id == 0) {
			$this->session->set_flashdata('error', 'Select Atleast One');
			redirect($this->redirect . '/admin/all');
		}
		$data = array(
			'status' => '2',
		);
		$result = $this->crud_model->update($this->table, $data, array('id' => $id));
		if ($result == true) {
			$this->session->set_flashdata('success', 'Successfully Deleted.');
			redirect($this->redirect . '/admin/all');
		} else {
			$this->session->set_flashdata('error', 'Unable To Delete.');
			redirect($this->redirect . '/admin/all');
		}
	}
}