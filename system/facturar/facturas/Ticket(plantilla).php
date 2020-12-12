 <?php  

class Ticket{
		public function __construct() { 
     } 

 public function Imprimir($tipo,$numero,$efectivo,$imp,$dato,$ticket){
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


 $logo_imagen="C:/AppServ/www/pizto/assets/img/logo_factura/". $img;


 $handle = printer_open($print);
 printer_set_option($handle, PRINTER_MODE, "RAW");

printer_start_doc($handle, "Mi Documento");
printer_start_page($handle);


printer_draw_bmp($handle, $logo_imagen, 100, 1, 300, 120);

$font = printer_create_font("Arial", $txt1, $txt2, PRINTER_FW_NORMAL, false, false, false, 0);
printer_select_font($handle, $font);


$oi="140";
printer_draw_text($handle, "ORDEN DE COMPRA", 100, $oi);


// $oi=$oi+$n2;
// printer_draw_text($handle, "____________________________________", 0, $oi);
// $oi=$oi+$n1;
// printer_draw_text($handle, "Cant.", 0, $oi);
// printer_draw_text($handle, "Descripcion", 140, $oi);
// printer_draw_text($handle, "P/U", 320, $oi);
// printer_draw_text($handle, "Total", 410, $oi);
// $oi=$oi+$n1;
// printer_draw_text($handle, "____________________________________", 0, $oi);

 if($tipo==1){
$a = $db->query("select cod, cant, producto, pv, total from ticket_temp where mesa = ".$numero." and tx = ".$_SESSION["tx"]." and td = ".$_SESSION["td"]." group by cod");
 }
 if($tipo==2) {
$a = $db->query("select cod, cant, producto, pv, total from ticket_temp where num_fac = ".$numero."  and tx = ".$_SESSION["tx"]." and td = ".$_SESSION["td"]." group by cod");
 }
if($tipo==3) {
$a = $db->query("select cod, cant, producto, pv, total from ticket_temp where cancela = ".$numero." and mesa='$dato' and tx = ".$_SESSION["tx"]." and td = ".$_SESSION["td"]." group by cod");
 }   
    foreach ($a as $b) {
 
 if($tipo==1){
/// para hacer las sumas
if ($s = $db->select("sum(cant), sum(total)", "ticket_temp", "WHERE cod = ".$b["cod"]." and mesa = '$numero' and tx = ".$_SESSION["tx"]." and td = ".$_SESSION["td"]."")) { 
        $scant=$s["sum(cant)"]; $stotal=$s["sum(total)"];
    } unset($s); 


if ($sx = $db->select("sum(total)", "ticket_temp", "WHERE mesa = '$numero' and tx = ".$_SESSION["tx"]." and td = ".$_SESSION["td"]."")) { 
        $stotalx=$sx["sum(total)"];
    } unset($sx); 
//////
 }
 if($tipo==2) {
/// para hacer las sumas
if ($s = $db->select("sum(cant), sum(total)", "ticket_temp", "WHERE cod = ".$b["cod"]." and num_fac = '$numero' and tx = ".$_SESSION["tx"]." and td = ".$_SESSION["td"]."")) { 
        $scant=$s["sum(cant)"]; $stotal=$s["sum(total)"];
    } unset($s); 
//////
if ($sx = $db->select("sum(total)", "ticket_temp", "WHERE num_fac = '$numero' and tx = ".$_SESSION["tx"]." and td = ".$_SESSION["td"]."")) { 
       $stotalx=$sx["sum(total)"];
    } unset($sx); 
 
 }

  if($tipo==3) {
/// para hacer las sumas
if ($s = $db->select("sum(cant), sum(total)", "ticket_temp", "WHERE cod = ".$b["cod"]." and cancela = '$numero' and mesa='$dato' and tx = ".$_SESSION["tx"]." and td = ".$_SESSION["td"]."")) { 
        $scant=$s["sum(cant)"]; $stotal=$s["sum(total)"];
    } unset($s); 
//////
if ($sx = $db->select("sum(total)", "ticket_temp", "WHERE cancela = '$numero' and mesa='$dato' and tx = ".$_SESSION["tx"]." and td = ".$_SESSION["td"]."")) { 
       $stotalx=$sx["sum(total)"];
    } unset($sx); 
 
 }


      $oi=$oi+$n1;
        printer_draw_text($handle, $scant, 0, $oi);
        printer_draw_text($handle, $b["producto"], 30, $oi);
        printer_draw_text($handle, $b["pv"], 315, $oi);
        printer_draw_text($handle, $stotal, 415, $oi);

    }    $a->close();



if($_SESSION['config_propina'] != 0.00){ ///  prara agregarle la propina -- sino borrar
$stotalx = Helpers::PropinaTotal($stotalx);
}


$oi=$oi+$n2;
printer_draw_text($handle, "Total:", 325, $oi);
printer_draw_text($handle, Helpers::Dinero($stotalx), 402, $oi);


if($efectivo != NULL){
$oi=$oi+$n1;
printer_draw_text($handle, "Efectivo:", 285, $oi);
printer_draw_text($handle, Helpers::Dinero($efectivo), 402, $oi);

$cambio = $efectivo - $stotalx;
  $oi=$oi+$n1;
  printer_draw_text($handle, "Cambio:", 290, $oi);
  printer_draw_text($handle, Helpers::Dinero($cambio), 402, $oi);
} else {
$oi=$oi+$n1;
printer_draw_text($handle, "Efectivo:", 285, $oi);
printer_draw_text($handle, Helpers::Dinero($stotalx), 402, $oi);

  $oi=$oi+$n1;
  printer_draw_text($handle, "Cambio:", 290, $oi);
  printer_draw_text($handle, Helpers::Dinero(0), 402, $oi);  
}

// $oi=$oi+$n2;
// printer_draw_text($handle, "____________________________________", 0, $oi);


$oi=$oi+$n1;
printer_draw_text($handle, date("d-m-Y"), 0, $oi);
printer_draw_text($handle, date("H:i:s"), 400, $oi);


$oi=$oi+$n1;
printer_draw_text($handle, "Cajero: " . $_SESSION['nombre'], 25, $oi);


$oi=$oi+$n1+$n2;
printer_draw_text($handle, "GRACIAS POR SU COMPRA...", 60, $oi);
printer_delete_font($font);
$oi=$oi+$n2;
printer_draw_text($handle, "REF: ". $numero, NULL, $oi);

if($_SESSION["td"] != 3){
$oi=$oi+$n1;
printer_draw_text($handle, ".", NULL, $oi);
}

printer_write($handle, chr(27).chr(112).chr(48).chr(55).chr(121)); //enviar pulso


printer_end_page($handle);
printer_end_doc($handle);
printer_close($handle);



  }




public function AbrirCaja($print){

    $handle = printer_open($print);
    printer_set_option($handle, PRINTER_MODE, "RAW");

    printer_start_doc($handle, "Mi Documento");
    printer_start_page($handle);
    printer_write($handle, chr(27).chr(112).chr(48).chr(55).chr(121)); //enviar pulso
    printer_end_page($handle);
    printer_end_doc($handle, 20);
    printer_close($handle);

  }















