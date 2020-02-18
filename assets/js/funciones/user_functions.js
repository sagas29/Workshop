$(document).ready(function () {
    let token =   $("#get_csrf_hash").val();
    $('#editable').DataTable({
        "pageLength": 10,
        "serverSide": true,
        "order": [[0, "asc"]],
        "ajax": {
            url: base_url+'Usuarios/get_data',
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

    $('#checkbox3').click(function(){
        if('password' == $('#password').attr('type')){
            $('#password').prop('type', 'text');
        }else{
            $('#password').prop('type', 'password');
        }
    });

    $('#admin_chk').change(function () {
        //$(this).is(":checked") ? $('.checkboxes').prop("checked", true) :    $('.checkboxes').prop("checked", false);
    });

});

$(document).on("click","#btn_save",function (e) {
    e.preventDefault();
    let modules = [];
    $(':checkbox:checked').each(function(i){
        modules[i] = $(this).val();
    });
    let id_user = $("#id_user").val();
    let admin_val = 0;
    $('#admin_chk').is(":checked") ? admin_val=1 : admin_val=0;
    permissions_user(modules,id_user,admin_val);
});

function permissions_user(modules, id_user, admin){
    for (let i=0; i<modules.length; i++){
        if(modules[i] == 0 || modules[i] == "" ){
            modules.splice(i,1);
        }
    }
    let token =   $("#get_csrf_hash").val();
    let dataString = "csrf_token_name="+token+"&modules="+modules+"&admin="+admin+"&id_user="+id_user;
    Swal.fire({
        title: 'Alerta!',
        text: "¿Seguro de asignar estos permisos?",
        type: 'info',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Aceptar',
        cancelButtonText: 'Cancelar',
    }).then((result) => {
        if (result.value) {
            $.ajax({
                type: "POST",
                url: base_url + "Usuarios/permisos",
                data: dataString,
                dataType: 'json',
                success: function (data) {
                    notification(data.type, data.title, data.msg);
                    if (data.type == "success") {
                        setTimeout("reload();", 1500);
                    }
                }
            });
        }
    });
}

$(document).on("click",".state_user", function(event)
{
    let id_user = $(this).attr("id");
    let data = $(this).attr("data-state");
    state_user(id_user,data);
});

$(document).on("click",".delete_user", function(event)
{
    let id_user = $(this).attr("id");
    delete_user(id_user);
});

function delete_user(id_user) {
    let token =   $("#get_csrf_hash").val()
    let dataString = "id=" + id_user + "&csrf_token_name="+token;
    Swal.fire({
        title: 'Alerta!!',
        text: "Estas seguro de eliminar este usuario?!",
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
                url: base_url+"Usuarios/delete_user",
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

function state_user(id_user, data) {
    let token =   $("#get_csrf_hash").val()
    let dataString = "id=" + id_user + "&csrf_token_name="+token;
    Swal.fire({
        title: 'Alerta!!',
        text: "Estas seguro de "+ data+" este servicio?!",
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
                url: base_url+"Usuarios/state_user",
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
        url: base_url+'Usuarios/agregar',
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
        url: base_url+'Usuarios/editar',
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
    location.href = base_url+"Usuarios";
}
