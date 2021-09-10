<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class mcaja_model extends CI_Model {

	function get_caja($sucursal){
		

		$this->db=$this->load->database($sucursal,true);
		$this->db->select("caja, fecha_ent as fecha, estado, total_vta as total , usuario");
		$this->db->where("estado",'A');
		$r = $this->db->get('p_caja');
		return $r->result();

	}

	function up_estado($caja,$sucursal){
		$this->db=$this->load->database($sucursal,true);
		$this->db->set("estado",'C');
		$this->db->where('caja',$caja);
		$this->db->update('p_caja');
		
	}
		
		
		
		
	

}