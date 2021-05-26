<?php
include_once '../../application/common/Helpers.php'; // [Para todo]
include_once '../../application/includes/variables_db.php';
include_once '../../application/common/Mysqli.php';
include_once '../../application/includes/DataLogin.php';
$db = new dbConn();
$seslog = new Login();
$seslog->sec_session_start();


if($_REQUEST["fecha"] != NULL){
  $fechax = $_REQUEST["fecha"];
} else {
  $fechax = date("-m-Y");
}



if ($seslog->login_check() == TRUE) {

include_once '../../application/common/Fechas.php';
include_once '../../application/common/Alerts.php';


if($fechax != NULL){


// $objPHPExcel->getColumnDimension('C')->setAutoSize(true);


$a = $db->query("select cod, sum(cant), sum(total), producto, pv, fecha 
                            from ticket 
                            where cod != 8888 and edo = 1 and fecha like '%$fechax' and td = ".$_SESSION['td']." GROUP BY cod order by sum(cant) desc");

    if($a->num_rows > 0){

require_once '../../application/common/PHPExcel.php';

// Create new PHPExcel object
$objPHPExcel = new PHPExcel();

// Set document properties
$objPHPExcel->getProperties()->setCreator("Hibrido")
                      ->setLastModifiedBy("Hibrido")
                      ->setTitle("Office 2007 XLSX Documento de reporte")
                      ->setSubject("Office 2007 XLSX Documento de reporte")
                      ->setDescription("Documento generado por Hibrido y su sistema Pizto.")
                      ->setKeywords("office 2007 openxml")
                      ->setCategory("Archivo de Reporte");



$objPHPExcel->getDefaultStyle()->getFont()->setName('Arial')
                                          ->setSize(12);

// Add encabezado
$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A1', 'CANTIDAD')
            ->setCellValue('B1', 'CODIGO')
            ->setCellValue('C1', 'PRODUCTO')
            ->setCellValue('D1', 'PRECIO DE VENTA')
            ->setCellValue('E1', 'TOTAL');
 


$fila = 1;   
   foreach ($a as $b) {

$fila = $fila + 1; 
$objPHPExcel->setActiveSheetIndex(0)
          ->setCellValue('A' . $fila, $b["sum(cant)"])
          ->setCellValue('B' . $fila, $b["cod"])
          ->setCellValue('C' . $fila, $b["producto"])
          ->setCellValue('D' . $fila, $b["pv"])
          ->setCellValue('E' . $fila, $b["sum(total)"]);
 

        } 




$columnas = array('A','B','C','D','E');
$numeros = array('D','E');

// establece ceros numerocico las filas numerocas
foreach($numeros as $columnID) {
$objPHPExcel->getActiveSheet()->getStyle($columnID . '2:' . $columnID.$fila)
    ->getNumberFormat()
    ->setFormatCode(
        '$0.00'
    );
}

// establece auto dimension a las columnas
foreach($columnas as $columnID) {
    $objPHPExcel->getActiveSheet()->getColumnDimension($columnID)
        ->setAutoSize(true);
}


// estableces como texto
$range = 'B2'.':B'.$fila;
$objPHPExcel->getActiveSheet()
       ->getStyle($range)
       ->getNumberFormat()
       ->setFormatCode( PHPExcel_Style_NumberFormat::FORMAT_TEXT );

// // formula de sumatoria
$filax = $fila + 1;
$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('D'. $filax, "TOTAL: ");
$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('E'. $filax, "=SUM(E2:E".$fila.")");

$objPHPExcel->getActiveSheet()->getStyle('E'. $filax)
    ->getNumberFormat()
    ->setFormatCode(
        '$0.00'
    );




// Rename worksheet
$objPHPExcel->getActiveSheet()->setTitle('Venta Mensual');


// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$objPHPExcel->setActiveSheetIndex(0);


$objPHPExcel->getActiveSheet()->getStyle("A1:E1")->getFont()->setBold(true);
// Redirect output to a client’s web browser (Excel2007)
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="VentasMensual'.$fechax.'.xlsx"');
header('Cache-Control: max-age=0');
// If you're serving to IE 9, then the following may be needed
header('Cache-Control: max-age=1');

// If you're serving to IE over SSL, then the following may be needed
header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
header ('Pragma: public'); // HTTP/1.0

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$objWriter->setPreCalculateFormulas(true);
$objWriter->save('php://output');
exit;





} // si hay registros
   $a->close();         


} // termina fecha


} else {
    
header("location: ../../");
}
/////////
$db->close();
?>