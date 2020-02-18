<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class RevisionsModel extends CI_Model
{
    function get_revisions($order, $search, $valid_columns, $length, $start, $dir)
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
        $this->db->select('r.*, v.p_number, cm.name as car_model');
        $this->db->join('cars as v', 'v.id_car = r.id_car', 'left');
        $this->db->join('car_models as cm', 'cm.id_model = v.id_model', 'left');
        $clients = $this->db->get("revisions as r");
        if ($clients->num_rows() > 0) {
            return $clients->result();
        } else {
            return 0;
        }
    }

    function totalrevisions(){
        $clients = $this->db->get("revisions");
        if ($clients->num_rows() > 0) {
            return $clients->num_rows();
        } else {
            return 0;
        }
    }

    function get_cars(){
        return $this->db->where('active',1)->get('cars');
    }

    function exits_revision($name,$brand,$presentation){
        $this->db->where('name', $name);
        $this->db->where('brand', $brand);
        $this->db->where('presentation', $presentation);
        $clients = $this->db->get("revision");
        if ($clients->num_rows() > 0) {
            return 1;
        } else {
            return 0;
        }
    }

    function search_mileage($id_revision){
        $this->db->where('id_revision', $id_revision);
        $result = $this->db->get('mileage');
        if($result->num_rows()>0) return 1;
        else return 0;
    }

    function get_revision($id_revision){
        $this->db->select('e.id_revision, e.id_frecuency, c.name as client_name,v.p_number,cm.name as car_name ,c1.name as driver_name,e.id_car, e.id_client, e.id_driver');
        $this->db->where('e.id_revision', $id_revision);
        $this->db->join('clients as c', 'c.id_client = e.id_client');
        $this->db->join('cars as v', 'v.id_car = e.id_car');
        $this->db->join('clients as c1', 'c1.id_client = e.id_driver');
        $this->db->join('car_models as cm', 'cm.id_model = v.id_model');
        $clients = $this->db->get("revision as e");
        if ($clients->num_rows() > 0) {
            return $clients->row();
        } else {
            return 0;
        }
    }

    function get_mileage_info($id_revision){
        $this->db->where('id_revision', $id_revision);
        $result = $this->db->get('mileage');
        if($result->num_rows()>0) return $result->row();
        else return 0;
    }

    function get_mileage($id_revision){
        $result = $this->db
            ->select('e.id_revision, f.frecuency, c.name as client_name,v.p_number,cm.name as car_name ,c1.name as driver_name,e.id_car, e.id_client, e.id_driver')
            ->select('m.*,CONCAT(u.first_name," ",last_name) as mechanic_name')
            ->where('m.id_revision', $id_revision)
            ->join('revision as e', 'e.id_revision = m.id_revision','left')
            ->join('clients as c', 'c.id_client = e.id_client')
            ->join('cars as v', 'v.id_car = e.id_car')
            ->join('clients as c1', 'c1.id_client = e.id_driver')
            ->join('car_models as cm', 'cm.id_model = v.id_model')
            ->join('users as u', 'u.id_user = m.id_mechanic','left')
            ->join('frecuency as f', 'f.id_frecuency = e.id_frecuency','left')
            ->get("mileage as m");
        if ($result->num_rows() > 0) {
            return $result->row();
        } else {
            return 0;
        }
    }

    function mileage_history($id_mileage){
        $this->db->where('id_mileage', $id_mileage);
        $result = $this->db->get("mileage_detail");
        if ($result->num_rows() > 0) {
            return $result->result();
        } else {
            return 0;
        }
    }

    function get_mileage_last($id_revision){
        $this->db->where('id_revision', $id_revision);
        $result = $this->db->get("mileage");
        if ($result->num_rows() > 0) {
            return $result->row()->current;
        } else {
            return 0;
        }
    }

    function get_frecuency(){
        return $this->db->get("frecuency")->result();
    }

    function get_state($id_revision){
        $this->db->where('active', 1);
        $this->db->where('id_revision', $id_revision);
        $clients = $this->db->get("revision");
        if ($clients->num_rows() > 0) {
            return 1;
        } else {
            return 0;
        }
    }

    function get_car_autocomplete($query){
        $this->db->select('id_car, p_number');
        $this->db->like('p_number', $query);
        $this->db->where('active', 1);
        $query = $this->db->get('cars');
        if($query->num_rows() > 0)
        {
            $output = array();
            foreach($query->result() as $row)
            {
                $output[] = array(
                    'car' => $row->id_car." | ".$row->p_number
                );
            }
            echo json_encode($output);
        }
    }

    function get_client_autocomplete($query){
        $this->db->like('name', $query);
        $this->db->where('active', 1);
        $query = $this->db->get('clients');
        if($query->num_rows() > 0)
        {
            $output = array();
            foreach($query->result() as $row)
            {
                $output[] = array(
                    'client' => $row->id_client." | ".$row->name
                );
            }
            echo json_encode($output);
        }
    }

    function get_lat_correlative(){
        $this->db->select('correlative');
        $this->db->order_by('id_revision', 'desc');
        $this->db->limit(1);
        $clients = $this->db->get("revision");
        if ($clients->num_rows() > 0) {
            return $clients->row();
        } else {
            return 0;
        }
    }

    function get_users(){
        $this->db->select('id_user, CONCAT(first_name," ",last_name) as name');
        $this->db->where('active', 1);
        $this->db->where('id_user>', 0);
        $result = $this->db->get('users');
        if ($result->num_rows() > 0) {
            return $result->result();
        } else {
            return 0;
        }
    }

}

/* End of file ClientModel.php */