<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Auth_controller extends MX_Controller
{
    protected $current_user = NULL;
    protected $per_page = NULL;
    protected $data = [];
    public function __construct()
    {
        parent::__construct();
        //$this->output->enable_profiler(TRUE);
        $this->load->library('auth');
        
        $this->data = $this->intializeData();
        
    }

    private function intializeData()
    {
        $this->load->library('auth');
        if (!$this->auth->is_logged()) {
            $this->session->set_flashdata('loginfirst', 'You Must Login First');
            redirect('login');
        }
        $current_user = $this->auth->current_user();
        //    to get controller (class) and function (method) name 

        $controller = $this->router->fetch_class();
        $module = $this->uri->segment(1);
        
        $function = $this->router->fetch_method();
        if($module != '' && $module != 'dashboard'){
            $module_function = $this->crud_model->get_module_function($module, $function);
            // echo "<pre>";
            // var_dump($module, $this->db->last_query(), $module_function);exit;
            if (!$module_function) {
                // $check = $this->crud_model->get_single('module_function_role', array('module_function_id' => $module_function->module_function_id, 'role_id' => $current_user->role_id));
                
                // if (empty($check)) {
                    
                    $this->session->set_flashdata('error', 'You Are Not Allowed Here!! Sorry...');
                    redirect('dashboard');
                // }
            }
        }
        
        
        $logs = array(
            'module' => $this->uri->segment(1),
            'function' => $this->uri->segment(3),
            'user_id' => $current_user->id,
        );
        $insert_log = $this->db->insert('user_log', $logs);
        if (!$insert_log) {
            $this->session->set_flashdata('error', 'Unable To Make Log.');
            redirect('dashboard');
        }
        
        $staff_detail = $this->db->get_where('staff_infos', array('id' => $current_user->staff_id))->row();
        $site_settings = $this->crud_model->get_where_single('site_settings',array('status'=>'1'));
        $data = [
            'site_settings' => $site_settings,
            'userId'=> $current_user->id,
            'current_user' => $current_user,
            'staff_name' => isset($staff_detail->full_name) ? $staff_detail->full_name : '',
            'appointed_date' => $staff_detail->appointed_date,
            'role_id' => $current_user->role_id,
            'staff_featured_image' => (isset($staff_detail->featured_image) && $staff_detail->featured_image != '') ? $staff_detail->featured_image : $site_settings->fav
        ];
        
        return $data;
    }
}