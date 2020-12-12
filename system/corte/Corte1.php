<?php
class Corte{

	public function __construct() { 
     } 

// En la tabla alter_opciones campo Actualizar se registra si esta activa la caja o no
// en cero, esta cerrada en uno esta aperturada solo para opcion 1 (una caja pero con tiempo)


	public function EjecutarCorte($efectivo){
		$db = new dbConn();

	// busco caja chica del ultimo corte
		if ($r = $db->select("efectivo", "corte_diario", "where edo = 1 and td = ".$_SESSION["td"]." order by time DESC LIMIT 1")) { 
	        $caja_chica=$r["efectivo"];
	    } unset($r);


		   	    $this->EliminarMesasActivas($fecha);

		   	    $inicio = $this->GetInicio();
		   	    $fin = Helpers::TimeId();
		   	    
    	// inserto los datos del corte de ahora
    		$datos = array();
		    $datos["fecha"] = date("d-m-Y");
		    $datos["fecha_format"] = Fechas::Format(date("d-m-Y"));
		    $datos["hora"] = date("H:i:s");
		    $datos["mesas"] = $this->MesasHoy();
		    $datos["clientes"] = $this->ClientesHoy();
		    $datos["efectivo"] = $efectivo;
		    $datos["propina"] = $this->PropinaHoy();
		    $datos["tx"] = $this->TotalTx();
		    $datos["no_tx"] = $this->TotalNoTx();
		    $datos["total"] = $this->VentaHoy();
		    $datos["gastos"] = $this->GastoHoy();
		    $datos["diferencia"] = $this->DiferenciaDinero($caja_chica, $efectivo);
		    $datos["user"] = $_SESSION["user"];
		    $datos["edo"] = 1;
		    $datos["td"] = $_SESSION["td"];
		    $datos["hash"] = Helpers::HashId();
			$datos["time"] = $fin;
		   if($db->insert("corte_diario", $datos)){

		     // pongo inactivo 
		   	$cambio = array();
			$cambio["actualizar"] = 0;
		   	Helpers::UpdateId("alter_opciones", $cambio, "td = ".$_SESSION["td"]."");
		   	//
		   	
		   //	Alerts::Alerta("success","Exito!","Se ha ejecutado el corte correctamente!");
		   	$this->CalcularGastoProductos($inicio, $fin);

		   	  	if(Helpers::ServerDomain() == FALSE and $_SESSION["root_plataforma"] == 0 and $_SESSION["root_tipo_sistema"] != 0){
			 		
			 		// eliminar el los datos de ticket_temp
					   	    $db->query("TRUNCATE ticket_temp");

			   		echo '<script>
						window.location.href="?modal=respaldar"
					</script>';
			   	}

		   	  	if(Helpers::ServerDomain() == TRUE and $_SESSION["root_plataforma"] != 0){
		   	  		// eliminar el los datos de ticket_temp si estan el la web
		   	  		$db->delete("ticket_temp", "WHERE fecha = '$fecha' and td = ".$_SESSION["td"]."");
		   	  	}		   	
		   }

	}






// tiempo del corte anterior
	public function GetInicio(){ // obtiene el tiempo de inicio de la aparteura
		$db = new dbConn();
	    if ($r = $db->select("time", "corte_diario", "WHERE edo=1 and td = ".$_SESSION["td"]." order by time DESC LIMIT 1")) { 
	        $inicio = $r["time"];
	    } 
	    unset($r); 
		return $inicio;
	}





	public function BuscaCorte($fecha){
		$db = new dbConn();
	    	$a = $db->query("SELECT * FROM corte_diario WHERE fecha = '$fecha' and edo = 1 and td = ".$_SESSION["td"]."");
			return $a->num_rows;
			$a->close();
	}



	public function UltimaFecha(){
		$db = new dbConn();
	    if ($r = $db->select("fecha", "corte_diario", "where edo = 1 and td = ".$_SESSION["td"]." order by id DESC LIMIT 1")) { 
	        $fechaultima=$r["fecha"];
	    } 
	    unset($r); 
		return $fechaultima;
	}


