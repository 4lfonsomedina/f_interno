<div class="col col-md-1"></div>
<div class="col col-md-10">
	<div class="panel panel-default">
		<div class="panel-heading titulo_panel">Merma y Donativos</div>
		<div class="panel-body">
			<div class="row bottom-padding-50 formulario_style">
			<form action="<?= site_url('reportes/traspasos/mermas_donativos');?>" method="POST" class="form-consulta" autocomplete="off">
				<div class="col-md-4">
					<b>SUCURSAL</b>
					<select class="form-control" name="sucursal">
						<option value="localbrasil" <?php if($sucursal=='localbrasil') echo "selected"; ?>>BRASIL</option>
						<option value="localsanmarcos" <?php if($sucursal=='localsanmarcos') echo "selected"; ?>>SAN MARCOS</option>
						<option value="localgastroshop" <?php if($sucursal=='localgastroshop') echo "selected"; ?>>GASTROSHOP</option>
					</select>
				</div>
				<div class="col col-md-2">
					<b>DESDE</b>
					<input type="text" class="form-control datepicker" name="periodo1" value="<?= $periodo1 ?>">
				</div>
				<div class="col col-md-2">
					<b>HASTA</b>
					<input type="text" class="form-control datepicker" name="periodo2" value="<?= $periodo2 ?>">
				</div>
				<div class="col col-md-2">
					<b>CLAVE</b>
					<select class="form-control act_trans" name="tipo_salida">
						<option value="T" <?php if(isset($tipo_salida)&&$tipo_salida=="T") echo "selected"; ?>> 
							Todos (003,004,035) 
						</option>
						<?php foreach($tipo_salidas as $ts){?>
						<option value="<?= $ts->clave ?>" <?php if(isset($tipo_salida)&&$tipo_salida==$ts->clave) echo "selected"; ?>><?= $ts->clave." - ".$ts->descripcion ?></option>
					<?php } ?>
					</select>
				</div>
				<div class="col col-md-2"><br><button class="btn btn-success">CONSULTAR</button></div>
			</form>
			</div>
			
			<table class="table table-condensed tabla_repote">
				<thead>
					<th>#Clave</th>
					<th>Descripcion</th>
					<th>Unidad</th>
					<th>Departamento</th>
					<th class="importe">Salida</th>
					<th class="importe">Vendidos</th>
					<th class="importe">( % )</th>
					<th class="importe">$ Salida</th>
					<th class="importe">$ Venta</th>
					<th class="importe">( % )</th>
				</thead>
				<tbody>

				<?php 
				if(isset($salidas)){foreach($salidas as $s){?>
					<tr>
						<td><?= $s->producto?></td>
						<td><?= $s->desc1 ?></td>
						<td><?= $s->um ?></td>
						<td><?= $s->linea.' - '; ?> <?php foreach($departamentos as $d)if($d->linea==$s->linea){ echo $d->nombre;} ?></td>
						<td class="importe"><?= round($s->cantidad,2) ?></td>
						<td class="importe"><?= round($s->cantidad_v,2) ?></td>
						<td class="importe">
							<?php if($s->cantidad_v>0){echo number_format(($s->cantidad/$s->cantidad_v)*100,2);} else{echo "0.00";} ?>
						 %</td>
						<td class="importe"><?= number_format($s->total,2) ?></td>
						<td class="importe"><?= number_format($s->total_v,2) ?></td>
						<td class="importe">
							<?php if($s->total_v>0){echo number_format(($s->total/$s->total_v)*100,2);} else{echo "0.00";} ?>
						 %</td>
					</tr>
				<?php } } ?>

				</tbody>
			</table>
			</div>
			
		</div>
	</div>
</div>