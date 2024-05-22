<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Question_own_teacher extends MY_Controller
{

    protected $access = array('admin','super_employee');
    private $table = "tbl_question_own_teacher";

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Question_own_teacher_model', 'question');
        $this->load->model('Question_model', 'question_main');
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
         $this->load->model('Pepar_model', 'pepar');
    }
    
    
     public function index()
    {
        $data['title'] = "Teacher Question";
        $data['include'] = 'admin/question_own_teacher';
        
        $this->load->view("admin/layout/main", $data);
    }
    
    
      public function ajax_list() {
       
        $this->load->helper('url');
        $list = $this->question->get_datatables();
        $data = array();
        $no = $_POST['start'];
        $i=1;
        foreach ($list as $question) {
            $status = isset($question->status) && $question->status == 'Y' ? 'N' : 'Y';
            $no++;
            $row = array();            
            $row[] = $i; 
            $adminName=   $this->person->get_by_id($question->created_by);
            $class_SubjectName=   $this->pepar->get_by_id($question->pepar_id);
            $class_Name=   $this->class->get_by_id(@$class_SubjectName->class_id);
            $SubjectName=   $this->subject->get_by_id(@$class_SubjectName->subject_id);
             $classSubjectId=   $this->class_subject->get_class_subject(@$class_SubjectName->class_id,@$class_SubjectName->subject_id);
            
            $currect_ansName=   $this->correct_answer->get_by_id($question->currect_ans);
            $currect_2Name=   $this->correct_answer->get_by_id($question->currect_ans2);
            
             if ($question->status == 'Y')
              $row[] = '<button  class="btn btn-success " title="Status Inactive" id="' . $question->id . '"> <i class="fa fa-exclamation-circle"></i></button>';
             
              else
             $row[] = '<a href="javascript:void(0)" class="btn btn-warning " title="Status Inactive" id="' . $question->id . '" onclick="addQuestion(' . $question->id .',' .@$class_SubjectName->class_id.',' .@$class_SubjectName->subject_id.','.@$classSubjectId->id.')"> <i class="fa fa-exclamation-triangle"></i></a>'; 
               
                
              $row[] = @$adminName->firstName; 
               $row[] = @$class_Name->class_name.' / '.@$SubjectName->subject_name;
              if($question->question_type==5){
                  $row[] = $question->question_name.'<span> (a)'.$question->answer1.' </span> <br><span>(b)'.$question->answer2.' </span> <br><span>(c)'.$question->answer3.' </span><br> <span>(d)'.$question->answer4.'</span>' ;
              
                
              }else{
                  $row[] =   $question->question_name;
              }
              $row[] = @$currect_ansName->correct_answer.' / '.@$currect_2Name->correct_answer;
              $row[] = $question->description_answer;
              $row[] = date('d-M-Y', strtotime($question->created_at));
            $data[] = $row;
            $i++;
        }
           $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->question->count_all(),
            "recordsFiltered" => $this->question->count_filtered(),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }

    

public function showChapter(){
     $id =  $this->input->post('question_own_teacher_id');
     $classId =  $this->input->post('classId');
     $subjectid =  $this->input->post('subjectid');
     $class_sub = $this->class_subject->get_class_subject($classId,$subjectid);
    
     //echo $list->id;
      $list = $this->chapter->get_active_class_subject($class_sub->id);
       //echo $this->db->last_query();
      foreach($list as $value){?>
         <option value="<?= $value->chapter_type?>"><?= $value->chapter_name?></option>
    <?php  }
}

  public function getInsert() {
       $id = $this->input->post('id');
       $question = $this->question->get_by_id($id);
       //echo $this->db->last_query();die;
        $data = array(            
                'question_name' => $question->question_name,
                'answer1' => $question->answer1,
                'answer2' => $question->answer2,
                'answer3' => $question->answer3,
                'answer4' => $question->answer4,
                'currect_ans' => $question->currect_ans,
                'description_answer' => $question->description_answer,
                'status' => 'Y',
                'question_type' => $question->question_type,
                'class_sub_id' => $this->input->post('class_sub_id'),
                'chapter' => $this->input->post('chapter_name_id'),
                'created_by' => $this->session->userdata('id'),
        );
        $insert = $this->question_main->save($data);
        if($insert){
             $update = array(
            'status' => 'Y',
        );
        $this->question->update(array('id' => $this->input->post('id')), $update);
          echo 1;
        }
     
    }

    
 

public function activeInactivestatusUpdate() {
    if ($this->input->is_ajax_request()) {
        $data = array(
            "id" => $this->input->post('id'),
            "status" => $this->input->post('status')
        );
        //print_r($data);die;
        $returnData = $this->commonStatusUpdate($this->table, $data);
        echo json_encode($returnData);
        } else {
        $returnData = array('No direct script access allowed');
        echo json_encode($returnData);
    }
}

    
}
