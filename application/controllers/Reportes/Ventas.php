<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ventas extends CI_Controller {
	public function __construct()
	{
		parent::__construct();
		//if(!$this->session->userdata('usuario')){ Redirect('Login');}
		$this->load->model('Reportes/ventas_model');
		$this->load->model('Reportes/compras_model');
		$this->load->model('Reportes/enviador');
	}
	public function index(){

		$data['sucursal']="NA";
		$data['ano']='2018';
		$data['lineas']=array();
		$data['grupo']='diario';
		
		//Consultamos las ventas
		if(isset($_POST['sucursal'])){
			$data['sucursal'] = $_POST['sucursal'];
			$data['ano']=$_POST['ejercicio'];
			$data['grupo']= $_POST['grupo'];
			$data['lineas']=$this->ventas_model->lineas_ano($_POST['ejercicio'],$_POST['sucursal']);
			$data['ventas'] = $this->ventas_model->ventas_ano($_POST['ejercicio'],$_POST['sucursal']);
		}
		
		$this->load->view('cabecera.php');
		$this->load->view('Reportes/ventas_ano_view.php',$data);
		$this->load->view('pie.php');
	}
	function mensual_dep(){
		$data['sucursal'] 	="NA";
		$data['ano'] 		=date('Y');
		$data['mes'] 		=date('m');
		$data['lineas'] 	=array();
		$data['grupo'] 		='mensual';
		
		//Consultamos las ventas
		if(isset($_POST['mes'])){
			$data['sucursal'] = $_POST['sucursal'];
			$data['ano']=$_POST['ejercicio'];
			$data['mes'] =$_POST['mes'];
			$data['lineas']=$this->ventas_model->lineas_mes($_POST['ejercicio'],$_POST['mes'],$_POST['sucursal']);
			$data['ventas'] = $this->ventas_model->ventas_mes($_POST['ejercicio'],$_POST['mes'],$_POST['sucursal']);
		}
		
		$this->load->view('cabecera.php');
		$this->load->view('Reportes/ventas_mes_view.php',$data);
		$this->load->view('pie.php');
	}
	function ventas_periodo(){
		$data['sucursal']="brasil";
		$data['fecha1']=date('d/m/Y');
		$data['fecha2']=date('d/m/Y');
		$data['dep']=array();
		$data['subdep']=array();
		if(isset($_POST['fecha1'])){
			$data['ventas'] = $this->ventas_model->ventas_periodo($_POST['sucursal'],$_POST['fecha1'],$_POST['fecha2'],$_POST['dep'],$_POST['subdep']);
			$data['fecha1']=$_POST['fecha1'];
			$data['fecha2']=$_POST['fecha2'];
			$data['dep']=$_POST['dep'];
			$data['subdep']=$_POST['subdep'];
			$data['sucursal']=$_POST['sucursal'];
			$data['subdepartamentos']=$this->compras_model->subdep_dep($data['sucursal'],$data['dep']);
		}
		$data['departamentos']=$this->compras_model->dep_suc($data['sucursal']);
		
		$this->load->view('cabecera.php');
		$this->load->view('Reportes/ventas_periodo_view.php',$data);
		$this->load->view('pie.php');
		
	}
	function ventas_anuales_prod(){
		$data['sucursal']="NA";
		$data['ano']='2018';
		$data['lineas']=array();
		$data['grupo']='diario';
		$data['producto']='';
		$data['productos']=$this->compras_model->get_productos();
		
		//Consultamos las ventas
		if(isset($_POST['sucursal'])){
			$data['sucursal'] = $_POST['sucursal'];
			$data['producto']=$_POST['producto'];
			$data['ano']=$_POST['ejercicio'];
			$data['grupo']= $_POST['grupo'];
			$data['ventas'] = $this->ventas_model->ventas_ano_producto($_POST['ejercicio'],$_POST['sucursal'],$_POST['producto']);
		}
		
		$this->load->view('cabecera.php');
		$this->load->view('Reportes/ventas_ano_prod_view.php',$data);
		$this->load->view('pie.php');
	}

	//ventas anuales por departamento
	function ventas_anuales_dep(){
		$data['sucursal']="NA";
		$data['ano']='2018';
		$data['lineas']=$this->compras_model->lineas();
		$data['grupo']='diario';
		$data['linea']='';
		$data['tipo']='c';
		//Consultamos las ventas
		if(isset($_POST['sucursal'])){
			$data['sucursal'] = $_POST['sucursal'];
			$data['ano']=$_POST['ejercicio'];
			$data['grupo']= $_POST['grupo'];
			$data['linea']=$_POST['linea'];
			$data['subdep']=$_POST['subdep'];
			$data['tipo']=$_POST['tipo'];
			$data['productos']=$this->ventas_model->get_productos_dep($data['sucursal'],$_POST['linea'],$_POST['subdep']);
			$data['subdeps']=$this->compras_model->subdep_dep($data['sucursal'],$_POST['linea']);
			$data['ventas'] = $this->ventas_model->ventas_ano_departamento(
				$_POST['ejercicio'],
				$_POST['sucursal'],
				$_POST['linea'],
				$_POST['subdep'],
				$_POST['tipo']
			);
		}
		$this->load->view('cabecera.php');
		$this->load->view('Reportes/ventas_ano_dep_view.php',$data);
		$this->load->view('pie.php');
	}
	//ventas por producto mexquite
	function ventas_mexquite(){
		$data['ano']='2019';
		$data['lineas']=$this->ventas_model->lineas_mexquite();
		$data['productos']=array();
		if(isset($_POST['ejercicio'])){
			$data['ano']=$_POST['ejercicio'];
			$data['lineas_consulta']=$_POST['lineas_consulta'];
			$data['productos']=$this->ventas_model->get_productos_mexquite($data['ano'],$_POST['lineas_consulta']);
			$data['ventas']=$this->ventas_model->ventas_tacos($data['ano'],$_POST['lineas_consulta']);
		}
		$this->load->view('cabecera.php');
		$this->load->view('Reportes/ventas_tacos.php',$data);
		$this->load->view('pie.php');
	}
	//Costo en base al ultimo costo en las ventas
	function costo_venta(){
		$data['sucursal'] = "NA";
		$data['periodo1']=date('d/m/Y');
		$data['periodo2']=date('d/m/Y');
		if(isset($_POST['periodo1'])){
			$data['periodo1']=$_POST['periodo1'];
			$data['periodo2']=$_POST['periodo2'];
			$data['sucursal']=$_POST['sucursal'];
			$data['ventas'] = $this->ventas_model->get_costo_venta(
				$_POST['sucursal'],
				sql_fecha($_POST['periodo1']),
				sql_fecha($_POST['periodo2'])
			);
		}
		$this->load->view('cabecera.php');
		$this->load->view('Reportes/costo_venta_view.php',$data);
		$this->load->view('pie.php');
	}
	function costo_venta_integrado(){
		$data['sucursal'] = "NA";
		$data['marca'] = "0";
		$data['marcas'] = $this->compras_model->marcas();
		if(isset($_POST['marca'])){
			$data['marca']=$_POST['marca'];
			$data['sucursal']=$_POST['sucursal'];
			$data['ventas'] = $this->ventas_model->get_costo_venta_integrado(
				$_POST['sucursal'],
				$data['marca']
			);
		}
		$this->load->view('cabecera.php');
		$this->load->view('Reportes/costo_venta_int_view.php',$data);
		$this->load->view('pie.php');
	}

	//reporte con los detalles de ventas por departamento
	function detallado_departamento(){
		//omologar las variables
		if(isset($_GET['periodo1'])){
			$_POST['periodo1']=$_GET['periodo1'];
			$_POST['periodo2']=$_GET['periodo2'];
			$_POST['sucursal']=$_GET['sucursal'];
			$_POST['linea']=$_GET['linea'];
			$_POST['subdep']='T';
		}

		$data['sucursal'] = "NA";
		$data['periodo1']=date('d/m/Y');
		$data['periodo2']=date('d/m/Y');
		$data['lineas']=$this->compras_model->lineas();
		if(isset($_POST['periodo1'])){
			$data['periodo1']=$_POST['periodo1'];
			$data['periodo2']=$_POST['periodo2'];
			$data['sucursal']=$_POST['sucursal'];
			$data['subdeps']=$this->compras_model->subdep_dep($data['sucursal'],$_POST['linea']);
			$data['ventas'] = $this->ventas_model->get_detallado_ventas(
				$_POST['sucursal'],
				sql_fecha($_POST['periodo1']),
				sql_fecha($_POST['periodo2']),
				sql_fecha($_POST['linea']),
				sql_fecha($_POST['subdep'])
			);
			$data['linea']=$_POST['linea'];
			$data['subdep']=$_POST['subdep'];
			$data['sucursal']=$_POST['sucursal'];
		}
		$this->load->view('cabecera.php');
		$this->load->view('Reportes/detallado_departamentos.php',$data);
		$this->load->view('pie.php');
	}
	function agrupado_departamento(){
		$data['sucursal'] = "NA";
		$data['periodo1']=date('d/m/Y');
		$data['periodo2']=date('d/m/Y');
		$data['lineas']=$this->compras_model->lineas();
		if(isset($_POST['periodo1'])){
			$data['periodo1']=$_POST['periodo1'];
			$data['periodo2']=$_POST['periodo2'];
			$data['sucursal']=$_POST['sucursal'];
			$data['ventas'] = $this->ventas_model->get_agrupado_ventas(
				$_POST['sucursal'],
				sql_fecha($_POST['periodo1']),
				sql_fecha($_POST['periodo2'])
			);
			$data['sucursal']=$_POST['sucursal'];
		}
		$this->load->view('cabecera.php');
		$this->load->view('Reportes/agrupado_departamentos.php',$data);
		$this->load->view('pie.php');
	}
	function detallado_producto(){
		//omologar las variables
		if(isset($_GET['periodo1'])){
			$_POST['periodo1']=$_GET['periodo1'];
			$_POST['periodo2']=$_GET['periodo2'];
			$_POST['sucursal']=$_GET['sucursal'];
			$_POST['producto']=$_GET['producto'];
		}
		$data['sucursal'] = "NA";
		$data['periodo1']=date('d/m/Y');
		$data['periodo2']=date('d/m/Y');
		$data['producto']="";
		if(isset($_POST['periodo1'])){
			$data['periodo1']=$_POST['periodo1'];
			$data['periodo2']=$_POST['periodo2'];
			$data['sucursal']=$_POST['sucursal'];
			$data['producto']=$_POST['producto'];
			$data['ventas'] = $this->ventas_model->get_detallado_producto(
				$_POST['sucursal'],
				sql_fecha($_POST['periodo1']),
				sql_fecha($_POST['periodo2']),
				$_POST['producto']
			);
		}
		$this->load->view('cabecera.php');
		$this->load->view('Reportes/detallado_producto.php',$data);
		$this->load->view('pie.php');
	}
	function detalle_ticket(){
		if(isset($_GET['ticket'])){
			$_POST['ticket']=$_GET['ticket'];
			$_POST['sucursal']=$_GET['sucursal'];
		}
		$data['ticket']="";
		if(isset($_POST['ticket'])){
			$data['detalle_venta'] = $this->ventas_model->get_detalle_ticket($_POST['ticket'],$_POST['sucursal']);
			if(isset($data['detalle_venta'][0]->venta))
				$data['venta'] = $this->ventas_model->get_venta($data['detalle_venta'][0]->venta,$_POST['sucursal']);
			$data['ticket']=$_POST['ticket'];
			$data['sucursal']=$_POST['sucursal'];
		}
		$this->load->view('cabecera.php');
		$this->load->view('Reportes/detalle_ticket.php',$data);
		$this->load->view('pie.php');
	}

	//reporte diario de ventas por mes
	function diario_ventas_global(){
		$data['mes']=date('m');
		$data['ano']=date('Y');
		$data['sucursales']=array('brasil','gastroshop','sanmarcos','mexquite');
		if(isset($_POST['mes'])){
			$data['ventas'] = $this->ventas_model->get_diario_ventas($_POST['mes'],$_POST['ano'],$data['sucursales']);
			$data['mes']=$_POST['mes'];
			$data['ano']=$_POST['ano'];
		}
		//cal_days_in_month(CAL_GREGORIAN, $i,$ano)
		$this->load->view('cabecera.php');
		$this->load->view('Reportes/diario_ventas.php',$data);
		$this->load->view('pie.php');
	}
	//reporte diario de ventas por mes
	function diario_ventas_global_API($mes,$ano){
		$data['mes']=date('m');
		$data['ano']=date('Y');
		$data['sucursales']=array('brasil','gastroshop','sanmarcos','mexquite');
		if(isset($mes)){
			$data['ventas'] = $this->ventas_model->get_diario_ventas($mes,$ano,$data['sucursales']);
			$data['mes']=$mes;
			$data['ano']=$ano;
		}
		//cal_days_in_month(CAL_GREGORIAN, $i,$ano)
		$html = $this->load->view('PDF/ventas_global.php',$data,TRUE);
		
		// Cargamos la librería
		$this->load->library('pdfgenerator');
		// definamos un nombre para el archivo. No es necesario agregar la extension .pdf
		$filename = 'reporte_ventas_'.$data['ano'].'_'.descrip_mes($data['mes']).'.pdf';
		// generamos el PDF. Pasemos por encima de la configuración general y definamos otro tipo de papel
		//$this->pdfgenerator->generate($html, $filename, true, 'Letter', 'portrait');
		//$this->pdfgenerator->generate($html, $filename, true, 'Letter', 'landscape');
    	$output = $this->pdfgenerator->generate($html, $filename, false, 'Letter', 'landscape');
    	file_put_contents('D:\Reportes\\'.$filename, $output);
    	$this->enviador->envio_pdf($filename,"Reporte de ventas global ".$data['ano'].'_'.descrip_mes($data['mes']),'rubenf@ferbis.com,almas@ferbis.com,gerencia@ferbis.com');
	}
	
	function venta_dia_service(){
		echo $this->ventas_model->get_venta_dia($_POST['sucursal'],$_POST['fecha']);
	}

	//dash ventas
	function dash_ventas(){
		$data['anos']=[(date('Y')-2),(date('Y')-1),date('Y')];
		$data['sucursales']=['brasil','sanmarcos','gastroshop','mexquite'];
		$data['ventas']['brasil'] = $this->ventas_model->get_ventas_mensual($data['anos'],$data['sucursales'][0]);
		$data['ventas']['sanmarcos'] = $this->ventas_model->get_ventas_mensual($data['anos'],$data['sucursales'][1]);
		$data['ventas']['gastroshop'] = $this->ventas_model->get_ventas_mensual($data['anos'],$data['sucursales'][2]);
		$data['ventas']['mexquite'] = $this->ventas_model->get_ventas_mensual($data['anos'],$data['sucursales'][3]);
		//cal_days_in_month(CAL_GREGORIAN, $i,$ano)
		$this->load->view('cabecera.php');
		$this->load->view('Reportes/dash_ventas.php',$data);
		$this->load->view('pie.php');
	}

	//herramienta de precortes
	//una herramienta comparativa de precortes a x hora contra 2 dias anteriores, semanas, meses
	function pre_corte(){
		$data['fecha'] = date('d/m/Y');
		$data['periodo'] = 'dia';
		$data['hora'] = '12:00';
		$data['sucursales'] = array('brasil','sanmarcos','gastroshop');
		$data['suc'] = array('Brasil','San Marcos','GastroShop');
		if(isset($_POST['fecha'])){
			$data['fecha']=$_POST['fecha'];
			$data['hora']=$_POST['hora'];
			$data['periodo']=$_POST['periodo'];
			$data['ventas'] = $this->ventas_model->get_pre_corte($data['sucursales'],$data['fecha'],$data['hora'],$data['periodo']);
			//show_array($data['ventas']);
		}
		$this->load->view('cabecera.php');
		$this->load->view('Reportes/pre_corte_view', $data);
		$this->load->view('pie.php');
	}

	function ventas_sd(){
		$data['sucursal'] = "brasil";
		$data['fecha_ini']=date('d/m/Y');
		$data['fecha_fin']=date('d/m/Y');
		if(isset($_POST['fecha_ini'])){
			$data['fecha_ini']=$_POST['fecha_ini'];
			$data['fecha_fin']=$_POST['fecha_fin'];
			$data['sucursal']=$_POST['sucursal'];
			$data['ventas'] = $this->ventas_model->get_ventas_sd($data['sucursal'],$data['fecha_ini'],$data['fecha_fin']);
		}
		$this->load->view('cabecera.php');
		$this->load->view('Reportes/ventas_sd',$data);
		$this->load->view('pie.php');
	}
	function ventas_sd2(){
		$data['sucursal'] = "brasil";
		$data['fecha_ini']=date('d/m/Y');
		$data['fecha_fin']=date('d/m/Y');
		$data['lineas']=$this->compras_model->lineas();
		if(isset($_POST['fecha_ini'])){
			$data['fecha_ini']=$_POST['fecha_ini'];
			$data['fecha_fin']=$_POST['fecha_fin'];
			$data['sucursal']=$_POST['sucursal'];
			$data['ventas'] = $this->ventas_model->get_ventas_sd2($data['sucursal'],$data['fecha_ini'],$data['fecha_fin']);
		}
		$this->load->view('cabecera.php');
		$this->load->view('Reportes/ventas_sd2',$data);
		$this->load->view('pie.php');
	}
	function ventas_carniceria_detalle(){
		$data['sucursal'] = "localbrasil";
		$data['fecha_ini']=date('d/m/Y');
		$data['fecha_fin']=date('d/m/Y');
		$data['lineas']=$this->compras_model->lineas();
		if(isset($_POST['fecha_ini'])){
			$data['fecha_ini']=$_POST['fecha_ini'];
			$data['fecha_fin']=$_POST['fecha_fin'];
			$data['sucursal']=$_POST['sucursal'];
			$data['linea']=$_POST['linea'];
			$data['ventas'] = $this->ventas_model->get_ventas_detalladas($data['sucursal'],sql_fecha($data['fecha_ini']),sql_fecha($data['fecha_fin']),$_POST['linea']);
		}
		$this->load->view('cabecera.php');
		$this->load->view('Reportes/ventas_detalladas_dep',$data);
		$this->load->view('pie.php');
	}

	

}

/* End of file Ventas.php */
/* Location: ./application/controllers/Reportes/Ventas.php */