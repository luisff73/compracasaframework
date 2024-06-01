<?php

    class common {
        public static function load_error() {  

            require_once (VIEW_PATH_INC . 'error404.html');
            //require_once (VIEW_PATH_INC . 'error503.html');
        }
        
        public static function load_view($topPage, $view) {
            //funcion para cargar la vista del home
            //comprobamos que existen los archivos top_page_home.html y home.html

            $topPage = VIEW_PATH_INC . $topPage;
            if ((file_exists($topPage)) && (file_exists($view))) {
                require_once ($topPage);
                require_once (VIEW_PATH_INC . 'header.html');
                require_once ($view);
                require_once (VIEW_PATH_INC . 'footer.html');
            }else {
                self::load_error();
            }
        }
        
        public static function load_model($model, $function = null, $args = null) { //carga el modelo
            $dir = explode('_', $model);
            $path = constant('MODEL_' . strtoupper($dir[0])) .  $model . '.class.singleton.php';

            if (file_exists($path)) {
                //error_log('file_exists '.$path);
                require_once ($path);  // del archivo xxxxx_model.class.singleton.php
                if (method_exists($model, $function)) {   //mira si en home_model existe la funcion get_carrusel
 
                    $obj = $model::getInstance(); // ejecuta la instancia de home_model
                    if ($args != null) {
                        return call_user_func(array($obj, $function), $args); //llama a la funcion get_carrusel
                    }
                    return call_user_func(array($obj, $function)); //llama a la funcion get_carrusel
  
                }
            }
            throw new Exception();
        }

        public static function generate_token_secure($longitud){
            if ($longitud < 4) {
                $longitud = 4;
            }
            return bin2hex(openssl_random_pseudo_bytes(($longitud - ($longitud % 2)) / 2)); //genera un token seguro
        }

        // function friendlyURL_php($url) {
        //     $link = "";
        //     if (URL_FRIENDLY) {
        //         $url = explode("&", str_replace("?", "", $url));
        //         foreach ($url as $key => $value) {
        //             $aux = explode("=", $value);
        //             $link .=  $aux[1]."/";
        //         }
        //     } else {
        //         $link = "index.php?" . $url;
        //     }
        //     return SITE_PATH . $link;
        // }
    }
?>