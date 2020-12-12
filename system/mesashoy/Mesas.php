<?php  

class Mesas{

	public function __construct(){

	}

	public function VerMesas($fecha,$dir) {
		$db = new dbConn();
		
		$a = $db->query("select * from mesa where fecha = '$fecha' and td = ".$_SESSION['td']." order by id desc");

		if($a->num_rows > 0){
		    
		echo '<table class="table table-striped table-responsive-sm table-sm">

		   <thead>
		     <tr>
		       <th>Mesa</th>';

		if($_SESSION["tipo_cuenta"] == 1){
		 echo '<th>Nombre</th>'; } 
		 echo '<th>Clientes</th>
		       <th>Mesero</th>
		       <th>Hora</th>
		       <th>S Total</th>
		       <th>Propina</th>
		       <th>Total</th>
		       <th>Ver</th>
		     </tr>
		   </thead>

		   <tbody>';
		    foreach ($a as $b) {

		    	if($b["estado"] == 1){ $tbl_ticket = "ticket_temp"; }
		    	if($b["estado"] == 2){ $tbl_ticket = "ticket"; }
		    
		    if($_SESSION["tipo_cuenta"] == 1){	
		    	if($r = $db->select("nombre", "mesa_nombre", "WHERE mesa = ".$b["mesa"]." and tx = ".$b["tx"]." and 
		    		td = ".$_SESSION["td"]."")) { 
			        $nombre = $r["nombre"];
			    } unset($r);  
		    }
		    if($nombre == NULL){ $nombre = "Unknow"; }
		     
		   
		    
		   $ax = $db->query("SELECT cod, sum(total), num_fac as factur FROM ".$tbl_ticket." WHERE edo = 1 and fecha = '$fecha' and mesa = ".$b["mesa"]." and td = ".$_SESSION['td']."");
		    foreach ($ax as $bx) {
		      $total=$bx["sum(total)"];
		      $totalz = Helpers::Dinero($total);

		      if($bx["cod"] == "989898"){
		        $prop = 0;
		      } else{

		    // ver la propina de cada uno

			    if($r = $db->select("sum(total)", "ticket_propina", "WHERE num_fac = ".$bx["factur"]." and tx = ".$b["tx"]." and td = ".$_SESSION["td"]."")) { 
			        $prop = $r["sum(total)"];
			    } unset($r);  	    

			   $propz = Helpers::Dinero($prop);
			  

		    //   $prop=$_SESSION["config_propina"]/100;
			   // $prop=$total*$prop;
			   // $propz = Helpers::Dinero($prop);


		      }
			    
		    } $ax->close();


		    $ar = $db->query("SELECT sum(total) FROM ".$tbl_ticket." WHERE edo = 1 and fecha = '$fecha' and td = ".$_SESSION['td']."");
		    foreach ($ar as $br) {

		      $totalr = $br["sum(total)"];
		    } $ar->close();



		    $az = $db->query("SELECT sum(total) FROM ".$tbl_ticket." WHERE edo = 1 and cod != '989898' and fecha = '$fecha' and td = ".$_SESSION['td']."");
		    foreach ($az as $bz) {
		      $xtotal=$bz["sum(total)"];

			    
			    if($r = $db->select("sum(total)", "ticket_propina", "WHERE fecha = '$fecha' and td = ".$_SESSION["td"]."")) { 
			        $xprop = $r["sum(total)"];
			    } unset($r); 

		      // $xprop=$_SESSION["config_propina"]/100;
		      // $xprop=$xtotal*$xprop;
		      
		      $totales=$total+$prop;
		      $totalesz = Helpers::Dinero($totales);
		    } $az->close();

		   
		    // si no esta cobrada
		   if($b["estado"] == 1) { 
		   	//$totalz='<span class="badge badge-danger">Pendiente</span>';
		   	$propz='<span class="badge badge-danger">Pendiente</span>';

		    	// para agragar vinculo a la mesa no cobrada, solo si el el user es igual
		    	if($_SESSION["user"] == $b["user"]){
		    		$totalesz='<a id="activarmesa" op="29" tipo="'.$b["tipo"].'" mesa="'.$b["mesa"].'" tx="'.$b["tx"].'"><span class="badge badge-success">Ir a Orden</span></a>';
		    	} else {
		    		$totalesz='<span class="badge badge-danger">Pendiente</span>';
		    	}
		   } ///////
		   	
		  echo '<tr>
		       <th scope="row">'. $b["mesa"] . '</th>';

		  if($_SESSION["tipo_cuenta"] == 1){     
		  echo '<td>'. $nombre . '</td>'; unset($nombre); }
		  echo '<td>'. $b["clientes"] . '</td>
		       <td>'. $b["empleado"] . '</td>
		       <td>'. $b["hora"] . '</td>
		       <td>'.$totalz.'</td>
		       <td>'.$propz.'</td>
		       <td>'.$totalesz.'</td>
		       <td><a id="xvermesa" mesa="'. $b["mesa"] . '" tx="'. $b["tx"] . '" op="78" tbl="'.$tbl_ticket.'" class="btn-floating btn-sm"><i class="fas fa-utensils red-text"></i></a></td>
		     </tr>';
		    }
		   $a->close();

		  if($_SESSION["tipo_cuenta"] == 1 or $_SESSION["tipo_cuenta"] == 5){
		  echo '<tr class="light-blue lighten-4">
		       <th scope="row">Totales</th>
		       <td></td>
		       <td></td>
		       <td></td>
		       <td></td>
		       <td><strong>'.Helpers::Dinero($totalr).'</strong></td>
		       <td><strong>'.Helpers::Dinero($xprop).'</strong></td>
		       <td><strong>'.Helpers::Dinero($xtotal=$totalr+$xprop).'</strong></td>
		     </tr>';
		 	}
		 
		  echo '</tbody>

		</table>';

	} else {
		Alerts::Mensajex("No se encontaron registros","info");
	}
		  
	}










	public function VerProductoMesas($mesa,$tx,$tbl) {
		$db = new dbConn();

		   $a = $db->query("SELECT * FROM ".$tbl." WHERE mesa = '$mesa' and tx = '$tx' and td = ".$_SESSION["td"]."");
		    if($a->num_rows > 0){
		    
		      	echo '<table class="table table-striped table-responsive-sm table-sm">
					  <thead>
					    <tr>
					      <th scope="col">Cantidad</th>
					      <th scope="col">Producto</th>
					      <th scope="col">Precio</th>
					      <th scope="col">Total</th>
					      <th scope="col">Cliente</th>
					      <th scope="col">Ticket</th>
					      <th scope="col">Estado</th>
					      </tr>
					  </thead>
					  <tbody>';
					  $total_eliminado = 0;
		    	 foreach ($a as $b) {
		    	 	
		    	 	if($b["num_fac"] == 0) $edo="Pendiente"; else $edo="Cancelado";
		    	     
		    	     
				     if($b["edo"] != 1){
				     	echo '<tr class="text-danger">';
				     	$total_eliminado = $total_eliminado + $b["total"];
				     } else {
				     	echo '<tr>';
				     }

		if($b["producto"] == "Producto-Especial"){
			if ($r = $db->select("nombre", "producto", "WHERE cod = ".$b["cod"]." and td = ".$_SESSION['td']."")) { 
			$nombre = "(Esp.) " . $r["nombre"];
			} unset($r);
		} else {
			$nombre = $b["producto"];
		}
				     echo '<th scope="row">'. $b["cant"] .'</th>
				      <td>'. $nombre .'</td>
				      <td>'. Helpers::Dinero($b["pv"]) .'</td>
				      <td>'. Helpers::Dinero($b["total"]) .'</td>
				      <td>'. $b["cliente"] .'</td>
				      <td>'. $b["num_fac"] .'</td>
				      <td>'. $edo .'</td>
				      </tr>';
		    	}
		    	echo '</tbody>
					</table>';





				    $s = $db->query("SELECT sum(total) FROM ".$tbl." WHERE mesa = '$mesa' and edo = 1 and tx = '$tx' and td = ".$_SESSION["td"]."");
				    foreach ($s as $t) {
				        $max=$t["sum(total)"];
				    } $s->close();
				    if($max > 0){
				    	echo "<h1 class='h1-responsive'>Total venta: ". Helpers::Dinero($max) ."</h1>";
				    }
				    if($total_eliminado > 0){
				    	echo '<h2 class="text-danger">Total Eliminado: '. Helpers::Dinero($total_eliminado) .'</h2>';
				    }		    

		    } $a->close();
		   

	}













 	public function ModalVerMesa($mesa,$tx,$tbl) {
		$db = new dbConn();

		$a = $db->query("SELECT * FROM ".$tbl." WHERE edo != 1 and mesa = '".$mesa."' and tx = '".$tx."' and td = ".$_SESSION["td"]."");
		if($a->num_rows > 0) echo '<p class="text-danger">Esta mesa contiene facturas eliminadas!</p>';
		$a->close();

		$this->VerProductoMesas($mesa,$tx,$tbl);
	}










	public function VerProductoTicket($ticket,$tx) {
		$db = new dbConn();

		   $a = $db->query("SELECT * FROM ticket WHERE num_fac = '$ticket' and tx = '$tx' and td = ".$_SESSION["td"]."");
		    if($a->num_rows > 0){
		    
		      	echo '<table class="table table-striped table-responsive-sm table-sm">
					  <thead>
					    <tr>
					      <th scope="col">Cantidad</th>
					      <th scope="col">Producto</th>
					      <th scope="col">Precio</th>
					      <th scope="col">Total</th>
					      <th scope="col">Cliente</th>
					      <th scope="col">Ticket</th>
					      <th scope="col">Estado</th>
					      </tr>
					  </thead>
					  <tbody>';
					  $total_eliminado = 0;
		    	 foreach ($a as $b) {
		    	 	
		    	 	if($b["num_fac"] == 0) $edo="Pendiente"; else $edo="Cancelado";
		    	     
		    	     
				     if($b["edo"] != 1){
				     	echo '<tr class="text-danger">';
				     	$total_eliminado = $total_eliminado + $b["total"];
				     } else {
				     	echo '<tr>';
				     }

		if($b["producto"] == "Producto-Especial"){
			if ($r = $db->select("nombre", "producto", "WHERE cod = ".$b["cod"]." and td = ".$_SESSION['td']."")) { 
			$nombre = "(Esp.) " . $r["nombre"];
			} unset($r);
		} else {
			$nombre = $b["producto"];
		}
				     echo '<th scope="row">'. $b["cant"] .'</th>
				      <td>'. $nombre .'</td>
				      <td>'. Helpers::Dinero($b["pv"]) .'</td>
				      <td>'. Helpers::Dinero($b["total"]) .'</td>
				      <td>'. $b["cliente"] .'</td>
				      <td>'. $b["num_fac"] .'</td>
				      <td>'. $edo .'</td>
				      </tr>';
		    	}
		    	echo '</tbody>
					</table>';





				    $s = $db->query("SELECT sum(total) FROM ticket WHERE num_fac = '$ticket' and edo = 1 and tx = '$tx' and td = ".$_SESSION["td"]."");
				    foreach ($s as $t) {
				        $max=$t["sum(total)"];
				    } $s->close();
				    if($max > 0){
				    	echo "<h1 class='h1-responsive'>Total venta: ". Helpers::Dinero($max) ."</h1>";
				    }
				    if($total_eliminado > 0){
				    	echo '<h2 class="text-danger">Total Eliminado: '. Helpers::Dinero($total_eliminado) .'</h2>';
				    }		    



    if ($r = $db->select("total", "ticket_propina", "WHERE num_fac = '$ticket' and tx = '$tx' and td = ".$_SESSION["td"]."")) { 
        $propina = $r["total"];
    } unset($r);  

    if($propina > 0){
    	echo "<h1 class='h3-responsive'>Propina: ". Helpers::Dinero($propina) ."</h1>";
    	echo "<h1 class='h1-responsive text-danger'>Total Factura: ". Helpers::Dinero($max + $propina) ."</h1>";
    }

		    } $a->close();
		   

	}









// termina la clase
 }


?>