<!DOCTYPE html>

<!--<li class="dropdown-submenu"><a href="#">Cuentas x pagar</a>
              <ul class="dropdown-menu">
                <li><a href="<?= site_url('reportes/reporteador/NotificacionPagoProveedores');?>">Notificacion de pago de proveedores</a></li>
              </ul>
            </li> -->

<html>
		<head> <meta charset="utf-8">
				<title></title>
		</head>

			<body>	

			 	<br><br>
				<center>
		    	
		   <form method="POST" action="<?php site_url('reporteador/validar_envio')?>">
             <input type="submit"
                    name="boton_generar"
                    value="GENERAR" />
     		</form>

     			</center>

			</body>


</html>



