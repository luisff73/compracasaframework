<?php
//include($path . "/module/login/model/DAO/login_dao.class.singleton.php");
//include($path . "/model/middleware_auth.inc.php");
    class controller_profile {
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
            common::load_view('top_page_profile.html', VIEW_PATH_PROFILE . 'profile.html'); //cargamos la vista del carrito
        }
        

        function lista_facturas() {   
            //echo json_encode ($_POST['username']) ;                                                           
             echo json_encode(common::load_model('profile_model', 'get_lista_facturas', $_POST['username']));

        }

        // function borra_vivienda() {      
        //     //echo json_encode ($_POST['username'])                                                            
        //     echo json_encode(common::load_model('profile_model', 'get_borra_vivienda',$_POST['id_vivienda'],$_POST['username'])); 
        // }

        // function cierra_carrito() {   
        //    //echo json_encode ('hola');
        //     //echo json_encode ($_POST['precio']);                                                     
        //     echo json_encode(common::load_model('profile_model', 'get_cierra_carrito',$_POST['username'],$_POST['id_vivienda'],$_POST['cantidad'])); 
        // }
    }
?>