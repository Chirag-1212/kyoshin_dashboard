<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Testimonials extends Front_controller
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
            // Querying 'testimonials' table with lowercase columns
            $testimonials = $this->crud_model->getData(
                'testimonials', 
                ['status' => '1'], 
                [], 
                10, 
                0, 
                'id, title, title_jp, sub_title, sub_title_jp, slug, doc_path, description, description_jp',
                'id desc'
            );
            
            if ($testimonials) { 
                $response = array(
                    'status' => "success",
                    'status_code' => 200,
                    'status_message' => "testimonial list",
                    'testimonials' => $testimonials, 
                );
            } else {
                $response = array(
                    'status' => "error",
                    'status_code' => 404,
                    'status_message' => "no testimonials found", 
                );
            } 
        } 
        echo json_encode($response);
    } 
}