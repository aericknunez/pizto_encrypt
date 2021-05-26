$(document).ready(function()
{


	$('#btn-login').click(function(e){ /// agregar un producto 
	e.preventDefault();
	$.ajax({
			url: "application/includes/process_login.php",
			method: "POST",
			data: $("#form-login").serialize(),
			beforeSend: function () {
				$('#btn-login').html('<span class="spinner-border spinner-border-sm mr-2" role="status" aria-hidden="true"></span>Loading...').addClass('disabled');
	        },
			success: function(data){
				$('#btn-login').html('Ingresar').removeClass('disabled');	      
				$("#form-login").trigger("reset");
				$("#msj").html(data);	
			}
		})
	});
    



// $("#form-login").keypress(function(e) {//Para deshabilitar el uso de la tecla "Enter"
// if (e.which == 13) {
// return false;
// }
// });


/// registrar modal

    $("body").on("click","#u_registrar",function(){ 
        
        $('#ModalAgregar').modal('show');
    });


	$('#btn-registrar').click(function(e){  
	e.preventDefault();
	$.ajax({
			url: "system/user/redirect.php?op=1",
			method: "POST",
			data: $("#form-registrar").serialize(),
			beforeSend: function () {
				$('#btn-registrar').html('<span class="spinner-border spinner-border-sm mr-2" role="status" aria-hidden="true"></span>Loading...').addClass('disabled');
	        },
			success: function(data){
				$('#btn-registrar').html('Login').removeClass('disabled');	      
				$("#form-registrar").trigger("reset");
				$("#lista_usuarios").load('system/user/redirect.php?op=8');
				$("#msj").html(data);	
				$('#ModalAgregar').modal('hide');
			}
		})
	});
    

$("#form-registrar").keypress(function(e) {//Para deshabilitar el uso de la tecla "Enter"
if (e.which == 13) {
return false;
}
});

//// termina registrar




/// elimiar
///////////// llamar modal para eliminar elemento
    $("body").on("click","#xdelete",function(){ 
        
        $('#ConfirmDelete').modal('show');
			var op = $(this).attr('op');
			var username = $(this).attr('username');
			var iden = $(this).attr('iden');
         
        $('#deluser').attr("op",op).attr("iden",iden).attr("username",username);
        
    });




    $("body").on("click","#deluser",function(){
		var op = $(this).attr('op');
		var username = $(this).attr('username');
		var iden = $(this).attr('iden');
        var dataString = 'op='+op+'&iden='+iden+'&username='+username;

        $.ajax({
            type: "POST",
            url: "system/user/redirect.php",
            data: dataString,
            beforeSend: function () {
               $("#lista_usuarios").html('<div class="row justify-content-md-center" ><img src="assets/img/load.gif" alt=""></div>');
            },
            success: function(data) {            
				$("#lista_usuarios").load('system/user/redirect.php?op=8');
				$("#msj").html(data);	
				$('#ConfirmDelete').modal('hide');
            }
        });
    });                 
// eliminar









//// cambiar pass
    $("body").on("click","#u_pass",function(){ 
        
        $('#ModalPass').modal('show');

        	var username = $(this).attr('username');
			var op = $(this).attr('op');
	        var dataString = 'op='+op+'&username='+username;

	        $.ajax({
	            type: "POST",
	            url: "system/user/redirect.php",
	            data: dataString,
	            beforeSend: function () {
	               $("#vista_password").html('<div class="row justify-content-md-center" ><img src="assets/img/load.gif" alt=""></div>');
	            },
	            success: function(data) {            
					$("#vista_password").html(data);	
	            }
	        });
    });

    	$('#btn-changepass').click(function(e){ /// para el formulario
		e.preventDefault();
		$.ajax({
			url: "system/user/redirect.php?op=5",
			method: "POST",
			data: $("#form-changepass").serialize(),
			success: function(data){
				$("#msj").html(data);
				$("#form-changepass").trigger("reset");
			}
		})
	})

// pass   
	



//// modificar usuraio
    $("body").on("click","#u_update",function(){ 
        
        $('#ModalUpdate').modal('show');

        	var username = $(this).attr('username');
			var op = $(this).attr('op');
	        var dataString = 'op='+op+'&username='+username;

	        $.ajax({
	            type: "POST",
	            url: "system/user/redirect.php",
	            data: dataString,
	            beforeSend: function () {
	               $("#vista_update").html('<div class="row justify-content-md-center" ><img src="assets/img/load.gif" alt=""></div>');
	            },
	            success: function(data) {            
					$("#vista_update").html(data);	
	            }
	        });
    });
///

	$('#btn-actualizar').click(function(e){ /// para el formulario
			e.preventDefault();
			$.ajax({
			url: "system/user/redirect.php?op=2",
			method: "POST",
			data: $("#form-actualizar").serialize(),
			beforeSend: function () {
				$('#btn-registrar').html('<span class="spinner-border spinner-border-sm mr-2" role="status" aria-hidden="true"></span>Loading...').addClass('disabled');
				$("#lista_usuarios").html('<div class="row justify-content-md-center" ><img src="assets/img/load.gif" alt=""></div>');
	        },
			success: function(data){
				$('#btn-actualizar').html('Login').removeClass('disabled');	      
				$("#form-actualizar").trigger("reset");
				$("#lista_usuarios").load('system/user/redirect.php?op=8');
				$("#msj").html(data);	
				$('#ModalUpdate').modal('hide');
			}
		})
	})

$("#form-actualizar").keypress(function(e) {//Para deshabilitar el uso de la tecla "Enter"
if (e.which == 13) {
return false;
}
});







////cambiar avatara

    $("body").on("click","#ver_avatar",function(){ 
        
        $('#ModalAvatar').modal('show');
			var username = $(this).attr('username');
			var op = $(this).attr('op');
	        var dataString = 'op='+op+'&username='+username;

	        $.ajax({
	            type: "POST",
	            url: "system/user/redirect.php",
	            data: dataString,
	            beforeSend: function () {
	               $("#vista_avatar").html('<div class="row justify-content-md-center" ><img src="assets/img/load.gif" alt=""></div>');
	            },
	            success: function(data) {            
					$("#vista_avatar").html(data);	
	            }
	        });
    });




    $("body").on("click","#cambiar-avatar",function(){
		var op = $(this).attr('op');
		var user = $(this).attr('user');
		var iden = $(this).attr('iden');
        var dataString = 'op='+op+'&iden='+iden+'&user='+user;

        $.ajax({
            type: "POST",
            url: "system/user/redirect.php",
            data: dataString,
            beforeSend: function () {
               $("#avatar-select").html('<div class="row justify-content-md-center" ><img src="assets/img/load.gif" alt=""></div>');
            },
            success: function(data) {            
				$("#avatar-select").html(data);
            }
        });
    });   
/// avatar






});