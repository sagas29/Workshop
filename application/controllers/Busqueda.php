<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Busqueda extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('UtilsModel');
        $this->load->Model("SearchModel");
    }

    public function index()
    {
        template("expedient/search_car","",array('extra_js'=>"search_functions.js"));
    }

    function get_car_autocomplete($query){
        echo $this->SearchModel->get_car_autocomplete($query);
    }
    function get_car(){
        $id_car = trim($this->input->post("id_car"));
        $row = $this->SearchModel->get_car($id_car);
        $data = array(
            "found"=>false,
            "type"=>"error",
            "title"=>"Error!",
            "msg"=>"No se ha creado ficha para el vehiculo!:(",
        );
        if ($row) echo json_encode($row);
        else echo json_encode($data);
    }
}

/* End of file Busqueda.php */