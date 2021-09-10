<div style=" padding: 10px;">
	
	<table width="100%" style="text-align: center;">
		<tr>
			<td>Deli Market Por Ferbis S.A. de C.V.</td>
		</tr>
		<tr>
			<td>DMF0306309E7</td>
		</tr>
		<tr>
			<td><?= dame_fecha($solicitud->fecha1)." ".dame_hora($solicitud->fecha1) ?> - <?= dame_fecha($solicitud->fecha2)." ".dame_hora($solicitud->fecha2) ?></td>
		</tr>
		<tr>
			<td>Solicitud de traspaso entre almacenes</td>
		</tr>
		<tr>
			<td> <?= folio_solicitud($solicitud->id_solicitud)." - ".status_solicitud($solicitud->status) ?> </td>
		</tr>
		<tr>
			<td> Solicitado por: <?= $solicitud->solicitante ?></td>
		</tr>
		<?php if($solicitud->status>0){?>
		<tr>
			<td> Procesado por: <?= $solicitud->proceso ?></td>
		</tr>
		<?php } ?>
	</table>

	<table width="100%" border='1' style="border-collapse: collapse; text-align: center">
		<tr>
			<th>CODIGO</th>
			<th>PRODUCTO</th>
			<th>UNIDAD</th>
			<th>CANTIDAD</th>
		</tr>
		<?php foreach($solicitud->detalles as $d){ ?>
			<tr>
				<td><?= $d->producto ?></td>
				<td><?= $d->descripcion ?></td>
				<td><?= $d->um ?></td>
				<td><?= $d->cantidad ?></td>
			</tr>
		<?php } ?>
	</table>
</div>
<script type="text/javascript">
	 	window.print();
 		setTimeout(window.close, 3000);
</script>