<div class="col col-md-1"></div>
<div class="col col-md-10">
	<div class="panel panel-default">
		<div class="panel-heading titulo_panel">Produccion Cocina Vs Ventas</div>
		<div class="panel-body">
			<div class="row bottom-padding-50 formulario_style">
			<form action="<?= site_url('reportes/compras/transferencias_cocina');?>" method="POST" class="form-consulta" autocomplete="off">
				<div class="col col-md-2">
					<b>Periodo Produccion</b>
					<input type="text" class="form-control datepicker" name="periodoc1" value="<?= $periodoc1 ?>">
				</div>
				<div class="col col-md-2">
					<b>hasta</b>
					<input type="text" class="form-control datepicker" name="periodoc2" value="<?= $periodoc2 ?>">
				</div>
				<div class="col col-md-2">
					<b>Periodo venta</b>
					<input type="text" class="form-control datepicker" name="periodov1" value="<?= $periodov1 ?>">
				</div>
				<div class="col col-md-2">
					<b>hasta</b>
					<input type="text" class="form-control datepicker" name="periodov2" value="<?= $periodov2 ?>">
				</div>
				<div class="col col-md-4"><br><button class="btn btn-success">CONSULTAR</button></div>
			</form>
			</div>
			<table class="table table-condensed tabla_repote">
				<thead>
					<th>#prod</th>
					<th>Producto</th>
					<th>Unidad</th>
					<th>Producido</th>
					<th>Env BR</th>
					<th>Env SM</th>
					<th>Env GS</th>
					<th>Env MEX</th>
					<th>Venta</th>
					<th>Vta BR</th>
					<th>Vta SM</th>
					<th>Vta GS</th>
					<th>Merma</th>
					<th>Donat</th>
					<th>Chef</th>
					<th>Asador</th>
					<th>Diferencia</th>
				</thead>
				<tbody>

				<?php $titulo=0;if(isset($compras)){foreach($compras as $c){?>
<!--
				<?php if($titulo==0){$titulo=contador_titulo($compras,"proveedor",$c->proveedor);?>
					<tr>
						<td colspan="7" class="sub_tit_tabla">Proveedor: <?= $c->proveedor." - ".$c->prov_nombre ?></td>
					</tr>
					<?php } $titulo--; ?>
-->
					<tr>
	
						<td><?= $c->producto ?></td>
						<td><?= $c->prod_descrip ?></td>
						<td><?= $c->prod_um ?></td>
						<td class="importe"><?= number_format($c->salida,2) ?></td>
						<td class="importe"><?= number_format($c->brasil,2) ?></td>
						<td class="importe"><?= number_format($c->sanmarcos,2) ?></td>
						<td class="importe"><?= number_format($c->gastro,2) ?></td>
						<td class="importe"><?= number_format($c->mexquite,2) ?></td>
						<td class="importe"><?= number_format($c->ventas_BR+$c->ventas_SM+$c->ventas_GS,2) ?></td>
						<td class="importe"><?= number_format($c->ventas_BR,2) ?></td>
						<td class="importe"><?= number_format($c->ventas_SM,2) ?></td>
						<td class="importe"><?= number_format($c->ventas_GS,2) ?></td>
						<td class="importe"><?= number_format($c->merma,2) ?></td>
						<td class="importe"><?= number_format($c->donativo,2) ?></td>
						<td class="importe"><?= number_format($c->chef,2) ?></td>
						<td class="importe"><?= number_format($c->asador,2) ?></td>
						<td class="importe"><?= number_format($c->salida-$c->ventas_BR-$c->ventas_SM-$c->ventas_GS-$c->merma-$c->donativo-$c->chef-$c->asador,2) ?></td>
					</tr>
				<?php } }?>

				</tbody>
			</table>
		</div>
	</div>
</div>