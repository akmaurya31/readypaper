<?php
 
defined('BASEPATH') OR exit('No direct script access allowed');
 
class Admin_group_exam extends MY_Controller {
 
   protected $access = ['admin'];
   private $table = "tbl_group_exam";
 
   public function __construct() {
       parent::__construct();
       $this->load->model('exam_model', 'exam');
       $this->load->model('group_exam_model', 'group_exam');
   }
 
   public function index() {
       $data['include'] = 'admin/group_exam';     
       $data['title'] = "Group Exam";
       $data['get_exam'] = $this->exam->get_active_exam();
       $this->load->view("admin/layout/main", $data);
      
   }
   
   
   public function ajax_list() {
        $uri= $this->session->userdata('role');
       
        $this->load->helper('url');
        $list = $this->group_exam->get_datatables();
        $data = array();
        $no = $_POST['start'];
        $i=1;
        foreach ($list as $group_exam) {
            $status = isset($group_exam->status) && $group_exam->status == 'Y' ? 'N' : 'Y';
            $no++;
            $row = array();            
            $row[] = $i; 
            $examName=   $this->exam->get_by_id($group_exam->exam_id);
            $row[] =$examName->exam_name;  
            $row[] =$group_exam->group_exam_name;  
           

            if ($group_exam->status == 'Y')
            $statusIs = '<a href="javascript:void(0)" class=" btn  btn-success" title="Status Active" id="' . $group_exam->id . '" onclick="statusUpdate(' . "'" . $group_exam->id . "'" . "," . "'" . $status . "'" . ')"> <i class="fa fa-info-circle"></i></a>';
        else
            $statusIs = '<a href="javascript:void(0)" class=" btn  btn-warning" title="Status Inactive" id="' . $group_exam->id . '" onclick="statusUpdate(' . "'" . $group_exam->id . "'" . "," . "'" . $status . "'" . ')"> <i class="fa fa-exclamation-triangle"></i></a>';
        //add html for action
       
                $row[] = '' . $statusIs . ' <a href="javascript:void(0)" class=" btn  btn-info" title="Edit group_exam" onclick="edit_group_exam(' . "'" . $group_exam->id . "'" . ')"> <i class="fas fa-pencil-alt"></i></a>
                <a class=" btn  btn-danger" href="javascript:void(0)" title="Delete" onclick="deleteData(' . "'" . $group_exam->id . "'" . ')"><i class="fa fa-trash"></i> </a>
               
                ';
            

            $data[] = $row;
            $i++;
        }
 $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->group_exam->count_all(),
            "recordsFiltered" => $this->group_exam->count_filtered(),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }

    public function ajax_edit($id) {
        $data = $this->group_exam->get_by_id($id);
        echo json_encode($data);
    }

    public function ajax_add() {
        $this->_validate();
        $this->_existCheck($this->input->post('id'));
        $data = array(            
            'group_exam_name' => $this->input->post('group_exam_name'),
            'exam_id' => $this->input->post('exam_id'),
            'created_at' => $this->session->userdata('id'),
        );

       

        $insert = $this->group_exam->save($data);

        echo json_encode(array("status" => TRUE));
    }

    public function ajax_update() {
        $this->_validate();
        //$this->_existCheck($this->input->post('id'));       
        $data = array(
             'group_exam_name' => $this->input->post('group_exam_name'),
           'exam_id' => $this->input->post('exam_id'),
        );

       
        $this->group_exam->update(array('id' => $this->input->post('id')), $data);
        echo json_encode(array("status" => TRUE));
    }

   

    private function _existCheck($id=null){
        $data = array();
        $data['error_string'] = [];
        $data['inputerror'] = [];
        $data['status'] = TRUE;

        $res = [];
        if(is_null($id)){
          $res = $this->group_exam->get_by_name($this->input->post('group_exam_name'));
        }elseif(!is_null($id)){
           $res = $this->group_exam->get_by_name($this->input->post('group_exam_name'),$id);
        }
       
        if(isset($res->id)){
            $data['inputerror'][] = 'group_exam_name';
            $data['error_string'][] = 'District name  already Exist';
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
        
        if ($this->input->post('group_exam_name') == '') {
            $data['inputerror'][] = 'group_exam_name';
            $data['error_string'][] = 'District name is required';
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
            
            $id = $this->input->post('id');
            $group_exam = $this->group_exam->get_by_id($id);
            $this->commonDelete($this->table, $id);
            echo json_encode(array("status" => TRUE));
        }else {
            $returnData = array('No direct script access allowed');
            echo json_encode($returnData);
        }
    }
   
   
   
}
 
