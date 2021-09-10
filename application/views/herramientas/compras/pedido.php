<div class="col col-md-1"></div>
<div class="col col-md-10">
<?php 
$blok="";
if(isset($_GET['no_menu'])){$blok="?no_menu";} ?>

	<div class="panel panel-default">
		<div class="panel-heading titulo_panel">Herramienta de pedido por sucursal</div>
		<div class="panel-body">
			<!--construccion de tabs uno por mes-->
			<div class="row bottom-padding-50 formulario_style">
				<?php if(!isset($bloqueo)) {?>
					<form method="POST" action="<?= site_url('Reportes/Compras/pedido_gastro').$blok ?>" class="form-consulta">
				<?php } else{?>
					<form method="POST" action="<?= site_url('Reportes/Compras/pedido_gastro_2').$blok ?>" class="form-consulta">
				<?php } ?>
				<div class="col-xs-2">
					<b>SUCURSAL</b>
					<select class="form-control act_dep_suc" name="sucursal" <?php if(isset($bloqueo)) echo "disabled";?>>
						<option value="brasil" <?php if($sucursal=='brasil') echo "selected"; ?>>BRASIL</option>
						<option value="gastroshop" <?php if($sucursal=='gastroshop') echo "selected"; ?>>GASTROSHOP</option>
						<option value="sanmarcos" <?php if($sucursal=='sanmarcos') echo "selected"; ?>>SAN MARCOS</option>
						<option value="mexquite" <?php if($sucursal=='mexquite') echo "selected"; ?>>MEXQUITE</option>
					</select>
				</div>
				<div class="col-xs-3">
					<b>DEPARTAMENTO</b>
					<select class="form-control act_dep_dep" name="linea">
						<option value="T">TODOS</option>
							<?php foreach($lineas as $l){?>
							<option value="<?= $l->linea ?>" 
								<?php if(isset($linea))if("a".$linea=="a".$l->linea) echo "selected";?>><?= $l->linea." - ".$l->nombre ?></option>
							<?php }?>
					</select>
				</div>
				<div class="col-xs-3">
					<b>SUB-DEP</b>
					<select class="form-control act_dep_sub" name="subdep">
						<option value="T">TODOS</option>
						<?php foreach($subdeps as $s){?>
							<option value="<?= $s->subdepto ?>" 
								<?php if(isset($subdep))if("a".$subdep=="a".$s->subdepto) echo "selected";?>><?= $s->subdepto." - ".$s->descrip ?></option>
						<?php }?>
					</select>
				</div>
				<div class="col col-xs-1">
					<b>FECHA</b>
					<input type="text" class="form-control datepicker" name="fecha_ini" value="<?= $fecha_ini ?>">
				</div>
				<div class="col col-xs-1">
					<b>BASE</b>
					<select class='form-control' name='tipo'>	
						<option value="promedio" 
<?php if(isset($_POST['tipo'])&&$_POST['tipo']=='promedio'){ echo "selected";}?>
> Promedio </option>
						<option value="top"
<?php if(isset($_POST['tipo'])&&$_POST['tipo']=='top'){ echo "selected";}?>
> TOP </option>
					</select>
				</div>
				<div class="col-xs-2">
					<br>
					<button type="submit" class="btn btn-success">Consulta</button>
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
			<style type="text/css">td.big-col{width:400px !important;}th.big-col{width:400px !important;}</style>
			<table class="table table-condensed table-border-1 tabla_repote">
				<thead>
					<tr>
						<th>Producto</th>
						<th>Descripcion</th>
						<th>Unidad</th>
						<th><?= $f_anteriores[3] ?></th>
						<th><?= $f_anteriores[2] ?></th>
						<th><?= $f_anteriores[1] ?></th>
						<th><?= $f_anteriores[0] ?></th>
<?php if(isset($_POST['tipo'])&&$_POST['tipo']=='promedio'){ ?>
						<th>Promedio</th>
<?php }if(isset($_POST['tipo'])&&$_POST['tipo']=='top'){ ?>
						<th>Top</th>
<?php } ?>
						<th>Stock</th>
						<th>Fisico</th>
						<th>Pedido</th>
					</tr>
				</thead>
				<tbody>
					<?php foreach($ventas as $v){
						?>
					<tr>
						<td><?= $v->producto ?></td>
						<td><?= $v->descrip ?></td>
						<td><?= $v->um ?></td>
						<td><?= number_format($v->cantidad3,2) ?></td>
						<td><?= number_format($v->cantidad2,2) ?></td>
						<td><?= number_format($v->cantidad1,2) ?></td>
						<td><?= number_format($v->cantidad0,2) ?></td>
<?php if(isset($_POST['tipo'])&&$_POST['tipo']=='promedio'){ ?>
						<td><?= number_format(($v->cantidad0+$v->cantidad1+$v->cantidad2+$v->cantidad3)/4,2) ?></td>
<?php }if(isset($_POST['tipo'])&&$_POST['tipo']=='top'){ ?>
						<td><?= calcular_mayor(array($v->cantidad3,$v->cantidad2,$v->cantidad1,$v->cantidad0)); ?></td>
<?php } ?>
						<td><?= $v->min ?></td>
						<td><?= $v->exis ?></td>
						<td>
<?php if(isset($_POST['tipo'])&&$_POST['tipo']=='promedio'){ ?>
<?= number_format(calculo_pedido(round(($v->cantidad0+$v->cantidad1+$v->cantidad2+$v->cantidad3)/4,2),$v->exis,$v->min),2) ?>
				
<?php }if(isset($_POST['tipo'])&&$_POST['tipo']=='top'){ ?>
<?= number_format(calculo_pedido(calcular_mayor(array($v->cantidad3,$v->cantidad2,$v->cantidad1,$v->cantidad0)),$v->exis,$v->min),2) ?>
<?php } ?>
						</td>

					</tr>
					<?php } ?>
				</tbody>
			</table>
			<?php } ?>
		</div>



		</div>
	</div>
</div>