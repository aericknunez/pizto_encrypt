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
        var panel = $(this).attr('panel');
        var cliente = $(this).attr('cliente');
        var dataString = 'op='+op+'&cod='+cod+'&mesa='+mesa+'&panel='+panel+'&cliente='+cliente;

        $.ajax({
            type: "POST",
            url: "application/src/routes.php",
            data: dataString,
            success: function(data) {   
                $("#lateral").load('application/src/routes.php?op=22');         
                MuestraOpciones(data);   // activar para seleccionar las opciones    
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
                    $("#aquillevar").html("Para LLevar <br> La propina no se cobrará");
                }

                $("#total_factura").load('application/src/routes.php?op=373');
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




/// mostrar modal para opciones del platillo

function MuestraOpciones(datos){
       
       datos = JSON.parse(datos);

        $('#ModalOpciones').modal('show');
        var dataString = 'op=18&producto='+datos.producto+'&codigo='+datos.codigo+'&identificador='+datos.identificador;

        $.ajax({
            type: "POST",
            url: "application/src/routes.php",
            data: dataString,
            beforeSend: function () {
               $("#vista_opcion").html('<div class="row justify-content-md-center" ><img src="assets/img/load.gif" alt=""></div>');
            },
            success: function(data) {            
                $("#vista_opcion").html(data); // lo que regresa de la busquea         
            }
        });
 
}


    $("body").on("click","#addopcion",function(){ 
        
        $('#ModalOpciones').modal('hide');
       
        var codigo = $(this).attr('codigo');
        var identificador = $(this).attr('identificador');
        var op = $(this).attr('op');
        var opcion = $(this).attr('opcion');
        var producto = $(this).attr('producto');
        var dataString = 'op='+op+'&codigo='+codigo+'&identificador='+identificador+'&opcion='+opcion+'&producto='+producto;

        $.ajax({
            type: "POST",
            url: "application/src/routes.php",
            data: dataString,
            beforeSend: function () {
               $("#vista_opcion").html('<div class="row justify-content-md-center" ><img src="assets/img/load.gif" alt=""></div>');
            },
            success: function(data) {  

            datos = JSON.parse(data);

                if(datos.mensaje != "Vacio"){ 
                    MuestraOpciones(data); // lo que regresa de la busquea         
                } else {
                   $("#vista_opcion").html(data);
                   $("#lateral").load('application/src/routes.php?op=22'); 
                }      
            }
        });       
    });












///////////ver modal de ver mesas
    $("body").on("click","#cometario_comanda",function(){         
        $('#ComentarioComanda').modal('show');
           
    });




    $('#btn-comentario').click(function(e){ /// agregar un comentario
    e.preventDefault();
    $.ajax({
            url: "application/src/routes.php?op=374",
            method: "POST",
            data: $("#form-comentario").serialize(),
            beforeSend: function () {
                $('#btn-comentario').html('<span class="spinner-border spinner-border-sm mr-2" role="status" aria-hidden="true"></span>Loading...').addClass('disabled');
               // $("#contenido").html('<div class="row justify-content-md-center" ><img src="assets/img/load.gif" alt=""></div>');
            },
            success: function(data){
                $('#btn-comentario').html('AGREGAR COMENTARIO').removeClass('disabled');  
                $("#vista_comentarios").html(data); 
            }
        })
        $("#lateral").load('application/src/routes.php?op=22'); 
    });
    














/// llamar modal cantidad
    $("body").on("click","#xcantidad",function(){ 
        
        $('#ModalCantidad').modal('show');
        
        var cantidad = $(this).attr('cantidad');
        var codigox = $(this).attr('codigox');
        var cliente = $(this).attr('cliente');

        $('#codigox').attr("value", codigox);
        $('#cantidad').attr("value", cantidad);
        $('#cliente').attr("value", cliente);
        
    });




    $('#btn-Ccantidad').click(function(e){ /// cambia la cantidad de los productos
        e.preventDefault();
        $.ajax({
            url: "application/src/routes.php?op=20q",
            method: "POST",
            data: $("#form-Ccantidad").serialize(),
            beforeSend: function () {
                $('#btn-Ccantidad').html('<span class="spinner-border spinner-border-sm mr-2" role="status" aria-hidden="true"></span>Loading...').addClass('disabled');
            },
            success: function(data){
               $('#btn-Ccantidad').html('Agregar').removeClass('disabled');
               $("#form-Ccantidad").trigger("reset");
               $('#ModalCantidad').modal('hide');
               $("#ventana").html(data); // lo que regresa de la busquea 
               $("#lateral").load('application/src/routes.php?op=22'); // caraga el lateral
            }
        })
    })







});