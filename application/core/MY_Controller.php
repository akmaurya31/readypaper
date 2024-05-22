<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class MY_Controller extends CI_Controller {
    protected $access = "*";

    public function __construct() {
        parent::__construct();
        $this->login_check();
        $this->load->model('Common_model', 'common');
    }

    public function login_check() {
        if ($this->access != "*") {          
            if (!$this->permission_check()) {
                if(isset($this->session->userdata['role'])){
                    if($this->session->userdata['role']=='admin'){
                        redirect("administrator");
                    }elseif($this->session->userdata['role']=='teacher'){
                        redirect("teacher_dashboard");
                    }elseif($this->session->userdata['role']=='employee'){
                        redirect("employee_dashboard");
                    }elseif($this->session->userdata['role']=='super_employee'){
                        redirect("super_employee_dashboard");
                    }else{
                        redirect("AdminLogin/logout");
                    }                    
                } 
            }
           
            if (!$this->session->userdata("logged_in")) {
                redirect("administrator");             
            }
        }
    }

    public function permission_check() {
        if ($this->access == "@") {
            return true;
        } else {
            $access = is_array($this->access) ?
                    $this->access :
                    explode(",", $this->access);
            if (in_array($this->session->userdata("role"), array_map("trim", $access))) {
                return true;
            }
            return false;
        }
    }
    
    public function commonStatusUpdate($table,$data){
      return $this->common->statusUpdate($table,$data);
    }
    
    public function commonDelete($table,$id){
        return $this->common->Delete($table,$id);
    }

}
