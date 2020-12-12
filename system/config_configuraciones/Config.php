<?php 
class Config{

	public function __construct() { 
     } 


	public function Configuraciones($data){
		$db = new dbConn();

	if($data["pais"] == 1){
		$moneda = "Dolares"; $simbolo = "$"; $imp = "IVA"; $doc = "NIT";
	}if($data["pais"] == 2){
		$moneda = "Lempiras"; $simbolo = "L"; $imp = "ISV"; $doc = "RTN";
	}if($data["pais"] == 3){
		$moneda = "Quetzales"; $simbolo = "Q"; $imp = "IVA"; $doc = "NIT";
	}
		$cambio = array();
	    $cambio["sistema"] = $data["sistema"];
	    $cambio["cliente"] = $data["cliente"];
	    $cambio["slogan"] = $data["slogan"];
	    $cambio["propietario"] = $data["propietario"];
	    $cambio["telefono"] = $data["telefono"];
	    $cambio["direccion"] = $data["direccion"];
	    $cambio["email"] = $data["email"];
	    $cambio["pais"] = $data["pais"];
	    $cambio["giro"] = $data["giro"];
	    $cambio["nit"] = $data["nit"];
	    $cambio["imp"] = $data["imp"];
	    $cambio["propina"] = $data["propina"];
	    $cambio["nombre_impuesto"] = $imp;
	    $cambio["nombre_documento"] = $doc;
	    $cambio["moneda"] = $moneda;
	    $cambio["moneda_simbolo"] = $simbolo;
	    $cambio["tipo_inicio"] = $data["tipo_inicio"];
	    $cambio["tipo_menu"] = $data["tipo_menu"];
	    $cambio["skin"] = $data["skin"];
	    $cambio["inicio_tx"] = $data["inicio_tx"];
	    $cambio["otras_ventas"] = $data["otras_ventas"];
	    $cambio["venta_especial"] = $data["venta_especial"];
	    $cambio["imprimir_antes"] = $data["imprimir_antes"];
	    $cambio["imprimir_comanda"] = $data["imprimir_comanda"];
	    $cambio["cambio_tx"] = $data["cambio_tx"];
	    $cambio["sonido"] = $data["sonido"];
	    $cambio["clave_simple"] = $data["clave_simple"];
	    $cambio["tcredito"] = $data["tcredito"];
	    $cambio["umesas"] = $data["umesas"];
	    $cambio["aqui"] = $data["aqui"];
	    if (Helpers::UpdateId("config_master", $cambio, "td = ".$_SESSION["td"]."")) {
	    	$this->CrearVariables();
	        Alerts::Alerta("success","Realizado!","Registros actualizados correctamente");
	    } else {
	       Alerts::Alerta("error","Error!","Ocurrio un error desconocido!");   
	    }

	
	}



