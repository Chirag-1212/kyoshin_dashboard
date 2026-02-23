<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Digital_services extends Front_controller
{
    protected $param;
    protected $table;
    protected $title;
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
        $this->table = 'digital_services'; 
        $this->title = 'Digital Services';
        $this->param = array('status'=>'1');
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
            $sql = 'title, id, slug, description, description_nepali, featured_image, external_url, title_nepali, created, updated';
            $items = $this->crud_model->get_sql_all_no_pagination($this->table, $this->param, 'id', 'DESC', $sql);
            if(!empty($items)){
                $digitalEn = [];
                $digitalNe = [];
                foreach($items as $key=>$val){
                    
                    //for english
                    $digitalEn[$key]['id'] = $val->id;
                    $digitalEn[$key]['title'] = $val->title;
                    $digitalEn[$key]['slug'] = $val->slug;
                    $digitalEn[$key]['image'] = $val->featured_image;
                    $digitalEn[$key]['description'] = $val->description;
                    $digitalEn[$key]['created_on'] = $val->created;
                    $digitalEn[$key]['lastmodified'] = $val->updated;

                    //for neapli
                    $digitalNe[$key]['id'] = $val->id;
                    $digitalNe[$key]['title'] = $val->title_nepali;
                    $digitalNe[$key]['slug'] = $val->slug;
                    $digitalNe[$key]['image'] = $val->featured_image;
                    $digitalNe[$key]['description'] = $val->description_nepali;
                    $digitalNe[$key]['created_on'] = $val->created;
                    $digitalNe[$key]['lastmodified'] = $val->updated;
                }
                
                
                $response = array(
                    'status' => "success",
                    'status_code' => 200,
                    'status_message' => "Data Retreived Successfully",
                    'items' => [
                        'en' =>$digitalEn,
                        'np' => $digitalNe
                    ], 
                );
            }else{
                $response = array(
                    'status' => "error",
                    'status_code' => 200,
                    'status_message' => "No Data found", 
                );
            } 
            
            
        }
        // var_dump($response);exit;
        $json_response = json_encode($response);
        echo $json_response;
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
                $detail = $this->crud_model->get_where_single_order_by($this->table, array_merge($this->param,array('slug'=>$slug)), 'id', 'DESC');
                if(!empty($detail)){
                    $response = array(
                        'status' => "success",
                        'status_code' => 200,
                        'status_message' => "Data Retreived Successfully",
                        'detail' => $detail, 
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
