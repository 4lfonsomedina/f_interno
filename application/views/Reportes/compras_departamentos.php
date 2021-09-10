<div class="col col-md-1"></div>
<div class="col col-md-10">

	<div class="panel panel-default">
		<div class="panel-heading titulo_panel">Compras anuales detallado</div>
		<div class="panel-body">
			<!--construccion de tabs uno por mes-->
			<div class="row bottom-padding-50 formulario_style">
				<form method="POST" action="<?= site_url('Reportes/Compras/compras_departamento') ?>" class="form-consulta">
					
				<div class="col-md-2">
					<b>SUCURSAL</b>
					<select class="form-control act_dep_suc" name="sucursal">
						<option value="brasil" <?php if($sucursal=='brasil') echo "selected"; ?>>BRASIL</option>
						<option value="sanmarcos" <?php if($sucursal=='sanmarcos') echo "selected"; ?>>SAN MARCOS</option>
						<option value="gastroshop" <?php if($sucursal=='gastroshop') echo "selected"; ?>>GASTROSHOP</option>
						<option value="mexquite" <?php if($sucursal=='mexquite') echo "selected"; ?>>MEXQUITE</option>
					</select>
				</div>
				<div class="col-md-3">
					<b>DEPARTAMENTO</b>
					<select class="form-control act_dep_dep" name="linea">
						<option value="T">TODOS</option>
							<?php foreach($lineas as $l){?>
							<option value="<?= $l->linea ?>" 
								<?php if(isset($linea))if("a".$linea=="a".$l->linea) echo "selected";?>><?= $l->linea." - ".$l->nombre ?></option>
							<?php }?>
					</select>
				</div>
				<div class="col-md-3">
					<b>SUB-DEP</b>
					<select class="form-control act_dep_sub" name="subdep">
						<option value="T">TODOS</option>
						<?php foreach($subdeps as $s){?>
							<option value="<?= $s->subdepto ?>" 
								<?php if(isset($subdep))if("a".$subdep=="a".$s->subdepto) echo "selected";?>><?= $s->subdepto." - ".$s->descrip ?></option>
						<?php }?>
					</select>
				</div>
				<div class="col-md-1">
					<b>MONEDA</b>
					<select class="form-control" name="moneda">
						<option value='todo' <?php if($moneda=='todo') echo "selected"; ?>>TODO EN PESOS</option>
						<option value='MN' <?php if($moneda=='MN') echo "selected"; ?>>SOLO COMPRAS PESOS</option>
						<option value='US' <?php if($moneda=='US') echo "selected"; ?>>SOLO COMPRAS DOLARES</option>
					</select>
				</div>
				<div class="col-md-1">
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
			
			<table class="table table-condensed tabla_repote_sin_orden">
				<thead>
					<th>Fecha</th>
					<th>#Compra</th>
					<th>#Producto</th>
					<th>#Proveedor</th>
					<th>Nom. Prov.</th>
					<th>Cantidad</th>
					<th>Precio/U</th>
					<th>Total</th>
				</thead>
				<tbody>

					<?php $producto = "";$contador=0;foreach($detalles as $d){
						if($producto!=$d->producto){
							$producto=$d->producto;
					?>
					<tr style="background-color: #595959; color:white;">
						<td></td>
						<td></td>
						<td><?= $d->producto?></td>
						<td><?php if(!isset($d->proveedor[0]['compra'])){ echo "XXX"; }?></td>
						<td><?= $d->desc1 ?></td>
						<td></td>
						<td></td>
						<td></td>
					</tr>
					<?php foreach($d->proveedor as $p){?>
					<tr>
						<td data-sort="<?= $contador++; ?>"><?= formato_fecha($p['fecha']) ?></td>
						<td><?= $p['compra'] ?></td>
						<td><?= $p['producto'] ?></td>
						<td><?= $p['proveedor'] ?></td>
						<td><?= $p['nombre'] ?></td>
						<td><?= $p['cantidad'] ?></td>
						<td><?= $p['costo'] ?></td>
						<td><?= $p['importe'] ?></td>
					</tr>
					<?php } } }?>
				</tbody>
			</table>
		<?php } ?>
		</div>




			 

		</div>
	</div>
</div>