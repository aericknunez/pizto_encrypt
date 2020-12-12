
<?php if($_SESSION["tipo_cuenta"] == 1 or $_SESSION["tipo_cuenta"] == 2  or $_SESSION["tipo_cuenta"] == 5) { ?>

<li><a href="?mesashoy" class="collapsible-header waves-effect arrow-r"><i class="fas fa-table"></i> MESAS HOY</a></li>

<?php } ?>





<?php if($_SESSION["tipo_cuenta"] == 1 or $_SESSION["tipo_cuenta"] == 2 or $_SESSION["tipo_cuenta"] == 3 or $_SESSION["tipo_cuenta"] == 5) {

if((Helpers::ServerDomain() == FALSE and $_SESSION["root_plataforma"] == 0) or (Helpers::ServerDomain() == TRUE and $_SESSION["root_plataforma"] == 1)) {
?>

<li><a href="?corte" class="collapsible-header waves-effect arrow-r"><i class="fas fa-money-bill"></i> CORTE DIARIO</a></li>

<?php } }  ?>




<?php if($_SESSION["tipo_cuenta"] == 1 or $_SESSION["tipo_cuenta"] == 5) { ?>
<li><a class="collapsible-header waves-effect arrow-r"><i class="fas fa-calendar-alt"></i> HISTORIAL<i class="fas fa-angle-down rotate-icon"></i></a>
<div class="collapsible-body">
<ul class="list-unstyled">
<li><a href="?reportediario" class="waves-effect"> Reporte Diario</a></li>
<li><a href="?diario" class="waves-effect"> Historial Diario</a></li>
<li><a href="?mensual" class="waves-effect"> Historial Mensual</a></li>
<li><a href="?cortes" class="waves-effect"> Historial de Cortes</a></li>
<li><a href="?gastodiario" class="waves-effect"> Gastos Diario</a></li>
<li><a href="?gastomensual" class="waves-effect"> Gastos Mensual</a></li>
<li><a href="?gra_semanal" class="waves-effect"> Grafico Semanal</a></li>
<li><a href="?gra_mensual" class="waves-effect"> Grafico Mensual</a></li>
<li><a href="?gra_semestre" class="waves-effect"> Grafico Semestral</a></li>
<li><a href="?ordenes_eliminadas" class="waves-effect"> Ordenes Eliminadas</a></li>
<li><a href="?ticket_eliminados" class="waves-effect"> Ticket Eliminados</a></li>
<li><a href="?resumen_meseros" class="waves-effect"> Resumen Meseros</a></li>
<?php if($_SESSION["tipo_cuenta"] == 1) { ?>
<li><a href="?mesasfecha" class="waves-effect"> Mesas Fecha</a></li>
<?php } ?>
<!-- <li><a href="?propinas" class="waves-effect"> Calcular Propinas</a></li> -->
</ul>
</div>
</li>
<?php } ?>




<?php if($_SESSION["tipo_cuenta"] == 1 or $_SESSION["tipo_cuenta"] == 2 or $_SESSION["tipo_cuenta"] == 3 or $_SESSION["tipo_cuenta"] == 5) {

if((Helpers::ServerDomain() == FALSE and $_SESSION["root_plataforma"] == 0) or (Helpers::ServerDomain() == TRUE and $_SESSION["root_plataforma"] == 1)) {
?>

<li><a class="collapsible-header waves-effect arrow-r"><i class="fas fa-cog"></i> EFECTIVO<i class="fa fa-angle-down rotate-icon"></i></a>
<div class="collapsible-body">
<ul class="list-unstyled">

<li><a href="?gastos" class="waves-effect"><i class="fas fa-cog"></i> Gastos y Compras</a></li>
<li><a href="?entradas" class="waves-effect"><i class="fas fa-cogs"></i> Entrada de Efectivo</a></li>

</ul>
</div>
</li>

<?php } } ?>





