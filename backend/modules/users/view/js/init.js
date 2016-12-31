$(document).ready(function () {
    ////**user menu*///
    var user = Tools.readCookie("user");
    //alert(user);
    if (user) {
      $("head").append("<script src='http://localhost/photoTourist_framework_v2_prettyurls/modules/users/view/js/logout.js'></script>");
        user = user.split("|");
        $("#LogProf").html("<a href=" + amigable('?module=users&function=profile') + "><img id='menuImg' class='icon rounded' src='" + user[2] + "'/>" + user[3] + "</a>");
        $("#LogProf").after("<li><a id='logout' href='#' >Log Out</a></li>");
        if ( (user[3] === "worker") || (user[3] === "client")  ) {
            $("#LogProf").before("<li><a href=" + amigable('?module=productsfe&function=list_products') + ">Mis fotos</a></li>")
        } else if (user[3] === "admin") {
            $("#LogProf").before("<li><a href=" + amigable('?module=admin') + ">Administrar</a></li>")
        }
    }

    var url = window.location.href;
    url = url.split("/");
    //console.log(url[4]+ " " + url[5]+ " "+ url[6]+ " "+ url[7])
    if (url[5] === "activar" && url[6].substring(0, 3) == "Ver"){
        $("#alertbanner").html("<a href='#alertbanner' class='alertbanner'>Su email ha sido verificado, disfrute de PhotoTourist</div>");
    }else if(url[6]==="503"){
         $("#alertbanner").html("<a href='#alertbanner' class='alertbanner alertbannerErr'>Hay un problema en la base de datos, inténtelo más tarde</div>");
    }else if (url[5] === "begin") {
        if (url[6] === "reg"){
            $("#alertbanner").html("<a href='#alertbanner' class='alertbanner'>PhotoTourist ha enviado un email para verificar su cuenta</div>");
        }else if (url[6] === "rest"){
            $("#alertbanner").html("<a href='#alertbanner' class='alertbanner'>Se ha cambiado satisfactoriamente su contraseña</div>");
        }else if (url[6] === "fb"){
            $("#alertbanner").html("<a href='#alertbanner' class='alertbanner'>¡¡Bienvenido a PhotoTourist!! Nosotros también tenemos FACEBOOK</div>");
        }
    } else if (url[5] === "profile"){
        if (url[6] === "done")
            $("#alertbanner").html("<a href='#alertbanner' class='alertbanner'>Usuario correctamente actualizado</div>");
    }
});
