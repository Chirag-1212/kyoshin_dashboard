<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends Auth_controller {

	public function __construct()
	{
		parent::__construct();
		// var_dump($this->current_user);exit;
		$this->load->library('form_validation');   
		$this->table = 'bank_guarantee';
		$this->redirect = 'bank_guarantee/admin/';
		$this->title = 'Bank Guarantee';
	}
	
	public function search($page = '')
	{

		$beneficiary_name = $this->input->post('beneficiary_name'); 
		$issued_branch = $this->input->post('issued_branch');
		$reference_number = $this->input->post('reference_number');
		$created_on = $this->input->post('created_on');
        // 		print_r($Type);die;
        // echo "<pre>";
        // var_dump($this->input->post());
        // exit;
		
		$data_filter = array(
    		    'beneficiary_name' => $beneficiary_name, 
    			'issued_branch' => $issued_branch,
    			'reference_number' => $reference_number,
    			'created_on' => $created_on,
    		);
		
		$all_data = $this->crud_model->count_all_data($this->table, $data_filter);
// 		var_dump($this->db->last_query());exit;
// 		var_dump($all_data);
// 		exit;
		$config['base_url'] = base_url($this->redirect . '/admin/search');
		$config['total_rows'] = $all_data->total;
		$config['uri_segment'] = 4;
		$config['per_page'] = 1000;

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
			'total_row' => $config['total_rows'],
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

	public function all($page='')
	{ 
		
		// $data['roles'] = $this->db->get_where('user_role',array('status !='=>'2'))->result(); 

		// var_dump($this->uri->segment(3));exit;

		$config['base_url'] = base_url($this->redirect.'all');
		$config['total_rows'] = $this->crud_model->count_all($this->table,array('status !='=>'2'),'id');
		$config['uri_segment'] = 4;
		$config['per_page'] = 10;
		//outside of flist that is <ul></ul>
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

		$data['pagination'] = $this->pagination->create_links();
		$data['items'] = $this->crud_model->get_where_pagination($this->table,array('status !='=>'2'),$config["per_page"], $page);
// 		var_dump($data['items']);exit;
        $data['total_row'] = $config['total_rows'];
		$data['title'] = $this->title;
        $data['page'] = 'list';
		$data['redirect'] = $this->redirect;
        $this->load->view('layouts/admin/index',$data);
	}
	
	public function form($id='')
	{ 
		
		$data['detail'] = $this->db->get_where($this->table,array('id'=>$id))->row();
		if($this->input->post()){
			$this->form_validation->set_rules('issued_branch', 'Issued Branch', 'required|trim');    
			$this->form_validation->set_rules('reference_number', 'Reference Number', 'required|trim');    
			$this->form_validation->set_rules('beneficiary_name', 'Beneficiary Name', 'required|trim');    
			$this->form_validation->set_rules('issue_date', 'Issue Date', 'required|trim');    
			$this->form_validation->set_rules('value_date', 'Value Date', 'required|trim');    
			$this->form_validation->set_rules('expiry_date', 'Expiry date', 'required|trim');    
			$this->form_validation->set_rules('currency_id', 'Currency', 'required|trim');    
			$this->form_validation->set_rules('amount', 'Amount', 'required|trim');    
			if($this->form_validation->run()){
			    
			    $id = $this->input->post('id'); 
			    
				$data = array(
							'issued_branch' => $this->input->post('issued_branch'),
				// 			'reference_number' => $this->input->post('reference_number'),   
							'beneficiary_name' => $this->input->post('beneficiary_name'),
							'issue_date' => $this->input->post('issue_date'),   
							'value_date' => $this->input->post('value_date'),
							'expiry_date' => $this->input->post('expiry_date'),   
							'currency_id' => $this->input->post('currency_id'),
							'amount' => $this->input->post('amount'),     
							'status' => $this->input->post('status'),  
						);   				
				 	
				if($id == ''){ 
				// 	$slug = $this->crud_model->createUrlSlug($this->input->post('title'));
				// 	$check_slug = $this->crud_model->get_where_single($this->table,array('slug'=>$slug));
				// 	if(empty($check_slug)){
				// 		$data['slug'] = strtolower ($slug);
				// 	}else{
				// 		$data['slug'] = strtolower ($slug).time();
				// 	}
				    $check_unique_reference_number = $this->crud_model->get_where_single($this->table,array('reference_number'=>$this->input->post('reference_number'), 'status !=' => '2'));
				    if(empty($check_unique_reference_number)){
						$data['reference_number'] = $this->input->post('reference_number');
					}else{
						$this->session->set_flashdata('error', 'Reference Number Should be unique');
						redirect($this->redirect.'form');
					}
					$data['created_by'] = $this->current_user->id; 
					$data['created_on'] = date('Y-m-d'); 
					$result = $this->crud_model->insert($this->table, $data);
					if($result==true){
						$this->session->set_flashdata('success','Successfully Inserted.');
						redirect($this->redirect.'all');
					}else{
						$this->session->set_flashdata('error', 'Unable To Insert.');
						redirect($this->redirect.'form');
					}
				}else{ 
				    $check_unique_reference_number = $this->crud_model->get_where_single($this->table,array('reference_number'=>$this->input->post('reference_number'), 'status !=' => '2', 'id !=' => $id));
				    if(empty($check_unique_reference_number)){
						$data['reference_number'] = $this->input->post('reference_number');
					}else{
						$this->session->set_flashdata('error', 'Reference Number Should be unique');
						redirect($this->redirect.'form');
					}
					$data['updated_on'] = date('Y-m-d');
					$data['updated_by'] = $this->current_user->id; 
					$result = $this->crud_model->update($this->table, $data,array('id'=>$id));
					if($result==true){
						$this->session->set_flashdata('success','Successfully Updated.');
						redirect($this->redirect.'all');
					}else{
						$this->session->set_flashdata('error', 'Unable To Update.');
						redirect($this->redirect.'form/'.$id);
					}
				}   
			}
		} 
		
		$data['branches'] = $this->crud_model->get_where_order_by('tbl_branch', array('status' => '1'), 'Title', 'ASC');
		$data['currencies'] = $this->crud_model->get_where_order_by('currency', array('status' => '1'), 'id', 'ASC');
		$data['title'] = 'Add/Edit '.$this->title;
        $data['page'] = 'form';
        $this->load->view('layouts/admin/index',$data);
	}

	public function soft_delete($id){
		$data = array(
			'status' => '2',
			'updated_by' => $this->current_user->id, 
			'updated_on' => date('Y-m-d'),
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
	
	public function import_from_excel($id = '')
	{ 
	   // $string = '002,"RAjesh, ENTERPRISES PVT. LTD",002-23-001SG,02/01/2023,02/01/2023,01/07/2023,01,4500000';
	    
	   // $string = str_getcsv($string, ",", '"', '#');
	   // echo "<pre>";
	   // var_dump($string);
	   // exit;
	    
		if ($this->input->post()) {   
		    
				if (strlen($_FILES['FileName']['name']) > 0) {

					$config['upload_path'] = 'uploads/bank_guarantee/';

					$config['allowed_types'] = 'csv';

					$config['max_size'] = '3000';





					$this->load->library('upload', $config);

					if (!$this->upload->do_upload('FileName')) {

						$this->session->set_flashdata('error', $this->upload->display_errors()); 
					    redirect($this->redirect . 'import_from_excel'); 
					} else {

						$file = $this->upload->data();

						$file_name = $file['file_name'];
						
				// 		$data['created_on'] = date('Y-m-d');
				//     	$data['created_by'] = $this->current_user->id; 

						if ($file_name != '') {
							$fp1 = file('uploads/bank_guarantee/' . $file_name);
							$total_rows = count($fp1) - 1 ;
                            $final_data = array();
							for ($i = 1; $i < count($fp1); $i++) {

								$fp2 = $fp1[$i];



								// $fp2 = explode(',', $fp2);
								
								$fp2 = str_getcsv($fp2, ",", '"', '#'); 



								for ($j = 0; $j < count($fp2); $j++) {

									if ($j == 0)

										$issued_branch_code = $fp2[$j];

									elseif ($j == 1)

										$beneficiary_name = $fp2[$j];

									elseif ($j == 2)

										$reference_number = $fp2[$j];

									elseif ($j == 3)

										$issue_date = $fp2[$j];

									elseif ($j == 4)

										$value_date = $fp2[$j];

									elseif ($j == 5)

										$expiry_date = $fp2[$j];
									elseif ($j == 6)

										$currency_code = $fp2[$j];
									elseif ($j == 7)

										$amount = $fp2[$j];	
								}
								$issued_branch_code = ltrim($issued_branch_code, '0');
								$branch_detail = $this->db->get_where('tbl_branch',array('branch_code'=>$issued_branch_code))->row();
								if(isset($branch_detail->id)){
								    $branch_id = $branch_detail->id;
								}else{
								    $this->session->set_flashdata('error', 'Invalid branch id. Branch_id = ' . $issued_branch_code);
        						    redirect($this->redirect . 'import_from_excel'); 
								};
								$currency_code = ltrim($currency_code, '0');
								$currency_detail = $this->db->get_where('currency',array('code'=>$currency_code))->row();
                                if(isset($currency_detail->id)){
								    $currency_id = $currency_detail->id;
								}else{
								    $this->session->set_flashdata('error', 'Invalid currency code. Currency_code = ' . $currency_code);
        						    redirect($this->redirect . 'import_from_excel'); 
								};
                                $issue_explode = explode("/",$issue_date);
                                $issue_date = $issue_explode[2].'-'.$issue_explode[1].'-'.$issue_explode[0];
                                
                                $value_explode = explode("/",$value_date);
                                $value_date = $value_explode[2].'-'.$value_explode[1].'-'.$value_explode[0];
                                
                                $expiry_explode = explode("/",$expiry_date);
                                $expiry_date = $expiry_explode[2].'-'.$expiry_explode[1].'-'.$expiry_explode[0];
                                
                                
                                if($branch_id && $currency_id){
                                    
                                    $check_unique_reference_number = $this->crud_model->get_where_single($this->table,array('reference_number'=>$reference_number, 'status !=' => '2')); 
                				    
                				    if(empty($check_unique_reference_number)){ 
                				        
                						$data1 = array(
    
        									'issued_branch' => $branch_id,
        
        									'beneficiary_name' => $beneficiary_name,
        
        									'reference_number' => $reference_number,
        
        									'issue_date' => $issue_date,
        
        									'value_date' => $value_date,
        
        									'expiry_date' => $expiry_date,
        
        									'currency_id' => $currency_id,
        									
        									'amount' => $amount,
        									
        								    'created_on' => date('Y-m-d'),
        								    
    				    	                'created_by' => $this->current_user->id, 
        
        								);
                                        $final_data[] = $data1;
        								// $this->crud_model->insert('bank_guarantee', $data1);
                					}else{
                					    $this->session->set_flashdata('error', 'Duplicate reference number. Reference number : '.$reference_number);
        						        redirect($this->redirect . 'import_from_excel'); 
                					} 
                                }else{
                                    $this->session->set_flashdata('error', 'Invalid currency Code or Branch Id');
        						    redirect($this->redirect . 'import_from_excel'); 
                                } 
							}
							
							$this->db->insert_batch('bank_guarantee', $final_data); 
							$this->session->set_flashdata('success', 'Successfully Inserted.Total New Inserted Rows : '. $total_rows );
						    redirect($this->redirect . 'all'); 
						}else{
						    $this->session->set_flashdata('error', 'Unable to get filename.');
						    redirect($this->redirect . 'import_from_excel'); 
						} 
					}
				} else {
					$this->session->set_flashdata('error', 'File is required.');
				    redirect($this->redirect . 'import_from_excel');
				}   
		}
		
        $data['title'] = 'Add ' . $this->title;
		$data['doc_path'] = 'uploads/bank_guarantee/';
		$data['page'] = 'import_from_excel';
		$this->load->view('layouts/admin/index', $data);
	}
	
	public function logged_users($page='')
	{ 
		
		// $data['roles'] = $this->db->get_where('user_role',array('status !='=>'2'))->result(); 

		// var_dump($this->uri->segment(3));exit;

		$config['base_url'] = base_url($this->redirect.'logged_users');
		$config['total_rows'] = $this->crud_model->count_all('logged_bank_guarantee_users',array('status !='=>'2'),'id');
		$config['uri_segment'] = 4;
		$config['per_page'] = 15;
		//outside of flist that is <ul></ul>
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

		$data['pagination'] = $this->pagination->create_links();
		$data['items'] = $this->crud_model->get_where_pagination('logged_bank_guarantee_users',array('status !='=>'2'),$config["per_page"], $page);
// 		var_dump($data['items']);exit;
		$data['title'] = 'List Logged Users';
        $data['page'] = 'list_logged_users';
		$data['redirect'] = $this->redirect;
        $this->load->view('layouts/admin/index',$data);
	}
	
	public function search_logged_users($page = '')
	{

		$email = $this->input->post('email');
		$reference_number = $this->input->post('reference_number');  
		
		$data_filter = array(
    		    'email' => $email,
    			'reference_number' => $reference_number, 
    		);
		
		$all_data = $this->crud_model->count_all_logged_users_data('logged_bank_guarantee_users', $data_filter);
// 		var_dump($this->db->last_query());exit;
// 		var_dump($all_data);
// 		exit;
		$config['base_url'] = base_url($this->redirect . '/admin/search_logged_users');
		$config['total_rows'] = $all_data->total;
		$config['uri_segment'] = 4;
		$config['per_page'] = 15;

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
		$items = $this->crud_model->get_all_logged_users_data('logged_bank_guarantee_users', $data_filter, $config['per_page'], $page);

        if($this->input->post('pdf')){
            $this->view_pdf($items);
            // redirect($path);
            // 'window'.open($path);
        }
	
		$data = array(
			'title' => 'List Logged Users',
			'page' => 'search_list_logged_users',
			'items' => $items,
			'data_filter' => $data_filter, 
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
	
	function generatePdfLoggedUsers($items)
    {
        // $this->load->library('pdf');
        $html = $this->load->view('pdf_logged_users', $items, true);
        echo "<pre>";
        var_dump($html);exit;
        $this->pdf->createPDF($html, 'mypdf', false);
    }
    
//     function mypdf($items){


// 	$this->load->library('pdf');


//   	$this->pdf->load_view('pdf_logged_users', $items, true);
//   	$this->pdf->render();


//   	$this->pdf->stream("welcome.pdf");
//   }


   
//   function rajeshPdf($items){
//     //   echo "go";exit;
//         //Load the library
//         $this->load->library('html2pdf');
//         // echo "here";exit;
//         //Set folder to save PDF to
//         $this->html2pdf->folder('./uploads/pdfs/');
        
//         //Set the filename to save/download as
//         $this->html2pdf->filename('test.pdf');
        
//         //Set the paper defaults
//         $this->html2pdf->paper('a4', 'portrait');
        
//         $html = $this->load->view('pdf_logged_users', $items, true);
//         echo "<pre>";
//         var_dump($html);exit;
//         //Load html view
//         // $logo = base_url('uploads/primelogo.png');
//         // var_dump($logo);exit;
//         // $html = '';
//         // $html .= '<img src="'.$logo.'">';
//         // $html .= '<h2 style="text-align:center;">Bank Guarantee Report</h2><br>';
//         // $html .= '<h3 style="text-align:center;">Prime Bank</h3>';
//         // $html .= '<table class="table table-bordered table-responsive">
//         //             <thead><tr><th>#</th><th>Email</th><th>OTP Code</th><th>Reference Number</th><th>Date/Time</th></tr></thead>
//         //             <tbody>';
        
//         // if(!empty($items)){ 
//         //     foreach($items as $key => $value){
//         //         $i = 1;
//         //         $html .='<tr><td>'. $i .'</td><td>'. $value->email .'</td><td>'. $value->otp_code .'</td><td>'. $value->reference_number .'</td><td>'. $value->created_time_stamp .'</td></tr>';
//         //         $i++;        
//         //     }
//         // }
        
//         // $html .= '</tbody></table>';
                
//         // var_dump($html); 
//         // exit;
//         $this->html2pdf->html($html);
        
//         $this->html2pdf->create('save');
        
//         if($path = $this->html2pdf->create('save')) {
//         	//PDF was successfully saved or downloaded
//         // 	echo 'PDF saved to: ' . $path;
//             return $path;
//         }
//   }
  
  public function view_pdf($items)
	{
		//load mPDF library
		$this->load->library('m_pdf');

        // $this->_data['items'] = $items;
        $html = $this->load->view('pdf_logged_users', $items, true);
        
        var_dump($html);exit;
        
		$pdfFilePath = "EngineeringReport-" . time() . ".pdf";

		//generate the PDF from the given html
		$this->m_pdf->pdf->WriteHTML($html);
		$this->m_pdf->pdf->Output();
		// 	exit;
		// 	//download it.
		// 	$this->m_pdf->pdf->Output($pdfFilePath, "D");

	}
}