	public function EliminarMesasActivas($fecha){
		$db = new dbConn();
	    	    
	    	    Helpers::DeleteId("mesa", "estado = 1 and fecha = '$fecha' and td = " . $_SESSION["td"]);

		}


	public function GetEfectivo($fecha){ //para reporte nada mas
		$db = new dbConn();
	    if ($r = $db->select("efectivo", "corte_diario", "where fecha = '$fecha' and td = ".$_SESSION["td"]." order by id DESC LIMIT 1")) { 
	        $efectivo=$r["efectivo"];
	    } 
	    unset($r); 
		return $efectivo;
	}

	public function GetDiferencia($fecha){ //para reporte nada mas
		$db = new dbConn();
	    if ($r = $db->select("diferencia", "corte_diario", "where fecha = '$fecha' and td = ".$_SESSION["td"]." order by id DESC LIMIT 1")) { 
	        $diferencia=$r["diferencia"];
	    } 
	    unset($r); 
		return $diferencia;
	}
////////////////////////////

	public function MesasHoy(){
		$db = new dbConn();
	    	$a = $db->query("SELECT * FROM mesa WHERE td = ".$_SESSION["td"]." and time BETWEEN '".$this->GetInicio()."' and '".Helpers::TimeId()."'"); 
	    	$total = $a->num_rows; $a->close();
		return $total;
	}




	public function ClientesHoy(){ // se refiere al numero de facturas emitidas
		$db = new dbConn();
	        $a = $db->query("SELECT count(num_fac) FROM ticket WHERE td = ".$_SESSION["td"]." and time BETWEEN '".$this->GetInicio()."' and '".Helpers::TimeId()."'");
		    foreach ($a as $b) {
		        $clientes=$b["count(num_fac)"];
		    } $a->close();
		    return  $clientes;

	}


	public function VentaHoy(){
		$db = new dbConn();
	    $a = $db->query("SELECT sum(total) FROM ticket WHERE edo = 1 and td = ".$_SESSION["td"]." and time BETWEEN '".$this->GetInicio()."' and '".Helpers::TimeId()."'");
		    foreach ($a as $b) {
		     $total=$b["sum(total)"];
		    } $a->close();
		    return $total;
	}




	public function VentaHoyTarjeta(){
		$db = new dbConn();
	    $a = $db->query("SELECT sum(total) FROM ticket WHERE edo = 1 and tipo_pago = 2 and td = ".$_SESSION["td"]." and time BETWEEN '".$this->GetInicio()."' and '".Helpers::TimeId()."'");
		    foreach ($a as $b) {
		     $total=$b["sum(total)"];
		    } $a->close();
		    return $total;
	}


	public function PropinaHoy(){
		$db = new dbConn();
	    $a = $db->query("SELECT sum(total) FROM ticket_propina WHERE td = ".$_SESSION["td"]." and time BETWEEN '".$this->GetInicio()."' and '".Helpers::TimeId()."'");
		    foreach ($a as $b) {
		     $total=$b["sum(total)"];
		    } $a->close();
		    return $total;
	}



	public function PropinaHoyTarjeta(){
		$db = new dbConn();
    $a = $db->query("SELECT num_fac, tx FROM ticket WHERE edo = 1 and tipo_pago = 2 and td = ".$_SESSION["td"]." and time BETWEEN '".$this->GetInicio()."' and '".Helpers::TimeId()."' GROUP BY num_fac");
    $total = 0;
    foreach ($a as $b) {

	    if ($r = $db->select("total", "ticket_propina", "WHERE num_fac = ".$b["num_fac"]." and td = ".$_SESSION["td"]." and tx = ".$b["tx"]."")) { 
	        $total2 = $r["total"];
	    } unset($r);  
	    $total = $total + $total2;
    } $a->close();
return $total;
	}




