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


    $(document).ready(function() {
    $('.mdb-select').materialSelect();
    });



/// Nueva cuenta
	$("body").on("click","#addcuenta",function(){ 
		
		$('#ModalAddCuenta').modal('show');

	});
    

 /// add cuenta    
	$('#btn-cuenta').click(function(e){ /// agregar un producto 
	e.preventDefault();

	$.ajax({
			url: "application/src/routes.php?op=200",
			method: "POST",
			data: $("#form-cuenta").serialize(),
			beforeSend: function () {
				$('#btn-cuenta').html('<span class="spinner-border spinner-border-sm mr-2" role="status" aria-hidden="true"></span>Loading...').addClass('disabled');
	           // $("#contenido").html('<div class="row justify-content-center" ><img src="assets/img/loa.gif" alt=""></div>');
            },
			success: function(data){
				$('#btn-cuenta').html('Guardar').removeClass('disabled');	      
				$("#form-cuenta").trigger("reset");
				$("#contenido").html(data);	
				$('#ModalAddCuenta').modal('hide');
			}
		})
	});
    




/// llamar modal ver
	$("body").on("click","#xver",function(){ 

		$('#ModalVerCuenta').modal('show');
		$("#btn-ra").remove();
		
		var op = $(this).attr('op');
		var cuenta = $(this).attr('cuenta');
		var dataString = 'op='+op+'&cuenta='+cuenta;

		$.ajax({
            type: "POST",
            url: "application/src/routes.php",
            data: dataString,
            beforeSend: function () {
               $("#vista_ver").html('<div class="row justify-content-center" ><img src="assets/img/loa.gif" alt=""></div>');
            },
            success: function(data) {            
                $("#vista_ver").html(data); // lo que regresa de la busquea 		
            }
        });
		$("#cerrarver").before('<a href="?modal=abonos_cuentas&cuenta='+cuenta+'" id="btn-ra" class="btn btn-secondary btn-rounded">Realizar Abonos</a>');
	});
    


/// 
/// 
/// 
 







 /// abonos    
	$('#btn-abono').click(function(e){ /// agregar un producto 
	e.preventDefault();

	var cuenta = $("#cuenta").val();

	$.ajax({
			url: "application/src/routes.php?op=205",
			method: "POST",
			data: $("#form-abono").serialize(),
			beforeSend: function () {
				$('#btn-abono').html('<span class="spinner-border spinner-border-sm mr-2" role="status" aria-hidden="true"></span>Loading...').addClass('disabled');
	           // $("#contenido").html('<div class="row justify-content-center" ><img src="assets/img/loa.gif" alt=""></div>');
            },
			success: function(data){
				$('#btn-abono').html('Agregar Abono').removeClass('disabled');	      
				$("#form-abono").trigger("reset");
				$("#contenido").html(data);	
				$("#data-abonos").load('application/src/routes.php?op=203&cuenta='+cuenta);
				$("#data-total").load('application/src/routes.php?op=204&cuenta='+cuenta);			
			}
		})
	});
    




    $("body").on("click","#delabono",function(){
        var op = $(this).attr('op');
		var cuenta = $(this).attr('cuenta');
		var hash = $(this).attr('hash');
        var dataString = 'op='+op+'&cuenta='+cuenta+'&hash='+hash;

        $.ajax({
            type: "POST",
            url: "application/src/routes.php",
            data: dataString,
            beforeSend: function () {
               $("#contenido").html('<div class="row justify-content-center" ><img src="assets/img/loa.gif" alt=""></div>');
            },
            success: function(data) {            
                $("#contenido").html(data); // lo que regresa de la busquea 
                $("#data-abonos").load('application/src/routes.php?op=203&cuenta='+cuenta);
				$("#data-total").load('application/src/routes.php?op=204&cuenta='+cuenta);				
            }
        });
    });                 





/////////////////////////////////////////////



///////////// llamar modal para eliminar elemento
    $("body").on("click","#xdelete",function(){ 
        
        $('#ConfirmDelete').modal('show');
        var op = $(this).attr('op');
        var iden = $(this).attr('iden');
         
        $('#borrar-cuenta').attr("op",op).attr("iden",iden);
        
    });



    $("body").on("click","#borrar-cuenta",function(){
        var op = $(this).attr('op');
        var iden = $(this).attr('iden');
        var dataString = 'op='+op+'&iden='+iden;

        $('#ConfirmDelete').modal('hide');

        $.ajax({
            type: "POST",
            url: "application/src/routes.php",
            data: dataString,
            beforeSend: function () {
               $("#contenido").html('<div class="row justify-content-center" ><img src="assets/img/loa.gif" alt=""></div>');
            },
            success: function(data) {            
                $("#contenido").html(data); // lo que regresa de la busquea 
            }
        });
    });                 















}); // termina query