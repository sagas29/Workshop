<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div class="modal-header">
    <h4 class="modal-title" id="myModalLabel">Agregar Modelo</h4>
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
</div>
<div class="modal-body">
    <form id='form_add' novalidate>
        <div class="row">
            <div class="form-group col-lg-12">
                <label for="model_name">Nombre del Modelo <span class="text-danger">*</span></label>
                <input type="text" name="model_name" id="model_name" required="" placeholder="Ingrese el nombre del modelo" class="form-control"
                       parsley-trigger="change" data-parsley-error-message="El campo es requerido">
            </div>
        </div>
        <div class="row">
            <div class="form-group col-lg-12">
                <label for="brand">Marca <span class="text-danger">*</span></label><br>
                <select name="brand" id="brand" class="form-control select2" required="" parsley-trigger="change" data-parsley-error-message="El campo es requerido" style="width:100%;">
                    <option value="">Selecciona una marca</option>
                    <?php foreach ($brands as $row): ?>
                        <option value="<?=$row->id_brand?>"><?=$row->name?></option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>
        <div class="form-group text-right m-b-0">
            <button class="btn btn-primary waves-effect waves-light btn_add" type="button" id="btn_add">Guardar</button>
            <button type="button" class="btn btn-light waves-effect" data-dismiss="modal">Cerrar</button>
            <input type="hidden" id="get_csrf_hash" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
        </div>
    </form>
</div>
<script>
    $("#btn_add").on('click', function(e){
        e.preventDefault();
        $('#form_add').parsley().validate();
        if ($('#form_add').parsley().isValid()){
            save_data();
        }
    });
    $('.select2').select2({
        dropdownParent: $("#viewModal")
    });
</script>
