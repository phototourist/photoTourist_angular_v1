<!-- <script type="text/javascript" src="https://maps.google.com/maps/api/js?sensor=true"></script>-->
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAYUTkG-to2bX5OaCYo9hRyHqPaZtOoXkw" async defer></script>
<script src="<?php echo CAMTOURIST_JS_PATH ?>geolocator.js"></script>

<section id="main" class="wrapper">

    <div class="container">
        <p class="lead">CamTourist, encuentra los puntos de interes :)</p>
        <!--<div id='ubicacion'></div>-->


        <div class="form-group">
            <label>Puntos CamTourist: </label></br>
            <select name="camtourist_puntos" id="camtourist_puntos" onchange="cargarMap()">
                <option value ="Select CamTourist" selected>Select CamTourist</option>
                <option value="barcelona">Barcelona</option>
                <option value="benidorm">Benidorm</option>
                <option value="cordoba">Cordoba</option>
                <option value="granada">Granada</option>
                <option value="madrid">Madrid</option>
                <option value="ontinyent">Ontinyent</option>
                <option value="sevilla">Sevilla</option>
                <option value="toledo">Toledo</option>
            </select>
            <div id="e_camtourist_puntos"></div>
        </div>

        <!-- Se escribe un mapa con la localizacion anterior-->
        <div id="mapa"></div>
        <div id="mapholder"></div>

        <div class="camtourist"></div><!--listado de camtourist-->
        <div id="map-canvas"/></div>
    </div>

</section>
