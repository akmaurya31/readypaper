<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Admin_service_plan extends MY_Controller {

    protected $access = array('admin');
    private $table = "tbl_plan";

    public function __construct() {
        parent::__construct();
        $this->load->model('plan_model', 'menu');
        $this->load->model('person_model', 'person'); 
        $this->load->model('Subject_model', 'subject'); 
    }

    public function index() {
        $data['include'] = 'admin/service_plan/service_plan';
		$data['title'] = "Service Plan"; 
		$data['getSubject'] = $this->subject->get_active_subject();
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
            $subjectName=   $this->subject->get_by_id($menu->subject_id);
            //$row[] = $adminName->firstName;
             if ($menu->status == 'Y')
                $statusIs = '<a href="javascript:void(0)" class="btn btn-success " title="Status Active" id="' . $menu->id . '" onclick="statusUpdate(' . "'" . $menu->id . "'" . "," . "'" . $status . "'" . ')"> <i class="fa fa-info-circle"></i></a>';
            else
                $statusIs = '<a href="javascript:void(0)" class="btn btn-warning " title="Status Inactive" id="' . $menu->id . '" onclick="statusUpdate(' . "'" . $menu->id . "'" . "," . "'" . $status . "'" . ')"> <i class="fa fa-exclamation-triangle"></i></a>';
            
             $row[] = $statusIs;
            if ($menu->pic)
            $row[] = '<img src="' . base_url('upload/' . $menu->pic) . '" class="img-responsive" style="width:100%;"/>';
            else
            $row[] = '(No photo)';
            
             
            if ($menu->free_plan == 1){
                 $row[] = $menu->heading."<br><h5 class='text-success'>Free Plan</h5>";
                }else{
                    $row[] =$menu->heading."<br><h5 class='text-danger'>Not Free Plan</h5>";
                }
               
            
            $empGroupName =   $this->menu->get_by_user($menu->heading);
            
            $empid = '';
            foreach($empGroupName as $val){
                $subjecName=   $this->subject->get_by_id($val->subject_id);
                $empid.= $subjecName->subject_name.',';
            }
            
            $row[] = $empid;
            $row[] = $menu->pepar_qty; 
            $row[] = '<a class="text-warning " href="javascript:void(0)" title="Delete" onclick="editPlan(' . $menu->id . ',' . $menu->price . ',' . "'" . $menu->start_date . "'" . ',' . "'" . $menu->end_date . "'" . ','. $menu->pepar_qty.','.$menu->validity.' )">Start Date:- '.$menu->start_date.' & End Date:- '.$menu->end_date.'</a>'; 
             $row[] = $menu->validity.' Month' ;  
            $row[] = 'Rs '.$menu->price;  
            $row[] = $menu->content;
            $row[] = date('d-M-Y', strtotime($menu->created_date));
            $data[] = $row;
            $i++;
        }
        //<a class="btn  btn-danger " href="javascript:void(0)" title="Delete" onclick="deleteData(' . "'" . $menu->id . "'" . ')"><i class="fa fa-trash"></i> </a>
        // <a href="admin_service_plan/menusEdit?editId='. $menu->id .'"  class="btn btn-primary " title="Edit menu"> <i class="fa fa-edit"></i></a>
                 
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
        $data['getSubject'] = $this->subject->get_active_subject();
        if ($this->form_validation->run('about')) {

            $filename = time() . $_FILES['pic']['name'];
            move_uploaded_file($_FILES["pic"]["tmp_name"], FCPATH . "upload/" . $filename);
            $imagepath = $filename;

            $save = FCPATH . 'upload/services/' . $imagepath;
            $file = FCPATH . 'upload/' . $imagepath;


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

           
                $count = count($this->input->post('subject_id'));
                $subjectid = $this->input->post('subject_id');
                $insert_data = array();
                
                for ($i = 0; $i < $count; $i++) {
                    $insert_data[] = array(
                        'price' => $this->input->post('price'),
                        'plan_price' => $this->input->post('plan_price'),
                        'gst' => $this->input->post('gst'),
                        'heading' => $this->input->post('heading'),
                        'content' => $this->input->post('content'),
                         'subject_id' => $subjectid[$i],
                        'pepar_qty' => $this->input->post('pepar_qty'),
                        'start_date' => $this->input->post('start_date'),
                        'end_date' => $this->input->post('end_date'),
                        'validity' => $this->input->post('validity'),
                         'free_plan' => $this->input->post('free_plan'),
                        
                        'pic' => $filename,
                        'created_by' => $this->session->userdata('id'),
                    );
                }
                
         $insert =   $this->db->insert_batch('tbl_plan', $insert_data); 
            if ($insert) {
                $this->session->set_flashdata('mass', 'menu details Inserted Successfully!');
                return redirect('admin_service_plan');
            }
        }
        $data['include'] = 'admin/service_plan/add_service_plan';
        $data['title'] = "Add Plan";
        $this->load->view("admin/layout/main", $data);
    }




   public function getPlanUpdate()
    {     
        $method = $this->input->post('id');
        $validite = $this->input->post('validite');
        $qty = $this->input->post('qty');
        $price = $this->input->post('price');
        $end_date = $this->input->post('end_date');
        
        $update = array(
            'start_date' => $this->input->post('start_date'),
            'end_date' => $this->input->post('end_date'),
        );

        $this->menu->update(array(//'id' => $method,
                                  'price'=>$price,
                                  'validity'=>$validite,
                                  'pepar_qty'=>$qty,
                                  //'end_date'=>$end_date,
                                  ),$update);	
        //echo $this->db->last_query();die;                          
                                  echo 1;
      
 }

function getShow(){
    $name = $this->input->post('name');
    $res = $this->menu->get_by_user($name);
    foreach($res as $val){
    $subjectName =   $this->subject->get_by_id($val->subject_id);
    ?>
    <tr>
        <td><?= $subjectName->subject_name?></td>
        </tr>
   <?php }
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
        if (file_exists('upload/' . $menu->pic) && $menu->pic)
            unlink('upload/' . $menu->pic);

        $this->commonDelete($this->table, $id);
        echo json_encode(array("status" => TRUE));
    }else {
        $returnData = array('No direct script access allowed');
        echo json_encode($returnData);
    }
}

}
