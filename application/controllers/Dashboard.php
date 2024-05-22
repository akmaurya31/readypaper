<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends MY_Controller {

    protected $access = array("admin");
    private $table = "user";

    public function __construct() {
        parent::__construct();
        $this->load->model('Board_type_model', 'board');
        $this->load->model('person_model', 'person');
         $this->load->model('Plan_model', 'plan');
                  $this->load->model('Contact_model', 'contact');
                  $this->load->model('Order_model', 'order');
                   $this->load->model('Question_model', 'question');
    }


	public function index()
	{
        $data['title'] = "Dashboard";
        $session_id =1;
        
        $data['totalemployee'] = $this->person->totalEmployee();
        $data['totalteacher'] = $this->person->totalTeacher();
        $data['totalsuper_employee'] = $this->person->totalsuper_employee();
        
        $data['getTodayTeacher'] = $this->order->totalorderDesc();
        
        $data['totalQuery'] = $this->contact->totalcontact_query();
        $data['totalPlan'] = $this->plan->totalPlan();
        $data['totalBoard'] = $this->board->totalactiveBoard();
        $data['totalQuestion'] = $this->question->totalactiveQuestion();
		$data['include'] = 'admin/views/dashboard';
        $this->load->view("admin/layout/main", $data);
	}
	
	
	 

	
	
	
}
