<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Admin_teacher_ad extends MY_Controller {

    protected $access = array('admin','employee');
    private $table = "tbl_teacher_ad";

    public function __construct() {
        parent::__construct();
        $this->load->model('Teacher_ads_model', 'menu');
        $this->load->model('person_model', 'person');        
    }

    public function index() {
        $data['include'] = 'admin/teacher_ad/teacher_ad';
		$data['title'] = "Ads Show"; 		
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

            if ($menu->pic)
            $row[] = '<img src="' . base_url('upload/company/' . $menu->pic) . '" class="img-responsive" style="width:100%;"/>';
            else
            $row[] = '(No photo)';

            $row[] = $menu->heading;            
            $row[] = $menu->content;          
                   
            $row[] = date('d-M-Y', strtotime($menu->created_date));


            
            if ($menu->status == 'Y')
                $statusIs = '<a href="javascript:void(0)" class="btn btn-success " title="Status Active" id="' . $menu->id . '" onclick="statusUpdate(' . "'" . $menu->id . "'" . "," . "'" . $status . "'" . ')"> <i class="fa fa-info-circle"></i></a>';
            else
                $statusIs = '<a href="javascript:void(0)" class="btn btn-warning " title="Status Inactive" id="' . $menu->id . '" onclick="statusUpdate(' . "'" . $menu->id . "'" . "," . "'" . $status . "'" . ')"> <i class="fa fa-exclamation-triangle"></i></a>';
            //add html for action

            $row[] = '' . $statusIs . ' <a href="admin_teacher_ad/menusEdit?editId='. $menu->id .'"  class="btn btn-primary " title="Edit menu"> <i class="fa fa-edit"></i></a>
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



    public function menusAdd()
    {
        if ($this->form_validation->run('about')) {

            $filename = time() . $_FILES['pic']['name'];
            move_uploaded_file($_FILES["pic"]["tmp_name"], FCPATH . "upload/company/" . $filename);
            $imagepath = $filename;

            $save = FCPATH . 'upload/' . $imagepath;
            $file = FCPATH . 'upload/company/' . $imagepath;


            //echo $file;die;
          /*  if ($filename != "") {
                list($width, $height) = @getimagesize($file);
                $modwidth = 500;
                $diff = $width / $modwidth;
                $modheight = 350;
                $tn = imagecreatetruecolor($modwidth, $modheight);
                $ext = pathinfo($filename, PATHINFO_EXTENSION);

                if ($ext == 'jpg' || $ext == 'jpeg') {
                    $image = imagecreatefromjpeg($file);
                    imagecopyresampled($tn, $image, 0, 0, 0, 0, $modwidth, $modheight, $width, $height);
                    imagejpeg($tn, $save, 70);
                } else if ($ext == 'png') {

                    $image = imagecreatefrompng($file);
                    imagecopyresampled($tn, $image, 0, 0, 0, 0, $modwidth, $modheight, $width, $height);
                    imagepng(@$tn, @$save);
                }
            }*/


            


            $data = array(               
                'heading' => $this->input->post('heading'),
                'content' => $this->input->post('content'),
                'pic' => $filename,               
                'created_by' => $this->session->userdata('id'),
            );

            $insert = $this->menu->save($data);
            if ($insert) {
                $this->session->set_flashdata('mass', 'menu details Inserted Successfully!');
                return redirect('admin_teacher_ad');
            }
        }
        $data['include'] = 'admin/teacher_ad/add_teacher_ad';
        $data['title'] = "Add Ads";
        $this->load->view("admin/layout/main", $data);
    }




    public function menusEdit()
    {
        $data['include'] = 'admin/teacher_ad/edit_teacher_ad';
        $data['title'] = " Ads";

	    $get = $this->input->get();
		
		$method = isset($get['editId']) && !empty($get['editId']) ? $get['editId'] : @$post['editId']; 
		
		 if ((isset($get['editId']) && !empty($get['editId'])
			 && is_numeric($get['editId'])) || (isset($post['editId']) && !empty($post['editId']) )) {
				
            if ($this->form_validation->run('about')){				
            $filename = '';

                    if($_FILES['pic']['name']!=""){

                    /* --------------------First Image ----------------------------------- */
                    $filename = time().$_FILES['pic']['name']; 

                    $filename = time().$_FILES['pic']['name']; 
                    move_uploaded_file($_FILES["pic"]["tmp_name"],FCPATH."upload/company/".$filename);
                    $imagepath = $filename;

                    $save = FCPATH.'upload/' . $imagepath;
                    $file = FCPATH.'upload/company/' . $imagepath;
                    /*if($filename!=""){
                    list($width, $height) = @getimagesize($file) ; 
                    $modwidth = 600; 
                    $diff = $width / $modwidth;
                    $modheight = 600; 
                    $tn = imagecreatetruecolor($modwidth, $modheight) ;           
                    $ext = pathinfo($filename, PATHINFO_EXTENSION);
                    if($ext=='jpg' || $ext=='jpeg'){
                    $image = imagecreatefromjpeg($file) ; 
                    imagecopyresampled($tn, $image, 0, 0, 0, 0, $modwidth, $modheight, $width, $height) ; 
                    imagejpeg($tn, $save, 70) ; 
                    }
                    else if($ext=='png'){                      
                    $image = imagecreatefrompng($file) ;  
                    imagecopyresampled($tn, $image, 0, 0, 0, 0, $modwidth, $modheight, $width, $height) ; 
                    imagepng(@$tn, @$save) ;   
                    }         
            }*/

                    /*--------------First Image End-------------------------*/
                    }else{

                    $filename=$this->input->post('pichidden');
                    }
                    
                    
                    
                          

        $update = array(
          
            'heading' => $this->input->post('heading'),
            'content' => $this->input->post('content'),
          'pic' => $filename,
        );

        $res = $this->menu->update(array('id' => $method),$update);	
            if($res){
            $this->session->set_flashdata('mass', 'details Updated Successfully!');			
            return redirect('admin_teacher_ad');
        }	
			
    }
 }

      
        $data['proResult']=$this->menu->get_by_id($method);
        $this->load->view("admin/layout/main", $data);
  
           

}
  
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
