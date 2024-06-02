<?php
  require ('module/shop/model/DAO/shop_dao.class.singleton.php');

	class cart_bll {
		private $dao;
		private $db;
		static $_instance;

		function __construct() {
			$this -> dao = cart_dao::getInstance();
			$this -> db = db::getInstance();
		}

		public static function getInstance() {
			if (!(self::$_instance instanceof self)) {
				self::$_instance = new self();
			}
			return self::$_instance;
		}
		public function get_all_viviendas_BLL($args) {
			return $this->dao->select_all_viviendas($this->db, $args[0], $args[1]);
		}
		public function get_incrementa_carrito_BLL($args) {
			//$token_dec = (middleware::decode_token($_POST['accestoken'])); //decodificamos el token
			////return $this -> dao -> incrementa_carrito($this -> db,  $_POST['id_vivienda'],$token_dec['username']);
			return $this -> dao -> incrementa_carrito($this -> db,  $_POST['id_vivienda'],$_POST['username']); //temporal
			//return ($_POST['username']);
		
		}
		public function get_lista_carrito_BLL($args) {
			//return ($args); // funciona
			return $this->dao->lista_carrito($this->db, $args);
		}
		public function get_borra_vivienda_BLL($args) {
			//return ($args); // funciona
			return $this->dao->borra_vivienda($this->db, $_POST['id_vivienda'],$_POST['username']);
		}
	}
?>