	public function Root($data){
		$db = new dbConn();

		$expira = Encrypt::Encrypt($data["expira"],$_SESSION['secret_key']);
		$expiracion = Encrypt::Encrypt(Fechas::Format($_POST["expira"]),$_SESSION['secret_key']);
		$pantallas = Encrypt::Encrypt($_POST["pantallas"],$_SESSION['secret_key']);
		$ftp_servidor = Encrypt::Encrypt($_POST["ftp_servidor"],$_SESSION['secret_key']);
		$ftp_path = Encrypt::Encrypt($_POST["ftp_path"],$_SESSION['secret_key']);
		$ftp_ruta = Encrypt::Encrypt($_POST["ftp_ruta"],$_SESSION['secret_key']);
		$ftp_user = Encrypt::Encrypt($_POST["ftp_user"],$_SESSION['secret_key']);
		$ftp_password = Encrypt::Encrypt($_POST["ftp_password"],$_SESSION['secret_key']);
		$tipo_sistema = Encrypt::Encrypt($_POST["tipo_sistema"],$_SESSION['secret_key']);
		$plataforma = Encrypt::Encrypt($_POST["plataforma"],$_SESSION['secret_key']);

		$cambio = array();
	    $cambio["expira"] = $expira;
	    $cambio["expiracion"] = $expiracion;
	    $cambio["pantallas"] = $pantallas;
	    $cambio["ftp_servidor"] = $ftp_servidor;
	    $cambio["ftp_path"] = $ftp_path;
	    $cambio["ftp_ruta"] = $ftp_ruta;
	    $cambio["ftp_user"] = $ftp_user;
	    $cambio["ftp_password"] = $ftp_password;
	    $cambio["tipo_sistema"] = $tipo_sistema;
	    $cambio["plataforma"] = $plataforma;
	    
	    if (Helpers::UpdateId("config_root", $cambio, "td = ".$_SESSION["td"]."")) {
	    	$this->CrearVariables();
	        Alerts::Alerta("success","Realizado!","Registros actualizados correctamente");
	    } else {
	       Alerts::Alerta("error","Error!","Ocurrio un error desconocido!");   
	    }

	
	}











public function CrearIconos($url, $msj){

	if($_SESSION["config_tipo_menu"] == 2){
		$this->CrearIconosResponsivos($url, $msj);
	} else {
		$this->CrearIconosDefault($url, $msj);
	}
}







public function CrearIconosDefault($url, $msj){
	$db = new dbConn();

//total de registros
$in = $db->query("SELECT * FROM images WHERE td = ".$_SESSION["td"]."");
$reg = $in->num_rows;
$in->close(); 


if($reg > 0){  // si hay registros

$return.= "<div class=\"row text-center \"> 
   <ul class=\"gallery\"> \n\n";

 $a = $db->query("Select * from images where popup='0' and td = ".$_SESSION["td"]." order by img_order asc");
    foreach ($a as $b) {

if($r = $db->select("panel", "control_panel_mostrar", "WHERE producto = '".$b["cod"]."' and td = ".$_SESSION["td"]."")){ $panel = $r["panel"]; } unset($r); 

if($r = $db->select("nombre, categoria", "producto", "WHERE cod = '".$b["cod"]."' and td = ".$_SESSION["td"]."")){ $nombre = $r["nombre"]; $categoria = $r["categoria"]; } unset($r); 


/// si es un producto o una categoria
if($b["cod"] <= 9900){
//Verifico las opciones activas
$ax = $db->query("SELECT * FROM opciones_asig WHERE producto = '".$b["cod"]."' and td = ".$_SESSION["td"]."");
$activas = $ax->num_rows;
$ax->close();
	
	if($activas > 0){ // opciones activas

$return .= '<li><a id="ventaopcion" op="19" cod="'.$b["cod"].'" mesa="<? echo $_SESSION["mesa"] ?>" cliente="<? echo $_SESSION["clientselect"] ?>" panel="'.$panel.'"><em>'.$nombre.'</em><img src="'.$b["img_name"].'" alt="'.$nombre.'" class="img-fluid wow fadeIn" /></a></li>';		
$return.= "\n\n";

	} else { // opciones inactivas

$return .= '<li><a id="venta" op="20" cod="'.$b["cod"].'" mesa="<? echo $_SESSION["mesa"] ?>" cliente="<? echo $_SESSION["clientselect"] ?>" panel="'.$panel.'"><em>'.$nombre.'</em><img src="'.$b["img_name"].'" alt="'.$nombre.'" class="img-fluid wow fadeIn" /></a></li>';	
$return.= "\n\n";

	}


} else { // si es categoria

if($r = $db->select("categoria", "categorias", "WHERE cod = '".$b["cod"]."' and td = ".$_SESSION["td"]."")){ 
	$ncat = $r["categoria"]; } unset($r); 

$return .= '<li><a data-target="#a'.$b["cod"].'" data-toggle="modal"><em>'.$ncat.'</em><img src="'.$b["img_name"].'" alt="'.$ncat.'" class="img-fluid wow fadeIn" /></a></li>';
$return.= "\n\n";

}

unset($panel);


} $a->close(); // temina recorrido por las imagenes


//// aqui agregamos las opciones de otras ventas y venta especial

if($_SESSION['config_otras_ventas'] == 1){
$return.= '<li><a href="?modal=otras_ventas&mesa=<? echo $_SESSION["mesa"]; ?>&cliente=<? echo $_SESSION["clientselect"] ?>"><em>Otras Ventas</em><img src="assets/img/ico/dfs.png" alt="image" class="img-fluid wow fadeIn" /></a></li>';
$return.= " \n \n";	
}

if($_SESSION['config_venta_especial'] == 1){
$return.= '<li><a href="?modal=venta_especial&mesa=<? echo $_SESSION["mesa"]; ?>&cliente=<? echo $_SESSION["clientselect"] ?>"><em>Venta Especial</em><img src="assets/img/ico/as.png" alt="image" class="img-fluid wow fadeIn" /></a></li>';
$return.= "\n\n";	
}


$return.= " </ul> \n </div> \n \n";


/// va lo de las categorias

$a = $db->query("Select * from categorias WHERE td = ".$_SESSION["td"]." order by id asc");
    foreach ($a as $b) {
    	$name=$b['categoria'];
		  $cod=$b["cod"];


$ar = $db->query("SELECT * FROM producto WHERE categoria = '".$b["cod"]."' and td = ".$_SESSION["td"]."");
$numerom=$ar->num_rows;
$ar->close();

if($numerom > 24) $large="modal-fluid";
if($numerom < 25 and $numerom > 12) $large="modal-lg";
if($numerom < 13 and $numerom > 6) $large="modal-md";
if($numerom < 7 and $numerom > 0) $large="modal-sm";

$return.= '<!-- POPUP CON EL CODIGO '; $return.= $b["cod"]; $return.= ' ';  $return.= $b["categoria"]; $return.= " --> \n \n";

$return.= '<div class="modal" id="a';
$return.= $b["cod"];
$return.= '" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog '; $return.= $large; $return.='" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">'; $return.= $b["categoria"]; $return.= '</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">';


$return.= "<div class=\"row text-center \"> 
   <ul class=\"gallery\"> \n\n";

 $ax = $db->query("Select * from images where popup='".$b["cod"]."' and td = ".$_SESSION["td"]." order by img_order asc");
    foreach ($ax as $bx) {

if($r = $db->select("panel", "control_panel_mostrar", "WHERE producto = '".$bx["cod"]."' and td = ".$_SESSION["td"]."")){ $panel = $r["panel"]; } unset($r); 

if($r = $db->select("nombre, categoria", "producto", "WHERE cod = '".$bx["cod"]."' and td = ".$_SESSION["td"]."")){ $nombre = $r["nombre"]; $categoria = $r["categoria"]; } unset($r); 


//Verifico las opciones activas
$ay = $db->query("SELECT * FROM opciones_asig WHERE producto = '".$bx["cod"]."' and td = ".$_SESSION["td"]."");
$activas = $ay->num_rows;
$ay->close();
	
	if($activas > 0){ // opciones activas

$return .= '<li><a id="ventaopcion" op="19" cod="'.$bx["cod"].'" mesa="<? echo $_SESSION["mesa"] ?>" cliente="<? echo $_SESSION["clientselect"] ?>" panel="'.$panel.'"><em>'.$nombre.'</em><img src="'.$bx["img_name"].'" alt="'.$nombre.'" class="img-fluid wow fadeIn" /></a></li>';		
$return.= "\n\n";

	} else { // opciones inactivas

$return .= '<li><a id="venta" op="20" cod="'.$bx["cod"].'" mesa="<? echo $_SESSION["mesa"] ?>" cliente="<? echo $_SESSION["clientselect"] ?>" panel="'.$panel.'"><em>'.$nombre.'</em><img src="'.$bx["img_name"].'" alt="'.$nombre.'" class="img-fluid wow fadeIn" /></a></li>';	
$return.= "\n\n";

	}

unset($panel);


} $ax->close(); // temina recorrido por las imagenes

$return.= " </ul> \n </div> \n \n";

  

 $return.= "</div>
      <div class=\"modal-footer\">
        <button type=\"button\" class=\"btn btn-primary btn-rounded\" data-dismiss=\"modal\">Cerrar</button>
      </div>
    </div>
  </div>
</div>";   
		

}  $a->close();
/// terminan los modales


/// modal de opciones
$return.= "\n \n";

 $return.= '<div class="modal" id="ModalOpciones" tabindex="-1" role="dialog" aria-labelledby="ModalOpciones" aria-hidden="true"  data-backdrop="false">
		  <div class="modal-dialog modal-md" role="document">
		    <div class="modal-content">
		      <div class="modal-header">
		        <h5 class="modal-title" id="exampleModalLabel">
		         ELIJA UNA OPCION</h5>
		      </div>
		      <div class="modal-body">

		<div id="vista_opcion"></div>

		</div>

  </div>
</div>
</div>'; 


} else { // si no hay registros

$return.= '<? '; 
$return.= 'Alerts::Mensajex("No hay iconos que mostrar, por favor ingrese sus productos para poder realizar sus ventas","danger","<a href=\"?iconos\" class=\"btn btn-success btn-sm\">CREAR ICONOS</a>","<a href=\"https://pizto.com/help#iconos\" class=\"btn btn-primary\" target=\"_blank\"><i class=\"fas fa-info-circle \"></i> VER COMO HACERLO </a>");'; 
$return.= ' ?>'; 

}

/// guarda el resultado del archivo
if($handle = fopen($url . "iconos_".$_SESSION["td"].".php",'w+')){

	if($msj != NULL){
		$alert = new Alerts;
	$alert->Alerta("success","Realizado!","Iconos creados correctamente");
	}
	
}
fwrite($handle,$return);
fclose($handle);


} // fin de la funcion














public function CrearIconosResponsivos($url, $msj){
	$db = new dbConn();

//total de registros
$in = $db->query("SELECT * FROM images WHERE td = ".$_SESSION["td"]."");
$reg = $in->num_rows;
$in->close(); 


if($reg > 0){  // si hay registros

$return.= "<div class=\"container-fluid\"> \n\n";
$row = 0;
$col = 0;
$count = 0;

 $a = $db->query("Select * from images where popup='0' and td = ".$_SESSION["td"]." order by img_order asc");
    $rec = $a->num_rows;
    $recx = $rec;
    foreach ($a as $b) {
$row++;
$col++;
$count++;
/// condicionales para row and col
if($row == 1){
	$return .= '<div class="row">';
					$return.= " \n \n";	
}
if($col == 1){
	$return .= '<div class="col-xl-6">
        			<div class="row">';
        			$return.= " \n \n";	
}
//////////
if($count == 1){
	if($_SESSION['config_otras_ventas'] == 1){
	$recx++;
	$return.= '
				<div class="col-3 col-md-3">
	                <div class="newmenu text-center">
	                    <a href="?modal=otras_ventas&mesa=<? echo $_SESSION["mesa"]; ?>&cliente=<? echo $_SESSION["clientselect"] ?>" title="Otras Ventas">
	                    <img src="assets/img/ico/dfs.png" class="img-fluid wow fadeIn">
	                    <div class="menu-title">Otras Ventas</div> 
	                    </a>
	                </div>
	            </div>';
	$return.= " \n \n";	
	$row++;
	$col++;
	$count++;
	}

	if($_SESSION['config_venta_especial'] == 1){
	$recx++;
	$return.= '
				<div class="col-3 col-md-3">
	                <div class="newmenu text-center">
	                    <a href="?modal=venta_especial&mesa=<? echo $_SESSION["mesa"]; ?>&cliente=<? echo $_SESSION["clientselect"] ?>" title="Venta Especial">
	                    <img src="assets/img/ico/as.png" class="img-fluid wow fadeIn">
	                    <div class="menu-title">Venta Especial</div> 
	                    </a>
	                </div>
	            </div>';
	$return.= " \n \n";
	$row++;
	$col++;
	$count++;
	}
}


if($r = $db->select("panel", "control_panel_mostrar", "WHERE producto = '".$b["cod"]."' and td = ".$_SESSION["td"]."")){ $panel = $r["panel"]; } unset($r); 

if($r = $db->select("nombre, categoria", "producto", "WHERE cod = '".$b["cod"]."' and td = ".$_SESSION["td"]."")){ $nombre = $r["nombre"]; $categoria = $r["categoria"]; } unset($r); 


/// si es un producto o una categoria
if($b["cod"] <= 9900){
//Verifico las opciones activas
$ax = $db->query("SELECT * FROM opciones_asig WHERE producto = '".$b["cod"]."' and td = ".$_SESSION["td"]."");
$activas = $ax->num_rows;
$ax->close();
	
	if($activas > 0){ // opciones activas

$return .= '
			<div class="col-3 col-md-3">
                <div class="newmenu text-center">
                    <a id="ventaopcion" op="19" cod="'.$b["cod"].'" mesa="<? echo $_SESSION["mesa"] ?>" cliente="<? echo $_SESSION["clientselect"] ?>" panel="'.$panel.'" title="'.ucwords(strtolower($nombre)).'">
                    <img src="'.$b["img_name"].'" class="img-fluid wow fadeIn">
                    <div class="menu-title text-truncate">'.ucwords(strtolower($nombre)).'</div> 
                    </a>
                </div>
            </div>';		
$return.= "\n\n";


	} else { // opciones inactivas

$return .= '
			<div class="col-3 col-md-3">
                <div class="newmenu text-center">
                    <a id="venta" op="20" cod="'.$b["cod"].'" mesa="<? echo $_SESSION["mesa"] ?>" cliente="<? echo $_SESSION["clientselect"] ?>" panel="'.$panel.'" title="'.ucwords(strtolower($nombre)).'">
                    <img src="'.$b["img_name"].'" class="img-fluid wow fadeIn">
                    <div class="menu-title2 text-truncate">'.ucwords(strtolower($nombre)).'</div> 
                    </a>
                </div>
            </div>';	
$return.= "\n\n";
	}

unset($panel);

} else { // si es categoria

if($r = $db->select("categoria", "categorias", "WHERE cod = '".$b["cod"]."' and td = ".$_SESSION["td"]."")){ 
	$ncat = $r["categoria"]; } unset($r); 

$return .= '
			<div class="col-3 col-md-3">
                <div class="newmenu text-center">
                    <a data-target="#a'.$b["cod"].'" data-toggle="modal" title="'.ucwords(strtolower($ncat)).'">
                    <img src="'.$b["img_name"].'" class="img-fluid wow fadeIn">
                    <div class="menu-title text-truncate">'.ucwords(strtolower($ncat)).'</div> 
                    </a>
                </div>
            </div>';
$return.= "\n\n";

}

// condicionales para row and col
if($col == 4 or  $recx == $count){
	$return.= "</div> \n
    		</div> \n \n";
   	$col = 0;
}
if($row == 8 or $recx == $count){
	$return.= "</div> \n";
   $row = 0;
}

} $a->close(); // temina recorrido por las imagenes





$return.= "</div> \n \n";

/// va lo de las categorias

$a = $db->query("Select * from categorias WHERE td = ".$_SESSION["td"]." order by id asc");
    foreach ($a as $b) {
    	$name=$b['categoria'];
		  $cod=$b["cod"];


$ar = $db->query("SELECT * FROM producto WHERE categoria = '".$b["cod"]."' and td = ".$_SESSION["td"]."");
$numerom=$ar->num_rows;
$ar->close();

if($numerom > 24) { $large="modal-fluid"; $ancho = "col-3 col-md-3"; }
if($numerom < 25 and $numerom > 12) { $large="modal-lg"; $ancho = "col-3"; }
if($numerom < 13 and $numerom > 0) { $large="modal-md"; $ancho = "col-4"; }

$return.= '<!-- POPUP CON EL CODIGO '; $return.= $b["cod"]; $return.= ' ';  $return.= $b["categoria"]; $return.= " --> \n \n";

$return.= '<div class="modal" id="a';
$return.= $b["cod"];
$return.= '" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog '; $return.= $large; $return.='" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">'; $return.= $b["categoria"]; $return.= '</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">';


$return.= "<div class=\"container-fluid\"> \n\n";
$row = 0;
$col = 0;
$count = 0;

 $ax = $db->query("Select * from images where popup='".$b["cod"]."' and td = ".$_SESSION["td"]." order by img_order asc");
 	$regx=$ax->num_rows;
    foreach ($ax as $bx) {
$row++;
$col++;
$count++;
/// condicionales para row and col
if($numerom > 24) {
	if($row == 1){
		$return .= '<div class="row"> ';
	}
	if($col == 1){
		$return .= '<div class="col-xl-6">
	        			<div class="row">';
	}
} else {
	if($row == 1){
		$return .= '<div class="row"> ';
	}
}
//////////

if($r = $db->select("panel", "control_panel_mostrar", "WHERE producto = '".$bx["cod"]."' and td = ".$_SESSION["td"]."")){ $panel = $r["panel"]; } unset($r); 

if($r = $db->select("nombre, categoria", "producto", "WHERE cod = '".$bx["cod"]."' and td = ".$_SESSION["td"]."")){ $nombre = $r["nombre"]; $categoria = $r["categoria"]; } unset($r); 


//Verifico las opciones activas
$ay = $db->query("SELECT * FROM opciones_asig WHERE producto = '".$bx["cod"]."' and td = ".$_SESSION["td"]."");
$activas = $ay->num_rows;
$ay->close();
	
	if($activas > 0){ // opciones activas

$return .= '<div class="'.$ancho.'">
                <div class="newmenu text-center">
                    <a id="ventaopcion" op="19" cod="'.$bx["cod"].'" mesa="<? echo $_SESSION["mesa"] ?>" cliente="<? echo $_SESSION["clientselect"] ?>" panel="'.$panel.'" title="'.ucwords(strtolower($nombre)).'">
                    <img src="'.$bx["img_name"].'" class="img-fluid wow fadeIn">
                    <div class="menu-titleC text-truncate">'.ucwords(strtolower($nombre)).'</div> 
                    </a>
                </div>
            </div>';		
$return.= "\n\n";

	} else { // opciones inactivas

$return .= '<div class="'.$ancho.'">
                <div class="newmenu text-center">
                    <a id="venta" op="20" cod="'.$bx["cod"].'" mesa="<? echo $_SESSION["mesa"] ?>" cliente="<? echo $_SESSION["clientselect"] ?>" panel="'.$panel.'" title="'.ucwords(strtolower($nombre)).'">
                    <img src="'.$bx["img_name"].'" class="img-fluid wow fadeIn">
                    <div class="menu-titleC text-truncate">'.ucwords(strtolower($nombre)).'</div> 
                    </a>
                </div>
            </div>';	
$return.= "\n\n";


	}

unset($panel);
// condicionales para row and col
if($numerom > 24) {
	if($col == 4 or $regx == $count){
		$return.= "</div> \n
	    		</div> \n \n";
	   	$col = 0;
	}
	if($row == 8 or $regx == $count){
		$return.= "</div> \n";
	   $row = 0;
	}
} else {
	if($row == 8 or $regx == $count){
		$return.= "</div> \n";
	   $row = 0;	
	 }
}

} $ax->close(); // temina recorrido por las imagenes

$return.= "</div> \n \n";

  

 $return.= "</div>
      <div class=\"modal-footer\">
        <button type=\"button\" class=\"btn btn-primary btn-rounded\" data-dismiss=\"modal\">Cerrar</button>
      </div>
    </div>
  </div>
</div>";   
		

}  $a->close();
/// terminan los modales


/// modal de opciones
$return.= "\n \n";

 $return.= '<div class="modal" id="ModalOpciones" tabindex="-1" role="dialog" aria-labelledby="ModalOpciones" aria-hidden="true"  data-backdrop="false">
		  <div class="modal-dialog modal-md" role="document">
		    <div class="modal-content">
		      <div class="modal-header">
		        <h5 class="modal-title" id="exampleModalLabel">
		         ELIJA UNA OPCION</h5>
		      </div>
		      <div class="modal-body">

		<div id="vista_opcion"></div>

		</div>
  </div>
</div>
</div>'; 


} else { // si no hay registros

$return.= '<? '; 
$return.= 'Alerts::Mensajex("No hay iconos que mostrar, por favor ingrese sus productos para poder realizar sus ventas","danger","<a href=\"?iconos\" class=\"btn btn-success btn-sm\">CREAR ICONOS</a>","<a href=\"https://pizto.com/help#iconos\" class=\"btn btn-primary\" target=\"_blank\"><i class=\"fas fa-info-circle \"></i> VER COMO HACERLO </a>");'; 
$return.= ' ?>'; 

}

/// guarda el resultado del archivo
if($handle = fopen($url . "iconos_".$_SESSION["td"].".php",'w+')){

	if($msj != NULL){
		$alert = new Alerts;
	$alert->Alerta("success","Realizado!","Iconos creados correctamente");
	}
	
}
fwrite($handle,$return);
fclose($handle);


} // fin de la funcion





///cambiar imagen del producto por una personalizada
   public function CambiarIcono($img, $cod){
          $db = new dbConn();


// obtengo la imagen actual para borrarla
$r = $db->select("img_name", "images", "where cod = ". $cod ." and td = ".$_SESSION['td']."");
 $imagen=$r["img_name"]; unset($r);


    $cambio = array();
    $cambio["img_name"] = $img;
    if(Helpers::UpdateId("images", $cambio, "cod = '$cod' and td = ".$_SESSION["td"]."")){

// si es una imagen subida se borrara
if (strpos($imagen, 'icoimg') !== false) {
       if (file_exists("../../" . $imagen)) {
           @unlink("../../" . $imagen);
       }	
}
////




    	Alerts::Alerta("success","Realizado!","Imagen cambiada correctamente");
    }

    $precios = new ConfigP();   
    $precios->VerTodosPrecio();
 }











	





