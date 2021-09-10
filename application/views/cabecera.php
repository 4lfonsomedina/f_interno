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
//traer los paneles que puede ver
$this->load->model('validar_model');
$menu = verificar_menu($this->session->userdata('usuario'));
if(!isset($_GET['no_menu'])){
?>

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
      <a class="navbar-brand" href="<?= base_url(); ?>"><img height="100%" alt="Brand" src="<?= base_url('assets/imagenes/logo2.png')?>"></a>
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav">
      

<?php if(!$menu||$menu['reportes']=='1'){ ?>
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><i class="fa fa-file-text-o" aria-hidden="true"></i> Reportes <span class="caret"></span></a>
          <ul class="dropdown-menu">
            <li class="dropdown-submenu">
              <a>Ventas</a>
              <ul class="dropdown-menu">
                <li><a href="<?= site_url('reportes/ventas/diario_ventas_global');?>"> Diario de Ventas</a></li>
                <li><a href="<?= site_url('reportes/ventas/pre_corte');?>"> Herramienta de pre_corte</a></li>
                <li><a href="<?= site_url('reportes/ventas/ventas_sd');?>"> Ventas Servicio a Domicilio</a></li>
                <li><a href="<?= site_url('reportes/ventas/ventas_sd2');?>"> Ventas Servicio a Domicilio (Departamentos)</a></li>
                <li><a href="<?= site_url('reportes/ventas/dash_ventas');?>"> Resumen Global de ventas</a></li>
                <li><a href="<?= site_url('reportes/ventas/mensual_dep');?>"> Ventas mensuales por departamento</a></li>
                <li><hr></li>
                <li><a href="<?= site_url('reportes/ventas/agrupado_departamento');?>"> Ventas Agrupadas por Departamento</a></li>
                <li><a href="<?= site_url('reportes/ventas/detallado_departamento');?>"> Ventas Detalladas por Departamento</a></li>
                <li><a href="<?= site_url('reportes/ventas/detallado_producto');?>"> Ventas Detalladas por Producto</a></li>
                <li><a href="<?= site_url('reportes/ventas/detalle_ticket');?>"> Detalle de ticket</a></li>
                <li><a href="<?= site_url('reportes/ventas/ventas_carniceria_detalle');?>"> Detallado de ventas por departamento</a></li>
                <li><hr></li>
                <li><a href="<?= site_url('reportes/ventas');?>"> Ventas por periodo</a></li>
                <li><a href="<?= site_url('reportes/ventas');?>"> Ventas anuales por departamento</a></li>
                <li><a href="<?= site_url('reportes/ventas/ventas_anuales_prod');?>"> Ventas anuales por producto</a></li>
                <li><a href="<?= site_url('reportes/ventas/ventas_mexquite');?>"> Acumulado anual Mexquite</a></li>
                
                
              </ul>
            </li>
            <li class="dropdown-submenu"><a href="#">Costos</a>
              <ul class="dropdown-menu">
                <li><a href="<?= site_url('reportes/ventas/costo_venta');?>"> Costo sobre venta</a></li>
                <li><a href="<?= site_url('reportes/ventas/costo_venta_integrado');?>"> Costo integrado sobre Precio de venta</a></li>
              </ul>
            </li>
             <li class="dropdown-submenu"><a href="#">Cuentas x pagar</a>
              <ul class="dropdown-menu">
                <li><a href="<?= site_url('reportes/reporteador/NotificacionPagoProveedores');?>">Notificacion de pago de proveedores</a></li>
              </ul>
            </li>
            <li class="dropdown-submenu"><a href="#">Pedido</a>
              <ul class="dropdown-menu">
                <li><a href="<?= site_url('reportes/compras/pedido_gastro');?>"> Pedido por dia</a></li>
                <li><a href="<?= site_url('reportes/compras/pedido_gastro_periodo');?>"> Pedido periodo</a></li>
                <li><a href="<?= site_url('reportes/compras/pedido_proveedor');?>"> Pedido por proveedor</a></li>
                <li><a href="<?= site_url('reportes/compras/pedido_periodo');?>"> Pedido vs 3 años</a></li>
                <li><a href="<?= site_url('reportes/compras/pedido_periodo_periodo');?>"> Pedido vs 4 periodos</a></li>
              </ul>
            </li>
            <li class="dropdown-submenu"><a href="#">Compras</a>
              <ul class="dropdown-menu">
                <li><a href="<?= site_url('reportes/compras/herramienta_compra');?>"> Herramienta de compra</a></li>
                <li><a href="<?= site_url('reportes/compras/compras_departamento');?>"> Compras anuales detallado</a></li>
                <li><a href="<?= site_url('reportes/compras');?>"> Compras anuales por departamento</a></li>
                <li><a href="<?= site_url('reportes/compras/proveedor');?>"> Compras anuales por proveedor</a></li>
                <li><a href="<?= site_url('reportes/compras/detalles_proveedor');?>"> Compras detalladas por proveedor</a></li>
                <li><a href="<?= site_url('reportes/compras/detalles_proveedor2');?>"> Compra por proveedor</a></li>
                <li><a href="<?= site_url('reportes/compras/detalles_producto');?>"> Compras detalladas por producto</a></li>
                <li><a href="<?= site_url('reportes/compras/comprasvsventas');?>"> Compras vs ventas cantidad</a></li>
                <li><a href="<?= site_url('reportes/compras/comprasvsventas2');?>"> Compras vs ventas importe</a></li>
                <li><a href="<?= site_url('reportes/compras/comprasvsventas3');?>"> Compras vs ventas MIXTO</a></li>
              </ul>
            </li>
            <li class="dropdown-submenu"><a href="#">Cocina</a>
              <ul class="dropdown-menu">
                <li><a href="<?= site_url('reportes/compras/transferencias_cocina');?>"> Produccion cocina vs ventas</a></li>
              </ul>
            </li>
            <li class="dropdown-submenu"><a href="#">Recibo</a>
              <ul class="dropdown-menu">
                <li><a href="<?= site_url('reportes/traspasos/transferencias');?>">Resumen Transferencias Externas</a></li>
                <li><a href="<?= site_url('reportes/traspasos/carga_usuarios');?>">Recibo de proveedores</a></li>
                <li><a href="<?= site_url('reportes/traspasos');?>"> Salidas de mercancia</a></li>
                <li><a href="<?= site_url('reportes/traspasos/merma_anual');?>"> Merma anual</a></li>
                <li><a href="<?= site_url('reportes/traspasos/mermas_donativos');?>">Merma y Donativos vs venta</a></li>
              </ul>
            </li>
            

          </ul>
        </li>
      <?php } ?>

<?php if(!$menu||$menu['inventario']=='1'){ ?>
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-cubes" aria-hidden="true"></i> Inventario <span class="caret"></span></a>
          <ul class="dropdown-menu" role="menu">
            <li><a href="<?= site_url('InventarioController') ?>">Monitor de Solicitudes</a></li>
            <li><a href="<?= site_url('InventarioController/nueva_solicitud') ?>">Solicitud de Mercancia</a></li>
            <li><a href="<?= site_url('InventarioController/precios_basculas_fyv') ?>">Actualizar Basculas FyV</a></li>
          </ul>
        </li>
<?php } ?>
<?php if(!$menu||$menu['contabilidad']=='1'){ ?>
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><i class="fa fa-file-code-o" aria-hidden="true"></i> Contabilidad <span class="caret"></span></a>
          <ul class="dropdown-menu">
            <li><a href="<?= site_url('facturacion/facturas_sin_timbrar');?>"> Facturas sin timbrar</a></li>
            <li><a href="<?= site_url('facturacion/factura_diaria');?>"> Monitor Factura Diaria</a></li>
            <li><a href="<?= site_url('facturacion/consulta_detalles');?>"> Detalles de factura</a></li>
            <li><a href="<?= site_url('facturacion/anteriores');?>"> Facturas de ventas anteriores</a></li>
            <li role="separator" class="divider"></li>
            <li><a href="<?= site_url('facturacion/formas_pago');?>"> Resumen de formas de pago</a></li>
            <li role="separator" class="divider"></li>
            <li><a href="<?= site_url('facturacion/enviar_brasil');?>"> Enviador de facturas Brasil</a></li>
            <li><a href="<?= site_url('facturacion/enviar_mexquite');?>"> Enviador de facturas Mexquite</a></li>
            <li class="dropdown-submenu">
              <a href="#">Polizas</a>
              <ul class="dropdown-menu">
                <li><a href="<?= site_url('Reportes/compras/poliza_compras');?>"> Compras </a></li>
              </ul>
            </li>
          </ul>

        </li>
<?php } ?>

        <!-- Consultar departamentos para actividades -->

        <?php 
           $departamentos=$this->sistemas_model->get_departamentos();

        ?>
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><i class="fa fa-tasks" aria-hidden="true"></i>  Actividades <span class="caret"></span></a>
          <ul class="dropdown-menu">
            <?php foreach($departamentos as $dep)if(!$menu||$menu['actividades']==$dep->id_departamento){?>
            <li><a href="<?= site_url('sistemas/sistemas?d=').$dep->id_departamento;?>"><?= $dep->nombre ?></a></li>
          <?php } ?>
          </ul>
        </li>

        


<?php if(!$menu||$menu['sistemas']=='1'){ ?>
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><i class="fa fa-television" aria-hidden="true"></i> Sistemas <span class="caret"></span></a>
          <ul class="dropdown-menu">
            <li><a href="<?= site_url('sistemas/fersa_controller/ventas');?>"> ventas fersa </a></li>
            <li><a href="<?= site_url('sistemas/herramienta_caja/monitor_cajas');?>"> Monitor de cajas</a></li>
            <li><a href="<?= site_url('sistemas/herramientas/monitor_frecuentes');?>"> Monitor de clientes frecuentes</a></li>
            <li><a href="<?= site_url('sistemas/sistemas/levantamiento');?>"> Pistola inventario</a></li>
            <li><a href="<?= site_url('sistemas/herramientas/frecuente');?>"> Verificar Cliente frecuente</a></li>
            <li><a href="<?= site_url('sistemas/sistemas/archivo_banco');?>"> Analizador de texto</a></li>
            <li><a href="<?= site_url('sistemas/herramientas/mover_mexquite');?>"> Mover ventas</a></li>
            <li><a href="<?= site_url('sistemas/herramientas/monitor_bloqueos');?>"> Monitor de procesos</a></li>
          </ul>
        </li>
<?php } ?>
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


