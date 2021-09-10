<div class="separar_1"></div>
<a class="btn btn-primary" id="agragar_check"> <i class="fa fa-plus" aria-hidden="true"></i> Actividad diaria</a>
<div class="separar_1"></div>
<form action="<?= site_url('sistemas/sistemas/guarda_check') ?>" method="POST">
	<input type="hidden" value="<?= $departamento ?>" name="dep">
<div class="separar_1"></div>
<table class="table">
	<thead>
		<tr>
			<th>Actividades en el dia</th>
			<th></th>
		</tr>
	</thead>
	<tbody id="tabla_check">
		<?php foreach($checks as $ch){ ?>
		<tr>
			<td><input type='text' name='checks[]' class='form-control' value='<?= $ch->descripcion ?>'></td> 
			<td><a class='borrar_check'><i class='fa fa-trash' aria-hidden='true'></i></a></td>
		</tr>
		<?php } ?>
	</tbody>
	
</table>
<div class="separar_1"></div><div class="separar_1"></div>
<button class="btn btn-success"><i class="fa fa-floppy-o" aria-hidden="true"></i> Guardar </button>
</form>