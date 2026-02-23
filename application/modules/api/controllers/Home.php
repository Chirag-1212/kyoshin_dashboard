<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Home extends Front_controller
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
        // $this->loggedinUser = $authKeyFromApp['Authorization'];
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
            //banners
            $banners = $this->crud_model->get_banners();
            foreach($banners as $key=>$val){
                $banners[$key]->file = isset($val->file)?base_url().$val->file:'';
            }
            //banner ends 
            
            //rangeProducts from loan and deposit category
            
             $rangeProducts = $this->crud_model->get_home_product();
          
            foreach($rangeProducts as $key=>$val){
                
                $rangeProducts[$key]->file = isset($val->file)?base_url($val->file):'';
            } 
            
        
            //about us
            // $about = $this -> crud_model -> getDetail('content', ['parent_id' => 6, 'show_type' => 'MAIN', 'status' => '1']);
           
            // $aboutDetail = [
            //     'en' => [
            //         'id' => $about->id,
            //         'title' => $about -> PageTitle,
            //         'slug' => $about->slug,
            //         'description' => $about->Description,
            //         'featured_img' => $about->CoverImage,
            //         ],
            //     'np' => [
            //         'id' => $about->id,
            //         'title' => $about->PageTitleNepali	,
            //         'slug' => $about->slug,
            //         'description' => $about->DescriptionNepali,
            //         'featured_img' => $about->CoverImage,
            //         ],
            // ];
            
            $chairperson_msg = $this -> crud_model -> getDetail('content', ['parent_id' => 56, 'show_type' => 'MAIN', 'status' => '1']);
        //   var_dump($chairperson_msg); die;
            $chairperson_msgDetail = [
                'en' => [
                    'id' => $chairperson_msg->id,
                    'title' => $chairperson_msg -> PageTitle,
                    'slug' => $chairperson_msg->slug,
                    'description' => $chairperson_msg->Description,
                    'featured_img' => $chairperson_msg->CoverImage,
                    ],
                'np' => [
                    'id' => $chairperson_msg->id,
                    'title' => $chairperson_msg->PageTitleNepali	,
                    'slug' => $chairperson_msg->slug,
                    'description' => $chairperson_msg->DescriptionNepali,
                    'featured_img' => $chairperson_msg->CoverImage,
                    ],
            ];
            
            //Our Digital Service start
            // $sql_en_type = "id,Title, TitleNepali, DocPath,slug,parent_id";
            // $main_category_detail=$this->crud_model->getData('service_category', array('status' => '1','show_home'=>'Y'),[], 8, 0, $sql_en_type,'updated_on DESC'); 
            $sql_en_type = "id,Title, TitleNepali, DocPath,slug,datevalue, Serial";
            $main_category_detail=$this->crud_model->getData('services', array('status' => '1'),[], 8, 0, $sql_en_type,'Serial ASC');  
           
            $servicesEn=[];
            $servicesNe=[];
            foreach($main_category_detail as $key=>$val){
                    $servicesEn[$key]['id'] = $val->id;
                    $servicesEn[$key]['title'] = $val->Title;
                    $servicesEn[$key]['slug'] = $val->slug;
                    $servicesEn[$key]['image'] = isset($val->DocPath)?base_url().$val->DocPath:'';
                    
                    $servicesNe[$key]['id'] = $val->id;
                    $servicesNe[$key]['title'] = $val->TitleNepali;
                    $servicesNe[$key]['slug'] = $val->slug;
                    $servicesNe[$key]['image'] = isset($val->DocPath)?base_url($val->DocPath):'';
            }
            $services = [
                'en' => $servicesEn,
                'np' => $servicesNe,
            ];
            //about ends

            
              //E-partners
            $getEpartners = $this->crud_model->getData('e_payment_partners', array('status'=>'1'), [], 10, 0, 'id, slug, title, featured_image as Image');
            $EpartnersEn = [];
            $EpartnersNe = [];
            if($getEpartners){
                foreach($getEpartners as $key=>$Epartner){
                    
                    $EpartnersEn[$key]['id'] = $Epartner->id;
                    $EpartnersEn[$key]['title'] = $Epartner->title;
                    $EpartnersEn[$key]['slug'] = $Epartner->slug;
                    $EpartnersEn[$key]['image'] = isset($Epartner->Image)?base_url().$Epartner->Image:'';
                    
                    $EpartnersNe[$key]['id'] = $Epartner->id;
                    $EpartnersNe[$key]['title'] = $Epartner->title;
                    $EpartnersNe[$key]['slug'] = $Epartner->slug;
                    $EpartnersNe[$key]['image'] = isset($Epartner->Image)?base_url($Epartner->Image):'';
                }
            }
            
            $Epartners = [
                'en' => $EpartnersEn,
                'np' => $EpartnersNe,
            ];
            
            
       
            
             // Notice Start 
            $noticessEn = [];
            $noticesNe = [];
            $sql_notices = "id, TitleNepali, Title, slug, DocPath, datevalue, due_date, created_on, slug, lastmodified";
            $getnotices = $this->crud_model->getDataIN('career', array('status'=>['1','3'],'Type'=>'notices'), [], 4, 0, $sql_notices,'datevalue DESC');
            if($getnotices){
                foreach($getnotices as $key=>$news){
                    $year=(new DateTime($news->datevalue))->format('Y');
                    $month=(new DateTime($news->datevalue))->format('m');
                    $day=(new DateTime($news->datevalue))->format('d');
                    $npdate=$this->nepali_calendar->AD_to_BS($year,$month,$day);
                    $noticesEn[$key]['id'] = $news->id;
                    $noticesEn[$key]['title'] = $news->Title;
                    $noticesEn[$key]['created'] = (new DateTime($news->datevalue))->format('M d, Y');
                    $noticesEn[$key]['day'] = (new DateTime($news->datevalue))->format('d');
                    $noticesEn[$key]['month'] = (new DateTime($news->datevalue))->format('F');
                    $noticesEn[$key]['published'] = (new DateTime($news->datevalue))->format('M d, Y');
                    $noticesEn[$key]['slug'] = $news->slug;
                    $noticesEn[$key]['nepali_date'] = $npdate;
                    
                    $noticesNe[$key]['id'] = $news->id;
                    $noticesNe[$key]['title'] = $news->TitleNepali;
                    $noticesNe[$key]['created'] = (new DateTime($news->datevalue))->format('M d, Y');
                    $noticesNe[$key]['day'] = (new DateTime($news->datevalue))->format('d');
                    $noticesNe[$key]['month'] = (new DateTime($news->datevalue))->format('F');
                    $noticesNe[$key]['published'] = (new DateTime($news->datevalue))->format('M d, Y');
                    $noticesNe[$key]['slug'] = $news->slug;
                    $noticesNe[$key]['nepali_date'] = $npdate;
                }
            }
            
            $notices = [
                'en' => $noticesEn,
                'np' => $noticesNe,
            ];
            //Notice End
            // important news Start
            $impnewsEn = [];
            $impnewsNe = [];
            $sql_impnews = "id, TitleNepali, Title, slug, DocPath, datevalue, due_date, created_on, slug, lastmodified";
            $getimpNews = $this->crud_model->getDataIN('career', array('status'=>['1','3'],'Type'=>'notices','imp_notice'=>'Y'), [], 4, 0, $sql_impnews,'datevalue DESC');
            // var_dump($this->db->last_query(),$getimpNews); die;
            if($getimpNews){
                foreach($getimpNews as $key=>$news){
                    $impnewsEn[$key]['id'] = $news->id;
                    $impnewsEn[$key]['title'] = $news->Title;
                    // $impnewsEn[$key]['created'] =$news->created_on;
                    // $impnewsEn[$key]['due_date'] =$news->due_date;
                    $impnewsEn[$key]['created'] = (new DateTime($news->datevalue))->format('M d, Y');
                    $impnewsEn[$key]['day'] = (new DateTime($news->datevalue))->format('d');
                    $impnewsEn[$key]['month'] = (new DateTime($news->datevalue))->format('F');
                    $impnewsEn[$key]['due'] = (new DateTime($news->due_date))->format('M d, Y');
                    $impnewsEn[$key]['dueday'] = (new DateTime($news->due_date))->format('d');
                    $impnewsEn[$key]['duemonth'] = (new DateTime($news->due_date))->format('F');
                    $impnewsEn[$key]['published'] = (new DateTime($news->datevalue))->format('M d, Y');
                    $impnewsEn[$key]['slug'] = $news->slug;
                    $impnewsEn[$key]['image'] = isset($news->DocPath)?base_url().$news->DocPath:'';
                    
                    $impnewsNe[$key]['id'] = $news->id;
                    $impnewsNe[$key]['title'] = $news->TitleNepali;
                    // $impnewsNe[$key]['created'] =$news->created_on;
                    // $impnewsNe[$key]['due_date'] =$news->due_date;
                    $impnewsNe[$key]['created'] = (new DateTime($news->datevalue))->format('M d, Y');
                    $impnewsNe[$key]['day'] = (new DateTime($news->datevalue))->format('d');
                    $impnewsNe[$key]['month'] = (new DateTime($news->datevalue))->format('F');
                    $impnewsNe[$key]['due'] = (new DateTime($news->due_date))->format('M d, Y');
                    $impnewsNe[$key]['dueday'] = (new DateTime($news->due_date))->format('d');
                    $impnewsNe[$key]['duemonth'] = (new DateTime($news->due_date))->format('F');
                    $impnewsNe[$key]['published'] = (new DateTime($news->datevalue))->format('M d, Y');
                    $impnewsNe[$key]['slug'] = $news->slug;
                    $impnewsNe[$key]['image'] = isset($news->DocPath)?base_url().$news->DocPath:'';
                }
            }
            
            $ImpNews = [
                'en' => $impnewsEn,
                'np' => $impnewsNe,
            ];
           
            //ALL news
            $newsEn = [];
            $newsNe = [];
            $sql_news = "id, TitleNepali, Title, slug, DocPath, datevalue, due_date, created_on, slug, lastmodified";
            $getNews = $this->crud_model->getDataIN('career', array('status'=>['1','3'],'Type'=>'news'), [], 4, 0, $sql_news,'datevalue DESC');
            if($getNews){
                foreach($getNews as $key=>$news){
                    $year=(new DateTime($news->datevalue))->format('Y');
                    $month=(new DateTime($news->datevalue))->format('m');
                    $day=(new DateTime($news->datevalue))->format('d');
                    $npdate=$this->nepali_calendar->AD_to_BS($year,$month,$day);
                    
                    $newsEn[$key]['id'] = $news->id;
                    $newsEn[$key]['title'] = $news->Title;
                    // $newsEn[$key]['due_date'] = $news->due_date;
                    // $newsEn[$key]['created'] =$news->created_on;
                    $newsEn[$key]['created'] = (new DateTime($news->datevalue))->format('M d, Y');
                    $newsEn[$key]['day'] = (new DateTime($news->datevalue))->format('d');
                    $newsEn[$key]['month'] = (new DateTime($news->datevalue))->format('F');
                    $newsEn[$key]['due'] = (new DateTime($news->due_date))->format('M d, Y');
                    $newsEn[$key]['dueday'] = (new DateTime($news->due_date))->format('d');
                    $newsEn[$key]['duemonth'] = (new DateTime($news->due_date))->format('F');
                    $newsEn[$key]['lastmodified'] = (new DateTime($news->lastmodified))->format('M d, Y');
                    $newsEn[$key]['slug'] = $news->slug;
                    $newsEn[$key]['image'] = isset($news->DocPath)?base_url().$news->DocPath:'';
                    $newsEn[$key]['nepali_date'] =$npdate;
                    
                    $newsNe[$key]['id'] = $news->id;
                    $newsNe[$key]['title'] = $news->TitleNepali;
                    // $newsNe[$key]['due_date'] = $news->due_date;
                    // $newsNe[$key]['created'] =$news->created_on;
                    $newsNe[$key]['created'] = (new DateTime($news->datevalue))->format('M d, Y');
                    $newsNe[$key]['day'] = (new DateTime($news->datevalue))->format('d');
                    $newsNe[$key]['month'] = (new DateTime($news->datevalue))->format('F');
                    $newsNe[$key]['due'] = (new DateTime($news->due_date))->format('M d, Y');
                    $newsNe[$key]['dueday'] = (new DateTime($news->due_date))->format('d');
                    $newsNe[$key]['duemonth'] = (new DateTime($news->due_date))->format('F');
                    $newsNe[$key]['lastmodified'] = (new DateTime($news->lastmodified))->format('M d, Y');
                    $newsNe[$key]['slug'] = $news->slug;
                    $newsNe[$key]['image'] = isset($news->DocPath)?base_url().$news->DocPath:'';
                    $newsNe[$key]['nepali_date'] =$npdate;
                }
            }
            
            $news = array(
                'en' => $newsEn,
                'np' => $newsNe,
            );
            

            //grievance
            $grievance_officer  = $this->crud_model->get_where_single_order_by('officers', array('type'=>'Grievance', 'status'=> '1'), 'id', 'DESC');
            isset($grievance_officer)?$grievance_officer->featured_image=isset($grievance_officer->featured_image)?base_url().$grievance_officer->featured_image:'':'';
            isset($grievance_officer)?$grievance_officer->designation=isset($grievance_officer->designation)?$this->db->get_where('designation_para',array('id'=>$grievance_officer->designation))->row()->designation_name:'':'';
            if (isset($grievance_officer)) {
                if (isset($grievance_officer->designation)) {
                    $designation = $this->db->get_where('designation_para', array('id' => $grievance_officer->designation))->row();
                    $grievance_officer->designation = isset($designation->designation_name) ? $designation->designation_name : '';
                    $grievance_officer->designation_np = isset($designation->designation_name_np) ? $designation->designation_name_np : '';
                } else {
                    $grievance_officer->designation = '';
                    $grievance_officer->designation_np = '';
                }
            }
            //grievance ends

            //information
            $information_officer  = $this->crud_model->get_where_single_order_by('officers', array('type'=>'Information', 'status'=> '1'), 'id', 'DESC'); 
            isset($information_officer)?$information_officer->featured_image=isset($information_officer->featured_image)?base_url().$information_officer->featured_image:'':'';
            if (isset($information_officer)) {
                if (isset($information_officer->designation)) {
                    $designation = $this->db->get_where('designation_para', array('id' => $information_officer->designation))->row();
                    $information_officer->designation = isset($designation->designation_name) ? $designation->designation_name : '';
                    $information_officer->designation_np = isset($designation->designation_name_np) ? $designation->designation_name_np : '';
                } else {
                    $information_officer->designation = '';
                    $information_officer->designation_np = '';
                }
            }
            //information ends

            //compliance
            $compliance_officer  = $this->crud_model->get_where_single_order_by('officers', array('type'=>'Compliance', 'status'=> '1'), 'id', 'DESC'); 
            isset($compliance_officer)?$compliance_officer->featured_image=isset($compliance_officer->featured_image)?base_url().$compliance_officer->featured_image:'':'';
            if (isset($compliance_officer)) {
                if (isset($compliance_officer->designation)) {
                    $designation = $this->db->get_where('designation_para', array('id' => $compliance_officer->designation))->row();
                    $compliance_officer->designation = isset($designation->designation_name) ? $designation->designation_name : '';
                    $compliance_officer->designation_np = isset($designation->designation_name_np) ? $designation->designation_name_np : '';
                } else {
                    $compliance_officer->designation = '';
                    $compliance_officer->designation_np = '';
                }
            }
            //compliance ends
            
            $DigitalHelpDesk  = $this->crud_model->get_where_single_order_by('officers', array('type'=>'Digital Help Desk', 'status'=> '1'), 'id', 'DESC'); 
            isset($DigitalHelpDesk)?$DigitalHelpDesk->featured_image=isset($DigitalHelpDesk->featured_image)?base_url().$DigitalHelpDesk->featured_image:'':'';
            isset($DigitalHelpDesk)?$DigitalHelpDesk->designation=isset($DigitalHelpDesk->designation)?$this->db->get_where('designation_para',array('id'=>$DigitalHelpDesk->designation))->row()->designation_name:'':'';
            if (isset($DigitalHelpDesk)) {
                if (isset($DigitalHelpDesk->designation)) {
                    $designation = $this->db->get_where('designation_para', array('id' => $DigitalHelpDesk->designation))->row();
                    $DigitalHelpDesk->designation = isset($designation->designation_name) ? $designation->designation_name : '';
                    $DigitalHelpDesk->designation_np = isset($designation->designation_name_np) ? $designation->designation_name_np : '';
                } else {
                    $DigitalHelpDesk->designation = '';
                    $DigitalHelpDesk->designation_np = '';
                }
            }
            
            // $digital_banking  = $this->crud_model->get_where_single_order_by('digital_banking', array('status'=> '1'), 'id', 'DESC'); 
            // isset($digital_banking)?$digital_banking->featured_image=isset($digital_banking->featured_image)?base_url().$digital_banking->featured_image:'':'';
            
            //site-setting
            $site_settings = $this->crud_model->get_where_single_order_by('site_settings', array('id'=>'1'), 'id', 'DESC');
            isset($site_settings)?$site_settings->logo=isset($site_settings->logo)?base_url().$site_settings->logo:'':'';
            isset($site_settings)?$site_settings->fav=isset($site_settings->fav)?base_url().$site_settings->fav:'':'';
            isset($site_settings)?$site_settings->default_img=isset($site_settings->default_img)?base_url().$site_settings->default_img:'':'';
            isset($site_settings)?$site_settings->closing_time=isset($site_settings->closing_time)?date('h:i a ', strtotime($site_settings->closing_time)):'':'';
            isset($site_settings)?$site_settings->opening_time=isset($site_settings->opening_time)?date('h:i a ', strtotime($site_settings->opening_time)):'':'';
            isset($site_settings)?$site_settings->opening_time_friday=isset($site_settings->opening_time_friday)?date('h:i a ', strtotime($site_settings->opening_time_friday)):'':'';
            isset($site_settings)?$site_settings->closing_time_friday=isset($site_settings->closing_time_friday)?date('h:i a ', strtotime($site_settings->closing_time_friday)):'':'';
            isset($site_settings)?$site_settings->holiday_opening=isset($site_settings->holiday_opening)?date('h:i a ', strtotime($site_settings->holiday_opening)):'':'';
            isset($site_settings)?$site_settings->holiday_closing=isset($site_settings->holiday_closing)?date('h:i a ', strtotime($site_settings->holiday_closing)):'':'';
            //site-setting ends
            
            $popups = $this->crud_model->get_notification();
          
            // $popups = $this->crud_model->get_popups();
            foreach($popups as $key=>$val){
                $popups[$key]->image = base_url($val->file);
            } 
            //pops ends
          
            //Counts
            $sql_en_count = "Title, Number, slug";
            $count_en = $this->crud_model->get_sql_all('count',array('status'=>'1'),'id','DESC',8,0,$sql_en_count);
            
            
            $sql_np_count = "TitleNepali as Title, NumberNepali as Number, slug";
            $count_np = $this->crud_model->get_sql_all('count',array('status'=>'1'),'id','DESC',4,0,$sql_np_count);
            
            
            $count = array(
                'en' => $count_en,
                'np' => $count_np,
            );
            
            //Counts ends
            $response = array(
                'status' => "success",
                'status_code' => 200,
                'status_message' => "Data Retreived Successfully",
                // 'about' => $aboutDetail,
                'chairperson_msg'=>$chairperson_msgDetail,
                'banners' => $banners,
                'services' => $services,
                'Epartners' => $Epartners,
                'RangeProducts'=>$rangeProducts,
                'ImpNews'=>$ImpNews,
                'news' => $news,
                'notices'=>$notices,
                // 'digital_banking' => $digital_banking,
                // 'support' => [
                //     [
                //         'parent' => 'Information Officer',
                //         'child' => $information_officer,
                //     ],
                //     [
                //         'parent' => 'Grievance Handling Officer',
                //         'child' => $grievance_officer,
                //     ],
                //     [
                //         'parent' => 'Digital Help Desk',
                //         'child' => $DigitalHelpDesk,
                //     ],
                //     // [
                //     //     'parent' => 'Compliance Officer',
                //     //     'child' => $compliance_officer,
                //     // ],
                    
                // ],
                'site_settings' => $site_settings,
                'count' => $count,
                'popups' => $popups, 
            );
        }
        // var_dump($response);exit;
        $json_response = json_encode($response);
        echo $json_response;
    }
   
    
}