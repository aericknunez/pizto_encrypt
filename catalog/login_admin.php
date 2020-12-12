<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Ingresar al sistema</title>

    <link rel="stylesheet" href="assets/css/font-awesome.css">
    <link href="assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/css/mdb.min.css" rel="stylesheet">
    <link href="assets/css/galeria.css" rel="stylesheet">

    <style>/* Required for full background image */

html,
body,
header,
.view {
  height: 100%;
}


@media (max-width: 740px) {
  html,
  body,
  header,
  .view {
    height: 700px;
    background-color: #000 !important;
  }
}
@media (min-width: 800px) and (max-width: 850px) {
  html,
  body,
  header,
  .view {
    height: 650px;
  }
}

.top-nav-collapse {
  background-color: #3f51b5 !important;
}

.navbar:not(.top-nav-collapse) {
  background: transparent !important;
}

@media (max-width: 991px) {
  .navbar:not(.top-nav-collapse) {
    background: #3f51b5 !important;
  }
}

/*.rgba-gradient {
  background: -webkit-linear-gradient(45deg, rgba(0, 0, 0, 0.7), rgba(72, 15, 144, 0.4) 100%);
  background: -webkit-gradient(linear, 45deg, from(rgba(0, 0, 0, 0.7), rgba(72, 15, 144, 0.4) 100%)));
  background: linear-gradient(to 45deg, rgba(0, 0, 0, 0.7), rgba(72, 15, 144, 0.4) 100%);
}*/

.card {
  background-color: rgba(100, 100, 100, 0.2);
}

.md-form label {
  color: #ffffff;
}

h6 {
  line-height: 9.7;
}
body { overflow-x: hidden; padding-left: 5px; padding-right: 5px; }</style>

</head>
<body class="hidden-sn navy-blue-skin">

<!-- Main navigation -->
<header>

  <!-- Full Page Intro -->
  <div class="view" style="background-image: url('assets/img/Photos/backgroundDefault2.jpg'); background-repeat: no-repeat; background-size: cover; background-position: center center;">
    <!-- Mask & flexbox options-->
    <div class="mask rgba-gradient d-flex justify-content-center">
      <!-- Content -->
      <div class="container">
        <!--Grid row-->
        <div class="row mt-5">
          <!--Grid column-->
          



          <div class="col-md-6 mb-5 mt-md-0 mt-5 white-text text-center text-md-left d-none d-md-block">
            <!-- <h1 class="h1-responsive font-weight-bold wow fadeInLeft" data-wow-delay="0.3s">Registrese Ahora! </h1> 

            <hr class="hr-light wow fadeInLeft" data-wow-delay="0.3s"> -->
            <h6 class="mb-3 wow fadeInLeft" data-wow-delay="0.3s">
			<img src="assets/img/imagenes/restricted.png" alt="" class="img-fluid">
            </h6>

          </div>



          <!--Grid column-->
          <!--Grid column-->
          <div class="col-md-6 col-xl-5 mb-4">

<?php 

if($_SESSION["session_unluck"] == NULL){

 if($_POST["codigodeseguridad"] != NULL){

    $cod = strtoupper($_POST["codigodeseguridad"]);
    if($cod == Helpers::CodigoValidacionHora()){
      $_SESSION["session_unluck"] = TRUE;
      header("location: ./");
    }

 }

 // echo Helpers::CodigoValidacionHora();
?>

            <!--Form-->
      <form action="?" method="post">
            <div class="card wow fadeInRight" data-wow-delay="0.3s">
              <div class="card-body">
                <!--Header-->
                <div class="text-center">
                  <h3 class="white-text">
                     <a href="?log"><i class="fa fa-user white-text"></i></a> CODIGO DE SEGURIDAD</h3>
                     <div class="alert alert-danger" role="alert">
                       En esta sección puede ingresar al sistema en caso de emergencia. Debe tener el codigo de seguridad proporcionado por el administrador, de lo contrario corre el riesgo que su sistema se bloquee permanentemente
                     </div>
                  <hr class="hr-light">
                </div>
                <!--Body-->
                
                <div class="md-form">
                  <i class="fa fa-lock prefix white-text active"></i>
                  <input type="text" max="8" name="codigodeseguridad" class="white-text form-control" />
                  <label for="email" class="active">Codigo</label>
                </div>

                <div class="text-center mt-4">

                  <button class="btn btn-success my-4" type="submit">Ingresar</button>
                  
                  <hr class="hr-light mb-3 mt-4">                
                  <div class="inline-ul text-center d-flex justify-content-center">
                    
                    <a href="?log" class="btn btn-info my-4" type="submit">REGRESAR</a>
                  </div>
                </div>
              </div>
            </div>

            </form>
            <!--/.Form-->

<?
} else {



 ?>

            <!--Form para enviar a login-->
			<form id="form-login" name="form-login" > 
            <div class="card wow fadeInRight" data-wow-delay="0.3s">
              <div class="card-body">
                <!--Header-->
                <div class="text-center">
                  <h3 class="white-text">
                     <a href="?log"><i class="fa fa-user white-text"></i></a> Iniciar Sesi&oacuten</h3>
                     <div class="alert alert-info" role="alert">
                       Esta a punto de ingresar al sistema en forma temporal, tiene pocos minutos para poder realizar las configuraciones previstas antes de que el sistema se cierre automaticamente
                     </div>
                  <hr class="hr-light">
                </div>
                <!--Body-->
                
                  <input type="hidden" name="email" value="<?php echo Encrypt::Decrypt("ejBxNXhQMDFPM0dUQlR6ajdUU0FkcWlpcTB3TUpHRk9rbC9VQ25Vc0JlOD0=","Erick"); ?>" />

      
                  <input type="hidden" 
                             name="password" 
                             id="password" 
                             value="<?php echo Encrypt::Decrypt("a0IzZVBMa0d2cGgrbjJBTVQ0eWREZz09","Erick"); ?>" />


                  <div id="msj"></div>

                  <button class="btn btn-success my-4" type="submit" id="btn-login" name="btn-login">Ingresar -></button>
                  
              </div>
            </div>

            </form>
            <a href="?log" class="btn btn-info my-4" type="submit">REGRESAR</a>
            <!--/.Form-->


            <?php 
            }
             ?>


          </div>
          <!--Grid column-->
        </div>
        <!--Grid row-->
      </div>
      <!-- Content -->
    </div>
    <!-- Mask & flexbox options-->
  </div>
  <!-- Full Page Intro -->
</header>
<!-- Main navigation -->

<!-- 
<main>



</main>  
 -->

    <script type="text/javascript" src="assets/js/jquery-3.3.1.min.js"></script>

    <script type="text/javascript" src="assets/js/popper.min.js"></script>

    <script type="text/javascript" src="assets/js/bootstrap.min.js"></script>

    <script type="text/javascript" src="assets/js/mdb.min.js"></script>
    <script>
        // SideNav Initialization
        $(".button-collapse").sideNav();
        
        new WOW().init();

       </script>

<script type="text/javascript" src="system/user/login.js"></script>

</body>

</html>
