<div class="col col-md-1"></div>
<div class="col col-md-10">
	<div class="panel panel-default">
		<div class="panel-heading titulo_panel">Resumen Servicio a Domicilio</div>
		<div class="panel-body">
			<form action="<?= site_url('Reportes/ventas/ventas_sd2') ?>" method="post" class="form-consulta">
				<div class="row">
				<div class="col-sm-3"><b>SUCURSAL</b>
					<select class="form-control" name="sucursal">
						<option value="brasil" <?php if($sucursal=='localbrasil') echo "selected"; ?>>BRASIL</option>
						<option value="sanmarcos" <?php if($sucursal=='localsanmarcos') echo "selected"; ?>>SAN MARCOS</option>
						<option value="gastroshop" <?php if($sucursal=='localgastroshop') echo "selected"; ?>>GASTROSHOP</option>
					</select>
				</div>
				<div class="col-sm-3">
					<b>FECHA INI</b>
					<input type="text" class="form-control datepicker" name="fecha_ini" value="<?= $fecha_ini ?>">
				</div>
				<div class="col-sm-3">
					<b>FECHA FIN</b>
					<input type="text" class="form-control datepicker" name="fecha_fin" value="<?= $fecha_fin ?>">
				</div>
				<div class="col-sm-3">
					<br>
					<button type="submit" class="btn btn-primary"> Calcular </button>
				</div>
				</div>
			</form>
			<div style="margin-top: 50px; text-align: center; color: gray;">
				Criterio: Ventas que contengan los productos VXEL y ENVIO
			</div>
			<table class="table table-condensed table-border-1 tabla_repote_sin_orden">
				<thead>
					<tr>
						<th>Departamento</th>
						<th>Productos</th>
						<th>Total</th>
					</tr>
				</thead>
				<tbody>
					<?php if(isset($ventas))foreach($ventas as $v){?>
						<tr>
							<td><?php foreach($lineas as $l){if($l->linea==$v->linea){ echo $l->nombre;}} ?></td>
							<td><?= $v->cantidad ?></td>
							<td><?= number_format($v->total,2) ?></td>
						</tr>
					<?php } ?>
				</tbody>
			</table>
		</div>
	</div>
</div>