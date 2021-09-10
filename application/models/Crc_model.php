<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Crc_model extends CI_Model {

	function guardar_reg($datos){
		$this->db=$this->load->database("interno",true);
		$this->db->insert('crc',$datos);
	}
}

/* End of file crc_model.php */
/* Location: ./application/models/crc_model.php */