<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Service extends Front_controller
{
    protected $param;
    protected $table;
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
        $this->table = 'services';  
        $this->param = ['status' => '1'];
    }
    
    // function all($page=1, $id = '')
    // { 
    //     header('Access-Control-Allow-Method:GET');
    //     if ($this->request_method != "GET") {
    //         $response=array(
    //             'status' => "Error",
    //             'status_code' => 204,
    //             'status_message' => "Access Method Not Allowed",
    //         );
    //     } else { 
                
              
    //             if($id){
    //               $this->param['service_category_id'] = $id;
    //             }
    //             $page = $this->input->get('offset');
    //             $page= isset($_GET['offset'])?intval($_GET['offset']):1;
    //             $offset = ($page*$per_page - $per_page); 
    //             // $per_page = 10;
    //             // $offset = ($page*$per_page - $per_page); 
    //             $sql_services = "id, TitleNepali, DescriptionNepali, Title, Description, slug, Link, CoverImage, DocPath, Image, datevalue";
    //             // $getServices = $this->crud_model->getData($this->table, $this->param, $per_page, $offset, $sql_services);
    //             $getServices = $this->crud_model->getData($this->table, $this->param, $page, $offset, $sql_services);
    //             $servicesEn = [];
    //             $servicesNe = [];
    //             foreach($getServices as $key=>$val){
    //                 $doc = '';
    //                 if($val->DocPath){
    //                     $doc = base_url($val->DocPath);
    //                 }

    //                 $image = '';
    //                 if($val->Image){
    //                     $image = base_url($val->Image);
    //                 }
                    
    //                 $coverImage = '';
    //                 if($val->CoverImage){
    //                     $coverImage = base_url($val->CoverImage);
    //                 }
                    
    //                 $service_category_name_en = '';
    //                 $service_category_name_ne = '';
    //                 if($val->service_category_id){
    //                      $sql_en_type = "id,Title, TitleNepali, slug";
    //                      $service_category_detail=$this->crud_model->get_sql_single('service_category', array('status' => '1', 'id' =>$val->service_category_id), 'serial', 'DESC',$sql_en_type); 
    //                     $service_category_name_en = $service_category_detail->Title;
    //                     $service_category_name_ne = $service_category_detail->TitleNepali;
    //                 } 
                    
    //                 //for english
    //                 $servicesEn[$key]['id'] = $val->id;
    //                 $servicesEn[$key]['title'] = $val->Title;
    //                 $servicesEn[$key]['slug'] = $val->slug;
    //                 $servicesEn[$key]['service_category_name'] = $service_category_name_en;
    //                 $servicesEn[$key]['Link'] = $val->Link;
    //                 $servicesEn[$key]['description'] = $val->Description;
    //                 $servicesEn[$key]['doc'] = $doc;
    //                 $servicesEn[$key]['cover_image'] = $coverImage;
    //                 $servicesEn[$key]['image'] = $image;
    //                 $servicesEn[$key]['publish_date'] = $val->datevalue;

    //                 //for neapli
    //                 $servicesNe[$key]['id'] = $val->id;
    //                 $servicesNe[$key]['title'] = $val->Title;
    //                 $servicesNe[$key]['slug'] = $val->slug;
    //                 $servicesNe[$key]['service_category_name'] = $service_category_name_en;
    //                 $servicesNe[$key]['Link'] = $val->Link;
    //                 $servicesNe[$key]['description'] = $val->Description;
    //                 $servicesNe[$key]['doc'] = $doc;
    //                 $servicesNe[$key]['cover_image'] = $coverImage;
    //                 $servicesNe[$key]['image'] = $image;
    //                 $servicesNe[$key]['publish_date'] = $val->datevalue;
                    

    //             }

    //             $total = $this->crud_model->count_all($this->table, $this->param, 'id'); 
    //             $mainservice_category_en = [];
    //             $mainservice_category_ne = [];
    //             $sql_en_type = "id,Title, TitleNepali, DocPath,slug,parent_id";
    //             $main_category_detail=$this->crud_model->get_sql_all('service_category', array('status' => '1','parent_id'=>'0'),'serial','ASC', 1000, 0, $sql_en_type); 
          
    //              foreach($main_category_detail as $key=>$val){
    //                 $doc = '';
    //                 if($val->DocPath){
    //                     $doc = base_url($val->DocPath);
    //                 }
    //                 $service_category_en[$key]=['id' => $val->id, 'title' => $val->Title,'slug'=>$val->slug,'doc'=>$doc];
                     
    //                 $childs=$this->crud_model->get_sql_all('service_category', array('status' => '1','parent_id'=>$val->id),'serial','ASC', 1000, 0, $sql_en_type);
    //                  if (!empty($childs)) {
    //                      $service_category_en[$key]['child']  =  $this->get_childs_en($childs);
    //                 }
                    
    //                 $service_category_ne[$key]=['id' => $val->id, 'title' => $val->TitleNepali,'slug'=>$val->slug,'doc'=>$doc];
                     
    //                 $childs=$this->crud_model->get_sql_all('service_category', array('status' => '1','parent_id'=>$val->id),'serial','ASC', 1000, 0, $sql_en_type);
    //                  if (!empty($childs)) {
    //                      $service_category_ne[$key]['child']  =  $this->get_childs_ne($childs);
    //                 }
                 
                        
    //                  //for english
    //                 // $service_category_en[$key]['id'] = $val->id;
    //                 // $service_category_en[$key]['title'] = $val->Title;
    //                 // $service_category_en[$key]['slug'] = $val->slug;
    //                 // $service_category_en[$key]['doc'] = $doc;
                    
    //                 // //for nepali
    //                 // $service_category_ne[$key]['id'] = $val->id;
    //                 // $service_category_ne[$key]['title'] = $val->TitleNepali;
    //                 // $service_category_ne[$key]['slug'] = $val->slug;
    //                 // $service_category_ne[$key]['doc'] = $doc;
    //              }
                  
                        
    //             if($total){ 
    //                 $response=array(
    //                     'status' => "Success",
    //                     'status_code' => 200,
    //                     'status_message' => "Item List",
    //                     'items' => [
    //                         'en' => $servicesEn,
    //                         'np' => $servicesNe
    //                     ],
    //                     'service_category' => [
    //                         'en' => $service_category_en,
    //                         'np' => $service_category_ne
    //                     ],
    //                     'total' => $total,
    //                     'per_page' => $per_page,
    //                 );
    //             }else{
    //                 $response=array(
    //                     'status' => "error",
    //                     'status_code' => 208,
    //                     'status_message' => "No Items Found", 
    //                 );
    //             } 
            
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
                $cat_detail = $this->crud_model->get_where_single('service_category', array('slug'=>$cat_slug,'status'=>'1'));
                $sql_services = "id, TitleNepali, DescriptionNepali, Title, Description, slug, Link, CoverImage, DocPath, Image, datevalue";
                // $getServices = $this->crud_model->get_sql_all('report',array('status' => '1', 'service_category_id' => $cat_detail->id),'id', 'DESC',$per_page, $page,$sql_services);
                $getServices = $this->crud_model->getData($this->table, array('status' => '1', 'service_category_id' => $cat_detail->id), $per_page, $offset, $sql_services);
                $servicesEn = [];
                $servicesNe = [];
                foreach($getServices as $key=>$val){
                    $doc = '';
                    if($val->DocPath){
                        $doc = base_url($val->DocPath);
                    }

                    $image = '';
                    if($val->Image){
                        $image = base_url($val->Image);
                    }
                    
                    $coverImage = '';
                    if($val->CoverImage){
                        $coverImage = base_url($val->CoverImage);
                    }
                    
                    $service_category_name_en = '';
                    $service_category_name_ne = '';
                    if($val->service_category_id){
                         $sql_en_type = "id,Title, TitleNepali, slug";
                         $service_category_detail=$this->crud_model->get_sql_single('service_category', array('status' => '1', 'id' =>$val->service_category_id), 'serial', 'Asc',$sql_en_type); 
                        $service_category_name_en = $service_category_detail->Title;
                        $service_category_name_ne = $service_category_detail->TitleNepali;
                    } 
                    
                    //for english
                    $servicesEn[$key]['id'] = $val->id;
                    $servicesEn[$key]['title'] = $val->Title;
                    $servicesEn[$key]['slug'] = $val->slug;
                    $servicesEn[$key]['service_category_name'] = $service_category_name_en;
                    $servicesEn[$key]['Link'] = $val->Link;
                    $servicesEn[$key]['description'] = $val->Description;
                    $servicesEn[$key]['doc'] = $doc;
                    $servicesEn[$key]['cover_image'] = $coverImage;
                    $servicesEn[$key]['image'] = $image;
                    $servicesEn[$key]['publish_date'] = $val->datevalue;

                    //for neapli
                    $servicesNe[$key]['id'] = $val->id;
                    $servicesNe[$key]['title'] = $val->TitleNepali;
                    $servicesNe[$key]['slug'] = $val->slug;
                    $servicesNe[$key]['service_category_name'] = $service_category_name_en;
                    $servicesNe[$key]['Link'] = $val->Link;
                    $servicesNe[$key]['description'] = $val->DescriptionNepali;
                    $servicesNe[$key]['doc'] = $doc;
                    $servicesNe[$key]['cover_image'] = $coverImage;
                    $servicesNe[$key]['image'] = $image;
                    $servicesNe[$key]['publish_date'] = $val->datevalue;
                    

                }

                $total = $this->crud_model->count_all($this->table, $this->param, 'id'); 
                $mainservice_category_en = [];
                $mainservice_category_ne = [];
                $sql_en_type = "id,Title, TitleNepali, DocPath,slug,parent_id";
                $main_category_detail=$this->crud_model->get_sql_all('service_category', array('status' => '1','parent_id'=>'0'),'serial','ASC', 1000, 0, $sql_en_type); 
          
                 foreach($main_category_detail as $key=>$val){
                    $doc = '';
                    if($val->DocPath){
                        $doc = base_url($val->DocPath);
                    }
                    $service_category_en[$key]=['id' => $val->id, 'title' => $val->Title,'slug'=>$val->slug,'doc'=>$doc];
                     
                    $childs=$this->crud_model->get_sql_all('service_category', array('status' => '1','parent_id'=>$val->id),'serial','ASC', 1000, 0, $sql_en_type);
                     if (!empty($childs)) {
                         $service_category_en[$key]['child']  =  $this->get_childs_en($childs);
                    }
                    
                    $service_category_ne[$key]=['id' => $val->id, 'title' => $val->TitleNepali,'slug'=>$val->slug,'doc'=>$doc];
                     
                    $childs=$this->crud_model->get_sql_all('service_category', array('status' => '1','parent_id'=>$val->id),'serial','ASC', 1000, 0, $sql_en_type);
                     if (!empty($childs)) {
                         $service_category_ne[$key]['child']  =  $this->get_childs_ne($childs);
                    }
                 
                        
                     //for english
                    // $service_category_en[$key]['id'] = $val->id;
                    // $service_category_en[$key]['title'] = $val->Title;
                    // $service_category_en[$key]['slug'] = $val->slug;
                    // $service_category_en[$key]['doc'] = $doc;
                    
                    // //for nepali
                    // $service_category_ne[$key]['id'] = $val->id;
                    // $service_category_ne[$key]['title'] = $val->TitleNepali;
                    // $service_category_ne[$key]['slug'] = $val->slug;
                    // $service_category_ne[$key]['doc'] = $doc;
                 }
                  
                        
                if($total){ 
                    $response=array(
                        'status' => "Success",
                        'status_code' => 200,
                        'status_message' => "Item List",
                        'items' => [
                            'en' => $servicesEn,
                            'np' => $servicesNe
                        ],
                        'service_category' => [
                            'en' => $service_category_en,
                            'np' => $service_category_ne
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
    
    public function category(){ 
        header('Access-Control-Allow-Method:GET');
        if ($this->request_method != "GET") {
            $response=array(
                'status' => "Error",
                'status_code' => 204,
                'status_message' => "Access Method Not Allowed",
            );
        } else { 
                
                $mainservice_category_en = [];
                $mainservice_category_ne = [];
                $sql_en_type = "id,Title, TitleNepali, DocPath,slug,parent_id";
                $main_category_detail=$this->crud_model->get_sql_all('service_category', array('status' => '1','parent_id'=>'0'),'serial','ASC', 1000, 0, $sql_en_type); 
          
                 foreach($main_category_detail as $key=>$val){
                    $doc = '';
                    if($val->DocPath){
                        $doc = base_url($val->DocPath);
                    }
                    $service_category_en[$key]=['id' => $val->id, 'title' => $val->Title,'slug'=>$val->slug,'doc'=>$doc];
                     
                    $childs=$this->crud_model->get_sql_all('service_category', array('status' => '1','parent_id'=>$val->id),'serial','ASC', 1000, 0, $sql_en_type);
                     if (!empty($childs)) {
                         $service_category_en[$key]['child']  =  $this->get_childs_en($childs);
                    }
                    
                    $service_category_ne[$key]=['id' => $val->id, 'title' => $val->TitleNepali,'slug'=>$val->slug,'doc'=>$doc];
                     
                    $childs=$this->crud_model->get_sql_all('service_category', array('status' => '1','parent_id'=>$val->id),'serial','ASC', 1000, 0, $sql_en_type);
                     if (!empty($childs)) {
                         $service_category_ne[$key]['child']  =  $this->get_childs_ne($childs);
                    }
                 
                 }
                        
                if($main_category_detail){ 
                    $response=array(
                        'status' => "Success",
                        'status_code' => 200,
                        'status_message' => "Item List",
                       
                        'service_category' => [
                            'en' => $service_category_en,
                            'np' => $service_category_ne
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
        $sql_en = "id,Title, TitleNepali, DocPath,slug,parent_id";
        $service_category_ne = [];
        if (!empty($childs)) {
            foreach ($childs as $key => $value) {
                $new_childs = $this->crud_model->get_sql_all('service_category', array('status' => '1','parent_id'=>$value->id),'rank','ASC', 1000, 0, $sql_en);
               
              
               // $new_childs = $this->crud_model->getAllData('service_category', array_merge($this->param,['parent_id' => $value->id]), ['MAIN', 'BOTH'],'show_type',0, 0,$sql_en, 'rank ASC');  
                $service_category_ne[$key]  = ['id' => $value->id, 'title' => $value->Title, 'slug' => $value->slug,];
                if (!empty($new_childs)) {
                    $service_category_ne[$key]['child']  = $this->get_childs_ne($new_childs);
                }
            }
        }
        return $service_category_ne;
    }
    
    
    public function get_childs_ne($childs = array())
    {
        
        $sql_en = "id,Title, TitleNepali, DocPath,slug,parent_id";
        $service_category_en = [];
        if (!empty($childs)) {
            foreach ($childs as $key => $value) {
                $new_childs = $this->crud_model->get_sql_all('service_category', array('status' => '1','parent_id'=>$value->id),'rank','ASC', 1000, 0, $sql_en);
                // $new_childs = $this->crud_model->getAllData('service_category', array_merge($this->param,['parent_id' => $value->id]), ['MAIN', 'BOTH'],'show_type',0, 0,$sql_en, 'rank ASC');  
                $service_category_en[$key]  = ['id' => $value->id, 'title' => $value->TitleNepali, 'slug' => $value->slug,];
                if (!empty($new_childs)) {
                    $service_category_en[$key]['child']  = $this->get_childs_ne($new_childs);
                }
            }
        }
        return $service_category_en;
    }
    
    function detail_old($slug)
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
                $sql_services = "id, TitleNepali, Title, slug";
                $getServices = $this->crud_model->getData($this->table, $this->param, $per_page, $offset, $sql_services);
                
                $categoryEn = [];
                $categoryNe = [];
                foreach($getServices as $key=>$val){
                    //for english
                    $categoryEn[$key]['id'] = $val->id;
                    $categoryEn[$key]['title'] = $val->Title;
                    $categoryEn[$key]['slug'] = $val->slug;

                    //for neapli
                    $categoryNe[$key]['id'] = $val->id;
                    $categoryNe[$key]['title'] = $val->TitleNepali;
                    $categoryNe[$key]['slug'] = $val->slug;
                }
                
                $sql_services = "id, TitleNepali, DescriptionNepali, Title, Description, slug, Link, CoverImage, DocPath, Image, created_on, lastmodified";
                $servicesEn = [];
                $servicesNe = [];
                $detail = $this->crud_model->getDetail($this->table, array_merge($this->param, ['slug'=>$slug]), $sql_services); 
                if($detail){
                    $doc = '';
                if($detail->DocPath){
                    $doc = base_url($detail->DocPath);
                }

                $image = '';
                if($detail->Image){
                    $image = base_url($detail->Image);
                }
                
                $coverImage = '';
                if($detail->CoverImage){
                    $coverImage = base_url($detail->CoverImage);
                }
                //for english
                $servicesEn['id'] = $detail->id;
                $servicesEn['title'] = $detail->Title;
                $servicesEn['slug'] = $detail->slug;
                $servicesEn['Link'] = $detail->Link;
                $servicesEn['description'] = $detail->Description;
                $servicesEn['doc'] = $doc;
                $servicesEn['cover_image'] = $coverImage;
                $servicesEn['image'] = $image;
                $servicesEn['created_on'] = $detail->created_on;
                $servicesEn['lastmodified'] = $detail->lastmodified;

                //for neapli
                $servicesNe['id'] = $detail->id;
                $servicesNe['title'] = $detail->TitleNepali;
                $servicesNe['slug'] = $detail->slug;
                $servicesNe['Link'] = $detail->Link;
                $servicesNe['description'] = $detail->DescriptionNepali;
                $servicesNe['doc'] = $doc;
                $servicesNe['cover_image'] = $coverImage;
                $servicesNe['image'] = $image;
                $servicesNe['created_on'] = $detail->created_on;
                $servicesNe['lastmodified'] = $detail->lastmodified;
                }
                
                if(!empty($detail)){
                    $response = array(
                        'status' => "success",
                        'status_code' => 200,
                        'status_message' => "Data Retreived Successfully",
                        'detail' => [
                            'en' => $servicesEn,
                            'np' => $servicesNe
                        ],
                        'category' => [
                            'en' => $categoryEn,
                            'np' => $categoryNe
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
                $sql_services = "id, TitleNepali, Title, slug";
                $getServices = $this->crud_model->getData($this->table, $this->param, $per_page, $offset, $sql_services);
                
                $categoryEn = [];
                $categoryNe = [];
                foreach($getServices as $key=>$val){
                    //for english
                    $categoryEn[$key]['id'] = $val->id;
                    $categoryEn[$key]['title'] = $val->Title;
                    $categoryEn[$key]['slug'] = $val->slug;

                    //for neapli
                    $categoryNe[$key]['id'] = $val->id;
                    $categoryNe[$key]['title'] = $val->TitleNepali;
                    $categoryNe[$key]['slug'] = $val->slug;
                }
                
                $sql_services = "id, TitleNepali, DescriptionNepali, Title, Description, slug, Link, CoverImage, DocPath, Image, created_on, lastmodified";
                $servicesEn = [];
                $servicesNe = [];
                $detail = $this->crud_model->getDetail($this->table, array_merge($this->param, ['slug'=>$slug]), $sql_services); 
                if($detail){
                    $doc = '';
                if($detail->DocPath){
                    $doc = base_url($detail->DocPath);
                }

                $image = '';
                if($detail->Image){
                    $image = base_url($detail->Image);
                }
                
                $coverImage = '';
                if($detail->CoverImage){
                    $coverImage = base_url($detail->CoverImage);
                }
                //for english
                $servicesEn['id'] = $detail->id;
                $servicesEn['title'] = $detail->Title;
                $servicesEn['slug'] = $detail->slug;
                $servicesEn['Link'] = $detail->Link;
                $servicesEn['description'] = $detail->Description;
                $servicesEn['doc'] = $doc;
                $servicesEn['cover_image'] = $coverImage;
                $servicesEn['image'] = $image;
                $servicesEn['created_on'] = $detail->created_on;
                $servicesEn['lastmodified'] = $detail->lastmodified;

                //for neapli
                $servicesNe['id'] = $detail->id;
                $servicesNe['title'] = $detail->TitleNepali;
                $servicesNe['slug'] = $detail->slug;
                $servicesNe['Link'] = $detail->Link;
                $servicesNe['description'] = $detail->DescriptionNepali;
                $servicesNe['doc'] = $doc;
                $servicesNe['cover_image'] = $coverImage;
                $servicesNe['image'] = $image;
                $servicesNe['created_on'] = $detail->created_on;
                $servicesNe['lastmodified'] = $detail->lastmodified;
                }
                
                if(!empty($detail)){
                    $response = array(
                        'status' => "success",
                        'status_code' => 200,
                        'status_message' => "Data Retreived Successfully",
                        'detail' => [
                            'en' => $servicesEn,
                            'np' => $servicesNe
                        ],
                        'category' => [
                            'en' => $categoryEn,
                            'np' => $categoryNe
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
}