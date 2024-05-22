<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Admin_syllabus extends MY_Controller {

    protected $access = array('admin','employee');
    private $table = "tbl_syllabus";

    public function __construct() {
        parent::__construct();
        $this->load->model('syllabus_model', 'syllabus');
        $this->load->model('person_model', 'person');
       $this->load->model('class_subject_model', 'class_subject');
       $this->load->model('class_model', 'class');
       $this->load->model('subject_model', 'subject');
    }

    public function index() {
        $data['include'] = 'admin/syllabus';
		$data['title'] = "Syllabus";
        $this->load->view("admin/layout/main", $data);
        
    }

  
    public function ajax_list() {
        
        $role= $this->session->userdata('role');
        $id= $this->session->userdata('id');
        $class_sub_id = $this->input->get('syllabus_id');
        $this->load->helper('url');
        $list = $this->syllabus->get_datatables($role,$id,$class_sub_id);
        $data = array();
        $no = $_POST['start'];
        $i=1;
        foreach ($list as $syllabus) {
            $status = isset($syllabus->status) && $syllabus->status == 'Y' ? 'N' : 'Y';
            $no++;
            $row = array();            
            $row[] = $i; 
            $adminName=   $this->person->get_by_id($syllabus->created_by);
            //$class_subjectName=   $this->class_subject->get_by_id($syllabus->class_sub_id);
            //$className=   $this->class->get_by_id(@$class_subjectName->class_id);
            // $subjectName=   $this->subject->get_by_id(@$class_subjectName->class_id);
             
           
            //$row[] = @$className->class_name.' / '.@$subjectName->subject_name; 
                $row[] = $syllabus->syllabus_name; 
            $row[] = $syllabus->syllabus_no;  
        
            $row[] = date('d-M-Y', strtotime($syllabus->created_at));


            if ($syllabus->status == 'Y')
            $statusIs = '<a href="javascript:void(0)" class="btn btn-success " title="Status Active" id="' . $syllabus->id . '" onclick="statusUpdate(' . "'" . $syllabus->id . "'" . "," . "'" . $status . "'" . ')"> <i class="fa fa-info-circle"></i></a>';
        else
            $statusIs = '<a href="javascript:void(0)" class="btn btn-warning " title="Status Inactive" id="' . $syllabus->id . '" onclick="statusUpdate(' . "'" . $syllabus->id . "'" . "," . "'" . $status . "'" . ')"> <i class="fa fa-exclamation-triangle"></i></a>';
        //add html for action
       
                $row[] = '' . $statusIs . ' <a href="javascript:void(0)" class="btn btn-primary " title="Edit syllabus" onclick="edit_syllabus(' . "'" . $syllabus->id . "'" . ')"> <i class="fa fa-edit"></i></a>
                  ';
            

            $data[] = $row;
            $i++;
        }
 $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->syllabus->count_all($role,$id,$class_sub_id),
            "recordsFiltered" => $this->syllabus->count_filtered($role,$id,$class_sub_id),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }

   

    public function ajax_add() {
        
        $this->_validate();
       //$this->_existCheck($this->input->post('id'));
        $data = array(            
            'syllabus_name' => $this->input->post('syllabus_name'),
            'syllabus_no' => $this->input->post('syllabus_no'),
            'class_sub_id' => $this->input->post('class_sub_id'),
            'created_by' => $this->session->userdata('id'),
        );
        $insert = $this->syllabus->save($data);
        echo json_encode(array("status" => TRUE));
    }
    
     public function ajax_edit($id) {
        $data = $this->syllabus->get_by_id($id);
        echo json_encode($data);
    }

    public function ajax_update() {
        $this->_validate();
        //$this->_existCheck($this->input->post('id'));       
        $data = array(
             'syllabus_name' => $this->input->post('syllabus_name'),
             'syllabus_no' => $this->input->post('syllabus_no'),
             //'class_sub_id' => $this->input->get('syllabus_id'),
        );
        $this->syllabus->update(array('id' => $this->input->post('id')), $data);
        echo json_encode(array("status" => TRUE));
    }


   private function _existCheck($id=null){
        $data = array();
        $data['error_string'] = [];
        $data['inputerror'] = [];
        $data['status'] = TRUE;

        $res = [];
        if(is_null($id)){
          $res = $this->syllabus->get_by_name($this->input->post('syllabus_name'));
        }elseif(!is_null($id)){
           $res = $this->syllabus->get_by_name($this->input->post('syllabus_name'),$id);
        }
       
        if(isset($res->id)){
            $data['inputerror'][] = 'name';
            $data['error_string'][] = 'Name  already Exist';
            $data['status'] = FALSE;  
        } 
        
        if ($data['status'] === FALSE) {
            echo json_encode($data);
            exit();
        }
    }
    private function _validate() {
        $data = array();
        $data['error_string'] = array();
        $data['inputerror'] = array();
        $data['status'] = TRUE;
        
        if ($this->input->post('syllabus_name') == '') {
            $data['inputerror'][] = 'syllabus_name';
            $data['error_string'][] = 'syllabus is required';
            $data['status'] = FALSE;
        }

        if ($data['status'] === FALSE) {
            echo json_encode($data);
            exit();
        }
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

    public function ajax_delete() {
        if ($this->input->is_ajax_request()) {
            //for delete file should write own code nut table data is automaticaly delete
            $id = $this->input->post('id');
            $syllabus = $this->class->get_by_id($id);
           

            $this->commonDelete($this->table, $id);
            echo json_encode(array("status" => TRUE));
        }else {
            $returnData = array('No direct script access allowed');
            echo json_encode($returnData);
        }
    }

}
