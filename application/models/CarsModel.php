<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class CarsModel extends CI_Model
{
    function get_cars($order, $search, $valid_columns, $length, $start, $dir)
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
        $this->db->select('c.id_car,c.p_number,b.name as brand,cm.name as model,c.active,c.year');
        $this->db->limit($length, $start);
        $this->db->join('car_models as cm', 'cm.id_model=c.id_model','left');
        $this->db->join('brands as b', 'b.id_brand=c.id_brand','left');
        $cars = $this->db->get("cars as c");
        if ($cars->num_rows() > 0) {
            return $cars->result();
        } else {
            return 0;
        }
    }
    function totalcars(){
        //$this->db->where('c.active', 1);
        $cars = $this->db->get("cars as c");
        if ($cars->num_rows() > 0) {
            return $cars->num_rows();
        } else {
            return 0;
        }
    }
    function exits_car($p_number,$year){
        $this->db->where('p_number', $p_number);
        $this->db->where('year', $year);
        $cars = $this->db->get("cars as c");
        if ($cars->num_rows() > 0) {
            return 1;
        } else {
            return 0;
        }
    }
    function get_brands(){
        $this->db->select('id_brand,name');
        $this->db->where('active', 1);
        $cars = $this->db->get("brands");
        if ($cars->num_rows() > 0) {
            return $cars->result();
        } else {
            return 0;
        }
    }
    function get_models($id_brand){
        $this->db->select('id_model,name');
        if($id_brand>0){
            $this->db->where('id_brand', $id_brand);
        }
        $this->db->where('active', 1);
        $cars = $this->db->get("car_models");
        if ($cars->num_rows() > 0) {
            return $cars->result();
        } else {
            return 0;
        }
    }
    function get_car($id_car){
        $this->db->where('id_car', $id_car);
        $cars = $this->db->get("cars");
        if ($cars->num_rows() > 0) {
            return $cars->row();
        } else {
            return 0;
        }
    }
    function get_state($id_car){
        $this->db->where('active', 1);
        $this->db->where('id_car', $id_car);
        $clients = $this->db->get("cars");
        if ($clients->num_rows() > 0) {
            return 1;
        } else {
            return 0;
        }
    }

}

/* End of file .php */