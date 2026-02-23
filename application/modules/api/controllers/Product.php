<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Product extends Front_controller
{
    protected $table;
    protected $limit;
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
        $this->table = 'products'; 
        $this->limit = 20;
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
                $sql_en = "id, DocPath, featured_image, product_cat, Description as Description, title, created, slug";
                $items_english = $this->crud_model->get_sql_all($this->table,array('status' => '1'),'id', 'DESC',$this->limit, $page,$sql_en);  
                foreach($items_english as $key=>$val){
                    if($val->DocPath){
                        $items_english[$key]->DocPath = base_url('uploads/doc/'.$val->DocPath);
                    }
                     if($val->featured_image){
                        $items_english[$key]->featured_image = base_url('uploads/doc/'.$val->featured_image);
                    }
                    if($val->product_cat){
                        $cat_detail = $this->crud_model->get_where_single_order_by('product_category', array('status'=>'1','id'=>$val->product_cat), 'id', 'DESC');
                        if(isset($cat_detail->title)){
                            $items_english[$key]->cat_name = $cat_detail->title;
                        }else{
                            $items_english[$key]->cat_name = '';
                        }
                    }else{
                        $items_english[$key]->cat_name = '';
                    }
                }
                
                $sql_np = "id,DocPath, featured_image, product_cat, DescriptionNepali as Description, title_nepali as Title, created, slug";
                $items_nepali = $this->crud_model->get_sql_all($this->table,array('status' => '1'),'id', 'DESC',$this->limit, $page,$sql_np);  
                foreach($items_nepali as $key=>$val){
                    if($val->DocPath){
                        $items_nepali[$key]->DocPath = base_url('uploads/doc/'.$val->DocPath);
                    }
                     if($val->featured_image){
                        $items_nepali[$key]->featured_image = base_url('uploads/doc/'.$val->featured_image);
                    }
                    
                    if($val->product_cat){
                        $cat_detail = $this->crud_model->get_where_single_order_by('product_category', array('status'=>'1','id'=>$val->product_cat), 'id', 'DESC');
                        if(isset($cat_detail->title_nepali)){
                            $items_nepali[$key]->cat_name = $cat_detail->title_nepali;
                        }else{
                            $items_nepali[$key]->cat_name = '';
                        }
                    }else{
                        $items_nepali[$key]->cat_name = '';
                    }
                }
                 
                $items = array(
                    'en' =>$items_english,
                    'np' => $items_nepali
                    );
                    
                // $items = $this->crud_model->get_where_pagination_order_by($this->table, array('status' => '1'), $per_page, $offset, 'id', 'DESC');  
                // foreach($items as $key=>$val){
                //     $items[$key]->DocPath = base_url('uploads/doc/'.$val->DocPath);
                // }
                $total = $this->crud_model->count_all($this->table, array('status' => '1'), 'id'); 
                if($items){ 
                    $response=array(
                            'status' => "Success",
                            'status_code' => 200,
                            'status_message' => "Item List",
                            'items' => $items,
                            'total' => $total,
                            'per_page' => $page,
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
                $detailEn = [];
                $detailNe = [];
                $detail = $this->crud_model->get_where_single_order_by($this->table, array('status'=>'1','slug'=>$slug), 'id', 'DESC'); 
                
                if($detail){
                    $file = '';
                    if($detail->DocPath){
                        $file = base_url('uploads/doc/'.$detail->DocPath);
                    }
                    $detailEn['id'] = $detail->id;
                    $detailEn['title'] = $detail->title;
                    $detailEn['slug'] = $detail->slug;
                    $detailEn['description'] = $detail->Description;
                    $detailEn['image'] = $file;
                    
                    $detailNe['id'] = $detail->id;
                    $detailNe['title'] = $detail->title_nepali;
                    $detailNe['slug'] = $detail->slug;
                    $detailNe['description'] = $detail->DescriptionNepali;
                    $detailNe['image'] = $file;
                    
                }
                $catNe = [];
                $catEn = [];
                $sql_en = "id, title_nepali, title, slug";
                $items = $this->crud_model->get_sql_all($this->table,array('status' => '1'),'id', 'DESC',100, 0,$sql_en);  
                foreach($items as $key=>$val){
                    $catEn[$key]['id'] = $val->id;
                    $catEn[$key]['title'] = $val->title;
                    $catEn[$key]['slug'] = $val->slug;
                    
                    $catNe[$key]['id'] = $val->id;
                    $catNe[$key]['title'] = $val->title_nepali;
                    $catNe[$key]['slug'] = $val->slug;
                }
                
                if(!empty($detail)){
                    $response = array(
                        'status' => "success",
                        'status_code' => 200,
                        'status_message' => "Data Retreived Successfully",
                        'detail' => [
                            'en' => $detailEn,
                            'np' => $detailEn,
                        ], 
                        'category' => [
                            'np' => $catNe,
                            'en' => $catEn
                        ]
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
    
    function details($slug){  
		header('Access-Control-Allow-Method:GET');
        if ($this->request_method != "GET") {
            $response = array(
                'status' => "Error",
                'status_code' => 204,
                'status_message' => "Access Method Not Allowed",
            );
        } else {
            if($slug){
                $detail = $this->crud_model->get_where_single_order_by('services', array('Disabled'=>0,'PageName'=>$slug), 'id', 'DESC');  
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
