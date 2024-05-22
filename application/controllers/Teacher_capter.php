<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Teacher_capter extends MY_Controller {

    protected $access = array('admin','teacher');
    private $table = "tbl_teacher_capter";

    public function __construct() {
        parent::__construct();
        $this->load->model('Capter_question_model', 'capter_question');
        $this->load->model('Question_model', 'question');
        $this->load->model('Pepar_model', 'pepar');
        $this->load->model('person_model', 'person');
        $this->load->model('Order_model', 'order');
    }

    


	public function index()
	{
       $data['title'] = "Capter";
       $empId = $this->session->userdata('id');
       $date = date('Y-m-d');
       $role = $this->session->userdata('role');
        $pepar_id =  base64_decode($_GET['pepar_id']);
       
       $check = $this->order->checkPlanTeacher($empId);
       $qty = subject_QTY_teacher($check->id) ?? 0;
          // if($check){
        $data['getTeacher'] = $this->pepar->get_active_teacher_pepar($empId,$pepar_id);
       // echo $this->db->last_query();die;
        $checked = $this->capter_question->checked_by_question($empId,$pepar_id);
        
        if ($this->form_validation->run('chapterQuestion')) {
            $capterIds = $this->input->post('capter_id');
        
            $insert_data = [];
            foreach ($capterIds as $capterId) {
                $insert_data[] = [
                    'pepar_id' => $pepar_id,
                    'capter_id' => $capterId,
                    'created_by' => $this->session->userdata('id'),
                ];
            }
        
            $deleted = $checked ? $this->capter_question->delete_by_teacher($empId, $pepar_id) : 0;
            $res = $this->db->insert_batch('tbl_capter_question', $insert_data);
            return redirect('teacher_question?pepar_id=' . $_GET['pepar_id'].'&type_id='. 5);
        }

		$data['include'] = 'teacher/teacher_capter';
        $this->load->view("admin/layout/main", $data);
            //}else{
              // return redirect('teacher_plan'); 
            //}
	}
	
	

	
	
	
	
	 

	
	
	
}

