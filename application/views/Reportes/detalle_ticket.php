<div class="col col-md-1"></div>
<div class="col col-md-10">
	<div class="panel panel-default">
		<div class="panel-heading titulo_panel">Detalle de ticket</div>
		<div class="panel-body">
			<div class="row bottom-padding-50 formulario_style">
			<form action="<?= site_url('reportes/ventas/detalle_ticket');?>" method="POST" class="form-consulta" autocomplete="off">
				<div class="col col-md-4">
					<b>TICKET</b>
					<input type="text" class="form-control producto_input" name="ticket" value="<?= $ticket ?>">
				</div>
				<div class="col-md-4">
					<b>SUCURSAL</b>
					<select class="form-control act_dep_suc" name="sucursal">
						<option value="brasil" <?php if($sucursal=='brasil') echo "selected"; ?>>BRASIL</option>
						<option value="sanmarcos" <?php if($sucursal=='sanmarcos') echo "selected"; ?>>SAN MARCOS</option>
						<option value="gastroshop" <?php if($sucursal=='gastroshop') echo "selected"; ?>>GASTROSHOP</option>
						<option value="mexquite" <?php if($sucursal=='mexquite') echo "selected"; ?>>MEXQUITE</option>
					</select>
				</div>
				<div class="col col-md-4"><br><button class="btn btn-success">CONSULTAR</button></div>
			</form>
			</div>
			<p align="center">
			<?php if(isset($venta)){ ?>
				<b>Ticket:</b> <?= $ticket ?><br>
				<b>Fecha:</b> <?= explode(" ", $venta->id_fecha)[0]." ".$venta->id_hora ?><br>
				<b>Vendedor:</b> <?= $venta->id ?><br>
			<?php } ?>
			</p>
			<table class="table table-condensed tabla_repote">
				<thead>
					<th>#prod</th>
					<th>Descripcion</th>
					<th>Unidad</th>
					<th class="importe">Precio/u</th>
					<th class="importe">Cantidad</th>
					<th class="importe">Improte</th>
					<th class="importe">Impuesto</th>
					<th class="importe">Total</th>
				</thead>
				<tbody>

				<?php $t1=0;$t2=0;$t3=0;if(isset($detalle_venta))foreach($detalle_venta as $v){
					$t1+=$v->importe;$t2+=$v->impuesto;$t3+=$v->total;
					?>
					<tr>
						<td><?= $v->producto ?></td>
						<td><?= $v->descrip ?></td>
						<td><?= $v->um ?></td>
						<td class="importe"><?= number_format($v->precio,2) ?></td>
						<td class="importe"><?= $v->cantidad ?></td>
						<td class="importe"><?= number_format($v->importe,2) ?></td>
						<td class="importe"><?= number_format($v->impuesto,2) ?></td>
						<td class="importe"><?= number_format($v->total,2) ?></td>
					</tr>
				<?php }?>
				</tbody>
				<tfoot>
					<tr>
						<th colspan="5"></th>
						<th class="importe"><?= number_format($t1,2) ?></th>
						<th class="importe"><?= number_format($t2,2) ?></th>
						<th class="importe"><?= number_format($t3,2) ?></th>
					</tr>
				</tfoot>
			</table>
	</div>
</div>