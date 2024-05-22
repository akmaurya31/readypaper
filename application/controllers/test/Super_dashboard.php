<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Super_dashboard extends MY_Controller {

    protected $access = array('admin','super_employee');
    private $table = "tbl_user";

    public function __construct() {
        parent::__construct();
        $this->load->model('Employee_model', 'dsahboard');
    }

    


	public function index()
	{
        $data['title'] = "Super Employee Dashboard";
		$data['include'] = 'super_employee/dashboard';
        $this->load->view("admin/layout/main", $data);
	}
	
	
	 

	
	
	
}

