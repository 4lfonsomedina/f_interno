$(document).ready(function() {
	$(document).on('click','.cabecera_solicitud',function(){ 
		$(this).parent('div').find('.cuerpo_solicitud').toggle();
	})
	$(document).on('click','.sol_procesar',function(){ 
		var id_solicitud = $(this).attr('id_solicitud');
		if(confirm("Esta seguro de que desea marcar solicitud como procesada?"))
			$.post('./InventarioController/cambio_estatus', {id_solicitud: id_solicitud}, function(r) {
				cargar_solicitudes();
			});
	})

	$(".sol_input_clave").on('keyup',function(e) {
		console.log(e.which);
	    if(e.which == 13) {
	    	$(this).next('div').find('input').select();
	    }
	    if(e.which == 106) {
	    	
	    	$(".col_clave_prod").val("");
	    	$(".btn_buscar").click();
	    }
	});
	$(".sol_input_cantidad").on('keypress',function(e) {
	    if(e.which == 13) {
	    	$(this).next('div').next('div').find('a').focus();
	    }
	});

	$(".btn_sol_agregar").click(function(){
		if($(".col_clave_prod").val()==""||$(".sol_desc_prod").val()==""||$(".sol_cantidad_prod").val()==""){
			alert("No se permiten campos en blanco");
			return;
		}

		$(".sol_contenido_tabla").append("<tr>"+
			"<td>"+
			"<input type='hidden' name='producto[]' value='"+$(".col_clave_prod").val()+"'>"+
			"<input type='hidden' name='descripcion[]' value='"+$(".sol_desc_prod").val()+"'>"+
			"<input type='hidden' name='um[]' value='"+$(".sol_um_prod").val()+"'>"+
			"<input type='hidden' name='cantidad[]' value='"+$(".sol_cantidad_prod").val()+"'>"+
			$(".col_clave_prod").val()+"</td>"+
			"<td>"+$(".sol_desc_prod").val()+"</td>"+
			"<td>"+$(".sol_um_prod").val()+"</td>"+
			"<td>"+$(".sol_cantidad_prod").val()+"</td>"+
			"<td><a href='#' class='sol_remover' nombre_prod='"+$(".sol_desc_prod").val()+"'><i class='fa fa-times' aria-hidden='true' style='color:red'></i></a></td>"+
		"</tr>");

		$(".col_clave_prod").val("");
		$(".sol_desc_prod").val("");
		$(".sol_um_prod").val("");
		$(".sol_cantidad_prod").val(1);
		setTimeout(function() { $(".col_clave_prod").focus(); }, 500);
		
		

	
	})

	$(document).on("click",".sol_remover",function(){
		if(confirm("Estas seguro de que deseas remover el producto:\n"+$(this).attr('nombre_prod'))){
			$(this).parent("td").parent("tr").remove();
		}
	})

	$(".btn_enviar_sol").click(function(){
		if(confirm("desea enviar la solicitud?")){
			$(".formulario_productos").submit();
		}
	})
	$(".btn_buscar").click(function(){
		console.log("buscar");
		$("#modal_input_buscar").val("");
		$(".modal_resultado_busqueda").html("");
		$("#modal_buscar").modal("show");
		setTimeout(function() {
			console.log("-");
			$("#modal_input_buscar").focus();
		}, 500);
	})
	$("#modal_input_buscar").keyup(function(){
		if($(this).val().length>2){
			$.post('../InventarioController/buscar_producto_desc', {desc: $(this).val() }, function(r) {
				$(".modal_resultado_busqueda").html(texto_tabla(r));
			})
		}
	})
	$(".modal_contenedor_buscador").on('keyup',function(e) {
		console.log(e.which);
	    if(e.which == 40) {
	    	console.log("seleccion");
	    }
	});

	function texto_tabla(string){
		var ret = "";
		$.each(jQuery.parseJSON(string), function(i,producto) {
			 ret+="<tr>"+
			 "<td><a class='seleccion_tr' href='#' producto='"+producto.producto+"'>"+producto.producto+"</a></td>"+
			 "<td>"+producto.desc1+"</td>"+
			 "<td>"+producto.um+"</td>"+
			 "</tr>";
		});
		return ret;
	}

	$(document).on("click",".seleccion_tr",function(){
		var prod = $(this).attr('producto');
		$("#modal_buscar").modal("hide");
		$(".col_clave_prod").val(prod);
		$(".col_clave_prod").focus();
		setTimeout(function() { $(".col_clave_prod").parent('div').next('div').find('input').focus(); }, 500);
	})



	$(document).on("focusout",".col_clave_prod",function(){
		$(".sol_desc_prod").val("");
		$(".sol_um_prod").val("");
		if($(this).val()!="")
		$.post('../InventarioController/buscar_producto', {producto: $(this).val() }, function(r) {
			if(r=="[]"){ 
				alert("No se encontro el producto"); 
				$(".col_clave_prod").select();
			}
			var producto = jQuery.parseJSON(r)[0];
			$(".sol_desc_prod").val(producto.desc1);
			$(".sol_um_prod").val(producto.um);
		});
	});

	/*
	$(document).on("keyup",".col_clave_prod",function(){
		if($(this).val().length > 2)
			$.post('./InventarioController/buscar_producto', {producto: $(this).val() }, function(r) {
				console.log(r);
			});
	})
	*/

	cargar_solicitudes();
	setInterval(function(){cargar_solicitudes()},20000);
	function cargar_solicitudes(){
		if($("#sol_pendiente").length > 0){
			//pendientes
			$.post('./InventarioController/get_solicitudes', {status: '0'}, function(r) {
				$("#sol_pendiente").html(r);
			});
			//procesadas 
			$.post('./InventarioController/get_solicitudes', {status: '1'}, function(r) {
				$("#sol_procesado").html(r);
			});
		}
	}
});
