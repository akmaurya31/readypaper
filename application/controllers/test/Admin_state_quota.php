<?php
 
defined('BASEPATH') OR exit('No direct script access allowed');
 
class Admin_state_quota extends MY_Controller {
 
   protected $access = ['admin'];
   private $table = "tbl_state_quota";
 
   public function __construct() {
       parent::__construct();
       $this->load->model('State_model', 'state');
       $this->load->model('state_quota_model', 'state_quota');
   }
 
   public function index() {
       $data['include'] = 'admin/state_quota';     
       $data['title'] = "District";
       $data['get_active_state'] = $this->state->get_active_state();
       $this->load->view("admin/layout/main", $data);
      
   }
   
   
   public function ajax_list() {
        $uri= $this->session->userdata('role');
       
        $this->load->helper('url');
        $list = $this->state_quota->get_datatables();
        $data = array();
        $no = $_POST['start'];
        $i=1;
        foreach ($list as $state_quota) {
            $status = isset($state_quota->status) && $state_quota->status == 'Y' ? 'N' : 'Y';
            $no++;
            $row = array();            
            $row[] = $i; 
            $stateName=   $this->state->get_by_id($state_quota->state_id);
            //$row[] = $adminName->firstName;
           // $row[] = date('d-m-y', strtotime($state_quota->created_date));
            $row[] =$state_quota->id.' / '.$stateName->state_name;  
            $row[] =$state_quota->state_quota_name;  
           

            if ($state_quota->status == 'Y')
            $statusIs = '<a href="javascript:void(0)" class=" btn  btn-success" title="Status Active" id="' . $state_quota->id . '" onclick="statusUpdate(' . "'" . $state_quota->id . "'" . "," . "'" . $status . "'" . ')"> <i class="fa fa-info-circle"></i></a>';
        else
            $statusIs = '<a href="javascript:void(0)" class=" btn  btn-warning" title="Status Inactive" id="' . $state_quota->id . '" onclick="statusUpdate(' . "'" . $state_quota->id . "'" . "," . "'" . $status . "'" . ')"> <i class="fa fa-exclamation-triangle"></i></a>';
        //add html for action
       
                $row[] = '' . $statusIs . ' <a href="javascript:void(0)" class=" btn  btn-info" title="Edit state_quota" onclick="edit_state_quota(' . "'" . $state_quota->id . "'" . ')"> <i class="fas fa-pencil-alt"></i></a>
                <a class=" btn  btn-danger" href="javascript:void(0)" title="Delete" onclick="deleteData(' . "'" . $state_quota->id . "'" . ')"><i class="fa fa-trash"></i> </a>
               
                ';
            

            $data[] = $row;
            $i++;
        }
 $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->state_quota->count_all(),
            "recordsFiltered" => $this->state_quota->count_filtered(),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }

    public function ajax_edit($id) {
        $data = $this->state_quota->get_by_id($id);
        echo json_encode($data);
    }

    public function ajax_add() {
        $this->_validate();
        $this->_existCheck($this->input->post('id'));
        $data = array(            
            'state_quota_name' => $this->input->post('state_quota_name'),
            'state_id' => $this->input->post('state_id'),
            'created_at' => $this->session->userdata('id'),
        );

       

        $insert = $this->state_quota->save($data);

        echo json_encode(array("status" => TRUE));
    }

    public function ajax_update() {
        $this->_validate();
        //$this->_existCheck($this->input->post('id'));       
        $data = array(
             'state_quota_name' => $this->input->post('state_quota_name'),
           'state_id' => $this->input->post('state_id'),
        );

       
        $this->state_quota->update(array('id' => $this->input->post('id')), $data);
        echo json_encode(array("status" => TRUE));
    }

   

    private function _existCheck($id=null){
        $data = array();
        $data['error_string'] = [];
        $data['inputerror'] = [];
        $data['status'] = TRUE;

        $res = [];
        if(is_null($id)){
          $res = $this->state_quota->get_by_name($this->input->post('state_quota_name'));
        }elseif(!is_null($id)){
           $res = $this->state_quota->get_by_name($this->input->post('state_quota_name'),$id);
        }
       
        if(isset($res->id)){
            $data['inputerror'][] = 'state_quota_name';
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
        
        if ($this->input->post('state_quota_name') == '') {
            $data['inputerror'][] = 'state_quota_name';
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
            $state_quota = $this->state_quota->get_by_id($id);
            $this->commonDelete($this->table, $id);
            echo json_encode(array("status" => TRUE));
        }else {
            $returnData = array('No direct script access allowed');
            echo json_encode($returnData);
        }
    }
   
   
   
}
 
