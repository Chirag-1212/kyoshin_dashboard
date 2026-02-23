<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Search extends Front_controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->helper('file');
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
    }
    
    
    function search($page=1)
    { 
        header('Access-Control-Allow-Method:POST');
        if ($this->request_method != "POST") {
            $response=array(
                'status' => "Error",
                'status_code' => 204,
                'status_message' => "Access Method Not Allowed",
            );
        } else {  
            
                $input_data = json_decode(file_get_contents("php://input"));
                
                if ($input_data) { 
                    $search_word =  isset($input_data->search_word)? $input_data->search_word:'';   
                    
                    // $this->session->set_userdata('search_word', $search_word); 
                    
                    $per_page = 12;
                    $offset = ($page*$per_page - $per_page); 
                    
                    if($search_word){
                        
                        $items = $this->crud_model->search_front($search_word,$per_page,$offset);  
                        $total = $this->crud_model->count_search($search_word);
                        $response=array(
                                'status' => "Success",
                                'status_code' => 200,
                                'status_message' => "Search Result",
                                'items' => $items,
                                'total' => $total,
                                'per_page' => $per_page,
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
    
    function pagination($search_word,$page=1)
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
                // var_dump($search_word, $page);
                $search_word = str_replace("-"," ",$search_word);
                $per_page = 12;
                
                if($search_word && $page){
                    
                    $items = $this->crud_model->search_front($search_word,$per_page, $offset);  
                    $total = $this->crud_model->count_search($search_word);
                    $response=array(
                            'status' => "Success",
                            'status_code' => 200,
                            'status_message' => "Search Result",
                            'items' => $items,
                            'total' => $total,
                            'per_page' => $per_page,
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
            
        } 
        $json_response = json_encode($response);
        echo $json_response;
    }
    
    function search_detail($slug)
    { 
        header('Access-Control-Allow-Method:GET');
        if ($this->request_method != "GET") {
            $response=array(
                'status' => "Error",
                'status_code' => 204,
                'status_message' => "Access Method Not Allowed",
            );
        } else { 
                    
            if($slug){
                $search = $this->crud_model->getDetail('vw_front_search', ['slug' => $slug], '*');
                if($search){
                    $items = $this->crud_model->getDetail($search->module_name, ['status' => '1' ,'slug' => $search->slug]); 
                    $items->description = $search->description;
                    $items->title = $search->title;
                    $response=array(
                            'status' => "Success",
                            'status_code' => 200,
                            'status_message' => "Search Result",
                            'items' => $items,
                        );
                }else{
                    $response=array(
                        'status' => "Success",
                        'status_code' => 200,
                        'status_message' => "No Content Found!",
                        'items' => array(),
                        'total' => 0,
                        'per_page' => $per_page,
                    );
            }
                
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
            
        } 
        $json_response = json_encode($response);
        echo $json_response;
    }
}