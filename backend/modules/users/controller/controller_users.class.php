<?php
  class controller_users
  {
      public function __construct()
      {
          include FUNCTIONS_USERS.'functions_users.inc.php';
          include LIBS.'password_compat-master/lib/password.php';
          include UTILS.'upload.php';
          $_SESSION['module'] = 'users';
      }

//Funciones para signup
      public function signup()
      {
          require_once VIEW_PATH_INC.'header.php';
          require_once VIEW_PATH_INC.'menu.php';

          echo '<br><br>';
          loadView('modules/users/view/', 'signup.php');

          require_once VIEW_PATH_INC.'footer.html';
      }

      public function signup_user()
      {
          $jsondata = array();
          $userJSON = $_POST;

          $result = validate_user_signup_PHP($userJSON);

          if ($result['resultado']) {
              $avatar = get_gravatar($result['datos']['email'], $s = 400, $d = 'identicon', $r = 'g', $img = false, $atts = array());
              $arrArgument = array(
              'email' => $result['datos']['email'],
              'pass' => password_hash($result['datos']['pass'], PASSWORD_BCRYPT),
              'avatar' => $avatar,
              'tipo' => 'client',
              'activado' => 0,
              'token' => '',
            );


            /* Control de registro */
            set_error_handler('ErrorHandler');
              try {
                  //loadModel
              $arrValue = loadModel(MODEL_USERS, 'users_model', 'count', array('column' => array('email'), 'like' => array($arrArgument['email'])));

                  if ($arrValue[0]['total'] == 1) {
                      //Tenemos 1 User con email que buscamos
                      $typeErr = 'Email';
                        $error = "Email ya registrado";

                        $jsondata["success"] = false;
                        $jsondata['typeErr'] = $typeErr;
                        $jsondata["error"] = $error;
                        echo json_encode($jsondata);
                        exit;
                  }
              } catch (Exception $e) {
                  $arrValue = false;
              }

              restore_error_handler();
            /* Fin de control de registro */

            set_error_handler('ErrorHandler');
            try {
                $arrArgument['token'] = "Ver" . md5(uniqid(rand(), true));
                $arrValue = loadModel(MODEL_USERS, "users_model", "create_user", $arrArgument);
            } catch (Exception $e) {
                $arrValue = false;
            }
            restore_error_handler();

            if ($arrValue) {
                sendtoken($arrArgument, "alta");
                $jsondata["success"] = true;
                echo json_encode($jsondata);
                exit;
            } else {
                $jsondata["success"] = false;
                $jsondata['typeErr'] = "error_server";
                echo json_encode($jsondata);
                exit;
            }
            ///////////////////////////////////////////////////////////////////
        } else {
            $jsondata["success"] = false;
            $jsondata['typeErr'] = "error";
            $jsondata["error"] = $result;
            echo json_encode($jsondata);
            exit;
        }
      }

      public function verify()
      {

          //MADREEEEEEEEE
          if (substr($_GET['param'], 0, 3) == 'Ver') {
              $arrArgument = array(
                'column' => array('token'),
                'like' => array($_GET['param']),
                'field' => array('activado'),
                'new' => array('1'),
            );

              set_error_handler('ErrorHandler');
              try {
                  $value = loadModel(MODEL_USERS, 'users_model', 'update_user', $arrArgument);
              } catch (Exception $e) {
                  $value = false;
              }
              restore_error_handler();

                set_error_handler('ErrorHandler');
              if ($value) {
                  $arrArgument = array(
                      'column' => array("token"),
                      'like' => array($_GET['param']),
                      'field' => array('*')
                  );
                  $user = loadModel(MODEL_USERS, "users_model", "select", $arrArgument);
                  $json['user'] = $user;
                  $json['success'] = true;
                  echo json_encode($json);
                  exit();
              }
              restore_error_handler();
              echo json_encode($value);

        }
      }
    //end SignUp

    //.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-

    //Redes Sociales
    public function social_signin()
    { //utilitzada per Facebook i Twitter
        $user = json_decode($_POST['user'], true);
        if (isset($user['twitter']) && $user['twitter']) {
            //Ahora no estamos utilizando
            $user['apellidos'] = '';
            $user['email'] = '';
            $mail = $user['user_id'].'@gmail.com';
        }
        set_error_handler('ErrorHandler');
        try {
            $arrValue = loadModel(MODEL_USERS, 'users_model', 'count', array('column' => array('email'), 'like' => array($user['email'])));
        } catch (Exception $e) {
            $arrValue = false;
        }
        restore_error_handler();

        if (!$arrValue[0]['total']) {
            if ($user['email']) {
                $avatar = 'https://graph.facebook.com/'.($user['token']).'/picture';
            } else {
                $avatar = get_gravatar($mail, $s = 400, $d = 'identicon', $r = 'g', $img = false, $atts = array());
            }

            $arrArgument = array(
                'token' => $user['token'],
                'name' => $user['name'],
                'last_name' => $user['last_name'],
                'email' => $user['email'],
                'avatar' => $avatar,
                'tipo' => 'client',
                'activado' => '1',
            );

            set_error_handler('ErrorHandler');
            try {
                $value = loadModel(MODEL_USERS, 'users_model', 'create_user', $arrArgument);
            } catch (Exception $e) {
                echo json_encode('Exception = '.$e->getMessage()); //Devuelve el mensaje de Excepción en formato cadena
                $value = false;
            }
            restore_error_handler();
        } else {
            $value = true;
        }

        if ($value) {
            set_error_handler('ErrorHandler');
            $arrArgument = array(
                'email' => $user['email'],
                'select' => '*',
            );
            $user = loadModel(MODEL_USERS, 'users_model', 'select', $arrArgument);
            echo json_encode($user[0]);
            restore_error_handler();
        } else {
            $jsondata['error'] = 'Error al crear el usuario';
            echo json_encode($jsondata);
        }
    }//FIN Redes sociales

    //.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-
    //Funciones para Login
      public function login_users()
      {
          require_once VIEW_PATH_INC.'header.php';
          require_once VIEW_PATH_INC.'menu.php';

          echo '<br><br>';
          loadView('modules/users/view/', 'signin.php');

          require_once VIEW_PATH_INC.'footer.html';
      }

      public function login()
      {
          $user = json_decode($_POST['login_json'], true);
          $email = $user['email'];
          $pass = $user['pass'];

          $arrArgument = array(
                'email' => $email,
                'pass' => $pass,
                'select' => 'pass',
              );

          set_error_handler('ErrorHandler');

          try {
              //loadModel
                  $arrValue = loadModel(MODEL_USERS, 'users_model', 'select', $arrArgument);

              if (count($arrValue) > 0) {
                  //Comprobamos si el Select nos ha devuelto algo
                  $passIsCorrect = password_verify($user['pass'], $arrValue[0]['pass']);

                  if ($passIsCorrect) {
                      $arrArgument['select'] = '*';
                      $arrValue = loadModel(MODEL_USERS, 'users_model', 'select', $arrArgument);
                      $jsondata['email'] = $arrValue[0]['email'];
                      $jsondata['user'] = $arrValue[0]['user'];
                      $jsondata['avatar'] = $arrValue[0]['avatar'];
                      $jsondata['tipo'] = $arrValue[0]['tipo'];
                      $jsondata['name'] = $arrValue[0]['name'];
                      echo json_encode($jsondata);
                    //  $url = amigable('?module=main&function=begin&param=reg', true);
                    //  $jsondata["redirect"] = $url;

                  } else {
                      $jsondata['error'] = 'Password incorrecto';
                      echo json_encode($jsondata);
                  }
              } else {
                  $jsondata['error'] = 'No existe email';
                  echo json_encode($jsondata);
              }
          } catch (Exception $e) {
              $jsondata['error'] = $e->getMessage();
              echo json_encode($jsondata);
          }

          restore_error_handler();
      }//FIN Login

      //.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-

      //.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-
      //Funciones para el Profile
      public function profile()
      {
          require_once VIEW_PATH_INC.'header.php';
          require_once VIEW_PATH_INC.'menu.php';

          echo '<br><br>';
          loadView('modules/users/view/', 'profile.php');

          require_once VIEW_PATH_INC.'footer.html';
      }

      public function upload_avatar()
      {
          $result_avatar = upload_files();
          $_SESSION['avatar'] = $result_avatar;
      }

      public function delete_avatar()
      {
          $_SESSION['avatar'] = array();
          $result = remove_files();
          if ($result === true) {
              echo json_encode(array('res' => true));
          } else {
              echo json_encode(array('res' => false));
          }
      }

      public function profile_filler()
      {
        //echo json_encode('email1 = ' . $_POST['email']);
          if (isset($_POST['email'])) {
            //echo json_encode('email2 = ' . $_POST['email']);
              set_error_handler('ErrorHandler');
              try {
                  $arrArgument = array(
                    'email' => $_POST['email'],
                    'select' => '*',
                );
                  $arrValue = loadModel(MODEL_USERS, 'users_model', 'select', $arrArgument);
                //$arrValue = loadModel(MODEL_USERS, 'users_model', 'select', array(column => array('usuario'), like => array($_POST['usuario']), field => array('*')));
              } catch (Exception $e) {
                  $arrValue = false;
              }
              restore_error_handler();

              if ($arrValue) {
                  $jsondata['success'] = true;
                  $jsondata['user'] = $arrValue[0];
                  echo json_encode($jsondata);
                  //exit();
              } else {
                  $url = amigable('?module=main', true);
                  //$jsondata['success'] = false;
                  $jsondata['redirect'] = $url;
                  echo json_encode($jsondata);
                  //exit();
              }
          } else {
              $url = amigable('?module=main', true);
              $jsondata['success'] = false;
              $jsondata['redirect'] = $url;
              echo json_encode($jsondata);
              exit();
          }
      }
      //DEPENDENT DROP DOWN [Pais, Provincias, Poblaciones]
      public function load_countries_users()
      {
          //if ((isset($_GET['load_country'])) && ($_GET['load_country'] == true)) {
              $json = array();
              $url = 'http://www.oorsprong.org/websamples.countryinfo/CountryInfoService.wso/ListOfCountryNamesByName/JSON';
              set_error_handler('ErrorHandler');

              try {
                  $json = loadModel(MODEL_USERS, 'users_model', 'obtain_paises', $url);
              } catch (Exception $e) {
                  $json = array();
                  //$json = false;
              }
              restore_error_handler();

        //FUNCION DE TONI para comprobar si la url de pais está disponible
            if (stristr($json, 'error')) {
                $json = 'error';
                exit;
                if ($json) {
                    echo $json;
                    exit;
                } else {
                    $json = 'error';
                    echo $json;
                    exit;
                }
            }

      }

      public function load_provinces_users()
      {

         //if ((isset($_GET['load_provinces'])) && ($_GET['load_provinces'] == true)) {
              $jsondata = array();
              $json = array();
              set_error_handler('ErrorHandler');

              try {
                  $json = loadModel(MODEL_USERS, 'users_model', 'obtain_provincias');
              } catch (Exception $e) {
                  $json = array();
              }

              if ($json) {
                  $jsondata['provincias'] = $json;
                  echo json_encode($jsondata);
                  exit;
              } else {
                  $jsondata['provincias'] = 'error';
                  echo json_encode($jsondata);
                  exit;
              }

      }

      public function load_towns_users()
      {
          if (isset($_POST['idPoblac'])) {
              $jsondata = array();
              $json = array();
              set_error_handler('ErrorHandler');

              try {
                  $json = loadModel(MODEL_USERS, 'users_model', 'obtain_poblaciones', $_POST['idPoblac']);
              } catch (Exception $e) {
                  showErrorPage(2, 'ERROR - 503 BD', 'HTTP/1.0 503 Service Unavailable', 503);
              }
              restore_error_handler();

              if ($json) {
                  $jsondata['poblaciones'] = $json;
                  echo json_encode($jsondata);
                  exit;
              } else {
                  $jsondata['poblaciones'] = 'error';
                  echo json_encode($jsondata);
                  exit;
              }
          }
        }
          //.-.-.-.-.-.-.-.-.-.-.-.-.-.-.--.-.--.-.-.-.-.-.-.-.-.--.-.-.

    function modify()
    {

        $jsondata = array();
        $userJSON = json_decode($_POST['mod_user_json'], true);
        //$userJSON['password2'] = $userJSON['password'];
        $result = validate_user_modify_PHP($userJSON);
        //json_encode('$result = ' . $result);


        if ($result['resultado']) {
            $arrArgument = array(
              'name' => ucfirst($result['datos']['name']),
              'last_name' => ucfirst($result['datos']['last_name']),
              'birth_date' => $result['datos']['birth_date'],
              'title_date' => $result['datos']['title_date'],
              'address' => $result['datos']['address'],
              'user' => $result['datos']['user'],
              'email' => $result['datos']['email'],
              'pass' => password_hash($result['datos']['pass'], PASSWORD_BCRYPT),
              'en_lvl' => strtoupper($result['datos']['en_lvl']),
              //'interests' => $result['datos']['interests'],
             'avatar' => $_SESSION['avatar']['datos'],
             'pais' => ucfirst($result['datos']['pais']),
             'provincia' => ucfirst($result['datos']['provincia']),
              'poblacion' => ucfirst($result['datos']['poblacion']),
            //  'tipo' => $result['datos']['tipo'],
            );

            $arrayDatos = array(
               "column" => array(
                 'email'
               ),
               "like" => array($arrArgument['email']),
           );

           $j = 0;
           foreach ($arrArgument as $clave => $valor) {
               if ($valor != '') {
                   $arrayDatos['field'][$j] = $clave;
                   $arrayDatos['new'][$j] = $valor;
                    ++$j;
                }
            }

            set_error_handler('ErrorHandler');
           try {
               $arrValue = loadModel(MODEL_USERS, 'users_model', 'update_user', $arrayDatos);
           } catch (Exception $e) {
               $arrValue = false;
           }
           restore_error_handler();

           if($arrValue){
           $jsondata["hola"] = $arrayDatos;
           $jsondata['success'] = true;
           $jsondata{"redirect"} = amigable('?module=users&function=profile&param=done', true);
             echo json_encode($jsondata);
             exit;
             }else {
                $jsondata['success'] = false;
                $jsondata['redirect'] = $url = amigable('?module=users&function=profile&param=503', true);
                echo json_encode($jsondata);
            }

             }else{
           $jsondata['success'] = false;
              $jsondata['datos'] = $result;
              echo json_encode($jsondata);
         }
      }
            //FIN Profile
      //_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-


      //.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-

      //Restaurar Contraseña
      //NO ESTA IMPLEMENTADA VISTAS vacías SOLO CÓDIGO COPIADO
      public function restore()
      {

        require_once VIEW_PATH_INC.'header.php';
        require_once VIEW_PATH_INC.'menu.php';

        loadView('modules/users/view/', 'restore.php');

        require_once VIEW_PATH_INC.'footer.html';

      }

      public function process_restore()
      {
          $result = array();
          if (isset($_POST['inputEmail'])) {
              $result = valida_email($_POST['inputEmail']);
              if ($result) {
                  $column = array(
                      'email',
                  );
                  $like = array(
                      $_POST['inputEmail'],
                  );
                  $field = array(
                      'token',
                  );

                  $token = 'Cha'.md5(uniqid(rand(), true));
                  $new = array(
                      $token,
                  );

                  $arrArgument = array(
                      'column' => $column,
                      'like' => $like,
                      'field' => $field,
                      'new' => $new,
                  );
                  $arrValue = loadModel(MODEL_USERS, 'users_model', 'count', $arrArgument);
                  if ($arrValue[0]['total'] == 1) {
                    set_error_handler('ErrorHandler');
                      $arrValue = loadModel(MODEL_USERS, 'users_model', 'update_user', $arrArgument);

                      if ($arrValue) {
                          //Este es el punto donde se Envia Email al usuario informando nueva Contraseña
                          $arrArgument = array(
                              'token' => $token,
                              'email' => $_POST['inputEmail'],
                          );
                          if (sendtoken($arrArgument, 'modificacion')) {
                              echo 'Tu nueva contraseña ha sido enviada al email';
                          } else {
                              echo 'Error en el servidor. Intentelo más tarde';
                          }
                      }
                  } else {
                      echo 'El email introducido no existe ';
                  }
              } else {
                  echo 'El email no es válido';
              }
          }
          restore_error_handler();
      }


      function changepass() {
          if (substr($_GET['param'], 0, 3) == "Cha") {

            require_once VIEW_PATH_INC.'header.php';
            require_once VIEW_PATH_INC.'menu.php';

            loadView('modules/users/view/', 'changepass.php');

            require_once VIEW_PATH_INC.'footer.html';


          } else {
              showErrorPage(1, "", 'HTTP/1.0 503 Service Unavailable', 503);
          }
      }

      public function update_pass()
      {



          $jsondata = array();
          $pass = json_decode($_POST['passw'], true);

          $arrArgument = array(
              'column' => array('token'),
              'like' => array($pass['token']),
              'field' => array('pass'),
              'new' => array(password_hash($pass['password'], PASSWORD_BCRYPT)),
          );

          $jsondata['hola'] = $arrArgument['new'];
        //  echo json_encode($jsondata);
          //exit;


          set_error_handler('ErrorHandler');

          try {
              $value = loadModel(MODEL_USERS, 'users_model', 'update_user', $arrArgument);
              } catch (Exception $e) {

              $value = false;
          }
          restore_error_handler();

          if ($value) {
              $url =  amigable("?module=main&function=begin" , true);
              $jsondata['success'] = true;
              $jsondata['redirect'] = $url;
              echo json_encode($jsondata);
              exit;
          } else {
              $url =  amigable('?module=main&function=begin&param=503', true);
              $jsondata['success'] = true;
              $jsondata['redirect'] = $url;
              echo json_encode($jsondata);
              exit;
          }
      }
      //FIN restaurar Contraseña

  }
