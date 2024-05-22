<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Admin_correct_answer extends MY_Controller {

    protected $access = array('admin');
    private $table = "tbl_correct_answer";

    public function __construct() {
        parent::__construct();
        $this->load->model('correct_answer_model', 'correct_answer');
        $this->load->model('person_model', 'person');
       
    }

    public function index() {
        $data['include'] = 'admin/correct_answer';
		$data['title'] = "Correct Answer";       
        $this->load->view("admin/layout/main", $data);
        
    }

  
    public function ajax_list() {
        $uri= $this->session->userdata('role');
       
        $this->load->helper('url');
        $list = $this->correct_answer->get_datatables();
        $data = array();
        $no = $_POST['start'];
        $i=1;
        foreach ($list as $correct_answer) {
            $status = isset($correct_answer->status) && $correct_answer->status == 'Y' ? 'N' : 'Y';
            $no++;
            $row = array();            
            $row[] = $i; 
            $adminName=   $this->person->get_by_id($correct_answer->created_by);          
            
            $row[] = $adminName->firstName;            
            $row[] = $correct_answer->correct_answer;  
            $row[] = $correct_answer->no;  
            $row[] = date('d-M-Y', strtotime($correct_answer->created_at));


            if ($correct_answer->status == 'Y')
            $statusIs = '<a href="javascript:void(0)" class="btn btn-success " title="Status Active" id="' . $correct_answer->id . '" onclick="statusUpdate(' . "'" . $correct_answer->id . "'" . "," . "'" . $status . "'" . ')"> <i class="fa fa-info-circle"></i></a>';
        else
            $statusIs = '<a href="javascript:void(0)" class="btn btn-warning " title="Status Inactive" id="' . $correct_answer->id . '" onclick="statusUpdate(' . "'" . $correct_answer->id . "'" . "," . "'" . $status . "'" . ')"> <i class="fa fa-exclamation-triangle"></i></a>';
        //add html for action
       
                $row[] = '' . $statusIs . ' <a href="javascript:void(0)" class="btn btn-primary " title="Edit correct_answer" onclick="edit_correct_answer(' . "'" . $correct_answer->id . "'" . ')"> <i class="fa fa-edit"></i></a>
                  ';
            

            $data[] = $row;
            $i++;
        }
 $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->correct_answer->count_all(),
            "recordsFiltered" => $this->correct_answer->count_filtered(),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }

    public function ajax_edit($id) {
        $data = $this->correct_answer->get_by_id($id);
        echo json_encode($data);
    }

    public function ajax_add() {
        $this->_validate();
       $this->_existCheck($this->input->post('id'));
        $data = array(            
            'correct_answer' => $this->input->post('correct_answer'),
            'no' => $this->input->post('no'),            
            'created_by' => $this->session->userdata('id'),
        );


        $insert = $this->correct_answer->save($data);

        echo json_encode(array("status" => TRUE));
    }

    public function ajax_update() {
        $this->_validate();
        //$this->_existCheck($this->input->post('id'));       
        $data = array(
            'correct_answer' => $this->input->post('correct_answer'),
            'no' => $this->input->post('no'),            
        );

       

        $this->correct_answer->update(array('id' => $this->input->post('id')), $data);
        echo json_encode(array("status" => TRUE));
    }


   private function _existCheck($id=null){
        $data = array();
        $data['error_string'] = [];
        $data['inputerror'] = [];
        $data['status'] = TRUE;

        $res = [];
        if(is_null($id)){
          $res = $this->correct_answer->get_by_name($this->input->post('correct_answer'));
        }elseif(!is_null($id)){
           $res = $this->correct_answer->get_by_name($this->input->post('correct_answer'),$id);
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
        
        if ($this->input->post('correct_answer') == '') {
            $data['inputerror'][] = 'correct_answer';
            $data['error_string'][] = 'correct_answer is required';
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

   

}
