<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Fichas extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('UtilsModel');
        $this->load->Model("ExpedientModel");
        $this->load->helper("utilities_helper");
    }

    public function index()
    {
        $data = array(
            "page_title"=> "Ficha",
            "page_icon"=> "fe-layers",
            'url_add' => 'Fichas/agregar',
            'txt_add' => 'Agregar Ficha',
            'modal_add' => false,
            "table"=>array(
                "ID"=>10,
                "Vehiculo"=>15,
                "Placa"=>15,
                "Propietario"=>15,
                "Responsable"=>15,
                "Ficha"=>10,
                //"Estado"=>10,
                "Acciones"=>10,
            ),
        );
        template("template/admin",$data,array('extra_js'=>"expedient_functions.js"));
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
            0 => 'e.id_expedient',
            1 => 'cm.name',
            2 => 'v.p_number',
            3 => 'c.name',
            4 => 'c1.name',
            5 => 'e.correlative'
        );
        if (!isset($valid_columns[$col])) {
            $order = null;
        } else {
            $order = $valid_columns[$col];
        }

        $users = $this->ExpedientModel->get_expedients($order, $search, $valid_columns, $length, $start, $dir);

        if ($users != 0) {
            $data = array();
            foreach ($users as $rows) {
                $menudrop = '<div class="btn-group">
                 <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">Menu <i class="fe-menu"></i></button>
                <div class="dropdown-menu" x-placement="top-start" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(0px, -159px, 0px);">';

                $filename = base_url() . "Fichas/editar";
                $menudrop .= "<a class='dropdown-item' href='" . $filename . "/" .$rows->id_expedient. "' ><i class='fe-edit' ></i> Editar</a>";

                $filename = base_url() . "Fichas/kilometraje";
                $menudrop .= "<a class='dropdown-item' href='" . $filename . "/" .$rows->id_expedient. "' ><i class='mdi mdi-car-cruise-control' ></i> Kilometraje</a>";

                $filename = base_url() . "Revisiones/ver";
                $menudrop .= "<a class='dropdown-item' href='" . $filename . "/" .$rows->id_expedient. "' ><i class='mdi mdi-hammer' ></i> Revisiones</a>";

                $menudrop .= "</div></div>";

                $cor = $rows->correlative;
                $correlative = str_pad($cor,7,"0",STR_PAD_LEFT);

                $data[] = array(
                    $rows->id_expedient,
                    $rows->name,
                    $rows->p_number,
                    $rows->owner,
                    $rows->responsable,
                    $correlative,
                    //$show_text,
                    $menudrop,
                );
            }
            $total = $this->ExpedientModel->totalexpedients();
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
            $frecuency = $this->ExpedientModel->get_frecuency();
            $data = array(
                'frecuency'=> $frecuency,
            );
            template("expedient/add_expedient",$data,array('extra_js'=>"expedient_functions.js"));
        }
        else if($this->input->method(TRUE) == "POST"){
            $id_car = trim($this->input->post("id_car"));
            $id_client = trim($this->input->post("id_owner"));
            $ic_responsable = $this->input->post("id_responsable");
            $frecuency = $this->input->post("frecuency");
            $date = date("Y-m-d");
            $row = $this->ExpedientModel->get_lat_correlative();

            $correlative = $row->correlative+1;
            $table = "expedient";
            $data = array(
                "id_car"=>$id_car,
                "id_client"=>$id_client,
                "id_driver"=>$ic_responsable,
                "id_frecuency"=>$frecuency,
                "creation_date"=>$date,
                "correlative"=>$correlative,
                "active"=>1
            );
            $this->UtilsModel->begin();
            $insert = $this->UtilsModel->insert($table,$data);
            if($insert){
                $this->UtilsModel->commit();
                $data['type'] = 'success';
                $data['title'] = 'Éxito';
                $data['msg'] = 'Ficha agregada exitosamente!';
            }else{
                $this->UtilsModel->rollback();
                $data['type'] = 'error';
                $data['title'] = 'Error';
                $data['msg'] = 'No se pudo guardar la ficha!';
            }
            echo json_encode($data);
        }
    }

    function editar($id_expedient=-1){
        if($this->input->method(TRUE) == "GET"){
            $row = $this->ExpedientModel->get_expedient($id_expedient);
            $frecuency = $this->ExpedientModel->get_frecuency();
            $data = array(
                'id_expedient'=>$row->id_expedient,
                'id_car'=>$row->id_car,
                'car_name'=>$row->car_name,
                'id_client'=>$row->id_client,
                'client_name'=>$row->client_name,
                'id_driver'=>$row->id_driver,
                'driver_name'=>$row->driver_name,
                'id_frecuency'=> $row->id_frecuency,
                'frecuency'=> $frecuency,
            );
            template("expedient/edit_expedient",$data,array('extra_js'=>"expedient_functions.js"));
        }
        else if($this->input->method(TRUE) == "POST"){
            $id_car = trim($this->input->post("id_car"));
            $id_client = trim($this->input->post("id_owner"));
            $ic_responsable = $this->input->post("id_responsable");
            $frecuency = $this->input->post("frecuency");
            $id_expedient = $this->input->post("id_expedient");
            $table = "expedient";
            $data = array(
                "id_car"=>$id_car,
                "id_client"=>$id_client,
                "id_driver"=>$ic_responsable,
                "id_frecuency"=>$frecuency,
            );
            $this->UtilsModel->begin();
            $where = " id_expedient ='".$id_expedient."'";
            $insert = $this->UtilsModel->update($table,$data,$where);
            if($insert){
                $this->UtilsModel->commit();
                $data['type'] = 'success';
                $data['title'] = 'Éxito';
                $data['msg'] = 'Ficha editada exitosamente!';
            }else{
                $this->UtilsModel->rollback();
                $data['type'] = 'error';
                $data['title'] = 'Error';
                $data['msg'] = 'No se pudo editar la ficha!';
            }
            echo json_encode($data);
        }
    }

    function kilometraje($id_expedient=-1){
        if($this->input->method(TRUE) == "GET"){
            //$id_expedient = $this->input->get('id_expedient',TRUE);
            $datas = $this->ExpedientModel->get_mileage($id_expedient);
            $id_mileage = $datas->id_mileage;
            $mileage = $this->ExpedientModel->mileage_history($id_mileage);
            $data = array(
                'id_expedient'=>$id_expedient,
                'id_car'=>$datas->id_car,
                'car_name'=>$datas->car_name,
                'p_number'=>$datas->p_number,
                'id_client'=>$datas->id_client,
                'client_name'=>$datas->client_name,
                'id_driver'=>$datas->id_driver,
                'driver_name'=>$datas->driver_name,
                'current'=>$datas->current,
                'frecuency'=>$datas->frecuency,
                'mechanic_name'=>$datas->mechanic_name,
                'service_date'=>d_m_Y($datas->service_date),
                'mileage_history'=>$mileage,
            );

            template("expedient/mileage",$data,array('extra_js'=>"expedient_functions.js"));
        }
        else if($this->input->method(TRUE) == "POST"){
            $id_expedient = trim($this->input->post("id_expedient"));
            $id_user = trim($this->input->post("responsable"));
            $mileage = trim($this->input->post("mileage"));

            $this->UtilsModel->begin();
            //Verify if exits mileage
            $exits = $this->ExpedientModel->search_mileage($id_expedient);
            //Doesnt exits
            if($exits==0){
                $table = "mileage";
                $form_data = array(
                    "id_expedient"=>$id_expedient,
                    "id_mechanic"=>$id_user,
                    "current"=>$mileage,
                    "last"=>$mileage,
                    "creation_date"=>date("Y-m-d"),
                    "service_date"=>date("Y-m-d"),
                );
                $insert = $this->UtilsModel->insert($table,$form_data);
                if($insert){
                    $rws = $this->ExpedientModel->get_mileage_info($id_expedient);
                    $id_mileage = $rws->id_mileage;
                    //Insert record in table mileage_detail
                    $tableb = "mileage_detail";
                    $form_datab = array(
                        "id_mileage"=>$id_mileage,
                        "id_mechanic"=>$id_user,
                        "measure"=>$mileage,
                        "date"=>date("Y-m-d"),
                    );
                    $insert2 = $this->UtilsModel->insert($tableb,$form_datab);
                    if($insert2){
                        $this->UtilsModel->commit();
                        $data['type'] = 'success';
                        $data['title'] = 'Éxito';
                        $data['msg'] = 'Kilometraje actualizado!';
                    }else{
                        $this->UtilsModel->rollback();
                        $data['type'] = 'error';
                        $data['title'] = 'Error';
                        $data['msg'] = 'No se pudo actualizar el kilometraje!';
                    }
                }
                else{
                    $this->UtilsModel->rollback();
                    $data['type'] = 'error';
                    $data['title'] = 'Error';
                    $data['msg'] = 'No se pudo actualizar el kilometraje!';
                }
            }
            //Exits Mileage
            else{
                //update table mileage
                $rws = $this->ExpedientModel->get_mileage_info($id_expedient);
                $id_mileage = $rws->id_mileage;

                //Insert record in table mileage_detail
                $tableb = "mileage_detail";
                $form_datab = array(
                    "id_mileage"=>$id_mileage,
                    "id_mechanic"=>$id_user,
                    "measure"=>$mileage,
                    "date"=>date("Y-m-d"),
                );
                $insert2 = $this->UtilsModel->insert($tableb,$form_datab);
                if($insert2){
                    $this->UtilsModel->commit();
                    $data['type'] = 'success';
                    $data['title'] = 'Éxito';
                    $data['msg'] = 'Kilometraje actualizado!';
                }else{
                    $this->UtilsModel->rollback();
                    $data['type'] = 'error';
                    $data['title'] = 'Error';
                    $data['msg'] = 'No se pudo actualizar el kilometraje!';
                }
            }
            $data['id_expedient']=$id_expedient;
            echo json_encode($data);
        }
    }

    function delete_expedient(){
        if($this->input->method(TRUE) == "POST"){
            $id_expedient = $this->input->post("id");
            $tabla = "expedient";
            $where = " id_expedient ='".$id_expedient."'";
            $this->UtilsModel->begin();
            $delete = $this->UtilsModel->delete($tabla,$where);
            if($delete) {
                $this->UtilsModel->commit();
                $data["type"] = "success";
                $data["title"] = "Información";
                $data["msg"] = "Ficha eliminado con exito!";
            }
            else {
                $this->UtilsModel->rollback();
                $data["type"] = "Error";
                $data["title"] = "Alerta!";
                $data["msg"] = "Ficha no pudo ser eliminado!";
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
            $tabla = "expedient";
            $form = array(
                "active" =>$state
            );
            $where = " id_expedient ='".$id."'";
            $this->UtilsModel->begin();
            $update = $this->UtilsModel->update($tabla,$form,$where);
            if($update) {
                $this->UtilsModel->commit();
                $data["type"] = "success";
                $data["title"] = "Información";
                $data["msg"] = "Ficha $text con exito!";
            }
            else {
                $this->UtilsModel->rollback();
                $data["type"] = "Error";
                $data["title"] = "Alerta!";
                $data["msg"] = "Ficha no pudo ser $text!";
            }
            echo json_encode($data);
            exit();
        }
    }

    function get_car_autocomplete($query){
        echo $this->ExpedientModel->get_car_autocomplete($query);
    }

    function get_client_autocomplete($query){
        echo $this->ExpedientModel->get_client_autocomplete($query);
    }

    function load_modal_update($id_expedient){
        $users = $this->ExpedientModel->get_users();
        $current = $this->ExpedientModel->get_mileage_last($id_expedient);
        $data = array(
            'row'=> $current,
            'id_expedient'=>$id_expedient,
            'users'=>$users,
        );
        $this->load->view('expedient/update_mileage',$data);
    }
}

/* End of file Ususarios.php */