<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
<div class="container mt-5">
	<table class="table encuesta" border="2">
		<tr>
			<td><input type="radio" name="c1"></td>
			<td><input type="radio" name="c1"></td>
			<td><input type="radio" name="c1"></td>
			<td><input type="radio" name="c1"></td>
			<td><input type="radio" name="c1"></td>
		</tr>
		<tr>
			<td><input type="radio" name="c2"></td>
			<td><input type="radio" name="c2"></td>
			<td><input type="radio" name="c2"></td>
			<td><input type="radio" name="c2"></td>
			<td><input type="radio" name="c2"></td>
		</tr>
		<tr>
			<td><input type="radio" name="c3"></td>
			<td><input type="radio" name="c3"></td>
			<td><input type="radio" name="c3"></td>
			<td><input type="radio" name="c3"></td>
			<td><input type="radio" name="c3"></td>
		</tr>
	</table>


<div class="row">
	<div class="col-sm-8"><input type="text" class="form-control"></div>
	<div class="col-sm-4"><input type="text" class="form-control"></div>
</div>
<div class="row mt-3">
	<div class="col-sm-12"><input type="text" class="form-control"></div>
</div>
</div>	


<img src="<?= base_url('assets/imagenes/likert/') ?>1.png">
<img src="<?= base_url('assets/imagenes/likert/') ?>2.png">
<img src="<?= base_url('assets/imagenes/likert/') ?>3.png">
<img src="<?= base_url('assets/imagenes/likert/') ?>4.png">
<img src="<?= base_url('assets/imagenes/likert/') ?>5.png">

<script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
  <script type="text/javascript">
  	$(document).ready(function() {
  		$(".encuesta tr td").click(function(){
  			$(this).find('input').prop("checked", true);
  			$("input[type='radio']").each(function(){
  				if($(this).is(":checked")){ $(this).parent("td").attr("style","background-color:green");}
  				else{$(this).parent("td").removeAttr('style');}
  			})
  		})
  	});
  </script>