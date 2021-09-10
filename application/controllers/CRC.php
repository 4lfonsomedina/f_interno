<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class CRC extends CI_Controller {
	public function __construct()
	{
		parent::__construct();
		if(!$this->session->userdata('usuario')){ Redirect('Login');}
		if(!$this->session->userdata('usuario')){ Redirect('Login');}
		$this->load->model('crc_model');
	}

	public function index()
	{//https://192.168.20.2:8089/cgi?sord=asc&sidx=extension&page=1&item_num=30&action=listAccount&options=extension%2Caccount_type%2Cfullname%2Cstatus%2Caddr%2Cout_of_service%2Cemail_to_user%2Cpresence_status%2Cpresence_def_script%2Curgemsg%2Cnewmsg%2Coldmsg
		$this->load->view('crc_view');
	}

	public function receptor(){
		$post = json_encode($_POST);
		$this->crc_model->guardar_reg(array('post'=>$post));
	}

}

/* End of file CRC.php */
/* Location: ./application/controllers/CRC.php */