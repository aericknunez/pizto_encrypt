$(document).ready(function()
{

	$("body").on("click","#venta-especial",function(){
	var op = $(this).attr('op');
	var cod = $(this).attr('cod');
	var mesa = $(this).attr('mesa');
	var cliente = $(this).attr('cliente');
    	$.post("application/src/routes.php", {op:op, cod:cod, mesa:mesa, cliente:cliente}, 
    	function(htmlexterno){
		$("#destino").load('application/src/routes.php?op=20z');
		//$("#destino").html(htmlexterno);
   	 	});
	});


	$("body").on("click","#borrar-especial",function(){
	var op = $(this).attr('op');
	var iden = $(this).attr('iden');
    	$.post("application/src/routes.php", {op:op, iden:iden}, 
    	function(htmlexterno){
		$("#destino").load('application/src/routes.php?op=20z');
		//$("#destino").html(htmlexterno);
   	 	});
	});




});