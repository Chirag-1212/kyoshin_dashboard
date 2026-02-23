<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Admin extends Auth_controller
{
	protected $title;
	protected $module;
	protected $redirect;
	protected $table;
	protected $userId;
	public function __construct()
	{
		parent::__construct();
		// var_dump($this->current_user);exit;
		$this->load->library('form_validation');
		$this->table = 'content';
		$this->redirect = 'content/admin/';
		$this->title = 'Content';
		$this->module = 'Content';
		$this->userId = $this->data['userId'];
	}

	public function all($page = '')
	{

		$like = [];
		$param = [
			'status !=' => '2',
			'show_on_menu' => 'No',
		];
		if($this->input->method() == 'get'){
			$search = $this->input->get('table_search');
			if($search){
			  	$like['PageTitle'] = $search;
			    $like['Description'] = $search;  
			}
		
		}
		$total = $this->crud_model->total($this->table, $param, $like);
		$page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
		$config['base_url'] = base_url($this->redirect . 'all/');
		
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

		$data['pagination'] = $this->pagination->create_links();
		$data['items'] = $this->crud_model->getData($this->table, $param, $like, $config["per_page"], $page);
		
		$data['offset'] = $page;
		$data['title'] = 'Contents';
		$data['page'] = 'list';
		$data['module'] = $this->module;
		$data['type'] = '';
		$data = array_merge($this->data, $data);

		$this->load->view('layouts/admin/index', $data);
	}

	public function edit($id = '')
	{

		$data['detail'] = $this->db->get_where($this->table, array('id' => $id))->row();
		$doc_path='uploads/content/';
		$type = $data['detail']->Type;
		if ($this->input->post()) {
			$this->form_validation->set_rules('PageTitle', 'Page Title', 'required|trim');

			if ($this->form_validation->run()) {
			    if (strlen($_FILES['featured_image']['name']) > 0) {

					$config['upload_path'] = $doc_path;

					$config['allowed_types'] = 'jpeg|jpg|gif|png|pdf';

					$config['max_size'] = '3000';
					$this->load->library('upload', $config);

					if (!$this->upload->do_upload('featured_image')) {

						$this->session->set_flashdata('error', $this->upload->display_errors());
						if ($id == '') {
							redirect($this->redirect . 'form');
						} else {
							redirect($this->redirect . 'edit/' . $id);
						}
					} else {

						$file = $this->upload->data();

						$featured_image = $doc_path.$file['file_name'];
					}
				} else {
					if (isset($data['detail']->featured_image) && $data['detail']->featured_image != '') {
						$featured_image = $data['detail']->featured_image;
					} else {
						$featured_image = "";
					}
				}
				$data = array(
					'PageTitle' => $this->input->post('PageTitle'),
					'PageTitleNepali' => $this->input->post('PageTitleNepali'),
					'Description' => ($this->input->post('description')),
					'DescriptionNepali' => ($this->input->post('DescriptionNepali')),
					'CoverImage' => $featured_image,
					'parent_id' => $this->input->post('parent_id'),
					'rank' => $this->input->post('rank'),
					'show_on_menu' => 'No',
					'show_type' => $this->input->post('show_type'),
				);
				$id = $this->input->post('id');
				if ($id == $data['parent_id']) {
					$data['parent_id'] = 0;
				}
				$data['updated_on'] = date('Y-m-d');
				$data['updated_by'] = $this->userId;
				$result = $this->crud_model->update($this->table, $data, array('id' => $id));
				
				if ($result == true) {
					$this->session->set_flashdata('success', 'Successfully Updated.');
					redirect($this->redirect . 'all');
				} else {
					$this->session->set_flashdata('error', 'Unable To Update.');
					redirect($this->redirect . 'edit/' . $id);
				}
			}
		}
		$data['title'] = 'Add/Edit ' . $this->title;
		$data['page'] = 'form';



		if (isset($data['detail']->parent_id)) {
			$selected_parent = $data['detail']->parent_id;
		} else {
			$selected_parent = '';
		}
		$data['html'] = $this->get_parents_html($selected_parent);
		$data['module'] = $this->module;
		$data['doc_path'] = $doc_path;
		$data = array_merge($this->data, $data);

		$this->load->view('layouts/admin/index', $data);
	}
	
	public function add()
	{	
		$doc_path='uploads/content/';
		if ($this->input->post()) {
			$this->form_validation->set_rules('PageTitle', 'Page Title', 'required|trim');

			if ($this->form_validation->run()) {
				if (strlen($_FILES['featured_image']['name']) > 0) {

					$config['upload_path'] = $doc_path;

					$config['allowed_types'] = 'jpeg|jpg|gif|png|pdf';

					$config['max_size'] = '3000';
					$this->load->library('upload', $config);

					if (!$this->upload->do_upload('featured_image')) {

						$this->session->set_flashdata('error', $this->upload->display_errors());
						if ($id == '') {
							redirect($this->redirect . 'add');
						} else {
							redirect($this->redirect . 'edit/' . $id);
						}
					} else {

						$file = $this->upload->data();

						$featured_image = $doc_path.$file['file_name'];
					}
				} else {
					if (isset($data['detail']->featured_image) && $data['detail']->featured_image != '') {
						$featured_image = $data['detail']->featured_image;
					} else {
						$featured_image = "";
					}
				}
				$data = array(
					'PageTitle' => $this->input->post('PageTitle'),
					'PageTitleNepali' => $this->input->post('PageTitleNepali'),
					'Description' => ($this->input->post('description')),
					'DescriptionNepali' => ($this->input->post('DescriptionNepali')),
					// 'type' => $type,
					'CoverImage' => $featured_image,
					'status' => '1',
					'parent_id' => $this->input->post('parent_id'),
					'rank' => $this->input->post('rank'),
					'show_on_menu' => 'No',
					'show_type' => $this->input->post('show_type'),
				);
                $checktext=$this->crud_model->detectTextLanguage($this->input->post('PageTitle'));
				 	
			    if($checktext==true){
			        $text=$this->input->post('PageTitle');
			    }else{
			        $text=$this->title. time();
			    }
				$slug = $this->crud_model->createUrlSlug($text);
				// $slug = $this->crud_model->createUrlSlug($this->input->post('PageTitle'));
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
					redirect($this->redirect . 'add');
				}
			}
		}
		$data['title'] = 'Add Content';
		$data['page'] = 'form';
		$data['doc_path'] = $doc_path;
		$data['html'] = $this->get_parents_html($selected_parent = '');
		$data['module'] = $this->module;
		$data = array_merge($this->data, $data);

		$this->load->view('layouts/admin/index', $data);
	}
	
	public function get_parents_html($selected_parent = '')
	{
		$html = '<option value="">Select Parent</option>';
		$parents = $this->db->order_by('rank', 'ASC')->get_where($this->table, array('status' => '1', 'parent_id' => 0))->result();
		if ($parents) {
			foreach ($parents as $key => $value) {

				
				$childs = $this->db->get_where($this->table, array('parent_id' => $value->id, 'status' => '1', 'show_on_menu' => 'Yes'))->result();
				$disable = '';
				if (!empty($childs)) {
					$disable = 'disabled = "disabled"';
				}
				$html  .= '<option '.$disable.' value="' . $value->id . '" ' . (((isset($value->id)) && $value->id == $selected_parent) ? "selected" : "") . '>' . $value->PageTitle . '</option>';
				
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
				$new_childs = $this->db->order_by('rank', 'ASC')->get_where($this->table, array('parent_id' => $value->id, 'status' => '1', 'show_on_menu' => 'Yes'))->result();
				$disable = '';
				if (!empty($new_childs)) {
					$disable = 'disabled = "disabled"';
				}
				$html  .= '<option '.$disable.' value="' . $value->id . '" ' . (((isset($value->id)) && $value->id == $selected_parent) ? "selected" : "") . '>' . $space . $value->PageTitle . '</option>';
				if (!empty($new_childs)) {
					$space = $space . '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
					$html .= $this->get_childs($new_childs, $selected_parent, $space);
				}
			}
		}
		return $html;
	}

	public function soft_delete( $id){
		$data = array(
			'status' => '2',
			'updated_by' => $this->userId,
			'updated_on' => date('Y-m-d'),
		);
		$result = $this->crud_model->update($this->table, $data, array('id' => $id));
		if ($result == true) {
			$this->session->set_flashdata('success', 'Successfully Deleted.');
			redirect($this->redirect . 'all/');
		} else {
			$this->session->set_flashdata('error', 'Unable To Delete.');
			redirect($this->redirect . 'all/' );
		}
	}
	public function soft_delete_type($type, $id){
		$data = array(
			'status' => '2',
			'updated_by' => $this->userId,
			'updated_on' => date('Y-m-d'),
		);
		$result = $this->crud_model->update($this->table, $data, array('id' => $id));
		if ($result == true) {
			$this->session->set_flashdata('success', 'Successfully Deleted.');
			redirect($this->redirect . 'all/' . $type);
		} else {
			$this->session->set_flashdata('error', 'Unable To Delete.');
			redirect($this->redirect . 'all/' . $type);
		}
	}


	// Rajesh Menu Part Strat

	public function menuTree($parent_id = 0, $html = '')
	{
		// $menus = Menu::where('category_id', $parent_id)->where('delete_status', '0')->where('publish_status', '1')->where('show_on_menu', '1')->orderBy('position','asc')->get();

		$menus = $this->db->order_by('rank', 'ASC')->get_where($this->table, array('parent_id' => $parent_id, 'status' => '1', 'show_on_menu' => 'Yes'))->result();
		// var_dump($this->db->last_query());
		// exit;
		if (count($menus) > 0) {
			$html = '';
			foreach ($menus as $row) {
				// $subMenus = Menu::where('category_id', $row->id)->where('delete_status', '0')->where('publish_status', '1')->where('show_on_menu', '1')->orderBy('position','asc')->get(); 
				$subMenus = $this->db->order_by('rank', 'ASC')->get_where($this->table, array('parent_id' => $row->id, 'status' => '1', 'show_on_menu' => 'Yes'))->result();
				if (count($subMenus) > 0) {
					$html .= '<li id="menuItem_' . $row->id . '">
                                <div class="menu-handle">
                                    <span>' .
						$row->PageTitle
						. '</span>
                                    <div class="menu-options">';
					if ($row->Type == 'em') {
						$html   .= '<a class="edit_self design_edit" id="' . $row->id . '">Edit</a>';
					} else {
						$html   .= '<a class="edit_self design_edit" id="' . $row->id . '">Edit</a>';
					}

					$html  .=  		'<a class="del_menu" id="' . $row->id . '">Remove</a>
                                    </div>
                                </div>
                                <ol>';
					$html .= $this->menuTree($row->id);
					$html .=    '</ol>
                            </li> ';
				} else {
					$html .= '
                                <li id="menuItem_' . $row->id . '">
                                        <div class="menu-handle">
                                        <span>' .
						$row->PageTitle
						. '</span>
                                        <div class="menu-options">';
					if ($row->Type == 'em') {
						$html   .= '<a class="edit_self design_edit" id="' . $row->id . '">Edit</a>';
					} else {
						$html   .= '<a class="edit_self design_edit" id="' . $row->id . '">Edit</a>';
					}

					$html  .=  					'<a class="del_menu" id="' . $row->id . '">Remove</a>
                                        </div>
                                        </div>
                                </li>';
				}
			}
		}
		return  $html;
	}

	public function menu()
	{
		if ($this->input->post()) {
			$this->form_validation->set_rules('PageTitle', 'Page Title', 'required|trim');
// 			$this->form_validation->set_rules('link', 'Url', 'required|trim');

			if ($this->form_validation->run()) {
				$data = array(
					'PageTitle' => $this->input->post('PageTitle'),
					'PageTitleNepali' => $this->input->post('PageTitleNepali'),
					'parent_id' => $this->input->post('parent_id'),
					'Type' => 'em',
					'status' => '1',
					'link' => $this->input->post('link'),
					'rank' => $this->input->post('rank'),
					'show_on_menu' => 'Yes',
					'show_type' => $this->input->post('show_type'),
				);

				$slug = $this->crud_model->createUrlSlug($this->input->post('PageTitle'));
				$check_slug = $this->crud_model->get_where_single($this->table, array('PageTitle' => $slug));
				if (empty($check_slug)) {
					$data['slug'] = strtolower($slug);
				} else {
					$data['slug'] = strtolower($slug) . time();
				}
				$data['created_by'] = $this->userId;
				$data['created'] = date('Y-m-d H:i:s');
				$data['created_on'] = date('Y-m-d');
				
				$result = $this->crud_model->insert($this->table, $data);
				if ($result == true) {
					$this->session->set_flashdata('success', 'Successfully Inserted.');
					redirect($this->redirect . 'menu');
				} else {
					$this->session->set_flashdata('error', 'Unable To Insert.');
					redirect($this->redirect . 'menu');
				}
			}
		}
		$data['menu'] = $this->menuTree();
		$data['title'] = 'Drag And Drop And Reorder All Menu';
		$data['html'] = $this->get_parents_menu_html($selected_parent = '');
		$data['page'] = 'menu';
		$data = array_merge($this->data, $data);
		
		$this->load->view('layouts/admin/index', $data);
	}

	public function menu_edit()
	{
		if ($this->input->post()) {
			$this->form_validation->set_rules('PageTitle', 'Page Title', 'required|trim');

			if ($this->form_validation->run()) {
				$data = array(
					'PageTitle' => $this->input->post('PageTitle'),
					'PageTitleNepali' => $this->input->post('PageTitleNepali'),
					'link' => $this->input->post('link'),
					'show_type' => $this->input->post('show_type'),
				);

				$id = $this->input->post('id');
				// to avoid changing slug
				// $slug = $this->crud_model->createUrlSlug($this->input->post('PageTitle'));
				// $alreadySlug = $this->crud_model->getField($this->table, array('id' => $id), 'slug');
				// if ($alreadySlug != $slug) {
				// 	$check_slug = $this->crud_model->get_where_single($this->table, array('id !=' => $id, 'slug' => strtolower($slug)));
				// 	$data['slug'] = strtolower($slug);
				// 	if($check_slug){
				// 		$data['slug'] = strtolower($slug) . time();
				// 	}
					
				// }
				$data['updated_by'] = $this->userId;
				$data['updated_on'] = date('Y-m-d');
				
				$result = $this->crud_model->update($this->table, $data, array('id' => $id));
				if ($result == true) {
					$this->session->set_flashdata('success', 'Successfully Inserted.');
					redirect($this->redirect . 'menu');
				} else {
					$this->session->set_flashdata('error', 'Unable To Insert.');
					redirect($this->redirect . 'menu');
				}
			}
		}
	}

	public function get_parents_menu_html($selected_parent = '')
	{
		$html = '<option value="NULL">Root</option>';
		$parents = $this->db->order_by('rank', 'ASC')->get_where($this->table, array('parent_id' => 0, 'status' => '1', 'show_on_menu' => 'Yes', 'show_type !=' => 'BOTTOM'))->result();
		if ($parents) {
			foreach ($parents as $key => $value) {
				$html  .= '<option value="' . $value->id . '" ' . (((isset($value->id)) && $value->id == $selected_parent) ? "selected" : "") . '>' . $value->PageTitle . '</option>';
				$childs = $this->db->get_where($this->table, array('parent_id' => $value->id, 'status' => '1', 'show_on_menu' => 'Yes', 'show_type !=' => 'BOTTOM'))->result();
				if (!empty($childs)) {
					$space = '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
					// var_dump($this->get_childs($html,$childs,$selected_parent,$space));exit;
					$html .= $this->get_childs_menu($childs, $selected_parent, $space);
				}
			}
		}

		return $html;
	}

	public function get_childs_menu($childs = array(), $selected_parent, $space)
	{
		// var_dump($html);exit;
		$html = '';
		if (!empty($childs)) {
			foreach ($childs as $key => $value) {
				// echo "here";exit;
				$html  .= '<option value="' . $value->id . '" ' . (((isset($value->id)) && $value->id == $selected_parent) ? "selected" : "") . '>' . $space . $value->PageTitle . '</option>';
				$new_childs = $this->db->order_by('rank', 'ASC')->get_where($this->table, array('parent_id' => $value->id, 'status' => '1', 'show_on_menu' => 'Yes', 'show_type !=' => 'BOTTOM'))->result();
				if (!empty($new_childs)) {
					$space = $space . '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
					$html .= $this->get_childs_menu($new_childs, $selected_parent, $space);
				}
			}
		}
		return $html;
	}

	public function save_order()
	{
		try {

			if (!$this->input->is_ajax_request()) {
				exit('No direct script access allowed');
			} else {
				// echo "here";exit;

				$post = $this->input->post();
				// var_dump($post);exit;
				$sort = $post["sort"];

				if ($sort) {
					parse_str($sort, $arr);

					// var_dump($arr);exit;

					$i = 1;

					foreach ($arr['menuItem'] as $key => $parent_id) {
						// dd($key,$id); 
						// var_dump($id);exit();
						$id = $key;
						if ($parent_id == 'null') {
							$parent_id = 0;
						} else {
							$parent_id = $parent_id;
						}

						$data['rank'] = $i;
						$data['parent_id'] = $parent_id;
						// $menu = Menu::find($key);
						// $menu->position = $i;
						// $menu->category_id = $id;
						// $menu->save();
						$this->crud_model->update($this->table, $data, array('id' => $id));
						$i++;
					}
					$response = array(
						'status' => 'success',
						'status_code' => 200,
						'status_message' => 'Successully Saved',
					);
				} else {
					$response = array(
						'status' => 'error',
						'status_code' => 300,
						'status_message' => 'Server Error',
					);
				}
			}
		} catch (Exception $e) {
			$response = array(
				'status' => 'error',
				'status_message' => $e->getMessage()
			);
		}
		header('Content-Type: application/json');
		echo json_encode($response);
	}

	public function change_show_on_menu_status()
	{
		try {

			if (!$this->input->is_ajax_request()) {
				exit('No direct script access allowed');
			} else {
				// echo "here";exit;

				$post = $this->input->post();
				// var_dump($post);exit;
				$id = $post["id"];

				if ($id) {

					$detail = $this->db->get_where($this->table, array('id' => $id))->row();

					$data['show_on_menu'] = 'No';


					$result = $this->crud_model->update($this->table, $data, array('id' => $id));
					if ($result) {
						$response = array(
							'status' => 'success',
							'status_code' => 200,
							'status_message' => 'Successfully Removed',
						);
					} else {
						$response = array(
							'status' => 'error',
							'status_code' => 500,
							'status_message' => 'Unable To Remove',
						);
					}
				} else {
					$response = array(
						'status' => 'error',
						'status_code' => 300,
						'status_message' => 'Server Error',
					);
				}
			}
		} catch (Exception $e) {
			$response = array(
				'status' => 'error',
				'status_message' => $e->getMessage()
			);
		}
		header('Content-Type: application/json');
		echo json_encode($response);
	}

	public function get_menu_detail_for_form()
	{
		try {

			if (!$this->input->is_ajax_request()) {
				exit('No direct script access allowed');
			} else {
				// echo "here";exit;

				$post = $this->input->post();
				// var_dump($post);exit;
				$id = $post["id"];

				if ($id) {

					$detail = $this->db->get_where($this->table, array('id' => $id))->row();
					if ($detail) {
						$response = array(
							'status' => 'success',
							'status_code' => 200,
							'status_message' => 'Successfully Removed',
							'detail' => $detail,
						);
					} else {
						$response = array(
							'status' => 'error',
							'status_code' => 500,
							'status_message' => 'No Records Found',
						);
					}
				} else {
					$response = array(
						'status' => 'error',
						'status_code' => 300,
						'status_message' => 'Server Error',
					);
				}
			}
		} catch (Exception $e) {
			$response = array(
				'status' => 'error',
				'status_message' => $e->getMessage()
			);
		}
		header('Content-Type: application/json');
		echo json_encode($response);
	}
}