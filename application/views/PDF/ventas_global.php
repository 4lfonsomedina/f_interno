				<style type="text/css">
					body{
						font-family: Arial, Helvetica, sans-serif;
					}
					table tr td{
						padding-left: 15px;
						border-bottom: solid 1px;
						font-size: 15px;
					}
					.importe{
						text-align: right;
					}
				</style>
				<?php if(isset($ventas)){
				
				//dias del mes
				$dias_mes		= cal_days_in_month(CAL_GREGORIAN, $mes,$ano);
				//en que dia comenzo el mes
				$dia_semana = nombre_dia($ano."-".$mes."-01");//yyyy-mm-dd
				//echo $ano."-".$mes."-01 -> ".$dia_semana;

				//calculo de semanas necesarias
				$inicio_papa=date('w', strtotime($ano."-".$mes."-01"));
				$sem_nec=ceil(($dias_mes+$inicio_papa)/7);
				//
				?>

				<table class="table">
					<thead>
						<tr>
							<th colspan="2" align="center"><img src="<?= base_url('assets/imagenes/logo.png') ?>" style="width: 100px"></th>
							<th colspan="6" align="center"><h2>Reporte de venta de <?= descrip_mes($mes)." ".$ano ?> </h2></th>
							<th><?= date('d/m/Y') ?></th>
						</tr>
						<tr>
							<th>SUCURSAL</th>
							<th class="importe">DOMINGO</th>
							<th class="importe">LUNES</th>
							<th class="importe">MARTES</th>
							<th class="importe">MIERCOLES</th>
							<th class="importe">JUEVES</th>
							<th class="importe">VIERNES</th>
							<th class="importe">SABADO</th>
							<th></th>
						</tr>
					</thead>
					<tbody>
						<?php 
						//iniciamos el periodo
						$gran_total=0;
						$dia_pivote=1;
						$inicio=$inicio_papa;
						$inicio2=$inicio_papa;
						$array_totales=array(0,0,0,0,0,0,0); 
						//ciclo de la semana
						for($sem=0;$sem<$sem_nec;$sem++){?>

						<tr style="background-color: black; color: white; font-weight: bold;">
							<td></td>
							<?php for($o=0;$o<7;$o++){if($inicio<=0&&$dia_pivote<=$dias_mes){?>
								<td class="importe"><?= $dia_pivote ?></td>
							<?php $dia_pivote++;}else{$inicio--;if(($sem+1)==$sem_nec){$dia_pivote++;}?>
								<td></td>
							<?php }} ?>
							<td class="importe">TOTAL(SEM)</td>
						</tr>

						<?php

						foreach($sucursales as $suc){
							$dia_pivote2=1;
							if($sem==0){ 	$inicio2	= $inicio_papa; }
							else{ 			$dia_pivote2= $dia_pivote-7; }
							$total_sem=0;
							
							?>

						<tr>
							<td><b><?= mayus_suc($suc); ?></b></td>
							<?php for($o=0;$o<7;$o++){if($inicio2<=0&&$dia_pivote2<=$dias_mes){?>
								<td class="importe">
									<?php if(isset($ventas[$suc][redondeo_fecha($ano."-".$mes."-".$dia_pivote2).' 00:00:00.000']['venta'])&&$ventas[$suc][redondeo_fecha($ano."-".$mes."-".$dia_pivote2).' 00:00:00.000']['venta']>1){?>
									<?= 
									number_format($ventas[$suc][redondeo_fecha($ano."-".$mes."-".$dia_pivote2).' 00:00:00.000']['venta'],2)?>
										<?php 
										$array_totales[$o]+=$ventas[$suc][redondeo_fecha($ano."-".$mes."-".$dia_pivote2).' 00:00:00.000']['venta'];
										$total_sem+=$ventas[$suc][redondeo_fecha($ano."-".$mes."-".$dia_pivote2).' 00:00:00.000']['venta'];} ?>
									</td>
							<?php $dia_pivote2++;}else{$inicio2--;?>
								<td></td>
							<?php }} ?>
							<td class="importe"><b><?= number_format($total_sem,2); ?></b></td>
						</tr>
						<?php }} ?>
						<tr>
							<td><b>TOTAL(DIA)</b></td>
							<?php for($o=0;$o<7;$o++){ $gran_total+=$array_totales[$o];?>
								<td class="importe"><b><?= number_format($array_totales[$o],2); ?></b></td>
							<?php }?>
							<td class="importe"><b><?= number_format($gran_total,2); ?></b></td>
						</tr>
					</tbody>
				</table>
				<?php }?>