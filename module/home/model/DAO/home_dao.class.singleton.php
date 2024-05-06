<?php

    class home_dao {
        
        static $_instance;

        private function __construct() {
        }

        public static function getInstance() {
            if(!(self::$_instance instanceof self)){
                self::$_instance = new self();
            }
            return self::$_instance;
        }

        public function select_data_carrusel($db) {

            $sql = "SELECT * FROM operation";

            $stmt = $db -> ejecutar($sql);
            return $db -> listar($stmt);
  
        }

        public function select_data_category($db) {

            $sql = "SELECT * FROM category";

             $stmt = $db -> ejecutar($sql);
             return $db -> listar($stmt);
          
         }

         public function select_data_city($db) {

            $sql = "SELECT * FROM city";

            $stmt = $db -> ejecutar($sql);
            return $db -> listar($stmt);
          
         }
         

        public function select_data_type($db) {

            $sql = "SELECT * FROM type";

            $stmt = $db -> ejecutar($sql);
            return $db -> listar($stmt);
            
        }

        public function select_data_operation($db) {

            $sql = "SELECT * FROM operation";

            $stmt = $db -> ejecutar($sql);
            return $db -> listar($stmt);
            
        }

        public function select_data_mas_visitadas($db) {

            $sql = "SELECT DISTINCT v.id_vivienda,v.vivienda_name,ci.city_name,state,status,v.vivienda_price,v.description,v.image_name,v.m2,c.category_name,o.operation_name, t.type_name,a.adapted, vv.visitas FROM viviendas v INNER JOIN category c ON v.id_category = c.id_category INNER JOIN operation o ON v.id_operation = o.id_operation INNER JOIN city ci ON v.id_city = ci.id_city INNER JOIN type t ON v.id_type = t.id_type LEFT JOIN adapted a ON v.id_vivienda = a.id_vivienda INNER JOIN most_visited vv ON v.id_vivienda=vv.id_vivienda order by vv.visitas desc;";

            $stmt = $db -> ejecutar($sql);
            return $db -> listar($stmt);
            
        }   

    }
?>