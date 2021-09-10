<!-- Facturas sin timbrar -->
<div class="col col-md-1"></div>
<div class="col col-md-10">
	<div class="panel panel-default">
		<div class="panel-heading titulo_panel">Facturas sin timbrar por sucursal</div>
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
									<th>Receptor</th>
									<th>Total</th>
								</tr>
							</thead>
							<tbody>
								<?php foreach($suc['facturas'] as $f){?>
								<tr>
									<td><?= $f->folio ?></td>
									<td><?= $f->fecha ?></td>
									<td><?= $f->receptor ?></td>
									<td><?= $f->total ?></td>
								</tr>
								<?php } ?>
							</tbody>
						</table>
							
						</table>
					</div>
				</div>
			<?php }?>
		</div>
	</div>
</div>


<!-- imprimir querys-->
<div class="col col-xs-6">
	<center>Timbrar global fuera de tiempo <br>
		UPDATE p_fact SET fecha='YYYY-mm-dd' WHERE factura='XXXXXXXX'<br>
		UPDATE p_factele SET fecha='YYYY-mm-dd' WHERE factura='XXXXXXXX'
</center>
<textarea class="form-control" rows="10">
<?php for($i=0;$i<4;$i++)foreach($sucursales[$i]['facturas'] as $f){?>
[<?= $i ?>1]UPDATE p_fact SET fecha='<?= date('Y-m-d') ?>' WHERE factura='<?= $f->folio ?>'
[<?= $i ?>1]UPDATE p_factele SET fecha='<?= date('Y-m-d') ?>' WHERE factura='<?= $f->folio ?>'
[<?= $i ?>2]UPDATE p_fact SET fecha='<?= $f->fecha ?>' WHERE factura='<?= $f->folio ?>'
[<?= $i ?>2]UPDATE p_factele SET fecha='<?= $f->fecha ?>' WHERE factura='<?= $f->folio ?>'
<?php } ?>
</textarea>
</div>
<div class="col col-xs-6">
	<center>Arreglar rfc<br>
		UPDATE p_factele SET rfc='XXXXX' WHERE rfc='YYYYYYYYY' and factura='ZZZZZZZZZZZZZZ'<br>
		UPDATE p_ctesfact SET rfc='XXXXX' WHERE rfc='YYYYYYYYY'
</center>
<textarea class="form-control" rows="10">
<?php for($i=0;$i<4;$i++)foreach($sucursales[$i]['facturas'] as $f){?>
[<?= $i ?>1]UPDATE p_factele SET rfc='XXXXX' WHERE rfc='<?= $f->receptor ?>' and factura='<?= $f->folio ?>'
[<?= $i ?>1]UPDATE p_ctesfact SET rfc='XXXXX' WHERE rfc='<?= $f->receptor ?>'
<?php } ?>
</textarea>
</div>