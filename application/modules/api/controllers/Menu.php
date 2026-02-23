<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Menu extends Front_controller
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
        // $this->loggedinUser = $authKeyFromApp['Authorization'];
        $this->table = 'content'; 
        $this->title = 'Menu';
        $this->param = [
            'status' => '1', 
            'show_on_menu' =>'Yes'
        ];
    } 
    
    function main($page=1)
    { 
        header('Access-Control-Allow-Method:GET');
        if ($this->request_method != "GET") {
            $response=array(
                'status' => "Error",
                'status_code' => 204,
                'status_message' => "Access Method Not Allowed",
            );
        } else {  
                $menuEn = $this->get_parents();
                $menuNe = $this->get_parents_ne();
                
                $menus = array(
                    'en' => $menuEn,
                    'np' => $menuNe,
                );
                if($menus){ 
                    
                    $response=array(
                            'status' => "Success",
                            'status_code' => 200,
                            'status_message' => "Item List",
                            'menu' => $menus,
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

	public function get_parents()
    {
        $html = [];
        $sql_en = "PageTitle, slug, PageTitleNepali, link, id";
        $parents = $this->crud_model->getAllData($this->table, array_merge($this->param,['parent_id' => 0]), ['MAIN', 'BOTH'],'show_type',0, 0,$sql_en, 'rank ASC');  
        
        if ($parents) {
            foreach ($parents as $key => $value) {

                $html[$key]  = ['id' => $value->id, 'title' => $value->PageTitle, 'slug' => ($value->slug == 'home') ? '' : $value->slug, 'link' => $value->link, 'PageTitleNepali' => $value->PageTitleNepali];
                $childs = $this->crud_model->getAllData($this->table, array_merge($this->param,['parent_id' => $value->id]), ['MAIN', 'BOTH'],'show_type',0, 0,$sql_en, 'rank ASC');  
                if (!empty($childs)) {
                    $html[$key]['child']  =  $this->get_childs_menu($childs);
                }else{
                    $new_childs = [];
                    switch ($value->slug){
                        case 'our-services':
                            // $new_childs = $this->crud_model->getDataArray('service', ['status' => '1','parent_id'=>'0'],'id, slug,Title as title','serial ASC'); 
                            $new_childs = $this->crud_model->getDataArray('services', ['status' => '1'],'id, slug,Title as title','Serial ASC'); 
                            $html[$key]['child']  =$new_childs; 
                        break;
                        case 'investor-relation':
                            $new_childs = $this->crud_model->getDataArray('report_category', ['status' => '1'],'id, slug,PageTitle as title', 'rank ASC'); 
                            $html[$key]['child']  =$new_childs; 
                        break;
                         case 'rates':
                            $new_childs = $this->crud_model->getDataArray('rates_category', ['status' => '1'],'id, slug,PageTitle as title', 'rank ASC'); 
                            $html[$key]['child']  =$new_childs; 
                        break;
                        case 'deposit':
                            $new_childs = $this->crud_model->getDataArray('deposit', ['status' => '1'],'id, slug,Title as title', 'serial ASC'); 
                            $html[$key]['child']  =$new_childs; 
                        break;
                        case 'loan':
                            $new_childs = $this->crud_model->getDataArray('loan', ['status' => '1'],'id, slug,Title as title', 'serial ASC'); 
                            $html[$key]['child']  =$new_childs; 
                        break;
                        case 'report':
                            $new_childs = $this->crud_model->getDataArray('report_category', ['status' => '1','show_on_menu'=>'Yes'],'id, slug,PageTitle as title', 'rank ASC'); 
                             foreach ($new_childs as $keys => $value) {
                                // $params = [
                                //     'parent_id' => $value['id'],
                                //     'status' => '1'
                                // ];
                                $reportCategory[$keys]['id'] = $value['id'];
                                $reportCategory[$keys]['slug'] = $value['slug'];
                                $reportCategory[$keys]['title'] = $value['title'];
                                // $reportCategory[$keys]['products'] =$this->crud_model->getDataArray('report_category', array_merge($this->param,['parent_id' => $value['id']]), 'id, slug, PageTitle as title','rank ASC'); 
                            }
                            
                            $html[$key]['child']  =$reportCategory; 
                        break;
                        // case 'investor-relation':
                        //     $reportCategory = [];
                        //     $new_childs = $this->crud_model->getDataArray('report_category', array_merge($this->param,['parent_id' => 0]), 'id, slug, PageTitle as title, type','rank ASC'); 
                        //     foreach ($new_childs as $keys => $value) {
                        //         $params = [
                        //             'product_cat' => $value['id'],
                        //             'status' => '1'
                        //         ];
                        //         $reportCategory[$keys]['id'] = $value['id'];
                        //         $reportCategory[$keys]['slug'] = $value['slug'];
                        //         $reportCategory[$keys]['title'] = $value['title'];
                        //         $reportCategory[$keys]['products'] =$this->crud_model->getDataArray('report_category', array_merge($this->param,['parent_id' => $value['id']]), 'id, slug, PageTitle as title','Serial ASC'); 
                        //     }
                            
                        //     $html[$key]['child']  =$reportCategory; 
                        // break;
                         
                        case 'products':
                            $productCategory = [];
                            $new_childs = $this->crud_model->getDataArray('product_category', ['status' => '1'], 'id, slug, title','order_no ASC'); 
                            foreach ($new_childs as $keys => $value) {
                                $params = [
                                    'product_cat' => $value['id'],
                                    'status' => '1'
                                ];
                                $productCategory[$keys]['id'] = $value['id'];
                                $productCategory[$keys]['slug'] = $value['slug'];
                                $productCategory[$keys]['title'] = $value['title'];
                                $productCategory[$keys]['products'] =$this->crud_model->getDataArray('products', $params, 'id, slug, title','Serial ASC'); 
                            }
                            $html[$key]['child']  =$productCategory; 
                        break;
                        default:
                    }
                }
            }
        }

        return $html;
    }

    public function get_childs_menu($childs = array())
    {
        $sql_en = "PageTitle, slug, PageTitleNepali, link,  id";
        $html = [];
        if (!empty($childs)) {
            foreach ($childs as $key => $value) {
                $new_childs = $this->crud_model->getAllData($this->table, array_merge($this->param,['parent_id' => $value->id]), ['MAIN', 'BOTH'],'show_type',0, 0,$sql_en, 'rank ASC');  
                $html[$key]  = [
                    'id' => $value->id, 
                    'title' => $value->PageTitle, 
                    'slug' => ($value->PageTitle == 'home') ? '' : $value->slug,
                    'PageTitleNepali' => $value->PageTitleNepali,
                    'link' => $value->link,
                    ];
                if (!empty($new_childs)) {
                    // $html[$key]  = ['id' => $value->id, 'title' => $value->PageTitle, 'slug' => ($value->PageTitle == 'home') ? '' : $value->PageTitle, 'PageTitleNepali' => $value->PageTitleNepali];
                    $html[$key]['child']  = $this->get_childs_menu($new_childs);
                }
            }
        }
        return $html;
    }

    public function get_parents_ne()
    {
        $html = [];
        $sql_en = "PageTitle, slug, PageTitleNepali, link, id";
        $parents = $this->crud_model->getAllData($this->table, array_merge($this->param,['parent_id' => 0]), ['MAIN', 'BOTH'],'show_type',0, 0,$sql_en, 'rank ASC');  
        
        if ($parents) {
            foreach ($parents as $key => $value) {

                $html[$key]  = ['id' => $value->id, 'title' => $value->PageTitleNepali, 'link' => $value->link, 'slug' => ($value->slug == 'home') ? '' : $value->slug,  'PageTitleNepali' => $value->PageTitleNepali];
                $childs = $this->crud_model->getAllData($this->table, array_merge($this->param,['parent_id' => $value->id]), ['MAIN', 'BOTH'],'show_type',0, 0,$sql_en, 'rank ASC');  
                if (!empty($childs)) {
                     $html[$key]['child']  =  $this->get_childs_ne($childs);
                }else{
                    $new_childs = [];
                   switch ($value->slug){
                        case 'our-services':
                            // $new_childs = $this->crud_model->getDataArray('service_category', ['status' => '1','parent_id'=>'0' ], 'id, slug, TitleNepali as title'); 
                             $new_childs = $this->crud_model->getDataArray('services', ['status' => '1'],'id, slug,TitleNepali as title','Serial ASC'); 
                            $html[$key]['child']  =$new_childs; 
                        break;
                        case 'investor-relation':
                            $new_childs = $this->crud_model->getDataArray('report_category', ['status' => '1'],'id, slug,PageTitleNepali as title', 'rank ASC'); 
                            $html[$key]['child']  =$new_childs; 
                        break;
                         case 'rates':
                            $new_childs = $this->crud_model->getDataArray('rates_category', ['status' => '1'],'id, slug,PageTitleNepali as title', 'rank ASC'); 
                            $html[$key]['child']  =$new_childs; 
                        break;
                        case 'deposit':
                            $new_childs = $this->crud_model->getDataArray('deposit', ['status' => '1'],'id, slug,TitleNepali as title', 'serial ASC'); 
                            $html[$key]['child']  =$new_childs; 
                        break;
                        case 'loan':
                            $new_childs = $this->crud_model->getDataArray('loan', ['status' => '1'],'id, slug,TitleNepali as title', 'serial ASC'); 
                            $html[$key]['child']  =$new_childs; 
                        break;
                        case 'report':
                            $new_childs = $this->crud_model->getDataArray('report_category', ['status' => '1','show_on_menu'=>'Yes'],'id, slug,PageTitleNepali as title', 'rank ASC'); 
                            foreach ($new_childs as $keys => $value) {
                                // $params = [
                                //     'parent_id' => $value['id'],
                                //     'status' => '1'
                                // ];
                                $reportCategory[$keys]['id'] = $value['id'];
                                $reportCategory[$keys]['slug'] = $value['slug'];
                                $reportCategory[$keys]['title'] = $value['title'];
                                // $reportCategory[$keys]['products'] =$this->crud_model->getDataArray('report_category', array_merge($this->param,['parent_id' => $value['id']]), 'id, slug, PageTitleNepali as title','rank ASC'); 
                            }
                            
                            $html[$key]['child']  =$reportCategory; 
                        break;
                        // case 'report':
                        //     $new_childs = $this->crud_model->getDataArray('report_category', ['status' => '1'],'id, slug,PageTitleNepali as title'); 
                        //     $html[$key]['child']  =$new_childs; 
                        // break;
                        // case 'investor-relation':
                        //     $reportCategory = [];
                        //     $new_childs = $this->crud_model->getDataArray('report_category', array_merge($this->param,['parent_id' => 0]), 'id, slug, PageTitleNepali as title, type','rank ASC'); 
                        //     foreach ($new_childs as $keys => $value) {
                        //         $params = [
                        //             'product_cat' => $value['id'],
                        //             'status' => '1'
                        //         ];
                        //         $reportCategory[$keys]['id'] = $value['id'];
                        //         $reportCategory[$keys]['slug'] = $value['slug'];
                        //         $reportCategory[$keys]['title'] = $value['title'];
                        //         $reportCategory[$keys]['products'] =$this->crud_model->getDataArray('report_category', array_merge($this->param,['parent_id' => $value['id']]), 'id, slug, PageTitleNepali as title','Serial ASC'); 
                        //     }
                            
                        //     $html[$key]['child']  =$reportCategory; 
                        // break;
                        case 'products':
                            $productCategory = [];
                            $new_childs = $this->crud_model->getDataArray('product_category', ['status' => '1'], 'id, slug, title_nepali as title','order_no ASC'); 
                            foreach ($new_childs as $keys => $value) {
                                $params = [
                                    'product_cat' => $value['id'],
                                    'status' => '1'
                                ];
                                $productCategory[$keys]['id'] = $value['id'];
                                $productCategory[$keys]['slug'] = $value['slug'];
                                $productCategory[$keys]['title'] = $value['title'];
                                $productCategory[$keys]['products'] =$this->crud_model->getDataArray('products', $params, 'id, slug, title_nepali as title','Serial ASC'); 
                            }
                            $html[$key]['child']  =$productCategory; 
                        break;
                        default:
                            
                    }
                    
                }
                
            }
        }

        return $html;
    }

    public function get_childs_ne($childs = array())
    {
        $sql_en = "PageTitle, slug, PageTitleNepali, link, id";
        $html = [];
        if (!empty($childs)) {
            foreach ($childs as $key => $value) {
                $new_childs = $this->crud_model->getAllData($this->table, array_merge($this->param,['parent_id' => $value->id]), ['MAIN', 'BOTH'],'show_type',0, 0,$sql_en, 'rank ASC');  
                $html[$key]  = ['id' => $value->id, 'title' => $value->PageTitleNepali, 'link' => $value->link, 'slug' => ($value->PageTitle == 'home') ? '' : $value->slug, 'PageTitleNepali' => $value->PageTitleNepali];
                if (!empty($new_childs)) {
                    $html[$key]['child']  = $this->get_childs_ne($new_childs);
                }
            }
        }
        return $html;
    }
    
    function top($page=1)
    { 
        header('Access-Control-Allow-Method:GET');
        if ($this->request_method != "GET") {
            $response=array(
                'status' => "Error",
                'status_code' => 204,
                'status_message' => "Access Method Not Allowed",
            );
        } else {  
                $per_page = 35;
                $offset = ($page*$per_page - $per_page); 
                            
                $total = $this->crud_model->total($this->table, array_merge($this->param, ['show_type' => 'TOP']),[], 'id'); 
                
                if($total){ 
                    $menuNe = $this->get_parents_top_ne()?:[];
                    $menuEn = $this->get_parents_top_en()?:[];
                    $response=array(
                            'status' => "Success",
                            'status_code' => 200,
                            'status_message' => "Item List",
                            'items' => [
                                'en' =>$menuEn,
                                'np' => $menuNe
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
    
    public function get_parents_top_en()
    {
        $html = [];
        $sql_en = "PageTitle, slug, PageTitleNepali, link, id";
        $parents = $this->crud_model->getAllData($this->table, array_merge($this->param,['parent_id' => 0, 'show_type' => 'TOP']), [],'',0, 0,$sql_en, 'rank ASC');  
        
        if ($parents) {
            foreach ($parents as $key => $value) {

                $html[$key]  = ['id' => $value->id, 'title' => $value->PageTitle, 'slug' => ($value->slug == 'home') ? '/' : $value->slug, 'link' => $value->link, 'PageTitleNepali' => $value->PageTitleNepali];
                $childs = $this->crud_model->getAllData($this->table, array_merge($this->param,['parent_id' => $value->id, 'show_type' => 'TOP']), [],'',0, 0,$sql_en, 'rank ASC');  
                if (!empty($childs)) {
                    $html[$key]['child']  =  $this->get_childs_top_en($childs);
                }
            }
        }

        return $html;
    }

    public function get_childs_top_en($childs = array())
    {
        $sql_en = "PageTitle, slug, PageTitleNepali, link, id";
        $html = [];
        if (!empty($childs)) {
            foreach ($childs as $key => $value) {
                $new_childs = $this->crud_model->getAllData($this->table, array_merge($this->param,['parent_id' => $value->id, 'show_type' => 'TOP']), [],'',0, 0,$sql_en, 'rank ASC');  
                $html[$key]  = ['id' => $value->id, 'title' => $value->PageTitle, 'slug' => ($value->PageTitle == 'home') ? '' : $value->slug, 'link' => $value->link, 'PageTitleNepali' => $value->PageTitleNepali];
                if (!empty($new_childs)) {
                     $html[$key]['child']  = $this->get_childs_menu($new_childs);
                }
            }
        }
        return $html;
    }

    public function get_parents_top_ne()
    {
        $html = [];
        $sql_en = "PageTitle, slug, PageTitleNepali, link, id";
        $parents = $this->crud_model->getAllData($this->table, array_merge($this->param,['parent_id' => 0, 'show_type' => 'TOP']), [],'',0, 0,$sql_en, 'rank ASC');  
        
        if ($parents) {
            foreach ($parents as $key => $value) {

                $html[$key]  = ['id' => $value->id, 'title' => $value->PageTitleNepali, 'slug' => ($value->slug == 'home') ? '/' : $value->slug,  'link' => $value->link, 'PageTitleNepali' => $value->PageTitleNepali];
                $childs = $this->crud_model->getAllData($this->table, array_merge($this->param,['parent_id' => $value->id, 'show_type' => 'TOP']), [],'',0, 0,$sql_en, 'rank ASC');  
                if (!empty($childs)) {
                    $html[$key]['child']  =  $this->get_childs_top_ne($childs);
                }
                
            }
        }

        return $html;
    }

    public function get_childs_top_ne($childs = array())
    {
        $sql_en = "PageTitle, slug, link, PageTitleNepali, id";
        $html = [];
        if (!empty($childs)) {
            foreach ($childs as $key => $value) {
                $new_childs = $this->crud_model->getAllData($this->table, array_merge($this->param,['parent_id' => $value->id]), ['TOP'],'show_type',0, 0,$sql_en, 'rank ASC');  
                $html[$key]  = ['id' => $value->id, 'title' => $value->PageTitleNepali, 'slug' => ($value->PageTitle == 'home') ? '' : $value->slug, 'link' => $value->link, 'PageTitleNepali' => $value->PageTitleNepali];
                if (!empty($new_childs)) {
                    $html[$key]['child']  = $this->get_childs_ne($new_childs);
                }
            }
        }
        return $html;
    }

    function bottom()
    { 
        header('Access-Control-Allow-Method:GET');
        if ($this->request_method != "GET") {
            $response=array(
                'status' => "Error",
                'status_code' => 204,
                'status_message' => "Access Method Not Allowed",
            );
        } else {  
                
                $menuEn = $this->get_parents_bottom_en();
                $menuNe = $this->get_parents_bottom_ne();
                
                $menus = array(
                    'en' => $menuEn,
                    'np' => $menuNe,
                );
                if($menus){ 
                    
                    $response=array(
                            'status' => "Success",
                            'status_code' => 200,
                            'status_message' => "Item List",
                            'menu' => $menus,
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

    public function get_parents_bottom_en()
    {
        $html = [];
        $sql_en = "PageTitle, slug, PageTitleNepali, id";
        $parents = $this->crud_model->getAllData($this->table, array_merge($this->param,['parent_id' => 0]), ['BOTTOM', 'BOTH'],'show_type',0, 0,$sql_en, 'rank ASC');  
        
        if ($parents) {
            foreach ($parents as $key => $value) {

                $html[$key]  = ['id' => $value->id, 'title' => $value->PageTitle, 'slug' => ($value->PageTitle == 'home') ? '' : $value->slug,  'PageTitleNepali' => $value->PageTitleNepali];
                $childs = $this->crud_model->getAllData($this->table, array_merge($this->param,['parent_id' => $value->id]), ['BOTTOM', 'BOTH'],'show_type',0, 0,$sql_en, 'rank ASC');  
                if (!empty($childs)) {
                    $html[$key]  = ['id' => $value->id, 'title' => $value->PageTitle, 'slug' => ($value->PageTitle == 'home') ? '' : $value->slug, 'PageTitleNepali' => $value->PageTitleNepali];
                    $html[$key][]  =  $this->get_childs_bottom_en($childs);
                }
            }
        }

        return $html;
    }

    public function get_childs_bottom_en($childs = array())
    {
        $sql_en = "PageTitle, slug, PageTitleNepali, id";
        $html = [];
        if (!empty($childs)) {
            foreach ($childs as $key => $value) {
                $new_childs = $this->crud_model->getAllData($this->table, array_merge($this->param,['parent_id' => $value->id]), ['BOTTOM', 'BOTH'],'show_type',0, 0,$sql_en, 'rank ASC');  
                $html[$key]  = ['id' => $value->id, 'title' => $value->PageTitle, 'slug' => ($value->PageTitle == 'home') ? '' : $value->slug, 'PageTitleNepali' => $value->PageTitleNepali];
                if (!empty($new_childs)) {
                    $html[$key]  = ['id' => $value->id, 'title' => $value->PageTitle, 'slug' => ($value->PageTitle == 'home') ? '' : $value->slug, 'PageTitleNepali' => $value->PageTitleNepali];
                    $html[$key][]  = $this->get_childs_bottom_en($new_childs);
                }
            }
        }
        return $html;
    }

    public function get_parents_bottom_ne()
    {
        $html = [];
        $sql_en = "PageTitle, slug, PageTitleNepali, id";
        $parents = $this->crud_model->getAllData($this->table, array_merge($this->param,['parent_id' => 0]), ['BOTTOM', 'BOTH'],'show_type',0, 0,$sql_en, 'rank ASC');  
        
        if ($parents) {
            foreach ($parents as $key => $value) {

                $html[$key]  = ['id' => $value->id, 'title' => $value->PageTitleNepali, 'slug' => ($value->PageTitle == 'home') ? '' : $value->slug,  'PageTitleNepali' => $value->PageTitleNepali];
                $childs = $this->crud_model->getAllData($this->table, array_merge($this->param,['parent_id' => $value->id]), ['BOTTOM', 'BOTH'],'show_type',0, 0,$sql_en, 'rank ASC');  
                if (!empty($childs)) {
                    $html[$key]  = ['id' => $value->id, 'title' => $value->PageTitleNepali, 'slug' => ($value->PageTitle == 'home') ? '' : $value->slug, 'PageTitleNepali' => $value->PageTitleNepali];
                    $html[$key][]  =  $this->get_childs_bottom_ne($childs);
                }
            }
        }

        return $html;
    }

    public function get_childs_bottom_ne($childs = array())
    {
        $sql_en = "PageTitle, slug, PageTitleNepali, id";
        $html = [];
        if (!empty($childs)) {
            foreach ($childs as $key => $value) {
                $new_childs = $this->crud_model->getAllData($this->table, array_merge($this->param,['parent_id' => $value->id]), ['BOTTOM', 'BOTH'],'show_type',0, 0,$sql_en, 'rank ASC');  
                $html[$key]  = ['id' => $value->id, 'title' => $value->PageTitleNepali, 'slug' => ($value->PageTitle == 'home') ? '' : $value->slug, 'PageTitleNepali' => $value->PageTitleNepali];
                if (!empty($new_childs)) {
                    $html[$key]  = ['id' => $value->id, 'title' => $value->PageTitleNepali, 'slug' => ($value->PageTitle == 'home') ? '' : $value->slug, 'PageTitleNepali' => $value->PageTitleNepali];
                    $html[$key][]  = $this->get_childs_bottom_ne($new_childs);
                }
            }
        }
        return $html;
    }
}