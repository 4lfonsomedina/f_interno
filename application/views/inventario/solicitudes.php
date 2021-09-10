<?php foreach($solicitudes as $s){ $panel = "primary"; $hiden_btn="hidden"; if($s->status==0){$panel="default";$hiden_btn="";}?>
	<div class="col-lg-4 col-md-6">
		<div class="panel panel-<?= $panel ?>">
			<div class="panel-heading cabecera_solicitud">
				<div class="row">
					<div class="col-xs-4" style="text-align: center">
						<?= dame_fecha($s->fecha1)."<br>".dame_hora($s->fecha1); ?>
					</div>
					<div class="col-xs-4" style="text-align: center; font-size: 24px;">
						<?= folio_solicitud($s->id_solicitud) ?>
					</div>
					<div class="col-xs-2" style="text-align: right;" <?= $hiden_btn ?>>
						<a href="#" class="btn btn-success btn-sm sol_procesar" id_solicitud="<?= $s->id_solicitud ?>" > 
							<i class="fa fa-check" aria-hidden="true"></i>
						</a>
					</div>
					<div class="col-xs-2" style="text-align: right;">
						<a href="InventarioController/imprimir_solicitud?id_solicitud=<?= $s->id_solicitud ?>" target="_blank" 
							class="btn btn-default btn-sm sol_imprimir" 
							id_solicitud="<?= $s->id_solicitud ?>"> 
							<i class="fa fa-print" aria-hidden="true"></i>
						</a>
					</div>
				</div>
			</div>
			<div class="panel-body cuerpo_solicitud" hidden>
				<div class="row">
					<div class="col-xs-12">
						<table class="table">
							<thead>
								<tr>
									<th>Codigo</th>
									<th>Descripcion</th>
									<th>Unidad</th>
									<th>Cantidad</th>
								</tr>
							</thead>
							<tbody>
								<?php foreach($s->detalles as $d){?>
									<tr>
										<td><?= $d->producto ?></td>
										<td><?= $d->descripcion ?></td>
										<td><?= $d->um ?></td>
										<td><?= $d->cantidad ?></td>
									</tr>
								<?php } ?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>


<?php } ?>