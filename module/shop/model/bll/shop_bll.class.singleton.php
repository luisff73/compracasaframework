<?php
  require ('module/shop/model/DAO/shop_dao.class.singleton.php');

	class shop_bll {
		private $dao;
		private $db;
		static $_instance;

		function __construct() {
			$this -> dao = shop_dao::getInstance();
			$this -> db = db::getInstance();
		}

		public static function getInstance() {
			if (!(self::$_instance instanceof self)) {
				self::$_instance = new self();
			}
			return self::$_instance;
   			//return 'hola get instance';
		}
		

		 public function get_all_viviendas_BLL($args) {
		 	return $this->dao->select_all_viviendas($this->db, $args[0], $args[1]);
		 }
		
public function afget_all_viviendas_BLL($args) {
    if (is_array($args) && count($args) >= 2) {
        return $this->dao->select_all_viviendas($this->db, $args[0], $args[1]);
    } else {
        // Manejar el error aquí, por ejemplo, devolver un mensaje de error
        return 'Argumentos inválidos';
    }
}


		 public function get_filters_shop_BLL($args) {
			 return $this -> dao -> select_filters_search($this -> db, $args[0], $args[1], $args[2]);
			 //return 'hola type';
		 }
		//  public function get_count_all_viviendas_BLL() {
		//  	return $this -> dao -> select_count_all_viviendas($this -> db);
		//  	//return 'hola city';
		//  }

		// public function get_filters_home_BLL() {
		// 	return $this -> dao -> select_filters_home($this -> db);
		// 	//return 'hola type';
		// }

		// public function get_count_filters_home_BLL() {
		// 	return $this -> dao -> select_filters_home($this -> db);
		// 	//return 'hola type';
		// }


		// public function get_filters_search_BLL() {
		// 	return $this -> dao -> select_filters_search($this -> db);
		// 	//return 'hola type';
		// }
		// public function get_count_filters_shop_BLL() {
		// 	return $this -> dao -> select_filters_search($this -> db);
		// 	//return 'hola type';
		// }
		// public function get_count_filters_search_BLL() {
		// 	return $this -> dao -> select_filters_search($this -> db);
		// 	//return 'hola type';
		// }
		// public function get_details_viviendas_BLL() {
		// 	return $this -> dao -> select_details_viviendas($this -> db);
		// 	//return 'hola type';
		// }
		public function get_select_categories_BLL() {
			return $this -> dao -> select_categories($this -> db);
			//return 'hola type';
		}
		public function get_select_city_BLL() {
			return $this -> dao -> select_city($this -> db);
			//return 'hola type';
		}
		public function get_select_type_BLL() {
			return $this -> dao -> select_type($this -> db);
			//return 'hola type';
		}
		
		public function get_select_operation_BLL() {
			return $this -> dao -> select_operation($this -> db);
			//return 'hola type';
		}
		public function get_select_price_BLL() {
			return $this -> dao -> select_price($this -> db);
			//return 'hola type';
		}
		// public function get_incrementa_visita_BLL() {
		// 	return $this -> dao -> select_incrementa_visita($this -> db);
		// 	//return 'hola type';
		// }
		// public function get_viviendas_related_BLL() {
		// 	return $this -> dao -> select_viviendas_related($this -> db);
		// 	//return 'hola type';
		// }
		// public function get_count_viviendas_related_BLL() {
		// 	return $this -> dao -> select_count_viviendas_related($this -> db);
		// 	//return 'hola type';
		// }
		// public function get_incrementa_like_BLL() {
		// 	return $this -> dao -> select_incrementa_like($this -> db);
		// 	//return 'hola type';
		// }
	}
?>