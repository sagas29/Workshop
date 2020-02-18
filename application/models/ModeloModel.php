<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ModeloModel extends CI_Model
{
    function get_car_models($order, $search, $valid_columns, $length, $start, $dir)
    {
        if ($order!=null) {
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
        $this->db->select('c.id_model,c.name,c.active, b.name as brand');
        $this->db->limit($length, $start);
        $this->db->join('brands as b', 'b.id_brand = c.id_brand', 'left');
        $cars = $this->db->get("car_models as c");
        if ($cars->num_rows() > 0) {
            return $cars->result();
        } else {
            return 0;
        }
    }

    function totalmodels(){
        $cars = $this->db->get("car_models");
        if ($cars->num_rows() > 0) {
            return $cars->num_rows();
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

    function exits_model($model,$id_brand){
        $this->db->where('name', $model);
        $this->db->where('id_brand', $id_brand);
        $cars = $this->db->get("car_models");
        if ($cars->num_rows() > 0) {
            return 1;
        } else {
            return 0;
        }
    }

    function get_model_info($id_model){
        $this->db->where('id_model', $id_model);
        $cars = $this->db->get("car_models");
        if ($cars->num_rows() > 0) {
            return $cars->row();
        } else {
            return 0;
        }
    }
    function get_state($id_model){
        $this->db->where('active', 1);
        $this->db->where('id_model', $id_model);
        $clients = $this->db->get("car_models");
        if ($clients->num_rows() > 0) {
            return 1;
        } else {
            return 0;
        }
    }
}

/* End of file ModeloModel.php */