<!DOCTYPE html>
<html>
<head>
	<title>crc</title>
<!-- Latest compiled and minified CSS -->
  <link rel="stylesheet" href="<?= base_url('assets/plugins/')?>bootstrap.min.css">
	  <!--jquery-->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <!-- Latest compiled and minified JavaScript -->
  <script src="<?= base_url('assets/plugins/')?>bootstrap.min.js"></script>
</head>
<body>
<h1>HOLA</h1>
</body>
<footer>
	<script type="text/javascript">
		$(document).ready(function() {
			$.post("https://192.168.20.2:8089/cgi?sord=asc&sidx=extension&page=1&item_num=30&action=listAccount&options=extension%2Caccount_type%2Cfullname%2Cstatus%2Caddr%2Cout_of_service%2Cemail_to_user%2Cpresence_status%2Cpresence_def_script%2Curgemsg%2Cnewmsg%2Coldmsg",function(r){
				console.log(r);
			})
		});
	</script>
</footer>
</html>