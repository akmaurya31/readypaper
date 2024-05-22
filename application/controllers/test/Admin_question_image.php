<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Admin_question_image extends MY_Controller {

    protected $access = array('admin','employee');
    private $table = "tbl_question_image_url";

    public function __construct() {
        parent::__construct();
        $this->load->model('Question_image_url_model', 'slider');
        $this->load->model('person_model', 'person');
       
       
        
    }

    public function index() {
        $data['include'] = 'admin/question_image_url';
		$data['title'] = "Question Image Url"; 
        $this->load->view("admin/layout/main", $data);
        
    }

  
    public function ajax_list() {
   
        $id= $this->session->userdata('id');
        
        $this->load->helper('url');
        $list = $this->slider->get_datatables($id);
        $data = array();
        $no = $_POST['start'];
        $i=1;
        foreach ($list as $slider) {
            $status = isset($slider->status) && $slider->status == 'Y' ? 'N' : 'Y';
            $no++;
            $row = array();            
            $row[] = $i; 
            $adminName=   $this->person->get_by_id($slider->created_by);
         
            $row[] = $adminName->firstName;           
           
            
            if ($slider->slider_image)
            $row[] = '<img src="' . base_url('upload/image/' . $slider->slider_image) . '" class="img-responsive" style="width:100%;"/>';
        else
            $row[] = '(No photo)';
            
             $row[] =  'https://readypaper.in/upload/image/'.$slider->slider_image;
              
            $row[] = date('d-M-Y', strtotime($slider->created_at));


           
       if($id==1){
            $row[] = ' <a class="btn  btn-danger " href="javascript:void(0)" title="Delete" onclick="deleteData(' . "'" . $slider->id . "'" . ')"><i class="fa fa-trash"></i> </a>
               
                ';
       }else{
            $row[] = ' ----- ';
       }
               
            

            $data[] = $row;
            $i++;
        }
 $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->slider->count_all($id),
            "recordsFiltered" => $this->slider->count_filtered($id),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }

  

    public function ajax_add() {
        
        $data = array(            
                      
            'created_by' => $this->session->userdata('id'),
        );

        if (!empty($_FILES['slider_image']['name'])) {
            $upload = $this->_do_upload();
            $data['slider_image'] = $upload;
        }

        $insert = $this->slider->save($data);

        echo json_encode(array("status" => TRUE));
    }

   

    private function _do_upload() {
        $config['upload_path'] = './upload/image/'; //where is file upload path
        $config['allowed_types'] = "gif|jpg|png|jpeg"; //which file type you want to allow
        $config['overwrite'] = FALSE;
        $config['max_size'] = "2048000"; // Can be set to particular file size , here it is 2 MB(2048 Kb)
        $config['max_width'] = 10000; // set max width image allowed
        $config['max_height'] = 10000; // set max height allowed
        $config['file_name'] = 'image'.rand(10,1000); //imagename auto chnage due to overwrite funcnality false
        $this->load->library('upload', $config);
        $this->upload->initialize($config);

        if (!$this->upload->do_upload('slider_image')) { //upload and validate
            $data['inputerror'][] = 'slider_image';
            $data['error_string'][] = 'Upload error: ' . $this->upload->display_errors('', ''); //show ajax error
            $data['status'] = FALSE;
            echo json_encode($data);
            exit();
        }
        return $this->upload->data('file_name');
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
            $slider = $this->slider->get_by_id($id);
            if (file_exists('upload/image/' . $slider->slider_image) && $slider->slider_image)
                unlink('upload/slider/' . $slider->slider_image);

            $this->commonDelete($this->table, $id);
            echo json_encode(array("status" => TRUE));
        }else {
            $returnData = array('No direct script access allowed');
            echo json_encode($returnData);
        }
    }

}
