<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class BrandsModel extends CI_Model
{
    function get_brands($order, $search, $valid_columns, $length, $start, $dir)
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
        $this->db->select('id_brand,name,active');
        $this->db->limit($length, $start);
        $cars = $this->db->get("brands");
        if ($cars->num_rows() > 0) {
            return $cars->result();
        } else {
            return 0;
        }
    }

    function totalbrands(){
        $cars = $this->db->get("brands");
        if ($cars->num_rows() > 0) {
            return $cars->num_rows();
        } else {
            return 0;
        }
    }

    function  exits_brand($brand){
        $this->db->where('name', $brand);
        $cars = $this->db->get("brands");
        if ($cars->num_rows() > 0) {
            return 1;
        } else {
            return 0;
        }
    }

    function get_brand_info($id_brand){
        $this->db->where('id_brand', $id_brand);
        $cars = $this->db->get("brands");
        if ($cars->num_rows() > 0) {
            return $cars->row();
        } else {
            return 0;
        }
    }
    function get_state($id_brand){
        $this->db->where('active', 1);
        $this->db->where('id_brand', $id_brand);
        $clients = $this->db->get("brands");
        if ($clients->num_rows() > 0) {
            return 1;
        } else {
            return 0;
        }
    }
}

/* End of file BrandsModel.php */