	public function PropinaHoyEfectivo(){
		$db = new dbConn();
    $a = $db->query("SELECT num_fac, tx FROM ticket WHERE edo = 1 and tipo_pago = 1 and td = ".$_SESSION["td"]." and time BETWEEN '".$this->GetInicio()."' and '".Helpers::TimeId()."' GROUP BY num_fac");
    $total = 0;
    foreach ($a as $b) {

	    if ($r = $db->select("total", "ticket_propina", "WHERE num_fac = ".$b["num_fac"]." and td = ".$_SESSION["td"]." and tx = ".$b["tx"]."")) { 
	        $total2 = $r["total"];
	    } unset($r);  
	    $total = $total + $total2;
    } $a->close();
return $total;
	}




	public function TotalTx(){
		$db = new dbConn();
	    $a = $db->query("SELECT sum(total) FROM ticket WHERE edo = 1 and td = ".$_SESSION["td"]." and time BETWEEN '".$this->GetInicio()."' and '".Helpers::TimeId()."' and tx = 1");
		    foreach ($a as $b) {
		     $total=$b["sum(total)"];
		    } $a->close();
		    return $total;
	}

	public function TotalNoTx(){
		$db = new dbConn();
	    $a = $db->query("SELECT sum(total) FROM ticket WHERE edo = 1 and td = ".$_SESSION["td"]." and time BETWEEN '".$this->GetInicio()."' and '".Helpers::TimeId()."' and tx = 0");
		    foreach ($a as $b) {
		     $total=$b["sum(total)"];
		    } $a->close();
		    return $total;
	}



	public function GastoHoy(){
		$db = new dbConn();
	    $a = $db->query("SELECT sum(cantidad) FROM gastos WHERE (edo = 1 or edo = 2) and tipo != 5 and td = ".$_SESSION["td"]." and time BETWEEN '".$this->GetInicio()."' and '".Helpers::TimeId()."'");
		    foreach ($a as $b) {
		     $total=$b["sum(cantidad)"];
		    } $a->close();
		    return $total;
	}






	public function EntradasEfectivo(){
		$db = new dbConn();
	        $a = $db->query("SELECT sum(cantidad) FROM entradas_efectivo WHERE edo = 1 and td = ".$_SESSION["td"]." and time BETWEEN '".$this->GetInicio()."' and '".Helpers::TimeId()."'");
		    foreach ($a as $b) {
		        $efectivo=$b["sum(cantidad)"];
		    } $a->close();
		    return  $efectivo;

	}


	public function DiferenciaDinero($caja_chica, $efectivo){
		/// conversiones para el dinero
			$total_cc = $this->VentaHoy()+$caja_chica+$this->EntradasEfectivo() + $this->PropinaHoy(); //total ventas  mas caja chica de ayer
				$total_debido = $total_cc-$this->GastoHoy() - $this->VentaHoyTarjeta() -$this->PropinaHoyTarjeta(); //dinero que deberia haber ()
				$diferencia = $efectivo - $total_debido;
				return $diferencia;
	}








public function CancelarCorte($ramdom,$fecha){

	$numero = sha1(Fechas::Format(date("d-m-Y")));
	$num = substr("$numero", 0, 6);

		if($ramdom == $num){

			$db = new dbConn();

				$inicio = $this->GetInicio();
		   	    $fin = Helpers::TimeId();


	    if ($r = $db->select("hash", "corte_diario", "where edo = 1 and td = ".$_SESSION["td"]." order by id DESC LIMIT 1")) { 
	        $hash=$r["hash"];
	    } unset($r);

				$cambio = array();
			    $cambio["edo"] = "2";
			    
			    if (Helpers::UpdateId("corte_diario", $cambio, "hash='".$hash."'")) {

			// pongo inactivo 
		   	$cambiox = array();
			$cambiox["actualizar"] = 1;
		   	Helpers::UpdateId("alter_opciones", $cambiox, "td = ".$_SESSION["td"]."");
		   	//

			        $this->RevertirCalcularGastoProductos($inicio, $fin);
					Alerts::Alerta("success","Exito!","Corte Anulado Correctamente");
			    } else {
			Alerts::Alerta("error","Error!","Codigo Invalido!!");
			}
		}

	}




///////////////////////////////////////// descuentos 

