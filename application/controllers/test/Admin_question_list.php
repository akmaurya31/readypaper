<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Admin_question_list extends MY_Controller
{

    protected $access = array('admin');
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
        $data['include'] = 'admin/all_question';
		$data['title'] = "All Question";
		$qstatus = @$this->input->get('qstatus');
		$qtype = @$this->input->get('qtype');
		$starting_date = @$this->input->get('starting_date');
		$ending_date = @$this->input->get('ending_date');
		$class = @$this->input->get('class');
		$subject = @$this->input->get('subject');
		
		 $classsubid = $this->class_subject->get_class_subject($class,$subject);
		 $class_sub_id = @$classsubid->id;
	    
	    $data['getType'] = $this->question_type->get_active_section();
	    $data['getEmployee'] = $this->person->get_by_role();
	    $data['getClass'] = $this->class->get_active_class();
	    $data['getSubject'] = $this->subject->get_active_subject();
	    if($class_sub_id){
		$data['getQuestion_list'] = $this->question->get_by_questionList($qstatus,$qtype,$starting_date,$ending_date,$class_sub_id);
	    }
		
        $this->load->view("admin/layout/main", $data);
    }
    
    
    
       
    public function question_daliywise() {
        $data['include'] = 'admin/daliywise_question';
		$data['title'] = "Daliy wise Question";
		$qstatus = @$this->input->get('qstatus');
		$starting_date = @date('Y-m-d');
	    $data['getEmployee'] = $this->person->get_by_role();
		$data['getQuestion_list'] = $this->question->get_by_question_daliywise($qstatus,$starting_date);
        $this->load->view("admin/layout/main", $data);
    }
    
    
    
    
     public function question_subject_chapter() {
        $data['include'] = 'admin/question_subject_chapter';
		$data['title'] = "All Subjects & Chapter Question";
	
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
    

    
}
