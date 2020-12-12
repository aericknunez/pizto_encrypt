<?php
require_once 'application/ticket/autoload.php'; // para ticket
$mesa = $_REQUEST["mesa"];
$cancela = $_REQUEST["cancela"];

if($cancela != NULL){
 $cancelar = " and cancela = '$cancela'";
} else {
 $cancelar = "";
}
?>
<div class="modal" id="<? echo $_GET["modal"]; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true"  data-backdrop="false">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">
          Mesa No. <?php echo $mesa ?></h5>
      </div>
      <a href="?">
      <div class="modal-body">
<!-- ./  content -->
<?php 
 $a = $db->query("SELECT sum(stotal) , sum(imp), sum(total) FROM ticket_temp WHERE mesa = '$mesa' $cancelar and tx = ".$_SESSION["tx"]." and td = ".$_SESSION["td"].""); 

    foreach ($a as $b) {
        $stotal=$b["sum(stotal)"];
        $imp=$b["sum(imp)"];
        $total=$b["sum(total)"];
    } $a->close();
//////////////////

/// define las variables finales



echo '<p class="text-center">Sub Total: '. Helpers::Dinero($stotal) .' ||  Impuestos: '. Helpers::Dinero($imp) . $prop .'</p>';

echo '<p class="text-center font-weight-bold">SUBTOTAL:</p>';
echo '<div class="display-4 text-center font-weight-bold">'. Helpers::Dinero($total) .'</div> <hr>';

if($_SESSION['config_propina'] != 0.00){ ///  prara agregarle la propina
 $prop = Helpers::Propina($total);
 $total = Helpers::PropinaTotal($total);
}

echo '<p class="text-center font-weight-bold">PROPINA:</p>';
echo '<div class="display-4 text-center font-weight-bold">'. Helpers::Dinero($prop) .'</div> <hr>';

echo '<p class="text-center text-danger font-weight-bold">TOTAL:</p>'; 
echo '<div class="display-4 text-danger text-center font-weight-bold">'. Helpers::Dinero($total) . '</div>'; 


if($_SESSION["tx"] == 0){

    if ($r = $db->select("cx0", "facturar_opciones", "WHERE td = ".$_SESSION["td"]."")) { 
        $cx0 = $r["cx0"]; 
    } unset($r);  

if($cx0 == 1){
    include_once 'system/facturar/facturas/'.$_SESSION["td"].'/Impresiones.php';
    $imprimir = new Impresiones; 

      if($cx0 == 1){
        $imprimir->ImprimirAntes($_REQUEST["efectivo"], $mesa, $cancelar);
      }
}
echo $_REQUEST["efectivo"] . " | ".$mesa . " | ".$cancelar;

} else {
    
    if ($r = $db->select("cx1", "facturar_opciones", "WHERE td = ".$_SESSION["td"]."")) { 
        $cx1 = $r["cx1"];
    } unset($r);  
 
     if($cx1 == 1){
        include_once 'system/facturar/facturas/'.$_SESSION["td"].'/Impresiones.php';
        $imprimir = new Impresiones; 

        if($cx1 == 1){
           $imprimir->ImprimirAntes($_REQUEST["efectivo"], $mesa, $cancelar);
        }

    } 


}




 ?> 


      </div></a>
      <div class="modal-footer">
          <?php if($_REQUEST["cancela"] != NULL){ 
            echo '<a href="?modal=pagar&mesa=' . $_REQUEST["mesa"] . '" class="btn btn-secondary btn-rounded">Continuar </a>';
          } ?>
          <a href="?view&mesa=<? echo $_REQUEST["mesa"];  ?>" class="btn btn-primary btn-rounded">Ir a mesa</a>
    
      </div>
    </div>
  </div>
</div>
<!-- ./  Modal -->