<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Import_question_model extends CI_Model {

    var $table = 'tbl_question';
    
    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

   
    function save($id,$pic,$pic1,$chapter,$question_name,$answer1,$answer2,$answer3,$answer4,$currect_ans,$currect_ans2,
					$description_answer,$status,$created_by,$created_at,$question_type,$exercise_id,$class_sub_id,$school_id,$importent_id)
	{
        $data = array(
            'id'=>$id,
            'pic'=>$pic,
            'pic1'=>$pic1,
            'chapter'=>$chapter,
            'question_name'=>$question_name,
            'answer1'=>$answer1,
            'answer2'=>$answer2,
            'answer3'=>$answer3,
            'answer4'=>$answer4,
            'currect_ans'=>$currect_ans,
            'currect_ans2'=>$currect_ans2,
            'description_answer'=>$description_answer,
            'status'=>$status,
            'created_by'=>$created_by,
            'created_at'=>$created_at,
            'question_type'=>$question_type,
            'exercise_id'=>$exercise_id,
            'class_sub_id'=>$class_sub_id,
            'school_id'=>$school_id,
            'importent_id'=>$importent_id,
        );
        //print_r($data);die;
        $this->db->insert('tbl_question',$data);
		
	}
	
	public function fetch_record_class_subject_chapter($chapter_id,$clas_sub_id){
	    $this->db->from($this->table);
	    $query = $this->db->where('chapter',$chapter_id)->where('class_sub_id',$clas_sub_id)->get();
		return $query;
		
	}
    
	public function fetch_record_class_subject($clas_sub_id){
	    $this->db->from($this->table);
	    $query = $this->db->where('class_sub_id',$clas_sub_id)->get();
		return $query;
		
	}
   

}
