<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class AttendanceRegister extends MY_Controller {
    
    protected $access = array('admin','employee','super_employee');
    private $table = "";
     
    public function __construct() {
        parent::__construct();
         $this->load->model('person_model', 'person');
         $this->load->model('Userlog_model', 'userlog');
    }

    public function index() {
        $data['title'] = "Attendance Register";
        $data['include'] = 'admin/attendanceRegister';
        $role = $this->session->userdata('role');
        $id = $this->session->userdata('id');
        $data['getdepartments'] =$this->person->get_active_teacher($role,$id);
        //echo $this->db->last_query();die;
        $this->load->view("admin/layout/main", $data);
    }
    
    public function getIpaddress() {
        $dates = $this->input->post('dates');
        $days = $this->input->post('day');
        $emp = $this->input->post('empid');
        $val =$this->userlog->get_by_Id($emp,$dates,$days);
        //echo $this->db->last_query();die;
        $i=1;
       // foreach($getIp as $val){?>
            <tr>
               
                <td><?= $val->created_at;// date('d M Y',strtotime())?></td>
                <td>
                    <?php 
                      if($this->session->userdata('role')=='admin'){?>
                    <a href="<?= base_url()?>count_question_report?emp=<?= $emp?>&dates=<?= $dates?>&days=<?= $days?>" class="text-danger"><?php $qname = countQuestion($val->created_by,$dates,$days); echo $qname;?> Click</a>
                    <?php } else{
                     $qname = countQuestion($val->created_by,$dates,$days); echo $qname;
                   
                     }?>
                    </td>
            </tr>
        <?php //$i++;}
    }
    
    
    

   


  
   
}
