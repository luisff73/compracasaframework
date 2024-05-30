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
		 public function get_filters_shop_BLL($args) {
			 return $this -> dao -> filters_search($this -> db, $args[0], $args[1], $args[2]);
		 }
		 public function get_count_all_viviendas_BLL() {
		 	return $this -> dao -> count_all_viviendas($this -> db);
		 }
		public function get_filters_home_BLL($args) {
			return $this -> dao -> filters_home($this -> db, $args[0], $args[1], $args[2]);
		}
		public function get_count_filters_home_BLL($args) {
			return $this -> dao -> filters_home($this -> db, $args[0], $args[1], $args[2]);
		}
		public function get_filters_search_BLL($args) {
			return $this -> dao -> filters_search($this -> db, $args[0], $args[1], $args[2]);
		}
		public function get_count_filters_shop_BLL($args) {
			return $this -> dao -> count_filters_shop($this -> db, $args);
		}
		public function get_count_filters_search_BLL($args) {
			return $this -> dao -> filters_search($this -> db, $args[0], $args[1], $args[2]);
		}
		public function get_details_viviendas_BLL() {

            // case 'details_vivienda':  //request al servidor

            //     try {
            //         $daoshop = new DAOShop();
                   $Details_viviendas= $this -> dao -> select_one_vivienda($this -> db, $_GET['id']);

            //     } catch (Exception $e) {
            //         echo json_encode("error");
            //     }
        
            //     try {
            //         $daoshop_img = new DAOShop();
            //         $Date_images = $daoshop_img->select_img_viviendas($_GET['id']);
					$Date_images = $this->dao->select_img_viviendas($this->db, $_GET['id']);


			//     } catch (Exception $e) {
            //         echo json_encode("error");
            //     }
        
                 if (!empty($Details_viviendas || $Date_images)) { // si hay datos details e images
                     $resultado = array();
                     $resultado[0] = $Details_viviendas;
                     $resultado[1][] = $Date_images;
                     //echo json_encode($resultado);
					 return $resultado;
                 } else {
        
                     echo json_encode("error");
                 }
            //     break;


			//return $this -> dao -> select_details_viviendas($this -> db, $args[0]);
		}
		public function get_select_categories_BLL() {
			return $this -> dao -> select_categories($this -> db);
		}
		public function get_select_city_BLL() {
			return $this -> dao -> select_city($this -> db);
		}
		public function get_select_type_BLL() {
			return $this -> dao -> select_type($this -> db);
		}
		public function get_select_operation_BLL() {
			return $this -> dao -> select_operation($this -> db);
		}
		public function get_select_price_BLL() {
			return $this -> dao -> select_price($this -> db);
		}
		public function get_incrementa_visita_BLL($args) {
			return $this -> dao -> incrementa_visita($this -> db, $args[0]);
		}
		public function get_viviendas_related_BLL($args) {
			return $this -> dao -> select_viviendas_related($this -> db, $args[0], $args[1], $args[2]);
		}
		public function get_count_viviendas_related_BLL($args) {
			return $this -> dao -> select_count_viviendas_related($this -> db, $args[0], $args[1], $args[2]);
		}
		public function get_incrementa_like_BLL($args) {
            $token_dec = (middleware::decode_token($_POST['accestoken'])); //decodificamos el token
			return $this -> dao -> incrementa_like($this -> db, $token_dec['username'], $_POST['id_vivienda']);
		}
	}
?>