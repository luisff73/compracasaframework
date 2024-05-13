<?php

    class search_dao {
        
        static $_instance;

        private function __construct() {
        }

        public static function getInstance() {
            if(!(self::$_instance instanceof self)){
                self::$_instance = new self();
            }
            return self::$_instance;
        }

        public function select_load_operations($db) {

            $sql = "SELECT id_operation, operation_name FROM operation;";

            $stmt = $db -> ejecutar($sql);
            return $db -> listar($stmt);
  
        }

        public function select_load_category_null($db) {

            $sql = "SELECT id_category, category_name FROM category;";

            $stmt = $db -> ejecutar($sql);
            return $db -> listar($stmt);
        
        }
        
        public function select_load_category($db, $operation) {

            $sql = "SELECT distinct c.id_category, c.category_name FROM viviendas v, category c WHERE c.id_category = v.id_category AND v.id_operation = '$operation';";

             $stmt = $db -> ejecutar($sql);
             return $db -> listar($stmt);
          
         }


         public function select_only_operation($db,$complete,$operation) {

            $sql = "SELECT v.*, c.city_name, o.operation_name FROM viviendas v, city c, operation o WHERE v.id_city=c.id_city and v.id_operation=o.id_operation and v.id_operation = '$operation' AND c.city_name LIKE '$complete%';";

            $stmt = $db -> ejecutar($sql);
            return $db -> listar($stmt);
          
         }
         

        public function select_only_category($db,$category,$complete) {

            $sql = "SELECT v.*, c.city_name, ca.category_name FROM viviendas v, city c, category ca WHERE v.id_city=c.id_city and v.id_category=ca.id_category and ca.id_category = '$category' AND c.city_name LIKE '$complete%';";

            $stmt = $db -> ejecutar($sql);
            return $db -> listar($stmt);
            
        }

        public function select_operation_category($db,$complete,$operation,$category) {

            $sql = "SELECT v.*, o.operation_name,ca.category_name, c.city_name FROM viviendas v, operation o, category ca, city c WHERE v.id_operation=o.id_operation and v.id_category=ca.id_category and v.id_city=c.id_city and o.id_operation = '$operation' and ca.id_category = '$category' AND c.city_name LIKE '$complete%';";

            $stmt = $db -> ejecutar($sql);
            return $db -> listar($stmt);
            
        }
        public function select_city($db,$complete) {

            $sql = "SELECT distinct c.city_name FROM viviendas v, city c WHERE v.id_city=c.id_city and c.city_name LIKE '$complete%';";

            $stmt = $db -> ejecutar($sql);
            return $db -> listar($stmt);
            
        }




    }
?>