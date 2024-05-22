<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin_import_question extends MY_Controller {
    protected $access = array('admin','employee','super_employee','teacher');
    private $table = "tbl_question";
     
    public function __construct() {
        parent::__construct();
        $this->load->model('Import_question_model', 'question');
    }


    public function index() {
        $data['title'] ="Import Question for excel csv file";
        $data['include'] = 'admin/import_question';
        $this->load->view("admin/layout/main", $data);
    }


    public function insert() {
            $data['include'] = 'admin/import_question';
            $data['title'] ="Import Question for excel csv file";
            
			$file = $_FILES['file']['tmp_name'];
			$handle = fopen($file, "r");
			$c = 0;//
			while(($filesop = fgetcsv($handle, 10000, ",")) !== false)
			{
            
            $id = $filesop[0];
            $pic = $filesop[1];
            $pic1 = $filesop[2];
            $chapter = $filesop[3];
            $question_name = $filesop[4];
            $answer1 = $filesop[5];
            $answer2 = $filesop[6];
            $answer3 = $filesop[7];
            $answer4 = $filesop[8];
            $currect_ans = $filesop[9];
            $currect_ans2 = $filesop[10];
            $description_answer = $filesop[11];
            $status = $filesop[12];
            $created_by = $filesop[13];
            $created_at = $filesop[14];
            $question_type = $filesop[15];
            $exercise_id = $filesop[16];
            $class_sub_id = $filesop[17];
            $school_id = $filesop[18];
            $importent_id = @$filesop[19];
            
				if($c<>0){
					$this->question->save($id,$pic,$pic1,$chapter,$question_name,$answer1,$answer2,$answer3,$answer4,$currect_ans,$currect_ans2,
					$description_answer,$status,$created_by,$created_at,$question_type,$exercise_id,$class_sub_id,$school_id,$importent_id);
				}
				$c = $c + 1;
			}
		
            $this->session->set_flashdata('success_message', 'Sucessfully import data!');			
            return redirect('admin_question?chapter_id='.$_GET['chapter_id'].'&clas_sub_id='.$_GET['clas_sub_id']);
    
    }
    
    
    
public function export()
 {
     $clas_sub_id = $_GET['clas_sub_id'];
     $chapter_id = $_GET['chapter_id'];
     $file_name = 'question_'.$chapter_id.'_'.$clas_sub_id.'_'.date('Y-m-d').'.csv'; 
     header("Content-Description: File Transfer"); 
     header("Content-Disposition: attachment; filename=$file_name"); 
     header("Content-Type: application/csv;");
     
    
     // get data 
     $student_data = $this->question->fetch_record_class_subject_chapter($chapter_id,$clas_sub_id);

     // file creation 
     $file = fopen('php://output', 'w');
 
     $header = array("Question Id",
                     "Image1",
                     "Image 2",
                     "Chapter Id",
                     "Question Heading",
                     "Option 1",
                     "Option 2",
                     "Option 3",
                     'Option 4',
                     'Correct Answer',
                     'Correct Answer1',
                     'Answer Description',
                     'Status',
                     'Created By',
                     'Date',
                     'Question Type Id',
                     'Exercise Id',
                     'class subject Id',
                     'School Id',
                     'Important Question Id'); 
     fputcsv($file, $header);
     foreach ($student_data->result_array() as $key => $value)
     { 
       fputcsv($file, $value); 
     }
     fclose($file); 
     exit; 
 }
  

public function Class_Subject_Export()
 {
     $clas_sub_id = $_GET['clas_sub_id'];
     $file_name = 'question_'.$clas_sub_id.'_'.date('Y-m-d').'.csv'; 
     header("Content-Description: File Transfer"); 
     header("Content-Disposition: attachment; filename=$file_name"); 
     header("Content-Type: application/csv;");
     
    
     // get data 
     $student_data = $this->question->fetch_record_class_subject($clas_sub_id);

     // file creation 
     $file = fopen('php://output', 'w');
 
     $header = array("Question Id",
                     "Image1",
                     "Image 2",
                     "Chapter Id",
                     "Question Heading",
                     "Option 1",
                     "Option 2",
                     "Option 3",
                     'Option 4',
                     'Correct Answer',
                     'Correct Answer1',
                     'Answer Description',
                     'Status',
                     'Created By',
                     'Date',
                     'Question Type Id',
                     'Exercise Id',
                     'class subject Id',
                     'School Id',
                     'Important Question Id'); 
     fputcsv($file, $header);
     foreach ($student_data->result_array() as $key => $value)
     { 
       fputcsv($file, $value); 
     }
     fclose($file); 
     exit; 
 }  
    

}
