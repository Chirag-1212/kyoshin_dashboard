<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Content extends Front_controller
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
        $this->table = 'content'; 
        $this->title = 'Content';
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
                
    //             $sql_en = "DocPath, CoverImage, Title, created_on, slug";
    //             $items_english = $this->crud_model->get_sql_all('news',array('status' => '1'),'id', 'DESC',$per_page, $offset,$sql_en);  
    //             foreach($items_english as $key=>$val){
    //                 if($val->DocPath){
    //                     $items_english[$key]->DocPath = base_url('uploads/doc/'.$val->DocPath);
    //                 }
    //                  if($val->CoverImage){
    //                     $items_english[$key]->CoverImage = base_url('uploads/doc/'.$val->CoverImage);
    //                 }
    //             }
                
    //             $sql_np = "DocPath, CoverImage, TitleNepali as Title, created_on, slug";
    //             $items_nepali = $this->crud_model->get_sql_all('news',array('status' => '1'),'id', 'DESC',$per_page, $offset,$sql_np);  
    //             foreach($items_nepali as $key=>$val){
    //                 if($val->DocPath){
    //                     $items_nepali[$key]->DocPath = base_url('uploads/doc/'.$val->DocPath);
    //                 }
    //                  if($val->CoverImage){
    //                     $items_nepali[$key]->CoverImage = base_url('uploads/doc/'.$val->CoverImage);
    //                 }
    //             }
                 
    //             $items = array(
    //                 'en' =>$items_english,
    //                 'np' => $items_nepali
    //                 );
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
                $category = $this->crud_model->get_sql_single('content',array('status' => '1', 'slug' => $slug),'id', 'DESC','id');
                
                $items_english = [];
                $items_nepali = [];
                if($category){
                    $sql_en = "PageTitle as Title, Description as description, CoverImage, created_on";
                    $items_english = $this->crud_model->get_sql_single('content', array('status' => '1', 'parent_id' => $category->id), 'id', 'DESC',$sql_en);  
                    
                    $sql_np = "PageTitleNepali as Title, DescriptionNepali as description, CoverImage, created_on";
                    $items_nepali = $this->crud_model->get_sql_single('content', array('status' => '1', 'parent_id' => $category->id), 'id', 'DESC',$sql_np); 
                    if($items_english->CoverImage){
                        $items_english->CoverImage = base_url($items_english->CoverImage);
                    } 
                    if($items_nepali->CoverImage){
                        $items_nepali->CoverImage = base_url($items_nepali->CoverImage);
                    } 
                }
                 
                
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
    
    function singledetail($slug)
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
            
                $items_english = [];
                $items_nepali = [];
                   $sql_en = "PageTitle as Title, Description as description, CoverImage, created_on";
                    $items_english = $this->crud_model->get_sql_single('content', array('status' => '1', 'slug' =>$slug), 'id', 'DESC',$sql_en);  
                         
                    $sql_np = "PageTitleNepali as Title, DescriptionNepali as description, CoverImage, created_on";
                    $items_nepali = $this->crud_model->get_sql_single('content', array('status' => '1', 'slug' =>$slug), 'id', 'DESC',$sql_np); 
                    $items_english->CoverImage = base_url().$items_english->CoverImage;
                    $items_nepali->CoverImage = base_url().$items_nepali->CoverImage;
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