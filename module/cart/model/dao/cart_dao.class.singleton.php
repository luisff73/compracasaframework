<?php

    class cart_dao {
        
        static $_instance;

        private function __construct() {
        }

        public static function getInstance() {
            if(!(self::$_instance instanceof self)){
                self::$_instance = new self();
            }
            return self::$_instance;
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
            LEFT JOIN adapted a ON v.id_vivienda = a.id_vivienda where v.id_vivienda>0 group by v.id_vivienda LIMIT $offset,$items_page;";
            //LEFT JOIN adapted a ON v.id_vivienda = a.id_vivienda where v.id_vivienda>0 group by v.id_vivienda;";
            $stmt = $db -> ejecutar($sql);
            return $db -> listar($stmt);
            
        }
        public function count_all_viviendas($db) {
        
            $sql = "SELECT COUNT(*) as contador FROM viviendas;";
        
            $stmt = $db -> ejecutar($sql);
            return $db -> listar($stmt);
            
        }
        function select_one_vivienda($db,$id) {
            //return $id;
            $sql = "SELECT v.id_vivienda, v.vivienda_name, ci.city_name, v.state, v.status, v.vivienda_price, v.description, 
            v.image_name, v.m2, v.long, v.lat, c.category_name, o.operation_name, t.type_name, a.adapted, v.id_city,  count(l.id_vivienda) as total_likes 
            FROM viviendas v 
            INNER JOIN category c ON v.id_category = c.id_category 
            INNER JOIN operation o ON v.id_operation = o.id_operation 
            INNER JOIN city ci ON v.id_city = ci.id_city 
            INNER JOIN type t ON v.id_type = t.id_type 
            LEFT JOIN adapted a ON v.id_vivienda = a.id_vivienda
            LEFT JOIN likes l on v.id_vivienda=l.id_vivienda 
            WHERE v.id_vivienda = '$id'
            GROUP BY v.id_vivienda;";

            $stmt = $db -> ejecutar($sql);
            return $db -> listar($stmt);

        }
        function select_img_viviendas($db,$id) {
            $sql = "SELECT id_vivienda, id_image, image_name FROM images WHERE id_vivienda = '$id';";
    
            $stmt = $db -> ejecutar($sql);
            return $db -> listar($stmt);
        }
        public function filters_home($db, $filters, $offset, $items_page) {

            $select = "SELECT v.id_vivienda, v.vivienda_name, ci.city_name, v.state, v.status, v.vivienda_price, 
            v.description, v.image_name, v.m2, v.long, v.lat, c.category_name, o.operation_name, t.type_name, 
            c.id_category, o.id_operation, ci.id_city, t.id_type, a.adapted, count(l.id_vivienda) as total_likes  
            FROM viviendas v 
            INNER JOIN category c ON v.id_category = c.id_category 
            INNER JOIN operation o ON v.id_operation = o.id_operation 
            INNER JOIN city ci ON v.id_city = ci.id_city 
            INNER JOIN type t ON v.id_type = t.id_type 
            LEFT JOIN adapted a ON v.id_vivienda = a.id_vivienda 
            LEFT JOIN likes l on v.id_vivienda=l.id_vivienda
            WHERE v.id_vivienda>0";

            if (isset($filters[0][0]) && $filters[0][0] == 'id_operation') {  // Si el array de filtros contiene el índice id_operation((iel isset obliga)
                $add_filter = $filters[0][1];
                $select .= " and o.id_operation = '$add_filter'";
            } else if (isset($filters[0][0]) && $filters[0][0] =='id_category') { // Si el array de filtros contiene el índice id_category
                $add_filter = $filters[0][1];
                $select .= " and c.id_category = '$add_filter'";
            } else if (isset($filters[0][0]) && $filters[0][0] =='id_city') { // Si el array de filtros contiene el índice id_city
                $add_filter = $filters[0][1];
                $select .= " and ci.id_city = '$add_filter'";
            } else if (isset($filters[0][0]) && $filters[0][0] =='id_type') { // Si el array de filtros contiene el índice id_type
                $add_filter = $filters[0][1];
                $select .= " and t.id_type = '$add_filter'";
            } else if (isset($filters[0][0]) && $filters[0][0] =='adapted') { // Si el array de filtros contiene el índice adapted
                $add_filter = $filters[0][1];
                $select .= " and a.adapted = '$add_filter'";
            } else if (isset($filters[0][0]) && $filters[0][0] =='vivienda_price') { // Si el array de filtros contiene el índice vivienda_price
                $add_filter = $filters[0][1];
                $select .= " and v.vivienda_price = '$add_filter'";
            } else if (isset($filters[0]['filter_order'])) { // Si el array de filtros contiene el índice filter_order
                $add_filter = $filters[0][1];
                $select .= " ORDER BY v.vivienda_price $add_filter";
            }
            $select .= " GROUP BY v.id_vivienda";
            $select .= " LIMIT $offset,$items_page";

            $stmt = $db -> ejecutar($select);
            return $db -> listar($stmt);

            
        }
        function count_filters_home($db,$filters){
            $select = "SELECT COUNT(*) as contador,v.id_vivienda, v.vivienda_name, ci.city_name, v.state, v.status, 
            v.vivienda_price, v.description, v.image_name, v.m2, v.long, v.lat, c.category_name, o.operation_name, 
            t.type_name, c.id_category, o.id_operation, ci.id_city, t.id_type, a.adapted 
            FROM viviendas v 
            INNER JOIN category c ON v.id_category = c.id_category 
            INNER JOIN operation o ON v.id_operation = o.id_operation 
            INNER JOIN city ci ON v.id_city = ci.id_city 
            INNER JOIN type t ON v.id_type = t.id_type 
            LEFT JOIN adapted a ON v.id_vivienda = a.id_vivienda WHERE v.id_vivienda>0";
    
            if (isset($filters[0][0]) && $filters[0][0] == 'id_operation') {  // Si el array de filtros contiene el índice id_operation((iel isset obliga)
                $add_filter = $filters[0][1];
                $select .= " and o.id_operation = '$add_filter'";
            } else if (isset($filters[0][0]) && $filters[0][0] == 'id_category') { // Si el array de filtros contiene el índice id_category
                $add_filter = $filters[0][1];
                $select .= " and c.id_category = '$add_filter'";
            } else if (isset($filters[0][0]) && $filters[0][0] == 'id_city') { // Si el array de filtros contiene el índice id_city
                $add_filter = $filters[0][1];
                $select .= " and ci.id_city = '$add_filter'";
            } else if (isset($filters[0][0]) && $filters[0][0] == 'id_type') { // Si el array de filtros contiene el índice id_type
                $add_filter = $filters[0][1];
                $select .= " and t.id_type = '$add_filter'";
            } else if (isset($filters[0][0]) && $filters[0][0] == 'adapted') { // Si el array de filtros contiene el índice adapted
                $add_filter = $filters[0][1];
                $select .= " and a.adapted = '$add_filter'";
            } else if (isset($filters[0][0]) && $filters[0][0] == 'vivienda_price') { // Si el array de filtros contiene el índice vivienda_price
                $add_filter = $filters[0][1];
                $select .= " and v.vivienda_price = '$add_filter'";
            }
    
            $stmt = $db -> ejecutar($select);
            return $db -> listar($stmt);
            //return $select; //Esto no devuelve $select, con estro comprobamos que resuelve ajaxs desde el console.log

        }
        function filters_shop($db,$filters, $offset, $items_page) {
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
        function count_filters_shop($db,$filters){
            $select = "SELECT COUNT(*) as contador,v.id_vivienda,v.vivienda_name,ci.city_name,v.state,v.status,v.vivienda_price,v.description,v.image_name,v.m2,c.category_name,o.operation_name,t.type_name,c.id_category,o.id_operation,ci.id_city,t.id_type,a.adapted,v.long,v.lat FROM viviendas v INNER JOIN category c ON v.id_category = c.id_category INNER JOIN operation o ON v.id_operation = o.id_operation INNER JOIN city ci ON v.id_city = ci.id_city INNER JOIN type t ON v.id_type = t.id_type LEFT JOIN adapted a ON v.id_vivienda = a.id_vivienda WHERE v.id_vivienda>0";

            for ($i = 0; $i < count($filters); $i++) {
                if ($filters[$i][0] == 'vivienda_price') {
                    // Si el filtro es 'filter_price', separamos el contenido por la coma
                    list($value1, $value2) = explode('|', $filters[$i][1]);
                    $select .= " AND v." . $filters[$i][0] . " BETWEEN " . $value1 . " AND " . $value2;
                } else {
                    $select .= " AND v." . $filters[$i][0] . "=" . $filters[$i][1];
                }
            }
 
            $stmt = $db -> ejecutar($select);
            return $db -> listar($stmt);
            //return $select; //Esto no devuelve $select, con estro comprobamos que resuelve ajaxs desde el console.log
 
        }
        public function filters_search($db, $filters, $offset, $items_page) {

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
        public function select_categories($db) {

            $sql = "SELECT * FROM category";

             $stmt = $db -> ejecutar($sql);
             return $db -> listar($stmt);
          
        }
        public function select_type($db) {
 
             $sql = "SELECT * FROM type";
 
             $stmt = $db -> ejecutar($sql);
             return $db -> listar($stmt);
             
        }
        public function select_city($db) {

            $sql = "SELECT * FROM city";

            $stmt = $db -> ejecutar($sql);
            return $db -> listar($stmt);
          
        }
        public function select_operation($db) {

            $sql = "SELECT * FROM operation";

            $stmt = $db -> ejecutar($sql);
            return $db -> listar($stmt);
            
        }
        public function incrementa_visita($db,$id) {

            $sql = "UPDATE most_visited SET visitas = visitas + 1 WHERE id_vivienda = '$id';";

            $stmt = $db -> ejecutar($sql);
            //return $db -> listar($stmt);
            
        }      
        public function select_viviendas_related($db,$id_city,$offset,$items) {

            $sql = "SELECT v.id_vivienda,v.vivienda_name,v.long,v.lat,ci.city_name,state,status,v.vivienda_price,
            v.description,v.image_name,v.m2,c.category_name,o.operation_name, t.type_name,a.adapted, ci.city_name
            FROM viviendas v 
            INNER JOIN category c ON v.id_category = c.id_category 
            INNER JOIN operation o ON v.id_operation = o.id_operation 
            INNER JOIN city ci ON v.id_city = ci.id_city 
            INNER JOIN type t ON v.id_type = t.id_type 
            LEFT JOIN adapted a ON v.id_vivienda = a.id_vivienda 
            WHERE ci.id_city = '$id_city' 
            LIMIT $offset, $items";


            $stmt = $db -> ejecutar($sql);
            return $db -> listar($stmt);
            
        }     
        public function select_count_viviendas_related($db,$id_city,$offset,$items) {

            $sql = "SELECT COUNT(*) AS num_viviendas,v.id_vivienda,v.vivienda_name,v.long,v.lat,ci.city_name,state,status,v.vivienda_price,
            v.description,v.image_name,v.m2,c.category_name,o.operation_name, t.type_name,a.adapted 
            FROM viviendas v 
            INNER JOIN category c ON v.id_category = c.id_category 
            INNER JOIN operation o ON v.id_operation = o.id_operation 
            INNER JOIN city ci ON v.id_city = ci.id_city 
            INNER JOIN type t ON v.id_type = t.id_type 
            LEFT JOIN adapted a ON v.id_vivienda = a.id_vivienda WHERE ci.id_city = '$id_city'";

            $stmt = $db -> ejecutar($sql);
            return $db -> listar($stmt);
            
        }      
        public function incrementa_like($db,$username,$id_vivienda) {

            $sql = "CALL ACTUALIZA_LIKES('$id_vivienda', '$username');";

            $stmt = $db -> ejecutar($sql);

            $sql = "SELECT COUNT(*) as total_likes from likes where id_vivienda = '$id_vivienda'";

            $count_likes = $db -> listar_objects($sql);
            return $count_likes;
            //echo json_encode ($sql);
        }   

        public function select_price($db) { // PENDIENTE

            $sql = "SELECT DISTINCT v.vivienda_price FROM viviendas v";
            $stmt = $db -> ejecutar($sql);      
            return $db -> listar($stmt);
            
        }

     }
?>