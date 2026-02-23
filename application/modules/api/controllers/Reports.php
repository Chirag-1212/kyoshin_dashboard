<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Reports extends Front_controller
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
        $this->table = 'report_category'; 
        $this->title = 'Report';
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
                $categoryIds = array_unique(array_filter(array_column($this->crud_model->getData('report', array_merge($param), ['title' => $_GET['title']], 1000, 0, 'category_id', 'id DESC'), 'category_id')));
                
            }
         
            $reportEn = [];
            $reportNe = [];
            $sql_cat = "id, title, title_nepali";
            $items = $this->crud_model->getAllData('report_category',$param,$categoryIds, 'id', 1000, 0, $sql_cat,'serial ASC');  
            $items_new = array();
            
            foreach($items as $key1=>$val1){
                $reportEn[$key1]['id'] = $val1->id;
                $reportEn[$key1]['cat_title'] = $val1->title;

                $reportNe[$key1]['id'] = $val1->id;
                $reportNe[$key1]['cat_title'] = $val1->title_nepali?:'';
                $sql_en = "id,DocPath,title_nepali, title, created, category_id";
                $reports_english = $this->crud_model->get_sql_all('report',array('status' => '1', 'category_id' => $val1->id),'Serial', 'ASC',1000, 0,$sql_en);  
                $childEn = [];
                $childNe = [];
                foreach($reports_english as $key=>$val){
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
                $reportEn[$key1]['child'] = $childEn;
                $reportNe[$key1]['child'] = $childNe;
            }
            
            
            $response = array(
                'status' => "success",
                'status_code' => 200,
                'status_message' => "Data Retreived Successfully",
                'reports_category' => [
                    'en' =>$reportEn,
                    'np' => $reportNe
                ], 
            );
        }
        
        $json_response = json_encode($response);
        echo $json_response;
    } 
    
    
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
            $cat_detail = $this->crud_model->get_where_single('report_category', array('slug'=>$cat_slug,'status'=>'1'));
            
            
            $sql_en = "id,title,slug, DocPath, fiscal_id, created, category_id";
            $items_english = $this->crud_model->get_sql_all('report',array('status' => '1', 'category_id' => $cat_detail->id),'id', 'DESC',$per_page, $page,$sql_en);  
            
            foreach($items_english as $key=>$val){
                if($val->DocPath){
                    $items_english[$key]->DocPath = base_url($val->DocPath);
                } 
                $items_english[$key]->created = (new DateTime($val->created))->format('Y-m-d');
            }
            
            $sql_np = "id,title_nepali as title, slug, DocPath, fiscal_id, created, category_id";
            $items_nepali = $this->crud_model->get_sql_all('report',array('status' => '1',  'category_id' => $cat_detail->id),'id', 'DESC',$per_page, $page,$sql_np);  
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
            $total = $this->crud_model->count_all('report', array('status' => '1', 'category_id' => $cat_detail->id), 'id'); 
            
            //  $sql_services = "id, PageTitleNepali, PageTitle, slug,Type";
            //     // $getServices = $this->crud_model->getData($this->table, array('status' => '1',  'Type' => 'Disclosure'),[], $per_page, $page, $sql_services,'rank ASC');
            //     $getServices = $this->crud_model->getData($this->table, array('status' => '1'),[], $per_page, $page, $sql_services,'rank ASC');
                
            //     $DisclosureEn = [];
            //     $DisclosureNe = [];
            //     foreach($getServices as $key=>$val){
            //         //for english
            //         $DisclosureEn[$key]['id'] = $val->id;
            //         $DisclosureEn[$key]['title'] = $val->PageTitle;
            //         $DisclosureEn[$key]['slug'] = $val->slug;
            //         $DisclosureEn[$key]['type'] = $val->Type;
            //         //for neapli
            //         $DisclosureNe[$key]['id'] = $val->id;
            //         $DisclosureNe[$key]['title'] = $val->PageTitleNepali;
            //         $DisclosureNe[$key]['slug'] = $val->slug;
            //         $DisclosureEn[$key]['type'] = $val->Type;
            //     }
                
            //     $Disclosures = array(
            //         'en' =>$DisclosureEn,
            //         'np' => $DisclosureNe
            //     );
                
                // $getServices = $this->crud_model->getData($this->table, array('status' => '1',  'Type' => 'Report'),[], $per_page, $page, $sql_services,'rank ASC');
                
                // $ReportEn = [];
                // $ReportNe = [];
                // foreach($getServices as $key=>$val){
                //     //for english
                //     $ReportEn[$key]['id'] = $val->id;
                //     $ReportEn[$key]['title'] = $val->PageTitle;
                //     $ReportEn[$key]['slug'] = $val->slug;

                //     //for neapli
                //     $ReportNe[$key]['id'] = $val->id;
                //     $ReportNe[$key]['title'] = $val->PageTitleNepali;
                //     $ReportNe[$key]['slug'] = $val->slug;
                // }
                
                // $Reports = array(
                //     'en' =>$ReportEn,
                //     'np' => $ReportNe
                // );
                
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
                    // 'reports'=>$Reports,
                    // 'all_categories'=>$Disclosures,
                    'FY'=>$FY,
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
                
                $mainreport_category_en = [];
                $mainreport_category_ne = [];
                $sql_en_type = "id, PageTitleNepali, PageTitle, slug,Type, DocPath,parent_id";
                $main_category_detail=$this->crud_model->get_sql_all('report_category', array('status' => '1','parent_id'=>'0'),'rank','ASC', 1000, 0, $sql_en_type); 
          
                 foreach($main_category_detail as $key=>$val){
                    $doc = '';
                    if($val->DocPath){
                        $doc = base_url($val->DocPath);
                    }
                    $report_category_en[$key]=['id' => $val->id, 'title' => $val->PageTitle,'Type'=>$val->Type,'slug'=>$val->slug,'doc'=>$doc];
                     
                    $childs=$this->crud_model->get_sql_all('report_category', array('status' => '1','parent_id'=>$val->id),'rank','ASC', 1000, 0, $sql_en_type);
                     if (!empty($childs)) {
                         $report_category_en[$key]['child']  =  $this->get_childs_en($childs);
                    }
                    
                    $report_category_ne[$key]=['id' => $val->id, 'title' => $val->PageTitleNepali,'Type'=>$val->Type,'slug'=>$val->slug,'doc'=>$doc];
                     
                    $childs=$this->crud_model->get_sql_all('report_category', array('status' => '1','parent_id'=>$val->id),'rank','ASC', 1000, 0, $sql_en_type);
                     if (!empty($childs)) {
                         $report_category_ne[$key]['child']  =  $this->get_childs_ne($childs);
                    }
                 
                 }
                        
                if($main_category_detail){ 
                    $response=array(
                        'status' => "Success",
                        'status_code' => 200,
                        'status_message' => "Item List",
                       
                        'report_category' => [
                            'en' => $report_category_en,
                            'np' => $report_category_ne
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
        $sql_en = "id, PageTitleNepali, PageTitle, slug, Type, DocPath,parent_id";
        $report_category_ne = [];
        if (!empty($childs)) {
            foreach ($childs as $key => $value) {
                $new_childs = $this->crud_model->get_sql_all('report_category', array('status' => '1','parent_id'=>$value->id),'rank','ASC', 1000, 0, $sql_en);
               
              
               // $new_childs = $this->crud_model->getAllData('report_category', array_merge($this->param,['parent_id' => $value->id]), ['MAIN', 'BOTH'],'show_type',0, 0,$sql_en, 'rank ASC');  
                $report_category_ne[$key]  = ['id' => $value->id, 'title' => $value->PageTitle, 'slug' => $value->slug,'Type'=>$val->Type,];
                if (!empty($new_childs)) {
                    $report_category_ne[$key]['child']  = $this->get_childs_ne($new_childs);
                }
            }
        }
        return $report_category_ne;
    }
    
    
    public function get_childs_ne($childs = array())
    {
        
        $sql_en = "id, PageTitleNepali, PageTitle, slug,Type, DocPath,parent_id";
        $report_category_en = [];
        if (!empty($childs)) {
            foreach ($childs as $key => $value) {
                $new_childs = $this->crud_model->get_sql_all('report_category', array('status' => '1','parent_id'=>$value->id),'rank','ASC', 1000, 0, $sql_en);
                // $new_childs = $this->crud_model->getAllData('report_category', array_merge($this->param,['parent_id' => $value->id]), ['MAIN', 'BOTH'],'show_type',0, 0,$sql_en, 'rank ASC');  
                $report_category_en[$key]  = ['id' => $value->id, 'title' => $value->PageTitleNepali, 'slug' => $value->slug,'Type'=>$val->Type,];
                if (!empty($new_childs)) {
                    $report_category_en[$key]['child']  = $this->get_childs_ne($new_childs);
                }
            }
        }
        return $report_category_en;
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
                $sql_report = "id, PageTitleNepali, PageTitle, slug,Type, DocPath,parent_id";
                $getreport = $this->crud_model->getData($this->table, $this->param, $per_page, $offset, $sql_report);
                
                $categoryEn = [];
                $categoryNe = [];
                foreach($getreport as $key=>$val){
                    //for english
                    $categoryEn[$key]['id'] = $val->id;
                    $categoryEn[$key]['title'] = $val->PageTitle;
                    $categoryEn[$key]['slug'] = $val->slug;

                    //for neapli
                    $categoryNe[$key]['id'] = $val->id;
                    $categoryNe[$key]['title'] = $val->PageTitleNepali;
                    $categoryNe[$key]['slug'] = $val->slug;
                }
                
                $sql_report = "id,title,title_nepali, DocPath,description,description_nepali, fiscal_id, created, category_id, slug";
                $reportEn = [];
                $reportNe = [];
                $detail = $this->crud_model->getDetail('report', array('slug'=>$slug, 'status'=>['1','3']), $sql_report); 
            
                if($detail){
                    $doc = '';
                if($detail->DocPath){
                    $doc = base_url($detail->DocPath);
                }
                //for english
                $reportEn['id'] = $detail->id;
                $reportEn['title'] = $detail->title;
                $reportEn['slug'] = $detail->slug;
                $reportEn['description'] = $detail->description;
                $reportEn['doc'] = $doc;
                $reportEn['fiscal_id'] = $detail->fiscal_id;

                //for neapli
                $reportNe['id'] = $detail->id;
                $reportNe['title'] = $detail->title_nepali;
                $reportNe['slug'] = $detail->slug;
                $reportNe['description'] = $detail->description_nepali;
                $reportNe['doc'] = $doc;
                $reportNe['fiscal_id'] = $detail->fiscal_id;
                }
                
                if(!empty($detail)){
                    $response = array(
                        'status' => "success",
                        'status_code' => 200,
                        'status_message' => "Data Retreived Successfully",
                        'detail' => [
                            'en' => $reportEn,
                            'np' => $reportNe
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
    
    function all_reports($cat_slug='',$page=0)
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
        $cat_detail = $this->crud_model->get_where_single('report_category', array('slug'=>$cat_slug,'status'=>'1'));
       
        $fiscalSql = 'id, title, title_nepali';
        $fiscal_years = $this->crud_model->get_sql_all_no_pagination('fiscal_year', array('status' => '1'), 'title', 'DESC',$fiscalSql);
        $fiscal_yearEn = [];
        $fiscal_yearNe = [];
        
        if($fiscal_years){
            $counterEn = 0;
            $counterNe = 0;
            
            foreach($fiscal_years as $fy){
              
                $sql_en = "id,title,title_nepali,slug, DocPath, fiscal_id, created, category_id";
                $items = $this->crud_model->get_sql_all_no_pagination('report',array('status' => '1', 'category_id' => $cat_detail->id,'fiscal_id'=>$fy->id),'id', 'DESC',$sql_en);  
                $items_english = [];
                $items_nepali = [];
                
                foreach ($items as $val) {
                    $item_english = [
                        'id' => $val->id,
                        'title' => $val->title,
                        'slug' => $val->slug,
                        'fiscal_id' => $val->fiscal_id,
                        'category_id' => $val->category_id,
                        'created' => (new DateTime($val->created))->format('Y-m-d'),
                    ];
                    if ($val->DocPath) {
                        $item_english['DocPath'] = base_url($val->DocPath);
                    }
                    $items_english[] = $item_english;
        
                    $item_nepali = [
                        'id' => $val->id,
                        'title' => $val->title_nepali,
                        'slug' => $val->slug,
                        'fiscal_id' => $val->fiscal_id,
                        'category_id' => $val->category_id,
                        'created' => (new DateTime($val->created))->format('Y-m-d'),
                    ];
                    if ($val->DocPath) {
                        $item_nepali['DocPath'] = base_url($val->DocPath);
                    }
                    $items_nepali[] = $item_nepali;
                }
                
                $total = $this->crud_model->count_all('report', array('status' => '1', 'category_id' => $cat_detail->id,'fiscal_id'=>$fy->id), 'id'); 
               
                if($total > 0){
                    //for english
                    $fiscal_yearEn[$counterEn] = [
                        'id' => $fy->id,
                        'title' => $fy->title,
                        'category_name'=>$cat_detail->PageTitle,
                        'child' => $items_english,
                        'total' => $total,
                    ];
                    $counterEn++;
                    //for nepali
                    $fiscal_yearNe[$counterNe] = [
                        'id' => $fy->id,
                        'title' => $fy->title_nepali,
                        'category_name'=>$cat_detail->PageTitleNepali,
                        'child' => $items_nepali,
                        'total' => $total,
                    ];
                    $counterNe++;
                }
              
            }
        }
        
        // Check if there are items in either English or Nepali arrays
        if(!empty($fiscal_yearEn) || !empty($fiscal_yearNe)){ 
            $FY = [
                'en' => $fiscal_yearEn,
                'np' => $fiscal_yearNe,
            ];
            $response=array(
                'status' => "Success",
                'status_code' => 200,
                'status_message' => "Item List",
                'FY' => $FY,
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

      
    // function all_reports_old($cat_slug='',$page=0)
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
    //         if(!$cat_slug){
    //           $response=array(
    //                 'status' => "error",
    //                 'status_code' => 208,
    //                 'status_message' => "Category slug is required", 
    //             ); 
    //             $json_response = json_encode($response);
    //             echo $json_response;exit;
    //         }
    //         $per_page = 200;
    //         $cat_detail = $this->crud_model->get_where_single('report_category', array('slug'=>$cat_slug,'status'=>'1'));
           
    //         $fiscalSql = 'id, title, title_nepali';
    //         $fiscal_years = $this->crud_model->get_sql_all_no_pagination('fiscal_year', array('status' => '1'), 'title', 'DESC',$fiscalSql);
    //         $fiscal_yearEn = [];
    //         $fiscal_yearNe = [];
    //         if($fiscal_years){
               
    //             foreach($fiscal_years as $key=>$fy){
                  
    //                 $sql_en = "id,title,title_nepali,slug, DocPath, fiscal_id, created, category_id";
    //                 $items = $this->crud_model->get_sql_all_no_pagination('report',array('status' => '1', 'category_id' => $cat_detail->id,'fiscal_id'=>$fy->id),'id', 'DESC',$sql_en);  
    //                 $items_english = [];
    //                 $items_nepali = [];
    //                   foreach ($items as $val) {
    //                     $item_english = [
    //                         'id' => $val->id,
    //                         'title' => $val->title,
    //                         'slug' => $val->slug,
    //                         'fiscal_id' => $val->fiscal_id,
    //                         'category_id' => $val->category_id,
    //                         'created' => (new DateTime($val->created))->format('Y-m-d'),
    //                     ];
    //                     if ($val->DocPath) {
    //                         $item_english['DocPath'] = base_url($val->DocPath);
    //                     }
    //                     $items_english[] = $item_english;
            
    //                     $item_nepali = [
    //                         'id' => $val->id,
    //                         'title' => $val->title_nepali,
    //                         'slug' => $val->slug,
    //                         'fiscal_id' => $val->fiscal_id,
    //                         'category_id' => $val->category_id,
    //                         'created' => (new DateTime($val->created))->format('Y-m-d'),
    //                     ];
    //                     if ($val->DocPath) {
    //                         $item_nepali['DocPath'] = base_url($val->DocPath);
    //                     }
    //                     $items_nepali[] = $item_nepali;
    //                 }
    //                 // foreach($items as $key=>$val){
    //                 //     $items_english[$keys] = [
    //                 //             'id'=> $val->id,
    //                 //             'title' => $val->title,
    //                 //             'slug' => $val->slug,
    //                 //             'fiscal_id' => $val->fiscal_id,
    //                 //             'category_id' => $val->category_id,
    //                 //             'created' => (new DateTime($val->created))->format('Y-m-d'),
    //                 //         ];
    //                 //     if($val->DocPath){
    //                 //         $items_english[$key]['DocPath'] = base_url($val->DocPath);
    //                 //     } 
    //                 //     $items_nepali[$keys] = [
    //                 //             'id'=> $val->id,
    //                 //             'title' => $val->title_nepali,
    //                 //             'slug' => $val->slug,
    //                 //             'fiscal_id' => $val->fiscal_id,
    //                 //             'category_id' => $val->category_id,
    //                 //             'created' => (new DateTime($val->created))->format('Y-m-d'),
    //                 //         ];
    //                 //     if($val->DocPath){
    //                 //         $items_nepali[$key]['DocPath'] = base_url($val->DocPath);
    //                 //     } 
    //                 // }
    //                 $total = $this->crud_model->count_all('report', array('status' => '1', 'category_id' => $cat_detail->id,'fiscal_id'=>$fy->id), 'id'); 
                   
    //                 if($total>0){
    //                     //for english
    //                     $fiscal_yearEn[$key]['id'] = $fy->id;
    //                     $fiscal_yearEn[$key]['title'] = $fy->title;
    //                     $fiscal_yearEn[$key]['child'] = $items_english;
    //                     $fiscal_yearEn[$key]['total'] = $total;
                
    //                     //for neapli
    //                     $fiscal_yearNe[$key]['id'] = $fy->id;
    //                     $fiscal_yearNe[$key]['title'] = $fy->title_nepali;
    //                     $fiscal_yearNe[$key]['child'] = $items_nepali;
    //                     $fiscal_yearNe[$key]['total'] = $total;
    //                 }
                  
    //             }
    //             // $FY = [
    //             //     'en' => $fiscal_yearEn,
    //             //     'np' => $fiscal_yearNe,
    //             // ];
                    
    //         }
    //         if(!empty($fiscal_yearEn) || !empty($fiscal_yearNe)){ 
    //             $FY = [
    //                 'en' => $fiscal_yearEn,
    //                 'np' => $fiscal_yearNe,
    //             ];
    //             $response=array(
    //                 'status' => "Success",
    //                 'status_code' => 200,
    //                 'status_message' => "Item List",
    //                 'FY' => $FY,
    //             );
    //         }else{
    //             $response=array(
    //                 'status' => "error",
    //                 'status_code' => 208,
    //                 'status_message' => "No Items Found", 
    //             );
    //         } 
          
    //         // if($FY){ 
    //         //     $response=array(
    //         //         'status' => "Success",
    //         //         'status_code' => 200,
    //         //         'status_message' => "Item List",
    //         //         'FY'=>$FY,
    //         //     );
    //         // }else{
    //         //     $response=array(
    //         //         'status' => "error",
    //         //         'status_code' => 208,
    //         //         'status_message' => "No Items Found", 
    //         //     );
    //         // } 
        
    //     } 
    //     $json_response = json_encode($response);
    //     echo $json_response;
    // } 
    
    //  function category($page=0)
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
            
    //         $per_page = 200;
    //          $sql_services = "id, PageTitleNepali, PageTitle, slug,Type";
    //             $getServices = $this->crud_model->getData($this->table, array('status' => '1'),[], $per_page, $page, $sql_services,'rank ASC');
                
    //             $DisclosureEn = [];
    //             $DisclosureNe = [];
    //             foreach($getServices as $key=>$val){
    //                 //for english
    //                 $DisclosureEn[$key]['id'] = $val->id;
    //                 $DisclosureEn[$key]['title'] = $val->PageTitle;
    //                 $DisclosureEn[$key]['slug'] = $val->slug;
    //                 $DisclosureEn[$key]['type'] = $val->Type;
    //                 //for neapli
    //                 $DisclosureNe[$key]['id'] = $val->id;
    //                 $DisclosureNe[$key]['title'] = $val->PageTitleNepali;
    //                 $DisclosureNe[$key]['slug'] = $val->slug;
    //                 $DisclosureNe[$key]['type'] = $val->Type;
    //             }
                
    //             $Disclosures = array(
    //                 'en' =>$DisclosureEn,
    //                 'np' => $DisclosureNe
    //             );
                
              
    //         if($Disclosures){ 
    //             $response=array(
    //                 'status' => "Success",
    //                 'status_code' => 200,
    //                 'status_message' => "Item List",
    //                 'all_categories'=>$Disclosures,
    //                 'total' => $total,
    //                 'per_page' => $per_page,
    //             );
    //         }else{
    //             $response=array(
    //                 'status' => "error",
    //                 'status_code' => 208,
    //                 'status_message' => "No Items Found", 
    //             );
    //         } 
        
    //     } 
    //     $json_response = json_encode($response);
    //     echo $json_response;
    // } 
}
