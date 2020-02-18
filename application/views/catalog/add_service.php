<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div class="content">
    <div class="container-fluid">
        <div class="row mt-3">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="header-title">Agregar Servicio</h4>
                        <?php echo form_open('', array('id' => 'form_add', 'novalidate' => '')); ?>
                        <!-- <form id="form_add" novalidate>-->
                        <div class="row">
                            <div class="form-group col-lg-6">
                                <label for="name">Nombre<span class="text-danger">*</span></label>
                                <input type="text" name="name" id="name" required="" placeholder="Ingrese el nombre del servicio" class="form-control"
                                       parsley-trigger="change" data-parsley-error-message="El campo es requerido">
                            </div>
                            <div class="form-group col-lg-6">
                                <label for="description">Descripción<span class="text-danger">*</span></label>
                                <input type="text" name="description" required="" placeholder="Ingrese la descripcion del servicio" class="form-control" id="year"
                                       parsley-trigger="change" data-parsley-error-message="El campo es requerido">
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-lg-6">
                                <label for="category">Categoría<span class="text-danger">*</span></label>
                                <select name="category" id="category" class="form-control select2" required="" parsley-trigger="change" data-parsley-error-message="El campo es requerido">
                                    <option value="">Selecciona una Categoría</option>
                                    <?php foreach ($category as $row): ?>
                                        <option value="<?=$row->id_category?>"><?=$row->name?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="form-group col-lg-6">
                                <label for="price">Precio <span class="text-danger">*</span></label>
                                <input type="text" name="price" required="" placeholder="Ingrese el precio del servicio" class="form-control"
                                       parsley-trigger="change" data-parsley-error-message="El campo es requerido">
                            </div>
                        </div>
                        <div class="form-group text-right m-b-0">
                            <button class="btn btn-primary waves-effect waves-light" type="submit">Guardar</button>
                            <button type="reset" class="btn btn-secondary waves-effect m-l-5">Cancelar</button>
                            <input type="hidden" id="get_csrf_hash" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
                        </div>
                        <?php echo form_close(); ?>
                        <!--</form>-->
                    </div> <!-- end card-body -->
                </div> <!-- end card -->
            </div><!-- end col -->
        </div><!--end row-->
    </div><!--end container fluid-->
</div><!--end content-->
