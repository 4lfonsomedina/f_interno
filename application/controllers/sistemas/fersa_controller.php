<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Fersa_controller extends CI_Controller {
	public function __construct()
	{
		parent::__construct();
		if(!$this->session->userdata('usuario')){ Redirect('Login');}
		$this->load->model('fersa_model');
	}
	function ventas(){
		$data['facturas'] = $this->fersa_model->get_facturas();
		$this->load->view('cabecera');
		$this->load->view('fersa/ventas',$data);
		$this->load->view('pie');
	}
	function cambiar_fecha_factura(){
		$this->fersa_model->cambiar_fecha_venta($_POST['factura'],$_POST['fecha']);
	}

}

/* End of file fersa_controller.php */
/* Location: ./application/controllers/sistemas/fersa_controller.php */