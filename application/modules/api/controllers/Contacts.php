<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Contacts extends Front_controller
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
    }

    function index()
    {
        // echo "here";exit;
        header('Access-Control-Allow-Method:GET');
        if ($this->request_method != "GET") {
            $response = array(
                'status' => "Error",
                'status_code' => 204,
                'status_message' => "Access Method Not Allowed",
            );
        } else { 
            $site_settings  = $this->crud_model->get_where_single_order_by('site_settings', array('status'=>'1'), 'id', 'DESC');   
            $response = array(
                'status' => "success",
                'status_code' => 200,
                'status_message' => "Data Retreived Successfully",
                'site_settings' => $site_settings, 
            );
        }
        // var_dump($response);exit;
        $json_response = json_encode($response);
        echo $json_response;
    }
    
    public function add_feedback()
    {
        // echo "here";exit;
        header('Access-Control-Allow-Method:POST');
        if ($this->request_method != "POST") {
            $response = array(
                'status' => "Error",
                'status_code' => 204,
                'status_message' => "Access Method Not Allowed",
            );
        } else { 
            $postdata = json_decode(file_get_contents("php://input")); 
            // var_dump($postdata);exit;
            if(!empty($postdata)){
                $email = $postdata->email;
                $fullname = $postdata->fullname;
                $phone = $postdata->phone;
                $address = $postdata->address;
                $message = $postdata->message;
                $token = $postdata->token;
                $secret = $postdata->secret; 
                
                if(empty($email) || empty($fullname) || empty($phone) || empty($address) || empty($message)){
                    $response = array(
                        'status' => "ERROR",
                        'status_code' => 205,
                        'status_message' => "All Fields Required"
                    );
                }else{
                    
                    $api_url = "https://www.google.com/recaptcha/api/siteverify?secret=".$secret."&response=".$token;

                    // Read JSON file
                    $json_data = file_get_contents($api_url);
                    
                    // Decode JSON data into PHP array
                    $response_data = json_decode($json_data);
                    
                    if($response_data->success = true){
                        $data = array(
                                'email' => $email,
                                'fullname' => $fullname,
                                'phone' => $phone,
                                'address' => $address,
                                'message' => $message,
                                'created_on' => (new DateTime())->format('Y-m-d')
                            );
                        
                        $result = $this->crud_model->insert('feedback_message',$data);
                        
                        if($result){
                            $response = array(
                                    'status' => "SUCCESS",
                                    'status_code' => 200,
                                    'status_message' => "Successfully inserted to feedback message",
                                );
                        }else{
                            $response = array(
                                'status' => "ERROR",
                                'status_code' => 205,
                                'status_message' => "Unable to send message"
                            );
                        } 
                    }else{
                        $response = array(
                                'status' => "ERROR",
                                'status_code' => 205,
                                'status_message' => "captcha not verified"
                            );
                    }   
                }    
            } else {
                $response = array(
                    'status' => "ERROR",
                    'status_code' => 205,
                    'status_message' => "Not Verified"
                );
            } 
        }
        // var_dump($response);exit;
        $json_response = json_encode($response);
        echo $json_response;
    }
    
    public function verify_token()
    {
        // echo "here";exit;
        header('Access-Control-Allow-Method:POST');
        if ($this->request_method != "POST") {
            $response = array(
                'status' => "Error",
                'status_code' => 204,
                'status_message' => "Access Method Not Allowed",
            );
        } else { 
            $postdata = json_decode(file_get_contents("php://input")); 
            
            if(!empty($postdata)){
                $token = $postdata->token; 
                $secret = $postdata->secret; 
                
                if(empty($token)){
                    $response = array(
                        'status' => "ERROR",
                        'status_code' => 205,
                        'status_message' => "Token Required"
                    );
                }else{
                    $api_url = "https://www.google.com/recaptcha/api/siteverify?secret=".$secret."&response=".$token;

                    // Read JSON file
                    $json_data = file_get_contents($api_url);
                    
                    // Decode JSON data into PHP array
                    $response_data = json_decode($json_data);
                    
                    // var_dump($response_data);exit;
                    
                    // $response = array(
                    //         'status' => "SUCCESS",
                    //         'success' => true,
                    //         'status_code' => 200,
                    //         'status_message' => "Successfully inserted to feedback message",
                    //         'rajesh' => $response_data,
                    //         'token' => $token,
                    //         'secret' => $secret,
                    //     );
                    
                    if($response_data->success == true){
                        $response = array(
                            'status' => "SUCCESS",
                            'success' => true,
                            'status_code' => 200,
                            'status_message' => "Successfully inserted to feedback message",
                            'data_api' => $response_data,
                            'token' => $token,
                            'secret' => $secret,
                        );
                    }else{
                        $response = array(
                            'status' => "ERROR",
                            'success' => false,
                            'status_code' => 205,
                            'status_message' => "Unable To verify captcha",
                            'token' => $token,
                            'secret' => $secret,
                        );
                    }
                }   
                    
            } else {
                $response = array(
                    'status' => "ERROR",
                    'status_code' => 205,
                    'status_message' => "Not Verified"
                );
            } 
        }
        // var_dump($response);exit;
        $json_response = json_encode($response);
        echo $json_response;
    }
}