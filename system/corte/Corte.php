<?php
class Corte{

	public function __construct() { 
     } 

// En la tabla alter_opciones campo Actualizar se registra si esta activa la caja o no
// en cero, esta cerrada en uno esta aperturada solo para opcion 1 (una caja pero con tiempo)


	public function EjecutarCorte($efectivo,$fecha){
		$db = new dbConn();

	if($this->UltimaFecha() == date("d-m-Y")){
		Alerts::Alerta("error","Error!","Ya existe un corte el dia de hoy");
	} else {
	// busco caja chica del ultimo corte
	// 
		if ($r = $db->select("efectivo", "corte_diario", "where edo = 1 and td = ".$_SESSION["td"]." order by id DESC LIMIT 1")) { 
	        $caja_chica=$r["efectivo"];
	    } unset($r);


		   	    $this->EliminarMesasActivas($fecha);
		   	    
    	// inserto los datos del corte de ahora
    		$datos = array();
		    $datos["fecha"] = $fecha;
		    $datos["fecha_format"] = Fechas::Format($fecha);
		    $datos["hora"] = date("H:i:s");
		    $datos["mesas"] = $this->MesasHoy($fecha);
		    $datos["clientes"] = $this->ClientesHoy($fecha);
		    $datos["efectivo"] = $efectivo;
		    $datos["propina"] = $this->PropinaHoy($fecha);
		    $datos["tx"] = $this->TotalTx($fecha);
		    $datos["no_tx"] = $this->TotalNoTx($fecha);
		    $datos["total"] = $this->VentaHoy($fecha);
		    $datos["gastos"] = $this->GastoHoy($fecha);
		    $datos["diferencia"] = $this->DiferenciaDinero($caja_chica, $efectivo, $fecha);
		    $datos["user"] = $_SESSION["user"];
		    $datos["edo"] = 1;
		    $datos["td"] = $_SESSION["td"];
		    $datos["hash"] = Helpers::HashId();
			$datos["time"] = Helpers::TimeId();
		   if($db->insert("corte_diario", $datos)){

		   	// pongo inactivo 
		   	$cambio = array();
			$cambio["actualizar"] = 0;
		   	Helpers::UpdateId("alter_opciones", $cambio, "td = ".$_SESSION["td"]."");
		   	//
		   //	Alerts::Alerta("success","Exito!","Se ha ejecutado el corte correctamente!");
		   	$this->CalcularGastoProductos($fecha);

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

		  
		}// de la comprobacion de fechas
	}


/// verifica si esta aperturada la caja

	public function VerificaApertura(){ /// 0 cerrada, 1 abierta
		$db = new dbConn();
	    if ($r = $db->select("actualizar", "alter_opciones", "where td = ".$_SESSION["td"]."")) { 
	        $apertura=$r["actualizar"];
	    } unset($r); 
		return $apertura;
	}



	public function UltimoEfectivo(){ //verifica cuento fue el ultimo efectivo para aperturar caja
		$db = new dbConn();
	    if ($r = $db->select("efectivo", "corte_diario", "where edo=1 and td = ".$_SESSION["td"]." order by id DESC LIMIT 1")) { 
	        $efectivo=$r["efectivo"];
	    } 
	    unset($r); 
		return $efectivo;
	}



// aperturar caja para opcion uno
	public function AperturarCaja(){
		$db = new dbConn();
		   	// pongo activo 
		   	$cambio = array();
			$cambio["actualizar"] = 1;
		   	if(Helpers::UpdateId("alter_opciones", $cambio, "td = ".$_SESSION["td"]."")){
		   		echo '<script>
						window.location.href="?"
					</script>';
				} else {
				echo '<script>
						window.location.href="?apertura"
					</script>';	
		    }
		   	
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

	public function MesasHoy($fecha){
		$db = new dbConn();
	    	$a = $db->query("SELECT * FROM mesa WHERE td = ".$_SESSION["td"]." and fecha = '$fecha'"); $total = $a->num_rows; $a->close();
		return $total;
	}


//////////// 

	public function MesasAbiertas($fecha){
		$db = new dbConn();
	    	$abi = $db->query("SELECT * FROM mesa WHERE estado = 1 and td = ".$_SESSION["td"]." and fecha = '$fecha'"); 
	    	$total = $abi->num_rows; $abi->close();
		
		if($total > 0){
			Alerts::Mensaje("Aun hay mesas sin cancelar, estas pueden afectar el total. No olvide cancelarlas. Si continua con el corte todos los datos de las mesas creadas y no canceladas se eliminaran","danger",NULL,NULL);
		}
	}

	public function EliminarMesasActivas($fecha){
		$db = new dbConn();
	    	    
	    	    Helpers::DeleteId("mesa", "estado = 1 and fecha = '$fecha' and td = " . $_SESSION["td"]);

		}
//////////


	public function ClientesHoy($fecha){
		$db = new dbConn();
	        $a = $db->query("SELECT sum(clientes) FROM mesa WHERE td = ".$_SESSION["td"]." and fecha = '$fecha'");
		    foreach ($a as $b) {
		        $clientes=$b["sum(clientes)"];
		    } $a->close();
		    return  $clientes;

	}


	public function VentaHoy($fecha){
		$db = new dbConn();
	    $a = $db->query("SELECT sum(total) FROM ticket WHERE edo = 1 and td = ".$_SESSION["td"]." and fecha = '$fecha'");
		    foreach ($a as $b) {
		     $total=$b["sum(total)"];
		    } $a->close();
		    return $total;
	}


	public function VentaMes($fecha){ /// solo para reporte de semestre
		$db = new dbConn();
	    $a = $db->query("SELECT sum(total) FROM ticket WHERE edo = 1 and td = ".$_SESSION["td"]." and fecha like '%-$fecha'");
		    foreach ($a as $b) {
		     $total=$b["sum(total)"];
		    } $a->close();
		    return $total;
	}

	public function PropinaHoy($fecha){
		$db = new dbConn();
	    $a = $db->query("SELECT sum(total) FROM ticket_propina WHERE td = ".$_SESSION["td"]." and fecha = '$fecha'");
		    foreach ($a as $b) {
		     $total=$b["sum(total)"];
		    } $a->close();
		    return $total;
	}


	public function TotalTx($fecha){
		$db = new dbConn();
	    $a = $db->query("SELECT sum(total) FROM ticket WHERE edo = 1 and td = ".$_SESSION["td"]." and fecha = '$fecha' and tx = 1");
		    foreach ($a as $b) {
		     $total=$b["sum(total)"];
		    } $a->close();
		    return $total;
	}

	public function TotalNoTx($fecha){
		$db = new dbConn();
	    $a = $db->query("SELECT sum(total) FROM ticket WHERE edo = 1 and td = ".$_SESSION["td"]." and fecha = '$fecha' and tx = 0");
		    foreach ($a as $b) {
		     $total=$b["sum(total)"];
		    } $a->close();
		    return $total;
	}


public function Porcentaje(){
	$db = new dbConn();

	$cant_g = Corte::TotalTx(date("d-m-Y"));
	$cant_e = Corte::TotalNoTx(date("d-m-Y"));

	$topor=$cant_g+$cant_e;
	$por1=$cant_g*100;
	@$por1=$por1/$topor;

	$por2=$cant_e*100;
	@$por2=$por2/$topor;
	$por1=number_format($por1,0,'.','.');
	$por2=number_format($por2,0,'.','.');

	return "$por1/$por2";

}


	public function GastoHoy($fecha){
		$db = new dbConn();
	    $a = $db->query("SELECT sum(cantidad) FROM gastos WHERE (edo = 1 or edo = 2) and tipo != 5 and td = ".$_SESSION["td"]." and fecha = '$fecha'");
		    foreach ($a as $b) {
		     $total=$b["sum(cantidad)"];
		    } $a->close();
		    return $total;
	}



	public function GastoMes($fecha){
		$db = new dbConn();
	    $a = $db->query("SELECT sum(cantidad) FROM gastos WHERE (edo = 1 or edo = 2) and tipo != 5 and td = ".$_SESSION["td"]." and fecha like '%-$fecha'");
		    foreach ($a as $b) {
		     $total=$b["sum(cantidad)"];
		    } $a->close();
		    return $total;
	}



	public function EntradasEfectivo($fecha){
		$db = new dbConn();
	        $a = $db->query("SELECT sum(cantidad) FROM entradas_efectivo WHERE edo = 1 and td = ".$_SESSION["td"]." and fecha = '$fecha'");
		    foreach ($a as $b) {
		        $efectivo=$b["sum(cantidad)"];
		    } $a->close();
		    return  $efectivo;

	}


	public function DiferenciaDinero($caja_chica, $efectivo, $fecha){
		/// conversiones para el dinero
			$total_cc = $this->VentaHoy($fecha)+$caja_chica+$this->PropinaHoy($fecha)+$this->EntradasEfectivo($fecha); //total ventas  mas caja chica de ayer
				$total_debido = $total_cc-$this->GastoHoy($fecha); //dinero que deberia haber ()
				$diferencia = $efectivo - $total_debido;
				return $diferencia;
	}



public function CancelarCorte($ramdom,$fecha){

	$numero = sha1(Fechas::Format(date("d-m-Y")));
	$num = substr("$numero", 0, 6);

		if($ramdom == $num){

			$db = new dbConn();


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

			        $this->RevertirCalcularGastoProductos($fecha);
					Alerts::Alerta("success","Exito!","Corte Anulado Correctamente");
			    } else {
			Alerts::Alerta("error","Error!","Codigo Invalido!!");
			}
		}

	}







////////////////////////////////// contenido //////////////////////////
	public function Contenido($fecha){
		if(Corte::UltimaFecha() == $fecha){
				$this->Content($fecha);
			} else {
				$this->Form();
			}
	}
	




	public function Content($fecha){   // para corte normal
		$sync = new Sync;


		 echo '<div class="card-deck">
			    <!--Panel-->
			    <div class="card">
			        <div class="card-body">
			            <h4 class="card-title">Efectivo</h4>
			            <p class="black-text display-4">' . Helpers::Dinero($this->GetEfectivo($fecha)) . '</p>
			        </div>
			    </div>
			    <!--/.Panel-->

			    <!--Panel-->
			    <div class="card">
			        <div class="card-body">
			            <h4 class="card-title">Total de venta</h4>
			            <p class="black-text display-4">' . Helpers::Dinero($this->VentaHoy($fecha)) . '</p>
			        </div>
			    </div>
			    <!--/.Panel-->

			    <!--Panel-->
			    <div class="card">
			        <div class="card-body">
			            <h4 class="card-title">Diferencia</h4>
			            <p class="black-text display-4">' . Helpers::Dinero($this->GetDiferencia($fecha)) . '</p>
			        </div>
			    </div>
			    <!--/.Panel-->

			    <!--Panel-->
			    <div class="card">
			        <div class="card-body">
			            <h4 class="card-title">Gastos</h4>
			            <p class="black-text display-4">' . Helpers::Dinero($this->GastoHoy($fecha)) . '</p>
			        </div>
			    </div>
			    <!--/.Panel-->

			</div>

			<button type="button" class="btn btn-danger" data-toggle="modal" data-target="#modalConfirmDelete">Eliminar Corte</button>';
			echo '<a id="imprimir_corte" class="btn-floating cyan" title="Imprimir Corte" data-toggle="tooltip" data-placement="bottom"><i class="fas fa-print"></i></a>';
		
	}





	public function Content1(){ //// par ala opcion de caja 1
		$sync = new Sync;
		$db = new dbConn();


    if ($r = $db->select("efectivo, propina, total, gastos, diferencia, clientes, time", "corte_diario", "WHERE edo = 1 and td = ".$_SESSION["td"]." order by time desc")) { 
        $efectivo = $r["efectivo"];
        $propina = $r["propina"];
        $total = $r["total"];
        $gastos = $r["gastos"];
        $diferencia = $r["diferencia"];
        $clientes = $r["clientes"];
        $fin = $r["time"];

    } unset($r);  



    if ($r = $db->select("efectivo, time", "corte_diario", "WHERE edo = 1 and td = ".$_SESSION["td"]." order by time desc limit 1, 1")) { 
        $apertura = $r["efectivo"];
        $inicio = $r["time"]+1;
    } unset($r);  

// tarjeta de credito
$a = $db->query("SELECT sum(total) FROM ticket WHERE edo = 1 and tipo_pago = 2 and td = ".$_SESSION["td"]." and time BETWEEN '".$inicio."' and '".$fin."'");
    foreach ($a as $b) {
     $tarjetacredito=$b["sum(total)"];
    } $a->close();

// venta en efectivo
$a = $db->query("SELECT sum(total) FROM ticket WHERE edo = 1 and tipo_pago = 1 and td = ".$_SESSION["td"]." and time BETWEEN '".$inicio."' and '".$fin."'");
    foreach ($a as $b) {
     $vefectivo=$b["sum(total)"];
    } $a->close();

/// propina de tarjeta
    $a = $db->query("SELECT num_fac, tx FROM ticket WHERE edo = 1 and tipo_pago = 2 and td = ".$_SESSION["td"]." and time BETWEEN  '".$inicio."' and '".$fin."' GROUP BY num_fac");
    $propinatarjetac = 0;
    foreach ($a as $b) {

	    if ($r = $db->select("total", "ticket_propina", "WHERE num_fac = ".$b["num_fac"]." and td = ".$_SESSION["td"]." and tx = ".$b["tx"]."")) { 
	        $totalx = $r["total"];
	    } unset($r);  
	    $propinatarjetac = $propinatarjetac + $totalx;
    } $a->close();


/// propina de efectivo
    $a = $db->query("SELECT num_fac, tx FROM ticket WHERE edo = 1 and tipo_pago = 1 and td = ".$_SESSION["td"]." and time BETWEEN  '".$inicio."' and '".$fin."' GROUP BY num_fac");
    $propinatarjetae = 0;
    foreach ($a as $b) {

	    if ($r = $db->select("total", "ticket_propina", "WHERE num_fac = ".$b["num_fac"]." and td = ".$_SESSION["td"]." and tx = ".$b["tx"]."")) { 
	        $total2 = $r["total"];
	    } unset($r);  
	    $propinatarjetae = $propinatarjetae + $total2;
    } $a->close();

		 echo '<div class="card-deck">


			    <!--Panel-->
			    <div class="card">
			        <div class="card-body" title="La suma de todas las ventas pagadas en efectivo sin incluir la propina" data-toggle="tooltip">
			            <h4 class="card-title">Venta Efectivo</h4>
			            <p class="black-text display-4">' . Helpers::Dinero($vefectivo) . '</p>
			        </div>
			    </div>
			    <!--/.Panel-->


			    <!--Panel-->
			    <div class="card">
			        <div class="card-body" title="La suma de las ventas pagadas con tarjeta de credito sin incluir propina" data-toggle="tooltip">
			            <h4 class="card-title">Tarjeta Credito</h4>
			            <p class="black-text display-4">' . Helpers::Dinero($tarjetacredito) . '</p>
			        </div>
			    </div>
			    <!--/.Panel-->


			    <!--Panel-->
			    <div class="card">
			        <div class="card-body" title="La suma de todas las propinas de la venta de hoy y separadas en efectivo o credito" data-toggle="tooltip">
			            <h4 class="card-title">Propina Total</h4>
			            <p class="black-text display-4">' . Helpers::Dinero($propina) . '</p>
			            <p>Tarjeta: '. Helpers::Dinero($propinatarjetac) .'</p>
			            <p>Efectivo: '. Helpers::Dinero($propinatarjetae) .'</p>
			        </div>
			    </div>
			    <!--/.Panel-->

			    <!--Panel-->
			    <div class="card">
			        <div class="card-body" title="El total de venta en efectivo y credito sumandole propina en efectivo y al credito" data-toggle="tooltip">
			            <h4 class="card-title">Total de Venta</h4>
			            <p class="black-text display-4">' . Helpers::Dinero($total + $propina) . '</p>
			        </div>
			    </div>
			    <!--/.Panel-->

			</div>';




		 echo '<div class="card-deck mt-3">

			    <!--Panel-->
			    <div class="card">
			        <div class="card-body" title="Efectivo Ingresado al momento de realizar el corte" data-toggle="tooltip">
			            <h4 class="card-title">Efectivo en caja</h4>
			            <p class="black-text display-4">' . Helpers::Dinero($efectivo) . '</p>
			        </div>
			    </div>
			    <!--/.Panel-->

			    <!--Panel-->
			    <div class="card">
			        <div class="card-body" title="La suma de todos los gastos reportados" data-toggle="tooltip">
			            <h4 class="card-title">Gastos</h4>
			            <p class="black-text display-4">' . Helpers::Dinero($gastos) . '</p>
			        </div>
			    </div>
			    <!--/.Panel-->

			    <!--Panel-->
			    <div class="card">
			        <div class="card-body" title="Dinero en efectivo del corte anterior" data-toggle="tooltip">
			            <h4 class="card-title">Apertura</h4>
			            <p class="black-text display-4">' . Helpers::Dinero($apertura) . '</p>
			        </div>
			    </div>
			    <!--/.Panel-->

			    <!--Panel-->
			    <div class="card">
			        <div class="card-body" title="Diferencia de dinero en el corte actual" data-toggle="tooltip">
			            <h4 class="card-title">Diferencia</h4>
			            <p class="black-text display-4">' . Helpers::Dinero($diferencia) . '</p>
			        </div>
			    </div>
			    <!--/.Panel-->

			</div>';



			echo '<button type="button" class="btn btn-danger" data-toggle="modal" data-target="#modalConfirmDelete">Eliminar Corte</button>';
			echo '<a id="imprimir_corte" class="btn-floating cyan" title="Imprimir Corte" data-toggle="tooltip" data-placement="bottom"><i class="fas fa-print"></i></a>';
		
	}




	public function Form(){
	echo '<p>Aun no se ha realizado el corte de este dia. <br />Ingrese la cantidad de su efectivo para poder continuar
		</p>
		<br />
		<form id="form-corte" name="form-corte">
		 
		 <div class="form-group row justify-content-center align-items-center">
		  <div class="col-xs-2">
		    <label for="ex1">Efectivo</label>
		    <input name="efectivo" type="number" id="efectivo" size="8" maxlength="8" class="form-control" placeholder="0.00" step="any" required autofocus />
		  </div>
		</div>
		<input type="image" src="assets/img/imagenes/print.png"  id="btn-corte" name="btn-corte" >
		</form>';
				
	}

///////////////////////////////////////// descuentos 

	public function CalcularGastoProductos($fecha){
		$db = new dbConn();
		// paso 1 recorro todos los productos vendidos ahora
		$a = $db->query("SELECT cod, cant FROM ticket WHERE fecha = '$fecha' and edo=1 and td = ".$_SESSION["td"]."");
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




	public function RevertirCalcularGastoProductos($fecha){
		$db = new dbConn();
		// paso 1 recorro todos los productos vendidos ahora
		$a = $db->query("SELECT cod, cant FROM ticket WHERE fecha = '$fecha'  and edo=1 and td = ".$_SESSION["td"]."");
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