<?php
include_once '../application/common/Helpers.php'; // [Para todo]
include_once '../application/includes/variables_db.php';
include_once '../application/common/Fechas.php';
include_once '../application/common/Mysqli.php';
include_once '../application/includes/DataLogin.php';
$db = new dbConn();



$seslog = new Login();
$seslog->sec_session_start();

    $aa = $db->query("SELECT tabla FROM sync_tabla");
    foreach ($aa as $ba) {

       
	    $registro = $db->query("SELECT * FROM ". $ba["tabla"] . "");
	    foreach ($registro as $registros) {
	        
	            $cambio = array();
			    $cambio["hash"] = Helpers::HashId();
			    $cambio["time"] = Helpers::TimeId();
			    $db->update($ba["tabla"], $cambio, "WHERE id=". $registros["id"]);  
	      
	    } $registro->close();



    } $aa->close();



    $datos = array();
    $datos["creado"] = "1";
    $datos["subido"] = "1";
    $datos["ejecutado"] = "1";
    $datos["fecha"] = date("d-m-Y");
    $datos["hora"] = date("H:i:s");
    $datos["fechaF"] = Fechas::Format(date("d-m-Y"));
    $datos["comprobacion"] = "hashdeiniciodesistema";
    $datos["inicio"] = Helpers::TimeId();;
    $datos["final"] = Helpers::TimeId();;
    $datos["hash"] = Helpers::HashId();
    $datos["time"] = Helpers::TimeId();
    $datos["td"] = $_SESSION["temporal_td"];
    $db->insert("sync_up", $datos);
    
 ?>