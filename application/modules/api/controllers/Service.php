<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Service extends Front_controller
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
        if ($this->request_method !== "GET") {
            $this->send_response("error", 405, "method not allowed");
            return;
        }

        // Using lowercase table and columns as per your instruction
        $items = $this->crud_model->getData(
            'service', 
            ['status' => '1'], 
            [], 
            20, 
            0, 
            'id, slug, title_en, title_jp, desc_en, desc_jp, docpath, coverimage, image, link, datevalue',
            'id desc'
        );
        
        if (!empty($items)) { 
            $this->send_response("success", 200, "item list", $items);
        } else {
            $this->send_response("error", 404, "no items found");
        } 
    }

    // Helper method to standardize all API outputs
    private function send_response($status, $code, $message, $data = null)
    {
        $response = array(
            'status' => $status,
            'status_code' => $code,
            'status_message' => $message,
        );
        
        if ($data !== null) {
            $response['data'] = $data;
        }
        
        echo json_encode($response);
    }
}