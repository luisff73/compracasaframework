<?php 
    class Conf { // Clase singleton para la configuración de la base de datos
        private $_userdb;
        private $_passdb;
        private $_hostdb;
        private $_db;
        static $_instance;

        private function __construct() { // Constructor privado para evitar que se pueda instanciar desde fuera de la clase
            $cnfg = parse_ini_file(UTILS."jwt.ini");
            $this->_hostdb = $cnfg['host'];
            $this->_userdb = $cnfg['user'];
            $this->_passdb = $cnfg['pass'];
            $this->_db = $cnfg['db'];
        }

        private function __clone() {

        }

        public static function getInstance() {
            if (!(self::$_instance instanceof self))
                self::$_instance = new self();
            return self::$_instance;
        }

        public function getHostDB() {
            $var = $this->_hostdb;
            return $var;
        }
        public function getUserDB() {
            $var = $this->_userdb;
            return $var;
        }
        public function getPassDB() {
            $var = $this->_passdb;
            return $var;
        }
        public function getDB() {
            $var = $this->_db;
            return $var;
        }
    }