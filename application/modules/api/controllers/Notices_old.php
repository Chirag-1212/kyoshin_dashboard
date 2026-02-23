<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Notices extends Front_controller
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
        
        $this->table = 'career';
        $this->title = 'Career';
        $this->param = [
            'status' => '1'
        ];
    }
    function all($page=1)
    { 
        header('Access-Control-Allow-Method:GET');
        if ($this->request_method != "GET") {
            $response=array(
                'status' => "Error",
                'status_code' => 204,
                'status_message' => "Access Method Not Allowed",
            );
        } else { 
            $news_param = [
                'Type'=> 'news' ,
                'status' => ['1','3']
            ];
            $notice_param = [
                'Type'=> 'notice' ,
                'status' => ['1','3']
            ];
            $noticeEn = [];
            $noticeNe = []; 
            $per_page = 5;
            $offset = ($page*$per_page - $per_page); 
            $sql = "id, DocPath, Description, DescriptionNepali, Title, TitleNepali, fiscal_id, datevalue, due_date, created_on, slug";
            $notices = $this->crud_model->get_sql_allIN($this->table,$notice_param,'id', 'DESC',$per_page, $offset,$sql);  
            // var_dump($this->db->last_query()); die;
            foreach($notices as $key=>$val){
                
                $doc = '';
                if($val->DocPath){
                    $doc = base_url($val->DocPath);
                }
                //for english
                $noticeEn[$key]['id'] = $val->id;
                $noticeEn[$key]['fiscal_id'] = $val->fiscal_id;
                $noticeEn[$key]['title'] = $val->Title;
                $noticeEn[$key]['slug'] = $val->slug;
                $noticeEn[$key]['description'] = $val->Description;
                $noticeEn[$key]['image'] = $doc;
                $noticeEn[$key]['created'] = (new DateTime($val->datevalue))->format('M d, Y');
                $noticeEn[$key]['day'] = (new DateTime($val->datevalue))->format('d');
                $noticeEn[$key]['month'] = (new DateTime($val->datevalue))->format('F');
                $noticeEn[$key]['due'] = (new DateTime($val->due_date))->format('M d, Y');
                $noticeEn[$key]['dueday'] = (new DateTime($val->due_date))->format('d');
                $noticeEn[$key]['duemonth'] = (new DateTime($val->due_date))->format('F');
                $noticeEn[$key]['published'] = $val->datevalue;
                $noticeEn[$key]['due_date'] = $val->due_date;
                $noticeEn[$key]['created_on'] = $val->created_on;

                //for neapli
                $noticeNe[$key]['id'] = $val->id;
                $noticeNe[$key]['fiscal_id'] = $val->fiscal_id;
                $noticeNe[$key]['title'] = $val->TitleNepali;
                $noticeNe[$key]['slug'] = $val->slug;
                $noticeNe[$key]['description'] = $val->DescriptionNepali;
                $noticeNe[$key]['image'] = $doc;
                $noticeNe[$key]['created'] = (new DateTime($val->datevalue))->format('M d, Y');
                $noticeNe[$key]['day'] = (new DateTime($val->datevalue))->format('d');
                $noticeNe[$key]['month'] = (new DateTime($val->datevalue))->format('F');
                $noticeNe[$key]['due'] = (new DateTime($val->due_date))->format('M d, Y');
                $noticeNe[$key]['dueday'] = (new DateTime($val->due_date))->format('d');
                $noticeNe[$key]['duemonth'] = (new DateTime($val->due_date))->format('F');
                $noticeNe[$key]['published'] = $val->datevalue;
                $noticeNe[$key]['due_date'] = $val->due_date;
                $noticeNe[$key]['created_on'] = $val->created_on;
                
            }
            $noticestotal = $this->crud_model->count_allIN($this->table, $notice_param, 'id'); 
            
            
            $newsEn = [];
            $newsNe = []; 
            $newss = $this->crud_model->get_sql_allIN($this->table,$news_param,'id', 'DESC',$per_page, $offset,$sql);  
            foreach($newss as $key=>$val){
                
                $doc = '';
                if($val->DocPath){
                    $doc = base_url($val->DocPath);
                }
                //for english
                $newsEn[$key]['id'] = $val->id;
                $newsEn[$key]['fiscal_id'] = $val->fiscal_id;
                $newsEn[$key]['title'] = $val->Title;
                $newsEn[$key]['slug'] = $val->slug;
                $newsEn[$key]['description'] = $val->Description;
                $newsEn[$key]['image'] = $doc;
                $newsEn[$key]['created'] = (new DateTime($val->datevalue))->format('M d, Y');
                $newsEn[$key]['day'] = (new DateTime($val->datevalue))->format('d');
                $newsEn[$key]['month'] = (new DateTime($val->datevalue))->format('F');
                $newsEn[$key]['due'] = (new DateTime($val->due_date))->format('M d, Y');
                $newsEn[$key]['dueday'] = (new DateTime($val->due_date))->format('d');
                $newsEn[$key]['duemonth'] = (new DateTime($val->due_date))->format('F');
                $newsEn[$key]['published'] = $val->datevalue;
                $newsEn[$key]['due_date'] = $val->due_date;
                $newsEn[$key]['created_on'] = $val->created_on;

                //for nepali
                $newsNe[$key]['id'] = $val->id;
                $newsNe[$key]['fiscal_id'] = $val->fiscal_id;
                $newsNe[$key]['title'] = $val->TitleNepali;
                $newsNe[$key]['slug'] = $val->slug;
                $newsNe[$key]['description'] = $val->DescriptionNepali;
                $newsNe[$key]['image'] = $doc;
                $newsNe[$key]['created'] = (new DateTime($val->datevalue))->format('M d, Y');
                $newsNe[$key]['day'] = (new DateTime($val->datevalue))->format('d');
                $newsNe[$key]['month'] = (new DateTime($val->datevalue))->format('F');
                $newsNe[$key]['due'] = (new DateTime($val->due_date))->format('M d, Y');
                $newsNe[$key]['dueday'] = (new DateTime($val->due_date))->format('d');
                $newsNe[$key]['duemonth'] = (new DateTime($val->due_date))->format('F');
                $newsNe[$key]['published'] = $val->datevalue;
                $newsNe[$key]['due_date'] = $val->due_date;
                $newsNe[$key]['created_on'] = $val->created_on;
                
            }
             
            $newsstotal = $this->crud_model->count_allIN($this->table, $news_param, 'id');
            
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
         
            if($noticestotal || $newsstotal){ 
                $response=array(
                        'status' => "Success",
                        'status_code' => 200,
                        'status_message' => "Item List",
                        'notices' => [
                            'en' =>$noticeEn,
                            'np' => $noticeNe
                        ],
                        'notices_total' => $noticestotal,
                        'news' => [
                            'en' =>$newsEn,
                            'np' =>$newsNe
                        ],
                        'news_total' => $newsstotal,
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
    
    function category($page=1)
    { 
        header('Access-Control-Allow-Method:GET');
        if ($this->request_method != "GET") {
            $response=array(
                'status' => "Error",
                'status_code' => 204,
                'status_message' => "Access Method Not Allowed",
            );
        } else { 
            $news_param = [
                // 'Type'=> 'news' ,
                'status' => ['1','3']
            ];
            $notice_param = [
                // 'Type'=> 'notice' ,
                'status' => ['1','3']
            ];
            $noticeEn = [];
            $noticeNe = []; 
            $per_page = 12;
            $offset = ($page*$per_page - $per_page); 
            $sql = "id, DocPath,Type, Description, DescriptionNepali, Title, TitleNepali, datevalue, due_date, created_on, slug";
            $notices = $this->crud_model->get_sql_allIN($this->table,$notice_param,'id', 'DESC',$per_page, $offset,$sql);  
            // var_dump($this->db->last_query()); die;
            foreach($notices as $key=>$val){
                
                $doc = '';
                if($val->DocPath){
                    $doc = base_url($val->DocPath);
                }
                //for english
                $noticeEn[$key]['id'] = $val->id;
                $noticeEn[$key]['title'] = $val->Title;
                $noticeEn[$key]['slug'] = $val->slug;
                $noticeEn[$key]['description'] = $val->Description;
                $noticeEn[$key]['image'] = $doc;
                $noticeEn[$key]['type'] = $val->Type;
                $noticeEn[$key]['created'] = (new DateTime($val->datevalue))->format('M d, Y');
                $noticeEn[$key]['day'] = (new DateTime($val->datevalue))->format('d');
                $noticeEn[$key]['month'] = (new DateTime($val->datevalue))->format('F');
                $noticeEn[$key]['due'] = (new DateTime($val->due_date))->format('M d, Y');
                $noticeEn[$key]['dueday'] = (new DateTime($val->due_date))->format('d');
                $noticeEn[$key]['duemonth'] = (new DateTime($val->due_date))->format('F');
                $noticeEn[$key]['published'] = $val->datevalue;
                $noticeEn[$key]['due_date'] = $val->due_date;
                $noticeEn[$key]['created_on'] = $val->created_on;

                //for neapli
                $noticeNe[$key]['id'] = $val->id;
                $noticeNe[$key]['title'] = $val->TitleNepali;
                $noticeNe[$key]['slug'] = $val->slug;
                $noticeNe[$key]['description'] = $val->DescriptionNepali;
                $noticeNe[$key]['image'] = $doc;
                $noticeNe[$key]['type'] = $val->Type;
                $noticeNe[$key]['created'] = (new DateTime($val->datevalue))->format('M d, Y');
                $noticeNe[$key]['day'] = (new DateTime($val->datevalue))->format('d');
                $noticeNe[$key]['month'] = (new DateTime($val->datevalue))->format('F');
                $noticeNe[$key]['due'] = (new DateTime($val->due_date))->format('M d, Y');
                $noticeNe[$key]['dueday'] = (new DateTime($val->due_date))->format('d');
                $noticeNe[$key]['duemonth'] = (new DateTime($val->due_date))->format('F');
                $noticeNe[$key]['published'] = $val->datevalue;
                $noticeNe[$key]['due_date'] = $val->due_date;
                $noticeNe[$key]['created_on'] = $val->created_on;
                
            }
            $noticestotal = $this->crud_model->count_allIN($this->table, $notice_param, 'id'); 
            
         
            if($noticestotal){ 
                $response=array(
                        'status' => "Success",
                        'status_code' => 200,
                        'status_message' => "Item List",
                        'items' => [
                            'en' =>$noticeEn,
                            'np' => $noticeNe
                        ],
                        'total' => $noticestotal,
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
    
    
    public function detail($slug)
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
                $noticeEn = [];
                $noticeNe = [];
                $sql = "id, DocPath,CoverImage, Description, DescriptionNepali, Title, TitleNepali, datevalue, due_date, created_on, slug";
                $detail = $this->crud_model->getDetail($this->table, array('slug'=>$slug,'status'=>['1','3']), $sql);
                if($detail){ 
                    $doc = '';
                    $file='';
                    if($detail->CoverImage){
                        $doc = base_url($detail->CoverImage);
                    }
                    if($detail->DocPath){
                        $file = base_url($detail->DocPath);
                    }
                    //for english
                    $noticeEn['id'] = $detail->id;
                    $noticeEn['title'] = $detail->Title;
                    $noticeEn['slug'] = $detail->slug;
                    $noticeEn['description'] = $detail->Description;
                    $noticeEn['image'] = $doc;
                    $noticeEn['file'] = $file;
                    $noticeEn['created'] = (new DateTime($detail->datevalue))->format('M d, Y');
                    $noticeEn['day'] = (new DateTime($detail->datevalue))->format('d');
                    $noticeEn['month'] = (new DateTime($detail->datevalue))->format('F');
                    $noticeEn['due'] = (new DateTime($detail->due_date))->format('M d, Y');
                    $noticeEn['dueday'] = (new DateTime($detail->due_date))->format('d');
                    $noticeEn['duemonth'] = (new DateTime($detail->due_date))->format('F');
                    $noticeEn['published'] = $detail->datevalue;
                    $noticeEn['due_date'] = $detail->due_date;
                    $noticeEn['created_on'] = $detail->created_on;
                    

                    //for neapli
                    $noticeNe['id'] = $detail->id;
                    $noticeNe['title'] = $detail->TitleNepali;
                    $noticeNe['slug'] = $detail->slug;
                    $noticeNe['description'] = $detail->DescriptionNepali;
                    $noticeNe['image'] = $doc;
                    $noticeNe['file'] = $file;
                    $noticeNe['created'] = (new DateTime($detail->datevalue))->format('M d, Y');
                    $noticeNe['day'] = (new DateTime($detail->datevalue))->format('d');
                    $noticeNe['month'] = (new DateTime($detail->datevalue))->format('F');
                    $noticeNe['due'] = (new DateTime($detail->due_date))->format('M d, Y');
                    $noticeNe['dueday'] = (new DateTime($detail->due_date))->format('d');
                    $noticeNe['duemonth'] = (new DateTime($detail->due_date))->format('F');
                    $noticeNe['published'] = $detail->datevalue;
                    $noticeNe['due_date'] = $detail->due_date;
                    $noticeNe['created_on'] = $detail->created_on;
                }
                
                if(!empty($detail)){
                    $response = array(
                        'status' => "success",
                        'status_code' => 200,
                        'status_message' => "Data Retreived Successfully",
                        'detail' => [
                            'en' => $noticeEn,
                            'ne' => $noticeNe
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