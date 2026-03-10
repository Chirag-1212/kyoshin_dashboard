<?php
defined('BASEPATH') or exit('No direct script access allowed');

class About extends Front_controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');

        header('Content-Type: application/json');
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Headers: Authorization, Origin, X-Requested-With, Content-Type, Accept");
        header("Access-Control-Allow-Methods: GET, POST, OPTIONS, DELETE, PUT");

        $this->request_method = $_SERVER["REQUEST_METHOD"];

        if ($this->request_method == "OPTIONS") {
            exit();
        }
    }

    function index()
    {
        header('Access-Control-Allow-Method: GET');

        if ($this->request_method != "GET") {

            $response = [
                'status' => "Error",
                'status_code' => 405,
                'status_message' => "Access Method Not Allowed"
            ];

        } else {

            $about = $this->crud_model->getData(
                'about_page',
                ['status' => '1'],
                [],
                10,
                0,
                'id, slug, title_en, title_jp',
                'id ASC'
            );

            if ($about) {

                $response = [
                    'status' => "Success",
                    'status_code' => 200,
                    'status_message' => "Item List",
                    'about' => $about
                ];

            } else {

                $response = [
                    'status' => "Error",
                    'status_code' => 404,
                    'status_message' => "No Items Found"
                ];
            }
        }

        echo json_encode($response);
    }
}