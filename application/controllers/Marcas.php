<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class Marcas extends  CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('BrandsModel');
    }

    public function index()
    {
        $data = array(
            "page_title"=> "Marcas",
            "page_icon"=> "fe-truck",
            'url_add' => 'Marcas/load_modal',
            'txt_add' => 'Agregar Marca',
            'modal_add' => true,
            "table"=>array(
                "ID"=>10,
                "Nombre"=>60,
                "Estado"=>20,
                "Acciones"=>10,
            ),
        );
        template("template/admin",$data,array('extra_js'=>"brand_functions.js"));
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
            0 => 'id_brand',
            1 => 'name',
        );
        if (!isset($valid_columns[$col])) {
            $order = null;
        } else {
            $order = $valid_columns[$col];
        }

        $brands = $this->BrandsModel->get_brands($order, $search, $valid_columns, $length, $start, $dir);

        if ($brands != 0) {
            $data = array();
            foreach ($brands as $rows) {
                $menudrop = '<div class="btn-group">
                 <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">Menu <i class="fe-menu"></i></button>
                <div class="dropdown-menu" x-placement="top-start" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(0px, -159px, 0px);">';

                $filename = base_url() . "Marcas/editar";
                $menudrop .= "<a data-id='$rows->id_brand' class='dropdown-item' href='" . $filename . "/" .$rows->id_brand. "' id='modal_btn_edit' role='button' data-toggle='modal' data-target='#viewModal' data-refresh='true'><i class='fe-edit' ></i> Editar</a>";

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
                $menudrop .= "<a class='dropdown-item state_brand' data-state='$txt'  id=" . $rows->id_brand . " ><i class='$icon'></i> $txt</a>";

                $menudrop .= "</div></div>";

                $data[] = array(
                    $rows->id_brand,
                    $rows->name,
                    $show_text,
                    $menudrop,
                );
            }
            $total = $this->BrandsModel->totalbrands();
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

            $this->load->view('cars/add_brand');

        }else if($this->input->method(TRUE) == "POST"){
            $this->load->model('UtilsModel');
            $brand = mb_strtoupper($this->input->post("brand_name"));
            $table = "brands";
            $form_data = array(
                "name" => $brand,
                "active" => 1
            );
            $this->UtilsModel->begin();
            $exits = $this->BrandsModel->exits_brand($brand);
            if($exits==0){
                $insert = $this->UtilsModel->insert($table, $form_data);
                if($insert){
                    $this->UtilsModel->commit();
                    $xdatos['type'] = 'success';
                    $xdatos['title'] = 'Alerta!';
                    $xdatos['msg'] = 'Marca registrada correctamente!';
                }else{
                    $this->UtilsModel->rollback();
                    $xdatos['type'] = 'error';
                    $xdatos['title'] = 'Alerta!';
                    $xdatos['msg'] = 'La marca no pudo ser registrada! ERR: 000UNI';
                }
            }
            echo json_encode($xdatos);
        }
    }

    function state_car(){
        if($this->input->method(TRUE) == "POST"){
            $id_brand = $this->input->post("id");
            $this->load->model('UtilsModel');
            $this->load->Model("BrandsModel");
            $active = $this->BrandsModel->get_state($id_brand);
            if($active==1){
                $state = 0;
                $text = 'desactivado';
            }else{
                $state = 1;
                $text = 'activado';
            }
            $tabla = "brands";
            $form = array(
                "active" =>$state
            );
            $where = " id_brand ='".$id_brand."'";
            $this->UtilsModel->begin();
            $update = $this->UtilsModel->update($tabla,$form,$where);
            if($update) {
                $this->UtilsModel->commit();
                $data["type"] = "success";
                $data["title"] = "Información";
                $data["msg"] = "Marca $text con exito!";
            }
            else {
                $this->UtilsModel->rollback();
                $data["type"] = "Error";
                $data["title"] = "Alerta!";
                $data["msg"] = "Marca no pudo ser $text!";
            }
            echo json_encode($data);
            exit();
        }
    }

    function editar($id_brand=-1){
        if($this->input->method(TRUE) == "GET"){
            $row = $this->BrandsModel->get_brand_info($id_brand);
            $data = array("data"=>$row,"id_brand"=>$id_brand);
            $this->load->view('cars/edit_brand', $data);
        }
        else if($this->input->method(TRUE) == "POST"){
            $this->load->Model("UtilsModel");
            $brand_name = $this->input->post("brand_name");
            $id_brand = $this->input->post("id_brand");
            $form = array(
                "name"=>$brand_name,
            );
            $table = "brands";
            $where = " id_brand ='".$id_brand."'";
            $this->UtilsModel->begin();
            $exits = $this->BrandsModel->exits_brand($brand_name);
            if($exits==0){
                $update = $this->UtilsModel->update($table,$form,$where);
                if($update){
                    $this->UtilsModel->commit();
                    $data['type'] = 'success';
                    $data['title'] = 'Exito';
                    $data['msg'] = 'Marca editado exitosamente!';
                }else{
                    $this->UtilsModel->rollback();
                    $data['type'] = 'error';
                    $data['title'] = 'Error';
                    $data['msg'] = 'No se pudo editar la marca!';
                }
            }else{
                $this->UtilsModel->rollback();
                $data['type'] = 'error';
                $data['title'] = 'Error';
                $data['msg'] = 'Ya existe una marca con el mismo nombre!';
            }
            echo json_encode($data);
        }
    }
}