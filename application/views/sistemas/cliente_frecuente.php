<div class="row">
	<div class="col-md-3"></div>
	<div class="col-md-6">
		<div class="panel panel-default" style="border:none;">
			<div class="panel-body" style="padding-top: 80px; text-align: center; ">
				<!-- FORMULARIO DE CONSULTA CON INPUT Y BOTON OCULTO2-->
				<form method="POST" action="<?= site_url('sistemas/herramientas/frecuente') ?>" 
					onsubmit="
					document.getElementById('loader').style.display = 'inline';
					document.getElementById('descripcion').style.display = 'none';
					" autocomplete="off">
					<!-- SELECCION DE SOCURSAL -->
					<span id="loader" style="display: none; font-size: 70px;"><i class="fa fa-spinner fa-spin fa-3x" aria-hidden="true"></i><br><br></span>
					<!-- MENSAJE DE BUSQUEDA -->
					<h1 align="center" style="height: 200px" id="descripcion">
						<?php if(isset($clienteF)){ if($clienteF==""){ $clienteF="No Existe"; }?>

							<div id="recibido"><?= $clienteF."<br>" ?></div>
						<?php }else{?>
							<div id="buscar">Buscar Cliente Frecuente
							</div>
						<?php }?>
					</h1>

					<!-- INPUT Y BOTTON-->
					<input type="text" name='frecuente' id="frecuente" class="form-control"><input type="submit" style="display: none;">
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
		document.getElementById("frecuente").focus();
	}
// OCULTAR MENSAJE DE BUSQUEDA
<?php if(isset($frecuente)){?>		
		setTimeout(function(){window.location.replace("http://192.168.1.10/ferbis-interno/index.php/sistemas/herramientas/frecuente");}, 6000);
<?php }?>

</script>