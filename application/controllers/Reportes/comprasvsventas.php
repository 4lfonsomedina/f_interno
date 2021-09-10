<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Comprasvsventas extends CI_Controller {
	public function __construct()
	{
		parent::__construct();
		if(!$this->session->userdata('usuario')){ Redirect('Login');}
		$this->load->model('Reportes/comprasvsventas_model');
	}

	public function index(){
		$data['compras'] = $this->comprasvsventas_model->get_reporte(0,'2019-02-04','2019-02-08','2019-02-04','2019-02-08');
		$this->load->view('cabecera.php');
		$this->load->view('Reportes/comprasvsventas_view.php',$data);
		$this->load->view('pie.php');
		
	}

}

/* End of file costosvsventas.php */
/* Location: ./application/controllers/Reportes/costosvsventas.php */