<?php
    require_once('utils/common.inc.php');
    require_once('paths.php');
    
    class controller_home {
        static $_instance;

        private function __construct() {
        }
        
        public static function getInstance() {
            if(!(self::$_instance instanceof self)){
                self::$_instance = new self();
            }
            return self::$_instance;
        }

        
        function view() {
            //echo ('Hola view');
            common::load_view('top_page_home.html', VIEW_PATH_HOME . 'home.html');
        }

        function carousel() {   
            //echo ('Hola carousel');
            echo json_encode(common::load_model('home_model', 'get_carrusel'));  //esta funcion get_carrusel se encuentra en el modelo home_model.class.singleton
            //error_log('valor de carousel '.json_encode(common::load_model('home_model', 'get_carrusel')));  
        }

        function category() {
            //echo ('Hola category');
            echo json_encode(common::load_model('home_model', 'get_category'));
            //error_log('valor de category '.json_encode(common::load_model('home_model', 'get_category')));
        }

        function city() {
            echo json_encode(common::load_model('home_model', 'get_city'));
        }
        
        function type() {
            echo json_encode(common::load_model('home_model', 'get_type'));
        }

        function operation() {
            echo json_encode(common::load_model('home_model', 'get_operation'));
        }
        
        function mas_visitadas() {
            echo json_encode(common::load_model('home_model', 'get_mas_visitadas'));
        }

        function ultimas_busquedas() {
            echo json_encode(common::load_model('home_model', 'get_ultimas_busquedas'));
        }
    }
?>