	public function CrearVariables(){
		$db = new dbConn();
		$encrypt = new Encrypt;

		if ($r = $db->select("*", "config_master", "WHERE td = ".$_SESSION['td']."")) { 

			$_SESSION['config_sistema'] = $r["sistema"];
			$_SESSION['config_cliente'] = $r["cliente"];
			$_SESSION['config_slogan'] = $r["slogan"];
			$_SESSION['config_propietario'] = $r["propietario"];
			$_SESSION['config_telefono'] = $r["telefono"];
			$_SESSION['config_giro'] = $r["giro"];
			$_SESSION['config_nit'] = $r["nit"];
			$_SESSION['config_imp'] = $r["imp"];
			$_SESSION['config_propina'] = $r["propina"];
			$_SESSION['config_direccion'] = $r["direccion"];
			$_SESSION['config_email'] = $r["email"];
			$_SESSION['config_imagen'] = $r["imagen"];
			$_SESSION['config_logo'] = $r["logo"];
			$_SESSION['config_skin'] = $r["skin"];
			$_SESSION['tipo_inicio'] = $r["tipo_inicio"];
			$_SESSION['config_tipo_menu'] = $r["tipo_menu"];

			$_SESSION['config_pais'] = $r["pais"];
			$_SESSION['config_moneda'] = $r["moneda"];
			$_SESSION['config_moneda_simbolo'] = $r["moneda_simbolo"];
			$_SESSION['config_nombre_impuesto'] = $r["nombre_impuesto"];
			$_SESSION['config_nombre_documento'] = $r["nombre_documento"];
			$_SESSION['tx'] = $r["inicio_tx"];
			$_SESSION['config_otras_ventas'] = $r["otras_ventas"];
			$_SESSION['config_venta_especial'] = $r["venta_especial"];
			
			$_SESSION['config_imprimir_antes'] = $r["imprimir_antes"];
			$_SESSION['config_imprimir_comanda'] = $r["imprimir_comanda"];
			$_SESSION['config_cambio_tx'] = $r["cambio_tx"];
			$_SESSION['config_sonido'] = $r["sonido"];
			$_SESSION['config_clave_simple'] = $r["clave_simple"];
			$_SESSION['config_tcredito'] = $r["tcredito"];
			$_SESSION['config_umesas'] = $r["umesas"];
			$_SESSION['config_aqui'] = $r["aqui"];

			if($_SESSION['config_skin'] == NULL) $_SESSION['config_skin'] = "mdb-skin";
			// white-skin , mdb-skin , grey-skin , pink-skin ,  light-blue-skin , black-skin  cyan-skin, navy-blue-skin

			// fixed-sn , hidden-sn
			} unset($r);

			    // para root pero sin descifrar
			if ($root = $db->select("*", "config_root", "WHERE td = ".$_SESSION['td']."")) {

			$_SESSION['root_expira'] = $root["expira"];
			$_SESSION['root_expiracion'] = $root["expiracion"];
			$_SESSION['root_tipo_sistema'] = $root["tipo_sistema"];
			$_SESSION['root_plataforma'] = $root["plataforma"];
     
			} unset($root);
			$_SESSION['root_tipo_sistema'] = $encrypt->Decrypt(
  			$_SESSION['root_tipo_sistema'],$_SESSION['secret_key']);

			$_SESSION['root_plataforma'] = $encrypt->Decrypt(
			$_SESSION['root_plataforma'],$_SESSION['secret_key']);


		if ($r = $db->select("*", "config_opciones", "WHERE td = ".$_SESSION['td']."")) { 

			$_SESSION['config_o_tipo_corte'] = $r["tipo_corte"];
			$_SESSION['config_o_tiempo_del_mesero'] = $r["tiempo_del_mesero"];
			$_SESSION['config_o_ticket_pantalla'] = $r["ticket_pantalla"];
			$_SESSION['config_o_no_caja'] = $r["no_caja"];
			$_SESSION['config_o_no_mesas'] = $r["no_mesas"];
			$_SESSION['config_o_registro_borrar'] = $r["registro_borrar"];
			$_SESSION['config_o_cometarios_comanda'] = $r["cometarios_comanda"];

			} unset($r);



	}



