 <?php  

class Impresiones{
		public function __construct() { 
     } 


 public function Ticket($efectivo, $numero){
  $db = new dbConn();

$img  = "tiaquiz.bmp";
$txt1   = "31"; 
$txt2   = "11";
$txt3   = "0";
$txt4   = "0";
$n1   = "40";
$n2   = "60";
$n3   = "0";
$n4   = "0";


$col1 = 0;
$col2 = 30;
$col3 = 340;
$col4 = 440;
$col5 = 500;
// $print
$print = "LR2000";
$logo_imagen="C:/AppServ/www/pizto/assets/img/logo_factura/". $img;



$handle = printer_open($print);
printer_set_option($handle, PRINTER_MODE, "RAW");

printer_start_doc($handle, "Mi Documento");
printer_start_page($handle);

printer_draw_bmp($handle, $logo_imagen, 35, 1, 450, 300);

$font = printer_create_font("Arial", $txt1, $txt2, PRINTER_FW_NORMAL, false, false, false, 0);
printer_select_font($handle, $font);



$oi=350;
//// comienza la factura

printer_draw_text($handle, "Final 10 Av Norte, Col Montecarlo", 25, $oi);
$oi=$oi+$n1;
printer_draw_text($handle, "Locales Esmeralda #6, Sonsonate", 25, $oi);
// $oi=$oi+$n1;
// printer_draw_text($handle, Helpers::Pais($_SESSION['config_pais']), 0, $oi);
// $oi=$oi+$n1;
// printer_draw_text($handle, "Propietario: " . $_SESSION['config_propietario'], 0, $oi);
// $oi=$oi+$n1;
// printer_draw_text($handle, $_SESSION['config_nombre_documento'] . ": " . $_SESSION['config_nit'], 0, $oi);
$oi=$oi+$n1;
printer_draw_text($handle, "CALL CENTER: " . $_SESSION['config_telefono'], 0, $oi);

$oi=$oi+$n1
printer_draw_text($handle, "FACTURA NUMERO: ". $num_fac, NULL, $oi);

$oi=$oi+$n2;
printer_draw_text($handle, "____________________________________", 0, $oi);
$oi=$oi+$n1;
printer_draw_text($handle, "Cant.", 55, $oi);
printer_draw_text($handle, "Descripcion", $col2, $oi);
printer_draw_text($handle, "P/U", $col3, $oi);
printer_draw_text($handle, "Total", $col4, $oi);

$oi=$oi+$n1+$n3;
printer_draw_text($handle, "____________________________________", 0, $oi);


///////////////
///
$subtotalf = 0;
///



$a = $db->query("select cod, cant, producto, pv, total, fecha, hora, num_fac from ticket_temp where mesa = '".$numero."' $cancelar and tx = ".$_SESSION["tx"]." and td = ".$_SESSION["td"]." group by cod");
  
    foreach ($a as $b) {
 
 $fechaf=$b["fecha"];
 $horaf=$b["hora"];
 $num_fac=$b["num_fac"];


/// para hacer las sumas
if ($s = $db->select("sum(cant), sum(total)", "ticket_temp", "WHERE cod = ".$b["cod"]." and mesa = '".$numero."'  $cancelar and tx = ".$_SESSION["tx"]." and td = ".$_SESSION["td"]."")) { 
        $scant=$s["sum(cant)"]; $stotal=$s["sum(total)"];
    } unset($s); 
//////
if ($sx = $db->select("sum(total)", "ticket_temp", "WHERE mesa = '".$numero."'  $cancelar and tx = ".$_SESSION["tx"]." and td = ".$_SESSION["td"]."")) { 
       $stotalx=$sx["sum(total)"];
    } unset($sx); 
 

          $oi=$oi+$n1;
          printer_draw_text($handle, $scant, $col1, $oi);
          printer_draw_text($handle, $b["producto"], $col2, $oi);
          printer_draw_text($handle, $b["pv"], $col3, $oi);
          printer_draw_text($handle, $stotal, $col4, $oi);


////
$subtotalf = $subtotalf + $stotal;
///

    }    $a->close();


if($_SESSION['config_propina'] != 0.00){ ///  prara agregarle la propina -- sino borrar
$oi=$oi+$n1;
printer_draw_text($handle, "Propina:", $col4, $oi);
printer_draw_text($handle, Helpers::Format(Helpers::Propina($subtotalf)), 402, $oi);
$subtotalf = Helpers::PropinaTotal($subtotalf);
}

$oi=$oi+$n1;
printer_draw_text($handle, "Total " . $_SESSION['config_moneda_simbolo'] . ":", 232, $oi);
printer_draw_text($handle, Helpers::Format($subtotalf), $col4, $oi);

$oi=$oi+$n2;
printer_draw_text($handle, "____________________________________", 0, $oi);

//efectivo
if($efectivo == NULL){
  $efectivo = $subtotalf;
}
$oi=$oi+$n1;
printer_draw_text($handle, "Efectivo " . $_SESSION['config_moneda_simbolo'] . ":", 160, $oi);
printer_draw_text($handle, Helpers::Format($efectivo), $col4, $oi);

//cambio
$cambios = $efectivo - $subtotalf;
$oi=$oi+$n1;
printer_draw_text($handle, "Cambio " . $_SESSION['config_moneda_simbolo'] . ":", 162, $oi);
printer_draw_text($handle, Helpers::Format($cambios), $col4, $oi);

$oi=$oi+$n2;
printer_draw_text($handle, "___________________________________", 0, $oi);


$oi=$oi+$n1;
printer_draw_text($handle, $fechaf, 100, $oi);
printer_draw_text($handle, $horaf, 332, $oi);


$oi=$oi+$n1;
printer_draw_text($handle, "Cajero: " . $_SESSION['nombre'], 25, $oi);


$oi=$oi+$n1+$n4;
printer_draw_text($handle, "GRACIAS POR SU COMPRA...", 50, $oi);
printer_delete_font($font);



$oi=$oi+$n1;
printer_draw_text($handle, ".", 0, $oi);

printer_write($handle, chr(27).chr(112).chr(48).chr(55).chr(121)); //enviar pulso

///
printer_end_page($handle);
printer_end_doc($handle);
printer_close($handle);



}








