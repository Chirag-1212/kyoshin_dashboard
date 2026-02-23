<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Officer extends Front_controller
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
        $this->table = 'officers'; 
        $this->title = 'Officer';
    }

     function holder($type, $page=0)
    { 
        // echo "here";exit;
        header('Access-Control-Allow-Method:GET');
        if ($this->request_method != "GET") {
            $response=array(
                'status' => "Error",
                'status_code' => 204,
                'status_message' => "Access Method Not Allowed",
            );
        } else { 
                $per_page = 12;
                $items = $this->crud_model->get_where_pagination_order_by($this->table, array('type'=>$type,'status' => '1'), $page, $per_page, 'id', 'DESC'); 
                
                foreach($items as $key=>$val){
                    
                    $items[$key]->branch = isset($branch_detail->PageTitle)?$branch_detail->PageTitle:'';
                    $items[$key]->valley = isset($branch_detail->Valley)?$branch_detail->Valley:'';
                }
                 
                $total = $this->crud_model->count_all($this->table, array('type'=>$type,'status' => '1'), 'id'); 
                if($items){ 
                    $response=array(
                            'status' => "Success",
                            'status_code' => 200,
                            'status_message' => "Item List",
                            'officer' => $items,
                            'total' => $total,
                            'per_page' => $per_page,
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