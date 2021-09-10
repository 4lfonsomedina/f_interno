<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class InventarioModel extends CI_Model {

	function get_solicitudes($status){
		$this->db->where('status',$status);
		$this->db->order_by('id_solicitud','DESC');
		$solicitudes = $this->db->get('solicitudes_merc')->result();
		if(count($solicitudes)>0)
		foreach ($solicitudes as &$s){
			$this->db->where('id_solicitud',$s->id_solicitud);
			$s->detalles = $this->db->get('solicitudes_det')->result();
		}
		return $solicitudes;
	}

	function update_status($id_solicitud){
		$this->db->where('id_solicitud',$id_solicitud);
		$this->db->update('solicitudes_merc',array(
			'status'=>1,
			'fecha2'=>date('Y-m-d H:i:s'),
			'proceso'=>$this->session->userdata('nombre')
		));
	}

	function get_solicitud($id_solicitud){
		$this->db->where('id_solicitud',$id_solicitud);
		$solicitud = $this->db->get('solicitudes_merc')->row();
		$this->db->where('id_solicitud',$solicitud->id_solicitud);
		$solicitud->detalles = $this->db->get('solicitudes_det')->result();
		return $solicitud;
	}
	function get_producto_brasil($producto){
		$this->db=$this->load->database('brasil',true);
		$this->db->select("producto,desc1,um");
		$this->db->where('producto',$producto);
		return $this->db->get('p_prod')->result();
	}
	function get_producto_brasil_desc($desc){
		$this->db=$this->load->database('brasil',true);
		$this->db->select("producto,desc1,um");
		$this->db->like('desc1',$desc);
		return $this->db->get('p_prod')->result();
	}

	function crear_solicitud($solicitante){
		$this->db->insert('solicitudes_merc', array(
			"solicitante" => $solicitante,
			"fecha1" => date("Y-m-d H:i:s")
		));
   		return $this->db->insert_id();
	}

	function crear_solicitud_det($data){
		$this->db->insert_batch('solicitudes_det', $data); 
	}

	function crear_archivo($id_solicitud){
		$solicitud = $this->get_solicitud($id_solicitud);
		$texto="";
		foreach($solicitud->detalles as $d) {
				$texto.=$d->producto."\t\t".$d->cantidad."\r\n";
		}

		$fh = fopen("D:\\Avattia\\traslados\\".folio_solicitud($id_solicitud).".txt", 'w') or die("Se produjo un error al crear el archivo");
		fwrite($fh, $texto) or die("No se pudo escribir en el archivo");
  		fclose($fh);
	}
}

/* End of file InventarioModel.php */
/* Location: ./application/models/InventarioModel.php */