<?php 
include_once 'system/ventas/Venta.php';
$ventas = new Venta;


if ($r = $db->select("clientes", "mesa", "WHERE mesa = ". $_REQUEST["mesa"]. " and td = " . $_SESSION["td"] . "")) { 
$clientes = $r["clientes"];
} unset($r); 
 ?>
<div class="modal" id="<? echo $_GET["modal"]; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true"  data-backdrop="false">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">
          Modificar Opciones</h5>
      </div>
      <div class="modal-body">
<!-- ./  content -->
<?php if($clientes > 0){ ?>
<div id="ventana"></div>
<div class="row">
    <div class="col-md-6 btn-outline-info z-depth-2" id="origen">
        <?php
        $ventas->VerProductosFactura($_REQUEST['mesa']); 
         ?>
    </div>
    
    <div class="col-md-6 btn-outline-grey z-depth-2" id="destino">
      Seleccione producto a modificar
    </div>
   
</div>
<?php } else { echo "No se encontraron clientes en esta mesa"; } ?>
<!-- ./  content -->
      </div>
      <div class="modal-footer">

        <?php 

          if($_SESSION["delivery_on"] == TRUE){
            $url="?delivery&mesa=" . $_REQUEST["mesa"];
          } elseif($_SESSION['tipo_inicio'] == 2){
            $url="?view&mesa=" . $_REQUEST["mesa"];
          } else {
            $url="?";
          }

         ?>
          
          <a href="<?php echo $url; ?>" class="btn btn-primary btn-rounded">Regresar</a>
    
      </div>
    </div>
  </div>
</div>
