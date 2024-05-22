<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Teacher_school extends MY_Controller {

    protected $access = array('teacher');
    private $table = "tbl_school";

    public function __construct() {
        parent::__construct();
        $this->load->model('School_model', 'school');
        $this->load->model('person_model', 'person');
        $this->load->model('School_log_model', 'school_log');
    }

    public function index() {
        $data['include'] = 'teacher/school';
		$data['title'] = "School/Institute"; 
		$id= $this->session->userdata('id');
		$data['countSchool'] = $this->school->getByCount($id);
		
        $this->load->view("admin/layout/main", $data);
        
    }

  
    public function ajax_list() {
        $id= $this->session->userdata('id');
        $this->load->helper('url');
        $list = $this->school->get_datatables($id);
        $data = array();
        $no = $_POST['start'];
        $i=1;
        foreach ($list as $school) {
            $status = isset($school->status) && $school->status == 'Y' ? 'N' : 'Y';
            $no++;
            $row = array();            
            $row[] = $i; 
            $teacherName=   $this->person->get_by_id($school->created_by);
         
            $row[] = $teacherName->firstName; 
            if ($school->pic)
            $row[] = '<img src="' . base_url('upload/school/' . $school->pic) . '" class="img-responsive" style="width:100%;"/>';
        else
            $row[] = '(No photo)';
            $row[] = $school->school_name;    
              $row[] = $school->address;       
            $row[] = date('d-M-Y', strtotime($school->created_at));

            $checkRes = checkSchool($school->created_by);
            if($checkRes>=2){
                $row[] = '<a href="javascript:void(0)" class="btn btn-warning " title="No Access school"> <i class="fa fa-edit"></i></a>';
            }else{
               if ($school->status == 'Y')
            $statusIs = '<a href="javascript:void(0)" class="btn btn-success " title="Status Active" id="' . $school->id . '" onclick="statusUpdate(' . "'" . $school->id . "'" . "," . "'" . $status . "'" . ')"> <i class="fa fa-info-circle"></i></a>';
            else
            $statusIs = '<a href="javascript:void(0)" class="btn btn-warning " title="Status Inactive" id="' . $school->id . '" onclick="statusUpdate(' . "'" . $school->id . "'" . "," . "'" . $status . "'" . ')"> <i class="fa fa-exclamation-triangle"></i></a>';
            $row[] = '<a href="javascript:void(0)" class="btn btn-primary " title="Edit school" onclick="edit_school(' . "'" . $school->id . "'" . ')"> <i class="fa fa-edit"></i></a>';
               
            }
            

            $data[] = $row;
            $i++;
        }
 $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->school->count_all($id),
            "recordsFiltered" => $this->school->count_filtered($id),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }

    public function ajax_edit($id) {
        $data = $this->school->get_by_id($id);
        echo json_encode($data);
    }

    public function ajax_add() {
        $this->_validate();
       // $this->_existCheck($this->input->post('id'));
        $data = array(            
            'school_name' => $this->input->post('head'),
            'fb' => $this->input->post('fb'),
            'you' => $this->input->post('you'),
            'teli' => $this->input->post('teli'),
            'lin' => $this->input->post('lin'),
            'address' => $this->input->post('address'),           
            'created_by' => $this->session->userdata('id'),
        );

        if (!empty($_FILES['pic']['name'])) {
            $upload = $this->_do_upload();
            $data['pic'] = $upload;
        }

        $insert = $this->school->save($data);
        if($insert){
         $this->school_log->save($data);
         echo json_encode(array("status" => TRUE));
        }
    }
    
    

    public function ajax_update() {
        $this->_validate();
        //$this->_existCheck($this->input->post('id'));       
        $data = array(
            'school_name' => $this->input->post('head'),
            'fb' => $this->input->post('fb'),
            'you' => $this->input->post('you'),
            'teli' => $this->input->post('teli'),
            'lin' => $this->input->post('lin'),
            'address' => $this->input->post('address'), 
            'created_by' => $this->session->userdata('id'),
        );

        if ($this->input->post('remove_photo')) { // if remove photo checked
            if (file_exists('upload/school/' . $this->input->post('remove_photo')) && $this->input->post('remove_photo'))
                unlink('upload/school/' . $this->input->post('remove_photo'));
            $data['pic'] = '';
        }

        if (!empty($_FILES['pic']['name'])) {
            $upload = $this->_do_upload();
            $school = $this->school->get_by_id($this->input->post('id'));
            if (file_exists('upload/school/' . $school->pic) && $school->pic)
                unlink('upload/school/' . $school->pic);
            $data['pic'] = $upload;
        }
       $res =  $this->school->update(array('id' => $this->input->post('id')), $data);
        if($res){
         $this->school_log->save($data);
         echo json_encode(array("status" => TRUE));
        }
        
    }

    private function _do_upload() {
        $config['upload_path'] = './upload/school/'; //where is file upload path
        $config['allowed_types'] = "gif|jpg|png|jpeg"; //which file type you want to allow
        $config['overwrite'] = FALSE;
        $config['max_size'] = "2048000"; // Can be set to particular file size , here it is 2 MB(2048 Kb)
        $config['max_width'] = 10000; // set max width image allowed
        $config['max_height'] = 10000; // set max height allowed
        $config['file_name'] = 'school'.rand(10,1000); //imagename auto chnage due to overwrite funcnality false
        $this->load->library('upload', $config);
        $this->upload->initialize($config);

        if (!$this->upload->do_upload('pic')) { //upload and validate
            $data['inputerror'][] = 'pic';
            $data['error_string'][] = 'Upload error: ' . $this->upload->display_errors('', ''); //show ajax error
            $data['status'] = FALSE;
            echo json_encode($data);
            exit();
        }
        return $this->upload->data('file_name');
    }

  

    private function _validate() {
        $data = array();
        $data['error_string'] = array();
        $data['inputerror'] = array();
        $data['status'] = TRUE;
        
        if ($this->input->post('head') == '') {
            $data['inputerror'][] = 'head';
            $data['error_string'][] = 'Heading is required';
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
            $school = $this->school->get_by_id($id);
            if (file_exists('upload/school/' . $school->pic) && $school->pic)
                unlink('upload/school/' . $school->pic);

            $this->commonDelete($this->table, $id);
            echo json_encode(array("status" => TRUE));
        }else {
            $returnData = array('No direct script access allowed');
            echo json_encode($returnData);
        }
    }

}
