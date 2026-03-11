<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Admin extends Auth_controller
{
    protected $userId, $table, $images_table, $redirect, $title;

    public function __construct()
    {
        parent::__construct();
        $this->table = 'gallery';
        $this->images_table = 'gallery_images';
        $this->title = 'Gallery';
        $this->redirect = 'gallery'; 
        $this->userId = $this->data['userId'];
    }

    public function all()
    {
        $search = $this->input->get('table_search');
        $param = ['status !=' => '2'];
        $like = $search ? ['title_en' => $search] : [];

        $config = [
            'base_url' => base_url($this->redirect . '/admin/all'),
            'total_rows' => $this->crud_model->total($this->table, $param, $like),
            'per_page' => 10,
            'uri_segment' => 4,
            'suffix' => $search ? "?table_search=$search" : ''
        ];
        
        $this->pagination->initialize($config);
        $page = $this->uri->segment(4) ?: 0;

        $data = array_merge($this->data, [
            'title' => $this->title,
            'page' => 'list',
            'items' => $this->crud_model->getData($this->table, $param, $like, $config["per_page"], $page, '*', 'id DESC'),
            'redirect' => $this->redirect,
            'form_link' => $this->redirect . '/admin/form/',
            'delete_link' => $this->redirect . '/admin/soft_delete/',
            'pagination' => $this->pagination->create_links(),
            'offset' => $page
        ]);

        $this->load->view('layouts/admin/index', $data);
    }

    public function form($id = '')
    {
        $detail = $this->crud_model->get_where_single($this->table, ['id' => $id]);
        $path = 'uploads/gallery/';

        if ($this->input->post()) {
            $this->form_validation->set_rules('title_en', 'Title English', 'required|trim');
            
            if ($this->form_validation->run()) {
                $post_id = $this->input->post('id');
                $cover_img = $this->_handle_upload('coverimage', $path, @$detail->coverimage);

                $save_data = [
                    'title_en'     => $this->input->post('title_en'),
                    'title_jn'     => $this->input->post('title_jn'),
                    'description'  => $this->input->post('description'),
                    'coverimage'   => $cover_img,
                    'status'       => $this->input->post('status')
                ];

                if (empty($post_id)) {
                    $save_data['created'] = date('Y-m-d');
                    $save_data['created_by'] = $this->userId;
                    $db_id = $this->crud_model->inserted($this->table, $save_data);
                } else {
                    $save_data['updated'] = date('Y-m-d');
                    $save_data['updated_by'] = $this->userId;
                    $this->crud_model->update($this->table, $save_data, ['id' => $post_id]);
                    $db_id = $post_id;
                }

                if ($db_id) $this->_handle_gallery($db_id, $path);
                $this->session->set_flashdata('success', 'Operation successful');
                redirect($this->redirect . '/admin/all');
            }
        }

        $data = [
            'title'    => ($detail ? 'Edit ' : 'Add ') . $this->title,
            'detail'   => $detail,
            'redirect' => $this->redirect,
            'items'    => $id ? $this->crud_model->get_where($this->images_table, ['status !=' => '2', 'gallery_id' => $id]) : [],
            'page'     => 'form'
        ];
        
        $this->load->view('layouts/admin/index', array_merge($this->data, $data));
    }

    private function _handle_upload($field, $path, $existing) {
        if (!empty($_FILES[$field]['name'])) {
            if (!is_dir($path)) mkdir($path, 0777, true);
            $config = ['upload_path' => $path, 'allowed_types' => 'jpeg|jpg|png', 'encrypt_name' => TRUE];
            $this->load->library('upload', $config);
            if ($this->upload->do_upload($field)) {
                $data = $this->upload->data();
                return $path . $data['file_name'];
            }
        }
        return $existing ?: "";
    }

    private function _handle_gallery($gallery_id, $path) {
        if (!empty($_FILES['files']['name'][0])) {
            $filesCount = count($_FILES['files']['name']);
            $uploadData = [];
            $this->load->library('upload');
            for ($i = 0; $i < $filesCount; $i++) {
                $_FILES['file']['name'] = $_FILES['files']['name'][$i];
                $_FILES['file']['type'] = $_FILES['files']['type'][$i];
                $_FILES['file']['tmp_name'] = $_FILES['files']['tmp_name'][$i];
                $_FILES['file']['error'] = $_FILES['files']['error'][$i];
                $_FILES['file']['size'] = $_FILES['files']['size'][$i];

                $config = ['upload_path' => $path, 'allowed_types' => 'jpg|jpeg|png|gif', 'encrypt_name' => TRUE];
                $this->upload->initialize($config);
                if ($this->upload->do_upload('file')) {
                    $fileData = $this->upload->data();
                    $uploadData[] = [
                        'docpath'    => $path . $fileData['file_name'],
                        'gallery_id' => $gallery_id,
                        'status'     => '1',
                        'created_on' => date("Y-m-d H:i:s")
                    ];
                }
            }
            if (!empty($uploadData)) $this->crud_model->insertarr($this->images_table, $uploadData);
        }
    }

    public function soft_delete($id){
        $data = array(
            'status'     => '2',
            'updated_by' => $this->userId, 
            'updated'    => date('Y-m-d'),
        );
        $this->db->where(array('id'=>$id));
        $result = $this->db->update($this->table, $data);
        if($result == true){
            $this->session->set_flashdata('success', 'Successfully Deleted.');
            redirect($this->redirect . '/admin/all');
        } else {
            $this->session->set_flashdata('error', 'Unable To Delete.');
            redirect($this->redirect . '/admin/all');
        }
    }
}