$(document).ready(function() {
    $("#username").keyup(function (event) {
        if($(this).val()!="")
        {
            if(event.keyCode == 13)
            {
                $("#password").focus();
            }
        }
    });
    $("#password").keyup(function (event) {
        if($(this).val()!="")
        {
            if(event.keyCode == 13)
            {
                iniciar_sesion();
            }
        }
    });
});
$(function() {
    //binding event click for button in modal form
    $(document).on("click", "#btn_login", function(event) {
        iniciar_sesion();
    });
});

function iniciar_sesion()
{
    var username = $("#username").val();
    var password = $("#password").val();
    var token = $('input[name="csrf_token_name"]').val();
    $.ajax({
        type: 'POST',
        url: "Login/iniciar_sesion",
        data: "username="+username+"&password="+password+"&csrf_token_name="+token,
        dataType: 'JSON',
        success: function(datax) {
            if (datax.typeinfo=="success") {
                Swal.fire({
                    title: datax.title,
                    text: datax.msg,
                    type: datax.typeinfo,
                }).then((result) => {
                    setTimeout("location.href='Dashboard';",500);
                });
            }else{
                Swal.fire(datax.title, datax.msg, datax.typeinfo);
            }
        }
    });
}
