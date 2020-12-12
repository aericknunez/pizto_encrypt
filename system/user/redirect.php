<?php
include_once '../../application/common/Helpers.php'; // [Para todo]
include_once '../../application/includes/variables_db.php';
include_once '../../application/common/Mysqli.php';
$db = new dbConn();
include_once '../../application/includes/DataLogin.php';
$seslog = new Login();
$seslog->sec_session_start();



include_once '../../application/common/Alerts.php';
$alert = new Alerts;
$helps = new Helpers;
include_once '../../application/common/Fechas.php';
include_once '../../application/common/Encrypt.php';


// filtros para cuando no hay session abierta
if ($seslog->login_check() != TRUE) {
echo '<script>
	window.location.href="application/includes/logout.php"
</script>';
} 

if($_SESSION["user"] == NULL and $_SESSION["td"] == NULL){
echo '<script>
	window.location.href="application/includes/logout.php"
</script>';
exit();
}

if($_REQUEST["op"]=="1"){ // redirecciona despues de registrar a llenar datos
	include_once '../../application/includes/DataLogin.php';
	$seslog->Register($_POST);

}




if($_REQUEST["op"]=="2"){ // terminar actualizar
	if($_POST["nombre"] != NULL && $_POST["tipo"] != NULL){
	include_once 'Usuarios.php';
	$usuarios = new Usuarios;
	$usuarios->ActualizarUsuario(Helpers::Mayusculas($_POST["nombre"]),$_POST["tipo"],$_POST["user"]);	
	} else {
	Alerts::Alerta("error","Error!","Faltan Datos!");	
	}
}




if($_REQUEST["op"]=="3"){ // cambiar avatar
include_once 'Usuarios.php';
	$usuarios = new Usuarios;
	$usuarios->CambiarAvatar($_REQUEST["iden"],$_REQUEST["user"]);
}


if($_REQUEST["op"]=="4"){ // redirecciona despues de registrar a llenar datos
echo '<script>
    window.location.href="../../?modal=register_success&user=' . $_REQUEST["user"] . '";
</script>';
}

/// usuarios
if($_REQUEST["op"]=="5"){
include_once 'Usuarios.php';
$usuarios = new Usuarios;
$passw1 = filter_input(INPUT_POST, 'pass1', FILTER_SANITIZE_STRING);
$passw2 = filter_input(INPUT_POST, 'pass2', FILTER_SANITIZE_STRING);


if($_SESSION['config_clave_simple'] == "on"){
	$claseComparar = "CompararPassInseguro";
} else {
	$claseComparar = "CompararPass";
}


$usuarios->$claseComparar($passw1, $passw2); 
}


if($_REQUEST["op"]=="6"){ /// para el modal del avatar
include_once 'Usuarios.php';
$usuarios = new Usuarios;
$usuarios->AvatarSelect($_REQUEST["username"]);
}


if($_REQUEST["op"]=="7"){
include_once 'Usuarios.php';
$usuarios = new Usuarios;
$usuarios->EliminarUsuario($_REQUEST["iden"], $_REQUEST["username"]);
}





if($_REQUEST["op"]=="8"){
include_once 'Usuarios.php';
$usuarios = new Usuarios;
$usuarios->VerUsuarios($_SESSION["ver_avatar"]);
}


if($_REQUEST["op"]=="9"){
include_once 'Usuarios.php';
$usuarios = new Usuarios;
$usuarios->ModalPass($_REQUEST["username"]);
}



if($_REQUEST["op"]=="10"){
include_once 'Usuarios.php';
$usuarios = new Usuarios;
$usuarios->ModalUpdate($_REQUEST["username"]);
}



?>