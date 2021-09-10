<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Factura_model extends CI_Model {

	function facturas_mexquite(){
		$this->db=$this->load->database('mexquite',true);

		$this->db->limit(300);
		$this->db->order_by("foliofact","DESC");
		$this->db->join('dbo.p_ctesfact','dbo.p_factele.rfc = dbo.p_ctesfact.rfc');
		$r = $this->db->get('p_factele');
		return $r->result();
	}
	function facturas_brasil(){
		$this->db=$this->load->database('brasil',true);

		$this->db->limit(300);
		$this->db->order_by("foliofact","DESC");
		$this->db->join('dbo.p_ctesfact','dbo.p_factele.rfc = dbo.p_ctesfact.rfc');
		$r = $this->db->get('p_factele');
		return $r->result();
	}
	function detalles_factura($sucursal,$folio){
		if($sucursal==1){$this->db=$this->load->database('brasil',true);}
		if($sucursal==2){$this->db=$this->load->database('sanmarcos',true);}
		if($sucursal==3){$this->db=$this->load->database('gastroshop',true);}
		if($sucursal==4){$this->db=$this->load->database('mexquite',true);}
		$this->db->where('factura',$folio);
		$this->db->where('p_factdet.producto !=','');
		$this->db->join('p_prod','p_factdet.producto = p_prod.producto');
		$this->db->order_by('p_factdet.producto');
		$r = $this->db->get('p_factdet');
		$r=$r->result();
		//echo $this->db->last_query();exit;
		//traer el numero de ticket
		$this->db->select('MAX(factura) as ticket');
		$this->db->where('venta',$r[0]->venta);
		$this->db->group_by('venta');
		$r2 = $this->db->get('p_vede');
		$r2=$r2->row();
		$r[0]->ticket=$r2->ticket;
		
		return $r;
	}
	function datos_factura($sucursal,$folio){
		if($sucursal==1){$this->db=$this->load->database('brasil',true);}
		if($sucursal==2){$this->db=$this->load->database('sanmarcos',true);}
		if($sucursal==3){$this->db=$this->load->database('gastroshop',true);}
		if($sucursal==4){$this->db=$this->load->database('mexquite',true);}

		$this->db->where('factura',$folio);
		$r = $this->db->get('p_factele');
		//echo $this->db->last_query();exit;
		return $r->row();
	}
	function facturas_sin_timbre($sucursal){
		$this->db=$this->load->database($sucursal,true);
		$this->db->select("factura as folio, CAST(fecha AS DATE) as fecha, rfc as receptor, importe as total");
		$this->db->where("es_cfdi","S");
		$this->db->group_start();
		$this->db->where("folio_fiscal","");
		$this->db->or_where("folio_fiscal IS NULL");
		$this->db->group_end();
		$this->db->where("estado","1");
		$r = $this->db->get('p_factele');
		return $r->result();
	}
	//facturas del dia
	function factura_diaria($sucursal,$mes,$ano){
		$ultimo_mes=cal_days_in_month(CAL_GREGORIAN, $mes, $ano);
		$this->db=$this->load->database($sucursal,true);
		$this->db->select("p_fact.factura, p_fact.fecha, p_factele.impuesto, p_factele.importe");
		$this->db->join("p_factele","p_fact.foliofact = p_factele.foliofact");
		$this->db->where("estatus","F");
		$this->db->where("tipo_fact","G");
		$this->db->where("p_fact.fecha >=",$ano."-".$mes."-01");
		$this->db->where("p_fact.fecha <=",$ano."-".$mes."-".$ultimo_mes);
		$this->db->order_by("p_fact.fecha","DESC");
		$r = $this->db->get('p_fact');
		return $r->result();
	}
	function anteriores($sucursal,$fecha_ini,$fecha_fin){
		$this->db=$this->load->database($sucursal,true);
		$fecha_ini=sql_fecha($fecha_ini);
		$fecha_fin=sql_fecha($fecha_fin);
		$this->db->select("
			max(p_factdet.factura) as factura,
			max(p_vede.factura) as ticket,
			max(p_vent.id_fecha) as fechaTicket,
			max(fact.fecha) as fechaFactura,
			max(p_vent.suma) as subtotal,
			max(p_vent.impuesto) as impuesto,
			max(p_vent.total) as importe"
		);
		$this->db->join("
			(select factura, fecha from p_fact where fecha>='$fecha_ini' and fecha<='$fecha_fin' and estatus='F' and tipo_fact !='G') fact","p_factdet.factura=fact.factura"
		);
		$this->db->join("p_vent","p_factdet.venta = p_vent.venta");
		$this->db->join("p_vede","p_vent.venta = p_vede.venta");
		$this->db->group_by("p_factdet.factura");
		$r=$this->db->get("p_factdet");
		return $r->result();
	}
}

/* End of file modelName.php */
/* Location: ./application/models/modelName.php */