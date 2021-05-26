 <?php  

class Impresiones{
		public function __construct() { 
     } 


 public function Ticket($efectivo, $numero){
  $db = new dbConn();


$txt1   = "17"; 
$txt2   = "10";
$txt3   = "15";
$txt4   = "8";
$n1   = "18";
$n2   = "24";
$n3   = "21";
$n4   = "10";

// $print
$print = "EPSON TM-U220 Receipt";


$col1 = 0;
$col2 = 30;
$col3 = 250;
$col4 = 330;
$col5 = 330;




$handle = printer_open($print);
printer_set_option($handle, PRINTER_MODE, "RAW");

printer_start_doc($handle, "Mi Documento");
printer_start_page($handle);


$font = printer_create_font("Arial", $txt1, $txt2, PRINTER_FW_NORMAL, false, false, false, 0);
printer_select_font($handle, $font);


//// comienza la factura
printer_draw_text($handle, "RESTAURANTE Y HOSTAL", 50, $oi);
$oi=$oi+$n1;
printer_draw_text($handle, "BUENOS AIRES", 98, $oi);

$oi=$oi+$n1;
printer_draw_text($handle, "El Paraiso Ataco", 100, $oi);
$oi=$oi+$n1;
printer_draw_text($handle, "2a Av. Norte, Finca Buenos Aires", 0, $oi);

$oi=$oi+$n1;
printer_draw_text($handle, "Tel: 2450-5034", 0, $oi);


//$numero1=str_pad($numero, 8, "0", STR_PAD_LEFT);
//$numero1="000-001-01-$numero1";
//
$oi=$oi+$n1;
printer_draw_text($handle, "CONTRIBUYENTE: ", 0, $oi);

$oi=$oi+$n1;
printer_draw_text($handle, "SAIDA MARIA PUENTES DE RIVAS", 10, $oi);


$oi=$oi+$n1;
printer_draw_text($handle, "NIT: 0110-240581-101-5", 0, $oi);

$oi=$oi+$n1;
printer_draw_text($handle, "NRC: 240124-4", 0, $oi);

$oi=$oi+$n1;
printer_draw_text($handle, "GIRO:Restaurantes y Actividades ", 0, $oi);


$oi=$oi+$n1;
printer_draw_text($handle, "De alojamiento Para Estancias cortas", 0, $oi);


$oi=$oi+$n1;
printer_draw_text($handle, "TICKET NUMERO: $numero", 0, $oi);

$oi=$oi+$n1+5;
printer_draw_text($handle, "Autorizacion: ASC-15041-036616-2021", 0, $oi);

$oi=$oi+$n1;
printer_draw_text($handle, "Del: 21NA0010000111", 0, $oi);
$oi=$oi+$n1;
printer_draw_text($handle, "Al: 21NA00100001115000", 0, $oi);


$oi=$oi+$n1;
printer_draw_text($handle, "Fecha de autorizacion: 08-01-2021", 0, $oi);

$oi=$oi+$n1;
printer_draw_text($handle, "CAJA: 1", 0, $oi);

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
 

          $oi=$oi+$n1;
          printer_draw_text($handle, $scant, $col1, $oi);
          printer_draw_text($handle, $b["producto"], $col2, $oi);
          printer_draw_text($handle, $b["pv"], $col3, $oi);
          printer_draw_text($handle, $stotal, $col4, $oi);


////
$subtotalf = $subtotalf + $stotal;
///

    }    $a->close();



$oi=$oi+$n3+$n1;
printer_draw_text($handle, "Sub Total " . $_SESSION['config_moneda_simbolo'] . ":", 185, $oi);
printer_draw_text($handle, Helpers::Format(Helpers::STotal($subtotalf, $_SESSION['config_imp'])), 320, $oi);


$oi=$oi+$n1;
printer_draw_text($handle, "IVA. " . $_SESSION['config_moneda_simbolo'] . ":", 175, $oi);
printer_draw_text($handle, Helpers::Format(Helpers::Impuesto(Helpers::STotal($subtotalf, $_SESSION['config_imp']), $_SESSION['config_imp'])), 320, $oi);



