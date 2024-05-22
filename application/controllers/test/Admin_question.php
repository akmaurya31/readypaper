<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Admin_question extends MY_Controller
{

    protected $access = array('admin','employee','super_employee','teacher');
    private $table = "tbl_question";

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Question_model', 'question');
        $this->load->model('Class_model', 'class');
        $this->load->model('Subject_model', 'subject');
        $this->load->model('Board_type_model', 'board');
        $this->load->model('Class_subject_model', 'class_subject');
        $this->load->model('Correct_answer_model', 'correct_answer');
        $this->load->model('Chapter_model', 'chapter');
        $this->load->model('Employee_subject_model', 'employee_subject');
        $this->load->model('person_model', 'person');
         $this->load->model('Question_type_model', 'question_type');
         $this->load->model('Class_subject_question_type_model', 'class_subject_question_type');
         $this->load->model('Exercise_model', 'exercise');
         $this->load->model('School_model', 'school');
    }
    
    
     public function index()
    {
        $data['title'] = "Question";
        $data['getquestiontype'] = $this->question_type->get_active_section();
		$data['getexercise'] = $this->exercise->get_active_exercise();
        $data['include'] = 'admin/question/question_list';
        $this->load->view("admin/layout/main", $data);
    }
    
    
      public function ajax_list() {
   
        $id= $this->session->userdata('id');
        $role= $this->session->userdata('role');
        $chapter_id= $this->input->get('chapter_id');
        $clas_sub_id = $this->input->get('clas_sub_id');
        $this->load->helper('url');
        $list = $this->question->get_datatables($role,$id,$chapter_id);
       // echo $this->db->last_query();
        $data = array();
        $no = $_POST['start'];
        $i=1;
        foreach ($list as $question) {
            $status = isset($question->status) && $question->status == 'Y' ? 'N' : 'Y';
            $no++;
            $row = array();            
            $row[] = $i; 
            $adminName=   $this->person->get_by_id($question->created_by);
            $chapterName=   $this->chapter->get_by_id($question->chapter);
            $currect_ansName=   $this->correct_answer->get_by_id($question->currect_ans);
            $currect_2Name=   $this->correct_answer->get_by_id($question->currect_ans2);
            
             if($role=='admin' || $role=='super_employee'){
             if ($question->status == 'Y')
            $statusIs = '<a href="javascript:void(0)" class="btn btn-success " title="Status Active" id="' . $question->id . '" onclick="statusUpdate(' . "'" . $question->id . "'" . "," . "'" . $status . "'" . ')"> <i class="fa fa-info-circle"></i></a>';
        else
            $statusIs = '<a href="javascript:void(0)" class="btn btn-warning " title="Status Inactive" id="' . $question->id . '" onclick="statusUpdate(' . "'" . $question->id . "'" . "," . "'" . $status . "'" . ')"> <i class="fa fa-exclamation-triangle"></i></a>';
        //add html for action
       
                $row[] = date('d-M-Y', strtotime($question->created_at)).'<br>'.$adminName->firstName.'('.@$adminName->role.')<br>' . $statusIs . ' <a href="admin_question/questionEdit?editId='.$question->id.'&chapter_id='.$_GET['chapter_id'].'&clas_sub_id='.$_GET['clas_sub_id'].'" class="btn btn-info" title="Edit Question"> <i class="fa fa-edit"></i></a>                    ';
               }else{
		          $row[] = date('d-M-Y', strtotime($question->created_at)).'<br>'.@$adminName->firstName.'('.@$adminName->role.')<br><a href="admin_question/questionEdit?editId='.$question->id.'&chapter_id='.$_GET['chapter_id'].'&clas_sub_id='.$_GET['clas_sub_id'].'" class="btn btn-info" title="Edit Question"> <i class="fa fa-edit"></i></a>
		           <a class="btn  btn-danger " href="javascript:void(0)" title="Delete" onclick="deleteData(' . "'" . $question->id . "'" . ')"><i class="fa fa-trash"></i> </a>';
               } 
                
              //$row[] = ;          
          
          /*if($question->pic==''){
              $row[] = @$chapterName->chapter_name; 
          }else{
              
              $row[] =@$chapterName->chapter_name.'
              <br> <img src="' . base_url('upload/question/' . $question->pic) . '" class="img-responsive"  style="width:40%"/>
              <br> <img src="' . base_url('upload/question/' . $question->pic1) . '" class="img-responsive"  style="width:40%"/>'; 
              
          }
            */  
              
              if($question->question_type==5){
                  $row[] = '<h6>'.$question->question_name.'</h6>
                  <span> Option (a)'.$question->answer1.' </span> <br>
                  <span>Option (b)'.$question->answer2.' </span> <br>
                  <span>Option (c)'.$question->answer3.' </span><br> 
                  <span>Option (d)'.$question->answer4.'</span> <br>
                   Answer:-'.@$currect_ansName->correct_answer.' / '.@$currect_2Name->correct_answer.'<br>
                  <h6>Description:-'.$question->description_answer.'</h6><br>
                  <img src="' . base_url('upload/question/' . $question->pic) . '" class="img-responsive"  style="width:40%"/><br> 
                  <img src="' . base_url('upload/question/' . $question->pic1) . '" class="img-responsive"  style="width:40%"/>';
              
                
              }else{
                  $row[] =   '<h6>'.$question->question_name.'</h6><br>
                  Answer:-'.@$currect_ansName->correct_answer.' / '.@$currect_2Name->correct_answer. '<br>
                  <h6>Description:-'.$question->description_answer.'</h6><br>
                  <img src="' . base_url('upload/question/' . $question->pic) . '" class="img-responsive"  style="width:40%"/><br> 
                  <img src="' . base_url('upload/question/' . $question->pic1) . '" class="img-responsive"  style="width:40%"/>';
              }
             
            $data[] = $row;
            $i++;
        }
 $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->question->count_all($role,$id,$chapter_id),
            "recordsFiltered" => $this->question->count_filtered($role,$id,$chapter_id),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }

    

    public function all_list()
    {
        $data['title'] = "Question";
        $clas_sub_id = $_GET['clas_sub_id'];
        $class_subject_id = $this->class_subject->subject_class_id($clas_sub_id);
        $data['getquestiontype'] = $this->class_subject_question_type->get_class_subject_section($class_subject_id->class_id,$class_subject_id->subject_id);
        
		if ($this->form_validation->run('questionval')) {
		     $question = $this->input->post('question_name');
		     
		     $chaeckQuextion = $this->question->checkQuestion($question);

            $filename =  $_FILES['pic']['name'];
            move_uploaded_file($_FILES["pic"]["tmp_name"], FCPATH . "upload/question/" . $filename);
            $imagepath = $filename;

            $save = FCPATH . 'upload/peparquestion/' . $imagepath;
            $file = FCPATH . 'upload/question/' . $imagepath;


            //echo $file;die;
            if ($filename != "") {
                list($width, $height) = @getimagesize($file);
                $modwidth = 500;
                $diff = $width / $modwidth;
                $modheight = 300;
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
            }
            
            
            
            $filename1 =  $_FILES['pic1']['name'];
            move_uploaded_file($_FILES["pic1"]["tmp_name"], FCPATH . "upload/question/" . $filename1);
            $imagepath = $filename1;

            $save = FCPATH . 'upload/peparquestion/' . $imagepath;
            $file = FCPATH . 'upload/question/' . $imagepath;


            //echo $file;die;
            if ($filename1 != "") {
                list($width, $height) = @getimagesize($file);
                $modwidth = 500;
                $diff = $width / $modwidth;
                $modheight = 300;
                $tn = imagecreatetruecolor($modwidth, $modheight);
                $ext = pathinfo($filename1, PATHINFO_EXTENSION);

                if ($ext == 'jpg' || $ext == 'jpeg') {
                    $image = imagecreatefromjpeg($file);
                    imagecopyresampled($tn, $image, 0, 0, 0, 0, $modwidth, $modheight, $width, $height);
                    imagejpeg($tn, $save, 70);
                } else if ($ext == 'png') {

                    $image = imagecreatefrompng($file);
                    imagecopyresampled($tn, $image, 0, 0, 0, 0, $modwidth, $modheight, $width, $height);
                    imagepng(@$tn, @$save);
                }
            }


            $data = array(
                'pic' => $filename,
                 'pic1' => $filename1,
                'chapter' => $this->input->get('chapter_id'),
                'question_name' => $this->input->post('question_name'),
                'answer1' => $this->input->post('answer1'),
                'answer2' => $this->input->post('answer2'),
                'answer3' => $this->input->post('answer3'),
                'answer4' => $this->input->post('answer4'),
                'currect_ans' => $this->input->post('currect_ans'),
                'currect_ans2' => $this->input->post('currect_ans2'),
                'description_answer' => $this->input->post('description_answer'),
                'question_type' => $this->input->post('question_type'),
                'exercise_id' => $this->input->post('exercise_id'),
                'importent_id' => $this->input->post('importent_id'),
                 'class_sub_id' => $this->input->get('clas_sub_id'),
                 'created_by' =>$this->session->userdata('id')
                
            );
    if($chaeckQuextion){
        $this->session->set_flashdata('mass', ' Question All Ready  Inserted !');
        return redirect('admin_question/all_list?chapter_id='.$_GET['chapter_id'].'&clas_sub_id='.$_GET['clas_sub_id']);  
    }else{
    
        $insert = $this->question->save($data);
    
        $this->session->set_flashdata('mass', ' details Inserted Successfully!');
        return redirect('admin_question/all_list?chapter_id='.$_GET['chapter_id'].'&clas_sub_id='.$_GET['clas_sub_id']);
    
    }
            
        }
        $clas_sub_id = $this->input->get('clas_sub_id');
		$data['getcorrect_answer'] = $this->correct_answer->get_active_correct();
		//$data['getquestiontype'] = $this->question_type->get_active_section();
		
		
		$data['getexercise'] = $this->exercise->get_active_Quesexercise($clas_sub_id);
		$id = $this->session->userdata('id');
		$data['getSchool'] = $this->school->get_by_school_Admin($id);
        $data['include'] = 'admin/question/question';
        $this->load->view("admin/layout/main", $data);
    }
    
    
   /* public function all_list(){
    $data['title'] = "Question";

    if ($this->form_validation->run('questionval')) {
        $question = $this->input->post('question_name');
        $checkQuestion = $this->question->checkQuestion($question);

        $data = $this->uploadAndProcessImage($data, 'pic', 'pic');
        $data = $this->uploadAndProcessImage($data, 'pic1', 'pic1');

        $data = array(
            'pic' => @$data['pic'],
            'pic1' => @$data['pic1'],
            'chapter' => $this->input->get('chapter_id'),
            'question_name' => $this->input->post('question_name'),
            'answer1' => $this->input->post('answer1'),
            'answer2' => $this->input->post('answer2'),
            'answer3' => $this->input->post('answer3'),
            'answer4' => $this->input->post('answer4'),
            'currect_ans' => $this->input->post('currect_ans'),
            'currect_ans2' => $this->input->post('currect_ans2'),
            'description_answer' => $this->input->post('description_answer'),
            'question_type' => $this->input->post('question_type'),
            'exercise_id' => $this->input->post('exercise_id'),
            'importent_id' => $this->input->post('importent_id'),
            'class_sub_id' => $this->input->get('clas_sub_id'),
            'created_by' => $this->session->userdata('id')
        );

        if ($checkQuestion) {
            $this->session->set_flashdata('error', ' Question Already Inserted!');
        } else {
            $this->question->save($data);
            $this->session->set_flashdata('mass', 'Details Inserted Successfully!');
        }

        return redirect('admin_question/all_list?chapter_id=' . $_GET['chapter_id'] . '&clas_sub_id=' . $_GET['clas_sub_id']);
    }

    $clas_sub_id = $this->input->get('clas_sub_id');
    $data['getcorrect_answer'] = $this->correct_answer->get_active_correct();
    $data['getquestiontype'] = $this->question_type->get_active_section();
    $data['getexercise'] = $this->exercise->get_active_Quesexercise($clas_sub_id);
    $id = $this->session->userdata('id');
    $data['getSchool'] = $this->school->get_by_school_Admin($id);
    $data['include'] = 'admin/question/question';
    $this->load->view("admin/layout/main", $data);
}

private function uploadAndProcessImage($data, $fileInputName, $fileName)
{
    $filename = $_FILES[$fileInputName]['name'];
    if (!empty($filename)) {
        $file = FCPATH . "upload/question/" . $filename;
        move_uploaded_file($_FILES[$fileInputName]["tmp_name"], $file);
        list($width, $height) = @getimagesize($file);
        $modwidth = 500;
        $modheight = 300;
        $tn = imagecreatetruecolor($modwidth, $modheight);
        $ext = pathinfo($filename, PATHINFO_EXTENSION);
        if ($ext == 'jpg' || $ext == 'jpeg') {
            $image = imagecreatefromjpeg($file);
        } elseif ($ext == 'png') {
            $image = imagecreatefrompng($file);
        }
        imagecopyresampled($tn, $image, 0, 0, 0, 0, $modwidth, $modheight, $width, $height);
        $savePath = FCPATH . 'upload/peparquestion/' . $filename;
        if ($ext == 'jpg' || $ext == 'jpeg') {
            imagejpeg($tn, $savePath, 70);
        } elseif ($ext == 'png') {
            imagepng($tn, $savePath);
        }
        $data[$fileName] = $filename;
    }
    return $data;
}*/

    
    

 
  public function questionEdit()
    {
        $data['title'] = "Update Question";
		$clas_sub_id = $_GET['clas_sub_id'];
        $class_subject_id = $this->class_subject->subject_class_id($clas_sub_id);
        $data['getquestiontype'] = $this->class_subject_question_type->get_class_subject_section($class_subject_id->class_id,$class_subject_id->subject_id);
        
		$get = $this->input->get();
		$method = isset($get['editId']) && !empty($get['editId']) ? $get['editId'] : @$post['editId'];
		
		$data['proResult']=$this->question->get_by_id($method);
		
		 if ((isset($get['editId']) && !empty($get['editId'])
			 && is_numeric($get['editId'])) || (isset($post['editId']) && !empty($post['editId']) )) {
           
		 if ($this->form_validation->run('questionval')) {

          
                   $filename = '';
                    if($_FILES['pic']['name']!=""){

                    $filename = time().$_FILES['pic']['name']; 
                    move_uploaded_file($_FILES["pic"]["tmp_name"],FCPATH."upload/question/".$filename);
                    $imagepath = $filename;

                   $save = FCPATH . 'upload/peparquestion/' . $imagepath;
            $file = FCPATH . 'upload/question/' . $imagepath;
                    if($filename!=""){
                    list($width, $height) = @getimagesize($file) ; 
                    $modwidth = 500; 
                    $diff = $width / $modwidth;
                    $modheight = 300; 
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
            }

                    /*--------------First Image End-------------------------*/
                    }else{

                    $filename=$this->input->post('pichidden');
                    }	
                    
                    
                    $filename1 = '';

                    if($_FILES['pic1']['name']!=""){


                    $filename1 = time().$_FILES['pic1']['name']; 
                    move_uploaded_file($_FILES["pic1"]["tmp_name"],FCPATH."upload/question/".$filename1);
                    $imagepath = $filename1;

                   $save = FCPATH . 'upload/peparquestion/' . $imagepath;
            $file = FCPATH . 'upload/question/' . $imagepath;
                    if($filename1!=""){
                    list($width, $height) = @getimagesize($file) ; 
                    $modwidth = 500; 
                    $diff = $width / $modwidth;
                    $modheight = 300; 
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
            }

                    /*--------------First Image End-------------------------*/
                    }else{

                    $filename1=$this->input->post('pichidden1');
                    }	

            $data = array(
                'pic' => $filename,
                'pic1' => $filename1,
                'chapter' => $this->input->get('chapter_id'),
                'question_name' => $this->input->post('question_name'),
                'answer1' => $this->input->post('answer1'),
                'answer2' => $this->input->post('answer2'),
                'answer3' => $this->input->post('answer3'),
                'answer4' => $this->input->post('answer4'),
                'currect_ans' => $this->input->post('currect_ans'),
                'currect_ans2' => $this->input->post('currect_ans2'),
                'description_answer' => $this->input->post('description_answer'),
                'exercise_id' => $this->input->post('exercise_id'),
                'question_type' => $this->input->post('question_type'),
                 'importent_id' => $this->input->post('importent_id'),
                 'class_sub_id' => $this->input->get('clas_sub_id'),
            );

            $res = $this->question->update(array('id' => $method),$data);
            if ($res) {
                $this->session->set_flashdata('mass', ' Question Inserted Successfully!');
                 return redirect('admin_question?chapter_id='.$_GET['chapter_id'].'&clas_sub_id='.$_GET['clas_sub_id']);
            }
        }
		}
        $clas_sub_id = $this->input->get('clas_sub_id');
        $data['getcorrect_answer'] = $this->correct_answer->get_active_correct();
        //$data['getquestiontype'] = $this->question_type->get_active_section();
		$data['getexercise'] = $this->exercise->get_active_Quesexercise($clas_sub_id);
		$id = $this->session->userdata('id');
		$data['getSchool'] = $this->school->get_by_school_Admin($id);
        $data['include'] = 'admin/question/question_edit';
        $this->load->view("admin/layout/main", $data);
    }
    
    
public function getQuestionDelete() {
    $id = $this->input->post('id');

    if ($id) {
        $result = $this->question->delete_by_id($id);

        if ($result) {
            $response = array('status' => 'success', 'message' => 'Question deleted successfully');
        } else {
            $response = array('status' => 'error', 'message' => 'Failed to delete question');
        }
    } else {
        $response = array('status' => 'error', 'message' => 'Invalid request');
    }
   
    echo json_encode($response);
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
            $slider = $this->question->get_by_id($id);
            if (file_exists('upload/question/' . $slider->pic) && $slider->pic)
                unlink('upload/question/' . $slider->pic);

            $this->commonDelete($this->table, $id);
            echo json_encode(array("status" => TRUE));
        }else {
            $returnData = array('No direct script access allowed');
            echo json_encode($returnData);
        }
    }

    
}
