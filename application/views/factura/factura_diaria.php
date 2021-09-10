<!-- Facturas sin timbrar -->
<div class="col col-md-1"></div>
<div class="col col-md-10">
	<div class="panel panel-default">
		<div class="panel-heading titulo_panel">Facturas Diarias por sucursal
			<div class="pull-right">
<form action="<?= site_url('facturacion/factura_diaria') ?>" method="post">
				<select name="mes">
					<?php for($i=1;$i<=12;$i++){?>}
						<option value="<?= $i ?>" <?php if($mes==$i) echo "selected" ?>><?= descrip_mes($i) ?></option>
					<?php } ?>
				</select>
				<select name="ano">
					<?php for($i=$ano-3;$i<=$ano;$i++){?>}
						<option value="<?= $i ?>" <?php if($ano==$i) echo "selected" ?>><?= $i ?></option>
					<?php } ?>
				</select>
				<button class="btn btn-primary btn-sm">Buscar</button>
</form>
			</div>
		</div>
		<div class="panel-body">
			<!-- Recorremos todas las sucursales -->
			<?php foreach($sucursales as $suc){?>
				<div class="col-sm-6">
					<h3 align="center"><?= $suc['nombre'] ?></h3>
					<div class="limite_y" style="height: 500px;">
						<table class="table">
							<thead>
								<tr>
									<th>Folio</th>
									<th>Fecha</th>
									<th>Dia</th>
									<th>Impuesto</th>
									<th>Importe</th>
								</tr>
							</thead>
							<tbody>
								<?php 
								$dia_anterior=0;
								foreach($suc['facturas'] as $f){
									if($dia_anterior>0&&($dia_anterior-1)!=explode("-", $f->fecha)[2]){?>
										<tr style="
											background-color: orange;
											color:white;
											font-weight: bold;
											">
											<td></td>
											<td><?= suma_dias(formato_fecha($f->fecha),1) ?></td>
											<td><?= dia_texto2(sql_fecha(suma_dias(formato_fecha($f->fecha),1))) ?></td>
											<td></td>
											<td></td>
									<?php }?>
								<tr>
									<td><?= $f->factura ?></td>
									<td><?= formato_fecha($f->fecha) ?></td>
									<td><?= dia_texto2($f->fecha) ?></td>
									<td><?= $f->impuesto ?></td>
									<td><?= $f->importe ?></td>
								</tr>
								<?php $dia_anterior=explode("-", $f->fecha)[2];} ?>
							</tbody>
						</table>
							
						</table>
					</div>
				</div>
			<?php }?>
		</div>
	</div>
</div>