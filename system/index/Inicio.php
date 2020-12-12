<?php 
class Inicio{

	public function __construct(){

	}


	public function CompruebaIconos($url, $msj){
		$db = new dbConn();

		// si la tabla no tiene nada le agrego un registro vacio
		$veri = $db->query("SELECT * FROM alter_opciones WHERE td = ".$_SESSION["td"]."");
		if($veri->num_rows == 0){
			$datos = array();
		    $datos["td"] = $_SESSION["td"];
		    $datos["hash"] = Helpers::HashId();
			$datos["time"] = Helpers::TimeId();
		    $db->insert("alter_opciones", $datos); 
		} $veri->close();

		////
		$nombre_fichero = $url . 'iconos_'.$_SESSION["td"] . '.php';
		
		if (file_exists($nombre_fichero)) {
		    
		    $size = filesize($nombre_fichero);

			if ($r = $db->select("icono", "alter_opciones", "WHERE td = ".$_SESSION["td"]."")) { 
			    $icono = $r["icono"];
			} unset($r); 

			    if($size != $icono){
			    	$configuracion = new Config;
        			$configuracion->CrearIconos($url, $msj);

	    	    $cambio = array();
			    $cambio["icono"] = $size;
			    
			    Helpers::UpdateId("alter_opciones", $cambio, "td = ".$_SESSION["td"]."");
			} 

		} else {
			$configuracion = new Config;
        	$configuracion->CrearIconos($url, $msj);
			
			$size = filesize($nombre_fichero);
				$cambio = array();
			    $cambio["icono"] = $size;
			    
			    Helpers::UpdateId("alter_opciones", $cambio, "td = ".$_SESSION["td"]."");
			} 

		      
	}




	public function CreaCodigos($fecha){
		$db = new dbConn();

		echo '<div class="row d-flex justify-content-center text-center text-danger p-4">
			  <div class="col-sm-4 border border-light">
				'.Encrypt::Encrypt(Fechas::Format($fecha),$_SESSION['secret_key']).'
			  </div>
			</div>';
	}


	public function RegisterInOut($edo){
		$db = new dbConn();
		    $datos = array();
		    $datos["user"] = $_SESSION['user'];
		    $datos["nombre"] = $_SESSION['nombre'];
		    $datos["accion"] = $edo;
		    $datos["ip"] = Helpers::GetIp();
		    $datos["navegador"] = $_SERVER["HTTP_USER_AGENT"];
		    $datos["fecha"] = date("d-m-Y");
		    $datos["fechaF"] = Fechas::Format(date("d-m-Y"));
		    $datos["hora"] = date("H:i:s");
		    $datos["td"] = $_SESSION["td"];
		    $db->insert("login_inout", $datos); 		
	}


	public function Validar($fecha,$codigo){
		$db = new dbConn();

		if($fecha != NULL or $codigo != NULL){
			$codigo = str_replace(' ', '', $codigo); // elimina espacios

			if(Fechas::Format($fecha) == Encrypt::Decrypt($codigo,$_SESSION['secret_key'])){
				
				    $cambio = array();
				    $cambio["expira"] = Encrypt::Encrypt($fecha,$_SESSION['secret_key']);
				    $cambio["expiracion"] = $codigo;
				    if ($db->update("config_root", $cambio, "WHERE td = ".$_SESSION["td"]."")) {
				        
				        Alerts::Alerta("success","Cambios realizados","Ha introducido su codigo correctamente");
				    } else {
				    	Alerts::Alerta("warning","Ocurrio algo","Ha ocurrido un inconveniente, introduzca su codigo nuevamente");
				    }

				
			} else {
				Alerts::Alerta("error","Error","Los codigos introducidos no son correctos, asegurese de tener codigos validos");
			}
	} else {
	Alerts::Alerta("error","Error","Ha enviado datos vacios");
	}	
		$this->Caduca();
		$this->NoAcceso();
		echo '<div class="row d-flex justify-content-center text-center">
		<a href="" class="btn btn-success">Volver a Intentarlo</a></div>';

	}



