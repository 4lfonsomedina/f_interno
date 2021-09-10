<div class="col col-md-1"></div>
<div class="col col-md-10">
	<div class="panel panel-default">
		<div class="panel-heading titulo_panel">Ventas por departamento</div>
		<div class="panel-body">
			<div class="row bottom-padding-50 formulario_style">
			<form action="<?= site_url('reportes/ventas/detallado_departamento');?>" method="POST" class="form-consulta" autocomplete="off">
				<div class="col-md-2">
					<b>SUCURSAL</b>
					<select class="form-control act_dep_suc" name="sucursal">
						<option value="brasil" <?php if($sucursal=='brasil') echo "selected"; ?>>BRASIL</option>
						<option value="sanmarcos" <?php if($sucursal=='sanmarcos') echo "selected"; ?>>SAN MARCOS</option>
						<option value="gastroshop" <?php if($sucursal=='gastroshop') echo "selected"; ?>>GASTROSHOP</option>
						<option value="mexquite" <?php if($sucursal=='mexquite') echo "selected"; ?>>MEXQUITE</option>
					</select>
				</div>
				<div class="col-md-2">
					<b>DEPARTAMENTO</b>
					<select class="form-control act_dep_dep" name="linea">
						<option value="T">TODOS</option>
							<?php foreach($lineas as $l){?>
							<option value="<?= $l->linea ?>" 
								<?php if(isset($linea))if("a".$linea=="a".$l->linea) echo "selected";?>><?= $l->linea." - ".$l->nombre ?></option>
							<?php }?>
					</select>
				</div>
				<div class="col-md-2">
					<b>SUB-DEP</b>
					<select class="form-control act_dep_sub" name="subdep">
						<option value="T">TODOS</option>
						<?php foreach($subdeps as $s){?>
							<option value="<?= $s->subdepto ?>" 
								<?php if(isset($subdep))if("a".$subdep=="a".$s->subdepto) echo "selected";?>><?= $s->subdepto." - ".$s->descrip ?></option>
						<?php }?>
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
				</thead>
				<tbody>

				<?php $t1=0;$t2=0;$t3=0;if(isset($ventas))foreach($ventas as $v){
					$t1+=$v->importe;$t2+=$v->costo;
					?>
					<tr>
						<td><?= $v->producto ?></td>
						<td><a href="detallado_producto?sucursal=<?=$sucursal?>&periodo1=<?=$periodo1?>&periodo2=<?=$periodo2?>&producto=<?=$v->producto?>" target="_blank">
							<?= $v->desc1 ?>
						</a></td>
						<td><?= $v->um ?></td>
						<td><?= $v->cantidad ?></td>
						<td class="importe"><?= number_format($v->precio,2) ?></td>
						<td class="importe"><?= number_format($v->ctoult,2) ?></td>
						<!--<td class="importe"><?= number_format($v->precio*$v->cantidad,2) ?></td>-->
						<!--<td class="importe"><?= number_format($v->ctoult*$v->cantidad,2) ?></td>-->
						<td class="importe"><?= number_format($v->importe,2) ?></td>
						<td class="importe"><?= number_format($v->costo,2) ?></td>
						<td class="importe"><?= number_format(($v->importe-$v->costo),2) ?></td>
					</tr>
				<?php }?>
				</tbody>
				<tfoot>
					<tr>
						<th colspan="6"></th>
						<th class="importe"><?= number_format($t1,2) ?></th>
						<th class="importe"><?= number_format($t2,2) ?></th>
						<th class="importe"><?= number_format($t1-$t2,2) ?></th>
					</tr>
				</tfoot>
			</table>
	</div>
</div>