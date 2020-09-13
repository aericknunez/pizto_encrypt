$(document).ready(function(){

		$('.datepicker').pickadate({
		  weekdaysShort: ['Do', 'Lu', 'Ma', 'Mi', 'Ju', 'Vi', 'Sa'],
		  weekdaysFull: ['Domingo', 'Lunes', 'Martes', 'Miercoles', 'Jueves', 'Viernes', 'Sabado'],
		  monthsFull: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre',
		  'Noviembre', 'Diciembre'],
		  monthsShort: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct',
		  'Nov', 'Dic'],
		  showMonthsShort: true,
		  formatSubmit: 'dd-mm-yyyy',
		  close: 'Cancelar',
		  clear: 'Limpiar',
		  today: 'Hoy'
		})



	$('#btn-addempleado').click(function(e){ /// para el formulario
	e.preventDefault();
	$.ajax({
			url: "application/src/routes.php?op=300",
			method: "POST",
			data: $("#form-addempleado").serialize(),
			success: function(data){
				$("#form-addempleado").trigger("reset");
				$("#contenido").html(data);			

			}
		})
	})
    


	$("#form-addempleado").keypress(function(e) {//Para deshabilitar el uso de la tecla "Enter"
	if (e.which == 13) {
	return false;
	}
	});



	$("body").on("click","#delempleado",function(){ // borrar categoria
	var op = $(this).attr('op');
	var hash = $(this).attr('hash');
	var dir = $(this).attr('dir');
	    $.post("application/src/routes.php", {op:op, hash:hash, dir:dir}, function(data){
		$("#contenido").html(data);
		$('#ConfirmDelete').modal('hide');
	   	 });
	});


////////////////
	$('#btn-editempleado').click(function(e){ /// actualizar empleado
	e.preventDefault();
	$.ajax({
			url: "application/src/routes.php?op=304",
			method: "POST",
			data: $("#form-editempleado").serialize(),
			success: function(data){
				$("#form-editempleado").trigger("reset");
				$("#contenido").html(data);			
			}
		})
	})
    



	$("#form-editempleado").keypress(function(e) {//Para deshabilitar el uso de la tecla "Enter"
	if (e.which == 13) {
	return false;
	}
	});



/// llamar modal ver
	$("body").on("click","#xver",function(){ 
		
		$('#ModalVerEmpleado').modal('show');
		
		var key = $(this).attr('key');
		var op = $(this).attr('op');
		var dataString = 'op='+op+'&key='+key;

		$.ajax({
            type: "POST",
            url: "application/src/routes.php",
            data: dataString,
            beforeSend: function () {
               $("#vista").html('<div class="row justify-content-md-center" ><img src="assets/img/load.gif" alt=""></div>');
            },
            success: function(data) {            
                $("#vista").html(data); // lo que regresa de la busquea 		
            }
        });

		$('#btn-pro').attr("href",'?modal=editempleado&key='+key);
		
	});



///////////// llamar modal para eliminar elemento
	$("body").on("click","#xdelete",function(){ 
		
		var op = $(this).attr('op');
		var hash = $(this).attr('hash');
		var dir = $(this).attr('dir');
		
		$('#delempleado').attr("op",op).attr("hash",hash).attr("dir",dir);
		$('#ConfirmDelete').modal('show');
	});





/// llamar modal extras
	$("body").on("click","#extras",function(){ 
		
		$('#ModalExtra').modal('show');
		
		var key = $(this).attr('key');

		$('#eempleado').attr("value",key); // asigna el value a id de empleado para form extra
		$('#aempleado').attr("value",key); // asigna el value a id de empleado para form adelanto
		$('#dempleado').attr("value",key); // asigna el value a id de empleado para form descuento
		$('#verextras').attr("key",key);
		
	});



/// llamar modal todas las extras
	$("body").on("click","#verextras",function(){ 
		
		$('#ModalExtra').modal('hide');
		$('#ModalVerExtras').modal('show');

		var key = $(this).attr('key');
		var op = "306";
		var dataString = 'op='+op+'&key='+key;

		$.ajax({
            type: "POST",
            url: "application/src/routes.php",
            data: dataString,
            beforeSend: function () {
               $("#vista-extras").html('<div class="row justify-content-md-center" ><img src="assets/img/load.gif" alt=""></div>');
            },
            success: function(data) {            
                $("#vista-extras").html(data); // lo que regresa de la busquea 		
            }
        });

	});



	$("body").on("click","#dextra",function(){ // borrar extra
	var op = $(this).attr('op');
	var key = $(this).attr('key');
	var empleado = $(this).attr('empleado');
	    $.post("application/src/routes.php", {op:op, key:key, empleado:empleado}, function(data){
		$("#vista-extras").html(data);
	   	 });
	});





	$('#btn-extra').click(function(e){ /// para el formulario
	e.preventDefault();
	$.ajax({
			url: "application/src/routes.php?op=305",
			method: "POST",
			data: $("#form-extra").serialize(),
			success: function(data){
				$("#form-extra").trigger("reset");
				$("#vista-extra").html(data);			

			}
		})
	})
  
  	$('#btn-adelantos').click(function(e){ /// para el formulario
	e.preventDefault();
	$.ajax({
			url: "application/src/routes.php?op=305",
			method: "POST",
			data: $("#form-adelantos").serialize(),
			success: function(data){
				$("#form-adelantos").trigger("reset");
				$("#vista-adelantos").html(data);			

			}
		})
	})

  	$('#btn-descuentos').click(function(e){ /// para el formulario
	e.preventDefault();
	$.ajax({
			url: "application/src/routes.php?op=305",
			method: "POST",
			data: $("#form-descuentos").serialize(),
			success: function(data){
				$("#form-descuentos").trigger("reset");
				$("#vista-descuentos").html(data);			

			}
		})
	})








