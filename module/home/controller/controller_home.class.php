<?php
    class controller_home {
        function view() {
            echo ('Hola view');
            //common::load_view('top_page_home.html', VIEW_PATH_HOME . 'home.html');
        }

        function carrusel() {
            echo ('Hola carousel');
            //echo json_encode(common::load_model('home_model', 'get_carrusel'));
        }

        function category() {
            echo ('Hola category');
            //echo json_encode(common::load_model('home_model', 'get_category'));
        }
        
        function type() {
            echo ('Hola type');
            //echo json_encode(common::load_model('home_model', 'get_type'));
        }
    }
?>