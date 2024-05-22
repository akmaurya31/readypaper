<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Admin_menu_details extends MY_Controller
{

    protected $access = array('admin');
    private $table = "tbl_menu_content";

    public function __construct()
    {
        parent::__construct();
        $this->load->model('menu_model', 'menus');
        $this->load->model('menu_content_model', 'menu');
        $this->load->model('person_model', 'person');
    }

    public function index()
    {
        $data['include'] = 'admin/menu/menu_details';
        $data['title'] = "Menu Content";
        $this->load->view("admin/layout/main", $data);
    }


    public function ajax_list()
    {
        $uri = $this->session->userdata('role');
        $menuid = $_GET['menu_id'];
        $this->load->helper('url');
        $list = $this->menu->get_datatables($menuid);
        $data = array();
        $no = $_POST['start'];
        $i = 1;
        foreach ($list as $menu) {
            $status = isset($menu->status) && $menu->status == 'Y' ? 'N' : 'Y';
            $no++;
            $row = array();
            $row[] = $i;
           
            $menusName =   $this->menus->get_by_id($menu->menu_id);
              $row[] = @$menusName->menu_name;
             if ($menu->pic)
                $row[] = '<img src="' . base_url('upload/' . $menu->pic) . '" class="img-responsive" style="width:100%;"/>';
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

            $row[] = '' . $statusIs . ' <a href="admin_menu_details/menusEdit?editId='. $menu->id .'&menu_id='. $_GET['menu_id'] .'"  class="btn btn-primary " title="Edit menu" onclick="edit_menu(' . "'" . $menu->id . "'" . ')"> <i class="fa fa-edit"></i></a>
                 ';
            $data[] = $row;
            $i++;
        }
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->menu->count_all($menuid),
            "recordsFiltered" => $this->menu->count_filtered($menuid),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }

 

    public function menusAdd()
    {
        if ($this->form_validation->run('about')) {

          $filename = time().$_FILES['pic']['name']; 
                    move_uploaded_file($_FILES["pic"]["tmp_name"],FCPATH."upload/".$filename);
                    $imagepath = $filename;

                    $save = FCPATH.'upload/services/' . $imagepath;
                    $file = FCPATH.'upload/' . $imagepath;



            $filename1 = time() . $_FILES['bg_image']['name'];
            move_uploaded_file($_FILES["bg_image"]["tmp_name"], FCPATH . "upload/" . $filename1);
            $imagepath = $filename1;

            $save = FCPATH . 'upload/services/' . $imagepath;
            $file = FCPATH . 'upload/' . $imagepath;




            $data = array(
                'pic' => $filename,
                'bg_images' => $filename1,
                'heading' => $this->input->post('heading'),
                'content' => $this->input->post('content'),
                'menu_id' => $this->input->get('menu_id'),
                'created_by' => $this->session->userdata('id'),
            );

            $insert = $this->menu->save($data);
            if ($insert) {
                $this->session->set_flashdata('mass', 'menu details Inserted Successfully!');
                return redirect('admin_menu_details?menu_id=' . $_GET['menu_id']);
            }
        }
        $data['include'] = 'admin/menu/add_menu_details';
        $data['title'] = "Add menus Content";
        $this->load->view("admin/layout/main", $data);
    }




    public function menusEdit()
    {
        $data['include'] = 'admin/menu/edit_menu_details';
        $data['title'] = "Edit menus Content";

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
                    move_uploaded_file($_FILES["pic"]["tmp_name"],FCPATH."upload/".$filename);
                    $imagepath = $filename;

                    $save = FCPATH.'upload/services/' . $imagepath;
                    $file = FCPATH.'upload/' . $imagepath;
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
                    
                    
                    
                           $filename1 = '';

                    if($_FILES['bg_image']['name']!=""){

                    /* --------------------First Image ----------------------------------- */
                    $filename1 = time().$_FILES['bg_image']['name']; 

                    $filename1 = time().$_FILES['bg_image']['name']; 
                    move_uploaded_file($_FILES["bg_image"]["tmp_name"],FCPATH."upload/".$filename1);
                    $imagepath = $filename1;

                    $save = FCPATH.'upload/services/' . $imagepath;
                    $file = FCPATH.'upload/' . $imagepath;
                    /*if($filename1!=""){
                    list($width, $height) = @getimagesize($file) ; 
                    $modwidth = 600; 
                    $diff = $width / $modwidth;
                    $modheight = 600; 
                    $tn = imagecreatetruecolor($modwidth, $modheight) ;           
                    $ext = pathinfo($filename1, PATHINFO_EXTENSION);
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

                    $filename1=$this->input->post('pichidden1');
                    }

        $update = array(
            'pic' => $filename,
              'bg_images' => $filename1,
            'heading' => $this->input->post('heading'),
            'content' => $this->input->post('content'),
            'menu_id' => $this->input->get('menu_id'),
        );

        $res = $this->menu->update(array('id' => $method),$update);	
            if($res){
            $this->session->set_flashdata('mass', 'details Updated Successfully!');			
            return redirect('admin_menu_details?menu_id='.$_GET['menu_id']);
        }	
			
    }
 }

      
        // $data['menu'] =$this->category->get_active_category();
        $data['proResult']=$this->menu->get_by_id($method);
        $this->load->view("admin/layout/main", $data);
  
           

}

  


    #########################################################
    # active status and delete method is extended by My  
    # controller which is call common model method
    ###########################################################


    public function activeInactivestatusUpdate()
    {
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

    public function ajax_delete()
    {
        if ($this->input->is_ajax_request()) {
            //for delete file should write own code nut table data is automaticaly delete
            $id = $this->input->post('id');
            $menu = $this->menu->get_by_id($id);
            if (file_exists('upload/services/' . $menu->photo) && $menu->photo)
                unlink('upload/services/' . $menu->photo);

            $this->commonDelete($this->table, $id);
            echo json_encode(array("status" => TRUE));
        } else {
            $returnData = array('No direct script access allowed');
            echo json_encode($returnData);
        }
    }
}
