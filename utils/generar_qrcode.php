<?php
// Incluir la biblioteca PHP QR Code
include "vendor/phpqrcode/qrlib.php";

// Definir la ruta donde se guardará la imagen del código QR
$rutaGuardar = 'qrcodes/';  

$nombreArchivo = $rutaGuardar . 'ejemplo_qrcode.png';

// Verificar si el directorio existe, si no, crearlo
if (!file_exists($rutaGuardar)) {
    mkdir($rutaGuardar, 0755, true);
}

// Los datos que quieres codificar
$datos = 'https://www.example.com';

// Generar el código QR y guardarlo en un archivo
QRcode::png($datos, $nombreArchivo, QR_ECLEVEL_L, 10);

// Mostrar la imagen del código QR
//echo '<img src="' . $nombreArchivo . '" />';
echo '<img src="http://localhost/compracasaframework/utils/qrcodes' . $nombreArchivo . '" />';
// Opcionalmente, proporcionar un enlace de descarga
//echo '<br><a href="' . $nombreArchivo . '" download>Descargar Código QR</a>';
echo '<br><a href="' . $nombreArchivo . '" download>Descargar Código QR</a>';
?>