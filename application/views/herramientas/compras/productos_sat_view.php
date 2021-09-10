<div class="col col-md-1"></div>
<div class="col col-md-10">
	<div class="panel panel-default">
		<div class="panel-heading titulo_panel">Resumen de formas de pago</div>
		<div class="panel-body">

			<table class="table table-condensed tabla_repote">
				<thead>
					<th>PRODUCTO</th>
					<th>DESCRIPCION</th>
					<th>FECHA ALTA</th>
					<th>USUARIO</th>
				</thead>
				<tbody>

				<?php if(isset($productos)){foreach($productos as $c){?>
					<tr>
						<td><?= $c->producto ?></td>
						<td><?= $c->desc1 ?></td>
						<td><?= formato_fecha($c->id_fecha) ?></td>
						<td><?= $c->id ?></td>
					</tr>
				<?php } }?>

				</tbody>
			</table>

			</div>
		</div>
	</div>
</div>