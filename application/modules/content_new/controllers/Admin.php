<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Admin extends Auth_controller
{

	public function __construct()
	{
		parent::__construct();
		// var_dump($this->current_user);exit;
		$this->load->library('form_validation');
		$this->table = 'content';
		$this->redirect = 'content/admin/';
		$this->title = 'Content';
	}

	public function all($page = '')
	{
		// $data['roles'] = $this->db->get_where('user_role',array('status !='=>'2'))->result(); 

		// var_dump($this->uri->segment(3));exit;

		$config['base_url'] = base_url($this->redirect . 'all');
		$config['total_rows'] = $this->crud_model->count_all($this->table, array('status !=' => '2'), 'id');
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

		$this->pagination->initialize($config);

		$page = ($this->uri->segment(5)) ? $this->uri->segment(5) : 0;

		$data['pagination'] = $this->pagination->create_links();
		$data['items'] = $this->crud_model->get_where_pagination($this->table, array('status !=' => '2'), $config["per_page"], $page);
		// var_dump($this->db->last_query());
		// exit;
		$data['title'] = $this->title;
		$data['page'] = 'list';
		$this->load->view('layouts/admin/index', $data);
	}

	public function form($id = '')
	{

		$data['detail'] = $this->db->get_where($this->table, array('id' => $id))->row();
		if ($this->input->post()) {
			$this->form_validation->set_rules('title', 'Title', 'required|trim');
			$this->form_validation->set_rules('type', 'Type', 'required|trim');
			if ($this->input->post('type') == 'others') {
				$this->form_validation->set_rules('external_url', 'External Url', 'required|trim');
			}

			if ($this->form_validation->run()) {
				$data = array(
					'title' => $this->input->post('title'),
					'type' => $this->input->post('type'),
					'description' => $this->input->post('description'),
					'featured_image' => $this->input->post('featured_image'),
					'sub_title' => $this->input->post('sub_title'),
					'status' => $this->input->post('status'),
					'parent_id' => $this->input->post('parent_id'),
					'order_no' => $this->input->post('order_no'),
					'show_on_menu' => $this->input->post('show_on_menu'),
					'show_type' => $this->input->post('show_type'),
				);
				$id = $this->input->post('id');
				if ($this->input->post('type') == 'others') {
					$data['external_url'] = $this->input->post('external_url');
				}
				if ($id == '') {
					$slug = $this->crud_model->createUrlSlug($this->input->post('title'));
					$check_slug = $this->crud_model->get_where_single($this->table, array('slug' => $slug));
					if (empty($check_slug)) {
						$data['slug'] = strtolower($slug);
					} else {
						$data['slug'] = strtolower($slug) . time();
					}
					$data['created_by'] = $this->current_user->id;
					$data['created_on'] = date('Y-m-d');
					$result = $this->crud_model->insert($this->table, $data);
					if ($result == true) {
						$this->session->set_flashdata('success', 'Successfully Inserted.');
						redirect($this->redirect . 'all');
					} else {
						$this->session->set_flashdata('error', 'Unable To Insert.');
						redirect($this->redirect . 'form');
					}
				} else {
					if ($id == $data['parent_id']) {
						$data['parent_id'] = 0;
					}
					$data['updated_on'] = date('Y-m-d');
					$data['updated_by'] = $this->current_user->id;
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
		$data['title'] = 'Add/Edit ' . $this->title;
		$data['page'] = 'form';

		if (isset($data['detail']->parent_id)) {
			$selected_parent = $data['detail']->parent_id;
		} else {
			$selected_parent = '';
		}
		$data['html'] = $this->get_parents_html($selected_parent);
		// var_dump($data['html']);exit;
		$this->load->view('layouts/admin/index', $data);
	}

	public function get_parents_html($selected_parent = '')
	{
		$html = '<option value="NULL">Root</option>';
		$parents = $this->db->order_by('order_no', 'ASC')->get_where($this->table, array('status' => '1', 'parent_id' => 0))->result();
		if ($parents) {
			foreach ($parents as $key => $value) {
				$html  .= '<option value="' . $value->id . '" ' . (((isset($value->id)) && $value->id == $selected_parent) ? "selected" : "") . '>' . $value->title . '</option>';
				$childs = $this->db->get_where($this->table, array('parent_id' => $value->id, 'status' => '1'))->result();
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
				$html  .= '<option value="' . $value->id . '" ' . (((isset($value->id)) && $value->id == $selected_parent) ? "selected" : "") . '>' . $space . $value->title . '</option>';
				$new_childs = $this->db->order_by('order_no', 'ASC')->get_where($this->table, array('parent_id' => $value->id, 'status' => '1'))->result();
				if (!empty($new_childs)) {
					$space = $space . '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
					$html .= $this->get_childs($new_childs, $selected_parent, $space);
				}
			}
		}
		return $html;
	}

	public function soft_delete($id)
	{
		// 		$data = array(
		// 			'status' => '2',
		// 			'updated_by' => $this->current_user->id,
		// 			'updated_on' => date('Y-m-d'),
		// 		);
		// 		$result = $this->crud_model->update($this->table, $data, array('id' => $id));
		// 		if ($result == true) {
		// 			$this->session->set_flashdata('success', 'Successfully Deleted.');
		// 			redirect($this->redirect . 'all');
		// 		} else {
		// 			$this->session->set_flashdata('error', 'Unable To Delete.');
		// 			redirect($this->redirect . 'all');
		// 		}

		$result = $this->crud_model->hard_delete($this->table, array('id' => $id));

		if ($result == 'success') {
			$this->session->set_flashdata('success', 'Successfully Deleted.');
			redirect($this->redirect . '/admin/all');
		} else {
			if ($result['code'] == 1451) {
				$this->session->set_flashdata('error', 'Can not be deleted, this row is used in another table !!!');
				redirect($this->redirect . '/admin/all');
			} else {
				$this->session->set_flashdata('error', $result['message']);
				redirect($this->redirect . '/admin/all');
			}
		}
	}


	// Rajesh Menu Part Strat

	public function menuTree($parent_id = 0, $html = '')
	{
		// $menus = Menu::where('category_id', $parent_id)->where('delete_status', '0')->where('publish_status', '1')->where('show_on_menu', '1')->orderBy('position','asc')->get();

		$menus = $this->db->order_by('order_no', 'ASC')->get_where($this->table, array('parent_id' => $parent_id, 'status' => '1', 'show_on_menu' => 'Yes', 'show_type !=' => 'BOTTOM'))->result();
		// var_dump($this->db->last_query());
		// exit;
		if (count($menus) > 0) {
			$html = '';
			foreach ($menus as $row) {
				// $subMenus = Menu::where('category_id', $row->id)->where('delete_status', '0')->where('publish_status', '1')->where('show_on_menu', '1')->orderBy('position','asc')->get(); 
				$subMenus = $this->db->order_by('order_no', 'ASC')->get_where($this->table, array('parent_id' => $row->id, 'status' => '1', 'show_on_menu' => 'Yes', 'show_type !=' => 'BOTTOM'))->result();
				if (count($subMenus) > 0) {
					$html .= '<li id="menuItem_' . $row->id . '">
                                <div class="menu-handle">
                                    <span>' .
						$row->title
						. '</span>
                                    <div class="menu-options">';
					if ($row->type == 'others') {
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
						$row->title
						. '</span>
                                        <div class="menu-options">';
					if ($row->type == 'others') {
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
			$this->form_validation->set_rules('title', 'Page Title', 'required|trim');
			$this->form_validation->set_rules('external_url', 'External Url', 'required|trim');

			if ($this->form_validation->run()) {
				$data = array(
					'title' => $this->input->post('title'),
					'parent_id' => $this->input->post('parent_id'),
					'type' => 'others',
					'status' => '1',
					'external_url' => $this->input->post('external_url'),
					'order_no' => $this->input->post('order_no'),
					'show_on_menu' => 'Yes',
					'show_type' => 'TOP',
				);

				$slug = $this->crud_model->createUrlSlug($this->input->post('title'));
				$check_slug = $this->crud_model->get_where_single($this->table, array('slug' => $slug));
				if (empty($check_slug)) {
					$data['slug'] = strtolower($slug);
				} else {
					$data['slug'] = strtolower($slug) . time();
				}
				$data['created_by'] = $this->current_user->id;
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
		$data['title'] = 'Drag And Drop And Reorder TOP Menu';
		$data['html'] = $this->get_parents_menu_html($selected_parent = '');
		$data['page'] = 'menu';
		$this->load->view('layouts/admin/index', $data);
	}

	public function menu_edit()
	{
		if ($this->input->post()) {
			$this->form_validation->set_rules('title', 'Page Title', 'required|trim');

			if ($this->form_validation->run()) {
				$data = array(
					'title' => $this->input->post('title'),
					'external_url' => $this->input->post('external_url'),
				);

				$id = $this->input->post('id');
				$slug = $this->crud_model->createUrlSlug($this->input->post('title'));
				$check_slug = $this->crud_model->get_where_single($this->table, array('slug' => $slug));
				if (empty($check_slug)) {
					$data['slug'] = strtolower($slug);
				} else {
					$data['slug'] = strtolower($slug) . time();
				}
				$data['updated_by'] = $this->current_user->id;
				$data['updated_on'] = date('Y-m-d');
				$result = $this->crud_model->update($this->table, $data, array('id' => $id));
				if ($result == true) {
					$this->session->set_flashdata('success', 'Successfully Updated.');
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
		$parents = $this->db->order_by('order_no', 'ASC')->get_where($this->table, array('parent_id' => 0, 'status' => '1', 'show_on_menu' => 'Yes', 'show_type !=' => 'BOTTOM'))->result();
		if ($parents) {
			foreach ($parents as $key => $value) {
				$html  .= '<option value="' . $value->id . '" ' . (((isset($value->id)) && $value->id == $selected_parent) ? "selected" : "") . '>' . $value->title . '</option>';
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
				$html  .= '<option value="' . $value->id . '" ' . (((isset($value->id)) && $value->id == $selected_parent) ? "selected" : "") . '>' . $space . $value->title . '</option>';
				$new_childs = $this->db->order_by('order_no', 'ASC')->get_where($this->table, array('parent_id' => $value->id, 'status' => '1', 'show_on_menu' => 'Yes', 'show_type !=' => 'BOTTOM'))->result();
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

						$data['order_no'] = $i;
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
