<div class="col col-md-1"></div>
<div class="col col-md-10">
	<div class="panel panel-default">
		<div class="panel-heading titulo_panel">Compras Vs Ventas MARCA (MIXTO)</div>
		<div class="panel-body">
			<div class="row bottom-padding-50 formulario_style">
			<form action="<?= site_url('reportes/compras/comprasvsventas3');?>" method="POST" class="form-consulta" autocomplete="off">
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
					<b>Periodo venta</b>
					<input type="text" class="form-control datepicker" name="periodov1" value="<?= $periodov1 ?>">
				</div>
				<div class="col col-md-2">
					<b>hasta</b>
					<input type="text" class="form-control datepicker" name="periodov2" value="<?= $periodov2 ?>">
				</div>
				<div class="col col-md-2">
					<b>Mostrar</b>
					<select class="form-control" name="mostrar">
						<option value="cantidad" <?php if($mostrar=='cantidad') echo "selected"; ?>>Cantidad</option>
						<option value="costo" <?php if($mostrar=='costo') echo "selected"; ?>>Importe</option>
					</select>
				</div>
				<div class="col col-md-2"><br><button class="btn btn-success">CONSULTAR</button></div>
			</form>
			</div>
			<table class="table table-condensed tabla_repote">
				
				<thead>
					<tr>
						<th colspan="3"></th>
						<th colspan="2" style="text-align: center; border: solid 1px;">Compra</th>
						<th colspan="4" style="text-align: center; border: solid 1px;">Venta</th>
						<th colspan="3" style="text-align: center; border: solid 1px;">Transferencia</th>
						<th colspan="5" style="text-align: center; border: solid 1px;">Merma</th>

					</tr>
					<tr>
						<th style="border-right: solid 1px;">#prod</th>
						<th>Producto</th>
						<th>Unidad</th>
						<th style="border-right: solid 1px;">BR</th>
						<th style="border-right: solid 1px;">SM</th>
						<th>BR</th>
						<th>SM</th>
						<th>GTRO</th>
						<th style="border-right: solid 1px;">MXT</th>
						<th>COCINA</th>
						<th>MXT</th>
						<th style="border-right: solid 1px;">Devol. MXT</th>
						<th>BR</th>
						<th>SM</th>
						<th>GTRO</th>
						<th>MXT</th>
						<th style="border-right: solid 1px;">COCINA</th>
					</tr>
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