<div class="col col-md-1"></div>
<div class="col col-md-10">
	<div class="panel panel-default">
		<div class="panel-heading titulo_panel">Ventas Mexquite por departamento</div>
		<div class="panel-body">
			<!--construccion de tabs uno por mes-->
			<div class="row bottom-padding-50">
				<form method="POST" action="<?= site_url('Reportes/Ventas/ventas_mexquite') ?>">
					<div class="row formulario_style">
<!-- Select para linea de centas -->
				<div class="col-md-4">
					Departamento:<br>
					<select class="multi-select" multiple="multiple" name="lineas_consulta[]">
						<optgroup label="Seleccionar Todos">
							<?php foreach($lineas as $l){?>
							<option value="<?= $l->linea ?>" 
								<?php if(isset($lineas_consulta))foreach($lineas_consulta as $lc){ if($l->linea==$lc) echo "selected"; }?>
								><?= $l->linea." ".$l->nombre ?></option>
							<?php }?>
						</optgroup>
					</select>
				</div>
				<div class="col-md-4">
					Ejercicio:<br>
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

				</div>
				</form>
			</div>


		<div class="limite_y">
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
						<th>DIA - MES</th>
					<?php for($i=1;$i<13;$i++){
						//numero de dias cal_days_in_month(CAL_GREGORIAN, 8, 2003);
						$dias_del_mes=cal_days_in_month(CAL_GREGORIAN, $i,$ano);
						for($o=1;$o<=$dias_del_mes;$o++){
						?>
						<th class="importe"><?= dia_texto($o,$i,$ano)." ".$o."-".$i?></th>
					<?php }} ?>
					</tr>
				</thead>
				<tbody>
					<?php foreach($productos as $p){?>
					<tr>
						<td><?= $p->producto?></td><td><?=$p->descripcion?></td>

						<?php for($i=1;$i<13;$i++){
							$dias_del_mes=cal_days_in_month(CAL_GREGORIAN, $i,$ano);
							for($o=1;$o<=$dias_del_mes;$o++){?>
						<td class="importe">
							<?php 
								if(isset($ventas[$i][$o][$p->producto]))
									echo number_format($ventas[$i][$o][$p->producto],0); 
									else echo "-"; 
							?>
						</td>
						<?php }} ?>
					</tr>
					<?php } ?>
				</tbody>
			</table>
		<?php }?>
		</div>




			 

		</div>
	</div>
</div>