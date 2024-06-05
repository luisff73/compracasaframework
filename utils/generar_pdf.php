<?php
// Incluir la biblioteca TCPDF
require_once('utils/vendor/autoload.php');

require_once('vendor/autoload.php');

// Crear un nuevo documento PDF
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
    
// Establecer la información del documento
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Tu Nombre');
$pdf->SetTitle('PDF de Ejemplo');
$pdf->SetSubject('Tutorial de TCPDF');
$pdf->SetKeywords('TCPDF, PDF, ejemplo, prueba, guía');

// Establecer los datos predeterminados del encabezado
$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING);

// Establecer las fuentes del encabezado y pie de página
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// Establecer la fuente predeterminada monoespaciada
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// Establecer los márgenes
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

// Establecer los saltos de página automáticos
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

// Establecer el factor de escala de la imagen
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

// Añadir una página
$pdf->AddPage();

// Establecer algún contenido para imprimir
$html = <<<EOD
<h1>¡Bienvenido a TCPDF!</h1>
<i>Este es un ejemplo de contenido HTML</i>
<p>Puedes poner cualquier contenido HTML aquí.</p>
EOD;

// Imprimir texto usando writeHTMLCell()
$pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);

// Cerrar y generar el documento PDF
$pdf->Output('ejemplo.pdf', 'I'); // 'I' para mostrar en línea, 'D' para descargar, 'F' para guardar en archivo

// 'F' para guardar en archivo
// $pdf->Output('/ruta/para/guardar/ejemplo.pdf', 'F');
?>