    if ($r = $db->select("total", "ticket_propina", "WHERE num_fac = '".$numero."' and tx = ".$_SESSION["tx"]." and td = ".$_SESSION["td"]."")) { 
        $propina = $r["total"];
    } unset($r); 


if($propina > 0.00){ ///  prara agregarle la propina -- sino borrar
$oi=$oi+$n2;
printer_draw_text($handle, "Propina: ", 160, $oi);
printer_draw_text($handle, Helpers::Format(Helpers::Propina($subtotalf)),$col4, $oi);
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
printer_draw_text($handle, "G=Articulo Gravado", 0, $oi);



$oi=$oi+$n1;
printer_draw_text($handle, $fechaf, 0, $oi);
printer_draw_text($handle, $horaf, 232, $oi);




///// crea de nuevo fuente
$font = printer_create_font("Arial", $txt1, $txt2, PRINTER_FW_NORMAL, false, false, false, 0);
printer_select_font($handle, $font);
//////////////////

$oi=$oi+$n1;
printer_draw_text($handle, "SERIE: MJ04HH0", 0, $oi);


$oi=$oi+$n1;
printer_draw_text($handle, "Cajero: " . $_SESSION['nombre'], 25, $oi);




if ($sx = $db->select("cajero", "ticket", "WHERE num_fac = '".$numero."'  $cancelar and tx = ".$_SESSION["tx"]." and td = ".$_SESSION["td"]."")) { 
     $mesero=$sx["cajero"];
} unset($sx); 
 

$oi=$oi+$n1;
printer_draw_text($handle, "Mesero: " . $mesero, 25, $oi);



$oi=$oi+$n1+$n4;
printer_draw_text($handle, "Nuestros precios incluyen IVA", 50, $oi);

$oi=$oi+$n1+$n4;
printer_draw_text($handle, "GRACIAS POR SU COMPRA...", 50, $oi);

$oi=$oi+$n1+$n2;
printer_draw_text($handle, ".", NULL, $oi);
printer_write($handle, chr(27).chr(112).chr(48).chr(55).chr(121)); //enviar pulso
printer_delete_font($font);



///
printer_end_page($handle);
printer_end_doc($handle);
printer_close($handle);



}



 public function Factura($efectivo, $numero){

  // $this->Ticket($efectivo, $numero);
  $this->Facturax($efectivo, $numero);


 }

 public function Facturax($efectivo, $numero){
  $db = new dbConn();



$txt1   = "17"; 
$txt2   = "10";
$txt3   = "15";
$txt4   = "8";
$n1   = "18";
$n2   = "24";
$n3   = "21";
$n4   = "10";

// $print
$print = "EPSON TM-U220 Receipt";


$col1 = 0;
$col2 = 30;
$col3 = 250;
$col4 = 330;
$col5 = 330;




$handle = printer_open($print);
printer_set_option($handle, PRINTER_MODE, "RAW");

printer_start_doc($handle, "Mi Documento");
printer_start_page($handle);


$font = printer_create_font("Arial", $txt1, $txt2, PRINTER_FW_NORMAL, false, false, false, 0);
printer_select_font($handle, $font);


//// comienza la factura
printer_draw_text($handle, "RESTAURANTE Y HOSTAL", 50, $oi);
$oi=$oi+$n1;
printer_draw_text($handle, "BUENOS AIRES", 98, $oi);

$oi=$oi+$n1;
printer_draw_text($handle, "El Paraiso Ataco", 100, $oi);
$oi=$oi+$n1;
printer_draw_text($handle, "2a Av. Norte, Finca Buenos Aires", 0, $oi);

$oi=$oi+$n1;
printer_draw_text($handle, "Tel: 2450-5034", 0, $oi);


//$numero1=str_pad($numero, 8, "0", STR_PAD_LEFT);
//$numero1="000-001-01-$numero1";
$oi=$oi+$n1;
printer_draw_text($handle, "CONTRIBUYENTE: ", 0, $oi);

$oi=$oi+$n1;
printer_draw_text($handle, "SAIDA MARIA PUENTES DE RIVAS", 10, $oi);


$oi=$oi+$n1;
printer_draw_text($handle, "NIT: 0110-240581-101-5", 0, $oi);

$oi=$oi+$n1;
printer_draw_text($handle, "NRC: 240124-4", 0, $oi);

$oi=$oi+$n1;
printer_draw_text($handle, "GIRO:Restaurantes y Actividades ", 0, $oi);


$oi=$oi+$n1;
printer_draw_text($handle, "De alojamiento Para Estancias cortas", 0, $oi);


$oi=$oi+$n1;
printer_draw_text($handle, "TICKET NUMERO: $numero", 0, $oi);

$oi=$oi+$n1+5;
printer_draw_text($handle, "Autorizacion: ASC-15041-036616-2021", 0, $oi);

$oi=$oi+$n1;
printer_draw_text($handle, "Del: 21NA0010000111", 0, $oi);
$oi=$oi+$n1;
printer_draw_text($handle, "Al: 21NA00100001115000", 0, $oi);


$oi=$oi+$n1;
printer_draw_text($handle, "Fecha de autorizacion: 08-01-2021", 0, $oi);

$oi=$oi+$n1;
printer_draw_text($handle, "CAJA: 1", 0, $oi);

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
 

          $oi=$oi+$n1;
          printer_draw_text($handle, $scant, $col1, $oi);
          printer_draw_text($handle, $b["producto"], $col2, $oi);
          printer_draw_text($handle, $b["pv"], $col3, $oi);
          printer_draw_text($handle, $stotal, $col4, $oi);


////
$subtotalf = $subtotalf + $stotal;
///

    }    $a->close();



$oi=$oi+$n3+$n1;
printer_draw_text($handle, "Sub Total " . $_SESSION['config_moneda_simbolo'] . ":", 185, $oi);
printer_draw_text($handle, Helpers::Format(Helpers::STotal($subtotalf, $_SESSION['config_imp'])), 320, $oi);


$oi=$oi+$n1;
printer_draw_text($handle, "IVA. " . $_SESSION['config_moneda_simbolo'] . ":", 175, $oi);
printer_draw_text($handle, Helpers::Format(Helpers::Impuesto(Helpers::STotal($subtotalf, $_SESSION['config_imp']), $_SESSION['config_imp'])), 320, $oi);


