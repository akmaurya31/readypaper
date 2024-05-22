<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Teacher_plan extends MY_Controller {

    protected $access = array('admin','teacher');
    private $table = "tbl_plan";

    public function __construct() {
        parent::__construct();
        $this->load->model('plan_model', 'plan');
        $this->load->model('person_model', 'person'); 
        $this->load->model('Subject_model', 'subject'); 
        $this->load->model('Order_model', 'order'); 
        
    }

    public function index() {
        $data['include'] = 'teacher/teacher_plan';
		$data['title'] = "Service Plan"; 
		$date = date('Y-m-d');
		$data['getPlan'] = $this->plan->getActivePlan_Date($date);
		//echo $this->db->last_query();die;
        $this->load->view("admin/layout/main", $data);
        
    }
    
   
    
    




  

}
