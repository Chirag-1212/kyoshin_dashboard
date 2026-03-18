<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Banner extends Front_controller
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
            // Querying 'banners' table with lowercase columns as per your setup
            $banners = $this->crud_model->getData(
                'banners', 
                ['status' => '1'], 
                [], 
                10, 
                0, 
                'id, submitdt, title, slug, docpath, target, border, description, type, file_type',
                'id desc'
            );
            
            if ($banners) { 
                $response = array(
                    'status' => "success",
                    'status_code' => 200,
                    'status_message' => "banner list",
                    'banners' => $banners, 
                );
            } else {
                $response = array(
                    'status' => "error",
                    'status_code' => 404,
                    'status_message' => "no banners found", 
                );
            } 
        } 
        echo json_encode($response);
    } 
}