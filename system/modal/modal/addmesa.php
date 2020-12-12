<div class="modal bounceIn" id="<? echo $_GET["modal"]; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true"  data-backdrop="false">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">
         Agregar nueva mesa</h5>
      </div>
      <div class="modal-body">
<!-- ./  content -->
 <?php 
if($_SESSION["nclientes"] == NULL){
  $_SESSION["nclientes"] = 1;
}
?>   
     <div class="d-flex justify-content-center">
<div class="shadow-box-example z-depth-4 flex-center "> 
<p class="black-text display-1" id="numero">
  <?php echo $_SESSION["nclientes"]; ?>
</p>
</div>
     </div>

<br>

 <div class="d-flex justify-content-center">
        <div class="btn-group radio-group ml-2">
        <a id="cambiar" op="41" class="btn btn-sm btn-primary btn-rounded waves-effect waves-light"><strong>—</strong></a>
        <a id="cambiar" op="40" class="btn btn-sm btn-primary btn-rounded waves-effect waves-light active"><strong>+</strong></a>
   
        </div>
</div>



<form class="text-center" id="form-addmesa" name="form-addmesa">
   

<div class="row justify-content-center mt-4">
<div class="col-md-6">
    <select class="browser-default custom-select mb-3" id="nmesa" name="nmesa">
<option value="" selected>SELECCIONE</option>
<?php 

    for ($i = 1; $i <= $_SESSION["config_o_no_mesas"]; $i++) {          
        echo '<option value="MESA # '.$i.'">MESA # '.$i.'</option>';
        }
 ?>
</select>
</div>
</div>

<br><br>
<!-- <div class="d-flex justify-content-center">
<a href="application/src/routes.php?op=42" class="btn btn-default btn-rounded">Aceptar</a>
</div> -->
<div id="contenido"></div>
<div class="d-flex justify-content-center">
<button class="btn btn-default btn-rounded" type="submit" id="btn-addmesa" name="btn-addmesa">Aceptar</button>
</div>
 </form>

<!-- ./  content -->
      </div>
      <div class="modal-footer">

    <a href="application/src/routes.php?op=43" class="btn btn-primary btn-rounded">Regresar</a>
    
      </div>
    </div>
  </div>
</div>
<!-- ./  Modal -->