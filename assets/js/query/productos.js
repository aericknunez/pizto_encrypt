$(document).ready(function()
{

	$('#btn-unidades').click(function(e){ /// para el formulario
		e.preventDefault();
		$.ajax({
			url: "application/src/routes.php?op=30",
			method: "POST",
			data: $("#form-unidades").serialize(),
			success: function(data){
				$("#productos").html(data);
				$("#form-unidades").trigger("reset");
			}
		})
	})
$("#form-unidades").keypress(function(e) {//Para deshabilitar el uso de la tecla "Enter"
if (e.which == 13) {
return false;
}
});



	$("body").on("click","#borrar-unidad",function(){
	var op = $(this).attr('op');
	var iden = $(this).attr('iden');
    	$.post("application/src/routes.php", {op:op, iden:iden}, 
    	function(htmlexterno){
		$("#productos").html(htmlexterno);
   	 	});
	});




	$('#btn-porciones').click(function(e){ /// para el formulario
		e.preventDefault();
		$.ajax({
			url: "application/src/routes.php?op=32",
			method: "POST",
			data: $("#form-porciones").serialize(),
			success: function(data){
				$("#productos").html(data);
				$("#form-porciones").trigger("reset");
			}
		})
	})
$("#form-porciones").keypress(function(e) {//Para deshabilitar el uso de la tecla "Enter"
if (e.which == 13) {
return false;
}
});


	$("body").on("click","#borrar-porcion",function(){
	var op = $(this).attr('op');
	var iden = $(this).attr('iden');
    	$.post("application/src/routes.php", {op:op, iden:iden}, 
    	function(htmlexterno){
		$("#productos").html(htmlexterno);
   	 	});
	});



	$('#btn-materia').click(function(e){ /// para el formulario
		e.preventDefault();
		$.ajax({
			url: "application/src/routes.php?op=34",
			method: "POST",
			data: $("#form-materia").serialize(),
			success: function(data){
				$("#productos").html(data);
				$("#form-materia").trigger("reset");
			}
		})
	})
$("#form-materia").keypress(function(e) {//Para deshabilitar el uso de la tecla "Enter"
if (e.which == 13) {
return false;
}
});


	$("body").on("click","#borrar-materia",function(){
	var op = $(this).attr('op');
	var iden = $(this).attr('iden');
    	$.post("application/src/routes.php", {op:op, iden:iden}, 
    	function(htmlexterno){
		$("#productos").html(htmlexterno);
   	 	});
	});





////////////////////////paginador 
	$("body").on("click","#paginador",function(){
	var op = $(this).attr('op');
	var iden = $(this).attr('iden');
    $.post("application/src/routes.php", {op:op, iden:iden}, function(htmlexterno){
	$("#productos").html(htmlexterno);
   	 });

	});



////////////////////////cambiar pantalla
	$("body").on("click","#pantalla",function(){
	var op = $(this).attr('op');
	var cod = $(this).attr('cod');
	var iden = $(this).attr('iden');
	var pagina = $(this).attr('pagina');
    $.post("application/src/routes.php", {op:op, cod:cod, iden:iden, pagina:pagina}, function(htmlexterno){
	$("#productos").html(htmlexterno);
   	 });

	});



//////////////////////// dar seguimiento a materia prima
	$("body").on("click","#cambiar-materia",function(){
	var op = $(this).attr('op');
	var iden = $(this).attr('iden');
	var cod = $(this).attr('cod');
    $.post("application/src/routes.php", {op:op, iden:iden, cod:cod}, function(htmlexterno){
	$("#productos").html(htmlexterno);
   	 });

	});





});