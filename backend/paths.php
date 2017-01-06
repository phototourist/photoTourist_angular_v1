<?php
    //SITE_ROOT
	$path=$_SERVER['DOCUMENT_ROOT'].'/photoTourist_angular_v1/backend/';
    define('SITE_ROOT', $path);

    //SITE_PATH
    define('SITE_PATH', 'https://' . $_SERVER['HTTP_HOST'] . '/photoTourist_angular_v1/');

		//log
    define('LOG_DIR',SITE_ROOT.'classes/log.class.singleton.php');
    define('USER_LOG_DIR',SITE_ROOT.'log/user/Site_User_errors.log');
    define('GENERAL_LOG_DIR',SITE_ROOT.'log/general/Site_General_errors.log');

		//libs
		define('LIBS',SITE_ROOT.'/libs/');

    //production
    define('PRODUCTION',true);

    //model
    define('MODEL_PATH',SITE_ROOT.'/model/');

    //modules
    define('MODULES_PATH',SITE_ROOT.'/modules/');

    //resources
    define('RESOURCES',SITE_ROOT.'/resources/');

    //media
    define('MEDIA_PATH',SITE_ROOT.'/media/');

    //utils
    define('UTILS',SITE_ROOT.'/utils/');

		//model users
	  define('FUNCTIONS_USERS', SITE_ROOT.'modules/users/utils/');
	  define('MODEL_PATH_USERS', SITE_ROOT.'modules/users/model/');
	  define('DAO_USERS', SITE_ROOT.'modules/users/model/DAO/');
	  define('BLL_USERS', SITE_ROOT.'modules/users/model/BLL/');
	  define('MODEL_USERS', SITE_ROOT.'modules/users/model/model/');
	  define('USERS_JS_PATH', SITE_PATH.'modules/users/view/js/');
		define('USERS_CSS_PATH', SITE_PATH . '/modules/users/view/css/');//Habrá que pensar si añadirlo al css general

    //model products
		define('FUNCTIONS_PRODUCTS',SITE_ROOT.'modules/productsfe/utils/');
    define('MODEL_PATH_PRODUCTS',SITE_ROOT.'modules/productsfe/model/');
    define('DAO_PRODUCTS',SITE_ROOT.'modules/productsfe/model/DAO/');
    define('BLL_PRODUCTS',SITE_ROOT.'modules/productsfe/model/BLL/');
    define('MODEL_PRODUCTS',SITE_ROOT.'modules/productsfe/model/model/');
    define('PRODUCTS_JS_PATH', SITE_PATH . 'modules/productsfe/view/js/');
		define('PRODUCTS_CSS_PATH', SITE_PATH . 'modules/productsfe/view/css/');

		//model contact
    define('CONTACT_JS_PATH', SITE_PATH . 'modules/contact/view/js/');
		define('CONTACT_CSS_PATH', SITE_PATH . 'modules/contact/view/css/');
		define('CONTACT_LIB_PATH', SITE_PATH . 'modules/contact/view/lib/');
		define('CONTACT_IMG_PATH', SITE_PATH . 'modules/contact/view/img/');
    define('CONTACT_VIEW_PATH', 'modules/contact/view/');

		//model camtourist
		define('CAMTOURIST_JS_PATH', SITE_PATH . '/modules/camtourist/view/js/');
		define('MODEL_CAMTOURIST', SITE_ROOT . '/modules/camtourist/model/model/');
		define('CAMTOURIST_CSS_PATH', SITE_PATH . 'modules/camtourist/view/css/');

		//amigables
		define('URL_AMIGABLES', TRUE);
