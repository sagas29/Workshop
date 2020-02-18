<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Usuarios extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('UtilsModel');
        $this->load->Model("UsersModel");
        $this->load->helper("Utilities_helper");
    }

    public function index()
    {
        $data = array(
            "page_title"=> "Usuarios",
            "page_icon"=> "fe-users",
            'url_add' => 'Usuarios/agregar',
            'txt_add' => 'Agregar Usuario',
            'modal_add' => false,
            "table"=>array(
                "ID"=>5,
                "Nombre"=>15,
                "Apellido"=>15,
                "Usuario"=>15,
                "Estado"=>15,
                "Tipo"=>15,
                "Acciones"=>10,
            ),
        );
        template("template/admin",$data,array('extra_js'=>"user_functions.js"));
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
            0 => 'id_user',
            1 => 'first_name',
            2 => 'last_name',
            3 => 'username'
        );
        if (!isset($valid_columns[$col])) {
            $order = null;
        } else {
            $order = $valid_columns[$col];
        }

        $users = $this->UsersModel->get_users($order, $search, $valid_columns, $length, $start, $dir);

        if ($users != 0) {
            $data = array();
            foreach ($users as $rows) {
                $menudrop = '<div class="btn-group">
                 <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">Menu <i class="fe-menu"></i></button>
                <div class="dropdown-menu" x-placement="top-start" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(0px, -159px, 0px);">';

                $filename = base_url() . "Usuarios/editar";
                $menudrop .= "<a class='dropdown-item' href='" . $filename . "/" .$rows->id_user. "' ><i class='fe-edit' ></i> Editar</a>";

                $filename = base_url() . "Usuarios/permisos";
                $menudrop .= "<a class='dropdown-item' href='" . $filename . "/" .$rows->id_user. "' ><i class='fe-lock' ></i> Permisos</a>";

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
                $menudrop .= "<a class='dropdown-item state_user' data-state='$txt'  id=" . $rows->id_user . " ><i class='$icon'></i> $txt</a>";

                $menudrop .= "<a class='dropdown-item delete_user'  id=" . $rows->id_user . " ><i class='fe-trash'></i> Eliminar</a>";


                $menudrop .= "</div></div>";

                if ($rows->admin==1){
                    $user = "Administrador";
                }
                else{
                    $user = "Usuario normal";
                }

                $data[] = array(
                    $rows->id_user,
                    $rows->first_name,
                    $rows->last_name,
                    $rows->username,
                    $show_text,
                    $user,
                    $menudrop,
                );
            }
            $total = $this->UsersModel->totalusers();
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
            template("config/add_user",'',array('extra_js'=>"user_functions.js"));
        }
        else if($this->input->method(TRUE) == "POST"){
            $fname = trim($this->input->post("fname"));
            $lname = trim($this->input->post("lname"));
            $username = $this->input->post("username");
            $password = encrypt($this->input->post("password"),'eNcRiPt_K3Y');
            $table = "users";

            if ($_FILES["fileinput"]["name"] != "") {

                $_FILES['file']['name'] = $_FILES['fileinput']['name'];
                $_FILES['file']['type'] = $_FILES['fileinput']['type'];
                $_FILES['file']['tmp_name'] = $_FILES['fileinput']['tmp_name'];
                $_FILES['file']['error'] = $_FILES['fileinput']['error'];
                $_FILES['file']['size'] = $_FILES['fileinput']['size'];

                $config['upload_path'] = "./assets/images/users/";
                $config['allowed_types'] = 'jpg|jpeg|png|bmp';

                $info = new SplFileInfo( $_FILES['fileinput']['name']);
                $name = uniqid(date("dmYHi")).".".$info->getExtension();
                $config['file_name'] = $name;
                $this->upload->initialize($config);
                $this->load->library('upload', $config);

                if ($this->upload->do_upload('file')){
                    $url = 'assets/images/users/'.$name;
                    $data = array(
                        "first_name"=>$fname,
                        "last_name"=>$lname,
                        "username"=>$username,
                        "password"=>$password,
                        "active"=>1,
                        "picture"=>$url,
                    );
                    $this->UtilsModel->begin();
                    $exits = $this->UsersModel->exits_user($username);
                    if($exits==0){
                        $insert = $this->UtilsModel->insert($table,$data);
                        if($insert){
                            $this->UtilsModel->commit();
                            $data['type'] = 'success';
                            $data['title'] = 'Éxito';
                            $data['msg'] = 'Usuario agregado exitosamente!';
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
                }else{
                    $xdatos["type"]="error";
                    $xdatos['title']='Alerta';
                    $xdatos["msg"]="Error al insertar los datos";
                }
            }
            else{

                $data = array(
                    "first_name"=>$fname,
                    "last_name"=>$lname,
                    "username"=>$username,
                    "password"=>$password,
                    "active"=>1
                );
                $this->UtilsModel->begin();
                $exits = $this->UsersModel->exits_user($username);
                if($exits==0){
                    $insert = $this->UtilsModel->insert($table,$data);
                    if($insert){
                        $this->UtilsModel->commit();
                        $data['type'] = 'success';
                        $data['title'] = 'Éxito';
                        $data['msg'] = 'Usuario agregado exitosamente!';
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
            }

            echo json_encode($data);
        }
    }

    function editar($id_user=-1){
        if($this->input->method(TRUE) == "GET"){
            $row = $this->UsersModel->get_user($id_user);
            $data = array(
                'id_user'=>$row->id_user,
                'first_name'=>$row->first_name,
                'last_name'=>$row->last_name,
                'username'=>$row->username,
                'password'=> decrypt($row->password,'eNcRiPt_K3Y'),
                'picture'=> $row->picture,
            );
            template("config/edit_user",$data,array('extra_js'=>"user_functions.js"));
        }
        else if($this->input->method(TRUE) == "POST"){
            $id_user = $this->input->post('id_user');
            $fname = trim($this->input->post("fname"));
            $lname = trim($this->input->post("lname"));
            $username = $this->input->post("username");
            $password = encrypt($this->input->post("password"),'eNcRiPt_K3Y');
            $table = "users";

            if ($_FILES["fileinput"]["name"] != "") {

                $_FILES['file']['name'] = $_FILES['fileinput']['name'];
                $_FILES['file']['type'] = $_FILES['fileinput']['type'];
                $_FILES['file']['tmp_name'] = $_FILES['fileinput']['tmp_name'];
                $_FILES['file']['error'] = $_FILES['fileinput']['error'];
                $_FILES['file']['size'] = $_FILES['fileinput']['size'];

                $config['upload_path'] = "./assets/images/users/";
                $config['allowed_types'] = 'jpg|jpeg|png|bmp';

                $info = new SplFileInfo( $_FILES['fileinput']['name']);
                $name = uniqid(date("dmYHi")).".".$info->getExtension();
                $config['file_name'] = $name;
                $this->upload->initialize($config);
                $this->load->library('upload', $config);

                if ($this->upload->do_upload('file')){
                    $url = 'assets/images/users/'.$name;
                    $data = array(
                        "first_name"=>$fname,
                        "last_name"=>$lname,
                        "username"=>$username,
                        "password"=>$password,
                        "active"=>1,
                        "picture"=>$url,
                    );
                    $this->UtilsModel->begin();
                    //$exits = $this->UsersModel->exits_user($username);
                    //if($exits==0){
                        $where = " id_user='".$id_user."'";
                        $update = $this->UtilsModel->update($table,$data,$where);
                        if($update){
                            $this->UtilsModel->commit();
                            $data['type'] = 'success';
                            $data['title'] = 'Éxito';
                            $data['msg'] = 'Usuario editado exitosamente!';
                        }else{
                            $this->UtilsModel->rollback();
                            $data['type'] = 'error';
                            $data['title'] = 'Error';
                            $data['msg'] = 'No se pudo editar el usuario!';
                        }
                    /*}else{
                        $this->UtilsModel->rollback();
                        $data['type'] = 'warning';
                        $data['title'] = 'Advertencia';
                        $data['msg'] = 'El usuario ya existe!';
                    }*/
                }else{
                    $xdatos["type"]="error";
                    $xdatos['title']='Alerta';
                    $xdatos["msg"]="Error al editar los datos";
                }
            }
            else{

                $data = array(
                    "first_name"=>$fname,
                    "last_name"=>$lname,
                    "username"=>$username,
                    "password"=>$password,
                    "active"=>1
                );
                $this->UtilsModel->begin();
                $exits = $this->UsersModel->exits_user($username);
                //if($exits==0){
                    $where = " id_user='".$id_user."'";
                    $update = $this->UtilsModel->update($table,$data,$where);
                    if($update){
                        $this->UtilsModel->commit();
                        $data['type'] = 'success';
                        $data['title'] = 'Éxito';
                        $data['msg'] = 'Usuario editado exitosamente!';
                    }else{
                        $this->UtilsModel->rollback();
                        $data['type'] = 'error';
                        $data['title'] = 'Error';
                        $data['msg'] = 'No se pudo editar el usuario!';
                    }
                /*}else{
                    $this->UtilsModel->rollback();
                    $data['type'] = 'warning';
                    $data['title'] = 'Advertencia';
                    $data['msg'] = 'El usuario ya existe!';
                }*/
            }
            echo json_encode($data);
        }
    }

    function permisos($id_user=-1){
        if($this->input->method(TRUE) == "GET"){
            $row = $this->UsersModel->get_user($id_user);
            $permissions = $this->UsersModel->get_permissions($id_user);

            $menus = $this->UsersModel->get_menu();
            $controller_base = $this->UsersModel->get_controller();
            $controller = array();
            foreach ($menus as $menu)
            {
                $id_menu = $menu->id_menu;
                $controller[$id_menu] = array_filter($controller_base, function($controller) use ($id_menu)
                {
                    return $controller->id_menu == $id_menu;
                });
            }
            $data = array(
                'id_user'=>$row->id_user,
                'fname'=>$row->first_name,
                'username'=>$row->username,
                'admin'=>$row->admin,
                'controller'=>$controller,
                'menu'=>$menus,
                'permissions_user'=>$permissions
            );
            template("config/permissions",$data,array('extra_js'=>"user_functions.js"));
        }
        else if($this->input->method(TRUE) == "POST"){
            $id_user = $this->input->post("id_user");
            $module = $this->input->post("modules");
            $modules = explode(",",$module);
            $admin = intval($this->input->post("admin"));
            $id_store = $this->session->id_store;
            $this->UtilsModel->begin();
            if($admin==1){
                $table  = "users";
                $form = array("admin"=>1);
                $where = " id_user ='".$id_user."'";
                $update = $this->UtilsModel->update($table,$form,$where);
                if($update){
                    $this->UtilsModel->commit();
                    $data['type'] = 'success';
                    $data['title'] = 'Éxito';
                    $data['msg'] = 'Permisos asignados exitosamente!';
                }else {
                    $this->UtilsModel->rollback();
                    $data['type'] = 'error';
                    $data['title'] = 'Error';
                    $data['msg'] = 'No se pudo guardar los permisos!';
                }
            }else{
                $table  = "users";
                $form = array("admin"=>0);
                $where = " id_user ='".$id_user."'";
                $update = $this->UtilsModel->update($table,$form,$where);
                if($update){
                    $tablep = "user_permission";
                    $wherep = " id_user='".$id_user."'";
                    $delete = $this->UtilsModel->delete($tablep,$wherep);
                    if($delete){
                        for ($i=0;$i<count($modules);$i++){
                            $form_data = array(
                                "id_user"=>$id_user,
                                "id_controller"=>$modules[$i],
                                "id_store"=>$id_store
                            );
                            $insert = $this->UtilsModel->insert($tablep,$form_data);
                        }
                        if($insert){
                            $this->UtilsModel->commit();
                            $data['type'] = 'success';
                            $data['title'] = 'Éxito';
                            $data['msg'] = 'Permisos asignados exitosamente!';
                        }
                    }else{
                        $this->UtilsModel->rollback();
                        $data['type'] = 'error';
                        $data['title'] = 'Error';
                        $data['msg'] = 'No se pudo guardar los permisos!';
                    }
                }else {
                    $this->UtilsModel->rollback();
                    $data['type'] = 'error';
                    $data['title'] = 'Error';
                    $data['msg'] = 'No se pudo guardar los permisos!';
                }
            }
            echo json_encode($data);
        }
    }

    function delete_user(){
        if($this->input->method(TRUE) == "POST"){
            $id_user = $this->input->post("id");
            $this->load->model('UsersModel');
            $tabla = "users";
            $where = " id_user ='".$id_user."'";
            $this->UtilsModel->begin();
            $delete = $this->UtilsModel->delete($tabla,$where);
            if($delete) {
                $this->UtilsModel->commit();
                $data["type"] = "success";
                $data["title"] = "Información";
                $data["msg"] = "Usuario eliminado con exito!";
            }
            else {
                $this->UtilsModel->rollback();
                $data["type"] = "Error";
                $data["title"] = "Alerta!";
                $data["msg"] = "Usuario no pudo ser eliminado!";
            }
            echo json_encode($data);
        }
    }

    function state_user(){
        if($this->input->method(TRUE) == "POST"){
            $id_user = $this->input->post("id");
            $active = $this->UsersModel->get_state($id_user);
            if($active==1){
                $state = 0;
                $text = 'desactivado';
            }else{
                $state = 1;
                $text = 'activado';
            }
            $tabla = "users";
            $form = array(
                "active" =>$state
            );
            $where = " id_user ='".$id_user."'";
            $this->UtilsModel->begin();
            $update = $this->UtilsModel->update($tabla,$form,$where);
            if($update) {
                $this->UtilsModel->commit();
                $data["type"] = "success";
                $data["title"] = "Información";
                $data["msg"] = "Usuario $text con exito!";
            }
            else {
                $this->UtilsModel->rollback();
                $data["type"] = "Error";
                $data["title"] = "Alerta!";
                $data["msg"] = "Usuario no pudo ser $text!";
            }
            echo json_encode($data);
            exit();
        }
    }


}

/* End of file Ususarios.php */