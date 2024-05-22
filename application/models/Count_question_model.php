<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Count_question_model extends CI_Model {

	var $table = 'tbl_question';
	var $column_order = array('question_name'); //set column field database for datatable orderable
	var $column_search = array('question_name'); //set column field database for datatable searchable just firstname , lastname , address are searchable
	var $order = array('id' => 'DESC'); // default order 

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

function get_datatables($role, $id, $date_days)
{
    $this->_get_datatables_query();

    if ($_POST['length'] != -1) {
        $this->db->limit($_POST['length'], $_POST['start']);

        if ($role == 'admin') {
            $this->db->where([
                'DATE(created_at)' => $date_days,
                'created_by' => $id
            ]);
        }
    }

    $query = $this->db->get();
    return $query->result();
}



	function count_filtered($role,$id,$date_days)
	{
		$this->_get_datatables_query();
if ($role == 'admin') {
            $this->db->where([
                'DATE(created_at)' => $date_days,
                'created_by' => $id
            ]);
        }
		$query = $this->db->get();
		return $query->num_rows();
	}

	public function count_all($role,$id,$date_days)
	{
		$this->db->from($this->table);
	if ($role == 'admin') {
            $this->db->where([
                'DATE(created_at)' => $date_days,
                'created_by' => $id
            ]);
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


public function get_by_name($name,$id=null) {
        $this->db->from($this->table);
       if(is_null($id)){
           $this->db->where('question_name', $name);
        }else{
           $this->db->where('question_name', $name);
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


	public function get_active_question($board,$class,$subject,$role,$empid)
	{
		$this->db->from($this->table);
		if($role =='admin'){
		$this->db->where('board',$board)->where('class',$class)->where('subject',$subject);//->where('status','Y')
		}else{
		    	$this->db->where('board',$board)->where('class',$class)->where('subject',$subject)->where('created_by',$empid);
		}
		$query = $this->db->get();
		return $query->result();
	}
	
	/*
	public function get_active_count_ajax($data)
    {
       // print_r($data);
        $query = '';
        $where="where 1=1 ";
      

        if (isset($data['course_name']) && !empty($data['course_name'])) {
            $query .= " AND course_name LIKE '%$data[course_name]%' ";
        }

        if (isset($data['degree_type']) && !empty($data['degree_type'])) {
           
            $query .= "AND  degree_term ='" . $data['degree_type'] . "'  ";
        }

        if (isset($data['degree_term']) && !empty($data['degree_term'])) {
            $query .= " AND  degree_type ='" . $data['degree_term']. "'  ";
        }

        if (isset($data['clinical_type']) && !empty($data['clinical_type'])) {
            $query .= " AND clinical_type ='" . $data['clinical_type'] . "'  ";
        }

        if (isset($lastId) && $lastId != 'undefined') {
            $query .= "AND id <  $lastId ";
        } 


        $sqlAllData = $this->db->query("SELECT id FROM tbl_courses   $where $query ORDER BY id desc");

        //echo $this->db->last_query();
        echo   $sqlAllData->num_rows();
        die();
    }

    public function get_Allcourses()
    {
        $query = $this->db->query("SELECT * FROM tbl_courses ORDER BY id desc LIMIT 40");
        return $query->result();
    }

    public function get_fatchAllcourses($lastId, $course_name, $degree_type, $degree_term, $clinical_type)
    {
        $query = '';
        $where="where 1=1 ";
      

        if (isset($course_name) && !empty($course_name)) {
            $query .= " AND course_name LIKE '%$course_name%' ";
        }

        if (isset($degree_type) && !empty($degree_type)) {
           
            $query .= "AND   degree_term ='" . $degree_type . "'  ";
        }

        if (isset($degree_term) && !empty($degree_term)) {
            $query .= " AND degree_type ='" . $degree_term . "'  ";
        }

        if (isset($clinical_type) && !empty($clinical_type)) {
            $query .= " AND clinical_type ='" . $clinical_type . "'  ";
        }

        if (isset($lastId) && $lastId != 'undefined') {
            $query .= "AND id <  $lastId ";
        } 


        $sqlAllData = $this->db->query("SELECT * FROM tbl_courses   $where $query ORDER BY id desc LIMIT 40");

        //echo $this->db->last_query();
        return $sqlAllData->result();
    }
	*/
	


}