	public function AddSucursal($user,$td){
		$db = new dbConn();

	    $datos = array();
	    $datos["user"] = $user;
	    $datos["sucursal"] = $td;
	    if ($db->insert("login_sucursales", $datos)) {
	    Alerts::Alerta("success","Agregado Correctamente","Usuario agregado correctamente a la sucursal");
	    } else {
	    Alerts::Alerta("danger","Error","Ocurrio un error inesperado");
	    }
		$this->CuentasSucursal($_SESSION['user']);

	}


	public function CuentasSucursal($user){
		$db = new dbConn();
	
	if($_SESSION["tipo_cuenta"] == 1 and $_SESSION["td"] != 0){ 
	 $a = $db->query("SELECT * FROM login_sucursales order by user desc");
	} else {
		$a = $db->query("SELECT * FROM login_sucursales WHERE user = '$user'");
	}

	if($a->num_rows > 0){
	 echo '<table class="table table-sm table-striped">
			  <thead>
			    <tr>
			    <th scope="col">Usuario</th>
			      <th scope="col">Nombre del Sistema</th>
			      <th scope="col">Pais</th>
			      <th scope="col">Cambiar</th>
			    </tr>
			  </thead>
			  <tbody>';
	    foreach ($a as $b) {  
		    $r = $db->select("cliente, pais, td", "config_master", "WHERE td = ".$b["sucursal"]."");

		    // ultima actualizacion
	    		if ($rx = $db->select("*", "login_sync", "WHERE td = ".$b["sucursal"]." and edo = 1 order by id desc")) {
		    		$update = $rx["fecha"] . " | " . $rx["hora"];		        
		    	} unset($rx);



	    	$userx = $b["user"];
	    	$x = $db->select("nombre", "login_userdata", "WHERE user = '$userx'");
		    echo '<tr>
		    	  <th scope="col">'.$x["nombre"].'</th>
			      <th scope="col">'.$r["td"].' - '.$r["cliente"].'</th>
			      <th scope="col">'.Helpers::Pais($r["pais"]).'</th>			      
			      <th scope="col">';
				if($b["sucursal"] == $_SESSION['td']){
					echo '<a id="predeterminar" op="131" iden="'.$b["sucursal"].'" class="btn-sm">Predeterminar  <i class="fas fa-play red-text"></i></a>';
				} else {
					echo '<a id="irlocal" op="129" iden="'.$b["sucursal"].'" class="btn-sm">Seleccionar  <i class="fas fa-play blue-text"></i></a>';
				}
			echo '</th>
			    </tr>';
		unset($r);
		unset($x);
	    } 
	    echo '</tbody>
		    </table>';
		} else {
			echo '<h1 class="text-danger text-center">No tiene mas sucursales vinculados a su cuenta</h1>';
		}
		$a->close();

	}





