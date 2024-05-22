<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Admin_menu extends MY_Controller {

    protected $access = array('admin','vendor');
    private $table = "tbl_menu";

    public function __construct() {
        parent::__construct();
        $this->load->model('menu_model', 'menu');
        $this->load->model('person_model', 'person');        
    }

    public function index() {
        $data['include'] = 'admin/menu/menu';
		$data['title'] = "Menu"; 
		$role= $this->session->userdata('role');
        $id = $this->session->userdata('id');
        
        $data['getCountList'] = $this->menu->getCountList($role,$id);
        $this->load->view("admin/layout/main", $data);
        
    }

  
    public function ajax_list() {
        $role= $this->session->userdata('role');
        $id = $this->session->userdata('id');
        $this->load->helper('url');
        $list = $this->menu->get_datatables($role,$id);
        $data = array();
        $no = $_POST['start'];
        $i=1;
        foreach ($list as $menu) {
            $status = isset($menu->status) && $menu->status == 'Y' ? 'N' : 'Y';
            $no++;
            $row = array();            
            $row[] = $i; 
            $adminName=   $this->person->get_by_id($menu->created_by);
           
            
            $row[] = $adminName->firstName;
            
            $row[] = $menu->menu_name;  
    
            if ($menu->bg_image)
            $row[] = '<img src="' . base_url('upload/banner/' . $menu->bg_image) . '" class="img-responsive" style="width:100%;"/>';
        else
            $row[] = '(No photo)';
                    
                   
            $row[] = date('d-M-Y', strtotime($menu->created_at));


            if ($menu->status == 'Y')
            $statusIs = '<a href="javascript:void(0)" class="btn btn-success " title="About" id="' . $menu->id . '" onclick="statusUpdate(' . "'" . $menu->id . "'" . "," . "'" . $status . "'" . ')"> <i class="fa fa-info-circle"></i></a>';
        else
            $statusIs = '<a href="javascript:void(0)" class="btn btn-warning " title="Policy" id="' . $menu->id . '" onclick="statusUpdate(' . "'" . $menu->id . "'" . "," . "'" . $status . "'" . ')"> <i class="fa fa-exclamation-triangle"></i></a>';
        //add html for action
       
                $row[] = '' . $statusIs . ' <a href="javascript:void(0)" class="btn btn-primary " title="Edit menu" onclick="edit_menu(' . "'" . $menu->id . "'" . ')"> <i class="fa fa-edit"></i></a>
                 <a href="'.base_url().'admin_menu_details?menu_id='.$menu->id.'" class="btn btn-info " title="Description" > <i class="fa fa-plus"></i></a>
               
                ';
            

            $data[] = $row;
            $i++;
        }
 $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->menu->count_all($role,$id),
            "recordsFiltered" => $this->menu->count_filtered($role,$id),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }

    public function ajax_edit($id) {
        $data = $this->menu->get_by_id($id);
        echo json_encode($data);
    }

    public function ajax_add() {
        $this->_validate();
       // $this->_existCheck($this->input->post('id'));
        $data = array(            
            'menu_name' => $this->input->post('menu_name'),
            'created_by' => $this->session->userdata('id'),
            'title' => $this->input->post('title'),
            'description' => $this->input->post('description'),
            'metakey' => $this->input->post('metakey'),
          
        );

        if (!empty($_FILES['bg_image']['name'])) {
            $upload = $this->_do_upload();
            $data['bg_image'] = $upload;
        }

        $insert = $this->menu->save($data);

        echo json_encode(array("status" => TRUE));
    }

    public function ajax_update() {
        $this->_validate();
        //$this->_existCheck($this->input->post('id'));       
        $data = array(
            'menu_name' => $this->input->post('menu_name'),
            'title' => $this->input->post('title'),
            'description' => $this->input->post('description'),
            'metakey' => $this->input->post('metakey'),
            
        );

        if ($this->input->post('remove_photo')) { // if remove photo checked
            if (file_exists('upload/banner/' . $this->input->post('remove_photo')) && $this->input->post('remove_photo'))
                unlink('upload/banner/' . $this->input->post('remove_photo'));
            $data['bg_image'] = '';
        }

        if (!empty($_FILES['bg_image']['name'])) {
            $upload = $this->_do_upload();

            //delete file
            $menu = $this->menu->get_by_id($this->input->post('id'));
            if (file_exists('upload/banner/' . $menu->bg_image) && $menu->bg_image)
                unlink('upload/banner/' . $menu->bg_image);

            $data['bg_image'] = $upload;
        }

        $this->menu->update(array('id' => $this->input->post('id')), $data);
        echo json_encode(array("status" => TRUE));
    }

    private function _do_upload() {
        $config['upload_path'] = './upload/banner/'; //where is file upload path
        $config['allowed_types'] = "gif|jpg|png|jpeg"; //which file type you want to allow
        $config['overwrite'] = FALSE;
        $config['max_size'] = "2048000"; // Can be set to particular file size , here it is 2 MB(2048 Kb)
        $config['max_width'] = 10000; // set max width bg_image allowed
        $config['max_height'] = 10000; // set max height allowed
        $config['file_name'] = 'menu'.rand(1,1000); //bg_imagename auto chnage due to overwrite funcnality false
        $this->load->library('upload', $config);
        $this->upload->initialize($config);

        if (!$this->upload->do_upload('bg_image')) { //upload and validate
            $data['inputerror'][] = 'bg_image';
            $data['error_string'][] = 'Upload error: ' . $this->upload->display_errors('', ''); //show ajax error
            $data['status'] = FALSE;
            echo json_encode($data);
            exit();
        }
        return $this->upload->data('file_name');
    }

   private function _existCheck($id=null){
        $data = array();
        $data['error_string'] = [];
        $data['inputerror'] = [];
        $data['status'] = TRUE;

        $res = [];
        if(is_null($id)){
          $res = $this->menu->get_by_name($this->input->post('menu_name'));
        }elseif(!is_null($id)){
           $res = $this->menu->get_by_name($this->input->post('menu_name'),$id);
        }
       
        if(isset($res->id)){
            $data['inputerror'][] = 'menu_name';
            $data['error_string'][] = 'name is already Exist';
            $data['status'] = FALSE;  
        } 
        
        if ($data['status'] === FALSE) {
            echo json_encode($data);
            exit();
        }
    }

    private function _validate() {
        $data = array();
        $data['error_string'] = array();
        $data['inputerror'] = array();
        $data['status'] = TRUE;
        
        if ($this->input->post('menu_name') == '') {
            $data['inputerror'][] = 'menu_name';
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
            $menu = $this->menu->get_by_id($id);
            if (file_exists('upload/banner/' . $menu->photo) && $menu->photo)
                unlink('upload/banner/' . $menu->photo);

            $this->commonDelete($this->table, $id);
            echo json_encode(array("status" => TRUE));
        }else {
            $returnData = array('No direct script access allowed');
            echo json_encode($returnData);
        }
    }

}
