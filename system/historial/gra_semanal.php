<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

include_once 'application/common/Alerts.php';
include_once 'system/corte/Corte.php';
include_once 'application/common/Fechas.php';

?>

<?
if($_REQUEST["t"] != NULL){
echo '<a href="?gra_semanal" class="btn btn-success btn-rounded btn-sm">Todos</a>';
}
if($_REQUEST["t"] == NULL or $_REQUEST["d"] == 1){
echo '<a href="?gra_semanal&t=bar&d=2" class="btn btn-danger btn-rounded btn-sm">Gastos</a>';
}
if($_REQUEST["t"] == NULL or $_REQUEST["d"] == 2){
echo '<a href="?gra_semanal&t=bar&d=1" class="btn btn-info btn-rounded btn-sm">Ventas</a>';
}

if($_REQUEST["t"]=="bar"){
 echo '<canvas id="barChart"></canvas>';
} else {
echo '<canvas id="Gsemanal"></canvas>';	
}
 ?>

 