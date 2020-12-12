<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

include_once 'application/common/Alerts.php';
include_once 'system/reportes/Reporte.php';
include_once 'system/historial/Historial.php';

$reporte = new Reporte;
$mes = date("m");
$ano = date("Y");
?>
<div id="msj"></div>

  <div class="row justify-content-md-center">
    <div class="col-12 col-md-auto">
        <form name="form-contadora" method="post" id="form-contadora">
    
        <div class="form-row mb-4">
        <div class="col">
            <select class="browser-default custom-select mb-3" id="mes" name="mes">
            <option value="0" disabled >Mes</option>
            <option <?php if($mes == "01") echo "selected"; ?> value="01">Enero</option>
            <option <?php if($mes == "02") echo "selected"; ?> value="02">Febrero</option>
            <option <?php if($mes == "03") echo "selected"; ?> value="03">Marzo</option>
            <option <?php if($mes == "04") echo "selected"; ?> value="04">Abril</option>
            <option <?php if($mes == "05") echo "selected"; ?> value="05">Mayo</option>
            <option <?php if($mes == "06") echo "selected"; ?> value="06">Junio</option>
            <option <?php if($mes == "07") echo "selected"; ?> value="07">Julio</option>
            <option <?php if($mes == "08") echo "selected"; ?> value="08">Agosto</option>
            <option <?php if($mes == "09") echo "selected"; ?> value="09">Septiembre</option>
            <option <?php if($mes == "10") echo "selected"; ?> value="10">Octubre</option>
            <option <?php if($mes == "11") echo "selected"; ?> value="11">Noviembre</option>
            <option <?php if($mes == "12") echo "selected"; ?> value="12">Diciembre</option>
          </select> 
        </div>
        <div class="col">
            <select class="browser-default custom-select mb-3" id="ano" name="ano">
            <option value="0" disabled >Año</option>
            <option <?php if($ano == "2019") echo "selected"; ?> value="2019">2019</option>
            <option <?php if($ano == "2020") echo "selected"; ?> value="2020">2020</option>
            <option <?php if($ano == "2021") echo "selected"; ?> value="2021">2021</option>
            <option <?php if($ano == "2022") echo "selected"; ?> value="2022">2022</option>
            <option <?php if($ano == "2023") echo "selected"; ?> value="2023">2023</option>
            <option <?php if($ano == "2024") echo "selected"; ?> value="2024">2024</option>
            <option <?php if($ano == "2025") echo "selected"; ?> value="2025">2025</option>
          </select> 
        </div>    
  </div>  

	<input name="btn-contadora" type="submit" id="btn-contadora" value="Mostrar datos" class="btn btn-outline-info btn-rounded btn-sm btn-block waves-effect">
      </form> 
    </div>
  </div>
<div class="row justify-content-md-center" id="loaderx">
	<img src="assets/img/loading.gif" alt=""></div>
<div id="contenido">
  <?php 
  $reporte->Contadora($mes, $ano);
 ?>

</div>
