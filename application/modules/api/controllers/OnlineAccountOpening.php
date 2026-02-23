<?php
defined('BASEPATH') or exit('No direct script access allowed');

class OnlineAccountOpening extends Front_controller
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
        $this->table = 'account_opening'; 
        $this->title = 'Grievance';
        $this->load->library('Nepali_calendar');
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
                
                    
                    $salution_name = isset($input_data->salution_name)? $input_data->salution_name:''; 
                    $first_name =  isset($input_data->first_name)? $input_data->first_name:''; 
                    $middle_name = isset($input_data->middle_name)? $input_data->middle_name:'';
                    $last_name = isset($input_data->phone)? $input_data->last_name:''; 
                    $gender = isset($input_data->gender)? $input_data->gender:'';
                    $email = isset($input_data->email)? $input_data->email:'';
                    $phone = isset($input_data->phone)? $input_data->phone:'';
                    
                    $bod_ad = isset($input_data->bod_ad)? $input_data->bod_ad:'';
                    
                    $currentDate  = new DateTime($bod_ad);
                    
            	    $current = $this->nepali_calendar->AD_to_BS($currentDate->format('Y'), $currentDate->format('m'), $currentDate->format('d'));
                	$nepaliBOD = new DateTime($current['year'] . '-' . $current['month'] . '-' . $current['date']);
                	
                    $permanent_address = isset($input_data->permanent_address)? $input_data->permanent_address:''; 
                    $temporary_address = isset($input_data->temporary_address)? $input_data->temporary_address:''; 
                    $images = isset($input_data->image)? $input_data->image:'';
                    
                    if ($input_data) {
					
					if($first_name == ""){
                        $response=array(
                                'status' => "Error",
                                'status_code' => 307,
                                'status_message' => "First Name is Required!!!", 
                            );
                        $json_response = json_encode($response);
                        echo $json_response;
                        // exit;
                    } 
                    if($last_name == ""){
                        $response=array(
                                'status' => "Error",
                                'status_code' => 307,
                                'status_message' => "Last Name is Required!!!", 
                            );
                        $json_response = json_encode($response);
                        echo $json_response;
                        // exit;
                    } 
                    
                    
                    
                    
                    if($email == ""){
                        $response=array(
                                'status' => "Error",
                                'status_code' => 307,
                                'status_message' => "Email And Issue Required!!!", 
                            );
                        $json_response = json_encode($response);
                        echo $json_response;
                        // exit;
                    } 
                    
                    if($phone == ""){
                        $response=array(
                                'status' => "Error",
                                'status_code' => 307,
                                'status_message' => "Mobile No is Required!!!", 
                            );
                        $json_response = json_encode($response);
                        echo $json_response;
                        // exit;
                    } 
                    
                    if($bod_ad == ""){
                        $response=array(
                                'status' => "Error",
                                'status_code' => 307,
                                'status_message' => "BOD (AD) is Required!!!", 
                            );
                        $json_response = json_encode($response);
                        echo $json_response;
                        // exit;
                    } 
                    
                    if($permanent_address == ""){
                        $response=array(
                                'status' => "Error",
                                'status_code' => 307,
                                'status_message' => "Permanent Address is Required!!!", 
                            );
                        $json_response = json_encode($response);
                        echo $json_response;
                        // exit;
                    } 
                    
                    if($temporary_address == ""){
                        $response=array(
                                'status' => "Error",
                                'status_code' => 307,
                                'status_message' => "Temporary Address is Required!!!", 
                            );
                        $json_response = json_encode($response);
                        echo $json_response;
                        // exit;
                    } 
                    $file_name = '';
    				if($images){
    				    $explode = explode(",",$images);
              
                        $file_name = $first_name."_".$last_name.'_online_account_passport_'. $email .time(). '.jpg';
                        // $uploadpath   = $_SERVER["DOCUMENT_ROOT"].'/PCS/dashprisallc/uploads/resumes/';
                        $uploadpath   = $_SERVER["DOCUMENT_ROOT"].'/uploads/online_account/';
                        $parts        = explode(";base64,", $images);
                        $imageparts   = explode("image/", @$parts[0]);
                        $imagetype    = $imageparts[1];
                        $imagebase64  = base64_decode($explode[1]);
                        $photo         = $uploadpath .$file_name;
    				}
    				
                    $citizenships = isset($input_data->citizenship)? $input_data->citizenship:'';
                    
                    if($citizenships){
                         $explode_citizenship = explode(",",$citizenships);
          
                        $citizenshipfile_name = $first_name.'_online_account_citizenship_'. $email.time() . '.jpg';
                        // $uploadpath   = $_SERVER["DOCUMENT_ROOT"].'/PCS/dashprisallc/uploads/resumes/';
                        $uploadpath   = $_SERVER["DOCUMENT_ROOT"].'/uploads/online_account/';
                        $parts_front        = explode(";base64,", $citizenships);
                        $imagepartsCit   = explode("image/", @$parts_front[0]);
                        $imagetype    = $imagepartsCit[1];
                        $imagebase64citizen  = base64_decode($explode_citizenship[1]);
                        $citizenship_path_url  = $uploadpath .$citizenshipfile_name;
                        
                        
                    }else{
                        // echo "come";exit;
                            $response=array(
                                'status' => "Error",
                                'status_code' => 206,
                                'status_message' => "Cizitenship file is required", 
                            );
                    }
                    
                    
                    $citizen_back = isset($input_data->citizen_back)? $input_data->citizen_back:'';
                    
                    if($citizen_back){
                         $explode_citizenship_back = explode(",",$citizen_back);
          
                        $citizenshipfile_back_name = $first_name.'_online_account_citizenship_back_'. $email.time() . '.jpg';
                        // $uploadpath   = $_SERVER["DOCUMENT_ROOT"].'/PCS/dashprisallc/uploads/resumes/';
                        $uploadpath   = $_SERVER["DOCUMENT_ROOT"].'/uploads/online_account/';
                        $parts_back        = explode(";base64,", $citizen_back);
                        $imageparts   = explode("image/", @$parts_back[0]);
                        $imagetype    = $imageparts[1];
                        $imagebase64citizenback  = base64_decode($explode_citizenship_back[1]);
                        $citizenship_path_back_url  = $uploadpath .$citizenshipfile_back_name;
                        
                        
                    }else{
                        // echo "come";exit;
                            $response=array(
                                'status' => "Error",
                                'status_code' => 206,
                                'status_message' => "Cizitenship file is required", 
                            );
                    }
                    
    				
					$data = array(
                        'salution' => $salution_name,
                        'first_name' => $first_name,
                        'middle_name' => $middle_name,
                        'last_name' => $last_name,
                        'gender' => $gender,
                        'email' => $email,
                        'phone' => $phone,
                        'bod_bs' => $nepaliBOD->format('Y-m-d'),
                        'bod_ad' => $bod_ad,
                        'paremanent_address' => $permanent_address,
                        'temporary_address' => $temporary_address,
                        'created' => date('Y-m-d'),
                        'status' => '0',
                    );
                    
                    if($images){
                        if(file_put_contents($photo, $imagebase64)){ 
                            $data['passport_photo'] = $file_name;
                        }else{
                            // echo "come";exit;
                            $response=array(
                                'status' => "Error",
                                'status_code' => 206,
                                'status_message' => "Unable To Upload Attachment Passport Photo", 
                            );
                        }
                        
                    } 
                    
                    if($citizenships){
                        if(file_put_contents($citizenship_path_url, $imagebase64citizen)){ 
                            $data['font_citizenship'] = $citizenshipfile_name;
                        }else{
                            // echo "come";exit;
                            $response=array(
                                'status' => "Error",
                                'status_code' => 206,
                                'status_message' => "Unable To Upload Attachment Citizenship Front Image", 
                            );
                        }
                        
                    } 
                    
                    if($citizen_back){
                        if(file_put_contents($citizenship_path_back_url, $imagebase64citizenback)){ 
                            $data['back_citizenship'] = $citizenshipfile_back_name;
                        }else{
                            // echo "come";exit;
                            $response=array(
                                'status' => "Error",
                                'status_code' => 206,
                                'status_message' => "Unable To Upload Attachment Citizenship Back Image", 
                            );
                        }
                        
                    } 
                    
                    $this->load->library('email');
					    
				    $config = Array(
                        'protocol' => 'sendmail',
                        // 'smtp_host'  => 'ssl://smtp.gmail.com',
                        'smtp_host' => 'mail.icfcbank.com',
                        'smtp_port' => '465',
                        'smtp_user' => 'noreply@icfcbank.com', 
                        'smtp_pass' => 'P@$$w0rD1', 
                        // 'smtp_host' => 'mail.admin.icfcbank.com',
                        // 'smtp_port' => '465',
                        // 'smtp_user' => 'grievance@admin.icfcbank.com', 
                        // 'smtp_pass' => '(cx$iLtX=N@%', 
                        'mailtype' => 'html',
                        //   'charset' => 'iso-8859-1',
                        'charset' => 'utf-8',
                        'wordwrap' => TRUE
                    );
                    
                    $this->email->initialize($config);
                    $this->email->from('noreply@icfcbank.com','Saptakoshi Development Bank LTD.');
                    $this->email->to("bikash@nyatapol.biz"); //$email
                   
                    // $this->email->cc();
                    // $this->email->bcc();
                    $this->email->subject('Saptakoshi Development Bank LTD. Online Account Opening');
                    $this->email->message(
                            '
                            <p>Dear customer,</p>

                            <p>Your online account opening has been successfully submitted. The bank will response back to you soon.</p></br>
                            <p>Keep checking your mail. </p></br>
                            <p>Regards,</p></br>
                            
                            <p>Saptakoshi Development Bank.</p></br>'
                        );
                    
                    if($this->email->send()){
                        // echo "<pre>";
                        // var_dump($data, $file, $citizenships, $file_cit);exit;
        				$account_id = $this->crud_model->inserted($this->table, $data);
        				if($account_id){
                            
                            $response=array(
                                    'status' => "Success",
                                    'status_code' => 200,
                                    'status_message' => "Successfully Submitted Online Opening Account. Please, check your mail.", 
                                );
                        }else{
                            $response=array(
                                    'status' => "Error",
                                    'status_code' => 307,
                                    'status_message' => "Unable to submit Online Opening Account. Please, contact to SKDBL", 
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
    
}
