<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MenuModel extends CI_Model
{
    function get_menu($id_store,$id_user,$admin)
    {
        $this->db->order_by('menu.priority', 'ASC');;
        $this->db->where('menu.id_store', $id_store);
        $this->db->where("menu.show_menu", 1);

        if($admin==0){
            $this->db->where('user_permission.id_user', $id_user);
            $this->db->join('controllers', 'controllers.id_menu = menu.id_menu', 'left');
            $this->db->join('user_permission', 'user_permission.id_controller = controllers.id_controller','left');
        }
        $query = $this->db->get("menu");
        if ($query->num_rows() > 0){
            return $query->result();
        }
        return 0;
    }
    function get_controller($id_store,$id_user,$admin)
    {
        if($admin==0){
            $this->db->where('user_permission.id_user', $id_user);
            $this->db->join('user_permission', 'user_permission.id_controller = controllers.id_controller');
        }
        $this->db->where('controllers.id_store', $id_store);
        $this->db->where("controllers.show_controller", 1);
        $query = $this->db->get("controllers");
        if ($query->num_rows() > 0){
            return $query->result();
        }
        return 0;
    }
}

/* End of file MenuModel.php */