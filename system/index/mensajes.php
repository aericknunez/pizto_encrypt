<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

include_once 'application/common/Alerts.php';
include_once 'application/common/Fechas.php';
include_once 'system/index/Inicio.php';
include_once 'system/corte/Corte.php';
include_once 'system/ventas/Venta.php';

if($_SESSION['sinuso'] != NULL){ // para decir que no esta en uso el sistema
Alerts::Mensaje('Al parecer sus sistema se encuentra sin registros, para iniciar debe agregar nuevos productos para posteriormente comenzar a venderlos. Si no sabe por donde comenzar, no se preocupe, puede ir a la secci&oacuten de ayuda o ponerse en contacto con nosotros.',"warning",'<a href="?iconos" class="btn btn-success">AGREGAR PRODUCTOS</a>','<a href="https://pizto.com/help" class="btn btn-primary" target="_blank"><i class="fas fa-info-circle "></i> IR A LA AYUDA </a>');
unset($_SESSION['sinuso']);	
}
?>