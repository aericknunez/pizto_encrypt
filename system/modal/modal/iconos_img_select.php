<?php 

include_once 'system/config_iconos/Icono.php';
$iconos = new Icono;


$op=$_REQUEST["op"];

$nombres=$_POST["nombre"];
$cod=$_POST["codigo"];
$cat=$_POST["categoria"];
$popup=$_POST["popup"];

$canti=$_POST["cantidad"];
$preci=$_POST["precio"];
$opcion=$_POST["opcion"];



$opciones='id="iconos" op="' . $op .'" nombre="'.$nombres.'" cod="'.$cod.'" cat="'.$cat.'" popup="'.$popup.'" canti="'.$canti.'" preci="'.$preci.'" opcion="'.$opcion.'"';

if($_SESSION["opcionesx"] == NULL){
$_SESSION["opcionesx"] = $opciones;
}
?>
<div class="modal" id="<? echo $_GET["modal"]; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true"  data-backdrop="false">
  <div class="modal-dialog modal-fluid" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">
          Seleccione una imagen para el producto 
          <a href="?modal=selectimg&cat="><span class="badge cyan">Todas</span></a>
          <?php 
                    $a = $db->query("SELECT * FROM login_images_categoria");
                    foreach ($a as $b) {
                      echo ' <a href="?modal=selectimg&cat='. $b["id"] .'"><span class="badge cyan">'. $b["categoria"] .'</span></a>';
                    } $a->close();

          ?>
          <a href="?modal=selectimg&cat=0"><span class="badge red">Sin Categoria</span></a>
        </h5>
      </div>
      <div class="modal-body">
<!-- ./  content -->

 <div id="iconoinfo"></div>  
<div class="row text-center portfolio"> 
    
<?

echo ' <div id="mostrariconos">
<ul class="gallery">';
$iconos->MostrarIconos($_REQUEST["cat"],$_SESSION["opcionesx"]);
echo '
</ul>
</div> ';
// $images = glob("assets/img/ico/*.*");  
//       foreach($images as $image)  
//       {  
//     $opciones='id="iconos" op="' . $op .'" nombre="'.$nombres.'" cod="'.$cod.'" cat="'.$cat.'" popup="'.$popup.'" imagen="'.$image.'" canti="'.$canti.'" preci="'.$preci.'" opcion="'.$opcion.'"';
//    $output .= '<li><a ' . $opciones .'><img src="' . $image .'" alt="image" class="img-fluid img-responsive wow fadeIn" /></a></li>';

//       }  
//       echo $output;
?>

 
</div>

<!-- ./  content -->
      </div>
      <div class="modal-footer">

          <a href="?iconos" class="btn btn-primary btn-rounded">Regresar</a>
    
      </div>
    </div>
  </div>
</div>
<!-- ./  Modal -->