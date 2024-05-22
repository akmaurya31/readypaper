<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Admin_class extends MY_Controller {

    protected $access = array('admin');
    private $table = "tbl_class";

    public function __construct() {
        parent::__construct();
        $this->load->model('class_model', 'class');
        $this->load->model('person_model', 'person');
       
    }

    public function index() {
        $data['include'] = 'admin/class';
		$data['title'] = "Class";       
        $this->load->view("admin/layout/main", $data);
        
    }

  
    public function ajax_list() {
        $uri= $this->session->userdata('role');
       
        $this->load->helper('url');
        $list = $this->class->get_datatables();
        $data = array();
        $no = $_POST['start'];
        $i=1;
        foreach ($list as $class) {
            $status = isset($class->status) && $class->status == 'Y' ? 'N' : 'Y';
            $no++;
            $row = array();            
            $row[] = $i; 
            $adminName=   $this->person->get_by_id($class->created_by);
           
            
            $row[] = $adminName->firstName;
            
            $row[] = $class->class_name;  
            $row[] = date('d M Y', strtotime($class->created_at));


            if ($class->status == 'Y')
            $statusIs = '<a href="javascript:void(0)" class="btn btn-success " title="Status Active" id="' . $class->id . '" onclick="statusUpdate(' . "'" . $class->id . "'" . "," . "'" . $status . "'" . ')"> <i class="fa fa-info-circle"></i></a>';
        else
            $statusIs = '<a href="javascript:void(0)" class="btn btn-warning " title="Status Inactive" id="' . $class->id . '" onclick="statusUpdate(' . "'" . $class->id . "'" . "," . "'" . $status . "'" . ')"> <i class="fa fa-exclamation-triangle"></i></a>';
        //add html for action
       
                $row[] = '' . $statusIs . ' <a href="javascript:void(0)" class="btn btn-primary " title="Edit class" onclick="edit_class(' . "'" . $class->id . "'" . ')"> <i class="fa fa-edit"></i></a>
                  ';
            

            $data[] = $row;
            $i++;
        }
 $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->class->count_all(),
            "recordsFiltered" => $this->class->count_filtered(),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }

    public function ajax_edit($id) {
        $data = $this->class->get_by_id($id);
        echo json_encode($data);
    }

    public function ajax_add() {
        $this->_validate();
       $this->_existCheck($this->input->post('id'));
        $data = array(            
            'class_name' => $this->input->post('class_name'),
            'created_by' => $this->session->userdata('id'),
        );


        $insert = $this->class->save($data);

        echo json_encode(array("status" => TRUE));
    }

    public function ajax_update() {
        $this->_validate();
        //$this->_existCheck($this->input->post('id'));       
        $data = array(
            'class_name' => $this->input->post('class_name'),          
        );

       

        $this->class->update(array('id' => $this->input->post('id')), $data);
        echo json_encode(array("status" => TRUE));
    }


   private function _existCheck($id=null){
        $data = array();
        $data['error_string'] = [];
        $data['inputerror'] = [];
        $data['status'] = TRUE;

        $res = [];
        if(is_null($id)){
          $res = $this->class->get_by_name($this->input->post('class_name'));
        }elseif(!is_null($id)){
           $res = $this->class->get_by_name($this->input->post('class_name'),$id);
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
        
        if ($this->input->post('class_name') == '') {
            $data['inputerror'][] = 'class_name';
            $data['error_string'][] = 'class is required';
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
            $class = $this->class->get_by_id($id);
            if (file_exists('upload/class/' . $class->photo) && $class->photo)
                unlink('upload/class/' . $class->photo);

            $this->commonDelete($this->table, $id);
            echo json_encode(array("status" => TRUE));
        }else {
            $returnData = array('No direct script access allowed');
            echo json_encode($returnData);
        }
    }

}
