<div class="modal" id="<? echo $_GET["modal"]; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true"  data-backdrop="false">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">
          Agregar Ingredientes que contiene este producto</h5>
      </div>
      <div class="modal-body">
<!-- ./  content -->
<?php 

  if ($r = $db->select("nombre", "producto", "WHERE cod = ".$_REQUEST["cod"]." and td = ".$_SESSION["td"]."")) { 
      echo "<h4>" . $r["nombre"]. "</h4> <hr>";
?>
 
      <form name="form-porciones" method="post" id="form-porciones" class="text-center border border-light p-2">
    
     <select id="producto" name="producto" class="browser-default form-control mb-2" required="yes">
      <option disabled selected>Seleccione un Producto</option>
      <?php 
      $a = $db->query("SELECT iden, nombre FROM pro_dependiente WHERE td = ". $_SESSION["td"] ." ORDER BY id");
      foreach ($a as $b) {
          echo '<option value='. $b["iden"] .'>'. $b["nombre"] .'</option>';
      }
      $a->close();
       ?>
    </select>
     <input type="hidden" name="iden" id="iden" value="<?php echo $_REQUEST["cod"]; ?>">
      <button class="btn btn-info btn-block my-4" name="btn-porciones"  id="btn-porciones" type="submit">Agregar Producto</button>

  </form>

<?
    }
    else {
    echo "No se ha encontrado nungun producto que corresponda al codigo: " . $_REQUEST["cod"];  
    }

?>  
<div id="porciones">
  <?php 
    include_once 'system/productos/Producto.php';
    $productos = new Producto;
    $productos->VerPorcionProducto($_REQUEST["cod"]);
   ?>
</div>
<!-- ./  content -->
      </div>
      <div class="modal-footer">

          <a href="?producto&x=3" class="btn btn-primary btn-rounded">Regresar</a>
    
      </div>
    </div>
  </div>
</div>
<!-- ./  Modal -->