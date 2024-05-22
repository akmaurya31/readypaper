<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Instruction_model extends CI_Model {

	var $table = 'tbl_instruction';
	var $column_order = array('instruction_name','address',null,null); //set column field database for datatable orderable
	var $column_search = array('instruction_name'); //set column field database for datatable searchable just instruction_name , lastname , address are searchable
	var $order = array('id' => 'desc'); // default order 

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}


	public function get_by_id($id)
	{
		$this->db->from($this->table);
		$this->db->where('id',$id);
		$query = $this->db->get();

		return $query->row();
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

	public function get_by_name($name,$id=null) {
        $this->db->from($this->table);
       if(is_null($id)){
           $this->db->where('username', $name);
        }else{
           $this->db->where('username', $name);
           $this->db->where('id !=', $id);
       }
        $query = $this->db->get();
        return $query->row();
    }
    
    public function get_by_school($id)
	{
		$this->db->from($this->table);
		$this->db->where('created_by',$id);
		$query = $this->db->get();
		return $query->row();
	}
    
	public function get_all_instruction($pepar_id,$id)
	{
		$this->db->from($this->table);
		$this->db->where('pepar_id', $pepar_id);
		$this->db->where('created_by',$id);
		$query = $this->db->get();
		return $query->result();
	}
	


	
	


}
