<div class="col col-md-1"></div>
<div class="col col-md-10">
	<div class="panel panel-default">
		<div class="panel-heading titulo_panel">Recibo de proveedores</div>
		<div class="panel-body">
			<form action="<?= site_url('Reportes/traspasos/carga_usuarios') ?>" method="post" class="form-consulta">
				<div class="row">
				<div class="col-sm-3"><b>SUCURSAL</b>
					<select class="form-control" name="sucursal">
						<option value="brasil" <?php if($sucursal=='brasil') echo "selected"; ?>>BRASIL</option>
						<option value="sanmarcos" <?php if($sucursal=='sanmarcos') echo "selected"; ?>>SAN MARCOS</option>
						<option value="gastroshop" <?php if($sucursal=='gastroshop') echo "selected"; ?>>GASTROSHOP</option>
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
			<div style="margin-top: 50px;"></div>
			<table class="table table-condensed table-border-1 tabla_repote_sin_orden">
				<thead>
					<tr>
						<th>fecha</th>
						<th>ID</th>
						<th>Nombre</th>
						<th align="center">Recibos</th>
						<th align="center">Articulos</th>
						<th align="center">Unidades</th>
						<th align="right">Importe MXN</th>
						<th align="right">Importe US</th>
					</tr>
				</thead>
				<tbody>
					<?php 

					$suma=array(0,0,0,0,0);
					$temp_fecha="";
					if(isset($datos))foreach($datos as $d){
						

						if($temp_fecha!=$d->fecha && $temp_fecha!=""){
						?>
						<tr style="border-top: solid 2px;">
							<td></td><td></td><td></td>
							<td align="center"><b><?= number_format($suma[0],0) ?></b></b></td>
							<td align="center"><b><?= number_format($suma[1],0) ?></b></td>
							<td align="center"><b><?= number_format($suma[2],2) ?></b></td>
							<td align="right"><b><?= number_format($suma[3],2) ?></b></td>
							<td align="right"><b><?= number_format($suma[4],2) ?></b></td>
						</tr>
						<tr>
							<td>.</td><td></td><td></td><td></td><td></td><td></td><td></td><td></td>
						</tr>
					<?php 
						$suma[0]=0;
						$suma[1]=0;
						$suma[2]=0;
						$suma[3]=0;
						$suma[4]=0;
				} ?>
					<tr>
						<td><?= formato_fecha($d->fecha) ?></td>
						<td><?= $d->usuario ?></td>
						<td><?= $d->nombre ?></td>
						<td align="center"><?= number_format($d->recibos,0) ?></td>
						<td align="center"><?= number_format($d->elementos,0) ?></td>
						<td align="center"><?= number_format($d->unidades,2) ?></td>
						<td align="right"><?= number_format($d->pesos,2) ?></td>
						<td align="right"><?= number_format($d->dlls,2) ?></td>
					</tr>
					<?php $temp_fecha=$d->fecha; 
					$suma[0]+=$d->recibos;
						$suma[1]+=$d->elementos;
						$suma[2]+=$d->unidades;
						$suma[3]+=$d->pesos;
						$suma[4]+=$d->dlls;
				} ?>
					<tr style="border-top: solid 2px;">
							<td></td><td></td><td></td>
							<td align="center"><b><?= number_format($suma[0],0) ?></b></td>
							<td align="center"><b><?= number_format($suma[1],0) ?></b></td>
							<td align="center"><b><?= number_format($suma[2],2) ?></b></td>
							<td align="right"><b><?= number_format($suma[3],2) ?></b></td>
							<td align="right"><b><?= number_format($suma[4],2) ?></b></td>
					</tr>
				</tbody>
			</table>
		</div>
	</div>
</div>