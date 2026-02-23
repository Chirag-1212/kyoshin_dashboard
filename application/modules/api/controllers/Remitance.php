<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Remitance extends Front_controller
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
        header('Access-Control-Allow-Method:GET');
        if ($this->request_method != "GET") {
            $response = array(
                'status' => "Error",
                'status_code' => 204,
                'status_message' => "Access Method Not Allowed",
            );
        } else {
            $getRemitance = $this->crud_model->getData('remitance', array('status'=>'1'), [], 10, 0, 'id, slug, title_nepali, title, featured_image as Image');
            $servicesEn = [];
            $servicesNe = [];
            if($getRemitance){
                foreach($getRemitance as $key=>$remit){
                    $remitsEn[$key]['id'] = $remit->id;
                    $remitsEn[$key]['title'] = $remit->title;
                    $remitsEn[$key]['slug'] = $remit->slug;
                    $remitsEn[$key]['image'] = $remit->Image;
                    
                    $remitsNe[$key]['id'] = $remit->id;
                    $remitsNe[$key]['title'] = $remit->title_nepali;
                    $remitsNe[$key]['slug'] = $remit->slug;
                    $remitsNe[$key]['image'] = $remit->Image;
                }
            }
            
            $remitance = [
                'en' => $remitsEn,
                'np' => $remitsNe,
            ];
            
            
            //Counts ends
            $response = array(
                'status' => "success",
                'status_code' => 200,
                'status_message' => "Data Retreived Successfully",
                'remitance' => $remitance,
            );
        }
        // var_dump($response);exit;
        $json_response = json_encode($response);
        echo $json_response;
    }
}