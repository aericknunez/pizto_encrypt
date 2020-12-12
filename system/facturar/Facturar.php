<?php 
class Facturar{

	public function __construct(){

	}

	public function AgregarRtn($cliente,$rtn){
		$db = new dbConn();

		if($cliente == NULL or $rtn == NULL){
			Alerts::Alerta("error","Error!","Faltan datos!");	
		}else{
			if (is_numeric($rtn)) {

					if($this->ComprobarRtn($rtn) == FALSE){
					    $datos = array();
					    $datos["rtn"] = $rtn;
					    $datos["cliente"] = strtoupper($cliente);
					    $datos["td"] = $_SESSION["td"];
					    $datos["hash"] = Helpers::HashId();
						$datos["time"] = Helpers::TimeId();
					    if ($db->insert("facturar_rtn", $datos)) {
					        Alerts::Alerta("success","Realizado!","RTN agregado correctamente!");

					    $_SESSION["rtn"] = $rtn;
						$_SESSION["cliente"] = strtoupper($cliente);

						 $this->Rtn();
					    } // se agrego
					} else {
						Alerts::Alerta("error","Error!","Ya exsiste ese RTN en el sistema!");
					}// comprueba rtn

			} else {
				Alerts::Alerta("error","Error!","El RTN no es un numero!");
			} // numeric
			     
		} // else


	}

	public function ComprobarRtn($rtn){
		$db = new dbConn();

		$a = $db->query("SELECT * FROM facturar_rtn WHERE rtn = '$rtn' and td = ".$_SESSION["td"]."");
			if($a->num_rows > 0){
				return TRUE;
			} else {
				return FALSE;
			}
			$a->close();

	}



	public function BuscarRtn($find){
		$db = new dbConn();

		    $a = $db->query("SELECT * FROM facturar_rtn WHERE rtn like '%" . $_POST["keyword"] . "%' OR cliente like '%" . $_POST["keyword"] . "%' and td = ".$_SESSION["td"]." ORDER BY id LIMIT 0,15");

		    foreach ($a as $b) {
		    	echo '<a id="ver-rtn" op="133" iden="'.$b["id"].'"><p>'.$b["cliente"].'</p></a>';
		    }  $a->close();
	}

	public function VerRtn($find){
		$db = new dbConn();

		        if ($r = $db->select("*", "facturar_rtn", "WHERE id = '$find' and td = ".$_SESSION["td"]."")) { 

			      $_SESSION["rtn"] = $r["rtn"];
			      $_SESSION["cliente"] = $r["cliente"];

			    } unset($r); 

			 $this->Rtn();
	}

	public function Rtn(){

		if($_SESSION["cliente"] != NULL and $_SESSION["rtn"] != NULL){
			 	echo '<div class="border border-light p-3"> <h4>';
			    echo $_SESSION["cliente"] . "<br>";
			    echo "RTN: ". $_SESSION["rtn"];
			    echo "</h4></div> ";
            echo '<a id="quitar-rtn" op="134" class="btn btn-warning btn-rounded">QUITAR RTN</a>';
            echo '<a id="eliminarx" op="136" idx="eliminar" opx="137" iden="'.$_SESSION["rtn"].'" class="btn btn-danger btn-rounded">ELIMINAR RTN</a>';
          }
	}


	public function QuitarRtn(){
		      unset($_SESSION["rtn"]);
		      unset($_SESSION["cliente"]);
	}


	public function EliminarRtn($rtn){
			$db = new dbConn();

		    if ( Helpers::DeleteId("facturar_rtn", "rtn = '$rtn' and td = ".$_SESSION["td"]."")) {
		        Alerts::Alerta("success","Error!","RTN Eliminado correctamente!");
		        $this->QuitarRtn();
		    } else {
		        Alerts::Alerta("error","Error!","El RTN no ha sido eliminado!");
		    } 
		      
	}


//////////////////////////// para cai

