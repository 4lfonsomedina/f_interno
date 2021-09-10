<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Api_model extends CI_Model {

	function productos_dep($dep){
		$this->db=$this->load->database('domicilio',true);
		$this->db->where('departamento',$dep);
		return $this->db->get('productos')->result();
	}
	function productos_desc($desc){
		$this->db=$this->load->database('domicilio',true);
		$this->db->like('descripcion',$desc);
		return $this->db->get('productos')->result();
	}
	function get_precio($productos){
		$this->db=$this->load->database('brasil',true);
		$this->db->select('producto,precio1 as precio');
		$this->db->where_in('producto',explode(',', $productos));
		return $this->db->get('p_prod')->result();
	}
	function get_precio_bizerba($productos){
		$this->db=$this->load->database('brasil',true);
		$this->db->select('cbarras3,precio1 as precio, desc1, um');
		$this->db->where_in('cbarras3',$productos);
		return $this->db->get('p_prod')->result();
	}
	function asignacion_cbarras3($plu,$producto){
		$this->db=$this->load->database('brasil',true);
		$this->db->where('producto',$producto);
		$this->db->update("p_prod", array("cbarras3"=>$plu));
		
		$this->db=$this->load->database('sanmarcos',true);
		$this->db->where('producto',$producto);
		$this->db->update("p_prod", array("cbarras3"=>$plu));
		
	}
	function get_producto($producto){
		$this->db=$this->load->database('brasil',true);
		$this->db->group_start();
			$this->db->where('producto',$producto);
			$this->db->or_where('cbarras',$producto);
			$this->db->or_where('cbarras2',$producto);
			$this->db->or_where('cbarras3',$producto);
		$this->db->group_end();
		$this->db->where('estatus','A');
		return $this->db->get('p_prod')->result();
	}
	function get_empleado($num,$rfc){
		$this->db=$this->load->database('sfera',true);
		$this->db->select("employee_num as numero,tax_id_num as rfc,CONCAT(employee_name,' ', first_name,' ',last_name) as nombre");
		$this->db->group_start();
		$this->db->where("last_period_num ='0' or last_period_num IS NULL");
		$this->db->group_end();
		$this->db->where("employee_num",$num);
		$this->db->where("tax_id_num",$rfc);
		return $this->db->get('premployee')->row();
	}
	function get_personal($usuario,$clave){
		$this->db->where('usuario',$usuario);
		$this->db->where('clave',$clave);
		return $this->db->get('personal')->row();
	}
	function get_actividad($id_actividad){
		return $this->db->where('id_actividad',$id_actividad)
		->join('personal', 'actividades.id_responsable = personal.id_personal','LEFT')
		->where('estatus','0')
		->where('calificacion_listo !=','1')
		->get('actividades')->row();
	}
	function get_actividades($id_responsable,$fecha,$activo){
		if($fecha!=""){
			$this->db->where('fecha_ini',$fecha);
		}
		if($activo!=""){
			$this->db->where('actividades.estatus !=','0');
			$this->db->where('actividades.estatus !=','3');
			$this->db->order_by('fecha_ini');
		}else{
			$this->db->where('actividades.estatus','0');
			$this->db->order_by('fecha_ini DESC');
		}
		$this->db->select("actividades.*,estatus.estatus as estatus_desc,estatus.color, adjunto = ''");
		$this->db->join('estatus','actividades.estatus=estatus.id_estatus');
		$this->db->where('id_responsable',$id_responsable);
		$this->db->limit(100);
		$result = $this->db->get('actividades')->result();
		foreach ($result as &$r) {
			$r->adjunto = existe_adjunto($r->id_actividad);
		}
		return $result;
	}
	function actividad_edit($id_actividad,$data){
		$this->db->where('id_actividad',$id_actividad);
		$this->db->update('actividades',$data);
	}
	function envio_sms($mensaje,$telefono){
		$ch = curl_init();
		$params = http_build_query(array(
			"message"=>$mensaje,
			"phone"=>$telefono
		));
		
		curl_setopt($ch, CURLOPT_URL, "http://192.168.1.15:8090/SendSMS?username=sistemas&password=Deli.3623&".$params);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$respuesta = curl_exec($ch);
		curl_close($ch);
		return $respuesta;
	}
}

/* End of file api_model.php */
/* Location: ./application/models/api_model.php */