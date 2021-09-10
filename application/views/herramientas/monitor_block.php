<style type="text/css">
	.table_contenedor{
		width: 100% ;
		height: 250px ;
		overflow-y: auto;
		border:1px solid;
	}
	.table_contenedor2{
		width: 100% ;
		height: 120px ;
		overflow-y: auto;
		border:1px solid;
	}
	.identificado{
		background: red;
		color:white;
	}
	.tachita{
		color: red;
		font-weight: bold;
	}
</style>
<div class="container" >

<div class="panel panel-primary">
	<div class="panel-heading titulo_panel">MONITOR DE BLOQUEOS AVATTIA</div>
	<div class="panel-body">
		<h2 align="center">
			<div class="col-md-9">
				Procesos en Tiempo Real 
			</div>
			<div class="col-md-3">
				<button class="btn btn-danger btn_limpiar" style="margin-bottom: 5px; border-radius: 60px !important; border-color: transparent !important;">
					<i class="fa fa-exclamation-circle" aria-hidden="true"></i> LIMPIAR TODO!
				</button>
			</div>
		</h2>
		<div class="table_contenedor">
			<table class="table">
				<thead>
				<tr>
					<th></th>
				<!--
					<th>[Fecha]</th>
					<th>[Hora]</th>
				-->
					<th>[SPID]</th>
					<th>[HostName]</th>
					<th>[Sucursal]</th>
				<!--
					<th>[Memory]</th>
					<th>[Blocked]</th>
					<th>[Status]</th>
					<th>[Program]</th>
				-->
				</tr>
				</thead>
				<tbody id="tabla_procesos">
				</tbody>
			</table>
		</div>
	</div>
</div>
</div>
</div>


<script type="text/javascript">
	$(document).ready(function() {
		consulta();
		setInterval(function() { consulta(); identifica_repetidos();}, 15000);

		function consulta(){
			$.post('<?= site_url() ?>/sistemas/herramientas/get_procesos_b', function(r) {
				$("#tabla_procesos").html("");
				if(r!=""){
					var today = new Date();
					var sucursales = ["Brasil","SanMarcos","Gastro"];
					var data = jQuery.parseJSON(r);
					var cadena="";
					$.each(data, function(o, item) {
						$.each(data[o], function(i, item) {
							if(data[o][i].Head_Blocker>0){
								cad_temp="<tr>"+
								"<td><span class='tachita' t_spid='"+data[o][i].PID+"' t_base='"+data[o][i].base_datos+"'>X</span></td>"+
									//"<td>"+today.getFullYear()+'-'+(today.getMonth()+1)+'-'+today.getDate()+"</td>"+
									//"<td>"+today.getHours() + ":" + today.getMinutes() + ":" + today.getSeconds()+"</td>"+
									"<td class='spid_acomulador'>"+o+data[o][i].PID+"</td>"+
									"<td>"+data[o][i].Host_Name+"</td>"+
									"<td>"+data[o][i].base_datos+"</td>";
									//"<td>"+data[o][i].Memory+"</td>"+
									//"<td>"+data[o][i].Head_Blocker+"</td>"+
									//"<td>"+data[o][i].Task_State+"</td>"+
									//"<td>"+data[o][i].Application+"</td></tr>";
								cadena+=cad_temp;
							}
						});
					});
					$("#tabla_procesos").html(cadena);
				}
				
			});
		}
		function identifica_repetidos(){
			// [{sucursal}{SPID}] ej = [051]
			$("tabla_procesos_log .spid_acomulador").each(function(){
				var spid= $(this).html();
				var contador=0;
				//recorrer en busqueda de este SPID
				$(".spid_acomulador").each(function(){
					if(spid==$(this).html())
						contador++;
				})
				console.log(spid+"-"+contador);
				if(contador>2){
					//erradicar y pasar al log
					$("#tabla_procesos_log_erradicados").append($(this).parent("tr").html());
					//KILL
					//$(this).parent("tr").remove();
				}
				
			})
		}
		$(document).on("click",".tachita",function(){
			if(confirm("Esta seguro de que desea parar esta tarea?")){
				$.post('<?=site_url()?>/sistemas/herramientas/kill_proceso/'+$(this).attr('t_spid')+'/'+$(this).attr('t_base'), 
					function(r) {
						alert(r);
				});
			}
		})
		$(document).on("click",".btn_limpiar",function(){
			if(confirm("Esta seguro de que desea parar todas las tareas?")){
				$(".tachita").each(function(index, el) {
					$.post('<?=site_url()?>/sistemas/herramientas/kill_proceso/'+$(this).attr('t_spid')+'/'+$(this).attr('t_base'), function(r) {});
				});
			}
		})
		



	});
</script>
