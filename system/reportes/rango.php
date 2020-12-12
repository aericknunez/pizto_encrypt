<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

include_once 'application/common/Alerts.php';
include_once 'system/reportes/Reporte.php';
include_once 'system/historial/Historial.php';

$reporte = new Reporte;
?>

  <div class="row justify-content-md-center">
    <div class="col-12 col-md-auto text-center">
     
        <form name="form-rango" method="post" id="form-rango">
        <?php Alerts::Mensaje("Ingrese la primera y ultima factura a imprimir","success",NULL,NULL); ?>  
      <div class="form-row mb-4">
        <div class="col">
          <input type="text"  id="inicio" name="inicio" class="form-control mb-3" placeholder="Primera Factura">
        </div>
        <div class="col">
          <input type="text"  id="final" name="final" class="form-control mb-3" placeholder="Ultima Factura">
        </div>    
    </div>  

	<input name="btn-rango" type="submit" id="btn-rango" value="Imprimir" class="btn btn-outline-info btn-rounded btn-sm btn-block waves-effect">
      </form> 
    </div>
  </div>


<div class="row justify-content-md-center" id="loaderx">
	<img src="assets/img/cargando.gif" alt="">
</div>
<br>
<div id="contenido">

</div>
