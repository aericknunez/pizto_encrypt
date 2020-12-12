<?php 
class Product{

	public function __construct(){

	}

		public function AgregarAveria($producto, $cantidad,$comentarios){
	    $db = new dbConn();

	    // obtener el nombre y detalles del producto
	   if ($r = $db->select("*", "pro_dependiente", "WHERE iden = '$producto' and td = ". $_SESSION["td"] ."")) { 
        $nombre = $r["nombre"]; $bruto = $r["producto"]; $cant = $r["cantidad"];
    	} unset($r); 

    	// obtengo cuanto hay en inventario para descontar
    	if ($x = $db->select("nombre, cantidad, um", "pro_bruto", "WHERE iden = '$bruto' and td = ". $_SESSION["td"] ."")) { 
        $nombre_bruto = $x["nombre"]; $inventario = $x["cantidad"]; $um = $x["um"];} unset($x); 
        $inventario = $inventario - ($cantidad * $cant);
        // unidad de medida
        if ($s = $db->select("unidad", "pro_unidades_medida", "WHERE iden = '$um' and td = ". $_SESSION["td"] ."")) { 
        $unidadmedida = $s["unidad"]; } unset($s); 
    	// descontar del inventario
    	    $cambio = array();
		    $cambio["cantidad"] = $inventario;
		    
		    if (Helpers::UpdateId("pro_bruto", $cambio, "iden='$bruto' and td = ". $_SESSION["td"] ."")) {
			    
			    $datos = array();
			    $datos["producto"] = $producto;
			    $datos["cantidad"] = $cantidad;
			    $datos["comentarios"] = $comentarios;
			    $datos["descuenta"] = "- " . $cantidad * $cant . " " .$unidadmedida. " a " . $nombre_bruto ;
			    $datos["fecha"] = date("d-m-Y");
			    $datos["hora"] = date("H:i:s");
			    $datos["usuario"] = $_SESSION["nombre"];
			    $datos["td"] = $_SESSION["td"];
			    $datos["hash"] = Helpers::HashId();
				$datos["time"] = Helpers::TimeId();

		    if ($db->insert("pro_historial_averias", $datos)) {
		    Alerts::Alerta("success","Agregado Correctamente","Averia agregada y desconta del inventario correctamente!");
		    }else {
			Alerts::Alerta("error","Error","Error desconocido, no se agrego el registro!");
			} 
		    } else {
		    Alerts::Alerta("error","Error","Error desconocido, no se agrego el registro!"); 
		    }

	        
			$this->VerAverias(1);
	}

	public function EliminarAveria($iden){
	    $db = new dbConn();

	    // cantidad de historial
        if ($x = $db->select("producto, cantidad", "pro_historial_averias", "WHERE iden = '$iden' and td = ". $_SESSION["td"] ."")) { 
        $cantidad = $x["cantidad"]; $producto = $x["producto"]; } unset($x);

        // conocer de que producto se desconto
        if ($s = $db->select("producto, cantidad", "pro_dependiente", "WHERE iden = '$producto' and td = ". $_SESSION["td"] ."")) { 
        $pro_bruto = $s["producto"]; $cant_dependiente = $s["cantidad"]; } unset($s); 

        // conocer cuanto es la cantidad que tiene ese bruto
        if ($z = $db->select("cantidad, iden", "pro_bruto", "WHERE iden = '$pro_bruto' and td = ". $_SESSION["td"] ."")) { $cant_bruto = $z["cantidad"]; } unset($z); 

        $cantidad = $cant_dependiente * $cantidad;
        $descontar = $cant_bruto + $cantidad;

	  if (Helpers::DeleteId("pro_historial_averias", "id='$iden' and td = ".$_SESSION["td"]."")) {

	  	    $cambio = array();
		    $cambio["cantidad"] = $descontar;
		    
		    Helpers::UpdateId("pro_bruto", $cambio, "iden='".$pro_bruto."' and td = ". $_SESSION["td"] ."");
		        
		   Alerts::Alerta("success","Agregado Correctamente","Averia agregada y desconta del inventario correctamente!");
		    }
		    $this->VerAverias(1);
	}



