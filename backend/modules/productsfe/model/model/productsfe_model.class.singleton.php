<?php
/*
$path = $_SERVER['DOCUMENT_ROOT'] . '/products_ORM_pagination_autocomplete/';
define('SITE_ROOT', $path);
require(SITE_ROOT . "modules/products_FE/model/BLL/products_bll.class.singleton.php");
*/

//require(BLL_PRODUCTS . "products_bll.class.singleton.php");

class productsfe_model {

    private $bll;
    static $_instance;

    private function __construct() {


        $this->bll = productsfe_bll::getInstance();


    }

    public static function getInstance() {
        if (!(self::$_instance instanceof self))
            self::$_instance = new self();
        return self::$_instance;
    }

    public function list_products() {
        return $this->bll->list_products_BLL();
    }

    public function details_products($id) {
        return $this->bll->details_products_BLL($id);
    }

    public function page_products($arrArgument) {
        return $this->bll->page_products_BLL($arrArgument);
    }

    public function total_products() {
        return $this->bll->total_products_BLL();
    }

    public function create_product($arrArgument) {
          return $this->bll->create_product_BLL($arrArgument);
      }

    public function list_limit_products($arrArgument){

          return $this->bll->list_limit_products_BLL($arrArgument);
      }

    public function count_products() {

          return $this->bll->count_products_BLL();
      }

    public function select_column_products($arrArgument){
          return $this->bll->select_column_products_BLL($arrArgument);
      }

    public function select_like_products($arrArgument){
          return $this->bll->select_like_products_BLL($arrArgument);
      }

    public function count_like_products($arrArgument){

          return $this->bll->count_like_products_BLL($arrArgument);
      }

    public function select_like_limit_products($arrArgument){

          return $this->bll->select_like_limit_products_BLL($arrArgument);
      }




}
