<script type="text/javascript">
	$(document).ready(function() {

		$(".button_api").click(function(){
			$.post("<?= site_url('sistemas/herramientas/consulta_ucm') ?>",function(r){
				console.log(r);
			})
		})
		
	});
</script>

<button class="btn btn-default button_api">post</button>

<script type="text/javascript">
	

</script>