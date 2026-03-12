<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Service_category extends Front_controller
{
    function __construct()
    {
        parent::__construct();
        header('Content-type:application/json');
        header("Access-Control-Allow-Origin: *");
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

        // Fetching all active service categories
        // Selecting fields that match your table schema
        $items = $this->crud_model->getData(
            'service_category', 
            ['status' => '1'], 
            [], 
            50, // Increased limit for categories
            0, 
            'id, parent_id, slug, title', 
            'id asc'
        );
        
        if (!empty($items)) { 
            $this->send_response("success", 200, "category list", $items);
        } else {
            $this->send_response("error", 404, "no categories found");
        } 
    }

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