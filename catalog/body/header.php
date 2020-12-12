<body class="hidden-sn <?php echo $_SESSION['config_skin']; ?>">
    
<!-- preloader -->
<!-- 
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
</div> -->

<!--   <div class="md-progress primary-color-dark">
    <div class="indeterminate"></div>
  </div> -->

<!-- proloader -->


<!-- white-skin , mdb-skin , grey-skin , pink-skin ,  light-blue-skin , black-skin  cyan-skin, navy-blue-skin -->
<!--Double navigation-->
<header>
<!-- Sidebar navigation -->
<div id="slide-out" class="side-nav sn-bg-4 custom-scrollbar">
<ul class="custom-scrollbar" id="menuconscroll">
    <!-- Logo -->
    <li>
        <div class="logo-wrapper waves-light">
            <a href="?"><img src="assets/img/logo/<?php echo $_SESSION['config_logo'] ?>" class="img-fluid flex-center"></a>
        </div>
    </li>
    <!--/. Logo -->

    <!--Search Form-->
    <li>
        <form class="search-form" role="search" method="post" action="?search">
            <div class="form-group md-form mt-0 pt-1 waves-light">
                <input type="text" class="form-control" placeholder="Buscar Factura" id="search" name="search">
            </div>
        </form>
    </li>
    <!--/.Search Form-->
    <!-- Side navigation links -->
<ul class="collapsible collapsible-accordion">
    
<?php include_once 'menu.php'; ?>
    <hr>
    <small> Powered By</small>  
    <a href="https://www.hibridosv.com" target="_blank"><img src="assets/img/logo/lgb.png" class="img-fluid flex-center"></a>
    <!--/. Side navigation links -->
</ul>
<div class="sidenav-bg mask-strong"></div>
</div>
<!--/. Sidebar navigation -->

<!-- //////////////////////////////////// -->

<!-- Navbar -->
<nav class="navbar fixed-top navbar-toggleable-md navbar-expand-lg scrolling-navbar double-nav">
<!-- SideNav slide-out button -->
<div class="float-left">
    <a href="#" data-activates="slide-out" class="button-collapse"><i class="fas fa-bars"></i></a>
</div>
<!-- Breadcrumb-->
<div class="breadcrumb-dn mr-auto">
    <p><?php echo $_SESSION["nombre"]; ?></p>
</div>

            <ul class="nav navbar-nav nav-flex-icons ml-auto">

<?php if($_SESSION["tipo_cuenta"] == 1 or $_SESSION["tipo_cuenta"] == 2 or $_SESSION["tipo_cuenta"] == 3 or ($_SESSION["tipo_cuenta"] == 5 and $_SESSION["tx"] != 13)) { ?>
                <li class="nav-item">
                    <a id="cambiar-pantalla-inicio" op="28" class="nav-link"><i class="fas fa-truck"></i></a>
                </li>

<?php } ?>
                
<?php if($_SESSION["tipo_cuenta"] == 1 or $_SESSION["tipo_cuenta"] == 2 or $_SESSION["tipo_cuenta"] == 3 or $_SESSION["tipo_cuenta"] == 5) {

                if($_SESSION['root_tipo_sistema'] != 1){ ?>    
                    <li class="nav-item">
                    <a id="cambiar-pantalla-inicio" op="26" class="nav-link"><i class="<?php if($_SESSION["tipo_inicio"] == 1) echo "fas fa-tv"; else { echo "fas fa-coffee"; } ?>"></i></a>
                </li>
                <?php }
                if($_SESSION['config_cambio_tx'] != NULL){ ?>
                <li class="nav-item">
                    <a id="cambiar-pantalla-inicio" op="27" class="nav-link"><i class="<?php if( $_SESSION["tx"] == 0) echo "fas fa-battery-empty"; else { echo "fas fa-battery-full"; } ?>"></i></a>
                </li>
                <?php } 
                } ?>
                <li class="nav-item">
                    <a href="?" class="nav-link"><i class="fas fa-home"></i> <span class="clearfix d-none d-sm-inline-block">Inicio</span></a>
                </li> 

            </ul>
            
</nav>
<!-- /.Navbar -->
</header>

<main>