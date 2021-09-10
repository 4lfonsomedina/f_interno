<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {
	
	public function __construct()
	{
		parent::__construct();
		$this->load->model('validar_model');
	}
	
	function index(){
		$this->load->view('Login');
	}

	function validar_old(){
		//validar usuario y password
		if($this->validar_model->validar_usuario($_POST['usuario'],$_POST['password'])){
			echo "EXISTE!";
		}else{
			Redirect('Login?err=1');
		}

	}
	function validar(){
		$resultado_session = $this->validar_model->validar_usuario($_POST['usuario'],$_POST['password']);
		if($resultado_session){
			$this->session->set_userdata($resultado_session);
			Redirect('Welcome');
		}else{
			Redirect('Login?e=1');
		}
	}

}

/* End of file login.php */
/* Location: ./application/controllers/login.php */