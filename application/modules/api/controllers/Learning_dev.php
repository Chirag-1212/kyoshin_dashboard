<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Learning_dev extends Front_controller
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
        
        $this->table = 'learning_dev'; 
        $this->title = 'Learning & Development';
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
           
            $download_param = [
                'status' => '1'
            ];
            $downloadEn = [];
            $downloadNe = []; 
            $per_page = 12;
            $offset = ($page*$per_page - $per_page); 
            $sql = "id,slug,DocPath,description,description_nepali, title,title_nepali, created";
            $downloads = $this->crud_model->get_sql_all($this->table,$download_param,'id', 'DESC',$per_page, $offset,$sql);  
            // var_dump($this->db->last_query()); die;
            foreach($downloads as $key=>$val){
                
                $doc = '';
                if($val->DocPath){
                    $doc = base_url($val->DocPath);
                }
                //for english
                $downloadEn[$key]['id'] = $val->id;
                $downloadEn[$key]['title'] = $val->title;
                $downloadEn[$key]['slug'] = $val->slug;
                $downloadEn[$key]['description'] = $val->description;
                $downloadEn[$key]['file'] = $doc;
                $downloadEn[$key]['created'] = (new DateTime($val->created))->format('M d, Y');
                $downloadEn[$key]['day'] = (new DateTime($val->created))->format('d');
                $downloadEn[$key]['month'] = (new DateTime($val->created))->format('F');
                // $downloadEn[$key]['published'] = $val->datevalue;
                // $downloadEn[$key]['due_date'] = $val->due_date;

                //for neapli
                $downloadNe[$key]['id'] = $val->id;
                $downloadNe[$key]['title'] = $val->title_nepali;
                $downloadNe[$key]['slug'] = $val->slug;
                $downloadNe[$key]['description'] = $val->description_nepali;
                $downloadNe[$key]['file'] = $doc;
                $downloadNe[$key]['created'] = (new DateTime($val->created))->format('M d, Y');
                $downloadNe[$key]['day'] = (new DateTime($val->created))->format('d');
                $downloadNe[$key]['month'] = (new DateTime($val->created))->format('F');
                // $downloadNe[$key]['published'] = $val->datevalue;
                // $downloadNe[$key]['due_date'] = $val->due_date;
                
            }
            $downloadstotal = $this->crud_model->count_all($this->table, $download_param, 'id'); 
          
            if($downloadstotal){ 
                $response=array(
                        'status' => "Success",
                        'status_code' => 200,
                        'status_message' => "Item List",
                        'downloads' => [
                            'en' =>$downloadEn,
                            'np' => $downloadNe
                        ],
                        'downloads_total' => $downloadstotal,
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

}