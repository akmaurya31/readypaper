<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Admin_order extends CI_Controller
{
    protected $access = array('admin');
    private $table = "tbl_order";

    public function __construct() {
        parent::__construct();
        $this->load->model('Order_model', 'order');
        $this->load->model('person_model', 'person'); 
       // $this->load->model('User_address_model', 'customer');  
         //  $this->load->model('Order_payment_model', 'order_payment');
    }

    public function index() {
        $data['include'] = 'admin/allorder';
		$data['title'] = "All Payment Order";
		$starting_date = @$this->input->get('starting_date');
		$ending_date = @$this->input->get('ending_date');
	
		$data['allOrder'] = $this->order->get_by_Order($starting_date,$ending_date);
		//echo $this->db->last_query();
        $this->load->view("admin/layout/main", $data);
    }
    
    
    
      public function pending_order() {
        $data['include'] = 'admin/pending_order';
		$data['title'] = " Pending Payment";
			$data['allOrder'] = $this->order->get_by_pending_Order();
		//echo $this->db->last_query();
        $this->load->view("admin/layout/main", $data);
    }
    
    public function success_order() {
        $data['include'] = 'admin/success_order';
		$data['title'] = "Success Payment";
		//$starting_date = @$this->input->get('starting_date');
		//$ending_date = @$this->input->get('ending_date');
	
		$data['allOrder'] = $this->order->get_by_success_Order();
		//echo $this->db->last_query();
        $this->load->view("admin/layout/main", $data);
    }
    
    
    
    public function teacher_order() {
        $data['include'] = 'admin/teacher_order';
		$data['title'] = "Teacher Payment";
		$tea_id = @$this->input->get('tea_id');
	
	
		$data['allOrder'] = $this->order->get_by_teacher_Order($tea_id);
		//echo $this->db->last_query();
        $this->load->view("admin/layout/main", $data);
    }
    
}
