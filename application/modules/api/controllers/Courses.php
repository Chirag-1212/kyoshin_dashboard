<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Courses extends Front_controller
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
    }

    function index()
    {
        if ($this->request_method != "GET") {
            $response = array(
                'status' => "error",
                'status_code' => 405,
                'status_message' => "method not allowed",
            );
        } else {  
            // Fetching active courses using small letters for table and columns
            $courses = $this->crud_model->getData(
                'our_courses', 
                ['status' => '1'], 
                [], 
                50, // Limit (adjust as needed)
                0,  // Offset
                'id, slug, title_en, title_jp, sub_level, sub_text_en, sub_text_jp, desc_en, desc_jp, docpath',
                'id desc'
            );
            
            if ($courses) { 
                $response = array(
                    'status' => "success",
                    'status_code' => 200,
                    'status_message' => "course list",
                    'courses' => $courses, 
                );
            } else {
                $response = array(
                    'status' => "error",
                    'status_code' => 404,
                    'status_message' => "no courses found", 
                );
            } 
        } 
        
        echo json_encode($response);
    } 
}