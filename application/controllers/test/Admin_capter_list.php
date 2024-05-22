<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Admin_capter_list extends MY_Controller {

    protected $access = array('admin','teacher');
    private $table = "tbl_teacher_capter";

    public function __construct() {
        parent::__construct();
        $this->load->model('Capter_question_model', 'capter_question');
        $this->load->model('Question_model', 'question');
        $this->load->model('Pepar_model', 'pepar');
        $this->load->model('person_model', 'person');
        $this->load->model('Order_model', 'order');
         $this->load->model('Class_model', 'class');
        $this->load->model('Subject_model', 'subject');
    }

    


	public function index()
	{
        $data['title'] = "Capterwise Question";
        
         $data['getClass'] = $this->class->get_active_class();
	    $data['getSubject'] = $this->subject->get_active_subject();
	    //echo $this->db->last_query();die;
        $data['include'] = 'admin/capter_list_report';
        $this->load->view("admin/layout/main", $data);
	}
	
	

	
	
	
	
	 

	
	
	
}

