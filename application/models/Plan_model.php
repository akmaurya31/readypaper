<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Plan_model extends CI_Model {

	var $table = 'tbl_plan';
	var $column_order = array('menu_name'); //set column field database for datatable orderable
	var $column_search = array('menu_name'); //set column field database for datatable searchable just firstname , lastname , address are searchable
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
		$query = $this->db->where('created_by',$id)->group_by('heading')->get();
		return $query->result();
	}

	function count_filtered($uri,$id)
	{
		$this->_get_datatables_query();
		$query = $this->db->where('created_by',$id)->group_by('heading')->get();
		return $query->num_rows();
	}

	public function count_all($uri,$id)
	{
		$this->db->from($this->table);		
		return $this->db->where('created_by',$id)->group_by('heading')->count_all_results();
	}

	public function get_by_id($id)
	{
		$this->db->from($this->table);
		$this->db->where('id',$id);
		$query = $this->db->get();

		return $query->row();
	}
	
	
		public function get_by_user($id)
	{
		$this->db->from($this->table);
		$this->db->where('heading',$id);
		$query = $this->db->get();
		return $query->result();
	}


	public function get_by_name($name,$id=null) {
        $this->db->from($this->table);
       if(is_null($id)){
           $this->db->where('menu_name', $name);
        }else{
           $this->db->where('menu_name', $name);
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
	
	
	
	public function getActivePlan()
	{
		$this->db->from($this->table);	
		$this->db->where('status','Y')->where('free_plan','0')->group_by('heading');
		$query = $this->db->get();
		return $query->result();
	}
	
		public function totalPlan()
	{
		 $query = $this->db->query("SELECT * FROM tbl_plan  group by heading  order by heading='ASC'");
		return $query->num_rows();
	}
	
	
		public function getActivePlan_Date($date)
	{
		 $query = $this->db->query("SELECT * FROM tbl_plan WHERE end_date >= '$date' and free_plan='0'   group by heading  order by heading='ASC'");//
		return $query->result();
	}
	
	
	


		public function getActivePlan_Date_limit($date)
	{
		 $query = $this->db->query("SELECT * FROM tbl_plan WHERE end_date >= '$date' and status='N' and free_plan='0'  group by heading  order by heading='ASC' limit 3");
		return $query->result();
	}
	
	
		public function getCountList($role,$id)
	{
		$this->db->from($this->table);
		
		 $this->db->where('created_by',$id);
	
		$query = $this->db->get();
		return $query->num_rows();
	}
	
	public function get_active_subject($name)
	{
		$this->db->from($this->table);	
		$this->db->where('heading',$name);//->where('free_plan','0')
		$query = $this->db->get();
		return $query->result();
	}
	
	
	
	
	public function getFreePlan()
	{
		$this->db->from($this->table);	
		$this->db->where('free_plan','1')->group_by('heading');
		$query = $this->db->get();
		return $query->result();
	}
	
	
		public function getFreePlanTecaher($plan_id)
	{
		$this->db->from($this->table);	
		$this->db->where('id',$plan_id)->order_by('id','desc');
		$query = $this->db->get();
		return $query->row();
	}
	


}
