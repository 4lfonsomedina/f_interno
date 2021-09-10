<div class="col col-md-1"></div>
<div class="col col-md-10">
	<div class="panel panel-default">
		<div class="panel-heading titulo_panel">Salidas de mercancia</div>
		<div class="panel-body">
			<div class="row bottom-padding-50 formulario_style">
			<form action="<?= site_url('reportes/traspasos');?>" method="POST" class="form-consulta" autocomplete="off">
				<div class="col-md-4">
					<b>SUCURSAL</b>
					<select class="form-control act_tipo_trans" name="sucursal">
						<option value="brasil" <?php if($sucursal=='brasil') echo "selected"; ?>>BRASIL</option>
						<option value="sanmarcos" <?php if($sucursal=='sanmarcos') echo "selected"; ?>>SAN MARCOS</option>
						<option value="gastroshop" <?php if($sucursal=='gastroshop') echo "selected"; ?>>GASTROSHOP</option>
						<option value="mexquite" <?php if($sucursal=='mexquite') echo "selected"; ?>>MEXQUITE</option>
					</select>
				</div>
				<div class="col col-md-2">
					<b>DESDE</b>
					<input type="text" class="form-control datepicker" name="periodo1" value="<?= $periodo1 ?>">
				</div>
				<div class="col col-md-2">
					<b>HASTA</b>
					<input type="text" class="form-control datepicker" name="periodo2" value="<?= $periodo2 ?>">
				</div>
				<div class="col col-md-2">
					<b>CLAVE</b>
					<select class="form-control act_trans" name="tipo_salida">
						<?php foreach($tipo_salidas as $ts){?>
						<option value="<?= $ts->clave ?>" <?php if(isset($tipo_salida)&&$tipo_salida==$ts->clave) echo "selected"; ?>><?= $ts->clave." - ".$ts->descripcion ?></option>
					<?php } ?>
					</select>
				</div>
				<div class="col col-md-2"><br><button class="btn btn-success">CONSULTAR</button></div>
			</form>
			</div>
			<?php if(isset($salidas)){ ?>
			<table class="table table-condensed tabla_repote">
				<thead>
					<th>#Clave</th>
					<th>Descripcion</th>
					<th>Dep.</th>
					<th>Prov.</th>
					<th>Origen</th>
					<th>Destino</th>
					<th>Unidad</th>
					<th>Cantidad</th>
					<th>Subtotal</th>
					<th>Impuesto</th>
					<th>Total</th>
					
					
				</thead>
				<tbody>

				<?php 
				
				//TOTALES POR DEPARTAMENTOS
				//agrupamos los departamentos
				$departamentos=array();
				foreach($salidas as $s){
					$existe=FALSE;
					foreach($departamentos as &$d){
						if("D".$d['linea']=="D".$s->linea){
							$existe=TRUE;
							$d['cantidad'] += $s->cantidad;
							$d['total'] += $s->total;
							$d['um'] = $s->um;
						}
					}
					if(!$existe){
						$departamentos[]['linea']=$s->linea;
						$departamentos[count($departamentos)-1]['cantidad']=0+$s->cantidad;
						$departamentos[count($departamentos)-1]['total']=0+$s->total;
						$departamentos[count($departamentos)-1]['um']=$s->um;
					}
				}
				//totales
				$t[0][0]=0;//subtotal br
				$t[0][1]=0;//imp br
				$t[0][2]=0;//total br
				$t[1][0]=0;//subtotal sm
				$t[1][1]=0;//imp sm
				$t[1][2]=0;//total sm
				$t[2][0]=0;//subtotal gs
				$t[2][1]=0;//imp gs
				$t[2][2]=0;//total gs
				$t[3][0]=0;//subtotal br
				$t[3][1]=0;//imp br
				$t[3][2]=0;//total br
				$t[4][0]=0;//subtotal cocina
				$t[4][1]=0;//imp cocina
				$t[4][2]=0;//total cocina
				

					foreach($salidas as $s){?>
					<tr>
						<td><?= $s->producto?></td>
						<td><?= $s->desc1 ?></td>
						<td><?php foreach($lineas as $lin)if("D".$lin->linea=="D".$s->linea){ echo $lin->nombre; }?></td>
						<td><?= $s->proveedor ?></td>
						<td><?= $s->almacen ?></td>
						<td><?= $s->nom_dest ?></td>
						<td><?= $s->um ?></td>
						<td class="importe"><?= round($s->cantidad,2) ?></td>
						<td class="importe"><?= number_format($s->importe,2) ?></td>
						<td class="importe"><?= number_format($s->impuesto,2) ?></td>
						<td class="importe"><?= number_format($s->total,2) ?></td>
						
					</tr>
				<?php 
				if($s->nom_dest=='FERBIS BRASIL'){
					$t[0][0]+=$s->importe;//subtotal br
					$t[0][1]+=$s->impuesto;//imp br
					$t[0][2]+=$s->total;//total br
				}
				if($s->nom_dest=='FERBIS SAN MARCOS'){
					$t[1][0]+=$s->importe;//subtotal br
					$t[1][1]+=$s->impuesto;//imp br
					$t[1][2]+=$s->total;//total br
				}
				if($s->nom_dest=='GASTROSHOP'){
					$t[2][0]+=$s->importe;//subtotal br
					$t[2][1]+=$s->impuesto;//imp br
					$t[2][2]+=$s->total;//total br
				}
				if($s->nom_dest=='MEXQUITE'){
					$t[3][0]+=$s->importe;//subtotal br
					$t[3][1]+=$s->impuesto;//imp br
					$t[3][2]+=$s->total;//total br
				}
				if($s->nom_dest=='COCINA BRASIL'){
					$t[4][0]+=$s->importe;//subtotal br
					$t[4][1]+=$s->impuesto;//imp br
					$t[4][2]+=$s->total;//total br
				}
			} ?>

				</tbody>
			</table>

			<div class="col col-md-6">
				<table class="table">
					<tr><th colspan="4" style="text-align: center"><h3>RESUMEN DE TRANSFERENCIAS ENTRE SUCURSALES</h3></th></tr>
					<tr>
						<th>DESTINO</th>
						<th class="importe">SUBTOTAL</th>
						<th class="importe">IMPUESTO</th>
						<th class="importe">TOTAL</th>
					</tr>
					<tr>
						<td>FERBIS BRASIL</td>
						<td class="importe"><?= number_format($t[0][0],2) ?></td>
						<td class="importe"><?= number_format($t[0][1],2) ?></td>
						<td class="importe"><?= number_format($t[0][2],2) ?></td>
					</tr>
					<tr>
						<td>FERBIS SAN MARCOS</td>
						<td class="importe"><?= number_format($t[1][0],2) ?></td>
						<td class="importe"><?= number_format($t[1][1],2) ?></td>
						<td class="importe"><?= number_format($t[1][2],2) ?></td>
					</tr>
					<tr>
						<td>GASTROSHOP</td>
						<td class="importe"><?= number_format($t[2][0],2) ?></td>
						<td class="importe"><?= number_format($t[2][1],2) ?></td>
						<td class="importe"><?= number_format($t[2][2],2) ?></td>
					</tr>
					<tr>
						<td>MEXQUITE</td>
						<td class="importe"><?= number_format($t[3][0],2) ?></td>
						<td class="importe"><?= number_format($t[3][1],2) ?></td>
						<td class="importe"><?= number_format($t[3][2],2) ?></td>
					</tr>
					<tr>
						<td>COCINA BRASIL</td>
						<td class="importe"><?= number_format($t[4][0],2) ?></td>
						<td class="importe"><?= number_format($t[4][1],2) ?></td>
						<td class="importe"><?= number_format($t[4][2],2) ?></td>
					</tr>
				</table>
			</div>

			<div class="col col-md-6">
				<table class="table">
					<tr><th colspan="4" style="text-align: center"><h3>RESUMEN DE TOTALES POR DEPARTAMENTO</h3></th></tr>
					<tr>
						<th>DEPARTAMENTO</th>
						<th class="importe">UNIDAD</th>
						<th class="importe">CANTIDAD</th>
						<th class="importe">TOTAL</th>
					</tr>
					<?php foreach($departamentos as $dep){?>
						<tr>
							<td><?php foreach($lineas as $lin)if("D".$lin->linea=="D".$dep['linea']){ echo $lin->nombre; }?></td>
							<td class="importe"><?= $dep['um'] ?></td>
							<td class="importe"><?= number_format($dep['cantidad'],2) ?></td>
							<td class="importe"><?= number_format($dep['total'],2) ?></td>
						</tr>
					<?php } ?>
				</table>
			</div>
			<?php } ?>


		</div>
	</div>
</div>