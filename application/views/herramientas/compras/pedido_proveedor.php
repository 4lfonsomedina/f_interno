<div class="col col-md-1"></div>
<div class="col col-md-10">

	<div class="panel panel-default">
		<div class="panel-heading titulo_panel">Herramienta de pedido por sucursal (proveedor)</div>
		<div class="panel-body">
			<!--construccion de tabs uno por mes-->
			<div class="row bottom-padding-50 formulario_style">
				<form method="POST" action="<?= site_url('Reportes/Compras/pedido_proveedor') ?>" class="form-consulta">

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
					<b>PROVEEDOR</b>
					<select class="multi-select" multiple="multiple" name="prov[]">
							<?php foreach($proveedores as $p){?>
							<option value="<?= $p->proveedor ?>" 
								<?php if(isset($prov))foreach($prov as $pr)if("a".$pr=="a".$p->proveedor) echo "selected";?>><?= $p->proveedor." - ".$p->nombre ?></option>
							<?php }?>
					</select>
				</div>
				<div class="col col-xs-2">
					<b>FECHA INI</b>
					<input type="text" class="form-control datepicker" name="fecha_ini" value="<?= $fecha_ini ?>">
				</div>
				<div class="col col-xs-2">
					<b>FECHA FIN</b>
					<input type="text" class="form-control datepicker" name="fecha_fin" value="<?= $fecha_fin ?>">
				</div>
				<div class="col-xs-3">
					<br>
					<button type="submit" class="btn btn-success">Consulta</button>
				</div>
				</form>
			</div>

		<div class="limite_y">
			<?php if(isset($ventas)){?>

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
						<th>Cantidad</th>
						<th>Stock</th>
						<th>Fisico</th>
						<th>Pedido</th>
					</tr>
				</thead>
				<tbody>
					<?php foreach($ventas as $v){
						?>
					<tr>
						<td><?= $v->producto ?></td>
						<td><?= $v->desc1 ?></td>
						<td><?= $v->um ?></td>
						<td><?= number_format($v->cantidad,2) ?></td>
						<td><?= $v->min ?></td>
						<td><?= $v->exis ?></td>
						<td><?= number_format($v->cantidad+$v->min-$v->exis,2) ?></td>
					</tr>
					<?php } ?>
				</tbody>
			</table>
			<?php } ?>
		</div>



		</div>
	</div>
</div>