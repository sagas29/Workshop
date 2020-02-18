<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div class="modal-header">
    <h4 class="modal-title" id="myModalLabel">Editar Marca</h4>
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
</div>
<div class="modal-body">
    <form id='form_edit' novalidate>
        <div class="row">
            <div class="form-group col-lg-12">
                <label for="brand_name">Nombre</label>
                <input type="text" name="model_name" id="brand_name" required="" placeholder="Ingrese el nombre de la marca" class="form-control" value="<?=$data->name?>"
                       parsley-trigger="change" data-parsley-error-message="El campo es requerido">
            </div>
        </div>
        <div class="form-group text-right m-b-0">
            <button class="btn btn-primary waves-effect waves-light" type="button" id="btn_edit">Guardar</button>
            <button type="button" class="btn btn-light waves-effect" data-dismiss="modal">Cerrar</button>
            <input type="hidden" id="id_brand" name="id_brand" value="<?=$data->id_brand?>">
            <input type="hidden" id="get_csrf_hash" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
        </div>
    </form>
</div>
<!--<script src="<?/*= base_url(); */?>assets/js/funciones/brand_functions.js"></script>-->
<script>
    $('.select').select2({
        dropdownParent: $("#viewModal")
    });
    $("#btn_edit").on('click', function(e){
        e.preventDefault();
        $('#form_edit').parsley().validate();
        if ($('#form_edit').parsley().isValid()){
            edit_data();
        }
    });

</script>
