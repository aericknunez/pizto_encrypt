 <?php  
use Mike42\Escpos\EscposImage;
use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;
use Mike42\Escpos\Printer;



class Impresiones{
    public function __construct() { 
     } 


 
 public function Ticket($efectivo, $numero){
  $db = new dbConn();
  $nombre_impresora = "PRECUENTA";
  $img  = "C:/AppServ/www/pizto/assets/img/logo_factura/grosera.jpg";


$connector = new WindowsPrintConnector($nombre_impresora);
$printer = new Printer($connector);
$printer -> initialize();

$printer -> setFont(Printer::FONT_B);
// $printer -> selectPrintMode(Printer::MODE_DOUBLE_HEIGHT);
// $printer -> selectPrintMode(Printer::MODE_DOUBLE_WIDTH);

$printer -> setTextSize(1, 2);
$printer -> setLineSpacing(80);


$printer -> setJustification(Printer::JUSTIFY_CENTER);
$logo = EscposImage::load($img, false);
$printer->bitImage($logo);
$printer -> setJustification(Printer::JUSTIFY_LEFT);

$printer->text("Km 35 carretera panamericana, Cojutepeque");

$printer->feed();
$printer->text("Tel: 2313-4541");

$printer->feed();
$printer->text("FACTURA NUMERO: " . $numero);


/* Stuff around with left margin */
$printer->feed();
$printer -> setJustification(Printer::JUSTIFY_CENTER);
$printer -> text("____________________________________________________________");
$printer -> setJustification(Printer::JUSTIFY_LEFT);
$printer->feed();
/* Items */

$printer -> setJustification(Printer::JUSTIFY_LEFT);
$printer -> setEmphasis(true);
$printer -> text($this->Item("Cant", 'Producto', 'Precio', 'Total'));
$printer -> setEmphasis(false);


$subtotalf = 0;

$a = $db->query("select cod, cant, producto, pv, total, fecha, hora, num_fac from ticket where num_fac = '".$numero."' $cancelar and tx = ".$_SESSION["tx"]." and td = ".$_SESSION["td"]." group by cod");
  
    foreach ($a as $b) {
 
 $fechaf=$b["fecha"];
 $horaf=$b["hora"];
 $num_fac=$b["num_fac"];


/// para hacer las sumas
if ($s = $db->select("sum(cant), sum(total)", "ticket", "WHERE cod = ".$b["cod"]." and num_fac = '".$numero."'  $cancelar and tx = ".$_SESSION["tx"]." and td = ".$_SESSION["td"]."")) { 
        $scant=$s["sum(cant)"]; $stotal=$s["sum(total)"];
    } unset($s); 
//////
if ($sx = $db->select("sum(total)", "ticket", "WHERE num_fac = '".$numero."'  $cancelar and tx = ".$_SESSION["tx"]." and td = ".$_SESSION["td"]."")) { 
       $stotalx=$sx["sum(total)"];
    } unset($sx); 
 
$printer -> text($this->Item($scant, $b["producto"], $b["pv"], $stotal));

////
$subtotalf = $subtotalf + $stotal;
///

    }    $a->close();


$printer -> text("____________________________________________________________");
$printer->feed();


    if ($r = $db->select("total", "ticket_propina", "WHERE num_fac = '".$numero."' and tx = ".$_SESSION["tx"]." and td = ".$_SESSION["td"]."")) { 
        $propina = $r["total"];
    } unset($r); 


$printer -> text($this->DosCol("Sub Total " . $_SESSION['config_moneda_simbolo'] . ":", 40, Helpers::Format($subtotalf), 20));




if($propina > 0.00){ ///  prara agregarle la propina -- sino borrar
$printer -> text($this->DosCol("Propina " . $_SESSION['config_moneda_simbolo'] . ":", 40, Helpers::Format($propina), 20));
}

$xtotal = $subtotalf + $propina;
$printer -> text($this->DosCol("Total " . $_SESSION['config_moneda_simbolo'] . ":", 40, Helpers::Format($xtotal), 20));


$printer -> text("____________________________________________________________");
$printer->feed();


//efectivo
if($efectivo == NULL){
  $efectivo = $xtotal;
}

$printer -> text($this->DosCol("Efectivo " . $_SESSION['config_moneda_simbolo'] . ":", 40, Helpers::Format($efectivo), 20));




//cambio
$cambios = $efectivo - $xtotal;

$printer -> text($this->DosCol("Cambio " . $_SESSION['config_moneda_simbolo'] . ":", 40, Helpers::Format($cambios), 20));


$printer -> text("____________________________________________________________");
$printer->feed();




$printer -> text($this->DosCol($fechaf, 30, $horaf, 30));



$printer -> text("Cajero: " . $_SESSION['nombre']);

$printer->feed();
$printer -> setJustification(Printer::JUSTIFY_CENTER);
$printer -> text("GRACIAS POR SU PREFERENCIA...");
$printer -> setJustification();




$printer->feed();
$printer->cut();
$printer->pulse();
$printer->close();

}









