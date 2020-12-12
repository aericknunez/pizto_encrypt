<?php
include_once 'application/common/Helpers.php'; // [Para todo]
include_once 'application/common/Encrypt.php'; // 
include_once 'application/includes/variables_db.php';
include_once 'application/common/Mysqli.php';
include_once 'application/includes/DataLogin.php';
$db = new dbConn();
$seslog = new Login();
$seslog->sec_session_start();



if ($seslog->login_check() == TRUE) {
    include_once 'catalog/index.php';
} else {
	
	if ($seslog->DataCheckUp() == TRUE) {

			if(isset($_REQUEST["change"])){ // cambio de pantalla
				if($_SESSION["inicio"] == NULL){
					$_SESSION["inicio"] = 1;
				} else {
					unset($_SESSION["inicio"]);
				} header("location: ./");
			} // termina cambio de pantalla
	

			if(isset($_REQUEST["log"])){ // cambio de pantalla
				if($_SESSION["login_admin"] == NULL){
					$_SESSION["login_admin"] = 1;
				} else {
					unset($_SESSION["session_unluck"], $_SESSION["login_admin"]);
				} header("location: ./");
			} // termina cambio de pantalla



			//include_once 'catalog/login.php';
			if(Helpers::ServerDomain() == FALSE){ // si esta local
			  		if($_SESSION["inicio"] == NULL){
						include_once 'catalog/login_user.php';
					} else {
						
						if($_SESSION["login_admin"] == NULL){
							include_once 'catalog/login.php';
						} else {
							include_once 'catalog/login_admin.php';
						}
						
					}
			} else { // si esta en la web
				include_once 'catalog/login.php';
			}   

	} else {
		include_once 'system/setup/activar.php';
	}

}
?>