	public function DefineSucursal($user,$td){
		$db = new dbConn();

		    $cambio = array();
		    $cambio["td"] = $td;
		    
		    if (Helpers::UpdateId("login_userdata", $cambio, "user = '$user'")) {
			    
		   		$_SESSION['td'] = $td;
		      	$_SESSION['secret_key'] = md5($_SESSION['td']);
			  	$this->CrearVariables();
			  	echo '<script>
				window.location.href="?"
				</script>';

			    } 

		     
	}













/// para las tablas a sync


	public function VerTablas(){
		$db = new dbConn();

	$tables = $db->listTables();
    $arrlength = count($tables);

		echo '<table class="table table-sm table-striped">
	   <thead>
	     <tr>
	       <th>Nombre de la Tabla</th>
	       <th>Estado</th>
	       <th>Acci&oacuten</th>
	     </tr>
	   </thead>
	   <tbody>';
			for($x = 0; $x < $arrlength; $x++) {     
	
		echo '<tr>
		       <td>' . $tables[$x] . '</td>';
		       if($this->VerificaTabla($tables[$x]) != FALSE){
		       	if($this->VerificaTabla($tables[$x]) == 1){
		       		$color = 'fas fa-check blue-text';
		       	} else {
		       		$color = 'fas fa-ban red-text';
		       	}
		       	echo '<td>Existe</td>
		       	<td><a id="tablemod" op="15" tabla="'.$tables[$x].'" accion="2" edo="'. $this->VerificaTabla($tables[$x]). '" class="btn-floating btn-sm"><i class="'.$color.'"></i></a></td>';
		       } else {
		       	echo '<td>No existe</td>
		       	<td><a id="tablemod" op="15" tabla="'.$tables[$x].'" accion="1"  class="btn-floating btn-sm"><i class="fas fa-check-circle green-text"></i></a></td>';
		       }
		echo '</tr>';

		    } 
		echo '</tbody>
		</table>';
 
 }



