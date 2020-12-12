$(document).ready(function()
{

    $("body").on("click","#paginador",function(){
        var op = $(this).attr('op');
        var iden = $(this).attr('iden');
        var orden = $(this).attr('orden');
        var dir = $(this).attr('dir');
        var dataString = 'op='+op+'&iden='+iden+'&orden='+orden+'&dir='+dir;

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






});