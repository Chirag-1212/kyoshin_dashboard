<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Province extends Front_controller
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
        $this->table = 'provinces'; 
        $this->title = 'Provinces';
        $this->param = array('status' => '1');
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
            $provienceNe = [];
            $provienceEn = [];
            $sql="id, p_no, title,title_nepali";
            $proviences = $this->crud_model->getData($this->table, ['status' => '1'], [], 0, 0,$sql,'p_no ASC');  
             foreach($proviences as $key=>$val){
                //for english
                $provienceEn[$key]['id'] = $val->p_no;
                $provienceEn[$key]['title'] = $val->title;
                
                //for neapli
                $provienceNe[$key]['id'] = $val->p_no;
                $provienceNe[$key]['title'] = $val->title_nepali;
            }
            
            
            $response = array(
                'status' => "success",
                'status_code' => 200,
                'status_message' => "Data Retreived Successfully",
                'provience' => array(
                    'en' =>$provienceEn,
                    'np' => $provienceNe
                ), 
            );
        }
        // var_dump($response);exit;
        $json_response = json_encode($response);
        echo $json_response;
    }
}
