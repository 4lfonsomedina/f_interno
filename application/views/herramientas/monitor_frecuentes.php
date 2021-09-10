<!-- Facturas sin timbrar -->
<div class="col col-md-1"></div>
<div class="col col-md-10">
	<div class="panel panel-default">
	<div class="panel-heading titulo_panel"><center><h1><b><font style="color: red">Monitor de clientes frecuentes</font></b></h1></center></div>
		<div class="panel-body">
			<!--construccion de tabs uno por mes-->
			<div class="row bottom-padding-50 formulario_style">
				<form method="POST" action="<?= site_url('sistemas/herramientas/monitor_frecuentes') ?>" class="form-consulta">

				<div class="col-xs-6">
					<b>SUCURSAL</b>
					<select class="form-control act_dep_suc" name="sucursal" <?php if(isset($bloqueo)) echo "disabled";?>>
						<option value="brasil" <?php if($sucursal=='brasil') echo "selected"; ?>>BRASIL</option>
						<option value="gastroshop" <?php if($sucursal=='gastroshop') echo "selected"; ?>>GASTROSHOP</option>
						<option value="sanmarcos" <?php if($sucursal=='sanmarcos') echo "selected"; ?>>SAN MARCOS</option>
						<option value="mexquite" <?php if($sucursal=='mexquite') echo "selected"; ?>>MEXQUITE</option>
					</select>
				</div>
				<div class="col col-xs-2">
					<b>Ejercicio</b>
					<select class="form-control" name="ano">
						<?php $actual=date('Y');for($i=0;$i<5;$i++){?>
							<option value="<?= $actual-$i ?>" <?php if($actual-$i==$ano) echo "selected"; ?>><?= $actual-$i ?></option>
						<?php } ?>
					</select>
				</div>
				<div class="col col-xs-2">
					<b>Mes</b>
					<select class="form-control" name="mes">
						<?php for($i=1;$i<13;$i++){?>
							<option value="<?= $i ?>" <?php if($i==$mes) echo "selected"; ?>><?= descrip_mes($i) ?></option>
						<?php } ?>
					</select>
				</div>
				<div class="col-xs-2">
					<br>
					<button type="submit" class="btn btn-success">Consulta</button>
				</div>
				</form>
			</div>
		</div>



