<?php

    class shop_dao {
        
        static $_instance;

        private function __construct() {
        }

        public static function getInstance() {
            if(!(self::$_instance instanceof self)){
                self::$_instance = new self();
            }
            return self::$_instance;
        }

        ///////////////////////////////////////////////////////////////////
        public function select_data_carrusel($db) {

            $sql = "SELECT * FROM operation";

            $stmt = $db -> ejecutar($sql);
            return $db -> listar($stmt);
  
        }

        public function select_categories($db) {

            $sql = "SELECT * FROM category";

             $stmt = $db -> ejecutar($sql);
             return $db -> listar($stmt);
          
         }

         public function select_city($db) {

            $sql = "SELECT * FROM city";

            $stmt = $db -> ejecutar($sql);
            return $db -> listar($stmt);
          
         }
         

        public function select_type($db) {

            $sql = "SELECT * FROM type";

            $stmt = $db -> ejecutar($sql);
            return $db -> listar($stmt);
            
        }

        public function select_operation($db) {

            $sql = "SELECT * FROM operation";

            $stmt = $db -> ejecutar($sql);
            return $db -> listar($stmt);
            
        }

        public function select_all_viviendas($db, $offset, $items_page) {

            $sql = "SELECT v.id_vivienda,v.vivienda_name,v.long,v.lat,ci.city_name,state,status,v.vivienda_price,
            v.description,v.image_name,v.m2,c.category_name,o.operation_name, t.type_name,a.adapted, count(l.id_vivienda) as total_likes 
            FROM viviendas v 
            INNER JOIN category c ON v.id_category = c.id_category 
            INNER JOIN operation o ON v.id_operation = o.id_operation 
            INNER JOIN city ci ON v.id_city = ci.id_city 
            INNER JOIN type t ON v.id_type = t.id_type 
            LEFT JOIN likes l on v.id_vivienda=l.id_vivienda
            LEFT JOIN adapted a ON v.id_vivienda = a.id_vivienda where v.id_vivienda>0 group by v.id_vivienda;";
            //LEFT JOIN adapted a ON v.id_vivienda = a.id_vivienda where v.id_vivienda>0 group by v.id_vivienda LIMIT $offset,$items_page;";
            $stmt = $db -> ejecutar($sql);
            return $db -> listar($stmt);
            
        }
        public function select_filters_search($db, $filters, $offset, $items_page) {

        $select = "SELECT v.id_vivienda,v.vivienda_name,ci.city_name,v.state,v.status,v.vivienda_price,
        v.description,v.image_name,v.m2,c.category_name,o.operation_name,t.type_name,c.id_category,
        o.id_operation,ci.id_city,t.id_type,
        a.adapted,v.long,v.lat, count(l.id_vivienda) as total_likes FROM viviendas v 
        INNER JOIN category c ON v.id_category = c.id_category 
        INNER JOIN operation o ON v.id_operation = o.id_operation 
        INNER JOIN city ci ON v.id_city = ci.id_city 
        INNER JOIN type t ON v.id_type = t.id_type 
        LEFT JOIN adapted a ON v.id_vivienda = a.id_vivienda 
        LEFT JOIN likes l ON v.id_vivienda = l.id_vivienda
        WHERE v.id_vivienda>0";

        $order = ""; // Variable para almacenar la cláusula ORDER BY

        for ($i = 0; $i < count($filters); $i++) {
            if ($filters[$i][0] == 'vivienda_price') {
                // Si el filtro es 'filter_price', separamos el contenido por la coma
                list($value1, $value2) = explode('|', $filters[$i][1]);
                $select .= " AND v." . $filters[$i][0] . " BETWEEN " . $value1 . " AND " . $value2;
            } elseif ($filters[$i][0] == 'filter_order') {
                $order = " ORDER BY " . $filters[$i][1];
            } else {
                $select .= " AND v." . $filters[$i][0] . "=" . $filters[$i][1];
            }
        }
        $select .= $order; // Añadimos la cláusula ORDER BY a la consulta
        $select .= " GROUP BY V.id_vivienda";
        $select .= " LIMIT $offset,$items_page ";

            $stmt = $db -> ejecutar($select);
            return $db -> listar($stmt);
            
        }

        public function select_price($db) {

            $sql = "SELECT DISTINCT v.vivienda_price FROM viviendas v";

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