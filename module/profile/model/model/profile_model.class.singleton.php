<?php

class profile_model
{

    private $bll;
    static $_instance;

    function __construct()
    {
        $this->bll = profile_bll::getInstance();
    }

    public static function getInstance()
    {
        if (!(self::$_instance instanceof self)) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }
    public function get_lista_facturas($args)
    {
        //return ('holagetlistacarrito');
        return $this->bll->get_lista_facturas_BLL($args);
    }
    public function get_lista_likes($args)
    {
        //return ('holagetlistacarrito');
        return $this->bll->get_lista_likes_BLL($args);
    }
    public function get_genera_PDF($args)
    {
        return $this->bll->get_generarPDF_BLL($args);
    }
}
