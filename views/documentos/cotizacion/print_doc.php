<?php
require_once("c://xampp/htdocs/sistemacompras/controllers/controladorCotizacion.php");
$obj = new controladorCotizacion(); 
$cotizacionValues = $obj->getCotizacion($_GET['cotizacion_id']);
$cotizacionItems = $obj->getCotizacionItems($_GET['cotizacion_id']);

$output = '';
$output .= '<table width="100%" border="1" cellpadding="5" cellspacing="0">
	<tr>
	<td colspan="2" align="center" style="font-size:18px"><b>Cotizacion Proveedor</b></td>
	</tr>
	<tr>
	<td colspan="2">
	<table width="100%" cellpadding="5">
	<tr>
	<td width="65%">
	DE,<br />
	<b>PROVEEDOR QUE COTIZA</b><br />
	RAÓN SOCIAL : ' . $cotizacionValues['Razon_Social'] . '<br /> 
	RUC : ' . $cotizacionValues['ruc'] . '<br />
	</td>
	<td width="70%">         
	Cotizacion no. : #' . $cotizacionValues['cotizacion_id'] . '<br />
	Fecha de la cotizacion : ' . $cotizacionValues['fecha_hora'] . '<br />
	</td>
	</tr>
	</table>
	<br />
	<table width="100%" border="1" cellpadding="5" cellspacing="0">
	<tr>
	<th align="left">No.</th>
	<th align="left">Producto</th>
	<th align="left">Cantidad</th> 
	</tr>';
$count = 0;
foreach ($cotizacionItems as $cotizacionItem) {
	$count++;
	$output .= '
	<tr>
	<td align="left">' . $count . '</td>
	<td align="left">' . $cotizacionItem["producto"] . '</td>
	<td align="left">' . $cotizacionItem["cotizacion_producto_cantidad"] . '</td>
	</tr>';
}

$output .= '
	</table>
	</td>
	</tr>
	</table>';
// create pdf of invoice	
$invoiceFileName = 'Factura ConfiguroWeb-' . $cotizacionValues['cotizacion_id'] . '.pdf';
require_once '../../../dompdf/src/Autoloader.php';
Dompdf\Autoloader::register();

use Dompdf\Dompdf;

$dompdf = new Dompdf();
$dompdf->loadHtml(html_entity_decode($output));
$dompdf->setPaper('A4', 'portrait');
$dompdf->render();
$dompdf->stream($invoiceFileName, array("Attachment" => false));
