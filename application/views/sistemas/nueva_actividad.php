<form action="<?= site_url('sistemas/sistemas/alta_actividad'); ?>" id="form_alta_actividad" method="post" autocomplete="off" enctype="multipart/form-data">
<input type="hidden" name="fecha_fin" value="<?= date('Y-m-d'); ?>">
<input type="hidden" name="id_departamento" value="<?= $departamento ?>">
	<div class="row">
		<div class="col col-sm-12">
			<label class="padding_top_20">
				Titulo:
				<input type="text" class="form-control" name="actividad" autofocus required

				<?php if(isset($_POST['titulo'])&&$_POST['titulo']!=""){ echo "value='".$_POST['titulo']."'";}?>
				>
			</label>
		</div>

		<div class="col col-sm-4">
			<label class="padding_top_20">
				Fecha programada:
				<input type="text" class="form-control datepicker" name="fecha_ini" value="<?= $fecha ?>">
			</label>
		</div>

		<div class="col col-sm-4">
			<label class="padding_top_20">
				Estatus:
				<select class="form-control" name="estatus" required>
					<?php foreach($estatus as $e){?>
						<option value='<?= $e->id_estatus?>' <?php if($e->id_estatus=='1') echo "selected";?> class='label-<?= $e->color?>' style='color:white; font-size: bold;'><?= $e->estatus?></option>
					<?php }?>
				</select>
			</label>
		</div>
		<div class="col col-sm-4">
			<label class="padding_top_20">
				Solicitante:
				<select class="form-control" name="id_solicitante" required>
					<?php foreach($departamentos as $d){?>
						<option value='<?= $d->id_departamento?>'

							<?php if(isset($departamento)&&$departamento==$d->id_departamento){
								echo "selected";
							}?>

							><?= $d->nombre?></option>
					<?php }?>
				</select>
			</label>
		</div>
		<div class="col col-sm-6">
			<label class="padding_top_20">
				Responsable:
				<select class="form-control" name="id_responsable" required>
					<?php foreach($personal as $p){?>
						<option value='<?= $p->id_personal ?>' 

							<?php if(isset($_POST['id_personal'])&&$_POST['id_personal']==$p->id_personal){
								echo "selected";
							}?>

							><?= $p->nombre ?></option>
					<?php } ?>
				</select>
			</label >
		</div>
		<div class="col col-sm-6">
			<label class="padding_top_20">
				Adjunto:
				<input type="file" name="adjunto" accept="image/*">
			</label >
		</div>
		<div class="col col-sm-12">
			<label class="padding_top_20">
				Descripcion:
				<textarea class="form-control" rows="5" name="descripcion" required><?php if(isset($_POST['descripcion'])&&$_POST['descripcion']!=""){ echo $_POST['descripcion'];}?></textarea>
			</label>
		</div>
		<div class="col col-sm-12">
			<label class="padding_top_20">
				Observaciones:
				<textarea class="form-control" rows="5" name="observaciones"><?php if(isset($_POST['observacion'])&&$_POST['observacion']!=""){ echo $_POST['observacion'];}?></textarea>
			</label>
		</div>
		<div class="col col-sm-12 padding_top_20" >
			<button class="btn btn-success"> <i class="fa fa-floppy-o" aria-hidden="true"></i> Guardar</button>
		</div>
	</div>

</form>