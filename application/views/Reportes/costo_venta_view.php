<div class="col col-md-1"></div>
<div class="col col-md-10">
	<div class="panel panel-default">
		<div class="panel-heading titulo_panel">Costo sobre ventas</div>
		<div class="panel-body">
			<div class="row bottom-padding-50 formulario_style">

<?php 
$blok="";
if(isset($bloqueo)){$blok="?no_menu";} ?>

			<form action="<?= site_url('reportes/ventas/costo_venta').$blok;?>" method="POST" class="form-consulta" autocomplete="off">
				<div class="col-md-6">
					<b>SUCURSAL</b>
					<select class="form-control" name="sucursal">
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
			<table class="table table-condensed tabla_repote">
				<thead>
					<th>#prod</th>
					<th>Producto</th>
					<th>Unidad</th>
					<th>Cant.</th>
					<th>MAX Precio</th>
					<th>MAX Costo.</th>
					<th>Venta</th>
					<th>Costo</th>
					<th>Utilidad</th>
					<th>%Util.</th>
				</thead>
				<tbody>

				<?php if(isset($ventas)){foreach($ventas as $v)if($v->costo>0){?>
					<tr>
						<td><?= $v->producto ?></td>
						<td><?= $v->desc1 ?></td>
						<td><?= $v->um ?></td>
						<td><?= $v->cantidad ?></td>
						<td class="importe"><?= number_format($v->precio,2) ?></td>
						<td class="importe"><?= number_format($v->ctoult,2) ?></td>
						<!--<td class="importe"><?= number_format($v->precio*$v->cantidad,2) ?></td>-->
						<!--<td class="importe"><?= number_format($v->ctoult*$v->cantidad,2) ?></td>-->
						<td class="importe"><?= number_format($v->importe,2) ?></td>
						<td class="importe"><?= number_format($v->costo,2) ?></td>
						<td class="importe"><?= number_format($v->importe-$v->costo,2) ?></td>
						<td class="importe"><?= number_format(($v->importe-$v->costo)/$v->importe,2)*100 ?></td>
					</tr>
				<?php } }?>

				</tbody>
			</table>
		</div>
	</div>
</div>