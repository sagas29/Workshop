<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ProductsModel extends CI_Model
{
    function get_products($order, $search, $valid_columns, $length, $start, $dir)
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
        $clients = $this->db->get("product");
        if ($clients->num_rows() > 0) {
            return $clients->result();
        } else {
            return 0;
        }
    }
    function totalproducts(){
        $clients = $this->db->get("product");
        if ($clients->num_rows() > 0) {
            return $clients->num_rows();
        } else {
            return 0;
        }
    }

    function exits_product($name,$brand,$presentation){
        $this->db->where('name', $name);
        $this->db->where('brand', $brand);
        $this->db->where('presentation', $presentation);
        $clients = $this->db->get("product");
        if ($clients->num_rows() > 0) {
            return 1;
        } else {
            return 0;
        }
    }

    function get_product($id_product){
        $this->db->where('id_product', $id_product);
        $clients = $this->db->get("product");
        if ($clients->num_rows() > 0) {
            return $clients->row();
        } else {
            return 0;
        }
    }

    function get_state($id_product){
        $this->db->where('active', 1);
        $this->db->where('id_product', $id_product);
        $clients = $this->db->get("product");
        if ($clients->num_rows() > 0) {
            return 1;
        } else {
            return 0;
        }
    }

}

/* End of file ClientModel.php */