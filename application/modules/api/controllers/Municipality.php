<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Municipality extends Front_controller
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
        $this->table = 'municipality'; 
        $this->title = 'Municipality';
        $this->param = array('status' => '1');
    }

    function all($id = '')
    {
        header('Access-Control-Allow-Method:GET');
        if ($this->request_method != "GET") {
            $response = array(
                'status' => "Error",
                'status_code' => 204,
                'status_message' => "Access Method Not Allowed",
            );
        } else { 
            $municipalityNe = [];
            $municipalityEn = [];
            $param = ['status' => '1'];
            if($id){
                $param['district_id'] = $id;
            }
            $municipalitys = $this->crud_model->getData($this->table, $param, [], 0, 0);  
             foreach($municipalitys as $key=>$val){
                //for english
                $municipalityEn[$key]['id'] = $val->id;
                $municipalityEn[$key]['title'] = $val->title;
                
                //for neapli
                $municipalityNe[$key]['id'] = $val->id;
                $municipalityNe[$key]['title'] = $val->title_nepali;
            }
            
            
            $response = array(
                'status' => "success",
                'status_code' => 200,
                'status_message' => "Data Retreived Successfully",
                'municipality' => array(
                    'en' =>$municipalityEn,
                    'np' => $municipalityNe
                ), 
            );
        }
        // var_dump($response);exit;
        $json_response = json_encode($response);
        echo $json_response;
    }
}
