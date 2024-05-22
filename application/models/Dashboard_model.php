<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard_model extends CI_Model {
	
	var $table = 'tbl_payments';
	var $column_order = array('user_id',null,null); //set column field database for datatable orderable
	var $column_search = array('user_id'); //set column field database for datatable searchable just firstname , lastname , address are searchable
	var $order = array('id' => 'desc'); // default order 

    

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

    public function payment_today($date){
        $this->db->from($this->table);
		$this->db->where('DATE(created_at)', $date)->order_by('id','desc')->limit(10);
		$query = $this->db->get();
		return $query->result();
    }
    
    public function tarvel_user_lisr($date){
        $this->db->from('tbl_mail');
		$this->db->where('DATE(tour_date)', $date)->where('conform_mail_id','1')->order_by('id','desc')->limit(10);
		$query = $this->db->get();
		return $query->result();
    }
    
    
    
    
	/**********************************Mail******************************************/
	
		private function _get_datatables_query()
	{
		
		$this->db->from('tbl_mail');

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

	function get_datatables($date,$role,$emp)
	{
		$this->_get_datatables_query();
		if($_POST['length'] != -1)
		
		
		
          if($role=='telecaller'){
    	    $this->db->where('created_by', $emp);
             $this->db->where('created_at', $date);
    	} else if($role=='operation'){
    	    $this->db->where('conform_mail_id', 1);
             $this->db->where('created_at', $date);
    	}
    	
    	else{
    	     $this->db->where('created_at', $date);
    	}
		 $this->db->limit($_POST['length'], $_POST['start']);
		$query = $this->db->get();
		return $query->result();
	}

	function count_filtered($date,$role,$emp)
	{
		$this->_get_datatables_query();
		
	     if($role=='telecaller'){
    	   $query =  $this->db->where('created_by', $emp)->where('created_at', $date)->get();
    	}  else{
    	   $query =  $this->db->where('created_at', $date)->get(); //$this->db->where('created_at', $date)->get();
    	}
		return $query ->num_rows();
	}

	public function count_all($date,$role,$emp)
	{
		$this->db->from($this->table);
	      if($role=='telecaller'){
    	   $this->db->where('created_by', $emp)->where('created_at', $date);
    	}  else{
    	    
    	     $this->db->where('created_at', $date);
    	}
		
		return $this->db->count_all_results();
	}

	
	

	public function get_by_id($id)
	{
		$this->db->from($this->table);
		$this->db->where('mail_id',$id)->order_by('id','desc');
		$query = $this->db->get();
		return $query->row();
	}
	
	

	


}
