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
        $this->load->library('form_validation');

        // CORS and JSON Headers
        header('Content-type:application/json');
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Headers: Authorization, Origin, X-Requested-With, Content-Type, Accept, Content-Length, Accept-Encoding, X-API-KEY, Access-Control-Request-Method");
        header("Access-Control-Allow-Methods: GET, POST, OPTIONS, DELETE, PUT");

        $this->request_method = $_SERVER["REQUEST_METHOD"];
        if ($this->request_method == "OPTIONS") {
            die();
        }

        // Table and column definitions (small letters)
        $this->table = 'feedback_message';
        $this->title = 'feedback';
    }

    /**
     * Internal function to send email to the office
     */
    private function send_office_email($id)
    {
        $detail = $this->crud_model->get_where_single($this->table, array('id' => $id));
        if (!$detail) return false;

        $subject = 'suyogya ssaccos feedback: ' . $detail->subject;
        
        $message = "<h2>feedback details</h2>";
        $message .= "full name: " . $detail->fullname . "<br>";
        $message .= "phone: " . $detail->phone . "<br>";
        $message .= "email: " . $detail->email . "<br>";
        $message .= "date: " . $detail->created_on . "<br>";
        $message .= "message: " . $detail->message . "<br>";

        $this->load->library('email');
        $config = array(
            'protocol'  => 'sendmail',
            'smtp_host' => 'mi3-sr5.supercp.com',
            'smtp_port' => '465',
            'mailtype'  => 'html',
            'charset'   => 'utf-8',
            'wordwrap'  => TRUE
        );

        $this->email->initialize($config);
        $this->email->from($detail->email, 'feedback from ' . $detail->fullname);
        $this->email->to('info@ssaccos.com');
        $this->email->subject($subject);
        $this->email->message($message);

        return $this->email->send();
    }

    /**
     * API Endpoint to submit feedback
     * POST: base_url/feedback/form
     */
    public function form()
    {
        if ($this->request_method != "POST") {
            return $this->output_json("error", 405, "access method not allowed");
        }

        $input_data = json_decode(file_get_contents("php://input"), true);
        if (!$input_data) {
            return $this->output_json("error", 400, "input data required");
        }

        // reCAPTCHA Validation
        $recaptcha_response = $input_data['g-recaptcha-response'] ?? '';
        $user_ip = $this->input->ip_address();
        $secret = '6LcD0y4qAAAAAEf63bTCNj-lyLAyI4D17Wne9D0p';
        
        $verify = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret={$secret}&response={$recaptcha_response}&remoteip={$user_ip}");
        $captcha_status = json_decode($verify, true);

        // Optional: Uncomment below to strictly enforce captcha
        /*
        if (!$captcha_status['success']) {
             return $this->output_json("error", 401, "captcha verification failed");
        }
        */

        $email = isset($input_data['email']) ? $this->clean_input($input_data['email']) : '';
        if (empty($email)) {
            return $this->output_json("error", 307, "email required!!!");
        }

        $save_data = array(
            'fullname'   => isset($input_data['fullname']) ? $this->clean_input($input_data['fullname']) : '',
            'phone'      => isset($input_data['phone'])    ? $this->clean_input($input_data['phone'])    : '',
            'subject'    => isset($input_data['subject'])  ? $this->clean_input($input_data['subject'])  : '',
            'message'    => isset($input_data['message'])  ? $this->clean_input($input_data['message'])  : '',
            'email'      => $email,
            'created_on' => date('Y-m-d H:i:s'),
            'status'     => '1',
        );

        $inserted_id = $this->crud_model->inserted($this->table, $save_data);

        if ($inserted_id) {
            // Send Auto-reply to User
            $this->send_user_reply($email, $save_data['fullname']);
            
            // Send Notification to Office
            $this->send_office_email($inserted_id);

            return $this->output_json("success", 200, "successfully submitted");
        }

        return $this->output_json("error", 300, "error in submitting the data");
    }

    private function send_user_reply($to_email, $name)
    {
        $this->load->library('email');
        $this->email->from('no-reply@ssaccos.com', 'suyogya ssaccos.');
        $this->email->to($to_email);
        $this->email->subject('feedback submission successful');
        $this->email->message("<p>dear $name,</p><p>your feedback has been submitted successfully. we will respond shortly.</p><p>regards,<br>suyogya ssaccos.</p>");
        $this->email->send();
    }

    private function clean_input($data)
    {
        return htmlspecialchars(stripslashes(trim($data)));
    }

    private function output_json($status, $code, $message)
    {
        echo json_encode(array(
            'status'         => $status,
            'status_code'    => $code,
            'status_message' => $message
        ));
        exit;
    }
}