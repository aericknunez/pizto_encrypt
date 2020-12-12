$(document).ready(function()
{

	$("body").on("click","#select-cliente",function(){
	var op = $(this).attr('op');
	var cliente = $(this).attr('cliente');
    	$.post("application/src/routes.php", {op:op, cliente:cliente}, 
    	function(htmlexterno){
		$("#origen").load('application/src/routes.php?op=50');
		$("#destino").load('application/src/routes.php?op=51');
		$("#ventana").html(htmlexterno);
   	 	});
	});

	$("body").on("click","#asign-cliente",function(){
	var op = $(this).attr('op');
	var cliente = $(this).attr('cliente');
    	$.post("application/src/routes.php", {op:op, cliente:cliente}, 
    	function(htmlexterno){
		$("#origen").load('application/src/routes.php?op=50');
		$("#destino").load('application/src/routes.php?op=51');
		$("#ventana").html(htmlexterno);
   	 	});
	});





});