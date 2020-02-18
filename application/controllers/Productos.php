<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Productos extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('UtilsModel');
        $this->load->Model("ProductsModel");
    }

    public function index()
    {
        $data = array(
            "page_title"=> "Productos",
            "page_icon"=> "fe-shopping-cart",
            'url_add' => 'Productos/agregar',
            'txt_add' => 'Agregar Producto',
            'modal_add' => false,
            "table"=>array(
                "ID"=>5,
                "Nombre"=>15,
                "Marca"=>15,
                "Presentación"=>15,
                "Precio"=>15,
                "Estado"=>15,
                "Acciones"=>10,
            ),
        );
        template("template/admin",$data,array('extra_js'=>"product_functions.js"));
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
            0 => 'id_product',
            1 => 'name',
            2 => 'brand',
            3 => 'presentation',
            4 => 'price'
        );
        if (!isset($valid_columns[$col])) {
            $order = null;
        } else {
            $order = $valid_columns[$col];
        }

        $users = $this->ProductsModel->get_products($order, $search, $valid_columns, $length, $start, $dir);

        if ($users != 0) {
            $data = array();
            foreach ($users as $rows) {
                $menudrop = '<div class="btn-group">
                 <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">Menu <i class="fe-menu"></i></button>
                <div class="dropdown-menu" x-placement="top-start" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(0px, -159px, 0px);">';

                $filename = base_url() . "Productos/editar";
                $menudrop .= "<a class='dropdown-item' href='" . $filename . "/" .$rows->id_product. "' ><i class='fe-edit' ></i> Editar</a>";

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
                $menudrop .= "<a class='dropdown-item state_change' data-state='$txt'  id=" . $rows->id_product . " ><i class='$icon'></i> $txt</a>";

                $menudrop .= "<a class='dropdown-item delete_row'  id=" . $rows->id_product . " ><i class='fe-trash'></i> Eliminar</a>";

                $menudrop .= "</div></div>";


                $data[] = array(
                    $rows->id_product,
                    $rows->name,
                    $rows->brand,
                    $rows->presentation,
                    $rows->price,
                    $show_text,
                    $menudrop,
                );
            }
            $total = $this->ProductsModel->totalproducts();
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
            template("catalog/add_product",'',array('extra_js'=>"product_functions.js"));
        }
        else if($this->input->method(TRUE) == "POST"){
            $name = trim($this->input->post("name"));
            $brand = trim($this->input->post("brand"));
            $presentation = $this->input->post("presentation");
            $price = $this->input->post("price");
            $table = "product";
            $data = array(
                "name"=>$name,
                "brand"=>$brand,
                "presentation"=>$presentation,
                "price"=>$price,
                "active"=>1
            );
            $this->UtilsModel->begin();
            $exits = $this->ProductsModel->exits_product($name,$brand,$presentation);
            if($exits==0){
                $insert = $this->UtilsModel->insert($table,$data);
                if($insert){
                    $this->UtilsModel->commit();
                    $data['type'] = 'success';
                    $data['title'] = 'Éxito';
                    $data['msg'] = 'Producto agregado exitosamente!';
                }else{
                    $this->UtilsModel->rollback();
                    $data['type'] = 'error';
                    $data['title'] = 'Error';
                    $data['msg'] = 'No se pudo guardar el usuario!';
                }
            }else{
                $this->UtilsModel->rollback();
                $data['type'] = 'warning';
                $data['title'] = 'Advertencia';
                $data['msg'] = 'El usuario ya existe!';
            }
            echo json_encode($data);
        }
    }

    function editar($id_product=-1){
        if($this->input->method(TRUE) == "GET"){
            $row = $this->ProductsModel->get_product($id_product);
            $data = array(
                'id_product'=>$row->id_product,
                'name'=>$row->name,
                'brand'=>$row->brand,
                'presentation'=>$row->presentation,
                'price'=> $row->price,
            );
            template("catalog/edit_product",$data,array('extra_js'=>"product_functions.js"));
        }
        else if($this->input->method(TRUE) == "POST"){
            $id_product = trim($this->input->post("id_product"));
            $name = trim($this->input->post("name"));
            $brand = trim($this->input->post("brand"));
            $presentation = $this->input->post("presentation");
            $price = $this->input->post("price");
            $table = "product";
            $data = array(
                "name"=>$name,
                "brand"=>$brand,
                "presentation"=>$presentation,
                "price"=>$price,
            );
            $this->UtilsModel->begin();
            $exits = $this->ProductsModel->exits_product($name,$brand,$presentation);
            if($exits==0){
                $where = " id_product='".$id_product."'";
                $insert = $this->UtilsModel->update($table,$data,$where);
                if($insert){
                    $this->UtilsModel->commit();
                    $data['type'] = 'success';
                    $data['title'] = 'Éxito';
                    $data['msg'] = 'Producto editado exitosamente!';
                }else{
                    $this->UtilsModel->rollback();
                    $data['type'] = 'error';
                    $data['title'] = 'Error';
                    $data['msg'] = 'No se pudo editar el producto!';
                }
            }else{
                $this->UtilsModel->rollback();
                $data['type'] = 'warning';
                $data['title'] = 'Advertencia';
                $data['msg'] = 'El producto ya existe!';
            }
            echo json_encode($data);
        }
    }

    function delete_product(){
        if($this->input->method(TRUE) == "POST"){
            $id_product = $this->input->post("id");
            $tabla = "product";
            $where = " id_product ='".$id_product."'";
            $this->UtilsModel->begin();
            $delete = $this->UtilsModel->delete($tabla,$where);
            if($delete) {
                $this->UtilsModel->commit();
                $data["type"] = "success";
                $data["title"] = "Información";
                $data["msg"] = "Producto eliminado con exito!";
            }
            else {
                $this->UtilsModel->rollback();
                $data["type"] = "Error";
                $data["title"] = "Alerta!";
                $data["msg"] = "Producto no pudo ser eliminado!";
            }
            echo json_encode($data);
        }
    }

    function state_change(){
        if($this->input->method(TRUE) == "POST"){
            $id = $this->input->post("id");
            $active = $this->ProductsModel->get_state($id);
            if($active==1){
                $state = 0;
                $text = 'desactivado';
            }else{
                $state = 1;
                $text = 'activado';
            }
            $tabla = "product";
            $form = array(
                "active" =>$state
            );
            $where = " id_product ='".$id."'";
            $this->UtilsModel->begin();
            $update = $this->UtilsModel->update($tabla,$form,$where);
            if($update) {
                $this->UtilsModel->commit();
                $data["type"] = "success";
                $data["title"] = "Información";
                $data["msg"] = "Producto $text con exito!";
            }
            else {
                $this->UtilsModel->rollback();
                $data["type"] = "Error";
                $data["title"] = "Alerta!";
                $data["msg"] = "Producto no pudo ser $text!";
            }
            echo json_encode($data);
            exit();
        }
    }


}

/* End of file Ususarios.php */