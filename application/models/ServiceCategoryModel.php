<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ServiceCategoryModel extends CI_Model
{
    function get_category($order, $search, $valid_columns, $length, $start, $dir)
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
        $clients = $this->db->get("category_service");
        if ($clients->num_rows() > 0) {
            return $clients->result();
        } else {
            return 0;
        }
    }
    function totalcategory(){
        $clients = $this->db->get("services");
        if ($clients->num_rows() > 0) {
            return $clients->num_rows();
        } else {
            return 0;
        }
    }

    function exits_category($name,$price){
        $this->db->where('name', $name);
        $this->db->where('description', $price);
        $clients = $this->db->get("category_service");
        if ($clients->num_rows() > 0) {
            return 1;
        } else {
            return 0;
        }
    }

    function get_category_info($id_category){
        $this->db->where('id_category', $id_category);
        $clients = $this->db->get("category_service");
        if ($clients->num_rows() > 0) {
            return $clients->row();
        } else {
            return 0;
        }
    }

    function get_state($id_categoryc){
        $this->db->where('active', 1);
        $this->db->where('id_category', $id_categoryc);
        $clients = $this->db->get("category_service");
        if ($clients->num_rows() > 0) {
            return 1;
        } else {
            return 0;
        }
    }

}

/* End of file ClientModel.php */