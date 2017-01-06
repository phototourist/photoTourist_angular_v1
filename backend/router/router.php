<?php
    require_once 'paths.php';
    require 'autoload.php';
    include UTILS.'common.inc.php';
//	include LOG_DIR;
    include UTILS.'filter.inc.php';
    include UTILS.'utils.inc.php';
    include UTILS.'response_code.inc.php';
    include UTILS.'mail.inc.php';

    if (PRODUCTION) { //estamos en producción
        ini_set('display_errors', '1');
        ini_set('error_reporting', E_ERROR | E_WARNING | E_NOTICE); //error_reporting(E_ALL) ;
    } else {
        ini_set('display_errors', '0');
        ini_set('error_reporting', '0'); //error_reporting(0);
    }

    session_start();
      $_SESSION['module'] = '';

    $filter = inputfilter::getInstance();
    $_POST = json_decode(file_get_contents('php://input'), true);
    $_POST = $filter->process($_POST);
    $_GET = $filter->process($_GET);

    function handlerRouter()
    {

        if (!empty($_GET['module'])) {
            $URI_module = $_GET['module'];
        } else {
            $URI_module = 'main';
        }

        if (!empty($_GET['function'])) {
            $URI_function = $_GET['function'];
        } else {
            $URI_function = 'begin';
        }

        handlerModule($URI_module, $URI_function);
    }

    function handlerModule($URI_module, $URI_function)
    {
        $modules = simplexml_load_file('resources/modules.xml');
        $exist = false;

        foreach ($modules->module as $module) {
            if (($URI_module === (string) $module->uri)) {
                $exist = true;

                $path = MODULES_PATH.$URI_module.'/controller/controller_'.$URI_module.'.class.php';
                if (file_exists($path)) {
                    require_once $path;

                    $controllerClass = 'controller_'.$URI_module;

                    $obj = new $controllerClass();
                } else {
									//handlerModule('main', 'begin');
                    require_once VIEW_PATH_INC.'header.php';
                    require_once VIEW_PATH_INC.'menu.php';
                    showErrorPage(1, '', 'HTTP/1.0 400 Bad Request', 400);
                    require_once VIEW_PATH_INC.'footer.html';
                }
                handlerfunction(((string) $module->name), $obj, $URI_function);
                break;
            }
        }
        if (!$exist) {
					//handlerModule('main', 'begin');
            require_once VIEW_PATH_INC.'header.php';
            require_once VIEW_PATH_INC.'menu.php';
            showErrorPage(1, '', 'HTTP/1.0 400 Bad Request', 400);
            require_once VIEW_PATH_INC.'footer.html';
        }
    }

    function handlerFunction($module, $obj, $URI_function)
    {
        $functions = simplexml_load_file(MODULES_PATH.$module.'/resources/functions.xml');
        $exist = false;

        foreach ($functions->function as $function) {
            if (($URI_function === (string) $function->uri)) {
                $exist = true;
                $event = (string) $function->name;
                break;
            }
        }
        if (!$exist) {
				//	handlerModule('main', 'begin');
            require_once VIEW_PATH_INC.'header.php';
            require_once VIEW_PATH_INC.'menu.php';
            showErrorPage(1, '', 'HTTP/1.0 400 Bad Request', 400);
            require_once VIEW_PATH_INC.'footer.html';
        } else {
            //$obj->$event();
            call_user_func(array($obj, $event));
        }
    }

    handlerRouter();