	public function ListarCai(){
			$db = new dbConn();

			    $a = $db->query("SELECT * FROM facturar_cai WHERE td = ".$_SESSION["td"]." order by id desc");

			    if($a->num_rows > 0) {
			        $az = $db->query("SELECT max(id) FROM facturar_cai WHERE td = ".$_SESSION["td"]."");
				    foreach ($az as $bz) {
				        $max=$bz["max(id)"];
				    } $az->close();
			    echo ' <h3>NUMEROS DE CAI AGREGADOS AL SISTEMA</h3>

				<table class="table table-sm table-striped">
			  <thead>
			    <tr>
			      <th scope="col">Inicial</th>
			      <th scope="col">Final</th>
			      <th scope="col">Fecha Limite</th>
			      <th scope="col">CAI</th>
			      <th>Eliminar</th>
			    </tr>
			  </thead>
			  <tbody>';
			    foreach ($a as $b) {
			    echo '<tr>
			      <td>'. $b["inicial"] .'</td>
			      <td>'. $b["final"] .'</th>
			      <td>'. $b["fecha_limite"] .'</td>
			      <td>'. $b["cai"] .'</td>
			      <td>';

			      if($max == $b["id"]){
			      	echo '<a id="eliminarx" op="136" idx="eliminar" opx="139" iden="'.$b["id"].'">
				      <span class="badge red"><i class="fas fa-trash-alt" aria-hidden="true"></i></span>
				      </a>';
			      } else {
			      	echo '<a>
				      <span class="badge green"><i class="fas fa-lock" aria-hidden="true"></i></span>
				      </a>';
			      }		      
				  echo '</td>
			    </tr>';
			    }
			    echo '</tbody>
		    		</table>';
		    	}
			    echo "El numero de registros es: ". $a->num_rows . "<br>";
			    
			    $a->close();    
	}



	public function AgregarCai($inicial,$final,$fecha,$cai){
			$db = new dbConn();

			if (is_numeric($inicial) and is_numeric($final)) {
					    $datos = array();
					    $datos["inicial"] = $inicial;
					    $datos["final"] = $final;
					    $datos["fecha_limite"] = $fecha;
					    $datos["fechaF"] = Fechas::Format($fecha);
					    $datos["cai"] = $cai;
					    $datos["td"] = $_SESSION["td"];
					    $datos["hash"] = Helpers::HashId();
						$datos["time"] = Helpers::TimeId();
					    if ($db->insert("facturar_cai", $datos)) {
					        Alerts::Alerta("success","Realizado!","Se agrego un nuevo CAI!");
					    } else {
					    	Alerts::Alerta("error","Error!","Ocurrio un error!");
					    }
				
			} else {
				Alerts::Alerta("error","Error!","Existe un error en los datos!");
			} // si no es numerico

			$this->ListarCai();
		}
///


	public function EliminarCai($id){
			$db = new dbConn();

		    if ( Helpers::DeleteId("facturar_cai", "id = '$id' and td = ".$_SESSION["td"]."")) {
		        Alerts::Alerta("success","Realizado!","CAI Eliminado correctamente!");
		        $this->QuitarRtn();
		    } else {
		        Alerts::Alerta("error","Error!","El CAI no ha sido eliminado!");
		    } 
		    
		    $this->ListarCai();  
	}









///////////////// facturas e impresoras /////////////

	public function VerImpresoras(){
			$db = new dbConn();


	    $a = $db->query("SELECT * FROM facturar_impresora WHERE td = ".$_SESSION["td"]." order by id desc");

	echo '<table class="table table-sm table-striped">
	  <thead>
	    <tr>
	      <th scope="col">Impresora</th>
	      <th scope="col">Comentarios</th>
	      <th scope="col">Eliminar</th>
	    </tr>
	  </thead>
	  <tbody>';
	    foreach ($a as $b) {
	    echo '<tr>
	      <td>'. $b["impresora"] .'</td>
	      <td>'. $b["comentarios"] .'</th>
	      <td><a id="eliminari" op="144" iden="'.$b["id"].'">
				      <span class="badge red"><i class="fas fa-trash-alt" aria-hidden="true"></i></span>
				      </a></td>
	    </tr>';
	    }
	    echo '</tbody>
    		</table>';
	    $a->close(); 

 
	}


