<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Person_model extends CI_Model {

	var $table = 'user';
	var $column_order = array('firstname','username','gender','address',null,null); //set column field database for datatable orderable
	var $column_search = array('firstname','username','mobile_no'); //set column field database for datatable searchable just firstname , lastname , address are searchable
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

	function get_datatables($role)
	{
	   $id =  $this->session->userdata('id');
		$this->_get_datatables_query();
		if($_POST['length'] != -1)
		if($role=='admin' ){
          $this->db->where('role', 'teacher');
		 }else{
			$this->db->where('id', $id);
		}
           
		 $this->db->limit($_POST['length'], $_POST['start']);
		$query = $this->db->get();
		return $query->result();
	}

	function count_filtered($role)
	{
	     $id =  $this->session->userdata('id');
		$this->_get_datatables_query();
		if($role=='admin' ){
         $query =  $this->db->where('role', 'teacher')->get();
		 }else{
		$query = 	$this->db->where('id', $id)->get();
		}
		return $query->num_rows();
	}

	public function count_all($role)
	{
	     $id =  $this->session->userdata('id');
		$this->db->from($this->table);
			if($role=='admin' ){
         $query =  $this->db->where('role', 'teacher')->get();
		 }else{
			$this->db->where('id', $id)->get();
		}
		return $this->db->count_all_results();
	}

	public function get_by_id($id)
	{
		$this->db->from($this->table);
		$this->db->where('id',$id);
		$query = $this->db->get();

		return $query->row();
	}
	
	public function get_active_teacher($role,$id)
	{
		
		$this->db->from($this->table);
		$this->db->where('status','Y');
		if($role=='admin'){
		$this->db->where_in('role',['employee','super_employee']);
		}else{
		    	$this->db->where('id',$id);
		}
		$query = $this->db->get();

		return $query->result();
	}
	
	
	
		public function get_by_mobile($id)
	{
		$this->db->from($this->table);
		$this->db->where('mobile_no',$id);
		$query = $this->db->get();
		return $query->num_rows();
	}
	


 public function get_by_user($id)
   {
       $this->db->from($this->table);
       $this->db->where('username',$id);//->where('status','Y')
       $query = $this->db->get();
       return $query->row();
   }
	
	
	public function get_active_employee()
	{
		
		$this->db->from($this->table);
		$this->db->where('status','Y');
		$this->db->where('role','teacher')->order_by('firstName','asc');
		$query = $this->db->get();
		return $query->result();
	}
	
	public function get_by_role()
	{
		
		$this->db->from($this->table);
		$this->db->where('status','Y');
		$this->db->where('role','employee')->order_by('firstName','asc');
		$query = $this->db->get();
		return $query->result();
	}

	public function totalTeacher()
	{
		
		$this->db->from($this->table);
		$this->db->where('role=','teacher');
				$this->db->where('status','Y');
		$query = $this->db->get();

		return $query->num_rows();
	}
	
	public function totalsuper_employee()
	{
		
		$this->db->from($this->table);
		$this->db->where('role=','super_employee');
				$this->db->where('status','Y');
		$query = $this->db->get();

		return $query->num_rows();
	}
	
	
	
		public function totalEmployee()
	{
		
		$this->db->from($this->table);
		$this->db->where('role=','employee');
				$this->db->where('status','Y');
		$query = $this->db->get();

		return $query->num_rows();
	}

	public function totalteacherInactive()
	{
		
		$this->db->from($this->table);
		$this->db->where('role!=','admin');
				$this->db->where('status','N');
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
    


	
	


}
