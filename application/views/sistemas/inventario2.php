
<link rel="stylesheet" href="<?= base_url('assets/plugins/')?>bootstrap.min.css">
<!--font-awesome-->
<link rel="stylesheet" href="<?= base_url('assets/font-awesome/css/')?>font-awesome.css">

<div class="row">
	<div class="col-md-3"></div>
	<div class="col-md-6">
		<div class="panel panel-default" style="border:none;">
			<div class="panel-body" style="padding-top: 80px; text-align: center; ">
				<!-- FORMULARIO DE CONSULTA CON INPUT Y BOTON OCULTO2-->
				<form method="POST" action="<?= site_url('sistemas/herramientas/levantamiento')."/".$sucursal ?>" 
					onsubmit="
					document.getElementById('loader').style.display = 'inline';
					document.getElementById('descripcion').style.display = 'none';
					" autocomplete="off">
					<!-- SELECCION DE SOCURSAL -->
					<input type="hidden" value="<?= $sucursal ?>" name="sucursal">
					<span id="loader" style="display: none; font-size: 70px;"><i class="fa fa-spinner fa-spin fa-3x" aria-hidden="true"></i><br><br></span>
					<!-- MENSAJE DE BUSQUEDA -->
					<h1 align="center" style="height: 250px" id="descripcion">
						<?php if(isset($codigo)){?>
							<div id="recibido"><?= $codigo->desc1."<br><br>" ?>
							<span style="font-weight: bold; font-size: 120px;">$ <?= $codigo->precio ?></span></div>
						<?php }else{?>
							<div id="buscar">Buscar Producto<br>
								<span style="font-weight: bold; font-size: 120px;">$ 0.00</span>
							</div>
						<?php }?>
					</h1>

					<!-- INPUT Y BOTTON-->
					<input type="text" name='codigo' id="codigo" class="form-control"><input type="submit" style="display: none;">

				</form>
				<br><br>
				<img src="<?= base_url('assets/imagenes/logo.png')?>">
			</div>
		</div>
	</div>
</div>







<script type="text/javascript">
	focus_input();
	function focus_input(){
		document.getElementById("codigo").focus();
	}
// OCULTAR MENSAJE DE BUSQUEDA
<?php if(isset($codigo)){?>		
	setTimeout(function(){window.location.replace("http://192.168.1.10/ferbis-interno/index.php/sistemas/herramientas/levantamiento/"+"<?= $sucursal ?>");}, 6000);
<?php }?>

</script>