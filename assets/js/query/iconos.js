$(document).ready(function()
{

	$("body").on("click","#iconos",function(){
	var op = $(this).attr('op');
	var nombre = $(this).attr('nombre');
	var cod = $(this).attr('cod');
	var cat = $(this).attr('cat');
	var popup = $(this).attr('popup');
	var imagen = $(this).attr('imagen');
	var canti = $(this).attr('canti');
	var preci = $(this).attr('preci');
	var opcion = $(this).attr('opcion');
    $.post("application/src/routes.php", {op:op, cod:cod, nombre:nombre, 
    	cat:cat, popup:popup, imagen:imagen, canti:canti, preci:preci, opcion:opcion}, 
    	function(htmlexterno){
	//$("#iconoinfo").html(htmlexterno);
	 window.location.href="?iconos";
   	 });

	});



    $("body").on("click","#deleteicon",function(){
        var op = $(this).attr('op');
        var cod = $(this).attr('cod');
        var dataString = 'op='+op+'&cod='+cod;

        $.ajax({
            type: "POST",
            url: "application/src/routes.php",
            data: dataString,
            beforeSend: function () {
               $("#contenido").html('<div class="row justify-content-md-center" ><img src="assets/img/load.gif" alt=""></div>');
            },
            success: function(data) {            
                $("#contenido").html(data); // lo que regresa de la busquea 
            }
        });
    });                 







	$('#btn-addopcion').click(function(e){ /// para el formulario
		e.preventDefault();
		$.ajax({
			url: "application/src/routes.php",
			method: "POST",
			data: $("#form-addopcion").serialize(),
			success: function(data){
				$("#veropcion").html(data);
				$("#form-addopcion").trigger("reset");
			}
		})
	})
$("#form-addopcion").keypress(function(e) {//Para deshabilitar el uso de la tecla "Enter"
if (e.which == 13) {
return false;
}
});




	$("body").on("click","#delopciones",function(){
	var op = $(this).attr('op');
	var cod = $(this).attr('cod');
	var opciones = $(this).attr('opciones');
    $.post("application/src/routes.php", {op:op, cod:cod, opciones:opciones}, 
    	function(htmlexterno){
	$("#veropcion").html(htmlexterno);
	 });

	});


//// crear iconos

	$("body").on("click","#crear-iconos",function(){
	var op = $(this).attr('op');
    $.post("application/src/routes.php", {op:op}, 
    	function(htmlexterno){
	 $("#ventana").html(htmlexterno);
   	 });

	});






    $("body").on("click","#obtenericonos",function(){

        $.ajax({
            type: "POST",
            url: "application/api/get_imagenes.php",
            beforeSend: function () {
              $('#obtenericonos').html('<span class="spinner-border spinner-border-sm mr-2" role="status" aria-hidden="true"></span>Loading...').addClass('disabled');
            },
            success: function(data) {            
                $('#obtenericonos').html('<i class="fas fa-sync"></i> Cargar Iconos').removeClass('disabled');	 
                $("#cantidadiconos").load('application/src/routes.php?op=93');
            }
        });
    });                 


















});