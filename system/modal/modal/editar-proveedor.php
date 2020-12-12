<div class="modal" id="<? echo $_GET["modal"]; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true"  data-backdrop="false">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">
          Editar Proveedor</h5>
      </div>
      <div class="modal-body">
<!-- ./  content -->
<?php if($_REQUEST["key"] != NULL){ 
  $key = $_REQUEST["key"];
  if ($r = $db->select("*", "proveedores", "WHERE hash = '$key' and td = ".$_SESSION["td"]."")) { 

$hash = $r["hash"];
$nombre = $r["nombre"];
$documento = $r["documento"];  
$registro = $r["registro"];
$direccion = $r["direccion"]; 
$municipio = $r["municipio"];
$departamento = $r["departamento"]; 
$giro = $r["giro"];
$telefono = $r["telefono"]; 
$email = $r["email"];
$contacto = $r["contacto"]; 
$tel_contacto = $r["tel_contacto"]; 
$comentarios = $r["comentarios"]; 
  }  unset($r); ?>

<div id="destinoproveedor">
  
</div>

<form id="form-editproveedor">
  
  <div class="form-row">

<input type="hidden" id="hash" name="hash" value="<?php echo $hash; ?>">
  <div class="col-md-8 mb-2 md-form">
      <label for="nombre">* Nombre</label>
      <input type="text" class="form-control" id="nombre" name="nombre" value="<?php echo $nombre; ?>">
    </div>

    <div class="col-md-4 mb-2 md-form">
      <label for="documento">* Documento</label>
      <input type="text" class="form-control" id="documento" name="documento" value="<?php echo $documento; ?>">
    </div>

  </div>


  <div class="form-row">

    <div class="col-md-6 mb-2 md-form">
      <label for="registro">Registro</label>
      <input type="text" class="form-control" id="registro" name="registro" value="<?php echo $registro; ?>">
    </div>

    <div class="col-md-6 mb-2 md-form">
      <label for="giro">* Giro</label>
      <input type="text" class="form-control" id="giro" name="giro" value="<?php echo $giro; ?>">
    </div>

  </div>


  <div class="form-row">

  <div class="col-md-12 mb-2 md-form">
      <label for="direccion">* Direcci&oacuten</label>
      <input type="text" class="form-control" id="direccion" name="direccion" value="<?php echo $direccion; ?>">
    </div>

  </div>


  <div class="form-row">

    <div class="col-md-6 mb-2 md-form">
      <label for="departamento">Departamento</label>
      <input type="text" class="form-control" id="departamento" name="departamento" value="<?php echo $departamento; ?>">
    </div>

  <div class="col-md-6 mb-2 md-form">
      <label for="municipio">Municipio</label>
      <input type="text" class="form-control" id="municipio" name="municipio" value="<?php echo $municipio; ?>">
    </div>

  </div>


  <div class="form-row">


  <div class="col-md-6 mb-2 md-form">
      <label for="telefono">* Tel&eacutefono</label>
      <input type="text" class="form-control" id="telefono" name="telefono" value="<?php echo $telefono; ?>">
    </div>

    <div class="col-md-6 mb-2 md-form">
      <label for="email">Email</label>
      <input type="text" class="form-control" id="email" name="email" value="<?php echo $email; ?>">
    </div>

  </div>



  <div class="form-row">

  <div class="col-md-6 mb-2 md-form">
      <label for="contacto">Nombre Contacto</label>
      <input type="text" class="form-control" id="contacto" name="contacto" value="<?php echo $contacto; ?>">
    </div>

  <div class="col-md-6 mb-2 md-form">
      <label for="tel_contacto">* Tel&eacutefono Contacto</label>
      <input type="text" class="form-control" id="tel_contacto" name="tel_contacto" value="<?php echo $tel_contacto; ?>">
    </div>


  </div>



  <div class="form-row">

    <div class="col-md-12 mb-1 md-form">
      <textarea id="comentarios" name="comentarios" class="md-textarea form-control" rows="3"> <?php echo $comentarios; ?></textarea>
      <label for="comentarios">Comentarios..</label>
    </div>

  </div>



  <div class="form-row">
    <div class="col-md-12 my-6 md-form text-center">
     <button class="btn btn-info my-4" type="submit" id="btn-editproveedor"><i class="fa fa-save mr-1"></i> Guardar</button>

    </div>
  </div>

</form>

<!-- TERMINA FORMULARIO PRINCIPAL -->
<? } ?>
<!-- ./  content -->
      </div>
      <div class="modal-footer">

          <a href="?proveedorver" class="btn btn-primary btn-rounded">Regresar</a>
    
      </div>
    </div>
  </div>
</div>
<!-- ./  Modal -->