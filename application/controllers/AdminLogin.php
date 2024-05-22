<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * This controller can be accessed 
 * for (all) non logged in users
 */
class AdminLogin extends MY_Controller {
    
    public function __construct() {
        parent::__construct();  
		$this->load->model('Userlog_model','userlog');
		$this->load->helper('captcha');
    }


    public function logged_in_check() {
        if ($this->session->userdata("logged_in")) {
            redirect("dashboard");
        }
    }
    
      public function index() {       
        
       		
        $this->logged_in_check();
        $this->load->library('form_validation');
        $this->form_validation->set_rules("username", "Username", "trim|required");
        $this->form_validation->set_rules("password", "Password", "trim|required");
       
        if ($this->form_validation->run() == true) {
            $this->load->model('auth_model', 'auth');
            // check the username & password of user
            $status = $this->auth->validate();
			
            if ($status == @ERR_INVALID_USERNAME) {
             $this->session->set_flashdata("error", "Username is invalid");
            } elseif ($status == @ERR_INVALID_PASSWORD) {
             $this->session->set_flashdata("error", "Password is invalid");
            } else {
                // success
                // store the user data to session
                $this->session->set_userdata($this->auth->get_data());
                $this->session->set_userdata("logged_in", true);
                // redirect to dashboard
                 if($this->session->userdata['role']=='admin'){
                        redirect("dashboard");
                    } 
                    elseif($this->session->userdata['role']=='employee'){
                         $user_data = array(
                    			'created_by' => $this->session->userdata('id'),
                    			'ipaddress'  => $_SERVER['REMOTE_ADDR'],
                		 );
	  
		                $this->userlog->save($user_data);
                        redirect("employee_dashboard");
                        
                    } 
                    elseif($this->session->userdata['role']=='teacher'){
                        $user_data = array(
                    			'created_by' => $this->session->userdata('id'),
                    			'ipaddress'  => $_SERVER['REMOTE_ADDR'],
                		 );
	  
		                $this->userlog->save($user_data);
                        redirect("teacher_dashboard");
                    } 
                    elseif($this->session->userdata['role']=='super_employee'){
                        $user_data = array(
                    			'created_by' => $this->session->userdata('id'),
                    			'ipaddress'  => $_SERVER['REMOTE_ADDR'],
                		 );
	  
		                $this->userlog->save($user_data);
                        redirect("super_dashboard");
                    } 
                    
            }
        }
          $this->load->view("admin/layout/login");

    }

    
    
    public function logout() {
        $this->session->unset_userdata("logged_in");
        $this->session->sess_destroy();
        if ($this->session->userdata['role'] == 'admin') {
            redirect("administrator");
        } elseif ($this->session->userdata['role'] == 'teacher') {
            redirect("administrator");
        }elseif ($this->session->userdata['role'] == 'super_employee') {
            redirect("administrator");
        }elseif ($this->session->userdata['role'] == 'employee') {
            redirect("administrator");
        }
        redirect("administrator");
    }
    
    
      
   

}
