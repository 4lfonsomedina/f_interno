<div class="col col-md-1"></div>
<div class="col col-md-10">
	<div class="panel panel-default">
		<div class="panel-heading titulo_panel">Costo sobre ventas</div>
		<div class="panel-body">
			<div class="row bottom-padding-50 formulario_style">

			<form action="<?= site_url('reportes/ventas/costo_venta_integrado')?>" method="POST" class="form-consulta" autocomplete="off">
				<div class="col-md-6">
					<b>SUCURSAL</b>
					<select class="form-control" name="sucursal">
						<option value="brasil" <?php if($sucursal=='brasil') echo "selected"; ?>>BRASIL</option>
						<option value="sanmarcos" <?php if($sucursal=='sanmarcos') echo "selected"; ?>>SAN MARCOS</option>
						<option value="gastroshop" <?php if($sucursal=='gastroshop') echo "selected"; ?>>GASTROSHOP</option>
						<option value="mexquite" <?php if($sucursal=='mexquite') echo "selected"; ?>>MEXQUITE</option>
					</select>
				</div>
				<div class="col col-md-4">
					<b>MARCA</b>
					<select class="form-control" name="marca">
						<option value='0'>TODAS</option>
						<?php foreach($marcas as $m){?>
							<option <?php if($marca." " == $m->marca." ") echo "selected"; ?> value="<?= $m->marca ?>"><?= $m->nombre ?></option>
						<?php } ?>
					</select>
				</div>
				<div class="col col-md-2"><br><button class="btn btn-success">CONSULTAR</button></div>
			</form>
			</div>
			<table class="table table-condensed tabla_repote">
				<thead>
					<th>#prod</th>
					<th>Producto</th>
					<th>Unidad</th>
					<th class="importe">Costo Int</th>
					<th class="importe">Precio</th>
					<th class="importe">Utilidad</th>
					<th class="importe">%Util.</th>
				</thead>
				<tbody>

				<?php if(isset($ventas)){foreach($ventas as $v)if($v->costo_inte>0){?>
					<tr>
						<td><?= $v->producto ?></td>
						<td><?= $v->desc1 ?></td>
						<td><?= $v->um ?></td>
						<td class="importe"><?= number_format($v->costo_inte,2) ?></td>
						<td class="importe"><?= number_format($v->precio1,2) ?></td>
						<td class="importe"><?= number_format($v->precio1-$v->costo_inte,2) ?></td>
						<td class="importe"><?= number_format((($v->precio1/$v->costo_inte)*100)-100,2) ?></td>
					</tr>
				<?php } }?>

				</tbody>
			</table>
		</div>
	</div>
</div>