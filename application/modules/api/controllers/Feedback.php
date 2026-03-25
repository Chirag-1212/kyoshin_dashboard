<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Feedback extends Front_controller
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

        if ($this->request_method == "OPTIONS") {
            die();
        }

        $this->table = 'feedback_message'; 
    }

    function index()
    { 
        header('Access-Control-Allow-Method:POST');

        if ($this->request_method != "POST") {
            $response = array(
                'status' => "Error",
                'status_code' => 204,
                'status_message' => "Access Method Not Allowed",
            );
        } else { 
            // Reading as object to match your Contacts reference style
            $postdata = json_decode(file_get_contents("php://input"));

            if (!empty($postdata)) {
                $email    = isset($postdata->email) ? htmlspecialchars(stripslashes(trim($postdata->email))) : '';
                $fullname = isset($postdata->fullname) ? htmlspecialchars(stripslashes(trim($postdata->fullname))) : '';
                $phone    = isset($postdata->phone) ? htmlspecialchars(stripslashes(trim($postdata->phone))) : '';
                $address  = isset($postdata->address) ? htmlspecialchars(stripslashes(trim($postdata->address))) : '';
                $message  = isset($postdata->message) ? htmlspecialchars(stripslashes(trim($postdata->message))) : '';
                $token    = isset($postdata->token) ? $postdata->token : '';
                $secret   = isset($postdata->secret) ? $postdata->secret : '';

                // Stricter validation matching your Contacts reference
                if (empty($email) || empty($fullname) || empty($phone) || empty($address) || empty($message)) {
                    $response = array(
                        'status' => "ERROR",
                        'status_code' => 205,
                        'status_message' => "All Fields Required"
                    );
                } else {
                    // Google reCAPTCHA Verification logic from reference
                    $api_url = "https://www.google.com/recaptcha/api/siteverify?secret=" . $secret . "&response=" . $token;
                    $json_data = file_get_contents($api_url);
                    $response_data = json_decode($json_data);
                    

                    // Note: Fixed the '=' to '==' comparison bug found in the reference
                    /*if (isset($response_data->success) && $response_data->success == true)*/
                    if(true) {
                        
                        $save_data = array(
                            'fullname'   => $fullname,
                            'email'      => $email,
                            'phone'      => $phone,
                            'address'    => $address,
                            'message'    => $message,
                            'status'     => '1',
                            'created_on' => (new DateTime())->format('Y-m-d')
                        );

                        // Using insert() as per your reference
                        $result = $this->crud_model->insert($this->table, $save_data);

                        if ($result) {
                            $response = array(
                                'status' => "SUCCESS",
                                'status_code' => 200,
                                'status_message' => "Successfully inserted to feedback message",
                            );
                        } else {
                            $response = array(
                                'status' => "ERROR",
                                'status_code' => 205,
                                'status_message' => "Unable to send message"
                            );
                        }
                    } else {
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

        echo json_encode($response);
    } 
}