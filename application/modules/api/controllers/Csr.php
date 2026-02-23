<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Csr extends Front_controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->library('Nepali_calendar');
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
        $this->table = 'csr'; 
        $this->title = 'CSR';
        $this->param = [
            'status' => '1'
        ];
    } 
   
   function all_year($page="")
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
            $fiscal_yearEn = [];
            $fiscal_yearNe = [];
          
            $fiscal_years = $this->crud_model->get_where_order_by('fiscal_year', array('status' => '1'), 'title', 'DESC');
            // $fiscal_years = $this->crud_model->get_sql_all_no_pagination('fiscal_year', array('status' => '1'), 'title', 'DESC','*');
                if($fiscal_years){
                        
                        foreach($fiscal_years as $fy_key=>$fy){
                            $csrEn = [];
                            $csrNe = [];
                            $param = array('status' => ['1', '3']);
                            $param['fiscal_id']=$fy->id;
                          
                            $sql_en = "id, fiscal_id,datevalue, Title, TitleNepali, Description,DescriptionNepali, lastmodified, created_on, slug";
                         
                            $items_english = $this->crud_model->get_sql_all_no_pagination('csr',$param,'datevalue', 'DESC',$sql_en);  
                            //   var_dump($this->db->last_query()); die;
                            foreach($items_english as $key=>$val){
                                
                                $year=(new DateTime($val->datevalue))->format('Y');
                                $month=(new DateTime($val->datevalue))->format('m');
                                $day=(new DateTime($val->datevalue))->format('d');
                                $npdate=$this->nepali_calendar->AD_to_BS($year,$month,$day);
                                $doc = '';
                                if($val->DocPath){
                                    $doc = base_url($val->DocPath);
                                } 
                                // $csr_type_name_en = '';
                                // $csr_type_name_ne = '';
                                // if($val->csr_type_id){
                                //      $sql_en_type = "id,Title, TitleNepali, slug";
                                //      $csr_type_detail=$this->crud_model->get_sql_single('csr_type', array('status' => '1', 'id' =>$val->csr_type_id), 'serial', 'DESC',$sql_en_type); 
                                //     $csr_type_name_en = $csr_type_detail->Title;
                                //     $csr_type_name_ne = $csr_type_detail->TitleNepali;
                                // } 
            
                                //for english
                                $csrEn[$key]['id'] = $val->id;
                                $csrEn[$key]['fiscal_id'] = $val->fiscal_id;
                                $csrEn[$key]['title'] = $val->Title;
                                $csrEn[$key]['slug'] = $val->slug;
                                // $csrEn[$key]['csr_type_name'] = $csr_type_name_en;
                                $csrEn[$key]['doc'] = $doc;
                                $csrEn[$key]['image'] = $doc;
                                $csrEn[$key]['description'] = strip_tags($val->Description);
                                $csrEn[$key]['publish_date'] = $val->datevalue;
                                $csrEn[$key]['due_date'] = $val->due_date;
                                $csrEn[$key]['lastmodified'] = $val->lastmodified;
                                $csrEn[$key]['nepali_date'] = $npdate;
            
                                //for nepali
                                $csrNe[$key]['id'] = $val->id;
                                $csrNe[$key]['fiscal_id'] = $val->fiscal_id;
                                $csrNe[$key]['title'] = $val->TitleNepali;
                                $csrNe[$key]['slug'] = $val->slug;
                                // $csrNe[$key]['csr_type_name'] = $csr_type_name_ne;
                                $csrNe[$key]['doc'] = $doc;
                                $csrNe[$key]['image'] = $doc;
                                $csrNe[$key]['description'] = strip_tags($val->DescriptionNepali);
                                $csrNe[$key]['publish_date'] = $val->datevalue;
                                $csrNe[$key]['due_date'] = $val->due_date;
                                $csrNe[$key]['lastmodified'] = $val->lastmodified;
                                $csrNe[$key]['nepali_date'] = $npdate;
            
                            }
                            //for english
                            $fiscal_yearEn[$fy_key] = [
                                'id' => $fy->id,
                                'title' => $fy->title,
                                'child' => $csrEn,
                            ];
                    
                            // For Nepali
                            $fiscal_yearNe[$fy_key] = [
                                'id' => $fy->id,
                                'title' => $fy->title_nepali,
                                'child' => $csrNe,
                            ];
                              
                            // $items = array(
                            //     'en' =>$csrEn,
                            //     'np' => $csrNe
                            // );
                          
                            // //for english
                            // $fiscal_yearEn[$key]['id'] = $fy->id;
                            // $fiscal_yearEn[$key]['title'] = $fy->title;
                            // $fiscal_yearEn[$key]['child'] = $csrEn;
                            
                            // //for neapli
                            // $fiscal_yearNe[$key]['id'] = $fy->id;
                            // $fiscal_yearNe[$key]['title'] = $fy->title_nepali;
                            // $fiscal_yearNe[$key]['child'] = $csrNe;
                        }
                        
                        $FY = array(
                            'en' =>$fiscal_yearEn,
                            'np' => $fiscal_yearNe
                        );
                }
              
          
                
              
                // $total = $this->crud_model->count_allIN('csr', $param, 'id'); 
                
                
                 
                if($FY){ 
                    $response=array(
                            'status' => "Success",
                            'status_code' => 200,
                            'status_message' => "Item List",
                            // 'items' => $items,
                            // 'total' => $total,
                             'FY'=>$FY,
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
    
   function all_slug($page="")
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
                $csrEn = [];
                $csrNe = [];
                $param = array('status' => ['1', '3']);
          
                
                $sql_en = "id, fiscal_id,datevalue, Title, TitleNepali, Description,DescriptionNepali, lastmodified, created_on, slug";
                 $items_english = $this->crud_model->get_sql_all_no_pagination('csr',$param,'datevalue', 'DESC',$sql_en);  
               
                foreach($items_english as $key=>$val){
                    
                    $year=(new DateTime($val->datevalue))->format('Y');
                    $month=(new DateTime($val->datevalue))->format('m');
                    $day=(new DateTime($val->datevalue))->format('d');
                    $npdate=$this->nepali_calendar->AD_to_BS($year,$month,$day);
                    $doc = '';
                    if($val->DocPath){
                        $doc = base_url($val->DocPath);
                    } 
                    // $csr_type_name_en = '';
                    // $csr_type_name_ne = '';
                    // if($val->csr_type_id){
                    //      $sql_en_type = "id,Title, TitleNepali, slug";
                    //      $csr_type_detail=$this->crud_model->get_sql_single('csr_type', array('status' => '1', 'id' =>$val->csr_type_id), 'serial', 'DESC',$sql_en_type); 
                    //     $csr_type_name_en = $csr_type_detail->Title;
                    //     $csr_type_name_ne = $csr_type_detail->TitleNepali;
                    // } 

                    //for english
                    $csrEn[$key]['id'] = $val->id;
                    $csrEn[$key]['fiscal_id'] = $val->fiscal_id;
                    $csrEn[$key]['title'] = $val->Title;
                    $csrEn[$key]['slug'] = $val->slug;
                    // $csrEn[$key]['csr_type_name'] = $csr_type_name_en;
                    $csrEn[$key]['doc'] = $doc;
                    $csrEn[$key]['image'] = $doc;
                    $csrEn[$key]['description'] = strip_tags($val->Description);
                    $csrEn[$key]['publish_date'] = $val->datevalue;
                    $csrEn[$key]['lastmodified'] = $val->lastmodified;
                    $csrEn[$key]['nepali_date'] = $npdate;

                    //for nepali
                    $csrNe[$key]['id'] = $val->id;
                    $csrNe[$key]['fiscal_id'] = $val->fiscal_id;
                    $csrNe[$key]['title'] = $val->TitleNepali;
                    $csrNe[$key]['slug'] = $val->slug;
                    // $csrNe[$key]['csr_type_name'] = $csr_type_name_ne;
                    $csrEn[$key]['doc'] = $doc;
                    $csrNe[$key]['image'] = $doc;
                    $csrEn[$key]['description'] = strip_tags($val->DescriptionNepali);
                    $csrNe[$key]['publish_date'] = $val->datevalue;
                    $csrNe[$key]['lastmodified'] = $val->lastmodified;
                    $csrNe[$key]['nepali_date'] = $npdate;

                }
                
                $items = array(
                    'en' =>$csrEn,
                    'np' => $csrNe
                );
                $total = $this->crud_model->count_allIN('csr', $param, 'id'); 
                
                $fiscal_years = $this->crud_model->get_where_order_by('fiscal_year', array('status' => '1'), 'title', 'DESC');
                if($fiscal_years){
                        $fiscal_yearEn = [];
                        $fiscal_yearNe = [];
                        foreach($fiscal_years as $key=>$fy){
                            //for english
                            $fiscal_yearEn[$key]['id'] = $fy->id;
                            $fiscal_yearEn[$key]['title'] = $fy->title;
        
                            //for neapli
                            $fiscal_yearNe[$key]['id'] = $fy->id;
                            $fiscal_yearNe[$key]['title'] = $fy->title_nepali;
                        }
                        
                        $FY = array(
                            'en' =>$fiscal_yearEn,
                            'np' => $fiscal_yearNe
                        );
                }
                 
                if($items){ 
                    $response=array(
                            'status' => "Success",
                            'status_code' => 200,
                            'status_message' => "Item List",
                            'items' => $items,
                            'total' => $total,
                             'FY'=>$FY,
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
   
   function all($page="")
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
                $csrEn = [];
                $csrNe = [];
                $per_page = 8;
                $param = array('status' => ['1', '3']);
                $offset = ($page*$per_page - $per_page); 
                $sql_en = "id, fiscal_id,datevalue,due_date, Title, TitleNepali, Description, DescriptionNepali, DocPath, CoverImage, lastmodified, created_on, slug";
                // $items_english = $this->crud_model->get_sql_all('csr',$param,'id', 'DESC',$per_page, $page,$sql_en);  
                 $items_english = $this->crud_model->get_sql_allIN('csr',$param,'datevalue', 'DESC',$per_page, $offset,$sql_en);  
               
                foreach($items_english as $key=>$val){
                    $year=(new DateTime($val->datevalue))->format('Y');
                    $month=(new DateTime($val->datevalue))->format('m');
                    $day=(new DateTime($val->datevalue))->format('d');
                    $npdate=$this->nepali_calendar->AD_to_BS($year,$month,$day);
                    $doc = '';
                    if($val->DocPath){
                        $doc = base_url($val->DocPath);
                    } 
                     $covimg = '';
                    if($val->CoverImage){
                        $covimg = base_url($val->CoverImage);
                    } 
                    // $csr_type_name_en = '';
                    // $csr_type_name_ne = '';
                    // if($val->csr_type_id){
                    //      $sql_en_type = "id,Title, TitleNepali, slug";
                    //      $csr_type_detail=$this->crud_model->get_sql_single('csr_type', array('status' => '1', 'id' =>$val->csr_type_id), 'serial', 'DESC',$sql_en_type); 
                    //     $csr_type_name_en = $csr_type_detail->Title;
                    //     $csr_type_name_ne = $csr_type_detail->TitleNepali;
                    // } 

                    //for english
                    $csrEn[$key]['id'] = $val->id;
                    $csrEn[$key]['fiscal_id'] = $val->fiscal_id;
                    $csrEn[$key]['title'] = $val->Title;
                    $csrEn[$key]['slug'] = $val->slug;
                    // $csrEn[$key]['csr_type_name'] = $csr_type_name_en;
                    $csrEn[$key]['cover_img'] = $covimg;
                    $csrEn[$key]['doc'] = $doc;
                    $csrEn[$key]['image'] = $doc;
                    $csrEn[$key]['description'] = strip_tags($val->Description);
                    $csrEn[$key]['publish_date'] = $val->datevalue;
                    $csrEn[$key]['due_date'] = $val->due_date;
                    $csrEn[$key]['lastmodified'] = $val->lastmodified;
                    $csrEn[$key]['nepali_date'] = $npdate;

                    //for nepali
                    $csrNe[$key]['id'] = $val->id;
                    $csrNe[$key]['fiscal_id'] = $val->fiscal_id;
                    $csrNe[$key]['title'] = $val->TitleNepali;
                    $csrNe[$key]['slug'] = $val->slug;
                    // $csrNe[$key]['csr_type_name'] = $csr_type_name_ne;
                    $csrNe[$key]['cover_img'] = $covimg;
                    $csrNe[$key]['doc'] = $doc;
                    $csrNe[$key]['image'] = $doc;
                    $csrNe[$key]['description'] = strip_tags($val->DescriptionNepali);
                    $csrNe[$key]['publish_date'] = $val->datevalue;
                    $csrNe[$key]['due_date'] = $val->due_date;
                    $csrNe[$key]['lastmodified'] = $val->lastmodified;
                    $csrNe[$key]['nepali_date'] = $npdate;

                }
                
                $items = array(
                    'en' =>$csrEn,
                    'np' => $csrNe
                );
                $total = $this->crud_model->count_allIN('csr', $param, 'id'); 
                
                $fiscal_years = $this->crud_model->get_where_order_by('fiscal_year', array('status' => '1'), 'title', 'DESC');
                if($fiscal_years){
                        $fiscal_yearEn = [];
                        $fiscal_yearNe = [];
                        foreach($fiscal_years as $key=>$fy){
                            //for english
                            $fiscal_yearEn[$key]['id'] = $fy->id;
                            $fiscal_yearEn[$key]['title'] = $fy->title;
        
                            //for neapli
                            $fiscal_yearNe[$key]['id'] = $fy->id;
                            $fiscal_yearNe[$key]['title'] = $fy->title_nepali;
                        }
                        
                        $FY = array(
                            'en' =>$fiscal_yearEn,
                            'np' => $fiscal_yearNe
                        );
                }
                 
                if($items){ 
                    $response=array(
                            'status' => "Success",
                            'status_code' => 200,
                            'status_message' => "Item List",
                            'items' => $items,
                            'total' => $total,
                            'per_page' => $per_page,
                             'FY'=>$FY,
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
    
    
//   function all($page="", $id = '')
//     { 
//         // echo "here";exit;
//         header('Access-Control-Allow-Method:GET');
//         if ($this->request_method != "GET") {
//             $response=array(
//                 'status' => "Error",
//                 'status_code' => 204,
//                 'status_message' => "Access Method Not Allowed",
//             );
//         } else { 
//                 $csrEn = [];
//                 $csrNe = [];
//                 $per_page = 6;
//                 $param = array('status' => ['1', '3']);
//                 // if($id){
//                 //   $param['csr_type_id'] = $id;
//                 // }
//                 // $page = $this->input->get('offset');
//                 // $page= isset($_GET['offset'])?intval($_GET['offset']):1;
//                 // $offset = ($page*$per_page - $per_page); 
                
//                 $sql_en = "id, datevalue, , Title, TitleNepali, Description, lastmodified, created_on, slug";
//                 // $items_english = $this->crud_model->get_sql_all('csr',$param,'id', 'DESC',$per_page, $page,$sql_en);  
//                  $items_english = $this->crud_model->get_sql_allIN('csr',$param,'datevalue', 'DESC',$per_page, $page,$sql_en);  
//                 var_dump($this->db->last_query()); die();
//                 foreach($items_english as $key=>$val){
//                     $doc = '';
//                     if($val->DocPath){
//                         $doc = base_url($val->DocPath);
//                     } 
//                     // $csr_type_name_en = '';
//                     // $csr_type_name_ne = '';
//                     // if($val->csr_type_id){
//                     //      $sql_en_type = "id,Title, TitleNepali, slug";
//                     //      $csr_type_detail=$this->crud_model->get_sql_single('csr_type', array('status' => '1', 'id' =>$val->csr_type_id), 'serial', 'DESC',$sql_en_type); 
//                     //     $csr_type_name_en = $csr_type_detail->Title;
//                     //     $csr_type_name_ne = $csr_type_detail->TitleNepali;
//                     // } 

//                     //for english
//                     $csrEn[$key]['id'] = $val->id;
//                     $csrEn[$key]['title'] = $val->Title;
//                     $csrEn[$key]['slug'] = $val->slug;
//                     // $csrEn[$key]['csr_type_name'] = $csr_type_name_en;
//                     $csrEn[$key]['doc'] = $doc;
//                     $csrEn[$key]['image'] = $doc;
//                     $csrEn[$key]['description'] = strip_tags($val->Description);
//                     $csrEn[$key]['publish_date'] = $val->datevalue;
//                     $csrEn[$key]['lastmodified'] = $val->lastmodified;

//                     //for nepali
//                     $csrNe[$key]['id'] = $val->id;
//                     $csrNe[$key]['title'] = $val->TitleNepali;
//                     $csrNe[$key]['slug'] = $val->slug;
//                     // $csrNe[$key]['csr_type_name'] = $csr_type_name_ne;
//                     $csrEn[$key]['doc'] = $doc;
//                     $csrNe[$key]['image'] = $doc;
//                     $csrEn[$key]['description'] = strip_tags($val->Description);
//                     $csrNe[$key]['publish_date'] = $val->datevalue;
//                     $csrNe[$key]['lastmodified'] = $val->lastmodified;

//                 }
                 
//                 $items = array(
//                     'en' =>$csrEn,
//                     'np' => $csrNe
//                 );
//                 $total = $this->crud_model->count_all('csr', $param, 'id'); 
//                 if($items){ 
//                     $response=array(
//                             'status' => "Success",
//                             'status_code' => 200,
//                             'status_message' => "Item List",
//                             'items' => $items,
//                             'total' => $total,
//                             'per_page' => $per_page,
//                         );
//                 }else{
//                     $response=array(
//                             'status' => "error",
//                             'status_code' => 208,
//                             'status_message' => "No Items Found", 
//                         );
//                 } 
            
//         } 
//         $json_response = json_encode($response);
//         echo $json_response;
//     }

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
                $csrEn = [];
                $csrNe = [];
                $multi_images = [];
                $sql_en = "id, slug, datevalue, Title, TitleNepali, Description, DescriptionNepali, DocPath, created_on";
                $items = $this->crud_model->getDetail('csr', array('status' => ['1', '3'], 'slug' => $slug),$sql_en); 
              
                if($items){
                    $doc = '';
                    if($items->DocPath){
                        $doc = base_url($items->DocPath);
                    }
                    
                    //for english
                    $csrEn['id'] = $items->id;
                    $csrEn['title'] = $items->Title;
                    $csrEn['slug'] = $items->slug;
                    $csrEn['description'] = $items->Description;
                    $csrEn['image'] = $doc;
                    $csrEn['publish_date'] = $items->datevalue;

                    //for neapli
                    $csrNe['id'] = $items->id;
                    $csrNe['title'] = $items->TitleNepali;
                    $csrNe['slug'] = $items->slug;
                    $csrNe['description'] = $items->DescriptionNepali;
                    $csrNe['image'] = $doc;
                    $csrNe['publish_date'] = $items->datevalue;
                    
                    $this->param['csr_id'] = $detail->id;
                    $multi_sql = "id,csr_id,DocPath";
                    $images = $this->crud_model->get_sql_all_no_pagination('csr_images', $this->param, 'id', 'DESC',$multi_sql);  
                    if($images){
                        foreach($images as $key=>$val){
                            $image_doc = '';
                            if($val->DocPath){
                                $image_doc = base_url($val->DocPath);
                            }
          
                            $multi_images[$key]['id'] = $val->id;
                            $multi_images[$key]['doc'] = $image_doc;
                        }
                        $csrEn['multi_images'] = $multi_images;
                        $csrNe['multi_images'] = $multi_images;
                        
                   }
                }
                
                
                $items = array(
                    'en' => $csrEn,
                    'np' => $csrNe,
                );
                    
                if(!empty($items)){
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
   
    function csr_type($page=1)
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
                $per_page = 10;
                $offset = ($page*$per_page - $per_page); 
                
                $sql_en = "id,DocPath, Title, created_on, slug";
                $items_english = $this->crud_model->get_sql_all('csr_type',array('status' => '1','parent_id'=>'0'),'serial', 'DESC',$per_page, $offset,$sql_en);  
                foreach($items_english as $key=>$val){
                    if($val->DocPath){
                        $items_english[$key]->DocPath = base_url($val->DocPath);
                    } 
                }
                
                $sql_np = "id,DocPath, TitleNepali as Title, created_on, slug";
                $items_nepali = $this->crud_model->get_sql_all('csr_type',array('status' => '1','parent_id'=>'0'),'serial', 'DESC',$per_page, $offset,$sql_np);  
                foreach($items_nepali as $key=>$val){
                    if($val->DocPath){
                        $items_nepali[$key]->DocPath = base_url($val->DocPath);
                    } 
                }
                 
                $items = array(
                    'en' =>$items_english,
                    'np' => $items_nepali
                    );
                $total = $this->crud_model->count_all('csr_type', array('status' => '1'), 'id'); 
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

    
    
    function csr_sub($slug)
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
                $csrTypeEn = [];
                $csrTypeNe = [];
                
                $items = array(
                    'en' => $this->get_parents($slug),
                    'np' => $this->get_parents_ne($slug),
                );
                if(!empty($items)){
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

    public function get_parents($slug = '')
	{
		$html = [];
		$parents = $this->db->get_where('csr_type', array('status' => '1', 'slug' => $slug))->result();
         
		if ($parents) {
			foreach ($parents as $key => $value) {
                $image = '';
                if($value->DocPath){
                    $image = base_url($value->DocPath);
                    
                } 
				$html['category']  =[
                    'id' => $value->id,
                    'title' => $value->Title,
                    'image' => $image,
                ];
				$childs = $this->db->get_where('csr_type', array('parent_id' => $value->id, 'status' => '1'))->result();
				if (!empty($childs)) {
					$html[$key]  =[
                        'id' => $value->id,
                        'title' => $value->Title,
                        'image' => $image,
                    ];
					$html[$key] = $this->get_childs($childs);
				}
			}
		}

		return $html;
	}

	public function get_childs($childs = array())
	{
		$html = [];
		if (!empty($childs)) {
			foreach ($childs as $key => $value) {
				$image = '';
                if($value->DocPath){
                    $image = base_url($value->DocPath);
                    
                } 
				$html[$key]  =[
                    'id' => $value->id,
                    'title' => $value->Title,
                    'image' => $image,
                ];
				$new_childs = $this->db->get_where('csr_type', array('parent_id' => $value->id, 'status' => '1'))->result();
				if (!empty($new_childs)) {
					$html[$key]  =[
                        'id' => $value->id,
                        'title' => $value->Title,
                        'image' => $image,
                    ];
					$html[$key] = $this->get_childs($new_childs);
				}
			}
		}
		return $html;
	}

    public function get_parents_ne($slug = '')
	{
		$html = [];
		$parents = $this->db->get_where('csr_type', array('status' => '1', 'slug' => $slug))->result();
         
		if ($parents) {
			foreach ($parents as $key => $value) {
                $image = '';
                if($value->DocPath){
                    $image = base_url($value->DocPath);
                    
                } 
				$html['category']  =[
                    'id' => $value->id,
                    'title' => $value->TitleNepali,
                    'image' => $image,
                ];
				$childs = $this->db->get_where('csr_type', array('parent_id' => $value->id, 'status' => '1'))->result();
				if (!empty($childs)) {
					$html[$key]  =[
                        'id' => $value->id,
                        'title' => $value->TitleNepali,
                        'image' => $image,
                    ];
					$html[$key] = $this->get_childs_ne($childs);
				}
			}
		}

		return $html;
	}

	public function get_childs_ne($childs = array())
	{
		$html = [];
		if (!empty($childs)) {
			foreach ($childs as $key => $value) {
				$image = '';
                if($value->DocPath){
                    $image = base_url($value->DocPath);
                    
                } 
				$html[$key]  =[
                    'id' => $value->id,
                    'title' => $value->TitleNepali,
                    'image' => $image,
                ];
				$new_childs = $this->db->get_where('csr_type', array('parent_id' => $value->id, 'status' => '1'))->result();
				if (!empty($new_childs)) {
					$html[$key]  =[
                        'id' => $value->id,
                        'title' => $value->TitleNepali,
                        'image' => $image,
                    ];
					$html[$key] = $this->get_childs_ne($new_childs);
				}
			}
		}
		return $html;
	}
}