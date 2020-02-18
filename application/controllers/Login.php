<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

    public function __construct() {
        parent::__construct();
    }

    public function index()
    {
        $this->load->view('login');

    }
    public function logout()
    {
        $this->session->sess_destroy();
        redirect('Login', 'refresh');
    }
    function iniciar_sesion()
    {
        $this->load->helper("Utilities_helper");
        $this->load->model('LoginModel');
        $username = $this->input->post("username");
        $password = encrypt($this->input->post("password"),'eNcRiPt_K3Y');
        if($this->LoginModel->exits_username($username)){
            if ($this->LoginModel->login_username($username, $password)) {
                $row = $this->LoginModel->login_username($username, $password);
                $first_name = $row->first_name;
                $last_name = $row->last_name;
                $imagen = $row->picture;
                $activo = $row->active;
                $id_store = $row->id_store;
                $id_user = $row->id_user;
                $admin = $row->admin;
                if($activo==1){
                    $user_session = array(
                        'id_user'  => $id_user,
                        'id_store'  => $id_store,
                        'username'  => $username,
                        'first_name'  => $first_name,
                        'last_name'  => $last_name,
                        'picture'  => $imagen,
                        'admin' =>$admin,
                        'logged_in' => TRUE
                    );
                    $this->session->set_userdata($user_session);
                    $xdatos["title"] = "Exito";
                    $xdatos["typeinfo"] = "success";
                    $xdatos["msg"] = "Bienvenido ";
                }
                else{
                    $xdatos["typeinfo"] = "error";
                    $xdatos["title"] = "Error";
                    $xdatos["msg"] = "El usuario esta inactivo!";
                }
            }
            else{
                $xdatos["typeinfo"] = "error";
                $xdatos["title"] = "Error";
                $xdatos["msg"] = "Contraseña incorrecta!";
            }
        }else{
            $xdatos["typeinfo"] = "error";
            $xdatos["title"] = "Error";
            $xdatos["msg"] = "El usuario ingresado no existe!";
        }
        echo json_encode($xdatos);
    }

}

/* End of file Login.php */