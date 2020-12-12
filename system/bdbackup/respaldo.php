<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

include_once 'system/bdbackup/Backup.php';
include_once 'application/common/Encrypt.php';

$back = new BackUp();
?>

<div class="row d-flex justify-content-center">
  <div class="col-md-8">



<div class="text-center">
	<h1 class="h1-responsive">CREAR RESPALDO DE SUS DATOS</h1>
	<div id="vista"></div>

	<div id="pendientes" class="mt-4">
	</div>
	<div id="respaldos" class="mt-4">
	</div>

</div>




  </div>
</div>