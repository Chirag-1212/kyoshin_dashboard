<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Calendar extends Front_controller
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
            
            $current_date = date('Y-m-d');
                
            $current_year_where = array(
                        'is_current' => 'Yes',
                        'status' => '1',
                );
            $current_year = $this->crud_model->get_where_single_order_by('calendar_year', $current_year_where, 'id', 'DESC');
            
            $current_year_id = $current_year->id;
            
            // var_dump($current_year_id);exit;
            
            
            $sql = "DocPath, Title, created_on, rank, calendar_year_id";
            $calendars = $this->crud_model->get_sql_all_no_pagination('calendar',array('status' => '1', 'calendar_year_id' => $current_year_id),'rank', 'ASC', $sql);
            
            foreach($calendars as $key=>$val){
                $calendars[$key]->DocPath = base_url('uploads/calendar/'.$val->DocPath);
            }
            
            // var_dump($emtDetail->user_id);exit; 
            $response = array(
                'status' => "success",
                'status_code' => 200,
                'status_message' => "Data Retreived Successfully",
                'calendars' => $calendars, 
            );
        }
        // var_dump($response);exit;
        $json_response = json_encode($response);
        echo $json_response;
    }
}
