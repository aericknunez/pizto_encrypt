<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
include_once 'application/common/Alerts.php';
include_once 'system/delivery/Llevar.php';
$delivery = new LLevar();

$datalive = TRUE; /// para saber que estoy en index


$_SESSION["mesa"] = $_REQUEST["mesa"];


/// verifico si existe la mesa antes de continuar
$ver_mesa = $db->query("SELECT estado FROM mesa WHERE estado = 1 and mesa = ". $_REQUEST["mesa"]. " and tx = ". $_SESSION["tx"]." and td = ". $_SESSION["td"]."");
if($ver_mesa->num_rows){




/// datos del cliente asignado a este delivery
$delivery->DatosCliente($_REQUEST["mesa"]);
 ?>  

   <?php 
// para saber el estado de la orden
    if ($r = $db->select("edo", "clientes_mesa", "WHERE mesa = ". $_REQUEST["mesa"]. " and tx = ". $_SESSION["tx"]." and td = ". $_SESSION["td"]."")) { 
        $edo = $r["edo"];
    } unset($r); 

 ?> 

 <hr>
<div align="center" id="edoiconos">

<?php 

if($edo == 1 or $edo == NULL){
   
    if(file_exists('application/iconos/iconos_'.$_SESSION["td"].'.php') == TRUE){
    include_once 'application/iconos/iconos_'.$_SESSION["td"].'.php';
    } else {
    echo '<a id="crear-iconos" op="92" class="btn btn-success">Crear Iconos</a>';
    }

} else {
  $delivery->MensajeEdoBlock();
}


 ?>

</div>
<div id="ventana"></div>


<?php 
} else {
 Alerts::Error404("Este pedido ya no existe, posiblemente ha sido cobrado o eliminado!");
} $ver_mesa->close();
 ?>












<!-- Ver agregar delivery -->
<div class="modal" id="ModalVer" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true"  data-backdrop="false">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">
         CLIENTE AL DELIVERY</h5>
      </div>
      <div class="modal-body">
<!-- ./  content -->

<div align="center">
  <div class="col-md-8 z-depth-2 justify-content-center">
      <div class="md-form mt-0">
        <form id="c-busqueda">
        <input class="form-control" type="text" placeholder="Buscar Cliente" aria-label="Search" id="cliente-asig" name="cliente-asig" autofocus>
        </form>
      </div>
  </div>
  <div class="col-md-6 z-depth-2 justify-content-center" id="muestra-asig"></div>
</div>


<!-- ./  content -->
      </div>
      <div class="modal-footer">


<a id="ncliente" class="btn btn-secondary btn-rounded">Nuevo Cliente</a>
<a class="btn btn-primary btn-rounded" data-dismiss="modal">Regresar</a>
         
    
      </div>
    </div>
  </div>
</div>
<!-- ./  Modal -->





<!-- nuevo cliente -->
<div class="modal" id="ModalNliente" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true"  data-backdrop="false">
  <div class="modal-dialog modal-md" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">
         NUEVO CLIENTE</h5>
      </div>
      <div class="modal-body">
<!-- ./  content -->


<form id="form-addclienteasig">
  
  <div class="form-row">

<input type="hidden" id="hash" name="hash" value="<?php echo $hash; ?>">
  <div class="col-md-8 mb-2 md-form">
      <label for="descripcion">* Nombre</label>
      <input type="text" class="form-control" id="nombre" name="nombre" >
    </div>

    <div class="col-md-4 mb-2 md-form">
      <label for="cod">* Documento</label>
      <input type="text" class="form-control" id="documento" name="documento" >
    </div>

  </div>


  <div class="form-row">

 <div class="col-md-6 mb-2 md-form">
      <label for="descripcion">* Tel&eacutefono</label>
      <input type="text" class="form-control" id="telefono" name="telefono" >
    </div>

  <div class="col-md-6 mb-2 md-form">
      <label for="descripcion">* Direcci&oacuten</label>
      <input type="text" class="form-control" id="direccion" name="direccion" >
    </div>

  </div>


  <div class="form-row">

    <div class="col-md-6 mb-2 md-form">
      <label for="cod">Departamento</label>
      <input type="text" class="form-control" id="departamento" name="departamento" >
    </div>

  <div class="col-md-6 mb-2 md-form">
      <label for="descripcion">Municipio</label>
      <input type="text" class="form-control" id="municipio" name="municipio" >
    </div>

  </div>



  <div class="form-row">

    <div class="col-md-6 mb-2 md-form">
      <label for="cod">Email</label>
      <input type="text" class="form-control" id="email" name="email" >
    </div>

  <div class="col-md-6 mb-2 md-form">
      <input placeholder="Fecha de Nacimiento" type="text" id="nacimiento" name="nacimiento" class="form-control datepicker">
    </div>

  </div>

  <div class="form-row">

    <div class="col-md-12 mb-1 md-form">
      <textarea id="comentarios" name="comentarios" class="md-textarea form-control" rows="3"> </textarea>
      <label for="comentarios">Comentarios..</label>
    </div>

  </div>



  <div class="form-row">
    <div class="col-md-12 my-6 md-form text-center">
     <button class="btn btn-info my-4" type="submit" id="btn-addclienteasig"><i class="fa fa-save mr-1"></i> Agregar Cliente</button>

    </div>
  </div>

