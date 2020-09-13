$(document).ready(function()
{

	$("body").on("click","#cambiar",function(){
	var op = $(this).attr('op');
    	$.post("application/src/routes.php", {op:op}, 
    	function(htmlexterno){
		$("#numero").html(htmlexterno);
   	 	});
	});


	$("body").on("click","#ventaopcion",function(){
	var op = $(this).attr('op');
	var cod = $(this).attr('cod');
	var mesa = $(this).attr('mesa');
	var cliente = $(this).attr('cliente');
	var opcion = $(this).attr('opcion');
    	$.post("application/src/routes.php", {op:op, cod:cod, mesa:mesa, cliente:cliente, opcion:opcion}, 
    	function(htmlexterno){
		window.location.href="?";
   	 	});
	});



 //    $("#contenido_clientes").show();
 //    $("#contenido_paginador").hide();
 //    $("#contenido_paginador").load('application/src/routes.php?op=14&iden=1');
	// $("#contenido_clientes").html(htmlexterno);

});