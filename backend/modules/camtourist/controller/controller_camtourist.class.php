<?php
    class controller_camtourist{

        public function __construct(){
            //include(UTILS . "common.inc.php");
        }

        public function camtourist_mapa(){
            require_once VIEW_PATH_INC.'header.php';
            require_once VIEW_PATH_INC.'menu.php';

            loadView('modules/camtourist/view/', 'camtourist.php');

            require_once VIEW_PATH_INC.'footer.html';
        }

        public function maploader(){
            set_error_handler('ErrorHandler');
            try {
                $arrValue = loadModel(MODEL_CAMTOURIST, 'camtourist_model', 'select', array('column' => array('false'), 'field' => array('*')));

            } catch (Exception $e) {
                $arrValue = false;
            }
            restore_error_handler();

            if ($arrValue) {
                $arrArguments['camtourist'] = $arrValue;//dentro Argument estava ofertas
                $arrArguments['success'] = true;
                echo json_encode($arrArguments);
            } else {
                $arrArguments['success'] = false;
                $arrArguments['error'] = 503;
                echo json_encode($arrArguments);
            }
        }
    }
