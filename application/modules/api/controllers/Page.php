<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Page extends Front_controller
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
        $this->table = 'news'; 
        $this->title = 'News';
    }  
    
    function detail($slug)
    {
        header('Access-Control-Allow-Method:GET');
        if ($this->request_method != "GET") {
            $response = array(
                'status' => "Error",
                'status_code' => 204,
                'status_message' => "Access Method Not Allowed",
            );
        } else {
            if($slug){
                
                $sql_en = "PageTitle, Description, CoverImage, created";
                $items_english = $this->crud_model->get_sql_single('content', array('status' => '1', 'slug' => $slug), 'id', 'DESC',$sql_en);  
                
                $sql_np = "PageTitleNepali as PageTitle, DescriptionNepali as Description, CoverImage, created";
                $items_nepali = $this->crud_model->get_sql_single('content', array('status' => '1', 'slug' => $slug), 'id', 'DESC',$sql_np);  
                
                $items = array(
                    'en' => $items_english,
                    'np' => $items_nepali,
                    );
                    
                if(!empty($items_english)){
                    $response = array(
                        'status' => "success",
                        'status_code' => 200,
                        'status_message' => "Data Retreived Successfully",
                        'detail' => $items, 
                    );
                }else{
                    $response = array(
                        'status' => "error",
                        'status_code' => 200,
                        'status_message' => "Invalid Slug", 
                    );
                } 
            }else{
                $response = array(
                    'status' => "error",
                    'status_code' => 200,
                    'status_message' => "Slug Required", 
                );
            }
            
        }
        // var_dump($response);exit;
        $json_response = json_encode($response);
        echo $json_response;
    }
}
