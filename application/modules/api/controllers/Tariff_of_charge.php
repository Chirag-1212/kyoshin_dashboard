<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Tariff_of_charge extends Front_controller
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
            $response=array(
                'status' => "Error",
                'status_code' => 204,
                'status_message' => "Access Method Not Allowed",
            );
        } else {  
            $sql='id, slug, PageTitle, PageTitleNepali, Description, DescriptionNepali';
            $epayment = $this->crud_model->getData('content', ['id' => 36,  'status' => '1'], [], 10, 0, 'id, slug, PageTitleNepali, PageTitle','rank ASC');
            
               
                if($epayment){ 
                    $response=array(
                            'status' => "Success",
                            'status_code' => 200,
                            'status_message' => "Item List",
                            'epayment' => $epayment, 
                        );
                }else{
                    $response=array(
                            'status' => "error",
                            'status_code' => 208,
                            'status_message' => "No Items Found", 
                        );
                } 
            
        } 
        $json_response = json_encode($response);
        echo $json_response;
    } 
}
