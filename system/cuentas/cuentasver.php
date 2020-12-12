<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

include_once 'application/common/Alerts.php';
include_once 'system/cuentas/Cuentas.php';
$cuenta = new Cuentas(); 
?>

<div id="msj"></div>

<div class="clearfix">
  <h2 class="h2-responsive float-left">CUENTAS POR PAGAR</h2> 
  <h2 class="h2-responsive float-right"><a id="addcuenta" class="btn-floating btn-info btn-sm mb-3" title="Nueva Cuenta"><i class="fas fa-plus"></i></a></h2>
</div>




<div id="contenido">
   <?php $cuenta->VerCuentas(1, "id", "desc"); ?>
</div>




<!-- Nueva cuenta -->
<div class="modal" id="ModalAddCuenta" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true"  data-backdrop="false">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">
         NUEVA CUENTA</h5>
      </div>
      <div class="modal-body">
<!-- ./  content -->

<?php 
    $a = $db->query("SELECT hash, nombre FROM proveedores WHERE td = ".$_SESSION["td"]."");

?>  
  <form id="form-cuenta">

  <div class="form-row">
    
    <div class="col-md-4 mt-0 md-form">
      <select class="mdb-select md-form colorful-select dropdown-dark" id="proveedor" name="proveedor">
        <option selected disabled>Proveedor</option>
        <?php foreach ($a as $b) {
        echo '<option value="'. $b["hash"] .'">'. $b["nombre"] .'</option>'; 
        } $a->close(); ?>
      </select>
    </div>

  <div class="col-md-8 mb-0 md-form">
      <label for="cuenta">* Nombre de la Cuenta</label>
      <input type="text" class="form-control" id="cuenta" name="cuenta" required>
    </div>

  </div>



    <div class="form-row">
    
    <div class="col-md-12 mt-0 md-form">
      <textarea id="detalles" name="detalles" class="md-textarea form-control" rows="3"></textarea>
      <label for="detalles">Detalles</label>
    </div>

  </div>




  <div class="form-row">
    
    <div class="col-md-4 mb-1 md-form">
      <label for="factura">* Factura</label>
      <input type="number" step="any" class="form-control" id="factura" name="factura" required>
    </div>

    <div class="col-md-4 mb-1 md-form">
      <label for="total">* Total</label>
      <input type="number" class="form-control" id="total" name="total" required>
    </div>
  
    <div class="col-md-4 mt-3 md-form">
          <input placeholder="Fecha Limite" type="text" id="fecha_limite" name="fecha_limite" class="form-control datepicker my-2">
    </div>

  </div>




  <div class="form-row mt-5">
    <div class="col-md-12 md-form text-center">
     <button class="btn btn-info" type="submit" id="btn-cuenta"><i class="fas fa-save mr-1"></i> Guardar</button>

    </div>
  </div>

</form>

<!-- ./  content -->
      </div>
      <div class="modal-footer">

<a id="cerrarmodal" class="btn btn-primary btn-rounded" data-dismiss="modal">Regresar</a>

          
    
      </div>
    </div>
  </div>
</div>
<!-- ./  Modal -->















<!-- modal para ver el cuenta -->
<div class="modal" id="ModalVerCuenta" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true"  data-backdrop="false">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">
         CUENTA POR COBRAR</h5>
      </div>
      <div class="modal-body">
<!-- ./  content -->

<div id="vista_ver"></div>

<!-- ./  content -->
      </div>
      <div class="modal-footer">

<!-- <a href="?modal=abonos<?php echo $url; ?>" class="btn btn-secondary btn-rounded">Realizar Abonos</a> -->
<a id="cerrarver" class="btn btn-primary btn-rounded" data-dismiss="modal">Regresar</a>

          
    
      </div>
    </div>
  </div>
</div>
<!-- ./  Modal -->



<!-- MODAL PARA CONFIRMAR ELIMINACION -->

<div class="modal fade" id="ConfirmDelete" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
  aria-hidden="true">
  <div class="modal-dialog modal-sm modal-notify modal-danger" role="document">
    <!--Content-->
    <div class="modal-content text-center">
      <!--Header-->
      <div class="modal-header d-flex justify-content-center">
        <p class="heading">Seguro que desea eliminar este elemento?</p>
      </div>

      <!--Body-->
      <div class="modal-body">

        <i class="fas fa-times fa-4x animated rotateIn"></i>

      </div>

      <!--Footer-->
      <div class="modal-footer flex-center">
        <a id="borrar-cuenta" class="btn  btn-outline-danger">Eliminar</a>
        <a type="button" class="btn  btn-danger waves-effect" data-dismiss="modal">No</a>
      </div>
    </div>
    <!--/.Content-->
  </div>
</div>
<!--Modal: modalConfirmDelete-->

