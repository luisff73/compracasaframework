<?php

require 'autoload.php';
//require __DIR__ . '/../vendor/autoload.php';


//$path = $_SERVER['DOCUMENT_ROOT'] . '/compracasaframework/';
//include($path . "utils/common.inc.php");
//include($path . "utils/mail.inc.php");
//require($path . "module/search/controller/controller_search.class.singleton.php");



ob_start();
session_start();

class router
{
    private $uriModule;
    private $uriFunction;
    private $nameModule;
    static $_instance;

    public static function getInstance()
    {  /// Crea el constructor si no existe

        //Si la propiedad estática $_instance no es una instancia de la clase actual    
        if (!(self::$_instance instanceof self)) {
            //Crear una nueva instancia de la clase y la asigna a $_instance
            self::$_instance = new self();
        }
        //Devuelve la instancia almacenada en $_instance
        return self::$_instance;
    }

    function __construct()
    {   // esta funcion se llama automaticamente.
        if (isset($_GET['module'])) { //comprueba si existe el modulo
            $this->uriModule = $_GET['module'];  //module es el nombre del modulo que viene del loadmenu en el main.js
        } else {
            $this->uriModule = 'home';
        }

        if (isset($_GET['op'])) { // si en la direccion url existe la variable op (si es true)

            //if ($_GET['op'] === 'verify_email' ){ 
            if ($_GET['module'] == 'login' && $_GET['op'] == 'verify_email') {

                //$this ->uriFunction ='verify_email';    
                //$this->uriFunction = 'view';
                $this->uriFunction = 'end_register';
            } else if ($_GET['op'] === 'recover_email') {
                $this->uriFunction = 'recover_view';
            } else {
                $this->uriFunction = ($_GET['op'] === "") ? 'view' : $_GET['op'];
            }

            //error_log($this -> uriFunction);
        } else {
            $this->uriFunction = 'view';
        }
        // Imprime el valor de uriModule

        // echo $this -> uriModule;

    }

    function routingStart()
    {
        try {
            //Llama a la función 'call_user_func' con un array que contiene 
            //el resultado de 'loadModule' y 'loadFunction'
            call_user_func(array($this->loadModule(), $this->loadFunction()));
        } catch (Exception $e) {
            //Si se produce una excepción, llamar al método 'load_error' de la clase 'common'
            common::load_error();
        }
    }

    private function loadModule()
    {    //Carga el modulo controlador especificado en la url
        if (file_exists('resources/modules.xml')) { //comprueba si existe el archivo modules.xml
            //echo ('el fichero existe');
            $modules = simplexml_load_file('resources/modules.xml'); //carga el archivo modules.xml
            foreach ($modules as $row) {   //recorre el archivo modules.xml
                if (in_array($this->uriModule, (array) $row->uri)) { //comprueba si el modulo existe
                    //construye la ruta al archivo del controlador con la constante MODULES_PATH
                    $path = MODULES_PATH . $row->name . '/controller/controller_' . (string) $row->name . '.class.singleton.php';
                    //echo $path;
                    if (file_exists($path)) {  //comprueba si existe el archivo del controlador 
                        require_once($path);
                        $controllerName = 'controller_' . (string) $row->name;
                        $this->nameModule = (string) $row->name;
                        //return new $controllerName;

                        return $controllerName::getInstance();;
                    }
                }
            }
        }
        throw new Exception('Not Module found.');

        // cargamos el controlador de la pagina de contacto
        // $path = 'module/contact/controller/controller_contact.class.php';
        // require_once($path);

        //$controllerName = 'controller_contact';
        // return new $controllerName;

    }

    private function loadFunction()
    { //Carga la función del controlador especificada en la url
        $path = MODULES_PATH . $this->nameModule . '/resources/function.xml';
        if (file_exists($path)) {
            $functions = simplexml_load_file($path);
            foreach ($functions as $row) {
                if (in_array($this->uriFunction, (array) $row->uri)) {
                    return (string) $row->name;
                }
            }
        }
        throw new Exception('Not Function found.');
        //return (String) 'view';
    }
}

// patron singleton para obtener una instancia de la clase router
// luego llama al metodo routingStart que inicia el enrutamiento 
// y determina que modulo y que funcion cargar

router::getInstance()->routingStart();
