<?php
 
defined('BASEPATH') OR exit('No direct script access allowed');
 
class Admin_state extends MY_Controller {
 
   protected $access = ['admin'];
   private $table = "tbl_state";
 
   public function __construct() {
       parent::__construct();
       $this->load->model('State_model', 'state');
   }
 
   public function index() {
       $data['include'] = 'admin/state';     
       $data['title'] = "state";
       $this->load->view("admin/layout/main", $data);
      
   }
   
   
   public function ajax_list() {
        $uri= $this->session->userdata('role');
       
        $this->load->helper('url');
        $list = $this->state->get_datatables();
        $data = array();
        $no = $_POST['start'];
        $i=1;
        foreach ($list as $state) {
            $status = isset($state->status) && $state->status == 'Y' ? 'N' : 'Y';
            $no++;
            $row = array();            
            $row[] = $i; 
            //$adminName=   $this->person->get_by_id($state->created_at);
            //$row[] = $adminName->firstName;
           // $row[] = date('d-m-y', strtotime($state->created_date));
            $row[] =$state->id.' / '.$state->state_name;  
           

            if ($state->status == 'Y')
            $statusIs = '<a href="javascript:void(0)" class=" btn btn-success" title="Status Active" id="' . $state->id . '" onclick="statusUpdate(' . "'" . $state->id . "'" . "," . "'" . $status . "'" . ')"> <i class="fa fa-info-circle"></i></a>';
        else
            $statusIs = '<a href="javascript:void(0)" class=" btn btn-warning" title="Status Inactive" id="' . $state->id . '" onclick="statusUpdate(' . "'" . $state->id . "'" . "," . "'" . $status . "'" . ')"> <i class="fa fa-exclamation-triangle"></i></a>';
        //add html for action
       
                $row[] = '' . $statusIs . ' <a href="javascript:void(0)" class=" btn btn-info" title="Edit state" onclick="edit_state(' . "'" . $state->id . "'" . ')"> <i class="fas fa-pencil-alt"></i></a>
                <a class=" btn btn-danger" href="javascript:void(0)" title="Delete" onclick="deleteData(' . "'" . $state->id . "'" . ')"><i class="fa fa-trash"></i> </a>
               
                ';
            

            $data[] = $row;
            $i++;
        }
 $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->state->count_all(),
            "recordsFiltered" => $this->state->count_filtered(),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }

    public function ajax_edit($id) {
        $data = $this->state->get_by_id($id);
        echo json_encode($data);
    }

    public function ajax_add() {
        $this->_validate();
        $this->_existCheck($this->input->post('id'));
        $data = array(            
            'state_name' => $this->input->post('state_name'),
            'created_at' => $this->session->userdata('id'),
        );

       

        $insert = $this->state->save($data);

        echo json_encode(array("status" => TRUE));
    }

    public function ajax_update() {
        $this->_validate();
        //$this->_existCheck($this->input->post('id'));       
        $data = array(
             'state_name' => $this->input->post('state_name'),
           
        );

       
        $this->state->update(array('id' => $this->input->post('id')), $data);
        echo json_encode(array("status" => TRUE));
    }

   

    private function _existCheck($id=null){
        $data = array();
        $data['error_string'] = [];
        $data['inputerror'] = [];
        $data['status'] = TRUE;

        $res = [];
        if(is_null($id)){
          $res = $this->state->get_by_name($this->input->post('state_name'));
        }elseif(!is_null($id)){
           $res = $this->state->get_by_name($this->input->post('state_name'),$id);
        }
       
        if(isset($res->id)){
            $data['inputerror'][] = 'state_name';
            $data['error_string'][] = 'State name  already Exist';
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
        
        if ($this->input->post('state_name') == '') {
            $data['inputerror'][] = 'state_name';
            $data['error_string'][] = 'State name is required';
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
            $state = $this->state->get_by_id($id);
            $this->commonDelete($this->table, $id);
            echo json_encode(array("status" => TRUE));
        }else {
            $returnData = array('No direct script access allowed');
            echo json_encode($returnData);
        }
    }
   
   
   
}
 