///////////// llamar modal para aplicar planilla 
	$("body").on("click","#aplicar",function(){ 
		
		var hash = $(this).attr('hash');


		$('#apliempleado').attr("value",hash); // asigna el value a id de empleado para form extra
		$('#ModalAplicar').modal('show');
	});



	$('#btn-fechas').click(function(e){ /// para el formulario fechas
	e.preventDefault();
	$.ajax({
			url: "application/src/routes.php?op=308",
			method: "POST",
			data: $("#form-fechas").serialize(),
			success: function(data){
				$("#form-fechas").trigger("reset");
				$("#contenido").html(data);			

			}
		})
			$('#ModalAplicar').modal('hide');
	})
    


	$("#form-fechas").keypress(function(e) {//Para deshabilitar el uso de la tecla "Enter"
	if (e.which == 13) {
	return false;
	}
	});










	$('#btn-adddescuento').click(function(e){ /// para el formulario fechas
	e.preventDefault();
	$.ajax({
			url: "application/src/routes.php?op=309",
			method: "POST",
			data: $("#form-adddescuento").serialize(),
			success: function(data){
				$("#form-adddescuento").trigger("reset");
				$("#contenido").html(data);			
				$("#select-descuento").load('application/src/routes.php?op=311'); // para recargar descuentos
			}
		})
	})
    


	$("#form-adddescuento").keypress(function(e) {//Para deshabilitar el uso de la tecla "Enter"
	if (e.which == 13) {
	return false;
	}
	});






///////////// llamar modal para eliminar descuento
	$("body").on("click","#xdeleted",function(){ 
		
		var op = $(this).attr('op');
		var hash = $(this).attr('hash');
		var dir = $(this).attr('dir');
		
		$('#deldescuento').attr("op",op).attr("hash",hash).attr("dir",dir);
		$('#ConfirmDelete').modal('show');
	});




	$("body").on("click","#deldescuento",function(){ // borrar categoria
	var op = $(this).attr('op');
	var hash = $(this).attr('hash');
	    $.post("application/src/routes.php", {op:op, hash:hash}, function(data){
		$("#contenido").html(data);
		$('#ConfirmDelete').modal('hide');
		$("#select-descuento").load('application/src/routes.php?op=311'); // para recargar descuentos
	   	 });
	});


//////////////////
	$('#btn-asignardescuento').click(function(e){ /// para el formulario asignar descuento
	e.preventDefault();
	$.ajax({
			url: "application/src/routes.php?op=312",
			method: "POST",
			data: $("#form-asignardescuento").serialize(),
			success: function(data){
				$("#form-asignardescuento").trigger("reset");
				$("#contenidoasig").html(data);			
			}
		})
	})
    


	$("#form-asignardescuento").keypress(function(e) {//Para deshabilitar el uso de la tecla "Enter"
	if (e.which == 13) {
	return false;
	}
	});




	$("body").on("click","#xdeletea",function(){ 
		
		var op = $(this).attr('op');
		var hash = $(this).attr('hash');

		$('#deldescuentoasig').attr("op",op).attr("hash",hash);
		$('#ConfirmDeleteAsig').modal('show');
	});

	$("body").on("click","#deldescuentoasig",function(){ // borrar categoria
	var op = $(this).attr('op');
	var hash = $(this).attr('hash');
	    $.post("application/src/routes.php", {op:op, hash:hash}, function(data){
		$("#contenidoasig").html(data);
		$('#ConfirmDeleteAsig').modal('hide');
		$("#select-descuento").load('application/src/routes.php?op=311'); // para recargar descuentos
	   	 });
	});





// para imprimir la boleta
    $('#imprimir').on("click", function () {
      $('#vista').printThis({
        importCSS: false,
        loadCSS: ["http://localhost/cozto/assets/css/font-awesome-582.css",
        		"http://localhost/cozto/assets/css/bootstrap.min.css"],
        removeScripts: true,
         base: false
      });
    });








}); // termina query