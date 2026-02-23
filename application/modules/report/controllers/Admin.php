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
		// var_dump($this->current_user);exit;
		$this->load->library('form_validation');
		$this->table = 'report';
		$this->redirect = 'report/admin/';
		$this->title = 'Report';
		$this->userId = $this->data['userId'];
	}
	
	
	public function all($page = '')
	{

		$like = [];
		$param = [
			'status !=' => '2'
		];
		if($this->input->method() == 'get'){
			$search = $this->input->get('table_search');
			$like['title'] = $search;
		}

		$total = $this->crud_model->total($this->table, $param, $like);

		$config['base_url'] = base_url($this->redirect . 'all');
		$config['total_rows'] = $total;
		$config['uri_segment'] = 4;
		$config['per_page'] = 10;
		//outside of flist that is <ul></ul>
		$config['full_tag_open'] = '<ul class="pagination pagination-sm m-0 float-right">';

		//go to first link customize
		$config['first_link'] = 'First';
		$config['first_tag_open'] = '<li class="page-item">';
		$config['first_tag_close'] = '</li>';

		//for all list outside of the a tag that is <li></li>
		$config['num_tag_open'] = '<li class="page-item">';
		//to add class to attribute
		$config['attributes'] = array('class' => 'page-link');
		$config['num_tag_close'] = '</li>';

		$config['next_link'] = 'Next';
		$config['next_tag_open'] = '<li class="page-item">';
		$config['next_tag_close'] = '</li>';

		$config['prev_link'] = 'Prev';
		$config['prev_tag_open'] = '<li class="page-item">';
		$config['prev_tag_close'] = '</li>';

		//customize current page
		$config['cur_tag_open'] = '<li class="page-item active"><a class="page-link">';
		$config['cur_tag_close'] = '</a></li>';

		$config['last_link'] = 'Last';
		$config['last_tag_open'] = '<li class="page-item">';
		$config['last_tag_close'] = '</li>';

		$config['full_tag_close'] = '</ul>';
		$config['suffix'] = isset($search)?"?table_search=$search":'';
		$this->pagination->initialize($config);

		$page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;

		$data['items'] = $this->crud_model->getData($this->table, $param, $like, $config["per_page"], $page);
		$data['pagination'] = $this->pagination->create_links();
		$data['offset'] = $page;
		$data['title'] = $this->title;
		$data['page'] = 'list';
		$data['report'] = 'report-all';
		$data['redirect'] = $this->redirect;
		$data = array_merge($this->data, $data);
		$this->load->view('layouts/admin/index', $data);
	}

	public function form($id = '')
	{

		$data['detail'] = $this->db->get_where($this->table, array('id' => $id))->row();
		$doc_path='uploads/report/';
		if ($this->input->post()) {
			$this->form_validation->set_rules('title', 'Title', 'required|trim');
			if ($this->form_validation->run()) {

				if (strlen($_FILES['DocPath']['name']) > 0) {

					$config['upload_path'] = $doc_path;

					$config['allowed_types'] = 'jpeg|jpg|gif|png|pdf';

					$config['max_size'] = '300000';

					$this->load->library('upload', $config);

					if (!$this->upload->do_upload('DocPath')) {

						$this->session->set_flashdata('error', $this->upload->display_errors());
						if ($id == '') {
							redirect($this->redirect . 'form');
						} else {
							redirect($this->redirect . 'form/' . $id);
						}
					} else {

						$file = $this->upload->data();

						$file_name =$doc_path. $file['file_name'];
					}
				} else {
					if (isset($data['detail']->DocPath) && $data['detail']->DocPath != '') {
						$file_name = $data['detail']->DocPath;
					} else {
						$file_name = "";
					}
				}

				$data = array(
					'title' => $this->input->post('title'),
					'title_nepali' => $this->input->post('title_nepali'),
					'DocPath' => $file_name,
					'fiscal_id' => $this->input->post('fiscal_id'),
					'description_nepali' => $this->input->post('description_nepali'),
					'description' => $this->input->post('description'),
					'category_id' => $this->input->post('category_id'),
					'status' => $this->input->post('status'),
				);
				$id = $this->input->post('id');
				if ($id == '') {
				    $checktext=$this->crud_model->detectTextLanguage($this->input->post('title'));
			 	
    			    if($checktext==true){
    			        $text=$this->input->post('title');
    			    }else{
    			        $text=$this->title. time();
    			    }
    				$slug = $this->crud_model->createUrlSlug($text);
				// 	$slug = $this->crud_model->createUrlSlug($this->input->post('title'));
					$check_slug = $this->crud_model->get_where_single($this->table, array('slug' => $slug));
					if (empty($check_slug)) {
						$data['slug'] = strtolower($slug);
					} else {
						$data['slug'] = strtolower($slug) . time();
					}
					$data['created_by'] = $this->userId;
					$data['created'] = date('Y-m-d');
					$result = $this->crud_model->insert($this->table, $data);
					if ($result == true) {
						$this->session->set_flashdata('success', 'Successfully Inserted.');
						redirect($this->redirect . 'all');
					} else {
						$this->session->set_flashdata('error', 'Unable To Insert.');
						redirect($this->redirect . 'form');
					}
				} else {
    				$slug = $this->crud_model->createUrlSlug($this->input->post('title'));
    				$alreadySlug = $this->crud_model->getField($this->table, array('id' => $id), 'slug');
    				if ($alreadySlug != $slug) {
    					$check_slug = $this->crud_model->get_where_single($this->table, array('id !=' => $id, 'slug' => strtolower($slug)));
    					$data['slug'] = strtolower($slug);
    					if($check_slug){
    						$data['slug'] = strtolower($slug) . time();
    					}
    					
				    }
					$data['updated'] = date('Y-m-d');
					$data['updated_by'] = $this->userId;
					$result = $this->crud_model->update($this->table, $data, array('id' => $id));
					if ($result == true) {
						$this->session->set_flashdata('success', 'Successfully Updated.');
						redirect($this->redirect . 'all');
					} else {
						$this->session->set_flashdata('error', 'Unable To Update.');
						redirect($this->redirect . 'form/' . $id);
					}
				}
			}
		}
		// $data['categories'] = $this->crud_model->get_where_order_by('report_category', array('status' => '1'), 'id', 'ASC');
		if (isset($data['detail']->category_id)) {
			$selected_category = $data['detail']->category_id;
		} else {
			$selected_category = '';
		}
		$data['fiscal_years'] = $this->crud_model->get_where_order_by('fiscal_year', array('status' => '1'), 'title', 'DESC');
		
		$data['html'] = $this->get_parents_html($selected_category);
		$data['doc_path'] = $doc_path;
		$data['title'] = 'Add/Edit ' . $this->title;
		$data['page'] = 'form';
		$data['report'] = 'report-form';
		$data = array_merge($this->data, $data);
		$this->load->view('layouts/admin/index', $data);
	}

	public function soft_delete($id)
	{
		$data = array(
			'status' => '2',
			'updated_by' => $this->userId,
			'updated' => date('Y-m-d'),
		);
		$result = $this->crud_model->update($this->table, $data, array('id' => $id));
		if ($result == true) {
			$this->session->set_flashdata('success', 'Successfully Deleted.');
			redirect($this->redirect . 'all');
		} else {
			$this->session->set_flashdata('error', 'Unable To Delete.');
			redirect($this->redirect . 'all');
		}
	}

	public function get_parents_html($selected_parent = '')
	{
		$html = '<option value="NULL">Root</option>';
		$parents = $this->db->order_by('rank', 'ASC')->get_where('report_category', array('status' => '1', 'parent_id' => 0))->result();
		if ($parents) {
			foreach ($parents as $key => $value) {
				$html  .= '<option value="' . $value->id . '" ' . (((isset($value->id)) && $value->id == $selected_parent) ? "selected" : "") . '>' . $value->PageTitle . '</option>';
				$childs = $this->db->get_where('report_category', array('parent_id' => $value->id, 'status' => '1'))->result();
				if (!empty($childs)) {
					$space = '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
					// var_dump($this->get_childs($html,$childs,$selected_parent,$space));exit;
					$html .= $this->get_childs($childs, $selected_parent, $space);
				}
			}
		}

		return $html;
	}

	public function get_childs($childs = array(), $selected_parent, $space)
	{
		// var_dump($html);exit;
		$html = '';
		if (!empty($childs)) {
			foreach ($childs as $key => $value) {
				// echo "here";exit;
				$html  .= '<option value="' . $value->id . '" ' . (((isset($value->id)) && $value->id == $selected_parent) ? "selected" : "") . '>' . $space . $value->PageTitle . '</option>';
				$new_childs = $this->db->order_by('rank', 'ASC')->get_where('report_category', array('parent_id' => $value->id, 'status' => '1'))->result();
				if (!empty($new_childs)) {
					$space = $space . '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
					$html .= $this->get_childs($new_childs, $selected_parent, $space);
				}
			}
		}
		return $html;
	}
}