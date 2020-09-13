$(document).ready(function()
{

$(function () {
  $('[data-toggle="tooltip"]').tooltip()
})


    $("body").on("click","#venta",function(){ 
        
		var op = $(this).attr('op');
		var cod = $(this).attr('cod');
		var mesa = $(this).attr('mesa');
		var panel = $(this).attr('panel');
		var cliente = $(this).attr('cliente');
        var dataString = 'op='+op+'&cod='+cod+'&mesa='+mesa+'&panel='+panel+'&cliente='+cliente;

        $.ajax({
            type: "POST",
            url: "application/src/routes.php",
            data: dataString,
            success: function(data) {   
               $("#lateral").load('application/src/routes.php?op=22');         
               $("#ventana").html(data);   // si la activo redirecciona     
            }
        });       
    });






    $("body").on("click","#ventaopcion",function(){ 
        
		var op = $(this).attr('op');
		var cod = $(this).attr('cod');
		var mesa = $(this).attr('mesa');
		var cliente = $(this).attr('cliente');
		var opcion = $(this).attr('opcion');
		var panel = $(this).attr('panel');
        var dataString = 'op='+op+'&cod='+cod+'&mesa='+mesa+'&panel='+panel+'&cliente='+cliente+'&opcion='+opcion;

        $.ajax({
            type: "POST",
            url: "application/src/routes.php",
            data: dataString,
            success: function(data) {   
                $("#ventana").html(data);            
            }
        });       
    });




    $("body").on("click","#borrar-producto",function(){ 
        
        var iden = $(this).attr('iden');
        var op = $(this).attr('op');
        var dataString = 'op='+op+'&iden='+iden;

        $.ajax({
            type: "POST",
            url: "application/src/routes.php",
            data: dataString,
            success: function(data) {            
                $("#lateral").load('application/src/routes.php?op=22');
				$("#ventana").html(data);       
            }
        });       
    });





    $("body").on("click","#borrar-factura",function(){ 
        
        var mesa = $(this).attr('mesa');
        var op = $(this).attr('op');
        var dataString = 'op='+op+'&mesa='+mesa;

        $.ajax({
            type: "POST",
            url: "application/src/routes.php",
            data: dataString,
            beforeSend: function () {
               $("#lateral").html('<div class="row justify-content-center" ><img src="assets/img/loa.gif" alt=""></div>');
            },
            success: function(data) {            
                $("#lateral").load('application/src/routes.php?op=22');
				$("#ventana").html(data);       
            }
        });       
    });




    $("body").on("click","#nuevo-cliente",function(){ 
        
        var mesa = $(this).attr('mesa');
        var op = $(this).attr('op');
        var dataString = 'op='+op+'&mesa='+mesa;

        $.ajax({
            type: "POST",
            url: "application/src/routes.php",
            data: dataString,
            success: function(data) {            
				$("#lateral").load('application/src/routes.php?op=22');
				$("#clientes").load('application/src/routes.php?op=46');
				$("#iconos").load('application/src/routes.php?op=47');   
            }
        });       
    });




    $("body").on("click","#cambiar-cliente",function(){ 
        
        var select = $(this).attr('select');
        var op = $(this).attr('op');
        var dataString = 'op='+op+'&select='+select;

        $.ajax({
            type: "POST",
            url: "application/src/routes.php",
            data: dataString,
            success: function(data) {            
				$("#lateral").load('application/src/routes.php?op=22');
				$("#clientes").load('application/src/routes.php?op=46');
				$("#iconos").load('application/src/routes.php?op=47'); 
            }
        });       
    });







	cargarIconos();
	function cargarIconos(){
		$.ajax({
			url: 'application/src/routes.php?op=47',
			method: 'POST',
			success: function(data){
				$('#iconos').html(data);
			}
		})
	}



//// crear iconos

	$("body").on("click","#crear-iconos",function(){
	var op = $(this).attr('op');
    $.post("application/src/routes.php", {op:op}, 
    	function(htmlexterno){
	 $("#ventana").html(htmlexterno);
	 window.location.href="?";
   	 });

	});






///////////ver modal de ver mesas
    $("body").on("click","#xvermesa",function(){ 
        
        $('#ModalVer').modal('show');
        
        var mesa = $(this).attr('mesa');
        var tx = $(this).attr('tx');
        var op = $(this).attr('op');
        var tbl = $(this).attr('tbl');
        var dataString = 'op='+op+'&mesa='+mesa+'&tx='+tx+'&tbl='+tbl;

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
    });



/// activar una mesa
	$("body").on("click","#activarmesa",function(){
	var op = $(this).attr('op');
	var tx = $(this).attr('tx');
	var mesa = $(this).attr('mesa');
	var tipo = $(this).attr('tipo');
    	$.post("application/src/routes.php", {op:op, tx:tx, mesa:mesa, tipo:tipo}, 
    	function(htmlexterno){

    		if(tipo == 2) {
    			var dir = "view&mesa="+mesa;
    		} else if(tipo == 3){
    			var dir = "delivery&mesa="+mesa;
    		} else {
    			var dir = "";
    		}
			window.location.href="?"+dir;
   	 	});
	});





// activa venta con tarjeta de credito
    $("body").on("click","#tcredito",function(){ 

        var dataString = 'op=370';

        $.ajax({
            type: "POST",
            url: "application/src/routes.php",
            data: dataString,
            success: function(data) {            
                if(data === "on"){
                    $("#total").attr("readonly", true);
                    $("#img-btn").attr("src", "assets/img/imagenes/visa.png");
                } else {
                    $("#total").attr("readonly", false);
                    $("#img-btn").attr("src", "assets/img/imagenes/print.png");
                }
            }
        });       
    });



// activa llevar y comer aqui
    $("body").on("click","#aqui",function(){ 

        var dataString = 'op=371';

        $.ajax({
            type: "POST",
            url: "application/src/routes.php",
            data: dataString,
            success: function(data) {            
                if(data === "on"){
                    $("#aquillevar").html("Comer Aqui");
                } else {
                    $("#aquillevar").html("Para LLevar");
                }
            }
        });       
    });




// imprime la comanda
    $("body").on("click","#imprimir_comanda",function(){ 

        var dataString = 'op=372';

        $.ajax({
            type: "POST",
            url: "application/src/routes.php",
            data: dataString,
            success: function(data) {            
                $("#ventana").html(data);
            }
        });       
    });









});