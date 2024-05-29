<?php
require_once ('utils/vendor/autoload.php'); // if you use Composer

function Envia_whatssapp() {
    $ultramsg_token="9eb1ihhtg32yp38k"; // Ultramsg.com token
    $instance_id="instance86860"; // Ultramsg.com instance id
    $client = new UltraMsg\WhatsAppApi($ultramsg_token,$instance_id);
    $to="678945132"; 
    $body="Mensaje de recuperacion"; 
    $api=$client->sendChatMessage($to,$body);
    //print_r($api);
    return($api);
}

    $response = Envia_whatssapp();
    echo json_encode($response);


// funcion que ejecutamos cuando agotamos intentos de acceso.