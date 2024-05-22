<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Admin_class_subject_question_type extends MY_Controller {

    protected $access = array('admin','employee');
    private $table = "tbl_class_subject";

    public function __construct() {
        parent::__construct();
        $this->load->model('Class_model', 'class');
        $this->load->model('subject_model', 'subject');
        $this->load->model('Question_type_model', 'question_type');
        $this->load->model('board_type_model', 'board_type');        
        $this->load->model('person_model', 'person');
        $this->load->model('class_subject_question_type_model', 'class_subject_question_type');
    }

    public function index() {
        $data['include'] = 'admin/class_subject/class_subject_question_type';
		$data['title'] = "Class Subject Question Type Mapping"; 
		
		$data['getClass'] = $this->class->get_active_class(); 
        $data['getSubject'] = $this->subject->get_active_subject(); 
        $data['getQuestion_type'] = $this->question_type->get_active_section();  
        
        $this->load->view("admin/layout/main", $data);
        
    }

  
    public function ajax_list() {
        $role= $this->session->userdata('role');       
        $id= $this->session->userdata('id');       
        $this->load->helper('url');
        $list = $this->class_subject_question_type->get_datatables($role,$id);
    //echo $this->db->last_query();die;
        $data = array();
        $no = $_POST['start'];
        $i=1;
        foreach ($list as $class_subject) {
            $status = isset($class_subject->status) && $class_subject->status == 'Y' ? 'N' : 'Y';
            $no++;
            $row = array();            
            $row[] = $i; 
            $QuestionTypeName=   $this->question_type->get_by_id($class_subject->question_type_id);
            $className=   $this->class->get_by_id($class_subject->class_id);
            $subjectName=   $this->subject->get_by_id($class_subject->subject_id);
           
           if ($class_subject->status == 'Y')
            $statusIs = '<a href="javascript:void(0)" class="btn btn-success " title="Status Active" id="' . $class_subject->id . '" onclick="statusUpdate(' . "'" . $class_subject->id . "'" . "," . "'" . $status . "'" . ')"> <i class="fa fa-info-circle"></i></a>';
        else
            $statusIs = '<a href="javascript:void(0)" class="btn btn-warning " title="Status Inactive" id="' . $class_subject->id . '" onclick="statusUpdate(' . "'" . $class_subject->id . "'" . "," . "'" . $status . "'" . ')"> <i class="fa fa-exclamation-triangle"></i></a>';
            $row[] = $statusIs; 
                       
            $row[] = @$className->class_name; 
            
              if($class_subject->subject_id==1){
                 $row[] = '<a href="javascript:;" style="color:#ff0000">'.@$subjectName->subject_name.'</a>'; 
            }elseif($class_subject->subject_id==3){
                 $row[] = '<a href="javascript:;" style="color:#c3989f">'.@$subjectName->subject_name.'</a>'; 
            }elseif($class_subject->subject_id==4){
                 $row[] = '<a href="javascript:;" style="color:#145650">'.$subjectName->subject_name.'</a>'; 
            }elseif($class_subject->subject_id==5){
                 $row[] = '<a href="javascript:;" style="color:#129d9b">'.$subjectName->subject_name.'</a>'; 
            }elseif($class_subject->subject_id==12){
                 $row[] = '<a href="javascript:;" style="color:#422dc6">'.$subjectName->subject_name.'</a>'; 
            }elseif($class_subject->subject_id==13){
                 $row[] = '<a href="javascript:;" style="color:#814435">'.$subjectName->subject_name.'</a>'; 
            }elseif($class_subject->subject_id==14){
                 $row[] = '<a href="javascript:;" style="color:#4e6e4e">'.$subjectName->subject_name.'</a>'; 
            }elseif($class_subject->subject_id==16){
                 $row[] = '<a href="javascript:;" style="color:#f72b50">'.$subjectName->subject_name.'</a>'; 
            }elseif($class_subject->subject_id==17){
                 $row[] = '<a href="javascript:;" style="color:#607d8b">'.$subjectName->subject_name.'</a>'; 
            }elseif($class_subject->subject_id==18){
                 $row[] = '<a href="javascript:;" style="color:#795548">'.$subjectName->subject_name.'</a>'; 
            }elseif($class_subject->subject_id==23){
                 $row[] = '<a href="javascript:;" style="color:#ffc107">'.$subjectName->subject_name.'</a>'; 
            }elseif($class_subject->subject_id==24){
                 $row[] = '<a href="javascript:;" style="color:#2196f3">'.$subjectName->subject_name.'</a>'; 
            }elseif($class_subject->subject_id==25){
                 $row[] = '<a href="javascript:;" style="color:#673ab7">'.$subjectName->subject_name.'</a>'; 
            }elseif($class_subject->subject_id==26){
                 $row[] = '<a href="javascript:;" style="color:#6e6e6e">'.$subjectName->subject_name.'</a>'; 
            }elseif($class_subject->subject_id==27){
                 $row[] = '<a href="javascript:;" style="color:#ffa755">'.$subjectName->subject_name.'</a>'; 
            }elseif($class_subject->subject_id==28){
                 $row[] = '<a href="javascript:;" style="color:#68e365">'.$subjectName->subject_name.'</a>'; 
            }elseif($class_subject->subject_id==29){
                 $row[] = '<a href="javascript:;" style="color:#145650">'.$subjectName->subject_name.'</a>'; 
            }elseif($class_subject->subject_id==30){
                 $row[] = '<a href="javascript:;" style="color:#0a0ae7">'.$subjectName->subject_name.'</a>'; 
            }elseif($class_subject->subject_id==31){
                 $row[] = '<a href="javascript:;" style="color:#d653c1">'.$subjectName->subject_name.'</a>'; 
            }else{
                 $row[] = '<a href="javascript:;" class="text-primary">'.$subjectName->subject_name.'</a>'; 
            }
                
            $row[] = @$QuestionTypeName->question_type_name; 
            $row[] = date('d/M/Y', strtotime($class_subject->created_at));
            $data[] = $row;
            $i++;
        }
 $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->class_subject_question_type->count_all($role,$id),
            "recordsFiltered" => $this->class_subject_question_type->count_filtered($role,$id),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }


    public function class_subject_add() {
        $data['getSubject'] = $this->subject->get_active_subject(); 
        $data['getClass'] = $this->class->get_active_class(); 
        $data['getQuestion_type'] = $this->question_type->get_active_section();  
        
		$data['title'] = "Class  Subject Question Type Mapping"; 
        if ($this->form_validation->run('subjectmap')) {
            
     $class_ids = $this->input->post('class_id');
    $subject_id = $this->input->post('subject_id');
    $question_type_ids = $this->input->post('question_type_id');

    $insert_data = [];
    foreach ($class_ids as $class_id) {
        foreach ($question_type_ids as $question_type_id) {
            $insert_data[] = array(
                'class_id' => $class_id,
                'subject_id' => $this->input->post('subject_id'),
                'question_type_id' => $question_type_id,
                'created_by' => $this->session->userdata('id'),
            );
        }
    }

    //echo "<pre>"; print_r($insert_data);die;
        $this->db->insert_batch('tbl_class_subject_question_type', $insert_data); 
        $this->session->set_flashdata('mass', 'class & Subject Inserted Successfully!');
                return redirect('admin_class_subject_question_type');
        }
        
        $data['include'] = 'admin/class_subject/add_class_subject_question_type';
        $this->load->view("admin/layout/main", $data);
    }


  
  
#########################################################
# active status and delete method is extended by My  
# controller which is call common model method
###########################################################

  
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
