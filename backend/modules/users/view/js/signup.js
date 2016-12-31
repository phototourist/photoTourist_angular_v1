$(document).ready(function () {

    $('#registrar_user').click(function () {
        validate_signup_user();
    });
    $("#signup_email, #signup_password").keyup(function () {
        if ($(this).val() !== "") {
            $(".error").fadeOut();
            return false;
        }
    });

    $("#signup_email").keyup(function () {
        var emailreg = /^[a-zA-Z0-9_\.\-]+@[a-zA-Z0-9\-]+\.[a-zA-Z0-9\-\.]+$/;
        if ($(this).val() !== "" && emailreg.test($(this).val())) {
            $(".error").fadeOut();
            return false;
        }
    });
    $("#signup_password").keyup(function () {
        if ($(this).val().length >= 6) {//Simplemente verificamos que sea mayor de 6 carácteres
            $(".error").fadeOut();
            return false;
        }
    });
}); //FIN Document Ready

function validate_signup_user() {
    var result = true;
    var emailreg = /^[a-zA-Z0-9_\.\-]+@[a-zA-Z0-9\-]+\.[a-zA-Z0-9\-\.]+$/;

    var email = $("#signup_email").val();
    var pass = $("#signup_password").val();

    $(".error").remove();
    if ($("#signup_email").val() === "" || !emailreg.test($("#signup_email").val())) {
        $("#signup_email").focus().after("<span class='error'>Email no válido o vacío</span>");
        result = false;
    } else if ($("#signup_password").val() === "") {
        $("#signup_password").focus().after("<span class='error'>Ingrese su contraseña</span>");
        result = false;
    } else if ($("#signup_password").val().length < 6) {
        $("#signup_password").focus().after("<span class='error'>Mínimo 6 carácteres para la contraseña</span>");
        result = false;
    }

    if (result) {
      //No sé si crear tipo por defecto? , "tipo": "client"
        var data = {"email": email, "pass": pass};
        var data_users_JSON = JSON.stringify(data);
        $.post(amigable("?module=users&function=signup_user"),{signup_user_json: data_users_JSON},
        //$.post("../../users/signup_user/",
        function (response) {
            console.log(response);
            if (response.success) {
              //alert("registro efectuado");
                window.location.href = response.redirect;
                //console.log(response.redirect);
            } else {
                if (response.typeErr === "Email") {
                    $("#signup_email").focus().after("<span class='error'>" + response.error + "</span>");
                } else {
                    if (response["datos"]["error"]["email"] !== undefined && response["datos"]["error"]["email"] !== null) {
                        $("#signup_email").focus().after("<span class='error'>" + response["datos"]["error"]["email"] + "</span>");
                    }
                    if (response["datos"]["error"]["pass"] !== undefined && response["datos"]["error"]["pass"] !== null) {
                        $("#signup_password").focus().after("<span class='error'>" + response["datos"]["error"]["pass"] + "</span>");
                    }
                }
            }
        }, "json").fail(function (xhr, textStatus, errorThrown) {
            //console.log(xhr);
            //console.log(xhr.responseJSON);
            //console.log(xhr.responseText);
            if( (xhr.responseJSON === undefined) || (xhr.responseJSON === null) )
                xhr.responseJSON = JSON.parse(xhr.responseText);
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
