<div class="col col-md-1"></div>
<div class="col col-md-10">
	<div class="panel panel-default">
		<div class="panel-heading titulo_panel">Compras anuales por departamento</div>
		<div class="panel-body">
			<!--construccion de tabs uno por mes-->
			<div class="row bottom-padding-50 formulario_style">
				<form method="POST" action="<?= site_url('Reportes/Compras') ?>" class="form-consulta">
				<div class="col-md-4"><b>SUCURSAL</b>
					<select class="form-control" name="sucursal">
						<option value="brasil" <?php if($sucursal=='localbrasil') echo "selected"; ?>>BRASIL</option>
						<option value="sanmarcos" <?php if($sucursal=='localsanmarcos') echo "selected"; ?>>SAN MARCOS</option>
						<option value="gastroshop" <?php if($sucursal=='localgastroshop') echo "selected"; ?>>GASTROSHOP</option>
						<option value="mexquite" <?php if($sucursal=='localmexquite') echo "selected"; ?>>MEXQUITE</option>
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
				<div class="col-md-4">
					<b>AÑO</b>
					<select class="form-control" name="ejercicio">
						<?php for($e=0;$e<5;$e++){?>
						<option value="<?= date('Y')-$e ?>" <?php if($ano==(date('Y')-$e)) echo "selected"; ?>><?= date('Y')-$e ?></option>
						<?php } ?>
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
			<?php if(isset($compras)){?>
				<div class='col col-lg-12 loader_ocu'>
					<div class='spinner spinner_reporte'>
					<div class='rect1'></div><div class='rect2'></div><div class='rect3'></div><div class='rect4'></div><div class='rect5'></div>
					</div>
				</div>
			<table class="table table-condensed table-border-1 tabla_reporte_ventas_anual">
				<thead>
					<tr>
						<th></th>
						<th><?= $grupo ?></th>

<!-- DIARIO -->
					<?php if($grupo=='diario')for($i=1;$i<13;$i++){
						$dias_del_mes=cal_days_in_month(CAL_GREGORIAN, $i,$ano);
							for($o=1;$o<=$dias_del_mes;$o++){?>
						<th class="importe"><?= dia_texto($o,$i,$ano)." ".$o."-".$i?></th>
					<?php }} ?>


<!-- SEMANAL -->
					<?php if($grupo=='semanal')for($i=1;$i<53;$i++){?>
						<th class="importe"><?= "Sem".$i ?></th>
					<?php } ?>


<!-- MENSUAL -->
					<?php if($grupo=='mensual')for($i=1;$i<13;$i++){?>
						<th><?= descrip_mes($i) ?></th>
					<?php } ?>


					</tr>
				</thead>
				<tbody>
					<?php foreach($lineas as $li){?>
					<tr>
						<td><?= $li->linea?></td><td><?=$li->descripcion?></td>

<!-- DIARIO -->
						<?php if($grupo=='diario')for($i=1;$i<13;$i++){
							$dias_del_mes=cal_days_in_month(CAL_GREGORIAN, $i,$ano);
							for($o=1;$o<=$dias_del_mes;$o++){?>
						<td class="importe">
							<?php 
								if(isset($compras[$i][$o][$li->linea]))
									echo number_format($compras[$i][$o][$li->linea],2); 
									else echo "0.00";
							?>
						</td>
						<?php }} ?>

<!-- SEMANAL -->
						<?php if($grupo=='semanal'){
							$total_semanal=0;
							$num_semana=1;
							$contador_semana=0;
							for($i=1;$i<13;$i++){
							$dias_del_mes=cal_days_in_month(CAL_GREGORIAN, $i,$ano);
							for($o=1;$o<=$dias_del_mes;$o++){
							if(isset($compras[$i][$o][$li->linea]))$total_semanal+=$compras[$i][$o][$li->linea];
							$contador_semana++;
							if($contador_semana==7){?>
								<td class="importe">
									<?= number_format($total_semanal,2) ?>
								</td>
							<?php 
							$num_semana++;
							$contador_semana=0;
							$total_semanal=0;
							}
							 ?>
						<?php }}} ?>
<!-- MENSUAL -->
						<?php 
							if($grupo=='mensual')for($i=1;$i<13;$i++){
								$dias_del_mes=cal_days_in_month(CAL_GREGORIAN, $i,$ano);
								$total_mensual=0;
								for($o=1;$o<=$dias_del_mes;$o++){if(isset($compras[$i][$o][$li->linea]))$total_mensual+=$compras[$i][$o][$li->linea];}
						?>
						<td class="importe big-col" ><?= number_format($total_mensual,2);	?></td>
						<?php } ?>
					</tr>
					<?php } ?>
				</tbody>
			</table>
		<?php }?>
		</div>




			 

		</div>
	</div>
</div>