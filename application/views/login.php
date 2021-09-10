<!DOCTYPE html>
<html style="min-height: 100%;">
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
	  <!-- PWA -->
  <link rel="manifest" href="<?= base_url() ?>/assets/js/manifest.json">
  
	<title>Login</title>
	<style type="text/css">
		label{width: 100%;}
	</style>
</head>

<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
<!--jquery-->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>








<script type="text/javascript">

jQuery(document).ready(function($) {
	
	$("#label_alert").click(function(){
		alert("presionaste el label!");
	})

});	

</script>





<body style="
  background:
    -webkit-linear-gradient(315deg, hsla(342.02, 0%, 75.3%, 1) 0%, hsla(342.02, 0%, 75.3%, 0) 70%),
    -webkit-linear-gradient(65deg, hsla(112.45, 0%, 100%, 1) 10%, hsla(112.45, 0%, 100%, 0) 80%),
    -webkit-linear-gradient(135deg, hsla(301.54, 0%, 79.33%, 1) 15%, hsla(301.54, 0%, 79.33%, 0) 80%),
    -webkit-linear-gradient(205deg, hsla(64.71, 0%, 100%, 1) 100%, hsla(64.71, 0%, 100%, 0) 70%);
  background:
    linear-gradient(135deg, hsla(342.02, 0%, 75.3%, 1) 0%, hsla(342.02, 0%, 75.3%, 0) 70%),
    linear-gradient(25deg, hsla(112.45, 0%, 100%, 1) 10%, hsla(112.45, 0%, 100%, 0) 80%),
    linear-gradient(315deg, hsla(301.54, 0%, 79.33%, 1) 15%, hsla(301.54, 0%, 79.33%, 0) 80%),
    linear-gradient(245deg, hsla(64.71, 0%, 100%, 1) 100%, hsla(64.71, 0%, 100%, 0) 70%);
">
<div class="col col-sm-4 col-lg-5"></div>
<div class="col col-sm-4 col-lg-2" style="background-color: white; padding: 30px;margin-top: 10%; border: #4D4D4D solid 2px; border-radius: 8px;">

			<form action="<?= site_url('login/validar')?>" method="POST">
				<label>
					<center>Usuario</center><input type="text" class="form-control" name="usuario">
				</label>
				<br><br>
				<label>
					<center>Clave</center><input type="password" class="form-control" name="password">
				</label>
				<div style="text-align: center; margin-top: 40px;">
					<button class="btn btn-defalt" style="width: 100%; background-color: #292b2c; color: white"> Entrar </button>
				</div>
			</form>

<?php if(isset($_GET['e'])&&$_GET['e']=='1'){?>
		<div class="alert alert-danger" style="margin-top: 100px" id="mensaje_error" hidden>
			<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
		  <strong>Usuario o clave incorrectos!</strong>.
		</div>
		<script type="text/javascript">
			$("#mensaje_error").show(500,function(){
				setTimeout(function() { $("#mensaje_error").hide(500); }, 5000);
			});
		</script>
<?php } ?>
</div>
</body>
</html>