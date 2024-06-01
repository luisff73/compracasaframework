<?php
require_once ('utils/vendor/autoload.php'); // if you use Composer
require_once __DIR__ . '/vendor/autoload.php';

class ultramsg {

public static function Envia_whatssapp($whats_token) {
    $ultramsg = parse_ini_file(UTILS."jwt.ini");
    $ultramsg_token=$ultramsg['ultramsg_token']; 
    $instance_id=$ultramsg['instance_id'];
    $client = new UltraMsg\WhatsAppApi($ultramsg_token,$instance_id);
    $to=$ultramsg['destinatario'];; 
    $body="Su cuenta ha sido bloqueada temporalmente, para activarla introduzca el siguiente codigo en la aplicacion".$whats_token; 
    $api=$client->sendChatMessage($to,$body);
    return true;
}
}
// funcion que ejecutamos cuando agotamos intentos de acceso.