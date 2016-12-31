$(document).ready(function() {
    /*$("#twlogin").click(function() {
        loginTw();
    });*/

    $("#accede_user").click(function() {
        login();
    });

    $("#signin_email").keyup(function() {
        if ($(this).val().length !== 0) {
            $(".error").fadeOut();
            return false;
        }
    });
    $("#signin_password").keyup(function() {
        if ($(this).val().length !== 0) {
            $(".error").fadeOut();
            return false;
        }
    });

});

function login() {
    var user_email = $("#signin_email").val();
    var user_pass = $("#signin_password").val();
    var value = false;

    //Validar Campos

    $(".error").remove();
    if (!user_email) {
        $("#signin_email").focus().after("<span class='error'>Email vacío</span>");
        value = false;
    } else {
        if (!user_pass) {
            $("#signin_password").focus().after("<span class='error'>Contraseña vacía</span>");
            value = false;
        } else
            value = true;
    }

    var data = {
        "email": user_email,
        "pass": user_pass
    };

    var login_JSON = JSON.stringify(data);

    if (value) {
        $.post(amigable("?module=users&function=login"), {
                login_json: login_JSON
            },
            function(response) {
                console.log(response);
                if (!response.error) {
                    //create session cookies
                    Tools.createCookie("user", response.email + "|" + response.user + "|" + response.avatar + "|" + response.tipo + "|" + response.name, 1);
                    //alert(response.name);
                    window.location.href  = amigable('?module=main&function=begin', true);
                } else {
                    if (response.datos == 503)
                      window.location.href = amigable("?module=main&fn=begin&param=503");
                    else
                    if(response.error.includes("email")){
                      $("#signin_email").focus().after("<span class='error'>" + response.error + "</span>");
                    }
                    else{
                      $("#signin_password").focus().after("<span class='error'>" + response.error + "</span>");
                    }
                }
            }, "json").fail(function(xhr, textStatus, errorThrown) {
            console.log(xhr.responseText);
            if (xhr.status === 0) {
                alert('Not connect: Verify Network.');
            } else if (xhr.status === 404) {
                alert('Requested page not found [404]');
            } else if (xhr.status === 500) {
                alert('Internal Server Error [500].');
            } else if (textStatus === 'parsererror') {
                alert('Requested JSON parse failed.');
            } else if (textStatus === 'timeout') {
                alert('Time out error.');
            } else if (textStatus === 'abort') {
                alert('Ajax request aborted.');
            } else {
                alert('Uncaught Error: ' + xhr.responseText);
            }
        });
    }
}
