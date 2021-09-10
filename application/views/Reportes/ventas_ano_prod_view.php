<div class="col col-md-1"></div>
<div class="col col-md-10">
	<div class="panel panel-default">
		<div class="panel-heading titulo_panel">Ventas anuales por producto</div>

		<div class="panel-body">
			<!--construccion de tabs uno por mes-->
			<div class="row bottom-padding-50 formulario_style">
				<form method="POST" action="<?= site_url('Reportes/ventas/ventas_anuales_prod') ?>" class="form-consulta">
				<div class="col-md-4">
					<b>PRODUCTO</b><br>
						<select class="form-control chosen-select" name="producto">
							<option value="NA"></option>
							<?php foreach($productos as $p){?>
								<option value="<?= $p->producto ?>" 
									<?php if($producto."a"==$p->producto."a") echo "selected"; ?>><?= $p->producto." - ".$p->desc1 ?></option>
							<?php } ?>
						</select>
					</div>
				<div class="col-md-2">
					<b>SUCURSAL</b>
					<select class="form-control" name="sucursal">
						<option value="brasil" <?php if($sucursal=='brasil') echo "selected"; ?>>BRASIL</option>
						<option value="sanmarcos" <?php if($sucursal=='sanmarcos') echo "selected"; ?>>SAN MARCOS</option>
						<option value="gastroshop" <?php if($sucursal=='gastroshop') echo "selected"; ?>>GASTROSHOP</option>
						<option value="mexquite" <?php if($sucursal=='mexquite') echo "selected"; ?>>MEXQUITE</option>
					</select>
				</div>
				<div class="col-md-2">
					<b>AÑO</b>
					<select class="form-control" name="ejercicio">
						<?php for($e=0;$e<5;$e++){?>
						<option value="<?= date('Y')-$e ?>" <?php if($ano==(date('Y')-$e)) echo "selected"; ?>><?= date('Y')-$e ?></option>
						<?php } ?>
					</select>
				</div>
				<div class="col-md-2">
					<b>AGRUPADO</b>
					<select class="form-control" name="grupo">
						<option value="diario" <?php if($grupo=='diario') echo "selected"; ?>>DIARIO</option>
						<option value="semanal" <?php if($grupo=='semanal') echo "selected"; ?>>SEMANAL</option>
						<option value="mensual" <?php if($grupo=='mensual') echo "selected"; ?>>MENSUAL</option>
					</select>
				</div>
				<div class="col-md-2">
					<br>
					<button type="submit" class="btn btn-success">Consulta</button>
				</div>
				</form>
			</div>


		<div class="limite_y">
			<style type="text/css">td.big-col{width:400px !important;}</style>
			<?php if(isset($ventas)){?>
				<div class='col col-lg-12 loader_ocu'>
					<div class='spinner spinner_reporte'>
					<div class='rect1'></div><div class='rect2'></div><div class='rect3'></div><div class='rect4'></div><div class='rect5'></div>
					</div>
				</div>
			<table class="table table-condensed table-border-1 tabla_repote">
				<thead>
					<tr>
						<th>Fecha</th>
						<th>Unidad</th>
						<th>Cantidad</th>
						<th>Precio</th>
						<th class="importe">Total</th>
				</thead>
				<tbody>
<!-- DIARIO -->
					<?php
					$contador=0;
					if($grupo=='diario') 
					for($i=1;$i<13;$i++){
						$dias_del_mes=cal_days_in_month(CAL_GREGORIAN, $i,$ano);
						for($o=1;$o<=$dias_del_mes;$o++){
						if(isset($ventas[$i][$o])){
					?>
						<tr>
							<td data-sort="<?= $contador++; ?>" ><?= formato_fecha($ventas[$i][$o]->id_fecha) ?></td>
							<td><?= $ventas[$i][$o]->um ?></td>
							<td><?= $ventas[$i][$o]->cantidad ?></td>
							<td class="importe"><?= number_format($ventas[$i][$o]->precio,2) ?></td>
							<td class="importe"><?= number_format($ventas[$i][$o]->total,2) ?></td>
						</tr>
					<?php }}} ?>
<!-- SEMANAL -->

					<?php 
					if($grupo=='semanal'){
						$num_semana=1;
						$contador_semana=0;
						$tm_cant=0;
						$tm_importe=0;
						$tm_um="123";
						$tm_precio=0;
					for($i=1;$i<13;$i++){
						$dias_del_mes=cal_days_in_month(CAL_GREGORIAN, $i,$ano);
					for($o=1;$o<=$dias_del_mes;$o++){
						if(isset($ventas[$i][$o])){
							$tm_cant+=$ventas[$i][$o]->cantidad; 
							$tm_importe+=$ventas[$i][$o]->total; 
							$tm_um=$ventas[$i][$o]->um;
							$tm_precio=$ventas[$i][$o]->precio;
						}
						$contador_semana++;
						if($contador_semana==7){
							$contador_semana=0;
						?>
						<tr>
							<td data-sort="<?= $contador++; ?>"><?= "Semana ".$num_semana ?></td>
							<td><?= $tm_um ?></td>
							<td><?= $tm_cant ?></td>
							<td class="importe"><?= number_format($tm_precio,2) ?></td>
							<td class="importe"><?= number_format($tm_importe,2) ?></td>
						</tr>
					<?php 
							$num_semana++;
							$contador_semana=0;
							$tm_cant=0;
							$tm_importe=0;
							$tm_um="123";
							$tm_precio=0;
						?>
					<?php } } } } ?>
				

<!-- MENSUAL -->
					<?php 
					if($grupo=='mensual') 
					for($i=1;$i<13;$i++){
						$dias_del_mes=cal_days_in_month(CAL_GREGORIAN, $i,$ano);
						$tm_cant=0;
						$tm_importe=0;
						$tm_um="123";
						$tm_precio=0;

						for($o=1;$o<=$dias_del_mes;$o++)
							if(isset($ventas[$i][$o])){ 
							$tm_cant+=$ventas[$i][$o]->cantidad; 
							$tm_importe+=$ventas[$i][$o]->total; 
							$tm_um=$ventas[$i][$o]->um;
							$tm_precio=$ventas[$i][$o]->precio;
						}

					?>
						<tr>
							<td data-sort="<?= $contador++; ?>" ><?= descrip_mes($i) ?></td>
							<td><?= $tm_um ?></td>
							<td><?= $tm_cant ?></td>
							<td class="importe"><?= number_format($tm_precio,2) ?></td>
							<td class="importe"><?= number_format($tm_importe,2) ?></td>
						</tr>
					<?php } ?>

				</tbody>
			</table>
		<?php } ?>
		</div>

		</div>
	</div>
</div>