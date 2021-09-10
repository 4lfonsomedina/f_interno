<form action="<?= site_url('sistemas/herramientas/mover_mexquite') ?>" method="POST">
<div class="container">
<div class="panel panel-primary">
	<div class="panel-heading">
		<h1 style="text-align: center">Mover ventas de mexquite</h1>
	</div>
	<div class="panel-body">
		<div class="row">
			<div class="col-md-5">
				<label>Ventas del: <input type="text" class="form-control datepicker" name="f1" value="<?= $f1 ?>"></label>
			</div>
			<div class="col-md-5">
				<label>Mover al: <input type="text" class="form-control datepicker" name="f2" value="<?= $f2 ?>"></label>
			</div>
			<div class="col-md-2"><br>
				<button type="submit" class="btn btn-danger">¡¡¡ Generar query !!!</button>
			</div>
		</div>
		<?php if(isset($query)){?>
		<div class="row">
			<div class="col-md-12">
				<textarea rows="9" class="form-control"><?= $query ?></textarea>
			</div>
		</div>
	<?php } ?>
	</div>
</div>
</div>
</form>