	public function VerUsuarios(){
			$db = new dbConn();

			$user=$_SESSION["user"];
	    $a = $db->query("SELECT * FROM facturar_users WHERE user = '$user' and td = ".$_SESSION["td"]." order by id desc");

	echo '<table class="table table-sm table-striped">
	  <thead>
	    <tr>
	      <th scope="col">Tipo</th>
	      <th scope="col">Ticket</th>
	      <th scope="col">Clase</th>
	      <th scope="col">Impresora</th>
	      <th scope="col">Borrar</th>
	    </tr>
	  </thead>
	  <tbody>';
	    foreach ($a as $b) {
	    	if($b["tipo"] == 1) { $tipo="Ticktet"; } else { $tipo="Factura"; }

	    	if ($r = $db->select("nombre", "facturar_ticket", "WHERE id = ".$b["ticket"]." and td = ".$_SESSION["td"]."")) { 
		        $nombre = $r["nombre"];
		    } unset($r);

	    	if ($r = $db->select("impresora", "facturar_impresora", "WHERE id = ".$b["impresora"]." and td = ".$_SESSION["td"]."")) { 
		        $impresora = $r["impresora"];
		    } unset($r);

	    echo '<tr>';
		echo '<td>'. $tipo .'</td>
	      <td>'. $nombre .'</th>
	      <td>'. $b["clase"] .'</td>
	      <td>'. $impresora .'</td>
	      <td><a id="eliminaru" op="145" iden="'.$b["id"].'">
				      <span class="badge red"><i class="fas fa-trash-alt" aria-hidden="true"></i></span>
				      </a></td>
	    </tr>';
	    }
	    echo '</tbody>
    		</table>';
	    $a->close(); 
 
	}




	public function VerTickets(){
			$db = new dbConn();


	    $a = $db->query("SELECT * FROM facturar_ticket WHERE td = ".$_SESSION["td"]." order by id desc");

	echo '<table class="table table-sm table-striped">
	  <thead>
	    <tr>
	      <th scope="col">Nombre</th>
	      <th scope="col">Ticket</th>
	      <th scope="col">Imagen</th>
	      <th scope="col">Textos</th>
	      <th scope="col">Saltos</th>
	      <th scope="col">Borrar</th>
	    </tr>
	  </thead>
	  <tbody>';
	    foreach ($a as $b) {
	    echo '<tr>
	      <td>'. $b["nombre"] .'</td>
	      <td>'. $b["tipo"] .'</th>
	      <td>'. $b["img"] .'</td>
	      <td>'. $b["txt1"] .' | '. $b["txt2"] .' | '. $b["txt3"] .' | '. $b["txt4"] .' | </td>
	      <td>'. $b["n1"] .' | '. $b["n2"] .' | '. $b["n3"] .' | '. $b["n4"] .' | </td>
	      <td><a id="eliminarf" op="143" iden="'.$b["id"].'">
				      <span class="badge red"><i class="fas fa-trash-alt" aria-hidden="true"></i></span>
				      </a></td>
	    </tr>';
	    }
	    echo '</tbody>
    		</table>';
	    $a->close(); 
 
	}




	public function AgregarFactura($nombre,$img,$tipo,$t1,$t2,$t3,$t4,$n1,$n2,$n3,$n4){
			$db = new dbConn();
			
			    $datos = array();
			    $datos["nombre"] = $nombre;
			    $datos["tipo"] = $tipo;
			    $datos["img"] = $img;
			    $datos["txt1"] = $t1;
			    $datos["txt2"] = $t2;
			    $datos["txt3"] = $t3;
			    $datos["txt4"] = $t4;
			    $datos["n1"] = $n1;
			    $datos["n2"] = $n2;
			    $datos["n3"] = $n3;
			    $datos["n4"] = $n4;
			    $datos["td"] = $_SESSION["td"];
			    $datos["hash"] = Helpers::HashId();
				$datos["time"] = Helpers::TimeId();
			    if ($db->insert("facturar_ticket", $datos)) {
			        Alerts::Alerta("success","Realizado!","Se agrego una factura!");
			    } else {
			    	Alerts::Alerta("error","Error!","Ocurrio un error!");
			    }
				
			
			$this->VerTickets();
		}



	public function AgregarImpresora($impresora,$comentarios){
			$db = new dbConn();
			
			    $datos = array();
			    $datos["impresora"] = $impresora;
			    $datos["comentarios"] = $comentarios;
			    $datos["td"] = $_SESSION["td"];
			    $datos["hash"] = Helpers::HashId();
				$datos["time"] = Helpers::TimeId();
			    if ($db->insert("facturar_impresora", $datos)) {
			        Alerts::Alerta("success","Realizado!","Se agrego una Impresora!");
			    } else {
			    	Alerts::Alerta("error","Error!","Ocurrio un error!");
			    }
				
			
			$this->VerImpresoras();
		}


