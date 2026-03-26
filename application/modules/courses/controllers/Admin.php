<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Admin extends Auth_controller
{
    protected $userId;
    protected $table;
    protected $redirect;
    protected $title;

    public function __construct()
    {
        parent::__construct();
        $this->table = 'our_courses';
        $this->title = 'Our Courses';
        $this->redirect = 'courses'; 
        $this->userId = $this->data['userId'];
    }

    public function all($page = '')
    {
        $like = [];
        $param = ['status !=' => '2']; 

        $search = $this->input->get('Title');
        $status = $this->input->get('status');
        $date_from = $this->input->get('date_from');
        $date_to   = $this->input->get('date_to');

        if ($search) {
            $like['title_en'] = $search;
            $like['title_jp'] = $search;
        }
        if ($status !== null && $status !== '') {
            $param['status'] = $status;
        }
        if ($date_from) $param['created_on >='] = $date_from . ' 00:00:00';
        if ($date_to)   $param['created_on <='] = $date_to . ' 23:59:59';

        $total = $this->crud_model->total($this->table, $param, $like);
        
        $get_params = $_GET;
        $search_query = http_build_query($get_params);

        $config = [
            'base_url'    => base_url($this->redirect . '/admin/all'),
            'total_rows'  => $total,
            'per_page'    => 10,
            'uri_segment' => 4,
            'suffix'      => $search_query ? '?' . $search_query : '',
            'first_url'   => base_url($this->redirect . '/admin/all') . ($search_query ? '?' . $search_query : '')
        ];

        $this->pagination->initialize($config);
        
        $page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
        $items = $this->crud_model->getData($this->table, $param, $like, $config["per_page"], $page, '*', 'id DESC');
        
        $data = array_merge($this->data, [
            'title'            => $this->title,
            'page'             => 'list',
            'list'             => $items,
            'redirect'         => $this->redirect,
            'form_link'        => $this->redirect . '/admin/form',
            'form_check_value' => 'form',
            'pagination'       => $this->pagination->create_links()
        ]);
        
        $this->load->view('layouts/admin/index', $data);
    }

    public function form($id = '')
    {
        $detail = $this->crud_model->get_where_single($this->table, ['id' => $id]);

        if ($this->input->post()) {
            $this->form_validation->set_rules('title_en', 'Title', 'required|trim');

            if ($this->form_validation->run()) {
                $post_id = $this->input->post('id');
                $file_name = $this->input->post('old_docpath');

                // 1. Image Upload Logic
                if (!empty($_FILES['docpath']['name'])) {
                    $upload_path = './uploads/courses/';
                    if (!is_dir($upload_path)) {
                        mkdir($upload_path, 0777, true);
                    }

                    $config = [
                        'upload_path'   => $upload_path,
                        'allowed_types' => 'jpeg|jpg|png|webp',
                        'encrypt_name'  => TRUE
                    ];
                    
                    $this->load->library('upload', $config);
                    $this->upload->initialize($config);

                    if ($this->upload->do_upload('docpath')) {
                        $file = $this->upload->data();
                        $file_name = 'uploads/courses/' . $file['file_name'];
                    } else {
                        $this->session->set_flashdata('error', $this->upload->display_errors());
                        redirect($this->redirect . '/admin/form/' . $id);
                    }
                }

                // 2. JSON Logic for points
                $types = $this->input->post('point_type');
                $texts = $this->input->post('point_text');
                $combined_points = [];

                if (!empty($texts)) {
                    foreach ($texts as $key => $val) {
                        if (!empty(trim($val))) {
                            $combined_points[] = [
                                'type' => $types[$key],
                                'text' => trim($val)
                            ];
                        }
                    }
                }
                $json_points = json_encode($combined_points);

                // 3. Robust Slug Logic
                $title_en = $this->input->post('title_en');
                $checktext = $this->crud_model->detectTextLanguage($title_en);
                
                if($checktext == true){
                    $text = $title_en;      
                } else {
                    $text = $this->title . ' ' . time();
                }

                $generated_slug = $this->crud_model->createUrlSlug($text);

                // If adding new course, check for slug uniqueness
                if (empty($post_id) && empty($id)) {
                    $check_slug = $this->crud_model->get_where_single($this->table, array('slug' => $generated_slug));
                    if (empty($check_slug)) {
                        $final_slug = strtolower($generated_slug);
                    } else {
                        $final_slug = strtolower($generated_slug) . '-' . time();
                    }
                } else {
                    // On update, keep existing slug from database
                    $final_slug = ($detail) ? $detail->slug : strtolower($generated_slug);
                }

                $update_data = [
                    'title_en'            => $title_en,
                    'title_jp'            => $this->input->post('title_jp'),
                    'slug'                => $final_slug,
                    'sub_level'           => $this->input->post('sub_level'),
                    'sub_text_en'         => $this->input->post('sub_text_en'),
                    'sub_text_jp'         => $this->input->post('sub_text_jp'),
                    'desc_en'             => $this->input->post('desc_en'),
                    'desc_jp'             => $this->input->post('desc_jp'),
                    'course_learn_points' => $json_points,
                    'docpath'             => $file_name,
                    'status'              => $this->input->post('status'), 
                    'updated_on'          => date('Y-m-d H:i:s'),
                    'updated_by'          => $this->userId
                ];
                
                $final_target_id = !empty($id) ? $id : $post_id;

                if (empty($final_target_id)) {
                    $update_data['created_on'] = date('Y-m-d H:i:s');
                    $update_data['created_by'] = $this->userId;
                    $this->crud_model->insert($this->table, $update_data);
                    $this->session->set_flashdata('success', 'Course added successfully');
                } else {
                    $this->crud_model->update($this->table, $update_data, ['id' => $final_target_id]);
                    $this->session->set_flashdata('success', 'Course updated successfully');
                }

                redirect($this->redirect . '/admin/all');
            }
        }

        $data = array_merge($this->data, [
            'detail'   => $detail,
            'title'    => ($id == '') ? 'Add ' . $this->title : 'Edit ' . $this->title,
            'page'     => 'form',
            'redirect' => $this->redirect
        ]);
        
        $this->load->view('layouts/admin/index', $data);
    }

    public function soft_delete($id){
        if ($id == '' || $id == 0) {
            $this->session->set_flashdata('error', 'Select Atleast One');
            redirect($this->redirect . '/admin/all');
        }

        $data = array(
            'status' => '2',
            'updated_by' => $this->userId, 
            'updated_on' => date('Y-m-d H:i:s'),
        );
        
        $result = $this->crud_model->update($this->table, $data, array('id' => $id));
        
        if($result){
            $this->session->set_flashdata('success','Successfully Deleted.');
        } else {
            $this->session->set_flashdata('error', 'Unable To Delete.');
        }
        redirect($this->redirect . '/admin/all');
    }
}