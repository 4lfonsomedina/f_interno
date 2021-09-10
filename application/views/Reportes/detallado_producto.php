<div class="col col-md-1"></div>
<div class="col col-md-10">
	<div class="panel panel-default">
		<div class="panel-heading titulo_panel">Cardex de venta de producto</div>
		<div class="panel-body">
			<div class="row bottom-padding-50 formulario_style">
			<form action="<?= site_url('reportes/ventas/detallado_producto');?>" method="POST" class="form-consulta" autocomplete="off">
				<div class="col col-md-2">
					<b>PRODUCTO</b>
					<input type="text" class="form-control producto_input" name="producto" value="<?= $producto ?>">
				</div>
				<div class="col-md-2">
					<b>SUCURSAL</b>
					<select class="form-control act_dep_suc" name="sucursal">
						<option value="brasil" <?php if($sucursal=='brasil') echo "selected"; ?>>BRASIL</option>
						<option value="sanmarcos" <?php if($sucursal=='sanmarcos') echo "selected"; ?>>SAN MARCOS</option>
						<option value="gastroshop" <?php if($sucursal=='gastroshop') echo "selected"; ?>>GASTROSHOP</option>
						<option value="mexquite" <?php if($sucursal=='mexquite') echo "selected"; ?>>MEXQUITE</option>
					</select>
				</div>
				<div class="col col-md-2">
					<b>PERIODO VENTA</b>
					<input type="text" class="form-control datepicker" name="periodo1" value="<?= $periodo1 ?>">
				</div>
				<div class="col col-md-2">
					<b>HASTA</b>
					<input type="text" class="form-control datepicker" name="periodo2" value="<?= $periodo2 ?>">
				</div>
				<div class="col col-md-2"><br><button class="btn btn-success">CONSULTAR</button></div>
			</form>
			</div>
			<h2 align="center"><?php if(isset($ventas)){ echo $ventas[0]->producto." - ".$ventas[0]->desc1; } ?></h2>
			<table class="table table-condensed tabla_repote">
				<thead>
					<th>fecha</th>
					<th>#ticket</th>
					<th>Unidad</th>
					<th class="importe">Precio/u</th>
					<th class="importe">Costo/u</th>
					<th class="importe">Cant.</th>
					<th class="importe">Venta</th>
					<th class="importe">Costo</th>
					<th class="importe">Utilidad</th>
				</thead>
				<tbody>

				<?php $t1=0;$t2=0;$t3=0;if(isset($ventas))foreach($ventas as $v){
					$t1+=$v->importe;$t2+=$v->costo;$t3+=$v->cantidad;
					?>
					<tr>
						<td><?= explode(" ", $v->fecha)[0];  ?></td>
						<td><a href="detalle_ticket?ticket=<?=$v->factura?>&sucursal=<?=$sucursal?>" target="_blank"><?= $v->factura ?></td>
						<td><?= $v->um ?></td>
						<td class="importe"><?= number_format($v->precio,2) ?></td>
						<td class="importe"><?= number_format($v->ctoult,2) ?></td>
						<td class="importe"><?= $v->cantidad ?></td>
						<td class="importe"><?= number_format($v->importe,2) ?></td>
						<td class="importe"><?= number_format($v->costo,2) ?></td>
						<td class="importe"><?= number_format(($v->importe-$v->costo),2) ?></td>
					</tr>
				<?php }?>
				</tbody>
				<tfoot>
					<tr>
						<th colspan="5"></th>
						<th class="importe"><?= number_format($t3,2) ?></th>
						<th class="importe"><?= number_format($t1,2) ?></th>
						<th class="importe"><?= number_format($t2,2) ?></th>
						<th class="importe"><?= number_format($t1-$t2,2) ?></th>
					</tr>
				</tfoot>
			</table>
	</div>
</div>