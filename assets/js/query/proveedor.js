$(document).ready(function(){

	$('#btn-addproveedor').click(function(e){ /// para el formulario
	$('#btn-addproveedor').addClass('disabled');
	e.preventDefault();
	$.ajax({
			url: "application/src/routes.php?op=190",
			method: "POST",
			data: $("#form-addproveedor").serialize(),
			beforeSend: function () {
				$('#btn-addproveedor').html('<span class="spinner-border spinner-border-sm mr-2" role="status" aria-hidden="true"></span>Loading...').addClass('disabled');
	         },
			success: function(data){
				$('#btn-addproveedor').html('Guardar').removeClass('disabled');
				$("#form-addproveedor").trigger("reset");
				$("#destinoproveedor").html(data);			
			}
		})
	})
    



	$("#form-addproveedor").keypress(function(e) {//Para deshabilitar el uso de la tecla "Enter"
	if (e.which == 13) {
	return false;
	}
	});



	$("body").on("click","#delproveedor",function(){ // borrar categoria
	var op = $(this).attr('op');
	var hash = $(this).attr('hash');
	    $.post("application/src/routes.php", {op:op, hash:hash}, function(data){
		$("#destinoproveedor").html(data);
		$('#ConfirmDelete').modal('hide');
	   	 });
	});


////////////////
	$('#btn-editproveedor').click(function(e){ /// actualizar proveedor
	$('#btn-editproveedor').addClass('disabled');
	e.preventDefault();
	$.ajax({
			url: "application/src/routes.php?op=193",
			method: "POST",
			data: $("#form-editproveedor").serialize(),
			beforeSend: function () {
				$('#btn-editproveedor').html('<span class="spinner-border spinner-border-sm mr-2" role="status" aria-hidden="true"></span>Loading...').addClass('disabled');
	         },
			success: function(data){
				$('#btn-editproveedor').html('Guardar').removeClass('disabled');
				$("#form-editproveedor").trigger("reset");
				$("#destinoproveedor").html(data);			
				setTimeout(BotonEnable, 1000); // para desactivar elboton por un rato
			}
		})
	})
    


	$("#form-editproveedor").keypress(function(e) {//Para deshabilitar el uso de la tecla "Enter"
	if (e.which == 13) {
	return false;
	}
	});




/// llamar modal ver
	$("body").on("click","#xver",function(){ 
		
		$('#ModalVerProveedor').modal('show');
		
		var key = $(this).attr('key');
		var op = $(this).attr('op');
		var dataString = 'op='+op+'&key='+key;

		$.ajax({
            type: "POST",
            url: "application/src/routes.php",
            data: dataString,
            beforeSend: function () {
               $("#vista").html('<div class="row justify-content-center" ><img src="assets/img/loa.gif" alt=""></div>');
            },
            success: function(data) {            
                $("#vista").html(data); // lo que regresa de la busquea 		
            }
        });

		$('#btn-pro').attr("href",'?modal=editproveedor&key='+key);
		
	});






///////////// llamar modal para eliminar elemento
	$("body").on("click","#xdelete",function(){ 
		
		var op = $(this).attr('op');
		var hash = $(this).attr('hash');
		
		$('#delproveedor').attr("op",op).attr("hash",hash);
		$('#ConfirmDelete').modal('show');
	});







}); // termina query