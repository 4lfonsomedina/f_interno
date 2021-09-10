<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class restmex_model extends CI_Model {


	function monitor_mex(){

	$this->db->limit(100);
	$this->db=$this->load->database('mexquite',true);
	$this->db->select('p_caja, desc1');
	$this->db->where('estado=A');
	$r = $this->db->get('p_caja');
	return $r->result();

	}

	function get_ventas_frecuentes($sucursal,$ano,$mes){
		$this->db=$this->load->database($sucursal,true);
		$this->db->select("max(cte_frec) as cte_frec, max(nombre) as nombre, count(cte_frec) as ventas_dia, SUM(total) as total, max(fecha) as fecha");
		$this->db->join("p_ctesfrec","cte_frec=clave","LEFT");
		$this->db->where('cte_frec is NOT NULL', NULL, FALSE);
		$this->db->where('year(fecha)',$ano);
		$this->db->where('month(fecha)',$mes);
		$this->db->group_by('cte_frec,fecha');
		$r=$this->db->get("p_fact");

		return $r->result();
	}
	function get_canjes($suc,$frec){
		$this->db=$this->load->database($suc,true);
		$this->db->where("ctefrec",$frec);
		$r=$this->db->get("p_canje");

		return $r->result();
	}

	function guardar_encuesta($data){
		$this->db=$this->load->database("interno",true);
		$this->db->insert("encuestas_mex",$data);
	}
	function get_encuestas(){
		$this->db=$this->load->database("interno",true);
		return $this->db->get("encuestas_mex")->result();
	}
	function get_encuesta($id_encuesta){
		$this->db=$this->load->database("interno",true);
		$this->db->where("id_encuesta",$id_encuesta);
		return $this->db->get("encuestas_mex")->row();
	}


	
}