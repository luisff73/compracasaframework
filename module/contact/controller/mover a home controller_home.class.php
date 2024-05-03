<?php

// require_once('utils/common.inc.php');
// require_once('utils/Conf.class.singleton.php');

    class controller_home {
        function view() {
            echo json_encode('Hola view');
            //common::load_view('top_page_home.html', VIEW_PATH_HOME . 'home.html');
        }

        function carrusel() {
            echo json_encode('Hola carrusel');
            //echo json_encode(common::load_model('home_model', 'get_carrusel'));
        }

        function category() {
            echo json_encode('Hola category');
            //echo json_encode(common::load_model('home_model', 'get_category'));
        }
        
        function type() {
            echo json_encode('Hola type');
            //echo json_encode(common::load_model('home_model', 'get_type'));
        }
    }
?>