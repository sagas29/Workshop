<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Servicios extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->model('ServiceModel');
        $this->load->Model("UtilsModel");
    }

    public function index()
    {
        $data = array(
            "page_title"=> "Servicios",
            "page_icon"=> "mdi mdi-book-multiple-variant",
            'url_add' => 'Servicios/agregar',
            'txt_add' => 'Agregar Servicio',
            'modal_add' => false,
            "table"=>array(
                "ID"=>10,
                "Nombre"=>20,
                "Descripcion"=>20,
                "Categoria"=>15,
                "Precio"=>10,
                "Estado"=>15,
                "Acciones"=>10,
            ),
        );
        template("template/admin",$data,array('extra_js'=>"services_functions.js"));
    }

    function get_data(){
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
            0 => 's.id_service',
            1 => 's.name',
            2 => 's.description',
            3 => 'c.name',
            4 => 's.price'
        );
        if (!isset($valid_columns[$col])) {
            $order = null;
        } else {
            $order = $valid_columns[$col];
        }

        $cars = $this->ServiceModel->get_services($order, $search, $valid_columns, $length, $start, $dir);

        if ($cars != 0) {
            $data = array();
            foreach ($cars as $rows) {
                $menudrop = '<div class="btn-group">
                            <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">Menu <i class="fe-menu"></i></button>
                            <div class="dropdown-menu" x-placement="top-start" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(0px, -159px, 0px);">';

                $filename = base_url() . "Servicios/editar";
                $menudrop .= "<a class='dropdown-item' href='" . $filename . "/" .$rows->id_service. "' ><i class='fe-edit' ></i> Editar</a>";

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
                $menudrop .= "<a class='dropdown-item state_service' data-state='$txt'  id=" . $rows->id_service . " ><i class='$icon'></i> $txt</a>";

                $menudrop .= "</div></div>";

                $data[] = array(
                    $rows->id_service,
                    $rows->name,
                    $rows->description,
                    $rows->category,
                    $rows->price,
                    $show_text,
                    $menudrop,
                );
            }
            $total = $this->ServiceModel->totalservices();
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
                "",
                "No se encontraron registros",
                "",
                "",
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
            $category = $this->ServiceModel->get_category(0);
            $data = array(
                "category"=>$category
            );
            template("catalog/add_service",$data,array('extra_js'=>"services_functions.js"));
        }
        else if($this->input->method(TRUE) == "POST"){
            $name = trim($this->input->post("name"));
            $description = trim($this->input->post("description"));
            $category = $this->input->post("category");
            $price = $this->input->post("price");
            $data = array(
                "name"=>$name,
                "description"=>$description,
                "id_category"=>$category,
                "price"=>$price,
                "active"=>1
            );
            $table = "services";
            $this->UtilsModel->begin();
            $exits = $this->ServiceModel->exits_service($name,$price);
            if($exits==0){
                $insert = $this->UtilsModel->insert($table,$data);
                if($insert){
                    $this->UtilsModel->commit();
                    $data['type'] = 'success';
                    $data['title'] = 'Éxito';
                    $data['msg'] = 'Servicio agregado exitosamente!';
                }else{
                    $this->UtilsModel->rollback();
                    $data['type'] = 'error';
                    $data['title'] = 'Error';
                    $data['msg'] = 'No se pudo guardar el servicio!';
                }
            }else{
                $this->UtilsModel->rollback();
                $data['type'] = 'warning';
                $data['title'] = 'Advertencia';
                $data['msg'] = 'El servicio ya existe!';
            }
            echo json_encode($data);
        }
    }

    function editar($id_service=-1){
        if($this->input->method(TRUE) == "GET"){
            $row = $this->ServiceModel->get_service($id_service);
            $category = $this->ServiceModel->get_category(0);
            $data = array(
                "data"=>$row,
                "category"=>$category,
            );
            template("catalog/edit_service",$data,array('extra_js'=>"services_functions.js"));
        }
        else if($this->input->method(TRUE) == "POST"){
            $id_service = $this->input->post('id_service');
            $name = trim($this->input->post("name"));
            $description = trim($this->input->post("description"));
            $category = $this->input->post("category");
            $price = $this->input->post("price");
            $form = array(
                "name"=>$name,
                "description"=>$description,
                "id_category"=>$category,
                "price"=>$price,
                "active"=>1
            );
            $table = "services";
            $where = " id_service ='".$id_service."'";
            $this->UtilsModel->begin();
            $exits = $this->ServiceModel->exits_service($name,$price);
            if($exits==0) {
                $insert = $this->UtilsModel->update($table, $form, $where);
                if ($insert) {
                    $this->UtilsModel->commit();
                    $data['type'] = 'success';
                    $data['title'] = 'Éxito';
                    $data['msg'] = 'Servicio editado exitosamente!';
                } else {
                    $this->UtilsModel->rollback();
                    $data['type'] = 'error';
                    $data['title'] = 'Error';
                    $data['msg'] = 'No se pudo editar el servicio!';
                }
            }
            else{
                $this->UtilsModel->rollback();
                $data['type'] = 'warning';
                $data['title'] = 'Advertencia';
                $data['msg'] = 'El servicio ya existe!';
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

    function state_service(){
        if($this->input->method(TRUE) == "POST"){
            $id_service = $this->input->post("id");
            $active = $this->ServiceModel->get_state($id_service);
            if($active==1){
                $state = 0;
                $text = 'desactivado';
            }else{
                $state = 1;
                $text = 'activado';
            }
            $tabla = "services";
            $form = array(
                "active" =>$state
            );
            $where = " id_service ='".$id_service."'";
            $this->UtilsModel->begin();
            $update = $this->UtilsModel->update($tabla,$form,$where);
            if($update) {
                $this->UtilsModel->commit();
                $data["type"] = "success";
                $data["title"] = "Información";
                $data["msg"] = "Servicio $text con exito!";
            }
            else {
                $this->UtilsModel->rollback();
                $data["type"] = "Error";
                $data["title"] = "Alerta!";
                $data["msg"] = "Servicio no pudo ser $text!";
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