<?php 
class Proveedores{

		public function __construct() { 
     	} 



  public function AddProveedor($datos){
    $db = new dbConn();
      if($this->CompruebaForm($datos) == TRUE){ // comprueba si todos los datos requeridos estan llenos

                $datos["hash"] = Helpers::HashId();
                $datos["time"] = Helpers::TimeId();
                $datos["td"] = $_SESSION["td"];
                if ($db->insert("proveedores", $datos)) {

                       Alerts::Alerta("success","Realizado!","Registro realizado correctamente!");  
                }

        } else {
          Alerts::Alerta("error","Error!","Faltan Datos!");
        }
      $this->VerProveedores();
  }


  public function CompruebaForm($datos){
        if($datos["nombre"] == NULL or
          $datos["documento"] == NULL or
          $datos["direccion"] == NULL or
          $datos["telefono"] == NULL){
          return FALSE;
        } else {
         return TRUE;
        }
  }

  public function UpProveedor($datos){ // lo que viede del formulario principal
    $db = new dbConn();
      if($this->CompruebaForm($datos) == TRUE){ // comprueba si todos los datos requeridos estan llenos

                $datos["time"] = Helpers::TimeId();
                $hash = $datos["hash"];
              if (Helpers::UpdateId("proveedores", $datos, "hash = '$hash' and td = ".$_SESSION["td"]."")) {
                  Alerts::Alerta("success","Realizado!","Cambio realizado exitsamente!");
                  echo '<script>
                        window.location.href="?proveedorver"
                      </script>';
              }           

      } else {
        Alerts::Alerta("error","Error!","Faltan Datos!");
      }
  }



  public function VerProveedores(){
      $db = new dbConn();
          $a = $db->query("SELECT * FROM proveedores WHERE td = ".$_SESSION["td"]." order by id desc limit 10");
          if($a->num_rows > 0){
        echo '<table class="table table-sm table-hover">
          <thead>
            <tr>
              <th scope="col">#</th>
              <th scope="col">Nombre</th>
              <th scope="col">Documento</th>
              <th scope="col">Direccion</th>
              <th scope="col">Telefono</th>
              <th scope="col">Contacto</th>
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
                      <td>'.$b["contacto"].'</td>
                      <td><a id="xdelete" hash="'.$b["hash"].'" op="191" ><i class="fa fa-minus-circle fa-lg red-text"></i></a></td>
                    </tr>';          
              }
        echo '</tbody>
        </table>';
            echo '<div class="text-center"><a href="?proveedorver" class="btn btn-outline-info btn-rounded waves-effect btn-sm">Ver Todos</a></div>';
          } $a->close();  
      
  }


  public function DelProveedor($hash){ // elimina precio
    $db = new dbConn();
        if (Helpers::DeleteId("proveedores", "hash='$hash'")) {
           Alerts::Alerta("success","Eliminado!","Proveedor eliminado correctamente!");
        } else {
            Alerts::Alerta("error","Error!","Algo Ocurrio!");
        } 
      $this->VerProveedores();
  }

  public function DelProveedorx($hash){ // elimina precio
    $db = new dbConn();
        if (Helpers::DeleteId("proveedores", "hash='$hash'")) {
           Alerts::Alerta("success","Eliminado!","Proveedor eliminado correctamente!");
        } else {
            Alerts::Alerta("error","Error!","Algo Ocurrio!");
        } 
      $this->VerTodosProveedores();
  }


  public function VerTodosProveedores(){
      $db = new dbConn();
          $a = $db->query("SELECT * FROM proveedores WHERE td = ".$_SESSION["td"]." order by id desc");
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
                      <td><a id="xver" op="189" key="'.$b["hash"].'"><i class="fas fa-search fa-lg green-text"></i></a></td>
                      <td><a id="xdelete" hash="'.$b["hash"].'" op="192"><i class="fa fa-minus-circle fa-lg red-text"></i></a></td>
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

          } $a->close();  

  }





  public function VistaProveedor($data){
      $db = new dbConn();
     if ($r = $db->select("*", "proveedores", "WHERE hash = '".$data["key"]."' and td = ".$_SESSION["td"]."")) { 

              echo '<table class="table table-hover">
                <thead>
                  <tr>
                    <th colspan="2">'.$r["nombre"].'</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td>Documento: '.$r["documento"].'</td>
                    <td>Registro: '.$r["registro"].'</td>
                  </tr>
                  <tr>
                    <th colspan="2">Direcci&oacuten: '.$r["direccion"].'</th>
                  </tr>
                  <tr>
                    <td>Departamento: '.$r["departamento"].'</td>
                    <td>Municipio: '.$r["municipio"].'</td>
                  </tr>
                  <tr>
                    <td>Giro: '.$r["giro"].'</td>
                    <td>Telefono: '.$r["telefono"].'  |  Email: '.$r["email"].'</td>
                  </tr>
                  <tr>
                    <td>Contacto: '.$r["contacto"].'</td>
                    <td>Tel. Contacto: '.$r["tel_contacto"].'</td>
                  </tr>
                  <tr>
                    <th colspan="2">Comenatarios: '.$r["comentarios"].'</th>
                  </tr>
                </tbody>
              </table>'; 

        }  unset($r); 

  }










} // Termina la lcase
?>