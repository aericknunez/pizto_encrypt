<?php
include_once 'application/common/Alerts.php';
$factura = $_REQUEST["factura"];
include_once 'system/facturar/facturas/'.$_SESSION["td"].'/Impresiones.php';
include_once 'system/facturar/Facturar.php';
require_once 'application/ticket/autoload.php'; // para ticket
      $fact = new Facturar();

?>
<div class="modal" id="<? echo $_GET["modal"]; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true"  data-backdrop="false">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">
          Factura No. <?php echo $factura ?></h5>
      </div>
      <a href="?">
      <div class="modal-body">
<!-- ./  content -->
<?php 
/// verifico si existe la mesa antes de continuar
$ver_mesa = $db->query("SELECT num_fac FROM ticket_temp WHERE num_fac = '$factura' and edo = 1 and tx = ". $_SESSION["tx"]." and td = ". $_SESSION["td"]."");
if($ver_mesa->num_rows){
////



 $a = $db->query("SELECT sum(stotal) , sum(imp), sum(total) FROM ticket_temp WHERE num_fac = '$factura' and tx = ".$_SESSION["tx"]." and td = ".$_SESSION["td"].""); 

    foreach ($a as $b) {
        $stotal=$b["sum(stotal)"];
        $imp=$b["sum(imp)"];
        $total=$b["sum(total)"];
    } $a->close();
//////////////////

/// define las variables finales




    if ($r = $db->select("propina, total", "ticket_propina", "WHERE num_fac = '".$factura."' and tx = ".$_SESSION["tx"]." and td = ".$_SESSION["td"]."")) { 
        $porcentaje = $r["propina"];
        $propina = $r["total"];
    } unset($r); 

if($propina > 0.00){ ///  prara agregarle la propina
 $prop = ' | Propina '.$porcentaje.'% : '. Helpers::Dinero($propina);
 $total = $propina + $total;
}


if($_REQUEST["efectivo"]==NULL){ $efectivo = $total; } else { $efectivo = $_REQUEST["efectivo"];}

$cambio = $efectivo - $total;

echo '<p class="text-center">Sub Total: '. Helpers::Dinero($stotal) .' ||  Impuestos: '. Helpers::Dinero($imp) . $prop .'</p>';

echo '<p class="text-center font-weight-bold">TOTAL:</p>';
echo '<div class="display-4 text-center font-weight-bold">'. Helpers::Dinero($total) .'</div> <hr>';

if($_SESSION['tcredito'] == "on"){

echo '<p class="text-center font-weight-bold">PAGO CON TARJETA DE CREDITO:</p>';
echo '<div class="display-4 text-center font-weight-bold">'. Helpers::Dinero($total) .'</div> <hr>';

echo '<p class="text-center text-danger font-weight-bold">CAMBIO:</p>'; 
echo '<div class="display-4 text-danger text-center font-weight-bold">'. Helpers::Dinero(0) . '</div>'; 
 
} else {
echo '<p class="text-center font-weight-bold">EFECTIVO:</p>';
echo '<div class="display-4 text-center font-weight-bold">'. Helpers::Dinero($efectivo) .'</div> <hr>';

echo '<p class="text-center text-danger font-weight-bold">CAMBIO:</p>'; 
echo '<div class="display-4 text-danger text-center font-weight-bold">'. Helpers::Dinero($cambio) . '</div>'; 
 
}

if($_SESSION["noimprimir"] == NULL){ // sino viene null hay que sacar la factura

//////// verifico si es local o web

$fact->ObtenerEstadoFactura($_REQUEST["efectivo"], $factura);

/// termina local o web

}  /// termina si no es null

    if($_SESSION["noimprimir"] == 1){ unset($_SESSION["noimprimir"]); } /// elimino la opcion de no imprimir
    // elimino los rtn
    if($_SESSION["rtn"] != NULL and $_SESSION["cliente"] != NULL){
        unset($_SESSION["cliente"]);
        unset($_SESSION["rtn"]); }

    // eliminar variabe de tarjeta de credito
      if($_SESSION['tcredito'] == "on"){
        unset($_SESSION['tcredito']); 
      }


      if ($r = $db->select("propina", "config_master", "WHERE td = ".$_SESSION["td"]."")) { 
          $_SESSION['config_propina'] = $r["propina"];
      } unset($r); 
      
///////////// termina factura
} else {
 Alerts::Error404("Este pedido ya no existe, posiblemente ha sido cobrado o eliminado!");
} $ver_mesa->close();
 ?> 


      </div></a>
      <div class="modal-footer">

          <a href="?" class="btn btn-primary btn-rounded">Regresar</a>
    
      </div>
    </div>
  </div>
</div>
<!-- ./  Modal -->