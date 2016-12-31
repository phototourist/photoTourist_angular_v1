<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.form/3.51/jquery.form.js"></script>
<!--<script type="text/javascript" src="modules/users/view/js/users.js" ></script>-->
<script type="text/javascript" src="<?php echo USERS_JS_PATH ?>facebook.js"></script>
<script type="text/javascript" src="<?php echo USERS_JS_PATH ?>login.js"></script>

<section id="signin-page">
    <div class="container">
            <p class="lead">Entra a Tu Maleta de Recuerdos :)</p>
            <hr>
    </div>
        <!--Por Ahora esto no se usa-->
    <div class="status alert alert-success" style="display: none"></div>
    <div class="login_signup">
      <ul class="icons log">
        <div class="social form-contact">

          <a class="icon rounded fa-facebook" id="fb" href="#">
              <span class="label">Facebook</span>
          </a>

          <a class="icon rounded fa-twitter" id="twlogin" href="#">
              <span class="label">Twitter</span>
          </a>

          <a class="icon rounded fa-google-plus" id="google" href="#">
              <span class="label">Google</span>
          </a>

        </div>
        </ul>
        <br>
        <div class=""><hr></div>

        <div class="control-group">
            <label>Email *</label>
            <input type="text" id="signin_email" name="signin_email" placeholder="email" class="form-control" value="" required="required">
            <div id="e_singin_email"></div>
        </div>
        <br/>
        <div class="control-group">
            <label>Password *</label>
            <input type="password" id="signin_password" name="signin_password" placeholder="password" class="form-control" value="" required="required">
            <div id="e_singin_password"></div>
        </div>
        <br/>

        <div class="form-group">
            <button type="button" id="accede_user" name="accede_user" class="btn btn-primary btn-lg centrado" value="ENTRAR">ENTRAR</button>
        </div>
        <div class=""><hr></div>
        <div class="form-contact reg ">
            <p>No tengo cuenta
                <a href="<?php amigable('?module=users&function=signup'); ?>" id="">REGISTRARME!!</a>
            </p>
            <br/>
            <p>
                <a href="<?php amigable('?module=users&function=restore'); ?>" id="datosOlvidar">Olvide mis datos 😥</a>
            </p>
        </div>
      </div>
        <!--/.row-->
    </div>
    <!--/.container-->
</section>
<!--/#contact-page-->
