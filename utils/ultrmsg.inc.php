<?php
require_once ('vendor/autoload.php'); // if you use Composer

$ultramsg_token="9eb1ihhtg32yp38k"; // Ultramsg.com token
$instance_id="instance86860"; // Ultramsg.com instance id
$client = new UltraMsg\WhatsAppApi($ultramsg_token,$instance_id);

$to="678945132"; 
$body="Hello world"; 
$api=$client->sendChatMessage($to,$body);
print_r($api);