<?php if($_SESSION["tipo_cuenta"] == 1 or $_SESSION["tipo_cuenta"] == 2 or $_SESSION["tipo_cuenta"] == 3 or $_SESSION["tipo_cuenta"] == 5) {

if((Helpers::ServerDomain() == FALSE and $_SESSION["root_plataforma"] == 0) or (Helpers::ServerDomain() == TRUE and $_SESSION["root_plataforma"] == 1)) {
?>

<li><a class="collapsible-header waves-effect arrow-r"><i class="fas fa-hand-holding-usd"></i> FACTURAS<i class="fas fa-angle-down rotate-icon"></i></a>
<div class="collapsible-body">
<ul class="list-unstyled">
<li><a href="?rtn" class="waves-effect"> Agregar <?php echo $_SESSION['config_nombre_documento']; ?></a></li>
<li><a href="#" class="waves-effect"> Agregar Exonerado</a></li>
<?php if(($_SESSION["tipo_cuenta"] == 1 or $_SESSION["tipo_cuenta"] == 2 or $_SESSION["tipo_cuenta"] == 5) and $_SESSION['config_pais'] == 2) { // para agregar un cai solo en honduras?>
<li><a href="?cai" class="waves-effect"> Nuevo CAI</a></li>
<?php } ?>
<?php if($_SESSION["root_plataforma"] == 0){ ?>
<li><a href="?rango" class="waves-effect"> Imprimir Facturas</a></li>
<?php } ?>
<li><a href="?propina" class="waves-effect"> Establecer Propina</a></li>

<?php if($_SESSION["tx"] == 1 and ($_SESSION["tipo_cuenta"] == 1 or $_SESSION["tipo_cuenta"] == 2 or $_SESSION["tipo_cuenta"] == 5)){
echo '<li><a href="?contadora" class="waves-effect"> Imprimir Reporte</a></li>';
echo '<li><a href="?eliminar_facturas" class="waves-effect"> Eliminar Facturas</a></li>';	
} ?>
</ul>
</div>
</li>

<?php } } ?>






<!-- 
<?php if($_SESSION["tipo_cuenta"] != 4) { 

if(Helpers::ServerDomain() == FALSE and $_SESSION["root_plataforma"] == 0) {
?>
<li><a href="?respaldos" class="collapsible-header waves-effect arrow-r"><i class="fas fa-download"></i> RESPALDOS </a></li>
<?php } } ?>
 -->






<?php if($_SESSION["tipo_cuenta"] == 1 or $_SESSION["tipo_cuenta"] == 2 or $_SESSION["tipo_cuenta"] == 5) { ?>
<li><a class="collapsible-header waves-effect arrow-r"><i class="fab fa-product-hunt"></i> PRODUCTOS<i class="fas fa-angle-down rotate-icon"></i></a>
<div class="collapsible-body">
<ul class="list-unstyled">

<li><a href="?inventario" class="waves-effect">Inventario</a></li>

<?php 
if((Helpers::ServerDomain() == FALSE and $_SESSION["root_plataforma"] == 0) or (Helpers::ServerDomain() == TRUE and $_SESSION["root_plataforma"] == 1)) {
 ?>
<li><a href="?addpro" class="waves-effect">Agregar Producto</a></li>
<li><a href="?averias" class="waves-effect">Agregar Averias</a></li>
<li><a href="?producto&x=3" class="waves-effect">Gestionar Producto</a></li>
<?php } ?>
</ul>
</div>
</li>
<?php } ?>









<?php if($_SESSION["root_tipo_sistema"] == 3) {  /// planilla

if($_SESSION["tipo_cuenta"] == 1 or $_SESSION["tipo_cuenta"] == 2 or $_SESSION["tipo_cuenta"] == 5) {
?>

<li><a class="collapsible-header waves-effect arrow-r"><i class="fas fa-user-alt"></i> PLANILLA<i class="fa fa-angle-down rotate-icon"></i></a>
<div class="collapsible-body">
<ul class="list-unstyled">
<li><a href="?planillasver" class="waves-effect"><i class="fas fa-search"></i> Ver Planillas</a></li>
<li><a href="?addempleado" class="waves-effect"><i class="fas fa-user"></i> Agrega Empleado</a></li>
<li><a href="?verempleado" class="waves-effect"><i class="fas fa-barcode"></i> Ver Empleados</a></li>
<li><a href="?descuentos" class="waves-effect"><i class="fas fa-search"></i> Aplicar Descuentos</a></li>

</ul>
</div>
</li>

<?php } } ?>




