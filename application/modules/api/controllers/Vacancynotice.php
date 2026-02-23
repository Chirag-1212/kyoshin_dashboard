<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Vacancynotice extends Front_controller
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
        $this->table = 'career_file'; 
        $this->title = 'Vacancy Notice';
        $this->param = [
            'status' => '1'
        ];
    }
    
    function all($page=0)
    { 
        header('Access-Control-Allow-Method:GET');
        if ($this->request_method != "GET") {
            $response=array(
                'status' => "Error",
                'status_code' => 204,
                'status_message' => "Access Method Not Allowed",
            );
        } else {  
                $per_page = 1;
                $galleryEn = [];
                $galleryNe = [];
                $sql = "id, slug, title_nepali , title, CoverImage, description,description_nepali,created, updated";
                $items = $this->crud_model->get_sql_all($this->table, $this->param, 'id', 'DESC',$per_page, $page,$sql);  
               
                foreach($items as $key=>$val){
                    $doc = '';
                    // if($val->DocPath){
                    //     $doc = base_url($val->DocPath);
                    // }

                    $image = '';
                    if($val->CoverImage){
                        $image = base_url($val->CoverImage);
                    }
                    //for english
                    $galleryEn[$key]['id'] = $val->id;
                    $galleryEn[$key]['title'] = $val->title;
                    $galleryEn[$key]['slug'] = $val->slug;
                    $galleryEn[$key]['description'] = $val->description;
                    // $galleryEn[$key]['doc'] = $doc;
                    $galleryEn[$key]['image'] = $image;
                    $galleryEn[$key]['created'] = $val->created;
                    $galleryEn[$key]['lastmodified'] = $val->updated;

                    //for neapli
                    $galleryNe[$key]['id'] = $val->id;
                    $galleryNe[$key]['title'] = $val->title_nepali;
                    $galleryNe[$key]['slug'] = $val->slug;
                    $galleryNe[$key]['description'] = $val->description_nepali;
                    // $galleryNe[$key]['doc'] = $doc;
                    $galleryNe[$key]['image'] = $image;
                    $galleryNe[$key]['created'] = $val->created;
                    $galleryNe[$key]['lastmodified'] = $val->updated;
                }
                
                
                 
                $items = array(
                    'en' =>$galleryEn,
                    'np' => $galleryNe
                );
                $total = $this->crud_model->count_all($this->table, $this->param, 'id'); 
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
                $items_english = [];
                $items_nepali = [];
                $multi_images = [];
                $sql = "id, slug, title_nepali , title, CoverImage, created,updated";
                $detail = $this->crud_model->get_sql_single($this->table, array('status' => '1', 'slug' => $slug), 'id', 'DESC',$sql);
                // $this->crud_model->getDetail($this->table, array_merge($this->param,['slug' => $slug]), $sql); 
                
                if($detail){
                    $doc = '';
                    // if($detail->DocPath){
                    //     $doc = base_url($detail->DocPath);
                    // }
                    $image = '';
                    if($detail->CoverImage){
                        $image = base_url($detail->CoverImage);
                    }

                    //for english
                    $items_english['id'] = $detail->id;
                    $items_english['title'] = $detail->title;
                    $items_english['slug'] = $detail->slug;
                    $items_english['doc'] = $doc;
                    $items_english['image'] = $image;
                    $items_english['created_on'] = $detail->created;
                    $items_english['lastmodified'] = $detail->updated;

                    //for nepali
                    $items_nepali['id'] = $detail->id;
                    $items_nepali['title'] = $detail->title;
                    $items_nepali['slug'] = $detail->slug;
                    $items_nepali['doc'] = $doc;
                    $items_nepali['image'] = $image;
                    $items_nepali['created_on'] = $detail->created;
                    $items_nepali['lastmodified'] = $detail->updated;
                    
                    $this->param['gallery_id'] = $detail->id;
                    $multi_sql = "id,gallery_id,DocPath";
                    $images = $this->crud_model->get_sql_all_no_pagination('gallery_images', $this->param, 'id', 'DESC',$multi_sql);  
                    if($images){
                        foreach($images as $key=>$val){
                            $image_doc = '';
                            if($val->DocPath){
                                $image_doc = base_url($val->DocPath);
                            }
          
                            $multi_images[$key]['id'] = $val->id;
                            $multi_images[$key]['doc'] = $image_doc;
                        }
                        $items_english['multi_images'] = $multi_images;
                        $items_nepali['multi_images'] = $multi_images;
                        
                   }
                    $items = array(
                        'en' => $items_english,
                        'np' => $items_nepali,
                    );
                
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
        $json_response = json_encode($response);
        echo $json_response;
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
    //             $galleryEn = [];
    //             $galleryNe = [];
    //             $per_page = 200;
    //             $offset = ($page*$per_page - $per_page); 
    //             $items = $this->crud_model->get_where_pagination_order_by($this->table, $this->param, $per_page, $offset, 'id', 'DESC');
                
    //             $total = $this->crud_model->count_all($this->table, $this->param, 'id');
              
    //             if($items){
    //                 foreach($items as $key=>$val){
    //                     //for english
    //                     $galleryEn[$key]['id'] = $val->id;
    //                     $galleryEn[$key]['title'] = $val->title;
    //                     $galleryEn[$key]['slug'] = $val->slug;
    //                     $galleryEn[$key]['description'] = $val->description;
    //                     $galleryEn[$key]['image'] = $val->featured_image;
    //                     $galleryEn[$key]['created_on'] = $val->created;

    //                     //for neapli
    //                     // $galleryNe[$key]['id'] = $val->id;
    //                     // $galleryNe[$key]['title'] = $val->title_nepali;
    //                     // $galleryNe[$key]['slug'] = $val->slug;
    //                     // $galleryNe[$key]['description'] = $val->description_nepali;
    //                     // $galleryNe[$key]['image'] = $val->featured_image;
    //                     // $galleryNe[$key]['created_on'] = $val->created;
    //                 }
                    
    //                 $response=array(
    //                         'status' => "Success",
    //                         'status_code' => 200,
    //                         'status_message' => "Item List",
    //                         'items' => $galleryEn,
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
}