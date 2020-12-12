$(document).ready(function()
{

    function CompruebaPanel(){
        $.ajax({
            type: "POST",
            url: "application/src/routes.php?op=95",
            success: function(data) {
            	if(data=="true"){
					getRandValue();
				}
            }
        });
    }


    function getRandValue(){
        $.ajax({
            type: "POST",
            url: "application/src/routes.php?op=96",
            success: function(data) {
                $('#contenido').html(data);
                $("#lateral-panel").load('application/src/routes.php?op=97');
            }
        });
    }
    setInterval(CompruebaPanel, 3000);




panel();
function panel(){
		$.ajax({
			type: "POST",
            url: "application/src/routes.php?op=96",
            success: function(data) {
                $('#contenido').html(data);
                $("#lateral-panel").load('application/src/routes.php?op=97');
            }
		})
	}



//////  producto realizado
    $("body").on("click","#pasar-producto",function(){
    var op = $(this).attr('op');
    var iden = $(this).attr('iden');
    var cod = $(this).attr('cod');
    var identificador = $(this).attr('identificador');
        $.post("application/src/routes.php", {op:op, iden:iden, cod:cod, identificador:identificador}, 
        function(data){
        $('#contenido').html(data);
        $("#lateral-panel").load('application/src/routes.php?op=97');
        });
    });


//////  cambiar pantalla panel
    $("body").on("click","#cambiar-panel",function(){
    var op = $(this).attr('op');
    var iden = $(this).attr('iden');
        $.post("application/src/routes.php", {op:op, iden:iden}, 
        function(data){
        $('#contenido').html(data);
        $("#lateral-panel").load('application/src/routes.php?op=97');
        });
    });



});