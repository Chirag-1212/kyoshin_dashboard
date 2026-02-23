<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Closing_days extends Front_controller
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
        $this->table = 'audio'; 
        $this->title = 'Audios';
    } 
    
    function index(){
        header('Access-Control-Allow-Method:GET');
        if ($this->request_method != "GET") {
            $response=array(
                'status' => "Error",
                'status_code' => 204,
                'status_message' => "Access Method Not Allowed",
            );
        } else {
            $current_date = date('Y-m-d');  
            
            $current_time = date('H:i');
            $newDay = date('l');
            
            $flag = true;
            $opening_time = '';
            $closing_time = '';
            
            
            $site_settings = $this->crud_model->get_where_single_order_by('site_settings', array('status' => '1'), 'id', 'DESC');
            if($newDay == "Friday"){
                $opening_time = $site_settings->opening_time_friday;
                $closing_time = $site_settings->closing_time_friday;
            }else{
                $opening_time = $site_settings->opening_time;
                $closing_time = $site_settings->closing_time;
            } 
            
            $check_closing_days = $this->crud_model->get_where_single_order_by('closing_days', array('date'=>$current_date, 'status' => '1'), 'id', 'DESC'); 
            if(!empty($check_closing_days)){
                $flag = false;
            }else{
            // $flag = true; 
                if($newDay == "Saturday"){
                    $flag = false;
                }else{  
                    if(strtotime($opening_time) <= strtotime($current_time) && strtotime($current_time) <= strtotime($closing_time) ){
                        // echo "up";exit;
                        $flag = true;
                    }else{
                        // echo "down";exit;
                        $flag = false;
                    }
                }
            }
            
            $new_date = $current_date;
            $day_name = '';
            
            if($flag == false){
                $x = 1;
                
                while($x <= 100) {
                  $new_date = date('Y-m-d', strtotime($new_date. ' + 1 days')); 
                  $check_closing_days = $this->crud_model->get_where_single_order_by('closing_days', array('date'=>$new_date, 'status' => '1'), 'id', 'DESC'); 
                  if(!empty($check_closing_days)){
                      continue;
                  }else{
                      $day_name =  date('l', strtotime($new_date));
                      if($day_name == "Saturday"){
                          continue;
                      }else{
                           if($day_name == "Friday"){
                                $opening_time = $site_settings->opening_time_friday;
                                $closing_time = $site_settings->closing_time_friday;
                            }else{
                                $opening_time = $site_settings->opening_time;
                                $closing_time = $site_settings->closing_time;
                            }
                            break;
                      }
                  }        
                  
                  
                  
                  $x++;
                }
            }
            
            $response=array(
                'status' => "Success",
                'status_code' => 200,
                'status_message' => "Condition Retrived",
                'condition' => $flag,
                'opening_time' => $opening_time,
                'closing_time' => $closing_time,
                'new_opening_date' => $new_date,
                'new_opening_day' => $day_name,
            );
        }   
        $json_response = json_encode($response);
        echo $json_response;
    } 
}