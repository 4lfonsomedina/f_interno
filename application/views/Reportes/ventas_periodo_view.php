<div class="col col-md-1"></div>
<div class="col col-md-10">
	<div class="panel panel-default">
		<div class="panel-heading titulo_panel">Ventas por Periodo</i></div>
		<div class="panel-body">
			<div class="row bottom-padding-50 formulario_style">
			<form action="<?= site_url('facturacion/anteriores');?>" method="POST" class="form-consulta">
				<div class="col col-md-3"><b>SUCURSAL</b><br>
					<select class="form-control" name='sucursal'>
						<option value="brasil" <?php if($sucursal=='brasil') echo "selected"; ?> >Barsil</option>
						<option value="sanmarcos" <?php if($sucursal=='sanmarcos') echo "selected"; ?>>SanMarcos</option>
						<option value="gastroshop" <?php if($sucursal=='gastrochop') echo "selected"; ?>>GastroShop</option>
						<option value="mexquite" <?php if($sucursal=='mexquite') echo "selected"; ?>>Mexquite</option>
					</select>
				</div>
				<div class="col col-md-2">
					<b>DEPARTAMENTO</b>
					<input type="text" class="form-control datepicker" name="fecha_ini" value="<?= $fecha_ini ?>">
				</div>
				<div class="col col-md-2">
					<b>SUBDEPARTA</b>
					<input type="text" class="form-control datepicker" name="fecha_fin" value="<?= $fecha_fin ?>">
				</div>
				<div class="col col-md-2">
					<b>DESDE</b>
					<input type="text" class="form-control datepicker" name="fecha_ini" value="<?= $fecha_ini ?>">
				</div>
				<div class="col col-md-2">
					<b>HASTA</b>
					<input type="text" class="form-control datepicker" name="fecha_fin" value="<?= $fecha_fin ?>">
				</div>
				<br>
				<div class="col col-md-5"><button class="btn btn-success">CONSULTAR</button></div>
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
						<th>IMPORTE</th>
					</thead>
					<tbody>
					
					<?php 
					$totalfuera=0;
					$sum=0;if(isset($facturas))foreach($facturas as $f){
						$rojo=false;
						
						if($f->fechaTicket!=$f->fechaFactura){
							$rojo=true;
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
							><?= number_format($f->importe,2);?></td>
						</tr>
					<?php }?>
					</tbody>
				</table>
		
		<div class="col col-md-9">
			<h3>Total con iva facturado fuera de tiempo en el periodo:</h3>
		</div><div class="col col-md-3">
			<h4 align="right"><?= "$ ".number_format($totalfuera,2); ?></h4></div>
		</div>
		<?php }?>
	</div>
</div>