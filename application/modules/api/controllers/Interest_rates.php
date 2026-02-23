<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Interest_rates extends Front_controller
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
        $this->table = 'interest_rate';  
        // $this->type = 'NU';
    } 
    
    function all($page=1)
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
                $interestEn = [];
                $interestNe = [];
                $per_page = 6;
                $offset = ($page*$per_page - $per_page); 
                $items = $this->crud_model->get_where_pagination_order_by($this->table, array('status' => '1'), $per_page, $offset, 'id', 'DESC');  
                foreach($items as $key=>$val){
                    $featured_image = '';
                    if($val->DocPath){
                        $featured_image = base_url('uploads/doc/'.$val->DocPath);
                    }
                    
                    //for english
                    $interestEn[$key]['id'] = $val->id;
                    $interestEn[$key]['title'] = $val->Title;
                    $interestEn[$key]['slug'] = $val->slug;
                    $interestEn[$key]['description'] = $val->Description;
                    $interestEn[$key]['doc'] = $featured_image;
                    $interestEn[$key]['created_on'] = $val->created_on;

                    //for neapli
                    $interestNe[$key]['id'] = $val->id;
                    $interestNe[$key]['title'] = $val->TitleNepali;
                    $interestNe[$key]['slug'] = $val->slug;
                    $interestNe[$key]['description'] = $val->DescriptionNepali;
                    $interestNe[$key]['doc'] = $featured_image;
                    $interestNe[$key]['created_on'] = $val->created_on;
                    
                }
                $total = $this->crud_model->count_all($this->table, array('status' => '1'), 'id'); 
                if($items){ 
                    $response=array(
                            'status' => "Success",
                            'status_code' => 200,
                            'status_message' => "Item List",
                            'items' => [
                                'en' => $interestEn,
                                'np' => $interestNe
                                
                            ],
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
                $detail = $this->crud_model->get_where_single_order_by($this->table, array('status'=>'1','slug'=>$slug), 'id', 'DESC'); 
                if(isset($detail->DocPath) && $detail->DocPath !=''){
                    $detail->DocPath = base_url('uploads/doc/'.$detail->DocPath);
                }
                
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
    
    function latest($slug){  
		header('Access-Control-Allow-Method:GET');
        if ($this->request_method != "GET") {
            $response = array(
                'status' => "Error",
                'status_code' => 204,
                'status_message' => "Access Method Not Allowed",
            );
        } else {
            if($slug){
                $detail = $this->crud_model->get_where_single_order_by($this->table, array('status'=>'1'), 'id', 'DESC');  
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
