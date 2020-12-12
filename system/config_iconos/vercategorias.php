<a href="?modal=addcat" class="btn btn-indigo btn-md">Nueva Categoria<i class="fas fa-user-alt ml-2"></i></a>
Categorias existentes:
<div class="row text-center portfolio"> 
   <ul class="gallery"> 
<?php 

  $d = $db->selectGroup("img_name, cod", "images", "where cod > '999' and td = ".$_SESSION["td"]." order by img_order asc");
    if ($d->num_rows > 0) {
        while($r = $d->fetch_assoc() ) {

    if ($n = $db->select("id, categoria", "categorias", "where cod=".$r["cod"]." and td = ".$_SESSION["td"]."")) { 
        
        echo "<li><a href='?modal=modcategoria&cod=".$r["cod"]."&name=" . $n["categoria"] . "&img=". $r["img_name"] ."'><em>" . $n["categoria"] . "</em><img src='". $r["img_name"] ."' alt='image' class='img-fluid img-responsive wow fadeIn' /></a></li>";
    } 
            unset($r);
        }
    }
$d->close();


 ?>


   </ul> 
</div>