<?php 
class ConfigP{

	public function __construct() { 
     } 



///////////////cambiar precios
	public function VerTodosPrecio(){
		$db = new dbConn();

	$a = $db->query("SELECT id, cod, nombre, cat, precio FROM precios WHERE td = ".$_SESSION['td']."");

	if($a->num_rows > 0){
	echo '<table class="table table-sm table-striped">

	   <thead>
	     <tr>
	       <th scope="col">#</th>
	       <th scope="col">Producto</th>
	       <th scope="col">Categoria</th>
	       <th scope="col">Precio</th>
	      <th scope="col">Editar</th>
	     </tr>
	   </thead>

	   <tbody>';

	   	$n=1;
		   foreach ($a as $b) {

		// BUSCO LA CATEGORIA
		if($b["cat"] != 0){
		$r = $db->select("categoria", "categorias", "where cod = ". $b["cat"] ." and td = ".$_SESSION['td'].""); $cate=$r["categoria"]; unset($r); /////
		} else { $cate = "Ninguna"; }

$r = $db->select("img_name", "images", "where cod = ". $b["cod"] ." and td = ".$_SESSION['td']."");
 $img=$r["img_name"]; unset($r);

			echo '<tr>
		       <th scope="row">'. $n++ . '</th>
		       <td>'. $b["nombre"] . '</td>
		       <td>'. $cate . '</td>
		       <td>'. $b["precio"] . '</td>
		       <td>
		       
		       <a id="c_precio" cod="'.$b["cod"].'" pre="'.$b["precio"].'" pro="'.$b["nombre"].'" title="Cambiar Precio" data-toggle="tooltip" data-placement="top"><i class="fa fa-money-bill-alt red-text fa-lg"></i></a>

		       <a id="c_opciones" cod="'.$b["cod"].'" pro="'.$b["nombre"].'" class="ml-3" title="Modificar Opciones" data-toggle="tooltip" data-placement="top"><i class="fas fa-utensils blue-text fa-lg"></i></a>


		       <a id="c_icono" cod="'.$b["cod"].'" pro="'.$b["nombre"].'" img="'.$img.'" class="ml-3" title="Modificar Icono" data-toggle="tooltip" data-placement="top"><i class="fas fa-images green-text fa-lg"></i></a


		       </td>
		     </tr>';
		 

		    }
		   $a->close();

		echo '</tbody>
		</table>';
		} else {
			Alerts::Mensajex("No se encontraron registros","danger");
		}
	}




public function CambiarPrecio($data){
		$db = new dbConn();

		$cambio = array();
	    $cambio["precio"] = $data["precio"];	    
	    if (Helpers::UpdateId("precios", $cambio, "cod = '".$data["cod"]."' and td = ".$_SESSION["td"]."")) {
	        Alerts::Alerta("success","Realiado!","Registros actualizados correctamente");
	    } else {
	       Alerts::Alerta("error","Error!","Ocurrio un error desconocido!");   
	    }
	    $this->VerTodosPrecio();

	}





public function VerOpcionesActivas($cod){
	$db = new dbConn();



	$a = $db->query("SELECT nombre, cod FROM opciones WHERE td = ".$_SESSION['td']."");

	if($a->num_rows > 0){
	echo '<table class="table table-sm table-striped">

	   <thead>
	     <tr>
	       <th scope="col">Opción</th>
	       <th scope="col">Estado</th>
	       <th scope="col">Opción</th>
	     </tr>
	   </thead>

	   <tbody>';

		   foreach ($a as $b) {

		$ax = $db->query("SELECT * FROM opciones_asig WHERE producto = '".$cod."' and opcion = '".$b["cod"]."' and td = ".$_SESSION['td']."");
		$num = $ax->num_rows;
		$ax->close();

		if($num == 0){
			$edo = '<div class="text-danger font-weight-bold">Inactivo</div>';
			$btn = '<a id="cambiarop" producto="'.$cod.'" opcion="'.$b["cod"].'" tipo="1" class="ml-3"><i class="fas fa-check green-text fa-lg"></i></a>';
		} else {
			$edo = '<div class="text-success font-weight-bold">Activo</div>';
			$btn = '<a id="cambiarop" producto="'.$cod.'" opcion="'.$b["cod"].'" tipo="0" class="ml-3"><i class="fas fa-ban red-text fa-lg"></i></a>';
		}

			echo '<tr>
		       <td>'. $b["nombre"] . '</td>
		       <td>'. $edo . '</td>
		       <td>'. $btn . '</td>
		     </tr>';
		 

		    }
		   $a->close();

		echo '</tbody>
		</table>';
		} else {
			Alerts::Mensajex("No se encontraron registros","danger");
		}

}




public function CambiarOpcion($data){
		$db = new dbConn();

// si tipo == 0 borro la opcion
if($data["tipo"] == 0){
    if (Helpers::DeleteId("opciones_asig", "opcion='".$data["opcion"]."' and producto='".$data["producto"]."' and td = ".$_SESSION['td']."")) {
       Alerts::Alerta("success","Eliminado!","Opción eliminada correctamente!");
    } else {
        Alerts::Alerta("error","Error!","Algo Ocurrio!");
    } 
}

// si no esta activa la agrego
if($data["tipo"] == 1){
    $dato = array();

    $datos["producto"] = $data["producto"];
    $datos["opcion"] = $data["opcion"];
    $datos["edo"] = 0;
    $datos["hash"] = Helpers::HashId();
    $datos["time"] = Helpers::TimeId();
    $datos["td"] = $_SESSION["td"];
    if ($db->insert("opciones_asig", $datos)) {
        Alerts::Alerta("success","Realizado!","Registro realizado correctamente!");  
    }else {
		Alerts::Alerta("error","Error!","Faltan Datos!");
	}

}

$this->VerOpcionesActivas($data["producto"]);


}





// para mostrar los iconos al cambiarlos
   	public function MostrarIconos(){
   		$db = new dbConn();
    	
    	$a = $db->query("SELECT * FROM login_imagenes");
	    foreach ($a as $b) {
	        echo '<li><a imagen="assets/img/ico/' . $b["imagen"] .'" id="cambioimg"><em>Seleccionar</em><img src="assets/img/ico/' . $b["imagen"] .'" alt="image" class="img-fluid img-responsive wow fadeIn" /></a></li>';
	    } $a->close();
   	}








} // fin de la clase

 ?>