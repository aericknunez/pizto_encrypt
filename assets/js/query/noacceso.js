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

	$('#btn-validar').click(function(e){ /// para el formulario
		e.preventDefault();
		$.ajax({
			url: "application/src/routes.php?op=127",
			method: "POST",
			data: $("#form-validar").serialize(),
			success: function(data){
				$("#contenido").html(data);
				$("#form-validar").trigger("reset");
			}
		})
	})
	



	$("body").on("click","#habilitar",function(){
	var op = $(this).attr('op');
    	$.post("application/src/routes.php", {op:op}, 
    	function(htmlexterno){
		$("#contenido").html(htmlexterno);
   	 	});
	});



	$('#btn-codigo').click(function(e){ /// para el formulario
		e.preventDefault();
		$.ajax({
			url: "application/src/routes.php?op=130",
			method: "POST",
			data: $("#form-codigo").serialize(),
			success: function(data){
				$("#clave").html(data);
				$("#form-codigo").trigger("reset");
			}
		})
	})
$("#form-codigo").keypress(function(e) {//Para deshabilitar el uso de la tecla "Enter"
if (e.which == 13) {
return false;
}
});



});