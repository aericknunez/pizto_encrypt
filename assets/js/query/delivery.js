$(document).ready(function()
{


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


///////////modal para agregar nuevo delivery
    $("body").on("click","#ndelivery",function(){ 
        
        $('#ModalVer').modal('show');
        
    });



/// nuevo cliente
   $("body").on("click","#ncliente",function(){ 
        
        $('#ModalVer').modal('hide');
        $('#ModalNliente').modal('show');
           
    });


/// addrepartidor
   $("body").on("click","#addrepartidor",function(){ 
        
        $('#ModalOpciones').modal('hide');
        $('#ModalRepartidor').modal('show');
           
    });

   $("body").on("click","#nrepartidor",function(){ 
        
        $('#ModalRepartidor').modal('hide');
        $('#ModalNRepartidor').modal('show');
           
    });

///////////modal para agregar estado delivery
    $("body").on("click","#deliveryedo",function(){ 
        
        $('#ModalEstado').modal('show');

        var op = "407";
		var dataString = 'op='+op;
		$.ajax({
            type: "POST",
            url: "application/src/routes.php",
            data: dataString,
            beforeSend: function () {
               $("#vistaestado").html('<div class="row justify-content-md-center" ><img src="assets/img/load.gif" alt=""></div>');
            },
            success: function(data) {            
                $("#vistaestado").html(data); // lo que regresa de la busquea 		
            }
        });
        
    });



///////////modal para agregar nuevo delivery
    $("body").on("click","#opciones",function(){ 
        
        $('#ModalOpciones').modal('show');

        var mesa = $(this).attr('mesa');
        var hash = $(this).attr('hash');
		var op = "406";
		var dataString = 'op='+op+'&mesa='+mesa+'&hash='+hash;

		$.ajax({
            type: "POST",
            url: "application/src/routes.php",
            data: dataString,
            beforeSend: function () {
               $("#vistaopciones").html('<div class="row justify-content-md-center" ><img src="assets/img/load.gif" alt=""></div>');
            },
            success: function(data) {            
                $("#vistaopciones").html(data); // lo que regresa de la busquea 		
            }
        });
        
    });



	$('#btn-addcliente').click(function(e){ /// agregar un producto 
	e.preventDefault();
	$.ajax({
			url: "application/src/routes.php?op=400",
			method: "POST",
			data: $("#form-addcliente").serialize(),
			beforeSend: function () {
				$('#btn-addcliente').html('<span class="spinner-border spinner-border-sm mr-2" role="status" aria-hidden="true"></span>Loading...').addClass('disabled');
	           // $("#contenido").html('<div class="row justify-content-md-center" ><img src="assets/img/load.gif" alt=""></div>');
            },
			success: function(data){
				$('#btn-addcliente').html('Agregar Cliente').removeClass('disabled');	
				if(data){
					$("#vista").load('application/src/routes.php?op=402');
					$("#form-addcliente").trigger("reset");
				} else {
					$("#vista").html(data);
				}     		
			}
		})
	});
    



$("#form-addcliente").keypress(function(e) {//Para deshabilitar el uso de la tecla "Enter"
if (e.which == 13) {
return false;
}
});




//// cliente buesqueda
	$("#cliente-busqueda").keyup(function(){ /// para la caja de busqueda
		$.ajax({
		type: "POST",
		url: "application/src/routes.php?op=401",
		data:'keyword='+$(this).val(),
		beforeSend: function(){
			$("#muestra-busqueda").css("background","#FFF url(assets/img/LoaderIcon.gif) no-repeat 550px");
		},
		success: function(data){
			$("#muestra-busqueda").show();
			$("#muestra-busqueda").html(data);
			$("#cliente-busqueda").css("background","#FFF");
		}
		});
	});

$("#p-busqueda").keypress(function(e) {//Para deshabilitar el uso de la tecla "Enter"
if (e.which == 13) {
return false;
}
});



//////// cancel 
	$("body").on("click","#cancel-p",function(){
		$("#muestra-busqueda").hide();
		$("#p-busqueda").trigger("reset"); 
	});

////////////////

	$("body").on("click","#scliente",function(){
		var hash = $(this).attr('hash');
    	$.post("application/src/routes.php?op=402", {hash:hash}, 
    	function(data){
    		$("#muestra-busqueda").hide();
    		$('#ModalVer').modal('hide');
		    $("#p-busqueda").trigger("reset"); // no funciona
    		$("#vista").html(data); // lo que regresa de la busquea 
   	 	});
	});


	$("body").on("click","#continuar",function(){
		var hash = null;
    	$.post("application/src/routes.php?op=402", {hash:hash}, 
    	function(data){
    		$("#vista").html(data); // lo que regresa de la busquea 
   	 	});
	});







//////////////// agregar ususario a un delivery ya agregado
	$("#cliente-asig").keyup(function(){ /// para la caja de busqueda
		$.ajax({
		type: "POST",
		url: "application/src/routes.php?op=403",
		data:'keyword='+$(this).val(),
		beforeSend: function(){
			$("#muestra-asig").css("background","#FFF url(assets/img/LoaderIcon.gif) no-repeat 550px");
		},
		success: function(data){
			$("#muestra-asig").show();
			$("#muestra-asig").html(data);
			$("#cliente-asig").css("background","#FFF");
		}
		});
	});

	$("body").on("click","#clienteasig",function(){
		var hash = $(this).attr('hash');
    	$.post("application/src/routes.php?op=404", {hash:hash}, 
    	function(data){
    		$("#muestra-busqueda").hide();
    		$('#ModalVer').modal('hide');
		    $("#c-busqueda").trigger("reset"); // no funciona
    		$("#vista").html(data); // lo que regresa de la busquea 
   	 	});
	});

//////// cancel 
	$("body").on("click","#cancel-asig",function(){
		$("#muestra-asig").hide();
		$("#c-busqueda").trigger("reset"); 
	});



	$('#btn-addclienteasig').click(function(e){ /// agregar un producto 
	e.preventDefault();
	$.ajax({
			url: "application/src/routes.php?op=400",
			method: "POST",
			data: $("#form-addclienteasig").serialize(),
			beforeSend: function () {
				$('#btn-addclienteasig').html('<span class="spinner-border spinner-border-sm mr-2" role="status" aria-hidden="true"></span>Loading...').addClass('disabled');
	           // $("#contenido").html('<div class="row justify-content-md-center" ><img src="assets/img/load.gif" alt=""></div>');
            },
			success: function(data){
				$('#btn-addclienteasig').html('Agregar Cliente').removeClass('disabled');	
				if(data){
					$("#vista").load('application/src/routes.php?op=404');
					$("#form-addclienteasig").trigger("reset");
				} else {
					$("#vista").html(data);
				}     		
			}
		})
	});
    



$("#form-addclienteasig").keypress(function(e) {//Para deshabilitar el uso de la tecla "Enter"
if (e.which == 13) {
return false;
}
});


	$("body").on("click","#desvincular",function(){
		var hash = $(this).attr('hash');
    	$.post("application/src/routes.php?op=405", {hash:hash}, 
    	function(data){
    		$("#vista").html(data); // lo que regresa de la busquea 
   	 	});
	});




	$("body").on("click","#addedo",function(){
		var edo = $(this).attr('edo');
		var op = "408";
    	$.post("application/src/routes.php", {op:op, edo:edo}, 
    	function(data){
    		$("#vistaestado").html(data); // lo que regresa de la busquea 
    		$("#lateral").load('application/src/routes.php?op=22');
    		$("#edoiconos").load('application/src/routes.php?op=409'); // mostrar el mensaje de block segun edo
   	 	});
	});











/////////////////repartidor
//// cliente buesqueda
	$("#repartidor-busqueda").keyup(function(){ /// para la caja de busqueda
		$.ajax({
		type: "POST",
		url: "application/src/routes.php?op=410",
		data:'keyword='+$(this).val(),
		beforeSend: function(){
			$("#muestra-repartidor").css("background","#FFF url(assets/img/LoaderIcon.gif) no-repeat 550px");
		},
		success: function(data){
			$("#muestra-repartidor").show();
			$("#muestra-repartidor").html(data);
			$("#repartidor-busqueda").css("background","#FFF");
		}
		});
	});

$("#r-busqueda").keypress(function(e) {//Para deshabilitar el uso de la tecla "Enter"
if (e.which == 13) {
return false;
}
});



//////// cancel 
	$("body").on("click","#cancel-r",function(){
		$("#muestra-repartidor").hide();
		$("#r-busqueda").trigger("reset"); 
	});

////////////////

	$("body").on("click","#srepartidor",function(){ // seleccionar
		var hash = $(this).attr('hash');
		var mesa = $(this).attr('mesa');
    	$.post("application/src/routes.php?op=411", {hash:hash, mesa:mesa}, 
    	function(data){
    		$("#muestra-repartidor").hide();
    		$('#ModalRepartidor').modal('hide');
		    $("#r-busqueda").trigger("reset"); // no funciona
		    $("#ventana").html(data); // lo que regresa de la busquea 
   	 	});
	});




/// agregar repartidor
	$('#btn-addrepartidorasig').click(function(e){ /// agregar un producto 
	e.preventDefault();
	$.ajax({
			url: "application/src/routes.php?op=412",
			method: "POST",
			data: $("#form-addrepartidorasig").serialize(),
			beforeSend: function () {
				$('#btn-addrepartidorasig').html('<span class="spinner-border spinner-border-sm mr-2" role="status" aria-hidden="true"></span>Loading...').addClass('disabled');
	           // $("#contenido").html('<div class="row justify-content-md-center" ><img src="assets/img/load.gif" alt=""></div>');
            },
			success: function(data){
				$('#btn-addrepartidorasig').html('Agregar Repartidor').removeClass('disabled');	
				$("#vistarepartidor").html(data);    		
			}
		})
	});
    



$("#form-addrepartidorasig").keypress(function(e) {//Para deshabilitar el uso de la tecla "Enter"
if (e.which == 13) {
return false;
}
});



	$("body").on("click","#delrepartidor",function(){
		var hash = $(this).attr('hash');
    	$.post("application/src/routes.php?op=413", {hash:hash}, 
    	function(data){
    		$("#vista").html(data); // lo que regresa de la busquea 
   	 	});
	});














}); /// termina jquery