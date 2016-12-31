<?php
/*
$path = $_SERVER['DOCUMENT_ROOT'] . '/products_ORM_pagination_autocomplete/';
define('SITE_ROOT', $path);
define('MODEL_PATH', SITE_ROOT . 'model/');
require (MODEL_PATH . "Db.class.singleton.php");
require(SITE_ROOT . "modules/products_FE/model/DAO/products_dao.class.singleton.php");
*/

//require (MODEL_PATH . "db.class.singleton.php");
//require(SITE_ROOT . "modules/productsfe/model/DAO/products_dao.class.singleton.php");

class productsfe_bll {

    private $dao;
    private $db;
    static $_instance;

    private function __construct() {
        $this->dao = productsfe_dao::getInstance();
        $this->db = db::getInstance();

    }

    public static function getInstance() {
        if (!(self::$_instance instanceof self))
            self::$_instance = new self();
        return self::$_instance;
    }

    public function create_products_BLL($arrArgument) {
      return $this->dao->create_products_DAO($this->db, $arrArgument);
  }

    public function list_products_BLL() {
        return $this->dao->list_products_DAO($this->db);
    }

    public function details_products_BLL($id) {
        return $this->dao->details_products_DAO($this->db,$id);
    }

    public function page_products_BLL($arrArgument) {
        return $this->dao->page_products_DAO($this->db,$arrArgument);
    }

    public function total_products_BLL() {
        return $this->dao->total_products_DAO($this->db);
    }

    public function list_limit_products_BLL($arrArgument) {

        return $this->dao->list_limit_products_DAO($this->db, $arrArgument);
    }

    public function count_products_BLL() {
          return $this->dao->count_products_DAO($this->db);
    }

    public function select_column_products_BLL($arrArgument){
      return $this->dao->select_column_products_DAO($this->db,$arrArgument);
      }

    public function select_like_products_BLL($arrArgument){
      return $this->dao->select_like_products_DAO($this->db,$arrArgument);
    }

    public function count_like_products_BLL($arrArgument){

      return $this->dao->count_like_products_DAO($this->db,$arrArgument);
    }

    public function select_like_limit_products_BLL($arrArgument){

      return $this->dao->select_like_limit_products_DAO($this->db,$arrArgument);
    }



}
