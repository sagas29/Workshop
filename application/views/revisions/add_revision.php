<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div class="modal-header">
    <h4 class="modal-title" id="myModalLabel">Nueva Revisi&oacute;n</h4>
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
</div>
<div class="modal-body">
    <form id='form_add' novalidate>
        <div class="row">
            <div class="form-group col-lg-12">
                <label for="car_search">Vehiculo</label>
                <div id="scrollable-dropdown-menu">
                    <input type="text" name="car_search" id="car_search" required="" placeholder="Ingrese el numero de placa" class="form-control"
                           parsley-trigger="change" data-parsley-error-message="El campo es requerido">
                    <input type="hidden" name="id_car" id="id_car" value="">
                    <span class="font-13 text-muted">Busca el vehículo por número de placa</span>
                </div>
            </div>
        </div>
        <div class="row" id="car_detail" style="display: block;">
            <div class="col-lg-12">
                <div class="table-responsive">
                    <table class="table table-bordered mb-0 table-sm">
                        <tbody>
                        <tr>
                            <th scope="row" width="30%">VEHICULO</th>
                            <td id="car_name" width="70%">dasdsd</td>
                        </tr>
                        <tr>
                            <th scope="row">PLACA</th>
                            <td id="p_number">dasdas</td>
                        </tr>
                        <tr>
                            <th scope="row">PROPIERTARIO</th>
                            <td id="client_name">dasd</td>
                        </tr>
                        <tr>
                            <th scope="row">RESPONSABLE</th>
                            <td id="driver_name">asdsd</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="form-group text-right m-b-0 mt-1">
            <button class="btn btn-blue" id="btn_next" type="button" style="display: inline">Siguiente</button>
            <button type="button" class="btn btn-light waves-effect" data-dismiss="modal">Cerrar</button>
            <input type="hidden" id="get_csrf_hash" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
        </div>
    </form>
</div>
<script>
    let token = $("#get_csrf_hash").val();
    $("#btn_add").on('click', function(e){
        e.preventDefault();
        $('#form_add').parsley().validate();
        if ($('#form_add').parsley().isValid()){
            save_data();
        }
    });
    $("#scrollable-dropdown-menu #car_search").typeahead({
            highlight: true,
        },
        {
            limit:100,
            name: 'cars',
            display: function(data) {
                prod=data.car.split("|");
                return prod[1];
            },
            source: function show(q, cb, cba) {
                let url = base_url+'Revisiones/get_car_autocomplete/'+q;
                $.ajax({
                    data: {"csrf_token_name": token},
                    url: url,
                }).done(function(res){
                    if(res) cba(JSON.parse(res));
                });
            },
            templates:{
                suggestion:function (data) {
                    var prod=data.car.split("|");
                    return '<div class="tt-suggestion tt-selectable">'+prod[1]+'</div>';
                }
            }
        }).on('typeahead:selected',onAutocompleted_car);
    function onAutocompleted_car($e, datum) {
        let prod = datum.car.split("|");
        let id_car = prod[0];
        $("#id_car").val(id_car);
    }

</script>
