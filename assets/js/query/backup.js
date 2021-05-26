$(document).ready(function()
{


 /////////////////// sverifica si hay datos en la api
    fetch_data();

    function fetch_data(){

        var op = "353";
        var dataString = 'op='+op;

        $.ajax({
            type: "POST",
            url: "application/src/routes.php",
            data: dataString,
            beforeSend: function () {
               $("#respaldos").hide();
               $("#pendientes").html('<div class="row justify-content-md-center" ><img src="assets/img/load.gif" alt=""></div>');
            },
            success: function(data) {  
                $("#respaldos").show();          
                $("#pendientes").html(data); // lo que regresa de la busquea      
                $("#respaldos").load('application/src/routes.php?op=351');
            }
        });
    }
///////////////////

    $("body").on("click","#backup",function(){ 
        
        var op = "350";
        var sistema = $(this).attr('sistema');
        var dataString = 'op='+op+'&sistema='+sistema;

        $.ajax({
            type: "POST",
            url: "application/src/routes.php",
            data: dataString,
            beforeSend: function () {
               $("#vista").html('<div class="row justify-content-md-center" ><img src="assets/img/load.gif" alt=""></div>');
            },
            success: function(data) {            
                $("#vista").html(data); // lo que regresa de la busquea      
                $("#respaldos").load('application/src/routes.php?op=351');
                $("#pendientes").load('application/src/routes.php?op=353');
            }
        });

    });


    $("body").on("click","#eliminar",function(){ 
        
        var op = "352";
        var data = $(this).attr('data');
        var dataString = 'op='+op+'&data='+data;

        $.ajax({
            type: "POST",
            url: "application/src/routes.php",
            data: dataString,
            beforeSend: function () {
               $("#vista").html('<div class="row justify-content-md-center" ><img src="assets/img/load.gif" alt=""></div>');
            },
            success: function(data) {            
                $("#vista").html(data); // lo que regresa de la busquea   
                $("#respaldos").load('application/src/routes.php?op=351');
                $("#pendientes").load('application/src/routes.php?op=353');
            }
        });

    });




/// eliminar datos del sistema
    $("body").on("click","#deleteall",function(){ 
        
        var op = "249";
        var dataString = 'op='+op;

        $.ajax({
            type: "POST",
            url: "application/src/routes.php",
            data: dataString,
            beforeSend: function () {
               $("#vista").html('<div class="row justify-content-center" ><img src="assets/img/loa.gif" alt=""></div>');
            },
            success: function(data) {            
                $("#vista").html(data); // lo que regresa de la busquea      
            }
        });

    });














});