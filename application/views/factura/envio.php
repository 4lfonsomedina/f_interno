
<div class="col col-sm-2"></div>
<div class="col col-sm-8">
	
	<div class="panel panel-default">
		<div class="panel-heading titulo_panel">Enviador de facturas</div>
		<div class="panel-body">
			<a class="refrescar btn btn-warning pull-right"> <span class="glyphicon glyphicon-retweet" aria-hidden="true"></span> Refrescar lista </a>
			<!--LOADER OCULTO-->
			<div class="col col-lg-8 loader_ocu" hidden>
				<h1 align="right" style="padding-top: 70px;">Enviando...</h1>
			</div>
			<div class="col col-lg-4 loader_ocu" hidden>
				<div class="spinner">
				  <div class="rect1"></div>
				  <div class="rect2"></div>
				  <div class="rect3"></div>
				  <div class="rect4"></div>
				  <div class="rect5"></div>
				</div>
			</div>
			<?php //var_dump($facturas); ?>
			<div class="limite_y" style="height: 700px; width: 100%;">
			<table class="table">
				<thead>
					<tr>
						<th>Folio</th>
						<th>RFC</th>
						<th>Nombre</th>
						<th>Correo</th>
						<th>Importe</th>
						<th>Enviar</th>
					</tr>
				</thead>
				<tbody>
					<?php foreach($facturas as $f){?>
						<tr>
							<td><?php echo $f->factura; ?></td>
							<td><?php echo $f->rfc; ?></td>
							<td><?php echo $f->cte_nom ?></td>
							<td><?php echo $f->email ?></td>
							<td align="right"><?php echo number_format($f->importe,2) ?></td>
							<td>
								<a class="btn btn-success btn-sm btn_envio" 
								folio_fact="<?php echo $f->factura;?>"
								nombre_cliente="<?php echo $f->cte_nom;?>" 
								correo="<?php echo $f->email;?>" 
								> <span class="glyphicon glyphicon-envelope" aria-hidden="true"></span> Enviar </a></td>
						</tr>
					<?php }?>
				</tbody>
			</table>
			</div>
			<!--
				<h3>Facturas Anteriores</h3>
				<label>Folio Factura:<input type="text" class="form-control"></label>
				<label>Correo:<input type="text" class="form-control"></label>
				<button class="btn btn-primary">Enviar</button>
			-->
		</div>
	</div>
</div>