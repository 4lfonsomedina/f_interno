<style type="text/css">
	th,td{
		text-align: center;
	}
</style>
<div class="col col-md-1"></div>
<div class="col col-md-10">
	<div class="panel panel-default">
		<div class="panel-heading titulo_panel">Herramienta de pre_corte</div>
		<div class="panel-body">
			<div class="row bottom-padding-50 formulario_style">
			<form action="<?= site_url('reportes/ventas/pre_corte');?>" method="POST" class="form-consulta" autocomplete="off">
				<div class="col-md-3">
					<b>Fecha Pivote</b>
					<input type="text" class="form-control datepicker" name="fecha" value="<?= $fecha ?>">
				</div>
				<div class="col-md-3">
					<b>Periodo De Comparacion</b>
					<select class="form-control" name="periodo">
						<option value='dia' <?php if($periodo=='dia'){echo 'selected';}?>>Dias (2 Anteriores)</option>
						<option value='semana' <?php if($periodo=='semana'){echo 'selected';}?>>Semana (Mismo Dia en 2 Semanas Anteriores)</option>
						<option value='mes' <?php if($periodo=='mes'){echo 'selected';}?>>Mes (Mismo dia en 2 Meses Anteriores)</option>
					</select>
				</div>
				<div class="col-md-3">
					<b>Hora De Corte</b>
					<select class="form-control" name="hora">
						<?php for($i=8;$i<21;$i++){ $hora_t = str_pad($i, 2, "0", STR_PAD_LEFT).":00"; ?>
						<option value='<?= $hora_t ?>' <?php if($hora==$hora_t){echo 'selected';}?>><?= $hora_t ?></option>
						<?php } ?>
					</select>
				</div>
				<div class="col col-md-3"><br><button class="btn btn-success">CONSULTAR</button></div>
			</form>
			</div>

			<?php if(isset($ventas)){?>
			<table class="table table-condensed tabla_repote">
				<thead>
					<th>Sucursal</th>
					<th><b><?= fecha_nice($ventas['brasil']['f3']) ?></b></th>
					<th><b><?= fecha_nice($ventas['brasil']['f2']) ?></b></th>
					<th><b><?= fecha_nice($ventas['brasil']['f1']) ?></b></th>
					
				</thead>
				<tbody>
				<?php $cont=0;foreach($ventas as $v){ ?>
					<tr>
						<th><?= $suc[$cont];?></th>
						<td><?= number_format($v['v3'],2); ?></td>
						<td><?= number_format($v['v2'],2); ?></td>
						<td><?= number_format($v['v1'],2); ?></td>
					</tr>
				<?php $cont++;} ?>
				</tbody>
			</table>
			<?php } ?>
			<div class="col-md-12" style="text-align: right;"><b>* No se contemplan devoluciones en este reporte</b></div>
			
		</div>
	</div>
</div>