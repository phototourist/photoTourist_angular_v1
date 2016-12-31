<?php
    function enviar_email($arr) {
        $html = '';
        $subject = '';
        $body = '';
        $ruta = '';
        $return = '';

        switch ($arr['type']) {
            case 'alta'://La $ruta hay que cambiarla NO BUENA
                $subject = 'BIENVENIDO A PHOTOTOURIST';
                $ruta = '<a href=' . amigable("?module=users&function=activar", true) . $arr['token'] . '>aqu&iacute;</a>';
                $body = 'Gracias por unirte a PhotoTourist<br> Para finalizar el registro, pulsa ' . $ruta;
                break;

            case 'modificacion':
                $subject = 'Tu Nuevo Password en PhotoTourist<br>';
                $ruta = '<a href="' . amigable("?module=users&function=changepass" , true) . $arr['token'] . '">aqu&iacute;</a>';
                $body = 'Para recordar tu password pulsa ' . $ruta;
                break;

            case 'contact':
                $subject = 'Tu Petici&oacute;n a PhotoTravel ha sido enviada<br>';
                $ruta = '<a href=' . 'https://examples-php-yomogan.c9.io/13B%20framework_contact/'. '>aqu&iacute;</a>';
                $body = 'Para visitar nuestra web, pulsa ' . $ruta;
                break;

            case 'admin':
                $subject = $arr['inputSubject'];
                $body = 'inputName: ' . $arr['inputName']. '<br>' .
                'inputEmail: ' . $arr['inputEmail']. '<br>' .
                'inputSubject: ' . $arr['inputSubject']. '<br>' .
                'inputMessage: ' . $arr['inputMessage'];
                break;
        }

        $html .= "<html>";
        $html .= "<body>";
	      $html .= "<h4>". $subject ."</h4>";
	      $html .= $body;
	      $html .= "<br><br>";
	      $html .= "<p>Enviado por PhotoTourist</p>";
		$html .= "</body>";
		$html .= "</html>";

        set_error_handler('ErrorHandler');
        try{
            $mail = email::getInstance();
            $mail->name = $arr['inputName'];
            if ($arr['type'] === 'admin')
                $mail->address = 'phototourist.contact@gmail.com';
            else
                $mail->address = $arr['inputEmail'];
            $mail->subject = $subject;
            $mail->body = $html;
        } catch (Exception $e) {
			$return = 0;
		}
		restore_error_handler();

        /*
        if ($mail->enviar()) {
            $return = 1;
        } else {
            $return = 0;
        }
        */
        $return = $mail->enviar();
        return $return;
    }
