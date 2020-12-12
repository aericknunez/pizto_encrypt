<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

include_once 'application/common/Alerts.php';
include_once 'application/common/Fechas.php';
include_once 'system/corte/Corte.php';
include_once 'system/sync/Sync.php';
$sync = new Sync();
?>
<h1 class="h1-responsive">CORTES PENDIENTES</h1>

<?php if(isset($_REQUEST["msj"])){
    echo '<div class="alert alert-danger">
 Se ha detectado que en los &uacuteltimos dias hubo actividad en el sistema pero por alg&uacutena raz&oacuten no se hubo registro de cortes o respaldos. <br>
 Puede hacer los cortes y respaldos uno a uno en esta secci&oacuten 
</div> ';
} ?>


<div class="row">
    <div class="col-md-12 btn-outline-info z-depth-2" id="origen">
    <h4>Estado de corte de los ultimos 7 dias</h4>
    <?php 
    $sync->ListaCortes();
     ?>
    </div>
    
  
</div>
