<?php 
class Producto{

	public function __construct(){

	}

	public function AddUnidad($nombre, $abreviacion){
	    $db = new dbConn();

	         $datos = array();
		    $datos["unidad"] = $nombre;
		    $datos["abreviacion"] = $abreviacion;
		    $datos["td"] = $_SESSION["td"];
		    $datos["hash"] = Helpers::HashId();
			$datos["time"] = Helpers::TimeId();
		    if ($db->insert("pro_unidades_medida", $datos)) {
		    		$i = $db->insert_id();
		    	    $cambio = array();
				    $cambio["iden"] =  $i;
				    
		    	Helpers::UpdateId("pro_unidades_medida", $cambio, "id=" . $i);
		       Alerts::Alerta("success","Agregado Correctamente","Unidad de medida Agregado corectamente!");
		    }else {
			    	Alerts::Alerta("danger","Error","Error desconocido, no se agrego el registro!");
			} 
			$this->VerUnidad(1);
	}



	public function VerUnidad($npagina){
	    $db = new dbConn();

	$limit = 10;
	$adjacents = 2;
	if($npagina == NULL) $npagina = 1;
	$a = $db->query("SELECT * FROM pro_unidades_medida WHERE td = ". $_SESSION['td'] ."");
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

 $a = $db->query("SELECT * FROM pro_unidades_medida WHERE td = ". $_SESSION["td"] ."  limit $offset, $limit");
	      	if($a->num_rows > 0){
	        echo '<table class="table table-sm table-striped">
			  <thead>
			    <tr>
			      <th scope="col">Unidad</th>
			      <th scope="col">Abreviaci&oacuten</th>
			      <th>Del</th>
			    </tr>
			  </thead>
			  <tbody>';
		    foreach ($a as $b) {
		    	echo '<tr>
			      <th scope="row">'. $b["unidad"] .'</th>
			      <td>'. $b["abreviacion"] .'</td>
			      <td><a id="borrar-unidad" op="31" iden="'. $b["iden"] .'">
				      <span class="badge red"><i class="fas fa-trash-alt" aria-hidden="true"></i></span>
				      </a></td>
			    </tr>';
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
				<a class="page-link" id="paginador" op="39.1" iden="1">&lt;&lt;</a>
			</li>';
		
		$page>1 ? $pagina = $page-1 : $pagina = 1;
		echo '<li class="page-item '.$enable.'">
				<a class="page-link" id="paginador" op="39.1" iden="'.$pagina.'">&lt;</a>
			</li>';

		for($i=$start; $i<=$end; $i++) {
			$i == $page ? $pagina =  'active' : $pagina = '';
			echo '<li class="page-item '.$pagina.'">
				<a class="page-link" id="paginador" op="39.1" iden="'.$i.'">'.$i.'</a>
			</li>';
		}

		$page >= $total_pages ? $enable = 'disabled' : $enable = '';
		$page < $total_pages ? $pagina = ($page+1) : $pagina = $total_pages;
		echo '<li class="page-item '.$enable.'">
				<a class="page-link" id="paginador" op="39.1" iden="'.$pagina.'">&gt;</a>
			</li>';

		echo '<li class="page-item '.$enable.'">
				<a class="page-link" id="paginador" op="39.1" iden="'.$total_pages.'">&gt;&gt;</a>
			</li>

			</ul>';



	 	 }  // end pagination 

	}

		public function BorrarUnidad($iden) {
		$db = new dbConn();
		    
		    if (Helpers::DeleteId("pro_unidades_medida", "iden='$iden' and td = ".$_SESSION["td"]."")) {
		        
		        Alerts::Alerta("warning","Unidad Eliminado","Se ha eliminado el registo correctamente!");
			    $this->VerUnidad(1);
		    }

   		}



	public function AddPorciones($nombre,$producto,$cantidad){
	    $db = new dbConn();

	         $datos = array();
		    $datos["nombre"] = $nombre;
		    $datos["producto"] = $producto;
		     $datos["cantidad"] = $cantidad;
		    $datos["td"] = $_SESSION["td"];
		    $datos["hash"] = Helpers::HashId();
			$datos["time"] = Helpers::TimeId();
		    if ($db->insert("pro_dependiente", $datos)) {
		    	$i = $db->insert_id();
		    	    $cambio = array();
				    $cambio["iden"] =  $i;
				    
		    	Helpers::UpdateId("pro_dependiente", $cambio, "id=" . $i);
		       Alerts::Alerta("success","Agregado Correctamente","Porcion de medida Agregado corectamente!");
		    }else {
			    	Alerts::Alerta("danger","Error","Error desconocido, no se agrego el registro!");
			} 
			$this->VerPorciones(1);
	}



	public function VerPorciones($npagina){
	    $db = new dbConn();
	
	$limit = 10;
	$adjacents = 2;
	if($npagina == NULL) $npagina = 1;
	$a = $db->query("SELECT * FROM pro_dependiente WHERE td = ". $_SESSION['td'] ."");
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

    $a = $db->query("SELECT * FROM pro_dependiente WHERE td = ". $_SESSION["td"] ."  limit $offset, $limit");
	      	if($a->num_rows > 0){
	        echo '<table class="table table-sm table-striped">
			  <thead>
			    <tr>
			      <th scope="col">Unidad</th>
			      <th scope="col">Producto</th>
			      <th scope="col">Cantidad</th>
			      <th>Del</th>
			    </tr>
			  </thead>
			  <tbody>';
		    foreach ($a as $b) {
		    
		    if ($r = $db->select("nombre", "pro_bruto", "WHERE iden = ".$b["producto"]." and td = ".$_SESSION["td"]."")) { 
		        $producto = $r["nombre"];
		    } unset($r); 

		    	echo '<tr>
			      <th scope="row">'. $b["nombre"] .'</th>
			      <td>'. $producto .'</td>
			      <td>'. $b["cantidad"] .'</td>
			      <td><a id="borrar-porcion" op="33" iden="'. $b["iden"] .'">
				      <span class="badge red"><i class="fas fa-trash-alt" aria-hidden="true"></i></span>
				      </a></td>
			    </tr>';
			    unset($producto);
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
				<a class="page-link" id="paginador" op="39.3" iden="1">&lt;&lt;</a>
			</li>';
		
		$page>1 ? $pagina = $page-1 : $pagina = 1;
		echo '<li class="page-item '.$enable.'">
				<a class="page-link" id="paginador" op="39.3" iden="'.$pagina.'">&lt;</a>
			</li>';

		for($i=$start; $i<=$end; $i++) {
			$i == $page ? $pagina =  'active' : $pagina = '';
			echo '<li class="page-item '.$pagina.'">
				<a class="page-link" id="paginador" op="39.3" iden="'.$i.'">'.$i.'</a>
			</li>';
		}

		$page >= $total_pages ? $enable = 'disabled' : $enable = '';
		$page < $total_pages ? $pagina = ($page+1) : $pagina = $total_pages;
		echo '<li class="page-item '.$enable.'">
				<a class="page-link" id="paginador" op="39.3" iden="'.$pagina.'">&gt;</a>
			</li>';

		echo '<li class="page-item '.$enable.'">
				<a class="page-link" id="paginador" op="39.3" iden="'.$total_pages.'">&gt;&gt;</a>
			</li>

			</ul>';



	 	 }  // end pagination 

	}




		public function BorrarPorcion($iden) {
		$db = new dbConn();
		    
		    if (Helpers::DeleteId("pro_dependiente", "iden='$iden' and td = ".$_SESSION["td"]."")) {
		        
		        Alerts::Alerta("warning","Porcion Eliminado","Se ha eliminado el registo correctamente!");
			    $this->VerPorciones(1);
		    }

   		}





	public function AddMateria($nombre,$cantidad,$unidad){
	    $db = new dbConn();

	         $datos = array();
		    $datos["nombre"] = $nombre;		    
		    $datos["cantidad"] = $cantidad;
		     $datos["um"] = $unidad;
		    $datos["td"] = $_SESSION["td"];
		    $datos["hash"] = Helpers::HashId();
			$datos["time"] = Helpers::TimeId();
		    if ($db->insert("pro_bruto", $datos)) {
		    	$i = $db->insert_id();
		    	    $cambio = array();
				    $cambio["iden"] =  $i;
				    
		    	Helpers::UpdateId("pro_bruto", $cambio, "id=" . $i);
		       Alerts::Alerta("success","Agregado Correctamente","Materia de medida Agregado corectamente!");
		    }else {
			    	Alerts::Alerta("danger","Error","Error desconocido, no se agrego el registro!");
			} 
			$this->VerMateria(1);
	}



	public function VerMateria($npagina){
	    $db = new dbConn();
	    
	$limit = 10;
	$adjacents = 2;
	if($npagina == NULL) $npagina = 1;
	$a = $db->query("SELECT * FROM pro_bruto WHERE td = ". $_SESSION['td'] ."");
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

    $a = $db->query("SELECT * FROM pro_bruto WHERE td = ". $_SESSION['td'] ." limit $offset, $limit");
	      	if($a->num_rows > 0){
	        echo '<table class="table table-sm table-striped">
			  <thead>
			    <tr>
			      <th scope="col">Nombre</th>
			      <th scope="col">Cantidad</th>
			      <th scope="col">Unidad</th>
			      <th>Del</th>';
			      if($_SESSION["tipo_cuenta"] == 1 or $_SESSION["tipo_cuenta"] == 5 or $_SESSION["tipo_cuenta"] == 2) {
		     	echo '<th>Seguir</th>';
			     }
			     echo '</tr>
			  </thead>
			  <tbody>';
	    foreach ($a as $b) {

	    	if ($r = $db->select("abreviacion", "pro_unidades_medida", "WHERE iden = ".$b["um"]." and td = ".$_SESSION["td"]."")) { 
		        $uni = $r["abreviacion"];
		    } unset($r);
		    	
	    		echo '<tr>
			      <th scope="row">'. $b["nombre"] .'</th>
			      <td>'. $b["cantidad"] .'</td>
			      <td>'. $uni .'</td>
			      <td><a id="borrar-materia" op="35" iden="'. $b["iden"] .'">
				      <span class="badge red"><i class="fas fa-trash-alt" aria-hidden="true"></i></span>
				  </a></td>';
				  // para materia prima
			    if($_SESSION["tipo_cuenta"] == 1 or $_SESSION["tipo_cuenta"] == 5 or $_SESSION["tipo_cuenta"] == 2) {
				     
				     $at = $db->query("SELECT * FROM alter_materiaprima_reporte WHERE producto = ". $b["iden"] ." and td =  ". $_SESSION['td'] ."");
	    		if($at->num_rows != 0){ $colore = "green"; $act = "Activo"; } else { $colore = "red"; $act = "Inactivo"; } $at->close();	

				     	echo '<td><a id="cambiar-materia" op="167" cod="'. $b["iden"] .'" iden="'.$npagina.'"><span class="badge badge-pill '.$colore.'">'.$act.'</span></a></td>';
				   /// termina lo de materia prima  
				}
			    echo '</tr>';
	        unset($uni);
		    } echo '</tbody>
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
				<a class="page-link" id="paginador" op="39" iden="1">&lt;&lt;</a>
			</li>';
		
		$page>1 ? $pagina = $page-1 : $pagina = 1;
		echo '<li class="page-item '.$enable.'">
				<a class="page-link" id="paginador" op="39" iden="'.$pagina.'">&lt;</a>
			</li>';

		for($i=$start; $i<=$end; $i++) {
			$i == $page ? $pagina =  'active' : $pagina = '';
			echo '<li class="page-item '.$pagina.'">
				<a class="page-link" id="paginador" op="39" iden="'.$i.'">'.$i.'</a>
			</li>';
		}

		$page >= $total_pages ? $enable = 'disabled' : $enable = '';
		$page < $total_pages ? $pagina = ($page+1) : $pagina = $total_pages;
		echo '<li class="page-item '.$enable.'">
				<a class="page-link" id="paginador" op="39" iden="'.$pagina.'">&gt;</a>
			</li>';

		echo '<li class="page-item '.$enable.'">
				<a class="page-link" id="paginador" op="39" iden="'.$total_pages.'">&gt;&gt;</a>
			</li>

			</ul>';



	 	 }  // end pagination 

	}






		public function BorrarMateria($iden) {
		$db = new dbConn();
		    
		    if (Helpers::DeleteId("pro_bruto", "iden='$iden' and td = ".$_SESSION["td"]."")) {
		        Helpers::DeleteId("alter_materiaprima_reporte", "producto=" . $iden);
		        Alerts::Alerta("warning","Materia Eliminado","Se ha eliminado el registo correctamente!");
			    $this->VerMateria(1);
		    }

   		}



		public function SeguirMateria($id, $iden) { // para saber a cuales productos sigo
		$db = new dbConn();

		    	$a = $db->query("SELECT * FROM alter_materiaprima_reporte WHERE producto = '$id' and td = ".$_SESSION["td"]."");
		if($a->num_rows == 0){

		    $datos = array();
		    $datos["producto"] = $id;
		    $datos["td"] = $_SESSION["td"];
		    $datos["hash"] = Helpers::HashId();
			$datos["time"] = Helpers::TimeId();
		    if ($db->insert("alter_materiaprima_reporte", $datos)) {
		      Alerts::Alerta("success","Cambiado Correctamente","El producto ha sido cambiado correctamente");
		    } else {
			        Alerts::Alerta("error","Error","Ha ocurrido un error desconocido"); 
			    }

		} else {

			    if ( Helpers::DeleteId("alter_materiaprima_reporte", "producto=" . $id)) {
			        Alerts::Alerta("success","Cambiado Correctamente","El producto ha sido eliminado correctamente"); 
			    } else {
			        Alerts::Alerta("error","Error","Ha ocurrido un error desconocido"); 
			    } 

		}
		$a->close();
		    
		    $this->VerMateria($iden);

   		}



	public function VerPlatillos($npagina){
    	$db = new dbConn();

    $limit = 10;
	$adjacents = 2;
	if($npagina == NULL) $npagina = 1; 
	$a = $db->query("SELECT * FROM producto WHERE td = ". $_SESSION['td'] ."");
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

    $a = $db->query("SELECT * FROM producto WHERE td = ". $_SESSION['td'] ." limit $offset, $limit");
    	$numerox=0;
    	if($a->num_rows > 0){
    	$numerox++;
    	
    	//  obtener numero de pantallas del  usuario
    	if ($r = $db->select("pantallas", "config_root", "WHERE td = ".$_SESSION["td"]."")) { 
	        $pantallas = Encrypt::Decrypt($r["pantallas"],$_SESSION['secret_key']);
	    } unset($r);

	      echo '<table class="table table-sm table-striped">
		   <thead>
		     <tr>
		       <th>Codigo</th>
		       <th>Nombre</th>
		       <th>Categoria</th>
		       <th>Detalle</th>
		       <th>Pantalla</th>
		     </tr>
		   </thead>
		   <tbody>';
	    foreach ($a as $b) {
	    		    		$r = $db->select("categoria", "categorias", "WHERE cod = ". $b["categoria"] ." and td =  ". $_SESSION['td'] ."");

	    		$az = $db->query("SELECT * FROM pro_asignado WHERE cod = ". $b["cod"] ." and td =  ". $_SESSION['td'] ."");				 
			    echo '<tr>
				       <th scope="row">'. $b["cod"] . '</th>
				       <td>'. $b["nombre"] . '</td>
				       <td>'. $r["categoria"] . '</td>
				       <td><a href="?modal=detalleproducto&cod='. $b["cod"] .'"><span class="badge badge-pill badge-info">Ver</span></a>
				       		<span class="badge badge-pill red">'.$az->num_rows.'</span></td>


				       <td>';
      
	       if ($rx = $db->select("panel", "control_panel_mostrar", "WHERE producto = ". $b["cod"] ." and td =  ". $_SESSION['td'] ."")) { 
	       	/// lo hago para cada pantalla
	       		for ($i = 1; $i <= $pantallas; $i++) {
				 if($rx["panel"] == $i) $colore = "green"; else $colore = "red";  
				echo '<a id="pantalla" op="39.2" cod="'. $b["cod"] .'" iden="'.$i.'" pagina="'.$npagina.'" >
		        <span class="badge badge-pill '.$colore.'">'.$i.'</span></a>';
				} // for
    
		    } else {

		    	for ($i = 1; $i <= $pantallas; $i++) { 
				echo '<a id="pantalla" op="39.2" cod="'. $b["cod"] .'" iden="'.$i.'" pagina="'.$npagina.'" >
		        <span class="badge badge-pill red">'.$i.'</span></a>';
				} // for

		    } unset($rx); // termina lo de las pntallas
    	
				       		
		       echo '</td>
		      </tr>';
		$az->close();
		unset($r);
	        
	    } echo '</tbody>
	    		 </table>';

			} else { echo "Aun no se han agregado productos"; }// num rows
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
				<a class="page-link" id="paginador" op="38" iden="1">&lt;&lt;</a>
			</li>';
		
		$page>1 ? $pagina = $page-1 : $pagina = 1;
		echo '<li class="page-item '.$enable.'">
				<a class="page-link" id="paginador" op="38" iden="'.$pagina.'">&lt;</a>
			</li>';

		for($i=$start; $i<=$end; $i++) {
			$i == $page ? $pagina =  'active' : $pagina = '';
			echo '<li class="page-item '.$pagina.'">
				<a class="page-link" id="paginador" op="38" iden="'.$i.'">'.$i.'</a>
			</li>';
		}

		$page >= $total_pages ? $enable = 'disabled' : $enable = '';
		$page < $total_pages ? $pagina = ($page+1) : $pagina = $total_pages;
		echo '<li class="page-item '.$enable.'">
				<a class="page-link" id="paginador" op="38" iden="'.$pagina.'">&gt;</a>
			</li>';

		echo '<li class="page-item '.$enable.'">
				<a class="page-link" id="paginador" op="38" iden="'.$total_pages.'">&gt;&gt;</a>
			</li>

			</ul>';



	 	 }  // end pagination 


  
    }





	public function AddPorcionProducto($cod,$dependiente){
	    $db = new dbConn();

	        $datos = array();
		    $datos["cod"] = $cod;		    
		    $datos["dependiente"] = $dependiente;
		    $datos["td"] = $_SESSION["td"];
		    $datos["hash"] = Helpers::HashId();
			$datos["time"] = Helpers::TimeId();
		    if ($db->insert("pro_asignado", $datos)) {
		    	$i = $db->insert_id();
		    	    $cambio = array();
				    $cambio["iden"] =  $i;
				    
		    	Helpers::UpdateId("pro_asignado", $cambio, "id=" . $i);
		       Alerts::Alerta("success","Agregado Correctamente","Producto Agregado corectamente!");
		    }else {
			    	Alerts::Alerta("warning","Error","Error desconocido, no se agrego el registro!");
			} 
			$this->VerPorcionProducto($cod);
	}


	public function VerPorcionProducto($cod){
	    $db = new dbConn();
	    
	    $a = $db->query("SELECT * FROM pro_asignado WHERE cod='$cod' and td = ".$_SESSION["td"]."");
	    if($a->num_rows > 0){
	    	echo '<h3>Productos agregados</h3>
	    	<table class="table table-sm table-striped">
				  <thead>
				    <tr>
				      <th scope="col">Cod</th>
				      <th scope="col">Dependiente</th>
				      <th scope="col">Borrar</th>
				    </tr>
				  </thead>
				  <tbody>';
	    	foreach ($a as $b) {
	 if ($r = $db->select("nombre", "pro_dependiente", "WHERE iden = ".$b["dependiente"]." and td = ".$_SESSION["td"]."")) { 
	        $dependiente=$r["nombre"];
	    } unset($r);
	    	echo '<tr>
			      <th scope="row">'. $b["cod"] .'</th>
			      <td>'. $dependiente .'</td>
			      <td>
			      <a id="borrar-porcion" op="37" iden="'. $b["iden"] .'" cod="'. $b["cod"] .'">
				      <span class="badge red"><i class="fas fa-trash-alt" aria-hidden="true"></i></span>
				      </a>
				      </td>
			    </tr>';
     		} // foreach
    		echo '</tbody>
				</table>';

	    }$a->close();


	}


		public function BorrarPorcionProducto($iden,$cod) {
		$db = new dbConn();
		    
		    if (Helpers::DeleteId("pro_asignado", "iden='$iden' and td = ".$_SESSION["td"]."")) {
		        
		        Alerts::Alerta("warning","Materia Eliminado","Se ha eliminado el registo correctamente!");
			   $this->VerPorcionProducto($cod);
		    }

   		}



		public function CambiarPantalla($cod,$iden) {
		$db = new dbConn();

			$ad = $db->query("SELECT * FROM control_panel_mostrar WHERE producto='$cod' and td = ". $_SESSION['td'] ."");
			if($ad->num_rows != 0){
				foreach ($ad as $bd) {
	        			// si el panel es igual al que viene, elimino
						if($bd["panel"] == $iden){
							// eliminar
							Helpers::DeleteId("control_panel_mostrar", "producto='$cod' and td = " . $_SESSION['td']);
						} else {
							// actualizar
							$cambio = array();
							$cambio["panel"] = $iden;
							
							Helpers::UpdateId("control_panel_mostrar", $cambio, "producto='$cod' and td = ".$_SESSION["td"]."");	
						}
			    }
			}  else { // si no existe en la tabla, lo agrego
					$datos = array();
				    $datos["producto"] = $cod;
				    $datos["panel"] = $iden;
				    $datos["td"] = $_SESSION["td"];
				    $datos["hash"] = Helpers::HashId();
					$datos["time"] = Helpers::TimeId();
				    $db->insert("control_panel_mostrar", $datos);
			}
		  $ad->close();
   	}






}

?>