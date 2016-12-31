var databasePositions = [];

$(document).ready(start);
function start() {
  $.post(amigable("?module=camtourist&function=maploader"), {value: {send: true}},
    //$.post("/camtourist/maploader", {value: {send: true}},

    function (response) {
        //alert(response.success);
        if (response.success) {
                if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(mostrarUbicacion);
                databasePositions = response.camtourist;
                /*cargarMap(response.camtourist);
                cargarCamtourist(response.camtourist);*/
                cargarMap(databasePositions);
                cargarCamtourist(databasePositions);
            } else {
                alert("¡Error! Este navegador no soporta la Geolocalización.");
            }
        } else {
            if (response.error == 503)
                //window.location.href = amigable("?module=main&fn=begin&param=503");
                alert("¡Error! 503");
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

    //
}


function mostrarUbicacion(position) {
    var times = position.timestamp;
    var latitud = position.coords.latitude;
    var longitud = position.coords.longitude;

    var altitud = position.coords.altitude;
    var exactitud = position.coords.accuracy;

    //setCookie("lat", latitud, 14);
    //setCookie("lon", longitud, 14);

    Tools.createCookie("lat", latitud, 1);
    Tools.createCookie("lon", longitud, 1);
}

function refrescarUbicacion() {
    navigator.geolocation.watchPosition(mostrarUbicacion);
}

//informacion lateral de las CamTourist
function cargarCamtourist(of) {
    for (var i = 0; i < of.length; i++) {
        var content = '<div class="of" id="' + of[i].id + '"><div class="desc">' + of[i].punto_interes + '</div><div class="">Categoría: ' + of[i].categoria + '</div><div class="hora"> Horario: ' + of[i].hora_inicio + ' - ' + of[i].hora_final + '</div></div>';
        $('.camtourist').append(content);
    }
}

function marcar(map, camtourist) {

  //  var image = './localizacion_maps.png';
    var latlon = new google.maps.LatLng(camtourist.latitud, camtourist.longitud);
    var marker = new google.maps.Marker({position: latlon, map: map,
      title: camtourist.punto_interes,

      icon:'http://localhost/photoTourist_framework_v2_prettyurls/modules/camtourist/view/img/localizacion_maps.png' ,scaledSize: new google.maps.Size(64, 64),


      //icon:'https://phototourist.josando.tk/photoTourist_framework_v2_prettyurls/modules/camtourist/view/js/localizacion_maps.png' ,scaledSize: new google.maps.Size(64, 64),

    animation: google.maps.Animation.BOUNCE});
    setTimeout(function(){ marker.setAnimation(null); }, 10000);//controlamos tiempo BOUNCE marcador

    var infowindow = new google.maps.InfoWindow({
        content: '<div id="iw-container">'+
        '<div class="iw-title">'+ camtourist.punto_interes + '</div>'+
        '<div class="iw-content">'+
        '<img src="'+ camtourist.imagen+'" alt="'+ camtourist.punto_interes + '" >'+
        '<p class="informacion">' + camtourist.descripcion + '</p><p class="horas">Horario: ' + camtourist.hora_inicio + ' - ' + camtourist.hora_final + '</p></div>'+
        '<div class="iw-bottom-gradient"></div>'+
        '</div>',
        maxWidth: 350
    });

    google.maps.event.addListener(marker, 'click', function () {
        infowindow.open(map, marker);

        //acceder al dom del InfoWindow para mejorar su aspecto
        google.maps.event.addListener(infowindow, 'domready', function () {
            var iwOuter = $('.gm-style-iw');
            var iwCloser = iwOuter.next();
            var iwBackground = iwOuter.prev();

            iwBackground.children(':nth-child(2)').css({'display': 'none'});
            iwBackground.children(':nth-child(4)').css({'display': 'none'});
            iwBackground.children(':nth-child(1)').attr('style', function (i, s) {
                return s + 'left: 76px !important;'
            });
            iwBackground.children(':nth-child(3)').attr('style', function (i, s) {
                return s + 'left: 76px !important;'
            });
            iwBackground.children(':nth-child(3)').find('div').children().css({'box-shadow': 'rgba(72, 181, 233, 0.6) 0px 1px 6px', 'z-index': '1'});

            iwCloser.css({opacity: '1', right: '38px', top: '3px', border: '7px solid #48b5e9', 'border-radius': '13px', 'box-shadow': '0 0 5px #3990B9'});

            if($('.iw-content').height() < 140){
                  $('.iw-bottom-gradient').css({display: 'none'});
                }

            iwCloser.mouseout(function () {
                $(this).css({opacity: '1'});
            });
        });
    });
}

function cargarMap(arrArguments) {
    if (arrArguments === undefined || arrArguments == null)
      arrArguments = databasePositions;

    var x = document.getElementById("mapa");
    navigator.geolocation.getCurrentPosition(showPosition, showError);

    var posicion=ciudadCamTourist();//PRUEBA FUNCION, ese valor ira dentro de showPosition
    //alert ('posicion1 = ' + posicion);
    //ciudadCamTourist();

    function showPosition(position){

        //Cordenadas de Prueba que muestran Tarragona punto inicio
        //var lat = 41.119116;
        //var lon = 1.244483;

        //////////////////////////////////
        var lat = posicion[0];
        var lon = posicion[1];
        //alert ('posicion[0] = ' + posicion[0]);
        //alert ('posicion[1] = ' + posicion[1]);
        //////////////////////////////////////

        //Estas variables recogen nuestra posición actual
        //var lat = position.coords.latitude;
        //var lon = position.coords.longitude;
        var latlon = new google.maps.LatLng(lat, lon);

        var mapholder = document.getElementById("mapholder");
        //mapholder.style.height = '550px';
        //mapholder.style.width = '900px';
        var myOptions = {
            center: latlon, zoom: 10,
            mapTypeId: google.maps.MapTypeId.ROADMAP,
            mapTypeControl: false,
            navigationControlOptions: {style: google.maps.NavigationControlStyle.SMALL}
        };
        var map = new google.maps.Map(document.getElementById("mapholder"), myOptions);
        // var marker = new google.maps.Marker({position: latlon, map: map, title: "You are here!"});

        //En el styles hemos insertado el diseño especial
        map.setOptions({styles: [{"featureType":"administrative","elementType":"labels.text.fill","stylers":[{"color":"#444444"}]},{"featureType":"landscape","elementType":"all","stylers":[{"color":"#f2f2f2"}]},{"featureType":"poi","elementType":"all","stylers":[{"visibility":"off"}]},{"featureType":"road","elementType":"all","stylers":[{"saturation":-100},{"lightness":45}]},{"featureType":"road.highway","elementType":"all","stylers":[{"visibility":"simplified"}]},{"featureType":"road.arterial","elementType":"labels.icon","stylers":[{"visibility":"off"}]},{"featureType":"transit","elementType":"all","stylers":[{"visibility":"off"}]},{"featureType":"water","elementType":"all","stylers":[{"color":"#46bcec"},{"visibility":"on"}]}]});

        for (var i = 0; i < arrArguments.length; i++)
            marcar(map, arrArguments[i]);
    }

    function showError(error){
        switch (error.code){
            case error.PERMISSION_DENIED:
                x.innerHTML = "Denegada la peticion de Geolocalización en el navegador.";
                break;
            case error.POSITION_UNAVAILABLE:
                x.innerHTML = "La información de la localización no esta disponible.";
                break;
            case error.TIMEOUT:
                x.innerHTML = "El tiempo de petición ha expirado.";
                break;
            case error.UNKNOWN_ERROR:
                x.innerHTML = "Ha ocurrido un error desconocido.";
                break;
        }
    }
  }

  function ciudadCamTourist(){
    var ciudad=document.getElementById('camtourist_puntos').value;
    var posicion = [];
    //alert ('ciudad');
    switch(ciudad){
       case 'barcelona':
        posicion = ["41.381158", "2.176795"];
         break;

       case 'benidorm':
         posicion = ["38.544013", "-0.131881"];
         break;

       case 'cordoba':
         posicion = ["37.885205", "-4.776041"];
         break;

       case 'granada':
         posicion = ["37.174396", "-3.598528"];
         break;

       case 'madrid':
         posicion = ["40.418851", "-3.691991"];
         break;

       case 'ontinyent':
         posicion = ["38.821218", "-0.609599"];
         break;

       case 'sevilla':
         posicion = ["37.388655", "-5.994696"];
         break;

       case 'toledo':
         posicion = ["39.856709", "-4.024796"];
         break;

       default:
        posicion = ["39.856709", "-4.024796"];
        break;
     }
     //alert(posicion);
     return posicion;
   }
