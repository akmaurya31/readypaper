<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');

class AuthAccess extends MY_Controller
{


    public function __construct()
    {
        parent::__construct();
        $this->load->model('Person_model', 'person');
        $this->load->model('auth_model', 'auth');
        $this->load->model('State_model', 'state');
       $this->load->model('state_quota_model', 'state_quota');
    }
    
      public function getstate()
    {

        $stateid = $this->input->post('id');
        $dist = $this->state_quota->get_active_quota($stateid);
        foreach($dist as $val){?>
            <option value="<?= $val->id?>"><?= $val->state_quota_name?></option>
       <?php  }
        
    }


    public function signup_user()
    {
        $data['title'] = "Register";
        $data['get_active_state'] = $this->state->get_active_state();
        $this->form_validation->set_rules("name", "Name", "trim|required");
        $this->form_validation->set_rules("username", "Username", "trim|required");
        $this->form_validation->set_rules("mobile", "Mobile", "trim|required");
        $this->form_validation->set_rules("password", "Password", "trim|required");

        if ($this->form_validation->run() == true) {

            $emailid = $this->input->post('username');
            $checkEmail = $this->person->get_by_user($emailid);
            if (isset($checkEmail)) {
                $this->session->set_flashdata('error_message', 'Your Email Id Alreday Exist.');
            } else {
                $insert = [
                    'email'  => $this->input->post('username'),
                    'username'  => $this->input->post('username'),
                    'firstName' => $this->input->post('name'),
                    'mobile_no' => $this->input->post('mobile'),
                    'password' => sha1($this->input->post('password')),
                    'pass' => $this->input->post('password'),
                    'role'  => 'teacher',
                    'state' => $this->input->post('state'),
                    'pincode' => $this->input->post('pincode'),
                    'district' => $this->input->post('district'),
                    'address' => $this->input->post('address'),
                    'otp' => rand(4, 100000),
                ];
                $lastId = $this->person->save($insert);
                
                $getFile = $this->person->get_by_id($lastId);
                
                $adminRow_Name = $this->person->get_by_id(1);
                $to =  $getFile->email.',readypaperldh@gmail.com'; 
                $subject = $adminRow_Name->firstName;
                $from = 'info@readypaper.in';             // Pass here your mail id

                $emailContent = '<!DOCTYPE>
                <html>
                <head></head>
                <body>
                <p>Hello ' . $getFile->firstName . '</p>
                <p>Welcome to ' . $adminRow_Name->firstName . '</p>
                <p>Please click the following link to activate your account</p>';

                $emailContent = '
                <p>Use OTP code ' . $getFile->otp . ' to activate your account.</p>
                <p>URL to Login: <a  href="' . base_url() . 'email_otp/' . $getFile->id . '" target="_blank">Click here</a></p>';

                $emailContent .= "<p>Thank You.</p>
                </body>
                </html>";


                $config['protocol']    = 'smtp';
                $config['smtp_host']    = 'mail.readypaper.in';
                $config['smtp_port']    = '25';
                $config['smtp_timeout'] = '60';

                $config['smtp_user']    = 'info@readypaper.in';    //Important
                $config['smtp_pass']    = 'Paika@12#3';  //Important

                $config['charset']    = 'utf-8';
                $config['newline']    = "\r\n";
                $config['crlf'] = "\r\n";
                $config['mailtype'] = 'html'; // or html
                $config['validation'] = TRUE; // bool whether to validate email or not 


                $this->email->initialize($config);
                $this->email->set_mailtype("html");
                $this->email->from($from);
                $this->email->to($to);
                $this->email->subject($subject);
                $this->email->message($emailContent);
                //echo $this->email->send();die;

                if ($this->email->send()) {
                    redirect("email_otp/" . base64_encode($lastId));
                } else {
                    show_error($this->email->print_debugger());
                }
                //redirect("email_otp/" . $getFile->id);
            } //checkEmail end
        }

        $this->load->view("admin/layout/signup", $data);
    }


