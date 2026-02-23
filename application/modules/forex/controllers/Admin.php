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
		$this->table = 'forex_date';
		$this->title = 'Forex';
		$this->redirect = 'forex';
		$this->userId = $this->data['userId'];
	}
	

	public function all($page = '')
	{
		$like = [];
		$param = [
			'status !=' => '2'
		];
		$status = '';
		$date_from = '';
		$date_to = '';
		if($this->input->method() == 'get'){
			$status = $this->input->get('status');
			$date_from = $this->input->get('date_from');
			$date_to = $this->input->get('date_to');
			if($status){
				$param['status'] = $status;
			}
			if($date_from && $date_to){
				$param['date_forex >='] = $date_from;
				$param['date_forex <='] = $date_to;
			}
		}
		$total = $this->crud_model->total($this->table, $param, $like);
		$config['base_url'] = base_url($this->redirect . '/admin/all');
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
		
		$config['suffix'] = "?date_from=$date_from&date_to=$date_to&satus=$status";
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
			'delete_link' => $this->redirect . '/admin/soft_delete/',
			'delete_check_value' => 'soft_delete',
			'view_link' => $this->redirect . '/admin/view/',
			'view_check_value' => 'view',
			'pagination' =>  $this->pagination->create_links(),
			'forex' => 'forex-all',
			'offset' => $page
		]);
		
		$this->load->view('layouts/admin/index', $data);
	}

	public function form($id = '')
	{
		$data['detail'] = $this->crud_model->get_where_single($this->table, array('id' => $id));
		if ($this->input->post()) {
			// echo "<pre>";
			// var_dump($this->input->post());
			// exit;
			$this->form_validation->set_rules('Date', 'Date', 'required|trim');
			$this->form_validation->set_rules('Time', 'Time', 'required|trim');
			if ($this->form_validation->run()) {
				$id = $this->input->post('id');

				if (strlen($_FILES['FileName']['name']) > 0) {

					$config['upload_path'] = 'uploads/forex/';

					$config['allowed_types'] = 'csv';

					$config['max_size'] = '3000';





					$this->load->library('upload', $config);

					if (!$this->upload->do_upload('FileName')) {

						$this->session->set_flashdata('error', $this->upload->display_errors());
						if ($id == '') {
							redirect($this->redirect . '/admin/form');
						} else {
							redirect($this->redirect . '/admin/form/' . $id);
						}
					} else {

						$file = $this->upload->data();

						$file_name = $file['file_name'];
					}
				} else {
					if (isset($data['detail']->FileName) && $data['detail']->FileName != '') {
						$file_name = $data['detail']->FileName;
					} else {
						$file_name = "";
					}
				}

				$data = array(
					'Date' => $this->input->post('Date'),
					'FileName' => $file_name,
					'Time' => $this->input->post('Time'),
					'status' => $this->input->post('status'),

				);

				if ($id == '') {
					$data['created_on'] = date('Y-m-d');
					$data['created_by'] = $this->userId;
					$result = $this->crud_model->insert($this->table, $data);
					$insert_id = $this->db->insert_id();
					if ($result == true) {

						if ($file_name != '') {
							$fp1 = file('uploads/forex/' . $file_name);

							for ($i = 0; $i < count($fp1); $i++) {

								$fp2 = $fp1[$i];



								$fp2 = explode(',', $fp2);



								for ($j = 0; $j < count($fp2); $j++) {

									if ($j == 0)

										$currency = strtoupper($fp2[$j]);

									elseif ($j == 1)

										$buying1 = $fp2[$j];

									elseif ($j == 2)

										$buying2 = ($fp2[$j]);

									elseif ($j == 3)

										$selling1 = $fp2[$j];

									// elseif ($j == 4)

									// 	$selling2 = $fp2[$j];

									// elseif ($j == 5)

									// 	$selling3 = $fp2[$j];
								}

								$data1 = array(

									'ForexId' => $insert_id,

									'CurrencyId' => $currency,

									'Buying1' => $buying1,

									'Buying2' => $buying2,

									'Selling1' => $selling1,

									// 'Selling2' => $selling2,

									// 'Selling3' => $selling3

								);

								$this->crud_model->insert('forex', $data1);
							}
						}

						$this->session->set_flashdata('success', 'Successfully Inserted.');
						redirect($this->redirect . '/admin/all');
					} else {
						$this->session->set_flashdata('error', 'Unable To Insert.');
						redirect($this->redirect . '/admin/form');
					}
				} else {
					$data['updated_on'] = date('Y-m-d');
					$data['updated_by'] = $this->userId;
					$result = $this->crud_model->update($this->table, $data, array('id' => $id));
					if ($result == true) {
						if ($file_name != '') {

							$this->db->delete('forex', array('ForexId' => $id));

							$fp1 = file('uploads/forex/' . $file_name);

							for ($i = 0; $i < count($fp1); $i++) {

								$fp2 = $fp1[$i];



								$fp2 = explode(',', $fp2);



								for ($j = 0; $j < count($fp2); $j++) {

									if ($j == 0)

										$currency = strtoupper($fp2[$j]);

									elseif ($j == 1)

										$buying1 = $fp2[$j];

									elseif ($j == 2)

										$buying2 = ($fp2[$j]);

									elseif ($j == 3)

										$selling1 = $fp2[$j];

									elseif ($j == 4)

										$selling2 = $fp2[$j];

									elseif ($j == 5)

										$selling3 = $fp2[$j];
								}

								$data1 = array(

									'ForexId' => $id,

									'CurrencyId' => $currency,

									'Buying1' => $buying1,

									'Buying2' => $buying2,

									'Selling1' => $selling1,

									'Selling2' => $selling2,

									'Selling3' => $selling3

								);
								$this->crud_model->update('forex', $data1, array('ForexId' => $id));
							}
						}
						$this->session->set_flashdata('success', 'Successfully Updated.');
						redirect($this->redirect . '/admin/all');
					} else {
						$this->session->set_flashdata('error', 'Unable To Update.');
						redirect($this->redirect . '/admin/form/' . $id);
					}
				}
			}
		}
		if ($data['detail']) {
			$data['title'] = 'Edit ' . $this->title;
		} else {
			$data['title'] = 'Add ' . $this->title;
		}
		$data['forex'] = 'forex-form';
		$data['doc_path'] = 'uploads/forex/';
		$data['page'] = 'form';
		$data = array_merge($this->data, $data);
		
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

	public function view($id, $page = '')
	{
		$config['base_url'] = base_url($this->redirect . '/admin/view/' . $id);
		$config['total_rows'] = $this->crud_model->count_all('forex_data', array('forex_date_id' => $id), 'id');
		$config['uri_segment'] = 5;
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

		$page = ($this->uri->segment(5)) ? $this->uri->segment(5) : 0;
		$items = $this->crud_model->get_where_pagination_order_by('forex_data', array('forex_date_id' => $id), $config['per_page'], $page, 'id', 'ASC');

		$data = array_merge($this->data, [
			'title' => $this->title,
			'page' => 'list_detail',
			'items' => $items,
			'pagination' =>  $this->pagination->create_links()
		]);
		
		$this->load->view('layouts/admin/index', $data);
	}
	
	public function getForex()
	{
		try {

			if (!$this->input->is_ajax_request()) {
				exit('No direct script access allowed');
			} else {
			    
			    $api_url = "https://www.nrb.org.np/api/forex/v1/app-rate";

                // Read JSON file
                $json_data = file_get_contents($api_url);
                
                // Decode JSON data into PHP array
                $response_data = json_decode($json_data);
                
                // $first_item =  $response_data[0];
                
                // echo "<pre>";
                // var_dump($first_item);exit;
                
                if($response_data){
                    $data = array(
                        'date_forex' => $response_data[0]->date,
                        'published_on' => $response_data[0]->published_on,
                        'modified_on' => $response_data[0]->modified_on,
                        'created_on' => date('Y-m-d'),
                        'created_by' => $this->userId,
                    );
                    
                    $check_duplicate = $this->crud_model->get_where_single_order_by('forex_date', array('published_on'=>$data['published_on']), 'id', 'DESC');
                    
                    if(empty($check_duplicate)){
                        $insert = $this->crud_model->insert('forex_date',$data);  
                     
                        $insert_id = $this->db->insert_id();
                        if($insert_id){
                            
                            $forex_data_batch = array();
                            foreach($response_data as $key=>$value){
                                $temp = array(
                                            'forex_date_id' => $insert_id,
                                            'iso3' => $value->iso3,
                                            'name' => $value->name,
                                            'unit' => $value->unit,
                                            'buy' => $value->buy,
                                            'sell' => $value->sell,
                                        );
                                $forex_data_batch[] = $temp;     
                            }
                            // echo "<pre>";
                            // var_dump($forex_data_batch);exit;
                            
                            $this->db->insert_batch('forex_data', $forex_data_batch); 
                            
                            $response = array(
    							'status' => 'success',
    							'status_code' => 200,
    							'status_message' => 'Successfully inserted',
    						);
                        }else{
                            $response = array(
    							'status' => 'error',
    							'status_code' => 200,
    							'status_message' => 'Unable to insert to our database',
    						);
                        }
                    }else{
                        $response = array(
							'status' => 'error',
							'status_code' => 200,
							'status_message' => 'Duplicate Entry, Already Received',
						);
                    } 
                }else{
                    $response = array(
							'status' => 'error',
							'status_code' => 200,
							'status_message' => 'Unable to get data from nrb',
						);
                } 
			}
		} catch (Exception $e) {
			$response = array(
				'status' => 'error',
				'status_message' => $e->getMessage()
			);
		}
		header('Content-Type: application/json');
		echo json_encode($response);
	}
}