	public function AgregarUsuarios($tipo,$ticket,$impresora,$clase){
			$db = new dbConn();
			
			    $datos = array();
			    $datos["tipo"] = $tipo;
			    $datos["ticket"] = $ticket;
			    $datos["user"] = $_SESSION["user"];
			    $datos["clase"] = $clase;
			    $datos["impresora"] = $impresora;			    
			    $datos["td"] = $_SESSION["td"];
			    $datos["hash"] = Helpers::HashId();
				$datos["time"] = Helpers::TimeId();
			    if ($db->insert("facturar_users", $datos)) {
			        Alerts::Alerta("success","Realizado!","Se agrego un nuevo Usuario!");
			    } else {
			    	Alerts::Alerta("error","Error!","Ocurrio un error!");
			    }
				
			
			$this->VerUsuarios();
		}




	public function EliminarFact($iden){
			$db = new dbConn();

		    if ( Helpers::DeleteId("facturar_ticket", "id = '$iden' and td = ".$_SESSION["td"]."")) {
		        Alerts::Alerta("success","Realizado!","Ticket Eliminado correctamente!");
		    } else {
		        Alerts::Alerta("error","Error!","El Ticket no ha sido eliminado!");
		    } 

		  $this->VerTickets();
		      
	}


	public function EliminarPrint($iden){
			$db = new dbConn();

		    if ( Helpers::DeleteId("facturar_impresora", "id = '$iden' and td = ".$_SESSION["td"]."")) {
		        Alerts::Alerta("success","Realizado!","Impresora Eliminado correctamente!");
		    } else {
		        Alerts::Alerta("error","Error!","La Impresora no ha sido eliminado!");
		    } 

		  $this->VerImpresoras();
		      
	}


	public function EliminarUser($iden){
			$db = new dbConn();

		    if ( Helpers::DeleteId("facturar_users", "id = '$iden' and td = ".$_SESSION["td"]."")) {
		        Alerts::Alerta("success","Realizado!","Usuario Eliminado correctamente!");
		    } else {
		        Alerts::Alerta("error","Error!","El Usuario no ha sido eliminado!");
		    } 

		  $this->VerUsuarios();
		      
	}













/////////////eliminar facturas - -  muestra las facturas generadas
	public function EliminarFacturas(){
			$db = new dbConn();

	$a = $db->query("SELECT * FROM ticket_num WHERE edo = '1' and tx = ".$_SESSION["tx"]." and td = ".$_SESSION["td"]." ORDER BY id desc limit 15");
	    if($a->num_rows > 0){
	echo '<table class="table table-sm table-striped">
	  <thead>
	    <tr>
	      <th scope="col">Factura</th>
	      <th scope="col">Hora</th>
	      <th scope="col">Borrar</th>
	    </tr>
	  </thead>
	  <tbody>';
	    foreach ($a as $b) {
	    echo '<tr>
	      <td>'. $b["num_fac"] .'</td>
	      <td>'. $b["hora"] .'</th>
	      <td><a id="eliminar-factura" op="168" num_fac="'.$b["num_fac"].'" mesa="'.$b["mesa"].'">
				      <span class="badge red"><i class="fas fa-trash-alt" aria-hidden="true"></i></span>
				      </a></td>
	    </tr>';
	    }
	    echo '</tbody>
    		</table>';
	    $a->close(); 
	  } else {
	  	echo '<h3 class="border border-light">No hay Facturas emitidas este dia</h3>';
	  }
 
	}



	public function BorrarFactura($mesa, $ticket) {  // elimina la factura de raiz
		$db = new dbConn();
		    
		    // temp
		     if ( Helpers::DeleteId("ticket_temp", "num_fac = '$ticket' and mesa='$mesa' and tx = ".$_SESSION["tx"]." and td = ".$_SESSION["td"]."")) {
		    
		    // ticket 
		      Helpers::DeleteId("ticket", "num_fac = '$ticket' and mesa='$mesa' and tx = ".$_SESSION["tx"]." and td = ".$_SESSION["td"]."");

		    // ticket 
		      Helpers::DeleteId("ticket_num", "num_fac = '$ticket' and mesa='$mesa' and tx = ".$_SESSION["tx"]." and td = ".$_SESSION["td"]."");

		    // verifica si ya no hay mas productos en la mesa
		    $a = $db->query("SELECT * FROM ticket_temp WHERE mesa='$mesa' and tx = ".$_SESSION["tx"]." and td = ".$_SESSION["td"]."");
				
				if($a->num_rows == 0){
					
					Helpers::DeleteId("mesa", "mesa='$mesa' and tx = ".$_SESSION["tx"]." and td = ".$_SESSION["td"]." and estado = 1");

		        	Helpers::DeleteId("mesa_nombre", "mesa='$mesa' and tx = ".$_SESSION["tx"]." and td = ".$_SESSION["td"]."");
				}

				$a->close(); 		       
	        	
	        	Alerts::Alerta("success","Eliminada!","factura: ". $ticket ." eliminada correctamente !");
		    } else {
		    	Alerts::Alerta("error","Error!","Ocurrio un error!");
		    }

		    $this->EliminarFacturas();

   	}













