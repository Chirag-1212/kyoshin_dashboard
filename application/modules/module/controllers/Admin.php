<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Admin extends Auth_controller
{
	protected $userId;
	
	protected $roleId;
	protected $table;
	protected $title;
	protected $redirect;
	
	public function __construct()
	{
		parent::__construct();
		// var_dump($this->current_user);exit;a
		// $this->load->library('form_validation'); 
		
		$this->table = 'module';
		$this->title = 'Modules';
		$this->redirect = 'module';
		$this->roleId = $this->data['role_id'];
		$this->userId = $this->data['userId'];
	}

	public function all()
{
    $like = [];
    $param = [
        'status !=' => '2'
    ];

    $search = '';

    if ($this->input->method() == 'get') {
        $search = $this->input->get('table_search');
        if (!empty($search)) {
            $like['display_name'] = $search;
        }
    }

    $total = $this->crud_model->total($this->table, $param, $like);

    $this->load->library('pagination');

    $config['base_url'] = base_url($this->redirect . '/admin/all');
    $config['total_rows'] = $total;
    $config['per_page'] = 10;
    $config['uri_segment'] = 4;

    // Bootstrap 4 Pagination Styling
    $config['full_tag_open'] = '<ul class="pagination pagination-sm m-0 float-right">';
    $config['full_tag_close'] = '</ul>';

    $config['first_link'] = 'First';
    $config['first_tag_open'] = '<li class="page-item">';
    $config['first_tag_close'] = '</li>';

    $config['last_link'] = 'Last';
    $config['last_tag_open'] = '<li class="page-item">';
    $config['last_tag_close'] = '</li>';

    $config['next_link'] = 'Next';
    $config['next_tag_open'] = '<li class="page-item">';
    $config['next_tag_close'] = '</li>';

    $config['prev_link'] = 'Prev';
    $config['prev_tag_open'] = '<li class="page-item">';
    $config['prev_tag_close'] = '</li>';

    $config['cur_tag_open'] = '<li class="page-item active"><a class="page-link">';
    $config['cur_tag_close'] = '</a></li>';

    $config['num_tag_open'] = '<li class="page-item">';
    $config['num_tag_close'] = '</li>';
    $config['attributes'] = ['class' => 'page-link'];

    if (!empty($search)) {
        $config['suffix'] = '?table_search=' . $search;
        $config['first_url'] = $config['base_url'] . '?table_search=' . $search;
    }

    $this->pagination->initialize($config);

    $page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;

    $items = $this->crud_model->getData(
        $this->table,
        $param,
        $like,
        $config['per_page'],
        $page
    );

    $data = array_merge($this->data, [
        'title' => $this->title . ' List',
        'page' => 'list',
        'items' => $items,
        'redirect' => $this->redirect,
        'pagination' => $this->pagination->create_links(),
        'modules' => 'modules-all',
        'offset' => $page
    ]);

    $this->load->view('layouts/admin/index', $data);
}


	public function form($id = '')
{
    $data['detail'] = $this->crud_model->get_where_single(
        $this->table,
        array('id' => $id)
    );

    // get active menus for dropdown
    $data['menus'] = $this->crud_model->get_where(
        'user_menu',
        array('status' => '1')
    );

    if ($this->input->post()) {

        $this->form_validation->set_rules('module_name', 'Module Name', 'required|trim');
        $this->form_validation->set_rules('display_name', 'Display Name', 'required|trim');
        $this->form_validation->set_rules('menu_id', 'Menu', 'required');

        if ($this->form_validation->run()) {

            $data_insert = array(
                'status'       => $this->input->post('status'),
                'display_name' => $this->input->post('display_name'),
                'menu_id'      => $this->input->post('menu_id'),
                'icon'         => $this->input->post('icon')
            );

            $id = $this->input->post('id');

            /* ================= INSERT ================= */
            if ($id == '') {

                $check = $this->crud_model->get_where_single(
                    'module',
                    array('module_name' => $this->input->post('module_name'))
                );

                if ($check) {
                    $this->session->set_flashdata('error', 'Duplicate Entry');
                    redirect($this->redirect . '/admin/form');
                }

                $data_insert['module_name'] = $this->input->post('module_name');

                $result = $this->crud_model->insert($this->table, $data_insert);
                $insert_id = $this->db->insert_id();

                if ($result) {

                    $function_name = $this->input->post('function_name');
                    $display_name_function = $this->input->post('display_name_function');

                    if (!empty($function_name)) {
                        $batch_data = array();
                        for ($i = 0; $i < count($function_name); $i++) {
                            $batch_data[] = array(
                                'module_id'    => $insert_id,
                                'function_name'=> $function_name[$i],
                                'display_name'=> $display_name_function[$i]
                            );
                        }
                        $this->db->insert_batch('module_function', $batch_data);
                    }

                    $this->session->set_flashdata('success', 'Successfully Inserted.');
                    redirect($this->redirect . '/admin/all');

                } else {
                    $this->session->set_flashdata('error', 'Unable To Insert.');
                    redirect($this->redirect . '/admin/form');
                }

            }
            /* ================= UPDATE ================= */
            else {

                $result = $this->crud_model->update(
                    $this->table,
                    $data_insert,
                    array('id' => $id)
                );

                if ($result) {

                    $this->db->delete(
                        'module_function',
                        array('module_id' => $id)
                    );

                    $function_name = $this->input->post('function_name');
                    $display_name_function = $this->input->post('display_name_function');

                    if (!empty($function_name)) {
                        $batch_data = array();
                        for ($i = 0; $i < count($function_name); $i++) {
                            $batch_data[] = array(
                                'module_id'    => $id,
                                'function_name'=> $function_name[$i],
                                'display_name'=> $display_name_function[$i]
                            );
                        }
                        $this->db->insert_batch('module_function', $batch_data);
                    }

                    $this->session->set_flashdata('success', 'Successfully Updated.');
                    redirect($this->redirect . '/admin/all');

                } else {
                    $this->session->set_flashdata('error', 'Unable To Update.');
                    redirect($this->redirect . '/admin/form/' . $id);
                }
            }
        }
    }

    $data['title']   = 'Add/Edit ' . $this->title;
    $data['page']    = 'form';
    $data['modules'] = 'modules-form';

    $data = array_merge($this->data, $data);
    $this->load->view('layouts/admin/index', $data);
}


	public function soft_delete($id)
	{
		if ($id == '' || $id == 0) {
			$this->session->set_flashdata('error', 'Select Atleast One');
			redirect($this->redirect . '/admin');
		}
		$data = array(
			'status' => '2',
		);
		$result = $this->crud_model->update($this->table, $data, array('id' => $id));
		if ($result == true) {
			$this->session->set_flashdata('success', 'Successfully Deleted.');
			redirect($this->redirect . '/admin');
		} else {
			$this->session->set_flashdata('error', 'Unable To Delete.');
			redirect($this->redirect . '/admin');
		}
	}

	public function role_function($id = '')
	{
		if ($this->roleId == 1) {
			$module = $this->crud_model->get_where('module', array('status' => '1'));
		} else {
			$module = $this->crud_model->get_where('module', array('status' => '1', 'id !=' => 33));
		}
		if ($this->roleId == 1) {
			$role = $this->crud_model->get_where_order_by('user_role', array('status' => '1'), 'id', 'ASC');
		} else {
			$role = $this->crud_model->get_where_order_by('user_role', array('status' => '1', 'id !=' => 1), 'id', 'ASC');
		}
		$data['role'] = $role;
		$data['module'] = $module;
		// echo "<pre>";
		// var_dump($role[0]->id);
		// exit;
		$module_function_role = $this->crud_model->get_where('module_function_role', array('role_id' => $role[0]->id));
		$data['module_function_role'] = $module_function_role;


		if ($this->input->post()) {
			// echo "<pre>";
			// var_dump($this->input->post());
			// exit;
			$this->form_validation->set_rules('role_id', 'Role', 'required|trim');
			if ($this->form_validation->run()) {
				$role = $this->input->post('role_id');
				$module_function_id = $this->input->post('module_function_id');

				if (count($module_function_id) > 0) {
					$batch_data = array();
					for ($i = 0; $i < count($module_function_id); $i++) {
						$insert_child['role_id'] = $role;
						$insert_child['module_function_id'] = $module_function_id[$i];

						$batch_data[] = $insert_child;
					}


					if ($this->roleId == 1) {
						$this->db->delete('module_function_role', array('role_id' => $role));
					} else {
						$this->db->delete('module_function_role', array('role_id' => $role, 'module_function_id  !=' => 278));
					}
					$this->db->insert_batch('module_function_role', $batch_data);
				}

				$this->session->set_flashdata('success', 'Successfully Inserted.');
				redirect($this->redirect . '/admin/role_function');
			}
		}
// var_dump($module_function_role); die;
		$data['title'] = 'Add/Edit ' . 'Function Role';
		$data['page'] = 'role_function';
		$data['modules'] = 'modules-role_function';
		$data = array_merge($this->data, $data); 
		$this->load->view('layouts/admin/index', $data);
	}
     
	
	public function get_role_permissions()
{
    $role_id = (int) $this->input->post('role_id');

    $data['module'] = $this->crud_model->get_all('module');
    $data['module_function_role'] = $this->crud_model->get_where(
        'module_function_role',
        ['role_id' => $role_id]
    );

    $this->load->view('module/partials/module_permissions', $data);
}

        
	public function getForm()
	{
		try {

			if (!$this->input->is_ajax_request()) {
				exit('No direct script access allowed');
			} else {
				$role_id = $this->input->post('role_id');

				if ($this->roleId == 1) {
					$module = $this->crud_model->get_where('module', array('status' => '1'));
				} else {
					$module = $this->crud_model->get_where('module', array('status' => '1', 'id !=' => 33));
				}

				$module_function_role = $this->crud_model->get_where('module_function_role', array('role_id' => $role_id));

				if ($role_id) {
					$html = '';
					foreach ($module as $key => $val) { 	
						$html   .= '<div class="row">';
						$html   .= '<div class="col-md-12">
										<label>' . $val->display_name . '</label>
									</div>';
						$module_function =  $this->crud_model->get_where('module_function', array('module_id' => $val->id));
						foreach ($module_function as $key_f => $val_f) {
						    
							$html .=  '<div class="col-md-3">
                                        <input type="checkbox" name="module_function_id[]" value="' . $val_f->id . '" style="margin-right: 10px;"';
							foreach ($module_function_role as $key_fr => $val_fr) {
								if ($val_fr->module_function_id == $val_f->id) {
									$html	.=						'checked';
								}
							}
							$html .=		'>' . $val_f->display_name . '
                                    </div>';
						}
						$html.= '</div>';
					}
				
					if ($html) {

						$response = array(
							'status' => 'success',
							'status_code' => 200,
							'status_message' => 'Successfully retrived',
							'data' => $html,
						);
					} else {
						$response = array(
							'status' => 'error',
							'status_code' => 300,
							'status_message' => 'Unable To Get Form',
						);
					}
				} else {
					$response = array(
						'status' => 'error',
						'status_code' => 300,
						'status_message' => 'Please Select Role First',
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