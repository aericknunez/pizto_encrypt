 <?php  

class Impresiones{
    public function __construct() { 
     } 


 
 public function Ticket($efectivo, $numero){
  $db = new dbConn();

$img  = "hotpizza.bmp";
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
$print = "TICKET";
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



printer_draw_text($handle, "Residencial Madrid Pol 39, Casa 1", 5, $oi);
$oi=$oi+$n1;
printer_draw_text($handle, "Ciudad Real", 200, $oi);
// $oi=$oi+$n1;
// printer_draw_text($handle, Helpers::Pais($_SESSION['config_pais']), 0, $oi);
// $oi=$oi+$n1;
// printer_draw_text($handle, "Propietario: " . $_SESSION['config_propietario'], 0, $oi);
// $oi=$oi+$n1;
// printer_draw_text($handle, $_SESSION['config_nombre_documento'] . ": " . $_SESSION['config_nit'], 0, $oi);
$oi=$oi+$n1;
printer_draw_text($handle, "Tel: 7659-2747", 0, $oi);

$oi=$oi+$n1;
printer_draw_text($handle, "FACTURA NUMERO: " . $numero, NULL, $oi);

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



$a = $db->query("select cod, cant, producto, pv, total, fecha, hora, num_fac from ticket_temp where num_fac = '".$numero."' $cancelar and tx = ".$_SESSION["tx"]." and td = ".$_SESSION["td"]." group by cod");
  
    foreach ($a as $b) {
 
 $fechaf=$b["fecha"];
 $horaf=$b["hora"];
 $num_fac=$b["num_fac"];


/// para hacer las sumas
if ($s = $db->select("sum(cant), sum(total)", "ticket_temp", "WHERE cod = ".$b["cod"]." and num_fac = '".$numero."'  $cancelar and tx = ".$_SESSION["tx"]." and td = ".$_SESSION["td"]."")) { 
        $scant=$s["sum(cant)"]; $stotal=$s["sum(total)"];
    } unset($s); 
//////
if ($sx = $db->select("sum(total)", "ticket_temp", "WHERE num_fac = '".$numero."'  $cancelar and tx = ".$_SESSION["tx"]." and td = ".$_SESSION["td"]."")) { 
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




    if ($r = $db->select("total", "ticket_propina", "WHERE num_fac = '".$numero."' and tx = ".$_SESSION["tx"]." and td = ".$_SESSION["td"]."")) { 
        $propina = $r["total"];
    } unset($r); 


$oi=$oi+$n1;
printer_draw_text($handle, "Sub Total " . $_SESSION['config_moneda_simbolo'] . ":", 232, $oi);
printer_draw_text($handle, Helpers::Format($subtotalf), $col4, $oi);


if($propina > 0.00){ ///  prara agregarle la propina -- sino borrar
$oi=$oi+$n2;
printer_draw_text($handle, "Propina " . $_SESSION['config_moneda_simbolo'] . ":", 232, $oi);
printer_draw_text($handle, Helpers::Format($propina),$col4, $oi);
}

$xtotal = $subtotalf + $propina;
$oi=$oi+$n1;
printer_draw_text($handle, "Total " . $_SESSION['config_moneda_simbolo'] . ":", 232, $oi);
printer_draw_text($handle, Helpers::Format($xtotal), $col4, $oi);



$oi=$oi+$n2;
printer_draw_text($handle, "____________________________________", 0, $oi);

//efectivo
if($efectivo == NULL){
  $efectivo = $xtotal;
}
$oi=$oi+$n1;
printer_draw_text($handle, "Efectivo " . $_SESSION['config_moneda_simbolo'] . ":", 160, $oi);
printer_draw_text($handle, Helpers::Format($efectivo), $col4, $oi);

//cambio
$cambios = $efectivo - $xtotal;
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

$oi=$oi+$n1+$n2;
printer_draw_text($handle, ".", 0, $oi);


// printer_write($handle, chr(29) . "V" . 0); //cortar papel

printer_write($handle, chr(27).chr(112).chr(48).chr(55).chr(121)); //enviar pulso

///
printer_end_page($handle);
printer_end_doc($handle);
printer_close($handle);



}








 public function Factura($efectivo, $numero){
  $db = new dbConn();

}   /// termina FACTURA





 public function CreditoFiscal($data){
  $db = new dbConn();

}










 public function ImprimirAntes($efectivo, $numero, $cancelar){
  $db = new dbConn();


$img  = "hotpizza.bmp";
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
$print = "TICKET";
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


printer_draw_text($handle, "Residencial Madrid Pol 39, Casa 1", 5, $oi);
$oi=$oi+$n1;
printer_draw_text($handle, "Ciudad Real", 200, $oi);
// $oi=$oi+$n1;
// printer_draw_text($handle, Helpers::Pais($_SESSION['config_pais']), 0, $oi);
// $oi=$oi+$n1;
// printer_draw_text($handle, "Propietario: " . $_SESSION['config_propietario'], 0, $oi);
// $oi=$oi+$n1;
// printer_draw_text($handle, $_SESSION['config_nombre_documento'] . ": " . $_SESSION['config_nit'], 0, $oi);
$oi=$oi+$n1;
printer_draw_text($handle, "Tel: 7659-2747", 0, $oi);

$oi=$oi+$n1;
printer_draw_text($handle, "ORDEN NUMERO: ". $numero, NULL, $oi);

$oi=$oi+$n1;
printer_draw_text($handle, "PRE CUENTA", NULL, $oi);



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
$oi=$oi+$n2;
printer_draw_text($handle, "Propina:", 232, $oi);
printer_draw_text($handle, Helpers::Format(Helpers::Propina($subtotalf)),$col4, $oi);
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
$oi=$oi+$n1;
printer_draw_text($handle, "Cliente: " . $cnombre, 10, $oi);
}
if($cdireccion != NULL){
$oi=$oi+$n1;
printer_draw_text($handle, $cdireccion, 10, $oi);
}
if($ctelefono != NULL){
$oi=$oi+$n1;
printer_draw_text($handle, "Telefono: " . $ctelefono, 10, $oi);
}

// datos del cliente delivery


$oi=$oi+$n1+$n4;
printer_draw_text($handle, "GRACIAS POR SU COMPRA...", 50, $oi);

$oi=$oi+$n1+$n2;
printer_draw_text($handle, ".", 0, $oi);

$oi=$oi+$n1+$n2;
printer_draw_text($handle, ".", 0, $oi);


// printer_write($handle, chr(27).chr(112).chr(48).chr(55).chr(121)); //enviar pulso

printer_delete_font($font);

///
printer_end_page($handle);
printer_end_doc($handle);
printer_close($handle);


} /// TERMINA IMPRIMIR ANTES







 public function Comanda(){

// registro el envio  
  $db = new dbConn();
$cambio = array();
$cambio["edo"] = 0;  
Helpers::UpdateId("mesa_comanda_edo", $cambio, "mesa = ".$_SESSION["mesa"]." and tx = ".$_SESSION["tx"]." and td = ".$_SESSION["td"]."");


  $this->ComandaCocina();
  $this->ComandaCocinaCopia();

 }




 public function ComandaCocina(){
  $db = new dbConn();

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
$print = "TICKET";
// 



$a = $db->query("select ticket_temp.cod as cod, ticket_temp.hash as hash, ticket_temp.cant as cant, ticket_temp.producto as producto, control_cocina.cod as codigo 
  FROM ticket_temp, control_panel_mostrar, control_cocina 
  WHERE ticket_temp.mesa = '".$_SESSION["mesa"]."' and ticket_temp.tx = ".$_SESSION["tx"]." and ticket_temp.td = ".$_SESSION["td"]." and control_panel_mostrar.producto = ticket_temp.cod and control_panel_mostrar.panel = 1 AND control_cocina.identificador = ticket_temp.hash and control_cocina.edo = 1 and control_cocina.cod = ticket_temp.cant");

 $cantidadproductos = $a->num_rows;

 if($cantidadproductos > 0){

$handle = printer_open($print);
printer_set_option($handle, PRINTER_MODE, "RAW");

printer_start_doc($handle, "Mi Documento");
printer_start_page($handle);


$font = printer_create_font("Arial", $txt1, $txt2, PRINTER_FW_NORMAL, false, false, false, 0);
printer_select_font($handle, $font);


$oi="60";
printer_draw_text($handle, "COMANDA DE COCINA", 100, $oi);



    foreach ($a as $b) {
//////
// obtener cantidad (la cantidad se cuentan cuantos hay activos en controlcocina)
$cont = $db->query("SELECT * FROM control_cocina WHERE edo = 1 and identificador = '".$b["hash"]."' and mesa = ".$_SESSION["mesa"]." and td = ".$_SESSION["td"]."");
$canti_p = $cont->num_rows;
$cont->close();
///
 

      $oi=$oi+$n1;
        printer_draw_text($handle, $canti_p, 0, $oi);
        printer_draw_text($handle, $b["producto"], 40, $oi);

    $ar = $db->query("SELECT opcion FROM opciones_ticket WHERE identificador = '".$b["hash"]."' and mesa = ".$_SESSION["mesa"]." and td = ".$_SESSION["td"]." and cod = '".$b["codigo"]."'");
    foreach ($ar as $br) {

if ($r = $db->select("nombre", "opciones_name", "WHERE cod = '".$br["opcion"]."' and td = ".$_SESSION["td"]."")) { 
      $oi=$oi+$n1;
      printer_draw_text($handle, "* " . $r["nombre"], 50, $oi);  
} unset($r); 

    } $ar->close();

/// aqui debo actualizar para borrar si es ticket el que lleva el control de panel mostrar (paso a estado 2)
// if($_SESSION["config_o_ticket_pantalla"] == 2){
//     $cambio = array();
//     $cambio["edo"] = 2;
//     Helpers::UpdateId("control_cocina", $cambio, "identificador = '".$b["hash"]."' and td = ".$_SESSION["td"]."");
// }

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
printer_draw_text($handle, "ORDEN: " . $_SESSION['mesa'], 300, $oi);



$font = printer_create_font("Arial", $txt3, $txt4, PRINTER_FW_NORMAL, false, false, false, 0);
printer_select_font($handle, $font);

$oi=$oi+$n2;
printer_draw_text($handle, date("d-m-Y"), 0, $oi);
printer_draw_text($handle, date("H:i:s"), 350, $oi);


$oi=$oi+$n1;
printer_draw_text($handle, "Cajero: " . $_SESSION['nombre'], 25, $oi);


// nombre de mesa
if ($r = $db->select("nombre", "mesa_nombre", "WHERE mesa = ".$_SESSION["mesa"]." and td = ".$_SESSION["td"]." and tx = ".$_SESSION["tx"]."")) { 
    $nombre_mesa = $r["nombre"];
} unset($r);  

if($nombre_mesa != NULL){
$oi=$oi+$n1;
printer_draw_text($handle, "Mesa: " . $nombre_mesa, 25, $oi);
}



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
$oi=$oi+$n1;
printer_draw_text($handle, "Cliente: " . $cnombre, 10, $oi);
}
if($cdireccion != NULL){
$oi=$oi+$n1;
printer_draw_text($handle, $cdireccion, 10, $oi);
}
if($ctelefono != NULL){
$oi=$oi+$n1;
printer_draw_text($handle, "Telefono: " . $ctelefono, 10, $oi);
}

// datos del cliente delivery

$oi=$oi+$n1;
printer_draw_text($handle, ".", 25, $oi);

// printer_write($handle, chr(27).chr(112).chr(48).chr(55).chr(121)); //enviar pulso


printer_end_page($handle);
printer_end_doc($handle);
printer_close($handle);

} // cantidad de productos


}






 public function ComandaCocinaCopia(){
  $db = new dbConn();

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
$print = "COCINA";
// 



$a = $db->query("select ticket_temp.cod as cod, ticket_temp.hash as hash, ticket_temp.cant as cant, ticket_temp.producto as producto, control_cocina.cod as codigo 
  FROM ticket_temp, control_panel_mostrar, control_cocina 
  WHERE ticket_temp.mesa = '".$_SESSION["mesa"]."' and ticket_temp.tx = ".$_SESSION["tx"]." and ticket_temp.td = ".$_SESSION["td"]." and control_panel_mostrar.producto = ticket_temp.cod and control_panel_mostrar.panel = 1 AND control_cocina.identificador = ticket_temp.hash and control_cocina.edo = 1 and control_cocina.cod = ticket_temp.cant");

 $cantidadproductos = $a->num_rows;

 if($cantidadproductos > 0){

$handle = printer_open($print);
printer_set_option($handle, PRINTER_MODE, "RAW");

printer_start_doc($handle, "Mi Documento");
printer_start_page($handle);


$font = printer_create_font("Arial", $txt1, $txt2, PRINTER_FW_NORMAL, false, false, false, 0);
printer_select_font($handle, $font);


$oi="60";
printer_draw_text($handle, "COMANDA DE COCINA", 100, $oi);



    foreach ($a as $b) {
//////
// obtener cantidad (la cantidad se cuentan cuantos hay activos en controlcocina)
$cont = $db->query("SELECT * FROM control_cocina WHERE edo = 1 and identificador = '".$b["hash"]."' and mesa = ".$_SESSION["mesa"]." and td = ".$_SESSION["td"]."");
$canti_p = $cont->num_rows;
$cont->close();
///
 

      $oi=$oi+$n1;
        printer_draw_text($handle, $canti_p, 0, $oi);
        printer_draw_text($handle, $b["producto"], 40, $oi);

    $ar = $db->query("SELECT opcion FROM opciones_ticket WHERE identificador = '".$b["hash"]."' and mesa = ".$_SESSION["mesa"]." and td = ".$_SESSION["td"]." and cod = '".$b["codigo"]."'");
    foreach ($ar as $br) {

if ($r = $db->select("nombre", "opciones_name", "WHERE cod = '".$br["opcion"]."' and td = ".$_SESSION["td"]."")) { 
      $oi=$oi+$n1;
      printer_draw_text($handle, "* " . $r["nombre"], 50, $oi);  
} unset($r); 

    } $ar->close();

/// aqui debo actualizar para borrar si es ticket el que lleva el control de panel mostrar (paso a estado 2)
if($_SESSION["config_o_ticket_pantalla"] == 2){
    $cambio = array();
    $cambio["edo"] = 2;
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



$oi=$oi+$n2;
printer_draw_text($handle, $lleva, 25, $oi);
printer_draw_text($handle, "ORDEN: " . $_SESSION['mesa'], 300, $oi);



$font = printer_create_font("Arial", $txt3, $txt4, PRINTER_FW_NORMAL, false, false, false, 0);
printer_select_font($handle, $font);

$oi=$oi+$n2;
printer_draw_text($handle, date("d-m-Y"), 0, $oi);
printer_draw_text($handle, date("H:i:s"), 350, $oi);


$oi=$oi+$n1;
printer_draw_text($handle, "Cajero: " . $_SESSION['nombre'], 25, $oi);


// nombre de mesa
if ($r = $db->select("nombre", "mesa_nombre", "WHERE mesa = ".$_SESSION["mesa"]." and td = ".$_SESSION["td"]." and tx = ".$_SESSION["tx"]."")) { 
    $nombre_mesa = $r["nombre"];
} unset($r);  

if($nombre_mesa != NULL){
$oi=$oi+$n1;
printer_draw_text($handle, "Mesa: " . $nombre_mesa, 25, $oi);
}

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
$oi=$oi+$n1;
printer_draw_text($handle, "Cliente: " . $cnombre, 10, $oi);
}
if($cdireccion != NULL){
$oi=$oi+$n1;
printer_draw_text($handle, $cdireccion, 10, $oi);
}
if($ctelefono != NULL){
$oi=$oi+$n1;
printer_draw_text($handle, "Telefono: " . $ctelefono, 10, $oi);
}

// datos del cliente delivery

$oi=$oi+$n1;
printer_draw_text($handle, ".", 25, $oi);

// printer_write($handle, chr(27).chr(112).chr(48).chr(55).chr(121)); //enviar pulso


printer_end_page($handle);
printer_end_doc($handle);
printer_close($handle);

} // cantidad de productos


}











 public function ReporteDiario($fecha){
  $db = new dbConn();



}   // termina reporte diario








 public function AbrirCaja(){
 // $print
$print = "TICKET";
  
    $handle = printer_open($print);
    printer_set_option($handle, PRINTER_MODE, "RAW");

    printer_start_doc($handle, "Mi Documento");
    printer_start_page($handle);
    printer_write($handle, chr(27).chr(112).chr(48).chr(55).chr(121)); //enviar pulso
    printer_end_page($handle);
    printer_end_doc($handle, 20);
    printer_close($handle);
}









 public function ReporteCorte(){ // imprime el resumen del ultimo corte
  $db = new dbConn();

$txt1   = "31"; 
$txt2   = "11";
$txt3   = "0";
$txt4   = "0";
$n1   = "40";
$n2   = "60";
$n3   = "0";
$n4   = "0";


$col1 = 0;
$col2 = 45;
$col3 = 65;
$col4 = 420;
$col5 = 450;
// $print
$print = "TICKET";



// $txt1   = "17"; 
// $txt2   = "10";
// $txt3   = "15";
// $txt4   = "8";
// $n1   = "18";
// $n2   = "24";
// $n3   = "21";
// $n4   = "10";

// $col1 = 0;
// $col2 = 30;
// $col3 = 50;
// $col4 = 300;
// $col5 = 350;

// // $print
// $print = "EPSON TM-U220 Receipt";


$handle = printer_open($print);
printer_set_option($handle, PRINTER_MODE, "RAW");

printer_start_doc($handle, "Mi Documento");
printer_start_page($handle);

$font = printer_create_font("Arial", $txt1, $txt2, PRINTER_FW_NORMAL, false, false, false, 0);
printer_select_font($handle, $font);


$oi=80;
//// comienza la factura


printer_draw_text($handle, "RESUMEN DE CORTE DE CAJA", 40, $oi);
$oi=$oi+$n1;


////////////// PRODUCTOS VENDIDOS

$oi=$oi+$n2;
printer_draw_text($handle, "____________________________________", 0, $oi);
$oi=$oi+$n1;
printer_draw_text($handle, "#", 10, $oi);
printer_draw_text($handle, "Cant.", 60, $oi);
printer_draw_text($handle, "Descripcion", $col2, $oi);
printer_draw_text($handle, "Total", $col4, $oi);

$oi=$oi+$n1+$n3;
printer_draw_text($handle, "____________________________________", 0, $oi);


///////////////
///
$subtotalf = 0;
///
// OBTENER EL NUMERO INICIAL DE TIME
    if ($r = $db->select("time", "corte_diario", "WHERE edo = 1 and td = ".$_SESSION["td"]." order by time desc limit 1, 1")) { 
        $timeinicial = $r["time"];
    } unset($r);  
////







$a = $db->query("select cod, cant, producto, pv, total, fecha, hora, num_fac from ticket where time BETWEEN '".$timeinicial."' and '".Helpers::TimeId()."' and td = ".$_SESSION["td"]." order by num_fac");
  
    foreach ($a as $b) {
 
$subtotalf = 0;

    $oi=$oi+$n1;
    printer_draw_text($handle, "(". $b["num_fac"] . ")", $col1, $oi);
    printer_draw_text($handle, $b["cant"], $col2, $oi);
    printer_draw_text($handle, $b["producto"], $col3, $oi);
    printer_draw_text($handle, $b["total"], $col4, $oi);
////
$subtotalf = $subtotalf + $stotal;
///

}    $a->close();


$oi=$oi+$n2;
printer_draw_text($handle, "____________________________________", 0, $oi);

  // total de venta
      $axy = $db->query("SELECT SUM(total) FROM ticket WHERE time BETWEEN '".$timeinicial."' and '".Helpers::TimeId()."' and edo = 1 and td = ".$_SESSION["td"]."");
    foreach ($axy as $bxy) {
        $counte=$bxy["SUM(total)"];
    } $axy->close();


$oi=$oi+$n2;
printer_draw_text($handle, "TOTAL DE VENTA: ", 20, $oi);
printer_draw_text($handle, Helpers::Dinero($counte), $col4, $oi);
 



  // total de venta
      $axy = $db->query("SELECT sum(total) FROM ticket_propina WHERE time BETWEEN '".$timeinicial."' and '".Helpers::TimeId()."' and td = ".$_SESSION["td"]."");
    foreach ($axy as $bxy) {
        $propinas=$bxy["sum(total)"];
    } $axy->close();


$oi=$oi+30;
printer_draw_text($handle, "TOTAL DE PROPINA: ", 20, $oi);
printer_draw_text($handle, Helpers::Dinero($propinas), $col4, $oi);

  

$oi=$oi+50;
printer_draw_text($handle, "TOTAL: ", 20, $oi);
printer_draw_text($handle, Helpers::Dinero($counte + $propinas), $col4, $oi);

  

$oi=$oi+$n2;
printer_draw_text($handle, "____________________________________", 0, $oi);



// Eliminadas
  $axy = $db->query("SELECT count(num_fac) FROM ticket_num WHERE time BETWEEN '".$timeinicial."' and '".Helpers::TimeId()."' and tx = 1 and edo = 2 and td = ".$_SESSION["td"]."");
foreach ($axy as $bxy) {
    $counte=$bxy["count(num_fac)"];
} $axy->close();


$oi=$oi+50;
printer_draw_text($handle, "TICKET ELIMINADOS: " . $counte, 20, $oi);

$oi=$oi+$n1;
printer_draw_text($handle, "____________________________________", 0, $oi);






// gastos
  $axy = $db->query("SELECT sum(cantidad) FROM gastos WHERE time BETWEEN '".$timeinicial."' and '".Helpers::TimeId()."' and edo = 1 and td = ".$_SESSION["td"]."");
foreach ($axy as $bxy) {
    $gasto=$bxy["sum(cantidad)"];
} $axy->close();


$oi=$oi+50;
printer_draw_text($handle, "GASTOS REGISTRADOS: ", 20, $oi);
printer_draw_text($handle, Helpers::Dinero($gasto), $col4, $oi);


$oi=$oi+$n1;
printer_draw_text($handle, "____________________________________", 0, $oi);



/// APERTURA DE CAJA
    if ($r = $db->select("efectivo", "corte_diario", "WHERE edo = 1 and td = ".$_SESSION["td"]." order by time desc limit 1, 1")) { 
        $apertura = $r["efectivo"];
    } unset($r);  

$oi=$oi+50;
printer_draw_text($handle, "DINERO EN APERTURA: ", 20, $oi);
printer_draw_text($handle, Helpers::Dinero($apertura), $col4, $oi);


$oi=$oi+$n1;
printer_draw_text($handle, "____________________________________", 0, $oi);

$oi=$oi+$n1;
printer_draw_text($handle, "____________________________________", 0, $oi);





$oi=$oi+50;
printer_draw_text($handle, "ORDENES ELIMINADAS: ", 20, $oi);

$oi=$oi+$n1;
printer_draw_text($handle, "#", 10, $oi);
printer_draw_text($handle, "Cant.", 60, $oi);
printer_draw_text($handle, "Descripcion", $col2, $oi);
printer_draw_text($handle, "Total", $col4, $oi);

$oi=$oi+$n1;
printer_draw_text($handle, "____________________________________", 0, $oi);

$a = $db->query("select mesa, cod, cant, producto, pv, total, fecha, hora, num_fac from ticket_borrado where time BETWEEN '".$timeinicial."' and '".Helpers::TimeId()."' and td = ".$_SESSION["td"]." order by num_fac");
  
    foreach ($a as $b) {
 
$subtotalf = 0;

    $oi=$oi+$n1;
    printer_draw_text($handle, "(" . $b["mesa"] . ")", $col1, $oi);
    printer_draw_text($handle, $b["cant"], $col2, $oi);
    printer_draw_text($handle, $b["producto"], $col3, $oi);
    printer_draw_text($handle, $b["total"], $col4, $oi);
////
$subtotalf = $subtotalf + $stotal;
///

}    $a->close();

printer_draw_text($handle, "____________________________________", 0, $oi);










    printer_end_page($handle);
    printer_end_doc($handle, 20);
    printer_close($handle);


}












 public function EliminaOrden(){ 
  $this->EliminaOrdenCocina();
 }










 public function EliminaOrdenCocina(){ // imprime el el producto que se borro
  $db = new dbConn();

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

$print = "COCINA";




$a = $db->query("select ticket_borrado.cod as cod, ticket_borrado.hash as hash, ticket_borrado.cant as cant, ticket_borrado.producto as producto, control_cocina.cod as codigo 
  FROM ticket_borrado, control_panel_mostrar, control_cocina 
  WHERE ticket_borrado.mesa = '".$_SESSION["mesa"]."' and ticket_borrado.tx = ".$_SESSION["tx"]." and ticket_borrado.td = ".$_SESSION["td"]." and control_panel_mostrar.producto = ticket_borrado.cod and control_panel_mostrar.panel = 1 AND control_cocina.identificador = ticket_borrado.hash and control_cocina.edo = 3 and control_cocina.cod = ticket_borrado.cant");

 $cantidadproductos = $a->num_rows;

 if($cantidadproductos > 0){

$handle = printer_open($print);
printer_set_option($handle, PRINTER_MODE, "RAW");

printer_start_doc($handle, "Mi Documento");
printer_start_page($handle);


$font = printer_create_font("Arial", $txt1, $txt2, PRINTER_FW_NORMAL, false, false, false, 0);
printer_select_font($handle, $font);


$oi="60";
printer_draw_text($handle, "ORDEN CANCELADA!", 100, $oi);


    if ($r = $db->select("motivo", "mesa_borrado", "WHERE mesa='".$_SESSION["mesa"]."' and tx = ".$_SESSION["tx"]." and td = ".$_SESSION["td"]."")) { 
        $motivo = $r["motivo"];
    } unset($r); 

$oi=$oi+$n2;
printer_draw_text($handle, "MOTIVO: " . $motivo, 5, $oi);
$oi=$oi+$n1;
printer_draw_text($handle, "____________________________________", 0, $oi);

    foreach ($a as $b) {
//////
// obtener cantidad (la cantidad se cuentan cuantos hay activos en controlcocina)
$cont = $db->query("SELECT * FROM control_cocina WHERE edo = 3 and identificador = '".$b["hash"]."' and mesa = ".$_SESSION["mesa"]." and td = ".$_SESSION["td"]."");
$canti_p = $cont->num_rows;
$cont->close();
///
 

      $oi=$oi+$n1;
        printer_draw_text($handle, $canti_p, 0, $oi);
        printer_draw_text($handle, $b["producto"], 40, $oi);

    $ar = $db->query("SELECT opcion FROM opciones_ticket WHERE identificador = '".$b["hash"]."' and mesa = ".$_SESSION["mesa"]." and td = ".$_SESSION["td"]." and cod = '".$b["codigo"]."'");
    foreach ($ar as $br) {

if ($r = $db->select("nombre", "opciones_name", "WHERE cod = '".$br["opcion"]."' and td = ".$_SESSION["td"]."")) { 
      $oi=$oi+$n1;
      printer_draw_text($handle, "* " . $r["nombre"], 50, $oi);  
} unset($r); 

    } $ar->close();

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



$oi=$oi+$n2;
printer_draw_text($handle, $lleva, 25, $oi);
printer_draw_text($handle, "MESA: " . $_SESSION['mesa'], 300, $oi);



$font = printer_create_font("Arial", $txt3, $txt4, PRINTER_FW_NORMAL, false, false, false, 0);
printer_select_font($handle, $font);

$oi=$oi+$n2;
printer_draw_text($handle, date("d-m-Y"), 0, $oi);
printer_draw_text($handle, date("H:i:s"), 350, $oi);


$oi=$oi+$n1;
printer_draw_text($handle, "Cajero: " . $_SESSION['nombre'], 25, $oi);


// nombre de mesa
if ($r = $db->select("nombre", "mesa_nombre", "WHERE mesa = ".$_SESSION["mesa"]." and td = ".$_SESSION["td"]." and tx = ".$_SESSION["tx"]."")) { 
    $nombre_mesa = $r["nombre"];
} unset($r);  

if($nombre_mesa != NULL){
$oi=$oi+$n1;
printer_draw_text($handle, "Mesa: " . $nombre_mesa, 25, $oi);
}



$oi=$oi+$n1;
printer_draw_text($handle, ".", 25, $oi);

// printer_write($handle, chr(27).chr(112).chr(48).chr(55).chr(121)); //enviar pulso


printer_end_page($handle);
printer_end_doc($handle);
printer_close($handle);

} // cantidad de productos


}















}// class