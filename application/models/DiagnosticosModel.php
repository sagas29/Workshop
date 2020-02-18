<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class DiagnosticosModel extends CI_Model
{
    function get_diagnostic($order, $search, $valid_columns, $length, $start, $dir)
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
        $clients = $this->db->get("diagnostic");
        if ($clients->num_rows() > 0) {
            return $clients->result();
        } else {
            return 0;
        }
    }
    function totaldiagnostic(){
        $clients = $this->db->get("services");
        if ($clients->num_rows() > 0) {
            return $clients->num_rows();
        } else {
            return 0;
        }
    }

    function exits_diagnostic($name,$description){
        $this->db->where('name', $name);
        $this->db->where('description', $description);
        $clients = $this->db->get("diagnostic");
        if ($clients->num_rows() > 0) {
            return 1;
        } else {
            return 0;
        }
    }

    function get_diagnostic_info($id_diagnostic){
        $this->db->where('id_diagnostic', $id_diagnostic);
        $clients = $this->db->get("diagnostic");
        if ($clients->num_rows() > 0) {
            return $clients->row();
        } else {
            return 0;
        }
    }

    function get_state($id_diagnostic){
        $this->db->where('active', 1);
        $this->db->where('id_diagnostic', $id_diagnostic);
        $clients = $this->db->get("diagnostic");
        if ($clients->num_rows() > 0) {
            return 1;
        } else {
            return 0;
        }
    }

}

/* End of file ClientModel.php */