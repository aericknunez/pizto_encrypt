<div class="modal" id="<? echo $_GET["modal"]; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true"  data-backdrop="false">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">
          Editar Empleado</h5>
      </div>
      <div class="modal-body">
<!-- ./  content -->
<?php if($_REQUEST["key"] != NULL){ 
  $key = $_REQUEST["key"];
  if ($r = $db->select("*", "planilla_empleados", "WHERE hash = '$key' and td = ".$_SESSION["td"]."")) { 

$hash = $r["hash"];
$nombre = $r["nombre"];
$puesto = $r["puesto"];
$documento = $r["documento"];  
$nit = $r["nit"]; 
$direccion = $r["direccion"]; 
$telefono = $r["telefono"]; 
$sueldo = $r["sueldo"];
$entradas = $r["entradas"]; 
$extras = $r["extras"];
$nocturnas = $r["nocturnas"]; 
$comentarios = $r["comentarios"]; 
  }  unset($r); ?>

<div id="contenido">
  
</div>

<form id="form-editempleado">
   <div class="form-row">
<input type="hidden" id="hash" name="hash" value="<?php echo $hash; ?>">

  <div class="col-md-8 mb-2 md-form">
      <label for="nombre">* Nombre</label>
      <input type="text" class="form-control" id="nombre" name="nombre" value="<?= $nombre ?>">
    </div>

    <div class="col-md-4 mb-2 md-form">
      <label for="documento">* Documento</label>
      <input type="text" class="form-control" id="documento" name="documento" value="<?= $documento ?>">
    </div>

  </div>


  <div class="form-row">

   <div class="col-md-4 mb-2 md-form">
      <label for="telefono">* Tel&eacutefono</label>
      <input type="text" class="form-control" id="telefono" name="telefono" value="<?= $telefono ?>">
    </div>

    <div class="col-md-8 mb-2 md-form">
      <label for="direccion">* Direcci&oacuten</label>
      <input type="text" class="form-control" id="direccion" name="direccion" value="<?= $direccion ?>">
    </div>

  </div>


  <div class="form-row">

    <div class="col-md-6 mb-2 md-form">
      <label for="nit">NIT</label>
      <input type="text" class="form-control" id="nit" name="nit" value="<?= $nit ?>">
    </div>

  <div class="col-md-6 mb-2 md-form">
      <label for="puesto">Puesto</label>
      <input type="text" class="form-control" id="puesto" name="puesto" value="<?= $puesto ?>">
    </div>

  </div>


 

  <div class="form-row">

    <div class="col-md-6 mb-2 md-form">
      <label for="sueldo">Sueldo</label>
      <input type="number" step="any" class="form-control" id="sueldo" name="sueldo" value="<?= $sueldo ?>">
    </div>

  <div class="col-md-6 mb-2 md-form">
        <div class="switch">
            <label>
             Entradas ||  Off
              <input type="checkbox" id="entradas" name="entradas" disabled>
              <span class="lever"></span> On 
            </label>
          </div>
    </div>

  </div>


  <div class="form-row">

    <div class="col-md-6 mb-2 md-form">
        <div class="switch">
            <label>
             Extra ||  Off
              <input type="checkbox" id="extra" name="extra" disabled>
              <span class="lever"></span> On 
            </label>
          </div>
    </div>

  <div class="col-md-6 mb-2 md-form">
          <div class="switch">
            <label>
             Nocturnas ||  Off
              <input type="checkbox" id="nocturnas" name="nocturnas" disabled>
              <span class="lever"></span> On 
            </label>
          </div>
    </div>

  </div>


  <div class="form-row mt-4">

    <div class="col-md-12 mb-1 md-form">
      <textarea id="comentarios" name="comentarios" class="md-textarea form-control" rows="3"> <?= $comentarios ?></textarea>
      <label for="comentarios">Comentarios..</label>
    </div>

  </div>


  <div class="form-row">
    <div class="col-md-12 my-6 md-form text-center">
     <button class="btn btn-info my-1" type="submit" id="btn-editempleado"><i class="fas fa-save mr-1"></i> Guardar</button>

    </div>
  </div>

</form>

<!-- TERMINA FORMULARIO PRINCIPAL -->
<? } ?>
<!-- ./  content -->
      </div>
      <div class="modal-footer">

          <a href="?verempleado" class="btn btn-primary btn-rounded">Regresar</a>
    
      </div>
    </div>
  </div>
</div>
<!-- ./  Modal -->