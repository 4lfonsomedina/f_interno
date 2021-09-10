<input type="hidden" value="<?= base_url(); ?>" id="base_url">
</div>
</body>

<footer>
	<!-- <?= explode("/", uri_string())[0] ?> -->
	<?php 
	$controlador = explode("/", uri_string())[0];
	if($controlador=="InventarioController"){?>
		<script type="text/javascript" src="<?= base_url('assets/js/inventario.js')?>"></script>
	<?php } ?>



<script type="text/javascript">
	jQuery(document).ready(function($) {

		$('.tabla_reporte').DataTable({
			responsive: true,
			"initComplete": function( settings, json ) {
    			$('.div_loading').remove();
  			}
		});
		$('.chosen-select').chosen();
		
		$(document).on("focus", ".datepicker", function(){
        	$(this).datepicker({
				dateFormat: "dd/mm/yy",
				showAnim: "slideDown",
				monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
				dayNamesShort: ['Dom','Lun','Mar','Mié','Juv','Vie','Sáb'],
	 			dayNamesMin: ['Do','Lu','Ma','Mi','Ju','Vi','Sá'],
			});
    	});
		$('.tabla_reporte_ventas_anual').DataTable({
        	scrollY:        500,
	        scrollX:        true,
	        scrollCollapse: true,
	        paging:         false,
	        dom: 'Bfrtip',
        	buttons: [
	            'copyHtml5',
	            'excelHtml5',
	            //'csvHtml5',
	            //'pdfHtml5'
        	],
        	"initComplete": function( settings, json ) {
    			$('.loader_ocu').remove();
  			},
        	fixedColumns:   {
        		leftColumns: 1,
	            leftColumns: 2
        	}
    	});
    	$('.tabla_repote').DataTable({
        	scrollY:        500,
	        paging:         false,
	        dom: 'Bfrtip',
        	buttons: [
        	'copyHtml5',
	        'excelHtml5',
        	{
	            extend: 'pdfHtml5',
	            text: 'PDF',
	            title: function(){return $("#titulo_tabla").val();},
	            //messageTop: function(){return $("#titulo_tabla2").val();},
	       }],
        	"initComplete": function( settings, json ) {
    			$('.loader_ocu').remove();
    			$('.cargando_tabla').remove();
		    	$('.tabla_repote').show();
  			}
    	});

    	$('.tabla_repote_sin_orden').DataTable({
    		ordering: 		false,
        	scrollY:        500,
	        paging:         false,
	        dom: 'Bfrtip',
        	buttons: [
	            'copyHtml5',
	            'excelHtml5',
	            //'csvHtml5',
	            'pdfHtml5'
        	],
        	"initComplete": function( settings, json ) {
    			$('.loader_ocu').remove();
  			}
    	});


        $('.multi-select').multiselect({enableClickableOptGroups: true,buttonWidth: '100%',buttonText:function(){return "Seleccion";}});

	});
</script>

</footer>

</html>