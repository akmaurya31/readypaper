<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Inactive_teacher extends MY_Controller {

    protected $access = array('admin');
    private $table = "user";

    public function __construct() {
        parent::__construct();
        $this->load->model('Inactive_person_model', 'person');
        $this->load->model('Userlog_model', 'userlog');
             $this->load->model('State_model', 'state');
        $this->load->model('state_quota_model', 'state_quota');
    }


    public function index() {
        $data['title'] = "Inactive Teacher";
        $data['include'] = 'admin/inactive_teacher';
        $role= $this->session->userdata('role');
       
        $this->load->view("admin/layout/main", $data);
    }

  
    public function ajax_list() {
        $role= $this->session->userdata('role');
        $teacherid = $this->session->userdata('id');
        $this->load->helper('url');
        $list = $this->person->get_datatables();
       // echo $this->db->last_query();die;
        $data = array();
        $no = $_POST['start'];
        $i=1;
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
							<a class="dropdown-item" href="admin_order/teacher_order?tea_id='.$person->id.'" class="btn btn-danger btn-sm" title="Payment" > Teacher Payment</a>
						
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
            "recordsTotal" => $this->person->count_all(),
            "recordsFiltered" => $this->person->count_filtered(),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }

   


}
