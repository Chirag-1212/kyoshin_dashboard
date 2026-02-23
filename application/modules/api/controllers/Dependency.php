<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dependency extends Front_controller
{
    protected $param;
    function __construct()
    {
        parent::__construct();
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
        $this->param = [
            'status' => '1'
        ]; 
    }
    
    function provience_wise_district($provienceId = '')
    { 
        header('Access-Control-Allow-Method:GET');
        if ($this->request_method != "GET") {
            $response=array(
                'status' => "Error",
                'status_code' => 204,
                'status_message' => "Access Method Not Allowed",
            );
        } else { 
            
                if ($provienceId) {  
                    
                   $district = $this->crud_model->getDataArray('districts', array_merge($this->param, ['province_id' => $provienceId]), 'title, id', 'id DESC');
                    if($district){
                        
                        $items = $this->crud_model->search_front($search_word,$offset,$per_page);  
                        $total = $this->crud_model->count_search($provience);
                        $response=array(
                                'status' => "Success",
                                'status_code' => 200,
                                'status_message' => "District listed",
                                'district' => $district,
                            );
                    }else{
                        $response=array(
                                'status' => "Success",
                                'status_code' => 200,
                                'status_message' => "No serach word found",
                                'items' => array(),
                                'total' => 0,
                                'per_page' => $per_page,
                            );
                    }
                }else{
                    $response=array(
                                'status' => "Error",
                                'status_code' => 300,
                                'status_message' => "Search word required", 
                            );
                }   
            
        } 
        $json_response = json_encode($response);
        echo $json_response;
    }
    
    function district_wise_municipality($districtId='')
    { 
        header('Access-Control-Allow-Method:GET');
        if ($this->request_method != "GET") {
            $response=array(
                'status' => "Error",
                'status_code' => 204,
                'status_message' => "Access Method Not Allowed",
            );
        } else { 
                // $provinceId ='','province_id' =>$provinceId, 
                if ($districtId ) {  
                    
                   $municipality = $this->crud_model->getDataArray('municipality', array_merge($this->param, ['district_id' => $districtId]), 'title, id, title_nepali');
                    if($municipality){
                        
                        $response = array(
                            'status' => "Success",
                            'status_code' => 200,
                            'status_message' => "District listed",
                            'municipality' => $municipality,
                        );
                    }else{
                        $response=array(
                            'status' => "Success",
                            'status_code' => 200,
                            'status_message' => "No serach word found",
                            'items' => array(),
                            'total' => 0,
                            'per_page' => $per_page,
                        );
                    }
                }else{
                    $response=array(
                                'status' => "Error",
                                'status_code' => 300,
                                'status_message' => "Search word required", 
                            );
                }   
            
        } 
        $json_response = json_encode($response);
        echo $json_response;
    }
    
    function district_wise_branch($districtId='')
    { 
        header('Access-Control-Allow-Method:GET');
        if ($this->request_method != "GET") {
            $response=array(
                'status' => "Error",
                'status_code' => 204,
                'status_message' => "Access Method Not Allowed",
            );
        } else { 
            
                if ($districtId) {  
                    
                   $branches = $this->crud_model->getDataArray('branches', array_merge($this->param, ['district_id' => $districtId]), 'PageTitle, id, latitude, longitude', 'id DESC');
                    if($branches){
                        
                        $items = $this->crud_model->search_front($search_word,$offset,$per_page);  
                        $total = $this->crud_model->count_search($provience);
                        $response=array(
                                'status' => "Success",
                                'status_code' => 200,
                                'status_message' => "District listed",
                                'branches' => $branches,
                            );
                    }else{
                        $response=array(
                                'status' => "Success",
                                'status_code' => 200,
                                'status_message' => "No serach word found",
                                'items' => array(),
                                'total' => 0,
                                'per_page' => $per_page,
                            );
                    }
                }else{
                    $response=array(
                                'status' => "Error",
                                'status_code' => 300,
                                'status_message' => "Search word required", 
                            );
                }   
            
        } 
        $json_response = json_encode($response);
        echo $json_response;
    }
    
    function branch($branchId='')
    { 
        header('Access-Control-Allow-Method:GET');
        if ($this->request_method != "GET") {
            $response=array(
                'status' => "Error",
                'status_code' => 204,
                'status_message' => "Access Method Not Allowed",
            );
        } else { 
            
                if ($branchId) {  
                    
                   $branche = $this->crud_model->getDetail('branches', array_merge($this->param, ['district_id' => $branchId]), 'id, latitude, longitude');
                    if($branche){
                        $response=array(
                            'status' => "Success",
                            'status_code' => 200,
                            'status_message' => "District listed",
                            'id' => $branche->id,
                            'latitude' => $branche->latitude,
                            'longitude' => $branche->longitude,
                        );
                    }else{
                        $response=array(
                            'status' => "Success",
                            'status_code' => 200,
                            'status_message' => "No serach word found",
                            'id' => '',
                            'latitude' => '',
                            'longitude' => '',
                        );
                    }
                }else{
                    $response=array(
                        'status' => "Error",
                        'status_code' => 300,
                        'status_message' => "Search word required", 
                    );
                }   
            
        } 
        $json_response = json_encode($response);
        echo $json_response;
    }
}