<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Count_question_report extends MY_Controller {
    
    protected $access = array('admin','employee','super_employee');
    private $table = "";
     
    public function __construct() {
        parent::__construct();
        $this->load->model('Count_question_model', 'question');
         $this->load->model('person_model', 'person');
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
    }

    public function index() {
        $data['title'] = "Employee Question";
        $data['include'] = 'admin/question_report';
        $role = $this->session->userdata('role');
        $id = $this->session->userdata('id');
        $data['getdepartments'] =$this->person->get_active_teacher($role,$id);
        $this->load->view("admin/layout/main", $data);
    }
    
      public function ajax_list() {
   
        $id= $_GET['emp'];
        $dates= $_GET['dates'];
        $days= $_GET['days'];
        $date_days = $dates.'-'.$days;
        $role= $this->session->userdata('role');
        $chapter_id= $this->input->get('chapter_id');
        $clas_sub_id = $this->input->get('clas_sub_id');
        
        $this->load->helper('url');
        $list = $this->question->get_datatables($role,$id,$date_days);
        //echo $this->db->last_query();die;
        $data = array();
        $no = $_POST['start'];
        $i=1;
        foreach ($list as $question) {
            $status = isset($question->status) && $question->status == 'Y' ? 'N' : 'Y';
            $no++;
            $row = array();            
            $row[] = $i; 
            $adminName=   $this->person->get_by_id($question->created_by);
            $chapterName=   $this->chapter->get_by_id($question->chapter);
            $currect_ansName=   $this->correct_answer->get_by_id($question->currect_ans);
            $currect_2Name=   $this->correct_answer->get_by_id($question->currect_ans2);
            
            
                
              $row[] = @$adminName->firstName.'('.@$adminName->role.')<br>';          
          $row[] = $question->created_at;
              $row[] = @$chapterName->chapter_name; 
              
              if($question->question_type==5){
                  $row[] = $question->question_name.' (a) '.$question->answer1.'  (b) '.$question->answer2.' (c) '.$question->answer3.' (d)'.$question->answer4 ;
              
                
              }else{
                  $row[] =   $question->question_name;
              }
              $row[] = @$currect_ansName->correct_answer.' / '.@$currect_2Name->correct_answer;
              $row[] = $question->description_answer;
              
            $data[] = $row;
            $i++;
        }
 $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->question->count_all($role,$id,$date_days),
            "recordsFiltered" => $this->question->count_filtered($role,$id,$date_days),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }
    
   
}