 public function Factura($efectivo, $numero){
  $db = new dbConn();

}   /// termina FACTURA





 public function CreditoFiscal($data){
  $db = new dbConn();

}










 public function ImprimirAntes($efectivo, $numero, $cancelar){
  $db = new dbConn();

  $nombre_impresora = "PRECUENTA";
  $img  = "C:/AppServ/www/pizto/assets/img/logo_factura/grosera.jpg";


$connector = new WindowsPrintConnector($nombre_impresora);
$printer = new Printer($connector);
$printer -> initialize();

$printer -> setFont(Printer::FONT_B);

$printer -> setTextSize(1, 2);
$printer -> setLineSpacing(80);


$printer -> setJustification(Printer::JUSTIFY_CENTER);
$logo = EscposImage::load($img, false);
$printer->bitImage($logo);
$printer -> setJustification(Printer::JUSTIFY_LEFT);

$printer->text("Km 35 carretera panamericana, Cojutepeque");

$printer->feed();
$printer->text("Tel: 2313-4541");

$printer->feed();
$printer->text("ORDEN NUMERO: " . $numero);


$printer->feed();
$printer->text("PRECUENTA");


/* Stuff around with left margin */
$printer->feed();
$printer -> setJustification(Printer::JUSTIFY_CENTER);
$printer -> text("____________________________________________________________");
$printer -> setJustification(Printer::JUSTIFY_LEFT);
$printer->feed();
/* Items */

$printer -> setJustification(Printer::JUSTIFY_LEFT);
$printer -> setEmphasis(true);
$printer -> text($this->Item("Cant", 'Producto', 'Precio', 'Total'));
$printer -> setEmphasis(false);



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
 
 
$printer -> text($this->Item($scant, $b["producto"], $b["pv"], $stotal));

////
$subtotalf = $subtotalf + $stotal;
///

    }    $a->close();




$printer -> text("____________________________________________________________");
$printer->feed();



$printer -> text($this->DosCol("Sub Total " . $_SESSION['config_moneda_simbolo'] . ":", 40, Helpers::Format($subtotalf), 20));



if($_SESSION['config_propina'] != 0.00 and $_SESSION["delivery_on"] == FALSE and $_SESSION["aquiLlevar"] == "on"){ ///  prara agregarle la propina -- sino borrar
$printer -> text($this->DosCol("Propina " . $_SESSION['config_moneda_simbolo'] . ":", 40, Helpers::Format(Helpers::Propina($subtotalf)), 20));
  $subtotalf = Helpers::PropinaTotal($subtotalf);
}



$xtotal = $subtotalf + $propina;
$printer -> text($this->DosCol("Total " . $_SESSION['config_moneda_simbolo'] . ":", 40, Helpers::Format($xtotal), 20));







$printer -> text("____________________________________________________________");
$printer->feed();





$printer -> text($this->DosCol($fechaf, 30, $horaf, 30));


$printer -> text("Cajero: " . $_SESSION['nombre']);
$printer->feed();

//// imprimir datos del cliente delivery
    if ($r = $db->select("cliente", "clientes_mesa", "WHERE mesa = '".$_SESSION["mesa"]."' and tx = ".$_SESSION["tx"]." and td = ".$_SESSION["td"]."")) { 
        $clientex = $r["cliente"];
    } unset($r);  

