<?php
//include($path . "/module/login/model/DAO/login_dao.class.singleton.php");
//include($path . "/model/middleware_auth.inc.php");
class controller_profile
{
    static $_instance;

    function __construct()
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
        common::load_view('top_page_profile.html', VIEW_PATH_PROFILE . 'profile.html'); //cargamos la vista del carrito
    }

    function lista_facturas()
    {
        //echo json_encode ($_POST['username']) ;                                                           
        echo json_encode(common::load_model('profile_model', 'get_lista_facturas', $_POST['username']));
    }
    function lista_likes()
    {
        echo json_encode(common::load_model('profile_model', 'get_lista_likes', $_POST['username']));
    }
    function generar_pdf()
    {
        //echo json_encode('hola factura' . $_POST['factura']);
        echo json_encode(common::load_model('profile_model', 'get_genera_PDF', $_POST['factura']));
    }
}
