<?php
defined('BASEPATH') or exit('No direct script access allowed');

class News extends Front_controller
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

        // Table definitions in small letters
        $this->table = 'news';
        $this->image_table = 'news_images';
    }

    /**
     * Fetch all active news items
     * GET: base_url/news/api
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
            // Fetching news data with lowercase columns
            $items = $this->crud_model->getData(
                $this->table,
                ['status' => '1'],
                [],
                20, // limit
                0,  // offset
                'id, slug, title_en, title_jp, desc_en, desc_jp, docpath',
                'id desc'
            );

            if ($items) {
                // Formatting image paths and checking for secondary image
                foreach ($items as &$item) {
                    $item->docpath = !empty($item->docpath) ? base_url($item->docpath) : null;
                    
                    // Fetching specific secondary image from news_images
                    $related = $this->crud_model->get_where_single($this->image_table, [
                        'news_id' => $item->id, 
                        'status' => '1'
                    ]);
                    $item->news_image = ($related) ? base_url($related->docpath) : null;
                }

                $response = array(
                    'status' => "success",
                    'status_code' => 200,
                    'status_message' => "news list",
                    'news' => $items,
                );
            } else {
                $response = array(
                    'status' => "error",
                    'status_code' => 404,
                    'status_message' => "no news items found",
                );
            }
        }
        echo json_encode($response);
    }

    /**
     * Fetch news detail by slug
     * GET: base_url/news/api/detail?slug=your-news-slug
     */
    public function detail()
    {
        if ($this->request_method != "GET") {
            $response = array('status' => 'error', 'status_code' => 405, 'status_message' => 'method not allowed');
        } else {
            $slug = $this->input->get('slug');
            $detail = $this->crud_model->get_where_single($this->table, ['slug' => $slug, 'status' => '1']);

            if ($detail) {
                $detail->docpath = !empty($detail->docpath) ? base_url($detail->docpath) : null;
                
                // Fetch related image
                $related = $this->crud_model->get_where_single($this->image_table, ['news_id' => $detail->id, 'status' => '1']);
                $detail->news_image = ($related) ? base_url($related->docpath) : null;

                $response = array(
                    'status' => "success",
                    'status_code' => 200,
                    'status_message' => "news detail",
                    'data' => $detail,
                );
            } else {
                $response = array('status' => 'error', 'status_code' => 404, 'status_message' => 'news not found');
            }
        }
        echo json_encode($response);
    }
}