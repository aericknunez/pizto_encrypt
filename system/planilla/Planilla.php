<?php 
class Planilla {

		public function __construct() { 
     	} 



  public function AddEmpleado($datos){
    $db = new dbConn();
      if($this->CompruebaForm($datos) == TRUE){ // comprueba si todos los datos requeridos estan llenos

                $datos["nombre"] = strtoupper($datos["nombre"]);
                $datos["hash"] = Helpers::HashId();
                $datos["time"] = Helpers::TimeId();
                $datos["td"] = $_SESSION["td"];
                if ($db->insert("planilla_empleados", $datos)) {

                    Alerts::Alerta("success","Realizado!","Registro realizado correctamente!");  
                }

        } else {
          Alerts::Alerta("error","Error!","Faltan Datos!");
        }
      $this->VerEmpleados();
  }


  public function CompruebaForm($datos){
        if($datos["nombre"] == NULL or
          $datos["documento"] == NULL or
          $datos["sueldo"] == NULL){
          return FALSE;
        } else {
         return TRUE;
        }
  }

  public function UpEmpleado($datos){ // lo que viede del formulario principal
    $db = new dbConn();
      if($this->CompruebaForm($datos) == TRUE){ // comprueba si todos los datos requeridos estan llenos

              $datos["nombre"] = strtoupper($datos["nombre"]);
              $datos["time"] = Helpers::TimeId();
              $hash = $datos["hash"];
              if (Helpers::UpdateId("planilla_empleados", $datos, "hash = '$hash' and td = ".$_SESSION["td"]."")) {
                  Alerts::Alerta("success","Realizado!","Cambio realizado exitsamente!");
                  echo '<script>
                        window.location.href="?verempleado"
                      </script>';
              }           

      } else {
        Alerts::Alerta("error","Error!","Faltan Datos!");
      }
  }



  public function VerEmpleados(){
      $db = new dbConn();
          $a = $db->query("SELECT * FROM planilla_empleados WHERE td = ".$_SESSION["td"]." order by id desc limit 10");
          if($a->num_rows > 0){
        echo '<table class="table table-sm table-hover">
          <thead>
            <tr>
              <th scope="col">#</th>
              <th scope="col">Nombre</th>
              <th scope="col">Documento</th>
              <th scope="col">Tel&eacutefono</th>
              <th scope="col">Sueldo</th>
              <th scope="col">Eliminar</th>
            </tr>
          </thead>
          <tbody>';
          $n = 1;
              foreach ($a as $b) { ;
                echo '<tr>
                      <th scope="row">'. $n ++ .'</th>
                      <td>'.$b["nombre"].'</td>
                      <td>'.$b["documento"].'</td>
                      <td>'.$b["telefono"].'</td>
                      <td>'.Helpers::Dinero($b["sueldo"]).'</td>
                      <td><a id="xdelete" hash="'.$b["hash"].'" op="301" dir="1"><i class="fa fa-minus-circle fa-lg red-text"></i></a></td>
                    </tr>';          
              }
        echo '</tbody>
        </table>';
            echo '<div class="text-center"><a href="?verempleado" class="btn btn-outline-info btn-rounded waves-effect btn-sm">Ver Todos</a></div>';
          } $a->close();  
      
  }