	public function VerAverias($npagina){
	    $db = new dbConn();

	$limit = 10;
	$adjacents = 2;
	if($npagina == NULL) $npagina = 1;
	$a = $db->query("SELECT * FROM pro_historial_averias WHERE td = ". $_SESSION['td'] ."");
	$total_rows = $a->num_rows;
	$a->close();

	$total_pages = ceil($total_rows / $limit);
	
	if(isset($npagina) && $npagina != NULL) {
		$page = $npagina;
		$offset = $limit * ($page-1);
	} else {
		$page = 1;
		$offset = 0;
	}

 $a = $db->query("SELECT * FROM pro_historial_averias WHERE td = ". $_SESSION["td"] ." order by id desc limit $offset, $limit");
	      	if($a->num_rows > 0){
	        echo '<table class="table table-sm table-striped">
			  <thead>
			    <tr>
			      <th scope="col">Producto</th>
			      <th scope="col">Cantidad</th>
			      <th scope="col">Descuenta</th>
			      <th scope="col">Comentarios</th>
			      <th scope="col">Fecha</th>
			      <th scope="col">Hora</th>
			      <th scope="col">Usuario</th>
			      <th>Del</th>
			    </tr>
			  </thead>
			  <tbody>';
		    foreach ($a as $b) {
		    // obtener el nombre y detalles del producto
		if ($r = $db->select("*", "pro_dependiente", "WHERE iden = ".$b["producto"]." and td = ". $_SESSION["td"] ."")) { 
        $producto = $r["nombre"]; } unset($r); 

		    	echo '<tr>
			      <th scope="row">'. $producto .'</th>
			      <td>'. $b["cantidad"] .'</td>
			      <td>'. $b["descuenta"] .'</td>
			       <td>'. $b["comentarios"] .'</td>
			      <td>'. $b["fecha"] .'</td>
			      <td>'. $b["hora"] .'</td>
			      <td>'. $b["usuario"] .'</td>';


                  if($b["fecha"] == date("d-m-Y")){
                      echo '<td><a id="borrar-averia" op="111" iden="'. $b["id"] .'">
				      <span class="badge red"><i class="fas fa-trash-alt" aria-hidden="true"></i></span>
				      </a></td>';
                    } else {
                      echo '<td><span class="badge green"><i class="fas fa-ban" aria-hidden="true"></i></span></td>';
                    }
			    echo '</tr>';
		    }
		    echo '</tbody>
		    </table>';
			}
  			$a->close();

	if($total_pages <= (1+($adjacents * 2))) {
		$start = 1;
		$end   = $total_pages;
	} else {
		if(($page - $adjacents) > 1) {	
			if(($page + $adjacents) < $total_pages) {  
				$start = ($page - $adjacents); 
				$end   = ($page + $adjacents); 
			} else {							
				$start = ($total_pages - (1+($adjacents*2))); 
				$end   = $total_pages; 
			}
		} else {
			$start = 1; 
			$end   = (1+($adjacents * 2));
		}
	}

	 if($total_pages > 1) { 

$page <= 1 ? $enable = 'disabled' : $enable = '';
	 	echo '<ul class="pagination pagination-sm justify-content-center">
	 	<li class="page-item '.$enable.'">
				<a class="page-link" id="paginador" op="112" iden="1">&lt;&lt;</a>
			</li>';
		
		$page>1 ? $pagina = $page-1 : $pagina = 1;
		echo '<li class="page-item '.$enable.'">
				<a class="page-link" id="paginador" op="112" iden="'.$pagina.'">&lt;</a>
			</li>';

		for($i=$start; $i<=$end; $i++) {
			$i == $page ? $pagina =  'active' : $pagina = '';
			echo '<li class="page-item '.$pagina.'">
				<a class="page-link" id="paginador" op="112" iden="'.$i.'">'.$i.'</a>
			</li>';
		}

		$page >= $total_pages ? $enable = 'disabled' : $enable = '';
		$page < $total_pages ? $pagina = ($page+1) : $pagina = $total_pages;
		echo '<li class="page-item '.$enable.'">
				<a class="page-link" id="paginador" op="112" iden="'.$pagina.'">&gt;</a>
			</li>';

		echo '<li class="page-item '.$enable.'">
				<a class="page-link" id="paginador" op="112" iden="'.$total_pages.'">&gt;&gt;</a>
			</li>

			</ul>';



	 	 }  // end pagination 

}







///////////////////////// PRODUCTO ////////////////////////

public function AgregarProducto($producto, $cantidad,$comentarios){
	    $db = new dbConn();

	    // obtener el nombre y detalles del producto
	   if ($r = $db->select("*", "pro_dependiente", "WHERE iden = '$producto' and td = ". $_SESSION["td"] ."")) { 
        $nombre = $r["nombre"]; $bruto = $r["producto"]; $cant = $r["cantidad"];
    	} unset($r); 

    	// obtengo cuanto hay en inventario para descontar
    	if ($x = $db->select("nombre, cantidad, um", "pro_bruto", "WHERE iden = '$bruto' and td = ". $_SESSION["td"] ."")) { 
        $nombre_bruto = $x["nombre"]; $inventario = $x["cantidad"]; $um = $x["um"];} unset($x); 
        $inventario = $inventario + ($cantidad * $cant);
        // unidad de medida
        if ($s = $db->select("unidad", "pro_unidades_medida", "WHERE iden = '$um' and td = ". $_SESSION["td"] ."")) { 
        $unidadmedida = $s["unidad"]; } unset($s); 
    	// descontar del inventario
    	    $cambio = array();
		    $cambio["cantidad"] = $inventario;
		    
		    if (Helpers::UpdateId("pro_bruto", $cambio, "iden='$bruto' and td = ". $_SESSION["td"] ."")) {
			    
			    $datos = array();
			    $datos["producto"] = $producto;
			    $datos["cantidad"] = $cantidad;
			    $datos["comentarios"] = $comentarios;
			    $datos["descuenta"] = "+ " . $cantidad * $cant . " " .$unidadmedida. " a " . $nombre_bruto ;
			    $datos["fecha"] = date("d-m-Y");
			    $datos["hora"] = date("H:i:s");
			    $datos["usuario"] = $_SESSION["nombre"];
			    $datos["td"] = $_SESSION["td"];
			    $datos["hash"] = Helpers::HashId();
				$datos["time"] = Helpers::TimeId();

		    if ($db->insert("pro_historial_addpro", $datos)) {
		    Alerts::Alerta("success","Agregado Correctamente","Producto agregado al inventario correctamente!");
		    }else {
			Alerts::Alerta("error","Error","Error desconocido, no se agrego el registro!");
			} 
		    } else {
		    Alerts::Alerta("error","Error","Error desconocido, no se agrego el registro!"); 
		    }

	        
			$this->VerProducto(1);
	}

