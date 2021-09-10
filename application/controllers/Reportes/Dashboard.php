<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {
	public function __construct()
	{
		parent::__construct();
		if(!$this->session->userdata('usuario')){ Redirect('Login');}
		
	}
	public function index(){
		$this->load->view('cabecera.php');
		$this->load->view('Reportes/dash.php');
		$this->load->view('pie.php');
	}

}

/* End of file dash_reportes.php */
/* Location: ./application/controllers/Reportes/dash_reportes.php */