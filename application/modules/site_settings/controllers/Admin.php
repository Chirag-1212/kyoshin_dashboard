<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Admin extends Auth_controller
{
	protected $userId;
	protected $site_settings;
	public function __construct()
	{
		parent::__construct();
		// var_dump($this->current_user);exit;
		$this->redirect='site_settings/admin';
		$this->load->library('form_validation');
		$this->site_settings = $this->crud_model->get_where_single('site_settings', array('status' => '1'));
		$this->userId = $this->data['userId'];
	}

	public function index()
	{

		$data['site_settings'] = $this->db->get_where('site_settings', array('status' => '1'))->row();
		$upload_path = 'uploads/site_settings/';
		if ($this->input->post()) {
		  //  echo "<pre>";
		  //  var_dump($this->input->post());exit;
			$this->form_validation->set_rules('meta_key_words', 'Meta Keywords', 'required|trim');
			$this->form_validation->set_rules('meta_description', 'Meta Description', 'required|trim');
			$this->form_validation->set_rules('meta_title', 'Meta Title', 'required|trim');
			if ($this->form_validation->run()) {
				if (strlen($_FILES['logo']['name']) > 0) {

					$config['upload_path'] = $upload_path;

					$config['allowed_types'] = 'jpeg|jpg|gif|png|pdf';

					$config['max_size'] = '300000';
					$this->load->library('upload', $config);

					if (!$this->upload->do_upload('logo')) {

						$this->session->set_flashdata('error', $this->upload->display_errors());
						if ($id == '') {
							redirect($this->redirect . '/index');
						} else {
							redirect($this->redirect . '/index/' . $id);
						}
					} else {

						$file = $this->upload->data();

						$logo = $upload_path.$file['file_name'];
					}
				} else {
					if (isset($data['site_settings']->logo) && $data['site_settings']->logo != '') {
						$logo = $data['site_settings']->logo;
					} else {
						$logo = "";
					}
				}
				if (strlen($_FILES['fav']['name']) > 0) {

					$config['upload_path'] = $upload_path;

					$config['allowed_types'] = 'jpeg|jpg|gif|png|pdf';

					$config['max_size'] = '300000';
					$this->load->library('upload', $config);

					if (!$this->upload->do_upload('fav')) {

						$this->session->set_flashdata('error', $this->upload->display_errors());
						if ($id == '') {
							redirect($this->redirect . '/index');
						} else {
							redirect($this->redirect . '/index/' . $id);
						}
					} else {

						$file = $this->upload->data();

						$fav = $upload_path.$file['file_name'];
					}
				} else {
					if (isset($data['site_settings']->fav) && $data['site_settings']->fav != '') {
						$fav = $data['site_settings']->fav;
					} else {
						$fav = "";
					}
				}
				if (strlen($_FILES['default_img']['name']) > 0) {

					$config['upload_path'] = $upload_path;

					$config['allowed_types'] = 'jpeg|jpg|gif|png|pdf|svg';

					$config['max_size'] = '300000';
					$this->load->library('upload', $config);

					if (!$this->upload->do_upload('default_img')) {

						$this->session->set_flashdata('error', $this->upload->display_errors());
						if ($id == '') {
							redirect($this->redirect . '/index');
						} else {
							redirect($this->redirect . '/index/' . $id);
						}
					} else {

						$file = $this->upload->data();

						$default_img = $upload_path.$file['file_name'];
					}
				} else {
					if (isset($data['site_settings']->default_img) && $data['site_settings']->default_img != '') {
						$default_img = $data['site_settings']->default_img;
					} else {
						$default_img = "";
					}
				}
				
				$data = array(
					'site_name' => $this->input->post('site_name'),
					'short_name' => $this->input->post('short_name'),
					'site_slogan' => $this->input->post('site_slogan'),
					'web_url' => $this->input->post('web_url'),
					'address' => $this->input->post('address'),
					'mobile' => $this->input->post('mobile'),
					'telephone' => $this->input->post('telephone'),
					
					'telephone_np' => $this->input->post('telephone_np'),
					'address_np' => $this->input->post('address_np'),
					'mobile_np' => $this->input->post('mobile_np'),
					'map_location' => $this->input->post('map_location'),
					'contact_detail' => $this->input->post('contact_detail'),
					'email' => $this->input->post('email'),
					'facebook' => $this->input->post('facebook'),
					'whatsapp' => $this->input->post('whatsapp'),
					'skype' => $this->input->post('skype'),
					'twitter' => $this->input->post('twitter'),
					'instagram' => $this->input->post('instagram'),
					'youtube' => $this->input->post('youtube'),
					'googleplus' => $this->input->post('googleplus'),
					'linked_in' => $this->input->post('linked_in'),
					'viber' => $this->input->post('viber'),
					'app_store' => $this->input->post('app_store'),
					'google_play' => $this->input->post('google_play'),
					
					'opening_time' => $this->input->post('opening_time'),
					'closing_time' => $this->input->post('closing_time'),
					'opening_time_friday' => $this->input->post('opening_time_friday'),
					'closing_time_friday' => $this->input->post('closing_time_friday'),
					'holiday_opening' => $this->input->post('holiday_opening'),
					'holiday_closing' => $this->input->post('holiday_closing'),
					
					'help_team' => $this->input->post('help_team'),
					'help_email' => $this->input->post('help_email'),
					'help_address' => $this->input->post('help_address'),
					'help_mobile' => $this->input->post('help_mobile'),
					'help_telephone' => $this->input->post('help_telephone'),
					'help_ext' => $this->input->post('help_ext'),
					'help_team_np' => $this->input->post('help_team_np'),
					'help_address_np' => $this->input->post('help_address_np'),
					'help_mobile_np' => $this->input->post('help_mobile_np'),
					'help_telephone_np' => $this->input->post('help_telephone_np'),
					'help_ext_np' => $this->input->post('help_ext_np'),
					
					'logo' => $logo,
					'fav' => $fav,
					'default_img' => $default_img,
					'meta_title' => $this->input->post('meta_title'),
					'meta_description' => $this->input->post('meta_description'),
					'meta_key_words' => $this->input->post('meta_key_words'),
					'updated_on' => date('Y-m-d'),
					'updated_by' => $this->userId,
				);

				$result = $this->db->update('site_settings', $data);
				if ($result) {
					$this->session->set_flashdata('success', 'Successfully Updated.');
					redirect('site_settings/admin');
				} else {
					$this->session->set_flashdata('error', 'Unable To Update.');
					redirect('site_settings/admin');
				}
			}
		}
		$data['site_settings'] = $this->site_settings;
		$data['title'] = 'Site Settings';
		$data['page'] = 'site_setting';
		$data['docpath'] = $upload_path;
		$data['setting'] = 'setting';
		$data = array_merge($this->data, $data);
		
		$this->load->view('layouts/admin/index', $data);
	}
}