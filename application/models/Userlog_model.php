<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Userlog_model extends CI_Model {

	var $table = 'user_log';
	var $column_order = array('created_by	',null,null); //set column field database for datatable orderable
	var $column_search = array('created_by	',); //set column field database for datatable searchable just firstname , lastname , address are searchable
	var $order = array('id' => 'asc'); // default order 

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

	function get_datatables($uri)
	{
		$this->_get_datatables_query();
		if($_POST['length'] != -1)
        //$this->db->where('status', 'Y');
		
			$this->db->where('created_by', $uri);
		
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

	public function get_by_resId($id)
	{
		$this->db->from($this->table);
		$this->db->where('created_by',$id)->order_by('id','desc');
		$query = $this->db->get();

		return $query->result();
	}


	public function get_by_Id($emp,$dates,$days)
	{
	    $this->db->select("*  from user_log WHERE created_by=$emp and date(created_at) = '$dates-$days' ");
		$query = $this->db->get();
		return $query->row();//$query->result();
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
	
}
