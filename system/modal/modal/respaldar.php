<?php 
if($_REQUEST["fecha"] == NULL){
$text1 = "REALIZANDO CORTE";
$text2 = "POR FAVOR ESPERE, NO CIERRE EL SISTEMA SE ESTA REALIZANDO EL CORTE";
} else {
$text1 = "REALIZANDO RESPALDO";
$text2 = "POR FAVOR ESPERE, NO CIERRE EL SISTEMA SE ESTA REALIZANDO EL RESPALDO";  
}

 ?>
<div class="modal" id="<? echo $_GET["modal"]; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true"  data-backdrop="false">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">
          <?php echo $text1; ?></h5>
      </div>
      <div class="modal-body">
<!-- ./  content -->

       <div align="center">   
        <img src="assets/img/cloud1.gif" alt="">
        <br>
        <?php echo $text2; ?>
        </div> 

      <div id="respaldo"></div>


<!-- ./  content -->
      </div>
<!--       <div class="modal-footer">
          <a href="?iconos" class="btn btn-primary btn-rounded">Regresar</a>
    
      </div> -->
    </div>
  </div>
</div>
<!-- ./  Modal -->