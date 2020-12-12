<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

include_once 'system/config_iconos/Icono.php';
$iconos = new Icono;
?>


<ul class="nav nav-tabs md-tabs" id="myTabMD" role="tablist">
  <li class="nav-item">
    <a class="nav-link active" id="home-tab-md" data-toggle="tab" href="#home-md" role="tab" aria-controls="home-md" aria-selected="true">Categorias</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" id="profile-tab-md" data-toggle="tab" href="#profile-md" role="tab" aria-controls="profile-md" aria-selected="false">Productos</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" id="contact-tab-md" data-toggle="tab" href="#contact-md" role="tab" aria-controls="contact-md" aria-selected="false">Opciones</a>
  </li>
</ul>


<div class="tab-content card pt-5" id="myTabContentMD">
  
  <div class="tab-pane fade show active" id="home-md" role="tabpanel" aria-labelledby="home-tab-md">
<?php 
include_once 'system/config_iconos/vercategorias.php';
?>

  </div>
  

<div class="tab-pane fade" id="profile-md" role="tabpanel" aria-labelledby="profile-tab-md">
<?php 
include_once 'system/config_iconos/verproductos.php';
?>

  </div>



<div class="tab-pane fade" id="contact-md" role="tabpanel" aria-labelledby="contact-tab-md">

<!-- ///// -->
<div class="row">
  <div class="col-sm-6">

<form class="form-inline md-form mr-auto mb-4" id="form-addopcion" name="form-addopcion">
  <input type="hidden" name="op" id="op" value="10" />
  <input class="form-control mr-sm-2" type="text" placeholder="Nueva Opcion" aria-label="Search" id="nombre" name="nombre">
  <button class="btn btn-default btn-rounded btn-sm my-0" id="btn-addopcion" name="btn-addopcion" type="submit">Agregar</button>
</form>

</div>
<!-- //// -->
<div  class="col-sm-6" id="veropcion">
<?php  
$iconos->VerOpciones();
?>
</div> 


</div>
 <!-- //////// -->

  </div>

</div>
