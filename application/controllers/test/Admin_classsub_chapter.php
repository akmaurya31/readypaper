<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Admin_classsub_chapter extends MY_Controller {

    protected $access = array('admin','employee','super_employee','teacher');
    private $table = "tbl_class_subject";

    public function __construct() {
        parent::__construct();
        $this->load->model('Class_model', 'class');
        $this->load->model('subject_model', 'subject');
        $this->load->model('board_type_model', 'board_type');        
        $this->load->model('person_model', 'person');
        $this->load->model('class_subject_model', 'class_subject');
    }

    public function index() {
        $data['include'] = 'admin/class_subject/class_subject_chapter';
		$data['title'] = "Chapter Subjects";    
        $data['getSubject'] = $this->subject->get_active_subject(); 
        $data['getboard_type'] = $this->board_type->get_active_board_type();  
        $data['getClass'] = $this->class->get_active_class(); 
        
        $class = @$_GET['class'];
        $subject = @$_GET['subject'];
        
        $data['getClass_Subject'] = $this->class_subject->get_by_questionList($class,$subject);
        //echo $this->db->last_query();die;
        
        $this->load->view("admin/layout/main", $data);
        
    }

  
   /* public function ajax_list() {
        $role= $this->session->userdata('role');       
        $id= $this->session->userdata('id');       
        $this->load->helper('url');
        
           $list = $this->class_subject->get_datatables($role,$id);
        //echo $this->db->last_query();die;
        
        $data = array();
        $no = $_POST['start'];
        $i=1;
         foreach ($list as $class_subject) {
            $status = isset($class_subject->status) && $class_subject->status == 'Y' ? 'N' : 'Y';
            $no++;
            $row = array();            
            $row[] = $i; 
            $boardName=   $this->board_type->get_by_id($class_subject->board_id);
            $className=   $this->class->get_by_id($class_subject->class_id);
            $subjectName=   $this->subject->get_by_id($class_subject->subject_id);
            
            
           if ($class_subject->status == 'Y')
            $statusIs = '<a href="javascript:void(0)" class="btn btn-success " title="Status Active" id="' . $class_subject->id . '" onclick="statusUpdate(' . "'" . $class_subject->id . "'" . "," . "'" . $status . "'" . ')"> <i class="fa fa-info-circle"></i></a>';
        else
            $statusIs = '<a href="javascript:void(0)" class="btn btn-warning " title="Status Inactive" id="' . $class_subject->id . '" onclick="statusUpdate(' . "'" . $class_subject->id . "'" . "," . "'" . $status . "'" . ')"> <i class="fa fa-exclamation-triangle"></i></a>';
            $row[] = '' . $statusIs . ' <a href="admin_chapter?clas_sub_id='.$class_subject->id.'" class="btn btn-warning" title="Add chapter"> <i class="fa fa-plus"></i></a> '; 
            
             $row[] = @$boardName->board_type_name;            
            $row[] = @$className->class_name; 
            
              $subjectStyles = [
                                1 => '#ff0000',
                                3 => '#c3989f',
                                4 => '#145650',
                                5 => '#129d9b',
                                12 => '#422dc6',
                                13 => '#814435',
                                14 => '#4e6e4e',
                                16 => '#f72b50',
                                17 => '#607d8b',
                                18 => '#795548',
                                23 => '#ffc107',
                                24 => '#2196f3',
                                25 => '#673ab7',
                                26 => '#6e6e6e',
                                27 => '#ffa755',
                                28 => '#68e365',
                                29 => '#145650',
                                30 => '#0a0ae7',
                                31 => '#d653c1',
                            ];

            $color = isset($subjectStyles[$class_subject->subject_id]) ? $subjectStyles[$class_subject->subject_id] : 'text-primary';
            $row[] = '<a href="javascript:;" style="color:' . $color . '">' . @$subjectName->subject_name . '</a>';
            $row[] = date('d/M/Y', strtotime($class_subject->created_at));
            $data[] = $row;
            $i++;
            
        }
        
 $output = array(
            "draw" => $_POST['draw'],
            //"recordsTotal" => $this->class_subject->count_all($role,$id),
            "recordsFiltered" => $this->class_subject->count_filtered($role,$id),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }*/


    public function class_subject_add() {
         $data['getSubject'] = $this->subject->get_active_subject(); 
        $data['getboard_type'] = $this->board_type->get_active_board_type();  
        $data['getClass'] = $this->class->get_active_class(); 
        
		$data['title'] = "Class & Subject Mapping"; 
        if ($this->form_validation->run('subjectmap')) {
            
        $count = count($this->input->post('subject_id'));
         
          $subjectid = $this->input->post('subject_id');
        $insert_data = array();
        for ($i = 0; $i < $count; $i++) {
             $insert_data[] = array(
            'class_id' => $this->input->post('class_id'),
            'subject_id' => $subjectid[$i],
            'created_by' => $this->session->userdata('id'),
            );
        }
        //print_r($insert_data);  die;
        $this->db->insert_batch('tbl_class_subject', $insert_data); 
        //$this->class_subject->insert_batch($insert_data);
       
        $this->session->set_flashdata('mass', 'class & Subject Inserted Successfully!');
                return redirect('admin_class_subject');
        }
        $data['include'] = 'admin/class_subject/add_class_subject';
        $this->load->view("admin/layout/main", $data);
    }

  
  
public function statusUpdate_clSub() {
   
        $data = array(
            "id" => $this->input->post('id'),
            "status" => $this->input->post('status')
        );
        //print_r($data);die;
        $returnData = $this->commonStatusUpdate($this->table, $data);
        echo 1; //json_encode($returnData);
        
    
}

   

}
