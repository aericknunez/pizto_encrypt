<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

include_once 'application/common/Alerts.php';
include_once 'system/corte/Corte.php';
include_once 'system/sync/Sync.php';


?>

<div class="row d-flex justify-content-center">
<?php 
$cortes = new Corte;
if($cortes->VerificaApertura() == 0){
 ?>

<div class="col-md-6" id="contenido">
  <h3>APERTURA DE CAJA</h3>
  <?php 
    Alerts::Mensajex("Verifique que la cantidad de dinero sea la correcta antes de continuar: <br><strong>" . Helpers::Dinero($cortes->UltimoEfectivo()). "</strong>","info", '<a id="apertura" class="btn btn-success waves-effect waves-light">Confirmar y continuar</a>');
   ?>
</div>
<?php 
} else {
      Alerts::Mensajex("Existe una caja aperturada.","info", '<a href="?" class="btn btn-success waves-effect waves-light">Continuar</a>');
}

 ?>
</div>