	public function VerificaTabla($tabla){
		$db = new dbConn();

		$a = $db->query("SELECT edo FROM sync_tabla WHERE tabla = '$tabla' and td =  ".$_SESSION["td"]."");
		if($a->num_rows > 0){
			    foreach ($a as $b) {
		        return $b["edo"];
		    	}
		} else {
			return FALSE;
		} $a->close();
 }


	public function ModTabla($datos){
		$db = new dbConn();

		if($datos["accion"] == "1"){

			    $inserta = array();
			    $inserta["tabla"] = $datos["tabla"];
			    $inserta["edo"] = 1;
			    $inserta["hash"] = Helpers::HashId();
			    $inserta["time"] = Helpers::TimeId();
			    $inserta["td"] = $_SESSION["td"];
			    if ($db->insert("sync_tabla", $inserta)) {
			        Alerts::Alerta("success","Agregado Correctamente","Se Agrego esta tabla");
			    } 

		} else {

			if($datos["edo"] == "1"){
					    $cambio = array();
					    $cambio["edo"] = "2";
					    
					    if (Helpers::UpdateId("sync_tabla", $cambio, "tabla='".$datos["tabla"]."'and td = ".$_SESSION["td"]."")) {
					     Alerts::Alerta("error","Cambiado Correctamente","Se Cambio el estado esta tabla a Inactivo");
					    }
			} else {
					    $cambio = array();
					    $cambio["edo"] = "1";
					    
					    if (Helpers::UpdateId("sync_tabla", $cambio, "tabla='".$datos["tabla"]."'and td = ".$_SESSION["td"]."")) {
					     Alerts::Alerta("info","Cambiado Correctamente","Se Cambio el estado esta tabla a Activo");
					    }

			}
		}
	
	$this->VerTablas();

	}









} // fin de la clase

 ?>