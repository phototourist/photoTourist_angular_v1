<?php

//Funcion para validar los 2 campos del Registro (SignUp)
function validate_user_signup_PHP($value){
    $error = array();
    $valido = true;
    $filtro = array(
      'email' => array(
          'filter' => FILTER_CALLBACK,
          'options' => 'valida_email',
      ),
        'pass' => array(
            'filter' => FILTER_VALIDATE_REGEXP,
            //'options' => array('regexp' => '/^[0-9a-zA-Z]{6,32}$/'),
            'options' => array('regexp' => '/^.{6,}$/')
        ),
    );

    $resultado = filter_var_array($value, $filtro);
    $valido = true;

    if (!$resultado['email']) {
        $error['email'] = 'error format email (example@example.com)';
        $valido = false;
    }

    if (!$resultado['pass']) {
        $error['pass'] = 'Password debe tener más de 6 caracteres';
        $valido = false;
    }

    return $return = array('resultado' => $valido, 'error' => $error, 'datos' => $resultado);
}

//Funcion para validar los campos del Profile [Solo Email es obligatorio]
function validate_user_modify_PHP($value){
    $error = array();
    $valido = true;
    $filtro = array(
      'name' => array(
          'filter' => FILTER_VALIDATE_REGEXP,
          'options' => array('regexp' => '/^[A-Za-z]{2,30}$/'),
      ),
      'last_name' => array(
          'filter' => FILTER_VALIDATE_REGEXP,
          'options' => array('regexp' => '/^[A-Za-z]{2,30}$/'),
      ),
      'birth_date' => array(
            'filter' => FILTER_VALIDATE_REGEXP,
            //'options' => array('regexp' => '/^(0[1-9]|1[012])[- \/.](0[1-9]|[12][0-9]|3[01])[- \/.](19|20)\d\d$/'),
            'options' => array('regexp' => '/^(0[1-9]|[12][0-9]|3[01])[- \/.](0[1-9]|1[012])[- \/.](19|20)\d\d$/'),
        ),
        'title_date' => array(
              'filter' => FILTER_VALIDATE_REGEXP,
              //'options' => array('regexp' => '/^(0[1-9]|1[012])[- \/.](0[1-9]|[12][0-9]|3[01])[- \/.](19|20)\d\d$/'),
              'options' => array('regexp' => '/^(0[1-9]|[12][0-9]|3[01])[- \/.](0[1-9]|1[012])[- \/.](19|20)\d\d$/'),
          ),
        'address' => array(
            'filter' => FILTER_VALIDATE_REGEXP,
            'options' => array('regexp' => '/^[a-z0-9- -.]+$/i'),
        ),
        'user' => array(
            'filter' => FILTER_VALIDATE_REGEXP,
            'options' => array('regexp' => '/^[0-9a-zA-Z]{2,20}$/'),
        ),
        'pass' => array(
            'filter' => FILTER_VALIDATE_REGEXP,
            'options' => array('regexp' => '/^[0-9a-zA-Z]{6,32}$/'),
        ),

    );

    $resultado = filter_var_array($value, $filtro);

    $valido = true;

    //Valores no filtrados con Expresiones Regulares
    // tODO ESTO SOBRA
    $resultado['en_lvl'] = $value['en_lvl'];
    $resultado['interests'] = $value['interests'];
    $resultado['pais'] = $value['pais'];
    $resultado['provincia'] = $value['provincia'];
    $resultado['poblacion'] = $value['poblacion'];
    //-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*
    if (isset($resultado['birth_date']) && !$resultado['birth_date']) {
        //validate to user's over 16
        $dates = validateAge($resultado['birth_date']);

        if (!$dates) {
            $error['birth_date'] = 'User must have more than 16 years';
            $valido = false;
          } else {
            $error['birth_date'] = 'error format date (mm/dd/yyyy)';
            $valido = false;
          }
    }
    //-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*


    if (isset($resultado['email']) && !$resultado['email']) {
        $error['email'] = 'error format email (example@example.com)';
        $valido = false;
    }

    if (isset($resultado['pass']) && !$resultado['pass']) {
        $error['pass'] = 'Password debe tener más de 6 caracteres';
        $valido = false;
    }


    if (isset($resultado['name']) && !$resultado['name']) {
        $error['name'] = 'Name must be 2 to 30 letters';
        $valido = false;
    }

    if (isset($resultado['user']) && !$resultado['user']) {
        $error['user'] = 'User must be 2 to 20 characters';
        $valido = false;
    }

    if (isset($resultado['address']) && !$resultado['address']) {
        $error['address'] = "Address don't have  symbols.";
        $valido = false;
    }

    if (isset($resultado['last_name']) && !$resultado['last_name']) {
        $error['last_name'] = 'Last name must be 2 to 30 letters';
        $valido = false;
    }

    //Podemos quitar una fecha, ya no tiene sentido
    if (isset($resultado['title_date']) && !$resultado['title_date']) {
        if ($resultado['title_date'] == '') {
            $error['title_date'] = "this camp can't empty";
            $valido = false;
        } else {
            $error['title_date'] = 'error format date (mm/dd/yyyy)';
            $valido = false;
        }
    }

    //$return = array('resultado' => $valido, 'error' => $error, 'datos' => $resultado);
    $return = array('resultado' => $valido, 'error' => $error, 'datos' => $value);

    return $return;
    //json_encode('$valido = ' . $valido);

}

