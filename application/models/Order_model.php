<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Order_model extends CI_Model {

    var $table = 'tbl_order';
	
    var $column_order = array('name','status','qname', null); //set column field database for datatable orderable
    var $column_search = array('name','mobileNumber','merchantId'); //set column field database for datatable searchable just firstname , lastname , address are searchable
    var $order = array('id' => 'desc'); // default order 

    public function __construct() {
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
		if($uri=='admin'){
		    $query = $this->db->where('status', 'Y');
		}else{
         $this->db->where('user_id', $id);
		}
		 $this->db->limit($_POST['length'], $_POST['start']);
		$query = $this->db->get();
		return $query->result();
	}

	function count_filtered($uri,$id)
	{
		$this->_get_datatables_query();
		
		if($uri=='admin'){
		    $query = $this->db->where('status', 'Y')->get();
		}else{
         $query = $this->db->where('user_id', $id)->get();
		}
		
		return $query->num_rows();
	}

	public function count_all($uri,$id)
	{
		$this->db->from($this->table);
			if($uri=='admin'){
		   	return $this->db->where('status', 'Y')->count_all_results();
		}else{
        	return $this->db->where('user_id', $id)->count_all_results();
		}
	
	}
	
		
	public function totalorderTeacherDesc($emp)
	{
		$this->db->from($this->table);
		$this->db->where('teacher_id',$emp)->order_by('id','desc')->limit(5);
		$query = $this->db->get();
		return $query->result();
	}
    
    public function get_by_id($id)
	{
		$this->db->from($this->table);
		$this->db->where('id',$id);
		$query = $this->db->get();

		return $query->row();
	}
	
		 public function get_by_users($id)
	{
		$this->db->from($this->table);
		$this->db->where('teacher_id',$id);
		$query = $this->db->get();
		return $query->num_rows();
	}
	
	
			public function get_by_Order($sdate,$edate)
{
    $this->db->select('tbl_order.*,
                        tbl_plan.id as cid,
                        tbl_plan.heading as plan_name,
                        user.firstName,
                        user.firstName,
                        user.mobile_no,
                        user.email,
                        user.id as cust_id, 
                        tbl_order.created_at as odate');
    $this->db->from('tbl_plan');
    $this->db->join('tbl_order', 'tbl_plan.id = tbl_order.plan_id');
    $this->db->join('user', 'tbl_order.teacher_id = user.id');
    $this->db->where('tbl_order.status', 'Y');

    /*if ($mode != 0) {
        $this->db->where('mode', $mode);
    }*/
    
      if ($sdate!='' && $edate == '') {
        $this->db->where('DATE(tbl_order.created_at)  ="' . $sdate . '"');
    }
    

    if ($sdate!='' && $edate != '') {
        $this->db->where('DATE(tbl_order.created_at) BETWEEN "' . $sdate . '" and "' . $edate . '"');
    }
    
    

    //$this->db->group_by('tbl_order.OrderId');
    $this->db->order_by('tbl_order.id', 'desc');
    $query = $this->db->get();
    return $query->result();
}


public function get_by_pending_Order()
{
    return $this->db->from($this->table)
                   // ->where('providerReferenceId', '')
                     ->where('code!=', 'PAYMENT_SUCCESS')
                       //->where('code', '')
                    ->order_by('id', 'desc')
                    ->get()
                    ->result();
}

	
	
	public function get_by_success_Order()
{
    return $this->db->from($this->table)
                   // ->where('providerReferenceId !=', '')
                     ->where('code', 'PAYMENT_SUCCESS')
                    ->order_by('id', 'desc')
                    ->get()
                    ->result();
}





	public function get_by_teacher_Order($user_id)
	{
		$this->db->from($this->table);
		$this->db->where('teacher_id',$user_id)->order_by('id','asc');
		$query = $this->db->get();
		return $query->result();
	}


	public function check_order_teacher($user_id)
	{
		$this->db->from($this->table);
		$this->db->where('teacher_id',$user_id)->order_by('plan_id','desc');
		$query = $this->db->get();
		return $query->row();
	}
	
	
		public function check_orderTeacherRow($user_id)
	{
		$this->db->from($this->table);
		$this->db->where('teacher_id',$user_id)->order_by('id','desc');//->order_by('plan_id','desc')
		$query = $this->db->get();
		return $query->row();
	}
	
	
		public function get_change_OredrId($id)
	{
		$this->db->from($this->table);
		$this->db->where('id',$id);//->order_by('plan_id','desc')
		$query = $this->db->get();
		return $query->row();
	}
	
	
	
	
		public function totalorderDesc()
	{
		$this->db->from($this->table);
		$this->db->order_by('id','desc')->limit(5);
		$query = $this->db->get();
		return $query->result();
	}
	
	public function checkPlanTeacherResult($user_id)
	{
	    $query = 	$this->db->query("SELECT *,DATE_ADD(created_at, INTERVAL plan_validity MONTH) as final_date,tbl_plan.id as pid,tbl_order.id as oid FROM `tbl_order`
	    inner JOIN tbl_plan on tbl_order.plan_name=tbl_plan.heading
		WHERE DATE_ADD(created_at, INTERVAL plan_validity MONTH) > CURRENT_TIMESTAMP AND `teacher_id`=$user_id and code='PAYMENT_SUCCESS' and qty_less_plan>=1");
		return $query->result();
	}
	
	
	public function checkPlanTeacher($user_id)
	{
		$this->db->from($this->table);
		$this->db->where('teacher_id',$user_id)->where('code','PAYMENT_SUCCESS')->order_by('id','desc');
		$query = $this->db->get();
		return $query->row();
	}
	
	
	public function get_by_transactionId($merchantOrderId)
	{
		$this->db->from($this->table);
		$this->db->where('merchantOrderId',$merchantOrderId)->order_by('id','desc');
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

}
