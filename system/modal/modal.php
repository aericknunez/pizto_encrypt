<style>
    body { 
        background-color: black; /* La página de fondo será negra */
        color: 000; 
    	}
</style>
<?php
defined('BASEPATH') OR exit('No direct script access allowed');

if($_REQUEST["modal"]=="modcategoria") include_once 'system/modal/modal/iconos_modcategoria.php';

if($_REQUEST["modal"]=="modproducto") include_once 'system/modal/modal/iconos_modproducto.php';

if($_REQUEST["modal"]=="modprocate") include_once 'system/modal/modal/iconos_modproducto-categoria.php';

if($_REQUEST["modal"]=="addcat") include_once 'system/modal/modal/iconos_addcat.php';

if($_REQUEST["modal"]=="selectimg") include_once 'system/modal/modal/iconos_img_select.php';

if($_REQUEST["modal"]=="addproducto") include_once 'system/modal/modal/iconos_addproducto.php';

if($_REQUEST["modal"]=="addopciones") include_once 'system/modal/modal/iconos_addopciones.php';

if($_REQUEST["modal"]=="factura") include_once 'system/modal/modal/factura.php';

if($_REQUEST["modal"]=="factura_imprimir") include_once 'system/modal/modal/factura_imprimir.php';

if($_REQUEST["modal"]=="detalleproducto") include_once 'system/modal/modal/detalleproducto.php';

if($_REQUEST["modal"]=="opciones") include_once 'system/modal/modal/opcion_platillos.php';

if($_REQUEST["modal"]=="addmesa") include_once 'system/modal/modal/addmesa.php';

if($_REQUEST["modal"]=="dividir") include_once 'system/modal/modal/dividircuenta.php';

if($_REQUEST["modal"]=="pagar") include_once 'system/modal/modal/pagarcuenta.php';

if($_REQUEST["modal"]=="modificar") include_once 'system/modal/modal/modificaropciones.php';

if($_REQUEST["modal"]=="reordenar") include_once 'system/modal/modal/iconos_reordenar.php';

if($_REQUEST["modal"]=="conf_config") include_once 'system/modal/modal/conf_config.php';

if($_REQUEST["modal"]=="conf_root") include_once 'system/modal/modal/conf_root.php';

if($_REQUEST["modal"]=="otras_ventas") include_once 'system/modal/modal/otras_ventas.php';

if($_REQUEST["modal"]=="venta_especial") include_once 'system/modal/modal/venta_especial.php';
if($_REQUEST["modal"]=="nombremesa") include_once 'system/modal/modal/nombremesa.php';

if($_REQUEST["modal"]=="img_negocio") include_once 'system/modal/modal/imagen_negocio.php';

if($_REQUEST["modal"]=="respaldar") include_once 'system/modal/modal/respaldar.php';

if($_REQUEST["modal"]=="newcut") include_once 'system/modal/modal/newcut.php';

if($_REQUEST["modal"]=="editcliente") include_once 'system/modal/modal/editar-cliente.php';

if($_REQUEST["modal"]=="editproveedor") include_once 'system/modal/modal/editar-proveedor.php';

// cuentas abonos
if($_REQUEST["modal"]=="abonos_cuentas") include_once 'system/modal/modal/cuentas_abonos.php';


/// planilla
if($_REQUEST["modal"]=="editempleado") include_once 'system/modal/modal/editar-empleado.php';
?>