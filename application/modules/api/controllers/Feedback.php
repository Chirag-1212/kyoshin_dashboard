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

    public function index()
    { 
        header('Access-Control-Allow-Method:POST');

        if ($this->request_method != "POST") {
            $response = array(
                'status' => "Error",
                'status_code' => 204,
                'status_message' => "Access Method Not Allowed",
            );
        } else { 
            // Read JSON input
            $stream_clean = $this->security->xss_clean(file_get_contents("php://input"));
            $input_data = json_decode($stream_clean, true);

            if (empty($input_data)) {
                $input_data = $this->input->post();
            }

            if ($input_data) {
                $email = isset($input_data['email']) ? htmlspecialchars(stripslashes(trim($input_data['email']))) : '';

                if (empty($email)) {
                    $response = array(
                        'status' => "Error",
                        'status_code' => 307,
                        'status_message' => "email is required",
                    );
                } else {
                    $save_data = array(
                        'fullname'   => isset($input_data['fullname']) ? htmlspecialchars(stripslashes(trim($input_data['fullname']))) : '',
                        'email'      => $email,
                        'phone'      => isset($input_data['phone'])    ? htmlspecialchars(stripslashes(trim($input_data['phone'])))    : '',
                        'address'    => isset($input_data['address'])  ? htmlspecialchars(stripslashes(trim($input_data['address'])))  : '',
                        'message'    => isset($input_data['message'])  ? htmlspecialchars(stripslashes(trim($input_data['message'])))  : '',
                        'status'     => '1',
                        'created_on' => date('Y-m-d'), // Matches your SQL 'date' type
                    );

                    $inserted_id = $this->crud_model->inserted($this->table, $save_data);

                    if ($inserted_id) {
                        $response = array(
                            'status' => "Success",
                            'status_code' => 200,
                            'status_message' => "successfully submitted",
                        );
                    } else {
                        $response = array(
                            'status' => "Error",
                            'status_code' => 300,
                            'status_message' => "error in submitting the data",
                        );
                    }
                }
            } else {
                $response = array(
                    'status' => "Error",
                    'status_code' => 300,
                    'status_message' => "input data required",
                );
            }
        } 

        echo json_encode($response);
    } 
}