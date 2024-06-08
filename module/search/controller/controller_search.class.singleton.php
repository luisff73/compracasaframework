<?php
class controller_search
{

    static $_instance;

    private function __construct()
    {
    }

    public static function getInstance()
    {
        if (!(self::$_instance instanceof self)) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    function view()
    {
        common::load_view('top_page_home.html', VIEW_PATH_HOME . 'home.html');
    }

    function search_operation()
    {
        echo json_encode(common::load_model('search_model', 'get_search_operation'));  //esta funcion get_carrusel se encuentra en el modelo search_model.class.singleton

    }

    function search_category()
    {
        echo json_encode(common::load_model('search_model', 'get_search_category', [$_POST['operation']]));
    }

    function search_category_null()
    {
        echo json_encode(common::load_model('search_model', 'get_search_category_null'));
    }


    function autocomplete()
    {
        echo json_encode(common::load_model('search_model', 'get_autocomplete', $_POST));
    }
}