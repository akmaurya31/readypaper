<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Admin_employee_subject extends MY_Controller {

    protected $access = array('admin');
    private $table = "tbl_employee_subject";

    public function __construct() {
        parent::__construct();
        $this->load->model('subject_model', 'subject');
        $this->load->model('person_model', 'person');
        $this->load->model('Employee_model', 'employee');
       $this->load->model('Class_model', 'class'); 
       $this->load->model('Employee_subject_model', 'employee_subject');
        $this->load->model('class_subject_model', 'class_subject');
        $this->load->model('Board_type_model', 'section');
    }

    public function index() {
        $data['include'] = 'admin/employee_subject/employee_subject';
		$data['title'] = "Assign Employee Subject "; 
		 $data['getSubject'] = $this->subject->get_active_subject(); 
		 $data['getemployees'] = $this->employee->get_active_super_employee(); 
		 $data['getClass'] = $this->class->get_active_class(); 
        $this->load->view("admin/layout/main", $data);
        
    }

  
    public function ajax_list() {
        $role= $this->session->userdata('role');
        $id= $this->session->userdata('id');
        $this->load->helper('url');
        $list = $this->employee_subject->get_datatables($role,$id);
        $data = array();
        $no = $_POST['start'];
        $i=1;
        foreach ($list as $subject) {
            $status = isset($subject->status) && $subject->status == 'Y' ? 'N' : 'Y';
            $no++;
            $row = array(); 
             if($subject->role=='employee'){
                $role='Employee';
            }else if($subject->role=='super_employee'){
                 $role='Super Employee';
            }else{
                $role=$subject->role;
            }
            $row[] = $i; 
            $adminName=   $this->person->get_by_id($subject->created_by);   
            $employeeName =   $this->employee->get_by_id($subject->employee_id);
            $empGroupName =   $this->employee_subject->active_subject_employee($subject->employee_id);
            
            $empid = '';
            foreach($empGroupName as $val){
                $subjecName=   $this->subject->get_by_id($val->subject_id);
                $empid.= $subjecName->subject_name.',';
            }
            $row[] = @$employeeName->firstName.'('.ucwords($role).')'.' <a href="javascript:void(0)" class="text-primary" title="Delete subject" onclick="deletesubject(' . "'" . $subject->employee_id . "'" . ')"><i class="fa fa-trash"></i></a>'; 
            $row[] = @$empid;
            $row[] = date('d M Y', strtotime($subject->created_at));
            
            

            $data[] = $row;
            $i++;
        }
 $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->employee_subject->count_all($role,$id),
            "recordsFiltered" => $this->employee_subject->count_filtered($role,$id),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }
    
    
   public function employee_subject_add() {
        $classid = $this->input->get('classid');
        //$data['getSubject'] = $this->class_subject->get_active_class_id($classid);
        $data['getSubject'] = $this->subject->get_active_subject();
        $data['getClass'] = $this->class->get_active_class(); 
        $data['getemployees'] = $this->employee->get_active_super_employee();
        
		$data['title'] = "Assign employee Subject "; 
        if ($this->form_validation->run('subjectmap')) {
            
        $count = count($this->input->post('subject_id'));
          $subjectid = $this->input->post('subject_id');
           $role = $this->employee->get_by_id($this->input->post('employee_id'));
         
        $insert_data = array();
        for ($i = 0; $i < $count; $i++) {
             $insert_data[] = array(
                'subject_id' => $subjectid[$i],
                'employee_id' => $this->input->post('employee_id'), 
                'role' => $role->role, 
                'created_by' => $this->session->userdata('id'),
            );
        }
        $this->db->insert_batch('tbl_employee_subject', $insert_data); 
        
        $this->session->set_flashdata('mass', 'employee & Subject Inserted Successfully!');
                return redirect('admin_employee_subject');
        }
        
        $data['include'] = 'admin/employee_subject/add_employee_subject';
        $this->load->view("admin/layout/main", $data);
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


public function deletesubject() {
    $empid = $this->input->post('empId');
    $list = $this->employee_subject->active_subject_employee($empid);
    foreach($list as $val){?>
       <tr>
           <td><?= subjectName($val->subject_id)?></td>
           <td><a href="javascript:;" class="btn btn-primary" onclick="deteEmployee('<?= $val->id?>')">Delete</td>
           </tr> 
    <?php }
}

public function deteEmployee() {
    $empid = $this->input->post('id');
    $this->employee_subject->delete_by_id($empid);
    echo 1;
}

    
}
