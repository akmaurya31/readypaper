<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Admin_chapter_type extends MY_Controller {

    protected $access = array('admin');
    private $table = "tbl_chapter_type";

    public function __construct() {
        parent::__construct();
        $this->load->model('chapter_type_model', 'chapter_type');
        $this->load->model('person_model', 'person');
       
    }

    public function index() {
        $data['include'] = 'admin/chapter_type';
		$data['title'] = "Chapter Type";
        $this->load->view("admin/layout/main", $data);
        
    }

  
    public function ajax_list() {
        $uri= $this->session->userdata('role');
       
        $this->load->helper('url');
        $list = $this->chapter_type->get_datatables();
        $data = array();
        $no = $_POST['start'];
        $i=1;
        foreach ($list as $chapter_type) {
            $status = isset($chapter_type->status) && $chapter_type->status == 'Y' ? 'N' : 'Y';
            $no++;
            $row = array();            
            $row[] = $i; 
            $adminName=   $this->person->get_by_id($chapter_type->created_by);          
             
            $row[] = $adminName->firstName;            
            $row[] = $chapter_type->chapter_type_name;  
          
             
            $row[] = date('d-M-Y', strtotime($chapter_type->created_at));


            if ($chapter_type->status == 'Y')
            $statusIs = '<a href="javascript:void(0)" class="btn btn-success " title="Status Active" id="' . $chapter_type->id . '" onclick="statusUpdate(' . "'" . $chapter_type->id . "'" . "," . "'" . $status . "'" . ')"> <i class="fa fa-info-circle"></i></a>';
        else
            $statusIs = '<a href="javascript:void(0)" class="btn btn-warning " title="Status Inactive" id="' . $chapter_type->id . '" onclick="statusUpdate(' . "'" . $chapter_type->id . "'" . "," . "'" . $status . "'" . ')"> <i class="fa fa-exclamation-triangle"></i></a>';
        //add html for action
       
                $row[] = '' . $statusIs . ' <a href="javascript:void(0)" class="btn btn-primary " title="Edit chapter_type" onclick="edit_chapter_type(' . "'" . $chapter_type->id . "'" . ')"> <i class="fa fa-edit"></i></a>
                  ';
            

            $data[] = $row;
            $i++;
        }
 $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->chapter_type->count_all(),
            "recordsFiltered" => $this->chapter_type->count_filtered(),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }

    public function ajax_edit($id) {
        $data = $this->chapter_type->get_by_id($id);
        echo json_encode($data);
    }

    public function ajax_add() {
        $this->_validate();
       //$this->_existCheck($this->input->post('id'));
        $data = array(            
            'chapter_type_name' => $this->input->post('chapter_type_name'),
          
            'created_by' => $this->session->userdata('id'),
        );
        $insert = $this->chapter_type->save($data);
        echo json_encode(array("status" => TRUE));
    }

    public function ajax_update() {
        $this->_validate();
        //$this->_existCheck($this->input->post('id'));       
        $data = array(
            'chapter_type_name' => $this->input->post('chapter_type_name'),
        );

       

        $this->chapter_type->update(array('id' => $this->input->post('id')), $data);
        echo json_encode(array("status" => TRUE));
    }


   private function _existCheck($id=null){
        $data = array();
        $data['error_string'] = [];
        $data['inputerror'] = [];
        $data['status'] = TRUE;

        $res = [];
        if(is_null($id)){
          $res = $this->chapter_type->get_by_name($this->input->post('chapter_type_name'));
        }elseif(!is_null($id)){
           $res = $this->chapter_type->get_by_name($this->input->post('chapter_type_name'),$id);
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
        
        if ($this->input->post('chapter_type_name') == '') {
            $data['inputerror'][] = 'chapter_type_name';
            $data['error_string'][] = 'chapter_type is required';
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
            $chapter_type = $this->class->get_by_id($id);
           

            $this->commonDelete($this->table, $id);
            echo json_encode(array("status" => TRUE));
        }else {
            $returnData = array('No direct script access allowed');
            echo json_encode($returnData);
        }
    }

}
