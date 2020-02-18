<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div class="content">
    <div class="container-fluid">
        <div class="row mt-3">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="header-title">Agregar Ficha</h4>
                        <form id="form_add" novalidate class="mt-3">
                            <div class="row">
                                <div class="form-group col-lg-6">
                                    <label for="car_search">Vehiculo<span class="text-danger">*</span></label>
                                    <div id="scrollable-dropdown-menu">
                                        <input type="text" id="car_search" required name="car_search"  parsley-trigger="change" data-parsley-error-message="El campo es requerido" class=" form-control" placeholder="Ingrese nombre del cliente" data-provide="typeahead">
                                        <input type="hidden" name="id_car" id="id_car" value="">
                                        <span class="font-13 text-muted">Busca el vehículo por número de placa</span>
                                    </div>
                                </div>
                                <div class="form-group col-lg-6">
                                    <label for="owner_search">Propietario<span class="text-danger">*</span></label>
                                    <div id="scrollable-dropdown-menu">
                                        <input type="text" id="owner_search" required name="owner_search"  parsley-trigger="change" data-parsley-error-message="El campo es requerido" class=" form-control" placeholder="Ingrese nombre del Propiertario" data-provide="typeahead">
                                        <input type="hidden" name="id_owner" id="id_owner" value="">
                                        <span class="font-13 text-muted">Busca el nombre del propietario</span>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-lg-6">
                                    <label for="responsable_search">Responsable<span class="text-danger">*</span></label>
                                    <div id="scrollable-dropdown-menu">
                                        <input type="text" id="responsable_search" required name="responsable_search"  parsley-trigger="change" data-parsley-error-message="El campo es requerido" class=" form-control" placeholder="Ingrese nombre del Propiertario" data-provide="typeahead">
                                        <input type="hidden" name="id_responsable" id="id_responsable" value="">
                                        <span class="font-13 text-muted">Busca el nombre del responsable</span>
                                    </div>
                                </div>
                                <div class="form-group col-lg-6">
                                    <label for="frecuency">Frecuencia de Mantenimiento<span class="text-danger">*</span></label>
                                    <select name="frecuency" id="frecuency" class="form-control select2">
                                        <?php foreach ($frecuency as $row): ?>
                                            <option value="<?=$row->id_frecuency?>"><?=$row->frecuency?></option>
                                        <?php endforeach; ?>
                                    </select>
                                    <span class="font-13 text-muted">Selecciona una frecuencia</span>
                                </div>
                            </div>
                            <div class="form-group text-right m-b-0">
                                <button class="btn btn-primary waves-effect waves-light" type="submit">Guardar</button>
                                <button type="reset" class="btn btn-secondary waves-effect m-l-5">Cancelar</button>
                                <input type="hidden" id="get_csrf_hash" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
                            </div>
                        </form>
                    </div> <!-- end card-body -->
                </div> <!-- end card -->
            </div><!-- end col -->
        </div><!--end row-->
    </div><!--end container fluid-->
</div><!--end content-->
