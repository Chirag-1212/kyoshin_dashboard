<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Branches extends Front_controller
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
        $this->table = 'branches'; 
        $this->title = 'Branches';
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
            $sql_en = "id, PageTitle, PageTitleNepali,Description,description_nepali, Address, AddressNepali, Phone, PhoneNepali, toll_free_no, toll_free_no_nepali, Fax, FaxNepali,POB,POBNepali, Map, Manager, ManagerNepali, mobile, mobile_nepali, Email, latitude, longitude, district_id";
            $items = $this->crud_model->get_sql_all_no_pagination('branches', array('status' => '1','show_career'=>'N'), 'Serial', 'ASC', $sql_en);
            // $items = $this->crud_model->get_sql_all_no_pagination('branches', array('status' => '1'), 'Serial', 'ASC', $sql_en);
             foreach($items as $key=>$val){
               $district_en = $this->crud_model->getField('districts', array_merge( $this->param ,['id' => $val->district_id]), 'title');
               $district_ne = $this->crud_model->getField('districts', array_merge( $this->param ,['id' => $val->district_id]), 'title_nepali');
                //for english
                $branchEn[$key]['id'] = $val->id;
                $branchEn[$key]['title'] = $val->PageTitle;
                $branchEn[$key]['description'] = $val->Description;
                $branchEn[$key]['address'] = $val->Address." ,$district_en";
                $branchEn[$key]['phone'] = $val->Phone;
                $branchEn[$key]['toll_free_no'] = $val->toll_free_no;
                $branchEn[$key]['Fax'] = $val->Fax;
                $branchEn[$key]['POB'] = $val->POB;
                $branchEn[$key]['Map'] = $val->Map;
                $branchEn[$key]['manager'] = $val->Manager;
                $branchEn[$key]['email'] = $val->Email;
                $branchEn[$key]['latitude'] = $val->latitude;
                $branchEn[$key]['longitude'] = $val->longitude;
                

                //for neapli
                $branchNe[$key]['id'] = $val->id;
                $branchNe[$key]['title'] = $val->PageTitleNepali;
                $branchNe[$key]['description'] = $val->description_nepali;
                $branchNe[$key]['address'] = $val->AddressNepali." ,$district_ne";;
                $branchNe[$key]['phone'] = $val->PhoneNepali;
                $branchNe[$key]['toll_free_no'] = $val->toll_free_no_nepali;
                $branchNe[$key]['Fax'] = $val->FaxNepali;
                $branchNe[$key]['POB'] = $val->POBNepali;
                $branchNe[$key]['Map'] = $val->Map;
                $branchNe[$key]['manager'] = $val->Manager;
                $branchNe[$key]['email'] = $val->Email;
                $branchNe[$key]['latitude'] = $val->latitude;
                $branchNe[$key]['longitude'] = $val->longitude;
            }
            
            $atmEn = [];
            $atmNe = [];
            $sql_en = "id,PageTitle, PageTitleNepali,Description,description_nepali, Address, AddressNepali,map_link, Map, google_plus, Location, latitude, longitude";
            $items = $this->crud_model->get_sql_all_no_pagination('atm', array('status' => '1'), 'Serial', 'ASC', $sql_en);  
            foreach($items as $key=>$val){
                //for english
                $atmEn[$key]['id'] = $val->id;
                $atmEn[$key]['title'] = $val->PageTitle;
                $atmEn[$key]['description'] = $val->Description;
                $atmEn[$key]['address'] = $val->Address;
                $atmEn[$key]['Map'] = $val->map_link;
                $atmEn[$key]['email'] = '';
                $atmEn[$key]['manager'] = '';
                $atmEn[$key]['phone'] = '';
                $atmEn[$key]['location'] = $val->Location;
                $atmEn[$key]['latitude'] = $val->latitude;
                $atmEn[$key]['longitude'] = $val->longitude;

                //for nepali
                $atmNe[$key]['id'] = $val->id;
                $atmNe[$key]['title'] = $val->PageTitleNepali;
                $atmNe[$key]['description'] = $val->description_nepali;
                $atmNe[$key]['address'] = $val->AddressNepali;
                $atmNe[$key]['Map'] = $val->map_link;
                $atmNe[$key]['email'] = '';
                $atmNe[$key]['manager'] = '';
                $atmNe[$key]['phone'] = '';
                $atmNe[$key]['location'] = $val->Location;
                $atmNe[$key]['latitude'] = $val->latitude;
                $atmNe[$key]['longitude'] = $val->longitude;
            } 
            $atms = array(
                'en' =>$atmEn,
                'np' => $atmNe
            );
            
            $branches = array(
                'en' =>$branchEn,
                'np' => $branchNe
            );
            $response = array(
                'status' => "success",
                'status_code' => 200,
                'status_message' => "Data Retreived Successfully",
                'branch' => $branches, 
                'atms' => $atms, 
                
            );
        }
        // var_dump($response);exit;
        $json_response = json_encode($response);
        echo $json_response;
    }
}
