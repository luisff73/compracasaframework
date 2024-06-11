<?php
// Incluir la biblioteca PHP QR Code
include "vendor/phpqrcode/qrlib.php";

if (isset($_POST['factura'])) {

    $factura = $_POST['factura'];

    // Definir la ruta donde se guardará la imagen del código QR
    $rutaGuardar = 'qrcodes/';

    // Nombre del archivo con el formato 'factura_<numero_factura>.png'
    $nombreArchivo = $rutaGuardar . 'factura_' . $factura . '.png';

    // URL de la factura
    //$datos = 'http://localhost/compracasaframework/utils/pdf/factura_' . $factura . '.pdf';
    $datos = 'https://drive.google.com/drive/folders/1uHTmNPGU-r5l7yz4XVqgHriA1A56yQL-/factura_' . $factura . '.pdf';
    // Generamos el código QR y lo guardamos en un archivo
    QRcode::png($datos, $nombreArchivo, QR_ECLEVEL_L, 10);

    // Mostrar la imagen del código QR
    echo '<img src="http://localhost/compracasaframework/utils/' . $nombreArchivo . '" />';
    //echo '<img src="https://drive.google.com/drive/folders/1uHTmNPGU-r5l7yz4XVqgHriA1A56yQL-/' . $nombreArchivo . '" />';

    // Proporcionar un enlace de descarga opcional
    echo '<br><a href="http://localhost/compracasaframework/utils/' . $nombreArchivo . '" download>Descargar Código QR</a>';
    //echo '<br><a href="https://drive.google.com/drive/folders/1uHTmNPGU-r5l7yz4XVqgHriA1A56yQL-/' . $nombreArchivo . '" download>Descargar Código QR</a>';
} else {
    // Si no se recibió la variable 'factura', mostrar un mensaje de error
    echo "Error: No se recibió el número de factura.";
}
