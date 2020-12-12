<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

include_once 'application/common/Alerts.php';
include_once 'system/facturar/Facturar.php';
$facturar = new Facturar; 

?>


<div class="row d-flex justify-content-center">
  <div class="col-sm-6">

<h3>ESTABLECER PROPINA</h3>

<form id="form-propina" name="form-propina">
 

<div id="resultado">

     <div class="justify-content-center">
      <div class="col-xs-2">
        <label for="ex1">Actualmente hay una propina establecida de <?php echo $_SESSION['config_propina']; ?> %</label>
        <input name="propina" type="number" id="propina" size="8" maxlength="8" class="form-control" placeholder="0.00" step="any" required autofocus />
      </div>
    </div>

    <div class="justify-content-center">
      <button class="btn btn-info my-4" type="submit" id="btn-propina" name="btn-propina">Establecer Propina</button>
    </div>

</div>

    </form>

  </div>
</div>
