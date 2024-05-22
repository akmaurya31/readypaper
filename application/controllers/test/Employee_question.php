<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Employee_question extends MY_Controller
{

    protected $access = array('super_employee');
    private $table = "tbl_question";

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Question_model', 'question');
        $this->load->model('Class_model', 'class');
        $this->load->model('Subject_model', 'subject');
        $this->load->model('Board_type_model', 'board');
        $this->load->model('Class_subject_model', 'class_subject');
        $this->load->model('Correct_answer_model', 'correct_answer');
        $this->load->model('Chapter_model', 'chapter');
        $this->load->model('Employee_subject_model', 'employee_subject');
        $this->load->model('person_model', 'person');
         $this->load->model('Question_type_model', 'question_type');
         $this->load->model('Exercise_model', 'exercise');
         $this->load->model('School_model', 'school');
    }
    

    
    public function index() {
        $data['include'] = 'admin/employee_question';
		$data['title'] = "Employee Question";
	
		$class = @$this->input->get('class');
		$subject = @$this->input->get('subject');
		
		 $classsubid = $this->class_subject->get_class_subject($class,$subject);
	
		 $class_sub_id = @$classsubid->id;
	    $qtype = @$this->input->get('qtype');
	   
	    $data['getChapter'] = $this->chapter->get_active_class_subject($class_sub_id);
	   	  //echo $this->db->last_query();
	    $data['getClass'] = $this->class->get_active_class();
	    $data['getSubject'] = $this->subject->get_active_subject();
	    if($class_sub_id){
		$data['getQuestion_list'] = $this->question->get_by_question_subject_chapter($qtype,$class_sub_id);
		//echo $this->db->last_query();
	    }
		
        $this->load->view("admin/layout/main", $data);
    }
    
    
   function getstatusUpdate(){
       $question_id = $this->input->post('id');
       $data = array(
            "status" => 'Y'
        );
        
       $this->question->update(array('id' => $question_id), $data);
       //echo $this->db->last_query();die;
        echo 1;
}
    
}
