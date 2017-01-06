
<?php
    class controller_contact {

        public function __construct() {
            $_SESSION['module'] = "contact";
        }

        /**
             * Send an email to client with the information that's filled in the form and send a copy to admin
             *
             * @return mixed[] Return an array containing a token, a name, an email, a subject and a message which has been filled
             * by the user previously
             */

        public function process_contact() {


          if ($_POST['token'] === "contact_form") {
            //////////////// Send the email to client
            $arrArgument = array(
                'type' => 'contact',
                'token' => '',
                'inputName' => $_POST['inputName'],
                'inputEmail' => $_POST['inputEmail'],
                'inputSubject' => $_POST['inputSubject'],
                'inputMessage' => $_POST['inputMessage']
            );
            set_error_handler('ErrorHandler');
            try {
/*
                    if (enviar_email($arrArgument)){
                        echo "<div class='alert alert-success'>Your message has been sent </div>";
                    } else {
                        echo "<div class='alert alert-error'>Server error. Try later...</div>";
                    }
*/
                    enviar_email($arrArgument);
				} catch (Exception $e) {
					$value = false;
				}
				restore_error_handler();


                //////////////// Envio del correo al admin de la ap web
                $arrArgument = array(
									'type' => 'admin',
									'token' => '',
									'inputName' => $_POST['inputName'],
									'inputEmail' => $_POST['inputEmail'],
									'inputSubject' => $_POST['inputSubject'],
									'inputMessage' => $_POST['inputMessage']
								);
                set_error_handler('ErrorHandler');
				try{
				    /*
                    if (enviar_email($arrArgument)){
                        echo "<div class='alert alert-success'>Your message has been sent </div>";
                    } else {
                        echo "<div class='alert alert-error'>Server error. Try later...</div>";
                    }
                    */
                    sleep(5);
                    enviar_email($arrArgument);
                    echo "true|Tu mensaje ha sido enviado correctamente";
				} catch (Exception $e) {
					echo "<div class='alert alert-error'>Server error. Try later...</div>";
				}
				restore_error_handler();

            }else{
                echo "<div class='alert alert-error'>Server error. Try later...</div>";
            }

        }




    }
