<?php

    // require 'autoload.php';
    
    // // $path = $_SERVER['DOCUMENT_ROOT'] . '/Ejercicios/Framework_PHP_OO_MVC/';
    // // include($path . "utils/common.inc.php");
    // // include($path . "utils/mail.inc.php");
    // // include($path . "paths.php");

    // ob_start();
    // session_start();

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
            }else{
                $this -> uriModule = 'home';
            }
            if(isset($_GET['op'])){
                $this -> uriFunction = ($_GET['op'] === "") ? 'view' : $_GET['op'];
            }else{
                $this -> uriFunction = 'view';
            }
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
        
        private function loadModule() {    //Carga el modulo controlador
            //  if (file_exists('resources/modules.xml')) {
            //      $modules = simplexml_load_file('resources/modules.xml');
            //      foreach ($modules as $row) {
            //          if (in_array($this -> uriModule, (Array) $row -> uri)) {
            //              $path = MODULES_PATH . $row -> name . '/controller/controller_' . (String) $row -> name . '.class.php';
            //              if (file_exists($path)) {  //comprueba si existe el archivo del controlador 
            //                  require_once($path);
            //                  $controllerName = 'controller_' . (String) $row -> name;
            //                  $this -> nameModule = (String) $row -> name;
            //                  return new $controllerName;
            //              }
            //          }
            //      } 
            //  }
            //  throw new Exception('Not Module found.');

            // cargamos el controlador de la pagina de contacto
            $path = 'module/contact/controller/controller_contact.class.php';
            require_once($path);

            $controllerName = 'controller_contact';
            return new $controllerName;

        }
        
        private function loadFunction() {
            // $path = MODULES_PATH . $this -> nameModule . '/resources/function.xml'; 
            // if (file_exists($path)) {
            //     $functions = simplexml_load_file($path);
            //     foreach ($functions as $row) {
            //         if (in_array($this -> uriFunction, (Array) $row -> uri)) {
            //             return (String) $row -> name;
            //         }
            //     }
            // }
            // throw new Exception('Not Function found.');
            return (String) 'view';
        }
    }
    

    // patron singleton para obtener una instancia de la clase router
    // luego llama al metodo routingStart que inicia el enrutamiento 
    // y determina que modulo y que funcion cargar

    
    router::getInstance() -> routingStart();

    //echo 'hola';