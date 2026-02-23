<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Grievance extends Front_controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->helper('file');
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
        $this->table = 'grievance'; 
        $this->title = 'Grievance';
    }

    function form()
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
                if ($input_data) { 
                    $name =  isset($input_data->fullname)? $input_data->fullname:''; 
                    $email = isset($input_data->email)? $input_data->email:'';
                    $mobno = isset($input_data->phone)? $input_data->phone:''; 
                    // $branch_name = isset($input_data->branch_name)? $input_data->branch_name:''; 
                    $subject = isset($input_data->subject)? $input_data->subject:'';
                    $issue = isset($input_data->issue)? $input_data->issue:''; 
                    // $images = isset($input_data->DocPath)? $input_data->DocPath:'';
                    
    				// if($images){
    				//     $explode = explode(",",$images);
              
        //                 $file_name = $name.'_grievance_'. uniqid() . '.jpg';
        //                 $uploadpath   = $_SERVER["DOCUMENT_ROOT"].'/pkh/uploads/grievance/';
        //                 $parts        = explode(";base64,", $images);
        //                 $imageparts   = explode("image/", @$parts[0]);
        //                 $imagetype    = $imageparts[1];
        //                 $imagebase64  = base64_decode($explode[1]);
        //                 $file         = $uploadpath .$file_name;
    				// }
    				
               
    				// $file = $this->request->getFile('DocPath');
    				
                    // var_dump($imagebase64);exit;
                    if($email == "" || $issue == ""){
                        $response=array(
                                'status' => "Error",
                                'status_code' => 307,
                                'status_message' => "Email And Issue Required!!!", 
                            );
                        $json_response = json_encode($response);
                        echo $json_response;
                        // exit;
                    } 
                    
                    $user_code = uniqid(); 
					$check_user_code = $this->crud_model->get_where_single($this->table,array('user_code'=>$user_code));
					if(empty($check_user_code)){
						$user_code = $user_code;
					}else{
						$user_code = $user_code.time();
					}
					
					$data = array(
                        'name' => $name,
                        'email' => $email,
                        'mobno' => $mobno,
                        'subject' => $subject,
                        // 'branch_name' => $branch_name,
                        // 'DocPath'=>$file_name,
                        'issue' => $issue,
                        'user_code' => $user_code,
                        'created' => date('Y-m-d'),
                        'date' => date('Y-m-d'),
                        'status' => '0',
                    );
                    // if($images){
                    //     if(file_put_contents($file, $imagebase64)){ 
                    //     $data['DocPath'] = $file_name;
                    //     }else{
                    //         $response=array(
                    //                     'status' => "Error",
                    //                     'status_code' => 206,
                    //                     'status_message' => "Unable To Upload Attachment", 
                    //                 );
                    //     }
                        
                    // } 
        //             		echo "<pre>";
    				// 	var_dump($data);
    				// 	exit;
                    $this->load->library('email');
					  
                    $config = Array(
                        'protocol' => 'sendmail',
                        'smtp_host' => 'mi3-sr5.supercp.com',
                        'smtp_port' => '465',
                        // 'smtp_user' => 'no-reply@pokharafinance.com.np', 
                        // 'smtp_pass' => 'UUrE7(WD6?V~', 
                        'mailtype' => 'html',
                        'charset' => 'utf-8',
                        'wordwrap' => TRUE
                    );
                    
                    $this->email->initialize($config);
                    $this->email->from('no-reply@pokharafinance.com.np','Pokhara Finance Ltd.');
                    $this->email->to($email);
                   
                    // $this->email->cc();
                    // $this->email->bcc();
                    $this->email->subject('Pokhara Finance Ltd. Grievance Submission');
                    $this->email->message(
                            '
                            <p>Dear Customer,</p>

                            <p>Your feedback has been successfully submitted. The bank will response back to you soon.</p></br>
                            <p>Keep checking your mail. </p></br>
                            
                            
                            <p>Regards,</p></br>
                            
                            <p>Pokhara Finance Ltd.</p></br>'
                        );
                    
                    if($this->email->send()){
        				$result = $this->crud_model->insert($this->table, $data);
                    
                        if($result){ 
                            
                            $response=array(
                                    'status' => "Success",
                                    'status_code' => 200,
                                    'status_message' => "Successfully Submitted", 
                                );
                        }else{
                            $response=array(
                                    'status' => "Error",
                                    'status_code' => 307,
                                    'status_message' => "Unable to submit", 
                                );
                        }
                    }
        			else {  
        				$response=array(
                                    'status' => "Error",
                                    'status_code' => 307,
                                    'status_message' => "Mail Not Sent!", 
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
    
    function check()
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
                if ($input_data) { 
                    $user_code =  isset($input_data->user_code)? $input_data->user_code:''; 
                    $email = isset($input_data->email)? $input_data->email:'';   
                    
                    $result = $this->crud_model->get_where_single('grievance',array('user_code'=>$user_code,'email'=>$email));
                    
                    if(!empty($result)){ 
                        $response=array(
                                'status' => "Success",
                                'status_code' => 200,
                                'status_message' => "Data Retrived successfully",
                                'grevience' => $result,
                            );
                    }else{
                        $response=array(
                                'status' => "Error",
                                'status_code' => 307,
                                'status_message' => "No Grevience Found", 
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
                if ($input_data) {  
                    $email = isset($input_data->email)? $input_data->email:'';
                    $otp_code = rand(1000,9999);
                    
                    $this->load->library('email');
                    
                    $config = Array(
                        'protocol' => 'sendmail',
                        'smtp_host' => 'mi3-sr5.supercp.com',
                        'smtp_port' => '465',
                        // 'smtp_user' => 'UUrE7(WD6?V~', 
                        // 'smtp_pass' => 'lVoa1vVP;&A5', 
                        'mailtype' => 'html',
                        'charset' => 'utf-8',
                        'wordwrap' => TRUE
                    );
                    
                    $this->email->initialize($config);
                    $this->email->from('no-reply@pokharafinance.com.np','Pokhara Finance Ltd.');
                    $this->email->to($email);
                   
                    // $this->email->cc();
                    // $this->email->bcc();
                    $this->email->subject('Grievance Verification Code');
                    $this->email->message(
                           '<p>Dear Customer,</p></br>
                            <p>Please enter the following verification code in Pokhara Finance`s grievance form.</p></br>
                            
                            <p>Verification Code:  <b>'.$otp_code.'</b></p></br>
                            
                            <p>Regards,</p></br>
                            <p>Pokhara Finance Ltd.</p>'
                        );
                    
                    if($this->email->send()){
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
