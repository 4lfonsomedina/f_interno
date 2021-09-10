






<!-- Facturas sin timbrar -->
<div class="col col-md-1"></div>
<div class="col col-md-10">
	<div class="panel panel-default">
	<div class="panel-heading titulo_panel"><center><h1><b><font style="color: red">CAJAS ABIERTAS</font></b></h1></center></div>
		<div class="panel-body">

			<!-- Recorremos todas las sucursales -->

			<?php foreach($sucursales as $suc){?>
				<div class="col-sm-6">
					<h3 align="center"><?= $suc['nombre'] ?></h3>
					<div class="limite_y" style="height: 250px;">
						<table class="table">
							<thead>
								<tr>
									<th>cerrar caja</th>
									<th>fecha</th>
									<th>caja</th>
									<th>usuario</th>
									<th>estado</th>
									<th>total</th>
								</tr>
							</thead>
							<tbody>
								<?php foreach($suc['cajas'] as $c){?>
								<tr>
									<td><a href="<?php echo site_url('sistemas/herramienta_caja/cerrar_c').'?c='.$c->caja ?>&s=<?= $suc['nombre'] ?>" onclick="return confirm('Estas seguro de cerrar caja?')"><i class="fa fa-lock"  aria-hidden="true" style="color: red"></i></a></td>
									<td><?= formato_fecha($c->fecha) ?></td>
									<td><?= $c->caja ?></td>
									<td><a href="#" class="link_usua" base="<?= $suc['nombre'] ?>" usuario="<?= $c->usuario ?>"><?= $c->usuario ?></a></td>
									<td><font style="color: green"><b><?= $c->estado ?></b></font></td>
									<td><?= $c->total ?></td>
								</tr>
								<?php } ?>
							</tbody>
						</table>
							
						</table>
					</div>
				</div>
			<?php }?>
		</div>
	</div>
</div>


<script type="text/javascript">
	$(document).ready(function() {
		$(".link_usua").click(function(){
			$.post("<?= site_url('sistemas/herramienta_caja/get_nombre_us') ?>", 
				{base: $(this).attr('base'),usuario:$(this).attr('usuario')},
				function(res){
				alert(res);
			});
		})
	});
</script>

