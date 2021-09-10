<div class="col col-md-1"></div>
<div class="col col-md-10">
	<div class="panel panel-default">
		<div class="panel-heading titulo_panel">Resumen de formas de pago</div>
		<div class="panel-body">
			<div class="row bottom-padding-50 formulario_style">
			<form action="<?= site_url('facturacion/formas_pago');?>" method="POST" class="form-consulta" autocomplete="off">
				<div class="col col-md-4">
					<b>DEDE</b>
					<input type="text" class="form-control datepicker" name="fecha1" value="<?= $fecha1 ?>">
				</div>
				<div class="col col-md-4">
					<b>HASTA</b>
					<input type="text" class="form-control datepicker" name="fecha2" value="<?= $fecha2 ?>">
				</div>
				<div class="col col-md-4"><br><button class="btn btn-success">CONSULTAR</button></div>
			</form>
			</div>
			<div class="row">
				<?php if(isset($ventas))foreach($formas_pago as $fp)if($fp->incr>0){?>
				<div class="col-md-2">
					<div class="panel panel-default" style="text-align: center">
						<div class="panel-heading" style="background-color: black;color: white;"><b><?= $fp->descrip ?></b></div>
						<div class="panel-body">$<?= number_format($fp->incr,2); ?></div>
					</div>
				</div>
				<?php } ?>
			</div>

			<table class="table table-condensed tabla_repote">
				<thead>
					<th>FECHA</th>
					<th>IMPORTE</th>
					<th>CLAVE</th>
					<th>FORMA PAGO</th>
				</thead>
				<tbody>

				<?php if(isset($ventas)){foreach($ventas as $vv)foreach($vv as $v)if($v->clave!='01'&&$v->clave!='02'&&$v->clave!='06'&&$v->clave!='05'){?>
					<tr>
						<td><?= formato_fecha($v->id_fecha) ?></td>
						<td><?= $v->importe ?></td>
						<td><?= $v->clave ?></td>
						<td><?= $v->descrip ?></td>
					</tr>
				<?php } }?>

				</tbody>
			</table>

			</div>
		</div>
	</div>
</div>