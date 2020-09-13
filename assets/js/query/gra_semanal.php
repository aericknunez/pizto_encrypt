<?php 
$hoy = date("d-m-Y");
$dia1 = Fechas::DiaResta(date("d-m-Y"),1);
$dia2 = Fechas::DiaResta(date("d-m-Y"),2);
$dia3 = Fechas::DiaResta(date("d-m-Y"),3);
$dia4 = Fechas::DiaResta(date("d-m-Y"),4);
$dia5 = Fechas::DiaResta(date("d-m-Y"),5);
$dia6 = Fechas::DiaResta(date("d-m-Y"),6);
 
 ?>


<script>

<?php 
if($_REQUEST["t"]=="bar"){
 ?>
 //bar
var ctxB = document.getElementById("barChart").getContext('2d');
var myBarChart = new Chart(ctxB, {
    type: 'bar',
    data: {
        labels: [
              "<?php echo Fechas::NombreDia($dia6); ?>", 
              "<?php echo Fechas::NombreDia($dia5); ?>", 
              "<?php echo Fechas::NombreDia($dia4); ?>", 
              "<?php echo Fechas::NombreDia($dia3); ?>", 
              "<?php echo Fechas::NombreDia($dia2); ?>", 
              "<?php echo Fechas::NombreDia($dia1); ?>", 
              "<?php echo Fechas::NombreDia($hoy); ?>"
        ],
        datasets: [{

          <?php 
            if($_REQUEST["d"]==1){
             ?>
            label: 'Ventas',
            data: [
            <?php echo Helpers::Entero(Corte::VentaHoy($dia6)); ?>, 
            <?php echo Helpers::Entero(Corte::VentaHoy($dia5)); ?>, 
            <?php echo Helpers::Entero(Corte::VentaHoy($dia4)); ?>, 
            <?php echo Helpers::Entero(Corte::VentaHoy($dia3)); ?>, 
            <?php echo Helpers::Entero(Corte::VentaHoy($dia2)); ?>, 
            <?php echo Helpers::Entero(Corte::VentaHoy($dia1)); ?>, 
            <?php echo Helpers::Entero(Corte::VentaHoy($hoy)); ?>
            <?php 
             }
            if($_REQUEST["d"]==2){
             ?>
              label: "Gastos",
              data: [
              <?php echo Helpers::Entero(Corte::GastoHoy($dia6)); ?>, 
              <?php echo Helpers::Entero(Corte::GastoHoy($dia5)); ?>, 
              <?php echo Helpers::Entero(Corte::GastoHoy($dia4)); ?>, 
              <?php echo Helpers::Entero(Corte::GastoHoy($dia3)); ?>, 
              <?php echo Helpers::Entero(Corte::GastoHoy($dia2)); ?>, 
              <?php echo Helpers::Entero(Corte::GastoHoy($dia1)); ?>, 
              <?php echo Helpers::Entero(Corte::GastoHoy($hoy)); ?>
            <?php } ?>
            ],
            backgroundColor: [
                'rgba(255, 99, 132, 0.2)',
                'rgba(54, 162, 235, 0.2)',
                'rgba(255, 206, 86, 0.2)',
                'rgba(75, 192, 192, 0.2)',
                'rgba(153, 102, 255, 0.2)',
                'rgba(255, 159, 64, 0.2)'
            ],
            borderColor: [
                'rgba(255,99,132,1)',
                'rgba(54, 162, 235, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(153, 102, 255, 1)',
                'rgba(255, 159, 64, 1)'
            ],
            borderWidth: 1
        }]
    },
    options: {
        scales: {
            yAxes: [{
                ticks: {
                    beginAtZero:true
                }
            }]
        }
    }
});

<?php } else {
 ?>  
//line
var ctxL = document.getElementById("Gsemanal").getContext('2d');
var myLineChart = new Chart(ctxL, {
  type: 'line',
  data: {
    labels: [
    "<?php echo Fechas::NombreDia($dia6); ?>", 
    "<?php echo Fechas::NombreDia($dia5); ?>", 
    "<?php echo Fechas::NombreDia($dia4); ?>", 
    "<?php echo Fechas::NombreDia($dia3); ?>", 
    "<?php echo Fechas::NombreDia($dia2); ?>", 
    "<?php echo Fechas::NombreDia($dia1); ?>", 
    "<?php echo Fechas::NombreDia($hoy); ?>"
    ],
    datasets: [{
        label: "Ventas",
        data: [
        <?php echo Helpers::Entero(Corte::VentaHoy($dia6)); ?>, 
        <?php echo Helpers::Entero(Corte::VentaHoy($dia5)); ?>, 
        <?php echo Helpers::Entero(Corte::VentaHoy($dia4)); ?>, 
        <?php echo Helpers::Entero(Corte::VentaHoy($dia3)); ?>, 
        <?php echo Helpers::Entero(Corte::VentaHoy($dia2)); ?>, 
        <?php echo Helpers::Entero(Corte::VentaHoy($dia1)); ?>, 
        <?php echo Helpers::Entero(Corte::VentaHoy($hoy)); ?>
        ],
        backgroundColor: [
          'rgba(105, 0, 132, .2)',
        ],
        borderColor: [
          'rgba(200, 99, 132, .7)',
        ],
        borderWidth: 2
      },
      {
        label: "Gastos",
        data: [
        <?php echo Helpers::Entero(Corte::GastoHoy($dia6)); ?>, 
        <?php echo Helpers::Entero(Corte::GastoHoy($dia5)); ?>, 
        <?php echo Helpers::Entero(Corte::GastoHoy($dia4)); ?>, 
        <?php echo Helpers::Entero(Corte::GastoHoy($dia3)); ?>, 
        <?php echo Helpers::Entero(Corte::GastoHoy($dia2)); ?>, 
        <?php echo Helpers::Entero(Corte::GastoHoy($dia1)); ?>, 
        <?php echo Helpers::Entero(Corte::GastoHoy($hoy)); ?>
        ],
        backgroundColor: [
          'rgba(0, 137, 132, .2)',
        ],
        borderColor: [
          'rgba(0, 10, 130, .7)',
        ],
        borderWidth: 2
      }
    ]
  },
  options: {
    responsive: true
  }
});

<?php } ?>  
</script>
