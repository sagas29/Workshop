$(document).ready(function () {
    let token =   $("#get_csrf_hash").val();

    $("#form_add").on('click', function(e){
        let id_car = $("#id_car").val();
        if(id_car) save_data();
    });

    $("#scrollable-dropdown-menu #search_car").typeahead({
            highlight: true,
        },
        {
            limit:100,
            name: 'car',
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
                    return '<div class="tt-suggestion tt-selectable">'+prod+'</div>';
                }
            }
        }).on('typeahead:selected',onAutocompleted);
    function onAutocompleted($e, datum) {
        let prod = datum.car.split("|");
        let id_car = prod[0];
        $("#id_car").val(id_car);
    }

    $("#search_btn").on('click', function(e){
        e.preventDefault();
        $("#search_form").parsley().validate();
        if ($("#search_form").parsley().isValid()){
            save_data();
        }
    });

});

function save_data(){
    let form = $("#search_form");
    let formdata = false;
    if (window.FormData) {
        formdata = new FormData(form[0]);
    }
    $.ajax({
        type: 'POST',
        url: base_url+'Busqueda/get_car',
        cache: false,
        data: formdata ? formdata : form.serialize(),
        contentType: false,
        processData: false,
        dataType: 'json',
        success: function (data) {
            if(data.found==false){
                notification(data.type,data.title,data.msg);
                $("#general").hide();
            }
            else{
                $("#car").html(data.car_name);
                $("#p_number").html(data.p_number);
                $("#client_name").html(data.client_name);
                $("#driver_name").html(data.driver_name);
                $('#btnR').attr('href', base_url+'Revisiones/historial/'+data.id_expedient);
                $('#btnK').attr('href', base_url+'Fichas/kilometraje/'+data.id_expedient);
                $("#general").show();
            }
        }
    });
}

function reload() {
    location.href = base_url+"Busqueda";
}

function reload_mileage() {
    location.href = base_url+"Fichas/kilometraje";
}
