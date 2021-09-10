<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Traspasos extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		if(!$this->session->userdata('usuario')){ Redirect('Login');}
		$this->load->model('Reportes/ventas_model');
		$this->load->model('Reportes/compras_model');
		$this->load->model('Reportes/traspasos_model');
	}
	public function index(){
		$data['sucursal']='brasil';
		$data['periodo1']=date('d/m/Y');
		$data['periodo2']=date('d/m/Y');
		$data['lineas']=array();
		
		if(isset($_POST['sucursal'])){
			$data['sucursal']=$_POST['sucursal'];
			$data['periodo1']=$_POST['periodo1'];
			$data['periodo2']=$_POST['periodo2'];
			$data['tipo_salida']=$_POST['tipo_salida'];
			$data['lineas']=$this->compras_model->dep_suc($_POST['sucursal']);
			$data['salidas']=$this->traspasos_model->salidas_merc($data['sucursal'],sql_fecha($data['periodo1']),sql_fecha($data['periodo2']),$data['tipo_salida']);
			//show_array($data['salidas']);
		}
		$data['tipo_salidas']=$this->traspasos_model->tipo_salida($data['sucursal']);

		$this->load->view('cabecera.php');
		$this->load->view('Reportes/traspasos_view.php',$data);
		$this->load->view('pie.php');
	}
	public function mermas_donativos(){
		$data['sucursal']='brasil';
		$data['periodo1']=date('d/m/Y');
		$data['periodo2']=date('d/m/Y');
		
		if(isset($_POST['sucursal'])){
			$data['sucursal']=$_POST['sucursal'];
			$data['periodo1']=$_POST['periodo1'];
			$data['periodo2']=$_POST['periodo2'];
			$data['tipo_salida']=$_POST['tipo_salida'];
			$data['salidas']=$this->traspasos_model->salidas_merc2($data['sucursal'],sql_fecha($data['periodo1']),sql_fecha($data['periodo2']),$data['tipo_salida']);
			//show_array($data['salidas']);
		}
		$data['tipo_salidas']=$this->traspasos_model->tipo_salida2($data['sucursal']);
		$data['departamentos']=$this->compras_model->dep_suc($data['sucursal']);

		$this->load->view('cabecera.php');
		$this->load->view('Reportes/traspasos_view2.php',$data);
		$this->load->view('pie.php');
	}
	function get_tipos(){
		echo json_encode($this->traspasos_model->tipo_salida($_POST['sucursal']));
	}
	function merma_anual(){
		error_reporting(E_ERROR | E_PARSE);
		$data['ano']=date('Y');
		$data['tipo']='c';
		$data['linea']="NA";
		$data['sucursal']="NA";
		$data['moneda']="";
		$data['lineas']=$this->compras_model->lineas();

		if(isset($_POST['sucursal'])){
			$data['sucursal'] = $_POST['sucursal'];
			$data['ano']=$_POST['ejercicio'];
			$data['moneda']=$_POST['moneda'];
			$data['merma'] = $this->traspasos_model->merma($_POST['sucursal'],$_POST['linea'],$_POST['ejercicio'],$_POST['tipo']);
			$data['productos']=$this->traspasos_model->merma_ano($_POST['ejercicio'],$_POST['sucursal'],$_POST['linea']);
			$data['ano']=$_POST['ejercicio'];
			$data['linea']=$_POST['linea'];
			$data['lineas']=$this->compras_model->dep_suc($_POST['sucursal']);
			$data['subdeps']=$this->compras_model->subdep_dep($_POST['sucursal'],$_POST['linea']);
			$data['sucursal']=$_POST['sucursal'];
			$data['grupo']=$_POST['grupo'];
			$data['tipo']=$_POST['tipo'];
		}
		$this->load->view('cabecera.php');
		$this->load->view('Reportes/merma_anual.php',$data);
		$this->load->view('pie.php');
	}

	function carga_usuarios(){
		$data['fecha_ini']=date('d/m/Y');
		$data['fecha_fin']=date('d/m/Y');
		$data['sucursal']="brasil";
		if(isset($_POST['fecha_ini'])){
			$data['datos'] = $this->traspasos_model->carga_usuarios($_POST['sucursal'],$_POST['fecha_ini'],$_POST['fecha_fin']);
			$data['fecha_ini']=$_POST['fecha_ini'];
			$data['fecha_fin']=$_POST['fecha_fin'];
			$data['sucursal']=$_POST['sucursal'];
		}
		$this->load->view('cabecera.php',$data);
		$this->load->view('Reportes/carga_usuarios.php');
		$this->load->view('pie.php');
	}

	function transferencias(){
		$data['sucursal']="brasil";
		$data['fecha']=date('d/m/Y');
		if(isset($_POST['fecha'])){
			$data['sucursal']=$_POST['sucursal'];
			$data['fecha']=$_POST['fecha'];
			$data['datos']=$this->traspasos_model->transferencias_externas($data['sucursal'],$data['fecha']);
		}
		$this->load->view('cabecera.php',$data);
		$this->load->view('Reportes/transferencias_externas.php');
		$this->load->view('pie.php');
	}
	function transferencias_dia(){
		echo json_encode($this->traspasos_model->transferencias_externas_det($_POST['sucursal'],$_POST['fecha'],$_POST['destino']));
	}

}

/* End of file traspasos.php */
/* Location: ./application/controllers/Reportes/traspasos.php */