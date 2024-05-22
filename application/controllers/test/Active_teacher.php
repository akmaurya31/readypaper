<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Active_teacher extends MY_Controller {

    protected $access = array('admin');
    private $table = "user";

    public function __construct() {
        parent::__construct();
        $this->load->model('Active_person_model', 'person');
        $this->load->model('Userlog_model', 'userlog');  
        $this->load->model('State_model', 'state');
        $this->load->model('state_quota_model', 'state_quota');
        $this->load->model('Plan_model', 'plan_FreeSrvices');
        $this->load->model('Order_model', 'order');
        $this->load->model('person_model', 'per_sion');
    }


    public function index() {
        $data['title'] = "Active Teacher";
        $data['include'] = 'admin/active_teacher';
        $role= $this->session->userdata('role');
        $data['getFreePlan'] = $this->plan_FreeSrvices->getFreePlan();
         $this->load->view("admin/layout/main", $data);
    }
    
    
  

    public function save_orderPlanFREE() {
        $plan_id = $this->input->post('plan_id');
        $teacher_id = $this->input->post('teacher_id');
        
        $getFreePlan = $this->plan_FreeSrvices->getFreePlanTecaher($plan_id);
        $getperson = $this->per_sion->get_by_id($teacher_id);
        
        $data = array(            
                    //'merchantId' => $merchantId,
                    'merchantTransactionId' =>0, // test transactionID
                    "merchantUserId"=>0,
                    "merchantOrderId"=>0,
                    'code' =>'PAYMENT_SUCCESS',
                    "checksum"=>0,
                    'merchantTransactionId' =>0,
                    'providerReferenceId' =>0,
                    'perches_date' =>0,
                    
                    "mobileNumber"=>$getperson->mobile_no,
                    "name"=>$getperson->firstName,
                    "email"=>$getperson->email,
                    
                    "plangst"=>0,
                    "amount"=>0,
                    "planprice"=>0,
                    "plan_id"=>$getFreePlan->id,
                    "plan_name"=>$getFreePlan->heading,
                    "plan_start_date"=>$getFreePlan->start_date,
                    
                    "plan_end_date"=>$getFreePlan->end_date,
                    "plan_validity"=>$getFreePlan->validity,
                    "plan_pepar_qty"=>$getFreePlan->pepar_qty,
                    "qty_less_plan"=>$getFreePlan->pepar_qty,
                    "plan_subject_id"=>$getFreePlan->subject_id,
                    'total_amount'=>0,
                    'is_free'=>1,
                    "teacher_id"=>$this->input->post('teacher_id'),
                    'created_by'=>$this->session->userdata('id')
                    );
                    //print_r($data);die;
                  $res = $this->order->save($data);

        echo 1;
    }
  
  
  
    public function ajax_list() {
        $role= $this->session->userdata('role');
        $teacherid = $this->session->userdata('id');
        $this->load->helper('url');
        $list = $this->person->get_datatables($role);
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
								<a class="dropdown-item" href="javascript:; class="btn btn-danger btn-sm" title="free Payment" onclick="getFreePlan('.$person->id.')"> Free Plan </a>
						    	<a class="dropdown-item" href="admin_order/teacher_order?tea_id='.$person->id.'" class="btn btn-danger btn-sm" title="Payment" > Teacher Payment</a>
						</div>
					</div>';
$row[] = $statusIs ;
            $row[] = date('d-M-Y', strtotime($person->created_at));
            if ($person->logo)
                $row[] = '<img src="' . base_url('upload/teacher/' . $person->logo) . '" class="img-responsive"  style="width:80%"/>';
            else
                $row[] = '(No photo)';
            $row[] =  $person->username . '/<br>(' . $person->role.')';

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

   


}
