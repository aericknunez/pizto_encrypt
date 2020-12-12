<?php  
class Especial{
	
	public function __construct(){
	

	}


	public function VentaEspecial($cod,$mesa,$cliente,$imp) {
		$db = new dbConn();
        $pv=0;

    	$stot=Helpers::STotal($pv, $imp);
    	$im=Helpers::Impuesto($stot, $imp);

		$datos = array();
	    $datos["cod"] = $cod;
	    $datos["cant"] = 1;
	    $datos["producto"] = "Producto-Especial";
	    $datos["pv"] = $pv;	    				   
	    $datos["stotal"] = $stot;	    				   
	    $datos["imp"] = $im;
	    $datos["total"] = $stot + $im;;
	    $datos["num_fac"] = 0;
	    $datos["fecha"] = date("d-m-Y");
	    $datos["hora"] = date("H:i:s");
	    $datos["mesa"] = $mesa;
	    $datos["cliente"] = $cliente;
	    $datos["cancela"] = $cliente;
	    $datos["cajero"] = $_SESSION['nombre'];
	    $datos["tipo_pago"] = 1;
	    $datos["user"] = $_SESSION['user'];
	    $datos["gravado"] = 1;
	    $datos["tx"] = $_SESSION['tx'];
	    $datos["fechaF"] = Fechas::Format(date("d-m-Y"));
	    $datos["edo"] = 1;
	    $datos["td"] = $_SESSION["td"];
	    $datos["hash"] = Helpers::HashId();
		$datos["time"] = Helpers::TimeId();
	    if ($db->insert("ticket_temp", $datos)) {
	        // Agregamos la factura
	    }  else {
	    	echo "Error!!";
	    }
	}




	public function BorrarEspecial($iden) {
		$db = new dbConn();
		Helpers::DeleteId("ticket_temp", "id='$iden' and td = ".$_SESSION["td"]." limit 1");	
		$a = $db->query("SELECT * FROM ticket_temp WHERE mesa = ".$_SESSION["mesa"]." and tx = ".$_SESSION["tx"]." and td = ".$_SESSION["td"]." and num_fac= 0");
		    if($a->num_rows == 0){
		    	Helpers::DeleteId("mesa", "mesa=".$_SESSION["mesa"]." and tx = ".$_SESSION["tx"]." and td = ".$_SESSION["td"]." and estado = 1");
		    	unset($_SESSION["mesa"]);
		    }		
	}








		public function BorrarTodo($url) {
		$db = new dbConn();
		Helpers::DeleteId("ticket_temp", "producto = 'Producto-Especial' and mesa = '".$_SESSION["mesa"]."' and tx = '".$_SESSION["tx"]."' and td = '".$_SESSION["td"]."' and num_fac= 0");
		
		if($url != NULL){
		// unset($_SESSION["mesa"]);
		header("location: ../../$url");
		}
			
	}





	public function ProductoEspecial() {
		$db = new dbConn();
			$a = $db->query("SELECT * FROM productos_venta_especial WHERE td = ".$_SESSION["td"]."");
			echo '<div class="row text-center portfolio"> 
   					<ul class="gallery">';
			    foreach ($a as $b) {
			    	    if ($r = $db->select("nombre", "producto", "WHERE cod = ".$b["producto"]." and td = ".$_SESSION["td"]."")) { 
					        $nombre = $r["nombre"]; } unset($r); 
					    if ($r = $db->select("img_name", "images", "WHERE cod = ".$b["producto"]." and td = ".$_SESSION["td"]."")) { 
					        $imagen = $r["img_name"]; } unset($r);
			        echo '<li><a id="venta-especial" op="20y" cod="'.$b["producto"].'" mesa="'.$_SESSION["mesa"].'" cliente="'.$_SESSION["clientselect"].'" ><em>'.$nombre.'</em><img src="'.$imagen.'" alt="image" class="img-fluid img-responsive wow fadeIn" /></a></li>';
			    } $a->close();
			    echo '</ul> 
 					</div>';
	}





	public function VerProductos($mesa){
		$db = new dbConn();
		$a = $db->query("SELECT * FROM ticket_temp WHERE producto = 'Producto-Especial' and mesa = '$mesa' and tx = ".$_SESSION["tx"]." and td = ".$_SESSION["td"]." and num_fac= 0");
		    if($a->num_rows != 0){
		    	echo '<br><h3>'.$_SESSION['config_cliente'].'</h3>';
		    	echo '<table class="table table-striped table-sm">
					  <thead>
					    <tr>
					      <th scope="col">Cod</th>
					      <th scope="col">Producto</th>
					      <th scope="col">Eliminar</th>
					    </tr>
					  </thead>
					  <tbody>';
		    	 foreach ($a as $b) {
		    	 	    if ($r = $db->select("nombre", "precios", "WHERE cod = ".$b["cod"]." and td = ".$_SESSION["td"]."")) { 
        				$nombre=$r["nombre"]; } unset($r);  
		    	     echo '<tr>
				      <th scope="row">'. $b["cod"] .'</th>
				      <td>'. $nombre .'</td>
				      <td>
				     <a id="borrar-especial" op="20w" iden="'. $b["id"] .'">
				      <span class="badge red"><i class="fas fa-minus-circle" aria-hidden="true"></i></span></a>
				      </td>
				    </tr>';
		    	}
		    	echo '</tbody>
					</table>';	
				echo '<form class="text-center border border-light p-2" method="post" action="application/src/routes.php?op=20u">
				   <input type="text" id="producto" name="producto" class="form-control mb-1" placeholder="Detalles">
				   <input type="number" step="any" id="cantidad" name="cantidad" class="form-control mb-1" placeholder="Cantidad">
				    <button class="btn btn-success" type="submit">Agregar</button>
				</form>';		   
		    } $a->close();
	}
// termina la clase
 }
?>