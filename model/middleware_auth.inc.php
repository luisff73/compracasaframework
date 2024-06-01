<?php

//$path = $_SERVER['DOCUMENT_ROOT'] . '/compracasaframework/';
require($path . "model/JWT.php"); // INCLUIMOS LA LIBRERIA JWT  

class middleware{

    public static function decode_token($token){
        $jwt = parse_ini_file(UTILS . "jwt.ini");
        $secret = $jwt['secret'];
        $JWT = new JWT;
        $token_dec = $JWT->decode($token, $secret);
        $rt_token = json_decode($token_dec, TRUE);
        //json_decode en una funcion de php que convierte un string json en un array asociativo
        return $rt_token;

    }
    public static function create_accestoken($username){
        $jwt = parse_ini_file(UTILS . "jwt.ini");
        $header = $jwt['header']; // OBTENEMOS EL HEADER DEL ARCHIVO INI
        $secret = $jwt['secret']; // OBTENEMOS EL SECRET DEL ARCHIVO INI
        $payload = '{"iat":"' . time() . '","exp":"' . time() + (600) . '","username":"' . $username . '"}';
        $JWT = new JWT;  // CREACION DE OBJETO JWT
        $token = $JWT->encode($header, $payload, $secret); // CODIFICAMOS EL TOKEN
        return $token;
    }
    public static function create_refreshtoken($username){
        $jwt = parse_ini_file(UTILS . "jwt.ini");
        $header = $jwt['header'];
        $secret = $jwt['secret'];
        $payload = '{"iat":"' . time() . '","exp":"' . time() + (1600) . '","username":"' . $username . '"}';
        $JWT = new JWT;  // CREACION DE OBJETO JWT
        $token = $JWT->encode($header, $payload, $secret); // CODIFICAMOS EL TOKEN
        return $token;
    }

}