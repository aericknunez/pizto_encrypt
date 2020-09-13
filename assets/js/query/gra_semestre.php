<?php 
$hoy = Fechas::MesResta(date("d-m-Y"),0);
$dia1 = Fechas::MesResta(date("d-m-Y"),1);
$dia2 = Fechas::MesResta(date("d-m-Y"),2);
$dia3 = Fechas::MesResta(date("d-m-Y"),3);
$dia4 = Fechas::MesResta(date("d-m-Y"),4);
$dia5 = Fechas::MesResta(date("d-m-Y"),5);
$dia6 = Fechas::MesResta(date("d-m-Y"),6);
 
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
              "<?php echo Fechas::MesEscrito($dia6); ?>", 
              "<?php echo Fechas::MesEscrito($dia5); ?>", 
              "<?php echo Fechas::MesEscrito($dia4); ?>", 
              "<?php echo Fechas::MesEscrito($dia3); ?>", 
              "<?php echo Fechas::MesEscrito($dia2); ?>", 
              "<?php echo Fechas::MesEscrito($dia1); ?>", 
              "<?php echo Fechas::MesEscrito($hoy); ?>"
        ],
        datasets: [{

          <?php 
            if($_REQUEST["d"]==1){
             ?>
            label: 'Ventas',
            data: [
            <?php echo Helpers::Entero(Corte::VentaMes($dia6)); ?>, 
            <?php echo Helpers::Entero(Corte::VentaMes($dia5)); ?>, 
            <?php echo Helpers::Entero(Corte::VentaMes($dia4)); ?>, 
            <?php echo Helpers::Entero(Corte::VentaMes($dia3)); ?>, 
            <?php echo Helpers::Entero(Corte::VentaMes($dia2)); ?>, 
            <?php echo Helpers::Entero(Corte::VentaMes($dia1)); ?>, 
            <?php echo Helpers::Entero(Corte::VentaMes($hoy)); ?>
            <?php 
             }
            if($_REQUEST["d"]==2){
             ?>
              label: "Gastos",
              data: [
              <?php echo Helpers::Entero(Corte::GastoMes($dia6)); ?>, 
              <?php echo Helpers::Entero(Corte::GastoMes($dia5)); ?>, 
              <?php echo Helpers::Entero(Corte::GastoMes($dia4)); ?>, 
              <?php echo Helpers::Entero(Corte::GastoMes($dia3)); ?>, 
              <?php echo Helpers::Entero(Corte::GastoMes($dia2)); ?>, 
              <?php echo Helpers::Entero(Corte::GastoMes($dia1)); ?>, 
              <?php echo Helpers::Entero(Corte::GastoMes($hoy)); ?>
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
    "<?php echo Fechas::MesEscrito($dia6); ?>", 
    "<?php echo Fechas::MesEscrito($dia5); ?>", 
    "<?php echo Fechas::MesEscrito($dia4); ?>", 
    "<?php echo Fechas::MesEscrito($dia3); ?>", 
    "<?php echo Fechas::MesEscrito($dia2); ?>", 
    "<?php echo Fechas::MesEscrito($dia1); ?>", 
    "<?php echo Fechas::MesEscrito($hoy); ?>"
    ],
    datasets: [{
        label: "Ventas",
        data: [
        <?php echo Helpers::Entero(Corte::VentaMes($dia6)); ?>, 
        <?php echo Helpers::Entero(Corte::VentaMes($dia5)); ?>, 
        <?php echo Helpers::Entero(Corte::VentaMes($dia4)); ?>, 
        <?php echo Helpers::Entero(Corte::VentaMes($dia3)); ?>, 
        <?php echo Helpers::Entero(Corte::VentaMes($dia2)); ?>, 
        <?php echo Helpers::Entero(Corte::VentaMes($dia1)); ?>, 
        <?php echo Helpers::Entero(Corte::VentaMes($hoy)); ?>
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
        <?php echo Helpers::Entero(Corte::GastoMes($dia6)); ?>, 
        <?php echo Helpers::Entero(Corte::GastoMes($dia5)); ?>, 
        <?php echo Helpers::Entero(Corte::GastoMes($dia4)); ?>, 
        <?php echo Helpers::Entero(Corte::GastoMes($dia3)); ?>, 
        <?php echo Helpers::Entero(Corte::GastoMes($dia2)); ?>, 
        <?php echo Helpers::Entero(Corte::GastoMes($dia1)); ?>, 
        <?php echo Helpers::Entero(Corte::GastoMes($hoy)); ?>
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
