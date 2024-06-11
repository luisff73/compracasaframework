<?php
require('module/profile/model/DAO/profile_dao.class.singleton.php');

class profile_bll
{
	private $dao;
	private $db;
	static $_instance;

	function __construct()
	{
		$this->dao = profile_dao::getInstance();
		$this->db = db::getInstance();
	}

	public static function getInstance()
	{
		if (!(self::$_instance instanceof self)) {
			self::$_instance = new self();
		}
		return self::$_instance;
	}

	public function get_lista_facturas_BLL($args)
	{
		//return ($args); // funciona
		return $this->dao->lista_facturas($this->db, $args);
	}
	public function get_lista_likes_BLL($args)
	{
		//return ($args); // funciona
		return $this->dao->lista_likes($this->db, $args);
	}

	public function get_generarPDF_BLL($factura)
	{
		// Consulta SQL para obtener los datos de la factura
		$stmt = $this->db->ejecutar("SELECT * FROM purchase WHERE operation_type ='VF' AND contador = ?");
		$stmt->bind_param("i", $factura);
		$stmt->execute();
		$result = $stmt->get_result();
		// Convertir el resultado en un array
		$data = $result->fetch_all(MYSQLI_ASSOC);

		// Codificar el array como JSON y devolverlo
		echo json_encode($data);
		exit(); // Parar la ejecución del código

		// Verificar si se encontraron resultados
		if ($result->num_rows > 0) {
			// Crear un nuevo documento PDF
			$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

			// Configuración del PDF
			$pdf->SetCreator(PDF_CREATOR);
			$pdf->SetAuthor('Fotocasa tu portal de viviendas');
			$pdf->SetTitle('Facturas');
			$pdf->SetSubject('Facturas Generadas');
			$pdf->SetKeywords('TCPDF, PDF, facturas');

			$logo = $_SERVER['DOCUMENT_ROOT'] . '/compracasaframework/view/img/logo_minusvalido_mini.png';
			$titulo = 'Fotocasa & Company SL.';
			$subtitulo = 'Calle Alqueria, 24 - 33550 - Oviedo';
			$pdf->SetHeaderData($logo, 10, $titulo, $subtitulo);
			$pdf->setHeaderFont([PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN]);
			$pdf->setFooterFont([PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA]);

			$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
			$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
			$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
			$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
			$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
			$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

			// Añadir página
			$pdf->AddPage();

			// Recorrer los resultados y añadir al PDF
			while ($row = $result->fetch_assoc()) {
				$html = "<h1>Factura número: " . $row['contador'] . "</h1>";
				$html .= "<p>Cliente: " . $row['username'] . "</p>";
				$html .= "<p>Dirección: Calle Romanescu, 54 </p>";
				$html .= "<p>Población: 35002 - Alicante </p>";
				$html .= "<p>Provincia: Alicante </p>";
				$html .= "<p>Teléfono: 685456235 </p>";
				$html .= "<p>Fecha de factura: " . date('d-m-Y') . "</p>";
				$html .= "<table border='1' cellspacing='0' cellpadding='5'>";
				$html .= "<tr><th>Cantidad</th><th>Descripción</th><th>Provincia</th><th>Precio</th></tr>";
				$html .= "<tr><td>" . $row['quantity'] . "</td><td>" . $row['vivienda_name'] . "</td><td>" . 'Valencia' . "</td><td>" . $row['vivienda_price'] . " €" . "</td></tr>";
				$html .= "</table>";

				$html .= "<br><br><h2>Total factura: " . $row['vivienda_price'] . " €</h2>";
				$pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);
			}

			// Guardar el archivo PDF en la carpeta utils/pdf
			$filename = 'factura_' . $factura . '.pdf';
			$filePath = $_SERVER['DOCUMENT_ROOT'] . '/compracasaframework/utils/pdf/' . $filename;
			$pdf->Output($filePath, 'F'); // 'F' para guardar en archivo

			// Devolver la ruta del archivo
			return '/compracasaframework/utils/pdf/' . $filename;
		} else {
			return false;
		}
	}
}
