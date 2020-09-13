$(document).ready(function()
{
	$('#btn-config').click(function(e){ /// para el formulario
		e.preventDefault();
		$.ajax({
			url: "application/src/routes.php?op=90",
			method: "POST",
			data: $("#form-config").serialize(),
			success: function(data){
				$("#ventana").html(data);
				window.location.href="?configuraciones";
			}
		})
	})
$("#form-config").keypress(function(e) {//Para deshabilitar el uso de la tecla "Enter"
if (e.which == 13) {
return false;
}
});

	$('#btn-root').click(function(e){ /// para el formulario
		e.preventDefault();
		$.ajax({
			url: "application/src/routes.php?op=91",
			method: "POST",
			data: $("#form-root").serialize(),
			success: function(data){
				$("#ventana").html(data);
				window.location.href="?root";
			}
		})
	})
$("#form-root").keypress(function(e) {//Para deshabilitar el uso de la tecla "Enter"
if (e.which == 13) {
return false;
}
});





////////////////////////paginador 
	$("body").on("click","#paginador",function(){
	var op = $(this).attr('op');
	var iden = $(this).attr('iden');
    $.post("application/src/routes.php", {op:op, iden:iden}, function(htmlexterno){
	$("#productos").html(htmlexterno);
   	 });

	});

////////////////////////cambiar especial 
	$("body").on("click","#cambiar-especial",function(){
	var op = $(this).attr('op');
	var iden = $(this).attr('iden');
	var cod = $(this).attr('cod');
    $.post("application/src/routes.php", {op:op, iden:iden, cod:cod}, function(htmlexterno){
	$("#productos").html(htmlexterno);
   	 });

	});




	$('#btn-cuentas').click(function(e){ /// para el formulario
		e.preventDefault();
		$.ajax({
			url: "application/src/routes.php?op=128",
			method: "POST",
			data: $("#form-cuentas").serialize(),
			success: function(data){
				$("#cuentas").html(data);
				$("#form-cuentas").trigger("reset");
			}
		})
	})
$("#form-cuentas").keypress(function(e) {//Para deshabilitar el uso de la tecla "Enter"
if (e.which == 13) {
return false;
}
});


////////////////////////cambiar de sistema
	$("body").on("click","#irlocal",function(){
	var op = $(this).attr('op');
	var iden = $(this).attr('iden');
    $.post("application/src/routes.php", {op:op, iden:iden}, function(htmlexterno){
	$("#cuentas").html(htmlexterno);
   	 });
});


////////////////////////cambiar de sistema
	$("body").on("click","#predeterminar",function(){
	var op = $(this).attr('op');
	var iden = $(this).attr('iden');
    $.post("application/src/routes.php", {op:op, iden:iden}, function(htmlexterno){
	$("#cuentas").html(htmlexterno);
   	 });
});



    $("body").on("click","#tablemod",function(){
        var op = $(this).attr('op');
        var tabla = $(this).attr('tabla');
        var accion = $(this).attr('accion');
        var edo = $(this).attr('edo');
        var dataString = 'op='+op+'&tabla='+tabla+'&accion='+accion+'&edo='+edo;

        $.ajax({
            type: "POST",
            url: "application/src/routes.php",
            data: dataString,
            beforeSend: function () {
               $("#contenido").html('<div class="row justify-content-md-center" ><img src="assets/img/load.gif" alt=""></div>');
            },
            success: function(data) {            
                $("#contenido").html(data); // lo que regresa de la busquea 
            }
        });
    });      



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












});
