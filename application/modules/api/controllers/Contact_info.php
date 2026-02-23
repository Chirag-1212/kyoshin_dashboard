<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Contact_info extends Front_controller
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
         
            //information_officers start
            $sql_en_type = "id,slug,name, name_nepali,description,description_nepali,designation,contact,contact_np, featured_image";
            $information_officers_detail=$this->crud_model->getData('teams', array('status' => '1','team_group_id'=>'6'),[], 100, 0, $sql_en_type,'rank ASC'); 
         
            $information_officersEn=[];
            $information_officersNe=[];
            foreach($information_officers_detail as $key=>$val){
                if (isset($val)) {
                    if (isset($val->designation)) {
                        $designation = $this->db->get_where('designation_para', array('id' => $val->designation))->row();
                        $val->designation = isset($designation->designation_name) ? $designation->designation_name : '';
                        $val->designation_np = isset($designation->designation_name_np) ? $designation->designation_name_np : '';
                    } else {
                        $val->designation = '';
                        $val->designation_np = '';
                    }
                }
                $information_officersEn[$key]['id'] = $val->id;
                $information_officersEn[$key]['title'] = $val->name;
                $information_officersEn[$key]['slug'] = $val->slug;
                $information_officersEn[$key]['description'] = $val->description;
                $information_officersEn[$key]['designation'] = $val->designation;
                $information_officersEn[$key]['contact'] = $val->contact;
                $information_officersEn[$key]['image'] = isset($val->featured_image)?base_url().$val->featured_image:'';
                
                $information_officersNe[$key]['id'] = $val->id;
                $information_officersNe[$key]['title'] = $val->name_nepali;
                $information_officersNe[$key]['slug'] = $val->slug;
                $information_officersNe[$key]['description'] = $val->description_nepali;
                $information_officersNe[$key]['designation'] = $val->designation_np;
                $information_officersNe[$key]['contact'] = $val->contact_np;
                $information_officersNe[$key]['image'] = isset($val->featured_image)?base_url($val->featured_image):'';
            }
            $information_officers = [
                'en' => $information_officersEn,
                'np' => $information_officersNe,
            ];
            //information_officers ends
            
            //board_of_directors start
            $sql_en_type = "id, slug,name, name_nepali, description, description_nepali, designation, contact, contact_np, featured_image";
            $board_of_directors_detail=$this->crud_model->getData('teams', array('status' => '1','team_group_id'=>'7'),[], 100, 0, $sql_en_type,'rank ASC'); 
        //  var_dump($this->db->last_query()); die;
            $board_of_directorsEn=[];
            $board_of_directorsNe=[];
            foreach($board_of_directors_detail as $key=>$val){
                if (isset($val)) {
                    if (isset($val->designation)) {
                        $designation = $this->db->get_where('designation_para', array('id' => $val->designation))->row();
                        $val->designation = isset($designation->designation_name) ? $designation->designation_name : '';
                        $val->designation_np = isset($designation->designation_name_np) ? $designation->designation_name_np : '';
                    } else {
                        $val->designation = '';
                        $val->designation_np = '';
                    }
                }
                    $board_of_directorsEn[$key]['id'] = $val->id;
                    $board_of_directorsEn[$key]['title'] = $val->name;
                    $board_of_directorsEn[$key]['slug'] = $val->slug;
                    $board_of_directorsEn[$key]['description'] = $val->description;
                    $board_of_directorsEn[$key]['designation'] = $val->designation;
                    $board_of_directorsEn[$key]['contact'] = $val->contact;
                    $board_of_directorsEn[$key]['image'] = isset($val->featured_image)?base_url().$val->featured_image:'';
                    
                    $board_of_directorsNe[$key]['id'] = $val->id;
                    $board_of_directorsNe[$key]['title'] = $val->name_nepali;
                    $board_of_directorsNe[$key]['slug'] = $val->slug;
                    $board_of_directorsNe[$key]['description'] = $val->description_nepali;
                    $board_of_directorsNe[$key]['designation'] = $val->designation_np;
                    $board_of_directorsNe[$key]['contact'] = $val->contact_np;
                    $board_of_directorsNe[$key]['image'] = isset($val->featured_image)?base_url($val->featured_image):'';
            }
            $board_of_directors = [
                'en' => $board_of_directorsEn,
                'np' => $board_of_directorsNe,
            ];
            //board_of_directors ends
            
            //management_committee start
            $sql_en_type = "id, slug,name, name_nepali, description, description_nepali, designation, contact, contact_np, featured_image";
            $management_committee_detail=$this->crud_model->getData('teams', array('status' => '1','team_group_id'=>'8'),[], 100, 0, $sql_en_type,'rank ASC'); 
  
            $management_committeeEn=[];
            $management_committeeNe=[];
            foreach($management_committee_detail as $key=>$val){
                if (isset($val)) {
                    if (isset($val->designation)) {
                        $designation = $this->db->get_where('designation_para', array('id' => $val->designation))->row();
                        $val->designation = isset($designation->designation_name) ? $designation->designation_name : '';
                        $val->designation_np = isset($designation->designation_name_np) ? $designation->designation_name_np : '';
                    } else {
                        $val->designation = '';
                        $val->designation_np = '';
                    }
                }
                    $management_committeeEn[$key]['id'] = $val->id;
                    $management_committeeEn[$key]['title'] = $val->name;
                    $management_committeeEn[$key]['slug'] = $val->slug;
                    $management_committeeEn[$key]['description'] = $val->description;
                    $management_committeeEn[$key]['designation'] = $val->designation;
                    $management_committeeEn[$key]['contact'] = $val->contact;
                    $management_committeeEn[$key]['image'] = isset($val->featured_image)?base_url().$val->featured_image:'';
                    
                    $management_committeeNe[$key]['id'] = $val->id;
                    $management_committeeNe[$key]['title'] = $val->name_nepali;
                    $management_committeeNe[$key]['slug'] = $val->slug;
                    $management_committeeNe[$key]['description'] = $val->description_nepali;
                    $management_committeeNe[$key]['designation'] = $val->designation_np;
                    $management_committeeNe[$key]['contact'] = $val->contact_np;
                    $management_committeeNe[$key]['image'] = isset($val->featured_image)?base_url($val->featured_image):'';
            }
            $management_committee = [
                'en' => $management_committeeEn,
                'np' => $management_committeeNe,
            ];
            //management_committee ends
            
            //branch_managers start
            $sql_en_type = "id, slug,name, name_nepali, description, description_nepali, designation, contact, contact_np, featured_image";
            $branch_managers_detail=$this->crud_model->getData('teams', array('status' => '1','team_group_id'=>'9'),[], 100, 0, $sql_en_type,'rank ASC'); 
  
            $branch_managersEn=[];
            $branch_managersNe=[];
            foreach($branch_managers_detail as $key=>$val){
                if (isset($val)) {
                    if (isset($val->designation)) {
                        $designation = $this->db->get_where('designation_para', array('id' => $val->designation))->row();
                        $val->designation = isset($designation->designation_name) ? $designation->designation_name : '';
                        $val->designation_np = isset($designation->designation_name_np) ? $designation->designation_name_np : '';
                    } else {
                        $val->designation = '';
                        $val->designation_np = '';
                    }
                }
                    $branch_managersEn[$key]['id'] = $val->id;
                    $branch_managersEn[$key]['title'] = $val->name;
                    $branch_managersEn[$key]['slug'] = $val->slug;
                    $branch_managersEn[$key]['description'] = $val->description;
                    $branch_managersEn[$key]['designation'] = $val->designation;
                    $branch_managersEn[$key]['contact'] = $val->contact;
                    $branch_managersEn[$key]['image'] = isset($val->featured_image)?base_url().$val->featured_image:'';
                    
                    $branch_managersNe[$key]['id'] = $val->id;
                    $branch_managersNe[$key]['title'] = $val->name_nepali;
                    $branch_managersNe[$key]['slug'] = $val->slug;
                    $branch_managersNe[$key]['description'] = $val->description_nepali;
                    $branch_managersNe[$key]['designation'] = $val->designation_np;
                    $branch_managersNe[$key]['contact'] = $val->contact_np;
                    $branch_managersNe[$key]['image'] = isset($val->featured_image)?base_url($val->featured_image):'';
            }
            $branch_managers = [
                'en' => $branch_managersEn,
                'np' => $branch_managersNe,
            ];
            //branch_managers ends
            
            //audit_committee start
            $sql_en_type = "id, slug,name, name_nepali, description, description_nepali, designation, contact, contact_np, featured_image";
            $audit_committee_detail=$this->crud_model->getData('teams', array('status' => '1','team_group_id'=>'10'),[], 100, 0, $sql_en_type,'rank ASC'); 
  
            $audit_committeeEn=[];
            $audit_committeeNe=[];
            foreach($audit_committee_detail as $key=>$val){
                if (isset($val)) {
                    if (isset($val->designation)) {
                        $designation = $this->db->get_where('designation_para', array('id' => $val->designation))->row();
                        $val->designation = isset($designation->designation_name) ? $designation->designation_name : '';
                        $val->designation_np = isset($designation->designation_name_np) ? $designation->designation_name_np : '';
                    } else {
                        $val->designation = '';
                        $val->designation_np = '';
                    }
                }
                    $audit_committeeEn[$key]['id'] = $val->id;
                    $audit_committeeEn[$key]['title'] = $val->name;
                    $audit_committeeEn[$key]['slug'] = $val->slug;
                    $audit_committeeEn[$key]['description'] = $val->description;
                    $audit_committeeEn[$key]['designation'] = $val->designation;
                    $audit_committeeEn[$key]['contact'] = $val->contact;
                    $audit_committeeEn[$key]['image'] = isset($val->featured_image)?base_url().$val->featured_image:'';
                    
                    $audit_committeeNe[$key]['id'] = $val->id;
                    $audit_committeeNe[$key]['title'] = $val->name_nepali;
                    $audit_committeeNe[$key]['slug'] = $val->slug;
                    $audit_committeeNe[$key]['description'] = $val->description_nepali;
                    $audit_committeeNe[$key]['designation'] = $val->designation_np;
                    $audit_committeeNe[$key]['contact'] = $val->contact_np;
                    $audit_committeeNe[$key]['image'] = isset($val->featured_image)?base_url($val->featured_image):'';
            }
            $audit_committee = [
                'en' => $audit_committeeEn,
                'np' => $audit_committeeNe,
            ];
            //audit_committee ends
            
            //promoters start
            $sql_en_type = "id, slug,name, name_nepali, description, description_nepali, designation, contact, contact_np, featured_image";
            $promoters_detail=$this->crud_model->getData('teams', array('status' => '1','team_group_id'=>'11'),[], 100, 0, $sql_en_type,'rank ASC'); 
  
            $promotersEn=[];
            $promotersNe=[];
            foreach($promoters_detail as $key=>$val){
                if (isset($val)) {
                    if (isset($val->designation)) {
                        $designation = $this->db->get_where('designation_para', array('id' => $val->designation))->row();
                        $val->designation = isset($designation->designation_name) ? $designation->designation_name : '';
                        $val->designation_np = isset($designation->designation_name_np) ? $designation->designation_name_np : '';
                    } else {
                        $val->designation = '';
                        $val->designation_np = '';
                    }
                }
                    $promotersEn[$key]['id'] = $val->id;
                    $promotersEn[$key]['title'] = $val->name;
                    $promotersEn[$key]['slug'] = $val->slug;
                    $promotersEn[$key]['description'] = $val->description;
                    $promotersEn[$key]['designation'] = $val->designation;
                    $promotersEn[$key]['contact'] = $val->contact;
                    $promotersEn[$key]['image'] = isset($val->featured_image)?base_url().$val->featured_image:'';
                    
                    $promotersNe[$key]['id'] = $val->id;
                    $promotersNe[$key]['title'] = $val->name_nepali;
                    $promotersNe[$key]['slug'] = $val->slug;
                    $promotersNe[$key]['description'] = $val->description_nepali;
                    $promotersNe[$key]['designation'] = $val->designation_np;
                    $promotersNe[$key]['contact'] = $val->contact_np;
                    $promotersNe[$key]['image'] = isset($val->featured_image)?base_url($val->featured_image):'';
            }
            $promoters = [
                'en' => $promotersEn,
                'np' => $promotersNe,
            ];
            //promoters ends
            
            //grievance_handling start
            $sql_en_type = "id, slug,name, name_nepali, description, description_nepali, designation, contact, contact_np, featured_image";
            $grievance_handling_detail=$this->crud_model->getData('teams', array('status' => '1','team_group_id'=>'11'),[], 100, 0, $sql_en_type,'rank ASC'); 
  
            $grievance_handlingEn=[];
            $grievance_handlingNe=[];
            foreach($grievance_handling_detail as $key=>$val){
                if (isset($val)) {
                    if (isset($val->designation)) {
                        $designation = $this->db->get_where('designation_para', array('id' => $val->designation))->row();
                        $val->designation = isset($designation->designation_name) ? $designation->designation_name : '';
                        $val->designation_np = isset($designation->designation_name_np) ? $designation->designation_name_np : '';
                    } else {
                        $val->designation = '';
                        $val->designation_np = '';
                    }
                }
                    $grievance_handlingEn[$key]['id'] = $val->id;
                    $grievance_handlingEn[$key]['title'] = $val->name;
                    $grievance_handlingEn[$key]['slug'] = $val->slug;
                    $grievance_handlingEn[$key]['description'] = $val->description;
                    $grievance_handlingEn[$key]['designation'] = $val->designation;
                    $grievance_handlingEn[$key]['contact'] = $val->contact;
                    $grievance_handlingEn[$key]['image'] = isset($val->featured_image)?base_url().$val->featured_image:'';
                    
                    $grievance_handlingNe[$key]['id'] = $val->id;
                    $grievance_handlingNe[$key]['title'] = $val->name_nepali;
                    $grievance_handlingNe[$key]['slug'] = $val->slug;
                    $grievance_handlingNe[$key]['description'] = $val->description_nepali;
                    $grievance_handlingNe[$key]['designation'] = $val->designation_np;
                    $grievance_handlingNe[$key]['contact'] = $val->contact_np;
                    $grievance_handlingNe[$key]['image'] = isset($val->featured_image)?base_url($val->featured_image):'';
            }
            $grievance_handling = [
                'en' => $grievance_handlingEn,
                'np' => $grievance_handlingNe,
            ];
            //grievance_handling ends
            
         

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
            
             //Company Secretary
            $company_secretary  = $this->crud_model->get_where_single_order_by('officers', array('type'=>'company-secretary', 'status'=> '1'), 'id', 'DESC'); 
            isset($company_secretary)?$company_secretary->featured_image=isset($company_secretary->featured_image)?base_url().$company_secretary->featured_image:'':'';
            if (isset($company_secretary)) {
                if (isset($company_secretary->designation)) {
                    $designation = $this->db->get_where('designation_para', array('id' => $company_secretary->designation))->row();
                    $company_secretary->designation = isset($designation->designation_name) ? $designation->designation_name : '';
                    $company_secretary->designation_np = isset($designation->designation_name_np) ? $designation->designation_name_np : '';
                } else {
                    $company_secretary->designation = '';
                    $company_secretary->designation_np = '';
                }
            }
            //Company Secretary ends
            
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
            
         
            $response = array(
                'status' => "success",
                'status_code' => 200,
                'status_message' => "Data Retreived Successfully",
                'board_of_directors' => $board_of_directors,
                'management_committee' => $management_committee,
                'branch_managers' => $branch_managers,
                'audit_committee' => $audit_committee,
                'promoters' => $promoters,
                // 'grievance_handling' => $grievance_handling,
                // 'information_officers' => $information_officers,
                'information_officer' => $information_officer,
                'compliance_officer'=>$compliance_officer,
                'company_secretary'=>$company_secretary,
                'grievance_officer' => $grievance_officer,
                'digitalHelpDesk' => $DigitalHelpDesk,
                // 'support' => [
                //     [
                //         'parent' => 'Information Officer',
                //         'child' => $information_officer,
                //     ],
                //     [
                //         'parent' => 'Grievance Officer',
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