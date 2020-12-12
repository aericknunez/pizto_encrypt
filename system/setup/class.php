<?php 
/**
 * aqui va la calse para registrar
 */
class Register {
	
	function __construct(){
		# code...
	}

	function CuentaClave($clave){
		if(strlen($clave) == 13 or strlen($clave) == 14 or strlen($clave) == 15){
			return TRUE;
		} else {
			return FALSE;
		}
	}

	function SanarClave($clave){
		return $res = substr($clave,10,-2);

	}

	function ObtenerCodigo($css, $clave, $td){ // (clave sananda) css clave sin sanar
		$cod = Encrypt::Encrypt($clave, $td . Fechas::Format(date("d-m-Y")));
		$codigo = substr($cod,0,4);
		return strtoupper($codigo);
	}


	function ValidarCodigo($clave, $codigo, $td){
		$clavex = $this->SanarClave($clave);
		$clavey = $this->ObtenerCodigo($clave, $clavex, $td);

		if($clavey == $codigo){
			return TRUE;
		} else {
			return FALSE;
		}
	}




	function ObtenerTipoCuenta($clave){
		return $tipo = substr($clave,3,1);
	}


	function ObtenerRand($clave){
		return $tipo = substr($clave,0,3);
	}


// $hash = "3-1-6d1a7c5b57cf56553ae79e3ae826ff0a";

// obtener el td y type del archivo
//     $fecha = date("d-m-Y");
//     $hora = date("H:i:s");
//   	$numero = strpos($hash, "-"); // extrae caracteres antes de -
// 	$td = substr($hash,0,$numero); // extrae el td
// 	$countc = strlen($td); // cuenta el numero de caracteres de td
// 	$type = substr($hash,$countc+1,1); // el numero de caracteres depues de td










}


 ?>