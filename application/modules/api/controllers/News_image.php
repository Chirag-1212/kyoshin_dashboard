<?php
defined('BASEPATH') or exit('No direct script access allowed');

class News_image extends Front_controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');

        // CORS and JSON Headers
        header('Content-type:application/json');
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Headers: Authorization, Origin, X-Requested-With, Content-Type, Accept, Content-Length, Accept-Encoding, X-API-KEY, Access-Control-Request-Method");
        header("Access-Control-Allow-Methods: GET, POST, OPTIONS, DELETE, PUT");

        $this->request_method = $_SERVER["REQUEST_METHOD"];
        if ($this->request_method == "OPTIONS") {
            die();
        }

        // Small letters for database logic
        $this->table = 'news_images';
    }

    /**
     * Fetch news images
     * Optional GET parameter: news_id (to filter images for a specific news post)
     * URL: base_url/news_image/api
     */
    public function index()
    {
        if ($this->request_method != "GET") {
            $response = array(
                'status' => "error",
                'status_code' => 405,
                'status_message' => "method not allowed",
            );
        } else {
            // Filter by news_id if provided in the URL (?news_id=5)
            $news_id = $this->input->get('news_id');
            $param = ['status' => '1'];
            
            if (!empty($news_id)) {
                $param['news_id'] = $news_id;
            }

            $items = $this->crud_model->getData(
                $this->table,
                $param,
                [],
                50, // limit
                0,  // offset
                'id, news_id, description, docpath',
                'id desc'
            );

            if ($items) {
                // Formatting image paths
                foreach ($items as &$item) {
                    $item->docpath = !empty($item->docpath) ? base_url($item->docpath) : null;
                }

                $response = array(
                    'status' => "success",
                    'status_code' => 200,
                    'status_message' => "image list",
                    'images' => $items,
                );
            } else {
                $response = array(
                    'status' => "error",
                    'status_code' => 404,
                    'status_message' => "no images found",
                );
            }
        }
        echo json_encode($response);
    }

    /**
     * Fetch a single image detail
     * URL: base_url/news_image/api/detail?id=5
     */
    public function detail()
    {
        if ($this->request_method != "GET") {
            $response = array('status' => 'error', 'status_code' => 405, 'status_message' => 'method not allowed');
        } else {
            $id = $this->input->get('id');
            $detail = $this->crud_model->get_where_single($this->table, ['id' => $id, 'status' => '1']);

            if ($detail) {
                $detail->docpath = !empty($detail->docpath) ? base_url($detail->docpath) : null;

                $response = array(
                    'status' => "success",
                    'status_code' => 200,
                    'status_message' => "image detail",
                    'data' => $detail,
                );
            } else {
                $response = array('status' => 'error', 'status_code' => 404, 'status_message' => 'image not found');
            }
        }
        echo json_encode($response);
    }
}