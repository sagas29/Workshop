<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ExpedientModel extends CI_Model
{
    function get_expedients($order, $search, $valid_columns, $length, $start, $dir)
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
        $this->db->select('e.id_expedient, v.p_number, cm.name, c.name as owner, c1.name as responsable, e.correlative, e.active');
        $this->db->join('clients as c1', 'c1.id_client = e.id_driver', 'left');
        $this->db->join('clients as c', 'c.id_client = e.id_client', 'left');
        $this->db->join('cars as v', 'v.id_car = e.id_car', 'left');
        $this->db->join('car_models as cm', 'cm.id_model = v.id_model', 'left');
        $clients = $this->db->get("expedient as e");
        if ($clients->num_rows() > 0) {
            return $clients->result();
        } else {
            return 0;
        }
    }

    function totalexpedients(){
        $clients = $this->db->get("expedient");
        if ($clients->num_rows() > 0) {
            return $clients->num_rows();
        } else {
            return 0;
        }
    }

    function exits_expedient($name,$brand,$presentation){
        $this->db->where('name', $name);
        $this->db->where('brand', $brand);
        $this->db->where('presentation', $presentation);
        $clients = $this->db->get("expedient");
        if ($clients->num_rows() > 0) {
            return 1;
        } else {
            return 0;
        }
    }

    function search_mileage($id_expedient){
        $this->db->where('id_expedient', $id_expedient);
        $result = $this->db->get('mileage');
        if($result->num_rows()>0) return 1;
        else return 0;
    }

    function get_expedient($id_expedient){
        $this->db->select('e.id_expedient, e.id_frecuency, c.name as client_name,v.p_number,cm.name as car_name ,c1.name as driver_name,e.id_car, e.id_client, e.id_driver');
        $this->db->where('e.id_expedient', $id_expedient);
        $this->db->join('clients as c', 'c.id_client = e.id_client');
        $this->db->join('cars as v', 'v.id_car = e.id_car');
        $this->db->join('clients as c1', 'c1.id_client = e.id_driver');
        $this->db->join('car_models as cm', 'cm.id_model = v.id_model');
        $clients = $this->db->get("expedient as e");
        if ($clients->num_rows() > 0) {
            return $clients->row();
        } else {
            return 0;
        }
    }

    function get_mileage_info($id_expedient){
        $this->db->where('id_expedient', $id_expedient);
        $result = $this->db->get('mileage');
        if($result->num_rows()>0) return $result->row();
        else return 0;
    }

    function get_mileage($id_expedient){
        $result = $this->db
            ->select('e.id_expedient, f.frecuency, c.name as client_name,v.p_number,cm.name as car_name ,c1.name as driver_name,e.id_car, e.id_client, e.id_driver')
            ->select('m.*,CONCAT(u.first_name," ",last_name) as mechanic_name')
            ->where('e.id_expedient', $id_expedient)
            ->join('mileage as m','m.id_expedient=e.id_expedient','left')
            ->join('clients as c', 'c.id_client = e.id_client','left')
            ->join('cars as v', 'v.id_car = e.id_car','left')
            ->join('clients as c1', 'c1.id_client = e.id_driver','left')
            ->join('car_models as cm', 'cm.id_model = v.id_model','left')
            ->join('users as u', 'u.id_user = m.id_mechanic','left')
            ->join('frecuency as f', 'f.id_frecuency = e.id_frecuency','left')
            ->get("expedient as e");
        if ($result->num_rows() > 0) {
            return $result->row();
        } else {
            return 0;
        }
    }

    function mileage_history($id_mileage){
        $this->db->select('m.*, CONCAT(u.first_name," ",last_name) as username');
        $this->db->where('id_mileage', $id_mileage);
        $this->db->join('users as u', 'u.id_user = m.id_mechanic', 'left');
        $result = $this->db->get("mileage_detail as m");
        return $result->result();
    }

    function get_mileage_last($id_expedient){
         $this->db->where('id_expedient', $id_expedient);
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

    function get_state($id_expedient){
        $this->db->where('active', 1);
        $this->db->where('id_expedient', $id_expedient);
        $clients = $this->db->get("expedient");
        if ($clients->num_rows() > 0) {
            return 1;
        } else {
            return 0;
        }
    }

    function get_car_autocomplete($query){
        $this->db->select('cars.id_car, cars.p_number');
        $this->db->like('cars.p_number', $query);
        $this->db->where('cars.active', 1);
        $this->db->join('expedient', 'expedient.id_car != cars.id_car');
        $this->db->group_by('cars.id_car');
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
        $this->db->order_by('id_expedient', 'desc');
        $this->db->limit(1);
        $clients = $this->db->get("expedient");
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