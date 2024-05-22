<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin_profile extends MY_Controller {

    protected $access = array('admin');
    private $table = "user";

    public function __construct() {
        parent::__construct();
        $this->load->model('Admin_profile_model', 'person');
       
    }


    public function index() {
        $data['include'] = 'admin/views/admin_profile';        
		$data['title'] = "Admin Profile";
        $this->load->view("admin/layout/main", $data);
        
    }

  
    public function ajax_list() {
        $uri= $this->session->userdata('role');
        $this->load->helper('url');
        $list = $this->person->get_datatables($uri,$this->session->userdata('id'));
        $data = array();
        $no = $_POST['start'];
        $i=1;
        foreach ($list as $person) {
            $status = isset($person->status) && $person->status == 'Y' ? 'N' : 'Y';
            $no++;
         
            
            $row = array();
                  
            if($person->role=='teacher'){
                $role='Teacher';
            }else{
                $role=$person->role;
            }
            
            $row[] = $i;
            if ($person->status == 'Y')
                $statusIs = '<a href="javascript:void(0)" class="btn btn-success " title="Status Active" id="' . $person->id . '" onclick="statusUpdate(' . "'" . $person->id . "'" . "," . "'" . $status . "'" . ')"> <i class="fa fa-info-circle"></i></a>';
            else
                $statusIs = '<a href="javascript:void(0)" class="btn btn-warning " title="Status Inctive" id="' . $person->id . '" onclick="statusUpdate(' . "'" . $person->id . "'" . "," . "'" . $status . "'" . ')"> <i class="fa fa-exclamation-triangle"></i></a>';
            //add html for action
            
                $row[] = '' . $statusIs . '<a href="javascript:void(0)" class="btn btn-primary " title="Edit" onclick="edit_admin_profile(' . "'" . $person->id . "'" . ')"> <i class="fa fa-edit"></i></a>';
           

            if ($person->logo)
                $row[] = '<img src="' . base_url('upload/' . $person->logo) . '" class="img-responsive"  style="width:100%"/>';
            else
                $row[] = '(No photo)';
                
                $row[] = $person->username.'<br> '.$person->send_mail;
            $row[] = $role;
            
            $row[] = $person->firstName.' <br> '.$person->mobile_no.' <br> '.$person->email;
            $row[] = $person->address.' <br>'. $person->editor_api;
            $row[] = date('d-M-Y', strtotime($person->created_at));

            
            $data[] = $row;
            $i++;
        }
// <a class="btn btn-sm btn-danger" href="javascript:void(0)" title="Delete" onclick="deleteData(' . "'" . $person->id . "'" . ')"><i class="glyphicon glyphicon-trash"></i> Delete</a>
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->person->count_all(),
            "recordsFiltered" => $this->person->count_filtered(),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }

    public function ajax_edit($id) {
        $data = $this->person->get_by_id($id);
        //$data->dob = ($data->dob == '0000-00-00') ? '' : $data->dob; // if 0000-00-00 set tu empty for datepicker compatibility
        echo json_encode($data);
    }
    
 
    public function ajax_update() {
        $this->_validate();
        if (!empty($this->input->post('password'))) {
            $password = sha1($this->input->post('password'));
        } else {
            $password = $this->input->post('passwordhide');
        }
        $data = array(
            'username' => $this->input->post('username'),
            'password' => $password,           
            'firstName' => $this->input->post('firstName'),
            'mobile_no' => $this->input->post('mobile_no'),
            'email' => $this->input->post('emailId'),
            'role' => $this->input->post('role'), 
            'send_mail' => $this->input->post('send_mail'),
            'editor_api' => $this->input->post('editor_api'), 
            'address' => $this->input->post('address')
        );

        if ($this->input->post('remove_photo')) { // if remove photo checked
            if (file_exists('upload/' . $this->input->post('remove_photo')) && $this->input->post('remove_photo'))
                unlink('upload/' . $this->input->post('remove_photo'));
            $data['logo'] = '';
        }

        if (!empty($_FILES['logo']['name'])) {
            $upload = $this->_do_upload();

            //delete file
            $person = $this->person->get_by_id($this->input->post('id'));
            if (file_exists('upload/' . $person->logo) && $person->logo)
                unlink('upload/' . $person->logo);

            $data['logo'] = $upload;
        }

        $this->person->update(array('id' => $this->input->post('id')), $data);
        echo json_encode(array("status" => TRUE));
    }

    private function _do_upload() {
        $config['upload_path'] = './upload/'; //where is file upload path
        $config['allowed_types'] = "gif|jpg|png|jpeg"; //which file type you want to allow
        $config['overwrite'] = FALSE;
        $config['max_size'] = "2048000"; // Can be set to particular file size , here it is 2 MB(2048 Kb)
        $config['max_width'] = 10000; // set max width image allowed
        $config['max_height'] = 10000; // set max height allowed
        $config['file_name'] = 'ncs'.rand(10,1000); //imagename auto chnage due to overwrite funcnality false
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

    private function _validate() {
        $data = array();
        $data['error_string'] = array();
        $data['inputerror'] = array();
        $data['status'] = TRUE;
        
        if ($this->input->post('username') == '') {
            $data['inputerror'][] = 'username';
            $data['error_string'][] = 'Name is required';
            $data['status'] = FALSE;
        }      

       
        if ($this->input->post('role') == '') {
            $data['inputerror'][] = 'role';
            $data['error_string'][] = 'Please select role';
            $data['status'] = FALSE;
        }

        if ($this->input->post('firstName') == '') {
            $data['inputerror'][] = 'firstName';
            $data['error_string'][] = 'Please select Employee Name';
            $data['status'] = FALSE;
        }

        if ($this->input->post('mobile_no') == '') {
            $data['inputerror'][] = 'mobile_no';
            $data['error_string'][] = 'Mobile no is required';
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
            $returnData = $this->commonStatusUpdate($this->table, $data);
            echo json_encode($returnData);
            } else {
            $returnData = array('No direct script access allowed');
            echo json_encode($returnData);
        }
    }

   

}
