<?php 
class BackUp{

  public function __construct() { 
     } 


public function AddRegistro($sistema){
    $db = new dbConn();
    /// el registro no se realiza en el servidor del sistema sino que en la app
      
      $updata = array(
      'sistema'  =>  $sistema,
      'td'   =>  $_SESSION['td']
        );
    $api_url = "https://hibridosv.com/app/api/addbackup.php";
    $client = curl_init($api_url);
    curl_setopt($client, CURLOPT_POST, true);
    curl_setopt($client, CURLOPT_POSTFIELDS, $updata);
    curl_setopt($client, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($client);
    curl_close($client);
    $result = json_decode($response, true);
    foreach($result as $keys => $values)
    {
      if($result[$keys]['success'] == '1'){
        Alerts::Alerta("success","Creado correctamente","Respaldo creado correctamente");
      }
      else{
        Alerts::Alerta("error","Error!","No se ha podido crear el registro de respaldo");
      }
    }

}


public function Search(){
    $db = new dbConn();

$api_url = "https://hibridosv.com/app/api/addbackup.php?action=search&x=" . $_SESSION["td"] . "&type=1";
$client = curl_init($api_url);
curl_setopt($client, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($client);
curl_close($client);
$result = json_decode($response, true);
    foreach($result as $keys => $values){
        if($result[$keys]['success'] == '1'){
           Alerts::Mensajex("YA TIENES UNA PETICION DE RESPALDO PENDIENTE","danger");
        
        } elseif($result[$keys]['success'] == '2'){
          Alerts::Mensajex("EN ESTE MOMENTO SE ESTA GENERANDO TU RESPALDO","info");

        } else{
         echo '<a id="backup" sistema="1" class="btn btn-success">Crear BackUp</a>';
        }
    }
}


  public function Crear($td){
    $db = new dbConn();

    $dir = $this->Tablas();

foreach ($dir as $key => $tabla) {
  //////////////////////        
    $s = $db->query("SELECT * FROM $tabla WHERE td = '$td'");
    foreach ($s as $y){ 

    $archivo.= "INSERT INTO $tabla VALUES(";
      // especifico los campos
        $fields = $db->listFields($tabla);
        $arrlength = count($fields);
        for($x = 0; $x < $arrlength; $x++) {
            $campo = $fields[$x]['name'];
  

  if($arrlength != $x+1) $archivo.= "\"" .$y["$campo"] . "\",";
  else $archivo.= "\"" . $y["$campo"] . "\"";

        }
    $archivo.= "); \n";

    }
     $s->close();
/////////////////////////////////


} /// termina recorrido de directorios

    if($archivo != NULL){

      // verifico si existe la carpeta. sino la creo
      if(!is_dir("../../system/bdbackup/backup/" .$td . "/")){
        mkdir("../../system/bdbackup/backup/" .$td . "/");

        $gitarch = fopen("../../system/bdbackup/backup/" .$td . "/" . ".gitkeep",'w+');
        fwrite($gitarch,"");
        fclose($gitarch);
      }

      $filename = "Backup-" . date("d-m-Y") . "-" . date("His");
      $ext =  ".piz";

      $handle = fopen("../../system/bdbackup/backup/" .$td . "/" . $filename . $ext,'w+');
      
      fwrite($handle,$archivo);

     fclose($handle);

    } 


}//



public function Tablas(){
  $dir  = array(
"alter_materiaprima_reporte", 
"alter_opciones", 
"alter_producto_reporte", 
"categorias",
"clientes",
"clientes_mesa", 
"config_master", 
"config_root", 
"control_cocina", 
"control_panel_mostrar", 
"corte_diario", 
"cuentas",
"cuentas_abonos",
"delivery_repartidor",
"entradas_efectivo", 
"facturar_cai", 
"facturar_opciones", 
"facturar_rtn", 
"facturar_rtn_cliente", 
"gastos", 
"gastos_images", 
"images", 
"mesa", 
"mesa_nombre", 
"opciones", 
"opciones_asig", 
"opciones_name", 
"opciones_ticket", 
"planilla_descuentos", 
"planilla_descuentos_asig", 
"planilla_empleados", 
"planilla_extras", 
"planilla_pagos", 
"precios", 
"pro_asignado", 
"pro_bruto", 
"pro_dependiente", 
"pro_historial_addpro", 
"pro_historial_averias", 
"pro_registro_averia", 
"pro_registro_up", 
"pro_unidades_medida", 
"producto", 
"productos_venta_especial", 
"ticket", 
"ticket_num", 
"ticket_propina", 
"ticket_temp"); // directorios a recorrer

  return $dir;
}




public function VerRespaldos($url){

      $num = 0;
      $archivos = array_reverse(glob($url . "*.piz"));  
      foreach($archivos as $file){  
        $num ++;
        $size = $this->FileZ($file); 
        $filename = str_replace($url, "", $file);
        $data = str_replace(".piz", "", $filename);
      $output .= '
           <tr>
             <th scope="row">'.$num.'</th>
             <td>' . $data . '</td>
             <td>' . $size . '</td>
             <td>
             <a href="downloader.php?data='. $filename . $ext .'&name='. $data .'&type=1" class="btn btn-indigo btn-sm m-0">Descargar
            </a>
             </td>
             <td>
               <a id="eliminar" data="'. $filename . $ext .'" ><i class="fas fa-ban fa-lg red-text"></i><br></a>
             </td>
           </tr>';
      }


      echo '<table class="table table-striped table-responsive-md btn-table">

   <thead>
     <tr>
       <th>#</th>
       <th>Respaldo</th>
       <th>Size</th>
       <th>Descargar</th>
       <th>Eliminar</th>
     </tr>
   </thead>

   <tbody>';

       echo $output;

  echo '</tbody>

</table>';

}


public function FileZ($archivo){

    $archivox = filesize($archivo);

  if($archivox < 1024){
    $file = filesize($archivo) . " Kbi";
  }
  if($archivox > 1023 and $archivox < 1024000){
    $file = round(filesize($archivo) / 1024) . " Kb";
  }
  if($archivox > 1024000){
    $file = filesize($archivo) . " Mb";
  }

  return $file;
}




public function Eliminar($url, $archivo){

  if(unlink($url . $archivo)){
    Alerts::Alerta("success","Eliminado Correctamente","Respaldo eliminado correctamente");
  }

}









}// class
?>