<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="utf-8" />
        <title>Upires Workshop</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta content="Sistema de Administración de taller" name="description" />
        <meta content="Soluciones Ideales" name="author" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <!-- App favicon -->
        <link href="<?=base_url();?>assets/images/logo.png" rel="icon" type="image/png">

        <!-- App css -->
        <link href="<?=base_url();?>assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <link href="<?=base_url();?>assets/css/icons.min.css" rel="stylesheet" type="text/css" />
        <link href="<?=base_url();?>assets/css/app.min.css" rel="stylesheet" type="text/css" />

        <link href="<?=base_url();?>assets/libs/sweetalert2/sweetalert2.min.css" rel="stylesheet" type="text/css" />

    </head>

    <body class="authentication-bg authentication-bg-pattern">

        <div class="account-pages mt-5 mb-5">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-8 col-lg-6 col-xl-5">
                        <div class="card bg-pattern">

                            <div class="card-body p-4">

                                <div class="text-center w-75 m-auto">
                                    <span><img src="<?=base_url();?>assets/images/logo.png" alt="" height="200"></span>
                                    <p class="text-muted mb-4 mt-3">Ingrese tu usuario y clave para ingresar al panel de control.</p>
                                </div>

                                <?php
                                echo form_open('',array('id' => 'login-form'));

                                $datos = array(
                                        'name'        => 'username',
                                        'id'          => 'username',
                                        'class'       => 'form-control',
                                        'placeholder'   => 'Ingresa tu email o usuario',
                                );
                                echo '<div class="form-group mb-3">';
                                echo form_label('Password', 'password');
                                echo form_input($datos);
                                echo '</div>';

                                $pass = array(
                                        'type'        => 'password',
                                        'name'        => 'password',
                                        'id'          => 'password',
                                        'class'       => 'form-control',
                                        'placeholder'   => 'Ingrese tu contraseña',
                                );
                                echo '<div class="form-group mb-3">';
                                echo form_label('Password', 'password');
                                echo form_input($pass);
                                echo '</div>';

                                $extra = array(
                                        'class'=>'btn btn-dark btn-block',
                                        'type'        => 'button',
                                        'name'        => 'btn_login',
                                        'id'          => 'btn_login',
                                        'value'       => 'Iniciar Sesión'
                                );
                                echo '<div class="form-group mb-3">';
                                echo form_input($extra);

                                echo '</div>';

                                echo form_close();
                                ?>
                             </div> <!-- end card-body -->
                        </div>
                        <!-- end card -->

                    </div> <!-- end col -->
                </div>
                <!-- end row -->
            </div>
            <!-- end container -->
        </div>
        <!-- end page -->


        <footer class="footer footer-alt">
            <?=date("Y")?> <a href="" class="text-white-50">Soluciones Ideales</a>
        </footer>

        <!-- Vendor js -->
        <script src="<?=base_url();?>assets/js/vendor.min.js"></script>

        <!-- App js -->
        <script src="<?=base_url();?>assets/js/app.min.js"></script>
        <script src="<?=base_url();?>assets/js/funciones/login.js"></script>

        <script src="<?=base_url()?>assets/libs/sweetalert2/sweetalert2.min.js"></script>

    </body>
</html>