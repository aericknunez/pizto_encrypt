 <?php  

class Impresiones{
		public function __construct() { 
     } 


 public function Ticket($efectivo, $numero){
  $db = new dbConn();

}








 public function Factura($efectivo, $numero){
  $db = new dbConn();


}   /// termina FACTURA





 public function CreditoFiscal($data){
  $db = new dbConn();

}










 public function ImprimirAntes($efectivo, $numero, $cancelar){
  $db = new dbConn();


} /// TERMINA IMPRIMIR ANTES











 public function Comanda(){
  $db = new dbConn();


}












 public function ReporteDiario($fecha){
  $db = new dbConn();

}   // termina reporte diario








 public function AbrirCaja(){
 // $print
	$print = "EPSON TM-T20II Receipt";
	
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