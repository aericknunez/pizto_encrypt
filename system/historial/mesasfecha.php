<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

include_once 'application/common/Alerts.php';
include_once 'system/mesashoy/Mesas.php';
?>

<form name="form-fechas" method="post" id="form-fechas">
  <div class="row justify-content-md-center">
    <div class="col-12 col-md-auto">     
    <input placeholder="Seleccione una fecha" type="text" id="fecha" name="fecha" class="form-control datepicker my-2">
    <label for="fecha">Fecha a buscar</label>
    </div>
  </div>
    <div class="row justify-content-md-center">   
	<input name="btn-fechas" type="submit" id="btn-fechas" value="Mostrar datos" class="btn btn-info my-2 btn-rounded btn-sm waves-effect">
  </div>     
</form> 


<div class="row justify-content-md-center" id="loaderx">
	<img src="assets/img/loading.gif" alt=""></div>

<div id="contenido">
</div>



<!-- Ver producto -->
<div class="modal" id="ModalVer" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true"  data-backdrop="false">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">
         DETALLES DE LA MESA</h5>
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