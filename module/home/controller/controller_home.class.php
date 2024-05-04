<?php
    class controller_home {
        function view() {
            //echo ('Hola view');
            common::load_view('top_page_home.html', VIEW_PATH_HOME . 'home.html');
        }

        function carousel() {
            
            echo json_encode(common::load_model('home_model', 'get_carrusel'));  //esta funcion get_carrusel se encuentra en el modelo home_model.class.singleton
        }

        function category() {
            //echo ('Hola category');
            echo json_encode(common::load_model('home_model', 'get_category'));
        }

        function city() {
            //echo ('Hola city');
            echo json_encode(common::load_model('home_model', 'get_city'));
        }
        
        function type() {
            //echo ('Hola type');
            echo json_encode(common::load_model('home_model', 'get_type'));
        }

        function operation() {
            //echo ('Hola operation');
            echo json_encode(common::load_model('home_model', 'get_operation'));
        }
        
        function mas_vivitadas() {
            //echo ('Hola mas_vivitadas');
            echo json_encode(common::load_model('home_model', 'get_mas_vivitadas'));
        }

        function ultimas_busquedas() {
            //echo ('Hola ultimas_busquedas');
            echo json_encode(common::load_model('home_model', 'get_ultimas_busquedas'));
        }
    }
?>