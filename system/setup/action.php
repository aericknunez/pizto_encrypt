<?php 
// no olvidar cambiar la conexion a demo
include_once '../../application/common/Alerts.php';
$alert = new Alerts();
include_once '../../application/common/Helpers.php';
include_once '../../application/includes/variables_db.php';
include_once '../../application/common/Mysqli.php';
$db = new dbConn();

include_once '../../application/common/Encrypt.php';
include_once '../../application/common/Fechas.php';

include_once 'class.php';
$reg = new Register();

// validando todos los campos
if($_POST["nombre"] == NULL){
$alert->Alerta("warning","Error!","El campo nombre esta vacio!");
}if($_POST["clave"] == NULL){
$alert->Alerta("warning","Error!","El campo clave esta vacio!");
}if($reg->CuentaClave($_POST["clave"]) == FALSE){
$alert->Alerta("warning","Error!","El campo clave no es correcto!");
}if($_POST["codigo"] == NULL){
$alert->Alerta("warning","Error!","El campo codigo esta vacio!");
} else {
	/// aqui ira todo para insertar los datos


$expira = Fechas::DiaSuma(date("d-m-Y"),30);
$td = $reg->SanarClave($_POST["clave"]);


$tsis = $reg->ObtenerTipoCuenta($_POST["clave"]);
if($tsis == NULL){ // selecciono vatiable tipo sistema
	$tsis = 1;
}


		     if($reg->ValidarCodigo($_POST["clave"], $_POST["codigo"], md5($td)) == TRUE){
			 
			 $_SESSION['secret_key'] = md5($td);

		     	// inserta datos en root
		     	$datosr = array();
			    $datosr["expira"] = Encrypt::Encrypt($expira,$_SESSION['secret_key']);
			    $datosr["expiracion"] = Encrypt::Encrypt(Fechas::Format($expira),$_SESSION['secret_key']);
			    $datosr["tipo_sistema"] = Encrypt::Encrypt($tsis,$_SESSION['secret_key']);
			    $datosr["plataforma"] = Encrypt::Encrypt(0,$_SESSION['secret_key']);
			    $datosr["pantallas"] = Encrypt::Encrypt(0,$_SESSION['secret_key']);
			    $datosr["td"] = $td;
			    $datosr["hash"] = Helpers::HashId();
			    $datosr["time"] = Helpers::TimeId();
				$db->insert("config_root", $datosr);
		     	// inserta datos en config
		     	$datom = array();
			    $datom["sistema"] = "Sistema de control " . $_POST["nombre"];
			    $datom["cliente"] = $_POST["nombre"];
			    $datom["imp"] = 0;
			    $datom["propina"] = 0;
			    $datom["imagen"] = "default.png";
			    $datom["logo"] = "pizto.png";
			    $datom["skin"] = "grey-skin";
			    $datom["tipo_inicio"] = 1;
			    $datom["inicio_tx"] = 1;
			    $datom["otras_ventas"] = 1;
			    $datom["venta_especial"] =1;		    
			    $datom["td"] = $td;
			    $datom["hash"] = Helpers::HashId();
			    $datom["time"] = Helpers::TimeId();
				$db->insert("config_master", $datom);
		     	// inserta datos en user data

		     	$dat = array();
			    $dat["username"] = "Erick";
			    $dat["email"] = "aerick.nunez@gmail.com";
			    $dat["password"] = "50236c59c304c8b5c2f6b5c1af94f4416d998e3ba3fd2fc5a795f740431c35e9bbd9d4439a3dad8a182173b14291a308e4716458278fc228ad7c8f9930d9547e";
			    $dat["salt"] = "5f1e8cce7a67bf3282acf41dee11c7c784b5c8b6687bc4a10b3a81e2af81f186402d4f19e545b62e474f308f9dbc142eb3c66c6033b264cd0e1ffe1209cdf57d";
				$db->insert("login_members", $dat);

				$dat2 = array();
			    $dat2["username"] = "52ce5b";
			    $dat2["email"] = "admin@pizto.com";
			    $dat2["password"] = "98f0639d567c832700db09874cdd3880fb27f7b4ddadd060b121f5787a3623c61c3661995c20c776d057699a0dd958d24a093f912d35f38417c0ad5703d5bf88";
			    $dat2["salt"] = "c2114b413899e2b1227171de6194d45083ecf9b7b16553b4fecf96df6212901975c814fa564ec8510de0a39112591404415457e786f5fe39b334ab5ae992cbf3";
				$db->insert("login_members", $dat2);


				$log = array();
			    $log["nombre"] = "Erick Nunez";
			    $log["tipo"] = 1;
			    $log["user"] = "Erick";
			    $log["tkn"] = "1";
			    $log["avatar"] = "11.png";
			    $log["td"] = 0;
				$db->insert("login_userdata", $log);

				$log2 = array();
			    $log2["nombre"] = "Administrador del Sistema";
			    $log2["tipo"] = 2;
			    $log2["user"] = "52ce5b";
			    $log2["tkn"] = "1";
			    $log2["avatar"] = "11.png";
			    $log2["td"] = 0;
				$db->insert("login_userdata", $log2);

		     	// estabiliza al ted correcto
			        $cambio = array();
				    $cambio["td"] = $td;
				    if ($db->update("login_userdata", $cambio, "WHERE td != '$td'")) {
				        echo '<script>
							window.location.href="index.php"
						</script>';
				    } else {
						$alert->Alerta("warning","Error!","Ocurrio un error desconocido!");
					}

			} else {
			  $alert->Alerta("warning","Error!","La clave no coincide con el codigo otrogados!");
			}
} 


exit();

 ?>