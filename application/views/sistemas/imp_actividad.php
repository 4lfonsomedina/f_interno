<title><?= $act->actividad ?></title>
<style type="text/css">
	td{
		padding-top: 40px;
	}
	body
	{
		font-family: monospace !important;
	}
	table
	{
		border-collapse: collapse;
		margin-top: 60px;
		width: 100%;
		border-color: gray;
	}
	table tr td
	{
		border: solid 1px gray;
		padding: 7px;
	}
</style>
<div style="
margin-left: 5%;
margin-right: 5%;
padding: 15px;
">
<p align="right">Fecha:<?= date('d/m/Y'); ?></p>
<table>
	<tr>
		<td><img src="<?= base_url('assets/imagenes/logo.png')?>" width='100px' class='pull-right'></td>
		<td align="center" colspan="5" style="font-size: 20px"><b > Orden de servicio </b></td>
	</tr>
	<tr>
		<td><b>Nombre de actividad:</b></td>
		<td colspan="5"><?= $act->actividad ?></td>
	</tr>
	<tr>
		<td><b>Departamento:</b></td>
		<td><?php foreach($departamentos as $d){if($act->id_departamento==$d->id_departamento){echo $d->nombre;}}?></td>
		<td><b>Estatus actual:</b></td>
		<td><?php foreach($estatus as $e)if($act->estatus==$e->id_estatus) echo $e->estatus; ?></td>
		<td><b>Solicitado por:</b></td>
		<td><?php foreach($departamentos as $d)if($act->id_solicitante==$d->id_departamento) echo $d->nombre; ?></td>
	</tr>
	<tr>
		<td><b>Fecha Programada:</b></td>
		<td><?= formato_fecha($act->fecha_ini) ?></td>
		<td><b>Fecha Terminacion:</b></td>
		<td><?= formato_fecha($act->fecha_fin) ?></td>

		<td colspan="2"></td>
	</tr>
	<tr>
		<td><b>Responsable:</b></td>
		<td colspan="5"><?php foreach($personal as $p){if($act->id_responsable==$p->id_personal){echo $p->nombre;}}?></td>
	</tr>
	<tr>
		<td><b>Descripcion:</b></td>
		<td colspan="5"><p><?= nl2br($act->descripcion) ?></p></td>
	</tr>
	<tr>
		<td><b>Observaciones:</b></td>
		<td colspan="5"><?= nl2br($act->observaciones) ?></td>
	</tr>
	<?php if(file_exists(path_adjunto($act->id_actividad))){?>
	<tr>
		<td align="center" colspan="6">
			<br><br>
  			<img src="<?= base_url().'/assets/archivos/act_adjunto_'.$act->id_actividad.'.png?'.rand(0, 1000);?>" height="200px">
  			<br><br>
		</td>
	</tr>
	<?php } ?>
	<tr>
		<td colspan="3" align="center"><br><br><br><br>_____________________<br>Frima de Encargado</td>
		<td colspan="3" align="center"><br><br><br><br>_____________________<br>Firma de Soporte</td>
	</tr>
</table>

<script type="text/javascript">
	setTimeout(function(){ window.print();window.close(); }, 500);
</script>
</div>