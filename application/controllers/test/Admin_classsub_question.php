<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Admin_classsub_question extends MY_Controller {

    protected $access = array('admin','teacher');
    private $table = "tbl_plan";

    public function __construct() {
        parent::__construct();
        $this->load->model('Class_model', 'class');
        $this->load->model('subject_model', 'subject');
        $this->load->model('board_type_model', 'board_type');        
        $this->load->model('person_model', 'person');
        $this->load->model('Plan_teacher_model', 'plan');
    }

    public function index() {
    $empId = $this->session->userdata('id');
    $check = checkPlanTeacher($empId);
    $date = date('Y-m-d');
    if ($check->end_date >= $date) {
        $data['include'] = 'admin/classsub_question';
		$data['title'] = "Subjects ";    
        $data['getSubject'] = $this->subject->get_active_subject(); 
        $data['getboard_type'] = $this->board_type->get_active_board_type();  
        $data['getClass'] = $this->class->get_active_class(); 
        $this->load->view("admin/layout/main", $data);
    }else{
           return redirect('teacher_plan'); 
        }
    }

  
    public function ajax_list() {
        $role= $this->session->userdata('role');       
        $id= $this->session->userdata('id');       
        $this->load->helper('url');
        $list = $this->plan->get_datatables($role,$id);
        
        $data = array();
        $no = $_POST['start'];
        $i=1;
         foreach ($list as $plan) {
            $status = isset($plan->status) && $plan->status == 'Y' ? 'N' : 'Y';
            $no++;
            $row = array();            
            $row[] = $i; 
            $subjectName=   $this->subject->get_by_id($plan->subject_id);
            
            $row[] = '<a href="admin_chapter?clas_sub_id='.$plan->id.'" class="btn btn-warning" title="Add chapter"> <i class="fa fa-plus"></i></a> '; 
            
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

            $color = isset($subjectStyles[$plan->subject_id]) ? $subjectStyles[$plan->subject_id] : 'text-primary';
            $row[] = '<a href="javascript:;" style="color:' . $color . '">' . @$subjectName->subject_name . '</a>';
            $row[] = date('d/M/Y', strtotime($plan->created_date));
            $data[] = $row;
            $i++;
            
        }
        
 $output = array(
            "draw" => $_POST['draw'],
            //"recordsTotal" => $this->plan->count_all($role,$id),
            "recordsFiltered" => $this->plan->count_filtered($role,$id),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }



   

}
