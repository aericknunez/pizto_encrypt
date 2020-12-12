<?php
include_once '../application/common/Helpers.php'; // [Para todo]
include_once '../application/includes/variables_db.php';
include_once '../application/common/Mysqli.php';
include_once '../application/includes/DataLogin.php';
$db = new dbConn();
$seslog = new Login();
$seslog->sec_session_start();
include_once '../application/common/Fechas.php';


$fecha = date("d-m-Y");
$hora = date("H:i:s");

    if ($r = $db->select("td", "config_root", "WHERE id = 1")) { 
        $_SESSION["temporal_td"] = $r["td"];
    } unset($r);  



$data =  file_get_contents('https://hibridosv.com/app/api/bd_remota.php?x=' . $_SESSION["temporal_td"] . '&type=1');  
$datos = json_decode($data, true);

foreach ($datos as $valores) { // vamos hacer un archivo por cada hash
	$sync = $valores["hash"];

$a = $db->query("SELECT * FROM login_db_sync WHERE hash = '$sync'");
if($a->num_rows == 0){


      $updata = array('validate'=>  1,
      				  'hash'   	=>  $sync,
				      'type' 	=>  2,
				  	  'x'   	=>  $_SESSION["temporal_td"]);

    $api_url = "https://hibridosv.com/app/api/bd_remota.php";
    $client = curl_init($api_url);
    curl_setopt($client, CURLOPT_POST, true);
    curl_setopt($client, CURLOPT_POSTFIELDS, $updata);
    curl_setopt($client, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($client);
    curl_close($client);
    $result = json_decode($response, true);

	// print_r($result);
    foreach($result as $keys => $values){
	      if($result[$keys]['success'] == '1'){
	      		$dato = array();
				$dato["hash"] = $sync;
				$dato["fecha"] = $fecha;
				$dato["hora"] = $hora;
				$db->insert("login_db_sync", $dato);

				// aqui ejecuto el sql que deberia estar en el directorio descargado de git
				$archx = "sql/" . $sync . ".sql";            

				if (file_exists($archx)) {
				$sql = explode(";",file_get_contents($archx));//
				foreach($sql as $query){
				@$db->query($query);
				} @unlink($archx); } 

				//
	     }
    }



	} $a->close();




} // foreach





///////// actualizar el root
if($data = file_get_contents('https://pizto.com/admin/application/includes/root_json.php?x=' . $_SESSION["temporal_td"])){
	$cambio = json_decode($data, true);
	$db->update("config_root", $cambio, "WHERE td=".$_SESSION["temporal_td"]."");
}

unset($_SESSION["temporal_td"]);

?>