$(document).ready(function()
{

$(function () {
  $('[data-toggle="tooltip"]').tooltip()
})


//// precios
    $("body").on("click","#c_precio",function(){ 

			var cod = $(this).attr('cod');
			var precio = $(this).attr('pre');
			var pro = $(this).attr('pro');
        
        $('#ModalCambiarPrecio').modal('show');
        $('#cod').attr("value",cod);
        $('#precio').attr("value",precio);
        $("#pro").html('<h3 class="row justify-content-md-center" >'+pro+'</h3>');
            
    });

/// cambia precio
	$('#btn-precio').click(function(e){ /// para el formulario
		e.preventDefault();
		$.ajax({
			url: "application/src/routes.php?op=3",
			method: "POST",
			data: $("#form-precio").serialize(),
			beforeSend: function () {
			$('#btn-precio').html('<span class="spinner-border spinner-border-sm mr-2" role="status" aria-hidden="true"></span>Loading...').addClass('disabled');
        	},
			success: function(data){
				$('#btn-precio').html('Registrar').removeClass('disabled');
				$("#precio_ver").html(data);
				$("#form-precio").trigger("reset");
				$('#ModalCambiarPrecio').modal('hide');
			}
		})
	})
$("#form-precio").keypress(function(e) {//Para deshabilitar el uso de la tecla "Enter"
if (e.which == 13) {
return false;
}
});






//// opciones
	$("body").on("click","#c_opciones",function(){ 

		$('#ModalOpciones').modal('show');
		var cod = $(this).attr('cod');
		var pro = $(this).attr('pro');

		$("#pro_op").html('<h3 class="row justify-content-md-center" >'+pro+'</h3>');

		var dataString = 'op=118&cod='+cod;

		$.ajax({
            type: "POST",
            url: "application/src/routes.php",
            data: dataString,
            beforeSend: function () {
               $("#vista_opciones").html('<div class="row justify-content-center" ><img src="assets/img/loa.gif" alt=""></div>');
            },
            success: function(data) {            
                $("#vista_opciones").html(data); // lo que regresa de la busquea 		
            }
        });
	});
    




//// opciones
	$("body").on("click","#cambiarop",function(){ 

		var opcion = $(this).attr('opcion');
		var producto = $(this).attr('producto');
		var tipo = $(this).attr('tipo');
		var dataString = 'op=119&opcion='+opcion+'&producto='+producto+'&tipo='+tipo;

		$.ajax({
            type: "POST",
            url: "application/src/routes.php",
            data: dataString,
            beforeSend: function () {
               $("#vista_opciones").html('<div class="row justify-content-center" ><img src="assets/img/loa.gif" alt=""></div>');
            },
            success: function(data) {            
                $("#vista_opciones").html(data); // lo que regresa de la busquea 		
            }
        });
	});
    












});
