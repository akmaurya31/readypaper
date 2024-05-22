<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Auth_model extends CI_Model {

    private $table = "user";
    private $_data = array();

    public function validate() {
        //echo "sddsf";die;
        $username = $this->input->post('username');
        $password = $this->input->post('password');
        $this->db->where("username", $username);
        $this->db->where("status", 'Y');
        $query = $this->db->get($this->table);
        
        if ($query->num_rows()) {
            // found row by username	
            $row = $query->row_array();
               
            // now check for the password
            if ($row['password'] == sha1($password)) {
                // we not need password to store in session
                unset($row['password']);
                $this->_data = $row;
                //echo $this->db->last_query();die;
                return ERR_NONE;
            }

            // password not match
            return ERR_INVALID_PASSWORD;
        } else {
            // not found
            return ERR_INVALID_USERNAME;
        }
    }


    public function validatesignup($username,$password) {
        //echo "sddsf";die;
        $username = $username;
        $password = $password;
        $this->db->where("username", $username);
        $this->db->where("status", 'Y');
        $query = $this->db->get($this->table);
//echo $this->db->last_query();die;
        if ($query->num_rows()) {
            // found row by username	
            $row = $query->row_array();

            // now check for the password
            if ($row['password'] == sha1($password)) {
                // we not need password to store in session
                unset($row['password']);
                $this->_data = $row;
                return ERR_NONE;
            }

            // password not match
            return ERR_INVALID_PASSWORD;
        } else {
            // not found
            return ERR_INVALID_USERNAME;
        }
    }


    public function validateOtp($user_id,$otp) {       
        $this->db->where("id", $user_id);
        $this->db->where("status", 'N');       
        $query = $this->db->get($this->table);

        if ($query->num_rows()) {
            $row = $query->row_array();
            if ($row['otp'] == $otp) {
                unset($row['otp']);
                $this->_data = $row;
                return ERR_NONE;
            }
        } else {
            return 0;
        }
    }




    public function get_data() {
        return $this->_data;
    }
    
    
    
    public function getForgetPassword($email){
        	$this->db->from($this->table);
		$this->db->where('email',$email);
		$query = $this->db->get();
		return $query->row();
    }

}
