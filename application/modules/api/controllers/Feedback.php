<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Feedback extends Front_controller
{
    protected $table;
    protected $title;
    protected $request_method;

    function __construct()
    {
        parent::__construct();
        // Load libraries here so they are available in all methods
        $this->load->library(array('form_validation', 'email'));
        $this->load->model('crud_model');

        header('Content-type:application/json');
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Headers: Authorization, Origin, X-Requested-With, Content-Type, Accept, Content-Length, Accept-Encoding, X-API-KEY, Access-Control-Request-Method");
        header("Access-Control-Allow-Methods: GET, POST, OPTIONS, DELETE, PUT");
        
        $this->request_method = $_SERVER["REQUEST_METHOD"];

        if ($this->request_method == "OPTIONS") {
            die();
        }

        $this->table = 'feedback_message';
        $this->title = 'feedback';
    }

    private function _get_email_config()
    {
        return array(
            'protocol'  => 'sendmail',
            'smtp_host' => 'mi3-sr5.supercp.com',
            'smtp_port' => '465',
            'mailtype'  => 'html',
            'charset'   => 'utf-8',
            'wordwrap'  => TRUE
        );
    }

    public function sendOfficeEmail($id)
    {
        $detail = $this->crud_model->get_where_single($this->table, array('id' => $id));
        if (!$detail) return false;

        $subject = 'New Feedback Received: ' . ($detail->subject ?? 'General');
        
        $message = "<h2>Feedback Details</h2>"
                 . "<strong>Full Name:</strong> {$detail->fullname}<br>"
                 . "<strong>Phone:</strong> {$detail->phone}<br>"
                 . "<strong>Email:</strong> {$detail->email}<br>"
                 . "<strong>Date:</strong> {$detail->created_on}<br>"
                 . "<strong>Message:</strong><br>" . nl2br($detail->message);

        $this->email->initialize($this->_get_email_config());
        $this->email->from('no-reply@ssaccos.com', 'System Notification');
        $this->email->to('info@ssaccos.com');
        $this->email->subject($subject);
        $this->email->message($message);
        
        return $this->email->send();
    }

    function form()
    {
        // Initializing default error response
        $response = array(
            'status' => "Error",
            'status_code' => 400,
            'status_message' => "Invalid Request"
        );

        if ($this->request_method != "POST") {
            $response['status_code'] = 405;
            $response['status_message'] = "Method Not Allowed";
        } else {
            $input_data = json_decode(file_get_contents("php://input"), true);
            
            if (!empty($input_data)) {
                // 1. Verify reCAPTCHA
                $recaptchaResponse = $input_data['g-recaptcha-response'] ?? '';
                $userIp = $this->input->ip_address();
                $secret = '6LcD0y4qAAAAAEf63bTCNj-lyLAyI4D17Wne9D0p';
                
                $url = "https://www.google.com/recaptcha/api/siteverify?secret=$secret&response=$recaptchaResponse&remoteip=$userIp";
                $verify = json_decode(file_get_contents($url), true);

                if (!$verify['success']) {
                    $response['status_message'] = "reCAPTCHA validation failed";
                    echo json_encode($response);
                    return;
                }

                // 2. Validate Data
                $email = isset($input_data['email']) ? $this->validation($input_data['email']) : '';

                if (empty($email)) {
                    $response['status_code'] = 307;
                    $response['status_message'] = "Email is required";
                } else {
                    $save_data = array(
                        'fullname'   => isset($input_data['fullname']) ? $this->validation($input_data['fullname']) : '',
                        'phone'      => isset($input_data['phone']) ? $this->validation($input_data['phone']) : '',
                        'message'    => isset($input_data['message']) ? $this->validation($input_data['message']) : '',
                        'subject'    => isset($input_data['subject']) ? $this->validation($input_data['subject']) : 'General Feedback',
                        'email'      => $email,
                        'address'    => isset($input_data['address']) ? $this->validation($input_data['address']) : '',
                        'created_on' => date('Y-m-d'),
                        'status'     => '1',
                    );

                    $rid = $this->crud_model->inserted($this->table, $save_data);

                    if ($rid) {
                        // 3. Send Emails
                        $this->email->initialize($this->_get_email_config());
                        $this->email->from('no-reply@ssaccos.com', 'Suyogya SSACCOS');
                        $this->email->to($email);
                        $this->email->subject('Feedback Submitted Successfully');
                        
                        $user_body = "<p>Dear {$save_data['fullname']},</p>
                                     <p>Thank you for your feedback. We have received it and will respond shortly.</p>
                                     <p>Regards,<br>Suyogya SSACCOS</p>";
                        
                        $this->email->message($user_body);
                        $this->email->send();

                        // Notify Office
                        $this->sendOfficeEmail($rid);

                        $response = array(
                            'status' => "Success",
                            'status_code' => 200,
                            'status_message' => "Successfully Submitted",
                        );
                    } else {
                        $response['status_message'] = "Database insertion failed";
                    }
                }
            } else {
                $response['status_message'] = "No input data detected";
            }
        }

        echo json_encode($response);
    }

    private function validation($data)
    {
        return htmlspecialchars(stripslashes(trim($data)));
    }
}