<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Revisiones extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('UtilsModel');
        $this->load->Model("RevisionsModel");
        $this->load->Model("UtilsModel");
        $this->load->helper("utilities_helper");
    }

    public function index()
    {
        $data = array(
            "page_title"=> "Revisiones",
            "page_icon"=> "mdi mdi-car-brake-abs",
            'url_add' => 'Revisiones/agregar',
            'txt_add' => 'Agregar Revision',
            'modal_add' => true,
            "table"=>array(
                "ID"=>10,
                "Vehiculo"=>15,
                "Placa"=>10,
                "Fecha"=>20,
                "Hora"=>20,
                "Problema"=>15,
                "Acciones"=>10,
            ),
        );
        template("template/admin",$data,array('extra_js'=>"revision_functions.js"));
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
            0 => 'r.id_revision',
            1 => 'v.p_number',
            2 => 'cm.name',
            5 => 'r.problem'
        );
        if (!isset($valid_columns[$col])) {
            $order = null;
        } else {
            $order = $valid_columns[$col];
        }

        $row = $this->RevisionsModel->get_revisions($order, $search, $valid_columns, $length, $start, $dir);

        if ($row != 0) {
            $data = array();
            foreach ($row as $rows) {
                $menudrop = '<div class="btn-group">
                 <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">Menu <i class="fe-menu"></i></button>
                <div class="dropdown-menu" x-placement="top-start" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(0px, -159px, 0px);">';

                $filename = base_url() . "Revisiones/editar";
                $menudrop .= "<a class='dropdown-item' href='" . $filename . "/" .$rows->id_revision. "' ><i class='fe-edit' ></i> Editar</a>";

                $filename = base_url() . "Revisiones/Detail";
                $menudrop .= "<a class='dropdown-item' href='" . $filename . "/" .$rows->id_revision. "' ><i class='fe-eye' ></i> Ver</a>";

                $filename = base_url() . "Revisiones/Imprimir";
                $menudrop .= "<a class='dropdown-item' href='" . $filename . "/" .$rows->id_revision. "' ><i class='fe-printer' ></i> Imprimir</a>";

                $menudrop .= "</div></div>";


                $data[] = array(
                    $rows->id_revision,
                    $rows->car_model,
                    $rows->p_number,
                    d_m_Y($rows->date),
                    hora_A_P($rows->hour),
                    $rows->problem,
                    $menudrop,
                );
            }
            $total = $this->RevisionsModel->totalrevisions();
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
            $cars = $this->RevisionsModel->get_cars();
            $data = array("cars"=>$cars);
            $this->load->view("revisions/add_revision",$data);
        }
        else if($this->input->method(TRUE) == "POST"){
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
            $exits = $this->RevisionsModel->exits_car($p_number,$year);
            if($exits==0){
                $insert = $this->UtilsModel->insert($table,$data);
                if($insert){
                    $this->UtilsModel->commit();
                    $data['type'] = 'success';
                    $data['title'] = 'Éxito';
                    $data['msg'] = 'Revision agregado exitosamente!';
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

    function editar($id_revision=-1){
        if($this->input->method(TRUE) == "GET"){
            $row = $this->RevisionsModel->get_car($id_revision);
            $brands = $this->RevisionsModel->get_brands();
            $model = $this->RevisionsModel->get_models(0);
            $data = array(
                "id_revision"=>$row->id_revision,
                "p_number"=>$row->p_number,
                "year"=>$row->year,
                "id_brand"=>$row->id_brand,
                "id_model"=>$row->id_model,
                "brands"=>$brands,
                "model"=>$model,
            );
            template("cars/edit_car",$data,array('extra_js'=>"revision_functions.js"));
        }
        else if($this->input->method(TRUE) == "POST"){
            $p_number = $this->input->post("p_number");
            $year = $this->input->post("year");
            $id_brand = $this->input->post("brand");
            $id_model = $this->input->post("model");
            $id_revision = $this->input->post("id_revision");
            $form = array(
                "p_number"=>$p_number,
                "year"=>$year,
                "id_brand"=>$id_brand,
                "id_model"=>$id_model,
            );
            $table = "cars";
            $where = " id_revision ='".$id_revision."'";
            $this->UtilsModel->begin();
            $insert = $this->UtilsModel->update($table,$form,$where);
            if($insert){
                $this->UtilsModel->commit();
                $data['type'] = 'success';
                $data['title'] = 'Éxito';
                $data['msg'] = 'Revision editado exitosamente!';
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
            $where = " id_revision ='".$id."'";
            $this->UtilsModel->begin();
            $delete = $this->UtilsModel->delete($tabla,$where);
            if($delete) {
                $this->UtilsModel->commit();
                $data["type"] = "success";
                $data["title"] = "Información";
                $data["msg"] = "Revision eliminado con exito!";
            }
            else {
                $this->UtilsModel->rollback();
                $data["type"] = "Error";
                $data["title"] = "Alerta!";
                $data["msg"] = "Revision no pudo ser eliminado!";
            }
            echo json_encode($data);
        }
    }

    function state_car(){
        if($this->input->method(TRUE) == "POST"){
            $id_revision = $this->input->post("id");
            $active = $this->RevisionsModel->get_state($id_revision);
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
            $where = " id_revision ='".$id_revision."'";
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


    function get_car_autocomplete($query)
    {
        echo $this->RevisionsModel->get_car_autocomplete($query);
    }

}

/* End of file Revisiones.php */