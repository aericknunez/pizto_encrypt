<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

include_once 'application/common/Alerts.php';
include_once 'system/historial/Historial.php';
?>

  <div class="row justify-content-md-center">
    <div class="col-12 col-md-auto">
        <form name="form-ticket" method="post" id="form-ticket">
    <input placeholder="Seleccione una fecha" type="text" id="fecha1" name="fecha1" class="form-control datepicker my-2">
    <input placeholder="Seleccione una fecha" type="text" id="fecha2" name="fecha2" class="form-control datepicker my-2">

    </div>
  </div>


  <div class="row justify-content-md-center">
    <div class="col-12 col-md-auto text-center">
    <button class="btn btn-info my-2 btn-rounded btn-sm waves-effect" type="submit" id="btn-ticket" name="btn-ticket">Mostra Datos</button>
      </form> 
    </div>
  </div>

<div id="contenido" class="mt-5">
<?php Alerts::Mensajex("Seleccione un rango de fechas a buscar", "info"); ?>
</div>

<div class="row justify-content-md-center" id="loaderx">
  <img src="assets/img/loading.gif" alt=""></div>









<!-- Ver producto -->
<div class="modal" id="ModalVer" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true"  data-backdrop="false">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">
         DETALLES DEL TICKET ELIMINADO</h5>
      </div>
      <div class="modal-body">
<!-- ./  content -->

<div id="vista"></div>

<!-- ./  content -->
      </div>
      <div class="modal-footer">

<a id="cerrarmodal" class="btn btn-primary btn-rounded" data-dismiss="modal">Regresar</a>
         
    
      </div>
    </div>
  </div>
</div>
<!-- ./  Modal -->