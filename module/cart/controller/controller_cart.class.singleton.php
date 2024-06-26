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

            common::load_view('top_page_cart.html', VIEW_PATH_CART . 'cart.html'); //cargamos la vista del carrito
        }
        
        function agrega_carrito() {   
            //echo json_encode ('hola')                                                            
            //echo json_encode(common::load_model('cart_model', 'get_incrementa_carrito',[$_POST['id_vivienda'],$_POST['accestoken']]));
            echo json_encode(common::load_model('cart_model', 'get_incrementa_carrito',[$_POST['id_vivienda'],$_POST['username']])); //temporal
        }

        function lista_carrito() {   
            //echo json_encode ($_POST['username'])                                                            
            echo json_encode(common::load_model('cart_model', 'get_lista_carrito',$_POST['username'])); 
        }

        function borra_vivienda() {   
            //echo json_encode ($_POST['username'])                                                            
            echo json_encode(common::load_model('cart_model', 'get_borra_vivienda',$_POST['id_vivienda'],$_POST['username'])); 
        }

        function cierra_carrito() {   
           //echo json_encode ('hola');
            //echo json_encode ($_POST['precio']);                                                     
            echo json_encode(common::load_model('cart_model', 'get_cierra_carrito',$_POST['username'],$_POST['id_vivienda'],$_POST['cantidad'])); 
        }
    }
?>