				<style type="text/css">
					body{
						font-family: Arial, Helvetica, sans-serif;
					}
					table tr td{
						padding-left: 15px;
						border-bottom: solid 1px;
						font-size: 12px;
					}
					.importe{
						text-align: right;
					}
				</style>
<div class="col col-md-1"></div>
<div class="col col-md-10">
	

			<table class="table table-condensed tabla_repote" style="width: 100%">
				<thead>
					<tr>
						<th colspan="1" align="center" style="padding-bottom: 30px"><img src="<?= base_url('assets/imagenes/logo.png') ?>" style="width: 100px"></th>
						<th colspan="2" align="center"><h2>Productos sin clave SAT </h2></th>
						<th colspan="1"><?= date('d/m/Y') ?></th>
					</tr>
					<tr>
						<th>PRODUCTO</th>
						<th>DESCRIPCION</th>
						<th>FECHA ALTA</th>
						<th>USUARIO</th>
					</tr>
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


