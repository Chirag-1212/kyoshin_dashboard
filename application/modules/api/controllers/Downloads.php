<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Downloads extends Front_controller
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
        
        $this->table = 'download'; 
        $this->title = 'Downloads';
    }
    
    // function all($page=1)
    // { 
    //     header('Access-Control-Allow-Method:GET');
    //     if ($this->request_method != "GET") {
    //         $response=array(
    //             'status' => "Error",
    //             'status_code' => 204,
    //             'status_message' => "Access Method Not Allowed",
    //         );
    //     } else { 
           
    //         $download_param = [
    //             'status' => '1'
    //         ];
    //         $downloadEn = [];
    //         $downloadNe = []; 
    //         $per_page = 12;
    //         $offset = ($page*$per_page - $per_page); 
    //         $sql = "id,slug,DocPath,description,description_nepali, title,title_nepali, created";
    //         $downloads = $this->crud_model->get_sql_all($this->table,$download_param,'id', 'DESC',$per_page, $offset,$sql);  
    //         // var_dump($this->db->last_query()); die;
    //         foreach($downloads as $key=>$val){
                
    //             $doc = '';
    //             if($val->DocPath){
    //                 $doc = base_url($val->DocPath);
    //             }
    //             //for english
    //             $downloadEn[$key]['id'] = $val->id;
    //             $downloadEn[$key]['title'] = $val->title;
    //             $downloadEn[$key]['slug'] = $val->slug;
    //             $downloadEn[$key]['description'] = $val->description;
    //             $downloadEn[$key]['file'] = $doc;
    //             $downloadEn[$key]['created'] = (new DateTime($val->created))->format('M d, Y');
    //             $downloadEn[$key]['day'] = (new DateTime($val->created))->format('d');
    //             $downloadEn[$key]['month'] = (new DateTime($val->created))->format('F');
    //             // $downloadEn[$key]['published'] = $val->datevalue;
    //             // $downloadEn[$key]['due_date'] = $val->due_date;

    //             //for neapli
    //             $downloadNe[$key]['id'] = $val->id;
    //             $downloadNe[$key]['title'] = $val->title_nepali;
    //             $downloadNe[$key]['slug'] = $val->slug;
    //             $downloadNe[$key]['description'] = $val->description_nepali;
    //             $downloadNe[$key]['file'] = $doc;
    //             $downloadNe[$key]['created'] = (new DateTime($val->created))->format('M d, Y');
    //             $downloadNe[$key]['day'] = (new DateTime($val->created))->format('d');
    //             $downloadNe[$key]['month'] = (new DateTime($val->created))->format('F');
    //             // $downloadNe[$key]['published'] = $val->datevalue;
    //             // $downloadNe[$key]['due_date'] = $val->due_date;
                
    //         }
    //         $downloadstotal = $this->crud_model->count_all($this->table, $download_param, 'id'); 
          
    //         if($downloadstotal){ 
    //             $response=array(
    //                     'status' => "Success",
    //                     'status_code' => 200,
    //                     'status_message' => "Item List",
    //                     'downloads' => [
    //                         'en' =>$downloadEn,
    //                         'np' => $downloadNe
    //                     ],
    //                     'downloads_total' => $downloadstotal,
    //                     'per_page' => $per_page,
    //                 );
    //         }else{
    //             $response=array(
    //                     'status' => "error",
    //                     'status_code' => 208,
    //                     'status_message' => "No Items Found", 
    //                 );
    //         } 
            
    //     } 
    //     $json_response = json_encode($response);
    //     echo $json_response;
    // } 
    
    function all($cat_slug='',$page=0)
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
            $cat_detail = $this->crud_model->get_where_single('download_category', array('slug'=>$cat_slug,'status'=>'1'));
            
            
            $sql_en = "title, DocPath, created, category_id";
            $items_english = $this->crud_model->get_sql_all('download',array('status' => '1', 'category_id' => $cat_detail->id),'id', 'DESC',$per_page, $page,$sql_en);  
        
            foreach($items_english as $key=>$val){
                if($val->DocPath){
                    $items_english[$key]->DocPath = base_url($val->DocPath);
                } 
                $items_english[$key]->created = (new DateTime($val->created))->format('Y-m-d');
            }
            
            $sql_np = "title_nepali as title, DocPath, created, category_id";
            $items_nepali = $this->crud_model->get_sql_all('download',array('status' => '1',  'category_id' => $cat_detail->id),'id', 'DESC',$per_page, $page,$sql_np);  
            foreach($items_nepali as $key=>$val){
                if($val->DocPath){
                    $items_nepali[$key]->DocPath = base_url($val->DocPath);
                } 
                $items_nepali[$key]->created = (new DateTime($val->created))->format('Y-m-d');
            }
             
            $items = array(
                    'en' =>$items_english,
                    'np' => $items_nepali
                );
            $total = $this->crud_model->count_all('download', array('status' => '1', 'category_id' => $cat_detail->id), 'id'); 
            
          
            if($items){ 
                $response=array(
                    'status' => "Success",
                    'status_code' => 200,
                    'status_message' => "Item List",
                    'items' => $items,
                  
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
    
     function category($page=0)
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
            
            $per_page = 200;
             $sql_services = "id, title, title_nepali, slug";
                $getServices = $this->crud_model->getData('download_category', array('status' => '1'),[], $per_page, $page, $sql_services,'serial ASC');
                
                $DisclosureEn = [];
                $DisclosureNe = [];
                foreach($getServices as $key=>$val){
                    //for english
                    $DisclosureEn[$key]['id'] = $val->id;
                    $DisclosureEn[$key]['title'] = $val->title;
                    $DisclosureEn[$key]['slug'] = $val->slug;
                    //for neapli
                    $DisclosureNe[$key]['id'] = $val->id;
                    $DisclosureNe[$key]['title'] = $val->title_nepali;
                    $DisclosureNe[$key]['slug'] = $val->slug;
                }
                
                $Disclosures = array(
                    'en' =>$DisclosureEn,
                    'np' => $DisclosureNe
                );
                
              
            if($Disclosures){ 
                $response=array(
                    'status' => "Success",
                    'status_code' => 200,
                    'status_message' => "Item List",
                    'all_categories'=>$Disclosures,
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
            $getdata = json_decode(file_get_contents("php://input")); 
            // var_dump($getdata, );exit;
            $param = array('status' => '1');
            if($_GET['title']){
                $categoryIds = array_unique(array_filter(array_column($this->crud_model->getData('download', array_merge($param), ['title' => $_GET['title']], 1000, 0, 'category_id', 'id DESC'), 'category_id')));
                
            }
            
            $downloadEn = [];
            $downloadNe = [];
            $sql_cat = "id, title, title_nepali";
            $items = $this->crud_model->getAllData('download_category',$param,$categoryIds, 'id', 1000, 0, $sql_cat,'serial ASC');  
            $items_new = array();
            
            foreach($items as $key1=>$val1){
                $downloadEn[$key1]['id'] = $val1->id;
                $downloadEn[$key1]['cat_title'] = $val1->title;

                $downloadNe[$key1]['id'] = $val1->id;
                $downloadNe[$key1]['cat_title'] = $val1->title_nepali?:'';
                $sql_en = "id,DocPath,title_nepali, title, created, category_id";
                $downloads_english = $this->crud_model->get_sql_all('download',array('status' => '1', 'category_id' => $val1->id),'Serial', 'ASC',1000, 0,$sql_en);  
                $childEn = [];
                $childNe = [];
                foreach($downloads_english as $key=>$val){
                    $doc = '';
                    if($val->DocPath){
                        $doc = base_url('uploads/doc/'.$val->DocPath);
                    } 
                    $childEn[$key]['id'] = $val->id;
                    $childEn[$key]['title'] = $val->title;
                    $childEn[$key]['category_id'] = $val->category_id;
                    $childEn[$key]['cat_title'] = $val->title;
                    $childEn[$key]['doc'] = $doc;

                    $childNe[$key]['id'] = $val->id;
                    $childNe[$key]['title'] = $val->title_nepali;
                    $childNe[$key]['category_id'] = $val->category_id;
                    $childNe[$key]['cat_title'] = $val->title_nepali;
                    $childNe[$key]['doc'] = $doc;
                } 
                $downloadEn[$key1]['child'] = $childEn;
                $downloadNe[$key1]['child'] = $childNe;
            }
            
            
            $response = array(
                'status' => "success",
                'status_code' => 200,
                'status_message' => "Data Retreived Successfully",
                'downloads_category' => [
                    'en' =>$downloadEn,
                    'np' => $downloadNe
                ], 
            );
        }
        
        $json_response = json_encode($response);
        echo $json_response;
    } 
}