  public function DelEmpleado($hash, $dir){ // elimina precio
    $db = new dbConn();
        if (Helpers::DeleteId("planilla_empleados", "hash='$hash'")) {
           Alerts::Alerta("success","Eliminado!","Empleado eliminado correctamente!");
        } else {
            Alerts::Alerta("error","Error!","Algo Ocurrio!");
        } 

      if($dir == "2"){
        $this->VerTodosEmpleados(1, "id", "asc");
      } else {
        $this->VerEmpleados();
      }
  }





public function VerTodosEmpleados($npagina, $orden, $dir){
      $db = new dbConn();


  $limit = 12;
  $adjacents = 2;
  if($npagina == NULL) $npagina = 1;
  $a = $db->query("SELECT * FROM planilla_empleados WHERE td = ". $_SESSION['td'] ."");
  $total_rows = $a->num_rows;
  $a->close();

  $total_pages = ceil($total_rows / $limit);
  
  if(isset($npagina) && $npagina != NULL) {
    $page = $npagina;
    $offset = $limit * ($page-1);
  } else {
    $page = 1;
    $offset = 0;
  }

if($dir == "desc") $dir2 = "asc";
if($dir == "asc") $dir2 = "desc";
$op = 302;

 $a = $db->query("SELECT * FROM planilla_empleados WHERE td = ".$_SESSION["td"]." order by ".$orden." ".$dir." limit $offset, $limit");
      
      if($a->num_rows > 0){
          echo '<table class="table table-sm table-striped">
        <thead>
          <tr>
            <th><a id="paginador" op="'.$op.'" iden="1" orden="id" dir="'.$dir2.'">No</a></th>
            <th><a id="paginador" op="'.$op.'" iden="1" orden="nombre" dir="'.$dir2.'">Nombre</a></th>
            <th class="th-sm"><a id="paginador" op="'.$op.'" iden="1" orden="telefono" dir="'.$dir2.'">Tel&eacutefono</a></th>
            <th class="th-sm"><a id="paginador" op="'.$op.'" iden="1" orden="sueldo" dir="'.$dir2.'">Sueldo</a></th>
            <th class="th-sm"><a id="paginador" op="'.$op.'" iden="1" orden="puesto" dir="'.$dir2.'">Puesto</a></th>
            <th>Ver</th>
            <th>Borrar</th>
          </tr>
        </thead>
        <tbody>';
         $n = 1;
        foreach ($a as $b) {
          echo '<tr>
                      <td>'. $n ++ .'</td>
                      <td>'.$b["nombre"].'</td>
                      <td>'.$b["telefono"].'</td>
                      <td>'.Helpers::Dinero($b["sueldo"]).'</td>
                      <td>'.$b["puesto"].'</td>
                      <td><a id="xver" op="303" key="'.$b["hash"].'"><i class="fas fa-search fa-lg green-text"></i></a></td>
                      <td><a id="xdelete" hash="'.$b["hash"].'" op="301" dir="2"><i class="fa fa-minus-circle fa-lg red-text"></i></a></td>
                    </tr>';
        }
        echo '</tbody>
        </table>';
      }
        $a->close();

  if($total_pages <= (1+($adjacents * 2))) {
    $start = 1;
    $end   = $total_pages;
  } else {
    if(($page - $adjacents) > 1) {  
      if(($page + $adjacents) < $total_pages) {  
        $start = ($page - $adjacents); 
        $end   = ($page + $adjacents); 
      } else {              
        $start = ($total_pages - (1+($adjacents*2))); 
        $end   = $total_pages; 
      }
    } else {
      $start = 1; 
      $end   = (1+($adjacents * 2));
    }
  }
echo $total_rows . " Registros encontrados";
   if($total_pages > 1) { 

$page <= 1 ? $enable = 'disabled' : $enable = '';
    echo '<ul class="pagination pagination-sm justify-content-center">
    <li class="page-item '.$enable.'">
        <a class="page-link" id="paginador" op="'.$op.'" iden="1" orden="'.$orden.'" dir="'.$dir.'">&lt;&lt;</a>
      </li>';
    
    $page>1 ? $pagina = $page-1 : $pagina = 1;
    echo '<li class="page-item '.$enable.'">
        <a class="page-link" id="paginador" op="'.$op.'" iden="'.$pagina.'" orden="'.$orden.'" dir="'.$dir.'">&lt;</a>
      </li>';

    for($i=$start; $i<=$end; $i++) {
      $i == $page ? $pagina =  'active' : $pagina = '';
      echo '<li class="page-item '.$pagina.'">
        <a class="page-link" id="paginador" op="'.$op.'" iden="'.$i.'" orden="'.$orden.'" dir="'.$dir.'">'.$i.'</a>
      </li>';
    }

    $page >= $total_pages ? $enable = 'disabled' : $enable = '';
    $page < $total_pages ? $pagina = ($page+1) : $pagina = $total_pages;
    echo '<li class="page-item '.$enable.'">
        <a class="page-link" id="paginador" op="'.$op.'" iden="'.$pagina.'" orden="'.$orden.'" dir="'.$dir.'">&gt;</a>
      </li>';

    echo '<li class="page-item '.$enable.'">
        <a class="page-link" id="paginador" op="'.$op.'" iden="'.$total_pages.'" orden="'.$orden.'" dir="'.$dir.'">&gt;&gt;</a>
      </li>

      </ul>';
     }  // end pagination 

  } // termina 










public function VerTodosPlanillas($npagina, $orden, $dir){
      $db = new dbConn();


  $limit = 12;
  $adjacents = 2;
  if($npagina == NULL) $npagina = 1;
  $a = $db->query("SELECT * FROM planilla_empleados WHERE td = ". $_SESSION['td'] ."");
  $total_rows = $a->num_rows;
  $a->close();

  $total_pages = ceil($total_rows / $limit);
  
  if(isset($npagina) && $npagina != NULL) {
    $page = $npagina;
    $offset = $limit * ($page-1);
  } else {
    $page = 1;
    $offset = 0;
  }

if($dir == "desc") $dir2 = "asc";
if($dir == "asc") $dir2 = "desc";
$op = 302;

 $a = $db->query("SELECT * FROM planilla_empleados WHERE td = ".$_SESSION["td"]." order by ".$orden." ".$dir." limit $offset, $limit");
      
      if($a->num_rows > 0){
          echo '<table class="table table-sm table-striped">
        <thead>
          <tr>
            <th><a id="paginador" op="'.$op.'" iden="1" orden="id" dir="'.$dir2.'">No</a></th>
            <th><a id="paginador" op="'.$op.'" iden="1" orden="nombre" dir="'.$dir2.'">Nombre</a></th>
            <th class="th-sm"><a id="paginador" op="'.$op.'" iden="1" orden="puesto" dir="'.$dir2.'">Puesto</a></th>
            <th class="th-sm"><a id="paginador" op="'.$op.'" iden="1" orden="sueldo" dir="'.$dir2.'">Sueldo</a></th>
            <th>Detalles</th>
            <th>Extras</th>
            <th>Fechar</th>
          </tr>
        </thead>
        <tbody>';
         $n = 1;
        foreach ($a as $b) {
// compruebo el rango de fechas que debo buscar si se ha realizado planilla o no
$fechahoy = Fechas::Format(date("d-m-Y"));
$fechafin = Fechas::Format($this->ComprobarPlanillaAdd($b["hash"]));
if($fechahoy > $fechafin) $check = ' Pendiente';
else $check = ' Agregado';
///
          echo '<tr>
                      <td>'. $n ++ .'</td>
                      <td>'.$b["nombre"].'</td>
                      <td>'.$b["puesto"].'</td>
                      <td>'.Helpers::Dinero($b["sueldo"]).'</td>
                      <td><a id="xver" op="303" key="'.$b["hash"].'"><i class="fas fa-search fa-lg green-text"></i></a></td>
                      <td><a id="extras" key="'.$b["hash"].'"><i class="fa fa-edit fa-lg red-text"></i></a></td>
                      <td><a id="aplicar" hash="'.$b["hash"].'" op="308"><i class="fa fa-calendar fa-lg cyan-text"></i></a> '.$check.'</td>
                    </tr>';
        }
        echo '</tbody>
        </table>';
      }
        $a->close();

  if($total_pages <= (1+($adjacents * 2))) {
    $start = 1;
    $end   = $total_pages;
  } else {
    if(($page - $adjacents) > 1) {  
      if(($page + $adjacents) < $total_pages) {  
        $start = ($page - $adjacents); 
        $end   = ($page + $adjacents); 
      } else {              
        $start = ($total_pages - (1+($adjacents*2))); 
        $end   = $total_pages; 
      }
    } else {
      $start = 1; 
      $end   = (1+($adjacents * 2));
    }
  }
echo $total_rows . " Registros encontrados";
   if($total_pages > 1) { 

$page <= 1 ? $enable = 'disabled' : $enable = '';
    echo '<ul class="pagination pagination-sm justify-content-center">
    <li class="page-item '.$enable.'">
        <a class="page-link" id="paginador" op="'.$op.'" iden="1" orden="'.$orden.'" dir="'.$dir.'">&lt;&lt;</a>
      </li>';
    
    $page>1 ? $pagina = $page-1 : $pagina = 1;
    echo '<li class="page-item '.$enable.'">
        <a class="page-link" id="paginador" op="'.$op.'" iden="'.$pagina.'" orden="'.$orden.'" dir="'.$dir.'">&lt;</a>
      </li>';

    for($i=$start; $i<=$end; $i++) {
      $i == $page ? $pagina =  'active' : $pagina = '';
      echo '<li class="page-item '.$pagina.'">
        <a class="page-link" id="paginador" op="'.$op.'" iden="'.$i.'" orden="'.$orden.'" dir="'.$dir.'">'.$i.'</a>
      </li>';
    }

    $page >= $total_pages ? $enable = 'disabled' : $enable = '';
    $page < $total_pages ? $pagina = ($page+1) : $pagina = $total_pages;
    echo '<li class="page-item '.$enable.'">
        <a class="page-link" id="paginador" op="'.$op.'" iden="'.$pagina.'" orden="'.$orden.'" dir="'.$dir.'">&gt;</a>
      </li>';

    echo '<li class="page-item '.$enable.'">
        <a class="page-link" id="paginador" op="'.$op.'" iden="'.$total_pages.'" orden="'.$orden.'" dir="'.$dir.'">&gt;&gt;</a>
      </li>

      </ul>';
     }  // end pagination 

  } // termina 






//// aregar extras
  public function AddExtra($datos){
    $db = new dbConn();
      $datos = $this->ExtraSan($datos);

    if($datos["empleado"] == NULL or $datos["extra"] == NUll or $datos["cantidad"] == NUll){
      Alerts::Alerta("error","Error!","faltan datos importantes!");
    } else {
          $data["empleado"] = $datos["empleado"];
          $data["extra"] = $datos["extra"];
          $data["cantidad"] = $datos["cantidad"];
          $data["tipo"] = $datos["opcion"];
          $data["fecha"] = date("d-m-Y");
          $data["hora"] = date("H:i:s");
          $data["fechaF"] = Fechas::Format(date("d-m-Y"));
          $data["hash"] = Helpers::HashId();
          $data["time"] = Helpers::TimeId();
          $data["td"] = $_SESSION["td"];
          if ($db->insert("planilla_extras", $data)) {
                
                if($data["tipo"] == 2){ // si es adelanto lo agrego a la tabla gastos
                $gastox["tipo"] = 4;
                $gastox["nombre"] = $data["extra"];
                $gastox["descripcion"] = "Adelanto a " . $this->NombreEmpleado($datos["empleado"]);
                $gastox["cantidad"] = $data["cantidad"];
                $gastox["fecha"] = date("d-m-Y");
                $gastox["fechaF"] = Fechas::Format(date("d-m-Y"));
                $gastox["hora"] = date("H:i:s");
                $gastox["user"] = $_SESSION["user"];
                $gastox["edo"] = 1;
                $gastox["hash"] = Helpers::HashId();
                $gastox["time"] = Helpers::TimeId();
                $gastox["td"] = $_SESSION["td"];
                $db->insert("gastos", $gastox);
               }

              Alerts::Alerta("success","Realizado!","Registro realizado correctamente!");  

          } else {
            Alerts::Alerta("error","Error!","Ocurrio un error inesperado!");
          }     
  }

  $this->VerExtra($datos["empleado"],$datos["opcion"]);
}



public function ExtraSan($datos){
    if($datos["opcion"] == 1){
      $datos["empleado"] = $datos["eempleado"];
      $datos["extra"] = $datos["eextra"];
      $datos["cantidad"] = $datos["ecantidad"];
    }
    if($datos["opcion"] == 2){
      $datos["empleado"] = $datos["aempleado"];
      $datos["extra"] = $datos["aextra"];
      $datos["cantidad"] = $datos["acantidad"];
    }
    if($datos["opcion"] == 3){
      $datos["empleado"] = $datos["dempleado"];
      $datos["extra"] = $datos["dextra"];
      $datos["cantidad"] = $datos["dcantidad"];
    }
  return $datos;
}



