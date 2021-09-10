<form action="<?= site_url('sistemas/sistemas/editar_actividad'); ?>" method="post" autocomplete="off" enctype="multipart/form-data">
<input type="hidden" name="id_actividad" value="<?= $act->id_actividad ?>">
<input type="hidden" name="id_departamento" value="<?= $act->id_departamento ?>">
<input type="hidden" name="fecha_fin" value="<?= date('Y-m-d'); ?>">
	<div class="row">
		<div class="col col-sm-12">
			<label class="padding_top_20">
				Titulo:
				<input type="text" class="form-control" name="actividad" value="<?= $act->actividad ?>" required>
			</label>
		</div>
		<div class="col col-sm-4">
			<label class="padding_top_20">
				Fecha programada:
				<input type="text" class="form-control datepicker" name="fecha_ini" value="<?= formato_fecha($act->fecha_ini) ?>">
			</label>
		</div>
		<div class="col col-sm-4">
			<label class="padding_top_20">
				Estatus:
				<select class="form-control" name="estatus" required>
					<?php foreach($estatus as $e){?>
						<option value='<?= $e->id_estatus?>' <?php if($act->estatus==$e->id_estatus) echo "selected";?> class='label-<?= $e->color?>' style='color:white; font-size: bold;'>
							<span class="label label-<?= $e->color ?>"><?= $e->estatus?></span>
						</option>
					<?php }?>
				</select>
			</label>
		</div>
		<div class="col col-sm-4">
			<label class="padding_top_20">
				Solicitante:
				<select class="form-control" name="id_solicitante" required>
					<?php foreach($departamentos as $d){?>
						<option value='<?= $d->id_departamento?>' <?php if($act->id_solicitante==$d->id_departamento) echo "selected";?>><?= $d->nombre?></option>
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
							<?php if($act->id_responsable==$p->id_personal){echo "selected";}?>
							><?= $p->nombre ?></option>
					<?php } ?>
				</select>
			</label >
		</div>
		<div class="col col-sm-6">
			<label class="padding_top_20">
				Adjunto: <?php if(file_exists(path_adjunto($act->id_actividad))){?>
					<a href='#' id="img_adjunto" img="<?= base_url().'/assets/archivos/act_adjunto_'.$act->id_actividad.'.png?'.rand(0, 1000);?>" class="link_adjunto">
						1 archivo adjunto
					</a>
					<a href="#" class="eliminar_adjunto pull-right link_adjunto" archivo='act_adjunto_<?= $act->id_actividad ?>.png'><i class="fa fa-trash" aria-hidden="true"></i></a>
				<?php } ?>
				<input type="file" name="adjunto" accept="image/*">
			</label >
		</div>
		<div class="col col-sm-12">
			<label class="padding_top_20">
				Descripcion:
				<textarea class="form-control" name="descripcion" rows="5" required><?= $act->descripcion ?></textarea>
			</label>
		</div>
		<div class="col col-sm-12">
			<label class="padding_top_20">
				Observaciones:
				<textarea class="form-control" rows="5" name="observaciones"><?= $act->observaciones ?></textarea>
			</label>
		</div>
		<div class="col col-sm-12 padding_top_20" >
			<button class="btn btn-success"> <i class="fa fa-floppy-o" aria-hidden="true"></i> Guardar</button>
		</div>
	</div>

</form>