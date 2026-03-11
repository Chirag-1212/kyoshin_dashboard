<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Jobs extends Front_controller
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
            $jobs = $this->crud_model->getData(
                'job_category', 
                ['status' => '1'], 
                [], 
                50, 
                0, 
                'id, slug, title_en, title_jp, desc_en, desc_jp, docpath',
                'id desc'
            );
            
            if ($jobs) { 
                $response = array(
                    'status' => "success",
                    'status_code' => 200,
                    'status_message' => "job category list",
                    'jobs' => $jobs, 
                );
            } else {
                $response = array(
                    'status' => "error",
                    'status_code' => 404,
                    'status_message' => "no job categories found", 
                );
            } 
        } 
        
        echo json_encode($response);
    } 
}