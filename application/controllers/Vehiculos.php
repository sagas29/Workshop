<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Vehiculos extends CI_Controller
{

	public function index()
	{
	    $data = array(
	        "page_title"=> "Vehículos",
	        "page_icon"=> "fe-truck",
            'url_add' => 'Vehiculos/agregar',
            'txt_add' => 'Agregar Vehículo',
            'modal_add' => false,
            "table"=>array(
                "ID"=>10,
                "Placa"=>15,
                "Año"=>10,
                "Modelo"=>20,
                "Marca"=>20,
                "Estado"=>15,
                "Acciones"=>10,
            ),
        );
        template("template/admin",$data,array('extra_js'=>"car_functions.js"));
	}

	function get_data(){
        $this->load->model('CarsModel');

        $draw = intval($this->input->post("draw"));
        $start = intval($this->input->post("start"));
        $length = intval($this->input->post("length"));

        $order = $this->input->post("order");
        $search = $this->input->post("search");
        $search = $search['value'];
        $col = 0;
        $dir = "";
        if (!empty($order)) {
            foreach ($order as $o) {
                $col = $o['column'];
                $dir = $o['dir'];
            }
        }

        if ($dir != "asc" && $dir != "desc") {
            $dir = "desc";
        }
        $valid_columns = array(
            0 => 'c.id_car',
            1 => 'c.p_number',
            2 => 'cm.name',
            3 => 'b.name'
        );
        if (!isset($valid_columns[$col])) {
            $order = null;
        } else {
            $order = $valid_columns[$col];
        }

        $cars = $this->CarsModel->get_cars($order, $search, $valid_columns, $length, $start, $dir);

        if ($cars != 0) {
            $data = array();
            foreach ($cars as $rows) {
                $menudrop = '<div class="btn-group">
                 <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">Menu <i class="fe-menu"></i></button>
                <div class="dropdown-menu" x-placement="top-start" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(0px, -159px, 0px);">';

                $filename = base_url() . "Vehiculos/editar";
                $menudrop .= "<a class='dropdown-item' href='" . $filename . "/" .$rows->id_car. "' ><i class='fe-edit' ></i> Editar</a>";

                $state = $rows->active;
                if($state==1){
                    $txt = "Desactivar";
                    $show_text = "<a class='text-success'>Activo<a>";
                    $icon = "mdi mdi-account-off-outline";
                }
                else{
                    $txt = "Activar";
                    $show_text = "<a class='text-danger'>Inactivo<a>";
                    $icon = "mdi mdi-account-check-outline";
                }
                $menudrop .= "<a class='dropdown-item state_car' data-state='$txt'  id=" . $rows->id_car . " ><i class='$icon'></i> $txt</a>";

                //$filename = base_url() . "Vehiculos/eliminar";
                //$menudrop .= "<a class='dropdown-item deleted' id=" . $rows->id_car . " ><i class='fe-delete'></i> Eliminar</a>";

                $menudrop .= "</div></div>";

                $data[] = array(
                    $rows->id_car,
                    $rows->p_number,
                    $rows->year,
                    $rows->brand,
                    $rows->model,
                    $show_text,
                    //$rows->active == 1 ? "ACTIVA" : "INACTIVA",
                    $menudrop,
                );
            }
            $total = $this->CarsModel->totalcars();
            $output = array(
                "draw" => $draw,
                "recordsTotal" => $total,
                "recordsFiltered" => $total,
                "data" => $data
            );
        } else {
            $data[] = array(
                "",
                "",
                "No se encontraron registros",
                "",
                "",
                //"",
                "",
            );
            $output = array(
                "draw" => 0,
                "recordsTotal" => 0,
                "recordsFiltered" => 0,
                "data" => $data
            );
        }
        echo json_encode($output);
        exit();
    }

    function agregar(){
        if($this->input->method(TRUE) == "GET"){
            $this->load->Model("CarsModel");
            $brands = $this->CarsModel->get_brands();
            $model = $this->CarsModel->get_models(0);
            $data = array(
                "brands"=>$brands,
                "model"=>$model,
            );
            template("cars/add_car",$data,array('extra_js'=>"car_functions.js"));
        }
        else if($this->input->method(TRUE) == "POST"){
            $this->load->Model("UtilsModel");
            $this->load->Model("CarsModel");
            $p_number = $this->input->post("p_number");
            $year = $this->input->post("year");
            $id_brand = $this->input->post("brand");
            $id_model = $this->input->post("model");
            $data = array(
                "p_number"=>$p_number,
                "year"=>$year,
                "id_brand"=>$id_brand,
                "id_model"=>$id_model,
                "active"=>1
            );
            $table = "cars";
            $this->UtilsModel->begin();
            $exits = $this->CarsModel->exits_car($p_number,$year);
            if($exits==0){
                $insert = $this->UtilsModel->insert($table,$data);
                if($insert){
                    $this->UtilsModel->commit();
                    $data['type'] = 'success';
                    $data['title'] = 'Éxito';
                    $data['msg'] = 'Vehículo agregado exitosamente!';
                }else{
                    $this->UtilsModel->rollback();
                    $data['type'] = 'error';
                    $data['title'] = 'Error';
                    $data['msg'] = 'No se pudo guardar el vehículo!';
                }
            }else{
                $this->UtilsModel->rollback();
                $data['type'] = 'warning';
                $data['title'] = 'Advertencia';
                $data['msg'] = 'El vehículo ya existe!';
            }
            echo json_encode($data);
        }
    }

    function editar($id_car=-1){
        if($this->input->method(TRUE) == "GET"){
            $this->load->Model("CarsModel");
            $row = $this->CarsModel->get_car($id_car);
            $brands = $this->CarsModel->get_brands();
            $model = $this->CarsModel->get_models(0);
            $data = array(
                "id_car"=>$row->id_car,
                "p_number"=>$row->p_number,
                "year"=>$row->year,
                "id_brand"=>$row->id_brand,
                "id_model"=>$row->id_model,
                "brands"=>$brands,
                "model"=>$model,
            );
            template("cars/edit_car",$data,array('extra_js'=>"car_functions.js"));
        }
        else if($this->input->method(TRUE) == "POST"){
            $this->load->Model("UtilsModel");
            $this->load->Model("CarsModel");
            $p_number = $this->input->post("p_number");
            $year = $this->input->post("year");
            $id_brand = $this->input->post("brand");
            $id_model = $this->input->post("model");
            $id_car = $this->input->post("id_car");
            $form = array(
                "p_number"=>$p_number,
                "year"=>$year,
                "id_brand"=>$id_brand,
                "id_model"=>$id_model,
            );
            $table = "cars";
            $where = " id_car ='".$id_car."'";
            $this->UtilsModel->begin();
            $insert = $this->UtilsModel->update($table,$form,$where);
            if($insert){
                $this->UtilsModel->commit();
                $data['type'] = 'success';
                $data['title'] = 'Éxito';
                $data['msg'] = 'Vehículo editado exitosamente!';
            }else{
                $this->UtilsModel->rollback();
                $data['type'] = 'error';
                $data['title'] = 'Error';
                $data['msg'] = 'No se pudo editar el vehículo!';
            }
            echo json_encode($data);
        }
    }

    function eliminar(){
        if($this->input->method(TRUE) == "POST"){
            $id = $this->input->post("id");
            $this->load->model('UtilsModel');
            $tabla = "cars";
            $where = " id_car ='".$id."'";
            $this->UtilsModel->begin();
            $delete = $this->UtilsModel->delete($tabla,$where);
            if($delete) {
                $this->UtilsModel->commit();
                $data["type"] = "success";
                $data["title"] = "Información";
                $data["msg"] = "Vehículo eliminado con exito!";
            }
            else {
                $this->UtilsModel->rollback();
                $data["type"] = "Error";
                $data["title"] = "Alerta!";
                $data["msg"] = "Vehículo no pudo ser eliminado!";
            }
            echo json_encode($data);
        }
    }

    function state_car(){
        if($this->input->method(TRUE) == "POST"){
            $id_car = $this->input->post("id");
            $this->load->model('UtilsModel');
            $this->load->Model("CarsModel");
            $active = $this->CarsModel->get_state($id_car);
            if($active==1){
                $state = 0;
                $text = 'desactivado';
            }else{
                $state = 1;
                $text = 'activado';
            }
            $tabla = "cars";
            $form = array(
                "active" =>$state
            );
            $where = " id_car ='".$id_car."'";
            $this->UtilsModel->begin();
            $update = $this->UtilsModel->update($tabla,$form,$where);
            if($update) {
                $this->UtilsModel->commit();
                $data["type"] = "success";
                $data["title"] = "Información";
                $data["msg"] = "Cliente $text con exito!";
            }
            else {
                $this->UtilsModel->rollback();
                $data["type"] = "Error";
                $data["title"] = "Alerta!";
                $data["msg"] = "Cliente no pudo ser $text!";
            }
            echo json_encode($data);
            exit();
        }
    }


    function get_models()
    {
        $this->load->model('CarsModel');
        $id_brand = $this->input->post("id_brand");
        $models = $this->CarsModel->get_models($id_brand);
        $option = "";
        $option .= "<option value='0'>Seleccione</option>";
        foreach ($models as  $value) {
            $option .= "<option value='".$value->id_model."'>".$value->name."</option>";
        }
        echo $option;
    }

}

/* End of file Vehiculos.php */