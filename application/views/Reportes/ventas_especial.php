<div class="col col-md-1"></div>
<div class="col col-md-10">
	<div class="panel panel-default">
		<div class="panel-heading titulo_panel">Herramienta de compras</div>
		<div class="panel-body">
			<form action="<?= site_url('Reportes/Compras/herramienta_compra') ?>" method="post" class="form-consulta">
				<div class="row">
				<div class="col-sm-3">
					<b>FECHA INI</b>
					<input type="text" class="form-control datepicker" name="fecha_ini" value="<?= $fecha_ini ?>">
					<b>FECHA FIN</b>
					<input type="text" class="form-control datepicker" name="fecha_fin" value="<?= $fecha_fin ?>">
				</div>
				<div class="col-sm-4"><b>BUSCAR POR:</b>
					<label><input type="radio" name="filtro" <?php if($filtro=='producto') echo "checked"; ?> value="producto"> Producto</label>
					<label><input type="radio" name="filtro" <?php if($filtro=='proveedor') echo "checked"; ?> value="proveedor"> Proveedor</label>
					<label><input type="radio" name="filtro" <?php if($filtro=='marca') echo "checked"; ?> value="marca"> Marca</label>
					<label><input type="radio" name="filtro" <?php if($filtro=='departamento') echo "checked"; ?> value="departamento"> Departamento</label>
				</div>
				<div class="col-sm-3"><b>UNIDAD:</b>
					<label><input type="radio" name="filtro2" <?php if($filtro2=='venta') echo "checked"; ?> value="venta"> Venta</label>
					<label><input type="radio" name="filtro2" <?php if($filtro2=='compra') echo "checked"; ?> value="compra"> Ult. Compra</label>
				</div>
				<div class="col-sm-2"><b>CODIGO</b>
					<span style="position: absolute; left: -20px;">
						<a href="#" class="btn btn-default btn-xs btn_buscar_codigo"><i class="fa fa-search" aria-hidden="true"></i></a>
					</span>
					<input type="text" class="form-control input_buscar_codigo" name="codigo" value="<?= $codigo ?>" required>

					<br>
					<button type="submit" class="btn btn-primary"> Calcular </button>
				</div>
				</div>
			</form>
			<div style="margin-top: 50px; text-align: center; color: gray;">
			</div>
			<table class="table table-condensed table-border-1 tabla_repote_sin_orden">
				<thead>
					<tr>
						<th>Clave</th>
						<th>Producto</th>
						<th>Unidad</th>
						<th>Ult.Costo</th>
						<th>Vta.BR</th>
						<th>Vta.SM</th>
						<th>Vta.GS</th>
						<th>Vta.Tot.</th>
						<th>Vta.(-1año)</th>
						<th>Dif.</th>
					</tr>
				</thead>
				<tbody>
					<?php if(isset($ventas))foreach($ventas as $v){
						$factor = 1;
						if(isset($v['umc'])){ 
							$v['um']=$v['umc'];
							$v['costo_ulti']=$v['cf'];
							$factor=$v['umf'];
						}

						if(isset($v['localbrasil'])){round($v['localbrasil'],2);}else{$v['localbrasil'] = 0;}
						if(isset($v['localsanmarcos'])){round($v['localsanmarcos'],2);}else{$v['localsanmarcos'] = 0;}
						if(isset($v['localgastroshop'])){round($v['localgastroshop'],2);}else{$v['localgastroshop'] = 0;}
						if(isset($v['localbrasil2'])){round($v['localbrasil2'],2);}else{$v['localbrasil2'] = 0;}
						if(isset($v['localsanmarcos2'])){round($v['localsanmarcos2'],2);}else{$v['localsanmarcos2'] = 0;}
						if(isset($v['localgastroshop2'])){round($v['localgastroshop2'],2);}else{$v['localgastroshop2'] = 0;}
						$ventaT=round($v['localbrasil']+$v['localsanmarcos']+$v['localgastroshop'],2);
						$ventaA=round($v['localbrasil2']+$v['localsanmarcos2']+$v['localgastroshop2'],2);
						$tendencia = $ventaT-$ventaA;
						?>
						<tr>
							<td><?= $v['producto'] ?></td>
							<td><?= $v['descrip'] ?></td>
							<td><?= $v['um'] ?></td>
							<td><?= round($v['costo_ulti'],2) ?></td>
							<td><?= round($v['localbrasil']/$factor,2) ?></td>
							<td><?= round($v['localsanmarcos']/$factor,2) ?></td>
							<td><?= round($v['localgastroshop']/$factor,2) ?></td>
							<td><?= round($ventaT/$factor,2) ?></td>
							<td><?= round($ventaA/$factor,2) ?></td>
							<td style="text-align: right; font-weight: bold;<?php if($tendencia>0){echo "color:green;";}if($tendencia<0){echo "color:red;";} ?>">
								<?= round($tendencia/$factor,2) ?>		
							</td>
						</tr>
					<?php } ?>
				</tbody>
			</table>
		</div>
	</div>
</div>




<!-- Modal -->
<div class="modal fade" id="modal_buscar_codigo" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Buscar Codigo</h5>
      </div>
      <div class="modal-body contenido_modal_codigo">
        
      </div>
    </div>
  </div>
</div>





<script type="text/javascript">
	jQuery(document).ready(function($) {
		$(".btn_buscar_codigo").click(function(){
			$("#modal_buscar_codigo").modal("show");
			$(".contenido_modal_codigo").html('<center><i class="fa fa-circle-o-notch fa-spin fa-3x fa-fw"></i></center>');
			$.post("<?= site_url('reportes/compras/tabla_busqueda') ?>", {filtro: $('input:radio[name=filtro]:checked').val()}, function(r) {
				$(".contenido_modal_codigo").html(r);
				$(".busqueda_codigo").DataTable({
		    		ordering: 		false,
		        	scrollY:        500,
			        paging:         false,
			        dom: 'Bfrtip',
		        	buttons: [
			            'copyHtml5',
			            'excelHtml5',
			            //'csvHtml5',
			            'pdfHtml5'
		        	],
		        	"initComplete": function( settings, json ) {
		        		setTimeout(function() {$('.dataTables_filter').find("label").find("input").focus();}, 500);
		  			}
		    	});
			});
		})
		$(document).on("click",".a_codigo",function(){
			$("#modal_buscar_codigo").modal("hide");
			$(".input_buscar_codigo").val($(this).attr("codigo"));
		})
	});
</script>