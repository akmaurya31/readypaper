<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Teacher_ads_model extends CI_Model {

	var $table = 'tbl_teacher_ad';
	var $column_order = array('company_name'); //set column field database for datatable orderable
	var $column_search = array('company_name'); //set column field database for datatable searchable just firstname , lastname , address are searchable
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


	function get_datatables($uri,$id)
	{
		$this->_get_datatables_query();
		if($_POST['length'] != -1)
       
		 $this->db->limit($_POST['length'], $_POST['start']);
		 if($uri=='admin'){
		     $query = $this->db->get();
		 }else{
		$query = $this->db->where('created_by',$id)->get();
		 }
		return $query->result();
	}

	function count_filtered($uri,$id)
	{
		$this->_get_datatables_query();
		if($uri=='admin'){
		     $query = $this->db->get();
		 }else{
		  $query = $this->db->where('created_by',$id)->get();
		 }
		return $query->num_rows();
	}

	public function count_all($uri,$id)
	{
		$this->db->from($this->table);	
		if($uri=='admin'){
		    	return $this->db->count_all_results();
		 }else{
		  	return $this->db->where('created_by',$id)->count_all_results();
		 }
	
	}

	public function get_by_id($id)
	{
		$this->db->from($this->table);
		$this->db->where('id',$id);
		$query = $this->db->get();

		return $query->row();
	}


	public function get_by_name($name,$id=null) {
        $this->db->from($this->table);
       if(is_null($id)){
           $this->db->where('company_name', $name);
        }else{
           $this->db->where('company_name', $name);
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


	public function getActivemenuRow($id)
	{
		$this->db->from($this->table);	
		$this->db->where('menu_name',$id);
		$query = $this->db->get();
		return $query->row();
	}
	
	public function getActiveAds_limit()
	{
		$this->db->from($this->table);	
		$this->db->where('status','Y')->order_by('id','desc')->limit(12);
		$query = $this->db->get();
		return $query->result();
	}



}
