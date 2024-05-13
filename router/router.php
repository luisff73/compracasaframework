<?php

    require 'autoload.php';
        
    $path = $_SERVER['DOCUMENT_ROOT'] . '/compracasaframework/';
    include($path . "utils/common.inc.php");
    //include($path . "utils/mail.inc.php");
    require($path . "module/search/controller/controller_search.class.php");
    


    ob_start();
    session_start();

    class router {
        private $uriModule;
        private $uriFunction;
        private $nameModule;
        static $_instance;

        public static function getInstance() {  /// Crea el constructor si no existe

            //Si la propiedad estática $_instance no es una instancia de la clase actual    
            if (!(self::$_instance instanceof self)) {
                //Crear una nueva instancia de la clase y la asigna a $_instance
                self::$_instance = new self();
            }
            //Devuelve la instancia almacenada en $_instance
            return self::$_instance;
        }
    
        function __construct() {   
            if(isset($_GET['module'])){
                $this -> uriModule = $_GET['module'];  //module es el nombre del modulo que viene del loadmenu en el main.js
                //error_log($this -> uriModule);
            }else{
                $this -> uriModule = 'home';
            }
            if(isset($_GET['op'])){
                $this -> uriFunction = ($_GET['op'] === "") ? 'view' : $_GET['op'];
                //error_log($this -> uriFunction);
            }else{
                $this -> uriFunction = 'view';
            }
                // Imprime el valor de uriModule

    // echo $this -> uriModule;



        }
    
        function routingStart() {
            try {
                //Llama a la función 'call_user_func' con un array que contiene 
                //el resultado de 'loadModule' y 'loadFunction'
                call_user_func(array($this -> loadModule(), $this -> loadFunction()));
            }catch(Exception $e) {
                //Si se produce una excepción, llamar al método 'load_error' de la clase 'common'
                common::load_error();
            }
        }
        
        private function loadModule() {    //Carga el modulo controlador especificado en la url
             if (file_exists('resources/modules.xml')) { //comprueba si existe el archivo modules.xml
                //echo ('el fichero existe');
                 $modules = simplexml_load_file('resources/modules.xml'); //carga el archivo modules.xml
                 foreach ($modules as $row) {   //recorre el archivo modules.xml
                     if (in_array($this -> uriModule, (Array) $row -> uri)) { //comprueba si el modulo existe
                       echo $modules;
                        //construye la ruta al archivo del controlador con la constante MODULES_PATH
                         $path = MODULES_PATH . $row -> name . '/controller/controller_' . (String) $row -> name . '.class.php'; 
                         if (file_exists($path)) {  //comprueba si existe el archivo del controlador 
                             require_once($path);
                             $controllerName = 'controller_' . (String) $row -> name;
                             $this -> nameModule = (String) $row -> name;
                             return new $controllerName;
                         }
                     }
                 } 
             }
             throw new Exception('Not Module found.');

            // cargamos el controlador de la pagina de contacto
            $path = 'module/contact/controller/controller_contact.class.php';
            require_once($path);

            $controllerName = 'controller_contact';
            return new $controllerName;

        }
        
        private function loadFunction() { //Carga la función del controlador especificada en la url
            $path = MODULES_PATH . $this -> nameModule . '/resources/function.xml'; 
            if (file_exists($path)) {
                $functions = simplexml_load_file($path);
                foreach ($functions as $row) {
                    if (in_array($this -> uriFunction, (Array) $row -> uri)) {
                        return (String) $row -> name;
                    }
                }
            }
            throw new Exception('Not Function found.');
            return (String) 'view';
        }
    }
    

    // patron singleton para obtener una instancia de la clase router
    // luego llama al metodo routingStart que inicia el enrutamiento 
    // y determina que modulo y que funcion cargar
    
    router::getInstance() -> routingStart();