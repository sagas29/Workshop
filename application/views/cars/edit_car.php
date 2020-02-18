<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div class="content">
    <div class="container-fluid">
        <div class="row mt-3">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="header-title">Editar Vehículo</h4>
                        <?php echo form_open('', array('id' => 'form_edit', 'novalidate' => '')); ?>
                        <!-- <form id="form_add" novalidate>-->
                        <div class="row">
                            <div class="form-group col-lg-6">
                                <label for="p_number">Numero de Placa<span class="text-danger">*</span></label>
                                <input type="text" name="p_number" id="p_number" required="" placeholder="Ingrese el numero de placa" class="form-control" value="<?=$p_number?>"
                                       parsley-trigger="change" data-parsley-error-message="El campo es requerido">
                            </div>
                            <div class="form-group col-lg-6">
                                <label for="year">Año del Vehículo<span class="text-danger">*</span></label>
                                <input type="number" name="year" required="" placeholder="Ingrese el año del vehículo" class="form-control" id="year" value="<?=$year?>"
                                       parsley-trigger="change" data-parsley-error-message="El campo es requerido">
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-lg-6">
                                <label for="brand">Marca<span class="text-danger">*</span></label>
                                <select name="brand" id="brand" class="form-control select2" required="" parsley-trigger="change" data-parsley-error-message="El campo es requerido">
                                    <option value="">Selecciona una marca</option>
                                    <?php foreach ($brands as $row): ?>
                                        <option value="<?=$row->id_brand?>"
                                            <?php if ($row->id_brand == $id_brand): ?>
                                                <?= "selected" ?>
                                            <?php endif; ?>
                                        > <?= $row->name ?> </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="form-group col-lg-6">
                                <label for="model">Modelo <span class="text-danger">*</span></label>
                                <select name="model" id="model" class="form-control select2" required="" parsley-trigger="change" data-parsley-error-message="El campo es requerido">
                                    <option value="">Selecciona un modelo</option>
                                    <?php foreach ($model as $row): ?>
                                        <option value="<?=$row->id_model?>"
                                            <?php if ($row->id_model == $id_model): ?>
                                                <?= "selected" ?>
                                            <?php endif; ?>
                                        > <?= $row->name ?> </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group text-right m-b-0">
                            <button class="btn btn-primary waves-effect waves-light" type="submit">Guardar</button>
                            <button type="reset" class="btn btn-secondary waves-effect m-l-5">Cancelar</button>
                            <input type="hidden" value="<?=$id_car?>" name="id_car" id="id_car">
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
