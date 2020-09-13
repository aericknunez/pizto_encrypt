$(document).ready(function(){

/// data tables
	$('#dtMaterialDesignExample').DataTable();
	$('#dtMaterialDesignExample_wrapper').find('label').each(function () {
	$(this).parent().append($(this).children());
	});
	$('#dtMaterialDesignExample_wrapper .dataTables_filter').find('input').each(function () {
	$('input').attr("placeholder", "Search");
	$('input').removeClass('form-control-sm');
	});
	$('#dtMaterialDesignExample_wrapper .dataTables_length').addClass('d-flex flex-row');
	$('#dtMaterialDesignExample_wrapper .dataTables_filter').addClass('md-form');
	$('#dtMaterialDesignExample_wrapper select').removeClass(
	'custom-select custom-select-sm form-control form-control-sm');
	$('#dtMaterialDesignExample_wrapper select').addClass('mdb-select');
	$('#dtMaterialDesignExample_wrapper .mdb-select').materialSelect();
	$('#dtMaterialDesignExample_wrapper .dataTables_filter').find('label').remove();
////////////
///
///



	$("body").on("click","#delproveedor",function(){ // borrar categoria
	var op = $(this).attr('op');
	var hash = $(this).attr('hash');
	    $.post("application/src/routes.php", {op:op, hash:hash}, function(data){
		$("#destinoproveedor").html(data);
	   	 });
	});


}); // termina query