	public function CalcularGastoProductos($inicio, $fin){
		$db = new dbConn();
		// paso 1 recorro todos los productos vendidos ahora
		$a = $db->query("SELECT cod, cant FROM ticket WHERE edo=1 and time BETWEEN '".$inicio."' and '".$fin."' and td = ".$_SESSION["td"]."");
	    foreach ($a as $b) {
	    	//  paso 2corroborar las guarniciones que lleva cada uno
	    	$ax = $db->query("SELECT dependiente FROM pro_asignado WHERE cod = ".$b["cod"]." and td = ".$_SESSION["td"]."");
	   		 foreach ($ax as $bx) {
	   		 		//  paso 3 ver cantidad de guarnicion
	   		 	if ($r = $db->select("cantidad, producto", "pro_dependiente", "WHERE iden = ".$bx["dependiente"]." and td = ".$_SESSION["td"]."")) { 
	   		 		// paso 4 // actualizar el registro
	   		 			 
	   		 			if ($x = $db->select("cantidad", "pro_bruto", "WHERE iden=".$r["producto"]." and td = ".$_SESSION["td"]."")) { 
	   		 			 	// resto la cantidad encontrada menos la cantidad ocupada
        				$cantidadx=$b["cant"] * $r["cantidad"]; 
	   		 			
		   		 		$cambio = array();
					    $cambio["cantidad"] = $x["cantidad"] - $cantidadx;
					    
					    Helpers::UpdateId("pro_bruto", $cambio, "iden=".$r["producto"]." and td = ".$_SESSION["td"]."");
					    }
        				unset($x); 
					    // Termina paso 4
    			} unset($r); // termina paso 3
	    	} $ax->close(); // termina paso 2
	    	// /// /// /// //
	    } $a->close(); // termina paso 1
// agregar a registro que se calculo
    	$datos = array();
	    $datos["fecha"] = date("d-m-Y");
	    $datos["hora"] = date("H:i:s");
	    $datos["td"] = $_SESSION["td"];
	    $datos["hash"] = Helpers::HashId();
		$datos["time"] = Helpers::TimeId();
	    $db->insert("pro_registro_up", $datos); 
	}




	public function RevertirCalcularGastoProductos($inicio, $fin){
		$db = new dbConn();
		// paso 1 recorro todos los productos vendidos ahora
		$a = $db->query("SELECT cod, cant FROM ticket WHERE edo=1 and time BETWEEN '".$inicio."' and '".$fin."' and td = ".$_SESSION["td"]."");
	    foreach ($a as $b) {
	    	//  paso 2corroborar las guarniciones que lleva cada uno
	    	$ax = $db->query("SELECT dependiente FROM pro_asignado WHERE cod = ".$b["cod"]." and td = ".$_SESSION["td"]."");
	   		 foreach ($ax as $bx) {
	   		 		//  paso 3 ver cantidad de guarnicion
	   		 	if ($r = $db->select("cantidad, producto", "pro_dependiente", "WHERE iden = ".$bx["dependiente"]." and td = ".$_SESSION["td"]."")) { 
	   		 		// paso 4 // actualizar el registro
	   		 			 if ($x = $db->select("cantidad", "pro_bruto", "WHERE iden =".$r["producto"]." and td = ".$_SESSION["td"]."")) { 
	   		 			 	// resto la cantidad encontrada menos la cantidad ocupada
        				$cantidadx=$b["cant"] * $r["cantidad"]; 
	   		 			
		   		 		$cambio = array();
					    $cambio["cantidad"] = $x["cantidad"] + $cantidadx;
					    
					    Helpers::UpdateId("pro_bruto", $cambio, "iden=".$r["producto"]." and td = ".$_SESSION["td"]."");
					    }
        				unset($x); 
	   		 		// Termina paso 4
    			} unset($r); // termina paso 3
	    	} $ax->close(); // termina paso 2
	    	// /// /// /// //
	    } $a->close(); // termina paso 1
// Elimino el registro de que se hizo la reversion
	Helpers::DeleteId("pro_registro_up", "fecha = '$fecha' and td = ".$_SESSION["td"]."");
	}













} // fin de la clase

 ?>