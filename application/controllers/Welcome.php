<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {
	public function __construct()
	{
		parent::__construct();
		if(!$this->session->userdata('usuario')){ Redirect('Login');}
	}
	public function index()
	{
		$this->load->view('cabecera');
		$this->load->view('welcome_message');
		$this->load->view('pie');
	}
}