 public function Factura($efectivo, $numero){
  $db = new dbConn();

$txt1   = "17"; 
$txt2   = "10";
$txt3   = "15";
$txt4   = "8";
$n1   = "30";
$n2   = "45";
$n3   = "21";
$n4   = "10";

// $print
$print = "LR2000";



$handle = printer_open($print);
printer_set_option($handle, PRINTER_MODE, "RAW");

printer_start_doc($handle, "Mi Documento");
printer_start_page($handle);


$font = printer_create_font("Arial", $txt1, $txt2, PRINTER_FW_NORMAL, false, false, false, 0);
printer_select_font($handle, $font);


//// comienza la factura
printer_draw_text($handle, $_SESSION['config_cliente'], 110, $oi);

$oi=$oi+$n1;
// printer_draw_text($handle, "Venta de pollo frito en piezas, Papas fritas", 0, $oi);
// $oi=$oi+$n1;
// printer_draw_text($handle, "y ensaladas, etc", 120, $oi);
// $oi=$oi+$n1;
// printer_draw_text($handle, "Bo. El centro 1/2 Cdra al Este", 0, $oi);
// $oi=$oi+$n1;
// printer_draw_text($handle, "del Elektra, Choluteca, Honduras.", 0, $oi);

printer_draw_text($handle, $_SESSION['config_direccion'], 0, $oi);
$oi=$oi+$n1;
// printer_draw_text($handle, Helpers::Pais($_SESSION['config_pais']), 0, $oi);
$oi=$oi+$n1;
printer_draw_text($handle, "Propietario: " . $_SESSION['config_propietario'], 0, $oi);
$oi=$oi+$n1;
printer_draw_text($handle, "Email: " . $_SESSION['config_email'], 0, $oi);
$oi=$oi+$n1;
printer_draw_text($handle, $_SESSION['config_nombre_documento'] . ": " . $_SESSION['config_nit'], 0, $oi);
$oi=$oi+$n1;
printer_draw_text($handle, "Tel: " . $_SESSION['config_telefono'], 0, $oi);
$oi=$oi+$n1;

$numero1=str_pad($numero, 8, "0", STR_PAD_LEFT);
$numero1="000-001-01-$numero1";
printer_draw_text($handle, "Factura Numero: $numero1", 0, $oi);


if ($r = $db->select("*", "facturar_cai", "WHERE inicial<='$numero' and final>='$numero' and td = ".$_SESSION["td"]."")) { 
$cai=$r["cai"];
$fecha_limite=$r["fecha_limite"];
$caiinicial=$r["inicial"];
$caifinal=$r["final"];
}  unset($r);  


$oi=$oi+$n1;
printer_draw_text($handle, "Fact. Inicial: 000-001-01-$caiinicial", 0, $oi);
$oi=$oi+$n1;
printer_draw_text($handle, "Fact. Final:  000-001-01-$caifinal", 0, $oi);
$oi=$oi+$n1;
printer_draw_text($handle, "Fecha limite CAI: $fecha_limite", 0, $oi);
////////////////
///


if($_SESSION["rtn"] != NULL){

$oi=$oi+$n3;
printer_draw_text($handle, "Cliente: " . $_SESSION["cliente"], 0, $oi); 
$oi=$oi+$n1;
printer_draw_text($handle, "RTN: " . $_SESSION["rtn"], 0, $oi); 
//insertar el rtn en la tabla
/////////////////////////////////////////////////////////////////////////////////////////
    $datos = array();
    $datos["factura"] = $numero;
    $datos["rtn"] =  $_SESSION["rtn"];
    $datos["cliente"] = $_SESSION["cliente"];
    $datos["td"] = $_SESSION["td"];
    $datos["hash"] = Helpers::HashId();
     $datos["time"] = Helpers::TimeId();
    $db->insert("facturar_rtn_cliente", $datos); 
/////////////////////////////////////////
// @unset($_SESSION["cliente"]);
// @unset($_SESSION["rtn"]);
}
/// nuevos datos exonerados
$oi=$oi+$n1;
printer_draw_text($handle, "Datos del Adquiriente Exonerado:", 0, $oi);
$oi=$oi+$n1;
printer_draw_text($handle, "NO. OCE:", 0, $oi);
printer_draw_text($handle, $_SESSION["nooce"], 232, $oi);
$oi=$oi+$n1;
printer_draw_text($handle, "NO. REG EXON:", 0, $oi);
printer_draw_text($handle, $_SESSION["regexon"], 232, $oi);
$oi=$oi+$n1;
printer_draw_text($handle, "NO. CARNET DIPL:", 0, $oi);
printer_draw_text($handle, $_SESSION["nocarnet"], 232, $oi);
$oi=$oi+$n1;
printer_draw_text($handle, "NO. SAG:", 0, $oi);
printer_draw_text($handle, $_SESSION["nosag"], 232, $oi);
///
///
///
///
$oi=$oi+$n2;
printer_draw_text($handle, "____________________________________", 0, $oi);
$oi=$oi+$n1;
printer_draw_text($handle, "Cant.", 0, $oi);
printer_draw_text($handle, "Descripcion", 60, $oi);
printer_draw_text($handle, "P/U", 240, $oi);
printer_draw_text($handle, "Total", 320, $oi);
$oi=$oi+$n1+$n3;
printer_draw_text($handle, "____________________________________", 0, $oi);


///////////////
///
$subtotalf = 0;
///

$a = $db->query("select cod, cant, producto, pv, total, fecha, hora from ticket where num_fac = ".$numero."  and tx = ".$_SESSION["tx"]." and td = ".$_SESSION["td"]." group by cod");
  
    foreach ($a as $b) {
 
 $fechaf=$b["fecha"];
 $horaf=$b["hora"];


/// para hacer las sumas
if ($s = $db->select("sum(cant), sum(total)", "ticket", "WHERE cod = ".$b["cod"]." and num_fac = '$numero' and tx = ".$_SESSION["tx"]." and td = ".$_SESSION["td"]."")) { 
        $scant=$s["sum(cant)"]; $stotal=$s["sum(total)"];
    } unset($s); 
//////
if ($sx = $db->select("sum(total)", "ticket", "WHERE num_fac = '$numero' and tx = ".$_SESSION["tx"]." and td = ".$_SESSION["td"]."")) { 
       $stotalx=$sx["sum(total)"];
    } unset($sx); 
 

          $oi=$oi+$n1;
          printer_draw_text($handle, $scant, 0, $oi);
          printer_draw_text($handle, $b["producto"], 30, $oi);
          printer_draw_text($handle, $b["pv"], 240, $oi);
          printer_draw_text($handle, $stotal, 320, $oi);

          $g="G";

          printer_draw_text($handle, $g, 385, $oi);
////
$subtotalf = $subtotalf + $stotal;
///

    }    $a->close();


$oi=$oi+$n3+$n1;
printer_draw_text($handle, "Sub Total " . $_SESSION['config_moneda_simbolo'] . ":", 185, $oi);
printer_draw_text($handle, Helpers::Format(Helpers::STotal($subtotalf, $_SESSION['config_imp'])), 320, $oi);


$oi=$oi+$n1;
printer_draw_text($handle, "15% Impu. " . $_SESSION['config_moneda_simbolo'] . ":", 175, $oi);
printer_draw_text($handle, Helpers::Format(Helpers::Impuesto(Helpers::STotal($subtotalf, $_SESSION['config_imp']), $_SESSION['config_imp'])), 320, $oi);


$oi=$oi+$n1;
printer_draw_text($handle, "18% Impu. ", 175, $oi);
printer_draw_text($handle, Helpers::Format(0), 320, $oi);


$oi=$oi+$n1;
printer_draw_text($handle, "Descuentos y Rebajas. ", 100, $oi);
printer_draw_text($handle, Helpers::Format(0), 320, $oi);


if($_SESSION['config_propina'] != 0.00){ ///  prara agregarle la propina -- sino borrar
$oi=$oi+$n1;
printer_draw_text($handle, "Propina:", 320, $oi);
printer_draw_text($handle, Helpers::Format(Helpers::Propina($subtotalf)), 402, $oi);
$subtotalf = Helpers::PropinaTotal($subtotalf);
}

$oi=$oi+$n1;
printer_draw_text($handle, "Total " . $_SESSION['config_moneda_simbolo'] . ":", 232, $oi);
printer_draw_text($handle, Helpers::Format($subtotalf), 320, $oi);

$oi=$oi+$n2;
printer_draw_text($handle, "____________________________________", 0, $oi);

//efectivo
if($efectivo == NULL){
  $efectivo = $subtotalf;
}
$oi=$oi+$n1;
printer_draw_text($handle, "Efectivo " . $_SESSION['config_moneda_simbolo'] . ":", 160, $oi);
printer_draw_text($handle, Helpers::Format($efectivo), 320, $oi);

//cambio
$cambios = $efectivo - $subtotalf;
$oi=$oi+$n1;
printer_draw_text($handle, "Cambio " . $_SESSION['config_moneda_simbolo'] . ":", 162, $oi);
printer_draw_text($handle, Helpers::Format($cambios), 320, $oi);

$oi=$oi+$n2;
printer_draw_text($handle, "___________________________________", 0, $oi);

$oi=$oi+$n1;
printer_draw_text($handle, "G=Articulo Gravado  E= Artculo Exento", 0, $oi);



$oi=$oi+$n1;
printer_draw_text($handle, $fechaf, 0, $oi);
printer_draw_text($handle, $horaf, 232, $oi);



// comienza cai
$font = printer_create_font("Arial", $txt3, $txt4, PRINTER_FW_NORMAL, false, false, false, 0);
printer_select_font($handle, $font);
$oi=$oi+$n1;
printer_draw_text($handle, "CAI:", 0, $oi);
$oi=$oi+$n1;

printer_draw_text($handle, "$cai", 0, $oi);
printer_delete_font($font);
///// termina cai


///// crea de nuevo fuente
$font = printer_create_font("Arial", $txt1, $txt2, PRINTER_FW_NORMAL, false, false, false, 0);
printer_select_font($handle, $font);
//////////////////

$oi=$oi+$n1;
printer_draw_text($handle, "Cajero: " . $_SESSION['nombre'], 25, $oi);


$oi=$oi+$n1+$n4;
printer_draw_text($handle, "GRACIAS POR SU COMPRA...", 50, $oi);
printer_delete_font($font);

$oi=$oi+$n1+$n2;
printer_draw_text($handle, ".", NULL, $oi);
printer_write($handle, chr(27).chr(112).chr(48).chr(55).chr(121)); //enviar pulso



///
printer_end_page($handle);
printer_end_doc($handle);
printer_close($handle);


}   /// termina FACTURA





