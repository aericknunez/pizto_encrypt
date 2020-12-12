<?php 
class Busqueda{

	public function __construct(){

	}


	public function VerProductosFactura($factura) {
		$db = new dbConn();

		    $a = $db->query("SELECT * FROM ticket WHERE num_fac = '$factura' and tx = ".$_SESSION["tx"]." and td = ".$_SESSION["td"]."");
		    if($a->num_rows == 0){
		    echo '<div align="center"><br>No se encontro factura</div>';
		    } else { 	
		    	echo '<br><table class="table table-striped table-sm">
					  <thead>
					    <tr>
					      <th scope="col">Cliente</th>
					      <th scope="col">Cantidad</th>
					      <th scope="col">Producto</th>
					      <th scope="col">Precio</th>
					      <th scope="col">Total</th>
					    </tr>
					  </thead>
					  <tbody>';
					  		$x=0;
		    	 foreach ($a as $b) {
		    	 			$x=$x+$b["total"];
		    	 			echo '<tr>
						      <th scope="row">'. $b["cliente"] .'</th>
						      <td>'. $b["cant"] .'</td>
						      <td>'. $b["producto"] .'</td>
						      <td>'. $b["pv"] .'</td>
						      <td>'. $b["total"] .'</td>
						      </tr>';
		    	 				    	     
		    	}
		    	echo '<tr>
						      <th scope="row" colspan="4">Total</th>
						      <td>'. Helpers::Dinero($x) .'</td>
						      </tr>';
		    	echo '</tbody>
					</table>';
				if($b["edo"]==2){
					Alerts::Mensajex("Esta factura ya ha sido eliminada!","danger");
				}
			   

		    } $a->close();
		
	}


	public function BorrarOrden($factura) {
		$db = new dbConn();
				// busco la mesa a la que pertenece
				 //    if ($r = $db->select("mesa", "ticket", "WHERE num_fac='$factura' and tx = ".$_SESSION["tx"]." and td = ".$_SESSION["td"]."")) { 
				 //        $mesa = $r["mesa"];
				 //    } unset($r);
		    
		   //   if ( Helpers::DeleteId("ticket", "num_fac='$factura' and tx = ".$_SESSION["tx"]." and td = ".$_SESSION["td"]."")) {
		        
		   //      Helpers::DeleteId("ticket_num", "num_fac='$factura' and tx = ".$_SESSION["tx"]." and td = ".$_SESSION["td"]."");

			  //       $a = $db->query("SELECT * FROM ticket WHERE num_fac='$factura' and tx = ".$_SESSION["tx"]." and td = ".$_SESSION["td"]."");
					// if($a->num_rows == 0){
					// 	Helpers::DeleteId("mesa", "mesa='$mesa' and tx = ".$_SESSION["tx"]." and td = ".$_SESSION["td"]."");
					// }
					// $a->close();
		        
		   //      echo '<script>
					// 	window.location.href="?"
		   //      	</script>';
	        
		   //  } else {
		   //  	Alerts::Alerta("error","Error!","Ha ocurrido un error!");
		   //  }


		    $cambio = array();
		    $cambio["edo"] = "2";
		    
		    if (Helpers::UpdateId("ticket", $cambio, "num_fac='$factura' and tx = ".$_SESSION["tx"]." and td = ".$_SESSION["td"]."")) {
		        Helpers::UpdateId("ticket_num", $cambio, "num_fac='$factura' and tx = ".$_SESSION["tx"]." and td = ".$_SESSION["td"]."");
		        echo '<script>
						window.location.href="?"
		        	</script>';
		    } else {
		    	Alerts::Alerta("error","Error!","Ha ocurrido un error!");
		    }
		    
	
   	}


	public function CancelarFactura($factura) {
		$db = new dbConn();
		
		    $cambio = array();
		    $cambio["edo"] = "2";
		    
		    if (Helpers::UpdateId("ticket", $cambio, "num_fac='$factura' and tx = ".$_SESSION["tx"]." and td = ".$_SESSION["td"]."")) {
		        Helpers::UpdateId("ticket_num", $cambio, "num_fac='$factura' and tx = ".$_SESSION["tx"]." and td = ".$_SESSION["td"]."");
		        echo '<script>
						window.location.href="?"
		        	</script>';
		    } else {
		    	Alerts::Alerta("error","Error!","Ha ocurrido un error!");
		    }
				

   	}


	public function CambiarFactura($factura) {
		$db = new dbConn();
		
		// buscar la ultima factura en tx 1 
		    $a = $db->query("SELECT max(num_fac) FROM ticket WHERE tx = 1 and td = ".$_SESSION["td"]."");
		    foreach ($a as $b) {
		        $max=$b["max(num_fac)"];
		    } $a->close();

		    $cambio = array();
		    $cambio["num_fac"] = $max+1;
		    $cambio["tx"] = 1;
		    
		    if (Helpers::UpdateId("ticket", $cambio, "num_fac='$factura' and tx = ".$_SESSION["tx"]." and td = ".$_SESSION["td"]."")) {
		        Helpers::UpdateId("ticket_num", $cambio, "num_fac='$factura' and tx = ".$_SESSION["tx"]." and td = ".$_SESSION["td"]."");
		        echo '<script>
						window.location.href="?"
		        	</script>';
		    } else {
		    	Alerts::Alerta("error","Error!","Ha ocurrido un error!");
		    }

		    				

   	}




}
  		
?>