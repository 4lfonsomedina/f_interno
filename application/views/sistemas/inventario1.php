<meta name="viewport" content="width=device-width, initial-scale=1">


<!-- FORMULARIO DE CONSULTA CON INPUT Y BOTON OCULTO-->
<form method="POST" action="<?= site_url('sistemas/sistemas/levantamiento') ?>">


	<!-- SELECCION DE SOCURSAL -->
	<label>
		SUCURSAL
		<select name="sucursal">
			<option value="brasil" <?php if($sucursal=='brasil')echo "selected";?>>BRASIL</option>
			<option value="sanmarcos" <?php if($sucursal=='sanmarcos')echo "selected";?>>SAN MARCOS</option>
			<option value="gastroshop" <?php if($sucursal=='gastroshop')echo "selected";?>>GASTROSHOP</option>
		</select>
	</label>
	
	<!-- INPUT Y BOTTON-->
	<input type="number" name='codigo' id="codigo" style="width: 100%; border-color: black;"><input type="submit" style="display: none;">



	<!-- MENSAJE DE BUSQUEDA -->
	<?php if(isset($codigo)){?>
		<p style="text-align: center; font-size: bold; color:white; padding:5px;background-color:green;" id="recibido">
			<?= $codigo->desc1."<br>$ ".$codigo->precio."<br> Exist: ".$codigo->exis ?>
		</p>
	<?php }?>
</form>





<script type="text/javascript">
	focus_input();
	function focus_input(){
		document.getElementById("codigo").focus();
	}
// OCULTAR MENSAJE DE BUSQUEDA
<?php if(isset($codigo)){?>		
		setTimeout(function(){document.getElementById("recibido").style.display = "none";}, 4000);
<?php }?>

</script>