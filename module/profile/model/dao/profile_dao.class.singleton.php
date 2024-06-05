<?php

    class profile_dao {
        
        static $_instance;

        private function __construct() {
        }

        public static function getInstance() {
            if(!(self::$_instance instanceof self)){
                self::$_instance = new self();
            }
            return self::$_instance;
        }

    // public function incrementa_carrito($db,$id_vivienda,$username) {

    //     $sql = "CALL ACTUALIZA_CARRITO('$id_vivienda', '$username');";

    //     $stmt = $db -> ejecutar($sql);
        
    //     $sql1 = "SELECT COUNT(*) as total_viviendas from purchase where id_vivienda = '$id_vivienda' and username = '$username'";

    //     $stmt = $db -> ejecutar($sql1);
    //     return $db -> listar($stmt);
    //     //return $username;

    // }  
    // public function cierra_carrito($db,$username,$id_vivienda,$cantidad) {

    //     $sql = "CALL CIERRA_CARRITO('$username','$id_vivienda','$cantidad');";

    //     $stmt = $db -> ejecutar($sql);
       
    //     //return $sql;

    // }   

    public function lista_facturas($db,$username) {

        $sql = "SELECT p.id_vivienda, p.vivienda_name, p.username, p.quantity, p.vivienda_price, p.contador, v.image_name, v.stock, v.status FROM purchase p, viviendas v where v.id_vivienda=p.id_vivienda and username = '$username' and operation_type ='VF'";
        $stmt = $db -> ejecutar($sql);
        return $db -> listar($stmt);
        //return $sql;
    }   
    // public function borra_vivienda($db,$id_vivienda,$username) {

    //     $sql = "delete from purchase where id_vivienda='$id_vivienda' and username='$username';";
    //     //return $sql;
    //     $stmt = $db -> ejecutar($sql);
    // }   

     }
?>