<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Teacher_instruction extends MY_Controller {

    protected $access = array('teacher');
    private $table = "tbl_instruction";

    public function __construct() {
        parent::__construct();
        $this->load->model('instruction_model', 'instruction');
        $this->load->model('person_model', 'person');         
    }

    public function index() {
        $data['include'] = 'teacher/instruction';
		$data['title'] = "Instruction"; 
		$id= $this->session->userdata('id');		
        $this->load->view("admin/layout/main", $data);
        
    }


    public function ajax_add() {  
        $data = array(            
            'instruction_name' => $this->input->post('instruction_name'),
            'pepar_id' => $this->input->post('pepar_id'),                   
            'created_by' => $this->session->userdata('id'),
        ); 
        $this->instruction->save($data);
    }

    
    public function get_all_instruction() {
        $id= $this->session->userdata('id');
        $pepar= $this->input->get('pepar_id');   

        $list = $this->instruction->get_all_instruction($pepar,$id);
        $i=1;
        foreach ($list as $instruction) {?>
        
        <div class="col-xl-9">
            <h4>Instruction<?= $i?></h4>
            <p><?= $instruction->instruction_name?></p>
        </div>
        <div class="col-xl-3">
        <a href="javascript:void(0)" class="btn btn-default "  onclick="edit_instruction(<?= $instruction->id?>)"> <i class="fa fa-edit"></i></a>
        <a class="btn  btn-default " href="javascript:void(0)" title="Delete" onclick="delete_instruction(<?= $instruction->id?>)"><i class="fa fa-trash"></i> </a>
        </div>
      
       <?php  $i++;}
    }

    

    public function delete_instruction() {
        $id= $this->session->userdata('id');
        $pepar = $this->input->get('id'); 
        $this->instruction->delete_by_id($pepar);
    }


    public function edit_instruction($id) {
        $data = $this->instruction->get_by_id($id);        
        echo json_encode($data);
    }




    public function ajax_update() {
        //$this->_validate();
        //$this->_existCheck($this->input->post('id'));       
        $data = array(
            'instruction_name' => $this->input->post('instruction_name'),
        );

        $this->instruction->update(array('id' => $this->input->post('id')), $data);
        echo $this->db->last_query();die;
        echo json_encode(array("status" => TRUE));
    }




}