<div class="limite_y">
	<?php if(isset($ventas)){ ?>
			<div class='col col-lg-12 loader_ocu'>
				<div class='spinner spinner_reporte'>
					<div class='rect1'></div><div class='rect2'></div><div class='rect3'></div><div class='rect4'></div><div class='rect5'></div>
				</div>
			</div>
			<style type="text/css">td.big-col{width:400px !important;}th.big-col{width:400px !important;}</style>
			<div class="col col-md-6">
				<h3 style="text-align: center;">Todas las ventas frecuentes***</h3>
				<table class="table table-condensed table-border-1 tabla_repote">
					<thead>
						<tr>
							<th>Fecha</th>
							<th>Clave</th>
							<th>Nombre</th>
							<th>Compras</th>
							<th>Total</th>
						</tr>
					</thead>
					<tbody>

						<?php  foreach($ventas as $v){?>
						<tr>
							<td><?= formato_fecha($v->fecha) ?></td>
							<td><a href="#" class="consulta_frecuente" suc="<?= $sucursal ?>" frec="<?= $v->cte_frec ?>">
									<?= $v->cte_frec ?>
								</a>
							</td>
							<td><?= $v->nombre ?></td>
							<td class="importe"><?= $v->ventas_dia ?></td>
							<td class="importe"><?= number_format($v->total,2) ?></td>
						</tr>
					<?php } ?>
					</tbody>
				</table>
			</div>

			<div class="col col-md-6">
				<h3 style="text-align: center;">Mas de 2,000.00 pesos en el dia***</h3>
				<table class="table table-condensed table-border-1 tabla_repote">
					<thead>
						<tr>
							<th>Fecha</th>
							<th>Clave</th>
							<th>Nombre</th>
							<th>Compras</th>
							<th>Total</th>
						</tr>
					</thead>
					<tbody>

						<?php  foreach($ventas as $v) if($v->total>2000){ ?>
						<tr>
							<td><?= formato_fecha($v->fecha) ?></td>
							<td><a href="#" class="consulta_frecuente" suc="<?= $sucursal ?>" frec="<?= $v->cte_frec ?>">
									<?= $v->cte_frec ?>
								</a>
							</td>
							<td><?= $v->nombre ?></td>
							<td class="importe"><?= $v->ventas_dia ?></td>
							<td class="importe"><?= number_format($v->total,2) ?></td>
						</tr>
					<?php } ?>
					</tbody>
				</table>
			</div>
			<div class="col col-md-6">
				<h3 style="text-align: center;">Mas de 1 compra en el dia</h3>
				<table class="table table-condensed table-border-1 tabla_repote">
					<thead>
						<tr>
							<th>Fecha</th>
							<th>Clave</th>
							<th>Nombre</th>
							<th>Compras</th>
							<th>Total</th>
						</tr>
					</thead>
					<tbody>
						<?php foreach($ventas as $v) if($v->ventas_dia>=2){?>
						<tr>
							<td><?= formato_fecha($v->fecha) ?></td>
							<td><a href="#" class="consulta_frecuente" suc="<?= $sucursal ?>" frec="<?= $v->cte_frec ?>">
									<?= $v->cte_frec ?>
								</a>
							</td>
							<td><?= $v->nombre ?></td>
							<td class="importe"><?= $v->ventas_dia ?></td>
							<td class="importe"><?= number_format($v->total,2) ?></td>
						</tr>
					<?php } ?>
					</tbody>
				</table>
			</div>

			<div class="col col-md-6">
				<h3 style="text-align: center;">TOP Frecuentes</h3>
				<table class="table table-condensed table-border-1 tabla_repote">
					<thead>
						<tr>
							<th>Clave</th>
							<th>Nombre</th>
							<th>Compras</th>
							<th>Total</th>
						</tr>
					</thead>
					<tbody>
						<?php
						$array_ventas=Array();
						foreach($ventas as $v){
							$array_ventas[$v->cte_frec]['cte_frec']=$v->cte_frec;
							$array_ventas[$v->cte_frec]['nombre']=$v->nombre;
							if(!isset($array_ventas[$v->cte_frec]['ventas_dia'])){
								$array_ventas[$v->cte_frec]['ventas_dia']=0;
							}
							if(!isset($array_ventas[$v->cte_frec]['total'])){
								$array_ventas[$v->cte_frec]['total']=0;
							}
							$array_ventas[$v->cte_frec]['ventas_dia']+=$v->ventas_dia;
							$array_ventas[$v->cte_frec]['total']+=$v->total;
						}
						$cont=0;
						foreach($array_ventas as $v){ 
						$cont++;
						?>
						<tr>
							<td>
								<a href="#" class="consulta_frecuente" suc="<?= $sucursal ?>" frec="<?=$v['cte_frec'] ?>">
									<?= $v['cte_frec'] ?>
								</a>
							</td>
							<td>
								<?= $v['nombre'] ?>
							</td>
							<td class="importe"><?= $v['ventas_dia'] ?></td>
							<td class="importe"><?= number_format($v['total'],2) ?></td>
						</tr>
					<?php } ?>
					</tbody>
				</table>
			</div>
			
			<?php } ?>
		</div>
	</div>
</div>

<!-- Modal -->
<div id="modal_cliente_frec" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">CANJES DE PUNTOS</h4>
      </div>
      <div class="modal-body">
        <table class="table" id="tabla_canjes">
        	
        </table>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>


<script type="text/javascript">
	$(document).ready(function() {
		$(".consulta_frecuente").click(function(){
			$.post("<?= site_url('sistemas/herramientas/canjes_frec') ?>",{suc:$(this).attr('suc'),frec:$(this).attr('frec')},function(r){
				$("#modal_cliente_frec").modal("show");
				$("#tabla_canjes").html(r);
			})
		})
	});
</script>