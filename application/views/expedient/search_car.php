<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div class="content">
    <div class="container-fluid">
        <div class="row mt-3">
            <div class="col-12">
                <h2>Búsqueda de expediente</h2>
                <!--Car Information-->
                <div class="row mt-3">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-header bg-dark py-2 text-white">
                                <h5 class="card-title mb-0 text-white"> <i class="fe-search"></i> Vehículo</h5>
                            </div>
                            <form id="search_form" novalidate>
                            <div class="row p-2">
                                <div class="col-lg-9">
                                    <div class="form-group">
                                        <label for="search_car">Número de placa</label>
                                        <div id="scrollable-dropdown-menu">
                                            <input type="text" id="search_car" class="form-control" required parsley-trigger="change" data-parsley-error-message="El campo es requerido"
                                                   placeholder="Ingrese numero de placa" data-provide="typeahead">
                                            <input type="hidden" name="id_car" id="id_car" value="">
                                            <span class="help-block"><small>Realiza la búsqueda por número de placa.</small></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-2">
                                    <div class="form-group mt-3">
                                        <input type="hidden" id="get_csrf_hash" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
                                        <button type="button" id="search_btn" class="btn btn-blue btn-rounded waves-effect waves-light">
                                        <span class="btn-label"><i class="fe-search"></i></span>Buscar</button>
                                    </div>
                                </div>
                            </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!--Table-->
                <div class="row mt-1" id="general" style="display: none;">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-header bg-dark py-2 text-white">
                                <h5 class="card-title mb-0 text-white"> <i class="fe-archive"></i> Datos Generales</h5>
                            </div>
                            <table class="table table-bordered table-hover table-responsive-sm">
                                <tbody>
                                    <tr>
                                        <td class="w-25 text-dark">VEHICULO</td>
                                        <td class="w-25" id="car"></td>
                                        <td class="w-25 text-dark">PLACA</td>
                                        <td class="w-25" id="p_number"></td>
                                    </tr>
                                    <tr>
                                        <td class="w-25 text-dark">PROPIERTARIO</td>
                                        <td id="client_name"></td>
                                        <td class="w-25 text-dark">RESPONSABLE</td>
                                        <td id="driver_name"></td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">
                                            <a role="button" id="btnR" href="" target="_blank" class="btn btn-blue btn-rounded waves-effect waves-light"><i class="icon-wrench"></i> Revisiones</span></a>
                                        </td>
                                        <td colspan="2">
                                            <a role="button" id="btnK" href="" target="_blank" class="btn btn-blue btn-rounded waves-effect waves-light"><i class="mdi mdi-speedometer"></i> Kilometraje</span></a>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div><!-- end col -->
        </div><!--end row-->
    </div><!--end container fluid-->
</div><!--end content-->