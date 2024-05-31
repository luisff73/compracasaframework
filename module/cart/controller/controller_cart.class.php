<?php
//include($path . "/module/login/model/DAO/login_dao.class.singleton.php");
//include($path . "/model/middleware_auth.inc.php");
    class controller_cart {
        static $_instance;

        function __construct() {
		}

		public static function getInstance() {
			if (!(self::$_instance instanceof self)) {
				self::$_instance = new self();
			}
			return self::$_instance;
		}
        
        function view() {
            //echo ('Hola view'); // hay que practicar esto
            //echo '<p>Hola view</p>';  // hay que practicar esto
            //echo ( VIEW_PATH_CART . 'cart.html');
            common::load_view('top_page_cart.html', VIEW_PATH_CART . 'cart.html'); //cargamos la vista del carrito
        }
        
        function incrementa_carrito() {                                                                
            echo json_encode(common::load_model('cart_model', 'get_incrementa_vivienda',[$_POST['id_vivienda'],$_POST['accestoken']]));
        }
    }
?>