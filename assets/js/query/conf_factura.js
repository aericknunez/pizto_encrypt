$(document).ready(function()
{

	$("body").on("click","#ax0",function(){ /// para el los botones de opciones

		if($(this).attr('checked')){ // es por que estaba activo
			$('#ax0').removeAttr("checked","checked");
			var dir = 'op=16&iden=ax0&edo=0';
		} 
		else {
			$('#ax0').attr("checked","checked");
			var dir = 'op=16&iden=ax0&edo=1';
		}
	
	QueryGo(dir);	
	
	});


	$("body").on("click","#ax1",function(){ /// para el los botones de opciones

		if($(this).attr('checked')){ // es por que estaba activo
			$('#ax1').removeAttr("checked","checked");
			var dir = 'op=16&iden=ax1&edo=0';
		} 
		else {
			$('#ax1').attr("checked","checked");
			var dir = 'op=16&iden=ax1&edo=1';
		}
	
	QueryGo(dir);	
	
	});






	$("body").on("click","#bx0",function(){ /// para el los botones de opciones

		if($(this).attr('checked')){ // es por que estaba activo
			$('#bx0').removeAttr("checked","checked");
			var dir = 'op=16&iden=bx0&edo=0';
		} 
		else {
			$('#bx0').attr("checked","checked");
			var dir = 'op=16&iden=bx0&edo=1';
		}
	
	QueryGo(dir);	
	
	});


	$("body").on("click","#bx1",function(){ /// para el los botones de opciones

		if($(this).attr('checked')){ // es por que estaba activo
			$('#bx1').removeAttr("checked","checked");
			var dir = 'op=16&iden=bx1&edo=0';
		} 
		else {
			$('#bx1').attr("checked","checked");
			var dir = 'op=16&iden=bx1&edo=1';
		}
	
	QueryGo(dir);	
	
	});



	$("body").on("click","#cx0",function(){ /// para el los botones de opciones

		if($(this).attr('checked')){ // es por que estaba activo
			$('#cx0').removeAttr("checked","checked");
			var dir = 'op=16&iden=cx0&edo=0';
		} 
		else {
			$('#cx0').attr("checked","checked");
			var dir = 'op=16&iden=cx0&edo=1';
		}
	
	QueryGo(dir);	
	
	});


	$("body").on("click","#cx1",function(){ /// para el los botones de opciones

		if($(this).attr('checked')){ // es por que estaba activo
			$('#cx1').removeAttr("checked","checked");
			var dir = 'op=16&iden=cx1&edo=0';
		} 
		else {
			$('#cx1').attr("checked","checked");
			var dir = 'op=16&iden=cx1&edo=1';
		}
	
	QueryGo(dir);	
	
	});



	$("body").on("click","#dx0",function(){ /// para el los botones de opciones

		if($(this).attr('checked')){ // es por que estaba activo
			$('#dx0').removeAttr("checked","checked");
			var dir = 'op=16&iden=dx0&edo=0';
		} 
		else {
			$('#dx0').attr("checked","checked");
			var dir = 'op=16&iden=dx0&edo=1';
		}
	
	QueryGo(dir);	
	
	});


	$("body").on("click","#dx1",function(){ /// para el los botones de opciones

		if($(this).attr('checked')){ // es por que estaba activo
			$('#dx1').removeAttr("checked","checked");
			var dir = 'op=16&iden=dx1&edo=0';
		} 
		else {
			$('#dx1').attr("checked","checked");
			var dir = 'op=16&iden=dx1&edo=1';
		}
	
	QueryGo(dir);	
	
	});



function QueryGo(dir){

        var dataString = dir;

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
}




});
