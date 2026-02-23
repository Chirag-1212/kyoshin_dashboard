<?php 

class Content extends Front_controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	 
	 public function __construct()
	{
		parent::__construct();   
		$this->table = 'contents'; 
		$this->title = 'Content';
	}
	
	public function all($page='')
	{   
	    $config['base_url'] = base_url('blog/all');
		$config['total_rows'] = $this->crud_model->count_all($this->table,array('status'=>'1'),'id');
		$config['uri_segment'] = 3;
		$config['per_page'] = 4;
		//outside of flist that is <ul></ul>
		$config['full_tag_open'] = '<ul class="justify-content-center">';

		//go to first link customize
		$config['first_link'] = 'First';
		$config['first_tag_open'] = '<li>';
		$config['first_tag_close'] = '</li>';

		//for all list outside of the a tag that is <li></li>
		$config['num_tag_open'] = '<li>'; 
		//to add class to attribute
		$config['attributes'] = array('class' => 'page-link');
		$config['num_tag_close'] = '</li>';

		//customize current page
		$config['cur_tag_open'] = '<li class="active"><a>';
		$config['cur_tag_close'] = '</a></li>';

		$config['last_link'] = 'Last';
		$config['last_tag_open'] = '<li class="page-item">';
		$config['last_tag_close'] = '</li>';

		$config['full_tag_close'] = '</ul>';

		$this->pagination->initialize($config);

		$page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;

		$data['pagination'] = $this->pagination->create_links();
		$data['items'] = $this->crud_model->get_where_pagination($this->table,array('status'=>'1'),$config["per_page"], $page);
	   
	    $data['site_settings'] = $this->session->userdata('site_settings'); 
	    $data['recent'] = $this->crud_model->get_where_pagination($this->table,array('status'=>'1'),6,0);
        $data['title'] = $this->title; 
        
        $data['page'] = 'front/list';
        $this->load->view('layouts/front/index',$data);
	}
	
	public function detail($slug='')
	{
	    $data['detail'] = $this->db->get_where($this->table,array('slug'=>$slug))->row();
	    
	    $data['site_settings'] = $this->session->userdata('site_settings'); 
        $data['title'] = $data['detail']->title;
        
        // meta property
        $data['meta_title'] = $data['detail']->title;
        $data['meta_description'] = substr(strip_tags($data['detail']->description), 0, 170);
        
        $meta_keywords_explode = explode(" ",$data['meta_title']);
        $meta_keywords = '';
        foreach($meta_keywords_explode as $key=>$value){
            if($key==0){
                $comma = '';
            }else{
                $comma = ', ';
            }
            $meta_keywords .= $comma.$value;
        }
        $data['meta_keywords'] = 'shine, trades, trades nepal, '.$meta_keywords; 
        // meta property end
        
        $data['recent'] = $this->crud_model->get_where_pagination($this->table,array('status'=>'1'),6,0);
        $data['page'] = 'front/detail';
        $this->load->view('layouts/front/index',$data);
	}
}