  public function VerExtra($empleado, $tipo = NULL){
      $db = new dbConn(); // nota: de momento muestra solo el ultimo registro. cambiar a los de la quicena

      if($tipo != NULL){
        $a = $db->query("SELECT * FROM planilla_extras WHERE empleado='".$empleado."' and tipo='".$tipo."' and td = ".$_SESSION["td"]." order by id desc limit 1");
      } else {
        $a = $db->query("SELECT * FROM planilla_extras WHERE empleado='".$empleado."' and td = ".$_SESSION["td"]." order by id desc limit 1");
      }
          
          if($a->num_rows > 0){
        echo '<table class="table table-sm table-hover">
          <thead>
            <tr>
              <th scope="col">#</th>
              <th scope="col">Extra</th>
              <th scope="col">Cantidad</th>
              <th scope="col">Fecha</th>
            </tr>
          </thead>   
          <tbody>';
          $n = 1;
              foreach ($a as $b) { ;
                echo '<tr>
                      <th scope="row">'. $n ++ .'</th>
                      <td>'.$b["extra"].'</td>
                      <td>'.Helpers::Dinero($b["cantidad"]).'</td>
                      <td>'.$b["fecha"].'</td>
                    </tr>';          
              }
        echo '</tbody>
        </table>';

          } $a->close();  
      
  }





public function VerDetalles($empleado){
       $db = new dbConn();
       

if ($r = $db->select("*", "planilla_empleados", "WHERE hash = '".$empleado."' and td = ". $_SESSION["td"] ."")) { 
    $nombre = $r["nombre"];
    $documento = $r["documento"];
    $direccion = $r["direccion"];
    $sueldo = $r["sueldo"];
    $puesto = $r["puesto"];
     } unset($r); 


if ($r = $db->select("*", "planilla_pagos", "WHERE empleado = '".$empleado."' and td = ". $_SESSION["td"] ." order by id desc limit 1")) { 
    $finicio = $r["fecha_inicio"];
    $ffin = $r["fecha_fin"];
    $iniciof = $r[" inicioF"];
    $finf = $r["finF"];
    $dias = $r["dias"];
    $sueldoq = $r["sueldo"];
    $extras = $r["extras"];
    $descuentos = $r["descuentos  "];
    $liquido = $r["liquido"];
} unset($r); 



echo '<div class="row">
      <div class="col-8">
              <div>
              <p>Empleado: '. $nombre .'</p>
              </div>
              <div><p>
              Dirección: '. $direccion .'</p></div>

      </div>
        <div class="col-4 text-right">
       
          <div>
              <p>Puesto : '. $puesto .'</p>
             </div>
      <div>
              <p>Sueldo Mensual : '. Helpers::Dinero($sueldo) .'</p>
             </div>
        </div>
  </div>


  <pre>Detalles de la planilla</pre>';

        echo '<table class="table table-striped table-sm">
        <thead>
          <tr>
            <th>Concepto</th>
            <th>Rem. Dia</th>
            <th>Total</th>
          </tr>
        </thead>
        <tbody>';
// sueldo ganado
        echo '<tr>
              <th>('.$dias.' dias ) Sueldo dias laborales</th>
              <th>'.number_format($sueldo/30,4,'.',',').'</th>
              <td>'.Helpers::Dinero($sueldoq).'</td>
            </tr>';
// adelantos otorgados
echo $this-> ExtraFactura($empleado, 2);

// extras aplicados
echo $this-> ExtraFactura($empleado, 1);

// descuentos otorgados
echo $this-> ExtraFactura($empleado, 3);

// Total
        echo '<tr>
              <th colspan="2">Total a pagar: </th>
              <th>'.Helpers::Dinero($liquido).'</th>
            </tr>';
///////////////////////
        echo '</tbody>
          </table>';

echo '<p>Son: ' .Dinero::DineroEscrito($liquido) .'</p>';

echo '<p>Planilla realizada desde el: '.$finicio.' hasta el '.$ffin.'</p>
<div class="row mt-4">
      <div class="col-12">
              <div>
              <h4> Total de dias laborados: '.$dias.'</h4>
              </div>
      </div>
</div>';



  }













/////////////////////////////// aqui van funciones que pueden ser comunes

/// obtener nombre de empleado
  public function NombreEmpleado($hash){ // obtien el nombre del empleado segun hash
    $db = new dbConn();
      if ($r = $db->select("nombre", "planilla_empleados", "where hash = '".$hash."' and td = ".$_SESSION["td"]." order by id DESC LIMIT 1")) { return $r["nombre"];
      } unset($r); 
  }

