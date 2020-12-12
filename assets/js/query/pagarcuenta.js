$(document).ready(function()
{

	$("body").on("click","#cliente-facturar",function(){
	var op = $(this).attr('op');
	var mesa = $(this).attr('mesa');
	var cliente = $(this).attr('cliente');
    	$.post("application/src/routes.php", {op:op, mesa:mesa, cliente:cliente}, 
    	function(htmlexterno){
		$("#origen").load('application/src/routes.php?op=54');
		$("#destino").html(htmlexterno);
   	 	});
	});





});