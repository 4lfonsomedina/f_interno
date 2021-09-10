
<?php 
/*
119-01-000	IVA pendiente de pago 16%
119-06-000	IVA pendiente de pago 8%

BRASIL 
502-01-001	Brasil Compras 0%
502-01-002	Brasil Compras 16%
502-01-005	Brasil Compras 8%

SAN MARCOS 
502-02-001	San Marcos Compras 0%
502-02-002	San Marcos Compras 16%
502-02-005	San Marcos Compras 8%

 	GASTRO 
502-03-001	Gastro Compras 0%
502-03-002	Gastro Compras 16%
502-03-005	Gastro Compras 8%
*/
$tienda=0;
switch ($sucursal) {
	case 'brasil':
		$tienda=0;break;
	case 'sanmarcos':
		$tienda=1;break;
	case 'gastroshop':
		$tienda=2;break;
}
//////////// BRASIL // SAN MARCOS // GASTRO /////
$_cero=array('50201001','50202001','50203001');
$_16=array('50201002','50202002','50203002');
$_8=array('50201005','50202005','50203005');
$_pago=array('11901000','11906000');
$_compra=array($_cero[$tienda],$_16[$tienda],$_8[$tienda]);
// $compra[0] // $compra[1] // $compra[2]

?>


<div class="col col-md-1"></div>
<div class="col col-md-10">
	<div class="panel panel-default">
		<div class="panel-heading titulo_panel">Poliza de compras</div>

		<div class="panel-body">
			<!--construccion de tabs uno por mes-->
			<div class="row bottom-padding-50 formulario_style">
				<form method="POST" action="<?= site_url('Reportes/Compras/poliza_compras') ?>" class="form-consulta">
				<div class="col-xs-4"><b>SUCURSAL</b>
					<select class="form-control" name="sucursal">
						<option value="brasil" <?php if($sucursal=='brasil') echo "selected"; ?>>BRASIL</option>
						<option value="sanmarcos" <?php if($sucursal=='sanmarcos') echo "selected"; ?>>SAN MARCOS</option>
						<option value="gastroshop" <?php if($sucursal=='gastroshop') echo "selected"; ?>>GASTROSHOP</option>
					</select>
				</div>
				<div class="col-xs-2">
					<b>MES</b>
					<input type="hidden" value="mensual" name="grupo">
					<select class="form-control" name="mes">
						<?php for($i=1;$i<=12;$i++){ ?>
							<option value="<?= ceros_izq($i,2) ?>" <?php if($mes==$i) echo "selected"; ?>><?= descrip_mes($i) ?></option>
						<?php } ?>
					</select>
				</div>
				<div class="col-xs-4">
					<b>AÑO</b>
					<select class="form-control" name="ejercicio">
						<?php for($e=0;$e<5;$e++){?>
						<option value="<?= date('Y')-$e ?>" <?php if($ano==(date('Y')-$e)) echo "selected"; ?>><?= date('Y')-$e ?></option>
						<?php } ?>
					</select>
				</div>
				<div class="col-xs-2">
					<br>
					<button type="submit" class="btn btn-success">Consulta</button>
				</div>
				</form>
			</div>


		<div class="limite_y">
			<style type="text/css">td.big-col{width:400px !important;}</style>
			<table class="table table-condensed table-border-1 tabla_repote_sin_orden">
				<thead>
					<tr>
						<th>Cuenta</th>
						<th></th>
						<th></th>
						<th></th>
						<th>Cargo</th>
						<th>Abono</th>
						<th>Factura</th>
						<th>Concepto</th>
					</tr>
				</thead>
				<tbody>
			<?php 
				$sum_cargo=0;
				$sum_abono=0;
				$fecha=""; 
				$cont=0;
			if(isset($compras))foreach($compras as $c){ 
				$cont++;
				if($c->fecha!=$fecha){
					if($fecha!=""){?>
					<tr>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td><?= $sum_cargo ?></td>
						<td><?= $sum_abono ?></td>
						<td></td>
						<td></td>
					</tr>
					
					<?php 
					$sum_cargo=0;
					$sum_abono=0;
					} 
					$fecha=$c->fecha;?>
					<tr>
						<td><b><?= formato_fecha($fecha) ?></b></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
					</tr>
				<?php } ?>


				<?php 
				$num_iva=1;//16
				///////////////// 16 /////////////////////////////////// 8 /////
				$cta_impuesto='11901000';if($c->iva==8){$cta_impuesto='11906000';$num_iva=2;}//16
				$complementaria=0;
				
				if($c->moneda=='US'){
					$c->gravado=round(($c->gravado*$c->tc),2);
					$c->tasacero=round(($c->tasacero*$c->tc),2);
					if($c->gravado<1){$c->gravado=0;$c->tasacero=$c->suma+$c->impuesto;}
					
					$total_cargo=$c->gravado+$c->tasacero+round($c->impuesto,2);

					$complementaria = round(($c->suma+$c->impuesto)-$c->totalus, 2);
					
					$ajuste = round(($c->suma+$c->impuesto), 2)-$total_cargo;
					$complementaria=$complementaria-$ajuste;
				}
				if($c->tipo=='1'&&$c->moneda!='US'){
					$c->tasacero=round($c->tasacero,2);
					$c->gravado=round($c->gravado,2);
					$c->impuesto=round($c->impuesto,2);
					$c->total=round($c->total,2);
					$c->totalus=round($c->totalus,2);
					$complementaria=round($complementaria,2);
					$c->suma=round($c->suma,2);

					if((round($c->tasacero,0)!=0&&round($c->gravado,0)!=0&&$c->impuesto!=0)||round($c->tasacero,0)==0&&round($c->gravado,0)!=0&&$c->impuesto!=0){
						$ajuste = round($c->total-$c->gravado-$c->tasacero-$c->impuesto,2);
						//$c->gravado=0;
						if($ajuste!=0){
							$c->gravado=($c->gravado+$ajuste);
							//echo "indice-".$cont." ".$ajuste." ".$c->nombre."**".$c->gravado."**".($c->gravado+$ajuste)."**"."<br>";
						}
						
					}
					
					//$c->gravado=$c->gravado-$ajuste;
				}

				if($c->tipo=='2'){
					$c->tasacero=-round($c->tasacero,2);
					$c->gravado=-round($c->gravado,2);
					$c->impuesto=-round($c->impuesto,2);
					$c->total=-round($c->total,2);
					$c->totalus=-round($c->totalus,2);
					$complementaria=-round($complementaria,2);

					$ajuste = $c->total-$c->gravado-$c->tasacero-$c->impuesto;
					//echo $ajuste;
					//$c->gravado=$c->gravado-$ajuste;
				}

				?>

<!-- CARGO -->
				<?php if(round($c->tasacero,0)!=0){ ?>
					<tr>
						<td><?= $_compra[0] ?></td>
						<td></td>
						<td></td>
						<td></td>
						<td><?= $c->tasacero ?></td>
						<td>0.00</td>
						<td><?= $c->factura ?></td>
						<td><?= $c->nombre ?></td>
					</tr>
					<?php $sum_cargo+=$c->tasacero; } ?>
					<?php if(round($c->gravado,0)!=0&&$c->impuesto!=0){?>
					<tr>
						<td><?= $_compra[$num_iva] ?></td>
						<td></td>
						<td></td>
						<td></td>
						<td><?= $c->gravado ?></td>
						<td>0.00</td>
						<td><?= $c->factura ?></td>
						<td><?= $c->nombre ?></td>
					</tr>
					<?php $sum_cargo+=$c->gravado; } ?>
					<?php if(round($c->gravado,0)!=0&&$c->impuesto!=0){?>
					<tr>
						<td><?= $cta_impuesto ?></td>
						<td></td>
						<td></td>
						<td></td>
						<td><?= $c->impuesto ?></td>
						<td>0.00</td>
						<td><?= $c->factura ?></td>
						<td><?= $c->nombre ?></td>
					</tr>
					<?php $sum_cargo+=$c->impuesto; } ?>

<!--  ABONO -->
				<?php if($c->moneda=='MN'){ ?>
					<!--  ABONO MXN -->
					<tr>
						<td><?= $c->ctacontamn ?></td>
						<td></td>
						<td></td>
						<td></td>
						<td>0.00</td>
						<td><?= $c->total ?></td>
						<td><?= $c->factura ?></td>
						<td><?= $c->nombre ?></td>
					</tr>
				<?php $sum_abono+=$c->total; } ?>
				<?php if($c->moneda=='US'){?>
					<!--  ABONO US -->
					<tr>
						<td><?= $c->ctacontaus ?></td>
						<td></td>
						<td></td>
						<td></td>
						<td>0.00</td>
						<td><?= $c->totalus ?></td>
						<td><?= $c->factura ?></td>
						<td><?= $c->nombre ?></td>
					</tr>
					<tr>
						<td><?= $c->ctacomple ?></td>
						<td></td>
						<td></td>
						<td></td>
						<td>0.00</td>
						<td><?= $complementaria ?></td>
						<td><?= $c->factura ?></td>
						<td><?= $c->nombre ?></td>
					</tr>
				<?php $sum_abono+=$c->totalus+$complementaria; }?>
			<?php } ?>
			<tr>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td><?= $sum_cargo ?></td>
						<td><?= $sum_abono ?></td>
						<td></td>
						<td></td>
					</tr>

</tbody>
			</table>
		</div>

		</div>
	</div>
</div>