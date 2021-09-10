<div class="col-md-1"></div><div class="col-md-10">
	<div class="panel panel-default">
		<div class="panel-body">
			<div class="row">
				<div class="col-sm-2 sol_input_clave">
					<a href="#" style="position: absolute;left: -0px;top:25px;" class="btn_buscar"><i class="fa fa-search" aria-hidden="true"></i></a>
					Clave
					<input type="text" class="form-control col_clave_prod" name="clave" autocomplete="off">
				</div>
				<div class="col-sm-5 sol_input_clave">
					Producto
					<input type="text" class="form-control sol_desc_prod">
				</div>
				<div class="col-sm-2 sol_input_cantidad">
					Cantidad
					<input type="number" class="form-control sol_cantidad_prod" value='1'>
				</div>
				<div class="col-sm-1">
					<br>
					<input type="text" class="form-control sol_um_prod" disabled>
				</div>
				<div class="col-sm-2">
					<br>
					<a href="#" class="btn btn-success btn_sol_agregar"> + Agregar</a>
				</div>
			</div>
		</div>
	</div>

	<div class="panel panel-default">
		<div class="panel-body" style="height: 50vh; overflow-y: auto;">
			<a href="#" class="btn btn-primary btn_enviar_sol" style="position: absolute; right: 20px; bottom:0px;width: 100px;"> <i class="fa fa-paper-plane" aria-hidden="true"></i> Solicitar</a>
			<form class="formulario_productos" method="POST" action="<?= site_url('InventarioController/procesar_solicitud') ?>">
				<input type="hidden" name='solicitante' value="<?= $this->session->userdata('nombre') ?>">
				<table class="table">
					<thead>
						<tr>
							<th>Clave</th>
							<th>Producto</th>
							<th>Unidad</th>
							<th>Cantidad</th>
							<th></th>
						</tr>
					</thead>
					<tbody class="sol_contenido_tabla">
						
					</tbody>
				</table>
			</form>
		</div>
	</div>

</div>






<!-- Modal -->
<div class="modal fade" id="modal_buscar" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Buscar Producto</h5>
      </div>
      <div class="modal-body">
        <div class="row">
        	<div class="col-xs-12 modal_contenedor_buscador">
        		<input type="text" class="form-control" id="modal_input_buscar"  autocomplete="off">
        	</div>
        	<div class="col-xs-12" style="height: 40vh; overflow-y: auto;">
        		<table class="table" id="productos_t">
        			<thead>
        				<tr>
        					<th>Producto</th>
        					<th>Descripcion</th>
        					<th>Unidad</th>
        				</tr>
        			</thead>
        			<tbody class="modal_resultado_busqueda">
        			</tbody>
        		</table>
        	</div>
        </div>
      </div>
    </div>
  </div>
</div>



