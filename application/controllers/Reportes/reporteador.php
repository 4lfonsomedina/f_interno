<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Reporteador extends CI_Controller {



	public function NotificacionPagoProveedores(){
		$this->load->view('cabecera.php');
		$this->load->view('Reportes/NotPagProv.php');
	}

	public function validar_envio(){
	$this->load->model('notificaciones_model');
	$this->notificaciones_model->notificacion_prov();
	Redirect("reportes/reporteador/NotificacionPagoProveedores");
	}

	




	

}

/* End of file reporteador.php */
/* Location: ./application/controllers/Reportes/reporteador.php */