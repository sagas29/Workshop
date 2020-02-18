<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div class="modal-header">
    <h4 class="modal-title" id="myModalLabel">Agregar Categoria</h4>
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
</div>
<div class="modal-body">
    <form id='form_add' novalidate>
        <div class="row">
            <div class="form-group col-lg-12">
                <label for="name">Nombre</label>
                <input type="text" name="name" id="name" required="" placeholder="Ingrese el nombre de la categoria" class="form-control"
                       parsley-trigger="change" data-parsley-error-message="El campo es requerido">
            </div>
        </div>
        <div class="row">
            <div class="form-group col-lg-12">
                <label for="description">Descripción</label>
                <input type="text" name="description" id="description" required="" placeholder="Ingrese la descripcion de la categoria" class="form-control"
                       parsley-trigger="change" data-parsley-error-message="El campo es requerido">
            </div>
        </div>
        <div class="form-group text-right m-b-0">
            <button class="btn btn-primary waves-effect waves-light btn_add" type="button" id="btn_add">Guardar</button>
            <button type="button" class="btn btn-light waves-effect" data-dismiss="modal">Cerrar</button>
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
    $('.select').select2({
        dropdownParent: $("#viewModal")
    });
</script>
