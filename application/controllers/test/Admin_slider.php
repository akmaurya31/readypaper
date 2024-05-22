<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Admin_slider extends MY_Controller {

    protected $access = array('admin','vendor');
    private $table = "slider";

    public function __construct() {
        parent::__construct();
        $this->load->model('Slider_model', 'slider');
        $this->load->model('person_model', 'person');
       
       
        
    }

    public function index() {
        $data['include'] = 'admin/slider/slider';
		$data['title'] = "Slider"; 
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
            $row[] = '<a href="' . base_url('upload/slider/' . $slider->slider_image) . '" target="_blank"><img src="' . base_url('upload/slider/' . $slider->slider_image) . '" class="img-responsive" style="width:100%;"/></a>';
        else
            $row[] = '(No photo)';
            $row[] = $slider->slider_heading;    
              $row[] = $slider->description;       
            $row[] = date('d-M-Y', strtotime($slider->created_at));


            if ($slider->status == 'Y')
            $statusIs = '<a href="javascript:void(0)" class="btn btn-success " title="Status Active" id="' . $slider->id . '" onclick="statusUpdate(' . "'" . $slider->id . "'" . "," . "'" . $status . "'" . ')"> <i class="fa fa-info-circle"></i></a>';
        else
            $statusIs = '<a href="javascript:void(0)" class="btn btn-warning " title="Status Inactive" id="' . $slider->id . '" onclick="statusUpdate(' . "'" . $slider->id . "'" . "," . "'" . $status . "'" . ')"> <i class="fa fa-exclamation-triangle"></i></a>';
        //add html for action
       
                $row[] = '' . $statusIs . ' <a href="javascript:void(0)" class="btn btn-primary " title="Edit slider" onclick="edit_slider(' . "'" . $slider->id . "'" . ')"> <i class="fa fa-edit"></i></a>
                <a class="btn  btn-danger " href="javascript:void(0)" title="Delete" onclick="deleteData(' . "'" . $slider->id . "'" . ')"><i class="fa fa-trash"></i> </a>
               
                ';
            

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

    public function ajax_edit($id) {
        $data = $this->slider->get_by_id($id);
        echo json_encode($data);
    }

    public function ajax_add() {
        $this->_validate();
       // $this->_existCheck($this->input->post('id'));
        $data = array(            
            'slider_heading' => $this->input->post('head'),
            'description' => $this->input->post('description'),           
            'created_by' => $this->session->userdata('id'),
        );

        if (!empty($_FILES['slider_image']['name'])) {
            $upload = $this->_do_upload();
            $data['slider_image'] = $upload;
        }

        $insert = $this->slider->save($data);

        echo json_encode(array("status" => TRUE));
    }

    public function ajax_update() {
        $this->_validate();
        //$this->_existCheck($this->input->post('id'));       
        $data = array(
            'slider_heading' => $this->input->post('head'),
            'description' => $this->input->post('description'),  
        );

        if ($this->input->post('remove_photo')) { // if remove photo checked
            if (file_exists('upload/slider/' . $this->input->post('remove_photo')) && $this->input->post('remove_photo'))
                unlink('upload/slider/' . $this->input->post('remove_photo'));
            $data['slider_image'] = '';
        }

        if (!empty($_FILES['slider_image']['name'])) {
            $upload = $this->_do_upload();

            //delete file
            $slider = $this->slider->get_by_id($this->input->post('id'));
            if (file_exists('upload/slider/' . $slider->slider_image) && $slider->slider_image)
                unlink('upload/slider/' . $slider->slider_image);

            $data['slider_image'] = $upload;
        }

        $this->slider->update(array('id' => $this->input->post('id')), $data);
        echo json_encode(array("status" => TRUE));
    }

    private function _do_upload() {
        $config['upload_path'] = './upload/slider/'; //where is file upload path
        $config['allowed_types'] = "gif|jpg|png|jpeg"; //which file type you want to allow
        $config['overwrite'] = FALSE;
        $config['max_size'] = "2048000"; // Can be set to particular file size , here it is 2 MB(2048 Kb)
        $config['max_width'] = 10000; // set max width image allowed
        $config['max_height'] = 10000; // set max height allowed
        $config['file_name'] = 'banner'.rand(10,1000); //imagename auto chnage due to overwrite funcnality false
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

  

    private function _validate() {
        $data = array();
        $data['error_string'] = array();
        $data['inputerror'] = array();
        $data['status'] = TRUE;
        
        if ($this->input->post('head') == '') {
            $data['inputerror'][] = 'head';
            $data['error_string'][] = 'Heading is required';
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
            if (file_exists('upload/slider/' . $slider->slider_image) && $slider->slider_image)
                unlink('upload/slider/' . $slider->slider_image);

            $this->commonDelete($this->table, $id);
            echo json_encode(array("status" => TRUE));
        }else {
            $returnData = array('No direct script access allowed');
            echo json_encode($returnData);
        }
    }

}
