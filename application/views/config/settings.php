<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div class="content">

    <!-- Start Content-->
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box">
                    <h4 class="page-title"><i class="<?=$page_icon?>"></i> <?=$page_title?></h4>
                </div>
                <div class="card">
                    <div class="card-box">
                        <h4 class="header-title m-t-0">Ajustes del sistema</h4>
                        <p class="text-muted font-14 m-b-20">
                            Los campos marcados con <span class="text-danger">*</span> son requeridos.
                        </p>
                        <?php echo form_open('', array('id' => 'form', 'novalidate' => '')); ?>
                        <div class="row">
                            <div class="form-group col-lg-6">
                                <label for="company">Nombre de la empresa<span class="text-danger">*</span></label>
                                <input type="text" name="company" id="company" required="" placeholder="Ingrese el nombre de la compania" class="form-control" value="<?=$row->name?>"
                                       parsley-trigger="change" data-parsley-error-message="El campo es requerido">
                            </div>
                            <div class="form-group col-lg-6">
                                <label for="address">Dirección<span class="text-danger">*</span></label>
                                <input type="text" name="address" id="address" required="" placeholder="Ingrese la direccion de la empresa" class="form-control" value="<?=$row->address;?>"
                                       parsley-trigger="change" data-parsley-error-message="El campo es requerido">
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-lg-6">
                                <label for="brand">Departamento<span class="text-danger">*</span></label>
                                <select name="departamento" id="departamento" class="form-control select2" required="" parsley-trigger="change" data-parsley-error-message="El campo es requerido">
                                    <option value="<?=$row->id_departamento?>"><?=$row->nombre_departamento?></option>
                                    <?php foreach ($departamento as $dep): ?>
                                        <option value="<?=$dep->id_departamento?>"><?=$dep->nombre_departamento?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="form-group col-lg-6">
                                <label for="municipio">Municipio <span class="text-danger">*</span></label>
                                <select name="municipio" id="municipio" class="form-control select2" required="" parsley-trigger="change" data-parsley-error-message="El campo es requerido">
                                    <option value="<?=$row->id_municipio?>"><?=$row->nombre_municipio?></option>
                                    <?php foreach ($municipio as $mun): ?>
                                        <option value="<?=$mun->id_municipio?>"><?=$mun->nombre_municipio?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-lg-4">
                                <label for="cellphone">Teléfono </label>
                                <input type="text" name="cellphone" id="cellphone" class="form-control" data-toggle="input-mask" data-mask-format="0000-0000" maxlength="9" value="<?php echo $row->cellphone;?>">
                                <span class="font-13 text-muted">ej. "xxxx-xxxx"</span>
                            </div>
                            <div class="form-group col-lg-4">
                                <label for="p_number">Email</label>
                                <input type="email" name="email" id="email" placeholder="Ingrese el correo electrónico" class="form-control" value="<?= $row->email;?>">
                            </div>
                            <div class="form-group col-lg-4">
                                <label for="p_number">Pagina web</label>
                                <input type="text" name="webpage" id="webpage" placeholder="Ingrese la pagina web" class="form-control" value="<?=$row->webpage;?>">
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-lg-6">
                                <label for="cellphone">NIT </label>
                                <input type="text" name="nit" id="nit" class="form-control" data-toggle="input-mask" data-mask-format="0000-000000-000-0" maxlength="17" value="<?=$row->nit;?>">
                                <span class="font-13 text-muted">ej. "xxxx-xxxxxx-xxx-x"</span>
                            </div>
                            <div class="form-group col-lg-6">
                                <label for="p_number">NRC</label>
                                <input type="text" name="nrc" id="nrc" class="form-control" data-toggle="input-mask" data-mask-format="000000-0" maxlength="8" value="<?=$row->nrc;?>">
                                <span class="font-13 text-muted">ej. "xxxxxx-x"</span>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="mt-3">
                                    <label for="p_number">Logo de la empresa</label>
                                    <input type="file" name="fileinput" class="dropify" data-default-file="<?=$row->logo;?>"  />
                                    <p class="text-muted text-center mt-2 mb-0">Logo actual</p>
                                </div>
                            </div>
                        </div>
                        <!-- end row -->
                        <div class="form-group text-right m-b-0">
                            <button class="btn btn-primary waves-effect waves-light" type="submit">Guardar</button>
                            <button type="reset" class="btn btn-secondary waves-effect m-l-5">Cancelar</button>
                        </div>
                        <?php echo form_close(); ?>
                    </div>
                </div>
            </div>
        </div>
        <!-- end page title -->
    </div> <!-- container -->
</div> <!-- content -->
<input type="hidden" id="get_csrf_hash" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
