
<?php 
/*
$variable=[array(2,5,48,6,3,2,array(2,5,48,6,3,array(2,5,48,6,array(2,5,48,6,3,2,45,8,'hola'),2,45,8,4),45,8,4),8,4),5,1,6,4,3,7,9,8];
show_array2($variable);

echo $variable[0][5][6][4][8];

//burbuja n^2
$temporal=0;
for($i=0;$i<count($variable);$i++){
	for($o=0;$o<count($variable);$o++){
		if($variable[$i]<$variable[$o]){
			$temporal=$variable[$o];
			$variable[$o]=$variable[$i];
			$variable[$i]=$temporal;
		}
	}
}



exit;
*/
?>


<div class="col col-md-1"></div>
<div class="col col-md-10">
	<div class="panel panel-default">
		<div class="panel-heading titulo_panel">Ventas anuales por departamento</div>

		<div class="panel-body">
			<!--construccion de tabs uno por mes-->
			<div class="row bottom-padding-50 formulario_style">
				<form method="POST" action="<?= site_url('Reportes/Ventas/mensual_dep') ?>" class="form-consulta">
				<div class="col-md-4"><b>SUCURSAL</b>
					<select class="form-control" name="sucursal">
						<option value="brasil" <?php if($sucursal=='brasil') echo "selected"; ?>>BRASIL</option>
						<option value="sanmarcos" <?php if($sucursal=='sanmarcos') echo "selected"; ?>>SAN MARCOS</option>
						<option value="gastroshop" <?php if($sucursal=='gastroshop') echo "selected"; ?>>GASTROSHOP</option>
						<option value="mexquite" <?php if($sucursal=='mexquite') echo "selected"; ?>>MEXQUITE</option>
					</select>
				</div>
				<div class="col-md-2">
					<b>MES</b>
					<input type="hidden" value="mensual" name="grupo">
					<select class="form-control" name="mes">
						<?php for($i=1;$i<=12;$i++){ ?>
							<option value="<?= ceros_izq($i,2) ?>" <?php if($mes==$i) echo "selected"; ?>><?= descrip_mes($i) ?></option>
						<?php } ?>
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
			<?php if(isset($ventas)){?>
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
								if(isset($ventas[$i][$o][$li->linea]))
									echo number_format($ventas[$i][$o][$li->linea],2); 
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
							if(isset($ventas[$i][$o][$li->linea]))$total_semanal+=$ventas[$i][$o][$li->linea];
							$contador_semana++;
							if($contador_semana==7){?>
								<td class="importe">
									<?= number_format($total_semanal,2)?>
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
								for($o=1;$o<=$dias_del_mes;$o++){if(isset($ventas[$i][$o][$li->linea]))$total_mensual+=$ventas[$i][$o][$li->linea];}
						?>
						<td class="importe big-col" ><?= number_format($total_mensual,2);	?></td>
						<?php } ?>


					</tr>
					<?php } ?>
				</tbody>
			</table>
		<?php } ?>
		</div>

		</div>
	</div>
</div>