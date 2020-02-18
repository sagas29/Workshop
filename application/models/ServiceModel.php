<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ServiceModel extends CI_Model
{
    function get_services($order, $search, $valid_columns, $length, $start, $dir)
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
        $this->db->select('s.id_service, s.name, s.description, c.name as category, s.price, s.active');
        $this->db->join('category_service as c', 'c.id_category = s.id_category', 'left');
        $clients = $this->db->get("services as s");
        if ($clients->num_rows() > 0) {
            return $clients->result();
        } else {
            return 0;
        }
    }
    function totalservices(){
        $clients = $this->db->get("services");
        if ($clients->num_rows() > 0) {
            return $clients->num_rows();
        } else {
            return 0;
        }
    }

    function exits_service($name,$price){
        $this->db->where('name', $name);
        $this->db->where('price', $price);
        $clients = $this->db->get("services");
        if ($clients->num_rows() > 0) {
            return 1;
        } else {
            return 0;
        }
    }

    function get_service($id_service){
        $this->db->where('id_service', $id_service);
        $clients = $this->db->get("services");
        if ($clients->num_rows() > 0) {
            return $clients->row();
        } else {
            return 0;
        }
    }

    function get_state($id_client){
        $this->db->where('active', 1);
        $this->db->where('id_service', $id_client);
        $clients = $this->db->get("services");
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
        $cars = $this->db->get("category_service");
        if ($cars->num_rows() > 0) {
            return $cars->result();
        } else {
            return 0;
        }
    }

}

/* End of file ClientModel.php */