  public function UltimoDia($hash){ // ultima fecha de pago empleado segun hash
    $db = new dbConn();
      if ($r = $db->select("fecha_fin", "planilla_pagos", "where hash = '".$hash."' and td = ".$_SESSION["td"]." order by id DESC LIMIT 1")) { return $r["fecha_fin"];
      } unset($r); 
  }


  public function SueldoEmpleado($hash){ // obtien el sueldp del empleado segun hash
    $db = new dbConn();
      if ($r = $db->select("sueldo", "planilla_empleados", "where hash = '".$hash."' and td = ".$_SESSION["td"]." order by id DESC LIMIT 1")) { return $r["sueldo"];
      } unset($r); 
  }

  public function NombreDescuento($hash){ // obtien el nombre del descuento segun hash
    $db = new dbConn();
      if ($r = $db->select("descuento", "planilla_descuentos", "where hash = '".$hash."' and td = ".$_SESSION["td"]." order by id DESC LIMIT 1")) { return $r["descuento"];
      } unset($r); 
  }



  public function SumarExtras($empleado, $tipo, $inicio, $fin){
    $db = new dbConn();
      $a = $db->query("SELECT sum(cantidad) FROM planilla_extras WHERE empleado = '".$empleado."' and tipo = '".$tipo."' and fechaF BETWEEN '$inicio' AND '$fin' and td = ".$_SESSION["td"]."");
        foreach ($a as $b) {
         return $b["sum(cantidad)"];
        } $a->close();
  }


