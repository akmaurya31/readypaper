<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Teacher_create_pepar extends MY_Controller {

    protected $access = array('admin','teacher');
    private $table = "tbl_plan";

    public function __construct() {
        parent::__construct();
        $this->load->model('plan_model', 'plan');
        $this->load->model('person_model', 'person'); 
        $this->load->model('Subject_model', 'subject'); 
        $this->load->model('Class_model', 'class');
        $this->load->model('Exam_model', 'exam');
        $this->load->model('Group_exam_model', 'group_exam');
        $this->load->model('Pepar_model', 'pepar');
        $this->load->model('Order_model', 'order');
        $this->load->model('Board_type_model', 'board');
         $this->load->model('School_model', 'school');
         $this->load->model('Question_type_model', 'question_type');
         $this->load->model('Class_subject_question_type_model', 'class_subject_question_type');
         $this->load->model('Pepar_question_type_model', 'pepar_question');
         
        
    }
    
 public function index() {
    $empid = $this->session->userdata('id');
    $data['check'] = $this->order->checkPlanTeacherResult($empid);
 if (count($data['check']) > 0) {
            $data['include'] = 'teacher/create_pepar';
            $data['title'] = "Create Pepar";
            $orderId = $data['check'][0]->oid;
            $data['orderId']  = $data['check'][0]->oid;
            $teacherId = $this->order->check_orderTeacherRow($empid);
            $data['getSubjectPlan'] = $this->plan->get_active_subject($teacherId->plan_name);

            
            $data['question_type'] = $this->question_type->get_active_section();
            $data['getPepartype'] = $this->exam->get_active_exam();
            $data['getClass'] = $this->class->get_active_class();
            $data['getBoard'] = $this->board->get_active_board_type();
            $data['getschool'] = $this->school->get_by_school($empid);
            $this->load->view("admin/layout/main", $data);
        } 
     else {
        return redirect('teacher_plan');
    }
}



function Insertpepar() {
    $orderId = $this->input->post('orderId');
    $paperData = [
        'class_id' => $this->input->post('class_id'),
        'board_id' => $this->input->post('board_id'),
        'subject_id' => $this->input->post('subject_id'),
        'exam_id' => $this->input->post('exam_id'),
        'group_exam_id' => $this->input->post('group_exam_id'),
        'exam_name' => $this->input->post('exam_name'),
        'school_id' => $this->input->post('school_id'),
        'teacher_id' => $this->session->userdata('id'),
        'order_id' => $orderId,
        'instruction_id' => $this->input->post('instruction_id'),
    ];

    // Save paper data
    $paperId = $this->pepar->save($paperData);

    if ($paperId) {
        $question_checkIDs = $this->input->post('question_check_id');
       // if($question_checkIDs){
        foreach ($question_checkIDs as $checkID) {
            $questionType = $this->input->post("question_type_$checkID");
            if (!empty($questionType)) {
                $insertedQuestionData = [
                    'create_pepar_id' => $paperId,
                    'question_mark' => $questionType[0], 
                    'check_question_id' => $checkID,
                    'created_by' => $this->session->userdata('id'),
                ];
                $this->pepar_question->save($insertedQuestionData);
            }
        }
        //}
        // Update order quantity
        $countQty = $this->order->get_change_OredrId($orderId);
        $update = [
            'qty_less_plan' => $countQty->qty_less_plan - 1,
        ];
        $this->order->update(['id' => $orderId], $update);
       echo json_encode(base64_encode($paperId));
    }
}




function getQuestionType() {
    $subid = $this->input->post('subid');
    $class_id = $this->input->post('classid');
    $subjectTypes = $this->class_subject_question_type->get_class_subject_section($class_id,$subid);?>
   <h4>Categories:-</h4>
<?php foreach ($subjectTypes as $val) { ?>
    <div class="form-check col-sm-4">
        <label class="form-check-label">
            <input type="checkbox" class="form-check-input" name="question_check_id[]" value="<?= $val->question_type_id ?>" onclick="showInput(this)">
            <?= question_typeName($val->question_type_id) ?>
            <input type="text" class="form-control- question-type-input"  name="question_type_<?= $val->question_type_id ?>[]"  style="width: 24%; display: none;">
        </label>
      <span class="text-danger errormark" style="display: none;"></span>
 
    </div>
<?php }
}


    
    
 public function edit_pepar() {
    $pepar_id =  base64_decode($_GET['pepar_id']);
    $empid = $this->session->userdata('id');
    $data['title'] = "Edit Create Pepar";
    
    $data['fatchpRecord'] = $this->pepar->get_by_id($pepar_id);
    $class_id = $data['fatchpRecord']->class_id;
    $subid = $data['fatchpRecord']->subject_id;
    $data['question_type'] = $this->class_subject_question_type->get_class_subject_section($class_id,$subid);
    //echo $this->db->last_query();die;
    
    $teacherId = $this->order->check_orderTeacherRow($empid);
    $data['getSubjectPlan'] = $this->plan->get_active_subject($teacherId->plan_name);
    
    $data['getPepartype'] = $this->exam->get_active_exam();
    $data['getClass'] = $this->class->get_active_class();
    $data['getBoard'] = $this->board->get_active_board_type();
    $data['getschool'] = $this->school->get_by_school($empid);
    
    $data['pepar_question'] = $this->pepar_question->get_by_pepar_id($pepar_id);
     
    $data['include'] = 'teacher/edit_create_pepar';
    $this->load->view("admin/layout/main", $data);
  
}




    public function editQuestion_typePepar(){
      $paperId =$this->input->post('paperId');
        $update = [
            'instruction_id' => $this->input->post('instruction_id'),
        ];
        $resUpdate = $this->pepar->update(['id' => $paperId], $update);
      //if($resUpdate){
      $deletePeparId = $this->pepar_question->delete_by_pepar_id($paperId);
        
      
        $question_checkIDs = $this->input->post('question_check_id');
        foreach ($question_checkIDs as $checkID) {
            $questionType = $this->input->post("question_type_$checkID");
            if (!empty($questionType)) {
                $insertedQuestionData = [
                    'create_pepar_id' => $paperId,
                    'question_mark' => $questionType[0], 
                    'check_question_id' => $checkID,
                    'created_by' => $this->session->userdata('id'),
                ];
                $this->pepar_question->save($insertedQuestionData);
            }
        }
        echo json_encode(base64_encode($paperId));
        //echo base64_encode($paperId);
      //}
    }
    

    
      public function exam_list() {
            $empid = $this->session->userdata('id');
            $check = $this->order->checkPlanTeacher($empid);
            $qty = subject_QTY_teacher($check->id) ?? 0;
            if($check){
           
           $date = date('Y-m-d');
            $data['include'] = 'teacher/pepar_exam_list';
    		$data['title'] = "Exam List"; 
    		$id = $this->session->userdata('id');
    		$data['getTeacherExam_list'] = $this->pepar->get_active_exam_teacher($id);
    		//echo $this->db->last_query();die;
    		$this->load->view("admin/layout/main", $data);
            }else{
               return redirect('teacher_plan'); 
            }
    }
    
    public function getGroupExam() {
         $exam = $this->input->post('id');
         $res = $this->group_exam->get_active_exam($exam);
         foreach($res as $val){?>
             <option value="<?= $val->id?>"><?= $val->group_exam_name?></option>
         <?php }
     }
    
    


  

}
