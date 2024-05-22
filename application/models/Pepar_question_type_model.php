<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pepar_question_type_model extends CI_Model
{
	var $table = 'tbl_pepar_question_id';
//	var $question_paper_table = 'tbl_capter_question_paper';
//	var $column_order = array('chapter_name'); //set column field database for datatable orderable
//	var $column_search = array('chapter_name'); //set column field database for datatable searchable just firstname , lastname , address are searchable
//	var $order = array('id' => 'asc'); // default order 

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
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
	
	public function delete_by_pepar_id($pepar_id)
	{
		$this->db->where('create_pepar_id', $pepar_id);
		$this->db->delete($this->table);
	}
	
	public function get_by_id($id)
	{
		$this->db->from($this->table);
		$this->db->where('id', $id);
		$query = $this->db->get();
		return $query->row();
	}
	
	public function get_by_pepar_id($pepar_id)
	{
		$this->db->from($this->table);
		$this->db->where('create_pepar_id', $pepar_id);
		$query = $this->db->get();
		return $query->result();
	}
	

 	public function get_by_pepar_empid($empId,$pepar_id)
	{
		$this->db->from($this->table);
		$this->db->where('create_pepar_id', $pepar_id);
		$this->db->where('created_by', $empId);
		$query = $this->db->get();
		return $query->result();
	}
	
	
	public function get_by_pepar_question_empid($empId, $pepar_id)
{
    $this->db->select('tbl_pepar_question_id.*, tbl_question_type.full_name,tbl_question_type.question_type_name,tbl_question_type.default_no');
    $this->db->from('tbl_pepar_question_id');
    $this->db->join('tbl_question_type', 'tbl_pepar_question_id.check_question_id = tbl_question_type.id');
    $this->db->where('tbl_pepar_question_id.create_pepar_id', $pepar_id);
    $this->db->where('tbl_pepar_question_id.created_by', $empId);
    $this->db->order_by('tbl_question_type.full_name');
    $query = $this->db->get();
    
    return $query->result();
}

	
	public function pepar_questionType($empId, $pepar_id,$questionType_id)
{
    $this->db->select('tbl_pepar_question_id.*, tbl_question_type.full_name,tbl_question_type.question_type_name,tbl_question_type.default_no');
    $this->db->from('tbl_pepar_question_id');
    $this->db->join('tbl_question_type', 'tbl_pepar_question_id.check_question_id = tbl_question_type.id');
    $this->db->where('tbl_pepar_question_id.create_pepar_id', $pepar_id);
    $this->db->where('tbl_pepar_question_id.created_by', $empId);
    $this->db->where('tbl_pepar_question_id.check_question_id', $questionType_id);
    $this->db->order_by('tbl_question_type.full_name');
    $query = $this->db->get();
    return $query->row();
}


	
	
   

}
