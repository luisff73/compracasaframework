<?php
    class db {
        private $server;
        private $user;
        private $password;
        private $database;
        private $link;
        private $stmt;
        private $array;
        private $object;
        static $_instance;

        private function __construct() { // Constructor privado para evitar que se pueda instanciar desde fuera de la clase
            $this -> setConexion();
            $this -> conectar();
        }
        
        private function setConexion() { // Establece la conexión con la base de datos
            require_once 'Conf.class.singleton.php';
            $conf = Conf::getInstance();
            
            $this->server = $conf -> getHostDB();
            $this->database = $conf -> getDB();
            $this->user = $conf -> getUserDB();
            $this->password = $conf -> getPassDB();
        }

        private function __clone() {

        }

        public static function getInstance() { // Devuelve la instancia de la clase
            if (!(self::$_instance instanceof self))
                self::$_instance = new self();
            return self::$_instance;
        }

        private function conectar() { // Conecta con la base de datos
            $this -> link = new mysqli($this -> server, $this -> user, $this -> password);
            $this -> link -> select_db($this -> database);
        }

        public function ejecutar($sql) { // Ejecuta una consulta sql
            $this -> stmt = $this -> link -> query($sql); 
            return $this->stmt;
        }
        
        public function listar($stmt) {
            $this -> array = array();
            while ($row = $stmt -> fetch_array(MYSQLI_ASSOC)) {
                array_push($this -> array, $row);
            }
            return $this -> array;
        }
        
        public function listar_object($stmt) {
            $this -> object= $stmt -> fetch_object();
            return $this -> object ;
        }


    }