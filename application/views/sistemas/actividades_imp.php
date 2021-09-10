<head>
	<style type="text/css">
		body{
			font-family: Arial, Helvetica, sans-serif !important;
		}
	</style>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <!--
  <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
  <script type="text/javascript">
    google.charts.load('current', {'packages':['timeline']});
    google.charts.setOnLoadCallback(drawChart);

    function drawChart() {

      var data = new google.visualization.DataTable();
      data.addColumn('string', 'Responsable');
      data.addColumn('string', 'Responsable');
      data.addColumn('date', 'Inicio');
      data.addColumn('date', 'Final');

/*barras de actividades pendientes*/
      data.addRows([
      	<?php foreach($actividades1 as $act){?>
        ['<?php foreach($personal as $p){if($act->id_responsable==$p->id_personal){echo $p->nombre;}}?>', 
        '<?= $act->actividad ?>',
new Date(<?= date('Y'); ?>,<?= date('m')-1; ?>,<?= date('d'); ?>), 
new Date(<?= extraer_sql_fecha('ano',$act->fecha_ini)?>,(<?= extraer_sql_fecha('mes',$act->fecha_ini)?>-1),<?= extraer_sql_fecha('dia',$act->fecha_ini)?>)],
     	

     	<?php } ?>
      ]);
      var options = {
        height: <?= count($actividades1)*62 ?>,
        width:700,
        timeline: {
          groupByRowLabel: true
        }
      };

      var chart = new google.visualization.Timeline(document.getElementById('chart_div'));
      chart.draw(data, options);
    }
    //setTimeout(function(){ window.print();window.close(); }, 2000);
  </script>
-->
  <title><?php foreach($departamentos as $dep){if($dep->id_departamento==$departamento){echo $dep->nombre.date('-d-m-Y');}}?></title>
</head>

  


<style type="text/css">
  .barra{
    background-color: #0D8AE0;
    color: white;
    padding: 0px;
    margin-top: 7px;
    text-align: center;
  }
  .calendar_cont{
    padding: 30px;
  }
	table, td, th {
		font-size: 10px;
  		border: 1px solid gray;
  		border-collapse: collapse;
	}
  body{
    -webkit-print-color-adjust:exact;
  }
  .contenedor_imp{
    width: 100%;
  }
  @media print{
     div.saltopagina{
        display:block;
        page-break-before:always;
     }
  }

</style>

<div class="contenedor_imp">

    <center><h1>Actividades del Area de <?php foreach($departamentos as $dep){if($dep->id_departamento==$departamento){echo $dep->nombre;}}?></h1></center>
    <p style="text-align: right;">Fecha: <?= date("d/m/YY")?></p>
    
<center><h3>Actividades Programadas</h3></center>

<center><h3>Lapso de resolución proyectada para actividades activas</h3></center>
    <!--<center><div id="chart_div" ></div></center><-->
<!-- calculo de tiepo de entrega pivote maximo -->
<?php 
foreach($actividades1 as $act){ 
  $pivote = 1;
  $dias = dias_entre_fechas(date('d/m/Y'),formato_fecha($act->fecha_ini))+1; //d/m/Y
  if($pivote<$dias){$pivote=$dias;}
}?>


<div style="padding: 100px;">
  <?php foreach($actividades1 as $act){ 
  $dias = dias_entre_fechas(date('d/m/Y'),formato_fecha($act->fecha_ini))+1; //d/m/Y
  $ancho = round((($dias)/$pivote)*100);
  ?>
  <div class="barra" style="width: <?= $ancho ?>%"> <?= $dias." dias " ?></div>
  <?= $act->actividad ?>
  <?php } ?>
</div>

<div class="saltopagina"></div>



<center><h3> <br><br>Calendario de Programacion</h3></center>
  <div class="calendar_cont"><div id='calendar'></div></div>
