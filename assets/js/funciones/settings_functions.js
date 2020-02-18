let envi = base_url+"Settings";
$(document).ready(function () {
    let token =   $("#get_csrf_hash").val();
    $("#form").on('submit', function(e){
        e.preventDefault();
        $(this).parsley().validate();
        if ($(this).parsley().isValid()){
            save_data();
        }
    });
    $("#departamento").change(function()
    {
        $("#municipio *").remove();
        $("#select2-municipio-container").text("");
        var ajaxdata = {
            "id_departamento": $("#departamento").val(),
            "csrf_token_name": $("#get_csrf_hash").val(),
        };
        $.ajax({
            url:envi+'/get_municipios',
            type: "POST",
            data: ajaxdata,
            success: function(opciones)
            {
                $("#select2-municipio-container").text("Selecciona un municipio");
                $("#municipio").html(opciones);
                $("#municipio").val("");
            }
        })
    });

    $(".dropify").dropify({
        messages: {
            default: "Drag and drop a file here or click",
            replace: "Drag and drop or click to replace",
            remove: "Remove",
            error: "Ooops, something wrong appended."
        },
        error: {
            fileSize: "The file size is too big (1M max)."
        }
    });
});
function save_data(){
    let form = $("#form");
    let formdata = false;
    if (window.FormData) {
        formdata = new FormData(form[0]);
    }
    $.ajax({
        type: 'POST',
        url: envi+'/save_changes',
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
    location.href = envi;
}
