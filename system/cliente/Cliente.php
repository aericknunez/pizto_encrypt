<?php 
class Clientes {

		public function __construct() { 
     	} 



  public function AddCliente($datos, $mostrar = NULL){ /// si mostrar es null muestra los clientes
    $db = new dbConn();
      if($this->CompruebaForm($datos) == TRUE){ // comprueba si todos los datos requeridos estan llenos

                $datos["nombre"] = strtoupper($datos["nombre"]);
                $datos["hash"] = Helpers::HashId();
                $datos["time"] = Helpers::TimeId();
                $datos["td"] = $_SESSION["td"];
                if ($db->insert("clientes", $datos)) {
                   
                    $edo = TRUE; 
                } else {
                    $edo = FALSE;
                }

        } else {
          $edo = FALSE;
        }


      if($mostrar == NULL){

            if($edo == TRUE){
              Alerts::Alerta("success","Realizado!","Registro realizado correctamente!"); 
            } else {
              Alerts::Alerta("error","Error!","Faltan Datos!");
            }
          $this->VerClientes();

      } else {
          if($edo == TRUE){
             $_SESSION["cad"] = $datos["hash"]; // el hash del cliente que se acaba de ingresar
          }
          return $edo;
      }
  }








  public function CompruebaForm($datos){
        if($datos["nombre"] == NULL or
          $datos["direccion"] == NULL or
          $datos["telefono"] == NULL){
          return FALSE;
        } else {
         return TRUE;
        }
  }

  public function UpCliente($datos){ // lo que viede del formulario principal
    $db = new dbConn();
      if($this->CompruebaForm($datos) == TRUE){ // comprueba si todos los datos requeridos estan llenos

              $datos["nombre"] = strtoupper($datos["nombre"]);
              $datos["time"] = Helpers::TimeId();
              $hash = $datos["hash"];
              if (Helpers::UpdateId("clientes", $datos, "hash = '$hash' and td = ".$_SESSION["td"]."")) {
                  Alerts::Alerta("success","Realizado!","Cambio realizado exitsamente!");
                  echo '<script>
                        window.location.href="?clientever"
                      </script>';
              }           

      } else {
        Alerts::Alerta("error","Error!","Faltan Datos!");
      }
  }



  public function VerClientes(){
      $db = new dbConn();
          $a = $db->query("SELECT * FROM clientes WHERE td = ".$_SESSION["td"]." order by id desc limit 10");
          if($a->num_rows > 0){
        echo '<table class="table table-sm table-hover">
          <thead>
            <tr>
              <th scope="col">#</th>
              <th scope="col">Nombre</th>
              <th scope="col">Documento</th>
              <th scope="col">Direccion</th>
              <th scope="col">Telefono</th>
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
                      <td>'.$b["direccion"].'</td>
                      <td>'.$b["telefono"].'</td>
                      <td><a id="xdelete" hash="'.$b["hash"].'" op="365"><i class="fa fa-minus-circle fa-lg red-text"></i></a></td>
                    </tr>';          
              }
        echo '</tbody>
        </table>';
            echo '<div class="text-center"><a href="?clientever" class="btn btn-outline-info btn-rounded waves-effect btn-sm">Ver Todos</a></div>';
          } else {
            Alerts::Mensajex("No se encontr&oacute regitro de clientes","info");
          } $a->close();  
      
  }


  public function DelCliente($hash){ // elimina precio
    $db = new dbConn();
        if (Helpers::DeleteId("clientes", "hash='$hash'")) {
           Alerts::Alerta("success","Eliminado!","Cliente eliminado correctamente!");
        } else {
            Alerts::Alerta("error","Error!","Algo Ocurrio!");
        } 
      $this->VerClientes();
  }

  public function DelClientex($hash){ // elimina precio
    $db = new dbConn();
        if(Helpers::DeleteId("clientes", "hash='$hash'")) {
           Alerts::Alerta("success","Eliminado!","Cliente eliminado correctamente!");
        } else {
           Alerts::Alerta("error","Error!","Algo Ocurrio!");
        } 
      $this->VerTodosClientes();
  }


  public function VerTodosClientes(){
      $db = new dbConn();
          $a = $db->query("SELECT * FROM clientes WHERE td = ".$_SESSION["td"]." order by id desc");
          if($a->num_rows > 0){
        echo '<table id="dtMaterialDesignExample" class="table table-striped" table-sm cellspacing="0" width="100%">
                <thead>
                  <tr>
                    <th class="th-sm">#</th>
                    <th class="th-sm">Nombre</th>
                    <th class="th-sm">Documento</th>
                    <th class="th-sm">Telefono</th>
                    <th class="th-sm">Ver</th>
                    <th class="th-sm">Eliminar</th>
                  </tr>
                </thead>
                <tbody>';
          $n = 1;
              foreach ($a as $b) { ;
                echo '<tr>
                      <td>'. $n ++ .'</td>
                      <td>'.$b["nombre"].'</td>
                      <td>'.$b["documento"].'</td>
                      <td>'.$b["telefono"].'</td>
                      <td><a id="xver" op="368" key="'.$b["hash"].'"><i class="fas fa-search fa-lg green-text"></i></a></td>
                      <td><a id="xdelete" hash="'.$b["hash"].'" op="366"><i class="fa fa-minus-circle fa-lg red-text"></i></a></td>
                    </tr>';          
              }
        echo '</tbody>
                <tfoot>
                  <tr>
                    <th>#</th>
                    <th>Nombre</th>
                    <th>Documento</th>
                    <th>Telefono</th>
                    <th>Ver</th>
                    <th>Eliminar</th>
                  </tr>
                </tfoot>
              </table>';

          } else {
            Alerts::Mensajex("No se encontr&oacute regitro de clientes","info");
          } $a->close();  

  }








public function VistaCliente($data){
      $db = new dbConn();
     if ($r = $db->select("*", "clientes", "WHERE hash = '".$data["key"]."' and td = ".$_SESSION["td"]."")) { 


echo '<blockquote class="blockquote bq-primary">
  <p class="bq-title" mb-0>'.$r["nombre"].'</p>
</blockquote>';

echo '  <p  class="mt-1">Documento: <strong>'.$r["documento"].'</strong> </p>';
echo '  <p  class="mt-1">Tel&eacutefono: <strong>'.$r["telefono"].'</strong> </p>';
echo '  <p  class="mt-1">Fecha de Nacimiento: <strong>'.Fechas::FechaEscrita($r["nacimiento"]).'</strong> </p>';

              echo '<table class="table table-hover">
                <tbody>
                  <tr>
                    <th colspan="2">Direcci&oacuten: '.$r["direccion"].'</th>
                  </tr>
                  <tr>
                    <td>Departamento: '.$r["departamento"].'</td>
                    <td>Municipio: '.$r["municipio"].'</td>
                  </tr>
                  <tr>
                    <td>Email: '.$r["email"].'</td>
                    <td>Comentarios: '.$r["comentarios"].'</td>
                  </tr>
                </tbody>
              </table>'; 

        }  unset($r); 


  }










} // Termina la lcase
?>