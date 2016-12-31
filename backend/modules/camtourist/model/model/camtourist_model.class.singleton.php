<?php
class camtourist_model {
    private $bll;
    static $_instance;

    private function __construct() {
        $this->bll = camtourist_bll::getInstance();
    }

    public static function getInstance() {
        if (!(self::$_instance instanceof self))
            self::$_instance = new self();
        return self::$_instance;
    }

    public function create_camtourist($arrArgument) {
        return $this->bll->create_camtourist_BLL($arrArgument);
    }

    public function update($arrArgument) {
        return $this->bll->update_BLL($arrArgument);
    }

    public function count($arrArgument) {
        return $this->bll->count_BLL($arrArgument);
    }

     public function select($arrArgument) {
        return $this->bll->select_BLL($arrArgument);
    }
}