	public function EliminarProducto($iden){
	    $db = new dbConn();

	    // cantidad de historial
        if ($x = $db->select("producto, cantidad", "pro_historial_addpro", "WHERE id = '$iden' and td = ". $_SESSION["td"] ."")) { 
        $cantidad = $x["cantidad"]; $producto = $x["producto"]; } unset($x);

        // conocer de que producto se desconto
        if ($s = $db->select("producto, cantidad", "pro_dependiente", "WHERE iden = '$producto' and td = ". $_SESSION["td"] ."")) { 
        $pro_bruto = $s["producto"]; $cant_dependiente = $s["cantidad"]; } unset($s); 

        // conocer cuanto es la cantidad que tiene ese bruto
        if ($z = $db->select("cantidad", "pro_bruto", "WHERE iden = '$pro_bruto' and td = ". $_SESSION["td"] ."")) { 
        $cant_bruto = $z["cantidad"]; } unset($z); 
        $cantidad = $cant_dependiente * $cantidad;
        $descontar = $cant_bruto - $cantidad;

	  if (Helpers::DeleteId("pro_historial_addpro", "id='$iden' and td = ".$_SESSION["td"]."")) {

	  	    $cambio = array();
		    $cambio["cantidad"] = $descontar;
		    
		    Helpers::UpdateId("pro_bruto", $cambio, "iden=".$pro_bruto." and td = ". $_SESSION["td"] ."");
		        
		   Alerts::Alerta("success","Agregado Correctamente","Producto Eliminado correctamente!");
		    }
		    $this->VerProducto(1);
	}



