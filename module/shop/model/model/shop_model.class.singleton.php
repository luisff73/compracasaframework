<?php

    class shop_model {

        private $bll;
        static $_instance;
        
        function __construct() {
            $this -> bll = shop_bll::getInstance();
        }

        public static function getInstance() {
            if (!(self::$_instance instanceof self)) {
                self::$_instance = new self();
            }
            return self::$_instance;
        }

         public function get_all_viviendas($args) {
             //return 'hola category';
             return $this -> bll -> get_all_viviendas_BLL($args);
         }

         public function get_filters_shop($args) {
             //return 'hola type';
             return $this -> bll -> get_filters_shop_BLL($args);
         }

         public function get_count_all_viviendas() {
            //return 'hola category';
            return $this -> bll -> get_count_all_viviendas_BLL();
        }

        public function get_filters_home($args) {
            //return 'hola type';
            return $this -> bll -> get_filters_home_BLL($args);
        }
        public function get_count_filters_home($args) {
            //return 'hola type';
            return $this -> bll -> get_count_filters_home_BLL($args);
        }
        public function get_filters_search($args) {
            //return 'hola type';
            return $this -> bll -> get_filters_search_BLL($args);
        }
        public function get_count_filters_shop($args) {
            //return 'hola type';
            return $this -> bll -> get_count_filters_shop_BLL($args);
        }
        public function get_count_filters_search($args) {
            //return 'hola type';
            return $this -> bll -> get_filters_search_BLL($args);
        }
        public function get_details_viviendas($args) {
            //return 'hola type';
            return $this -> bll -> get_details_viviendas_BLL($args);
        }
        public function get_select_categories() {
            //return 'hola type';
            return $this -> bll -> get_select_categories_BLL();
        }
        public function get_select_city() {
            //return 'hola type';
            return $this -> bll -> get_select_city_BLL();
        }
        public function get_select_type() {
            //return 'hola type';
            return $this -> bll -> get_select_type_BLL();
        }
        
        public function get_select_operation() {
            //return 'hola type';
            return $this -> bll -> get_select_operation_BLL();
        }
        public function get_select_price() {
            //return 'hola type';
            return $this -> bll -> get_select_price_BLL();
        }
        public function get_incrementa_visita($args) {
            //return 'hola type';
            return $this -> bll -> get_incrementa_visita_BLL($args);
        }
        public function get_viviendas_related($args) {
            //return 'hola type';
            return $this -> bll -> get_viviendas_related_BLL($args);
        }
        public function get_count_viviendas_related($args) {
            //return 'hola type';
            return $this -> bll -> get_count_viviendas_related_BLL($args);
        }
        public function get_incrementa_like($args) {
            //return 'hola type';
            return $this -> bll -> get_incrementa_like_BLL($args);
        }
    }
?>