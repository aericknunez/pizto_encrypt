
    <script type="text/javascript" src="assets/js/jquery-3.4.1.min.js"></script>

    <script type="text/javascript" src="assets/js/popper.min.js"></script>

    <script type="text/javascript" src="assets/js/bootstrap.min.js"></script>

    <script type="text/javascript" src="assets/js/mdb.min.js"></script>
    <script type="text/javascript" src="assets/js/scrollbar.js"></script>

    <script>
        // SideNav Initialization
        $(".button-collapse").sideNav();
            var el =  document.getElementById('menuconscroll')
            var ps = new PerfectScrollbar(el);
        
        new WOW().init();
       </script>
    
    <!-- carga el query correcto -->
    <?php include_once 'application/src/query.php' ?> 