	public function Caduca(){ // ver si esta caducado el sistema
        $db = new dbConn();
        $r = $db->select("*", "config_root", "where td = ".$_SESSION['td']."");
        $encrypt = new Encrypt;
        $fechas = new Fechas;


            if($_SESSION['tipo_cuenta'] != 1){

                $key1 = $encrypt->Decrypt($r["expira"],$_SESSION['secret_key']);
                $key2 = $encrypt->Decrypt($r["expiracion"],$_SESSION['secret_key']);
                $key1 = $fechas->Format($key1);


                    if($key1 == $key2){ // si son iguales verifico que no esten vencidas
                            $ahora = $fechas->Format(date("d-m-Y"));

                            if($ahora < $key1){ // esta bien // CADUCA 0 = bien, 1 = 5 dias, 2 = paso
                                $_SESSION["caduca"] = 0;
                            } if($ahora > $key1 - 432000 and $ahora <= $key1){ // entre los 5
                                $_SESSION["caduca"] = 1;
                            } if($ahora > $key1 and $ahora <= $key1 + 432000){ // 
                                $_SESSION["caduca"] = 2;
                            }if($ahora > $key1 + 432000){ // se paso
                                $_SESSION["caduca"] = 3;
                            } 

                        } else { // de una vez las declaro invalidas
                            $_SESSION["caduca"] = 3;
                        }
            
            } else {
                $_SESSION["caduca"] = 0;
            }  

            unset($r);  
       }






	public function Formulario(){
		echo '<div class="row d-flex justify-content-center text-center">
				  <div class="col-sm-4">
				<h3>C&oacutedigo de validaci&oacuten</h3>	

				<form class="text-center border border-light p-2" method="post" id="form-validar" name="form-validar">
				    <input placeholder="Seleccione una fecha" type="text" id="fecha" name="fecha" class="form-control datepicker my-2">
				    <label for="fecha">Fecha a buscar</label>
				    <input type="text" id="codigo" name="codigo" class="form-control mb-1" placeholder="Codigo">
				    <button class="btn btn-success" type="submit" id="btn-validar" name="btn-validar">Validar</button>
				</form>

				  </div>
				</div>';
	}


	public function FormularioCodigos(){
		echo '<div class="row d-flex justify-content-center text-center">
				  <div class="col-sm-4">
				<h3>Crear C&oacutedigos</h3>	

				<form class="text-center border border-light p-2" method="post" id="form-codigo" name="form-codigo">
				    <input placeholder="Seleccione una fecha" type="text" id="fecha" name="fecha" class="form-control datepicker my-2">
				    <label for="fecha">Fecha a buscar</label>
				    <br>
				    <button class="btn btn-success" type="submit" id="btn-codigo" name="btn-codigo">Crear Codigo</button>
				</form>

				  </div>
				</div>';
	}


	public function NoAcceso(){
		$db = new dbConn();

		$r = $db->select("*", "config_root", "where td = ".$_SESSION['td']."");

if($_SESSION["caduca"] == 0){
	echo Alerts::Mensaje("Su cuenta esta desbloqueada y activa hasta el " . Encrypt::Decrypt($r["expira"],$_SESSION['secret_key']),"success",'<a href="?" class="btn btn-info waves-effect waves-light">Continuar...</a>',NUll);
}
if($_SESSION["caduca"] == 1){
	echo Alerts::Mensaje("Su cuenta esta a punto de expirar, caduca el " . Encrypt::Decrypt($r["expira"],$_SESSION['secret_key']),"danger",'<a id="habilitar" op="126" class="btn btn-info waves-effect waves-light">Continuar Usandolo</a>','<a href="application/includes/logout.php" class="btn btn-danger waves-effect waves-light">Salir del Sistema</a>');
}
if($_SESSION["caduca"] == 2){
	echo Alerts::Mensaje("Su cuenta ha expirado desde " . Encrypt::Decrypt($r["expira"],$_SESSION['secret_key']) . " Es Necesario que ingrese un codigo de activacion v&aacutelido para poder siguir usando el sistema o &eacuteste ser&aacute bloqueado. Ultima fecha para ingresar un c&oacutedigo es: ". Fechas::DiaSuma(Encrypt::Decrypt($r["expira"],$_SESSION['secret_key']), 5).". Cualquier duda contacte al administrador.","danger",'<a id="habilitar" op="126" class="btn btn-info waves-effect waves-light">Continuar Usandolo</a>','<a href="application/includes/logout.php" class="btn btn-danger waves-effect waves-light">Salir del Sistema</a>');
}
if($_SESSION["caduca"] == 3){
	echo Alerts::Mensaje("Su cuenta ha sido Bloqueada desde " . Encrypt::Decrypt($r["expira"],$_SESSION['secret_key']) . ". Para poder seguir usando el sistema debe ingresar un nuevo c&oacutedigo de activaci&oacuten v&aacutelido.","danger",'<a href="application/includes/logout.php" class="btn btn-danger waves-effect waves-light">Salir del Sistema</a>',NUll);
}

 unset($r); 

	}












////////////