  public function ComprobarPlanillaAdd($empleado){ /// comprueba de cuado fue la ultima planilla
    $db = new dbConn();
      $a = $db->query("SELECT fecha_fin FROM planilla_pagos WHERE empleado = '".$empleado."' and td = ".$_SESSION["td"]." order by id desc limit 1");
        foreach ($a as $b) {
         return $b["fecha_fin"];
        } $a->close();
  }



  public function ExtraFactura($empleado, $tipo, $borrar = NULL){
      $db = new dbConn(); // nota: de momento muestra solo el ultimo registro. cambiar a los de la quicena

if($tipo != 1) $sig = "- "; else $sig = "  ";

// compruebo el rango de fechas que debo buscar si se ha realizado planilla o no
$fechahoy = Fechas::Format(date("d-m-Y"));
$fechafin = Fechas::Format($this->ComprobarPlanillaAdd($empleado));

if($fechahoy > $fechafin){ // si la fecha de hoy es mayor a la fecha en la bd, obtener nuevas fechas hasta hoy
$inicioextra = $fechafin;
$finextra = $fechahoy;
} else { /// ocupar las fechas datas por la base de datos
  $a = $db->query("SELECT inicioF, finF FROM planilla_pagos WHERE empleado = '".$empleado."' and td = ".$_SESSION["td"]." order by id desc limit 1");
  foreach ($a as $b) {
    $inicioextra = $b["inicioF"];
    $finextra = $b["finF"];
  } $a->close();

}
// termina comprobacion de fechas



        $a = $db->query("SELECT * FROM planilla_extras WHERE empleado='".$empleado."' and fechaF BETWEEN '$inicioextra' AND '$finextra' and tipo='".$tipo."' and td = ".$_SESSION["td"]." order by id desc");
         
          if($a->num_rows > 0){
          $data; 
              foreach ($a as $b) {

      if($borrar == 1) $bor = '<td><a id="dextra" op="307" key="'. $b["hash"] .'" empleado="'. $empleado .'">
              <span class="badge red"><i class="fas fa-trash-alt" aria-hidden="true"></i></span>
              </a></td>'; else $bor = "  ";

      $data.= '<tr>
              <td colspan="2">'.$b["extra"].'</td>
              <td>'. $sig . Helpers::Dinero($b["cantidad"]).'</td>
              '.$bor.'
            </tr>';          
      }
  } $a->close(); 

      return $data;
  }


public function VerTodasExtras($empleado){ // solo para ver todos los extra y borrar

echo '<pre>Extras de la planilla</pre>';

        echo '<table class="table table-striped table-sm">
        <thead>
          <tr>
            <th>Concepto</th>
            <th>Total</th>
            <th>Borrar</th>
          </tr>
        </thead>
        <tbody>';
// adelantos otorgados
echo $this-> ExtraFactura($empleado, 2,1);

// extras aplicados
echo $this-> ExtraFactura($empleado, 1,1);

// descuentos otorgados
echo $this-> ExtraFactura($empleado, 3,1);

///////////////////////
        echo '</tbody>
          </table>';

  }