<br><br>

    <table width="100%" style="border: 1px solid black; border-collapse: collapse;">
    	<thead>
    		<tr>
    			<th>#</th>
    			<th>Titulo</th>
          <th>Descripcion</th>
    			<th>feacha INI</th>
    			<th>feacha FIN</th>
    			<th>Responsable</th>
          <th>Solicitante</th>
    			<th>Observaciones</th>
          <th>Estatus</th>
    		</tr>
    	</thead>
    	<tbody>
    		<?php foreach($actividades1 as $act){?>
    		<tr>
    			<td><?= $act->id_actividad ?></td>
    			<td><?= $act->actividad ?></td>
          <td><?= $act->descripcion ?></td>
           
    			<td><?= formato_fecha($act->fecha_ini) ?></td>
    			<td><?= formato_fecha($act->fecha_fin) ?></td>
    			<td>
    				<?php foreach($personal as $p){if($act->id_responsable==$p->id_personal){echo $p->nombre;}}?>
    			</td>
          <td>
             <?php foreach($departamentos as $d){if($act->id_solicitante==$d->id_departamento){echo $d->nombre;}}?>
          </td>
          
    			
    			<td><?= $act->observaciones ?></td>
          <?php foreach($estatus as $e)if($act->estatus==$e->id_estatus){?>
            <td style='background-color:<?= $e->color2 ?>; color: white;'>
             <?= $e->estatus ?>
            </td>
         <?php } ?> 

    		</tr>
    	<?php  } ?>
    	</tbody>
    </table>

    <center><h3>Reporte del dia <?= date('Y-m-d') ?></h3></center>
     <div style="padding-right: 150px;padding-left: 150px;">
     <table width="100%" style="border: 1px solid black; border-collapse: collapse;">
    	<?php foreach($checks as $ch){ ?>
    		<tr>
    			<td><?= $ch->descripcion?></td>
    			<td><?php foreach($reg_ch as $rc){if($rc->id_check==$ch->id_check){?>
            <svg class="bi bi-check" height="3em" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M13.854 3.646a.5.5 0 010 .708l-7 7a.5.5 0 01-.708 0l-3.5-3.5a.5.5 0 11.708-.708L6.5 10.293l6.646-6.647a.5.5 0 01.708 0z" clip-rule="evenodd"/></svg>
            <?php } }?></td>
    		</tr>
		  <?php } ?>
		  <tr><td colspan="2"><b><center>Observaciones</center></b></td></tr>
		  <tr><td colspan="2"><?php if(isset($reg_ch[0])){echo $reg_ch[0]->observacion;} ?></td></tr>
    </table>
    </div>


    <center><h3>Actividades del dia <?= date('d/m/Y') ?></h3></center>
    <table width="100%" style="border: 1px solid black; border-collapse: collapse;">
      <thead>
        <tr>
          <th>#</th>
          <th>Titulo</th>
          <th>Descripcion</th>
          <th>feacha INI</th>
          <th>feacha FIN</th>
          <th>Responsable</th>
          <th>Solicitante</th>
          
          
          <th>Observaciones</th>
          <th>Estatus</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach($actividades2 as $act)if(formato_fecha($act->fecha_fin)==date('d/m/Y')){?>
        <tr>
          <td><?= $act->id_actividad ?></td>
          <td><?= $act->actividad ?></td>
          <td><?= $act->descripcion ?></td>
          <td><?= formato_fecha($act->fecha_ini) ?></td>
          <td><?= formato_fecha($act->fecha_fin) ?></td>
          <td>
            <?php foreach($personal as $p){if($act->id_responsable==$p->id_personal){echo $p->nombre;}}?>
          </td>
          <td>
             <?php foreach($departamentos as $d){if($act->id_solicitante==$d->id_departamento){echo $d->nombre;}}?>
          </td>
            
          
          <td><?= nl2br($act->observaciones) ?></td>
          <?php foreach($estatus as $e)if($act->estatus==$e->id_estatus){?>
            <td style='background-color:<?= $e->color2 ?>; color: white;'>
              <?= $e->estatus ?>
            </td>
         <?php } ?>

        </tr>
      <?php  } ?>
      </tbody>
    </table>

    

    <center><h3>Historico de actividades conluidas</h3></center>
    <table width="100%" style="border: 1px solid black; border-collapse: collapse;">
    	<thead>
        <tr>
          <th>#</th>
          <th>Titulo</th>
          <th>Descripcion</th>
          <th>feacha INI</th>
          <th>feacha FIN</th>
          <th>Responsable</th>
          <th>Solicitante</th>
          
          
          <th>Observaciones</th>
          <th>Estatus</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach($actividades2 as $act)if(formato_fecha($act->fecha_fin)!=date('d/m/Y')){?>
        <tr>
          <td><?= $act->id_actividad ?></td>
          <td><?= $act->actividad ?></td>
          <td><?= $act->descripcion ?></td>
          <td><?= formato_fecha($act->fecha_ini) ?></td>
          <td><?= formato_fecha($act->fecha_fin) ?></td>
          <td>
            <?php foreach($personal as $p){if($act->id_responsable==$p->id_personal){echo $p->nombre;}}?>
          </td>
          <td>
             <?php foreach($departamentos as $d){if($act->id_solicitante==$d->id_departamento){echo $d->nombre;}}?>
          </td>
            
          
          <td><?= nl2br($act->observaciones) ?></td>
          <?php foreach($estatus as $e)if($act->estatus==$e->id_estatus){?>
            <td style='background-color:<?= $e->color2 ?>; color: white;'>
              <?= $e->estatus ?>
            </td>
         <?php } ?>

        </tr>
      <?php  } ?>
      </tbody>
    </table>

      
  </div>
