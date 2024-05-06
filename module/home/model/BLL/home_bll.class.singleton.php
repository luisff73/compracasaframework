<?php
  require ('module/home/model/DAO/home_dao.class.singleton.php');

	class home_bll {
		private $dao;
		private $db;
		static $_instance;

		function __construct() {
			$this -> dao = home_dao::getInstance();
			$this -> db = db::getInstance();
		}

		public static function getInstance() {
			if (!(self::$_instance instanceof self)) {
				self::$_instance = new self();
			}
			return self::$_instance;
   			//return 'hola get instance';
		}

		public function get_carrusel_BLL() {
			return $this -> dao -> select_data_carrusel($this -> db);
			//return 'hola carrusel';	
		}

		 public function get_category_BLL() {
		 	return $this -> dao -> select_data_category($this -> db);
		 	//return 'hola category';
		 }

		 public function get_city_BLL() {
		 	return $this -> dao -> select_data_city($this -> db);
		 	//return 'hola city';
		 }

		public function get_type_BLL() {
			return $this -> dao -> select_data_type($this -> db);
			//return 'hola type';
		}

		public function get_operation_BLL() {
			return $this -> dao -> select_data_operation($this -> db);
			//return 'hola type';
		}

		public function get_mas_visitadas_BLL() {
			return $this -> dao -> select_data_mas_visitadas($this -> db);
			//return 'hola type';
		}
	}
?>