	public function Ventas(){
		$db = new dbConn();

		$mes=date("m");
		@$ano=date("Y");
		$fecha="-$mes-$ano";

		$ap = $db->query("SELECT sum(total) FROM ticket_propina where fecha like '%$fecha' and td = ".$_SESSION['td']."");
		    foreach ($ap as $bp) { 
		    	$prop = $bp["sum(total)"];

		    } $ap->close();


	    $a = $db->query("SELECT sum(total) FROM ticket WHERE edo = 1 and td = ".$_SESSION["td"]." and fecha like '%$fecha'");
		    foreach ($a as $b) {
		     $total=$b["sum(total)"];
		    } $a->close();
		    return $total + $prop;
	}

	public function Gastos(){
		$db = new dbConn();

		$mes=date("m");
		@$ano=date("Y");
		$fecha="-$mes-$ano";

	    $a = $db->query("SELECT sum(cantidad) FROM gastos WHERE edo = 1 and tipo !=5 and td = ".$_SESSION["td"]." and fecha like '%$fecha'");
		    foreach ($a as $b) {
		     $total=$b["sum(cantidad)"];
		    } $a->close();
		    return $total;
	}

	public function Efectivo(){
		$db = new dbConn();

    if ($r = $db->select("efectivo,fecha", "corte_diario", "WHERE td = ".$_SESSION["td"]." order by id DESC LIMIT 1")) { 
        $efectivo = $r["efectivo"];
        $fecha = $r["fecha"];
    } unset($r);  

    	if($fecha == date("d-m-Y")){
    		$total = $efectivo;
		    return $total;	
		} else {
			$total = $efectivo + Corte::VentaHoy(date("d-m-Y")) - Corte::GastoHoy(date("d-m-Y")) + Corte::PropinaHoy(date("d-m-Y")) + Corte::EntradasEfectivo(date("d-m-Y"));
		    return $total;
		}

	   		
	}


	public function Remesas(){
		$db = new dbConn();

		$mes=date("m");
		@$ano=date("Y");
		$fecha="-$mes-$ano";

	    $a = $db->query("SELECT sum(cantidad) FROM gastos WHERE edo = 1 and tipo = 3 and td = ".$_SESSION["td"]." and fecha like '%$fecha'");
		    foreach ($a as $b) {
		     $total=$b["sum(cantidad)"];
		    } $a->close();
		    return $total;
	}


	public function Cheques(){
		$db = new dbConn();

		$mes=date("m");
		@$ano=date("Y");
		$fecha="-$mes-$ano";

	    $a = $db->query("SELECT sum(cantidad) FROM gastos WHERE tipo = 5 and td = ".$_SESSION["td"]." and fecha like '%$fecha'");
		    foreach ($a as $b) {
		     $total=$b["sum(cantidad)"];
		    } $a->close();
		    return $total;
	}



	public function LastUpdate(){
		$db = new dbConn();

		 if ($r = $db->select("*", "sync_up_cloud", "WHERE td = ".$_SESSION["td"]." and ejecutado = 1 order by id desc")) {
		    	if($r["fecha"] == date("d-m-Y")){
		    		return $r["hora"];
		    	} else {
		    		return $r["fecha"] . " | " . $r["hora"];
		    	}
		        
		    } unset($r);  

	}


