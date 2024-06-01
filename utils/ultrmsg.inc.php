<?php

//require_once __DIR__ . '/vendor/autoload.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['otp'])) {
    require_once ('utils/vendor/autoload.php'); // if you use Composer
    Ultramsg::Envia_whatssapp($_POST['otp']);
}

class Ultramsg {

public static function Envia_whatssapp($otp) {
    $ultramsg = parse_ini_file(UTILS."jwt.ini");
    $ultramsg_token=$ultramsg['ultramsg_token']; 
    $instance_id=$ultramsg['instance_id'];
    $client = new Ultramsg\WhatsAppApi($ultramsg_token,$instance_id);
    $to=$ultramsg['destinatario'];; 
    $body="Su cuenta ha sido bloqueada temporalmente, para activarla introduzca el siguiente codigo en la aplicacion".$otp; 
    $api=$client->sendChatMessage($to,$body);
    return true;
}
}
// funcion que ejecutamos cuando agotamos intentos de acceso.