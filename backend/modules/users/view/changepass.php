<script src="<?php echo USERS_JS_PATH; ?>restore.js"></script>
<script src="<?php echo CONTACT_LIB_PATH; ?>bootstrap-button.js"></script>
<script src="<?php echo CONTACT_LIB_PATH; ?>jquery.validate.min.js"></script>
<script src="<?php echo CONTACT_LIB_PATH; ?>jquery.validate.extended.js"></script>
<link href="<?php echo CONTACT_CSS_PATH; ?>bootstrap.min.css" rel="stylesheet">
<link href="<?php echo CONTACT_CSS_PATH; ?>custom.css" rel="stylesheet">
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0-alpha/js/bootstrap.min.js"></script>
<script src="<?php echo USERS_JS_PATH; ?>changepass.js"></script>
<br>
<div class="container">
    <form id="changepass_form" name="changepass_form" class="form-contact">
        <br />
        <div class="form-title"><h2 class="form-contact-heading">Cambia tu contraseña</h2></div>
        <p>Por favor introduce tu nueva contraseña.</p>

        <div class="control-group">
            <input type="password" id="inputPassword" name="inputPassword" placeholder="Password" class="input-block-level" maxlength="100">
        </div>
        <div class="control-group">
            <input type="password" id="inputPassword2" name="inputPassword2" placeholder="Repite tu Password" class="input-block-level" maxlength="100">
        </div>

        <input class="btn btn-primary" type="button" name="submit" id="changeBtn" value="Enviar"/>

        <img src="<?php echo CONTACT_IMG_PATH; ?>ajax-loader.gif" alt="ajax loader icon" class="ajaxLoader" /><br/><br/>

        <div id="resultMessage" style="display: none;"></div>
    </form>
</div> <!-- /container -->
