<div class="col col-md-1"></div>
<div class="col col-md-10">

	<div class="panel panel-default">
		<div class="panel-heading titulo_panel">Compras detallado proveedor</div>
		<div class="panel-body">
			<!--construccion de tabs uno por mes-->
			<div class="row bottom-padding-50 formulario_style">
				<form method="POST" action="<?= site_url('Reportes/Compras/detalles_proveedor') ?>" class="form-consulta">
					<div class="col-md-5">
						<b>PROVEEDOR</b>
						<select class="form-control chosen-select" name="proveedor">
							<option value="NA"></option>
							<?php foreach($proveedores as $p){?>
								<option value="<?= $p->proveedor ?>" 
									<?php if($proveedor."a"=="".$p->proveedor."a") echo "selected"; ?>><?= $p->proveedor." - ".$p->nombre ?></option>
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
					<b>AÑO</b>
					<select class="form-control" name="ejercicio">
						<?php for($e=0;$e<5;$e++){?>
						<option value="<?= date('Y')-$e ?>" <?php if($ano==(date('Y')-$e)) echo "selected"; ?>><?= date('Y')-$e ?></option>
						<?php } ?>
					</select>
				</div>
				<div class="col-md-3">
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
					<th>#Producto</th>
					<th>Desc. Prod.</th>
					<th>Unidad</th>
					<th>Cantidad</th>
					<th class="importe">Precio/U</th>
					<th class="importe">Importe</th>
					<th class="importe">Impuesto</th>
					<th class="importe">Total</th>
				</thead>
				<tbody>
					<?php $contador=0;foreach($detalles as $d){?>
					<tr>
						<td data-sort="<?= $contador++; ?>"><?= formato_fecha($d->fecha) ?></td>
						<td><?= $d->compra ?></td>
						<td><?= $d->producto ?></td>
						<td><?= $d->desc ?></td>
						<td><?= $d->um ?></td>
						<td><?= number_format($d->cantidad,2) ?></td>
						<td class="importe"><?= number_format($d->costo,2) ?></td>
						<td class="importe"><?= number_format($d->importe,2) ?></td>
						<td class="importe"><?= number_format($d->impuesto,2) ?></td>
						<td class="importe"><?= number_format($d->importe+$d->impuesto,2) ?></td>
					</tr>
					<?php } ?>
				</tbody>
			</table>
		<?php } ?>
		</div>




			 

		</div>
	</div>
</div>