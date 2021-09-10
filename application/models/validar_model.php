<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Validar_model extends CI_Model {

	//funcion para validar si existe el usuario y password
	function validar_usuario($us,$pass){

		//conexion a la base de datos deseada
		$this->db=$this->load->database("brasil",true);
		
		//construccion de query
		$this->db->select("usuario,nombre,tipo");
		$this->db->where("usuario",$us);
		$this->db->where("password",$pass);
		$r = $this->db->get('p_usua');
		
		//validar el numero de filas recibidas
		if($r->num_rows()>0)
			return $r->row_array();
		else
			return false;
	}

	//traer permisos
	function permisos($usuario){
		$this->db->where('usuario',$usuario);
		$r = $this->db->get('permisos');
		
		//validar el numero de filas recibidas
		if($r->num_rows()>0)
			return $r->row_array();
		else
			return FALSE;
	}

}