    public function Resend_otp()
    {
        $data['title'] = "Resend OTP";
    
        $user_id = $this->uri->segment('2');
        $getFile = $this->person->get_by_id(base64_decode($user_id));
    
        if ($getFile->otp) {// != ''
            $data = [
                'otp' => rand(4, 100000),
            ];
            $userId = base64_decode($user_id);
            
            $this->person->update(['id' => $userId], $data);
            $this->session->set_flashdata('error_resend', 'Resend OTP Your Email Id .');
                $adminRow_Name = $this->person->get_by_id(1);
                $getRESEND = $this->person->get_by_id($userId);
                 $to =  $getFile->email.',readypaperldh@gmail.com'; 
                $subject = "Resend OTP";
                $from = 'info@readypaper.in';             // Pass here your mail id
    
               $emailContent = '<!DOCTYPE>
                <html>
                <head></head>
                <body>
                <p>Hello ' . $getFile->firstName . '</p>
                <p>Welcome to ' . $adminRow_Name->firstName . '</p>
                <p>Please click the following link to activate your account</p>';
    
                $emailContent = '
                <p>Resend OTP  ' . $getRESEND->otp . ' to activate your account.</p>';
    
                $emailContent .= "<p>Thank You.</p>
                </body>
                </html>";
    
    
                $config['protocol']    = 'smtp';
                $config['smtp_host']    = 'mail.readypaper.in';
                $config['smtp_port']    = '25';
                $config['smtp_timeout'] = '60';
    
                $config['smtp_user']    = 'info@readypaper.in';    //Important
                $config['smtp_pass']    = 'Paika@12#3';  //Important
    
                $config['charset']    = 'utf-8';
                $config['newline']    = "\r\n";
                $config['crlf'] = "\r\n";
                $config['mailtype'] = 'html'; // or html
                $config['validation'] = TRUE; // bool whether to validate email or not 
    
    
                $this->email->initialize($config);
                $this->email->set_mailtype("html");
                $this->email->from($from);
                $this->email->to($to);
                $this->email->subject($subject);
                $this->email->message($emailContent);
                //echo $this->email->send();die;
    
                if ($this->email->send()) {
                    redirect("email_otp/".$user_id);
                } else {
                    show_error($this->email->print_debugger());
                }
            
        }
        
    }


    public function emailOtp()
{
    $data['title'] = "OTP Verify";
    $user_id = base64_decode($this->uri->segment('2'));
    $data['getEmail'] = $this->person->get_by_id($user_id);
    //echo $this->db->last_query();die;
    $this->form_validation->set_rules("otp", "Otp", "trim|required");

    if ($this->form_validation->run() === true) {
        $this->load->model('auth_model', 'auth');
        $otp = $this->input->post('otp');
        $status = $this->auth->validateOtp($user_id, $otp);

        if ($status === ERR_NONE) {
            $userotp = ['otp' => '', 'status' => 'Y'];
            $this->person->update(['id' => $user_id], $userotp);
            redirect("teacher_dashboard");
        } else {
            $this->session->set_flashdata("error_email_otp", "OTP is invalid");
        }
    }

    $this->load->view("admin/layout/email_veryfy", $data);
}




public function email_verify() {
    $data['title'] = "Email Verify";        

    $this->form_validation->set_rules("username", "Email", "trim|required");     
  
    if ($this->form_validation->run() == true) {  
        $emailid = $this->input->post('username');      
           $checkEmail = $this->person->get_by_user($emailid);   
           if (isset($checkEmail)) {
           
                $getFile = $this->person->get_by_id($checkEmail->id);
                //echo $this->db->last_query();die;
                $adminRow_Name = $this->person->get_by_id(1);
                $to =  $getFile->email.',readypaperldh@gmail.com';  // User email pass here
                $subject = "Forgot Password";
                $from = 'info@readypaper.in';             // Pass here your mail id

                $emailContent = '<!DOCTYPE>
                <html>
                <head></head>
                <body>
                <p>Hello ' . $getFile->firstName . '</p>
                <p>Welcome to ' . $adminRow_Name->firstName . '</p>';

                $emailContent = '
              

<p>We received a request to reset the password for you through your email address.</p>

<p>To Show your password - User Name:- '.$getFile->username.' , Password:-'. $getFile->pass.'</p>

<p>If you did not request this reset link, then it is possible that someone else is trying to access the account so.
Do not Forward or give this link to anyone.</p>
';

                $emailContent .= "<p>Thank You.</p>
                </body>
                </html>";


                $config['protocol']    = 'smtp';
                $config['smtp_host']    = 'mail.readypaper.in';
                $config['smtp_port']    = '25';
                $config['smtp_timeout'] = '60';

                $config['smtp_user']    = 'info@readypaper.in';    //Important
                $config['smtp_pass']    = 'Paika@12#3';  //Important

                $config['charset']    = 'utf-8';
                $config['newline']    = "\r\n";
                $config['crlf'] = "\r\n";
                $config['mailtype'] = 'html'; // or html
                $config['validation'] = TRUE; // bool whether to validate email or not 


                $this->email->initialize($config);
                $this->email->set_mailtype("html");
                $this->email->from($from);
                $this->email->to($to);
                $this->email->subject($subject);
                $this->email->message($emailContent);
                //echo $this->email->send();die;

                if ($this->email->send()) {
                    redirect("teacherlogin");
                } else {
                    show_error($this->email->print_debugger());
                }
               

           }else{
                $this->session->set_flashdata('error_veryfy', 'Plz Currect Email Id.');
            } 
    }

    $this->load->view("admin/layout/forget_password",$data);
}





  
}
