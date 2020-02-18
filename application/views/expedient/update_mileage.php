<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div class="modal-header">
    <h4 class="modal-title" id="myModalLabel">Actualizar Kilometraje</h4>
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
</div>
<div class="modal-body">
    <form id='form_mileage' novalidate>
        <div class="row">
            <div class="form-group col-lg-12">
                <label for="mileage">Kilometraje</label>
                <input type="number" name="mileage" id="mileage" required="" placeholder="Ingrese el kilometraje actual" class="form-control" value="<?=$row?>"
                       parsley-trigger="change" data-parsley-error-message="El campo es requerido">
            </div>
            <div class="form-group col-lg-12">
                <label for="mileage">Responsable/Mecánico</label>
                <select name="responsable" id="responsable" class="form-control select2" required="" parsley-trigger="change" data-parsley-error-message="El campo es requerido" style="width:100%;">
                    <option value="">Selecciona un responsable</option>
                    <?php foreach ($users as $row): ?>
                        <option value="<?=$row->id_user?>"><?=$row->name?></option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>
        <div class="form-group text-right m-b-0">
            <button class="btn btn-primary waves-effect waves-light" type="button" id="edit_mileage">Guardar</button>
            <button type="button" class="btn btn-light waves-effect" data-dismiss="modal">Cerrar</button>
            <input type="hidden" id="id_expedient" name="id_expedient" value="<?=$id_expedient;?>">
            <input type="hidden" id="get_csrf_hash" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
        </div>
    </form>
</div>
<script>
    $("#edit_mileage").on('click', function(e){
        e.preventDefault();
        $('#form_mileage').parsley().validate();
        if ($('#form_mileage').parsley().isValid()){
            edit_mileage();
        }
    });

</script>
