<div class="col-xs-2"></div><div class="col-xs-8">
<div class="panel panel-default">
	<div class="panel-heading">Ventas fersa</div>
	<div class="panel-body">
		<table class="table">
			<thead>
				<tr>
					<th>Factura</th>
					<th>Fecha</th>
					<th>Total</th>
				</tr>
			</thead>
			<tbody>
				<?php foreach($facturas as $f){?>
				<tr>
					<td><?= $f->factura ?></td>
					<td><input type="date" value="<?= explode(' ',$f->fecha)[0]  ?>" class="fecha_f_fersa" factura='<?= $f->factura ?>'></td>
					<td><?= $f->total ?></td>
				</tr>
			<?php } ?>
			</tbody>
		</table>
	</div>
</div>
<script type="text/javascript">
	$(document).ready(function() {
		$(".fecha_f_fersa").change(function(){
			$.post('../Fersa_controller/cambiar_fecha_factura', {fecha: $(this).val(),factura:$(this).attr('factura')}, function(r) {
				alert('Fecha actualizada!');
			});
		});
	});
</script>