  public function DelExtra($data){ // elimina precio
    $db = new dbConn();
    $hash = $data["key"]; 

        if (Helpers::DeleteId("planilla_extras", "hash='$hash'")) {
           Alerts::Alerta("success","Eliminado!","Extra eliminado correctamente!");
        } else {
            Alerts::Alerta("error","Error!","Algo Ocurrio!");
        } 


        $this->VerTodasExtras($data["empleado"]);
  }




  public function AddPlanilla($data){
    $db = new dbConn();
  
  if($data["fecha1_submit"] == NULL or $data["fecha2_submit"] == NULL){
      Alerts::Alerta("error","Error!","Ingrese las fechas laboradas!");  
  } elseif(Fechas::Format($this->ComprobarPlanillaAdd($data["apliempleado"])) >= Fechas::Format($data["fecha1_submit"])){ // si la fecha de inicio es igual o mayor que la fecha fin registrada
      Alerts::Alerta("error","Error!","Compuebe sus fechas por favor!");
  } else {

$empleado = $data["apliempleado"];
$extras = $this->SumarExtras($empleado, 1, Fechas::Format($data["fecha1_submit"]), Fechas::Format($data["fecha2_submit"])) + $this->SumarExtras($empleado, 2, Fechas::Format($data["fecha1_submit"]), Fechas::Format($data["fecha2_submit"]));

$sueldo = $this->SueldoDias($empleado, Fechas::Format($data["fecha1_submit"]), Fechas::Format($data["fecha2_submit"]));
// obtengo los datos del empleado

////  aplicar descuentos de porcentajes establecidos
$ar = $db->query("SELECT planilla_descuentos.porcentaje as porcentaje, planilla_descuentos.descuento as descuento FROM planilla_descuentos
INNER JOIN planilla_descuentos_asig ON planilla_descuentos.hash = planilla_descuentos_asig.descuento WHERE
    planilla_descuentos_asig.empleado = '".$empleado."'");
    foreach ($ar as $br) {
       $percent = $this->PorcentajeDescuento($br["porcentaje"], $sueldo);

       $this->AddExtraPlan($empleado, $br["descuento"], $percent);
    } $ar->close();
// termina descuentos

$descuento = $this->SumarExtras($empleado, 3, Fechas::Format($data["fecha1_submit"]), Fechas::Format($data["fecha2_submit"]));

    $datos["empleado"] = $empleado;
    $datos["fecha_inicio"] = $data["fecha1_submit"];
    $datos["fecha_fin"] = $data["fecha2_submit"];
    $datos["inicioF"] = Fechas::Format($data["fecha1_submit"]);
    $datos["finF"] = Fechas::Format($data["fecha2_submit"]);
    $datos["dias"] = $this->ContarDias(Fechas::Format($data["fecha1_submit"]), Fechas::Format($data["fecha2_submit"]));
    $datos["sueldo"] = $sueldo;
    $datos["extras"] = $extras;
    $datos["descuentos"] = $descuento;
    $datos["liquido"] = $this->GetLiquido($sueldo, $extras, $descuento);
    $datos["hash"] = Helpers::HashId();
    $datos["time"] = Helpers::TimeId();
    $datos["td"] = $_SESSION["td"];
    if ($db->insert("planilla_pagos", $datos)) {

            Alerts::Alerta("success","Realizado!","Registro realizado correctamente!");  
        } else {
          Alerts::Alerta("error","Error!","Ocurrio un error inesperado!");  
        }

  }


      $this->VerTodosPlanillas(1, "id", "asc");
  }



//// aregar extras (solo para cuando se hace la planilla y se agregan gastos fijos)
  public function AddExtraPlan($empleado, $extra, $cantidad){
    $db = new dbConn();

    if($empleado != NULL or $cantidad != NUll){
          $data["empleado"] = $empleado;
          $data["extra"] = $extra;
          $data["cantidad"] = $cantidad;
          $data["tipo"] = 3;
          $data["fecha"] = date("d-m-Y");
          $data["hora"] = date("H:i:s");
          $data["fechaF"] = Fechas::Format(date("d-m-Y"));
          $data["hash"] = Helpers::HashId();
          $data["time"] = Helpers::TimeId();
          $data["td"] = $_SESSION["td"];
          $db->insert("planilla_extras", $data);            
  }
}

public function ContarDias($inicio, $fin){
  //86400 equivale a un dia
  $data =  $fin - $inicio;
  $data = $data + 86400;
  $dias =  $data / 86400;
  return $dias;
}


public function SueldoDias($empleado, $inicio, $fin){
  // sueldo entre 30 * dias laborados
  $sueldodia = $this->SueldoEmpleado($empleado) / 30;
  $dias = $this->ContarDias($inicio, $fin);
 $sueldo = $sueldodia * $dias;
 return $sueldo;
}

public function GetLiquido($sueldo, $extras, $descuento){
  $data = $sueldo + $extras;
  $liquido =  $data - $descuento;
  return $liquido;
}

public function PorcentajeDescuento($descuento, $sueldo){ // obterner porcentaje descuento
  $porcentaje = $descuento / 100;
  $total =  $porcentaje * $sueldo;
  return $total;
}




public function AddDescuento($dato){
      $db = new dbConn();
      if($dato["descuento"] == NULL or $dato["porcentaje"] == NULL){
        Alerts::Alerta("error","Error!","Faltan datos importantes!");  
    } else {

            $datos["descuento"] = $dato["descuento"];
            $datos["porcentaje"] = $dato["porcentaje"];
            $datos["hash"] = Helpers::HashId();
            $datos["time"] = Helpers::TimeId();
            $datos["td"] = $_SESSION["td"];
            if ($db->insert("planilla_descuentos", $datos)) {

                Alerts::Alerta("success","Realizado!","Registro realizado correctamente!");  
            }

    }
$this->VerDescuentos();
}

public function VerDescuentos(){
     $db = new dbConn();
          $a = $db->query("SELECT * FROM planilla_descuentos WHERE td = ".$_SESSION["td"]." order by id desc");
          if($a->num_rows > 0){
        echo '<table class="table table-sm table-hover">
          <thead>
            <tr>
              <th scope="col">#</th>
              <th scope="col">Descuento</th>
              <th scope="col">Porcentaje</th>
              <th scope="col">Eliminar</th>
            </tr>
          </thead>
          <tbody>';
          $n = 1;
              foreach ($a as $b) { ;
                echo '<tr>
                      <th scope="row">'. $n ++ .'</th>
                      <td>'.$b["descuento"].'</td>
                      <td>'.$b["porcentaje"].' %</td>
                      <td><a id="xdeleted" hash="'.$b["hash"].'" op="310"><i class="fa fa-minus-circle fa-lg red-text"></i></a></td>
                    </tr>';          
              }
        echo '</tbody>
        </table>';
          } $a->close(); 
}



  public function DelDescuento($hash){ // elimina precio
    $db = new dbConn();
        if (Helpers::DeleteId("planilla_descuentos", "hash='$hash'")) {
            Helpers::DeleteId("planilla_descuentos_asig", "descuento='$hash'"); // descuento aplicado
           Alerts::Alerta("success","Eliminado!","Descuento eliminado correctamente!");
        } else {
            Alerts::Alerta("error","Error!","Algo Ocurrio!");
        } 

   $this->VerDescuentos();
  }



  public function SelectDescuento(){ // Es el Select de la descuento Para poder Recargarlo
    $db = new dbConn();
    $a = $db->query("SELECT hash, descuento FROM planilla_descuentos WHERE td = ".$_SESSION["td"].""); 
           echo '<select class="browser-default custom-select" id="descuento" name="descuento">
                  <option selected disabled>Descuento</option>';

             foreach ($a as $b) {
              echo '<option value="'. $b["hash"] .'">'. $b["descuento"] .'</option>'; 
                } $a->close();
          echo '</select>';          

  }

  public function SelectEmpleado(){ // Es el Select de la descuento Para poder Recargarlo
    $db = new dbConn();
    $a = $db->query("SELECT hash, nombre FROM planilla_empleados WHERE td = ".$_SESSION["td"].""); 
           echo '<select class="browser-default custom-select" id="empleado" name="empleado">
                  <option selected disabled>Empleado</option>';

             foreach ($a as $b) {
              echo '<option value="'. $b["hash"] .'">'. $b["nombre"] .'</option>'; 
                } $a->close();
          echo '</select>';          

  }

///////////
public function AddDescuentoAsig($dato){
      $db = new dbConn();
      if($dato["descuento"] == NULL or $dato["empleado"] == NULL){
        Alerts::Alerta("error","Error!","Faltan datos importantes!");  
    } else {
        // se debe buscar si no existes ya ese descuento
        $a = $db->query("SELECT * FROM planilla_descuentos_asig WHERE descuento = '".$dato["descuento"]."' and empleado = '".$dato["empleado"]."'");
        $cantidades = $a->num_rows;
        $a->close();
        // 
        if($cantidades == 0){
                 $datos["descuento"] = $dato["descuento"];
                $datos["empleado"] = $dato["empleado"];
                $datos["hash"] = Helpers::HashId();
                $datos["time"] = Helpers::TimeId();
                $datos["td"] = $_SESSION["td"];
                if ($db->insert("planilla_descuentos_asig", $datos)) {

                    Alerts::Alerta("success","Realizado!","Registro realizado correctamente!");  
                }         
          } else {
            Alerts::Alerta("error","Error!","Ya existe el registro de este descuento con empleado!"); 
          }


    }
$this->VerDescuentosAsig();
}


public function VerDescuentosAsig(){
     $db = new dbConn();
          $a = $db->query("SELECT * FROM planilla_descuentos_asig WHERE td = ".$_SESSION["td"]." order by empleado");
          if($a->num_rows > 0){
        echo '<table class="table table-sm table-hover">
          <thead>
            <tr>
              <th scope="col">#</th>
              <th scope="col">Descuento</th>
              <th scope="col">Empleado</th>
              <th scope="col">Eliminar</th>
            </tr>
          </thead>
          <tbody>';
          $n = 1;
              foreach ($a as $b) { ;
                echo '<tr>
                      <th scope="row">'. $n ++ .'</th>
                      <td>'. $this->NombreEmpleado($b["empleado"]).'</td>
                      <td>'. $this->NombreDescuento($b["descuento"]).'</td>
                      <td><a id="xdeletea" hash="'.$b["hash"].'" op="313"><i class="fa fa-minus-circle fa-lg red-text"></i></a></td>
                    </tr>';          
              }
        echo '</tbody>
        </table>';
          } $a->close(); 
  
}



  public function DelDescuentoAsig($hash){ // elimina precio
    $db = new dbConn();
        if (Helpers::DeleteId("planilla_descuentos_asig", "hash='$hash'")) {
           Alerts::Alerta("success","Eliminado!","Descuento eliminado correctamente!");
        } else {
            Alerts::Alerta("error","Error!","Algo Ocurrio!");
        } 

   $this->VerDescuentosAsig();
  }






} // Termina la clase
?>