</form>


<div id="vista"></div>

<!-- ./  content -->
      </div>
      <div class="modal-footer">

<a class="btn btn-primary btn-rounded" data-dismiss="modal">Regresar</a>
         
    
      </div>
    </div>
  </div>
</div>
<!-- ./  Modal -->


















<!-- Ver agregar delivery -->
<div class="modal" id="ModalOpciones" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true"  data-backdrop="false">
  <div class="modal-dialog modal-sm" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">
         OPCIONES</h5>
      </div>
      <div class="modal-body">
<!-- ./  content -->


<div id="vistaopciones">
  
</div>


<!-- ./  content -->
      </div>
      <div class="modal-footer">

<a class="btn btn-primary btn-rounded" data-dismiss="modal">Regresar</a>
         
    
      </div>
    </div>
  </div>
</div>
<!-- ./  Modal -->





<!-- Ver agregar delivery -->
<div class="modal" id="ModalEstado" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true"  data-backdrop="false">
  <div class="modal-dialog modal-sm" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">
         ESTADO</h5>
      </div>
      <div class="modal-body">
<!-- ./  content -->
<div id="vistaestado">
 

</div>
<!-- ./  content -->
      </div>
      <div class="modal-footer">

      <a class="btn btn-primary btn-rounded" data-dismiss="modal">Regresar</a>
         
    
      </div>
    </div>
  </div>
</div>
<!-- ./  Modal -->






<!-- Ver agregar delivery -->
<div class="modal" id="ModalRepartidor" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true"  data-backdrop="false">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">
         AGREGAR REPARTIDOR</h5>
      </div>
      <div class="modal-body">
<!-- ./  content -->


<div align="center">
  <div class="col-md-8 z-depth-2 justify-content-center">
      <div class="md-form mt-0">
        <form id="r-busqueda">
        <input class="form-control" type="text" placeholder="Buscar Repartidor" aria-label="Search" id="repartidor-busqueda" name="repartidor-busqueda" autofocus>
        </form>
      </div>
  </div>
  <div class="col-md-6 z-depth-2 justify-content-center" id="muestra-repartidor"></div>
</div>

<!-- ./  content -->
      </div>
      <div class="modal-footer">


<a id="nrepartidor" class="btn btn-secondary btn-rounded">Nuevo Repartidor</a>
<a class="btn btn-primary btn-rounded" data-dismiss="modal">Regresar</a>
         
    
      </div>
    </div>
  </div>
</div>
<!-- ./  Modal -->





<!-- nuevo repartidor -->
<div class="modal" id="ModalNRepartidor" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true"  data-backdrop="false">
  <div class="modal-dialog modal-md" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">
         NUEVO REPARTIDOR</h5>
      </div>
      <div class="modal-body">
<!-- ./  content -->


<form id="form-addrepartidorasig">
  
  <div class="form-row">
  <div class="col-md-8 mb-2 md-form">
      <label for="descripcion">* Nombre</label>
      <input type="text" class="form-control" id="nombre" name="nombre" >
    </div>

    <div class="col-md-4 mb-2 md-form">
      <label for="cod">* Documento</label>
      <input type="text" class="form-control" id="documento" name="documento" >
    </div>

  </div>


  <div class="form-row">

 <div class="col-md-6 mb-2 md-form">
      <label for="descripcion">* Tel&eacutefono</label>
      <input type="text" class="form-control" id="telefono" name="telefono" >
    </div>

  <div class="col-md-6 mb-2 md-form">
      <label for="descripcion">* Direcci&oacuten</label>
      <input type="text" class="form-control" id="direccion" name="direccion" >
    </div>

  </div>


  <div class="form-row">

    <div class="col-md-12 mb-1 md-form">
      <textarea id="comentarios" name="comentarios" class="md-textarea form-control" rows="3"> </textarea>
      <label for="comentarios">Comentarios..</label>
    </div>

  </div>



  <div class="form-row">
    <div class="col-md-12 my-6 md-form text-center">
     <button class="btn btn-info my-4" type="submit" id="btn-addrepartidorasig"><i class="fa fa-save mr-1"></i> Agregar Repartidor</button>

    </div>
  </div>

</form>


<div id="vistarepartidor"></div>

<!-- ./  content -->
      </div>
      <div class="modal-footer">

<a class="btn btn-primary btn-rounded" data-dismiss="modal">Regresar</a>
         
    
      </div>
    </div>
  </div>
</div>
<!-- ./  Modal -->
