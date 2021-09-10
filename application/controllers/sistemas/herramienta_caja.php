<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Herramienta_caja extends CI_Controller {

public function __construct()
	{
		parent::__construct();
		$this->load->model('mcaja_model');
		$this->load->model('sistemas_model');
		
	}

 		function monitor_cajas()
	{	
		$data['sucursales'][0]['nombre']="brasil";
		$data['sucursales'][1]['nombre']="sanmarcos";
		$data['sucursales'][2]['nombre']="gastroshop";
		$data['sucursales'][3]['nombre']="mexquite";
		$data['sucursales'][0]['cajas']=$this->mcaja_model->get_caja("brasil");
		$data['sucursales'][1]['cajas']=$this->mcaja_model->get_caja("sanmarcos");
		$data['sucursales'][2]['cajas']=$this->mcaja_model->get_caja("gastroshop");
		$data['sucursales'][3]['cajas']=$this->mcaja_model->get_caja("mexquite");

		$this->load->view('cabecera.php');
		$this->load->view('sistemas\cerrar_cajas',$data);
		$this->load->view('pie.php');

	}

	function cerrar_c(){	
		$caja = $this->input->get('c');
		$sucursal = $this->input->get('s');
		$this->mcaja_model->up_estado($caja,$sucursal);
		redirect('sistemas/Herramienta_caja/monitor_cajas');
	}

	function get_nombre_us(){
		echo $this->sistemas_model->get_usuario_nombre($_POST['base'],$_POST['usuario']);
	}



		
}
