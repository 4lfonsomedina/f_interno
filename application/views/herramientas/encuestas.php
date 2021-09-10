<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

<style type="text/css">
	.font_red{
		font-weight: bold;
		color:red;
	}
	.font_orange{
		font-weight: bold;
		color:orange;
	}
	.tabla_encuesta_view tr td{
		padding: 5px;
	}
</style>

<head>

  <center>
    <div class="mt-3"> <img src=" <?= base_url('assets/imagenes/likert/') ?>mexquite.png" ></div>
  </center>

</head>


<body style="background-color: black;">
<div class="container mt-3" style="background-color: white">
	<div class="row">
		<div class="col-sm-12 mt-3" style="text-align: right;"><button class="btn btn-dark" id="btn_encuesta"> + Nueva Encuesta</button></div>
	</div>
	<h4>Encuestas tomadas resultado</h4>
	<table class="table table-striped table-hover">
		<thead>
			<tr>
				<th>Fecha</th>
				<th>Mesa</th>
				<th>Mesero</th>
				<th>Global</th>
			</tr>
		</thead>
		<tbody>
			<?php foreach($encuestas as $e){ 
				 $suma = $e->atencion+$e->servicio+$e->rapidez+$e->temperatura+$e->sabor+$e->porcion;
				?>
			<tr class="tr_encuesta" id_encuesta='<?= $e->id_encuesta ?>'>
				<td><?= formato_fecha($e->fecha) ?></td>
				<td><?= $e->mesa ?></td>
				<td><?= $e->mesero ?></td>
				<td class="<?php if($suma<20){echo 'font_red';} ?>"><?= $suma ?>/30</td>
			</tr>
			<?php } ?>
		</tbody>
	</table>
</div>

</body>


<!-- Modal -->
<div class="modal fade" id="modal_nueva_encuesta" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<form action="<?= site_url('sistemas/herramientas/encuesta_mexquite') ?>" method="POST">
	  <div class="modal-dialog" role="document">
	    <div class="modal-content">
	      <div class="modal-header">
	        <h5 class="modal-title" id="exampleModalLabel">Nueva Encuesta</h5>
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	          <span aria-hidden="true">&times;</span>
	        </button>
	      </div>
	      <div class="modal-body">
	        <input type="text" name="mesero" placeholder="Mesero" class="form-control">
	        <select class="form-control mt-3" name="mesa">
	        	<option value="barra"> BARRA </option>
	        	<?php for($i=1;$i<26;$i++){ ?>
	        		<option value="Mesa<?= $i ?>">Mesa<?= $i ?></option>
	        	<?php } ?>
	        </select>
	      </div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
	        <button type="submit" class="btn btn-primary">Iniciar Encuesta</button>
	      </div>
	    </div>
	  </div>
	</form>
</div>

<!-- Modal -->
<div class="modal fade" id="modal_ver_encuesta" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	  <div class="modal-dialog" role="document">
	    <div class="modal-content">
	      <div class="modal-header">
	        <h5 class="modal-title" id="exampleModalLabel">Encuesta</h5>
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	          <span aria-hidden="true">&times;</span>
	        </button>
	      </div>
	      <div class="modal-body" id="cuerpo_encuesta">
	        
	      </div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
	      </div>
	    </div>
	  </div>
</div>

<script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
  
  <script type="text/javascript">

    $(document).ready(function() {
      
      $("#btn_encuesta").click(function(){
      	$("#modal_nueva_encuesta").modal("show");
      })

      $(".tr_encuesta").click(function(){
      	$.post("<?= site_url('sistemas/herramientas/encuesta/') ?>"+$(this).attr("id_encuesta") , function(result){
      		$("#cuerpo_encuesta").html(result);
      	})
      	$("#modal_ver_encuesta").modal("show");
      })

      $(".font_red").click(function(){
      	//alert("presionaste un elemento con la clase font_red");
      })

    });

  </script>