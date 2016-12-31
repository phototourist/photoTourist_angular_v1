<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.form/3.51/jquery.form.js"></script>
<!--<script type="text/javascript" src="modules/users/view/js/users.js" ></script>-->
<script type="text/javascript" src="<?php echo USERS_JS_PATH ?>facebook.js"></script>
<script type="text/javascript" src="<?php echo USERS_JS_PATH ?>signup.js"></script>

<section id="signup-page">
    <div class="container">
            <p class="lead">Forma parte de la Familia PhotoTourist ;)
            </p>
            <hr>
      </div>
        <!--Por Ahora esto no se usa-->
        <div class="status alert alert-success" style="display: none"></div>
        <div class="login_signup">
            <div class="social form-contact">
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
                <input type="text" id="signup_email" name="signup_email" placeholder="email" class="form-control" value="" required="required">
                <div id="e_singup_email"></div>
            </div>
            <br/>
            <div class="control-group">
                <label>Password *</label>
                <input type="password" id="signup_password" name="signup_password" placeholder="password" class="form-control" value="" required="required">
                <div id="e_singup_password"></div>
            </div>
            <br/>

            <div class="form-group">
                <button type="button" id="registrar_user" name="registrar_user" class="btn btn-primary btn-lg centrado" value="REGISTRARSE">REGISTRARSE</button>
            </div>
            <div class=""><hr></div>
        <!--/.row-->
    </div>
    <!--/.container-->
</section>
<!--/#contact-page-->
