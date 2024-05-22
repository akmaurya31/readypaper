<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Capter_question_model extends CI_Model
{
	var $table = 'tbl_capter_question';
	var $question_paper_table = 'tbl_capter_question_paper';
	var $column_order = array('chapter_name'); //set column field database for datatable orderable
	var $column_search = array('chapter_name'); //set column field database for datatable searchable just firstname , lastname , address are searchable
	var $order = array('id' => 'asc'); // default order 

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}



	public function checked_by_question($empId,$pepar_id)
	{
		$this->db->from($this->table);
		$this->db->where('created_by', $empId);
			$this->db->where('pepar_id', $pepar_id);
		$query = $this->db->get();
		return $query->num_rows();
	}





	public function save($data)
	{
		$this->db->insert($this->table, $data);
		return $this->db->insert_id();
	}

	public function update($where, $data)
	{
		$this->db->update($this->table, $data, $where);
		return $this->db->affected_rows();
	}
	

	public function delete_by_id($id)
	{
		$this->db->where('id', $id);
		$this->db->delete($this->table);
	}
	

    public function delete_by_teacher($empId,$pepar_id)
	{
			$this->db->where('created_by', $empId);
			$this->db->where('pepar_id', $pepar_id);
		$this->db->delete($this->table);
	}
	
	
	public function getQuestion_by_Emp($empId,$pepar_id,$type_id,$offset)
	{
        $offset = isset($offset) ? $offset : 0;
	    $query = $this->db->query("SELECT tbl_chapter.*,tbl_question.*,tbl_capter_question.pepar_id,tbl_capter_question.created_by 
        FROM tbl_chapter 
        inner join tbl_capter_question on tbl_chapter.id=tbl_capter_question.capter_id
        inner join tbl_question on tbl_chapter.id=tbl_question.chapter 
        where tbl_question.question_type=$type_id and tbl_capter_question.pepar_id=$pepar_id and tbl_capter_question.created_by=$empId  ORDER BY tbl_question.id desc LIMIT $offset, 20");//and tbl_question.question_type=$type_id
        return $query->result();
	
	}
	
	
	
	
	public function get_active_count_ajax($data){
    // print_r($data);
        $query = '';
        $where="where 1=1 ";
        if (isset($data['question_name_search']) && !empty($data['question_name_search'])) {
            $query .= " AND tbl_question.question_name LIKE '%" . $data['question_name_search'] . "%'  ";
        }
        if (isset($data['question_type']) && !empty($data['question_type'])) {
            $query .= " AND tbl_question.question_type ='" . $data['question_type'] . "'  ";
        }
        if (isset($data['pepar_id']) && !empty($data['pepar_id'])) {
            $query .= " AND tbl_capter_question.pepar_id ='" . $data['pepar_id'] . "'  ";
        }
        
         if (isset($data['capter_id']) && !empty($data['capter_id'])) {
            $query .= " AND tbl_capter_question.capter_id ='" . $data['capter_id'] . "'  ";
        }
        
        if (isset($data['empId']) && !empty($data['empId'])) {
            $query .= " AND tbl_capter_question.created_by ='" . $data['empId'] . "'  ";
        }

        if (isset($lastId) && $lastId != 'undefined') {
            $query .= "AND tbl_question.id <  $lastId ";
        } 

        $sqlAllData = $this->db->query("SELECT tbl_chapter.*,tbl_chapter.id as cid,tbl_question.*,tbl_capter_question.pepar_id,tbl_capter_question.created_by 
            FROM tbl_chapter 
            inner join tbl_capter_question on tbl_chapter.id=tbl_capter_question.capter_id
            inner join tbl_question on tbl_chapter.id=tbl_question.chapter  $where $query ORDER BY tbl_question.id desc ");

        //echo $this->db->last_query();
        echo   $sqlAllData->num_rows();
        die();
    }



    public function get_fatchAllQuestion($lastId,$data){
        // print_r($data);
        $query = '';
        $where="where 1=1 ";
        $offset = isset($data['offset']) ? $data['offset'] : 0;
        if (isset($data['question_name_search']) && !empty($data['question_name_search'])) {
            $query .= " AND tbl_question.question_name LIKE '%" . $data['question_name_search'] . "%'  ";
        }
		if (isset($data['question_type']) && !empty($data['question_type'])) {
            $query .= " AND tbl_question.question_type ='" . $data['question_type'] . "'  ";
        }
        if (isset($data['pepar_id']) && !empty($data['pepar_id'])) {
            $query .= " AND tbl_capter_question.pepar_id ='" . $data['pepar_id'] . "'  ";
        }
         if (isset($data['capter_id']) && !empty($data['capter_id'])) {
            $query .= " AND tbl_capter_question.capter_id ='" . $data['capter_id'] . "'  ";
        }
        if (isset($data['empId']) && !empty($data['empId'])) {
            $query .= " AND tbl_capter_question.created_by ='" . $data['empId'] . "'  ";
        }

        if (isset($lastId) && $lastId != 'undefined') {
            $query .= "AND tbl_question.id <  $lastId ";
        } 
		// echo $query;die;

        $sqlAllData = $this->db->query("SELECT tbl_chapter.*,tbl_chapter.id as cid,tbl_question.*,tbl_capter_question.pepar_id,tbl_capter_question.created_by 
            FROM tbl_chapter 
            inner join tbl_capter_question on tbl_chapter.id=tbl_capter_question.capter_id
            inner join tbl_question on tbl_chapter.id=tbl_question.chapter  $where $query ORDER BY tbl_question.id desc LIMIT $offset, 20");

        return $sqlAllData->result();
    }
    
    /***************************************INSERT TEACHER QUESTION**********************************************/

    public function save_question_paper($data)
	{
		$this->db->insert($this->question_paper_table, $data);
		return $this->db->insert_id();
	}
	
	
		public function view_by_question($empId,$pepar_id)
	{
		$this->db->from($this->question_paper_table);
		$this->db->where('empId', $empId);
			$this->db->where('pepar_id', $pepar_id);
		$query = $this->db->get();
		return $query->row();
	}
	
	public function check_question_paper($empId,$type_id,$pepar_id)
	{
		$this->db->from($this->question_paper_table);
		$this->db->where('empId', $empId);
		$this->db->where('type_id', $type_id);
		$this->db->where('pepar_id', $pepar_id);
		$query = $this->db->get();
		return $query->row();
	}

	public function update_question_paper($empId,$type_id,$pepar_id,$data)
	{

		$this->db->update($this->question_paper_table, $data, array('empId' => $empId,"type_id"=>$type_id,"pepar_id"=>$pepar_id));
		return $this->db->affected_rows();
	}


}
