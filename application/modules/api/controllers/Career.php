<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Career extends Front_controller
{
    protected $param;
    protected $table;
    protected $title;
    function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');

        header('Content-type:application/json');
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Headers: Authorization, Origin, X-Requested-With, Content-Type, Accept, Content-Length, Accept-Encoding, X-API-KEY, Access-Control-Request-Method");
        header("Access-Control-Allow-Methods: GET, POST, OPTIONS, DELETE, PUT");
        $this->request_method = $_SERVER["REQUEST_METHOD"];
        // $this->request = $_SERVER['REQUEST']; 

        if ($this->request_method == "OPTIONS") {
            die();
        }

        $authKeyFromApp = apache_request_headers();
        // $this->loggedinUser = $authKeyFromApp['Authorization'];
        // $this->table = 'careers';
        $this->table = 'career';
        $this->title = 'Career';
        $this->param = array('Type'=> 'career' ,'status' => ['1','3']);
    }
    
    function all($page=0)
    { 
        // echo "here";exit;
        header('Access-Control-Allow-Method:GET');
        if ($this->request_method != "GET") {
            $response=array(
                'status' => "Error",
                'status_code' => 204,
                'status_message' => "Access Method Not Allowed",
            );
        } else {  
                $per_page = 10;
                $careerEn = [];
                $careerNe = [];
                $currentDate = (new DateTime())->format('Y-m-d');
                $sql = "id, DocPath, Duration, JobNumber, Description, DescriptionNepali, status, Title, TitleNepali, branch_id, Experience, created_on, slug, due_date, datevalue";
                $careers = $this->crud_model->get_sql_allIN($this->table, array('Type'=> 'career' ,'status' => ['1','3'],'due_date >=' => $currentDate),'id', 'DESC',$per_page, $page,$sql);  
               
                foreach($careers as $key=>$val){
                    
                    $doc = '';
                    if($val->DocPath){
                        // $doc = base_url('pkh/uploads/noticeCareer/'.$val->DocPath);
                        $doc = base_url($val->DocPath);
                    }
                    $branches = [];
                    $selectedBranchIds = isset($val->branch_id)? explode(',', $val->branch_id) : [];
                    if($selectedBranchIds){ 
                        for($i = 0; count($selectedBranchIds) > $i; $i++){
                            $sql = "id, PageTitle, PageTitleNepali, slug";
                            $detail = $this->crud_model->getDetail('branches', array_merge(['status' => '1'], ['id' => $selectedBranchIds[$i]]), $sql);
                             
                            $branches[$i] = $detail; 
                        }
                        
                    }
                    //for english
                    $careerEn[$key]['id'] = $val->id;
                    $careerEn[$key]['title'] = $val->Title;
                    $careerEn[$key]['slug'] = $val->slug;
                    $careerEn[$key]['duration'] = $val->Duration;
                    $careerEn[$key]['jobNumber'] = $val->JobNumber;
                    $careerEn[$key]['experience'] = ($val->Experience?:0) . " Year";
                    $careerEn[$key]['description'] = $val->Description;
                    $careerEn[$key]['image'] = $doc;
                    $careerEn[$key]['created_on'] = $val->created_on;
                    $careerEn[$key]['due_date'] = $val->due_date;
                    $careerEn[$key]['StartDate'] = $val->datevalue;
                    $careerEn[$key]['branches'] = $branches;

                    //for neapli
                    $careerNe[$key]['id'] = $val->id;
                    $careerNe[$key]['title'] = $val->TitleNepali;
                    $careerNe[$key]['slug'] = $val->slug;
                    $careerNe[$key]['duration'] = $val->Duration;
                    $careerNe[$key]['jobNumber'] = $val->JobNumber;
                    $careerEn[$key]['experience'] = ($val->Experience?:0)." Year";
                    $careerNe[$key]['description'] = $val->DescriptionNepali;
                    $careerNe[$key]['image'] = $doc;
                    $careerNe[$key]['created_on'] = $val->created_on;
                    $careerNe[$key]['due_date'] = $val->due_date;
                    $careerNe[$key]['StartDate'] = $val->datevalue;
                    $careerNe[$key]['branches'] = $branches;
                }
                 
                $items = [
                    'en' =>$careerEn,
                    'np' => $careerNe
                ];
                $total = $this->crud_model->count_allIN($this->table, array('Type'=> 'career' ,'status' => ['1','3'],'due_date >=' => $currentDate), 'id'); 
               
                if($items){ 
                    $response=array(
                            'status' => "Success",
                            'status_code' => 200,
                            'status_message' => "Item List",
                            'items' => $items,
                            'total' => $total,
                            'per_page' => $per_page,
                        );
                }else{
                    $response=array(
                            'status' => "error",
                            'status_code' => 208,
                            'status_message' => "No Items Found", 
                        );
                } 
            
        } 
        $json_response = json_encode($response);
        echo $json_response;
    } 
    
    
    public function detail($slug)
    {
        header('Access-Control-Allow-Method:GET');
        if ($this->request_method != "GET") {
            $response = array(
                'status' => "Error",
                'status_code' => 204,
                'status_message' => "Access Method Not Allowed",
            );
        } else {
            if($slug){
                $careerEn = [];
                $careerNe = [];
                $sql = "id,  DocPath, Duration, JobNumber, Description, DescriptionNepali, Title, TitleNepali, branch_id, Experience, slug, due_date, datevalue ,status, created_on, slug";
                $detail = $this->crud_model->getDetail($this->table, array_merge($this->param,['slug'=>$slug]), $sql);
                if($detail){
                    
                    $doc = '';
                    if($detail->DocPath){
                        // $doc = base_url('pkh/uploads/noticeCareer/'.$detail->DocPath);
                        $doc = base_url($detail->DocPath);
                    }
                    
                    $branches = [];
                    $selectedBranchIds = isset($detail->branch_id)? explode(',', $detail->branch_id) : [];
                    if($selectedBranchIds){ 
                        for($i = 0; count($selectedBranchIds) > $i; $i++){
                            $sql = "id, PageTitle,PageTitleNepali, slug";
                            $branch_val = $this->crud_model->getDetail('branches', array_merge(['status' => '1'], ['id' => $selectedBranchIds[$i]]), $sql);
                             
                            $branches[$i] = $branch_val; 
                        }
                        
                    }
                   
                    //for english
                    $careerEn['id'] = $detail->id;
                    $careerEn['title'] = $detail->Title;
                    $careerEn['slug'] = $detail->slug;
                    $careerEn['duration'] = $detail->Duration;
                    $careerEn['jobNumber'] = $detail->JobNumber;
                    $careerEn['description'] = $detail->Description;
                    $careerEn['image'] = $doc;
                    $careerEn['created_on'] = $detail->created_on;
                    // $careerEn['branches'] = $branches;
                    $careerEn['Experience'] = $detail->Experience;
                    $careerEn['due_date'] = $detail->due_date;
                    $careerEn['datevalue'] = $detail->datevalue;
                    

                    //for neapli
                    $careerNe['id'] = $detail->id;
                    $careerNe['title'] = $detail->TitleNepali;
                    $careerNe['slug'] = $detail->slug;
                    $careerNe['duration'] = $detail->Duration;
                    $careerNe['jobNumber'] = $detail->JobNumber;
                    $careerNe['description'] = $detail->DescriptionNepali;
                    $careerNe['image'] = $doc;
                    $careerNe['created_on'] = $detail->created_on;
                    // $careerNe['branches'] = $branches;
                    $careerNe['Experience'] = $detail->Experience;
                    $careerNe['due_date'] = $detail->due_date;
                    $careerNe['datevalue'] = $detail->datevalue;
                    
                }
                if(!empty($detail)){
                    $response = array(
                        'status' => "success",
                        'status_code' => 200,
                        'status_message' => "Data Retreived Successfully",
                        'branches'=> $branches,
                        'detail' => [
                            'en' =>$careerEn,
                            'np' => $careerNe
                        ], 
                    );
                }else{
                    $response = array(
                        'status' => "error",
                        'status_code' => 200,
                        'status_message' => "Invalid Slug", 
                    );
                } 
            }else{
                $response = array(
                    'status' => "error",
                    'status_code' => 200,
                    'status_message' => "Slug Required", 
                );
            }
            
        }
        // var_dump($response);exit;
        $json_response = json_encode($response);
        echo $json_response;
    }
    
    public function generateApplicationID($career_id) {
   
        $this->db->select('datevalue');
        $this->db->from('career');
        $this->db->where('id', $career_id);
        $this->db->where('status!=', '2');
        $vacancyDateRow = $this->db->get()->row();
    
        if (!$vacancyDateRow) {
            // Handle the case where the career ID does not exist
            return null; // or throw an exception, or handle error accordingly
        }
    
        // Format the vacancy date
        $vacancyDate = $vacancyDateRow->datevalue; // Assuming datevalue is in 'Y-m-d' format
        $formattedDate = date('Ymd', strtotime($vacancyDate));
    
        // Get the current number of applicants
        $this->db->select('COUNT(*) as applicant_count');
        $this->db->from('career_apply');
        $this->db->where('career_id', $career_id);
        $result = $this->db->get()->row();
    
        $serialNumber = sprintf('%03d', $result->applicant_count + 1); // 3-digit serial number
    
        // Generate Application ID
        $applicationID = $formattedDate . $serialNumber;
    
        return $applicationID;
    }

    function form()
    { 
        // echo "here";exit;
        header('Access-Control-Allow-Method:POST');
        if ($this->request_method != "POST") {
            $response=array(
                'status' => "Error",
                'status_code' => 204,
                'status_message' => "Access Method Not Allowed",
            );
        } else {  
            
                $input_data = json_decode(file_get_contents("php://input"), true);
                // $recaptchaResponse = trim($this->input->post('g-recaptcha-response'));
                $recaptchaResponse = $input_data['g-recaptcha-response'];
                // var_dump($recaptchaResponse); die;
                $userIp=$this->input->ip_address();
                // $secret = $this->config->item('google_secret');
                $secret = '6LcD0y4qAAAAAEf63bTCNj-lyLAyI4D17Wne9D0p';
                $url="https://www.google.com/recaptcha/api/siteverify?secret=".$secret."&response=".$recaptchaResponse."&remoteip=".$userIp;
                $ch = curl_init(); 
                curl_setopt($ch, CURLOPT_URL, $url); 
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
                $output = curl_exec($ch); 
                curl_close($ch);      
                $status= json_decode($output, true);
                
                if ($input_data) {                   
                       $career_id = isset($input_data['career_id'])? $this->validation($input_data['career_id']):''; 
                       $first_name =  isset($input_data['first_name'])? $this->validation($input_data['first_name']):''; 
                       $middle_name =  isset($input_data['middle_name'])? $this->validation($input_data['middle_name']):'';
                       $last_name =  isset($input_data['last_name'])? $this->validation($input_data['last_name']):'';
                       $bod =  isset($input_data['bod'])? $this->validation($input_data['bod']):'';
                       $age =  isset($input_data['age'])? $this->validation($input_data['age']):'';
                       $father_name =  isset($input_data['father_name'])? $this->validation($input_data['father_name']):'';
                       $mother_name =  isset($input_data['mother_name'])? $this->validation($input_data['mother_name']):'';
                       $email = isset($input_data['email'])? $this->validation($input_data['email']):'';
                       $mobno = isset($input_data['mobno'])? $this->validation($input_data['mobno']):''; 
                       $gender =  isset($input_data['gender'])? $this->validation($input_data['gender']):''; 
                       $nationality =  isset($input_data['nationality'])? $this->validation($input_data['nationality']):'';
                       $religion =  isset($input_data['religion'])? $this->validation($input_data['religion']):'';
                       $marital_status =  isset($input_data['marital_status'])? $this->validation($input_data['marital_status']):'';
                       $citizenship_no =  isset($input_data['citizenship_no'])? $this->validation($input_data['citizenship_no']):'';
                       $citizen_issue_location =  isset($input_data['citizen_issue_location'])? $this->validation($input_data['citizen_issue_location']):'';
                       $permanent_provience =  isset($input_data['permanent_provience'])? $this->validation($input_data['permanent_provience']):'';
                       $permanent_district = isset($input_data['permanent_district'])? $this->validation($input_data['permanent_district']):'';
                       $permanent_municipality = isset($input_data['permanent_municipality'])? $this->validation($input_data['permanent_municipality']):''; 
                       $permanent_ward =  isset($input_data['permanent_ward'])? $this->validation($input_data['permanent_ward']):''; 
                       $temporary_provience =  isset($input_data['temporary_provience'])? $this->validation($input_data['temporary_provience']):'';
                       $temporary_district =  isset($input_data['temporary_district'])? $this->validation($input_data['temporary_district']):'';
                       $temporary_municipality =  isset($input_data['temporary_municipality'])? $this->validation($input_data['temporary_municipality']):'';
                       $temporary_ward =  isset($input_data['temporary_ward'])? $this->validation($input_data['temporary_ward']):'';
                       $expected_salary =  isset($input_data['expected_salary'])? $this->validation($input_data['expected_salary']):'';
                       $driving_license =  isset($input_data['driving_license'])? $this->validation($input_data['driving_license']):'';
                       $branch_name = isset($input_data['branch_name'])? $this->validation($input_data['branch_name']):'';
                       $images = isset($input_data['DocPath'])?$input_data['DocPath']:'';
                       $certificate = isset($input_data['certificate'])? $input_data['certificate']:''; 
                       $cv =  isset($input_data['cv'])? $this->validation($input_data['cv']):'';
                       $application = isset($input_data['application'])? $this->validation($input_data['application']):'';
                       $training_certificate = isset($input_data['training_certificate'])? $this->validation($input_data['training_certificate']):''; 
                       $citizenship = isset($input_data['citizenship'])? $this->validation($input_data['citizenship']):''; 
                       $experience_letters = isset($input_data['experience_letters'])? $this->validation($input_data['experience_letters']):''; 
                       
                    //   if($email == ""){
                    //       $response=array(
                    //           'status' => "Error",
                    //           'status_code' => 307,
                    //           'status_message' => "Email Required!!!", 
                    //       );
                    //       $json_response = json_encode($response);
                    //       echo $json_response;
                    //       exit;
                    //   }
                       $errors = [];
                       
                        if (empty($email)) {
                            $errors[] = 'Email is required.';
                        }
                        
                       if (strlen($first_name) > 20) {
                            $errors[] = 'First Name cannot exceed 20 characters.';
                        } 
                        // Additional checks for First Name
                        if (preg_match('/[^a-zA-Z\s]/', $first_name)) {
                            $errors[] = 'First Name can only contain letters and spaces.';
                        }
                        if (strlen($middle_name) > 20) {
                            $errors[] = 'Middle Name cannot exceed 20 characters.';
                        }
                        if (preg_match('/[^a-zA-Z\s]/', $middle_name)) {
                            $errors[] = 'Middle Name can only contain letters and spaces.';
                        }
                        if (strlen($last_name) > 20) {
                            $errors[] = 'Last Name cannot exceed 20 characters.';
                        }
                        if (preg_match('/[^a-zA-Z\s]/', $last_name)) {
                            $errors[] = 'Last Name can only contain letters and spaces.';
                        }
                        // Ensure Marital Status doesn't exceed 15 characters
                        if (strlen($marital_status) > 15) {
                            $errors[] = 'Marital Status cannot exceed 15 characters.';
                        }
                        
                        if (empty($mobno)) {
                            $errors[] = 'Contact Number is required.';
                        } elseif (strlen($mobno) !== 10) {
                            $errors[] = 'Contact Number must be exactly 10 characters.';
                        } elseif (!preg_match('/^\d{10}$/', $mobno)) {
                            $errors[] = 'Contact Number must contain only digits.';
                        }
                        
                        if ($input_data['educationaddmore'] != "") {
                            foreach ($input_data['educationaddmore'] as $key => $value) {
                                // Check if organization or board is provided
                                if ($value['organization'] != "" || $value['board'] != '') {
                                    // Validate GPA/Percentile
                                    if (strlen($value['gpa']) > 5) {
                                        // Handle error if GPA exceeds 5 characters
                                        $errors[] = "GPA/Percentile must not exceed 5 characters for organization: " . $value['organization'];
                                        continue; // Skip this iteration
                                    }          
                                }
                            }
                        }
                        if(!empty($errors)){
                           $response=array(
                           'status' => "Error",
                           'status_code' => 300,
                        //   'status_message' => "Error in Validation & Submitting the data.", 
                        'status_message' => implode(" ", $errors),
                           'error'=>$errors,
                       );
                        $json_response = json_encode($response);
                           echo $json_response;
                           exit;
                        }
                        
                        $applicationID = $this->generateApplicationID($career_id);
                      
                        $data = array(
                           'application_id' =>$applicationID,
                           'first_name' => $first_name,
                           'middle_name' => $middle_name,
                           'last_name' => $last_name,
                           'bod' => $bod,
                           'age' => $age,
                           'father_name' => $father_name,
                           'mother_name' => $mother_name,
                           'email' => $email,
                           'phone_number' => $mobno,
                           'gender' => $gender,
                           'nationality' => $nationality,
                           'religion' => $religion,
                           'marital_status' => $marital_status,
                           'citizenship_no' => $citizenship_no,
                           'citizen_issue_location' => $citizen_issue_location,
                           'permanent_provience' => $permanent_provience,
                           'permanent_district' => $permanent_district,
                           'permanent_municipality' => $permanent_municipality,
                           'permanent_ward' => $permanent_ward,
                           'temporary_provience' => $temporary_provience,
                           'temporary_district' => $temporary_district,
                           'temporary_municipality' => $temporary_municipality,
                           'temporary_ward' => $temporary_ward,
                           // 'cv' => $cv,
                           // 'application' => $application,
                           // 'training_certificate' => $training_certificate,
                           // 'citizenship' => $citizenship,
                           'expected_salary' => $expected_salary,
                           'driving_license' => $driving_license,
                           'branch_id' => $branch_name,
                           'career_id' => $career_id,
                           'created' => (new DateTime())->format('Y-m-d H:i:s'),
                           'status' => '1',
                       );
                        
                       $clientName = implode(' ', [$first_name, $middle_name, $last_name]);
                       if($certificate){
                           $explodeCertificate = explode(",",$certificate);
                           $arrayExtensions = ['pdf', 'jpg', 'jpeg', 'png', 'gif','doc','docx'];
                           for($i= 0; $i <= count($arrayExtensions); $i++){
                               if(strpos( $explodeCertificate[0], $arrayExtensions[$i])){
                                   $extensions = '.'.$arrayExtensions[$i];
                               }
                           }
                           
                           $file_names = $clientName.'_career_certificate_'. uniqid() . $extensions;
                           $uploadpaths   = $_SERVER["DOCUMENT_ROOT"].'/uploads/certificate/';
                           $parts        = explode(";base64,", $certificate);
                           $imageparts   = explode("image/", @$part[0]);
                           $imagetype    = $imageparts[1];
                           $imagebase641  = base64_decode($explodeCertificate[1]);
                           // Check the file size (3 MB = 3,145,728 bytes)
                            // if (strlen($imagebase641) > 3145728) {
                            //     // File size exceeds 500KB, return error
                            //     $response = array(
                            //         'status' => "Error",
                            //         'status_code' => 206,
                            //         'status_message' => "Attachment Certificate File size exceeds the 3MB limit.",
                            //     );
                            //     $json_response = json_encode($response);
                            //     echo $json_response;
                            //     exit;
                            // }
                           $files         = $uploadpaths .$file_names;
                           if(file_put_contents($files, $imagebase641)){ 
                               $data['certificate'] = 'uploads/certificate/'.$file_names;
                           }else{
                               $response=array(
                                   'status' => "Error",
                                   'status_code' => 206,
                                   'status_message' => "Unable To Upload Attachment Certificate.", 
                               );
                               $json_response = json_encode($response);
                               echo $json_response;
                               exit;
                           }
                           
                       } 
                       
                       if($images){
                           $explode = explode(",",$images);
                           $arrayExtension = ['pdf', 'jpg', 'jpeg', 'png', 'gif','doc','docx'];
                           for($i= 0; $i <= count($arrayExtension); $i++){
                               if(strpos( $explode[0], $arrayExtension[$i])){
                                   $extension = '.'.$arrayExtension[$i];
                               }
                           }
                           
                           $file_name = $clientName.'_career_'. uniqid() . $extension;
                           $uploadpath   = $_SERVER["DOCUMENT_ROOT"].'/uploads/careerApply/';
                           $parts        = explode(";base64,", $images);
                           $imageparts   = explode("image/", @$parts[0]);
                           $imagetype    = $imageparts[1];
                           $imagebase64  = base64_decode($explode[1]);
                            // if (strlen($imagebase641) > 1048576 ) {
                            //     // File size exceeds 500KB, return error
                            //     $response = array(
                            //         'status' => "Error",
                            //         'status_code' => 206,
                            //         'status_message' => "Attachment Photo File size exceeds the 500KB limit.",
                            //     );
                            //     $json_response = json_encode($response);
                            //     echo $json_response;
                            //     exit;
                            // }
                           
                           $file         = $uploadpath .$file_name;
                           if(file_put_contents($file, $imagebase64)){ 
                               $data['DocPath'] = 'uploads/careerApply/'.$file_name;
                           }else{
                               $response=array(
                                   'status' => "Error",
                                   'status_code' => 206,
                                   'status_message' => "Unable To Upload Attachment Photo.", 
                               );
                               $json_response = json_encode($response);
                               echo $json_response;
                               exit;
                           }
                           
                       } 
                       
                       if($training_certificate){
                           $explodetraining_certificate = explode(",",$training_certificate);
                       
                           $arrayExtensions = ['pdf', 'jpg', 'jpeg', 'png', 'gif','doc','docx'];
                           for($i= 0; $i <= count($arrayExtensions); $i++){
                               if(strpos( $explodetraining_certificate[0], $arrayExtensions[$i])){
                                   $extensions = '.'.$arrayExtensions[$i];
                               }
                           }
                           
                           $file_names = $clientName.'_career_training_certificate_'. uniqid() . $extensions;
                           $uploadpaths   = $_SERVER["DOCUMENT_ROOT"].'/uploads/training_certificate/';
                           $parts        = explode(";base64,", $training_certificate);
                           $imageparts   = explode("image/", @$part[0]);
                           $imagetype    = $imageparts[1];
                           $imagebase641  = base64_decode($explodetraining_certificate[1]); 
                        //   if (strlen($imagebase641) > 3145728) {
                        //         // File size exceeds 500KB, return error
                        //         $response = array(
                        //             'status' => "Error",
                        //             'status_code' => 206,
                        //             'status_message' => "Attachment Training Certificate File size exceeds the 3MB limit.",
                        //         );
                        //         $json_response = json_encode($response);
                        //         echo $json_response;
                        //         exit;
                        //     }
                           
                           $files         = $uploadpaths .$file_names;
                           if(file_put_contents($files, $imagebase641)){ 
                               $data['training_certificate'] = 'uploads/training_certificate/'.$file_names;
                           }else{
                               $response=array(
                                   'status' => "Error",
                                   'status_code' => 206,
                                   'status_message' => "Unable To Upload Attachment Training Certificate.", 
                               );
                               $json_response = json_encode($response);
                               echo $json_response;
                               exit;
                           }
                           
                       } 
                       
                       if($application){
                           $explodeapplication = explode(",",$application);
                       
                            $arrayExtensions = ['pdf', 'jpg', 'jpeg', 'png', 'gif','doc','docx'];
                           for($i= 0; $i <= count($arrayExtensions); $i++){
                               if(strpos( $explodeapplication[0], $arrayExtensions[$i])){
                                   $extensions = '.'.$arrayExtensions[$i];
                               }
                           }
                           
                           $file_names = $clientName.'_career_application_'. uniqid() . $extensions;
                           $uploadpaths   = $_SERVER["DOCUMENT_ROOT"].'/uploads/application/';
                           $parts        = explode(";base64,", $application);
                           $imageparts   = explode("image/", @$part[0]);
                           $imagetype    = $imageparts[1];
                           $imagebase641  = base64_decode($explodeapplication[1]);
                            // if (strlen($imagebase641) > 1048576 ) {
                            //     // File size exceeds 500KB, return error
                            //     $response = array(
                            //         'status' => "Error",
                            //         'status_code' => 206,
                            //         'status_message' => "Attachment Hand Written Application File size exceeds the 500KB limit.",
                            //     );
                            //     $json_response = json_encode($response);
                            //     echo $json_response;
                            //     exit;
                            // }
                            $files         = $uploadpaths .$file_names;
                           if(file_put_contents($files, $imagebase641)){ 
                               $data['application'] = 'uploads/application/'.$file_names;
                           }else{
                               $response=array(
                                   'status' => "Error",
                                   'status_code' => 206,
                                   'status_message' => "Unable To Upload Attachment Hand Written Application.", 
                               );
                               $json_response = json_encode($response);
                               echo $json_response;
                               exit;
                           }
                           
                       } 
                       
                       if($citizenship){
                           $explodecitizenship = explode(",",$citizenship);
                       
                            $arrayExtensions = ['pdf', 'jpg', 'jpeg', 'png', 'gif','doc','docx'];
                           for($i= 0; $i <= count($arrayExtensions); $i++){
                               if(strpos( $explodecitizenship[0], $arrayExtensions[$i])){
                                   $extensions = '.'.$arrayExtensions[$i];
                               }
                           }
                           
                           $file_names = $clientName.'_career_citizenship_'. uniqid() . $extensions;
                           $uploadpaths   = $_SERVER["DOCUMENT_ROOT"].'/uploads/citizenship/';
                           $parts        = explode(";base64,", $citizenship);
                           $imageparts   = explode("image/", @$part[0]);
                           $imagetype    = $imageparts[1];
                           $imagebase641  = base64_decode($explodecitizenship[1]);
                            // if (strlen($imagebase641) > 1048576 ) {
                            //     // File size exceeds 500KB, return error
                            //     $response = array(
                            //         'status' => "Error",
                            //         'status_code' => 206,
                            //         'status_message' => "Attachment Citizenship File size exceeds the 500KB limit.",
                            //     );
                            //     $json_response = json_encode($response);
                            //     echo $json_response;
                            //     exit;
                            // }
                           $files         = $uploadpaths .$file_names;
                           if(file_put_contents($files, $imagebase641)){ 
                               $data['citizenship'] = 'uploads/citizenship/'.$file_names;
                           }else{
                               $response=array(
                                   'status' => "Error",
                                   'status_code' => 206,
                                   'status_message' => "Unable To Upload Attachment Citizenship.", 
                               );
                               $json_response = json_encode($response);
                               echo $json_response;
                               exit;
                           }
                           
                       } 
                       
                       if($cv){
                           $explodecv = explode(",",$cv);
                       
                            $arrayExtensions = ['pdf', 'jpg', 'jpeg', 'png', 'gif'];
                           for($i= 0; $i <= count($arrayExtensions); $i++){
                               if(strpos( $explodecv[0], $arrayExtensions[$i])){
                                   $extensions = '.'.$arrayExtensions[$i];
                               }
                           }
                           
                           $file_names = $clientName.'_career_cv_'. uniqid() . $extensions;
                           $uploadpaths   = $_SERVER["DOCUMENT_ROOT"].'/uploads/cv/';
                           $parts        = explode(";base64,", $cv);
                           $imageparts   = explode("image/", @$part[0]);
                           $imagetype    = $imageparts[1];
                           $imagebase641  = base64_decode($explodecv[1]);
                        //   if (strlen($imagebase641) > 1048576 ) {
                        //         // File size exceeds 500KB, return error
                        //         $response = array(
                        //             'status' => "Error",
                        //             'status_code' => 206,
                        //             'status_message' => "Attachment CV File size exceeds the 500KB limit.",
                        //         );
                        //         $json_response = json_encode($response);
                        //         echo $json_response;
                        //         exit;
                        //     }
                           
                           $files         = $uploadpaths .$file_names;
                           if(file_put_contents($files, $imagebase641)){ 
                               $data['cv'] = 'uploads/cv/'.$file_names;
                           }else{
                               $response=array(
                                   'status' => "Error",
                                   'status_code' => 206,
                                   'status_message' => "Unable To Upload Attachment CV.", 
                               );
                               $json_response = json_encode($response);
                               echo $json_response;
                               exit;
                           }
                           
                       } 
                       if($experience_letters){
                           $explodeexperience_letters = explode(",",$experience_letters);
                       
                            $arrayExtensions = ['pdf', 'jpg', 'jpeg', 'png', 'gif','doc','docx'];
                           for($i= 0; $i <= count($arrayExtensions); $i++){
                               if(strpos( $explodeexperience_letters[0], $arrayExtensions[$i])){
                                   $extensions = '.'.$arrayExtensions[$i];
                               }
                           }
                           
                           $file_names = $clientName.'_career_experience_letters_'. uniqid() . $extensions;
                           $uploadpaths   = $_SERVER["DOCUMENT_ROOT"].'/uploads/experience_letters/';
                           $parts        = explode(";base64,", $experience_letters);
                           $imageparts   = explode("image/", @$part[0]);
                           $imagetype    = $imageparts[1];
                           $imagebase641  = base64_decode($explodeexperience_letters[1]);
                            // if (strlen($imagebase641) > 1048576 ) {
                            //     // File size exceeds 500KB, return error
                            //     $response = array(
                            //         'status' => "Error",
                            //         'status_code' => 206,
                            //         'status_message' => "Attachment Experience Letters File size exceeds the 500KB limit.",
                            //     );
                            //     $json_response = json_encode($response);
                            //     echo $json_response;
                            //     exit;
                            // }
                           $files         = $uploadpaths .$file_names;
                           if(file_put_contents($files, $imagebase641)){ 
                               $data['experience_letters'] = 'uploads/experience_letters/'.$file_names;
                           }else{
                               $response=array(
                                   'status' => "Error",
                                   'status_code' => 206,
                                   'status_message' => "Unable To Upload Attachment experience_letters.", 
                               );
                               $json_response = json_encode($response);
                               echo $json_response;
                               exit;
                           }
                           
                       } 
                       
                        
                        $rid = $this->crud_model->inserted('career_apply', $data);
                       
                       if($input_data['educationaddmore'] != ""){
                           foreach ($input_data['educationaddmore'] as $key => $value) {
                               if($value['organization']!= "" || $value['board']!=''){ 
                                   $educationdata=array(
                                   'career_apply_id '=>$rid,
                                   'organization'=>$value['organization'],
                                   'board'=>$value['board'],
                                   'degree'=>$value['degree'],
                                   'faculty'=>$value['faculty'],
                                   'passed_year'=>$value['passed_year'],
                                   'gpa'=>$value['gpa'],
                                   'created_on'=>date('Y-m-d h:i:s')
                               );
                               
                               $educationid=$this->db->insert('applicant_education',$educationdata);
                               $educationid=$this->db->insert_id();
                               }
                               
                           }
                       
                       }
                       
                       if($input_data['experienceaddmore'] != ""){
                           foreach ($input_data['experienceaddmore']as $key => $value) {
                               if($value['organization']!= "" || $value['position']!=''){ 
                                   $experiencedata=array(
                                   'career_apply_id '=>$rid,
                                   'organization'=>$value['organization'],
                                   'position'=>$value['position'],
                                   'department'=>$value['department'],
                                //   'work_period'=>$value['work_period'],
                                    'date_from'=>$value['date_from'],
                                    'date_to'=>$value['date_to'],
                                   'created_on'=>date('Y-m-d h:i:s')
                               );
                               
                               $experienceid=$this->db->insert('applicant_experience',$experiencedata);
                               $experienceid=$this->db->insert_id();
                               }
                               
                           }
                       
                       }
                       
                       if($input_data['trainingaddmore'] != ""){
                           foreach ($input_data['trainingaddmore'] as $key => $value) {
                               if($value['organization']!= "" || $value['traning_date']!=''){ 
                                   $trainingdata=array(
                                   'career_apply_id '=>$rid,
                                   'organization'=>$value['organization'],
                                   'traning_date'=>$value['traning_date'],
                                   'title'=>$value['title'],
                                   'created_on'=>date('Y-m-d h:i:s')
                               );
                              
                               $trainingid=$this->db->insert('applicant_training',$trainingdata);
                               $trainingid=$this->db->insert_id();
                               }
                               
                           }
                       
                       }
                       
                       if($input_data['referencesaddmore'] != ""){
                           foreach ($input_data['referencesaddmore'] as $key => $value) {
                               if($value['organization']!= "" || $value['name']!=''){ 
                                   $referencesdata=array(
                                   'career_apply_id '=>$rid,
                                   'organization'=>$value['organization'],
                                   'name'=>$value['name'],
                                   'position'=>$value['position'],
                                   'address'=>$value['address'],
                                   'contact'=>$value['contact'],
                                   'created_on'=>date('Y-m-d h:i:s')
                               );
                               
                               $referencesid=$this->db->insert('applicant_references',$referencesdata);
                               $referencesid=$this->db->insert_id();
                               }
                               
                           }
                       
                       }
                       
                       
                       if($rid){
                           $this->load->library('email');
                         
                           $config = Array(
                               'protocol' => 'sendmail',
                               'smtp_host' => 'mi3-sr5.supercp.com',
                               'smtp_port' => '465',
                               // 'smtp_user' => 'no-reply@pkh.com.np', 
                               // 'smtp_pass' => 'UUrE7(WD6?V~', 
                               'mailtype' => 'html',
                               'charset' => 'utf-8',
                               'wordwrap' => TRUE
                           );
                           
                           $this->email->initialize($config);
                           $this->email->from('no-reply@ssaccos.com','Suyogya SSACCOS.');
                           $this->email->to($email);
                          
                           // $this->email->cc();
                           // $this->email->bcc();
                           $this->email->subject('Suyogya SSACCOS. ');
                           
                           $this->email->message(
                                   "
                                   <p>Dear $clientName,</p>
       
                                   <p>Your personal detail and CV has been successfully submitted. The bank will response back to you soon.</p></br>
                                   <p>Keep checking your mail. </p></br>
                                   
                                   
                                   <p>Regards,</p></br>
                                   
                                   <p>Suyogya SSACCOS.</p></br>"
                               );
                           
                           if($this->email->send()){
                               $response=array(
                                   'status' => "Success",
                                   'status_code' => 200,
                                   'status_message' => "Successfully Submitted", 
                               );
                               
                           }
                           else {  
                               $response=array(
                                           'status' => "Error",
                                           'status_code' => 307,
                                           'status_message' => "Mail Not Sent!", 
                                       );
                           } 
                       }else{
                       $response=array(
                           'status' => "Error",
                           'status_code' => 300,
                           'status_message' => "Error in submitting the data.", 
                       );
                       }  
                      
                   }else{
                       $response=array(
                                   'status' => "Error",
                                   'status_code' => 300,
                                   'status_message' => "Input data required", 
                               );
                   } 
                // if ($status['success']) {
                     
                
                // }
                 
            
        } 
        $json_response = json_encode($response);
        echo $json_response;
    }
    
    function validation($data) {
      $data = trim($data);
      $data = stripslashes($data);
      $data = htmlspecialchars($data);
      return $data;
    }
    
    
    
    
}