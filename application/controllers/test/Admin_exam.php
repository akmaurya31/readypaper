<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Admin_exam extends MY_Controller {

    protected $access = array('admin');
    private $table = "tbl_exam";

    public function __construct() {
        parent::__construct();
        $this->load->model('exam_model', 'exam');
        $this->load->model('person_model', 'person');
       
    }

    public function index() {
        $data['include'] = 'admin/exam';
		$data['title'] = "Exam";
        $this->load->view("admin/layout/main", $data);
        
    }

  
    public function ajax_list() {
        $uri= $this->session->userdata('role');
       
        $this->load->helper('url');
        $list = $this->exam->get_datatables();
        $data = array();
        $no = $_POST['start'];
        $i=1;
        foreach ($list as $exam) {
            $status = isset($exam->status) && $exam->status == 'Y' ? 'N' : 'Y';
            $no++;
            $row = array();            
            $row[] = $i; 
            $adminName=   $this->person->get_by_id($exam->created_by);          
             
            $row[] = $adminName->firstName;            
            $row[] = $exam->exam_name;  
          
             
            $row[] = date('d-M-Y', strtotime($exam->created_at));


            if ($exam->status == 'Y')
            $statusIs = '<a href="javascript:void(0)" class="btn btn-success " title="Status Active" id="' . $exam->id . '" onclick="statusUpdate(' . "'" . $exam->id . "'" . "," . "'" . $status . "'" . ')"> <i class="fa fa-info-circle"></i></a>';
        else
            $statusIs = '<a href="javascript:void(0)" class="btn btn-warning " title="Status Inactive" id="' . $exam->id . '" onclick="statusUpdate(' . "'" . $exam->id . "'" . "," . "'" . $status . "'" . ')"> <i class="fa fa-exclamation-triangle"></i></a>';
        //add html for action
       
                $row[] = '' . $statusIs . ' <a href="javascript:void(0)" class="btn btn-primary " title="Edit exam" onclick="edit_exam(' . "'" . $exam->id . "'" . ')"> <i class="fa fa-edit"></i></a>
                  ';
            

            $data[] = $row;
            $i++;
        }
 $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->exam->count_all(),
            "recordsFiltered" => $this->exam->count_filtered(),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }

    public function ajax_edit($id) {
        $data = $this->exam->get_by_id($id);
        echo json_encode($data);
    }

    public function ajax_add() {
        $this->_validate();
       //$this->_existCheck($this->input->post('id'));
        $data = array(            
            'exam_name' => $this->input->post('exam_name'),
          
            'created_by' => $this->session->userdata('id'),
        );


        $insert = $this->exam->save($data);

        echo json_encode(array("status" => TRUE));
    }

    public function ajax_update() {
        $this->_validate();
        //$this->_existCheck($this->input->post('id'));       
        $data = array(
            'exam_name' => $this->input->post('exam_name'),
        );

       

        $this->exam->update(array('id' => $this->input->post('id')), $data);
        echo json_encode(array("status" => TRUE));
    }


   private function _existCheck($id=null){
        $data = array();
        $data['error_string'] = [];
        $data['inputerror'] = [];
        $data['status'] = TRUE;

        $res = [];
        if(is_null($id)){
          $res = $this->exam->get_by_name($this->input->post('exam_name'));
        }elseif(!is_null($id)){
           $res = $this->exam->get_by_name($this->input->post('exam_name'),$id);
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
        
        if ($this->input->post('exam_name') == '') {
            $data['inputerror'][] = 'exam_name';
            $data['error_string'][] = 'exam is required';
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
            $exam = $this->class->get_by_id($id);
           

            $this->commonDelete($this->table, $id);
            echo json_encode(array("status" => TRUE));
        }else {
            $returnData = array('No direct script access allowed');
            echo json_encode($returnData);
        }
    }

}
