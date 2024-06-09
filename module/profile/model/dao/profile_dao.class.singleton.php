<?php

class profile_dao
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

    public function lista_facturas($db, $username)
    {

        $sql = "SELECT p.id_vivienda, p.vivienda_name, p.username, p.quantity, p.vivienda_price, p.contador, v.image_name, v.stock, v.status FROM purchase p, viviendas v where v.id_vivienda=p.id_vivienda and username = '$username' and operation_type ='VF'";
        $stmt = $db->ejecutar($sql);
        return $db->listar($stmt);
        //return $sql;
    }
}