 public function CreditoFiscal($data){
  $db = new dbConn();

}










 public function ImprimirAntes($efectivo, $numero, $cancelar){
  $db = new dbConn();


$img  = "tiaquiz.bmp";
$txt1   = "31"; 
$txt2   = "11";
$txt3   = "0";
$txt4   = "0";
$n1   = "40";
$n2   = "60";
$n3   = "0";
$n4   = "0";


$col1 = 0;
$col2 = 30;
$col3 = 340;
$col4 = 440;
$col5 = 500;
// $print
$print = "LR2000";
$logo_imagen="C:/AppServ/www/pizto/assets/img/logo_factura/". $img;



$handle = printer_open($print);
printer_set_option($handle, PRINTER_MODE, "RAW");

printer_start_doc($handle, "Mi Documento");
printer_start_page($handle);

printer_draw_bmp($handle, $logo_imagen, 35, 1, 450, 300);

$font = printer_create_font("Arial", $txt1, $txt2, PRINTER_FW_NORMAL, false, false, false, 0);
printer_select_font($handle, $font);



$oi=350;
//// comienza la factura

printer_draw_text($handle, "Final 10 Av Norte, Col Montecarlo", 25, $oi);
$oi=$oi+$n1;
printer_draw_text($handle, "Locales Esmeralda #6, Sonsonate", 25, $oi);
// $oi=$oi+$n1;
// printer_draw_text($handle, Helpers::Pais($_SESSION['config_pais']), 0, $oi);
// $oi=$oi+$n1;
// printer_draw_text($handle, "Propietario: " . $_SESSION['config_propietario'], 0, $oi);
// $oi=$oi+$n1;
// printer_draw_text($handle, $_SESSION['config_nombre_documento'] . ": " . $_SESSION['config_nit'], 0, $oi);
$oi=$oi+$n1;
printer_draw_text($handle, "CALL CENTER: " . $_SESSION['config_telefono'], 0, $oi);

$oi=$oi+$n1
printer_draw_text($handle, "FACTURA NUMERO: ". $num_fac, NULL, $oi);


$oi=$oi+$n2;
printer_draw_text($handle, "____________________________________", 0, $oi);
$oi=$oi+$n1;
printer_draw_text($handle, "Cant.", 55, $oi);
printer_draw_text($handle, "Descripcion", $col2, $oi);
printer_draw_text($handle, "P/U", $col3, $oi);
printer_draw_text($handle, "Total", $col4, $oi);

$oi=$oi+$n1+$n3;
printer_draw_text($handle, "____________________________________", 0, $oi);


///////////////
///
$subtotalf = 0;
///



$a = $db->query("select cod, cant, producto, pv, total, fecha, hora from ticket_temp where mesa = '".$numero."' $cancelar and tx = ".$_SESSION["tx"]." and td = ".$_SESSION["td"]." group by cod");
  
    foreach ($a as $b) {
 
 $fechaf=$b["fecha"];
 $horaf=$b["hora"];


/// para hacer las sumas
if ($s = $db->select("sum(cant), sum(total)", "ticket_temp", "WHERE cod = ".$b["cod"]." and mesa = '".$numero."'  $cancelar and tx = ".$_SESSION["tx"]." and td = ".$_SESSION["td"]."")) { 
        $scant=$s["sum(cant)"]; $stotal=$s["sum(total)"];
    } unset($s); 
//////
if ($sx = $db->select("sum(total)", "ticket_temp", "WHERE mesa = '".$numero."'  $cancelar and tx = ".$_SESSION["tx"]." and td = ".$_SESSION["td"]."")) { 
       $stotalx=$sx["sum(total)"];
    } unset($sx); 
 

          $oi=$oi+$n1;
          printer_draw_text($handle, $scant, $col1, $oi);
          printer_draw_text($handle, $b["producto"], $col2, $oi);
          printer_draw_text($handle, $b["pv"], $col3, $oi);
          printer_draw_text($handle, $stotal, $col4, $oi);


////
$subtotalf = $subtotalf + $stotal;
///

    }    $a->close();


if($_SESSION['config_propina'] != 0.00){ ///  prara agregarle la propina -- sino borrar
$oi=$oi+$n1;
printer_draw_text($handle, "Propina:", $col4, $oi);
printer_draw_text($handle, Helpers::Format(Helpers::Propina($subtotalf)), 402, $oi);
$subtotalf = Helpers::PropinaTotal($subtotalf);
}

$oi=$oi+$n1;
printer_draw_text($handle, "Total " . $_SESSION['config_moneda_simbolo'] . ":", 232, $oi);
printer_draw_text($handle, Helpers::Format($subtotalf), $col4, $oi);

$oi=$oi+$n2;
printer_draw_text($handle, "____________________________________", 0, $oi);

//efectivo
if($efectivo == NULL){
  $efectivo = $subtotalf;
}
$oi=$oi+$n1;
printer_draw_text($handle, "Efectivo " . $_SESSION['config_moneda_simbolo'] . ":", 160, $oi);
printer_draw_text($handle, Helpers::Format($efectivo), $col4, $oi);

//cambio
$cambios = $efectivo - $subtotalf;
$oi=$oi+$n1;
printer_draw_text($handle, "Cambio " . $_SESSION['config_moneda_simbolo'] . ":", 162, $oi);
printer_draw_text($handle, Helpers::Format($cambios), $col4, $oi);

$oi=$oi+$n2;
printer_draw_text($handle, "___________________________________", 0, $oi);


$oi=$oi+$n1;
printer_draw_text($handle, $fechaf, 100, $oi);
printer_draw_text($handle, $horaf, 332, $oi);


$oi=$oi+$n1;
printer_draw_text($handle, "Cajero: " . $_SESSION['nombre'], 25, $oi);


$oi=$oi+$n1+$n4;
printer_draw_text($handle, "GRACIAS POR SU COMPRA...", 50, $oi);
printer_delete_font($font);

$oi=$oi+$n1+$n2;
printer_draw_text($handle, ".", NULL, $oi);


// printer_write($handle, chr(27).chr(112).chr(48).chr(55).chr(121)); //enviar pulso

///
printer_end_page($handle);
printer_end_doc($handle);
printer_close($handle);


} /// TERMINA IMPRIMIR ANTES











