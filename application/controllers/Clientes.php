<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Clientes extends CI_Controller
{

    public function index()
	{
	    $data = array(
	        "page_title"=> "Clientes",
	        "page_icon"=> "fe-users",
            'url_add' => 'Clientes/agregar',
            'txt_add' => 'Agregar Cliente',
            'modal_add' => false,
            "table"=>array(
                "ID"=>10,
                "Nombre"=>25,
                "Direccion"=>15,
                "Telefono"=>10,
                "Correo"=>15,
                "Estado"=>15,
                "Acciones"=>10,
            ),
        );
        template("template/admin",$data,array('extra_js'=>"client_functions.js"));
	}

	function get_data(){
        $this->load->model('ClientModel');

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
            0 => 'id_client',
            1 => 'name',
            2 => 'address',
            3 => 'cellphone',
            4 => 'email',
            5 => 'dui',
        );
        if (!isset($valid_columns[$col])) {
            $order = null;
        } else {
            $order = $valid_columns[$col];
        }

        $cars = $this->ClientModel->get_clients($order, $search, $valid_columns, $length, $start, $dir);

        if ($cars != 0) {
            $data = array();
            foreach ($cars as $rows) {
                $menudrop = '<div class="btn-group">
                 <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">Menu <i class="fe-menu"></i></button>
                <div class="dropdown-menu" x-placement="top-start" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(0px, -159px, 0px);">';

                $filename = base_url() . "Clientes/editar";
                $menudrop .= "<a class='dropdown-item' href='" . $filename . "/" .$rows->id_client. "' ><i class='fe-edit' ></i> Editar</a>";

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
                $menudrop .= "<a class='dropdown-item state_client' data-state='$txt'  id=" . $rows->id_client . " ><i class='$icon'></i> $txt</a>";

                $menudrop .= "</div></div>";

                $data[] = array(
                    $rows->id_client,
                    $rows->name,
                    $rows->address,
                    $rows->cellphone,
                    $rows->email,
                    $show_text,
                    $menudrop,
                );
            }
            $total = $this->ClientModel->totalclients();
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
        $this->load->Model("ClientModel");
        if($this->input->method(TRUE) == "GET"){
            template("clients/add_client","",array('extra_js'=>"client_functions.js"));
        }
        else if($this->input->method(TRUE) == "POST"){
            $this->load->Model("UtilsModel");
            $name = $this->input->post("name");
            $address = $this->input->post("address");
            $cellphone = $this->input->post("cellphone");
            $email = $this->input->post("email");
            $dui = $this->input->post("dui");
            $data1 = array(
                "name"=>$name,
                "address"=>$address,
                "cellphone"=>$cellphone,
                "email"=>$email,
                "dui"=>$dui,
                'active'=>1
            );
            $table = "clients";
            $this->UtilsModel->begin();
            $exits = $this->ClientModel->exits_car($name,$address,$cellphone);
            if($exits==0){
                $insert = $this->UtilsModel->insert($table,$data1);
                if($insert){
                    $this->UtilsModel->commit();
                    $data['type'] = 'success';
                    $data['title'] = 'Exito';
                    $data['msg'] = 'Cliente agregado exitosamente!';
                }else{
                    $this->UtilsModel->rollback();
                    $data['type'] = 'error';
                    $data['title'] = 'Error';
                    $data['msg'] = 'No se pudo guardar el cliente!';
                }
            }else{
                $this->UtilsModel->rollback();
                $data['type'] = 'warning';
                $data['title'] = 'Advertencia';
                $data['msg'] = 'El cliente ya existe!';
            }
            echo json_encode($data);
        }
    }

    function editar($id_client=-1){
        $this->load->Model("ClientModel");
        if($this->input->method(TRUE) == "GET"){
            $row = $this->ClientModel->get_client_info($id_client);
            $data = array("data"=>$row,"id_client"=>$id_client);
            template("clients/edit_client",$data,array('extra_js'=>"client_functions.js"));
        }
        else if($this->input->method(TRUE) == "POST"){
            $this->load->Model("UtilsModel");
            $name = $this->input->post("name");
            $address = $this->input->post("address");
            $cellphone = $this->input->post("cellphone");
            $email = $this->input->post("email");
            $dui = $this->input->post("dui");
            $id_client = $this->input->post("id_client");
            $form = array(
                "name"=>$name,
                "address"=>$address,
                "cellphone"=>$cellphone,
                "email"=>$email,
                "dui"=>$dui
            );
            $table = "clients";
            $where = " id_client ='".$id_client."'";
            $this->UtilsModel->begin();
            $update = $this->UtilsModel->update($table,$form,$where);
            if($update){
                $this->UtilsModel->commit();
                $data['type'] = 'success';
                $data['title'] = 'Exito';
                $data['msg'] = 'Cliente editado exitosamente!';
            }else{
                $this->UtilsModel->rollback();
                $data['type'] = 'error';
                $data['title'] = 'Error';
                $data['msg'] = 'No se pudo editar el cliente!';
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

    function state_client(){
        if($this->input->method(TRUE) == "POST"){
            $id_client = $this->input->post("id");
            $this->load->model('UtilsModel');
            $this->load->Model("ClientModel");
            $active = $this->ClientModel->get_state($id_client);
            if($active==1){
                $state = 0;
                $text = 'desactivado';
            }else{
                $state = 1;
                $text = 'activado';
            }
            $tabla = "clients";
            $form = array(
                "active" =>$state
            );
            $where = " id_client ='".$id_client."'";
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

}

/* End of file Vehiculos.php */