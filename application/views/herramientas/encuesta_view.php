<table class="tabla_encuesta_view">
	        	<tr>
	        		<td><b>Fecha:</b></td>
	        		<td colspan="2"><?= $encuesta->fecha ?></td>
	        		<td><b>Hora:</b></td>
	        		<td colspan="2"><?= explode('.',$encuesta->hora)[0]  ?></td>
	        	</tr>
	        	<tr>
	        		<td><b>Mesero:</b></td>
	        		<td colspan="2"><?= $encuesta->mesero ?></td>
	        		<td><b>Mesa:</b></td>
	        		<td colspan="2"><?= $encuesta->mesa ?></td>
	        	</tr>
	        	<tr>
					<th>ATE</th>
					<th>SER</th>
					<th>RAP</th>
					<th>TEM</th>
					<th>SAB</th>
					<th>POR</th>
				</tr>
				<tr>
					<td class="<?php if($encuesta->atencion<3){echo 'font_red';} ?>"><?= $encuesta->atencion ?>/5</td>
					<td class="<?php if($encuesta->servicio<3){echo 'font_red';} ?>"><?= $encuesta->servicio ?>/5</td>
					<td class="<?php if($encuesta->rapidez<3){echo 'font_red';} ?>"><?= $encuesta->rapidez ?>/5</td>
					<td class="<?php if($encuesta->temperatura<3){echo 'font_red';} ?>"><?= $encuesta->temperatura ?>/5</td>
					<td class="<?php if($encuesta->sabor<3){echo 'font_red';} ?>"><?= $encuesta->sabor ?>/5</td>
					<td class="<?php if($encuesta->porcion<3){echo 'font_red';} ?>"><?= $encuesta->porcion ?>/5</td>
				</tr>
				<tr>
	        		<td><b>Coment:</b></td>
	        		<td colspan="5" ><?= $encuesta->comentarios ?></td>
	        	</tr>
	        	<tr>
	        		<td><b>Nombre:</b></td>
	        		<td colspan="3" ><?= $encuesta->nombre ?></td>
	        		<td><b>Edad:</b></td>
	        		<td>27</td>
	        	</tr>
	        	<tr>
	        		<td><b>Email:</b></td>
	        		<td colspan="5"><?= $encuesta->email ?></td>
	        	</tr>
	        </table>