<div class="modal" id="<? echo $_GET["modal"]; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true"  data-backdrop="false">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">
          Realizar Corte del dia <?php echo $_REQUEST["fecha"]; ?></h5>
      </div>
      
      <div class="modal-body">
<!-- ./  content -->
<h2 align="center">Ha ocurrido un error, de momento &eacutesta opci&oacuten est&aacute deshabilitada</h2>

<div class="text-danger text-center">Para realizar el corte pendiente, cambie la fecha a su computadora y realice el corte normalmente</div>
<!-- ./  content -->
      </div>
      <div class="modal-footer">

          <a href="?respaldos" class="btn btn-primary btn-rounded">Regresar</a>
    
      </div>
    </div>
  </div>
</div>
<!-- ./  Modal -->