	public function Diferencia(){

	   		$total = Inicio::Remesas() - Inicio::Cheques();
		    return $total;
	}


	public function Clave(){
			$numero = sha1(Fechas::Format(date("d-m-Y")));
			$num = substr("$numero", 0, 6);
			 return $num;
	}


		public function SiCorte(){
			if(Corte::VerificaApertura() == 0){
				return "Corte: " . Helpers::Dinero(Corte::GetDiferencia(date("d-m-Y")));
			} else {
				return 'Sin Corte';
			}
	}


	public function Root(){
	$corte = new Corte();

echo '<div class="row">

    <div class="col-xl-3 col-md-6 mb-4  col-sm-6 col-6">
      <div class="card-counter light">
        <i class="fas fa-cut"></i>
        <span class="count-numbers"><h5 class="font-weight-bold">'.Inicio::LastUpdate().'</h5></span>
        <span class="count-name">'.Inicio::SiCorte().'</span>
      </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4  col-sm-6 col-6">
      <div class="card-counter light">
        <i class="fas fa-money-bill-alt"></i>
        <span class="count-numbers"><h5 class="font-weight-bold">'.Helpers::Dinero($corte->VentaHoy(date("d-m-Y"))).'</h5></span>
        <span class="count-name">Venta Hoy</span>
      </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4  col-sm-6 col-6">
      <div class="card-counter light">
        <i class="fas fa-dollar-sign"></i>
        <span class="count-numbers"><h5 class="font-weight-bold">'. Helpers::Dinero($corte->GastoHoy(date("d-m-Y"))) .'</h5></span>
        <span class="count-name">Gastos Hoy</span>
      </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4  col-sm-6 col-6">
      <div class="card-counter light">
        <i class="fas fa-money-bill-wave"></i>
        <span class="count-numbers"><h5 class="font-weight-bold">'. Helpers::Dinero(Inicio::Efectivo()) .'</h5></span>
        <span class="count-name">Efectivo caja Chica</span>
      </div>
    </div>


  </div>';



echo '<hr>';
	
	}











		public function Admin(){
		$corte = new Corte();

echo '    <div class="row">

    <div class="col-xl-3 col-md-6 mb-4  col-sm-6 col-6">
      <div class="card-counter primary">
        <i class="fas fa-barcode"></i>
        <span class="count-numbers"><h5 class="font-weight-bold">'.Inicio::Clave().'</h5></span>
        <span class="count-name">';
        	if($_SESSION["user"] == "Erick"){
        		echo Helpers::CodigoValidacionHora();	
        	} else {
        		echo "Codigo";
        	}
        echo '</span>
      </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4  col-sm-6 col-6">
      <div class="card-counter danger">
        <i class="fas fa-file-invoice-dollar"></i>
        <span class="count-numbers"><h5 class="font-weight-bold">'. Helpers::Dinero($corte->TotalTx(date("d-m-Y"))) .'</h5></span>
        <span class="count-name">Total Tx</span>
      </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4  col-sm-6 col-6">
      <div class="card-counter success">
        <i class="fas fa-file-invoice"></i>
        <span class="count-numbers"><h5 class="font-weight-bold">'. Helpers::Dinero($corte->TotalNoTx(date("d-m-Y"))) .'</h5></span>
        <span class="count-name">Total No Tx</span>
      </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4  col-sm-6 col-6">
      <div class="card-counter info">
        <i class="fa fa-users"></i>
        <span class="count-numbers"><h5 class="font-weight-bold">'.Helpers::Entero($corte->ClientesHoy(date("d-m-Y"))).'</h5></span>
        <span class="count-name">Clientes</span>
      </div>
    </div>


  </div>';


if((Helpers::ServerDomain() == FALSE and $_SESSION["root_plataforma"] == 0) or (Helpers::ServerDomain() == TRUE and $_SESSION["root_plataforma"] == 1)){
echo '<div class="text-center"><a id="cambiar-pantalla-inicio" op="27x" class="btn btn-success">Ir a Facturar</a></div>';
}


		}











} // clase

?>