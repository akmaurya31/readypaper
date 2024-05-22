<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Admin_chapter extends MY_Controller {

    protected $access = array('admin','employee','super_employee','teacher');
    private $table = "tbl_chapter";

    public function __construct() {
        parent::__construct();
        $this->load->model('chapter_model', 'chapter');
        $this->load->model('person_model', 'person');
        $this->load->model('Class_model', 'class');
        $this->load->model('Subject_model', 'subject');
        $this->load->model('Board_type_model', 'board');
         $this->load->model('Chapter_type_model', 'chapter_type_modal'); 
         
    }

    public function index() {
        $data['include'] = 'admin/chapter';
		$data['title'] = "Chapter ";
	    $data['getchapter_type'] = $this->chapter_type_modal->get_active_chapter_type();
        $this->load->view("admin/layout/main", $data);
        
    }

  
    public function ajax_list() {
          $role= $this->session->userdata('role');
        $id= $this->session->userdata('id');
        $clas_sub_id = $this->input->get('clas_sub_id');
        $this->load->helper('url');
        $list = $this->chapter->get_datatables($role,$id,$clas_sub_id);
        //echo $this->db->last_query();die;
        $data = array();
        $no = $_POST['start'];
        $i=1;
        foreach ($list as $chapter) {
            $status = isset($chapter->status) && $chapter->status == 'Y' ? 'N' : 'Y';
            $no++;
            $row = array();            
            $row[] = $i; 
            //$adminName=   $this->person->get_by_id($chapter->created_by);          
            //$getBoard= $this->board->get_by_id($chapter->board_id);
		    //$getsubject = $this->subject->get_by_id($chapter->subject_id);
		    $getchapter_typeName = $this->chapter_type_modal->get_by_id($chapter->chapter_type);
		    
		    if($role=='admin'){
		    if ($chapter->status == 'Y')
            $statusIs = '<a href="javascript:void(0)" class="btn btn-success " title="Status Active" id="' . $chapter->id . '" onclick="statusUpdate(' . "'" . $chapter->id . "'" . "," . "'" . $status . "'" . ')"> <i class="fa fa-info-circle"></i></a>';
            else
            $statusIs = '<a href="javascript:void(0)" class="btn btn-warning " title="Status Inactive" id="' . $chapter->id . '" onclick="statusUpdate(' . "'" . $chapter->id . "'" . "," . "'" . $status . "'" . ')"> <i class="fa fa-exclamation-triangle"></i></a>';
            $row[] = '' . $statusIs . ' <a href="javascript:void(0)" class="btn btn-primary " title="Edit chapter" onclick="edit_chapter(' . "'" . $chapter->id . "'" . ')"> <i class="fa fa-edit"></i></a>
                  <a href="admin_question?chapter_id='.$chapter->id .'&clas_sub_id='.$_GET['clas_sub_id'].'" class="btn btn-info " title="Add Question" > <i class="flaticon-022-copy"></i></a>';
             }else{
		          $row[] = '<a href="admin_question?chapter_id='.$chapter->id .'&clas_sub_id='.$_GET['clas_sub_id'].'" class="btn btn-info " title="Add Question" > <i class="flaticon-022-copy"></i></a>
		           ';
                 
             }
            
            $row[] = @$getchapter_typeName->chapter_type_name; 
            $row[] = $chapter->chapter_name;
            $row[] = date('d-M-Y', strtotime($chapter->created_at));
            $data[] = $row;
            $i++;
        }
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->chapter->count_all($role,$id,$clas_sub_id),
            "recordsFiltered" => $this->chapter->count_filtered($role,$id,$clas_sub_id),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }

    public function ajax_edit($id) {
        $data = $this->chapter->get_by_id($id);
        echo json_encode($data);
    }

    public function ajax_add() {
        $this->_validate();
       //$this->_existCheck($this->input->post('id'));
        $data = array(            
                //'board_id' => $this->input->post('board'),
                //'class_id' => $this->input->post('class'),
               // 'subject_id' => $this->input->post('subject'),
                'clas_sub_id' => $this->input->post('clas_sub_id'),
                'chapter_name' => $this->input->post('chapter_name'),
               'chapter_type' => $this->input->post('chapter_type'),
                'created_by' => $this->session->userdata('id'),
        );
        $insert = $this->chapter->save($data);
        echo json_encode(array("status" => TRUE));
    }

    public function ajax_update() {
        $this->_validate();
        //$this->_existCheck($this->input->post('id'));       
        $data = array(
            'chapter_name' => $this->input->post('chapter_name'),  
            //'board_id' => $this->input->post('board'),
           // 'class_id' => $this->input->post('class'),
            //'subject_id' => $this->input->post('subject'),
            'chapter_type' => $this->input->post('chapter_type'),
             'clas_sub_id' => $this->input->post('clas_sub_id'),
        );
        $this->chapter->update(array('id' => $this->input->post('id')), $data);
        echo json_encode(array("status" => TRUE));
    }


   private function _existCheck($id=null){
        $data = array();
        $data['error_string'] = [];
        $data['inputerror'] = [];
        $data['status'] = TRUE;
        $res = [];
        if(is_null($id)){
          $res = $this->chapter->get_by_name($this->input->post('chapter_name'));
        }elseif(!is_null($id)){
           $res = $this->chapter->get_by_name($this->input->post('chapter_name'),$id);
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
        /*if ($this->input->post('subject') == '') {
            $data['inputerror'][] = 'subject';
            $data['error_string'][] = 'Subject Name is required';
            $data['status'] = FALSE;
        }
        if ($this->input->post('board') == '') {
            $data['inputerror'][] = 'board';
            $data['error_string'][] = 'Board Name is required';
            $data['status'] = FALSE;
        }
        if ($this->input->post('class') == '') {
            $data['inputerror'][] = 'class';
            $data['error_string'][] = 'Class Name is required';
            $data['status'] = FALSE;
        }*/
        
        if ($this->input->post('chapter_type') == '') {
            $data['inputerror'][] = 'chapter_type';
            $data['error_string'][] = 'chapter type Name is required';
            $data['status'] = FALSE;
        }
         if ($this->input->post('chapter_name') == '') {
            $data['inputerror'][] = 'chapter_name';
            $data['error_string'][] = 'chapter Name is required';
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
            $chapter = $this->class->get_by_id($id);
            if (file_exists('upload/class/' . $chapter->photo) && $chapter->photo)
                unlink('upload/class/' . $chapter->photo);

            $this->commonDelete($this->table, $id);
            echo json_encode(array("status" => TRUE));
        }else {
            $returnData = array('No direct script access allowed');
            echo json_encode($returnData);
        }
    }

}
