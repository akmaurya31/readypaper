<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Employee_dashboard extends MY_Controller {

    protected $access = array('admin','employee');
    private $table = "tbl_user";

    public function __construct() {
        parent::__construct();
        $this->load->model('Employee_model', 'dsahboard');
    }

    


	public function index()
	{
        $data['title'] = "Employee Dashboard";
		$data['include'] = 'employee/dashboard';
        $this->load->view("admin/layout/main", $data);
	}
	
	
	 

	
	
	
}

