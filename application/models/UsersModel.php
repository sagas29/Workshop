<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class UsersModel extends CI_Model
{
    function get_users($order, $search, $valid_columns, $length, $start, $dir)
    {
        if ($order !=	 null) {
            $this->db->order_by($order, $dir);
        }
        if (!empty($search)) {
            $x = 0;
            foreach ($valid_columns as $sterm) {
                if ($x == 0) {
                    $this->db->like($sterm, $search);
                } else {
                    $this->db->or_like($sterm, $search);
                }
                $x++;
            }
        }
        $this->db->limit($length, $start);
        $this->db->where('id_user>', 0);
        $clients = $this->db->get("users");
        if ($clients->num_rows() > 0) {
            return $clients->result();
        } else {
            return 0;
        }
    }
    function totalusers(){
        $this->db->where('id_user >', 0);
        $clients = $this->db->get("users");
        if ($clients->num_rows() > 0) {
            return $clients->num_rows();
        } else {
            return 0;
        }
    }

    function exits_user($username){
        $this->db->where('username', $username);
        $clients = $this->db->get("users");
        if ($clients->num_rows() > 0) {
            return 1;
        } else {
            return 0;
        }
    }

    function get_user($id_user){
        $this->db->where('id_user', $id_user);
        $clients = $this->db->get("users");
        if ($clients->num_rows() > 0) {
            return $clients->row();
        } else {
            return 0;
        }
    }

    function get_state($id_user){
        $this->db->where('active', 1);
        $this->db->where('id_user', $id_user);
        $clients = $this->db->get("users");
        if ($clients->num_rows() > 0) {
            return 1;
        } else {
            return 0;
        }
    }

    function get_category($id_service){
        $this->db->select('id_category,name');
        if($id_service>0){
            $this->db->where('id_category', $id_service);
        }
        $this->db->where('active', 1);
        $cars = $this->db->get("users");
        if ($cars->num_rows() > 0) {
            return $cars->result();
        } else {
            return 0;
        }
    }
    function get_controller(){
        $this->db->where('show_controller', 1);
        $cars = $this->db->get("controllers");
        if ($cars->num_rows() > 0) {
            return $cars->result();
        } else {
            return 0;
        }
    }
    function get_menu(){
        $this->db->where('show_menu', 1);
        $cars = $this->db->get("menu");
        if ($cars->num_rows() > 0) {
            return $cars->result();
        } else {
            return 0;
        }
    }
    function get_permissions($id_user){
        $this->db->where('id_user', $id_user);
        $cars = $this->db->get("user_permission");
        return $cars->result();
    }

}

/* End of file ClientModel.php */