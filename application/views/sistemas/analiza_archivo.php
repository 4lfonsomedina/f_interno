<div class="col col-xs-2"></div>
<div class="col col-xs-8">
	<div class="panel">
		<div class="panel-heading">Analiza archivo</div>
		<div class="panel-body">
			<form action="<?= site_url('sistemas/sistemas/archivo_banco')?>" method="post" enctype="multipart/form-data">
				<div class="col col-xs-10"><input type="file" class="form-control" name='archivo'></div>
				<div class="col col-xs-2"><button type="submit" class="btn btn-primary">Subir ☻</button></div>
				<br><br>
				<div class="col col-xs-12">
					<textarea class="form-control" rows="20"><?php if(isset($texto))echo $texto;?></textarea>
				</div>
			</form>
		</div>
	</div>