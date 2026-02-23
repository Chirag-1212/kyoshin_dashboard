<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Fiscal_year_wise_interest extends Front_controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
//baserate page
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
        $this->table = 'interest_rate_fiscal';  
       
    } 
    function index()
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
                $items = $this->crud_model->get_where_order_by('fiscal_year', array('status' => '1'), 'title', 'DESC'); 
                // $interest_rates = array('');
                foreach($items as $key=>$val){
                    $sql_en = "id, Title as title,Description, slug, DocPath";
                    $getEnglish = $this->crud_model->getData($this->table, array('status' => '1','fiscal_id' => $val->id),[], 1000, 0,$sql_en,'id DESC'); 
                    if (!empty($getEnglish)) {
                        $en = $getEnglish[0];
                        $en->doc = isset($en->DocPath) ? base_url() . $en->DocPath : '';
                    }
                    // foreach($getEnglish as $keyEn=>$en){
                    //      $getEnglish[$keyEn]->doc = isset($en->DocPath)?base_url().$en->DocPath:'';
                    // }
                    $sql_ne = "id, TitleNepali as title,DescriptionNepali as Description, slug, DocPath";
                    $getNeapli = $this->crud_model->getData($this->table, array('status' => '1','fiscal_id' => $val->id),[], 1000, 0,$sql_ne,'id DESC'); 
                    if (!empty($getNeapli)) {
                        $nep = $getNeapli[0];
                        $nep->doc = isset($nep->DocPath) ? base_url() . $nep->DocPath : '';
                    }
                   if($getEnglish){
                        $interestEn[$key]['id'] = $val->id;
                        $interestEn[$key]['title'] = $val->title;
                        $interestEn[$key]['slug'] = $val->slug;
                        $interestEn[$key]['interest_rates'] = !empty($getEnglish) ? $en : null;
                    }
                    if($getNeapli){
                        $interestNe[$key]['id'] = $val->id;
                        $interestNe[$key]['title'] = $val->title_nepali;
                        $interestNe[$key]['slug'] = $val->slug;
                        $interestNe[$key]['interest_rates'] = !empty($getNeapli) ? $nep : null;
                    }
                    //for english
                    // $interestEn[$key]['id'] = $val->id;
                    // $interestEn[$key]['title'] = $val->title;
                    // $interestEn[$key]['interest_rates'] = !empty($getEnglish) ? $en : null;
                    // $interestEn[$key]['interest_rates'] =  $getEnglish;

                    //for neapli
                    // $interestNe[$key]['id'] = $val->id;
                    // $interestNe[$key]['title'] = $val->title_nepali;
                    // $interestNe[$key]['interest_rates'] = !empty($getNeapli) ? $nep : null;
                    // $interestNe[$key]['interest_rates'] = $getNeapli;
                } 
                if($items){ 
                    $response=array(
                        'status' => "Success",
                        'status_code' => 200,
                        'status_message' => "Item List",
                        'items' => [
                            'en' => $interestEn,
                            'np' => $interestNe
                        ],  
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
    
    function index2()
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
                $items = $this->crud_model->get_where_order_by('fiscal_year', array('status' => '1'), 'title', 'DESC');
                // $interest_rates = array('');
                foreach($items as $key=>$val){
                    $sql_en = "id, Title as title,Description, slug, DocPath";
                    $getEnglish = $this->crud_model->getDataArray($this->table, array('status' => '1','fiscal_id' => $val->id), $sql_en);
                    foreach($getEnglish as $keyEn=>$en){
                        if(isset($en['DocPath']) && $en['DocPath'] !=''){
                            $getEnglish[$keyEn]['doc'] = base_url('uploads/doc/'.$en['DocPath']);
                        }
                        
                    }
                    $sql_ne = "id, TitleNepali as title,DescriptionNepali, slug, DocPath";
                    $getNeapli = $this->crud_model->getDataArray($this->table, array('status' => '1','fiscal_id' => $val->id), $sql_ne);
                    foreach($getNeapli as $keyNep=>$nep){
                        if(isset($nep['DocPath']) && $nep['DocPath'] !=''){
                            $getNeapli[$keyNep]['doc'] = base_url('uploads/doc/'.$nep['DocPath']);
                        }
                        
                    }
                    //for english
                    $interestEn[$key]['id'] = $val->id;
                    $interestEn[$key]['title'] = $val->title;
                    $interestEn[$key]['interest_rates'] =  $getEnglish;

                    //for neapli
                    $interestNe[$key]['id'] = $val->id;
                    $interestNe[$key]['title'] = $val->title_nepali;
                    $interestNe[$key]['interest_rates'] = $getNeapli;
                } 
                if($items){ 
                    $response=array(
                        'status' => "Success",
                        'status_code' => 200,
                        'status_message' => "Item List",
                        'items' => [
                            'en' => $interestEn,
                            'np' => $interestNe
                        ],  
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
