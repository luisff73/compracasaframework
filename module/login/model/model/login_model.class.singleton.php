<?php

error_reporting(E_ALL);
class login_model
{
    private $bll;
    static $_instance;

    function __construct()
    {
        $this->bll = login_bll::getInstance();
    }

    public static function getInstance()
    {
        if (!(self::$_instance instanceof self)) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    public function register($args)
    {
        $res = $this->bll->get_register_BLL($args);
        return $res;  /////////// añadido despues de verificar que funciona
    }

    public function login($args)
    {
        return $this->bll->get_login_BLL($args);
    }
    public function social_login($args)
    {
        return $this->bll->get_social_login_BLL($args);
    }

    //////////////////////////////////////////////////////////////////////

    public function get_verify_email($args)
    {
        //return 'fail';
        return $this->bll->get_verify_email_BLL($args);
    }

    public function recover_email($args)
    {
        return $this->bll->get_recover_email_BLL($args);
    }
    /////////////////////////////////////////////////////////////////////
    public function data_user($args)
    {
        return $this->bll->get_data_user_BLL($args);
    }
    public function activity()
    {
        return $this->bll->get_activity_BLL();
    }
    public function controluser($args)
    {
        return $this->bll->get_controluser_BLL($args);
    }





    public function new_password($args)
    {
        return $this->bll->get_new_password_BLL($args);
    }
}