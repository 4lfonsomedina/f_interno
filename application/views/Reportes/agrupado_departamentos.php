<div class="col col-md-1"></div>
<div class="col col-md-10">
	<div class="panel panel-default">
		<div class="panel-heading titulo_panel">Ventas agrupadas por departamento</div>
		<div class="panel-body">
			<div class="row bottom-padding-50 formulario_style">
			<form action="<?= site_url('reportes/ventas/agrupado_departamento');?>" method="POST" class="form-consulta" autocomplete="off">
				<div class="col-md-3">
					<b>SUCURSAL</b>
					<select class="form-control act_dep_suc" name="sucursal">
						<option value="localbrasil" <?php if($sucursal=='brasil') echo "selected"; ?>>BRASIL</option>
						<option value="localsanmarcos" <?php if($sucursal=='sanmarcos') echo "selected"; ?>>SAN MARCOS</option>
						<option value="localgastroshop" <?php if($sucursal=='gastroshop') echo "selected"; ?>>GASTROSHOP</option>
						<option value="localmexquite" <?php if($sucursal=='mexquite') echo "selected"; ?>>MEXQUITE</option>
					</select>
				</div>
				<div class="col col-md-3">
					<b>PERIODO VENTA</b>
					<input type="text" class="form-control datepicker" name="periodo1" value="<?= $periodo1 ?>">
				</div>
				<div class="col col-md-3">
					<b>HASTA</b>
					<input type="text" class="form-control datepicker" name="periodo2" value="<?= $periodo2 ?>">
				</div>
				<div class="col col-md-3"><br><button class="btn btn-success">CONSULTAR</button></div>
			</form>
			</div>
			<table class="table table-condensed tabla_repote">
				<thead>
					<th>linea</th>
					<th>Departamento</th>
					<th>Venta</th>
					<th>Costo</th>
					<th>Utilidad</th>
				</thead>
				<tbody>

				<?php $t1=0;$t2=0;$t3=0;if(isset($ventas))foreach($ventas as $v){
					?>
					<tr>
						<td><?= $v->linea ?></td>
						<td><a href="detallado_departamento?sucursal=<?=$sucursal?>&periodo1=<?=$periodo1?>&periodo2=<?=$periodo2?>&linea=<?=$v->linea?>" target="_blank">
							<?php foreach($lineas as $l)if(".".$l->linea==".".$v->linea){ echo $l->nombre; } ?></a>
						</td>
						<td class="importe"><?= number_format($v->importe,2) ?></td>
						<td class="importe"><?= number_format($v->costo,2) ?></td>
						<td class="importe"><?= number_format(($v->importe-$v->costo),2) ?></td>
					</tr>
				<?php 
				$t1+=$v->importe;
				$t2+=$v->costo;
			}?>
				</tbody>
				<tfoot>
					<tr>
						<th colspan="2"></th>
						<th class="importe"><?= number_format($t1,2) ?></th>
						<th class="importe"><?= number_format($t2,2) ?></th>
						<th class="importe"><?= number_format($t1-$t2,2) ?></th>
					</tr>
				</tfoot>
			</table>
		</div>
	</div>
</div>
