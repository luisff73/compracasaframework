<?php
//include($path . "/module/login/model/DAO/login_dao.class.singleton.php");
//include($path . "/model/middleware_auth.inc.php");
    class controller_shop {
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
            //echo ( VIEW_PATH_HOME . 'shop.html');
            common::load_view('top_page_shop.html', VIEW_PATH_SHOP . 'shop.html'); //cargamos la vista del shop
        }
        
        
        function all_viviendas() {   
            // echo ('Hola all_viviendas');
            echo json_encode(common::load_model('shop_model', 'get_all_viviendas', [$_POST['offset'], $_POST['items_page']]));  //esta funcion get_carrusel se encuentra en el modelo home_model.class.singleton.php
        }              
        function filters_shop() {
            echo json_encode(common::load_model('shop_model', 'get_filters_shop', [$_POST['filters'], $_POST['offset'],$_POST['items_page']]));
        }
        
        function count_all_viviendas() {
           echo json_encode(common::load_model('shop_model', 'get_count_all_viviendas'));
        }

        function filters_home() {
            echo json_encode(common::load_model('shop_model', 'get_filters_home', [$_POST['filters'], $_POST['offset'],$_POST['items_page']]));
        }
        
        function count_filters_home() {
            echo json_encode(common::load_model('shop_model', 'get_count_filters_home', $_POST['filters_home']));
        }

        
        function filters_search() {
            echo json_encode(common::load_model('shop_model', 'get_filters_search', [$_POST['filters'], $_POST['offset'],$_POST['items_page']]));
        }

        function count_filters_shop() {
             echo json_encode(common::load_model('shop_model', 'get_count_filters_shop', $_POST['filters_shop']));
        }

        function count_filters_search() {
            echo json_encode(common::load_model('shop_model', 'get_count_filters_search', $_POST['filters_search']));
        }

        function details_viviendas() {
            echo json_encode(common::load_model('shop_model', 'get_details_viviendas', $_GET['id']));
        }

        function select_categories() {
            echo json_encode(common::load_model('shop_model', 'get_select_categories'));
        }

        function select_city() {
            echo json_encode(common::load_model('shop_model', 'get_select_city'));
        }


        function select_type() {
            echo json_encode(common::load_model('shop_model', 'get_select_type'));
        }

        function select_operation() {
            echo json_encode(common::load_model('shop_model', 'get_select_operation'));
        }

        function select_price() {
            echo json_encode(common::load_model('shop_model', 'get_select_price'));
        }

        function incrementa_visita() {
            echo json_encode(common::load_model('shop_model', 'get_incrementa_visita', $_GET['id']));
            echo json_encode("Visita incrementada con éxito");
        }

        function viviendas_related() {
            echo json_encode(common::load_model('shop_model', 'get_viviendas_related', [$_POST['id_city'],$_POST['offset'],$_POST['items_page']]));
        }

        function count_viviendas_related() {
            echo json_encode(common::load_model('shop_model', 'get_viviendas_related', [$_POST['id_city'],$_POST['offset'],$_POST['items_page']]));
        }

        function incrementa_like() {                                                                
            echo json_encode(common::load_model('shop_model', 'get_incrementa_like',[$_POST['id_vivienda'],$_POST['accestoken']]));
        }
    }
?>