	public function VerProducto($npagina){
	    $db = new dbConn();

	$limit = 10;
	$adjacents = 2;
	if($npagina == NULL) $npagina = 1;
	$a = $db->query("SELECT * FROM pro_historial_addpro WHERE td = ". $_SESSION['td'] ."");
	$total_rows = $a->num_rows;
	$a->close();

	$total_pages = ceil($total_rows / $limit);
	
	if(isset($npagina) && $npagina != NULL) {
		$page = $npagina;
		$offset = $limit * ($page-1);
	} else {
		$page = 1;
		$offset = 0;
	}

 $a = $db->query("SELECT * FROM pro_historial_addpro WHERE td = ". $_SESSION["td"] ." order by id desc limit $offset, $limit");
	      	if($a->num_rows > 0){
	        echo '<table class="table table-sm table-striped">
			  <thead>
			    <tr>
			      <th scope="col">Producto</th>
			      <th scope="col">Cantidad</th>
			      <th scope="col">Agrega</th>
			      <th scope="col">Comentarios</th>
			      <th scope="col">Fecha</th>
			      <th scope="col">Hora</th>
			      <th scope="col">Usuario</th>
			      <th>Del</th>
			    </tr>
			  </thead>
			  <tbody>';
		    foreach ($a as $b) {
		    // obtener el nombre y detalles del producto
		if ($r = $db->select("*", "pro_dependiente", "WHERE iden = ".$b["producto"]." and td = ". $_SESSION["td"] ."")) { 
        $producto = $r["nombre"]; } unset($r); 

		    	echo '<tr>
			      <th scope="row">'. $producto .'</th>
			      <td>'. $b["cantidad"] .'</td>
			      <td>'. $b["descuenta"] .'</td>
			       <td>'. $b["comentarios"] .'</td>
			      <td>'. $b["fecha"] .'</td>
			      <td>'. $b["hora"] .'</td>
			      <td>'. $b["usuario"] .'</td>';
			       if($b["fecha"] == date("d-m-Y")){
			      echo '<td><a id="borrar-averia" op="116" iden="'. $b["id"] .'">
				      <span class="badge red"><i class="fas fa-trash-alt" aria-hidden="true"></i></span>
				      </a></td>';
				     } else {
				   echo '<td>
				      <span class="badge green"><i class="fas fa-ban" aria-hidden="true"></i></span></td>';
				     }
			    echo '</tr>';
		    }
		    echo '</tbody>
		    </table>';
			}
  			$a->close();

	if($total_pages <= (1+($adjacents * 2))) {
		$start = 1;
		$end   = $total_pages;
	} else {
		if(($page - $adjacents) > 1) {	
			if(($page + $adjacents) < $total_pages) {  
				$start = ($page - $adjacents); 
				$end   = ($page + $adjacents); 
			} else {							
				$start = ($total_pages - (1+($adjacents*2))); 
				$end   = $total_pages; 
			}
		} else {
			$start = 1; 
			$end   = (1+($adjacents * 2));
		}
	}

	 if($total_pages > 1) { 

$page <= 1 ? $enable = 'disabled' : $enable = '';
	 	echo '<ul class="pagination pagination-sm justify-content-center">
	 	<li class="page-item '.$enable.'">
				<a class="page-link" id="paginador" op="117" iden="1">&lt;&lt;</a>
			</li>';
		
		$page>1 ? $pagina = $page-1 : $pagina = 1;
		echo '<li class="page-item '.$enable.'">
				<a class="page-link" id="paginador" op="117" iden="'.$pagina.'">&lt;</a>
			</li>';

		for($i=$start; $i<=$end; $i++) {
			$i == $page ? $pagina =  'active' : $pagina = '';
			echo '<li class="page-item '.$pagina.'">
				<a class="page-link" id="paginador" op="117" iden="'.$i.'">'.$i.'</a>
			</li>';
		}

		$page >= $total_pages ? $enable = 'disabled' : $enable = '';
		$page < $total_pages ? $pagina = ($page+1) : $pagina = $total_pages;
		echo '<li class="page-item '.$enable.'">
				<a class="page-link" id="paginador" op="117" iden="'.$pagina.'">&gt;</a>
			</li>';

		echo '<li class="page-item '.$enable.'">
				<a class="page-link" id="paginador" op="117" iden="'.$total_pages.'">&gt;&gt;</a>
			</li>

			</ul>';



	 	 }  // end pagination 

	}


}

?>