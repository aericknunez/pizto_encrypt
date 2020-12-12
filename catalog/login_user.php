<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Ingresar al Sistema</title>

    <link rel="stylesheet" href="assets/css/font-awesome.css">
    <link href="assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/css/mdb.min.css" rel="stylesheet">
    <link href="assets/css/galeria.css" rel="stylesheet">

    <style>body { overflow-x: hidden; padding-left: 15px; }</style>
</head>

<body class="hidden-sn <?php echo SKIN; ?>">
<main id="todocontenido">

<div id="mdb-preloader" class="flex-center">
    <div class="preloader-wrapper big active crazy">
        <div class="spinner-layer spinner-blue-only">
          <div class="circle-clipper left">
            <div class="circle"></div>
          </div>
          <div class="gap-patch">
            <div class="circle"></div>
          </div>
          <div class="circle-clipper right">
            <div class="circle"></div>
          </div>
        </div>
      </div>
</div>

<!-- <div class="container"> -->
<div class="row">

	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">


<!-- Section: Team v.1 -->
<section class="team-section text-center">
  <!-- Grid row -->
  <div class="row d-flex justify-content-center">

<?php 
    $a = $db->query("SELECT * FROM login_members WHERE id != '1' and id != '2'");
    if($a->num_rows > 0){
    foreach ($a as $b) {
    	$user=$b['username'];
    if ($r = $db->select("nombre, avatar", "login_userdata", "WHERE user = '$user'")) { 
        $nombre=$r["nombre"]; $avatar= $r["avatar"];
    	} unset($r); 

        echo '<div class="col-lg-2 col-md-2 mb-lg-1 mb-5">
        <div class="avatar mx-auto">
		     <a id="login" email="'.$b['email'].'" avatar="'.$avatar.'">
		        <img src="assets/img/avatar/'.$avatar.'" class="rounded-circle z-depth-3"
		          alt="Sample avatar">
		      </a>
		      </div>
		      <h5 class="font-weight-bold mt-2 mb-0">'.$nombre.'</h5>
		      <small>' . $b["email"] . '</small>
          </a>
		    </div>';
    }  $a->close();
 ?>
   </div>
  <!-- Grid row -->

  <?php
if (isset($_GET['error'])) {
    echo '<p class="text-danger">Error al Ingresar!</p>';
}
} else {
  echo '<div class="row col-md-4 col-lg-4 d-flex justify-content-center">
  <blockquote class="blockquote bq-success">
  <p class="bq-title">Aviso!</p>
  <p>Aún no se encuentran usuarios registrados. Favor Inicie Sesión como administardor y agregue usuarios del sistema
  </p>
</blockquote>

  <a class="btn btn-secondary" href="?change">Iniciar</a></div>';
}
?>

</section>
<!-- Section: Team v.1 -->


	</div>

</div>
<!-- </div> -->


<a href="?change">Cambiar inicio</a>
</main>

    <script type="text/javascript" src="assets/js/jquery-3.3.1.min.js"></script>
    <script type="text/javascript" src="assets/js/popper.min.js"></script>
    <script type="text/javascript" src="assets/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="assets/js/mdb.min.js"></script>
 

<!--Modal Form Login with Avatar Demo-->
<div class="modal bounceIn" id="ModalLogin" tabindex="-1" role="dialog" aria-labelledby="ModalLogin" aria-hidden="true" data-backdrop="false">
    <div class="modal-dialog cascading-modal modal-avatar modal-sm" role="document">
        <!--Content-->
<div class="modal-content">

<!--Header-->
<div class="modal-header">
<img id="avatar" class="rounded-circle img-responsive" alt="Avatar photo" >
</div>
<!--Body-->
<div class="modal-body text-center mb-1">

  <form name="form-login" id="form-login"> 
   <input type="hidden" name="email" id="email" />

<div class="col-xs-2">
  <input type="password" name="password" id="password" class="form-control" autocomplete="off" />
  <button id="show_password" class="btn btn-primary" type="button">
  <span class="fa fa-eye-slash icon"></span>
  </button>
</div>


<button class="btn btn-info my-4" type="submit" id="btn-login" name="btn-login">Ingresar</button>
</form>
<img src="assets/img/loading (1).gif" width="0" height="0">
<div id="msj"></div>

</div>
<div class="modal-footer">
<a id="cerrarModal" class="btn btn-secondary">Cancelar</a>
</div>
          
    </div>
    <!--/.Content-->
</div>
</div>
<div id="cssnegro"></div>
<!--Modal Form Login with Avatar Demo-->

<!-- <style>
    body { 
        background-color: black; /* La página de fondo será negra */
        color: 000; 
      }
</style> -->
 <script>
$(document).ready(function(){

    $("body").on("click","#login",function(){

        $("#ModalLogin").modal("show");

        var email = $(this).attr('email');
        var avatar = $(this).attr('avatar');

        $('#email').attr("value", email);
        $('#avatar').attr("src", 'assets/img/avatar/' + avatar);


        $("body").css("background","#000");
        $("main").hide();

    });      
    
    $("body").on("click","#cerrarModal",function(){

        $("#ModalLogin").modal("hide");
         $("body").css("background","#FFF");
         $("main").show();
    });

  


        $('#show_password').hover(function show() {
          //Cambiar el atributo a texto
          $('#password').attr('type', 'text');
          $('.icon').removeClass('fa fa-eye-slash').addClass('fa fa-eye');
      },

      function () {
          //Cambiar el atributo a contraseña
          $('#password').attr('type', 'password');
          $('.icon').removeClass('fa fa-eye').addClass('fa fa-eye-slash');
      });
      //CheckBox mostrar contraseña
      
      $('#ShowPassword').click(function () {
          $('#Password').attr('type', $(this).is(':checked') ? 'text' : 'password');
      });

});
</script>


<script>
      $(window).on("load", function () {
        $('#mdb-preloader').fadeOut('fast');
    });
</script>

<script type="text/javascript" src="system/user/login.js"></script>

</body>
</html>

