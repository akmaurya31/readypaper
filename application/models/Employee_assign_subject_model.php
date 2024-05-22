<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Employee_assign_subject_model extends CI_Model
{

	var $table = 'tbl_class_subject';
	var $column_order = array('subject_id'); //set column field database for datatable orderable
	var $column_search = array('subject_id'); //set column field database for datatable searchable just firstname , lastname , address are searchable
	var $order = array('class_id' => 'desc'); // default order 
	
	
		public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	private function _get_datatables_query()
	{
		
	     $this->db->select('tbl_class_subject.*,tbl_employee_subject.employee_id');
		$this->db->from($this->table);
		$this->db->join('tbl_employee_subject', 'tbl_class_subject.subject_id = tbl_employee_subject.subject_id');
		
		

		$i = 0;
	
		foreach ($this->column_search as $item) // loop column 
		{
			if($_POST['search']['value']) // if datatable send POST for search
			{
				
				if($i===0) // first loop
				{
					$this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
					$this->db->like($item, $_POST['search']['value']);
				}
				else
				{
					$this->db->or_like($item, $_POST['search']['value']);
				}

				if(count($this->column_search) - 1 == $i) //last loop
					$this->db->group_end(); //close bracket
			}
			$i++;
		}
		
		if(isset($_POST['order'])) // here order processing
		{
			$this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
		} 
		else if(isset($this->order))
		{
			$order = $this->order;
			$this->db->order_by(key($order), $order[key($order)]);
		}
	}
	

	function get_datatables($role,$id)
	{
		$this->_get_datatables_query();
		if($_POST['length'] != -1)
     ;
		 $this->db->limit($_POST['length'], $_POST['start']);
		$query = $this->db->where('tbl_employee_subject.employee_id',$id)->get();
		return $query->result();
	}

	function count_filtered($role,$id)
	{
		$this->_get_datatables_query();
		$query = $this->db->where('tbl_employee_subject.employee_id',$id)->get();
		return $query->num_rows();
	}
	


	public function count_all($role,$id)
	{
		//$this->db->from($this->table);
		 $this->_get_datatables_query();
	     $this->db->where('tbl_employee_subject.employee_id',$id);
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
			$this->db->where('subject_id', $name);
		} else {
			$this->db->where('subject_id', $name);
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

	public function get_active_class_id($id)
	{
		$this->db->from($this->table);
		$this->db->where('class_id', $id);
				$this->db->where('status', 'Y');
		$query = $this->db->get();
		return $query->result();
	}
	public function get_active_class_subject()
	{
		$this->db->from($this->table);
		$this->db->where('status', 'Y');
		$query = $this->db->get();
		return $query->result();
	}
	
	/*	public function active_class_query($class_id)
	{  
	    $query = $this->db->query("SELECT * FROM `tbl_class_subject` inner join 
	    tbl_subject on 
	    tbl_class_subject.subject_id =tbl_subject.id
	    WHERE tbl_subject.subject_type_id=1 and tbl_class_subject.class_id=$class_id");
        
         
        return $query->result();
	}
	
	
		public function active_class_subject_mark($class_id)
	{  
	    $query = $this->db->query("SELECT * FROM `tbl_class_subject` inner join 
	    tbl_subject on 
	    tbl_class_subject.subject_id =tbl_subject.id
	    WHERE tbl_subject.subject_type_id!=1 and tbl_class_subject.class_id=$class_id");
        
         
        return $query->result();
	}
	*/
	
}
