$(document).ready(function()
{


	$("body").on("click","#ver-producto",function(){ // ver los productos de la factura
	var op = $(this).attr('op');
	var iden = $(this).attr('iden');
	var cod = $(this).attr('cod');
	var mesa = $(this).attr('mesa');
	var cliente = $(this).attr('cliente');
    	$.post("application/src/routes.php", {op:op, iden:iden, cod:cod, mesa:mesa, cliente:cliente}, 
    	function(htmlexterno){
		$("#destino").html(htmlexterno);
   	 	});
	});


	$("body").on("click","#borrar-opcion",function(){ // borra la opcion
	var op = $(this).attr('op');
	var cod = $(this).attr('cod');
	var iden = $(this).attr('iden');
	var mesa = $(this).attr('mesa');
	var activo = $(this).attr('activo');
	var cliente = $(this).attr('cliente');
    	$.post("application/src/routes.php", {op:op, cod:cod, iden:iden, mesa:mesa, activo:activo, cliente:cliente}, 
    	function(htmlexterno){
		$("#destino").html(htmlexterno);
   	 	});
	});


	$("body").on("click","#modificar-opcion",function(){ // muestra las opcines del produ
	var op = $(this).attr('op');
	var cod = $(this).attr('cod');
	var iden = $(this).attr('iden');
	var opcion = $(this).attr('opcion');
	var mesa = $(this).attr('mesa');
	var activo = $(this).attr('activo');
	var cliente = $(this).attr('cliente');
    	$.post("application/src/routes.php", {op:op, cod:cod, iden:iden, 
    		opcion:opcion, mesa:mesa, activo:activo, cliente:cliente}, 
    	function(htmlexterno){
		$("#destino").html(htmlexterno);
   	 	});
	});


	$("body").on("click","#ejecutar-modificar-opcion",function(){ // modificar o eliminar
	var op = $(this).attr('op');
	var cod = $(this).attr('cod');
	var iden = $(this).attr('iden');
	var opcion = $(this).attr('opcion');
	var mesa = $(this).attr('mesa');
	var activo = $(this).attr('activo');
	var cambio = $(this).attr('cambio');
	var cliente = $(this).attr('cliente');
    	$.post("application/src/routes.php", {op:op, cod:cod, iden:iden, 
    		opcion:opcion, mesa:mesa, activo:activo, cambio:cambio, cliente:cliente}, 
    		function(htmlexterno){
		$("#destino").html(htmlexterno);
   	 	});
	});


	$("body").on("click","#agregar-opcion",function(){ // para ver el listado de opciones
	var op = $(this).attr('op');
	var cod = $(this).attr('cod');
	var iden = $(this).attr('iden');
	var mesa = $(this).attr('mesa');
	var cliente = $(this).attr('cliente');
    	$.post("application/src/routes.php", {op:op, cod:cod, iden:iden, mesa:mesa, cliente:cliente}, 
    		function(htmlexterno){
		$("#destino").html(htmlexterno);
   	 	});
	});


	$("body").on("click","#ver-sub-opcion",function(){ // muestra las sub opciones
	var op = $(this).attr('op');
	var cod = $(this).attr('cod');
	var opcion = $(this).attr('opcion');
	var iden = $(this).attr('iden');
	var mesa = $(this).attr('mesa');
	var cliente = $(this).attr('cliente');
    	$.post("application/src/routes.php", {op:op, cod:cod, opcion:opcion, iden:iden, mesa:mesa, cliente:cliente}, 
    		function(htmlexterno){
		$("#destino").html(htmlexterno);
   	 	});
	});

	$("body").on("click","#ejecutar-agregar-opcion",function(){ // agrega la opciones
	var op = $(this).attr('op');
	var cod = $(this).attr('cod');
	var opcion = $(this).attr('opcion');
	var iden = $(this).attr('iden');
	var mesa = $(this).attr('mesa');
	var cliente = $(this).attr('cliente');
    	$.post("application/src/routes.php", {op:op, cod:cod, opcion:opcion, iden:iden, mesa:mesa, cliente:cliente}, 
    		function(htmlexterno){
		$("#destino").html(htmlexterno);
   	 	});
	});






});