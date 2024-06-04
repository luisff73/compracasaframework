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
        
    // public function select_all_viviendas($db, $offset, $items_page) {

    //     $sql = "SELECT v.id_vivienda,v.vivienda_name,v.long,v.lat,ci.city_name,state,status,v.vivienda_price,
    //     v.description,v.image_name,v.m2,c.category_name,o.operation_name, t.type_name,a.adapted, count(l.id_vivienda) as total_likes 
    //     FROM viviendas v 
    //     INNER JOIN category c ON v.id_category = c.id_category 
    //     INNER JOIN operation o ON v.id_operation = o.id_operation 
    //     INNER JOIN city ci ON v.id_city = ci.id_city 
    //     INNER JOIN type t ON v.id_type = t.id_type 
    //     LEFT JOIN likes l on v.id_vivienda=l.id_vivienda
    //     LEFT JOIN adapted a ON v.id_vivienda = a.id_vivienda where v.id_vivienda>0 group by v.id_vivienda LIMIT $offset,$items_page;";
    //     //LEFT JOIN adapted a ON v.id_vivienda = a.id_vivienda where v.id_vivienda>0 group by v.id_vivienda;";
    //     $stmt = $db -> ejecutar($sql);
    //     return $db -> listar($stmt);
        
    // }
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

    // public function lista_carrito($db,$username) {

    //     $sql = "SELECT p.id_vivienda, p.vivienda_name, p.username, p.quantity, p.vivienda_price, v.image_name, v.stock, v.status FROM purchase p, viviendas v where v.id_vivienda=p.id_vivienda and username = '$username' and operation_type ='VP'";
    //     $stmt = $db -> ejecutar($sql);
    //     return $db -> listar($stmt);
    //     //return $sql;
    // }   
    // public function borra_vivienda($db,$id_vivienda,$username) {

    //     $sql = "delete from purchase where id_vivienda='$id_vivienda' and username='$username';";
    //     //return $sql;
    //     $stmt = $db -> ejecutar($sql);
    // }   

     }
?>