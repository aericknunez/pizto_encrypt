<?php 
$hoy = date("d-m-Y");
$dia1 = Fechas::DiaResta(date("d-m-Y"),1);
$dia2 = Fechas::DiaResta(date("d-m-Y"),2);
$dia3 = Fechas::DiaResta(date("d-m-Y"),3);
$dia4 = Fechas::DiaResta(date("d-m-Y"),4);
$dia5 = Fechas::DiaResta(date("d-m-Y"),5);
$dia6 = Fechas::DiaResta(date("d-m-Y"),6);
$dia7 = Fechas::DiaResta(date("d-m-Y"),7);
$dia8 = Fechas::DiaResta(date("d-m-Y"),8);
$dia9 = Fechas::DiaResta(date("d-m-Y"),9);
$dia10 = Fechas::DiaResta(date("d-m-Y"),10);
$dia11 = Fechas::DiaResta(date("d-m-Y"),11);
$dia12 = Fechas::DiaResta(date("d-m-Y"),12);
$dia13 = Fechas::DiaResta(date("d-m-Y"),13);
$dia14 = Fechas::DiaResta(date("d-m-Y"),14);
$dia15 = Fechas::DiaResta(date("d-m-Y"),15);
$dia16 = Fechas::DiaResta(date("d-m-Y"),16);
$dia17 = Fechas::DiaResta(date("d-m-Y"),17);
$dia18 = Fechas::DiaResta(date("d-m-Y"),18);
$dia19 = Fechas::DiaResta(date("d-m-Y"),19);
$dia20 = Fechas::DiaResta(date("d-m-Y"),20);
$dia21 = Fechas::DiaResta(date("d-m-Y"),21);
$dia22 = Fechas::DiaResta(date("d-m-Y"),22);
$dia23 = Fechas::DiaResta(date("d-m-Y"),23);
$dia24 = Fechas::DiaResta(date("d-m-Y"),24);
$dia25 = Fechas::DiaResta(date("d-m-Y"),25);
$dia26 = Fechas::DiaResta(date("d-m-Y"),26);
$dia27 = Fechas::DiaResta(date("d-m-Y"),27);
$dia28 = Fechas::DiaResta(date("d-m-Y"),28);
$dia29 = Fechas::DiaResta(date("d-m-Y"),29);
$dia30 = Fechas::DiaResta(date("d-m-Y"),30);
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
              "<?php echo Fechas::NombreDia($dia30); ?>", 
              "<?php echo Fechas::NombreDia($dia29); ?>", 
              "<?php echo Fechas::NombreDia($dia28); ?>",
              "<?php echo Fechas::NombreDia($dia27); ?>", 
              "<?php echo Fechas::NombreDia($dia26); ?>", 
              "<?php echo Fechas::NombreDia($dia25); ?>", 
              "<?php echo Fechas::NombreDia($dia24); ?>", 
              "<?php echo Fechas::NombreDia($dia23); ?>", 
              "<?php echo Fechas::NombreDia($dia22); ?>", 
              "<?php echo Fechas::NombreDia($dia21); ?>",
              "<?php echo Fechas::NombreDia($dia20); ?>", 
              "<?php echo Fechas::NombreDia($dia19); ?>", 
              "<?php echo Fechas::NombreDia($dia18); ?>", 
              "<?php echo Fechas::NombreDia($dia17); ?>", 
              "<?php echo Fechas::NombreDia($dia16); ?>", 
              "<?php echo Fechas::NombreDia($dia15); ?>", 
              "<?php echo Fechas::NombreDia($dia14); ?>",
              "<?php echo Fechas::NombreDia($dia13); ?>", 
              "<?php echo Fechas::NombreDia($dia12); ?>", 
              "<?php echo Fechas::NombreDia($dia11); ?>", 
              "<?php echo Fechas::NombreDia($dia10); ?>", 
              "<?php echo Fechas::NombreDia($dia9); ?>", 
              "<?php echo Fechas::NombreDia($dia8); ?>", 
              "<?php echo Fechas::NombreDia($dia7); ?>",
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
            <?php echo Helpers::Entero(Corte::VentaHoy($dia30)); ?>, 
            <?php echo Helpers::Entero(Corte::VentaHoy($dia29)); ?>, 
            <?php echo Helpers::Entero(Corte::VentaHoy($dia28)); ?>,
            <?php echo Helpers::Entero(Corte::VentaHoy($dia27)); ?>, 
            <?php echo Helpers::Entero(Corte::VentaHoy($dia26)); ?>, 
            <?php echo Helpers::Entero(Corte::VentaHoy($dia25)); ?>, 
            <?php echo Helpers::Entero(Corte::VentaHoy($dia24)); ?>, 
            <?php echo Helpers::Entero(Corte::VentaHoy($dia23)); ?>, 
            <?php echo Helpers::Entero(Corte::VentaHoy($dia22)); ?>, 
            <?php echo Helpers::Entero(Corte::VentaHoy($dia21)); ?>,
            <?php echo Helpers::Entero(Corte::VentaHoy($dia20)); ?>, 
            <?php echo Helpers::Entero(Corte::VentaHoy($dia19)); ?>, 
            <?php echo Helpers::Entero(Corte::VentaHoy($dia18)); ?>, 
            <?php echo Helpers::Entero(Corte::VentaHoy($dia17)); ?>, 
            <?php echo Helpers::Entero(Corte::VentaHoy($dia16)); ?>, 
            <?php echo Helpers::Entero(Corte::VentaHoy($dia15)); ?>, 
            <?php echo Helpers::Entero(Corte::VentaHoy($dia14)); ?>,
            <?php echo Helpers::Entero(Corte::VentaHoy($dia13)); ?>, 
            <?php echo Helpers::Entero(Corte::VentaHoy($dia12)); ?>, 
            <?php echo Helpers::Entero(Corte::VentaHoy($dia11)); ?>, 
            <?php echo Helpers::Entero(Corte::VentaHoy($dia10)); ?>, 
            <?php echo Helpers::Entero(Corte::VentaHoy($dia9)); ?>, 
            <?php echo Helpers::Entero(Corte::VentaHoy($dia8)); ?>, 
            <?php echo Helpers::Entero(Corte::VentaHoy($dia7)); ?>,
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
              <?php echo Helpers::Entero(Corte::GastoHoy($dia30)); ?>, 
              <?php echo Helpers::Entero(Corte::GastoHoy($dia29)); ?>, 
              <?php echo Helpers::Entero(Corte::GastoHoy($dia28)); ?>,
              <?php echo Helpers::Entero(Corte::GastoHoy($dia27)); ?>, 
              <?php echo Helpers::Entero(Corte::GastoHoy($dia26)); ?>, 
              <?php echo Helpers::Entero(Corte::GastoHoy($dia25)); ?>, 
              <?php echo Helpers::Entero(Corte::GastoHoy($dia24)); ?>, 
              <?php echo Helpers::Entero(Corte::GastoHoy($dia23)); ?>, 
              <?php echo Helpers::Entero(Corte::GastoHoy($dia22)); ?>, 
              <?php echo Helpers::Entero(Corte::GastoHoy($dia21)); ?>,
              <?php echo Helpers::Entero(Corte::GastoHoy($dia20)); ?>, 
              <?php echo Helpers::Entero(Corte::GastoHoy($dia19)); ?>, 
              <?php echo Helpers::Entero(Corte::GastoHoy($dia18)); ?>, 
              <?php echo Helpers::Entero(Corte::GastoHoy($dia17)); ?>, 
              <?php echo Helpers::Entero(Corte::GastoHoy($dia16)); ?>, 
              <?php echo Helpers::Entero(Corte::GastoHoy($dia15)); ?>, 
              <?php echo Helpers::Entero(Corte::GastoHoy($dia14)); ?>,
              <?php echo Helpers::Entero(Corte::GastoHoy($dia13)); ?>, 
              <?php echo Helpers::Entero(Corte::GastoHoy($dia12)); ?>, 
              <?php echo Helpers::Entero(Corte::GastoHoy($dia11)); ?>, 
              <?php echo Helpers::Entero(Corte::GastoHoy($dia10)); ?>, 
              <?php echo Helpers::Entero(Corte::GastoHoy($dia9)); ?>, 
              <?php echo Helpers::Entero(Corte::GastoHoy($dia8)); ?>, 
              <?php echo Helpers::Entero(Corte::GastoHoy($dia7)); ?>,
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
              "<?php echo Fechas::NombreDia($dia30); ?>", 
              "<?php echo Fechas::NombreDia($dia29); ?>", 
              "<?php echo Fechas::NombreDia($dia28); ?>",
              "<?php echo Fechas::NombreDia($dia27); ?>", 
              "<?php echo Fechas::NombreDia($dia26); ?>", 
              "<?php echo Fechas::NombreDia($dia25); ?>", 
              "<?php echo Fechas::NombreDia($dia24); ?>", 
              "<?php echo Fechas::NombreDia($dia23); ?>", 
              "<?php echo Fechas::NombreDia($dia22); ?>", 
              "<?php echo Fechas::NombreDia($dia21); ?>",
              "<?php echo Fechas::NombreDia($dia20); ?>", 
              "<?php echo Fechas::NombreDia($dia19); ?>", 
              "<?php echo Fechas::NombreDia($dia18); ?>", 
              "<?php echo Fechas::NombreDia($dia17); ?>", 
              "<?php echo Fechas::NombreDia($dia16); ?>", 
              "<?php echo Fechas::NombreDia($dia15); ?>", 
              "<?php echo Fechas::NombreDia($dia14); ?>",
              "<?php echo Fechas::NombreDia($dia13); ?>", 
              "<?php echo Fechas::NombreDia($dia12); ?>", 
              "<?php echo Fechas::NombreDia($dia11); ?>", 
              "<?php echo Fechas::NombreDia($dia10); ?>", 
              "<?php echo Fechas::NombreDia($dia9); ?>", 
              "<?php echo Fechas::NombreDia($dia8); ?>", 
              "<?php echo Fechas::NombreDia($dia7); ?>",
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
            <?php echo Helpers::Entero(Corte::VentaHoy($dia30)); ?>, 
            <?php echo Helpers::Entero(Corte::VentaHoy($dia29)); ?>, 
            <?php echo Helpers::Entero(Corte::VentaHoy($dia28)); ?>,
            <?php echo Helpers::Entero(Corte::VentaHoy($dia27)); ?>, 
            <?php echo Helpers::Entero(Corte::VentaHoy($dia26)); ?>, 
            <?php echo Helpers::Entero(Corte::VentaHoy($dia25)); ?>, 
            <?php echo Helpers::Entero(Corte::VentaHoy($dia24)); ?>, 
            <?php echo Helpers::Entero(Corte::VentaHoy($dia23)); ?>, 
            <?php echo Helpers::Entero(Corte::VentaHoy($dia22)); ?>, 
            <?php echo Helpers::Entero(Corte::VentaHoy($dia21)); ?>,
            <?php echo Helpers::Entero(Corte::VentaHoy($dia20)); ?>, 
            <?php echo Helpers::Entero(Corte::VentaHoy($dia19)); ?>, 
            <?php echo Helpers::Entero(Corte::VentaHoy($dia18)); ?>, 
            <?php echo Helpers::Entero(Corte::VentaHoy($dia17)); ?>, 
            <?php echo Helpers::Entero(Corte::VentaHoy($dia16)); ?>, 
            <?php echo Helpers::Entero(Corte::VentaHoy($dia15)); ?>, 
            <?php echo Helpers::Entero(Corte::VentaHoy($dia14)); ?>,
            <?php echo Helpers::Entero(Corte::VentaHoy($dia13)); ?>, 
            <?php echo Helpers::Entero(Corte::VentaHoy($dia12)); ?>, 
            <?php echo Helpers::Entero(Corte::VentaHoy($dia11)); ?>, 
            <?php echo Helpers::Entero(Corte::VentaHoy($dia10)); ?>, 
            <?php echo Helpers::Entero(Corte::VentaHoy($dia9)); ?>, 
            <?php echo Helpers::Entero(Corte::VentaHoy($dia8)); ?>, 
            <?php echo Helpers::Entero(Corte::VentaHoy($dia7)); ?>,
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
              <?php echo Helpers::Entero(Corte::GastoHoy($dia30)); ?>, 
              <?php echo Helpers::Entero(Corte::GastoHoy($dia29)); ?>, 
              <?php echo Helpers::Entero(Corte::GastoHoy($dia28)); ?>,
              <?php echo Helpers::Entero(Corte::GastoHoy($dia27)); ?>, 
              <?php echo Helpers::Entero(Corte::GastoHoy($dia26)); ?>, 
              <?php echo Helpers::Entero(Corte::GastoHoy($dia25)); ?>, 
              <?php echo Helpers::Entero(Corte::GastoHoy($dia24)); ?>, 
              <?php echo Helpers::Entero(Corte::GastoHoy($dia23)); ?>, 
              <?php echo Helpers::Entero(Corte::GastoHoy($dia22)); ?>, 
              <?php echo Helpers::Entero(Corte::GastoHoy($dia21)); ?>,
              <?php echo Helpers::Entero(Corte::GastoHoy($dia20)); ?>, 
              <?php echo Helpers::Entero(Corte::GastoHoy($dia19)); ?>, 
              <?php echo Helpers::Entero(Corte::GastoHoy($dia18)); ?>, 
              <?php echo Helpers::Entero(Corte::GastoHoy($dia17)); ?>, 
              <?php echo Helpers::Entero(Corte::GastoHoy($dia16)); ?>, 
              <?php echo Helpers::Entero(Corte::GastoHoy($dia15)); ?>, 
              <?php echo Helpers::Entero(Corte::GastoHoy($dia14)); ?>,
              <?php echo Helpers::Entero(Corte::GastoHoy($dia13)); ?>, 
              <?php echo Helpers::Entero(Corte::GastoHoy($dia12)); ?>, 
              <?php echo Helpers::Entero(Corte::GastoHoy($dia11)); ?>, 
              <?php echo Helpers::Entero(Corte::GastoHoy($dia10)); ?>, 
              <?php echo Helpers::Entero(Corte::GastoHoy($dia9)); ?>, 
              <?php echo Helpers::Entero(Corte::GastoHoy($dia8)); ?>, 
              <?php echo Helpers::Entero(Corte::GastoHoy($dia7)); ?>,
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
