$(document).ready(function()
{




	$("body").on("click","#mensaje-borrar",function(){
	var op = $(this).attr('op');
	var iden = $(this).attr('iden');
    	$.post("application/src/routes.php", {op:op, iden:iden}, 
    	function(htmlexterno){
		$("#ventana").html(htmlexterno);
   	 	});
	});


	$("body").on("click","#eliminar-orden",function(){
	var op = $(this).attr('op');
	var iden = $(this).attr('iden');
    	$.post("application/src/routes.php", {op:op, iden:iden}, 
    	function(htmlexterno){
		$("#ventana").html(htmlexterno);
   	 	});
	});

	$("body").on("click","#mensaje-cancelar",function(){
	var op = $(this).attr('op');
	var iden = $(this).attr('iden');
    	$.post("application/src/routes.php", {op:op, iden:iden}, 
    	function(htmlexterno){
		$("#ventana").html(htmlexterno);
   	 	});
	});

	$("body").on("click","#cancelar-factura",function(){
	var op = $(this).attr('op');
	var iden = $(this).attr('iden');
    	$.post("application/src/routes.php", {op:op, iden:iden}, 
    	function(htmlexterno){
		$("#ventana").html(htmlexterno);
   	 	});
	});



	$("body").on("click","#mensaje-pasar",function(){
	var op = $(this).attr('op');
	var iden = $(this).attr('iden');
    	$.post("application/src/routes.php", {op:op, iden:iden}, 
    	function(htmlexterno){
		$("#ventana").html(htmlexterno);
   	 	});
	});

	$("body").on("click","#pasar-factura",function(){
	var op = $(this).attr('op');
	var iden = $(this).attr('iden');
    	$.post("application/src/routes.php", {op:op, iden:iden}, 
    	function(htmlexterno){
		$("#ventana").html(htmlexterno);
   	 	});
	});



		$("body").on("click","#imprimir-factura",function(){
	var op = $(this).attr('op');
	var factura = $(this).attr('factura');
    	$.post("application/src/routes.php", {op:op, factura:factura}, 
    	function(htmlexterno){
		$("#ventana").html(htmlexterno);
   	 	});
	});



	// cargarIconos();
	// function cargarIconos(){
	// 	$.ajax({
	// 		url: 'application/src/routes.php?op=47',
	// 		method: 'POST',
	// 		success: function(data){
	// 			$('#iconos').html(data);
	// 		}
	// 	})
	// }


	// $('#btn_send_factura').click(function(e){ /// para el formulario
	// 	e.preventDefault();
	// 	$.ajax({
	// 		url: "application/src/routes.php?op=21",
	// 		method: "POST",
	// 		data: $("#form_send_factura").serialize(),
	// 		success: function(data){
	// 			//$("#lateral").load('application/src/routes.php?op=22');
	// 			$("#lateral").html(htmlexterno);
	// 		}
	// 	})
	// })


 //    $("#contenido_clientes").show();
 //    $("#contenido_paginador").hide();
 //    $("#contenido_paginador").load('application/src/routes.php?op=14&iden=1');
	// $("#contenido_clientes").html(htmlexterno);

});