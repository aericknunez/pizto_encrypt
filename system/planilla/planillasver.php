<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
include_once 'application/common/Fechas.php';
include_once 'application/common/Alerts.php';
include_once 'system/planilla/Planilla.php';
$planilla = new Planilla(); 

?>

<div id="msj"></div>
<h2 class="h2-responsive">Todos los empleados</h2>


<div id="contenido">
   <?php $planilla->VerTodosPlanillas(1, "id", "asc"); ?>
</div>

<!-- /// modal ver detalles empleado -->

<div class="modal" id="ModalVerEmpleado" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true"  data-backdrop="false">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">
         DETALLES EMPLEADO</h5>
      </div>
      <div class="modal-body">
<!-- ./  content -->

<div id="vista"></div>

<!-- ./  content -->
      </div>
      <div class="modal-footer">

<a id="imprimir" class="btn-floating btn-sm blue-gradient"><i class="fa fa-print"></i></a>
<a href="" id="btn-pro" class="btn btn-secondary btn-rounded">Modificar Datos</a>
<a id="cerrarmodal" class="btn btn-primary btn-rounded" data-dismiss="modal">Regresar</a>

          
    
      </div>
    </div>
  </div>
</div>
<!-- ./  Modal -->




<!-- /// modal agregar extras empleado -->

<div class="modal" id="ModalExtra" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true"  data-backdrop="false">
  <div class="modal-dialog modal-md" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">
         AGREGAR EXTRAS</h5>
      </div>
      <div class="modal-body">
<!-- ./  content -->


  
  <nav>
    <div class="nav nav-tabs" id="nav-tab" role="tablist">
      <a class="nav-item nav-link active" id="nav-extra-tab" data-toggle="tab" href="#nav-extra" role="tab"
        aria-controls="nav-extra" aria-selected="true">Pagos Extra</a>
      <a class="nav-item nav-link" id="nav-adelantos-tab" data-toggle="tab" href="#nav-adelantos" role="tab"
        aria-controls="nav-adelantos" aria-selected="false">Adelantos</a>
      <a class="nav-item nav-link" id="nav-descuentos-tab" data-toggle="tab" href="#nav-descuentos" role="tab"
        aria-controls="nav-descuentos" aria-selected="false">Descuentos</a>
    </div>
  </nav>
  <div class="tab-content" id="nav-tabContent">

    <div class="tab-pane fade show active" id="nav-extra" role="tabpanel" aria-labelledby="nav-extra-tab">
    <?php Alerts::Mensajex("Agregue la cantidad a apagar extra","info"); ?>
    
      
<form class="text-center border border-light p-3" id="form-extra" name="form-extra">
<input type="hidden"  id="opcion" name="opcion" value="1">
<input type="hidden"  id="eempleado" name="eempleado" class="form-control mb-3" value="">
    
<input type="text"  id="eextra" name="eextra" class="form-control mb-3" placeholder="Descripcion Pago Extra">

<input type="number" step="any" id="ecantidad" name="ecantidad" class="form-control mb-3" placeholder="Cantidad">
<button class="btn btn-info my-4" type="submit" id="btn-extra" name="btn-extra">Agregar Extra</button>
 </form>

<div id="vista-extra"></div>
    
    </div>
    <div class="tab-pane fade" id="nav-adelantos" role="tabpanel" aria-labelledby="nav-adelantos-tab">
   <?php Alerts::Mensajex("Ingrese la cantidad del adelanto","success"); ?>
   

<form class="text-center border border-light p-3" id="form-adelantos" name="form-adelantos">
<input type="hidden"  id="opcion" name="opcion" value="2">
<input type="hidden"  id="aempleado" name="aempleado" class="form-control mb-3" value="">
    
<input type="text"  id="aextra" name="aextra" class="form-control mb-3" placeholder="Descripcion Adelanto">

<input type="number" step="any" id="acantidad" name="acantidad" class="form-control mb-3" placeholder="Cantidad">
<button class="btn btn-secondary my-4" type="submit" id="btn-adelantos" name="btn-adelantos">Agregar Adelanto</button>
 </form>

<div id="vista-adelantos"></div>

    </div>
    <div class="tab-pane fade" id="nav-descuentos" role="tabpanel" aria-labelledby="nav-descuentos-tab">
    <?php Alerts::Mensajex("Agregue la cantidad del descuento a aplicar","danger"); ?>
    
      
<form class="text-center border border-light p-3" id="form-descuentos" name="form-descuentos">
<input type="hidden"  id="opcion" name="opcion" value="3">
<input type="hidden"  id="dempleado" name="dempleado" value="">
    
<input type="text"  id="dextra" name="dextra" class="form-control mb-3" placeholder="Descripcion Descuento">

<input type="number" step="any" id="dcantidad" name="dcantidad" class="form-control mb-3" placeholder="Cantidad">
<button class="btn btn-danger my-4" type="submit" id="btn-descuentos" name="btn-descuentos">Agregar Descuento</button>
 </form>

<div id="vista-descuentos"></div>
    
    </div>

  </div>


<!-- ./  content -->
      </div>
      <div class="modal-footer">

<a id="verextras"  key="" class="btn btn-grey darken-1 btn-rounded">Ver Extras</a>
<a id="cerrarmodal" class="btn btn-primary btn-rounded" data-dismiss="modal">Regresar</a>

          
    
      </div>
    </div>
  </div>
</div>
<!-- ./  Modal -->








<!-- /// modal ver detalles empleado -->

<div class="modal fadeIn" id="ModalVerExtras" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true"  data-backdrop="false">
  <div class="modal-dialog modal-md" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">
         DETALLES EXTRAS</h5>
      </div>
      <div class="modal-body">
<!-- ./  content -->

<div id="vista-extras"></div>

<!-- ./  content -->
      </div>
      <div class="modal-footer">

<a id="cerrarmodal" class="btn btn-primary btn-rounded" data-dismiss="modal">Regresar</a>

        
    
      </div>
    </div>
  </div>
</div>
<!-- ./  Modal -->







<!-- /// modal agregar extras empleado -->

<div class="modal fadeIn" id="ModalAplicar" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true"  data-backdrop="false">
  <div class="modal-dialog modal-md" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">
         AGREGAR FECHAS</h5>
      </div>
      <div class="modal-body">
<!-- ./  content -->

   <?php Alerts::Mensajex("Ingrese las fechas laboradas","success"); ?>
   


  <div class="row justify-content-md-center">
    <div class="col-12 col-md-auto">
        <form name="form-fechas" method="post" id="form-fechas">
    <input placeholder="Seleccione una fecha" type="text" id="fecha1" name="fecha1" class="form-control datepicker my-2">
    <input placeholder="Seleccione una fecha" type="text" id="fecha2" name="fecha2" class="form-control datepicker my-2">

    </div>
  </div>

<input type="hidden"  id="apliempleado" name="apliempleado" class="form-control mb-3" value="">
  

  <div class="row justify-content-md-center">
    <div class="col-12 col-md-auto text-center">
    <button class="btn btn-info my-2 btn-rounded btn-md waves-effect" type="submit" id="btn-fechas" name="btn-fechas">Agregar Fechas</button>
      </form> 
    </div>
  </div>

<!-- ./  content -->
      </div>
      <div class="modal-footer">

<a id="cerrarmodal" class="btn btn-primary btn-rounded" data-dismiss="modal">Regresar</a>

          
    
      </div>
    </div>
  </div>
</div>
<!-- ./  Modal -->