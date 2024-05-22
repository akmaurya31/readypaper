<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Person extends MY_Controller
{

    protected $access = array('admin', 'teacher');
    private $table = "user";

    public function __construct()
    {
        parent::__construct();
        $this->load->model('person_model', 'person');
        $this->load->model('Userlog_model', 'userlog');
        $this->load->model('State_model', 'state');
        $this->load->model('state_quota_model', 'state_quota');
    }


    public function index()
    {
        $data['include'] = 'admin/views/person_view';
        $role = $this->session->userdata('role');
        if ($role == 'admin') {
            $data['title'] = "Create Teacher";
        } else {
            $data['title'] = "Teacher Profile";
        }
        $data['get_active_state'] = $this->state->get_active_state();
        $this->load->view("admin/layout/main", $data);
    }


    public function ajax_list()
    {
        $role = $this->session->userdata('role');
        $teacherid = $this->session->userdata('id');
        $this->load->helper('url');
        $list = $this->person->get_datatables($role);
        // echo $this->db->last_query();die;
        $data = array();
        $no = $_POST['start'];
        $i = 1;
        foreach ($list as $person) {
            $stateName = $this->state->get_by_id($person->state);
            $distName = $this->state_quota->get_by_id($person->district);
            $status = isset($person->status) && $person->status == 'Y' ? 'N' : 'Y';
            $no++;
            $row = array();
            $row[] = $i;
            if ($person->status == 'Y')
                $statusIs = '<a href="javascript:void(0)" class="btn btn-success btn-sm" title="Status Active" id="' . $person->id . '" onclick="statusUpdate(' . "'" . $person->id . "'" . "," . "'" . $status . "'" . ')"> <i class="fa fa-info-circle"></i></a>';
            else
                $statusIs = '<a href="javascript:void(0)" class="btn btn-warning btn-sm" title="Status Inctive" id="' . $person->id . '" onclick="statusUpdate(' . "'" . $person->id . "'" . "," . "'" . $status . "'" . ')"> <i class="fa fa-exclamation-triangle"></i></a>';
            //add html for action

            


          $row[] = '<div class="dropdown">
						<button type="button" class="btn btn-primary light sharp" data-bs-toggle="dropdown">
							<svg width="20px" height="20px" viewBox="0 0 24 24" version="1.1"><g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd"><rect x="0" y="0" width="24" height="24"/><circle fill="#000000" cx="5" cy="12" r="2"/><circle fill="#000000" cx="12" cy="12" r="2"/><circle fill="#000000" cx="19" cy="12" r="2"/></g></svg>
						</button>
						<div class="dropdown-menu">
							<a class="dropdown-item" href="javascript:void(0)"  title="Edit" onclick="edit_person(' . "'" . $person->id . "'" . ')"> Edit Teacher</a>  
							
						
						</div>
					</div>';
$row[] = $statusIs ;
            $row[] = date('d-M-Y', strtotime($person->created_at));
            if ($person->logo)
                $row[] = '<img src="' . base_url('upload/teacher/' . $person->logo) . '" class="img-responsive"  style="width:80%"/>';
            else
                $row[] = '(No photo)';
            $row[] = $person->username . '/<br>' . $person->role;

            $row[] = $person->firstName . ' / ' . $person->mobile_no . ' / ' . $person->email . ' <br> ' . $person->gender;
            $row[] = @$stateName->state_name. ', ' .@$distName->state_quota_name  . ', ' . @$person->pincode . '<br> ' . @$person->address;
            $data[] = $row;
            $i++;
        }
        // <a class="btn btn-sm btn-danger" href="javascript:void(0)" title="Delete" onclick="deleteData(' . "'" . $person->id . "'" . ')"><i class="glyphicon glyphicon-trash"></i> Delete</a>
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->person->count_all($role),
            "recordsFiltered" => $this->person->count_filtered($role),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }

    public function ajax_edit($id)
    {
        $data = $this->person->get_by_id($id);
        echo json_encode($data);
    }

    public function ajax_add()
    {
        $this->_validate();
        $password = sha1($this->input->post('password'));
        $data = array(

            'created_by' => $this->session->userdata('id'),
            'username' => $this->input->post('username'),
            'password' => $password,
            // 'salary'=>$this->input->post('salary'),
            'firstName' => $this->input->post('firstName'),
            'mobile_no' => $this->input->post('mobile_no'),
            'email' => $this->input->post('emailId'),
            'role' => $this->input->post('role'),
            'pass' => $this->input->post('password'),
            'address' => $this->input->post('address'),
            'pincode' => $this->input->post('pincode'),
            'gender' => $this->input->post('gender'),
             'dob' => $this->input->post('dob'),
            'state' => $this->input->post('state'),
            'district' => $this->input->post('district'),
        );

        if (!empty($_FILES['logo']['name'])) {
            $upload = $this->_do_upload();
            $data['logo'] = $upload;
        }

        $insert = $this->person->save($data);

        echo json_encode(array("status" => TRUE));
    }

    public function ajax_update()
    {
        $this->_validate();
        if (!empty($this->input->post('password'))) {
            $password = sha1($this->input->post('password'));
        } else {
            $password = $this->input->post('passwordhide');
        }
        $data = array(
            'username' => $this->input->post('username'),
            'password' => $password,
            // 'salary'=>$this->input->post('salary'),
            'firstName' => $this->input->post('firstName'),
            'mobile_no' => $this->input->post('mobile_no'),
            'email' => $this->input->post('emailId'),
            'role' => $this->input->post('role'),
            'pass' => $this->input->post('password'),
            'address' => $this->input->post('address'),
            'pincode' => $this->input->post('pincode'),
            'gender' => $this->input->post('gender'),
           'dob' => $this->input->post('dob'),
            'state' => $this->input->post('state'),
            'district' => $this->input->post('district'),
        );

        if ($this->input->post('remove_photo')) { // if remove photo checked
            if (file_exists('upload/teacher/' . $this->input->post('remove_photo')) && $this->input->post('remove_photo'))
                unlink('upload/teacher/' . $this->input->post('remove_photo'));
            $data['logo'] = '';
        }

        if (!empty($_FILES['logo']['name'])) {
            $upload = $this->_do_upload();

            //delete file
            $person = $this->person->get_by_id($this->input->post('id'));
            if (file_exists('upload/teacher/' . $person->logo) && $person->logo)
                unlink('upload/teacher/' . $person->logo);

            $data['logo'] = $upload;
        }

        $this->person->update(array('id' => $this->input->post('id')), $data);
        echo json_encode(array("status" => TRUE));
    }

    private function _do_upload()
    {
        $config['upload_path'] = './upload/teacher/'; //where is file upload path
        $config['allowed_types'] = "gif|jpg|png|jpeg"; //which file type you want to allow
        $config['overwrite'] = FALSE;
        $config['max_size'] = "2048000"; // Can be set to particular file size , here it is 2 MB(2048 Kb)
        $config['max_width'] = 10000; // set max width image allowed
        $config['max_height'] = 10000; // set max height allowed
        $config['file_name'] = 'teacher' . rand(10, 100); //imagename auto chnage due to overwrite funcnality false
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

    private function _validate()
    {
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
            $data['error_string'][] = 'Please select Teacher Name';
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


    public function activeInactivestatusUpdate()
    {
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


    public function getuserLog()
    {
        $userid =  $this->input->post('id');
        $res = $this->userlog->get_by_resId($userid);
        $i = 1;
        foreach ($res as $val) { ?>
            <table>
                <tr>
                    <th><?= $i ?></th>
                    <th>IP Address</th>
                    <td><?= $val->ipaddress ?></td>
                    <th>Date</th>
                    <td><?= $val->created_at ?></td>
                </tr>
            </table>
<?php $i++;
        }
    }
    
    
    public function teacherprofile(){
         $data['include'] = 'teacher/views/profile';
        $data['title'] = "Teacher Profile";
        $method = $this->session->userdata('id');
        $data['proResult']=$this->person->get_by_id($method);
        $data['get_active_state'] = $this->state->get_active_state();
        $data['get_state_quota'] = $this->state_quota->get_active_quota_test();
       
         if ($this->form_validation->run('profile')){				
            $filename = '';

                    if($_FILES['pic']['name']!=""){

                    /* --------------------First Image ----------------------------------- */
                    $filename = time().$_FILES['pic']['name']; 

                    $filename = time().$_FILES['pic']['name']; 
                    move_uploaded_file($_FILES["pic"]["tmp_name"],FCPATH."upload/".$filename);
                    $imagepath = $filename;

                    $save = FCPATH.'upload/teacher/' . $imagepath;
                    $file = FCPATH.'upload/' . $imagepath;
                     /*--------------First Image End-------------------------*/
                    }else{

                    $filename=$this->input->post('pichidden');
                    } 
                    
                    if (!empty($this->input->post('password'))) {
            $password = sha1($this->input->post('password'));
        } else {
            $password = $this->input->post('passwordhide');
        }
        $update = array(
            'logo'=>$filename,
            'username' => $this->input->post('username'),
            'password' => $password,
            // 'salary'=>$this->input->post('salary'),
            'firstName' => $this->input->post('firstName'),
            'mobile_no' => $this->input->post('mobile_no'),
            'email' => $this->input->post('emailId'),
            'role' =>'teacher',
            'pass' => $this->input->post('password'),
            'address' => $this->input->post('address'),
            'pincode' => $this->input->post('pincode'),
            'gender' => $this->input->post('gender'),
            'dob' => $this->input->post('dob'),
            'state' => $this->input->post('state'),
            'district' => $this->input->post('district'),
        );
                    
                    $res = $this->person->update(array('id' => $method),$update);	
                        if($res){
                        $this->session->set_flashdata('mass', 'details Updated Successfully!');			
                        return redirect('teacher_dashboard');
                    }
         }
        $this->load->view("admin/layout/main", $data);
    }
    
}
