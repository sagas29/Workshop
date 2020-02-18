<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class Modelos extends  CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('ModeloModel');
    }

    public function index()
    {
        $data = array(
            "page_title"=> "Modelos",
            "page_icon"=> "fe-truck",
            'url_add' => 'Modelos/load_modal',
            'txt_add' => 'Agregar Modelo',
            'modal_add' => true,
            "table"=>array(
                "ID"=>10,
                "Nombre"=>30,
                "Marca"=>30,
                "Estado"=>20,
                "Acciones"=>10,
            ),
        );
        template("template/admin",$data,array('extra_js'=>"model_functions.js"));
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
            0 => 'c.id_model',
            1 => 'c.name',
            2 => 'b.brand'
        );
        if (!isset($valid_columns[$col])) {
            $order = null;
        } else {
            $order = $valid_columns[$col];
        }

        $models = $this->ModeloModel->get_car_models($order, $search, $valid_columns, $length, $start, $dir);

        if ($models != 0) {
            $data = array();
            foreach ($models as $rows) {
                $menudrop = '<div class="btn-group">
                 <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">Menu <i class="fe-menu"></i></button>
                <div class="dropdown-menu" x-placement="top-start" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(0px, -159px, 0px);">';

                $filename = base_url() . "Modelos/editar";
                $menudrop .= "<a data-id='$rows->id_model' class='dropdown-item' href='" . $filename . "/" .$rows->id_model. "' id='modal_btn_edit' role='button' data-toggle='modal' data-target='#viewModal' data-refresh='true'><i class='fe-edit' ></i> Editar</a>";

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
                $menudrop .= "<a class='dropdown-item state_brand' data-state='$txt'  id=" . $rows->id_model . " ><i class='$icon'></i> $txt</a>";

                $menudrop .= "</div></div>";

                $data[] = array(
                    $rows->id_model,
                    $rows->name,
                    $rows->brand,
                    $show_text,
                    $menudrop,
                );
            }
            $total = $this->ModeloModel->totalmodels();
            $output = array(
                "draw" => $draw,
                "recordsTotal" => $total,
                "recordsFiltered" => $total,
                "data" => $data
            );
        } else {
            $data[] = array(
                "",
                "No se encontraron registros",
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
            $brands = $this->ModeloModel->get_brands();
            $this->load->view('cars/add_model',array('brands'=>$brands));

        }else if($this->input->method(TRUE) == "POST"){
            $this->load->model('UtilsModel');
            $name = mb_strtoupper($this->input->post("model_name"));
            $brand = $this->input->post("brand");
            $table = "car_models";
            $form_data = array(
                "name" => $name,
                "id_brand" => $brand,
                "active" => 1
            );
            $this->UtilsModel->begin();
            $exits = $this->ModeloModel->exits_model($name,$brand);
            if($exits==0){
                $insert = $this->UtilsModel->insert($table, $form_data);
                if($insert){
                    $this->UtilsModel->commit();
                    $xdatos['type'] = 'success';
                    $xdatos['title'] = 'Alerta!';
                    $xdatos['msg'] = 'Modelo registrado correctamente!';
                }else{
                    $this->UtilsModel->rollback();
                    $xdatos['type'] = 'error';
                    $xdatos['title'] = 'Alerta!';
                    $xdatos['msg'] = 'El modelo no pudo ser registrado! ERR: 000UNI';
                }
            }
            echo json_encode($xdatos);
        }
    }

    function editar($id_model=-1){
        if($this->input->method(TRUE) == "GET"){
            $row = $this->ModeloModel->get_model_info($id_model);
            $brands = $this->ModeloModel->get_brands();
            $data = array("data"=>$row,"id_model"=>$id_model,"brands"=>$brands);
            $this->load->view('cars/edit_model', $data);
        }
        else if($this->input->method(TRUE) == "POST"){
            $this->load->Model("UtilsModel");
            $model_name = $this->input->post("model_name");
            $brand = $this->input->post("brand");
            $id_model = $this->input->post("id_model");
            $form = array(
                "name"=>$model_name,
                "id_brand" => $brand,
            );
            $table = "car_models";
            $where = " id_model ='".$id_model."'";
            $this->UtilsModel->begin();
            $exits = $this->ModeloModel->exits_model($model_name,$brand);
            if($exits==0){
                $update = $this->UtilsModel->update($table,$form,$where);
                if($update){
                    $this->UtilsModel->commit();
                    $data['type'] = 'success';
                    $data['title'] = 'Exito';
                    $data['msg'] = 'Modelo editado exitosamente!';
                }else{
                    $this->UtilsModel->rollback();
                    $data['type'] = 'error';
                    $data['title'] = 'Error';
                    $data['msg'] = 'No se pudo editar el modelo!';
                }
            }else{
                $this->UtilsModel->rollback();
                $data['type'] = 'error';
                $data['title'] = 'Error';
                $data['msg'] = 'Ya existe un modelo con el mismo nombre!';
            }
            echo json_encode($data);
        }
    }

    function state_model(){
        if($this->input->method(TRUE) == "POST"){
            $id_model = $this->input->post("id");
            $this->load->model('UtilsModel');
            $active = $this->ModeloModel->get_state($id_model);
            if($active==1){
                $state = 0;
                $text = 'desactivado';
            }else{
                $state = 1;
                $text = 'activado';
            }
            $tabla = "car_models";
            $form = array(
                "active" =>$state
            );
            $where = " id_model ='".$id_model."'";
            $this->UtilsModel->begin();
            $update = $this->UtilsModel->update($tabla,$form,$where);
            if($update) {
                $this->UtilsModel->commit();
                $data["type"] = "success";
                $data["title"] = "Información";
                $data["msg"] = "Modelo $text con exito!";
            }
            else {
                $this->UtilsModel->rollback();
                $data["type"] = "Error";
                $data["title"] = "Alerta!";
                $data["msg"] = "Modelo no pudo ser $text!";
            }
            echo json_encode($data);
            exit();
        }
    }
}