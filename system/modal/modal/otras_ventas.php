<div class="modal" id="<? echo $_GET["modal"]; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop="false">
  <div class="modal-dialog modal-sm" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">
          OTRAS VENTAS</h5>
      </div>
      <div class="modal-body">
<!-- ./  content -->

<form class="text-center border border-light p-2" method="post" action="application/src/routes.php?op=20x">
    <input type="text" id="producto" name="producto"class="form-control mb-1" placeholder="Producto">
    <input type="number" step="any" id="cantidad" name="cantidad" class="form-control mb-1" placeholder="Cantidad">
    <button class="btn btn-success" type="submit">Agregar</button>
</form>


<!-- ./  content -->
      </div>
      <div class="modal-footer">

          <a href="<?php echo $_SERVER["HTTP_REFERER"]; ?>" class="btn btn-primary btn-rounded">Regresar</a>
    
      </div>
    </div>
  </div>
</div>
<!-- ./  Modal -->