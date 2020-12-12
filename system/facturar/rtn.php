<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

include_once 'application/common/Alerts.php';
include_once 'system/facturar/Facturar.php';
$facturar = new Facturar; 

$doc = $_SESSION['config_nombre_documento'];
?>


<div class="row d-flex justify-content-center">
  <div class="col-sm-6">
<?php 

if(isset($_REQUEST["new"])){
?>
<h3>
<a href="?rtn"class="btn-floating btn-sm blue-gradient"><i class="fas fa-user-alt"></i></a>
<?php echo "NUEVO " . $doc; ?>
</h3>

<form class="text-center border border-light p-3" id="form-rtn" name="form-rtn"> 
<input type="text" id="cliente" name="cliente" autocomplete="off" class="form-control mb-3" placeholder="Cliente">  
<input type="text" id="rtn" name="rtn" autocomplete="off" class="form-control mb-3" placeholder="<?php echo $doc; ?>">
<button class="btn btn-info btn-block my-4" type="submit" id="btn-rtn" name="btn-rtn"><?php echo "Agregar " . $doc; ?></button>
</form>
<? 
} else {
 ?>
<h3>
<a href="?rtn&new" class="btn-floating btn-sm blue-gradient"><i class="fas fa-plus"></i></a>
<?php echo "INGRESAR " . $doc; ?>
</h3>

<form class="text-center border border-light p-3">   
<input type="text" id="search-box-rtn" name="search-box-rtn" autocomplete="off" class="form-control mb-3" placeholder="<?php echo "Ingresar " . $doc; ?>">
</form>
<?php 
}
 ?>
<div id="resultado" class="my-4 text-center">
 <?php 
     $facturar->Rtn();            
  ?> 
</div>

  </div>
</div>
