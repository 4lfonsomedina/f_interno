<div class="col col-md-1"></div>
<div class="col col-md-10">
	<div class="panel panel-default">
		<div class="panel-heading titulo_panel">Tickets facturados en fecha diferente a la venta</i></div>
		<div class="panel-body">
			<div class="row bottom-padding-50 formulario_style">
			<form action="<?= site_url('facturacion/anteriores');?>" method="POST" class="form-consulta">
				<div class="col col-xs-3"><b>SUCURSAL</b><br>
					<select class="form-control" name='sucursal'>
						<option value="brasil" <?php if($sucursal=='1') echo "selected"; ?> >Barsil</option>
						<option value="sanmarcos" <?php if($sucursal=='2') echo "selected"; ?>>SanMarcos</option>
						<option value="gastroshop" <?php if($sucursal=='3') echo "selected"; ?>>GastroShop</option>
						<option value="mexquite" <?php if($sucursal=='4') echo "selected"; ?>>Mexquite</option>
					</select>
				</div>
				<div class="col col-xs-2">
					<b>DESDE</b>
					<input type="text" class="form-control datepicker" name="fecha_ini" value="<?= $fecha_ini ?>">
				</div>
				<div class="col col-xs-2">
					<b>HASTA</b>
					<input type="text" class="form-control datepicker" name="fecha_fin" value="<?= $fecha_fin ?>">
				</div>
				<br>
				<div class="col col-xs-5"><button class="btn btn-success">CONSULTAR</button></div>
			</form>
			</div>
			<?php if(isset($facturas)){?>
			<div class="limite_y">

				<table class="table table-condensed table-border-1 tabla_repote">
					<thead>
						<th>FACTURA</th>
						<th>FECHA FAC</th>
						<th>TICKET</th>
						<th>FECHA TICK</th>
						<th>SUBTOTAL</th>
						<th>IMPUESTO</th>
						<th>IMPORTE</th>
						<th>BOOL</th>
					</thead>
					<tbody>
					
					<?php 
					$totalfuerasub=0;
					$totalfueraimp=0;
					$totalfuera=0;
					$sum=0;if(isset($facturas))foreach($facturas as $f){
						$rojo=false;
						
						if($f->fechaTicket!=$f->fechaFactura){
							$rojo=true;
							$totalfuerasub+=$f->subtotal;
							$totalfueraimp+=$f->impuesto;
							$totalfuera+=$f->importe;
						}
						?>
						<tr>
							<td <?php if($rojo){?>style="background-color: red; color:white;"<?php } ?>
							><?= $f->factura;?></td>
							<td <?php if($rojo){?>style="background-color: red; color:white;"<?php } ?>
							><?= formato_fecha($f->fechaFactura);?></td>
							<td <?php if($rojo){?>style="background-color: red; color:white;"<?php } ?>
							><?= $f->ticket;?></td>
							<td <?php if($rojo){?>style="background-color: red; color:white;"<?php } ?>
							><?= formato_fecha($f->fechaTicket);?></td>
							<td class="importe" <?php if($rojo){?>style="background-color: red; color:white;"<?php } ?>
							><?= number_format($f->subtotal,2);?></td>
							<td class="importe" <?php if($rojo){?>style="background-color: red; color:white;"<?php } ?>
							><?= number_format($f->impuesto,2);?></td>
							<td class="importe" <?php if($rojo){?>style="background-color: red; color:white;"<?php } ?>
							><?= number_format($f->importe,2);?></td>
							<td class="importe" <?php if($rojo){?>style="background-color: red; color:white;"<?php } ?>
							><?php if($rojo) echo "1"; else echo "0";?></td>
						</tr>
					<?php }?>
					</tbody>
				</table>

		<div class="col col-xs-9 importe" ><h3>SUBTOTAL:</h3></div>
		<div class="col col-xs-3"><h4 align="right"><?= "$ ".number_format($totalfuerasub,2); ?></h4></div>

		<div class="col col-xs-9 importe"><h3>IMPUESTO:</h3></div>
		<div class="col col-xs-3"><h4 align="right"><?= "$ ".number_format($totalfueraimp,2); ?></h4></div>

		<div class="col col-xs-9 importe"><h3>TOTAL:</h3></div>
		<div class="col col-xs-3"><h4 align="right"><?= "$ ".number_format($totalfuera,2); ?></h4></div>

		</div>
		<?php }?>
	</div>
</div>