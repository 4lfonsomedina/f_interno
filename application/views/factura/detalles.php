<div class="col col-md-1"></div>
<div class="col col-md-10">
	<div class="panel panel-default">
		<div class="panel-heading titulo_panel">Detalles de factura</i></div>
		<div class="panel-body">
			<div class="row bottom-padding-50 formulario_style">
			<form action="<?= site_url('facturacion/consulta_detalles');?>" method="POST" class="form-consulta">
				<div class="col col-xs-5">
					<select class="form-control" name='sucursal'>
						<option value="1" <?php if($sucursal=='1') echo "selected"; ?> >Barsil</option>
						<option value="2" <?php if($sucursal=='2') echo "selected"; ?>>SanMarcos</option>
						<option value="3" <?php if($sucursal=='3') echo "selected"; ?>>GastroShop</option>
						<option value="4" <?php if($sucursal=='4') echo "selected"; ?>>Mexquite</option>
					</select>
				</div>
				<div class="col col-xs-5">
					<input type="text" class="form-control" placeholder="FOLIO FACTURA" name='folio' value="<?= $folio; ?>">
				</div>
				<div class="col col-xs-2"><button class="btn btn-success">CONSULTAR</button></div>
			</form>
			</div>
			<?php if(isset($detalles)){?>

				<div class="row bottom-padding-50 formulario_style">
				<div class="col col-xs-12">
					<div class="col col-md-1"><b>FECHA:</b><br>
						<?= formato_fecha($factura->fecha) ?>
					</div>
					<div class="col col-md-1"><b>HORA:</b><br>
						<?= $factura->id_hora ?>
					</div>
					<div class="col col-md-6"><b>RECEPTOR:</b><br>
						<?= $factura->rfc." - ".$factura->cte_nom ?>
					</div>
					<div class="col col-md-1"><b>USO CFDI:</b><br>
						<?= $factura->uso_cfdi ?>
					</div>
					<div class="col col-md-2"><b>METODO PAGO:</b><br>
						<?= $factura->metodo_pago33 ?>
					</div>
					<div class="col col-md-1"><b>IMPORTE:</b><br>
						<?= number_format($factura->importe,2) ?>
					</div>
					<div class="col col-md-1"><b>TICKET:</b><br>
						<?= $detalles[0]->ticket ?>
					</div>
					
				</div>
				</div>
			<table class="table">
				<thead>
					<th>#SAT</th>
					<th>#Producto</th>
					<th>Descripcion</th>
					<th class="centrado">Unidad</th>
					<th class="importe">Precio U.</th>
					<th class="centrado">Cantidad</th>
					<th class="importe">Total</th>
				</thead>
				<tbody>
				
				<?php $sum=0;if(isset($detalles)){foreach($detalles as $d){?>
					<tr>
						<td><?= $d->producto_sat;?></td>
						<td><?= $d->producto;?></td>
						<td><?= $d->descrip;?></td>
						<td class="centrado"><?= $d->um;?></td>
						<td class="importe"><?= number_format($d->precio,2);?></td>
						<td class="centrado"><?= $d->cantidad;?></td>
						<td class="importe"><?= number_format($d->impototal,2);?></td>
					</tr>
				<?php $sum+=$d->impototal;}} ?>
				<td colspan="5"></td>
				<td><b>TOTAL</b></td>
				<td class="importe"><b><?= number_format($sum,2);?></b></td>
				</tbody>
			</table>
		<?php } ?>
		</div>
	</div>
</div>