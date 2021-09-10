<!--configuraciones-->
<style type="text/css">
	.panel-heading{
		text-align: center; 
		font-size: 40px;
	}
</style>
<div class="col col-md-4"></div>
<div class="col col-md-4">
<div class="panel panel-default">
	<div class="panel-heading">Monitor de Metas</div>
	<div class="panel-body">
		<form action="<?= site_url('sistemas/herramientas/monitor_metas') ?>" method="post">
		<div class="col-md-2"></div>
		<div class="col-md-8">
			DIA
			<input type="text" class="form-control datepicker" name="fecha" value="<?= $fecha ?>">
			<br>
			<button class="btn btn-primary"> CONSULTAR </button>
		</div>
		</form>
	</div>
</div>
</div>

<?php 
if(isset($productos)){
	$total_ant=0;
	$total_act=0;
	foreach($productos as $p){
		$total_ant+=$p->venta;
		$total_act+=$p->venta2;
	} 
?>
<div class="col col-md-6">
<div class="panel panel-default">
	<div class="panel-body">
		<table class="table" style="font-size: 2rem; text-align: center">
			<thead>
				<tr >
					<th style="text-align: center"><?= explode('/', $fecha0)[2] ?></th>
					<th style="text-align: center"> VS </th>
					<th style="text-align: center"><?= explode('/', $fecha)[2] ?></th>
					<th style="text-align: center"> % </th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td ><?= resumen_miles($total_ant) ?></td>
					<td></td>
					<td ><?= resumen_miles($total_act) ?></td>
					<?php 
					$tcolor='red';
					$porcentaje=0;
					if($total_ant>0)
						$porcentaje = round(($total_act/$total_ant)*100,2);
					if($porcentaje>100) $tcolor='green';?>
					<td style="color:<?= $tcolor ?>"><b><?= $porcentaje ?></b></td>
				</tr>
			</tbody>
		</table>
	</div>
</div>
</div>
<div class="col col-md-6">
<div class="panel panel-default">
	<div class="panel-body">
		<textarea id="titulo_tabla" hidden>Meta De Ventas
			<?= nombre_dia(sql_fecha($fecha0))." ".$fecha0 ?> VS <?= nombre_dia(sql_fecha($fecha))." ".$fecha ?> 		%
				.				$ <?= resumen_miles($total_ant) ?> 				$ <?= resumen_miles($total_act) ?> 				<?= $porcentaje ?></textarea>
		<table class="table table-condensed table-border-1 tabla_repote">
			<thead>
				<tr>
					<th>Descripcion</th>
					<th class="importe">Venta <?= explode('/', $fecha0)[2] ?></th>
					<th class="importe">Meta</th>
					<th class="importe">Venta Real</th>
				</tr>
			</thead>
			<tbody>
				<?php if(isset($productos))foreach($productos as $p){ 
					$meta=1.08;
					if($p->linea==103){ $meta=1.2; }
					$tcolor='red';
					if(round($p->cantidad*$meta)<=round($p->cantidad2)){$tcolor='green';}?>
				<tr>
					<td data-sort="<?= $p->linea ?>"><?= $p->descripcion ?></td>
					<td class="importe"><?= round($p->cantidad) ?></td>
					<td class="importe"><?= round($p->cantidad*$meta) ?></td>
					<td class="importe" style="color:<?= $tcolor ?>"><?= round($p->cantidad2) ?></td>
				</tr>
				<?php } ?>
			</tbody>
		</table>
	</div>
</div>
</div>

<?php } ?>
</div>
<style type="text/css">
	.contenedor_principal{
		margin-top: 20px !important;
	}
</style>
