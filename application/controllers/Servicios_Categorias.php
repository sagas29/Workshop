<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Servicios_Categorias extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('ServiceCategoryModel');
        $this->load->Model("UtilsModel");
    }

    public function index()
    {
        $data = array(
            "page_title"=> "Categorias de Servicios",
            "page_icon"=> "mdi mdi-book-multiple-variant",
            'url_add' => 'Servicios_Categorias/agregar',
            'txt_add' => 'Agregar Categoria',
            'modal_add' => true,
            "table"=>array(
                "ID"=>10,
                "Nombre"=>30,
                "Descripcion"=>50,
                "Estado"=>20,
                "Acciones"=>10,
            ),
        );
        template("template/admin",$data,array('extra_js'=>"service_category_functions.js"));
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
            0 => 'id_category',
            1 => 'name',
            2 => 'description',
        );
        if (!isset($valid_columns[$col])) {
            $order = null;
        } else {
            $order = $valid_columns[$col];
        }

        $category = $this->ServiceCategoryModel->get_category($order, $search, $valid_columns, $length, $start, $dir);

        if ($category != 0) {
            $data = array();
            foreach ($category as $rows) {
                $menudrop = '<div class="btn-group">
                 <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">Menu <i class="fe-menu"></i></button>
                <div class="dropdown-menu" x-placement="top-start" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(0px, -159px, 0px);">';

                $filename = base_url() . "Servicios_Categorias/editar";
                $menudrop .= "<a data-id='$rows->id_category' class='dropdown-item' href='" . $filename . "/" .$rows->id_category. "' id='modal_btn_edit' role='button' data-toggle='modal' data-target='#viewModal' data-refresh='true'><i class='fe-edit' ></i> Editar</a>";

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
                $menudrop .= "<a class='dropdown-item change_state' data-state='$txt'  id=" . $rows->id_category . " ><i class='$icon'></i> $txt</a>";


                $menudrop .= "</div></div>";

                $data[] = array(
                    $rows->id_category,
                    $rows->name,
                    $rows->description,
                    $show_text,
                    $menudrop,
                );
            }
            $total = $this->ServiceCategoryModel->totalcategory();
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
            $this->load->view("catalog/add_category");
        }
        else if($this->input->method(TRUE) == "POST"){
            $name = trim($this->input->post("name"));
            $description = trim($this->input->post("description"));
            $data = array(
                "name"=>$name,
                "description"=>$description,
                "active"=>1
            );
            $table = "category_service";
            $this->UtilsModel->begin();
            $exits = $this->ServiceCategoryModel->exits_category($name,$description);
            if($exits==0){
                $insert = $this->UtilsModel->insert($table,$data);
                if($insert){
                    $this->UtilsModel->commit();
                    $data['type'] = 'success';
                    $data['title'] = 'Éxito';
                    $data['msg'] = 'Categoria agregada exitosamente!';
                }else{
                    $this->UtilsModel->rollback();
                    $data['type'] = 'error';
                    $data['title'] = 'Error';
                    $data['msg'] = 'No se pudo guardar la categoria!';
                }
            }else{
                $this->UtilsModel->rollback();
                $data['type'] = 'warning';
                $data['title'] = 'Advertencia';
                $data['msg'] = 'La categoria ya existe!';
            }
            echo json_encode($data);
        }
    }

    function editar($id_category=-1){
        if($this->input->method(TRUE) == "GET"){
            $row = $this->ServiceCategoryModel->get_category_info($id_category);
            $this->load->view("catalog/edit_category",array("row"=>$row));
        }
        else if($this->input->method(TRUE) == "POST"){
            $id_category = $this->input->post('id_category');
            $name = trim($this->input->post("name"));
            $description = trim($this->input->post("description"));
            $form = array(
                "name"=>$name,
                "description"=>$description,
            );
            $table = "category_service";
            $where = " id_category ='".$id_category."'";
            $this->UtilsModel->begin();
            $exits = $this->ServiceCategoryModel->exits_category($name,$description);
            if($exits==0) {
                $insert = $this->UtilsModel->update($table, $form, $where);
                if ($insert) {
                    $this->UtilsModel->commit();
                    $data['type'] = 'success';
                    $data['title'] = 'Éxito';
                    $data['msg'] = 'Categoria editada exitosamente!';
                } else {
                    $this->UtilsModel->rollback();
                    $data['type'] = 'error';
                    $data['title'] = 'Error';
                    $data['msg'] = 'No se pudo editar la categoria!';
                }
            }
            else{
                $this->UtilsModel->rollback();
                $data['type'] = 'warning';
                $data['title'] = 'Advertencia';
                $data['msg'] = 'La categoria ya existe!';
            }
            echo json_encode($data);
        }
    }

    function state_category(){
        if($this->input->method(TRUE) == "POST"){
            $id_category = $this->input->post("id");
            $active = $this->ServiceCategoryModel->get_state($id_category);
            if($active==1){
                $state = 0;
                $text = 'desactivada';
            }else{
                $state = 1;
                $text = 'activada';
            }
            $tabla = "category_service";
            $form = array(
                "active" =>$state
            );
            $where = " id_category ='".$id_category."'";
            $this->UtilsModel->begin();
            $update = $this->UtilsModel->update($tabla,$form,$where);
            if($update) {
                $this->UtilsModel->commit();
                $data["type"] = "success";
                $data["title"] = "Información";
                $data["msg"] = "Categoria $text con exito!";
            }
            else {
                $this->UtilsModel->rollback();
                $data["type"] = "Error";
                $data["title"] = "Alerta!";
                $data["msg"] = "Categoria no pudo ser $text!";
            }
            echo json_encode($data);
            exit();
        }
    }

}

/* End of file Vehiculos.php */