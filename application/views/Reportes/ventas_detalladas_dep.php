<div class="col col-md-1"></div>
<div class="col col-md-10">
	<div class="panel panel-default">
		<div class="panel-heading titulo_panel">Detalles de venta por departamento</div>
		<div class="panel-body">
			<form action="<?= site_url('Reportes/ventas/ventas_carniceria_detalle') ?>" method="post" class="form-consulta">
				<div class="row">
				<div class="col-md-3"><b>SUCURSAL</b>
					<select class="form-control" name="sucursal">
						<option value="brasil" <?php if($sucursal=='localbrasil') echo "selected"; ?>>BRASIL</option>
						<option value="sanmarcos" <?php if($sucursal=='localsanmarcos') echo "selected"; ?>>SAN MARCOS</option>
						<option value="gastroshop" <?php if($sucursal=='localgastroshop') echo "selected"; ?>>GASTROSHOP</option>
					</select>
				</div>
				<div class="col-md-3"><b>Departamento</b>
					<select class="form-control" name="linea">
							<?php foreach($lineas as $l){?>
							<option value="<?= $l->linea ?>" 
								<?php if(isset($linea) && $l->linea==$linea){ echo "selected"; }?>
								><?= $l->linea." ".$l->nombre ?></option>
							<?php }?>
					</select>
				</div>
				<div class="col-md-2">
					<b>FECHA INI</b>
					<input type="text" class="form-control datepicker" name="fecha_ini" value="<?= $fecha_ini ?>">
				</div>
				<div class="col-md-2">
					<b>FECHA FIN</b>
					<input type="text" class="form-control datepicker" name="fecha_fin" value="<?= $fecha_fin ?>">
				</div>
				<div class="col-md-2">
					<br>
					<button type="submit" class="btn btn-primary"> Calcular </button>
				</div>
				</div>
			</form>
			<div style="margin-top: 50px; text-align: center; color: gray;">
			</div>
			<?php if(isset($ventas)){?>
				<div class="cargando_tabla">
					<h1><i class="fa fa-circle-o-notch fa-spin fa-3x fa-fw"></i> Cargando Información...</h1>
				</div>
			<?php } ?>
			<table class="table table-condensed table-border-1 tabla_repote" hidden>
				<thead>
					<tr>
						<th>Fecha</th>
						<th>Dia</th>
						<th>Ticket</th>
						<th>Producto</th>
						<th>Descripcion</th>
						<th>Unidad</th>
						<th>Cantidad</th>
					</tr>
				</thead>
				<tbody>
					<?php if(isset($ventas))foreach($ventas as $v){?>
						<tr>
							<td><?= formato_fecha($v->id_fecha) ?></td>
							<td><?= dia_texto2($v->id_fecha) ?></td>
							<td><?= $v->factura ?></td>
							<td><?= $v->producto ?></td>
							<td><?= $v->descrip ?></td>
							<td><?= $v->um ?></td>
							<td><?= number_format($v->cantidad,2) ?></td>
						</tr>
					<?php } ?>
				</tbody>
			</table>
		</div>
	</div>
</div>