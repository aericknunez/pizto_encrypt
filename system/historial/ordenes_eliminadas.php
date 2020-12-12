<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

include_once 'application/common/Alerts.php';
include_once 'system/historial/Historial.php';
?>

<div id="contenido">
<?php 
	$historial = new Historial;
	$historial->HistorialOrdenes();

 ?>
</div>