    if ($r = $db->select("total", "ticket_propina", "WHERE num_fac = '".$numero."' and tx = ".$_SESSION["tx"]." and td = ".$_SESSION["td"]."")) { 
        $propina = $r["total"];
    } unset($r); 


if($propina > 0.00){ ///  prara agregarle la propina -- sino borrar
$oi=$oi+$n2;
printer_draw_text($handle, "Propina: ", 160, $oi);
printer_draw_text($handle, Helpers::Format(Helpers::Propina($subtotalf)),$col4, $oi);
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
printer_draw_text($handle, "G=Articulo Gravado", 0, $oi);



$oi=$oi+$n1;
printer_draw_text($handle, $fechaf, 0, $oi);
printer_draw_text($handle, $horaf, 232, $oi);




///// crea de nuevo fuente
$font = printer_create_font("Arial", $txt1, $txt2, PRINTER_FW_NORMAL, false, false, false, 0);
printer_select_font($handle, $font);
//////////////////

$oi=$oi+$n1;
printer_draw_text($handle, "SERIE: MJ04HH0", 0, $oi);


$oi=$oi+$n1;
printer_draw_text($handle, "Cajero: " . $_SESSION['nombre'], 25, $oi);




if ($sx = $db->select("cajero", "ticket", "WHERE num_fac = '".$numero."'  $cancelar and tx = ".$_SESSION["tx"]." and td = ".$_SESSION["td"]."")) { 
     $mesero=$sx["cajero"];
} unset($sx); 
 

$oi=$oi+$n1;
printer_draw_text($handle, "Mesero: " . $mesero, 25, $oi);



$oi=$oi+$n1+$n4;
printer_draw_text($handle, "Nuestros precios incluyen IVA", 50, $oi);

$oi=$oi+$n1+$n4;
printer_draw_text($handle, "GRACIAS POR SU COMPRA...", 50, $oi);

$oi=$oi+$n1+$n2;
printer_draw_text($handle, ".", NULL, $oi);
printer_write($handle, chr(27).chr(112).chr(48).chr(55).chr(121)); //enviar pulso
printer_delete_font($font);



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

$txt1   = "17"; 
$txt2   = "10";
$txt3   = "15";
$txt4   = "8";
$n1   = "18";
$n2   = "24";
$n3   = "21";
$n4   = "10";

// $print
$print = "EPSON TM-U220 Receipt";


$col1 = 0;
$col2 = 30;
$col3 = 250;
$col4 = 330;
$col5 = 330;


$logo_imagen="C:/AppServ/www/pizto/assets/img/logo_factura/". $img;



$handle = printer_open($print);
printer_set_option($handle, PRINTER_MODE, "RAW");

printer_start_doc($handle, "Mi Documento");
printer_start_page($handle);

$font = printer_create_font("Arial", $txt1, $txt2, PRINTER_FW_NORMAL, false, false, false, 0);
printer_select_font($handle, $font);



//// comienza la factura
printer_draw_text($handle, "RESTAURANTE Y HOSTAL", 50, $oi);
$oi=$oi+$n1;
printer_draw_text($handle, "BUENOS AIRES", 98, $oi);

$oi=$oi+$n1;
printer_draw_text($handle, "El Paraiso Ataco", 100, $oi);
$oi=$oi+$n1;
printer_draw_text($handle, "2a Av. Norte, Finca Buenos Aires", 0, $oi);

$oi=$oi+$n1;
printer_draw_text($handle, "Tel: 2450-5034", 0, $oi);
$oi=$oi+$n1;

//$numero1=str_pad($numero, 8, "0", STR_PAD_LEFT);
//$numero1="000-001-01-$numero1";
printer_draw_text($handle, "Factura Numero: $numero", 0, $oi);



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
printer_draw_text($handle, "Propina: ", 160, $oi);
printer_draw_text($handle, Helpers::Format(Helpers::Propina($subtotalf)),$col4, $oi);
$subtotalf = Helpers::PropinaTotal($subtotalf);
}

$oi=$oi+$n1;
printer_draw_text($handle, "Total " . $_SESSION['config_moneda_simbolo'] . ":", 160, $oi);
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
printer_draw_text($handle, $fechaf, 50, $oi);
printer_draw_text($handle, $horaf, 200, $oi);


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


// nombre de mesa
if ($r = $db->select("nombre", "mesa_nombre", "WHERE mesa = ".$_SESSION["mesa"]." and td = ".$_SESSION["td"]." and tx = ".$_SESSION["tx"]."")) { 
    $nombre_mesa = $r["nombre"];
} unset($r);  

if($nombre_mesa != NULL){
$oi=$oi+$n1;
printer_draw_text($handle, "Mesa: " . $nombre_mesa, 10, $oi);
}


$oi=$oi+$n1+$n4;
printer_draw_text($handle, "Nuestros precios incluyen IVA", 50, $oi);

$oi=$oi+$n1+$n4;
printer_draw_text($handle, "GRACIAS POR SU COMPRA...", 50, $oi);

$oi=$oi+$n1+$n2;
printer_draw_text($handle, ".", NULL, $oi);


// printer_write($handle, chr(27).chr(112).chr(48).chr(55).chr(121)); //enviar pulso
printer_delete_font($font);

///
printer_end_page($handle);
printer_end_doc($handle);
printer_close($handle);


} /// TERMINA IMPRIMIR ANTES










 public function Comanda($data){
  $db = new dbConn();

}












 public function ReporteDiario($fecha){
  $db = new dbConn();


}   // termina reporte diario








 public function AbrirCaja(){
 // $print
	$print = "EPSON TM-T20II Receipt5";
	
    $handle = printer_open($print);
    printer_set_option($handle, PRINTER_MODE, "RAW");

    printer_start_doc($handle, "Mi Documento");
    printer_start_page($handle);
    printer_write($handle, chr(27).chr(112).chr(48).chr(55).chr(121)); //enviar pulso
    printer_end_page($handle);
    printer_end_doc($handle, 20);
    printer_close($handle);
}












 public function ReporteCorte($timeinicial = NULL, $timefinal = NULL){ // imprime el resumen del ultimo corte
  $db = new dbConn();

$txt1   = "17"; 
$txt2   = "10";
$txt3   = "15";
$txt4   = "8";
$n1   = "18";
$n2   = "24";
$n3   = "21";
$n4   = "10";

// $print
$print = "EPSON TM-U220 Receipt";


$col1 = 0;
$col2 = 30;
$col3 = 250;
$col4 = 320;
$col5 = 330;



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


if($timeinicial == NULL and $timefinal == NULL){

// OBTENER EL NUMERO INICIAL DE TIME
    if ($r = $db->select("time", "corte_diario", "WHERE edo = 1 and td = ".$_SESSION["td"]." order by time desc limit 1, 1")) { 
        $timeinicial = $r["time"];
        $timefinal = Helpers::TimeId();
    } unset($r);  
////

}





$oi=$oi+$n2;
printer_draw_text($handle, "____________________________________", 0, $oi);

  // total de venta
      $axy = $db->query("SELECT SUM(total) FROM ticket WHERE time BETWEEN '".$timeinicial."' and '".$timefinal."' and edo = 1 and td = ".$_SESSION["td"]."");
    foreach ($axy as $bxy) {
        $counte=$bxy["SUM(total)"];
    } $axy->close();


$oi=$oi+$n2;
printer_draw_text($handle, "TOTAL DE VENTA: ", 20, $oi);
printer_draw_text($handle, Helpers::Dinero($counte), $col4, $oi);
 

//// venta con tarjeta
$a = $db->query("SELECT sum(total) FROM ticket WHERE edo = 1 and tipo_pago = 2 and td = ".$_SESSION["td"]." and time BETWEEN '".$timeinicial."' and '".$timefinal."'");
foreach ($a as $b) {
 $ttarjeta=$b["sum(total)"];
} $a->close();

// venta en efectivo
$a = $db->query("SELECT sum(total) FROM ticket WHERE edo = 1 and tipo_pago = 1 and td = ".$_SESSION["td"]." and time BETWEEN '".$timeinicial."' and '".$timefinal."'");
foreach ($a as $b) {
 $tefectivo=$b["sum(total)"];
} $a->close();

$oi=$oi+$n2;
printer_draw_text($handle, "TOTAL EN EFECTIVO: ", 20, $oi);
printer_draw_text($handle, Helpers::Dinero($tefectivo), $col4, $oi);
 


$oi=$oi+$n2;
printer_draw_text($handle, "TOTAL TARJETA: ", 20, $oi);
printer_draw_text($handle, Helpers::Dinero($ttarjeta), $col4, $oi);
 









  // total de venta
      $axy = $db->query("SELECT sum(total) FROM ticket_propina WHERE time BETWEEN '".$timeinicial."' and '".$timefinal."' and td = ".$_SESSION["td"]."");
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
  $axy = $db->query("SELECT count(num_fac) FROM ticket_num WHERE time BETWEEN '".$timeinicial."' and '".$timefinal."' and tx = 1 and edo = 2 and td = ".$_SESSION["td"]."");
foreach ($axy as $bxy) {
    $counte=$bxy["count(num_fac)"];
} $axy->close();


$oi=$oi+50;
printer_draw_text($handle, "TICKET ELIMINADOS: " . $counte, 20, $oi);

$oi=$oi+$n1;
printer_draw_text($handle, "____________________________________", 0, $oi);




// listado de gastos
  $axz = $db->query("SELECT nombre, cantidad FROM gastos WHERE time BETWEEN '".$timeinicial."' and '".$timefinal."' and edo = 1 and td = ".$_SESSION["td"]."");
foreach ($axz as $bxz) {

$oi=$oi+$n1;
printer_draw_text($handle, $bxz["nombre"], 5, $oi);
printer_draw_text($handle, Helpers::Dinero($bxz["cantidad"]), $col4, $oi);

} $axz->close();



// gastos
  $axy = $db->query("SELECT sum(cantidad) FROM gastos WHERE tipo != 3 and tipo != 5 and time BETWEEN '".$timeinicial."' and '".$timefinal."' and edo = 1 and td = ".$_SESSION["td"]."");
foreach ($axy as $bxy) {
    $gasto=$bxy["sum(cantidad)"];
} $axy->close();

// remesas (tipo  3)
  $axy = $db->query("SELECT sum(cantidad) FROM gastos WHERE tipo = 3 and time BETWEEN '".$timeinicial."' and '".$timefinal."' and edo = 1 and td = ".$_SESSION["td"]."");
foreach ($axy as $bxy) {
    $remesas=$bxy["sum(cantidad)"];
} $axy->close();



$oi=$oi+50;
printer_draw_text($handle, "GASTOS REGISTRADOS: ", 20, $oi);
printer_draw_text($handle, Helpers::Dinero($gasto), $col4, $oi);


$oi=$oi+50;
printer_draw_text($handle, "REMESAS: ", 20, $oi);
printer_draw_text($handle, Helpers::Dinero($remesas), $col4, $oi);


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



/// FECHA HORA Y USUARIO
    if ($r = $db->select("fecha, hora, user", "corte_diario", "WHERE edo = 1 and td = ".$_SESSION["td"]." order by time desc limit 1")) { 
        $ifecha = $r["fecha"];
        $ihora = $r["hora"];
        $iuser = $r["user"];
    } unset($r);  

    if ($r = $db->select("nombre", "login_userdata", "WHERE user = '$iuser' and td = ".$_SESSION["td"]."")) { 
        $user = $r["nombre"];
    } unset($r);  


$oi=$oi+$n1;
printer_draw_text($handle, "USUARIO: ", 20, $oi);
printer_draw_text($handle, $user, $col3, $oi);

$oi=$oi+$n1;
printer_draw_text($handle, "FECHA: ", 20, $oi);
printer_draw_text($handle, $ifecha . " : " . $ihora, $col3, $oi);



$oi=$oi+$n1;
printer_draw_text($handle, "____________________________________", 0, $oi);

$oi=$oi+$n1;
printer_draw_text($handle, "____________________________________", 0, $oi);




    printer_end_page($handle);
    printer_end_doc($handle, 20);
    printer_close($handle);


}









}// class