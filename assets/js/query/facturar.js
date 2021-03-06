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


	$("#search-box-rtn").keyup(function(){ /// para la caja de busqueda
			$.ajax({
			type: "POST",
			url: "application/src/routes.php?op=132",
			data:'keyword='+$(this).val(),
			beforeSend: function(){
				$("#search-box-rtn").css("background","#FFF url(assets/img/LoaderIcon.gif) no-repeat 165px");
			},
			success: function(data){
				$("#resultado").show();
				$("#resultado").html(data);
				$("#search-box-rtn").css("background","#FFF");
			}
			});
		});
		function selectProducto(val) {
		$("#search-box-rtn").val(val);
		$("#resultado").hide();
	}




	$("body").on("click","#ver-rtn",function(){
	var op = $(this).attr('op');
	var iden = $(this).attr('iden');
    	$.post("application/src/routes.php", {op:op, iden:iden}, 
    	function(htmlexterno){
		$("#resultado").html(htmlexterno);
   	 	});
	});


	$("body").on("click","#quitar-rtn",function(){ // quita
	var op = $(this).attr('op');
    	$.post("application/src/routes.php", {op:op}, 
    	function(htmlexterno){
		$("#resultado").html(htmlexterno);
   	 	});
	});


	$("body").on("click","#eliminarx",function(){ // pregunta elimanar
	var op = $(this).attr('op');
	var idx = $(this).attr('idx');
	var opx = $(this).attr('opx');
	var iden = $(this).attr('iden');
    	$.post("application/src/routes.php", {op:op,idx:idx,opx:opx,iden:iden}, 
    	function(htmlexterno){
		$("#resultado").html(htmlexterno);
   	 	});
	});

	$("body").on("click","#eliminar",function(){ // elimina
	var op = $(this).attr('op');
	var iden = $(this).attr('iden');
    	$.post("application/src/routes.php", {op:op,iden:iden}, 
    	function(htmlexterno){
		$("#resultado").html(htmlexterno);
   	 	});
	});

	$('#btn-rtn').click(function(e){ /// para el formulario agregar rtn
		e.preventDefault();
		$.ajax({
			url: "application/src/routes.php?op=135",
			method: "POST",
			data: $("#form-rtn").serialize(),
			success: function(data){
				$("#resultado").html(data);
				$("#form-rtn").trigger("reset");
			}
		})
	})
$("#form-rtn").keypress(function(e) {//Para deshabilitar el uso de la tecla "Enter"
if (e.which == 13) {
return false;
}
});




	$('#btn-cai').click(function(e){ /// para el formulario agregar rtn
		e.preventDefault();
		$.ajax({
			url: "application/src/routes.php?op=138",
			method: "POST",
			data: $("#form-cai").serialize(),
			success: function(data){
				$("#resultado").html(data);
				$("#form-cai").trigger("reset");
			}
		})
	})
$("#form-cai").keypress(function(e) {//Para deshabilitar el uso de la tecla "Enter"
if (e.which == 13) {
return false;
}
});






//////////////// eliminar la factura
	$("body").on("click","#eliminar-factura",function(){
	var op = $(this).attr('op');
	var num_fac = $(this).attr('num_fac');
	var mesa = $(this).attr('mesa');
    	$.post("application/src/routes.php", {op:op, num_fac:num_fac, mesa:mesa}, 
    	function(htmlexterno){
		$("#resultado").html(htmlexterno);
   	 	});
	});






	$('#btn-propina').click(function(e){ /// para el formulario agregar rtn
		e.preventDefault();
		$.ajax({
			url: "application/src/routes.php?op=69",
			method: "POST",
			data: $("#form-propina").serialize(),
			success: function(data){
				$("#resultado").html(data);
				$("#form-propina").trigger("reset");
			}
		})
	})
$("#form-propina").keypress(function(e) {//Para deshabilitar el uso de la tecla "Enter"
if (e.which == 13) {
return false;
}
});





/// cambiar para porcentaje o establecer cantidad de propina
	$("body").on("click","#prop",function(){ /// para el los botones de opciones

		if($(this).attr('checked')){ // es por que estaba activo
			$('#prop').removeAttr("checked","checked");
			var dir = 'op=69x&edo=0';
		} 
		else {
			$('#prop').attr("checked","checked");
			var dir = 'op=69x&edo=1';
		}
	
	QueryGo(dir);	
	
	});

function QueryGo(dir){

        var dataString = dir;

        $.ajax({
            type: "POST",
            url: "application/src/routes.php",
            data: dataString,
            beforeSend: function () {
               $("#load").html('<div class="row justify-content-md-center" ><img src="assets/img/load.gif" alt=""></div>');
            },
            success: function(data) {            
                $("#load").html(data); // lo que regresa de la busquea 
            }

    });      
}

///////





	$('#btn-borrrarelemento').click(function(e){ /// 
		e.preventDefault();
		$.ajax({
			url: "application/src/routes.php?op=79",
			method: "POST",
			data: $("#form-borrrarelemento").serialize(),
			success: function(data){
				$("#resultado").html(data);
				$("#form-borrrarelemento").trigger("reset");
			}
		})
	})
$("#form-borrrarelemento").keypress(function(e) {//Para deshabilitar el uso de la tecla "Enter"
if (e.which == 13) {
return false;
}
});






});