function validate_user($value){

    $error = array();
    $valido = true;
    $filtro = array(
        'name' => array(
            'filter' => FILTER_VALIDATE_REGEXP,
            'options' => array('regexp' => '/^[A-Za-z]{2,30}$/'),
        ),
        'last_name' => array(
            'filter' => FILTER_VALIDATE_REGEXP,
            'options' => array('regexp' => '/^[A-Za-z]{2,30}$/'),
        ),

        //Atención con las fechas, ahora esta en formato Español [dd/mm/yyyy]
        'birth_date' => array(
            'filter' => FILTER_VALIDATE_REGEXP,
            //'options' => array('regexp' => '/^(0[1-9]|1[012])[- \/.](0[1-9]|[12][0-9]|3[01])[- \/.](19|20)\d\d$/'),
            'options' => array('regexp' => '/^(0[1-9]|[12][0-9]|3[01])[- \/.](0[1-9]|1[012])[- \/.](19|20)\d\d$/'),
        ),
        'title_date' => array(
            'filter' => FILTER_VALIDATE_REGEXP,
            //'options' => array('regexp' => '/^(0[1-9]|1[012])[- \/.](0[1-9]|[12][0-9]|3[01])[- \/.](19|20)\d\d$/'),
            'options' => array('regexp' => '/^(0[1-9]|[12][0-9]|3[01])[- \/.](0[1-9]|1[012])[- \/.](19|20)\d\d$/'),
        //_*_*_*_*_*_*_*_*_*_*_*_*_*_*_*_*_*_*_*_*_*_*_*_*_*_*_*

        ),
        'address' => array(
            'filter' => FILTER_VALIDATE_REGEXP,
            'options' => array('regexp' => '/^[a-z0-9- -.]+$/i'),
        ),
        'user' => array(
            'filter' => FILTER_VALIDATE_REGEXP,
            'options' => array('regexp' => '/^[0-9a-zA-Z]{2,20}$/'),
        ),
        'pass' => array(
            'filter' => FILTER_VALIDATE_REGEXP,
            'options' => array('regexp' => '/^[0-9a-zA-Z]{6,32}$/'),
        ),
        'email' => array(
            'filter' => FILTER_CALLBACK,
            'options' => 'valida_email',
        ),
    );

    $resultado = filter_var_array($value, $filtro);

    //Valores no filtrados con Expresiones Regulares
    $resultado['en_lvl'] = $value['en_lvl'];
    $resultado['interests'] = $value['interests'];
    $resultado['pais'] = $value['pais'];
    $resultado['provincia'] = $value['provincia'];
    $resultado['poblacion'] = $value['poblacion'];
    //-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*


    if ($resultado['birth_date']) {
        //validate to user's over 16
        $dates = validateAge($resultado['birth_date']);

        if (!$dates) {
            $error['birth_date'] = 'User must have more than 16 years';
            $valido = false;
        }
    }

    if ($resultado['birth_date'] && $resultado['title_date']) {
        //compare date of birth with title_date
        $dates = valida_dates($resultado['birth_date'], $resultado['title_date']);

        if (!$dates) {
            $error['birth_date'] = 'birth date must be before the date of registration and must have more than 16 years.';
            $valido = false;
        }
    }

    if ($resultado['en_lvl'] === 'Select level') {
        $error['en_lvl'] = "You haven't select lvl.";
        $valido = false;
    }

    if ($value['conf_pass'] != $resultado['pass']) {
        $error['conf_pass'] = "Pass doesn't match";
        $valido = false;
    }

    if ($value['conf_email'] != $resultado['email']) {
        $error['conf_email'] = "emails doesn't match";
        $valido = false;
    }

    if (count($resultado['interests']) <= 1) {
        $error['interests'] = 'Select 2 or more.';
        $valido = false;
    }

    if ($resultado != null && $resultado) {
        if (!$resultado['name']) {
            $error['name'] = 'Name must be 2 to 30 letters';
            $valido = false;
        }

        if (!$resultado['user']) {
            $error['user'] = 'User must be 2 to 20 characters';
            $valido = false;
        }

        if (!$resultado['email']) {
            $error['email'] = 'error format email (example@example.com)';
            $valido = false;
        }

        if (!$resultado['pass']) {
            $error['pass'] = 'Pass must be 6 to 32 characters';
            $valido = false;
        }

        if (!$resultado['address']) {
            $error['address'] = "Address don't have  symbols.";
            $valido = false;
        }

        if (!$resultado['last_name']) {
            $error['last_name'] = 'Last name must be 2 to 30 letters';
            $valido = false;
        }

        if (!$resultado['birth_date']) {
            if ($resultado['birth_date'] == '') {
                $error['birth_date'] = "this camp can't empty";
                $valido = false;
            } else {
                $error['birth_date'] = 'error format date (mm/dd/yyyy)';
                $valido = false;
            }
        }

        if (!$resultado['title_date']) {
            if ($resultado['title_date'] == '') {
                $error['title_date'] = "this camp can't empty";
                $valido = false;
            } else {
                $error['title_date'] = 'error format date (mm/dd/yyyy)';
                $valido = false;
            }
        }
    } else {
        $valido = false;
    }

    return $return = array('resultado' => $valido, 'error' => $error, 'datos' => $resultado);
}

