<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Admin_contact extends MY_Controller
{

    protected $access = ['admin'];
    private $table = "tbl_contact";

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Contact_model', 'contact');
     
    }

    public function index()
    {
        $data['include'] = 'admin/contact_list';
        $data['title'] = "Contact Query";
        $this->load->view("admin/layout/main", $data);
    }


    public function ajax_list()
    {       
        $id = $this->session->userdata('id');
        $list = $this->contact->get_datatables($id);
        $data = array();
        $no = $_POST['start'];
        $i = 1;        
        foreach ($list as $admin) {
            $status = isset($admin->status) && $admin->status == 'Y' ? 'N' : 'Y';
            $no++;
            $row = array();
            $row[] = $i;
           
            $row[] = date('d-M-Y', strtotime($admin->create_date));
            $row[] = '<i class="fa fa-user"></i> '.$admin->name;
            $row[] = ' <i class="fa fa-envelope"></i> '.$admin->email;
            $row[] = '<i class="fa fa-phone"></i> '.$admin->mobile_no;
               
            $row[] = $admin->massge;
           
            $data[] = $row;
            $i++;
        }
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->contact->count_all($id),
            "recordsFiltered" => $this->contact->count_filtered($id),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }
    
    
    

   
}
