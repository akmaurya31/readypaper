<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pepar_model extends CI_Model
{

	var $table = 'tbl_create_pepar';
	var $column_order = array('exam_name'); //set column field database for datatable orderable
	var $column_search = array('exam_name'); //set column field database for datatable searchable just firstname , lastname , address are searchable
	var $order = array('id' => 'desc'); // default order 

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	private function _get_datatables_query()
	{

		$this->db->from($this->table);

		$i = 0;

		foreach ($this->column_search as $item) // loop column 
		{
			if ($_POST['search']['value']) // if datatable send POST for search
			{

				if ($i === 0) // first loop
				{
					$this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
					$this->db->like($item, $_POST['search']['value']);
				} else {
					$this->db->or_like($item, $_POST['search']['value']);
				}

				if (count($this->column_search) - 1 == $i) //last loop
					$this->db->group_end(); //close bracket
			}
			$i++;
		}

		if (isset($_POST['order'])) // here order processing
		{
			$this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
		} else if (isset($this->order)) {
			$order = $this->order;
			$this->db->order_by(key($order), $order[key($order)]);
		}
	}

	function get_datatables()
	{
		$this->_get_datatables_query();
		if ($_POST['length'] != -1);
		$this->db->limit($_POST['length'], $_POST['start']);
		$query = $this->db->get();
		return $query->result();
	}

	function count_filtered()
	{
		$this->_get_datatables_query();
		$query = $this->db->get();
		return $query->num_rows();
	}

	public function count_all()
	{
		$this->db->from($this->table);
		return $this->db->count_all_results();
	}

	public function get_by_id($id)
	{
		$this->db->from($this->table);
		$this->db->where('id', $id);
		$query = $this->db->get();
		return $query->row();
	}


	public function get_by_name($name, $id = null)
	{
		$this->db->from($this->table);
		if (is_null($id)) {
			$this->db->where('exam_name', $name);
		} else {
			$this->db->where('exam_name', $name);
			$this->db->where('id !=', $id);
		}
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

	
		public function get_active_exam_teacher($id)
	{
		
		$query = $this->db->query("SELECT *,tbl_create_pepar.exam_name,tbl_exam.exam_name as ename,tbl_group_exam.group_exam_name,
		tbl_create_pepar.id as cpid,tbl_create_pepar.created_at as cdate
FROM `tbl_create_pepar`
INNER JOIN tbl_exam ON tbl_create_pepar.exam_id = tbl_exam.id
INNER JOIN tbl_group_exam ON tbl_create_pepar.group_exam_id = tbl_group_exam.id
where tbl_create_pepar.teacher_id= $id");
		return $query->result();
	}
	
	public function get_active_teacher($id)
	{
		$this->db->from($this->table);
		$this->db->where('teacher_id', $id);
		$query = $this->db->get();
		return $query->result();
	}
	
	
	
	public function get_active_teacher_pepar($id,$pepar_id){
	$query = $this->db->query("SELECT *
                                FROM `tbl_create_pepar`
                                where tbl_create_pepar.teacher_id= $id AND tbl_create_pepar.id=$pepar_id");
		return $query->row();
	}
	
	public function get_create_teacher_pepar($pepar_id){
	$query = $this->db->query("SELECT *
                                FROM `tbl_capter_question_paper`
                                where tbl_capter_question_paper.pepar_id=$pepar_id");
		return $query->row();
	}
	
	
	
}
