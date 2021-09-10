<div class="col-md-2"></div>
	<div class="col-md-8">
		<div class="panel panel-primary">
			<div class="panel-heading titulo_panel"> Actualizacion de precios en basculas FyV </div>
			<div class="panel-body">
				<div class="row">
					<div class="col-md-3">
						<select class="form-control" id="ip_bascula">
							<option value='192.168.1.155'>Brasil</option>
							<option value='192.168.0.55'>San Marcos</option>
						</select>
					</div>
					<div class="col-md-3">
						<a class="btn btn-primary" id="conectar_bascula"><i class="fa fa-plug" aria-hidden="true"></i> Conectar</a>
					</div>
					<div class="col-md-2">
						<a class="btn btn-info" id="alta_prod_modal"><i class="fa fa-plus" aria-hidden="true"></i> Alta de producto</a>
					</div>
					<div class="col-md-2">
						<a class="btn btn-warning" id="sincronizar_avattia"><i class="fa fa-refresh" aria-hidden="true"></i> Sinc. Avattia</a>
					</div>
					<div class="col-md-2">
						<a class="btn btn-success"  id="subir_bascula"><i class="fa fa-upload" aria-hidden="true"></i> Subir</a>
					</div>

				</div>
			</div>
			<div class="row">
				<div class="col-xs-12">
					<table class="table">
						<thead>
							<tr>
								<th>PLU</th>
								<th>DESCRIPCION</th>
								<th>PESO/PIEZA</th>
								<th>PRECIO</th>
								<th>ALTA/BAJA</th>
							</tr>
						</thead>
						<tbody id="productos_bascula">
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>

<!-- MODAL LOADER -->
<div id="modal_alta_p" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-body">
        <div class="row">
        	<div class="col-xs-12"><label>Codigo avattia<input type="text" class="form-control" id="producto_avattia"></label></div>
        </div>
    </div>
    <div class="panel-footer">
    	<div class="row">
        	<div class="col-xs-12"><a class="btn btn-info" id="alta_prod"><i class="fa fa-plus" aria-hidden="true"></i> Agregar</a></div>
        </div>
    </div>

  </div>
</div>
</div>



	<!-- MODAL LOADER -->
<div id="modal_loader" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-body">
        <div class="row"><div class="col-xs-4"><i class="fa fa-cog fa-spin fa-3x fa-fw"></i></div><div class="col-xs-8"><p>Cargando informacion, espere....</p></div>
      </div>
    </div>
  </div>
</div>
</div>
<script type="text/javascript">
	jQuery(document).ready(function($) {

		/*traer precios de bascula*/
		$("#conectar_bascula").click(function(){
			$('#modal_loader').modal({backdrop: 'static', keyboard: false});
			$.post('get_bizerba', {ip: $('#ip_bascula').val()}, function(r) {
				if(r=='0'){
					alert("Equipo no encontrado...");
				}else{
					$("#productos_bascula").html(r);
				}	
				$('#modal_loader').modal("hide");
			});
		})

		/*sincronizar precios con avattia*/
		$("#sincronizar_avattia").click(function(){
			$('#modal_loader').modal({backdrop: 'static', keyboard: false});
			var productos = Array();
			$('.bz_plu').each(function(index, el) {
				productos.push($(el).val());
			});
			console.log(productos);
			$.post('sincronizar_avattia', {productos: productos}, function(r) {
				var prod = JSON.parse(r);
				$.each(prod, function(i) {
					$("#act_pre_"+prod[i].cbarras3).val(prod[i].precio);
					$("#act_des_"+prod[i].cbarras3).val(prod[i].desc1);
					if(prod[i].um=="KG"){
						$("#act_uni_"+prod[i].cbarras3).val(0);
					}
					else{
						$("#act_uni_"+prod[i].cbarras3).val(1);
					}
				});
				$('#modal_loader').modal("hide");
			});
		})


		/* subir datos a bascula */
		$("#subir_bascula").click(function(){
			$('#modal_loader').modal({backdrop: 'static', keyboard: false});
			var plu 	= ""; $('.bz_plu').each(function(index, el) {plu+=$(el).val()+",";});
			var desc 	= ""; $('.bz_desc').each(function(index, el) {desc+=$(el).val()+",";});
			var unidad 	= ""; $('.bz_unidad').each(function(index, el) {unidad+=$(el).val()+",";});
			var precio 	= ""; $('.bz_precio').each(function(index, el) {precio+=$(el).val()+",";});
			var alta 	= ""; $('.bz_alta').each(function(index, el) {alta+=$(el).val()+",";});

			$.post('subir_bascula', {ip: $('#ip_bascula').val(),plu:plu,desc:desc,unidad:unidad,precio:precio,alta:alta}, function(r) {
				if(r=='0'){
					alert("Equipo no encontrado...");
				}else{
					alert(r);
				}	
				$('#modal_loader').modal("hide");
			});
		})

		$(document).on("click","#alta_prod_modal",function(){
			$("#modal_alta_p").modal("show");
		})

		/* Alta de producto */
		$(document).on("click","#alta_prod",function(){
			var mayor=300001;
			$.each($(".bz_plu"), function(index, val) {mayor++;});

			$.post('alta_producto_fyv', {plu: mayor, producto: $('#producto_avattia').val()}, function(r) {
				$("#productos_bascula").append(r);
				$("#modal_alta_p").modal("hide");
			});
			
		})
	});
</script>