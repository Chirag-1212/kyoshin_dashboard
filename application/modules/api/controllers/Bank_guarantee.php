<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Bank_guarantee extends Front_controller
{

    function __construct()
    {
        
        parent::__construct();
        $this->load->library('form_validation');

        header('Content-type:application/json');
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Headers: Authorization, Origin, X-Requested-With, Content-Type, Accept, Content-Length, Accept-Encoding, X-API-KEY, Access-Control-Request-Method");
        header("Access-Control-Allow-Methods: GET, POST, OPTIONS, DELETE, PUT");
        $this->request_method = $_SERVER["REQUEST_METHOD"];
        // $this->request = $_SERVER['REQUEST']; 

        if ($this->request_method == "OPTIONS") {
            die();
        }

        $authKeyFromApp = apache_request_headers();
        // $this->loggedinUser = $authKeyFromApp['Authorization'];
        $this->table = 'bank_guarantee'; 
        $this->title = 'Bank Guarantee';
    }
    
    function index()
    {
        // echo "here";exit;
        header('Access-Control-Allow-Method:POST');
        if ($this->request_method != "POST") {
            $response=array(
                'status' => "Error",
                'status_code' => 204,
                'status_message' => "Access Method Not Allowed",
            );
        } else {  
            
                $input_data = json_decode(file_get_contents("php://input"));
                // var_dump($input_data->otp_code);exit;
                if ($input_data) { 
                    $reference_number= $_POST['reference_number']  =  isset($input_data->reference_number)? $input_data->reference_number:''; 
                    $fullname = $_POST['fullname'] = isset($input_data->fullname)? $input_data->fullname:''; 
                    $phone =$_POST['phone'] = isset($input_data->phone)? $input_data->phone:'';
                    $this->load->library('form_validation');
                 
                  
                    $this->form_validation->set_rules(
                        'phone',
                        'Mobile Number',
                        'required|exact_length[10]|numeric', 
                        [
                            'required' => 'The %s field is required',
                            'exact_length' => 'The %s field must be exactly 10 digits',
                            'numeric' => 'The %s field must contain only numbers'
                        ]
                    );
                    $this->form_validation->set_rules(
                        'fullname',
                        'Full Name',
                        'required|trim', 
                        [
                            'required' => 'This %s field is required'
                        ]
                    );
                    $this->form_validation->set_rules(
                        'reference_number',
                        'Reference number',
                        'required|trim', 
                        [
                            'required' => 'This %s field is required' // Custom error message
                        ]
                    );
                    
                    // if($reference_number == "" || $fullname == "" || $phone == ""){
                    if ($this->form_validation->run() == FALSE) {
                            $errors = $this->form_validation->error_array();
                            // $error_messages = implode(' ', $errors);
                        $response=array(
                                'status' => "Error",
                                'status_code' => 307,
                                // 'status_message' => "Full Name, Reference Number And Phone Number Required!!!", 
                                 'status_message' => $errors,
                            );
                        $json_response = json_encode($response);
                        echo $json_response;
                        exit;
                    }  
                    
                    //check reference number exits or not
                     $check = $this->crud_model->get_where_single($this->table,array('reference_number' => $reference_number));
                     if($check){
                         
                        $branch_detail = $this->crud_model->get_where_single('branches',array('id'=>$check->issued_branch));
					    $branch_name = isset($branch_detail->PageTitle)?$branch_detail->PageTitle:'';
					    
					    $currency_detail = $this->crud_model->get_where_single('currency',array('id'=>$check->currency_id));
					    $currency_symbol = isset($currency_detail->symbol)?$currency_detail->symbol:'';
					    
					    $check->branch_name = $branch_name;
					    $check->currency_symbol = $currency_symbol;
					    $check->current_date = date('Y-m-d h:i:s');
                        $insert['phone'] =  $phone;
				        $insert['reference_number'] =  $reference_number; 
				        $insert['fullname'] =  $fullname; 
				        
				        $result = $this->crud_model->insert('logged_bank_guarantee_users', $insert);
				        $response=array(
                                            'status' => "success",
                                            'status_code' => 200,
                                            'status_message' => "Record Matched Successfully",
                                            'data' => $check,
                                        );
                     }else{
                     	$response=array(
                            'status' => "error",
                            'status_code' => 403,
                            'status_message' => "Reference Number doesn't match", 
                        );
			       
				    }
                    // var_dump($check);exit;
                 
                }else{
                    $response=array(
                                'status' => "Error",
                                'status_code' => 300,
                                'status_message' => "Input data required", 
                            );
                }   
            
        } 
        $json_response = json_encode($response);
        echo $json_response;
    }

    function index2()
    {
        // echo "here";exit;
        header('Access-Control-Allow-Method:POST');
        if ($this->request_method != "POST") {
            $response=array(
                'status' => "Error",
                'status_code' => 204,
                'status_message' => "Access Method Not Allowed",
            );
        } else {  
            
                $input_data = json_decode(file_get_contents("php://input"));
                // var_dump($input_data->otp_code);exit;
                if ($input_data) { 
                    $reference_number =  isset($input_data->reference_number)? $input_data->reference_number:''; 
                    $amount = isset($input_data->amount)? $input_data->amount:''; 
                    $email = isset($input_data->email)? $input_data->email:'';
                    $otp = isset($input_data->otp_code)? $input_data->otp_code:'';
                    
                    if($reference_number == "" || $amount == "" || $otp == ""){
                        $response=array(
                                'status' => "Error",
                                'status_code' => 307,
                                'status_message' => "OTP, Reference Number And Amount Required!!!", 
                            );
                        $json_response = json_encode($response);
                        echo $json_response;
                        exit;
                    }  
                    // var_dump($otp);exit;
                    // $check_otp = $this->crud_model->get_where_single('logged_bank_guarantee_users',array('email' => $email, 'otp_code' => $otp));
                    $check_otp = $this->crud_model->get_where_single_order_by('logged_bank_guarantee_users', array('email' => $email, 'otp_code' => $otp), 'id', 'DESC');
                    // var_dump($this->db->last_query());
                    // exit;
                    if(!empty($check_otp)){
                        if($check_otp->dissable_tag == '1' || $check_otp->expiry_date <= date('Y-m-d')){
                            $response=array(
                                    'status' => "error",
                                    'status_code' => 403,
                                    'status_message' => "Otp Expired", 
                                );
                        }else{
                            $check = $this->crud_model->get_where_single($this->table,array('reference_number' => $reference_number, 'amount' => $amount));
        					if(empty($check)){
        						$response=array(
                                            'status' => "error",
                                            'status_code' => 403,
                                            'status_message' => "No Record Matched", 
                                        );
        					}else{
        					    if($check_otp->reference_number == ''){
        					        $update['reference_number'] = $reference_number;
        					        
        					        $result = $this->crud_model->update('logged_bank_guarantee_users', $update, array('id'=>$check_otp->id));
        					    }else{
        					        $update['dissable_tag'] = '1';
        					        
        					        $result = $this->crud_model->update('logged_bank_guarantee_users', $update, array('id'=>$check_otp->id));
        					        
        					        $insert['email'] =  $check_otp->email;
        					        $insert['otp_code'] =  $check_otp->otp_code;
        					        $insert['expiry_date'] =  $check_otp->expiry_date;
        					        $insert['reference_number'] =  $reference_number; 
        					        
        					        $result = $this->crud_model->insert('logged_bank_guarantee_users', $insert);
        					    }
        					    
        					    $branch_detail = $this->crud_model->get_where_single('tbl_branch',array('id'=>$check->issued_branch));
        					    $branch_name = isset($branch_detail->Title)?$branch_detail->Title:'';
        					    
        					    $currency_detail = $this->crud_model->get_where_single('currency',array('id'=>$check->currency_id));
        					    $currency_symbol = isset($currency_detail->symbol)?$currency_detail->symbol:'';
        					    
        					    $check->branch_name = $branch_name;
        					    $check->currency_symbol = $currency_symbol;
        					    
        						$response=array(
                                            'status' => "success",
                                            'status_code' => 200,
                                            'status_message' => "Record Matched Successfully",
                                            'data' => $check,
                                        );
        					} 
                        }
                    }else{
                        $response=array(
                                    'status' => "error",
                                    'status_code' => 403,
                                    'status_message' => "Otp Doesnt Matched", 
                                );
                    }   
                }else{
                    $response=array(
                                'status' => "Error",
                                'status_code' => 300,
                                'status_message' => "Input data required", 
                            );
                }   
            
        } 
        $json_response = json_encode($response);
        echo $json_response;
    }
    
    function otp()
    { 
        header('Access-Control-Allow-Method:POST');
        if ($this->request_method != "POST") {
            $response=array(
                'status' => "Error",
                'status_code' => 204,
                'status_message' => "Access Method Not Allowed",
            );
        } else {  
            
                $input_data = json_decode(file_get_contents("php://input"));
                if ($input_data) {  
                    $email = isset($input_data->email)? $input_data->email:'';
                    $otp_code = rand(1000,9999);
                    
                    $this->load->library('email');
					    
				    $config = Array(
                        'protocol' => 'sendmail',
                        'smtp_host' => 'mi3-sr5.supercp.com',
                        'smtp_port' => '465',
                        // 'smtp_user' => '$bankemailID',
                        // 'smtp_pass' => 'J5(+V0PGNU%B', 
                    
                        'mailtype' => 'html',
                        'charset' => 'utf-8',
                        'wordwrap' => TRUE
                    );
                    $this->email->initialize($config);
                    $this->email->from('$bankemailID','Pokhara Finance Bank');
                    $this->email->to($email);
                    $this->email->subject('Bank Guarantee Verification Code');
                    $this->email->message(
                           '<p>Dear Customer,</p></br>
                            <p>Please enter the following verification code in Pokhara Finance bank guarantee form.</p></br>
                            
                            <p>Verification Code:  <b>'.$otp_code.'</b></p></br>
                            
                            <p>Regards,</p></br>
                            <p>Pokhara Finance  Bank</p>'
                        );
                    if($this->email->send()){
                        // var_dump($this->email->get_debugger_messages());exit;
                        
                        $update['dissable_tag'] = '1';
        					        
        			    $result = $this->crud_model->update('logged_bank_guarantee_users', $update, array('email'=>$email));
                        
                        $insert =array(
                                'email' => $email,
                                'otp_code' => $otp_code,
                                'expiry_date' => date('Y-m-d', strtotime(date('Y-m-d') . ' +1 day')),
                            );
                            
                        $result = $this->crud_model->insert('logged_bank_guarantee_users',$insert);    
                        
                        $response=array(
                                'status' => "Success",
                                'status_code' => 200,
                                'status_message' => "Otp sent in mail successfully",
                                'otp_code' => $otp_code,
                            );
                    }else{
                        $response=array(
                                'status' => "Error",
                                'status_code' => 300,
                                'status_message' => "Unable to send mail", 
                            );
                    } 
                }else{
                    $response=array(
                                'status' => "Error",
                                'status_code' => 300,
                                'status_message' => "Input data required", 
                            );
                }   
            
        } 
        $json_response = json_encode($response);
        echo $json_response;
    }
}
