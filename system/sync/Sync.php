<?php 
class Sync{

	public function __construct(){

	}




	public function ListaCortes(){
		//
		$dia=10;
		echo '<table class="table table-sm table-striped">
			  <thead>
			    <tr>
			      <th scope="col">No</th>
			      <th scope="col">Fecha</th>
			      <th scope="col">Estado</th>
			      <th scope="col">Datos</th>
			    </tr>
			  </thead>
			  <tbody>';
		    for ($x = 1; $x <= $dia; $x++) {
		    	$dias = Fechas::DiaResta(date("d-m-Y"),$x);
		    	
		    	echo '<tr>
		    	  <td scope="row">'. $x .'</td>
			      <td scope="row">'. $dias .'</td>
			      <td>';
			      if($this->VerificarDatos($dias) == "No"){
			      	echo "Sin Datos";
			      } else {
			      if(Corte::BuscaCorte($dias) == 1){ $this-> UrlCorte($dias, TRUE); 
					} else { $this-> UrlCorte($dias, FALSE); }
				  }
			      echo '</td>
			      <td>'. $this->VerificarDatos($dias) .'</td>
			      </tr>';		    	
		    }	


		    echo '</tbody>
		    </table>';

	}




	public function UrlCorte($fecha, $url){
		if($url == FALSE){
			echo '<a href="?modal=newcut&fecha='.$fecha.'" class="btn btn-danger waves-effect waves-light">
			    Hacer Corte
			</a>';
		} else {
			echo '<a class="btn btn-success waves-effect waves-light">
			    Existe Corte
			</a>';
		}
	}



	public function BuscaRespaldo($fecha){
		$db = new dbConn();
	    	$a = $db->query("SELECT * FROM sync_status WHERE fecha = '$fecha' and creado = 1 and ejecutado = 1 and td = ".$_SESSION["td"]."");
			return $a->num_rows;
			$a->close();
	}


	public function VerificarDatos($fecha){
		$db = new dbConn();
	    	$a = $db->query("SELECT * FROM ticket WHERE fecha = '$fecha' and td = ".$_SESSION["td"]."");
			if($a->num_rows > 0){ return "Si";} else { return "No";}
			$a->close();
	}











} // class

?>