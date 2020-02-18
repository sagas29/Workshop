<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class LoginModel extends CI_Model
{
    function exits_username($username){
        $this->db->where('username', $username);
        $query = $this->db->get('users');
        if ($query->num_rows() > 0){
            return 1;
        }
        return 0;
    }

    function login_username($username,$password){
        $this->db->where('username', $username);
        $this->db->where('password', $password);
        $query = $this->db->get('users');
        if ($query->num_rows() > 0){
            return $query->row();
        }
        return 0;
    }

}

/* End of file LoginModel.php */