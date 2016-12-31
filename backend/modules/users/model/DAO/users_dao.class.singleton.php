<?php

class users_dao{
    public static $_instance;

    private function __construct(){
    }

    public static function getInstance(){
        if (!(self::$_instance instanceof self)) {
            self::$_instance = new self();
        }

        return self::$_instance;
    }

    public function create_user_DAO($db, $arrArgument){
        $name = $arrArgument['name'];
        $last_name = $arrArgument['last_name'];
        $birth_date = $arrArgument['birth_date'];
        $title_date = $arrArgument['title_date'];
        $address = $arrArgument['address'];
        $user = $arrArgument['user'];
        $pass = $arrArgument['pass'];
        $email = $arrArgument['email'];
        $en_lvl = $arrArgument['en_lvl'];
        $interests = $arrArgument['interests'];
        $avatar = $arrArgument['avatar'];
        $pais = $arrArgument['pais'];
        $provincia = $arrArgument['provincia'];
        $poblacion = $arrArgument['poblacion'];
        $tipo = $arrArgument['tipo'];
        $token = $arrArgument['token'];
        if ($arrArgument['activado'])
            $activado = $arrArgument['activado'];
        else
            $activado = 0;

        $history = 0;
        $music = 0;
        $computing = 0;
        $magic = 0;

        foreach ($interests as $indice) {
            if ($indice === 'History') {
                $history = 1;
            }
            if ($indice === 'Music') {
                $music = 1;
            }
            if ($indice === 'Computing') {
                $computing = 1;
            }
            if ($indice === 'Magic') {
                $magic = 1;
            }
        }

        $sql = 'INSERT INTO users (name, last_name, birth_date, title_date,'
                .' address, user, pass, email, en_lvl,Computing,History,'
                .' Magic,Music,avatar,pais,provincia, poblacion,'
                .' tipo,token,activado)'
                ." VALUES ('$name', '$last_name', '$birth_date','$title_date', "
                ." '$address', '$user', '$pass', '$email', '$en_lvl', '$computing', '$history', "
                ." '$magic', '$music', '$avatar', '$pais', '$provincia', '$poblacion',"
                ." '$tipo', '$token','$activado')";

        return $db->ejecutar($sql);
    }



        public function count_DAO($db, $arrArgument) {
            /* $arrArgument is composed by 2 array ("column" and "like"), this iterates
             * the number of positions the array have, this way we get a method that builds a
             * custom sql to select with the needed arguments
             */
            $i = count($arrArgument['column']);

            $sql = "SELECT COUNT(*) as total FROM users WHERE ";

            for ($j = 0; $j < $i; $j++) {
                if ($i > 1 && $j != 0)
                    $sql.=" AND ";
                $sql .= $arrArgument['column'][$j] . " like '" . $arrArgument['like'][$j] . "'";
            }
            $stmt = $db->ejecutar($sql);
            return $db->listar($stmt);
        }

        public function select_DAO($db, $arrArgument) {//Seleccionamos Users según email
            $select = $arrArgument['select'];
            $email = $arrArgument['email'];

            $sql = "SELECT " . $select . " FROM users WHERE email = '" . $email . "'";

            $stmt = $db->ejecutar($sql);
            return $db->listar($stmt);
        }

        /*public function select_DAO($db, $arrArgument) {
            $i = count($arrArgument['column']);
            $k = count($arrArgument['field']);
            $sql1 = "SELECT ";
            $sql2 = " FROM users WHERE ";

            for ($j = 0; $j < $i; $j++) {
                if ($i > 1 && $j != 0)
                    $sql.=" AND ";
                $sql .= $arrArgument['column'][$j] . " like '" . $arrArgument['like'][$j] . "'";
            }

            for ($l = 0; $l < $k; $l++) {
                if ($l > 1 && $k != 0)
                    $fields.=", ";
                $fields .= $arrArgument['field'][$l];
            }


            $sql = $sql1 . $fields . $sql2 . $sql;

            $stmt = $db->ejecutar($sql);
            return $db->listar($stmt);
        }*/

        public function update_user_DAO($db, $arrArgument) {
            /*
             * @param= $arrArgument( column => array(colum),
             *                          like => array(like),
             *                          field => array(field),
             *                          new => array(new)
             *                      );
             */
            $i = count($arrArgument['field']);
            $k = count($arrArgument['column']);

            $sql1 = "UPDATE users SET ";
            $sql2 = "  WHERE ";

            for ($j = 0; $j < $i; $j++) {
                if ($i > 1 && $j != 0)
                    $change.=", ";
                $change .= $arrArgument['field'][$j] . "='" . $arrArgument['new'][$j] . "'";
            }
            for ($l = 0; $l < $k; $l++) {
                if ($k > 1 && $l != 0)
                    $sql.=" AND ";
                $sql .= $arrArgument['column'][$l] . " like '" . $arrArgument['like'][$l] . "'";
            }

            $sql = $sql1 . $change . $sql2 . $sql;

            return $db->ejecutar($sql);
        }

    public function obtain_paises_DAO($url){
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
        $file_contents = curl_exec($ch);
        curl_close($ch);

        return ($file_contents) ? $file_contents : false;
    }

    public function obtain_provincias_DAO(){
        $json = array();
        $tmp = array();
        //$provincias = simplexml_load_file($_SERVER['DOCUMENT_ROOT'].'photoTourist_framework_v2_prettyurls/resources/provinciasypoblaciones.xml');
        $provincias = simplexml_load_file(RESOURCES . 'provinciasypoblaciones.xml');
        $result = $provincias->xpath('/lista/provincia/nombre | /lista/provincia/@id');
        for ($i = 0; $i < count($result); $i += 2) {
            $e = $i + 1;
            $provincia = $result[$e];

            $tmp = array(
           'id' => (string) $result[$i], 'nombre' => (string) $provincia,
         );
            array_push($json, $tmp);
        }

        return $json;
    }

    public function obtain_poblaciones_DAO($arrArgument){
        $json = array();
        $tmp = array();

        $filter = (string) $arrArgument;
        //$xml = simplexml_load_file($_SERVER['DOCUMENT_ROOT'].'/php/photoTourist_framework_v1/resources/provinciasypoblaciones.xml');
        $xml = simplexml_load_file(RESOURCES . 'provinciasypoblaciones.xml');
        $result = $xml->xpath("/lista/provincia[@id='$filter']/localidades");

        for ($i = 0; $i < count($result[0]); ++$i) {
            $tmp = array(
             'poblacion' => (string) $result[0]->localidad[$i],
           );
            array_push($json, $tmp);
        }

        return $json;
    }


}
