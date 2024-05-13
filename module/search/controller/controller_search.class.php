<?php
    class controller_search {
        function view() {
            echo ('Hola view');
            echo ( VIEW_PATH_HOME . 'shop.html');
            common::load_view('top_page_shop.html', VIEW_PATH_HOME . 'home.html');
        }

        function load_operations() {   
            echo json_encode(common::load_model('search_model', 'search_operation'));  //esta funcion get_carrusel se encuentra en el modelo search_model.class.singleton

        }

        function load_category() {
            echo json_encode(common::load_model('search_model', 'search_category' , [$_POST['operation']]));

        }

        function load_category_null() {
            echo json_encode(common::load_model('search_model', 'search_category_null'));
        }
        
        function autocomplete() {
            echo json_encode(common::load_model('search_model', 'autocomplete',$_POST['sdata']));
        }

    }
?>