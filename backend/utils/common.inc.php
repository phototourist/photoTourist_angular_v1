<?php
    function loadModel($model_path, $model_name, $function, $arrArgument = '') {
        $model = $model_path . $model_name . '.class.singleton.php';

        if (file_exists($model)) {
            include_once($model);

            $modelClass = $model_name;

            if (!method_exists($modelClass, $function)){
                throw new Exception();
            }

            $obj = $modelClass::getInstance();

            if (isset($arrArgument)) {
                return $obj->$function($arrArgument);// funcion create_products en model.class
            }
        } else {
          throw new Exception();
          /*
          $message = "Model Not Found under Model Folder";
          $arrData = $message;
          require_once 'view/inc/404.php';
          die();
*/
        }
    }


    function loadView($rutaVista = '', $templateName = '', $arrPassValue = '') {
    		$view_path = $rutaVista . $templateName;
    		$arrData = '';

    		if (file_exists($view_path)) {
    			if (isset($arrPassValue))
    				$arrData = $arrPassValue;

    			include_once($view_path);

    		} else {

          //millora per a no utilitzar  ob_start() per evitar dublicació de headers
      $error = filter_num_int($rutaVista);

      if($error['resultado']){
          $rutaVista = $error['datos'];
      }else{
          $rutaVista = http_response_code();
      }


          $log = log::getInstance(http_response_code());
        			$log->add_log_general("error loadView general", $_GET['module'], "response ".http_response_code()); //$text, $controller, $function
        			$log->add_log_user("error loadView general", "", $_GET['module'], "response ".http_response_code());//$msg, $username = "", $controller, $function


        			$result = response_code($rutaVista);
        			$arrData = $result;
              require_once(VIEW_PATH_INC."header.php");
  			      require_once(VIEW_PATH_INC."menu.php");

              require_once VIEW_PATH_INC_ERROR. $result['code'] .'.php';

              require_once(VIEW_PATH_INC."footer.html");

			//die();
            	//require_once 'view/inc/error.php';


    			//die($templateName . ' Template Not Found under View Folder');
/*
    			$message = "NO TEMPLATE FOUND";
    			$arrData = $message;
    			require_once 'view/inc/404.php';
    			die();
*/
    		}
    	}
