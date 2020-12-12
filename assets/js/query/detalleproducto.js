$(document).ready(function()
{

	$('#btn-porciones').click(function(e){ /// para el formulario
		e.preventDefault();
		$.ajax({
			url: "application/src/routes.php?op=36",
			method: "POST",
			data: $("#form-porciones").serialize(),
			success: function(data){
				$("#porciones").html(data);
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
	var cod = $(this).attr('cod');
    	$.post("application/src/routes.php", {op:op, iden:iden, cod:cod}, 
    	function(htmlexterno){
		$("#porciones").html(htmlexterno);
   	 	});
	});


});