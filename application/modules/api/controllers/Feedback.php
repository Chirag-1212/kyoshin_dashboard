<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Feedback extends Front_controller
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
        $this->table = 'feedback_message';
        $this->title = 'feedback';
        $this->param = array('Type'=> 'career' ,'status' => ['1','3']);
    }
    
    public function sendOfficeEmail($id){
        $detail =$this->crud_model->get_where_single('feedback_message', array('id' => $id));
        $subject='Suyogya SSACCOS Feedback: '. $detail->subject;
        // Build the message content
        $message = "<h2>Feedback Details</h2>";
        $message .= "Full Name: " . $detail->fullname . "<br>";
        $message .= "Phone: " . $detail->phone . "<br>";
        $message .= "Email: " . $detail->email . "<br>";
        $message .= "Date: " . $detail->created_on . "<br>";
        $message .= "Message: " . $detail->message . "<br>";
      
        // Add other fields as needed
       
     
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
        $this->email->from($detail->email,'Feedback From  '. $detail->fullname);
         $this->email->to('info@ssaccos.com');
        // $this->email->to('info@ssaccos.com');
        // $this->email->cc();
        // $this->email->bcc();
        $this->email->subject($subject);
        
        $this->email->message($message);
        if($this->email->send()){
            return true;
        }
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
                       $fullname =  isset($input_data['fullname'])? $this->validation($input_data['fullname']):''; 
                       $phone =  isset($input_data['phone'])? $this->validation($input_data['phone']):'';
                       $subject =  isset($input_data['subject'])? $this->validation($input_data['subject']):'';
                       $email = isset($input_data['email'])? $this->validation($input_data['email']):'';
                       $message = isset($input_data['message'])? $this->validation($input_data['message']):'';
                      
                       
                       if($email == ""){
                           $response=array(
                               'status' => "Error",
                               'status_code' => 307,
                               'status_message' => "Email Required!!!", 
                           );
                           $json_response = json_encode($response);
                           echo $json_response;
                           exit;
                       } 
                       
                       $data = array(
                           'fullname' => $fullname,
                           'phone' => $phone,
                           'message' => $message,
                           'subject' => $subject,
                           'email' => $email,
                           'created_on' => (new DateTime())->format('Y-m-d H:i:s'),
                           'status' => '1',
                       );
                       
                       $rid = $this->crud_model->inserted($this->table, $data);
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
                                   <p>Dear $fullname,</p>
       
                                   <p>Your Feedback has been submitted successfully. The bank will response back to you soon.</p></br>
                                   <p>Keep checking your mail. </p></br>
                                   
                                   
                                   <p>Regards,</p></br>
                                   
                                   <p>Suyogya SSACCOS.</p></br>"
                               );
                           
                           if($this->email->send()){
                                if($rid){
                                  $this->sendOfficeEmail($rid);
                                }
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