<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Compras extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		//if(!$this->session->userdata('usuario')){ Redirect('Login');}
		$this->load->model('Reportes/compras_model');
		$this->load->model('Reportes/enviador');
	}
	public function index(){

		$data['sucursal']="NA";
		$data['ano']='2018';
		$data['grupo']='diario';
		$data['lineas']=array();
		//Consultamos las ventas
		if(isset($_POST['sucursal'])){
			$data['sucursal'] = $_POST['sucursal'];
			$data['ano']=$_POST['ejercicio'];
			$data['lineas']=$this->compras_model->lineas_ano($_POST['ejercicio'],$_POST['sucursal']);
			$data['grupo']= $_POST['grupo'];
			$data['compras'] = $this->compras_model->compras_ano($_POST['ejercicio'],$_POST['sucursal']);
		}
		
		$this->load->view('cabecera.php');
		$this->load->view('Reportes/compras_ano_view.php',$data);
		$this->load->view('pie.php');
	}
	public function proveedor(){

		$data['sucursal']="NA";
		$data['ano']='2018';
		$data['grupo']='diario';
		$data['proveedores']=array();
		//Consultamos las ventas
		if(isset($_POST['sucursal'])){
			$data['sucursal'] = $_POST['sucursal'];
			$data['ano']=$_POST['ejercicio'];
			$data['proveedores']=$this->compras_model->proveedores_ano($_POST['ejercicio'],$_POST['sucursal']);
			$data['grupo']= $_POST['grupo'];
			$data['compras'] = $this->compras_model->compras_proveedores_ano($_POST['ejercicio'],$_POST['sucursal']);

		}
		
		$this->load->view('cabecera.php');
		$this->load->view('Reportes/compras_ano_proveedor_view.php',$data);
		$this->load->view('pie.php');
	}

	function detalles_proveedor(){
		$data['proveedores']=$this->compras_model->get_proveedores();
		$data['proveedor']="NA";
		$data['sucursal']="NA";
		$data['ano']='2018';

		//Consultamos las ventas
		if(isset($_POST['sucursal'])){
			$data['sucursal'] = $_POST['sucursal'];
			$data['ano']=$_POST['ejercicio'];
			$data['proveedor']=$_POST['proveedor'];

			$data['detalles'] = $this->compras_model->compras_det_proveedor($_POST['ejercicio'],$_POST['sucursal'],$_POST['proveedor']);

		}
		
		$this->load->view('cabecera.php');
		$this->load->view('Reportes/compras_det_proveedor_view.php',$data);
		$this->load->view('pie.php');
	}

	function detalles_proveedor2(){
		$data['proveedores']=$this->compras_model->get_proveedores();
		$data['proveedor']="NA";
		$data['sucursal']="NA";
		$data['ano']=date('Y');

		//Consultamos las ventas
		if(isset($_POST['sucursal'])){
			$data['sucursal'] = $_POST['sucursal'];
			$data['ano']=$_POST['ejercicio'];
			$data['proveedor']=$_POST['proveedor'];

			$data['detalles'] = $this->compras_model->compras_det_proveedor2($_POST['ejercicio'],$_POST['sucursal'],$_POST['proveedor']);

		}
		
		$this->load->view('cabecera.php');
		$this->load->view('Reportes/compras_det_proveedor_view2.php',$data);
		$this->load->view('pie.php');
	}

	function detalles_producto(){
		$data['productos']=$this->compras_model->get_productos();
		$data['producto']="NA";
		$data['sucursal']="NA";
		$data['ano']=date('Y');
		$data['moneda']='todo';

		//Consultamos las ventas
		if(isset($_POST['sucursal'])){
			$data['sucursal'] = $_POST['sucursal'];
			$data['ano']=$_POST['ejercicio'];
			$data['producto']=$_POST['producto'];
			$data['moneda']=$_POST['moneda'];

			$data['detalles'] = $this->compras_model->compras_det_producto($_POST['ejercicio'],$_POST['sucursal'],$_POST['producto'],$_POST['moneda']);

		}
		
		$this->load->view('cabecera.php');
		$this->load->view('Reportes/compras_det_productos_view.php',$data);
		$this->load->view('pie.php');
	}
	function comprasvsventas(){
		$data['tipo']=0;
		$data['marca']='T';
		$data['periodoc1']=date('d/m/Y');
		$data['periodoc2']=date('d/m/Y');
		$data['periodov1']=date('d/m/Y');
		$data['periodov2']=date('d/m/Y');
		$data['lineas']=$this->compras_model->lineas();
		$data['marcas']=$this->compras_model->marcas();
		if(isset($_POST['tipo'])){
			$data['compras'] = $this->compras_model->get_comprasvsventas(
				$_POST['tipo'],
				$_POST['marca'],
				sql_fecha($_POST['periodoc1']),
				sql_fecha($_POST['periodoc2']),
				sql_fecha($_POST['periodov1']),
				sql_fecha($_POST['periodov2'])
			);
			$data['periodoc1']=$_POST['periodoc1'];
			$data['periodoc2']=$_POST['periodoc2'];
			$data['periodov1']=$_POST['periodov1'];
			$data['periodov2']=$_POST['periodov2'];
			$data['tipo']=$_POST['tipo'];
			$data['marca']=$_POST['marca'];
		}
		$this->load->view('cabecera.php');
		$this->load->view('Reportes/comprasvsventas_view.php',$data);
		$this->load->view('pie.php');
		
	}
	function comprasvsventas2(){
		$data['tipo']=0;
		$data['marca']='T';
		$data['periodoc1']=date('d/m/Y');
		$data['periodoc2']=date('d/m/Y');
		$data['periodov1']=date('d/m/Y');
		$data['periodov2']=date('d/m/Y');
		$data['lineas']=$this->compras_model->lineas();
		$data['marcas']=$this->compras_model->marcas();
		if(isset($_POST['tipo'])){
			$data['compras'] = $this->compras_model->get_comprasvsventas(
				$_POST['tipo'],
				$_POST['marca'],
				sql_fecha($_POST['periodoc1']),
				sql_fecha($_POST['periodoc2']),
				sql_fecha($_POST['periodov1']),
				sql_fecha($_POST['periodov2'])
			);
			$data['periodoc1']=$_POST['periodoc1'];
			$data['periodoc2']=$_POST['periodoc2'];
			$data['periodov1']=$_POST['periodov1'];
			$data['periodov2']=$_POST['periodov2'];
			$data['tipo']=$_POST['tipo'];
			$data['marca']=$_POST['marca'];
		}
		$this->load->view('cabecera.php');
		$this->load->view('Reportes/comprasvsventas2_view.php',$data);
		$this->load->view('pie.php');
		
	}
	function comprasvsventas3(){
		$data['tipo']=0;
		$data['marca']='T';
		$data['mostrar']='cantidad';
		$data['periodov1']=date('d/m/Y');
		$data['periodov2']=date('d/m/Y');
		$data['lineas']=$this->compras_model->lineas();
		$data['marcas']=$this->compras_model->marcas();
		if(isset($_POST['tipo'])){
			$data['compras'] = $this->compras_model->get_comprasvsventas3(
				$_POST['tipo'],
				$_POST['marca'],
				sql_fecha($_POST['periodov1']),
				sql_fecha($_POST['periodov2'])
			);
			$data['periodov1']=$_POST['periodov1'];
			$data['periodov2']=$_POST['periodov2'];
			$data['tipo']=$_POST['tipo'];
			$data['marca']=$_POST['marca'];
			$data['mostrar']=$_POST['mostrar'];

			//show_array($data['compras']);
		}
		$this->load->view('cabecera.php');
		$this->load->view('Reportes/comprasvsventas3_view.php',$data);
		$this->load->view('pie.php');
		
	}

	function transferencias_cocina(){
		$data['tipo']=0;
		$data['periodoc1']=date('d/m/Y');
		$data['periodoc2']=date('d/m/Y');
		$data['periodov1']=date('d/m/Y');
		$data['periodov2']=date('d/m/Y');
		if(isset($_POST['periodoc1'])){
			$data['compras'] = $this->compras_model->get_transferencias_cocina(
				sql_fecha($_POST['periodoc1']),
				sql_fecha($_POST['periodoc2']),
				sql_fecha($_POST['periodov1']),
				sql_fecha($_POST['periodov2'])
			);
			$data['periodoc1']=$_POST['periodoc1'];
			$data['periodoc2']=$_POST['periodoc2'];
			$data['periodov1']=$_POST['periodov1'];
			$data['periodov2']=$_POST['periodov2'];
		}
		$this->load->view('cabecera.php');
		$this->load->view('Reportes/transferencias_cocina_view.php',$data);
		$this->load->view('pie.php');
		
	}
	
	//funcion para calcular las campras del año agrupado por productos y todas las compras que tuvo
	function compras_departamento(){
error_reporting(E_ERROR | E_PARSE);
		$data['ano']=date('Y');
		$data['linea']="NA";
		$data['sucursal']="NA";
		$data['subd']="";
		$data['moneda']="";
		$data['lineas']=$this->compras_model->lineas();

		//Consultamos las ventas
		if(isset($_POST['sucursal'])){
			$data['sucursal'] = $_POST['sucursal'];
			$data['ano']=$_POST['ejercicio'];
			$data['moneda']=$_POST['moneda'];

			$data['detalles'] = $this->compras_model->compras_det_producto2($_POST['ejercicio'],$_POST['sucursal'],$_POST['linea'],$_POST['subdep'],$_POST['moneda']);
			$data['ano']=$_POST['ejercicio'];
			$data['linea']=$_POST['linea'];
			$data['lineas']=$this->compras_model->dep_suc($_POST['sucursal']);
			$data['subdeps']=$this->compras_model->subdep_dep($_POST['sucursal'],$_POST['linea']);
			$data['subdep']=$_POST['subdep'];
			$data['sucursal']=$_POST['sucursal'];

		}

		$this->load->view('cabecera.php');
		$this->load->view('reportes/compras_departamentos.php',$data);
		$this->load->view('pie.php');
	} 

	//function para gastro genere el formato para llenado
	function pedido_gastro(){

		$data['fecha_ini']=date('d/m/Y');
		$data['linea']="NA";
		$data['sucursal']="NA";
		$data['subd']="";
		$data['lineas']=$this->compras_model->lineas();
		if(isset($_POST['fecha_ini'])){
			$data['f_anteriores'] = fechas_anteriores($_POST['fecha_ini']);
			$data['ventas'] = $this->compras_model->get_calculo_pedido($_POST['sucursal'],$_POST['linea'],$_POST['subdep'], $data['f_anteriores']);
			$data['fecha_ini']=$_POST['fecha_ini'];
			$data['linea']=$_POST['linea'];
			$data['lineas']=$this->compras_model->dep_suc($_POST['sucursal']);
			$data['subdeps']=$this->compras_model->subdep_dep($_POST['sucursal'],$_POST['linea']);
			$data['subdep']=$_POST['subdep'];
			$data['sucursal']=$_POST['sucursal'];
		}
		$this->load->view('cabecera.php');
		$this->load->view('herramientas/compras/pedido.php',$data);
		$this->load->view('pie.php');
	}

	//function para gastro genere el formato para llenado ***PARA GASTRO SIN MENU
	function pedido_gastro_2(){

		$data['fecha_ini']=date('d/m/Y');
		$data['linea']="NA";
		$data['sucursal']="gastroshop";
		$data['subd']="";
		$data['bloqueo']='1';
		$data['lineas']=$this->compras_model->dep_suc($data['sucursal']);
		if(isset($_POST['fecha_ini'])){
			$data['f_anteriores'] = fechas_anteriores($_POST['fecha_ini']);
			$data['ventas'] = $this->compras_model->get_calculo_pedido($data['sucursal'],$_POST['linea'],$_POST['subdep'], $data['f_anteriores']);
			$data['fecha_ini']=$_POST['fecha_ini'];
			$data['linea']=$_POST['linea'];
			$data['lineas']=$this->compras_model->dep_suc($data['sucursal']);
			$data['subdeps']=$this->compras_model->subdep_dep($data['sucursal'],$_POST['linea']);
			$data['subdep']=$_POST['subdep'];
			$data['sucursal']=$data['sucursal'];
		}
		$this->load->view('cabecera.php',$data);
		$this->load->view('herramientas/compras/pedido.php');
		$this->load->view('pie.php');
	}
	function pedido_gastro_periodo(){
		$data['fecha_ini']=date('d/m/Y');
		$data['fecha_fin']=date('d/m/Y');
		$data['linea']="NA";
		$data['sucursal']="gastroshop";
		$data['subd']="";
		$data['lineas']=$this->compras_model->dep_suc($data['sucursal']);
		if(isset($_POST['fecha_ini'])){
			$data['sucursal']=$_POST['sucursal'];
			$data['periodo'] = array(sql_fecha($_POST['fecha_ini']),sql_fecha($_POST['fecha_fin']));
			//$data['ventas'] = $this->compras_model->get_calculo_pedido($data['sucursal'],$_POST['linea'],$_POST['subdep'], $data['f_anteriores']);
			$data['ventas'] = $this->compras_model->get_calculo_pedido_periodo($data['sucursal'],$_POST['linea'],$_POST['subdep'], $data['periodo']);
			$data['fecha_ini']=$_POST['fecha_ini'];
			$data['fecha_fin']=$_POST['fecha_fin'];
			$data['linea']=$_POST['linea'];
			$data['lineas']=$this->compras_model->dep_suc($data['sucursal']);
			$data['subdeps']=$this->compras_model->subdep_dep($data['sucursal'],$_POST['linea']);
			$data['subdep']=$_POST['subdep'];
			
		}
		$this->load->view('cabecera.php',$data);
		$this->load->view('herramientas/compras/pedido_periodo.php');
		$this->load->view('pie.php');
	}
	function pedido_periodo(){
		$data['fecha_ini']=date('d/m/Y');
		$data['fecha_fin']=date('d/m/Y');
		$data['linea']="NA";
		$data['sucursal']="brasil";
		$data['subd']="";
		$data['lineas']=$this->compras_model->dep_suc($data['sucursal']);
		if(isset($_POST['fecha_ini'])){
			$data['sucursal']=$_POST['sucursal'];
			$f1=explode("/", $_POST['fecha_ini']);
			$f2=explode("/", $_POST['fecha_fin']);
			$data['periodo'] = array(
				($f1[2]-1)."-".$f1[1]."-".$f1[0],($f2[2]-1)."-".$f2[1]."-".$f2[0],
				($f1[2]-2)."-".$f1[1]."-".$f1[0],($f2[2]-2)."-".$f2[1]."-".$f2[0],
				($f1[2]-3)."-".$f1[1]."-".$f1[0],($f2[2]-3)."-".$f2[1]."-".$f2[0],
				($f1[2]-4)."-".$f1[1]."-".$f1[0],($f2[2]-4)."-".$f2[1]."-".$f2[0]
			);
			//$data['ventas'] = $this->compras_model->get_calculo_pedido($data['sucursal'],$_POST['linea'],$_POST['subdep'], $data['f_anteriores']);
			$data['ventas'] = $this->compras_model->get_calculo_pedido_periodo2($data['sucursal'],$_POST['linea'],$_POST['subdep'], $data['periodo']);
			$data['fecha_ini']=$_POST['fecha_ini'];
			$data['fecha_fin']=$_POST['fecha_fin'];
			$data['linea']=$_POST['linea'];
			$data['lineas']=$this->compras_model->dep_suc($data['sucursal']);
			$data['subdeps']=$this->compras_model->subdep_dep($data['sucursal'],$_POST['linea']);
			$data['subdep']=$_POST['subdep'];
			$data['sucursal']=$data['sucursal'];
			$data['ano']=explode("/", $_POST['fecha_ini']);
			$data['ano']=$data['ano'][2];
		}
		$this->load->view('cabecera.php',$data);
		$this->load->view('herramientas/compras/pedido_anterior.php');
		$this->load->view('pie.php');
	}
	function pedido_periodo_periodo(){
		$data['fecha_ini']=date('d/m/Y');
		$data['fecha_fin']=date('d/m/Y');
		$data['linea']="NA";
		$data['sucursal']="brasil";
		$data['subd']="";
		$data['lineas']=$this->compras_model->dep_suc($data['sucursal']);
		if(isset($_POST['fecha_ini'])){
			$data['sucursal']=$_POST['sucursal'];
			$dias = dias_entre_fechas($_POST['fecha_ini'],$_POST['fecha_fin']);
			$dias++;
			$f1 = resta_dias($_POST['fecha_ini'],$dias);
			$f2 = resta_dias($f1,$dias);
			$f3 = resta_dias($f2,$dias);
			$f4 = resta_dias($f3,$dias);
			/*
			echo $_POST['fecha_ini']." - ".$_POST['fecha_fin']."<br>".$dias."<br>".
			$f1." - ".resta_dias($_POST['fecha_ini'],1)."<br>".
			$f2." - ".resta_dias($f1,1)."<br>".
			$f3." - ".resta_dias($f2,1)."<br>".
			$f4." - ".resta_dias($f3,1)."<br>";
			*/
			$data['periodo']=array(
				sql_fecha($f1),sql_fecha(resta_dias($_POST['fecha_ini'],1)),
				sql_fecha($f2),sql_fecha(resta_dias($f1,1)),
				sql_fecha($f3),sql_fecha(resta_dias($f2,1)),
				sql_fecha($f4),sql_fecha(resta_dias($f3,1))
			);

//			show_array($data['periodo']);

			//$data['ventas'] = $this->compras_model->get_calculo_pedido($data['sucursal'],$_POST['linea'],$_POST['subdep'], $data['f_anteriores']);
			$data['ventas'] = $this->compras_model->get_calculo_pedido_periodo2($data['sucursal'],$_POST['linea'],$_POST['subdep'], $data['periodo']);
			$data['fecha_ini']=$_POST['fecha_ini'];
			$data['fecha_fin']=$_POST['fecha_fin'];
			$data['linea']=$_POST['linea'];
			$data['lineas']=$this->compras_model->dep_suc($data['sucursal']);
			$data['subdeps']=$this->compras_model->subdep_dep($data['sucursal'],$_POST['linea']);
			$data['subdep']=$_POST['subdep'];
			$data['sucursal']=$data['sucursal'];
			$data['ano']=explode("/", $_POST['fecha_ini']);
			$data['ano']=$data['ano'][2];
		}
		$this->load->view('cabecera.php',$data);
		$this->load->view('herramientas/compras/pedido_periodo_periodo.php');
		$this->load->view('pie.php');
	}
	function pedido_proveedor(){
		$data['fecha_ini']=date('d/m/Y');
		$data['fecha_fin']=date('d/m/Y');
		$data['linea']="NA";
		$data['sucursal']="gastroshop";
		$data['subd']="";
		$data['lineas']=$this->compras_model->dep_suc($data['sucursal']);
		$data['proveedores']=$this->compras_model->get_proveedores();
		if(isset($_POST['fecha_ini'])){
			$data['periodo'] = array(sql_fecha($_POST['fecha_ini']),sql_fecha($_POST['fecha_fin']));
			//$data['ventas'] = $this->compras_model->get_calculo_pedido($data['sucursal'],$_POST['linea'],$_POST['subdep'], $data['f_anteriores']);
			$data['ventas'] = $this->compras_model->get_calculo_pedido_proveedor($_POST['sucursal'],$_POST['prov'], $data['periodo']);
			$data['fecha_ini']=$_POST['fecha_ini'];
			$data['fecha_fin']=$_POST['fecha_fin'];
			
			$data['prov']=$_POST['prov'];
			$data['sucursal']=$_POST['sucursal'];
		}
		$this->load->view('cabecera.php',$data);
		$this->load->view('herramientas/compras/pedido_proveedor.php');
		$this->load->view('pie.php');
	}
	function consulta_dep(){
		//traer departamentos de la sucursal
		echo json_encode($this->compras_model->dep_suc($_POST['suc']));
	}
	function consulta_sub_dep(){
		//traer sub-dep de la sucursal y departamento
		echo json_encode($this->compras_model->subdep_dep($_POST['suc'],$_POST['dep']));
	}
	function poliza_compras(){
		$data['sucursal']="brasil";
		$data['mes']=date('m');
		$data['ano']=date('Y');
		if(isset($_POST['sucursal'])){
			$data['compras'] =	$this->compras_model->get_compras_credito($_POST['sucursal'],$_POST['mes'],$_POST['ejercicio']);
			$data['sucursal']=$_POST['sucursal'];
			$data['mes']=$_POST['mes'];
			$data['ano']=$_POST['ejercicio'];
		}
		$this->load->view('cabecera.php',$data);
		$this->load->view('herramientas/compras/polizas');
		$this->load->view('pie.php');
	}

	//productos sin clave sat
	function productos_sat(){
		$data['productos'] = $this->compras_model->get_productos_sat();
		$this->load->view('cabecera.php',$data);
		$this->load->view('herramientas/compras/productos_sat_view',$data);
		$this->load->view('pie.php');
	}
	function productos_sat_api(){
		$data['productos'] = $this->compras_model->get_productos_sat();
		if(count($data['productos'])==0){echo "Productos sat OK";exit;}
		//cal_days_in_month(CAL_GREGORIAN, $i,$ano)
		$html = $this->load->view('PDF/productos_sat.php',$data,TRUE);

		// Cargamos la librería
		$this->load->library('pdfgenerator');
		// definamos un nombre para el archivo. No es necesario agregar la extension .pdf
		$filename = 'reporte_productosSAT_'.date('Y_m_d').'.pdf';
		// generamos el PDF. Pasemos por encima de la configuración general y definamos otro tipo de papel
		//$this->pdfgenerator->generate($html, $filename, true, 'Letter', 'portrait');
		//$this->pdfgenerator->generate($html, $filename, false, 'Letter', 'landscape');
    	$output = $this->pdfgenerator->generate($html, $filename, false, 'Letter', 'portrait');
    	file_put_contents('D:\Reportes\\'.$filename, $output);
    	$this->enviador->envio_pdf($filename,"Reporte de producos sin clave SAT ",'costos@ferbis.com');
	}
	function herramienta_compra(){
		$data['codigo']='';
		$data['filtro']='producto';
		$data['filtro2']='venta';
		$data['fecha_ini']=date('d/m/Y');
		$data['fecha_fin']=date('d/m/Y');

		if(isset($_POST['filtro'])){
			$sucursales = array('brasil','sanmarcos','gastroshop');
			$data['ventas'] = $this->compras_model->get_ventas_especial($sucursales,$_POST['fecha_ini'],$_POST['fecha_fin'],$_POST['filtro'],$_POST['filtro2'],$_POST['codigo']);
			$data['filtro']=$_POST['filtro'];
			$data['filtro2']=$_POST['filtro2'];
			$data['codigo']=$_POST['codigo'];
			$data['fecha_ini']=$_POST['fecha_ini'];
			$data['fecha_fin']=$_POST['fecha_fin'];
		}
		$this->load->view('cabecera.php');
		$this->load->view('Reportes/ventas_especial',$data);
		$this->load->view('pie.php');
	}
	function tabla_busqueda(){
		$datos = $this->compras_model->tabla_busqueda_filtro($_POST['filtro']);
		$td="";
		if($_POST['filtro']=="proveedor"){
			foreach($datos as $d){
				$td.="<tr><td><a class='a_codigo' codigo='".$d->proveedor."'>".$d->proveedor."</a></td>"."<td>".$d->nombre."</td></tr>";
			}
		}
		if($_POST['filtro']=="marca"){
			foreach($datos as $d){
				$td.="<tr><td><a class='a_codigo' codigo='".$d->marca."'>".$d->marca."</a></td>"."<td>".$d->nombre."</td></tr>";
			}
		}
		if($_POST['filtro']=="producto"){
			foreach($datos as $d){
				$td.="<tr><td><a class='a_codigo' codigo='".$d->producto."'>".$d->producto."</a></td>"."<td>".$d->desc1."</td></tr>";
			}
		}
		if($_POST['filtro']=="departamento"){
			foreach($datos as $d){
				$td.="<tr><td><a class='a_codigo' codigo='".$d->linea."'>".$d->linea."</a></td>"."<td>".$d->nombre."</td></tr>";
			}
		}
		echo "<table class='table table-condensed busqueda_codigo'>".
			"<thead><tr><th>Codigo</th><th>Descripcion</th></tr></thead><tbody>".
			$td.
			"</tbody></table>";
	}
}

/* End of file Compras.php */
/* Location: ./application/controllers/Reportes/Compras.php */