<div class="col col-md-1"></div>
<div class="col col-md-10">

	<div class="panel panel-default">
		<div class="panel-heading titulo_panel">Herramienta de pedido por sucursal (periodo vs 4 periodos anteriores)</div>
		<div class="panel-body">
			<!--construccion de tabs uno por mes-->
			<div class="row bottom-padding-50 formulario_style">
				<form method="POST" action="<?= site_url('Reportes/Compras/pedido_periodo_periodo') ?>" class="form-consulta">

				<div class="col-xs-2">
					<b>SUCURSAL</b>
					<select class="form-control act_dep_suc" name="sucursal" <?php if(isset($bloqueo)) echo "disabled";?>>
						<option value="brasil" <?php if($sucursal=='brasil') echo "selected"; ?>>BRASIL</option>
						<option value="gastroshop" <?php if($sucursal=='gastroshop') echo "selected"; ?>>GASTROSHOP</option>
						<option value="sanmarcos" <?php if($sucursal=='sanmarcos') echo "selected"; ?>>SAN MARCOS</option>
						<option value="mexquite" <?php if($sucursal=='mexquite') echo "selected"; ?>>MEXQUITE</option>
					</select>
				</div>
				<div class="col-xs-3">
					<b>DEPARTAMENTO</b>
					<select class="form-control act_dep_dep" name="linea">
						<option value="T">TODOS</option>
							<?php foreach($lineas as $l){?>
							<option value="<?= $l->linea ?>" 
								<?php if(isset($linea))if("a".$linea=="a".$l->linea) echo "selected";?>><?= $l->linea." - ".$l->nombre ?></option>
							<?php }?>
					</select>
				</div>
				<div class="col-xs-3">
					<b>SUB-DEP</b>
					<select class="form-control act_dep_sub" name="subdep">
						<option value="T">TODOS</option>
						<?php foreach($subdeps as $s){?>
							<option value="<?= $s->subdepto ?>" 
								<?php if(isset($subdep))if("a".$subdep=="a".$s->subdepto) echo "selected";?>><?= $s->subdepto." - ".$s->descrip ?></option>
						<?php }?>
					</select>
				</div>
				<div class="col col-xs-1">
					<b>FECHA INI</b>
					<input type="text" class="form-control datepicker" name="fecha_ini" value="<?= $fecha_ini ?>">
				</div>
				<div class="col col-xs-1">
					<b>FECHA FIN</b>
					<input type="text" class="form-control datepicker" name="fecha_fin" value="<?= $fecha_fin ?>">
				</div>
				<div class="col-xs-2">
					<br>
					<button type="submit" class="btn btn-success">Consulta</button>
				</div>
				</form>
			</div>

		<div class="limite_y">
			<?php $t1=0;$t2=0;$t3=0;$t4=0;if(isset($ventas)){?>

			<div class='col col-lg-12 loader_ocu'>
				<div class='spinner spinner_reporte'>
					<div class='rect1'></div><div class='rect2'></div><div class='rect3'></div><div class='rect4'></div><div class='rect5'></div>
				</div>
			</div>
			<style type="text/css">td.big-col{width:400px !important;}th.big-col{width:400px !important;}</style>
			<table class="table table-condensed table-border-1 tabla_repote">
				<thead>
					<tr>
						<th>Producto</th>
						<th>Descripcion</th>
						<th>Unidad</th>
						<th><?= $periodo[6]." : ".$periodo[7] ?></th>
						<th><?= $periodo[4]." : ".$periodo[5] ?></th>
						<th><?= $periodo[2]." : ".$periodo[3] ?></th>
						<th><?= $periodo[0]." : ".$periodo[1] ?></th>
						<th>TOP</th>
						<th>STOK</th>
						<th>FISICO</th>
						<th>PEDIDO</th>
					</tr>
				</thead>
				<tbody>
					<?php foreach($ventas as $v){
						?>
						<?php $top=number_format(calcular_mayor(array($v->cantidad4,$v->cantidad3,$v->cantidad2,$v->cantidad1)));?>
					<tr>
						<td><?= $v->producto ?></td>
						<td><?= $v->desc1 ?></td>
						<td><?= $v->um ?></td>
						<td><?= number_format($v->cantidad4,2) ?></td>
						<td><?= number_format($v->cantidad3,2) ?></td>
						<td><?= number_format($v->cantidad2,2) ?></td>
						<td><?= number_format($v->cantidad1,2) ?></td>
						<td><?= $top ?></td>
						<td><?= number_format($v->min,2) ?></td>
						<td><?= number_format($v->exis,2) ?></td>
						<td><?= number_format($top+$v->min-$v->exis,2) ?></td>
					</tr>
					<?php $t1+=$v->cantidad1;$t2+=$v->cantidad2;$t3+=$v->cantidad3;$t4+=$v->cantidad4;} ?>
				</tbody>
			</table>
			<?php } ?>
		</div>

		<div id="chart_div"></div>


		</div>
	</div>
</div>


<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script type="text/javascript">
	google.charts.load('current', {packages: ['corechart', 'bar']});
google.charts.setOnLoadCallback(drawBasic);

function drawBasic() {

      //var data = new google.visualization.DataTable();
      var data = google.visualization.arrayToDataTable([
        ['Año', 'Cantidad'],
        ['<?= $periodo[6]." : ".$periodo[7] ?>',<?= round($t4) ?>],
        ['<?= $periodo[4]." : ".$periodo[5] ?>',<?= round($t3) ?>],   
		['<?= $periodo[2]." : ".$periodo[3] ?>',<?= round($t2) ?>],  
		['<?= $periodo[0]." : ".$periodo[1] ?>',<?= round($t1) ?>]
      ]);
      

      var options = {
        title: 'Cantidad vendido',
        hAxis: {
          title: 'Año',
          viewWindow: {
            min: [7, 30, 0],
            max: [17, 30, 0]
          }
        },
        vAxis: {
          title: 'Cantidad global'
        }
      };

      var chart = new google.visualization.ColumnChart(
        document.getElementById('chart_div'));

      chart.draw(data, options);
    }
</script>