<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Common_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }
    //status update for all table
    public function statusUpdate($table, $data) {
        $this->db->update($table, $data, array("id"=>$data['id']));
        return $this->db->affected_rows();
    }
  
    // delete data from any table
    public function Delete($table,$id){
         $this->db->where('id', $id);
        $this->db->delete($table);
    }

}
