<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class SearchModel extends CI_Model
{

    function get_car($id_car){
        $this->db->select('e.id_expedient, c.name as client_name,v.p_number,cm.name as car_name ,c1.name as driver_name,v.id_car');
        $this->db->where('v.id_car', $id_car);
        $this->db->join('expedient as e', 'v.id_car = e.id_car');
        $this->db->join('clients as c', 'c.id_client = e.id_client');
        $this->db->join('clients as c1', 'c1.id_client = e.id_driver');
        $this->db->join('car_models as cm', 'cm.id_model = v.id_model');
        $result = $this->db->get("cars as v");
        if ($result->num_rows() > 0) {
            return $result->row();
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


}

/* End of file ClientModel.php */