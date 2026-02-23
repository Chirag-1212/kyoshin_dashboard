<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Forex extends Front_controller
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

    function index($date = '')
    {
        header('Access-Control-Allow-Method:GET');
        if ($this->request_method != "GET") {
            $response = array(
                'status' => "Error",
                'status_code' => 204,
                'status_message' => "Access Method Not Allowed",
            );
        } else { 
            
                //   $forex_data = $this->crud_model->get_forex($date); 
                
                if($date != ''){ 
                    $date = $date;
                }else{
                    $latest_date = $this->crud_model->get_where_single_order_by('forex_date', array('status'=>'1'), 'id', 'DESC');
                    $date = isset($latest_date->date_forex)?$latest_date->date_forex:date('Y-m-d');
                }    
                
                // $forex_dates = $this->crud_model->get_where_order_by('forex_date', array('date_forex' => $date), 'id', 'DESC');
                
                $sql_dates = "id, date_forex, published_on, modified_on, created_on";
                
                $forex_dates = $this->crud_model->get_sql_all_no_pagination('forex_date', array('date_forex' => $date), 'id', 'DESC', $sql_dates);
                
                foreach($forex_dates as $key=>$val){
                    $forex_values = $this->crud_model->get_where_order_by('forex_data', array('forex_date_id' => $val->id), 'id', 'DESC');
                    $forex_dates[$key]->forex_values = $forex_values;
                }
                
                if($forex_dates){
                    $response = array(
                        'status' => "success",
                        'status_code' => 200,
                        'status_message' => "Forex Retreived Successfully",
                        'data' => $forex_dates, 
                    );
                }else{
                    $response = array(
                        'status' => "error",
                        'status_code' => 204,
                        'status_message' => "Unable to get data", 
                    );
                } 
        }
        // var_dump($response);exit;
        $json_response = json_encode($response);
        echo $json_response;
    }
    
    
    function getForex($date = '')
    {
        header('Access-Control-Allow-Method:GET');
        if ($this->request_method != "GET") {
            $response = array(
                'status' => "Error",
                'status_code' => 204,
                'status_message' => "Access Method Not Allowed",
            );
        } else { 
            
                //   $forex_data = $this->crud_model->get_forex($date); 
                
                if($date != ''){ 
                    $date = $date;
                }else{  
                    $date = date('Y-m-d');
                }  
                
                // $api_url = 'https://www.nrb.org.np/api/forex/v1/rates?per_page=100&page=1&from='.$date.'&to='.$date;

                // Read JSON file
                // $json_data = file_get_contents($api_url);
                
                // // Decode JSON data into PHP array
                // $response_data = json_decode($json_data);
                
                // echo "<pre>";
                // var_dump($response_data->data->payload[0]->rates);exit;
                
                $sql_dates = "id, date_forex, published_on, modified_on, created_on";
                
                $forex_dates = $this->crud_model->get_sql_all_no_pagination('forex_date', array('status'=>'1', 'date_forex' => $date), 'id', 'DESC', $sql_dates);
                
                
                if($forex_dates){
                    foreach($forex_dates as $key=>$val){
                        $forex_values = $this->crud_model->get_where_order_by('forex_data', array('forex_date_id' => $val->id), 'id', 'DESC');
                        $forex_dates[$key]->forex_values = $forex_values;
                    }
                    
                    $response = array(
                        'status' => "success",
                        'status_code' => 200,
                        'status_message' => "Forex Retreived Successfully",
                        'data' => $forex_dates, 
                    );
                }else{ 
                    
                    $api_url = 'https://www.nrb.org.np/api/forex/v1/rates?per_page=100&page=1&from='.$date.'&to='.$date;

                    // Read JSON file
                    $json_data = file_get_contents($api_url);
                    
                    // Decode JSON data into PHP array
                    $response_data = json_decode($json_data);
                    
                    if($response_data->data->payload[0]->rates){
                        
                        $data = array(
                            'date_forex' => $response_data->data->payload[0]->date,
                            'published_on' => $response_data->data->payload[0]->published_on,
                            'modified_on' => $response_data->data->payload[0]->modified_on,
                            'created_on' => date('Y-m-d'),
                            // 'created_by' => $this->current_user->id,
                        );
                        
                        $check_duplicate = $this->crud_model->get_where_single_order_by('forex_date', array('status'=>'1','published_on'=>$data['published_on']), 'id', 'DESC');
                        
                        if(empty($check_duplicate)){
                            $insert = $this->crud_model->insert('forex_date',$data); 
                            $insert_id = $this->db->insert_id();
                            
                            if($insert_id){
                                
                                $rates = $response_data->data->payload[0]->rates;
                                
                                $forex_data_batch = array();
                                
                                foreach($rates as $key=>$value){
                                    $temp = array(
                                                'forex_date_id' => $insert_id,
                                                'iso3' => $value->currency->iso3,
                                                'name' => $value->currency->name,
                                                'unit' => $value->currency->unit,
                                                'buy' => $value->buy,
                                                'sell' => $value->sell,
                                            );
                                    $forex_data_batch[] = $temp;     
                                }
                                // echo "<pre>";
                                // var_dump($forex_data_batch);exit;
                                
                                $this->db->insert_batch('forex_data', $forex_data_batch); 
                                
                                // $forex_dates = $this->crud_model->get_sql_all_no_pagination('forex_date', array('date_forex' => $date), 'id', 'DESC', $sql_dates);
                                
                                // $sql_dates = "id, date_forex, published_on, modified_on, created_on";
                                
                                $sql_datesss = "id, date_forex, published_on, modified_on, created_on";
                
                                $forex_dates = $this->crud_model->get_sql_all_no_pagination('forex_date', array('status'=>'1', 'date_forex' => $response_data->data->payload[0]->date), 'id', 'DESC', $sql_datesss);
                                
                                foreach($forex_dates as $key=>$val){
                                    $forex_values = $this->crud_model->get_where_order_by('forex_data', array('forex_date_id' => $val->id), 'id', 'DESC');
                                    $forex_dates[$key]->forex_values = $forex_values;
                                } 
                                
                                // $forex_dates = array(
                                //                     '0' => array(
                                //                                 'id' => $insert_id,
                                //                                 'date_forex' => $response_data->data->payload[0]->date,
                                //                                 'published_on' => $response_data->data->payload[0]->published_on,
                                //                                 'modified_on' => $response_data->data->payload[0]->modified_on,
                                //                                 'created_on' => date('Y-m-d'),
                                //                                 'forex_values' => $forex_data_batch,
                                //                             )
                                //                 );
                                
                                $response = array(
        							'status' => 'success',
        							'status_code' => 200,
        							'status_message' => 'Successfully inserted',
        							'forex_dates' => $forex_dates,
        						);
                            }else{
                                $response = array(
        							'status' => 'error',
        							'status_code' => 200,
        							'status_message' => 'Unable to insert to our database',
        						);
                            }
                        }else{
                            $response = array(
    							'status' => 'error',
    							'status_code' => 200,
    							'status_message' => 'Duplicate Entry, Already Received',
    						);
                        }
                        
                    }else{
                        $response = array(
                            'status' => "error",
                            'status_code' => 205,
                            'status_message' => "Unable to get data from NRB", 
                        );
                    }
                } 
        }
        // var_dump($response);exit;
        $json_response = json_encode($response);
        echo $json_response;
    } 
}
