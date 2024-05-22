<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Admin_exercise extends MY_Controller {

    protected $access = array('admin');
    private $table = "tbl_exercise";

    public function __construct() {
        parent::__construct();
        $this->load->model('exercise_model', 'exercise');
        $this->load->model('person_model', 'person');
       
    }

    public function index() {
        $data['include'] = 'admin/exercise';
		$data['title'] = "Exercise";
        $this->load->view("admin/layout/main", $data);
        
    }

  
    public function ajax_list() {
        $role= $this->session->userdata('role');
        $id= $this->session->userdata('id');
        $class_sub_id = $this->input->get('class_subj_id');
       
        $this->load->helper('url');
        $list = $this->exercise->get_datatables($role,$id,$class_sub_id);
        $data = array();
        $no = $_POST['start'];
        $i=1;
        foreach ($list as $exercise) {
            $status = isset($exercise->status) && $exercise->status == 'Y' ? 'N' : 'Y';
            $no++;
            $row = array();            
            $row[] = $i; 
            $adminName=   $this->person->get_by_id($exercise->created_by);          
             
            $row[] = $adminName->firstName;            
            $row[] = $exercise->exercise_name;  
          
             
            $row[] = date('d-M-Y', strtotime($exercise->created_at));


            if ($exercise->status == 'Y')
            $statusIs = '<a href="javascript:void(0)" class="btn btn-success " title="Status Active" id="' . $exercise->id . '" onclick="statusUpdate(' . "'" . $exercise->id . "'" . "," . "'" . $status . "'" . ')"> <i class="fa fa-info-circle"></i></a>';
        else
            $statusIs = '<a href="javascript:void(0)" class="btn btn-warning " title="Status Inactive" id="' . $exercise->id . '" onclick="statusUpdate(' . "'" . $exercise->id . "'" . "," . "'" . $status . "'" . ')"> <i class="fa fa-exclamation-triangle"></i></a>';
        //add html for action
       
                $row[] = '' . $statusIs . ' <a href="javascript:void(0)" class="btn btn-primary " title="Edit exercise" onclick="edit_exercise(' . "'" . $exercise->id . "'" . ')"> <i class="fa fa-edit"></i></a>
                  ';
            

            $data[] = $row;
            $i++;
        }
 $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->exercise->count_all($role,$id,$class_sub_id),
            "recordsFiltered" => $this->exercise->count_filtered($role,$id,$class_sub_id),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }

    public function ajax_edit($id) {
        $data = $this->exercise->get_by_id($id);
        echo json_encode($data);
    }

    public function ajax_add() {
        $this->_validate();
        //echo  $this->input->get('class_subj_id');die;
       //$this->_existCheck($this->input->post('id'));
        $data = array(            
            'exercise_name' => $this->input->post('exercise_name'),
            'class_subj_id' => $this->input->post('class_subj_id'),
            'created_by' => $this->session->userdata('id'),
        );

        $insert = $this->exercise->save($data);
        echo json_encode(array("status" => TRUE));
    }

    public function ajax_update() {
        $this->_validate();
        //$this->_existCheck($this->input->post('id'));       
        $data = array(
            'exercise_name' => $this->input->post('exercise_name'),
             'class_subj_id' => $this->input->post('class_subj_id'),
        );

        $this->exercise->update(array('id' => $this->input->post('id')), $data);
        echo json_encode(array("status" => TRUE));
    }


   private function _existCheck($id=null){
        $data = array();
        $data['error_string'] = [];
        $data['inputerror'] = [];
        $data['status'] = TRUE;

        $res = [];
        if(is_null($id)){
          $res = $this->exercise->get_by_name($this->input->post('exercise_name'));
        }elseif(!is_null($id)){
           $res = $this->exercise->get_by_name($this->input->post('exercise_name'),$id);
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
        
        if ($this->input->post('exercise_name') == '') {
            $data['inputerror'][] = 'exercise_name';
            $data['error_string'][] = 'Exercise is required';
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
            $exercise = $this->class->get_by_id($id);
           

            $this->commonDelete($this->table, $id);
            echo json_encode(array("status" => TRUE));
        }else {
            $returnData = array('No direct script access allowed');
            echo json_encode($returnData);
        }
    }

}
