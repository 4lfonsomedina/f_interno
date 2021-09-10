<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Notificaciones_model extends CI_Model {


function notificacion_prov(){

$this->db=$this->load->database("brasil",true);
$this->db->query("execute dbo.sp_alertas_diarias");

}
	

}