<?php if($_SESSION["tipo_cuenta"] == 1 or $_SESSION["tipo_cuenta"] == 2 or $_SESSION["tipo_cuenta"] == 3 or $_SESSION["tipo_cuenta"] == 5) {
	?>

<li><a class="collapsible-header waves-effect arrow-r"><i class="far fa-user"></i> CLIENTES<i class="fa fa-angle-down rotate-icon"></i></a>
<div class="collapsible-body">
<ul class="list-unstyled">

<li><a href="?clienteadd" class="waves-effect"><i class="fas fa-user"></i> Agrega Cliente</a></li>
<li><a href="?clientever" class="waves-effect"><i class="fas fa-address-book"></i> Ver Cliente</a></li>

</ul>
</div>
</li>


<?php } ?>













<?php if($_SESSION["tipo_cuenta"] == 1 or $_SESSION["tipo_cuenta"] == 2 or $_SESSION["tipo_cuenta"] == 3 or $_SESSION["tipo_cuenta"] == 5) { ?>
<li><a class="collapsible-header waves-effect arrow-r"><i class="fas fa-compress-arrows-alt"></i> OPCIONES<i class="fas fa-angle-down rotate-icon"></i></a>
<div class="collapsible-body">
<ul class="list-unstyled">
 
<?php if($_SESSION["tipo_cuenta"] == 1 or $_SESSION["tipo_cuenta"] == 5) { 
?>

<li><a id="cambiar-pantalla-inicio" op="88" class="collapsible-header waves-effect arrow-r"> Abrir Caja Dinero</a></li>

<li><a href="?ctc" class="collapsible-header waves-effect arrow-r"> Cambiar Cuenta</a></li>

<?php } 

if((Helpers::ServerDomain() == FALSE and $_SESSION["root_plataforma"] == 0) or (Helpers::ServerDomain() == TRUE and $_SESSION["root_plataforma"] == 1)) {

if($_SESSION['root_tipo_sistema'] != 1){ 
 ?>
<li><a id="cambiar-pantalla-inicio" op="26" class="collapsible-header waves-effect arrow-r"> Cambiar Inicio </a></li>
<?php }

if($_SESSION['config_cambio_tx'] != NULL){ ?>
<li><a id="cambiar-pantalla-inicio" op="27" class="collapsible-header waves-effect arrow-r"> Cambiar Opci&oacuten </a></li>

<?php } ?>
<?php 
if($_SESSION["tipo_cuenta"] == 1 or $_SESSION["tipo_cuenta"] == 2 or $_SESSION["tipo_cuenta"] == 5){

if($_SESSION["muestra_vender"] == NULL) $nf="Mostrar Facturar";
else $nf="Mostrar Panel Inicio";
echo '<li><a id="cambiar-pantalla-inicio" op="27x" class="collapsible-header waves-effect arrow-r"> '.$nf.' </a></li>';

} }
?>

</ul>
</div>
</li>
<?php } ?>



<?php if($_SESSION["tipo_cuenta"] == 1 or $_SESSION["tipo_cuenta"] == 2 or $_SESSION["tipo_cuenta"] == 3 or $_SESSION["tipo_cuenta"] == 5) {
 ?>

<li><a class="collapsible-header waves-effect arrow-r"><i class="fas fa-user-alt"></i> PROVEEDORES<i class="fa fa-angle-down rotate-icon"></i></a>
<div class="collapsible-body">
<ul class="list-unstyled">

<li><a href="?proveedoradd" class="waves-effect"><i class="fas fa-user"></i> Agrega Proveedor</a></li>
<li><a href="?proveedorver" class="waves-effect"><i class="fas fa-barcode"></i> Ver Proveedores</a></li>

</ul>
</div>
</li>

<?php } ?>






