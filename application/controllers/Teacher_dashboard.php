<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Teacher_dashboard extends MY_Controller {

    protected $access = array('admin','teacher');
    private $table = "tbl_user";

    public function __construct() {
        parent::__construct();
        $this->load->model('Dashboard_model', 'dsahboard');
        $this->load->model('School_model', 'school');
        $this->load->model('person_model', 'person');
        $this->load->model('Order_model', 'plan_order');
         $this->load->model('Teacher_ads_model', 'teacher_ads');
         
    }

    


	public function index()
	{
	    $role = $this->session->userdata('role');
        $emp = $this->session->userdata('id');
        $data['title'] = "Teacher Dashboard";
		$data['include'] = 'teacher/dashboard';
		$data['getTeacher'] =  $this->person->get_by_id($emp);
		$data['getSchool'] =  $this->school->get_by_school($emp);
		$data['getPlanSubject'] =  $this->plan_order->check_order_teacher($emp);
		$data['getSchoolAds'] =  $this->teacher_ads->getActiveAds_limit($emp);
		$data['getTodayTeacher'] = $this->plan_order->totalorderTeacherDesc($emp);
        $this->load->view("admin/layout/main", $data);
	}
	
	
	 

	
	
	
}

