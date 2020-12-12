<div class="modal" id="<? echo $_GET["modal"]; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true"  data-backdrop="false">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">
         SUBIR IMAGEN PARA SU NEGOCIO</h5>
      </div>
      <div class="modal-body">
<!-- ./  content -->

<form id="form-img" name="form-img" class="md-form">

    <div class="file-field">
        <a class="btn-floating blue-gradient mt-0 float-left">
            <i class="fa fa-paperclip" aria-hidden="true"></i>
            <input type="file" id="archivo" name="archivo">
        </a>
        <div class="file-path-wrapper">
           <input class="file-path validate" type="text" placeholder="Agregue su imagen">
        </div>
    </div>

<input type="hidden" id="ancho" name="ancho" value="400">    
<input type="hidden" id="alto" name="alto" value="400"> 

<button class="btn btn-outline-info btn-rounded btn-block z-depth-0 my-4 waves-effect" type="submit" id="btn-img" name="btn-img">Subir Imagen</button>


    </form>
<!--div para visualizar mensajes-->
    
    <div id="result" class="text-center">
      
      <?php 
      include_once 'application/common/ImagenesSuccess.php';
      $Up = new Success;
      $Up->VerImgNegocio("assets/img/logo/");
       ?>
    </div>
<!-- ./  content -->
      </div>
      <div class="modal-footer">
          <a href="?configuraciones" class="btn btn-primary btn-rounded">Regresar</a>
    
      </div>
    </div>
  </div>
</div>
<!-- ./  Modal -->