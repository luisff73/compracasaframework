<?php
// Incluir la biblioteca TCPDF
require_once("vendor/autoload.php");

//use TCPDF;

// Configurar la conexión a la base de datos
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "fotocasa";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);
    if ($data['action'] === 'generate_pdf') {
        // Consultar las facturas desde la base de datos
        $sql = "SELECT * FROM purchase where operation_type ='VF' AND contador = '$contador'"; // Ajusta la consulta según tu esquema
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            // Crear un nuevo documento PDF
            $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

            // Configuración del PDF
            $pdf->SetCreator(PDF_CREATOR);
            $pdf->SetAuthor('Fotocasa tu portal de viviendas');
            $pdf->SetTitle('Facturas');
            $pdf->SetSubject('Facturas Generadas');
            $pdf->SetKeywords('TCPDF, PDF, facturas');

            $pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING);
            $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
            $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

            $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
            $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
            $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
            $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
            $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
            $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

            // Añadir página
            $pdf->AddPage();

            // Recorrer los resultados y añadir al PDF
            while($row = $result->fetch_assoc()) {
                $html = "<h1>Factura numero: " . $row['contador'] . "</h1>";
                $html .= "<p>Cliente: " . $row['usersname'] . "</p>";
                $html .= "<p>Fecha: " . $row['fecha'] . "</p>";
                $html .= "<p>Total: $" . $row['vivienda_price'] . "</p>";
                $pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);
                $pdf->AddPage();
            }

            // Generar y enviar el PDF
            $pdf->Output('facturas.pdf', 'I');
        } else {
            echo "No se encontraron facturas.";
        }
    } else {
        echo "Acción no válida.";
    }
}

$conn->close();
?>