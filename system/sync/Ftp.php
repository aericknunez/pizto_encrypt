<?php 
class Ftp{

	public function __construct(){

	}



	public function Servidor($host,$login,$pass,$archivo,$ruta,$origen){ // conecta al host
		$archivox = $archivo . ".sql";
		if(@$ftp=ftp_connect($host)){

			ftp_login($ftp,$login,$pass);
			ftp_pasv($ftp, true); 

			ftp_chdir($ftp,$ruta); //ruta del server

				if (@ftp_put($ftp, $archivox, $origen, FTP_BINARY)) {
					$db = new dbConn();
				    
				    $cambio = array();
				    $cambio["subido"] = "1";
				    
				    if ($db->update("sync_up", $cambio, "WHERE creado = 1 and comprobacion = '$archivo' and subido = 0 and td = ".$_SESSION["temporal_td"]." limit 1")) {
				       return TRUE;
				    }

				} else{
					return FALSE;
				}
		
		} else {
			return FALSE;
		}
		

		ftp_quit($ftp);
	}






} // class
 ?>