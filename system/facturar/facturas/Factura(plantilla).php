 <?php  

class Factura{
		public function __construct() { 
     } 


 public function Imprimir($tipo,$numero,$efectivo,$imp,$dato,$ticket){
  $db = new dbConn();
//(tipo,numero,cambio,impresor,mesa,factura_o_tiket)
// el tipo es 1 =  mesa, 2 = factura, 3 = cancela un cliente

if ($r = $db->select("*", "facturar_ticket", "WHERE id = '$ticket' and td = ".$_SESSION["td"]."")) { 
$img = $r["img"];
$txt1=$r["txt1"]; 
$txt2=$r["txt2"];
$txt3=$r["txt3"];
$txt4=$r["txt4"];
$n1=$r["n1"];
$n2=$r["n2"];
$n3=$r["n3"];
$n4=$r["n4"];
} unset($r);  

if ($r = $db->select("*", "facturar_impresora", "WHERE id = '$imp'")) { 
$print = $r["impresora"];
} unset($r); 


$handle = printer_open($print);
printer_set_option($handle, PRINTER_MODE, "RAW");

printer_start_doc($handle, "Mi Documento");
printer_start_page($handle);


$font = printer_create_font("Arial", $txt1, $txt2, PRINTER_FW_NORMAL, false, false, false, 0);
printer_select_font($handle, $font);


//// comienza la factura
printer_draw_text($handle, $_SESSION['config_cliente'], 110, $oi);

if($_SESSION["td"] == 4){
  $oi=$oi+$n1;
printer_draw_text($handle, "Venta de pollo frito en piezas, Papas fritas", 0, $oi);
$oi=$oi+$n1;
printer_draw_text($handle, "y ensaladas, etc", 120, $oi);
$oi=$oi+$n1;
printer_draw_text($handle, "Mercado Concepcion, 1/2 al sur de", 0, $oi);
$oi=$oi+$n1;
printer_draw_text($handle, "Farmacia san Jose, Choluteca.", 0, $oi);
} elseif($_SESSION["td"] == 3){
  $oi=$oi+$n1;
printer_draw_text($handle, "Venta de pollo frito en piezas, Papas fritas", 0, $oi);
$oi=$oi+$n1;
printer_draw_text($handle, "y ensaladas, etc", 120, $oi);
$oi=$oi+$n1;
printer_draw_text($handle, "Bo. El centro 1/2 Cdra al Este", 0, $oi);
$oi=$oi+$n1;
printer_draw_text($handle, "del Elektra, Choluteca, Honduras.", 0, $oi);
} else {
  $oi=$oi+$n1;
printer_draw_text($handle, $_SESSION['config_giro'], 0, $oi);

$oi=$oi+$n1;
  printer_draw_text($handle, $_SESSION['config_direccion'], 0, $oi);
} 
//printer_draw_text($handle, $_SESSION['config_direccion'], 0, $oi);
// $oi=$oi+$n1;
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
 if($tipo==1){
$a = $db->query("select cod, cant, producto, pv, total, fecha, hora from ticket where mesa = ".$numero." and tx = ".$_SESSION["tx"]." and td = ".$_SESSION["td"]." group by cod");
 }
 if($tipo==2) {
$a = $db->query("select cod, cant, producto, pv, total, fecha, hora from ticket where num_fac = ".$numero."  and tx = ".$_SESSION["tx"]." and td = ".$_SESSION["td"]." group by cod");
 }
if($tipo==3) {
$a = $db->query("select cod, cant, producto, pv, total, fecha, hora from ticket where cancela = ".$numero." and mesa='$dato' and tx = ".$_SESSION["tx"]." and td = ".$_SESSION["td"]." group by cod");
 }   
    foreach ($a as $b) {
 
 $fechaf=$b["fecha"];
 $horaf=$b["hora"];

 if($tipo==1){
/// para hacer las sumas
if ($s = $db->select("sum(cant), sum(total)", "ticket", "WHERE cod = ".$b["cod"]." and mesa = '$numero' and tx = ".$_SESSION["tx"]." and td = ".$_SESSION["td"]."")) { 
        $scant=$s["sum(cant)"]; $stotal=$s["sum(total)"];
    } unset($s); 


if ($sx = $db->select("sum(total)", "ticket", "WHERE mesa = '$numero' and tx = ".$_SESSION["tx"]." and td = ".$_SESSION["td"]."")) { 
        $stotalx=$sx["sum(total)"];
    } unset($sx); 
//////
 }
 if($tipo==2) {
/// para hacer las sumas
if ($s = $db->select("sum(cant), sum(total)", "ticket", "WHERE cod = ".$b["cod"]." and num_fac = '$numero' and tx = ".$_SESSION["tx"]." and td = ".$_SESSION["td"]."")) { 
        $scant=$s["sum(cant)"]; $stotal=$s["sum(total)"];
    } unset($s); 
//////
if ($sx = $db->select("sum(total)", "ticket", "WHERE num_fac = '$numero' and tx = ".$_SESSION["tx"]." and td = ".$_SESSION["td"]."")) { 
       $stotalx=$sx["sum(total)"];
    } unset($sx); 
 
 }

  if($tipo==3) {
/// para hacer las sumas
if ($s = $db->select("sum(cant), sum(total)", "ticket", "WHERE cod = ".$b["cod"]." and cancela = '$numero' and mesa='$dato' and tx = ".$_SESSION["tx"]." and td = ".$_SESSION["td"]."")) { 
        $scant=$s["sum(cant)"]; $stotal=$s["sum(total)"];
    } unset($s); 
//////
if ($sx = $db->select("sum(total)", "ticket", "WHERE cancela = '$numero' and mesa='$dato' and tx = ".$_SESSION["tx"]." and td = ".$_SESSION["td"]."")) { 
       $stotalx=$sx["sum(total)"];
    } unset($sx); 
 
 }


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
///
///
///
printer_end_page($handle);
printer_end_doc($handle);
printer_close($handle);

}





   public function ReporteDiario($fecha,$imp,$ticket){
    $db = new dbConn();


if ($r = $db->select("*", "facturar_ticket", "WHERE id = '$ticket' and td = ".$_SESSION["td"]."")) { 
$img = $r["img"];
$txt1=$r["txt1"]; 
$txt2=$r["txt2"];
$txt3=$r["txt3"];
$txt4=$r["txt4"];
$n1=$r["n1"];
$n2=$r["n2"];
$n3=$r["n3"];
$n4=$r["n4"];
} unset($r);  


    if ($r = $db->select("*", "facturar_impresora", "WHERE id = '$imp'")) { 
    $print = $r["impresora"];
    } unset($r); 




    $handle = printer_open($print);
    printer_set_option($handle, PRINTER_MODE, "RAW");

    printer_start_doc($handle, "Mi Documento");
    printer_start_page($handle);

    $font = printer_create_font("Arial", $txt1, $txt2, PRINTER_FW_NORMAL, false, false, false, 0);
    printer_select_font($handle, $font);

$oi=0;
//// comienza la factura
printer_draw_text($handle, $_SESSION['config_cliente'], 110, $oi);
if($_SESSION["td"] == 4){
$oi=$oi+$n1;
printer_draw_text($handle, "Mercado Concepcion, 1/2 al sur de", 0, $oi);
$oi=$oi+$n1;
printer_draw_text($handle, "Farmacia san Jose, Choluteca.", 0, $oi);
} if($_SESSION["td"] == 3){
$oi=$oi+$n1;
printer_draw_text($handle, "Bo. El centro 1/2 Cdra al Este", 0, $oi);
$oi=$oi+$n1;
printer_draw_text($handle, "del Elektra, Choluteca, Honduras.", 0, $oi);
} 

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



  }   /// termina reporte diario
















 public function Italia($tipo,$numero,$efectivo,$imp,$dato,$ticket){
  $db = new dbConn();
//(tipo,numero,cambio,impresor,mesa,factura_o_tiket)
// el tipo es 1 =  mesa, 2 = factura, 3 = cancela un cliente

if ($r = $db->select("*", "facturar_ticket", "WHERE id = '$ticket' and td = ".$_SESSION["td"]."")) { 
$img = $r["img"];
$txt1=$r["txt1"]; 
$txt2=$r["txt2"];
$txt3=$r["txt3"];
$txt4=$r["txt4"];
$n1=$r["n1"];
$n2=$r["n2"];
$n3=$r["n3"];
$n4=$r["n4"];
} unset($r);  

if ($r = $db->select("*", "facturar_impresora", "WHERE id = '$imp'")) { 
$print = $r["impresora"];
} unset($r); 


$handle = printer_open($print);
printer_set_option($handle, PRINTER_MODE, "RAW");

printer_start_doc($handle, "Mi Documento");
printer_start_page($handle);

$logo_imagen="C:/AppServ/www/pizto/assets/img/logo_factura/". $img;
printer_draw_bmp($handle, $logo_imagen, 100, 1, 300, 120);


$font = printer_create_font("Arial", $txt1, $txt2, PRINTER_FW_NORMAL, false, false, false, 0);
printer_select_font($handle, $font);


//// comienza la factura
$oi="140";
printer_draw_text($handle, $_SESSION['config_cliente'], 110, $oi);


  $oi=$oi+$n1;
printer_draw_text($handle, $_SESSION['config_giro'], 0, $oi);

$oi=$oi+$n1;
  printer_draw_text($handle, $_SESSION['config_direccion'], 0, $oi);

//printer_draw_text($handle, $_SESSION['config_direccion'], 0, $oi);
// $oi=$oi+$n1;
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
printer_draw_text($handle, "P/U", 330, $oi);
printer_draw_text($handle, "Total", 420, $oi);
$oi=$oi+$n1+$n3;
printer_draw_text($handle, "____________________________________", 0, $oi);


///////////////
///
$subtotalf = 0;
///
 if($tipo==1){
$a = $db->query("select cod, cant, producto, pv, total, fecha, hora from ticket where mesa = ".$numero." and tx = ".$_SESSION["tx"]." and td = ".$_SESSION["td"]." group by cod");
 }
 if($tipo==2) {
$a = $db->query("select cod, cant, producto, pv, total, fecha, hora from ticket where num_fac = ".$numero."  and tx = ".$_SESSION["tx"]." and td = ".$_SESSION["td"]." group by cod");
 }
if($tipo==3) {
$a = $db->query("select cod, cant, producto, pv, total, fecha, hora from ticket where cancela = ".$numero." and mesa='$dato' and tx = ".$_SESSION["tx"]." and td = ".$_SESSION["td"]." group by cod");
 }   
    foreach ($a as $b) {
 
 $fechaf=$b["fecha"];
 $horaf=$b["hora"];

 if($tipo==1){
/// para hacer las sumas
if ($s = $db->select("sum(cant), sum(total)", "ticket", "WHERE cod = ".$b["cod"]." and mesa = '$numero' and tx = ".$_SESSION["tx"]." and td = ".$_SESSION["td"]."")) { 
        $scant=$s["sum(cant)"]; $stotal=$s["sum(total)"];
    } unset($s); 


if ($sx = $db->select("sum(total)", "ticket", "WHERE mesa = '$numero' and tx = ".$_SESSION["tx"]." and td = ".$_SESSION["td"]."")) { 
        $stotalx=$sx["sum(total)"];
    } unset($sx); 
//////
 }
 if($tipo==2) {
/// para hacer las sumas
if ($s = $db->select("sum(cant), sum(total)", "ticket", "WHERE cod = ".$b["cod"]." and num_fac = '$numero' and tx = ".$_SESSION["tx"]." and td = ".$_SESSION["td"]."")) { 
        $scant=$s["sum(cant)"]; $stotal=$s["sum(total)"];
    } unset($s); 
//////
if ($sx = $db->select("sum(total)", "ticket", "WHERE num_fac = '$numero' and tx = ".$_SESSION["tx"]." and td = ".$_SESSION["td"]."")) { 
       $stotalx=$sx["sum(total)"];
    } unset($sx); 
 
 }

  if($tipo==3) {
/// para hacer las sumas
if ($s = $db->select("sum(cant), sum(total)", "ticket", "WHERE cod = ".$b["cod"]." and cancela = '$numero' and mesa='$dato' and tx = ".$_SESSION["tx"]." and td = ".$_SESSION["td"]."")) { 
        $scant=$s["sum(cant)"]; $stotal=$s["sum(total)"];
    } unset($s); 
//////
if ($sx = $db->select("sum(total)", "ticket", "WHERE cancela = '$numero' and mesa='$dato' and tx = ".$_SESSION["tx"]." and td = ".$_SESSION["td"]."")) { 
       $stotalx=$sx["sum(total)"];
    } unset($sx); 
 
 }


          $oi=$oi+$n1;
          printer_draw_text($handle, $scant, 0, $oi);
          printer_draw_text($handle, $b["producto"], 30, $oi);
          printer_draw_text($handle, $b["pv"], 330, $oi);
          printer_draw_text($handle, $stotal, 420, $oi);

          $g="G";

          printer_draw_text($handle, $g, 400, $oi);
////
$subtotalf = $subtotalf + $stotal;
///

    }    $a->close();


$oi=$oi+$n3+$n1;
printer_draw_text($handle, "Sub Total " . $_SESSION['config_moneda_simbolo'] . ":", 185, $oi);
printer_draw_text($handle, Helpers::Format(Helpers::STotal($subtotalf, $_SESSION['config_imp'])), 420, $oi);


$oi=$oi+$n1;
printer_draw_text($handle, "15% Impu. " . $_SESSION['config_moneda_simbolo'] . ":", 175, $oi);
printer_draw_text($handle, Helpers::Format(Helpers::Impuesto(Helpers::STotal($subtotalf, $_SESSION['config_imp']), $_SESSION['config_imp'])), 420, $oi);


$oi=$oi+$n1;
printer_draw_text($handle, "18% Impu. ", 175, $oi);
printer_draw_text($handle, Helpers::Format(0), 420, $oi);


$oi=$oi+$n1;
printer_draw_text($handle, "Descuentos y Rebajas. ", 100, $oi);
printer_draw_text($handle, Helpers::Format(0), 420, $oi);


if($_SESSION['config_propina'] != 0.00){ ///  prara agregarle la propina -- sino borrar
$oi=$oi+$n1;
printer_draw_text($handle, "Propina:", 175, $oi);
printer_draw_text($handle, Helpers::Format(Helpers::Propina($subtotalf)), 420, $oi);
$subtotalf = Helpers::PropinaTotal($subtotalf);
}

$oi=$oi+$n1;
printer_draw_text($handle, "Total " . $_SESSION['config_moneda_simbolo'] . ":", 232, $oi);
printer_draw_text($handle, Helpers::Format($subtotalf), 420, $oi);

$oi=$oi+$n2;
printer_draw_text($handle, "____________________________________", 0, $oi);

//efectivo
if($efectivo == NULL){
  $efectivo = $subtotalf;
}
$oi=$oi+$n1;
printer_draw_text($handle, "Efectivo " . $_SESSION['config_moneda_simbolo'] . ":", 160, $oi);
printer_draw_text($handle, Helpers::Format($efectivo), 420, $oi);

//cambio
$cambios = $efectivo - $subtotalf;
$oi=$oi+$n1;
printer_draw_text($handle, "Cambio " . $_SESSION['config_moneda_simbolo'] . ":", 162, $oi);
printer_draw_text($handle, Helpers::Format($cambios), 420, $oi);

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
///
///
///
printer_end_page($handle);
printer_end_doc($handle);
printer_close($handle);

}






public function MrPollo($tipo,$numero,$efectivo,$imp,$dato,$ticket){
  $db = new dbConn();
//(tipo,numero,cambio,impresor,mesa,factura_o_tiket)
// el tipo es 1 =  mesa, 2 = factura, 3 = cancela un cliente

if ($r = $db->select("*", "facturar_ticket", "WHERE id = '$ticket' and td = ".$_SESSION["td"]."")) { 
$img = $r["img"];
$txt1=$r["txt1"]; 
$txt2=$r["txt2"];
$txt3=$r["txt3"];
$txt4=$r["txt4"];
$n1=$r["n1"];
$n2=$r["n2"];
$n3=$r["n3"];
$n4=$r["n4"];
} unset($r);  

if ($r = $db->select("*", "facturar_impresora", "WHERE id = '$imp'")) { 
$print = $r["impresora"];
} unset($r); 


$handle = printer_open($print);
printer_set_option($handle, PRINTER_MODE, "RAW");

printer_start_doc($handle, "Mi Documento");
printer_start_page($handle);


$font = printer_create_font("Arial", $txt1, $txt2, PRINTER_FW_NORMAL, false, false, false, 0);
printer_select_font($handle, $font);


//// comienza la factura
printer_draw_text($handle, $_SESSION['config_cliente'], 80, $oi);


  $oi=$oi+$n1;
printer_draw_text($handle, "Venta de pollo frito en piezas, papas", 0, $oi);
$oi=$oi+$n1;
printer_draw_text($handle, "y ensaladas, etc", 35, $oi);
$oi=$oi+$n1;
printer_draw_text($handle, "Barrio El Centro casa #24", 35, $oi);
$oi=$oi+$n1;
printer_draw_text($handle, "Gracias Lempira", 60, $oi);

//printer_draw_text($handle, $_SESSION['config_direccion'], 0, $oi);
// $oi=$oi+$n1;
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
printer_draw_text($handle, "Descripcion", 30, $oi);
printer_draw_text($handle, "P/U", 115, $oi);
printer_draw_text($handle, "Total", 155, $oi);
$oi=$oi+$n1;
printer_draw_text($handle, "____________________________________", 0, $oi);


///////////////
///
$subtotalf = 0;
///
 if($tipo==1){
$a = $db->query("select cod, cant, producto, pv, total, fecha, hora from ticket where mesa = ".$numero." and tx = ".$_SESSION["tx"]." and td = ".$_SESSION["td"]." group by cod");
 }
 if($tipo==2) {
$a = $db->query("select cod, cant, producto, pv, total, fecha, hora from ticket where num_fac = ".$numero."  and tx = ".$_SESSION["tx"]." and td = ".$_SESSION["td"]." group by cod");
 }
if($tipo==3) {
$a = $db->query("select cod, cant, producto, pv, total, fecha, hora from ticket where cancela = ".$numero." and mesa='$dato' and tx = ".$_SESSION["tx"]." and td = ".$_SESSION["td"]." group by cod");
 }   
    foreach ($a as $b) {
 
 $fechaf=$b["fecha"];
 $horaf=$b["hora"];

 if($tipo==1){
/// para hacer las sumas
if ($s = $db->select("sum(cant), sum(total)", "ticket", "WHERE cod = ".$b["cod"]." and mesa = '$numero' and tx = ".$_SESSION["tx"]." and td = ".$_SESSION["td"]."")) { 
        $scant=$s["sum(cant)"]; $stotal=$s["sum(total)"];
    } unset($s); 


if ($sx = $db->select("sum(total)", "ticket", "WHERE mesa = '$numero' and tx = ".$_SESSION["tx"]." and td = ".$_SESSION["td"]."")) { 
        $stotalx=$sx["sum(total)"];
    } unset($sx); 
//////
 }
 if($tipo==2) {
/// para hacer las sumas
if ($s = $db->select("sum(cant), sum(total)", "ticket", "WHERE cod = ".$b["cod"]." and num_fac = '$numero' and tx = ".$_SESSION["tx"]." and td = ".$_SESSION["td"]."")) { 
        $scant=$s["sum(cant)"]; $stotal=$s["sum(total)"];
    } unset($s); 
//////
if ($sx = $db->select("sum(total)", "ticket", "WHERE num_fac = '$numero' and tx = ".$_SESSION["tx"]." and td = ".$_SESSION["td"]."")) { 
       $stotalx=$sx["sum(total)"];
    } unset($sx); 
 
 }

  if($tipo==3) {
/// para hacer las sumas
if ($s = $db->select("sum(cant), sum(total)", "ticket", "WHERE cod = ".$b["cod"]." and cancela = '$numero' and mesa='$dato' and tx = ".$_SESSION["tx"]." and td = ".$_SESSION["td"]."")) { 
        $scant=$s["sum(cant)"]; $stotal=$s["sum(total)"];
    } unset($s); 
//////
if ($sx = $db->select("sum(total)", "ticket", "WHERE cancela = '$numero' and mesa='$dato' and tx = ".$_SESSION["tx"]." and td = ".$_SESSION["td"]."")) { 
       $stotalx=$sx["sum(total)"];
    } unset($sx); 
 
 }


          $oi=$oi+$n1;
          printer_draw_text($handle, $scant, 0, $oi);
          printer_draw_text($handle, $b["producto"], 30, $oi);
          printer_draw_text($handle, $b["pv"], 115, $oi);
          printer_draw_text($handle, $stotal, 155, $oi);

          $g="G";

          printer_draw_text($handle, $g, 180, $oi);
////
$subtotalf = $subtotalf + $stotal;
///

    }    $a->close();


$oi=$oi+$n3+$n1;
printer_draw_text($handle, "Sub Total " . $_SESSION['config_moneda_simbolo'] . ":", 100, $oi);
printer_draw_text($handle, Helpers::Format(Helpers::STotal($subtotalf, $_SESSION['config_imp'])), 170, $oi);


$oi=$oi+$n1;
printer_draw_text($handle, "15% Impu. " . $_SESSION['config_moneda_simbolo'] . ":", 100, $oi);
printer_draw_text($handle, Helpers::Format(Helpers::Impuesto(Helpers::STotal($subtotalf, $_SESSION['config_imp']), $_SESSION['config_imp'])), 170, $oi);


$oi=$oi+$n1;
printer_draw_text($handle, "18% Impu. ", 100, $oi);
printer_draw_text($handle, Helpers::Format(0), 170, $oi);


$oi=$oi+$n1;
printer_draw_text($handle, "Descuentos y Rebajas. ", 50, $oi);
printer_draw_text($handle, Helpers::Format(0), 170, $oi);


if($_SESSION['config_propina'] != 0.00){ ///  prara agregarle la propina -- sino borrar
$oi=$oi+$n1;
printer_draw_text($handle, "Propina:", 170, $oi);
printer_draw_text($handle, Helpers::Format(Helpers::Propina($subtotalf)), 100, $oi);
$subtotalf = Helpers::PropinaTotal($subtotalf);
}

$oi=$oi+$n1;
printer_draw_text($handle, "Total " . $_SESSION['config_moneda_simbolo'] . ":", 100, $oi);
printer_draw_text($handle, Helpers::Format($subtotalf), 170, $oi);

$oi=$oi+$n2;
printer_draw_text($handle, "____________________________________", 0, $oi);

//efectivo
if($efectivo == NULL){
  $efectivo = $subtotalf;
}
$oi=$oi+$n1;
printer_draw_text($handle, "Efectivo " . $_SESSION['config_moneda_simbolo'] . ":", 100, $oi);
printer_draw_text($handle, Helpers::Format($efectivo), 170, $oi);

//cambio
$cambios = $efectivo - $subtotalf;
$oi=$oi+$n1;
printer_draw_text($handle, "Cambio " . $_SESSION['config_moneda_simbolo'] . ":", 100, $oi);
printer_draw_text($handle, Helpers::Format($cambios), 170, $oi);

$oi=$oi+$n2;
printer_draw_text($handle, "___________________________________", 0, $oi);

$oi=$oi+$n1;
printer_draw_text($handle, "G=Articulo Gravado  E= Artculo Exento", 0, $oi);



$oi=$oi+$n1;
printer_draw_text($handle, $fechaf, 0, $oi);
printer_draw_text($handle, $horaf, 150, $oi);



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
printer_draw_text($handle, "GRACIAS POR SU COMPRA...", 27, $oi);
printer_delete_font($font);

$oi=$oi+$n1+$n2;
printer_draw_text($handle, ".", NULL, $oi);
printer_write($handle, chr(27).chr(112).chr(48).chr(55).chr(121)); //enviar pulso


///
///
///
///
printer_end_page($handle);
printer_end_doc($handle);
printer_close($handle);

}












}// class