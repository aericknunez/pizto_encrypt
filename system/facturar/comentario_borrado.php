<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

include_once 'application/common/Alerts.php';
include_once 'system/facturar/Facturar.php';
$facturar = new Facturar; 

?>


<div class="row d-flex justify-content-center">
  <div class="col-sm-6">

<h3>BORRAR ELEMENTO</h3>

<form id="form-borrrarelemento" name="form-borrrarelemento">
 

<div id="resultado">

     <div class="justify-content-center">
      <div class="col-xs-2">
        <label for="ex1">Ingrese el motivo por el cual desea borrar este elemento</label>
        <textarea type="text" id="motivo" name="motivo" class="form-control mb-3"></textarea>
        <input type="hidden" id="tipo" name="tipo" value="<?php echo $_REQUEST["tipo"] ?>">
        <input type="hidden" id="iden" name="iden" value="<?php echo $_REQUEST["iden"] ?>">


      </div>
    </div>

    <div class="justify-content-center">
      <button class="btn btn-info my-4" type="submit" id="btn-borrrarelemento" name="btn-borrrarelemento">BORRAR ELEMENTO</button>
    </div>

</div>

    </form>

  </div>
</div>
