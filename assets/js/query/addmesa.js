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



	$('#btn-addmesa').click(function(e){ /// agregar un producto 
	e.preventDefault();
	$.ajax({
			url: "application/src/routes.php?op=42",
			method: "POST",
			data: $("#form-addmesa").serialize(),
			beforeSend: function () {
				$('#btn-addmesa').html('<span class="spinner-border spinner-border-sm mr-2" role="status" aria-hidden="true"></span>Loading...').addClass('disabled');
	           // $("#contenido").html('<div class="row justify-content-md-center" ><img src="assets/img/load.gif" alt=""></div>');
            },
			success: function(data){
				$('#btn-addmesa').html('Aceptar').removeClass('disabled');	      
				$("#form-addmesa").trigger("reset");
				$("#contenido").html(data);	
			}
		})
	});
    



 //    $("#contenido_clientes").show();
 //    $("#contenido_paginador").hide();
 //    $("#contenido_paginador").load('application/src/routes.php?op=14&iden=1');
	// $("#contenido_clientes").html(htmlexterno);

});