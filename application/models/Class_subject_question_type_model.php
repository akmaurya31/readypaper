<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Class_subject_question_type_model extends CI_Model
{

	var $table = 'tbl_class_subject_question_type';
	var $column_order = array('id'); //set column field database for datatable orderable
	var $column_search = array('subject_id'); //set column field database for datatable searchable just firstname , lastname , address are searchable
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

	function get_datatables()
	{
		$this->_get_datatables_query();
		if($_POST['length'] != -1)
     ;
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
	
	
		public function get_class_subject_section($class_id,$subbject_id)
	{
		$this->db->from($this->table);
	    $this->db->where('class_id', $class_id);
        $this->db->where('subject_id',$subbject_id);
		$query = $this->db->get();
		return $query->result();
	}
	
	/*

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
	
	
	
	
	
	
	
	
	
	
	
			public function get_by_questionList($class,$subject){
			    
    $this->db->select('*');
    $this->db->from('tbl_class_subject');
    //$this->db->where('tbl_question.status', 'Y');

    if ($class != 0) {
        $this->db->where('class_id', $class);
    }
     if ($subject != 0) {
        $this->db->where('subject_id', $subject);
    }
    
    $this->db->order_by('tbl_class_subject.class_id', 'desc');
    $query = $this->db->get();
    return $query->result();
}*.
	
	
	
	
	
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
