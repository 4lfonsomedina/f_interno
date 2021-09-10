<form action="<?= site_url('sistemas/sistemas/guarda_reg_check') ?>" method="POST">
	<input type="hidden" name="dep" value="<?= $departamento ?>">
	<input type="hidden" name="fecha" value="<?= $fecha ?>">
<ul class="list-group">
	<?php foreach($checks as $ch){ ?>
  <label><li class="list-group-item">
  	<input type="checkbox" name="checks[]" class="diario_check" value="<?= $ch->id_check ?>" 
  	<?php foreach($reg_ch as $rc){if($rc->id_check==$ch->id_check){echo "checked";}}?>
  	> <?= $ch->descripcion?>
  </li></label>
  <?php } ?>
</ul>
<label>
Observaciones del dia
<textarea class="form-control" rows="4" name="observacion"><?php if(isset($reg_ch[0])){echo $reg_ch[0]->observacion;} ?></textarea>
</label>
  <div class="separar_1"></div>  <div class="separar_1"></div>
  <button href="#" class="btn btn-success"><i class="fa fa-floppy-o" aria-hidden="true"></i> Guardar </button>
</form>