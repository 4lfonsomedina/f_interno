<link rel="stylesheet" href="<?= base_url('assets/plugins/')?>bootstrap.min.css">
<meta name="viewport" content="width=device-width, initial-scale=1">


<!-- FORMULARIO DE CONSULTA CON INPUT Y BOTON OCULTO-->
<form method="POST" action="<?= site_url('sistemas/sistemas/levantamiento') ?>">


	<!-- SELECCION DE SOCURSAL -->
<center>
	<div class="col-xs-12">
		<h1>SUCURSAL</h1>
	</div>
	<div class="col-xs-4">
		<label><input type="radio" name='sucursal' class="form-control" value='brasil' <?php if($sucursal=='brasil') echo "checked"; ?>>BR</label>
	</div>
	<div class="col-xs-4">
		<label><input type="radio" name='sucursal' class="form-control" value='sanmarcos' <?php if($sucursal=='sanmarcos') echo "checked"; ?>>SM</label>
	</div>
	<div class="col-xs-4">
		<label><input type="radio" name='sucursal' class="form-control" value='gastroshop' <?php if($sucursal=='gastroshop') echo "checked"; ?>>GS</label>
	</div>
</center>
	<!-- INPUT Y BOTTON-->
	<div class="col-xs-12" style="margin-top: 50px"></div>
	<div class="col-xs-9">
		<input type="number" name='codigo' id="codigo" style="width: 100%; border-color: black;" class="form-control">
	</div><div class="col-xs-1"><button type="submit" class="btn btn-default"><b>-></b></button></div>

	<div class="col-xs-12" style="margin-top: 50px"></div>
	<div class="col-md-4 col-xs-1"></div><div class="col-md-4 col-xs-10">
		
	<!-- MENSAJE DE BUSQUEDA -->
	<?php if(isset($codigo)&&count($codigo)>1){ ?>
	<div id="recibido">
		<p style="text-align: center; font-size: bold; color:white; padding:5px;background-color:green; font-size: 32px; border-radius: 20px;">
			<?= $codigo['desc1']."<br>$ ".$codigo['precio']." ".$codigo['um']."<br>"?>
		</p>
		<?php foreach($almacenes as $al)if($codigo['exis'.$al->sucursal]>0||$codigo['exis'.$al->sucursal]<0){?>
		<div class="col-xs-6">
			<p style="text-align: center; font-size: bold; padding:5px; font-size: 18px; border-radius: 20px;" class="recibido2">
				<?= "<b>".$al->nombre."</b><br>".$codigo['exis'.$al->sucursal] ?>
			</p>
		</div>
		<?php } ?>
	</div>
	<?php }else{?>
		<center><h1>NO ENCONTRADO, INTENTE DE NUEVO</h1></center>
	<?php }?>
	</div>
</form>

<script type="text/javascript">
	focus_input();
	function focus_input(){
		document.getElementById("codigo").focus();
	}
// OCULTAR MENSAJE DE BUSQUEDA
<?php if(isset($codigo)){?>		
		setTimeout(function(){document.getElementById("recibido").style.display = "none";}, 6000);
<?php }?>

</script>