 public function Italia($tipo,$numero,$efectivo,$imp,$dato,$ticket){
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


 $logo_imagen="C:/AppServ/www/pizto/assets/img/logo_factura/". $img;


 $handle = printer_open($print);
 printer_set_option($handle, PRINTER_MODE, "RAW");

printer_start_doc($handle, "Mi Documento");
printer_start_page($handle);

printer_draw_bmp($handle, $logo_imagen, 100, 1, 300, 120);

$font = printer_create_font("Arial", $txt1, $txt2, PRINTER_FW_NORMAL, false, false, false, 0);
printer_select_font($handle, $font);


$oi="140";
printer_draw_text($handle, "ORDEN DE COMPRA", 100, $oi);


// $oi=$oi+$n2;
// printer_draw_text($handle, "____________________________________", 0, $oi);
// $oi=$oi+$n1;
// printer_draw_text($handle, "Cant.", 0, $oi);
// printer_draw_text($handle, "Descripcion", 140, $oi);
// printer_draw_text($handle, "P/U", 320, $oi);
// printer_draw_text($handle, "Total", 410, $oi);
// $oi=$oi+$n1;
// printer_draw_text($handle, "____________________________________", 0, $oi);

 if($tipo==1){
$a = $db->query("select cod, cant, producto, pv, total from ticket_temp where mesa = ".$numero." and tx = ".$_SESSION["tx"]." and td = ".$_SESSION["td"]." group by cod");
 }
 if($tipo==2) {
$a = $db->query("select cod, cant, producto, pv, total from ticket_temp where num_fac = ".$numero."  and tx = ".$_SESSION["tx"]." and td = ".$_SESSION["td"]." group by cod");
 }
if($tipo==3) {
$a = $db->query("select cod, cant, producto, pv, total from ticket_temp where cancela = ".$numero." and mesa='$dato' and tx = ".$_SESSION["tx"]." and td = ".$_SESSION["td"]." group by cod");
 }   
    foreach ($a as $b) {
 
 if($tipo==1){
/// para hacer las sumas
if ($s = $db->select("sum(cant), sum(total)", "ticket_temp", "WHERE cod = ".$b["cod"]." and mesa = '$numero' and tx = ".$_SESSION["tx"]." and td = ".$_SESSION["td"]."")) { 
        $scant=$s["sum(cant)"]; $stotal=$s["sum(total)"];
    } unset($s); 


if ($sx = $db->select("sum(total)", "ticket_temp", "WHERE mesa = '$numero' and tx = ".$_SESSION["tx"]." and td = ".$_SESSION["td"]."")) { 
        $stotalx=$sx["sum(total)"];
    } unset($sx); 
//////
 }
 if($tipo==2) {
/// para hacer las sumas
if ($s = $db->select("sum(cant), sum(total)", "ticket_temp", "WHERE cod = ".$b["cod"]." and num_fac = '$numero' and tx = ".$_SESSION["tx"]." and td = ".$_SESSION["td"]."")) { 
        $scant=$s["sum(cant)"]; $stotal=$s["sum(total)"];
    } unset($s); 
//////
if ($sx = $db->select("sum(total)", "ticket_temp", "WHERE num_fac = '$numero' and tx = ".$_SESSION["tx"]." and td = ".$_SESSION["td"]."")) { 
       $stotalx=$sx["sum(total)"];
    } unset($sx); 
 
 }

  if($tipo==3) {
/// para hacer las sumas
if ($s = $db->select("sum(cant), sum(total)", "ticket_temp", "WHERE cod = ".$b["cod"]." and cancela = '$numero' and mesa='$dato' and tx = ".$_SESSION["tx"]." and td = ".$_SESSION["td"]."")) { 
        $scant=$s["sum(cant)"]; $stotal=$s["sum(total)"];
    } unset($s); 
//////
if ($sx = $db->select("sum(total)", "ticket_temp", "WHERE cancela = '$numero' and mesa='$dato' and tx = ".$_SESSION["tx"]." and td = ".$_SESSION["td"]."")) { 
       $stotalx=$sx["sum(total)"];
    } unset($sx); 
 
 }


      $oi=$oi+$n1;
        printer_draw_text($handle, $scant, 0, $oi);
        printer_draw_text($handle, $b["producto"], 30, $oi);

    }    $a->close();




// $oi=$oi+$n2;
// printer_draw_text($handle, "____________________________________", 0, $oi);

$oi=$oi+$n1;
$oi=$oi+$n1;
printer_draw_text($handle, date("d-m-Y"), 0, $oi);
printer_draw_text($handle, date("H:i:s"), 400, $oi);


$oi=$oi+$n1;
printer_draw_text($handle, "Cajero: " . $_SESSION['nombre'], 25, $oi);

printer_delete_font($font);
$oi=$oi+$n2;
printer_draw_text($handle, "REF: ". $numero, NULL, $oi);
printer_write($handle, chr(27).chr(112).chr(48).chr(55).chr(121)); //enviar pulso


printer_end_page($handle);
printer_end_doc($handle);
printer_close($handle);

  }






}// class