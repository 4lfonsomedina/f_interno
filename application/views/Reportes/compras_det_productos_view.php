<div class="col col-md-1"></div>
<div class="col col-md-10">

	<div class="panel panel-default">
		<div class="panel-heading titulo_panel">Compras detallado productos</div>
		<div class="panel-body">
			<!--construccion de tabs uno por mes-->
			<div class="row bottom-padding-50 formulario_style">
				<form method="POST" action="<?= site_url('Reportes/Compras/detalles_producto') ?>" class="form-consulta">
					<div class="col-md-4">
						<b>PRODUCTO</b>
						<select class="form-control chosen-select" name="producto">
							<option value="NA"></option>
							<?php foreach($productos as $p){?>
								<option value="<?= $p->producto ?>" 
									<?php if($producto."a"==$p->producto."a") echo "selected"; ?>><?= $p->producto." - ".$p->desc1 ?></option>
							<?php } ?>
						</select>
					</div>
				<div class="col-md-2">
					<b>SUCURSAL</b>
					<select class="form-control" name="sucursal">
						<option value="brasil" <?php if($sucursal=='brasil') echo "selected"; ?>>BRASIL</option>
						<option value="sanmarcos" <?php if($sucursal=='sanmarcos') echo "selected"; ?>>SAN MARCOS</option>
						<option value="gastroshop" <?php if($sucursal=='gastroshop') echo "selected"; ?>>GASTROSHOP</option>
						<option value="mexquite" <?php if($sucursal=='mexquite') echo "selected"; ?>>MEXQUITE</option>
					</select>
				</div>
				<div class="col-md-2">
					<b>MONEDA</b>
					<select class="form-control" name="moneda">
						<option value='todo' <?php if($moneda=='todo') echo "selected"; ?>>TODO EN PESOS</option>
						<option value='MN' <?php if($moneda=='MN') echo "selected"; ?>>SOLO COMPRAS PESOS</option>
						<option value='US' <?php if($moneda=='US') echo "selected"; ?>>SOLO COMPRAS DOLARES</option>
					</select>
				</div>
				<div class="col-md-2">
					<b>AÑO</b>
					<select class="form-control" name="ejercicio">
						<?php for($e=0;$e<5;$e++){?>
						<option value="<?= date('Y')-$e ?>" <?php if($ano==(date('Y')-$e)) echo "selected"; ?>><?= date('Y')-$e ?></option>
						<?php } ?>
					</select>
				</div>
				<div class="col-md-2">
					<br>
					<button type="submit" class="btn btn-success">Consulta</button>
				</div>
				</form>
			</div>


		<div class="limite_y">
			<?php if(isset($detalles)){?>
			<div class='col col-lg-12 loader_ocu'>

			
				<div class='spinner spinner_reporte'>
					<div class='rect1'></div><div class='rect2'></div><div class='rect3'></div><div class='rect4'></div><div class='rect5'></div>
				</div>
			</div>
			
			<table class="table table-condensed tabla_repote">
				<thead>
					<th>Fecha</th>
					<th>#Compra</th>
					<th>#Proveedor</th>
					<th>Nom. Prov.</th>
					<th>Cantidad</th>
					<th>Precio/U</th>
					<th>Total</th>
				</thead>
				<tbody>
					<?php $contador=0;foreach($detalles as $d){?>
					<tr>
						<td data-sort="<?= $contador++; ?>"><?= formato_fecha($d->fecha) ?></td>
						<td><?= $d->compra ?></td>
						<td><?= $d->proveedor ?></td>
						<td><?= $d->nombre ?></td>
						<td><?= $d->cantidad ?></td>
						<td><?= $d->costo ?></td>
						<td><?= $d->importe ?></td>
					</tr>
					<?php } ?>
				</tbody>
			</table>
		<?php } ?>
		</div>




			 

		</div>
	</div>
</div>