<?php if($_SESSION["tipo_cuenta"] == 1 or $_SESSION["tipo_cuenta"] == 2 or $_SESSION["tipo_cuenta"] == 5) {

if((Helpers::ServerDomain() == FALSE and $_SESSION["root_plataforma"] == 0) or (Helpers::ServerDomain() == TRUE and $_SESSION["root_plataforma"] == 1)) {
?>
<li><a class="collapsible-header waves-effect arrow-r"><i class="fas fa-money-bill-alt"></i> CUENTAS POR PAGAR<i class="fa fa-angle-down rotate-icon"></i></a>
<div class="collapsible-body">
<ul class="list-unstyled">

<li><a href="?cuentas" class="waves-effect"><i class="fas fa-money-bill-alt"></i> Ver todas las cuentas</a></li>
</ul>
</div>
</li>
<?php } } ?>





<?php 
if((Helpers::ServerDomain() == FALSE and $_SESSION["root_plataforma"] == 0) or (Helpers::ServerDomain() == TRUE and $_SESSION["root_plataforma"] == 1)) {
 ?>

<li><a class="collapsible-header waves-effect arrow-r"><i class="fas fa-cogs"></i> CONFIGURACIONES<i class="fas fa-angle-down rotate-icon"></i></a>
<div class="collapsible-body">
<ul class="list-unstyled">

<li><a href="?user" class="collapsible-header waves-effect arrow-r"> Usuarios </a></li>
<?php 
if($_SESSION["tipo_cuenta"] == 1 or $_SESSION["tipo_cuenta"] == 2 or $_SESSION["tipo_cuenta"] == 5) { 
 
 ?>
<li><a href="?iconos" class="waves-effect">Iconos</a></li>
<li><a href="?precios" class="waves-effect">Precios y Opciones</a></li>
<?php if($_SESSION["tipo_cuenta"] == 1 or $_SESSION["tipo_cuenta"] == 5 or $_SESSION["tipo_cuenta"] == 2) { ?>                        
<li><a href="?configuraciones" class="waves-effect">Configuraciones</a></li>
<li><a href="?tablas" class="waves-effect">Tablas Sync</a></li>
<?php } ?>

<li><a href="?venta_especial" class="waves-effect">Venta Especial</a></li>
<?php if($_SESSION["tipo_cuenta"] == 1) { ?>
<li><a href="?root" class="waves-effect">Configuracion Root</a></li>
<li><a href="?conf_factura" class="waves-effect">Configuracion Facturas</a></li>
<li><a href="?codigos" class="waves-effect">C&oacutedigos de validaci&oacuten</a></li>
<?php } } ?>
</ul>
</div>
</li>
<?php }  ?>



<?php // solo si es local pero se visualia en la web
if(Helpers::ServerDomain() == TRUE and $_SESSION["root_plataforma"] == 0) {
 ?>

<li><a class="collapsible-header waves-effect arrow-r"><i class="fas fa-cogs"></i> CONFIGURACIONES<i class="fas fa-angle-down rotate-icon"></i></a>
<div class="collapsible-body">
<ul class="list-unstyled">

<li><a href="?user" class="collapsible-header waves-effect arrow-r"> Usuarios </a></li>
</ul>
</div>
</li>
<?php }  ?>



<?php 
if($_SESSION["config_o_ticket_pantalla"] == 1){

if((Helpers::ServerDomain() == FALSE and $_SESSION["root_plataforma"] == 0) or (Helpers::ServerDomain() == TRUE and $_SESSION["root_plataforma"] == 1)) {
 ?>

<li><a href="?tv" class="collapsible-header waves-effect arrow-r"><i class="fas fa-tv"></i> VER PANTALLA </a></li>

<?php }

}

 ?>


<li><a href="application/includes/logout.php" class="collapsible-header waves-effect arrow-r"><i class="fas fa-power-off"></i> SALIR </a></li>


</ul>
</li>