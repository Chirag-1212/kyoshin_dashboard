<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Team extends Front_controller
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
        $this->table = 'news'; 
        $this->title = 'News';
    } 
    
    function all($group_slug)
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
                
                
                $group_detail = $this->crud_model->get_where_single('team_group', array('slug'=>$group_slug,'status'=>'1'));
                
                $sql_en = "featured_image, name, email, contact, designation, address, sub_designation, department_id, is_block, team_group_id";
                
                $items_english = $this->crud_model->get_sql_all_no_pagination('teams',array('status' => '1', 'team_group_id' => $group_detail->id),'rank', 'ASC', $sql_en);  
                
                foreach($items_english as $key=>$val){
                    $designation_detail = $this->crud_model->get_where_single('designation_para', array('id'=>$val->designation,'status'=>'1'));
                    $items_english[$key]->designation_name = isset($designation_detail->designation_name) ? $designation_detail->designation_name: '';
                    
                    $department_detail = $this->crud_model->get_where_single('department_para', array('id'=>$val->department_id,'status'=>'1'));
                    $items_english[$key]->department_name = isset($department_detail->department_name) ? $department_detail->department_name: '';
                    isset($items_english[$key]->featured_image)?$items_english[$key]->featured_image = base_url().$items_english[$key]->featured_image:'';
                }
                
                $sql_np = "featured_image, name_nepali as name, email, contact,address_np as address, designation, sub_designation, department_id, is_block, team_group_id";
                $items_nepali = $this->crud_model->get_sql_all_no_pagination('teams',array('status' => '1',  'team_group_id' => $group_detail->id),'rank', 'ASC', $sql_np);  
                foreach($items_nepali as $key=>$val){
                    $designation_detail = $this->crud_model->get_where_single('designation_para', array('id'=>$val->designation,'status'=>'1'));
                    $items_nepali[$key]->designation_name = isset($designation_detail->designation_name_np) ? $designation_detail->designation_name_np: $designation_detail->designation_name;
                    
                    $department_detail = $this->crud_model->get_where_single('department_para', array('id'=>$val->department_id,'status'=>'1'));
                    $items_nepali[$key]->department_name = isset($department_detail->department_name_np) ? $department_detail->department_name_np: '';
                    isset($items_nepali[$key]->featured_image)?$items_nepali[$key]->featured_image = base_url().$items_nepali[$key]->featured_image:'';
                }
                 
                $items = array(
                        'en' =>$items_english,
                        'np' => $items_nepali
                    ); 
                    
                if($items){ 
                    $response=array(
                            'status' => "Success",
                            'status_code' => 200,
                            'status_message' => "Item List",
                            'items' => $items,  
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
