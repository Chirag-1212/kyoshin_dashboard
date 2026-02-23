<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Invest_interest extends Front_controller
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
    } 
    
    function all($type)
    {  
        header('Access-Control-Allow-Method:GET');
        if ($this->request_method != "GET") {
            $response=array(
                'status' => "Error",
                'status_code' => 204,
                'status_message' => "Access Method Not Allowed",
            );
        } else {   
                //base rates starts----TYpe ---Base ---  Spread  
                $current_date = date('Y-m-d');
                
                $current_fiscal_where = array(
                    // 'date_from <=' => $current_date,
                    // 'date_to >=' => $current_date,
                    'status' => '1',
                );
                $catSql = 'id, title, title_nepali';
                $current_fiscal_year = $this->crud_model->get_sql_all_no_pagination('fiscal_year', $current_fiscal_where, 'title', 'DESC', $catSql);
                
                 
                $ratesEn = [];
                $ratesNe = [];
                if($current_fiscal_year){
                    foreach($current_fiscal_year as $key=>$fiscal){
                        // $fiscal_title_en = $this->crud_model->getField('fiscal_year', array('status' => '1', 'id' => $rate->fisacl_year_id), 'title');
                        // $fiscal_title_ne = $this->crud_model->getField('fiscal_year', array('status' => '1', 'id' => $rate->fisacl_year_id), 'title_nepali');
                        $sql = "id, slug,Title,TitleNepali, created_on, rate, avg_rates, Description, DescriptionNepali, category_id as fisacl_year_id";
                        // $rates = $this->crud_model->get_sql_all_no_pagination('other_interest_rate',array('status' => '1', 'type' => $type, 'category_id' => $fiscal->id),'id', 'DESC', $sql);
                        $rates = $this->crud_model->get_sql_all_no_pagination('other_interest_rate',array('status' => '1', 'type' => $type, 'category_id' => $fiscal->id),'serial', 'ASC', $sql);
                        $ratesEn[$key]['id'] = $fiscal->id;
                        $ratesEn[$key]['title'] = $fiscal->title;
                        $english = [];
                        $nepali = [];
                        foreach($rates as $keys=>$rate){
                            $english[$keys] = [
                                'id'=> $rate->id,
                                'title' => $rate->Title,
                                'slug' => $rate->slug,
                                'rate' => $rate->rate,
                                'avg_rates'=>$rate->avg_rates,
                                'created_on' => $rate->created_on,
                                'description' => $rate->Description
                            ];
                            
                            $nepali[$keys] = [
                                'id' => $rate->id,
                                'title' => $rate->TitleNepali,
                                'slug' => $rate->slug,
                                'rate' => $rate->rate,
                                'avg_rates'=>$rate->avg_rates,
                                'created_on' => $rate->created_on,
                                'description' => $rate->DescriptionNepali
                            ];
                        }
                        
                        $ratesNe[$key]['id'] = $rate->id;
                        $ratesNe[$key]['title'] = $rate->title_nepali?:'';
                        
                        $ratesEn[$key]['child'] = $english;
                        $ratesNe[$key]['child'] = $nepali;
                    }
                }
                
                $ratesInterest = [
                    'en' => $ratesEn,
                    'np' => $ratesNe,
                ];
                    
                
                 
                $response=[
                    'status' => "Success",
                    'status_code' => 200,
                    'status_message' => "Item List",
                    'rates' => $ratesInterest,
                ]; 
            
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
                $detail = $this->crud_model->get_where_single_order_by('other_interest_rate', array('status'=>'1','slug'=>$slug), 'id', 'DESC'); 
                $detailEn['id'] = $detail->id;
                $detailEn['title'] = $detail->Title;
                $detailEn['slug'] = $detail->slug;
                $detailEn['description'] = $detail->Description;
                
                $detailNe['id'] = $detail->id;
                $detailNe['title'] = $detail->TitleNepali;
                $detailNe['description'] = $detail->slug;
                $detailNe['description'] = $detail->DescriptionNepali;
                
                $sql = "id, slug,Title,TitleNepali";
                $rates = $this->crud_model->get_sql_all_no_pagination('other_interest_rate',array('status' => '1', 'type' => 'Commissions'),'id', 'DESC', $sql); 
                $ratesEn = [];
                $ratesNe = [];
                if($rates){
                    foreach($rates as $key=>$rate){
                        $fiscal_title_en = $this->crud_model->getField('fiscal_year', array('status' => '1', 'id' => $rate->fisacl_year_id), 'title');
                        $fiscal_title_ne = $this->crud_model->getField('fiscal_year', array('status' => '1', 'id' => $rate->fisacl_year_id), 'title_nepali');
                        $ratesEn[$key]['id'] = $rate->id;
                        $ratesEn[$key]['title'] = $rate->Title;
                        $ratesEn[$key]['slug'] = $rate->slug;
                        
                        $ratesNe[$key]['id'] = $rate->id;
                        $ratesNe[$key]['title'] = $rate->TitleNepali;
                        $ratesNe[$key]['slug'] = $rate->slug;
                    }
                }
                
                $ratesInterest = [
                    'en' => $ratesEn,
                    'np' => $ratesNe,
                ];
                if(!empty($detail)){
                    $response = array(
                        'status' => "success",
                        'status_code' => 200,
                        'status_message' => "Data Retreived Successfully",
                        'detail' => [
                            'en' => $detailEn,
                            'np' =>$detailNe
                        ], 
                        'category' => $ratesInterest,
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
