$(document).ready(function()
{

	$('#btn-averias').click(function(e){ /// para el formulario
		e.preventDefault();
		$.ajax({
			url: "application/src/routes.php?op=110",
			method: "POST",
			data: $("#form-averias").serialize(),
			success: function(data){
				$("#historial").html(data);
				$("#form-averias").trigger("reset");
			}
		})
	})
$("#form-averias").keypress(function(e) {//Para deshabilitar el uso de la tecla "Enter"
if (e.which == 13) {
return false;
}
});


	$('#btn-addpro').click(function(e){ /// para el formulario
		e.preventDefault();
		$.ajax({
			url: "application/src/routes.php?op=115",
			method: "POST",
			data: $("#form-addpro").serialize(),
			success: function(data){
				$("#historial").html(data);
				$("#form-addpro").trigger("reset");
			}
		})
	})
$("#form-addpro").keypress(function(e) {//Para deshabilitar el uso de la tecla "Enter"
if (e.which == 13) {
return false;
}
});



	$("body").on("click","#borrar-averia",function(){
	var op = $(this).attr('op');
	var iden = $(this).attr('iden');
    	$.post("application/src/routes.php", {op:op, iden:iden}, 
    	function(htmlexterno){
		$("#historial").html(htmlexterno);
   	 	});
	});


		$("body").on("click","#borrar-addpro",function(){
	var op = $(this).attr('op');
	var iden = $(this).attr('iden');
    	$.post("application/src/routes.php", {op:op, iden:iden}, 
    	function(htmlexterno){
		$("#historial").html(htmlexterno);
   	 	});
	});




////////////////////////paginador 
	$("body").on("click","#paginador",function(){
	var op = $(this).attr('op');
	var iden = $(this).attr('iden');
    $.post("application/src/routes.php", {op:op, iden:iden}, function(htmlexterno){
	$("#historial").html(htmlexterno);
   	 });

	});




});