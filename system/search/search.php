<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
include_once 'application/common/Alerts.php';

include_once 'system/search/Busqueda.php';
$search = new Busqueda();

$a = $db->query("SELECT * FROM ticket WHERE num_fac='".$_POST["search"]."' and tx = ".$_SESSION["tx"]." and td = ".$_SESSION["td"]."");
$registros = $a->num_rows;
$a->close();

if($registros != 0){
?>


<div class="row">
 <div class="col-sm-6">
  <h3>Opciones</h3>
  <div id="ventana"></div>
<hr>
<?php if($_SESSION["tx"]==1){

	if($_SESSION["root_plataforma"] == 0){
		echo '<a id="imprimir-factura" op="86"  factura="'.$_POST["search"].'" class="btn-floating btn-lg btn-mdb-color" data-toggle="tooltip" title="Imprimir Factura"><i class="fas fa-print"></i></a>';
	} else {
		echo '<a href="system/facturar/ticket_web.php?factura='.$_POST["search"].'" class="btn-floating btn-lg btn-mdb-color" data-toggle="tooltip" title="Imprimir Factura"><i class="fas fa-print"></i></a>';
	}


    if ($r = $db->select("edo", "ticket", "WHERE num_fac='".$_POST["search"]."' and tx = ".$_SESSION["tx"]." and td = ".$_SESSION["td"]."")) { 
        if($r["edo"] == 1){
        	echo '<a id="mensaje-borrar" op="82" iden="'.$_POST["search"].'" class="btn-floating btn-lg btn-danger" title="Elimiar Factura"><i class="fas fa-trash-alt"></i></a>';

        }
    } unset($r); 

} else {

if($_SESSION["root_plataforma"] == 0){	
echo '<a id="imprimir-factura" op="86" factura="'.$_POST["search"].'" class="btn-floating btn-lg btn-mdb-color" data-toggle="tooltip" title="Imprimir Factura"><i class="fas fa-print"></i></a>';
} else {
echo '<a href="system/facturar/ticket_web.php?factura='.$_POST["search"].'" class="btn-floating btn-lg btn-mdb-color" data-toggle="tooltip" title="Imprimir Factura"><i class="fas fa-print"></i></a>';
}


echo '<a id="mensaje-borrar" op="80" iden="'.$_POST["search"].'" class="btn-floating btn-lg btn-danger" title="Elimiar Factura"><i class="fas fa-trash-alt"></i></a>

<a id="mensaje-pasar" op="84" iden="'.$_POST["search"].'" class="btn-floating btn-lg btn-warning" title="Cambiar Orden"><i class="fas fa-redo"></i></a>'; 
}


?>


</div>


<div  class="col-sm-6" id="unidades">
 <h3>Detalles de la factura # <?php echo $_POST["search"] ?></h3>
<hr>
<?php 
$search->VerProductosFactura($_POST["search"]);
?>
<!-- <a href="" class="btn btn-danger">Cancelar</a> -->


</div> 


</div>
<?php 
} else {
	Alerts::Mensajex("No se encuentraron registros","danger");
}


 ?>