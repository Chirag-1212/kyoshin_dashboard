<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Rates extends Front_controller
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
        $this->table = 'rates_category'; 
        $this->title = 'Rates';
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
                $sql_rates = "id, TitleNepali, Title, slug";
                $getrates = $this->crud_model->getData($this->table, $this->param, $per_page, $offset, $sql_rates);
                
                $categoryEn = [];
                $categoryNe = [];
                foreach($getrates as $key=>$val){
                    //for english
                    $categoryEn[$key]['id'] = $val->id;
                    $categoryEn[$key]['title'] = $val->Title;
                    $categoryEn[$key]['slug'] = $val->slug;

                    //for neapli
                    $categoryNe[$key]['id'] = $val->id;
                    $categoryNe[$key]['title'] = $val->TitleNepali;
                    $categoryNe[$key]['slug'] = $val->slug;
                }
                
                $sql_rates = "id, TitleNepali, DescriptionNepali, Title, Description, slug,DocPath, datevalue";
                $ratesEn = [];
                $ratesNe = [];
                $detail = $this->crud_model->getDetail('rates', array('slug'=>$slug, 'status'=>['1','3']), $sql_rates); 
            
                if($detail){
                    $doc = '';
                if($detail->DocPath){
                    $doc = base_url($detail->DocPath);
                }
                //for english
                $ratesEn['id'] = $detail->id;
                $ratesEn['title'] = $detail->Title;
                $ratesEn['slug'] = $detail->slug;
                $ratesEn['description'] = $detail->Description;
                $ratesEn['doc'] = $doc;
                $ratesEn['publish_date'] = $detail->datevalue;

                //for neapli
                $ratesNe['id'] = $detail->id;
                $ratesNe['title'] = $detail->TitleNepali;
                $ratesNe['slug'] = $detail->slug;
                $ratesNe['description'] = $detail->DescriptionNepali;
                $ratesNe['doc'] = $doc;
                $ratesNe['publish_date'] = $detail->datevalue;
                }
                
                if(!empty($detail)){
                    $response = array(
                        'status' => "success",
                        'status_code' => 200,
                        'status_message' => "Data Retreived Successfully",
                        'detail' => [
                            'en' => $ratesEn,
                            'ne' => $ratesNe
                        ],
                        'category' => [
                            'en' => $categoryEn,
                            'ne' => $categoryNe
                        ],
                        
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
    
    public function category(){ 
        header('Access-Control-Allow-Method:GET');
        if ($this->request_method != "GET") {
            $response=array(
                'status' => "Error",
                'status_code' => 204,
                'status_message' => "Access Method Not Allowed",
            );
        } else { 
                
                $mainrates_category_en = [];
                $mainrates_category_ne = [];
                $sql_en_type = "id,PageTitle, PageTitleNepali, DocPath,slug,parent_id";
                $main_category_detail=$this->crud_model->get_sql_all('rates_category', array('status' => '1','parent_id'=>'0'),'rank','ASC', 1000, 0, $sql_en_type); 
          
                 foreach($main_category_detail as $key=>$val){
                    $doc = '';
                    if($val->DocPath){
                        $doc = base_url($val->DocPath);
                    }
                    $rates_category_en[$key]=['id' => $val->id, 'title' => $val->PageTitle,'slug'=>$val->slug,'doc'=>$doc];
                     
                    $childs=$this->crud_model->get_sql_all('rates_category', array('status' => '1','parent_id'=>$val->id),'rank','ASC', 1000, 0, $sql_en_type);
                     if (!empty($childs)) {
                         $rates_category_en[$key]['child']  =  $this->get_childs_en($childs);
                    }
                    
                    $rates_category_ne[$key]=['id' => $val->id, 'title' => $val->PageTitleNepali,'slug'=>$val->slug,'doc'=>$doc];
                     
                    $childs=$this->crud_model->get_sql_all('rates_category', array('status' => '1','parent_id'=>$val->id),'rank','ASC', 1000, 0, $sql_en_type);
                     if (!empty($childs)) {
                         $rates_category_ne[$key]['child']  =  $this->get_childs_ne($childs);
                    }
                 
                 }
                        
                if($main_category_detail){ 
                    $response=array(
                        'status' => "Success",
                        'status_code' => 200,
                        'status_message' => "Item List",
                       
                        'rates_category' => [
                            'en' => $rates_category_en,
                            'ne' => $rates_category_ne
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
    
    public function get_childs_en($childs = array())
    {
        $sql_en = "id,PageTitle, PageTitleNepali, DocPath,slug,parent_id";
        $rates_category_ne = [];
        if (!empty($childs)) {
            foreach ($childs as $key => $value) {
                $new_childs = $this->crud_model->get_sql_all('rates_category', array('status' => '1','parent_id'=>$value->id),'rank','ASC', 1000, 0, $sql_en);
               
              
               // $new_childs = $this->crud_model->getAllData('rates_category', array_merge($this->param,['parent_id' => $value->id]), ['MAIN', 'BOTH'],'show_type',0, 0,$sql_en, 'rank ASC');  
                $rates_category_ne[$key]  = ['id' => $value->id, 'title' => $value->PageTitle, 'slug' => $value->slug,];
                if (!empty($new_childs)) {
                    $rates_category_ne[$key]['child']  = $this->get_childs_ne($new_childs);
                }
            }
        }
        return $rates_category_ne;
    }
    
    
    public function get_childs_ne($childs = array())
    {
        
        $sql_en = "id,PageTitle, PageTitleNepali, DocPath,slug,parent_id";
        $rates_category_en = [];
        if (!empty($childs)) {
            foreach ($childs as $key => $value) {
                $new_childs = $this->crud_model->get_sql_all('rates_category', array('status' => '1','parent_id'=>$value->id),'rank','ASC', 1000, 0, $sql_en);
                // $new_childs = $this->crud_model->getAllData('rates_category', array_merge($this->param,['parent_id' => $value->id]), ['MAIN', 'BOTH'],'show_type',0, 0,$sql_en, 'rank ASC');  
                $rates_category_en[$key]  = ['id' => $value->id, 'title' => $value->PageTitleNepali, 'slug' => $value->slug,];
                if (!empty($new_childs)) {
                    $rates_category_en[$key]['child']  = $this->get_childs_ne($new_childs);
                }
            }
        }
        return $rates_category_en;
    }
    
    
    // function index()
    // {
    //     header('Access-Control-Allow-Method:GET');
    //     if ($this->request_method != "GET") {
    //         $response = array(
    //             'status' => "Error",
    //             'status_code' => 204,
    //             'status_message' => "Access Method Not Allowed",
    //         );
    //     } else { 
    //         $getdata = json_decode(file_get_contents("php://input")); 
    //         // var_dump($getdata, );exit;
    //         $param = array('status' => '1');
    //         if($_GET['title']){
    //             $categoryIds = array_unique(array_filter(array_column($this->crud_model->getData('rates', array_merge($param), ['title' => $_GET['title']], 1000, 0, 'category_id', 'id DESC'), 'category_id')));
                
    //         }
          
    //         $downloadEn = [];
    //         $downloadNe = [];
    //         $sql_cat = "id, title, title_nepali";
    //         $items = $this->crud_model->getAllData('download_category',$param,$categoryIds, 'id', 1000, 0, $sql_cat,'serial ASC');  
    //         $items_new = array();
            
    //         foreach($items as $key1=>$val1){
    //             $downloadEn[$key1]['id'] = $val1->id;
    //             $downloadEn[$key1]['cat_title'] = $val1->title;

    //             $downloadNe[$key1]['id'] = $val1->id;
    //             $downloadNe[$key1]['cat_title'] = $val1->title_nepali?:'';
    //             $sql_en = "id,DocPath,title_nepali, title, created, category_id";
    //             $downloads_english = $this->crud_model->get_sql_all('download',array('status' => '1', 'category_id' => $val1->id),'Serial', 'ASC',1000, 0,$sql_en);  
    //             $childEn = [];
    //             $childNe = [];
    //             foreach($downloads_english as $key=>$val){
    //                 $doc = '';
    //                 if($val->DocPath){
    //                     $doc = base_url('uploads/doc/'.$val->DocPath);
    //                 } 
    //                 $childEn[$key]['id'] = $val->id;
    //                 $childEn[$key]['title'] = $val->title;
    //                 $childEn[$key]['category_id'] = $val->category_id;
    //                 $childEn[$key]['cat_title'] = $val->title;
    //                 $childEn[$key]['doc'] = $doc;

    //                 $childNe[$key]['id'] = $val->id;
    //                 $childNe[$key]['title'] = $val->title_nepali;
    //                 $childNe[$key]['category_id'] = $val->category_id;
    //                 $childNe[$key]['cat_title'] = $val->title_nepali;
    //                 $childNe[$key]['doc'] = $doc;
    //             } 
    //             $downloadEn[$key1]['child'] = $childEn;
    //             $downloadNe[$key1]['child'] = $childNe;
    //         }
            
            
    //         $response = array(
    //             'status' => "success",
    //             'status_code' => 200,
    //             'status_message' => "Data Retreived Successfully",
    //             'downloads_category' => [
    //                 'en' =>$downloadEn,
    //                 'np' => $downloadNe
    //             ], 
    //         );
    //     }
        
    //     $json_response = json_encode($response);
    //     echo $json_response;
    // } 
    
    
    function all($cat_slug='',$page=0)
    { 
        header('Access-Control-Allow-Method:GET');
        if ($this->request_method != "GET") {
            $response=array(
                'status' => "Error",
                'status_code' => 204,
                'status_message' => "Access Method Not Allowed",
            );
        } else {  
            if(!$cat_slug){
               $response=array(
                    'status' => "error",
                    'status_code' => 208,
                    'status_message' => "Category slug is required", 
                ); 
                $json_response = json_encode($response);
                echo $json_response;exit;
            }
            $per_page = 200;
            $cat_detail = $this->crud_model->get_where_single('rates_category', array('slug'=>$cat_slug,'status'=>'1'));
            
            
           
            $sql_en = "Title as title,slug,Description, DocPath, created_on,datevalue, category_id";
            $items_english = $this->crud_model->get_sql_allIN('rates',array('status' => ['1','3'], 'category_id' => $cat_detail->id),'id', 'DESC',$per_page, $page,$sql_en);  
       
            foreach($items_english as $key=>$val){
                if($val->DocPath){
                    $items_english[$key]->DocPath = base_url($val->DocPath);
                } 
                $items_english[$key]->publish_date = (new DateTime($val->datevalue))->format('Y-m-d');
            }
            
            $sql_np = "TitleNepali as title,slug,DescriptionNepali, DocPath, created_on,datevalue, category_id";
            $items_nepali = $this->crud_model->get_sql_allIN('rates',array('status' => ['1','3'],  'category_id' => $cat_detail->id),'id', 'DESC',$per_page, $offset,$sql_np);  
            foreach($items_nepali as $key=>$val){
                if($val->DocPath){
                    $items_nepali[$key]->DocPath = base_url($val->DocPath);
                } 
                $items_nepali[$key]->publish_date = (new DateTime($val->datevalue))->format('Y-m-d');
            }
             
            $items = array(
                    'en' =>$items_english,
                    'np' => $items_nepali
                );
            $total = $this->crud_model->count_all('rates', array('status' => '1', 'category_id' => $cat_detail->id), 'id'); 
            
             $sql_services = "id, PageTitleNepali, PageTitle, slug,parent_id";
              
                $getServices = $this->crud_model->getData($this->table, array('status' => '1'), $per_page, $offset, $sql_services);
                
                $ratesEn = [];
                $ratesNe = [];
                foreach($getServices as $key=>$val){
                    //for english
                    $ratesEn[$key]['id'] = $val->id;
                    $ratesEn[$key]['title'] = $val->PageTitle;
                    $ratesEn[$key]['slug'] = $val->slug;

                    //for neapli
                    $ratesNe[$key]['id'] = $val->id;
                    $ratesNe[$key]['title'] = $val->PageTitleNepali;
                    $ratesNe[$key]['slug'] = $val->slug;
                }
                
                $rates_category = array(
                    'en' =>$ratesEn,
                    'np' => $ratesNe
                );
                
                // $fiscal_years = $this->crud_model->get_where_order_by('interest_rate_categories', array('status' => '1'), 'title', 'DESC');
                // if($fiscal_years){
                //         $fiscal_yearEn = [];
                //         $fiscal_yearNe = [];
                //         foreach($fiscal_years as $key=>$fy){
                //             //for english
                //             $fiscal_yearEn[$key]['id'] = $fy->id;
                //             $fiscal_yearEn[$key]['title'] = $fy->title;
        
                //             //for neapli
                //             $fiscal_yearNe[$key]['id'] = $fy->id;
                //             $fiscal_yearNe[$key]['title'] = $fy->title_nepali;
                //         }
                        
                //         $FY = array(
                //             'en' =>$fiscal_yearEn,
                //             'np' => $fiscal_yearNe
                //         );
                // }
            if($items){ 
                $response=array(
                    'status' => "Success",
                    'status_code' => 200,
                    'status_message' => "Item List",
                    'items' => $items,
                    'rates_category'=>$rates_category,
                    // 'FY'=>$FY,
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
}