    if ($r = $db->select("nombre, direccion, telefono", "clientes", "WHERE hash = '".$clientex."'  and td = ".$_SESSION["td"]."")) { 
        $cnombre = $r["nombre"];
        $cdireccion = $r["direccion"];
        $ctelefono = $r["telefono"];
    } unset($r);  

if($cnombre != NULL){
  $printer -> text("Cliente: " . $cnombre);
  $printer->feed();
}
if($cdireccion != NULL){
  $printer -> text($cdireccion);
  $printer->feed();
}
if($ctelefono != NULL){
  $printer -> text("Telefono: " . $ctelefono);
  $printer->feed();
}

// datos del cliente delivery


// nombre de mesa
if ($r = $db->select("nombre", "mesa_nombre", "WHERE mesa = ".$_SESSION["mesa"]." and td = ".$_SESSION["td"]." and tx = ".$_SESSION["tx"]."")) { 
    $nombre_mesa = $r["nombre"];
} unset($r);  

if($nombre_mesa != NULL){
  $printer -> text("Mesa: " . $nombre_mesa);
   $printer->feed();
}



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

  $printer -> text($lleva);
   $printer->feed();


$printer -> text("____________________________________________________________");
$printer->feed();


$printer->feed();
$printer -> setJustification(Printer::JUSTIFY_CENTER);
$printer -> text("GRACIAS POR SU PREFERENCIA...");
$printer -> setJustification();


$printer->feed();
$printer->cut();
$printer->close();

} /// TERMINA IMPRIMIR ANTES






 public function Comanda(){
$db = new dbConn();

$cambio = array();
$cambio["edo"] = 0;  
Helpers::UpdateId("mesa_comanda_edo", $cambio, "mesa = ".$_SESSION["mesa"]." and tx = ".$_SESSION["tx"]." and td = ".$_SESSION["td"]."");


  $this->ComandaCocina();
  $this->ComandaBar();

 }




 public function ComandaCocina(){
  $db = new dbConn();


$a = $db->query("select ticket_temp.cod as cod, ticket_temp.hash as hash, ticket_temp.cant as cant, ticket_temp.producto as producto, control_cocina.cod as codigo 
  FROM ticket_temp, control_panel_mostrar, control_cocina 
  WHERE ticket_temp.mesa = '".$_SESSION["mesa"]."' and ticket_temp.tx = ".$_SESSION["tx"]." and ticket_temp.td = ".$_SESSION["td"]." and control_panel_mostrar.producto = ticket_temp.cod and control_panel_mostrar.panel = 1 AND control_cocina.identificador = ticket_temp.hash and control_cocina.edo = 1 and control_cocina.cod = ticket_temp.cant");

 $cantidadproductos = $a->num_rows;

 if($cantidadproductos > 0){



$nombre_impresora = "PRECUENTA";

$connector = new WindowsPrintConnector($nombre_impresora);
$printer = new Printer($connector);
$printer -> initialize();


$printer -> setJustification(Printer::JUSTIFY_LEFT);

$printer -> selectPrintMode(Printer::MODE_DOUBLE_HEIGHT);
$printer -> selectPrintMode(Printer::MODE_DOUBLE_WIDTH);
$printer -> text("COMANDA DE COCINA");
$printer -> selectPrintMode();
$printer->feed();


$printer -> setFont(Printer::FONT_B);

$printer -> setTextSize(1, 2);
$printer -> setLineSpacing(80);


$printer -> text("____________________________________________________________");
$printer->feed();


    foreach ($a as $b) {
//////
// obtener cantidad (la cantidad se cuentan cuantos hay activos en controlcocina)
$cont = $db->query("SELECT * FROM control_cocina WHERE edo = 1 and identificador = '".$b["hash"]."' and mesa = ".$_SESSION["mesa"]." and td = ".$_SESSION["td"]."");
$canti_p = $cont->num_rows;
$cont->close();
///
 

$printer -> text($canti_p . " - " .  $b["producto"]);
$printer->feed();


  $ap = $db->query("SELECT cod FROM control_cocina WHERE identificador = '".$b["hash"]."' and mesa = ".$_SESSION["mesa"]." and td = ".$_SESSION["td"]." and edo = 1");
  foreach ($ap as $bp) {

    $ar = $db->query("SELECT opcion FROM opciones_ticket WHERE identificador = '".$b["hash"]."' and mesa = ".$_SESSION["mesa"]." and td = ".$_SESSION["td"]." and cod = '".$bp["cod"]."'");
    foreach ($ar as $br) {

if ($r = $db->select("nombre", "opciones_name", "WHERE cod = '".$br["opcion"]."' and td = ".$_SESSION["td"]."")) {


$printer -> text("* " . $r["nombre"]);
$printer->feed();

} unset($r); 

    } $ar->close();

} $ap->close();

// aqui debo actualizar para borrar si es ticket el que lleva el control de panel mostrar (paso a estado 2)
if($_SESSION["config_o_ticket_pantalla"] == 2){
    $cambio = array();
    $cambio["edo"] = 2;
    Helpers::UpdateId("control_cocina", $cambio, "identificador = '".$b["hash"]."' and td = ".$_SESSION["td"]."");
}

    }    $a->close();


$printer -> text("____________________________________________________________");
$printer->feed();



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



$printer -> text($this->DosCol($lleva, 11, "MESA: " . $_SESSION['mesa'], 30));


$printer -> text($this->DosCol(date("d-m-Y"), 11, date("H:i:s"), 30));

$printer -> text("Cajero: " . $_SESSION['nombre']);
$printer->feed();


// nombre de mesa
if ($r = $db->select("nombre", "mesa_nombre", "WHERE mesa = ".$_SESSION["mesa"]." and td = ".$_SESSION["td"]." and tx = ".$_SESSION["tx"]."")) { 
    $nombre_mesa = $r["nombre"];
} unset($r);  

if($nombre_mesa != NULL){

$printer -> text("Mesa: " . $nombre_mesa);
$printer->feed();
}




// COMENTARIOS DE LA MESA
if ($r = $db->select("comentario", "mesa_comentarios", "WHERE mesa = ".$_SESSION["mesa"]." and td = ".$_SESSION["td"]." and tx = ".$_SESSION["tx"]."")) { 
    $comentario = $r["comentario"];
} unset($r);  

if($comentario != NULL){
$printer -> text("OBSERVACIONES: " . $comentario);
$printer->feed();
}





$printer->feed();
$printer->cut();
$printer->close();


} // cantidad de productos


}






 public function ComandaBar(){
  $db = new dbConn();

$a = $db->query("select ticket_temp.cod as cod, ticket_temp.hash as hash, ticket_temp.cant as cant, ticket_temp.producto as producto, control_cocina.cod as codigo 
  FROM ticket_temp, control_panel_mostrar, control_cocina 
  WHERE ticket_temp.mesa = '".$_SESSION["mesa"]."' and ticket_temp.tx = ".$_SESSION["tx"]." and ticket_temp.td = ".$_SESSION["td"]." and control_panel_mostrar.producto = ticket_temp.cod and control_panel_mostrar.panel = 2 AND control_cocina.identificador = ticket_temp.hash and control_cocina.edo = 1 and control_cocina.cod = ticket_temp.cant");

 $cantidadproductos = $a->num_rows;

 if($cantidadproductos > 0){



$nombre_impresora = "BAR";

$connector = new WindowsPrintConnector($nombre_impresora);
$printer = new Printer($connector);
$printer -> initialize();


$printer -> setJustification(Printer::JUSTIFY_LEFT);

$printer -> selectPrintMode(Printer::MODE_DOUBLE_HEIGHT);
$printer -> selectPrintMode(Printer::MODE_DOUBLE_WIDTH);
$printer -> text("COMANDA DE BAR");
$printer -> selectPrintMode();
$printer->feed();


$printer -> setFont(Printer::FONT_B);

$printer -> setTextSize(1, 2);
$printer -> setLineSpacing(80);


$printer -> text("____________________________________________________________");
$printer->feed();


    foreach ($a as $b) {
//////
// obtener cantidad (la cantidad se cuentan cuantos hay activos en controlcocina)
$cont = $db->query("SELECT * FROM control_cocina WHERE edo = 1 and identificador = '".$b["hash"]."' and mesa = ".$_SESSION["mesa"]." and td = ".$_SESSION["td"]."");
$canti_p = $cont->num_rows;
$cont->close();
///
 

$printer -> text($canti_p . " - " .  $b["producto"]);
$printer->feed();


  $ap = $db->query("SELECT cod FROM control_cocina WHERE identificador = '".$b["hash"]."' and mesa = ".$_SESSION["mesa"]." and td = ".$_SESSION["td"]." and edo = 1");
  foreach ($ap as $bp) {

    $ar = $db->query("SELECT opcion FROM opciones_ticket WHERE identificador = '".$b["hash"]."' and mesa = ".$_SESSION["mesa"]." and td = ".$_SESSION["td"]." and cod = '".$bp["cod"]."'");
    foreach ($ar as $br) {

if ($r = $db->select("nombre", "opciones_name", "WHERE cod = '".$br["opcion"]."' and td = ".$_SESSION["td"]."")) {


$printer -> text("* " . $r["nombre"]);
$printer->feed();

} unset($r); 

    } $ar->close();

} $ap->close();

// aqui debo actualizar para borrar si es ticket el que lleva el control de panel mostrar (paso a estado 2)
if($_SESSION["config_o_ticket_pantalla"] == 2){
    $cambio = array();
    $cambio["edo"] = 2;
    Helpers::UpdateId("control_cocina", $cambio, "identificador = '".$b["hash"]."' and td = ".$_SESSION["td"]."");
}

    }    $a->close();


$printer -> text("____________________________________________________________");
$printer->feed();



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



$printer -> text($this->DosCol($lleva, 11, "MESA: " . $_SESSION['mesa'], 30));


$printer -> text($this->DosCol(date("d-m-Y"), 11, date("H:i:s"), 30));

$printer -> text("Cajero: " . $_SESSION['nombre']);
$printer->feed();


// nombre de mesa
if ($r = $db->select("nombre", "mesa_nombre", "WHERE mesa = ".$_SESSION["mesa"]." and td = ".$_SESSION["td"]." and tx = ".$_SESSION["tx"]."")) { 
    $nombre_mesa = $r["nombre"];
} unset($r);  

if($nombre_mesa != NULL){

$printer -> text("Mesa: " . $nombre_mesa);
$printer->feed();
}




// COMENTARIOS DE LA MESA
if ($r = $db->select("comentario", "mesa_comentarios", "WHERE mesa = ".$_SESSION["mesa"]." and td = ".$_SESSION["td"]." and tx = ".$_SESSION["tx"]."")) { 
    $comentario = $r["comentario"];
} unset($r);  

if($comentario != NULL){
$printer -> text("OBSERVACIONES: " . $comentario);
$printer->feed();
}







$printer->feed();
$printer->cut();
$printer->close();


} // cantidad de productos


}












 public function ReporteDiario($fecha){
  $db = new dbConn();



}   // termina reporte diario








 public function AbrirCaja(){
$nombre_impresora = "PRECUENTA";

$connector = new WindowsPrintConnector($nombre_impresora);
$printer = new Printer($connector);
$printer->pulse();
$printer->close();
}









 public function ReporteCorte(){ // imprime el resumen del ultimo corte
  $db = new dbConn();



  $nombre_impresora = "PRECUENTA";


$connector = new WindowsPrintConnector($nombre_impresora);
$printer = new Printer($connector);
$printer -> initialize();

$printer -> setFont(Printer::FONT_B);

$printer -> setTextSize(1, 2);
$printer -> setLineSpacing(80);

$printer -> setJustification(Printer::JUSTIFY_LEFT);

$printer -> text("RESUMEN DE CORTE DE CAJA");

/* Stuff around with left margin */
$printer->feed();
$printer -> setJustification(Printer::JUSTIFY_CENTER);
$printer -> text("____________________________________________________________");
$printer -> setJustification(Printer::JUSTIFY_LEFT);
$printer->feed();
/* Items */



$printer -> setJustification(Printer::JUSTIFY_LEFT);
$printer -> setEmphasis(true);
$printer -> text($this->Item("Cant", 'Producto', 'Precio', 'Total'));
$printer -> setEmphasis(false);

///
$subtotalf = 0;
///
// OBTENER EL NUMERO INICIAL DE TIME
    if ($r = $db->select("efectivo, time", "corte_diario", "WHERE edo = 1 and td = ".$_SESSION["td"]." order by time desc limit 1, 1")) { 
        $apertura = $r["efectivo"];
        $inicio = $r["time"]+1;
    } unset($r);  
////


$a = $db->query("select cod, cant, producto, pv, total, fecha, hora, num_fac from ticket where time BETWEEN '".$inicio."' and '".Helpers::TimeId()."' and td = ".$_SESSION["td"]." order by num_fac");
  
    foreach ($a as $b) {
 
$subtotalf = 0;

$printer -> text($this->Item("(". $b["num_fac"] . ") " . $b["cant"], $b["producto"], $b["pv"], $b["total"]));

$subtotalf = $subtotalf + $stotal;
///

}    $a->close();


$printer -> text("____________________________________________________________");
$printer->feed();

  // total de venta
      $axy = $db->query("SELECT SUM(total) FROM ticket WHERE time BETWEEN '".$inicio."' and '".Helpers::TimeId()."' and edo = 1 and td = ".$_SESSION["td"]."");
    foreach ($axy as $bxy) {
        $counte=$bxy["SUM(total)"];
    } $axy->close();





//////////////// del corte anterior
    if ($r = $db->select("efectivo, propina, total, gastos, diferencia, clientes, time", "corte_diario", "WHERE edo = 1 and td = ".$_SESSION["td"]." order by time desc")) { 
        $efectivo = $r["efectivo"];
        $propina = $r["propina"];
        $total = $r["total"];
        $gastos = $r["gastos"];
        $diferencia = $r["diferencia"];
        $clientes = $r["clientes"];
        $fin = $r["time"];

    } unset($r);  





// tarjeta de credito
$a = $db->query("SELECT sum(total) FROM ticket WHERE edo = 1 and tipo_pago = 2 and td = ".$_SESSION["td"]." and time BETWEEN '".$inicio."' and '".$fin."'");
    foreach ($a as $b) {
     $tarjetacredito=$b["sum(total)"];
    } $a->close();

// venta en efectivo
$a = $db->query("SELECT sum(total) FROM ticket WHERE edo = 1 and tipo_pago = 1 and td = ".$_SESSION["td"]." and time BETWEEN '".$inicio."' and '".$fin."'");
    foreach ($a as $b) {
     $vefectivo=$b["sum(total)"];
    } $a->close();

/// propina de tarjeta
    $a = $db->query("SELECT num_fac, tx FROM ticket WHERE edo = 1 and tipo_pago = 2 and td = ".$_SESSION["td"]." and time BETWEEN  '".$inicio."' and '".$fin."' GROUP BY num_fac");
    $propinatarjetac = 0;
    foreach ($a as $b) {

      if ($r = $db->select("total", "ticket_propina", "WHERE num_fac = ".$b["num_fac"]." and td = ".$_SESSION["td"]." and tx = ".$b["tx"]."")) { 
          $totalx = $r["total"];
      } unset($r);  
      $propinatarjetac = $propinatarjetac + $totalx;
    } $a->close();


/// propina de efectivo
    $a = $db->query("SELECT num_fac, tx FROM ticket WHERE edo = 1 and tipo_pago = 1 and td = ".$_SESSION["td"]." and time BETWEEN  '".$inicio."' and '".$fin."' GROUP BY num_fac");
    $propinatarjetae = 0;
    foreach ($a as $b) {

      if ($r = $db->select("total", "ticket_propina", "WHERE num_fac = ".$b["num_fac"]." and td = ".$_SESSION["td"]." and tx = ".$b["tx"]."")) { 
          $total2 = $r["total"];
      } unset($r);  
      $propinatarjetae = $propinatarjetae + $total2;
    } $a->close();






$printer -> text($this->DosCol("VENTA EN EFECTIVO: ", 40, Helpers::Dinero($vefectivo), 20));

$printer -> text($this->DosCol("PROPINA EN EFECTIVO: ", 40, Helpers::Dinero($propinatarjetae), 20));


$printer -> text($this->DosCol("VENTA CON TARJETA: ", 40, Helpers::Dinero($tarjetacredito), 20));

$printer -> text($this->DosCol("PROPINA CON TARJETA: ", 40, Helpers::Dinero($propinatarjetac), 20));



$printer -> text($this->DosCol("TOTAL DE VENTA: ", 40, Helpers::Dinero($counte), 20));




  // total de venta
      $axy = $db->query("SELECT sum(total) FROM ticket_propina WHERE time BETWEEN '".$inicio."' and '".Helpers::TimeId()."' and td = ".$_SESSION["td"]."");
    foreach ($axy as $bxy) {
        $propinas=$bxy["sum(total)"];
    } $axy->close();


$printer -> text($this->DosCol("TOTAL DE PROPINA: ", 40, Helpers::Dinero($propinas), 20));



$printer -> text($this->DosCol("TOTAL: ", 40, Helpers::Dinero($counte + $propinas), 20));


  
$printer -> text("____________________________________________________________");
$printer->feed();



// Eliminadas
  $axy = $db->query("SELECT count(num_fac) FROM ticket_num WHERE time BETWEEN '".$inicio."' and '".Helpers::TimeId()."' and tx = 1 and edo = 2 and td = ".$_SESSION["td"]."");
foreach ($axy as $bxy) {
    $counte=$bxy["count(num_fac)"];
} $axy->close();



$printer -> text($this->DosCol("TICKET ELIMINADOS: ", 40, $counte, 20));


$printer -> text("____________________________________________________________");
$printer->feed();




// gastos
  $axy = $db->query("SELECT sum(cantidad) FROM gastos WHERE tipo != 3 and tipo != 5 and time BETWEEN '".$inicio."' and '".Helpers::TimeId()."' and edo = 1 and td = ".$_SESSION["td"]."");
foreach ($axy as $bxy) {
    $gasto=$bxy["sum(cantidad)"];
} $axy->close();

// remesas (tipo  3)
  $axy = $db->query("SELECT sum(cantidad) FROM gastos WHERE tipo = 3 and time BETWEEN '".$inicio."' and '".Helpers::TimeId()."' and edo = 1 and td = ".$_SESSION["td"]."");
foreach ($axy as $bxy) {
    $remesas=$bxy["sum(cantidad)"];
} $axy->close();



$printer -> text($this->DosCol("GASTOS REGISTRADOS: ", 40, Helpers::Dinero($gasto), 10));


$printer -> text($this->DosCol("REMESAS: ", 40, Helpers::Dinero($remesas), 10));


$printer -> text("_______________________________________________________");
$printer->feed();




$printer -> text($this->DosCol("DINERO EN APERTURA: ", 40, Helpers::Dinero($apertura), 20));

$printer -> text($this->DosCol("EFECTIVO INGRESADO: ", 40, Helpers::Dinero($efectivo), 20));


$printer -> text($this->DosCol("DIFERENCIA: ", 40, Helpers::Dinero($diferencia), 20));

$printer -> text("____________________________________________________________");
$printer->feed();




$printer -> text("ORDENES ELIMINADAS: ");
$printer->feed();

$printer -> setJustification(Printer::JUSTIFY_LEFT);
$printer -> setEmphasis(true);
$printer -> text($this->Item("#", 'Cant', 'Descripcion', 'Total'));
$printer -> setEmphasis(false);


$printer -> text("____________________________________________________________");
$printer->feed();



$a = $db->query("select mesa, cod, cant, producto, pv, total, fecha, hora, num_fac from ticket_borrado where time BETWEEN '".$inicio."' and '".Helpers::TimeId()."' and td = ".$_SESSION["td"]." order by num_fac");
  
    foreach ($a as $b) {
 
$subtotalf = 0;

$printer -> text($this->Item("(" . $b["mesa"] . ") " . $b["cant"], $b["producto"], NULL ,$b["total"]));

$subtotalf = $subtotalf + $stotal;
///

}    $a->close();



$printer->feed();
$printer->cut();
$printer->close();


}












 public function EliminaOrden(){ 
  $this->EliminaOrdenCocina();
 }










 public function EliminaOrdenCocina(){ // imprime el el producto que se borro
  $db = new dbConn();



$a = $db->query("select ticket_borrado.cod as cod, ticket_borrado.hash as hash, ticket_borrado.cant as cant, ticket_borrado.producto as producto, control_cocina.cod as codigo 
  FROM ticket_borrado, control_panel_mostrar, control_cocina 
  WHERE ticket_borrado.mesa = '".$_SESSION["mesa"]."' and ticket_borrado.tx = ".$_SESSION["tx"]." and ticket_borrado.td = ".$_SESSION["td"]." and control_panel_mostrar.producto = ticket_borrado.cod and control_panel_mostrar.panel = 1 AND control_cocina.identificador = ticket_borrado.hash and control_cocina.edo = 3 and control_cocina.cod = ticket_borrado.cant");

 $cantidadproductos = $a->num_rows;

 if($cantidadproductos > 0){

$nombre_impresora = "PRECUENTA";

$connector = new WindowsPrintConnector($nombre_impresora);
$printer = new Printer($connector);
$printer -> initialize();


$printer -> setJustification(Printer::JUSTIFY_LEFT);

$printer -> selectPrintMode(Printer::MODE_DOUBLE_HEIGHT);
$printer -> selectPrintMode(Printer::MODE_DOUBLE_WIDTH);
$printer -> text("ORDEN CANCELADA!");
$printer -> selectPrintMode();
$printer->feed();


$printer -> setFont(Printer::FONT_B);

$printer -> setTextSize(1, 2);
$printer -> setLineSpacing(80);


$printer -> text("____________________________________________________________");
$printer->feed();


    if ($r = $db->select("motivo", "mesa_borrado", "WHERE mesa='".$_SESSION["mesa"]."' and tx = ".$_SESSION["tx"]." and td = ".$_SESSION["td"]."")) { 
        $motivo = $r["motivo"];
    } unset($r); 

$printer -> text("MOTIVO: " . $motivo);
$printer->feed();

$printer -> text("____________________________________________________________");
$printer->feed();


    foreach ($a as $b) {
//////
// obtener cantidad (la cantidad se cuentan cuantos hay activos en controlcocina)
$cont = $db->query("SELECT * FROM control_cocina WHERE edo = 3 and identificador = '".$b["hash"]."' and mesa = ".$_SESSION["mesa"]." and td = ".$_SESSION["td"]."");
$canti_p = $cont->num_rows;
$cont->close();
///
 

$printer -> text($canti_p . " - " .  $b["producto"]);
$printer->feed();



  $ap = $db->query("SELECT cod FROM control_cocina WHERE identificador = '".$b["hash"]."' and mesa = ".$_SESSION["mesa"]." and td = ".$_SESSION["td"]." and edo = 3");
  foreach ($ap as $bp) {

    $ar = $db->query("SELECT opcion FROM opciones_ticket WHERE identificador = '".$b["hash"]."' and mesa = ".$_SESSION["mesa"]." and td = ".$_SESSION["td"]." and cod = '".$bp["cod"]."'");
    foreach ($ar as $br) {

if ($r = $db->select("nombre", "opciones_name", "WHERE cod = '".$br["opcion"]."' and td = ".$_SESSION["td"]."")) {


$printer -> text("* " . $r["nombre"]);
$printer->feed();

} unset($r); 

    } $ar->close();

} $ap->close();


/// aqui debo actualizar para borrar si es ticket el que lleva el control de panel mostrar (paso a estado 2)
if($_SESSION["config_o_ticket_pantalla"] == 2){
    $cambio = array();
    $cambio["edo"] = 4;
    Helpers::UpdateId("control_cocina", $cambio, "identificador = '".$b["hash"]."' and td = ".$_SESSION["td"]."");
}

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




$printer -> text($this->DosCol($lleva, 11, "MESA: " . $_SESSION['mesa'], 30));

$printer -> text($this->DosCol(date("d-m-Y"), 11, date("H:i:s"), 30));

$printer -> text("Cajero: " . $_SESSION['nombre']);
$printer->feed();



// nombre de mesa
if ($r = $db->select("nombre", "mesa_nombre", "WHERE mesa = ".$_SESSION["mesa"]." and td = ".$_SESSION["td"]." and tx = ".$_SESSION["tx"]."")) { 
    $nombre_mesa = $r["nombre"];
} unset($r);  

if($nombre_mesa != NULL){
$printer -> text("Mesa: " . $nombre_mesa);
}


$printer->feed();
$printer->cut();
$printer->close();

} // cantidad de productos


}












 public function Item($cant,  $name = '', $price = '', $total = '', $dollarSign = false)
    {
        $rightCols = 10;
        $leftCols = 42;
        if ($dollarSign) {
            $leftCols = $leftCols / 2 - $rightCols / 2;
        }
        $left = str_pad($cant . " " . $name, $leftCols) ;
        
        $sign = ($dollarSign ? '$ ' : '');

        $total = str_pad($sign . $total, $rightCols, ' ', STR_PAD_LEFT);
        $right = str_pad($sign . $price, $rightCols, ' ', STR_PAD_LEFT);
        return "$left$right$total\n";
    }



 public function DosCol($izquierda = '', $iz, $derecha = '', $der)
    {
        $left = str_pad($izquierda, $iz, ' ', STR_PAD_LEFT) ;      
        $right = str_pad($derecha, $der, ' ', STR_PAD_LEFT);
        return "$left$right\n";
    }








}// class