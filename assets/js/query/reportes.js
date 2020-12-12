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




	$('#btn-reporte').click(function(e){ /// para el formulario
		$("#form-reporte").hide();
		MuestraLoader();
		e.preventDefault();
		$.ajax({
			url: "application/src/routes.php?op=160",
			method: "POST",
			data: $("#form-reporte").serialize(),
			success: function(data){
				$("#contenido").html(data);
				$("#form-reporte").trigger("reset");
				$("#form-reporte").show();
				EscondeLoader();
			}
		})
	})
	



// quita el loader
	EscondeLoader();
	function EscondeLoader(){
		$("#loaderx").hide();
	}

// muestra loader
	function MuestraLoader(){
		$("#loaderx").show();
	}



	$('#btn-rango').click(function(e){ /// para el formulario
		$("#form-rango").hide();
		MuestraLoader();
		e.preventDefault();
		$.ajax({
			url: "application/src/routes.php?op=161",
			method: "POST",
			data: $("#form-rango").serialize(),
			success: function(data){
				$("#contenido").html(data);
				$("#form-rango").trigger("reset");
				$("#form-rango").show();
				EscondeLoader();
			}
		})
	})





	$('#btn-contadora').click(function(e){ /// para el formulario
		$("#form-contadora").hide();
		MuestraLoader();
		e.preventDefault();
		$.ajax({
			url: "application/src/routes.php?op=162",
			method: "POST",
			data: $("#form-contadora").serialize(),
			success: function(data){
				$("#contenido").html(data);
				$("#form-contadora").trigger("reset");
				$("#form-contadora").show();
				EscondeLoader();
			}
		})
	})





	$("body").on("click","#imprimir-reporte",function(){
	var op = $(this).attr('op');
	var iden = $(this).attr('iden');
    	$.post("application/src/routes.php", {op:op, iden:iden}, 
    	function(htmlexterno){
		$("#msj").html(htmlexterno);
   	 	});
	});








///////////ver modal de ber mesas
    $("body").on("click","#verespecial",function(){ 
        
        $('#ModalVerEspecial').modal('show');
        
        var factura = $(this).attr('factura');
        var tx = $(this).attr('tx');
        var op = $(this).attr('op');
        var dataString = 'op='+op+'&factura='+factura+'&tx='+tx;

        $.ajax({
            type: "POST",
            url: "application/src/routes.php",
            data: dataString,
            beforeSend: function () {
               $("#vista_especial").html('<div class="row justify-content-md-center" ><img src="assets/img/load.gif" alt=""></div>');
            },
            success: function(data) {            
                $("#vista_especial").html(data); // lo que regresa de la busquea         
            }
        });       
    });




////ver imagenes de gastos
    $("body").on("click","#xver",function(){ 
        
        $('#ModalImagenes').modal('show');
        var gasto = $(this).attr('gasto');
    
            $.ajax({
                url: "application/src/routes.php?op=175&gasto="+gasto,
                method: "POST",
                beforeSend: function () {
               		$("#vista").html('<div class="row justify-content-md-center" ><img src="assets/img/load.gif" alt=""></div>');
            	},
                success: function(data){
                    $("#vista").html(data);         
                }
            });

    });

    $("body").on("click","#verimagen",function(){ 
         var iden = $(this).attr('iden');
         var gasto = $(this).attr('gasto');
         $.ajax({
                url: "application/src/routes.php?op=176&iden="+iden+"&gasto="+gasto,
                method: "POST",
                beforeSend: function () {
               		$("#vista").html('<div class="row justify-content-md-center" ><img src="assets/img/load.gif" alt=""></div>');
            	},
                success: function(data){
                    $("#vista").html(data);         
                }
            });
    });





});