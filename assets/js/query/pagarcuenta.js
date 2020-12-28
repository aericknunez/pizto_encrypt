$(document).ready(function()
{

	$("body").on("click","#cliente-facturar",function(){
	var op = $(this).attr('op');
	var mesa = $(this).attr('mesa');
	var cliente = $(this).attr('cliente');
    	$.post("application/src/routes.php", {op:op, mesa:mesa, cliente:cliente}, 
    	function(htmlexterno){
		$("#origen").load('application/src/routes.php?op=54');
		$("#destino").html(htmlexterno);
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






});