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
		// $this->load->library('form_validation'); 
		
		$this->table = 'career_apply';
		$this->title = 'Career Apply';
		$this->redirect = 'CareerApply';
		$this->userId = $this->data['userId'];
	}

	public function all($page = '')
	{
	    $param = ['status !=' => '2'];
	    $like = [];
	    if($this->input->get()){
	        $branch_id = $this->input->get('branch_id');
	        $full_name = $this->input->get('full_name');
	       // $highest_education = $this->input->get('highest_education');
	        $career_id = $this->input->get('career_id');
	        if($full_name){
	            $explode = explode(' ', $full_name);
	            if(count($explode) <= 3){
	                $like['first_name'] = $explode[0];
	                if($explode[1]){
    	                $like['middle_name'] = $explode[1];
	                }
    	            if($explode[2]){
    	                $like['last_name'] = $explode[2];
    	            }
    	            
	            }
	            
	        }
	        if($branch_id){
	            $param['branch_id'] = $branch_id;
	        }
	        if($career_id){
    	            $param['career_id'] = $career_id;
    	        }
	       // if($highest_education){
	       //     $like['highest_education'] = $highest_education;
	       // }
	        
	    }
	    
	    
		$config['base_url'] = base_url($this->redirect . '/admin/all');
		$config['total_rows'] = $this->crud_model->total($this->table, $param, $like);
		$config['uri_segment'] = 4;
		$config['per_page'] = 10;

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

		$page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
		
        $select = 'id,first_name, last_name, middle_name, career_id, email, phone_number, branch_id, DocPath, certificate,cv, created';
		$items = $this->crud_model->getData($this->table, $param,  $like, $config['per_page'], $page, $select, 'id DESC');
		
        $branches = $this->crud_model->getDataArray('branches', ['status' => '1'], 'id, PageTitle as title', 'id DESC');
        $careers = $this->crud_model->getDataArray('career', ['status' => '1', 'Type' => 'career'], 'id, Title as title', 'id DESC');
		$data = array_merge($this->data, [
			'title' => $this->title . ' List',
			'page' => 'list',
			'items' => $items,
			'redirect' => $this->redirect,
			'pagination' =>  $this->pagination->create_links(),
            'branches' => $branches,
            'careers' => $careers,
			'form_link' => $this->redirect . '/admin/form/',
			'form_check_value' => 'form',
			'delete_link' => $this->redirect . '/admin/soft_delete/',
			'delete_check_value' => 'soft_delete',
			'CareerApply' => 'CareerApply-all',
			'offset' => $page]);
			$data['module'] = 'CareerApply';
		$this->load->view('layouts/admin/index', $data);
	} 
	
	public function edit($id){
        $data['detail'] =$this->crud_model->get_where_single($this->table, array('id' => $id));
        $data['education']=$this->crud_model->getDataArray('applicant_education', ['career_apply_id'=>$id], [], 'id DESC');
        $data['experience']=  $this->crud_model->getDataArray('applicant_experience', ['career_apply_id'=>$id], [], 'id DESC'); 
        $data['references']=  $this->crud_model->getDataArray('applicant_references', ['career_apply_id'=>$id], [], 'id DESC'); 
        $data['training']=  $this->crud_model->getDataArray('applicant_training', ['career_apply_id'=>$id], [], 'id DESC');
        $data['title'] = 'View ' . $this->title;
		$data['page'] = 'view';
		$data['online'] = 'onlne-all';
		$data['module'] = 'CareerApply';
		$data = array_merge($this->data, $data);
		$this->load->view('layouts/admin/index', $data);
    }
	
	public function getExport()
    {
        try {
            $this->load->library('ExcelPHP');
            if (!$this->input->is_ajax_request()) {
                $response = array(
                    'status' => 'error',
                    'status_code' => 300,
                    'status_message' => 'No direct script access allowed',
                );
                header('Content-Type: application/json');
                echo json_encode($response);
                exit;
            }
    
            // Parameters
            // $param = ['status !=' => '2'];
            $param = ['status' => '1'];
            $like = [];
            $branch_id = $this->input->post('branchId');
            $full_name = $this->input->post('fullName');
            $career_id = $this->input->post('careerId');
    
            // Building search conditions
            if ($full_name) {
                $explode = explode(' ', $full_name);
                if (count($explode) <= 3) {
                    $like['first_name'] = $explode[0];
                    if (isset($explode[1])) {
                        $like['middle_name'] = $explode[1];
                    }
                    if (isset($explode[2])) {
                        $like['last_name'] = $explode[2];
                    }
                }
            }
    
            if ($career_id) {
                $param['career_id'] = $career_id;
            }
            if ($branch_id) {
                $param['branch_id'] = $branch_id;
            }
    
            // Fields to select
            $select = 'id,application_id, career_id, branch_id, first_name, middle_name, last_name, bod, age, gender, marital_status, phone_number, email, nationality, religion, driving_license, permanent_provience, permanent_district, permanent_municipality, permanent_ward, temporary_provience, temporary_district, temporary_municipality, temporary_ward, created';
    
            // Fetch data from the model
            $items = $this->crud_model->getDataArrays($this->table, $param, $like, 0, 0, $select, 'first_name ASC');
    
            // Map fetched data to structured output for Excel
            $careerApply = array_map(function($item) {
                $item['Applicant ID'] = $item['application_id'];
                unset($item['application_id']);
                
                $item['Branch_Name'] = $this->crud_model->getField('branches', ['id' => $item['branch_id']], 'PageTitle');
                unset($item['branch_id']);
                $item['Career_Title'] = $this->crud_model->getField('career', ['id' => $item['career_id']], 'Title');
                 unset($item['career_id']);
                $item['Full_Name'] = implode(' ', [$item['first_name'], $item['middle_name'], $item['last_name']]);
                unset($item['first_name'], $item['middle_name'], $item['last_name']);
                $item['DOB'] = $item['bod'];
                unset($item['bod']);
                $item['Age'] = $item['age'];
                unset($item['age']);
                $item['Gender'] = $item['gender'];
                unset($item['gender']);
                $item['Marital Status'] = $item['marital_status'];
                unset($item['marital_status']);
                $item['Phone_Number'] = $item['phone_number'];
                unset($item['phone_number']);
                $item['Email'] = $item['email'];
                unset($item['email']);
                $item['Nationality'] = $item['nationality'];
                unset($item['nationality']);
                $item['Religion'] = $item['religion'];
                unset($item['religion']);
                $item['Driving License'] = $item['driving_license'];
                unset($item['driving_license']);
                $item['Permanent Provience Name'] = $this->crud_model->getField('provinces', ['id' => $item['permanent_provience']], 'title');
                $item['Permanent District Name'] = $this->crud_model->getField('districts', ['id' => $item['permanent_district']], 'title');
                $item['Permanent Municipality Name'] = $this->crud_model->getField('municipality', ['id' => $item['permanent_municipality']], 'title');
                $item['Permanent Address'] = $item['permanent_ward'];
               
                $item['Temporary Provience Name'] = ($item['temporary_provience'] == 0 || $item['temporary_provience'] == null) ? $this->crud_model->getField('provinces', ['id' => $item['permanent_provience']], 'title') : $this->crud_model->getField('provinces', ['id' => $item['temporary_provience']], 'title');
                unset($item['temporary_provience']);
                $item['Temporary District Name'] = ($item['temporary_district'] == 0 || $item['temporary_district'] == null) ? $this->crud_model->getField('districts', ['id' => $item['permanent_district']], 'title'): $this->crud_model->getField('districts', ['id' => $item['temporary_district']], 'title');
                unset($item['temporary_district']);
                $item['Temporary Municipality Name'] = ($item['temporary_municipality'] == 0  || $item['temporary_municipality'] == null) ?$this->crud_model->getField('municipality', ['id' => $item['permanent_municipality']], 'title') : $this->crud_model->getField('municipality', ['id' => $item['temporary_municipality']], 'title');
                unset($item['temporary_municipality']);
                $item['Temporary Address'] = ($item['temporary_ward'] == ''  || $item['temporary_ward'] == null) ? $item['permanent_ward']: $item['temporary_ward'];
                unset($item['temporary_ward']);
                
                unset($item['permanent_provience']);
                unset($item['permanent_district']);
                unset($item['permanent_municipality']);
                unset($item['permanent_ward']);
                
                  // Fetch education details for the applicant
                $educations = $this->crud_model->getDataArray('applicant_education', ['career_apply_id' => $item['id']], [], 'id ASC');
                
                // Prepare separate arrays for different qualifications
                $educationDetails = [
                    'SEE/SLC' => [],
                    '+2/HSEB' => [],
                    'Bachelor' => [],
                    'Other' => []
                ];
                
                // Map indices to qualifications
                $qualificationMap = [
                    0 => 'SEE/SLC',
                    1 => '+2/HSEB',
                    2 => 'Bachelor'
                ];
                
                // Iterate over the fetched education data
                foreach ($educations as $index => $education) {
                    // Format the education details
                    $details = $education['organization'] . ' (Board: ' . $education['board'] . ', Degree: ' . $education['degree'] . ', Faculty: ' . $education['faculty'] . ', Year: ' . $education['passed_year'] . ', GPA: ' . $education['gpa'] . ')';
                
                    // Determine the qualification type based on the index
                    $qualificationType = isset($qualificationMap[$index]) ? $qualificationMap[$index] : 'Other';
                    
                    // Add details to the respective qualification array
                    $educationDetails[$qualificationType][] = $details;
                }
                
                // Combine all education details into a single string for each qualification
                $item['SEE/SLC'] = implode('; ', $educationDetails['SEE/SLC']);
                $item['+2/HSEB'] = implode('; ', $educationDetails['+2/HSEB']);
                $item['Bachelor'] = implode('; ', $educationDetails['Bachelor']);
                $item['Others'] = implode('; ', $educationDetails['Other']);
                
                // Fetch experience details for the applicant
                $experiences = $this->crud_model->getDataArray('applicant_experience', ['career_apply_id' => $item['id']], [], 'id ASC');
                
                // Prepare separate arrays for different types of experience
                $experienceDetails = [
                    'Work-Experience1' => [],
                    'Work-Experience2' => [],
                    'Work-Experience3' => [],
                    'Other-Work-Experience' => []
                ];
                
                // Map indices or categories based on your logic
                $experienceMap = [
                    0 => 'Work-Experience1',
                    1 => 'Work-Experience2',
                    2 => 'Work-Experience3'
                ];
                
                // Iterate over the fetched experience data
                foreach ($experiences as $index => $experience) {
                    // Format the experience details
                    $details = $experience['organization'] . ' (Position: ' . $experience['position'] . ', Department: ' . $experience['department'] . ', From: ' . $experience['date_from'] . ', To: ' . $experience['date_to'] . ')';
                
                    // Determine the experience type based on the index
                    $experienceType = isset($experienceMap[$index]) ? $experienceMap[$index] : 'Other-Work-Experience';
                    
                    // Add details to the respective experience array
                    $experienceDetails[$experienceType][] = $details;
                }
                
                // Combine all experience details into a single string for each type
                $item['Work-Experience1'] = implode('; ', $experienceDetails['Work-Experience1']);
                $item['Work-Experience2'] = implode('; ', $experienceDetails['Work-Experience2']);
                $item['Work-Experience3'] = implode('; ', $experienceDetails['Work-Experience3']);
                $item['Other-Work-Experience'] = implode('; ', $experienceDetails['Other-Work-Experience']);
                
                
                // Fetch training details for the applicant
                $trainings = $this->crud_model->getDataArray('applicant_training', ['career_apply_id' => $item['id']], [], 'id ASC');
                
                // Prepare separate arrays for different types of training
                $trainingDetails = [
                    'Training1' => [],
                    'Training2' => [],
                    'Training3' => [],
                    'Other-Training' => []
                ];
                
                // Map indices or categories based on your logic
                $trainingMap = [
                    0 => 'Training1',
                    1 => 'Training2',
                    2 => 'Training3'
                ];
                
                // Iterate over the fetched training data
                foreach ($trainings as $index => $training) {
                    // Format the training details
                    $details = $training['organization'] . ' (Topic: ' . $training['title'] . ', Training Date: ' . $training['traning_date'] . ')';
                
                    // Determine the training type based on the index
                    $trainingType = isset($trainingMap[$index]) ? $trainingMap[$index] : 'Other-Training';
                    
                    // Add details to the respective training array
                    $trainingDetails[$trainingType][] = $details;
                }
                
                // Combine all training details into a single string for each type
                $item['Training1'] = implode('; ', $trainingDetails['Training1']);
                $item['Training2'] = implode('; ', $trainingDetails['Training2']);
                $item['Training3'] = implode('; ', $trainingDetails['Training3']);
                $item['Other-Training'] = implode('; ', $trainingDetails['Other-Training']);
                
                $references=  $this->crud_model->getDataArray('applicant_references', ['career_apply_id'=>$item['id']], [], 'id ASC'); 
                 
                // Prepare separate arrays for different types of reference
                $referenceDetails = [
                    'Reference1' => [],
                    'Reference2' => [],
                    'Reference3' => [],
                    'Other-Reference' => []
                ];
                
                // Map indices or categories based on your logic
                $referenceMap = [
                    0 => 'Reference1',
                    1 => 'Reference2',
                    2 => 'Reference3'
                ];
                
                // Iterate over the fetched reference data
                foreach ($references as $index => $reference) {
                    // Format the reference details
                    $details = $reference['organization'] . ' (Name: ' . $reference['name'] . ', Position: ' . $reference['position'] . ', Address: ' . $reference['address'] . ', Mobile Number: ' . $reference['contact'] . ')';
                
                    // Determine the reference type based on the index
                    $referenceType = isset($referenceMap[$index]) ? $referenceMap[$index] : 'Other-Reference';
                    
                    // Add details to the respective reference array
                    $referenceDetails[$referenceType][] = $details;
                }
                
                // Combine all reference details into a single string for each type
                $item['Reference1'] = implode('; ', $referenceDetails['Reference1']);
                $item['Reference2'] = implode('; ', $referenceDetails['Reference2']);
                $item['Reference3'] = implode('; ', $referenceDetails['Reference3']);
                $item['Other-Reference'] = implode('; ', $referenceDetails['Other-Reference']);
                
                unset($item['id']);
                
                
                $item['Apply_On'] = (new DateTime($item['created']))->format('Y-m-d');
                unset($item['created']);
                return $item;
            }, $items);
    
            // Generate Excel file if data exists
            if ($careerApply) {
                $objPHPExcel = new PHPExcel();
                $objPHPExcel->getProperties()->setCreator('Applicant User Information Export')
                    ->setLastModifiedBy('Applicant User Information Export')
                    ->setTitle("Applicant User Information Export")
                    ->setSubject("Applicant User Information Export")
                    ->setDescription("Applicant User Information Export")
                    ->setKeywords("Applicant User Information Export");
                $objPHPExcel->getDefaultStyle()
                    ->getNumberFormat()
                    ->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);
    
                $titles = array_keys($careerApply[0]);
                $tiltleCell = range('A', 'Z');
                $tiltleCell = array_merge($tiltleCell, array_map(function($letter) { return 'A' . $letter; }, range('A', 'Z')));
    
                // Set header
                $one = 1;
                foreach ($titles as $t => $title) {
                    $stringExplode = explode('_', $title);
                    $objPHPExcel->getActiveSheet()->SetCellValue($tiltleCell[$t] . $one, ucwords(implode(' ', $stringExplode)));
                }
    
                // Populate data
                $n = 2;
                foreach ($careerApply as $row) {
                    $i = 0;
                    foreach ($row as $k => $ite) {
                        $cellNumber = $tiltleCell[$i] . $n;
                        $objPHPExcel->getActiveSheet()->setCellValue($cellNumber, (string)$ite);
                        if (in_array($k, ['Phone_Number'])) {
                            $objPHPExcel->getActiveSheet()->getStyle($cellNumber)->getNumberFormat()->setFormatCode('#,##0.00');
                        }
                        if (in_array($k, ['Apply_On', 'BOD'])) {
                            $objPHPExcel->getActiveSheet()->getStyle($cellNumber)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_DATE_YYYYMMDDSLASH);
                        }
                        $i++;
                    }
                    $n++;
                }
    
                // Export Excel file
                $filename = 'Attendance Report.xls';
                header('Content-Type: application/vnd.ms-excel');
                header('Content-Disposition: attachment;filename="' . $filename . '"');
                header('Cache-Control: max-age=0');
                
                ob_start();
                $write = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
                $write->save('php://output');
                $xlsData = ob_get_contents();
                ob_end_clean();
    
                // Return response
                $response = array(
                    'status' => 'success',
                    'status_code' => 200,
                    'status_message' => 'Successfully retrieved data',
                    'file' => "data:application/vnd.ms-excel;base64," . base64_encode($xlsData)
                );
                header('Content-Type: application/json');
                echo json_encode($response);
                exit;
            }
    
            // If no data found
            $response = array(
                'status' => 'error',
                'status_code' => 500,
                'status_message' => 'No data found',
            );
            header('Content-Type: application/json');
            echo json_encode($response);
    
        } catch (Exception $e) {
            $response = array(
                'status' => 'error',
                'status_message' => $e->getMessage()
            );
            header('Content-Type: application/json');
            echo json_encode($response);
        }
    }


	public function soft_delete($id)
	{
		if ($id == '' || $id == 0) {
			$this->session->set_flashdata('error', 'Select Atleast One');
			redirect($this->redirect . '/admin/all');
		}
		$data = array(
			'status' => '2',
		);
		$result = $this->crud_model->update($this->table, $data, array('id' => $id));
		if ($result == true) {
			$this->session->set_flashdata('success', 'Successfully Deleted.');
			redirect($this->redirect . '/admin/all');
		} else {
			$this->session->set_flashdata('error', 'Unable To Delete.');
			redirect($this->redirect . '/admin/all');
		}
	} 
	
	public function view($id){
        $data['detail'] =$this->crud_model->get_where_single($this->table, array('id' => $id));
        $data['education']=$this->crud_model->getDataArray('applicant_education', ['career_apply_id'=>$id], [], 'id DESC'); 
        $data['experience']=  $this->crud_model->getDataArray('applicant_experience', ['career_apply_id'=>$id], [], 'id DESC'); 
        $data['references']=  $this->crud_model->getDataArray('applicant_references', ['career_apply_id'=>$id], [], 'id DESC'); 
        $data['training']=  $this->crud_model->getDataArray('applicant_training', ['career_apply_id'=>$id], [], 'id DESC'); 
        $data['title'] = 'View ' . $this->title;
		$data['page'] = 'view';
		$data['online'] = 'onlne-all';
		$data['module'] = 'CareerApply';
		$data = array_merge($this->data, $data);
		$this->load->view('layouts/admin/index', $data);
    }
}