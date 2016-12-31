$(document).ready(function () {
    $("#fb").click(function () {
        LoginFB();
    });
});

window.fbAsyncInit = function () {
    FB.init({
        appId: '898487790287946', // App ID
        channelUrl: '//connect.facebook.net/en_US/all.js', // Channel File
        status: true, // check login status
        cookie: true, // enable cookies to allow the server to access the session
        xfbml: true  // parse XFBML
    });

    FB.Event.subscribe('auth.authResponseChange', function (response) {
        if (response.status === 'connected') {
            //document.getElementById("message").innerHTML += "<br>Connected to Facebook";
            //SUCCESS
            //alert('SUCCESS');
        } else if (response.status === 'not_authorized') {
            //FB.login();
            //FAILED
            alert('FAILED');
        } else {
            //FB.login();
            //UNKNOWN ERROR
            alert('UNKNOWN ERROR');
        }
    });
};

function LoginFB() {
    FB.login(function (response) {
        if (response.authResponse) {
            getUserInfo();
        } else {
            console.log('Error Facebook no tiene tus datos');
            alert('Error Facebook no tiene tus datos');
        }
    }, {scope: 'email,user_photos,user_videos,user_birthday'});//indica el alcance, en términos de datos, a los cuales la app tendrá acceso.
}

function getUserInfo() {
    FB.api('/me', function (response) {
        FB.api('/me', {fields: 'id, first_name, last_name, email'},//estos son los campos que devuelve Facebook
        function (response) {
          //hacer un console log para ver que da Facebook
            var data = {"token": response.id, "name": response.first_name, "last_name": response.last_name, "email": response.email};//guardamos en Token id FB
            var datos_social = JSON.stringify(data);

            $.post(amigable('?module=users&function=social_signin'), {user: datos_social},
            function (response) {
                if (!response.error) {
                    Tools.createCookie("user", response.email + "|" + response.user + "|" + response.avatar + "|" + response.tipo + "|" + response.name, 1);
                    //alert(response.name);
                    //window.location.href = amigable("?module=main");
                    window.location.href  = amigable('?module=main&function=begin&param=fb', true);//
                } else {
                    if (response.datos == 503)
                        window.location.href = amigable("?module=main&fn=begin&param=503");
                }
            }, "json").fail(function (xhr, textStatus, errorThrown) {
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
        );
    });
}

function Logout() {
    FB.logout(function () {
        document.location.reload();
        Tools.eraseCookie("user");
        window.location.href = amigable("?module=main");
    });
}

// Load the SDK asynchronously
(function (d) {
    var js, id = 'facebook-jssdk', ref = d.getElementsByTagName('script')[0];
    if (d.getElementById(id)) {
        return;
    }
    js = d.createElement('script');
    js.id = id;
    js.async = true;
    js.src = "//connect.facebook.net/en_US/all.js";
    ref.parentNode.insertBefore(js, ref);
}(document));
