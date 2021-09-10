jQuery(document).ready(function($) {
	var base_url=$('#base_url').val()+"index.php/";

	$(".btn_envio").click(function(){
		var folio = $(this).attr("folio_fact");
		var nombre = $(this).attr("nombre_cliente");
		var correo = $(this).attr("correo");
		$(".loader_ocu").show();
		$.post('envio_factura', {folio: folio,nombre: nombre,correo: correo}, function(r){
			console.log(r);
			if(r=='1'){
				alert("Correo enviado!");
			}else{
				alert("ERROR!");
			}
			location.reload();
		});
	})


	$(".refrescar").click(function(){
		location.reload();
	})

	$(".form-consulta").submit(function(e){
		//e.preventDefault();
		$(this).find('div').hide();
		$(this).append(loader());
	})
	$(".dropdown-submenu").click(function(e){
		e.stopPropagation();
	})
	function loader(){
		var loader="<div class='col col-lg-12 loader_ocu'><div class='spinner'>"+
		"<div class='rect1'>"+
		"</div><div class='rect2'>"+
		"</div><div class='rect3'>"+
		"</div><div class='rect4'>"+
		"</div><div class='rect5'>"+
		"</div></div></div>";
		return loader;
	}



	/***************** ACTIVIDADES SISTEMAS ******************************/
	/* ALTA DE ACTIVIDAD */
	$('#alta_actividad_btn').click(function(){
		$('#modal_actividades').modal("show");
		$('#modal_actividades_body').html(loader());
		$.post(base_url+"sistemas/sistemas/alta_actividad_view/"+$(this).attr('departamento'),function(r){
			$('#modal_actividades_body').html(r);
		})
	})
	/* BAJA DE ACTIVIDAD */
	$('.baja_actividad').click(function(){
		if(!confirm("seguro de que desea borrar la actividad?")){return;}
		$.post(base_url+"sistemas/sistemas/baja_actividad/"+$(this).attr('id_actividad'),function(r){
			location.reload();
		})
	})

	/* COPIAR ENLACE DE CALIFICACION */
	$('.calificar_link').click(function(){
		copyToClipboard($(this).attr("enlace"));
		alert("Texto copiado");
	})
	function copyToClipboard(text) {
	   var textArea = document.createElement( "textarea" );
	   textArea.value = text;
	   document.body.appendChild( textArea );       
	   textArea.select();
	   try {
	      var successful = document.execCommand( 'copy' );
	      var msg = successful ? 'successful' : 'unsuccessful';
	      console.log('Copying text command was ' + msg);
	   } catch (err) {
	      console.log('Oops, unable to copy',err);
	   }    
	   document.body.removeChild( textArea );
	}

	
	/* EDITAR ACTIVIDAD */
	$('.editar_actividad').click(function(){
		$('#modal_actividades').modal("show");
		$('#modal_actividades_body').html(loader());
		$.post(base_url+"sistemas/sistemas/editar_actividad_view/"+$(this).attr('id_actividad'),function(r){
			$('#modal_actividades_body').html(r);
		})
	})
	/* IMPRIMIR ACTIVIDAD */
	$('.concluir_act').click(function(){
		if(confirm("Esta seguro de que desea marcar esta actividad como concluida?"))
			$.post(base_url+"sistemas/sistemas/cuncluir_actividad/"+$(this).attr('id_actividad'),function(r){
				alert("Actividad concluida!");
				location.reload();
			})
	})

	/* SORTEAR PRIORIDADES */
	$("#widgets").sortable({
	   handle: ".panel-heading",
	   cursor: "move",
	   //opacity: 0.5,
	   stop : function(event, ui){
	   	var cont_act=1;
	      $(".input_orden").each(function(){
	      	$(this).val(cont_act++);
	      })
	      $.post(base_url+"sistemas/sistemas/actualizar_prioridad",$("#orden_act_form").serialize(),function(r){
	      })
	   }
	});
	var fecha_act=0;
	var drag_act=0;
	/* SORTEAR DIA */
	$(".widgets2").draggable({
		zIndex: 100,
		handle: ".panel-heading",
		cursor: "move",
		//connectToSortable: ".widgets2",
		//opacity: 0.5,
		drag : function(event, ui){
			fecha_act=$(this).attr('fecha_act');
			drag_act=$(this).attr('actividad');
			//console.log("soltado!");
			//console.log(event);
			//console.log(ui);
	   	}
	});

	$(".drag_test").droppable({
	    drop: function( event, ui ) {
	    	console.log($(this).attr('fecha_dia'));
	      	if(fecha_act!=$(this).attr('fecha_dia')){
	      		$.post($('#base_url').val()+"index.php/sistemas/sistemas/fecha_actividad/",{
	            	id_actividad:drag_act,
	            	fecha:$(this).attr('fecha_dia'),
	          	},function(r){
	          		location.reload();
	            	//$("#fecha_ini_act_"+info.event.id).html(fecha_end);
	          	})
	          	
	      	}
	    }
  	});

	/*CAMBIO DE RESPONSABLE */
	$("#filtro_responsable").change(function(){
		var dep = $(this).attr('departamento');
		var per = $(this).val();
		var sol = $("#filtro_solicitante").val();
		window.location.href = base_url+"sistemas/sistemas?d="+dep+"&p="+per+"&s="+sol;
	})
	/*CAMBIO DE RESPONSABLE */
	$("#filtro_solicitante").change(function(){
		var dep = $(this).attr('departamento');
		var sol = $(this).val();
		var per = $("#filtro_responsable").val();
		window.location.href = base_url+"sistemas/sistemas?d="+dep+"&p="+per+"&s="+sol;
	})

	/*CHECKLIST*/
	$(".fixed_check").click(function(){
		$(this).hide(100);
		$(".contenedor_check").show(100);
		$(".cargar_check").html(loader());
		load_check();
	})
	$("#fecha_check").change(function(){load_check();})
	function load_check(){
		$.post(base_url+"sistemas/sistemas/cargar_check",{dep:$("#acts_departamento").val(),fecha:$("#fecha_check").val()},function(r){
			$(".cargar_check").html(r);
			$(".diario_check").each(function(){{ if($(this).is(':checked')){$(this).parent("li").addClass("active");}}})
		})
	}
	$(".contenedor_check .ocultar_check").click(function(){$(this).parent("div").hide(100);$(".fixed_check").show(100);})
	$(".contenedor_check").click(function(){
		$(".list-group-item").removeClass('active');
		$(".diario_check").each(function(){{ if($(this).is(':checked')){$(this).parent("li").addClass("active");}}})
	})
	/* MODIFICAR CHECKS*/
	$('#aconfig_check').click(function(){
		$('#modal_actividades').modal("show");
		$('#modal_actividades_body').html(loader());
		$.post(base_url+"sistemas/sistemas/check_edit",{dep:$("#acts_departamento").val()},function(r){
			$('#modal_actividades_body').html(r);
		})
	})
	/* AGREGAR CHECK */
	$(document).on('click','#agragar_check',function(){
	var tr="<tr><td><input type='text' name='checks[]' class='form-control' autofocus></td>"+
			"<td><a class='borrar_check'><i class='fa fa-trash' aria-hidden='true'></i></a></td></tr>";
	$("#tabla_check").append(tr);
	})
	/* BORRAR CHECK */
	$(document).on("click",".borrar_check",function(){
		$(this).parent("td").parent("tr").remove();
	})
	/* FILTRADO DE ACTIVIDADES CONCLUIDAS */
	$("#tab_historico_actividades").click(function(){ $('#filter_input').focus(); })
	$('#filter_input').on('keyup', function() {
	    var val = this.value.toLowerCase();
	    $('.panel_conluidos').show().filter(function() {
	        var panelTitleText = $(this).find('.panel-heading').text().toLowerCase();
	        return panelTitleText.indexOf(val) < 0;
	    }).hide();
	});


	$('#filter_input2').on('keyup', function() {
	    var val = this.value.toLowerCase();
	    console.log(val);
	    $('.contenedor_actividades_act').show().filter(function() {
	        var panelTitleText = $(this).find('.panel-heading').text().toLowerCase();
	        return panelTitleText.indexOf(val) < 0;
	    }).hide();
	});

/* RECURRENTES */
	$("#reporte_recurrente").click(function(){
		$("#modal_reporte_recurrentes").modal("show");
	})
	$("#btn_alta_recurrentes").click(function(){
		$("#form_recurrente").attr("action",$("#url_alta_recurrente").val());
		$("#eliminar_recurrente").hide();
		$("#rec_titulo").val("");
		$("#rec_limite").val("08:00:00");
		$("#rec_desc").val("");
		$("#modal_recurrentes").modal("show");
		$("#contenedor_campos").html("");
	});
	$("#btn_alta_campo").click(function(){
		var tr=	"<tr>"+
				"<td><input type='text' class='form-control' name='c_nombre[]' placeholder='NOMBRE'></td>"+
				"<td><input type='text' class='form-control' name='c_desc[]' placeholder='DESCRIPCION'></td>"+
				"<td><select class='form-control select_tipo' name='c_tipo[]'>"+
					"<option value='0'>Check</option>"+
					"<option value='1'>Cantidad</option>"+
				"</select>"+
				"</td>"+
				"<td><a style='color:red' class='c_eliminar'><i class='fa fa-trash' aria-hidden='true'></i></a></td></tr>"+
				"<tr class='int_min_max' hidden>"+
				"<td><input class='form-control' type='text' name='min[]' placeholder='MIN'></td>"+
				"<td><input class='form-control' type='text' name='max[]' placeholder='MAX'></td>"+
				"</tr>";

		$("#contenedor_campos").append(tr);
	})

	$(document).on("change",".select_tipo",function(){
		if($(this).val()=='0')
			$(this).parent("td").parent("tr").next(".int_min_max").hide();
		if($(this).val()=='1')
			$(this).parent("td").parent("tr").next(".int_min_max").show();
	})

	$(document).on("click",".c_eliminar",function(){
		if(confirm("estas seguro de que deseas eliminar este campo recurrente?")){
			$(this).parent("td").parent("tr").remove();
		}
	})
	$(".editar_recurrente").click(function() {
		$("#form_id_recurrente").val($(this).attr("id_recurrente"));
		$("#form_recurrente").attr("action",$("#url_editar_recurrente").val());
		$("#eliminar_recurrente").show();
		$("#eliminar_recurrente").attr("id_recurrente", $(this).attr("id_recurrente"));
		$.post(base_url+"sistemas/sistemas/datos_recurrente",{id_recurrente:$(this).attr("id_recurrente")},function(r){
			var rec = JSON.parse(r);
			$("#rec_titulo").val(rec.titulo);
			$("#rec_limite").val(rec.hora_limite);
			$("#rec_desc").val(rec.descripcion);
			$("#modal_recurrentes").modal("show");
			$("#contenedor_campos").html("");
			$.each(rec.campos, function(i,campo) {
				var hidden = "";
				$tipo0=""; if(campo.tipo==0){ $tipo0="selected"; hidden="hidden";}
				$tipo1=""; if(campo.tipo==1){ $tipo1="selected"; }
				var tr=	"<tr>"+
				"<td>"+
				"<input type='hidden' name='id_recurrente_campo[]' value='"+campo.id_recurrente_campo+"'>"+
				"<input type='text' class='form-control' name='c_e_nombre[]' value='"+campo.titulo+"' placeholder='NOMBRE'></td>"+
				"<td><input type='text' class='form-control' name='c_e_desc[]' value='"+campo.subtitulo+"' placeholder='DESCRIPCION'></td>"+
				"<td><select class='form-control select_tipo' name='c_e_tipo[]'>"+
					"<option value='0' "+$tipo0+">Check</option>"+
					"<option value='1' "+$tipo1+">Cantidad</option>"+
				"</select></td>"+
				"<td><a style='color:red' class='c_eliminar'><i class='fa fa-trash' aria-hidden='true'></i></a></td></tr>"+
				"<tr class='int_min_max' "+hidden+">"+
				"<td><input class='form-control' type='text' name='min[]' placeholder='MIN' value='"+campo.min+"'></td>"+
				"<td><input class='form-control' type='text' name='max[]' placeholder='MAX' value='"+campo.max+"'></td>"+
				"</tr>";
				$("#contenedor_campos").append(tr);
			})
		})
	});

	$(".duplicar_recurrente").click(function(){
		if(!confirm("Esta tarea sera duplicada")){return;}
		$.post(base_url+"sistemas/sistemas/duplicar_recurrente", {id_recurrente: $(this).attr("id_recurrente")}, function(data){
			location.reload();
		});
	})

	$(document).on("click","#eliminar_recurrente", function(){
		if(confirm("estas seguro de que deseas eliminar Esta tarea recurrente?")){
			$.post(base_url+"sistemas/sistemas/eliminar_recurrente",{id_recurrente:$(this).attr("id_recurrente")},function(r){
				location.reload();
			})
		}
	})
	$(".realizar_t").click(function(){
		$("#modal_check_recurrente_body").html(loader());
		$("#modal_check_recurrente").modal("show");
		$.post(base_url+"sistemas/sistemas/datos_recurrente",{id_recurrente:$(this).attr("id_recurrente")},function(r){
			var html_tarea = "";
			var rec = JSON.parse(r);
			$(".text_rec_titulo").html(rec.titulo);
			$(".text_rec_limite").html(rec.hora_limite);
			$(".text_rec_desc").html(rec.descripcion);
			$("#contenedor_campos_2").html("");
			$.each(rec.campos, function(i,campo){
				if(campo.lectura==null){campo.lectura='';}
				if(campo.observacion==null){campo.observacion='';}
				
				var checked = ""; var checked_valor = 0;if(campo.tipo==0&&campo.lectura==1){ checked='checked'; checked_valor = 1;}
				var tipo="<input type='checkbox' class='form-control checkbox_recurrente' "+checked+"><input type='hidden' class='valor_rec' value='"+checked_valor+"' name='lectura[]' value='"+campo.lectura+"'>"; 
				if(campo.tipo==1){tipo="<input type='text' class='form-control valor_rec' placeholder='VALOR' name='lectura[]' value='"+campo.lectura+"'>"; }
				var tr=	"<tr>"+
				"<td><input type='hidden' name='id_recurrente[]' value='"+campo.id_recurrente+"'>"+
				"<input type='hidden' name='id_recurrente_campo[]' value='"+campo.id_recurrente_campo+"'>"+
				"<input type='hidden' name='min[]' value='"+campo.min+"'>"+
				"<input type='hidden' name='max[]' value='"+campo.max+"'>"+
				"<input type='hidden' name='tarea[]' value='"+campo.titulo+" - "+campo.subtitulo+"'>"+
				"<input type='hidden' name='tipo[]' value='"+campo.tipo+"'>"+
				"<b>"+campo.titulo+"</b><br>"+campo.subtitulo+"</td>"+
				"<td style='width:160px; line-height:4px'>"+tipo+
				"</td></tr><tr><td colspan='2' style='border-top:none'><input type='text' name='observacion[]' class='form-control' placeholder='OBSERVACION' value='"+campo.observacion+"'></td></tr>";
				$("#contenedor_campos_2").append(tr);
			})
			$("#modal_check_recurrente_body").html(html_tarea);
		})
	})

	$(document).on("change",".checkbox_recurrente",function(){
		if ($(this).is(':checked')){
			$(this).next("input").val(1);
		}else{
			$(this).next("input").val(0);
		}
	})

	$("#btn_guardar_check_recurrente").click(function(){
		var filtro=true;
			$('.valor_rec').each(function(i,e){if($(e).val()==''){ filtro=false; }})
		if(filtro){
			//$("#form_registro_recurrente").submit();
			//$("#v").ajaxForm();
			$.post($('#form_registro_recurrente').attr('action'), $('#form_registro_recurrente').serialize(),function(){
				$("#modal_check_recurrente").modal('hide');
			});
		}else{alert("No puede dejar campos vacios");}
	})
	/* RECURRENTES */

	
	/*************************** ACTIVIDADES SISTEMAS ******************************/

	/***************** ACTUALIZACION DE TIPOS DE SALIDA ****************************/
	$(".act_tipo_trans").change(function(){
		$.post(base_url+"reportes/traspasos/get_tipos",{sucursal:$(this).val()},function(r){
			$(".act_trans").html("");
			var dep = JSON.parse(r);
			$.each(dep, function(i) {
				$(".act_trans").append("<option value='"+dep[i].clave+"'>"+dep[i].clave+" - "+dep[i].descripcion+"</option>");
			});
		})
	})
	/***************** ACTUALIZACION DE TIPOS DE SALIDA ****************************/


	/***************** ACTUALIZACION DE DEPARTAMENTOS ******************************/
	$(".act_dep_suc").change(function(){
		$(".act_dep_sub").html("<option value='T'>TODOS</option>");
		$.post(base_url+"reportes/compras/consulta_dep",{suc:$(this).val()},function(r){
			$(".act_dep_dep").html("");
			$(".act_dep_dep").append("<option value='T'>TODOS</option>");
			var dep = JSON.parse(r);
			$.each(dep, function(i) {
				$(".act_dep_dep").append("<option value='"+dep[i].linea+"'>"+dep[i].linea+" - "+dep[i].nombre+"</option>");
			});
		})
	})
	$(".act_dep_dep").change(function(){
		$.post(base_url+"reportes/compras/consulta_sub_dep",{suc:$(".act_dep_suc").val(),dep:$(this).val()},function(r){
			var subdep = JSON.parse(r);
			$(".act_dep_sub").html("");
			$(".act_dep_sub").append("<option value='T'>TODOS</option>");
			var subdep = JSON.parse(r);
			$.each(subdep, function(i) {
				$(".act_dep_sub").append("<option value='"+subdep[i].subdepto+"'>"+subdep[i].subdepto+" - "+subdep[i].descrip+"</option>");
			});
		})
	})


	/******************** FUNCION PARA VER IMAGENES ********************************/
	
	$(document).on("click","#img_adjunto",function(){
		$("#myModalimg").css("display","block");
	  	$("#img01").attr('src',$(this).attr('img'));})
	$(document).on("click",".close_img",function(){$("#myModalimg").css("display","none");})
	$(document).on("click",".eliminar_adjunto",function(){
	if(confirm("Estas seguro de que deseas eliminar este archivo adjunto?")){
		$(".link_adjunto").hide();
		$.post(base_url+"sistemas/sistemas/borrar_adjunto",{archivo:$(this).attr("archivo")}, function(r) {
			alert("Archivo adjunto eliminado");
		});
	}	
	})

});
