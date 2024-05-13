<?php

    class search_model {

        private $bll;
        static $_instance;
        
        function __construct() {
            $this -> bll = search_bll::getInstance();
        }

        public static function getInstance() {
            if (!(self::$_instance instanceof self)) {
                self::$_instance = new self();
            }
            //return 'hola get instance';
            return self::$_instance;
        }

        public function get_load_operations() {
            //return 'hola carrusel';
            return $this -> bll -> get_load_operations_BLL();
        }

         public function get_load_category() {
             //return 'hola category';
             return $this -> bll -> get_load_category_BLL();
         }

         public function get_load_category_null() {
            //return 'hola category';
            return $this -> bll -> get_load_category_null_BLL();
        }

        public function get_autocomplete() {
            //return 'hola type';
            return $this -> bll -> get_autocomplete_BLL();
        }

    }
?>