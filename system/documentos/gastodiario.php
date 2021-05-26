<?php
include_once '../../application/common/Helpers.php'; // [Para todo]
include_once '../../application/includes/variables_db.php';
include_once '../../application/common/Mysqli.php';
include_once '../../application/includes/DataLogin.php';
$db = new dbConn();
$seslog = new Login();
$seslog->sec_session_start();


if($_REQUEST["fecha"] != NULL){
  $fecha = $_REQUEST["fecha"];
} else {
  $fecha = date("d-m-Y");
}



if ($seslog->login_check() == TRUE) {

include_once '../../application/common/Fechas.php';
include_once '../../application/common/Alerts.php';


if($fecha != NULL){


// $objPHPExcel->getColumnDimension('C')->setAutoSize(true);


$a = $db->query("SELECT * FROM gastos WHERE fecha = '$fecha' and td = ". $_SESSION["td"] ." order by id desc");

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
            ->setCellValue('A1', 'TIPO')
            ->setCellValue('B1', 'GASTO')
            ->setCellValue('C1', 'DESCRIPCION')
            ->setCellValue('D1', 'CANTIDAD');
 


$fila = 1;   
   foreach ($a as $b) {

$fila = $fila + 1; 
$objPHPExcel->setActiveSheetIndex(0)
          ->setCellValue('A' . $fila, Gasto($b["tipo"]))
          ->setCellValue('B' . $fila, $b["nombre"])
          ->setCellValue('C' . $fila, $b["descripcion"])
          ->setCellValue('D' . $fila, $b["cantidad"]);
 

        } 




$columnas = array('A','B','C','D');
$numeros = array('D');

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


// // formula de sumatoria
$filax = $fila + 1;
$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('C'. $filax, "TOTAL: ");
$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('D'. $filax, "=SUM(D2:D".$fila.")");

$objPHPExcel->getActiveSheet()->getStyle('D'. $filax)
    ->getNumberFormat()
    ->setFormatCode(
        '$0.00'
    );




// Rename worksheet
$objPHPExcel->getActiveSheet()->setTitle('Gasto Diario');


// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$objPHPExcel->setActiveSheetIndex(0);


$objPHPExcel->getActiveSheet()->getStyle("A1:D1")->getFont()->setBold(true);
// Redirect output to a client’s web browser (Excel2007)
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="GastosDiarios-'.$fecha.'.xlsx"');
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

    function Gasto($string) {
    if($string == "1") return 'Compra No Facturado';
    if($string == "2") return 'Compra con Factura';
    if($string == "3") return 'Remesas';
    if($string == "4") return 'Adelanto a personal';
    if($string == "5") return 'Cheques';
    }

    
$db->close();
?>