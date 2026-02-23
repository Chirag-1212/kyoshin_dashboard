<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Extension extends Front_controller
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
        $this->table = 'extension_counter'; 
        $this->title = 'Extension Counter';
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
            $branchNe = [];
            $branchEn = [];
            $sql_en = "id, PageTitle, PageTitleNepali, Address, AddressNepali, Phone, PhoneNepali, Manager, ManagerNepali, mobile, mobile_nepali, Email, latitude, longitude, district_id";
            $items = $this->crud_model->get_sql_all_no_pagination($this->table,  $this->param , 'Serial', 'ASC', $sql_en);  
             foreach($items as $key=>$val){
               $district_en = $this->crud_model->getField('districts', array_merge( $this->param ,['id' => $val->district_id]), 'title');
               $district_ne = $this->crud_model->getField('districts', array_merge( $this->param ,['id' => $val->district_id]), 'title_nepali');
                //for english
                $branchEn[$key]['id'] = $val->id;
                $branchEn[$key]['title'] = $val->PageTitle;
                $branchEn[$key]['address'] = $val->Address." ,$district_en";
                $branchEn[$key]['phone'] = $val->Phone?$val->Phone:$val->mobile;
                $branchEn[$key]['manager'] = $val->Manager;
                $branchEn[$key]['email'] = $val->Email;
                $branchEn[$key]['latitude'] = $val->latitude;
                $branchEn[$key]['longitude'] = $val->longitude;
                

                //for neapli
                $branchNe[$key]['id'] = $val->id;
                $branchNe[$key]['title'] = $val->PageTitleNepali;
                $branchNe[$key]['address'] = $val->AddressNepali." ,$district_ne";;
                $branchNe[$key]['phone'] = $val->PhoneNepali?$val->PhoneNepali:$val->mobile_nepali;
                $branchNe[$key]['manager'] = $val->Manager;
                $branchNe[$key]['email'] = $val->Email;
                $branchNe[$key]['latitude'] = $val->latitude;
                $branchNe[$key]['longitude'] = $val->longitude;
            }
            
            
            $response = array(
                'status' => "success",
                'status_code' => 200,
                'status_message' => "Data Retreived Successfully",
                'extension' => array(
                    'en' =>$branchEn,
                    'np' => $branchNe
                ), 
            );
        }
        // var_dump($response);exit;
        $json_response = json_encode($response);
        echo $json_response;
    }
}
