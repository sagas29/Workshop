$(document).ready(function () {
    let token =   $("#get_csrf_hash").val();
    $('#editable').DataTable({
        "pageLength": 10,
        "serverSide": true,
        "order": [[0, "asc"]],
        "ajax": {
            url: base_url+'Fichas/get_data',
            type: 'POST',
            data: {"csrf_token_name": token},
        },
        "language": {
            "sProcessing": "Procesando...",
            "sLengthMenu": "Mostrar _MENU_ registros",
            "sZeroRecords": "No se encontraron resultados",
            "sEmptyTable": "Ningún dato disponible en esta tabla",
            "sInfo": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
            "sInfoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
            "sInfoFiltered": "(filtrado de un total de _MAX_ registros)",
            "sInfoPostFix": "",
            "sSearch": "Buscar:",
            "sUrl": "",
            "sInfoThousands": ",",
            "sLoadingRecords": "Cargando...",
            "oPaginate": {
                "sFirst": "Primero",
                "sLast": "Último",
                "sNext": "Siguiente",
                "sPrevious": "Anterior"
            },
            "oAria": {
                "sSortAscending": ": Activar para ordenar la columna de manera ascendente",
                "sSortDescending": ": Activar para ordenar la columna de manera descendente"
            }
        }
    }); // End of DataTable

    $("#form_add").on('submit', function(e){
        e.preventDefault();
        $(this).parsley().validate();
        if ($(this).parsley().isValid()){
            save_data();
        }
    });

    $("#form_edit").on('submit', function(e){
        e.preventDefault();
        $(this).parsley().validate();
        if ($(this).parsley().isValid()){
            edit_data();
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
                let url = base_url+'Fichas/get_car_autocomplete/'+ q;
                $.ajax({
                    data: {"csrf_token_name": token},
                    url: url
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

    $("#scrollable-dropdown-menu #owner_search").typeahead({
            highlight: true,
        },
        {
            limit:100,
            name: 'client',
            display: function(data) {
                prod=data.client.split("|");
                return prod[1];
            },
            source: function show(q, cb, cba) {
                let url = base_url+'Fichas/get_client_autocomplete/'+ q;
                $.ajax({
                    data: {"csrf_token_name": token},
                    url: url
                }).done(function(res){
                    if(res) cba(JSON.parse(res));
                });
            },
            templates:{
                suggestion:function (data) {
                    var prod=data.client.split("|");
                    return '<div class="tt-suggestion tt-selectable">'+prod[1]+'</div>';
                }
            }
        }).on('typeahead:selected',onAutocompleted_owner);
    function onAutocompleted_owner($e, datum) {
        let prod = datum.client.split("|");
        let id_owner = prod[0];
        $("#id_owner").val(id_owner);
    }

    $("#scrollable-dropdown-menu #responsable_search").typeahead({
            highlight: true,
        },
        {
            limit:100,
            name: 'client',
            display: function(data) {
                prod=data.client.split("|");
                return prod[1];
            },
            source: function show(q, cb, cba) {
                let url = base_url+'Fichas/get_client_autocomplete/'+ q;
                $.ajax({
                    data: {"csrf_token_name": token},
                    url: url
                }).done(function(res){
                    if(res) cba(JSON.parse(res));
                });
            },
            templates:{
                suggestion:function (data) {
                    var prod=data.client.split("|");
                    return '<div class="tt-suggestion tt-selectable">'+prod[1]+'</div>';
                }
            }
        }).on('typeahead:selected',onAutocompleted_client);
    function onAutocompleted_client($e, datum) {
        let prod = datum.client.split("|");
        let id_responsable = prod[0];
        $("#id_responsable").val(id_responsable);
    }


});

$(document).on("click", "#modal_update", function()
{
    let id_expedient = $(this).attr("data-id");
    $("#viewModal").modal("show");
    $("#viewModal .modal-content").load(base_url+"Fichas/load_modal_update/"+id_expedient);
});

$(document).on("click",".state_change", function(event)
{
    let id_product = $(this).attr("id");
    let data = $(this).attr("data-state");
    state_change(id_product,data);
});
$(document).on("click",".delete_row", function(event)
{
    let id_row = $(this).attr("id");
    delete_row(id_row);
});

function delete_row(id_row) {
    let token =   $("#get_csrf_hash").val()
    let dataString = "id=" + id_row + "&csrf_token_name="+token;
    Swal.fire({
        title: 'Alerta!!',
        text: "Estas seguro de eliminar esta ficha?!",
        type: 'error',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Aceptar',
        cancelButtonText: 'Cancelar',
    }).then((result) => {
        if (result.value) {
            $.ajax({
                type: "POST",
                url: base_url+"Fichas/delete_product",
                data: dataString,
                dataType: 'json',
                success: function (data) {
                    notification(data.type,data.title,data.msg);
                    if (data.type == "success") {
                        setTimeout("reload();", 1500);
                    }
                }
            });
        }
    });
}

function state_change(id_row, data) {
    let token =   $("#get_csrf_hash").val()
    let dataString = "id=" + id_row + "&csrf_token_name="+token;
    Swal.fire({
        title: 'Alerta!!',
        text: "Estas seguro de "+ data+" esta ficha?!",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Si,'+data,
        cancelButtonText: 'Cancelar',
    }).then((result) => {
        if (result.value) {
            $.ajax({
                type: "POST",
                url: base_url+"Fichas/state_change",
                data: dataString,
                dataType: 'json',
                success: function (data) {
                    notification(data.type,data.title,data.msg);
                    if (data.type == "success") {
                        setTimeout("reload();", 1500);
                    }
                }
            });
        }
    });
}

function save_data(){
    let form = $("#form_add");
    let formdata = false;
    if (window.FormData) {
        formdata = new FormData(form[0]);
    }
    $.ajax({
        type: 'POST',
        url: base_url+'Fichas/agregar',
        cache: false,
        data: formdata ? formdata : form.serialize(),
        contentType: false,
        processData: false,
        dataType: 'json',
        success: function (data) {
            notification(data.type,data.title,data.msg);
            if (data.type == "success") {
                setTimeout("reload();", 1500);
            }
        }
    });
}

function edit_data(){
    let form = $("#form_edit");
    let formdata = false;
    if (window.FormData) {
        formdata = new FormData(form[0]);
    }
    $.ajax({
        type: 'POST',
        url: base_url+'Fichas/editar',
        cache: false,
        data: formdata ? formdata : form.serialize(),
        contentType: false,
        processData: false,
        dataType: 'json',
        success: function (data) {
            notification(data.type,data.title,data.msg);
            if (data.type == "success") {
                setTimeout("reload();", 1500);
            }
        }
    });
}

function edit_mileage() {
    let form = $("#form_mileage");
    let formdata = false;
    if (window.FormData) {
        formdata = new FormData(form[0]);
    }
    $.ajax({
        type: 'POST',
        url: base_url+'Fichas/kilometraje',
        cache: false,
        data: formdata ? formdata : form.serialize(),
        contentType: false,
        processData: false,
        dataType: 'json',
        success: function (data) {
            notification(data.type,data.title,data.msg);
            if (data.type == "success") {
                setTimeout("reload_mileage();"+data.id_expedient, 1500);
            }
        }
    });
}

function reload() {
    location.href = base_url+"Fichas";
}

function reload_mileage() {
    location.href = base_url+"Fichas/kilometraje/";
}
