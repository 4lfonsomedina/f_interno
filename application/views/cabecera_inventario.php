<!DOCTYPE html>
<html>
<head>
  <link rel="icon" type="image/png" href="../../../assets/imagenes/LOGOAPP.ico" />
  <!--<link rel="icon" href="<?= base_url('assets/imagenes/')?>/LOGOAPP.ico">-->
  <title>Ferbis APP</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- Latest compiled and minified CSS -->
  <link rel="stylesheet" href="<?= base_url('assets/plugins/')?>bootstrap.min.css">

  <!-- Optional theme -->
  <link rel="stylesheet" href="<?= base_url('assets/plugins/')?>bootstrap-theme.min.css" >

  <!--jquery-->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

  <!-- Latest compiled and minified JavaScript -->
  <script src="<?= base_url('assets/plugins/')?>bootstrap.min.js"></script>

  <link rel="stylesheet" href="<?= base_url('assets/plugins/')?>bootstrap-theme.min.css">

  <!-- data tables -->
  <link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css">
  <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.5.2/css/buttons.dataTables.min.css">
  <script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
  <script src="https://cdn.datatables.net/buttons/1.5.2/js/dataTables.buttons.min.js"></script>
  <script src="<?= base_url('assets/plugins/')?>jszip.min.js"></script>
  <script src="<?= base_url('assets/plugins/')?>pdfmake.min.js"></script>
  <script src="<?= base_url('assets/plugins/')?>vfs_fonts.js"></script>
  <script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.html5.min.js"></script>
  <script src="https://cdn.datatables.net/fixedcolumns/3.2.6/js/dataTables.fixedColumns.min.js"></script>

  <!-- select autocomplete -->
  <script type="text/javascript" src="<?= base_url('assets/js/')?>chosen.js"></script>
  <link rel="stylesheet" href="<?= base_url('assets/css/')?>chosen.css" type="text/css"/>

  <!-- multiselect -->
  <script type="text/javascript" src="<?= base_url('assets/js/')?>bootstrap-multiselect.js"></script>
  <link rel="stylesheet" href="<?= base_url('assets/css/')?>bootstrap-multiselect.css" type="text/css"/>
  
  <!--Generales-->
  <script src="<?= base_url('assets/js/')?>general.js?v=<?php echo time();?>"></script>
  <link rel="stylesheet" href="<?= base_url('assets/css/')?>general.css?v=<?php echo time();?>">

  <!--font-awesome-->
  <link rel="stylesheet" href="<?= base_url('assets/font-awesome/css/')?>font-awesome.css">

  <!--datepicker-->
  <script src="<?= base_url('assets/js/')?>jquery-ui.js"></script>
  <link rel="stylesheet" href="<?= base_url('assets/css/')?>jquery-ui.css">

  

</head>
<body>


<?php 
if(isset($_GET['no_menu'])){
  $bloqueo=TRUE;
}

if(!isset($bloqueo)){?>
<!-- BARRA DE NAVEGACION-->
<nav class="navbar navbar-inverse">
  <div class="container-fluid">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="#"><img height="100%" alt="Brand" src="<?= base_url('assets/imagenes/logo2.png')?>"></a>
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav">
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-cubes" aria-hidden="true"></i> Inventario <span class="caret"></span></a>
          <ul class="dropdown-menu" role="menu">
            <li><a href="<?= site_url('InventarioController') ?>">Monitor de Solicitudes</a></li>
            <li><a href="<?= site_url('InventarioController/nueva_solicitud') ?>">Solicitud de Mercancia</a></li>
          </ul>
        </li>
      </ul>
      <ul class="nav navbar-nav navbar-right">
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
            <i class="fa fa-user-circle" aria-hidden="true"></i> <?= $this->session->userdata('nombre') ?>
            <span class="caret"></span></a>
          <ul class="dropdown-menu">
            <!--<li><a href="#">Action</a></li>-->
            <li><a href="<?= site_url('Login') ?>"><i class="fa fa-user-circle" aria-hidden="true"></i> Salir</a></li>
          </ul>
        </li>
      </ul>
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>
<!-- BARRA DE NAVEGACION-->
<?php } ?>

  <div class="contenedor_principal">