 public function Comanda(){
  $db = new dbConn();

$img  = "tiaquiz.bmp";
$txt1   = "35"; 
$txt2   = "13";
$txt3   = "28";
$txt4   = "16";
$n1   = "50";
$n2   = "90";
$n3   = "120";
$n4   = "0";

// $print
$print = "LR2000";


$handle = printer_open($print);
printer_set_option($handle, PRINTER_MODE, "RAW");

printer_start_doc($handle, "Mi Documento");
printer_start_page($handle);


$font = printer_create_font("Arial", $txt1, $txt2, PRINTER_FW_NORMAL, false, false, false, 0);
printer_select_font($handle, $font);


$oi="60";
printer_draw_text($handle, "COMANDA DE COCINA", 100, $oi);


$a = $db->query("select hash, cant, producto from ticket_temp where mesa = '".$_SESSION["mesa"]."' and tx = ".$_SESSION["tx"]." and td = ".$_SESSION["td"]."");
 
    foreach ($a as $b) {
//////

 

      $oi=$oi+$n1;
        printer_draw_text($handle, $b["cant"], 0, $oi);
        printer_draw_text($handle, $b["producto"], 40, $oi);

    $ar = $db->query("SELECT opcion FROM opciones_ticket WHERE identificador = '".$b["hash"]."' and mesa = ".$_SESSION["mesa"]." and td = ".$_SESSION["td"]."");
    foreach ($ar as $br) {

if ($r = $db->select("nombre", "opciones_name", "WHERE cod = '".$br["opcion"]."' and td = ".$_SESSION["td"]."")) { 
      $oi=$oi+$n1;
      printer_draw_text($handle, "* " . $r["nombre"], 50, $oi);  
} unset($r); 

    } $ar->close();

    }    $a->close();





    if ($r = $db->select("llevar", "mesa", "WHERE mesa = '".$_SESSION["mesa"]."' and tx = ".$_SESSION["tx"]." and td = ".$_SESSION["td"]."")) { 
        $llevar = $r["llevar"];
    } unset($r);  

if($llevar == 1){
  $lleva = "COMER AQUI";
}
if($llevar == 2){
  $lleva = "PARA LLEVAR";
}
if($llevar == 3){
  $lleva = "DELIVERY";
}



$oi=$oi+$n2;
printer_draw_text($handle, $lleva, 25, $oi);


$font = printer_create_font("Arial", $txt3, $txt4, PRINTER_FW_NORMAL, false, false, false, 0);
printer_select_font($handle, $font);

$oi=$oi+$n2;
printer_draw_text($handle, date("d-m-Y"), 0, $oi);
printer_draw_text($handle, date("H:i:s"), 350, $oi);


$oi=$oi+$n1;
printer_draw_text($handle, "Cajero: " . $_SESSION['nombre'], 25, $oi);

$oi=$oi+$n1;
printer_draw_text($handle, ".", 25, $oi);

// printer_write($handle, chr(27).chr(112).chr(48).chr(55).chr(121)); //enviar pulso


printer_end_page($handle);
printer_end_doc($handle);
printer_close($handle);




}












