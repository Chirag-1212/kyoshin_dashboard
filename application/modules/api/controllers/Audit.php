<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Audit extends Front_controller
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
        $this->table = 'teams'; 
        $this->title = 'Teams';
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
            $audit  = $this->crud_model->get_where_order_by($this->table, array('status'=>'1','team_group_id'=>28), 'rank', 'ASC'); 
            
            foreach($audit as $key=>$val){
                $team_group_detail = $this->crud_model->get_where_single_order_by('team_group', array('id'=>$val->team_group_id), 'id', 'DESC');
                $designation_detail = $this->crud_model->get_where_single_order_by('designation_para', array('id'=>$val->designation), 'id', 'DESC');
                $audit[$key]->group = isset($team_group_detail->group_name)?$team_group_detail->group_name:'';
                $audit[$key]->designation_name = isset($designation_detail->designation_name)?$designation_detail->designation_name:'';
            }
            
            $audit_detail = $this->crud_model->get_where_single_order_by('content', array('id'=>189), 'id', 'DESC');
            // var_dump($emtDetail->user_id);exit; 
            $response = array(
                'status' => "success",
                'status_code' => 200,
                'status_message' => "Data Retreived Successfully",
                'audit_detail' => $audit_detail,
                'audit' => $audit, 
            );
        }
        // var_dump($response);exit;
        $json_response = json_encode($response);
        echo $json_response;
    }
    
    // function all($page=1)
    // { 
    //     // echo "here";exit;
    //     header('Access-Control-Allow-Method:GET');
    //     if ($this->request_method != "GET") {
    //         $response=array(
    //             'status' => "Error",
    //             'status_code' => 204,
    //             'status_message' => "Access Method Not Allowed",
    //         );
    //     } else {  
    //             $per_page = 5;
    //             $offset = ($page*$per_page - $per_page); 
    //             $items = $this->crud_model->get_where_pagination_order_by($this->table, array('status' => '1'), $per_page, $offset, 'id', 'DESC');  
    //             $total = $this->crud_model->count_all($this->table, array('status' => '1'), 'id'); 
    //             if($items){ 
    //                 $response=array(
    //                         'status' => "Success",
    //                         'status_code' => 200,
    //                         'status_message' => "Item List",
    //                         'items' => $items,
    //                         'total' => $total,
    //                         'per_page' => $per_page,
    //                     );
    //             }else{
    //                 $response=array(
    //                         'status' => "error",
    //                         'status_code' => 208,
    //                         'status_message' => "No Items Found", 
    //                     );
    //             } 
            
    //     } 
    //     $json_response = json_encode($response);
    //     echo $json_response;
    // } 
}