	public function ModFactura($data){
		$db = new dbConn();

		$cambio = array();	

		switch ($data["iden"]) {
			case "ax0":
				$cambio["ax0"] = $data["edo"];
				break;
			case "ax1":
				$cambio["ax1"] = $data["edo"];
				break;
			case "bx0":
				$cambio["bx0"] = $data["edo"];
				break;
			case "bx1":
				$cambio["bx1"] = $data["edo"];
				break;
			case "cx0":
				$cambio["cx0"] = $data["edo"];
				break;
			case "cx1":
				$cambio["cx1"] = $data["edo"];
				break;
			case "dx0":
				$cambio["dx0"] = $data["edo"];
				break;
			case "dx1":
				$cambio["dx1"] = $data["edo"];
				break;

		}


		$a = $db->query("SELECT * FROM facturar_opciones WHERE td = ".$_SESSION["td"]."");
		if($a->num_rows > 0){    
		    if (Helpers::UpdateId("facturar_opciones", $cambio, "td = ".$_SESSION["td"]."")) {
		        Alerts::Alerta("success","Realizado!","Registros actualizados correctamente");
		    }		
		} else {
		    $cambio["td"] = $_SESSION["td"];
			$cambio["hash"] = Helpers::HashId();
			$cambio["time"] = Helpers::TimeId();
		    if ($db->insert("facturar_opciones", $cambio)) {
		    	Alerts::Alerta("success","Realizado!","Registros actualizados correctamente");
		    } 			
		}

		$a->close();     
	}




public function ObtenerEstadoFactura($efectivo, $factura){ // esta funcion obtiene el estado de la factura, el tx o si es local o web para decidir cual factura mostrar
		$db = new dbConn();
		$imprimir = new Impresiones(); 
		
if($_SESSION["tx"] == 0){

    if ($r = $db->select("ax0, bx0", "facturar_opciones", "WHERE td = ".$_SESSION["td"]."")) { 
        $ax0 = $r["ax0"]; $bx0 = $r["bx0"];
    } unset($r);  

	if($ax0 == 1 or $bx0 == 1){

	      if($ax0 == 1){  // tx0 ticket

	      		if($_SESSION["root_plataforma"] == 0){ // si es local
	      			$imprimir->Ticket($efectivo, $factura);
	      			// echo "Ticket tx0 y local";
	         //(tipo,numero,cambio,impresor,mesa,factura_o_tiket)
	      		} else {
	      			// aqui va el vinculo a web
	      			echo '<a href="system/facturar/ticket_web.php?factura='.$factura.'" class="btn-floating btn-sm btn-info"><i class="fas fa-print"></i></a>';
	      			// echo "Ticket tx0 y Web";
	      		}        
	      }
	      if($bx0 == 1){ // tx0 factura
	      		if($_SESSION["root_plataforma"] == 0){ // si es local
	      			$imprimir->Factura($efectivo, $factura);
	      			// echo "Factura tx0 y local";
	         //(tipo,numero,cambio,impresor,mesa,factura_o_tiket)
	      		} else {
	      			// aqui va el vinculo a web
	      			echo '<a href="system/facturar/ticket_web.php?factura='.$factura.'" class="btn-floating btn-sm btn-info"><i class="fas fa-print"></i></a>';
	      			// echo "Factura tx0 y Web";
	      		}
	      }


	}

} else {
    
    if ($r = $db->select("ax1, bx1", "facturar_opciones", "WHERE td = ".$_SESSION["td"]."")) { 
        $ax1 = $r["ax1"]; $bx1 = $r["bx1"];
    } unset($r);  
 
     if($ax1 == 1 or $bx1 == 1){ 

        if($ax1 == 1){ // tx1 ticket
        		if($_SESSION["root_plataforma"] == 0){ // si es local
	      			$imprimir->Ticket($efectivo, $factura);
	      			// echo "Ticket tx1 y local";
	         //(tipo,numero,cambio,impresor,mesa,factura_o_tiket)
	      		} else {
	      			// aqui va el vinculo a web
	      			echo '<a href="system/facturar/ticket_web.php?factura='.$factura.'" class="btn-floating btn-sm btn-info"><i class="fas fa-print"></i></a>';
	      			// echo "Ticekt tx1 y Web";
	      		}
           
        }
        if($bx1 == 1){ // tx1 Factura
        		if($_SESSION["root_plataforma"] == 0){ // si es local
	      			$imprimir->Factura($efectivo, $factura);

	      			// echo "Factura tx1 y local";
	         //(tipo,numero,cambio,impresor,mesa,factura_o_tiket)
	      		} else {
	      			// aqui va el vinculo a web
	      			echo '<a href="system/facturar/ticket_web.php?factura='.$factura.'" class="btn-floating btn-sm btn-info"><i class="fas fa-print"></i></a>';
	      			// echo "Factura tx1 y Web";
	      		}        	
           
        }

    } 


}

}// termina le funcion









public function ObtenerEstadoFacturaReimprimir($efectivo, $factura){ // esta funcion obtiene el estado de la factura, el tx o si es local o web para decidir cual factura mostrar
		$db = new dbConn();
		$imprimir = new Impresiones(); 
		
if($_SESSION["tx"] == 0){

    if ($r = $db->select("ax0, bx0", "facturar_opciones", "WHERE td = ".$_SESSION["td"]."")) { 
        $ax0 = $r["ax0"]; $bx0 = $r["bx0"];
    } unset($r);  

	if($ax0 == 1 or $bx0 == 1){

	      if($ax0 == 1){  // tx0 ticket

	      		if($_SESSION["root_plataforma"] == 0){ // si es local
	      			$imprimir->Ticket($efectivo, $factura);
	      			// echo "Ticket tx0 y local";
	         //(tipo,numero,cambio,impresor,mesa,factura_o_tiket)
	      		} else {
	      			// aqui va el vinculo a web
	      			echo '<a href="system/facturar/ticket_web.php?factura='.$factura.'" class="btn-floating btn-sm btn-info"><i class="fas fa-print"></i></a>';
	      			// echo "Ticket tx0 y Web";
	      		}        
	      }
	      if($bx0 == 1){ // tx0 factura
	      		if($_SESSION["root_plataforma"] == 0){ // si es local
	      			$imprimir->Facturax($efectivo, $factura);
	      			// echo "Factura tx0 y local";
	         //(tipo,numero,cambio,impresor,mesa,factura_o_tiket)
	      		} else {
	      			// aqui va el vinculo a web
	      			echo '<a href="system/facturar/ticket_web.php?factura='.$factura.'" class="btn-floating btn-sm btn-info"><i class="fas fa-print"></i></a>';
	      			// echo "Factura tx0 y Web";
	      		}
	      }


	}

} else {
    
    if ($r = $db->select("ax1, bx1", "facturar_opciones", "WHERE td = ".$_SESSION["td"]."")) { 
        $ax1 = $r["ax1"]; $bx1 = $r["bx1"];
    } unset($r);  
 
     if($bx1 == 1 or $bx1 == 1){ 

        if($ax1 == 1){ // tx1 ticket
        		if($_SESSION["root_plataforma"] == 0){ // si es local
	      			$imprimir->Ticket($efectivo, $factura);
	      			// echo "Ticket tx1 y local";
	         //(tipo,numero,cambio,impresor,mesa,factura_o_tiket)
	      		} else {
	      			// aqui va el vinculo a web
	      			echo '<a href="system/facturar/ticket_web.php?factura='.$factura.'" class="btn-floating btn-sm btn-info"><i class="fas fa-print"></i></a>';
	      			// echo "Ticekt tx1 y Web";
	      		}
           
        }
        if($bx1 == 1){ // tx1 Factura
        		if($_SESSION["root_plataforma"] == 0){ // si es local
	      			$imprimir->Facturax($efectivo, $factura);

	      			// echo "Factura tx1 y local";
	         //(tipo,numero,cambio,impresor,mesa,factura_o_tiket)
	      		} else {
	      			// aqui va el vinculo a web
	      			echo '<a href="system/facturar/ticket_web.php?factura='.$factura.'" class="btn-floating btn-sm btn-info"><i class="fas fa-print"></i></a>';
	      			// echo "Factura tx1 y Web";
	      		}        	
           
        }

    } 


}

}// termina le funcion






}  // class
?>