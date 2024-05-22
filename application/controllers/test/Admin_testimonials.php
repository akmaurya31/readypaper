<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Admin_testimonials extends MY_Controller {

    protected $access = array('admin');
    private $table = "tbl_testimonial";

    public function __construct() {
        parent::__construct();
        $this->load->model('Testimonials_model', 'testimonials');
        $this->load->model('person_model', 'person');
        
    }

    public function index() {
        $data['include'] = 'admin/testimonials';
		$data['title'] = "Testimonials";       
        $this->load->view("admin/layout/main", $data);
        
    }

  
    public function ajax_list() {
        $uri= $this->session->userdata('role');
        $this->load->helper('url');
        $list = $this->testimonials->get_datatables();
        $data = array();
        $no = $_POST['start'];
        $i=1;
        foreach ($list as $testimonials) {
            $status = isset($testimonials->status) && $testimonials->status == 'Y' ? 'N' : 'Y';
            $no++;
            $row = array();            
            $row[] = $i; 
            $adminName=   $this->person->get_by_id($testimonials->created_by);
             
            $row[] = $adminName->firstName;
            if ($testimonials->logo)
            $row[] = '<img src="' . base_url('upload/banner/' . $testimonials->logo) . '" class="img-responsive" style="width:40%;"/>';
        else
            $row[] = '(No photo)';
            $row[] = $testimonials->name; 
            $row[] = $testimonials->description; 
             
            
                    
                   
            $row[] = date('d-M-Y', strtotime($testimonials->created_at));


            if ($testimonials->status == 'Y')
            $statusIs = '<a href="javascript:void(0)" class="btn btn-success " title="Status Active" id="' . $testimonials->id . '" onclick="statusUpdate(' . "'" . $testimonials->id . "'" . "," . "'" . $status . "'" . ')"> <i class="fa fa-info-circle"></i></a>';
        else
            $statusIs = '<a href="javascript:void(0)" class="btn btn-warning " title="Status Inactive" id="' . $testimonials->id . '" onclick="statusUpdate(' . "'" . $testimonials->id . "'" . "," . "'" . $status . "'" . ')"> <i class="fa fa-exclamation-triangle"></i></a>';
        //add html for action
       
                $row[] = '' . $statusIs . ' <a href="javascript:void(0)" class="btn btn-primary" title="Edit testimonials" onclick="edit_testimonials(' . "'" . $testimonials->id . "'" . ')"> <i class="fa fa-check"></i></a>
                ';
            

            $data[] = $row;
            $i++;
        }
 $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->testimonials->count_all(),
            "recordsFiltered" => $this->testimonials->count_filtered(),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }

    public function ajax_edit($id) {
        $data = $this->testimonials->get_by_id($id);
        //$data->dob = ($data->dob == '0000-00-00') ? '' : $data->dob; // if 0000-00-00 set tu empty for datepicker compatibility
        echo json_encode($data);
    }

    public function ajax_add() {
        $this->_validate();
        $this->_existCheck($this->input->post('id'));
        $data = array(            
            'name' => $this->input->post('name'),
            'description' => $this->input->post('description'),            
            'created_by' => $this->session->userdata('id'),
        );

        if (!empty($_FILES['logo']['name'])) {
            $upload = $this->_do_upload();
            $data['logo'] = $upload;
        }

        $insert = $this->testimonials->save($data);

        echo json_encode(array("status" => TRUE));
    }

    public function ajax_update() {
        $this->_validate();
        $this->_existCheck($this->input->post('id'));       
        $data = array(
            'name' => $this->input->post('name'),
            'description' => $this->input->post('description'), 
        );

        if ($this->input->post('remove_photo')) { // if remove photo checked
            if (file_exists('upload/banner/' . $this->input->post('remove_photo')) && $this->input->post('remove_photo'))
                unlink('upload/' . $this->input->post('remove_photo'));
            $data['logo'] = '';
        }

        if (!empty($_FILES['logo']['name'])) {
            $upload = $this->_do_upload();

            //delete file
            $testimonials = $this->testimonials->get_by_id($this->input->post('id'));
            if (file_exists('upload/banner/' . $testimonials->logo) && $testimonials->logo)
                unlink('upload/banner/' . $testimonials->logo);

            $data['logo'] = $upload;
        }

        $this->testimonials->update(array('id' => $this->input->post('id')), $data);
        echo json_encode(array("status" => TRUE));
    }

    private function _do_upload() {
        $config['upload_path'] = './upload/banner/'; //where is file upload path
        $config['allowed_types'] = "gif|jpg|png|jpeg"; //which file type you want to allow
        $config['overwrite'] = FALSE;
        $config['max_size'] = "2048000"; // Can be set to particular file size , here it is 2 MB(2048 Kb)
        $config['max_width'] = 10000; // set max width image allowed
        $config['max_height'] = 10000; // set max height allowed
        $config['file_name'] = 'testimonials'.rand(10,100); //imagename auto chnage due to overwrite funcnality false
        $this->load->library('upload', $config);
        $this->upload->initialize($config);

        if (!$this->upload->do_upload('logo')) { //upload and validate
            $data['inputerror'][] = 'logo';
            $data['error_string'][] = 'Upload error: ' . $this->upload->display_errors('', ''); //show ajax error
            $data['status'] = FALSE;
            echo json_encode($data);
            exit();
        }
        return $this->upload->data('file_name');
    }

    private function _existCheck($id=null){
        $data = array();
        $data['error_string'] = [];
        $data['inputerror'] = [];
        $data['status'] = TRUE;

        $res = [];
        if(is_null($id)){
          $res = $this->testimonials->get_by_name($this->input->post('name'));
        }elseif(!is_null($id)){
           $res = $this->testimonials->get_by_name($this->input->post('name'),$id);
        }
       
        if(isset($res->id)){
            $data['inputerror'][] = 'name';
            $data['error_string'][] = 'name is already Exist';
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
        
        if ($this->input->post('name') == '') {
            $data['inputerror'][] = 'name';
            $data['error_string'][] = 'Name is required';
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
            $testimonials = $this->testimonials->get_by_id($id);
            if (file_exists('upload/banner/' . $testimonials->photo) && $testimonials->photo)
                unlink('upload/banner/' . $testimonials->photo);

            $this->commonDelete($this->table, $id);
            echo json_encode(array("status" => TRUE));
        }else {
            $returnData = array('No direct script access allowed');
            echo json_encode($returnData);
        }
    }

}