function valida_dates($start_days, $dayslight)
{
    $start_day = date('m/d/Y', strtotime($start_days));
    $daylight = date('m/d/Y', strtotime($dayslight));

    list($mes_one, $dia_one, $anio_one) = split('/', $start_day);
    list($mes_two, $dia_two, $anio_two) = split('/', $daylight);

    $dateOne = new DateTime($anio_one.'-'.$mes_one.'-'.$dia_one);
    $dateTwo = new DateTime($anio_two.'-'.$mes_two.'-'.$dia_two);

    if ($dateOne <= $dateTwo) {
        return true;
    }

    return false;
}

// validate birthday
function validateAge($birthday, $age = 16)
{
    // $birthday can be UNIX_TIMESTAMP or just a string-date.
    if (is_string($birthday)) {
        $birthday = strtotime($birthday);
    }

    // check
    // 31536000 is the number of seconds in a 365 days year.
    if (time() - $birthday < $age * 31536000) {
        return false;
    }

    return true;
}

//validate email
function valida_email($email)
{
    $email = filter_var($email, FILTER_SANITIZE_EMAIL);
    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
      //$emailreg = /^[a-zA-Z0-9_\.\-]+@[a-zA-Z0-9\-]+\.[a-zA-Z0-9\-\.]+$/;
        //if (filter_var($email, FILTER_VALIDATE_REGEXP, array('options' => array('regexp' => '/^.{5,50}$/')))) {
            return $email;
        //}
    }

    return false;
}

//Crear un get_gravatar
function get_gravatar($email, $s = 80, $d = 'wavatar', $r = 'g', $img = false, $atts = array()) {
    $email = trim($email);
    $email = strtolower($email);
    $email_hash = md5($email);

    $url = "https://www.gravatar.com/avatar/" . $email_hash;
    $url .= md5(strtolower(trim($email)));
    $url .= "?s=$s&d=$d&r=$r";
    if ($img) {
        $url = '<img src="' . $url . '"';
        foreach ($atts as $key => $val)
            $url .= ' ' . $key . '="' . $val . '"';
        $url .= ' />';
    }
    return $url;
}
//Fin Gravatar

//Funcion envio token
function sendtoken($arrArgument, $type) {
    $mail = array(
        'type' => $type,
        'token' => $arrArgument['token'],
        'inputEmail' => $arrArgument['email']
    );
    set_error_handler('ErrorHandler');
    try {
        enviar_email($mail);
        return true;
    } catch (Exception $e) {
        return false;
    }
    restore_error_handler();
}
//Fin Token
