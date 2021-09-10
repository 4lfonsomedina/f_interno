<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

<div class="col col-md-1"></div>
<div class="col col-md-10">
	<div class="panel panel-default">
		<div class="panel-heading"><center><h1>Resumen de ventas Ferbis</h1></center></div>
		<div class="panel-body">
			<?php foreach($sucursales as $suc){?>
			<div class="col-md-6">
				<div class="panel panel-primary">
					<div class="panel-heading"><center><?= mayus_suc($suc) ?></center></div>
					<div class="panel-body">
						<div id="grafica<?= $suc ?>" style="width: 85%"></div>
						<table class="table">
							<tr>
								<th>MES</th>
								<?php foreach($anos as $ano){?><th class="importe"><?= $ano ?></th><?php } ?>
							</tr>
			<?php 
			$mes_t=[0,0,0];
			for($i=1;$i<=12;$i++){
				$mes_t=[0,0,0];
				if(isset($ventas[$suc][$anos[0]][$i])){$mes_t[0]=$ventas[$suc][$anos[0]][$i];}
				if(isset($ventas[$suc][$anos[1]][$i])){$mes_t[1]=$ventas[$suc][$anos[1]][$i];}
				if(isset($ventas[$suc][$anos[2]][$i])){$mes_t[2]=$ventas[$suc][$anos[2]][$i];}
			?>
			<tr>
				<td><?= descrip_mes($i) ?></td>
				<td class="importe"><?= number_format($mes_t[0],2) ?></td>
				<td class="importe"><?= number_format($mes_t[1],2) ?></td>
				<td class="importe"><?= number_format($mes_t[2],2) ?></td>
			</tr>
			<?php } ?>
							</tr>
						</table>
					</div>
				</div>
			</div>
			<?php } ?>
			<div class="col-md-12">
				<table class="table">
					<thead>
					<tr>
						<th>Sucursal</th>
						<?php foreach($anos as $ano){?>
						<th class="importe"><?= $ano ?></th>
						<?php }?>
					</tr>
					</thead>
					<tbody>
						<?php foreach($sucursales as $suc){
							foreach($anos as $ano){$importe_ano[$suc][$ano]=0;}
							for($i=1;$i<=12;$i++)
								foreach($anos as $ano)
									if(isset($ventas[$suc][$ano][$i]))
										$importe_ano[$suc][$ano]+=$ventas[$suc][$ano][$i];
							?>
						<tr>
							<td><?= mayus_suc($suc) ?></td>
							<td class="importe"><?= number_format($importe_ano[$suc][$anos[0]],2) ?></td>
							<td class="importe"><?= number_format($importe_ano[$suc][$anos[1]],2) ?></td>
							<td class="importe"><?= number_format($importe_ano[$suc][$anos[2]],2) ?></td>
						</tr>
						<?php } ?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>

<!-- CONSTRUCCION DE GRAFICA -->
<script type="text/javascript">

	google.charts.load('current', {'packages':['line']});
    google.charts.setOnLoadCallback(drawChart);

    function drawChart() {
		
		<?php foreach($sucursales as $suc){?>

			var data<?= $suc ?> = new google.visualization.DataTable();

			data<?= $suc ?>.addColumn('number', 'MES');

		<?php foreach($anos as $ano){?>
			data<?= $suc ?>.addColumn('number', <?= $ano ?>);
		<?php }?>

		data<?= $suc ?>.addRows([
			<?php 
			
			$mes_t=['','',''];
			for($i=1;$i<=12;$i++){
				$mes_t[0]='null';
				$mes_t[1]='null';
				$mes_t[2]='null';
				if(isset($ventas[$suc][$anos[0]][$i])){$mes_t[0]=$ventas[$suc][$anos[0]][$i];}
				if(isset($ventas[$suc][$anos[1]][$i])){$mes_t[1]=$ventas[$suc][$anos[1]][$i];}
				if(isset($ventas[$suc][$anos[2]][$i])&&$i!=date('m')){$mes_t[2]=$ventas[$suc][$anos[2]][$i];}
			?>
				[<?= $i ?>,  <?= $mes_t[0] ?>, <?= $mes_t[1] ?>, <?= $mes_t[2] ?>],
			<?php } ?>
			]);

		var options<?= $suc ?> = {
		hAxis: {
          title: 'Meses'
        },
        vAxis: {
          title: 'Venta'
        },
		chart: {
		  	title: 'Comparacion Anual',
		  	subtitle: 'Detalle por mes'
		},
			height: 350
		};

		var chart<?= $suc ?> = new google.charts.Line(document.getElementById('grafica<?= $suc ?>'));
		chart<?= $suc ?>.draw(data<?= $suc ?>, google.charts.Line.convertOptions(options<?= $suc ?>));

		<?php }?>
		
}

</script>