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
    







//// modal icono
	$("body").on("click","#c_icono",function(){ 

		$('#ModalIconos').modal('show');
		var cod = $(this).attr('cod');
		var pro = $(this).attr('pro');
		var img = $(this).attr('img');

		$("#pro_ic").html('<h3 class="row justify-content-md-center" >'+pro+'</h3>');
		$("#img-ico").html('<img src="'+img+'" alt="Icono del producto" class="img-fluid">');
		$("#codigo").attr("value",cod);

		$("#vericonos").attr("codigox",cod); // boton

	});
    


//////agregar imagen
    $("#btn-img").click(function (event) {
        event.preventDefault();
        var form = $('#form-img')[0];
        var data = new FormData(form);
        var iden = $(this).attr('codigo');

        $.ajax({
            type: "POST",
            enctype: 'multipart/form-data',
            url: "application/src/routes.php?op=315",
            data: data,
            processData: false,
            contentType: false,
            cache: false,
            timeout: 600000,
            beforeSend: function () {
                $('#btn-img').html('<span class="spinner-border spinner-border-sm mr-2" role="status" aria-hidden="true"></span>Loading...').addClass('disabled');
            },
            success: function (data) {
                $('#btn-img').html('Subir Imagen').removeClass('disabled');
                $("#form-img").trigger("reset");
                $("#precio_ver").html(data);
            },
        });
        $('#ModalIconos').modal('hide');
    });



//// modal icono
	$("body").on("click","#vericonos",function(){ 

		$('#ModalIconosTodos').modal('show');
		$('#ModalIconos').modal('hide');
		var cod = $(this).attr("codigox");

		$("a").attr("codigos", cod);

	});
    



	$("body").on("click","#cambioimg",function(){ 

		var codigos = $(this).attr('codigos');
		var imagen = $(this).attr('imagen');
		var dataString = 'op=316&codigos='+codigos+'&imagen='+imagen;

		$.ajax({
            type: "POST",
            url: "application/src/routes.php",
            data: dataString,
            success: function(data) {            
                $("#precio_ver").html(data); 		
            }
        });
         $('#ModalIconosTodos').modal('hide');
	});
    









});
