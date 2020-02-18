<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div class="content">
    <div class="container-fluid">
        <div class="row mt-3">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="header-title">Editar Cliente</h4>
                        <form id="form_edit" novalidate>
                        <div class="row">
                            <div class="form-group col-lg-6">
                                <label for="nombre">Nombre<span class="text-danger">*</span></label>
                                <input type="text" name="name" id="name" required="" placeholder="Ingrese el nombre del cliente" class="form-control" value="<?=$data->name?>"
                                       parsley-trigger="change" data-parsley-error-message="El campo es requerido">
                            </div>
                            <div class="form-group col-lg-6">
                                <label for="address">Dirección<span class="text-danger">*</span></label>
                                <input type="text" name="address" id="address" required="" placeholder="Ingrese el año del vehículo" class="form-control" id="year" value="<?=$data->address?>"
                                       parsley-trigger="change" data-parsley-error-message="El campo es requerido">
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-lg-4">
                                <label for="cellphone">Teléfono<span class="text-danger">*</span></label>
                                <input type="text" name="cellphone" id="cellphone" required="" placeholder="0000-0000" class="form-control" data-toggle="input-mask" data-mask-format="0000-0000" maxlength="9" value="<?=$data->cellphone?>">
                                <span class="font-13 text-muted">ej. "xxxx-xxxx"</span>
                            </div>
                            <div class="form-group col-lg-4">
                                <label for="email">Correo Electrónico</label>
                                <input type="email" name="email"  placeholder="Ingrese el correo del cliente" class="form-control" id="email" value="<?=$data->email?>">
                            </div>
                            <div class="form-group col-lg-4">
                                <label for="dui">Dui</label>
                                <input type="text" name="dui" id="dui" class="form-control" data-toggle="input-mask" placeholder="00000000-0" data-mask-format="00000000-0" maxlength="10" value="<?=$data->dui?>">
                                <span class="font-13 text-muted">ej. "xxxxxxxx-x"</span>
                            </div>
                        </div>
                        <div class="form-group text-right m-b-0">
                            <button class="btn btn-primary waves-effect waves-light" type="submit">Guardar</button>
                            <button type="reset" class="btn btn-secondary waves-effect m-l-5">Cancelar</button>
                            <input type="hidden" value="<?=$id_client?>" name="id_client" id="id_client">
                            <input type="hidden" id="get_csrf_hash" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
                        </div>
                        </form>
                    </div> <!-- end card-body -->
                </div> <!-- end card -->
            </div><!-- end col -->
        </div><!--end row-->
    </div><!--end container fluid-->
</div><!--end content-->
