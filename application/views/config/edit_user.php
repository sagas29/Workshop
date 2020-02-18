<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div class="content">
    <div class="container-fluid">
        <div class="row mt-3">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="header-title">Agregar Usuario</h4>
                        <?php echo form_open('', array('id' => 'form_edit', 'novalidate' => '')); ?>
                        <!-- <form id="form_add" novalidate>-->
                        <div class="row">
                            <div class="form-group col-lg-6">
                                <label for="fname">Nombre<span class="text-danger">*</span></label>
                                <input type="text" name="fname" id="fname" required="" placeholder="Ingrese el nombre" class="form-control" value="<?=$first_name;?>"
                                       parsley-trigger="change" data-parsley-error-message="El campo es requerido">
                            </div>
                            <div class="form-group col-lg-6">
                                <label for="lname">Apellido<span class="text-danger">*</span></label>
                                <input type="text" name="lname" id="lname" required="" placeholder="Ingrese la apellid" class="form-control" id="lname" value="<?=$last_name;?>"
                                       parsley-trigger="change" data-parsley-error-message="El campo es requerido">
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-lg-6">
                                <label for="username">Usuario<span class="text-danger">*</span></label>
                                <input type="text" name="username" id="username" required="" placeholder="Ingrese la nombre del usuario" class="form-control" value="<?=$username;?>"
                                       parsley-trigger="change" data-parsley-error-message="El campo es requerido" autocomplete="off">
                            </div>
                            <div class="form-group col-lg-6">
                                <label for="password">Contraseña <span class="text-danger">*</span></label>
                                <input type="password" name="password" id="password" required="" placeholder="Ingrese la contraseña" class="form-control" value="<?=$password;?>"
                                       parsley-trigger="change" data-parsley-error-message="El campo es requerido" autocomplete="off">
                                <div class="checkbox checkbox-primary mb-1 mt-1">
                                    <input id="checkbox3" type="checkbox">
                                    <label for="checkbox3">Mostrar Contraseña</label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="mt-3">
                                    <label for="p_number">Imagen de Usuario</label>
                                    <input type="file" name="fileinput" class="dropify" data-default-file="<?= base_url($picture);?>" />
                                    <p class="text-muted text-center mt-2 mb-0">Imagen de Perfil</p>
                                </div>
                            </div>
                        </div>
                        <div class="form-group text-right m-b-0">
                            <button class="btn btn-primary waves-effect waves-light" type="submit">Guardar</button>
                            <button type="reset" class="btn btn-secondary waves-effect m-l-5">Cancelar</button>
                            <input type="hidden" name="id_user" value="<?=$id_user;?>">
                        </div>
                        <?php echo form_close(); ?>
                        <!--</form>-->
                    </div> <!-- end card-body -->
                </div> <!-- end card -->
            </div><!-- end col -->
        </div><!--end row-->
    </div><!--end container fluid-->
</div><!--end content-->