 public function ReporteDiario($fecha){
  $db = new dbConn();


$txt1   = "17"; 
$txt2   = "10";
$txt3   = "15";
$txt4   = "8";
$n1   = "30";
$n2   = "45";
$n3   = "21";
$n4   = "10";

// $print
$print = "EPSON TM-T20II Receipt";


    $handle = printer_open($print);
    printer_set_option($handle, PRINTER_MODE, "RAW");

    printer_start_doc($handle, "Mi Documento");
    printer_start_page($handle);

    $font = printer_create_font("Arial", $txt1, $txt2, PRINTER_FW_NORMAL, false, false, false, 0);
    printer_select_font($handle, $font);

$oi=0;
//// comienza la factura
printer_draw_text($handle, $_SESSION['config_cliente'], 110, $oi);

$oi=$oi+$n1;
printer_draw_text($handle, "Bo. El centro 1/2 Cdra al Este", 0, $oi);
$oi=$oi+$n1;
printer_draw_text($handle, "del Elektra, Choluteca, Honduras.", 0, $oi);


$oi=$oi+$n1;
printer_draw_text($handle, "Email: " . $_SESSION['config_email'], 0, $oi);
$oi=$oi+$n1;
printer_draw_text($handle, $_SESSION['config_nombre_documento'] . ": " . $_SESSION['config_nit'], 0, $oi);
$oi=$oi+$n1;
printer_draw_text($handle, "Tel: " . $_SESSION['config_telefono'], 0, $oi);




      // inicial y final
          $ax = $db->query("SELECT max(num_fac), min(num_fac), count(num_fac)  FROM ticket_num WHERE fecha = '$fecha' and tx = 1 and edo = 1 and td = ".$_SESSION["td"]."");
        foreach ($ax as $bx) {
            $max=$bx["max(num_fac)"]; $min=$bx["min(num_fac)"]; $count=$bx["count(num_fac)"];
        } $ax->close();
        
        
        
$oi=$oi+$n1;
printer_draw_text($handle, "Fact. Inicial: " . Helpers::NFactura($min), 0, $oi);

$oi=$oi+$n1;
printer_draw_text($handle, "Fact. Final: " . Helpers::NFactura($max), 0, $oi);

$oi=$oi+$n1;
printer_draw_text($handle, "FACTURAS: " .  $count, 0, $oi);



      // total
      $ay = $db->query("SELECT sum(total) FROM ticket WHERE fecha = '$fecha' and tx = 1 and edo = 1 and td = ".$_SESSION["td"]."");
        foreach ($ay as $by) {
            $total=$by["sum(total)"];
        } $ay->close();

$oi=$oi+$n2;
    printer_draw_text($handle, "____________________________________", 0, 220);
    //consulta cuantos productos imprimir
    $oi=250;
    printer_draw_text($handle, $fecha, 15, $oi);

    $oi=$oi+30;
    printer_draw_text($handle, "EXENTO:  " . Helpers::Dinero(0), 10, $oi);

    $oi=$oi+30;
    printer_draw_text($handle, "GRAVADO:  " . Helpers::Dinero(Helpers::STotal($total, $_SESSION['config_imp'])), 10, $oi);

    $oi=$oi+30;
    printer_draw_text($handle, "SUBTOTAL:  " . Helpers::Dinero(Helpers::STotal($total, $_SESSION['config_imp'])), 10, $oi);

    $oi=$oi+30;
    printer_draw_text($handle, "ISV:  " . Helpers::Dinero(Helpers::Impuesto(Helpers::STotal($total, $_SESSION['config_imp']), $_SESSION['config_imp'])), 10, $oi);

    $oi=$oi+30;
    printer_draw_text($handle, "____________________________________", 0, $oi);
    $oi=$oi+30;
    printer_draw_text($handle, "TOTAL:  " . Helpers::Dinero($total), 10, $oi);
    printer_delete_font($font);


    //////////////////
    $oi=$oi+30;
    printer_draw_text($handle, "Cajero: " . $_SESSION['nombre'], 20, $oi);


      // Eliminadas
          $axy = $db->query("SELECT count(num_fac) FROM ticket_num WHERE fecha = '$fecha' and tx = 1 and edo = 2 and td = ".$_SESSION["td"]."");
        foreach ($axy as $bxy) {
            $counte=$bxy["count(num_fac)"];
        } $axy->close();


    $oi=$oi+30;
    printer_draw_text($handle, "Total Eliminadas: " . $counte, 20, $oi);
      

    printer_end_page($handle);
    printer_end_doc($handle, 20);
    printer_close($handle);




}   // termina reporte diario








 public function AbrirCaja(){
// $print
$print = "LR2000";

    $handle = printer_open($print);
    printer_set_option($handle, PRINTER_MODE, "RAW");

    printer_start_doc($handle, "Mi Documento");
    printer_start_page($handle);
    printer_write($handle, chr(27).chr(112).chr(48).chr(55).chr(121)); //enviar pulso
    printer_end_page($handle);
    printer_end_doc($handle, 20);
    printer_close($handle);
}











}// class