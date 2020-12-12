<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

include_once 'application/common/Alerts.php';
include_once 'system/gastos/Gasto.php';
$gasto = new Gastos();

include_once 'system/corte/Corte.php';
$cut = new Corte();
if($cut->VerificaApertura() == 1){ // comprobacion de corte
?>

<div class="row d-flex justify-content-center">
  <div class="col-md-6">
<h3>ENTRADAS DE EFECTIVO</h3>

<form class="text-center border border-light p-3" id="form-entradas" name="form-entradas">

Descripci&oacuten
<textarea type="text" id="descripcion" name="descripcion" class="form-control mb-3"></textarea>

<input type="number" step="any" id="cantidad" name="cantidad" class="form-control mb-3" placeholder="Cantidad">
<button class="btn btn-info my-4" type="submit" id="btn-entradas" name="btn-entradas">Agregar Efectivo</button>
 </form>

  </div>


</div>

<hr>
<div  class="col-sm-12" id="contenido">
 <?php 
  $gasto->VerEntradas();
   ?>
</div> 







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
        <a id="borrar-efectivo" class="btn  btn-outline-danger">Eliminar</a>
        <a type="button" class="btn  btn-danger waves-effect" data-dismiss="modal">No</a>
      </div>
    </div>
    <!--/.Content-->
  </div>
</div>
<!--Modal: modalConfirmDelete-->



<?php 
} else { /// termina comprobacion de corte
	Alerts::CorteEcho("Ingresos de efectivo");
}
 ?>