<div class="col col-md-1"></div>
<div class="col col-md-10">
	<div class="panel panel-default">
		<div class="panel-heading titulo_panel">RESUMEN DE TRANSFERENCIAS EXTERNAS</div>
		<div class="panel-body">
			<form action="<?= site_url('Reportes/traspasos/transferencias') ?>" method="post" class="form-consulta">
				<div class="row">
				<div class="col-sm-4"><b>SUCURSAL ORIGEN</b>
					<select class="form-control" name="sucursal">
						<option value="brasil" <?php if($sucursal=='brasil') echo "selected"; ?>>BRASIL</option>
						<option value="sanmarcos" <?php if($sucursal=='sanmarcos') echo "selected"; ?>>SAN MARCOS</option>
						<option value="gastroshop" <?php if($sucursal=='gastroshop') echo "selected"; ?>>GASTROSHOP</option>
						<option value="cocina" <?php if($sucursal=='cocina') echo "selected"; ?>>COCINA</option>
					</select>
				</div>
				<div class="col-sm-4">
					<b>FECHA </b>
					<input type="text" class="form-control datepicker" name="fecha" value="<?= $fecha ?>">
				</div>
				<div class="col-sm-4">
					<br>
					<button type="submit" class="btn btn-primary"> Calcular </button>
				</div>
				</div>
			</form>
			<div style="margin-top: 50px;"></div>
			<table class="table table-condensed table-border-1 tabla_repote_sin_orden">
				<thead>
					<tr>
						<th>Sucursal destino</th>
						<th align="center">Movimientos en sistema</th>
						<th align="right">Valor total de inventario tranferido</th>
					</tr>
				</thead>
				<tbody>
					<?php 
					$total1=0;
					$total2=0;
					if(isset($datos))foreach($datos as $d){ 
						$total1+=$d->movimientos;
						$total2+=$d->total;
						?>
						<tr>
							<td><?= $d->tienda ?></td>
							<td align="center" class="dia_salidas"
							sucursal="<?= $sucursal ?>" 
							destino="<?= $d->destino ?>" 
							fecha="<?= $fecha ?>"
							><a href="#"><?= $d->movimientos ?></a></td>
							<td align="right"><?= number_format($d->total,2) ?></td>
						</tr>
					<?php } ?>
						<tr>
							<td align="right"><b>Total</b></td>
							<td align="center"><?= $total1 ?></td>
							<td align="right"><?= number_format($total2,2) ?></td>
						</tr>
				</tbody>
			</table>
		</div>
	</div>
</div>

<!-- Modal -->
<div id="modal_det_salidas" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title" style="text-align: center">DETALLE DE SALIDAS</h4>
      </div>
      <div class="modal-body" style="max-height: 500px;overflow-y: auto">
        <table class="table">
        	<thead>
        		<tr>
        			<th>#salida</th>
        			<th>Usuario</th>
        			<th>Hora</th>
        			<th style="text-align: right">Total</th>
        		</tr>
        	</thead>
        	<tbody id="tabla_salidas" >
        		
        	</tbody>
        </table>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
      </div>
    </div>

  </div>
</div>

<script type="text/javascript">
	$(document).ready(function() {
		$(".dia_salidas").click(function(){
			console.log($(this).attr('sucursal'));
			console.log($(this).attr('destino'));
			console.log($(this).attr('fecha'));
			$("#tabla_salidas").html("");
			$.post('transferencias_dia', {sucursal: $(this).attr('sucursal'), destino:$(this).attr('destino'), fecha:$(this).attr('fecha')}, function(r) {
				var sal = JSON.parse(r);
				$.each(sal, function(i) {
					$("#tabla_salidas").append("<tr><td>"+sal[i].salida+"</td><td>"+sal[i].id+"</td><td>"+sal[i].hora+"</td><td align='right'>"+sal[i].total+"</td></tr>");
				});
				$("#modal_det_salidas").modal("show");
				/*optional stuff to do after success */
			});
		})
	});
</script>