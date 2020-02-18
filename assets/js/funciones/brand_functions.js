$(document).ready(function () {
    let token =   $("#get_csrf_hash").val();
    $('#editable').DataTable({
        "pageLength": 10,
        "serverSide": true,
        "order": [[0, "asc"]],
        "ajax": {
            url: 'Marcas/get_data',
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

    $("#brand").change(function()
    {
        $("#model *").remove();
        $("#select2-model-container").text("");
        var ajaxdata = {
            "id_brand": $("#brand").val(),
            "csrf_token_name": $("#get_csrf_hash").val(),
        };
        $.ajax({
            url:"get_models",
            type: "POST",
            data: ajaxdata,
            success: function(opciones)
            {
                $("#select2-model-container").text("Selecciona un modelo");
                $("#model").html(opciones);
                $("#model").val("");
            }
        })
    });

});


$(document).on('hidden.bs.modal', function (e) {
    var target = $(e.target);
    target.removeData('bs.modal').find(".modal-content").html('');
});
$(document).on("click", "#modal_btn_add", function()
{
    $("#viewModal").modal("show");
    $("#viewModal .modal-content").load(base_url+"Marcas/agregar");
});
$(document).on("click", "#modal_btn_edit", function()
{
    let id_brand = $(this).attr("data-id");
    $("#viewModal").modal("show");
    $("#viewModal .modal-content").load(base_url+'Marcas/editar/'+id_brand);
});

$(document).on("click",".state_brand", function(event)
{
    let id_brand = $(this).attr("id");
    let data = $(this).attr("data-state");
    state_client(id_brand,data);
});

function state_client(id_brand, data) {
    let token =   $("#get_csrf_hash").val()
    let dataString = "id=" + id_brand + "&csrf_token_name="+token;
    Swal.fire({
        title: 'Alerta!!',
        text: "Estas seguro de "+ data+" esta marca?!",
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
                url: base_url+"Marcas/state_car",
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

/*
$(document).on("click",".deleted", function(event)
{
    let id_car = $(this).attr("id");
    deleted(id_car);
});

function deleted(id_car) {
    let token =   $("#get_csrf_hash").val()
    let dataString = "id=" + id_car + "&csrf_token_name="+token;
    Swal.fire({
        title: 'Alerta!!',
        text: "Estas seguro de eliminar este vehículo?!",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Si, eliminar!'
    }).then((result) => {
        if (result.value) {
            $.ajax({
                type: "POST",
                url: "Vehiculos/eliminar",
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
*/
function save_data(){
    let form = $("#form_add");
    let formdata = false;
    if (window.FormData) {
        formdata = new FormData(form[0]);
    }
    $.ajax({
        type: 'POST',
        url: base_url+'Marcas/agregar',
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
        url: base_url+'Marcas/editar',
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



function reload() {
    location.href = base_url+"Marcas";
}
