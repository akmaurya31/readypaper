<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Admin_subject extends MY_Controller {

    protected $access = array('admin');
    private $table = "tbl_subject";

    public function __construct() {
        parent::__construct();
        $this->load->model('subject_model', 'subject');
        $this->load->model('person_model', 'person');
    }

    public function index() {
        $data['include'] = 'admin/subject';
		$data['title'] = "Subject"; 
        $this->load->view("admin/layout/main", $data);
        
    }

  
    public function ajax_list() {
        $uri= $this->session->userdata('role');
       
        $this->load->helper('url');
        $list = $this->subject->get_datatables();
        $data = array();
        $no = $_POST['start'];
        $i=1;
        foreach ($list as $subject) {
            $status = isset($subject->status) && $subject->status == 'Y' ? 'N' : 'Y';
            $no++;
            $row = array();            
            $row[] = $i; 
            $adminName=   $this->person->get_by_id($subject->created_by); 
            $row[] = $adminName->firstName; 
            
            if($subject->id==1){
                 $row[] = '<a href="javascript:;" style="color:#ff0000">'.@$subject->subject_name.'</a>'; 
            }elseif($subject->id==3){
                 $row[] = '<a href="javascript:;" style="color:#c3989f">'.@$subject->subject_name.'</a>'; 
            }elseif($subject->id==4){
                 $row[] = '<a href="javascript:;" style="color:#145650">'.$subject->subject_name.'</a>'; 
            }elseif($subject->id==5){
                 $row[] = '<a href="javascript:;" style="color:#129d9b">'.$subject->subject_name.'</a>'; 
            }elseif($subject->id==12){
                 $row[] = '<a href="javascript:;" style="color:#422dc6">'.$subject->subject_name.'</a>'; 
            }elseif($subject->id==13){
                 $row[] = '<a href="javascript:;" style="color:#814435">'.$subject->subject_name.'</a>'; 
            }elseif($subject->id==14){
                 $row[] = '<a href="javascript:;" style="color:#4e6e4e">'.$subject->subject_name.'</a>'; 
            }elseif($subject->id==16){
                 $row[] = '<a href="javascript:;" style="color:#f72b50">'.$subject->subject_name.'</a>'; 
            }elseif($subject->id==17){
                 $row[] = '<a href="javascript:;" style="color:#607d8b">'.$subject->subject_name.'</a>'; 
            }elseif($subject->id==18){
                 $row[] = '<a href="javascript:;" style="color:#795548">'.$subject->subject_name.'</a>'; 
            }elseif($subject->id==23){
                 $row[] = '<a href="javascript:;" style="color:#ffc107">'.$subject->subject_name.'</a>'; 
            }elseif($subject->id==24){
                 $row[] = '<a href="javascript:;" style="color:#2196f3">'.$subject->subject_name.'</a>'; 
            }elseif($subject->id==25){
                 $row[] = '<a href="javascript:;" style="color:#673ab7">'.$subject->subject_name.'</a>'; 
            }elseif($subject->id==26){
                 $row[] = '<a href="javascript:;" style="color:#6e6e6e">'.$subject->subject_name.'</a>'; 
            }elseif($subject->id==27){
                 $row[] = '<a href="javascript:;" style="color:#ffa755">'.$subject->subject_name.'</a>'; 
            }elseif($subject->id==28){
                 $row[] = '<a href="javascript:;" style="color:#68e365">'.$subject->subject_name.'</a>'; 
            }elseif($subject->id==29){
                 $row[] = '<a href="javascript:;" style="color:#145650">'.$subject->subject_name.'</a>'; 
            }elseif($subject->id==30){
                 $row[] = '<a href="javascript:;" style="color:#0a0ae7">'.$subject->subject_name.'</a>'; 
            }elseif($subject->id==31){
                 $row[] = '<a href="javascript:;" style="color:#d653c1">'.$subject->subject_name.'</a>'; 
            }else{
                 $row[] = '<a href="javascript:;" class="text-primary">'.$subject->subject_name.'</a>'; 
            }
            
            $row[] = date('d M Y', strtotime($subject->created_at));


            if ($subject->status == 'Y')
            $statusIs = '<a href="javascript:void(0)" class="btn btn-success " title="Status Active" id="' . $subject->id . '" onclick="statusUpdate(' . "'" . $subject->id . "'" . "," . "'" . $status . "'" . ')"> <i class="fa fa-info-circle"></i></a>';
        else
            $statusIs = '<a href="javascript:void(0)" class="btn btn-warning " title="Status Inactive" id="' . $subject->id . '" onclick="statusUpdate(' . "'" . $subject->id . "'" . "," . "'" . $status . "'" . ')"> <i class="fa fa-exclamation-triangle"></i></a>';
        //add html for action
       
                $row[] = '' . $statusIs . ' <a href="javascript:void(0)" class="btn btn-primary " title="Edit subject" onclick="edit_subject(' . "'" . $subject->id . "'" . ')"> <i class="fa fa-edit"></i></a>
                  ';
            

            $data[] = $row;
            $i++;
        }
 $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->subject->count_all(),
            "recordsFiltered" => $this->subject->count_filtered(),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }

    public function ajax_edit($id) {
        $data = $this->subject->get_by_id($id);
        echo json_encode($data);
    }

    public function ajax_add() {
        $this->_validate();
       $this->_existCheck($this->input->post('id'));
        $data = array(            
            'subject_name' => $this->input->post('subject_name'), 
            'created_by' => $this->session->userdata('id'),
        );


        $insert = $this->subject->save($data);

        echo json_encode(array("status" => TRUE));
    }

    public function ajax_update() {
        $this->_validate();
        //$this->_existCheck($this->input->post('id'));       
        $data = array(
            'subject_name' => $this->input->post('subject_name'),     
        );

       

        $this->subject->update(array('id' => $this->input->post('id')), $data);
        echo json_encode(array("status" => TRUE));
    }


   private function _existCheck($id=null){
        $data = array();
        $data['error_string'] = [];
        $data['inputerror'] = [];
        $data['status'] = TRUE;

        $res = [];
        if(is_null($id)){
          $res = $this->subject->get_by_name($this->input->post('subject_name'));
        }elseif(!is_null($id)){
           $res = $this->subject->get_by_name($this->input->post('subject_name'),$id);
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
        
        if ($this->input->post('subject_name') == '') {
            $data['inputerror'][] = 'subject_name';
            $data['error_string'][] = 'subject is required';
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
            $subject = $this->class->get_by_id($id);
            if (file_exists('upload/class/' . $subject->photo) && $subject->photo)
                unlink('upload/class/' . $subject->photo);

            $this->commonDelete($this->table, $id);
            echo json_encode(array("status" => TRUE));
        }else {
            $returnData = array('No direct script access allowed');
            echo json_encode($returnData);
        }
    }

}
