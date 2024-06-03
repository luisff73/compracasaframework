<?php

    class cart_model {

        private $bll;
        static $_instance;
        
        function __construct() {
            $this -> bll = cart_bll::getInstance();
        }

        public static function getInstance() {
            if (!(self::$_instance instanceof self)) {
                self::$_instance = new self();
            }
            return self::$_instance;
        }

         public function get_all_viviendas($args) {
             return $this -> bll -> get_all_viviendas_BLL($args);
         }
         public function get_incrementa_carrito($args) {
            //return ('hola');
            return $this -> bll -> get_incrementa_carrito_BLL($args);
        }
        public function get_lista_carrito($args) {
            //return ('holagetlistacarrito');
            return $this -> bll -> get_lista_carrito_BLL($args);
        }
        public function get_borra_vivienda($args) {
            return $this -> bll -> get_borra_vivienda_BLL($args);
        }
        public function get_cierra_carrito($args) {
            return $this -> bll -> get_cierra_carrito_BLL($args);
        }

    }
?>