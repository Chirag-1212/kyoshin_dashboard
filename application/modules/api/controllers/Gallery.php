<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Gallery extends Front_controller
{
    function __construct()
    {
        parent::__construct();
        header('Content-type:application/json');
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Headers: Authorization, Origin, X-Requested-With, Content-Type, Accept, Content-Length, Accept-Encoding, X-API-KEY, Access-Control-Request-Method");
        header("Access-Control-Allow-Methods: GET, POST, OPTIONS, DELETE, PUT");
        
        $this->request_method = $_SERVER["REQUEST_METHOD"];
        if ($this->request_method == "OPTIONS") {
            die();
        }

        $this->table = 'gallery';
        $this->images_table = 'gallery_images';
    }

    // Get List of Galleries
    public function index($page = 0)
    {
        if ($this->request_method != "GET") {
            echo json_encode(['status' => "error", 'status_code' => 405, 'status_message' => "method not allowed"]);
            return;
        }

        $per_page = 12;
        $params = ['status' => '1'];
        
        // Ensure column names match your DB schema (no slug)
        $sql = "id, title_en, title_jn, coverimage, description, created, updated";
        
        $items = $this->crud_model->getData($this->table, $params, [], $per_page, $page, $sql, 'id DESC');
        
        // FIX: Added the 3rd argument (empty array) to satisfy the model's requirement
        $total = $this->crud_model->total($this->table, $params, []);

        if (!empty($items) && is_array($items)) {
            $galleryEn = [];
            $galleryNp = [];

            foreach ($items as $key => $val) {
                $image_url = !empty($val->coverimage) ? base_url($val->coverimage) : '';
                
                $galleryEn[$key] = [
                    'id' => $val->id,
                    'title' => $val->title_en,
                    'image' => $image_url,
                    'description' => $val->description,
                    'created' => $val->created
                ];

                $galleryNp[$key] = [
                    'id' => $val->id,
                    'title' => $val->title_jn,
                    'image' => $image_url,
                    'description' => $val->description,
                    'created' => $val->created
                ];
            }

            $response = [
                'status' => "success",
                'status_code' => 200,
                'items' => ['en' => $galleryEn, 'np' => $galleryNp],
                'total' => (int)$total,
                'per_page' => $per_page
            ];
        } else {
            $response = [
                'status' => "error", 
                'status_code' => 404, 
                'status_message' => "no items found"
            ];
        }

        echo json_encode($response);
    }

    // Get Single Gallery Detail using ID
    public function detail($id)
    {
        if ($this->request_method != "GET" || empty($id)) {
            echo json_encode(['status' => "error", 'status_code' => 400, 'status_message' => "invalid request"]);
            return;
        }

        $detail = $this->crud_model->get_where_single($this->table, ['id' => $id, 'status' => '1']);

        if ($detail) {
            $multi_images = [];
            $images = $this->crud_model->get_where($this->images_table, ['gallery_id' => $detail->id, 'status' => '1']);
            
            if (!empty($images) && is_array($images)) {
                foreach ($images as $img) {
                    $multi_images[] = [
                        'id' => $img->id,
                        'doc' => base_url($img->docpath)
                    ];
                }
            }

            $image_url = !empty($detail->coverimage) ? base_url($detail->coverimage) : '';

            $response = [
                'status' => "success",
                'status_code' => 200,
                'detail' => [
                    'en' => [
                        'id' => $detail->id,
                        'title' => $detail->title_en,
                        'description' => strip_tags($detail->description),
                        'image' => $image_url,
                        'multi_images' => $multi_images
                    ],
                    'np' => [
                        'id' => $detail->id,
                        'title' => $detail->title_jn,
                        'description' => strip_tags($detail->description),
                        'image' => $image_url,
                        'multi_images' => $multi_images
                    ]
                ]
            ];
        } else {
            $response = ['status' => "error", 'status_code' => 404, 'status_message' => "gallery not found"];
        }

        echo json_encode($response);
    }
}