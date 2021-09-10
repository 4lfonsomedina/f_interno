<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Fersa_model extends CI_Model {

	function get_facturas(){
		$this->db=$this->load->database('fersa',true);
		$this->db->select('factura,fecha,total');
		$this->db->order_by('factura');
		return $this->db->get('p_fact')->result();
	}
	function cambiar_fecha_venta($factura,$fecha){
		$this->db=$this->load->database('fersa',true);

		$venta = $this->db->query("select venta from p_vede where factura='".$factura."' group by venta")->row()->venta;

		$this->db->query("UPDATE p_vent SET id_fecha='".$fecha." 00:00:00.000',pedido='".$fecha." 00:00:00.000'
		where venta ='".$venta."'");

		$this->db->query("UPDATE p_fact SET id_fecha='".$fecha." 00:00:00.000',fecha='".$fecha." 00:00:00.000',f_pago='".$fecha." 00:00:00.000', vence='".$fecha." 00:00:00.000'
		where factura in (select factura from p_vede where venta ='".$venta."')");

		$this->db->query("UPDATE p_vede SET fecha='".$fecha." 00:00:00.000',id_fecha='".$fecha." 00:00:00.000'
		where venta ='".$venta."'");

		$this->db->query("UPDATE p_factdet SET id_fecha='".$fecha." 00:00:00.000' 
		where venta ='".$venta."'");
	}

}

/* End of file fersa_model.php */
/* Location: ./application/models/fersa_model.php */