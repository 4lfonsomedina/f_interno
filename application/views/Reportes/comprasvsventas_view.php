<div class="col col-md-1"></div>
<div class="col col-md-10">
	<div class="panel panel-default">
		<div class="panel-heading titulo_panel">Compras Vs Ventas</div>
		<div class="panel-body">
			<div class="row bottom-padding-50 formulario_style">
			<form action="<?= site_url('reportes/compras/comprasvsventas');?>" method="POST" class="form-consulta" autocomplete="off">
				<div class="col col-md-2">
					<b>Linea</b>
					<select class="form-control" name='tipo'>
						<option value="0" <?php if($tipo==0) echo "selected"; ?> >Frutas y Verduras</option>
						<option value="1" <?php if($tipo==1) echo "selected"; ?>>Carniceria</option>
						<option value="2" <?php if($tipo==2) echo "selected"; ?>>Abarrotes</option>
						<option value="3" <?php if($tipo==3) echo "selected"; ?>>DPI</option>
<?php foreach($lineas as $l){?>
					<option value="<?= $l->linea ?>" 
					<?php if(isset($tipo))if("a".$tipo=="a".$l->linea) echo "selected";?>><?= $l->linea." - ".$l->nombre ?></option>
<?php }?>
					</select>
				</div>
				<div class="col col-md-1">
					<b>Marca</b>
					<select class="form-control" name='marca'>
						<option value='T'>Todos</option>
						<?php foreach($marcas as $m){?>
							<option value='<?= $m->marca ?>' <?php if($marca==$m->marca) echo 'selected'; ?>>
								<?= $m->marca.' - '.$m->nombre ?></option>
						<?php } ?>
					</select>
				</div>
				<div class="col col-md-2">
					<b>Periodo Compra</b>
					<input type="text" class="form-control datepicker" name="periodoc1" value="<?= $periodoc1 ?>">
				</div>
				<div class="col col-md-2">
					<b>hasta</b>
					<input type="text" class="form-control datepicker" name="periodoc2" value="<?= $periodoc2 ?>">
				</div>
				<div class="col col-md-2">
					<b>Periodo venta</b>
					<input type="text" class="form-control datepicker" name="periodov1" value="<?= $periodov1 ?>">
				</div>
				<div class="col col-md-2">
					<b>hasta</b>
					<input type="text" class="form-control datepicker" name="periodov2" value="<?= $periodov2 ?>">
				</div>
				<div class="col col-md-1"><br><button class="btn btn-success">CONSULTAR</button></div>
			</form>
			</div>
			<table class="table table-condensed tabla_repote">
				<thead>
					<th>#prod</th>
					<th>Producto</th>
					<th>Unidad</th>
					<th>Compra</th>
					<th>Venta</th>
					<th>Env Cos</th>
					<th>Env SM</th>
					<th>Env GS</th>
					<th>Env MX</th>
					<th>Vta BR</th>
					<th>Vta SM</th>
					<th>Vta GS</th>
					<th>Merma</th>
					<th>Donat</th>
					<th>Chef</th>
					<th>Asador</th>
					<th>Diferencia</th>
				</thead>
				<tbody>

				<?php $titulo=0;if(isset($compras)){foreach($compras as $c){?>
<!--
				<?php if($titulo==0){$titulo=contador_titulo($compras,"proveedor",$c->proveedor);?>
					<tr>
						<td colspan="7" class="sub_tit_tabla">Proveedor: <?= $c->proveedor." - ".$c->prov_nombre ?></td>
					</tr>
					<?php } $titulo--; ?>
-->
					<tr>
	
						<td><?= $c->producto ?></td>
						<td><?= $c->prod_descrip ?></td>
						<td><?= $c->prod_um ?></td>
						<td class="importe"><?= number_format($c->cant_compra,2) ?></td>
						<td class="importe"><?= number_format($c->ventas_BR+$c->ventas_SM+$c->ventas_GS,2) ?></td>
						<td class="importe"><?= number_format($c->cocina,2) ?></td>
						<td class="importe"><?= number_format($c->sanmarcos,2) ?></td>
						<td class="importe"><?= number_format($c->gastro,2) ?></td>
						<td class="importe"><?= number_format($c->mexquite,2) ?></td>
						<td class="importe"><?= number_format($c->ventas_BR,2) ?></td>
						<td class="importe"><?= number_format($c->ventas_SM,2) ?></td>
						<td class="importe"><?= number_format($c->ventas_GS,2) ?></td>
						<td class="importe"><?= number_format($c->merma,2) ?></td>
						<td class="importe"><?= number_format($c->donativo,2) ?></td>
						<td class="importe"><?= number_format($c->chef,2) ?></td>
						<td class="importe"><?= number_format($c->asador,2) ?></td>
						<td class="importe"><?= number_format($c->cant_compra-$c->ventas_BR-$c->ventas_SM-$c->ventas_GS-$c->cocina-$c->merma-$c->donativo-$c->chef-$c->asador,2) ?></td>
					</tr>
				<?php } }?>

				</tbody>
			</table>
		</div>
	</div>
</div>