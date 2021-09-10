<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Traspasos_model extends CI_Model {

	function tipo_salida($suc){
		$this->db=$this->load->database($suc,true);
		$this->db->order_by('clave');
		$r = $this->db->get('p_movs');
		return $r->result();
	}
	function tipo_salida2($suc){
		$this->db=$this->load->database($suc,true);
		$this->db->order_by('clave');
		$this->db->where_in('clave',array('003','004', '035'));
		$r = $this->db->get('p_movs');
		return $r->result();
	}
	function salidas_merc($sucursal,$periodo1,$periodo2,$tipo_salida){
		$this->db=$this->load->database($sucursal,true);
		$this->db->select("p_saod.producto,MAX(p_prod.desc1) as desc1, MAX(p_prod.linea) as linea,MAX(p_prod.proveedor) as proveedor, MAX(p_saod.fecha) as fecha,MAX(p_sucu.nombre) as almacen,MAX(p_tiendas.nombre) as nom_dest, SUM(p_saod.cantidad) as cantidad,SUM(p_saod.importe) as importe,SUM(p_saod.impuesto) as impuesto,SUM((p_saod.importe+p_saod.impuesto)) as total, MAX(p_saod.um) as um, sucur_dest, destino");
		$this->db->join("p_saot","p_saod.salida=p_saot.salida","left");
		$this->db->join("p_sucu","p_saot.sucur_dest=p_sucu.sucursal","left");
		$this->db->join("p_prod","p_saod.producto=p_prod.producto","left");
		$this->db->join("p_tiendas","p_saot.destino=p_tiendas.clave","left");
		$this->db->where("p_saot.clave", $tipo_salida);
		$this->db->where("p_saot.fecha >=", $periodo1);
		$this->db->where("p_saot.fecha <=", $periodo2);
		$this->db->group_by("p_saod.producto,sucur_dest,destino");
		$this->db->order_by("linea");
		$r = $this->db->get("p_saod");
		//echo $this->db->last_query();
		return $r->result();
	}
	function salidas_merc2($sucursal,$periodo1,$periodo2,$tipo_salida){

		$this->db=$this->load->database($sucursal,true);
		$this->db->select("p_saod.producto,MAX(p_prod.desc1) as desc1,MAX(p_prod.linea) as linea, MAX(p_saod.fecha) as fecha, SUM(p_saod.cantidad) as cantidad,SUM(p_saod.importe) as importe,SUM((p_saod.importe+p_saod.impuesto)) as total, MAX(p_saod.um) as um");
		$this->db->join("p_prod","p_saod.producto=p_prod.producto","left");
		
		if($tipo_salida=='T')
			$this->db->where_in("p_saod.clave", array('003','004','035'));
		else
			$this->db->where("p_saod.clave", $tipo_salida);

		$this->db->where("p_saod.fecha >=", $periodo1);
		$this->db->where("p_saod.fecha <=", $periodo2);
		$this->db->group_by("p_saod.producto");
		$res = $this->db->get("p_saod");
		$res = $res->result();
		$productos=array();
		if(count($res)==0){return $res;}
		foreach($res as $r){
			$productos[]=$r->producto;
		}
		//echo $this->db->last_query();
		$this->db->select("producto, SUM(p_vede.cantidad) as cantidad_v , SUM(p_vede.importe+p_vede.impuesto) as total_v");
		$this->db->where("id_fecha BETWEEN '".$periodo1."' and '".$periodo2."'");
		$this->db->group_by("p_vede.producto");
		$res2 = $this->db->get("p_vede");
		$res2 = $res2->result();
		//echo $this->db->last_query();
		foreach($res as &$r){
			$r->total_v=0;
			$r->cantidad_v=0;
			foreach($res2 as $r2)if($r->producto==$r2->producto){
				$r->total_v=$r2->total_v;
				$r->cantidad_v=$r2->cantidad_v;
			}
		}
		return $res;
	}
	function merma($sucursal,$linea,$ejercicio,$tipo){
		//004,035

		//traer los datos agrupados por dia BRASIL
		$this->db=$this->load->database($sucursal,true);

		//siempre ponerle los nombre a cada columna en un SQL
		$this->db->select("p_saod.producto, MAX(p_saod.fecha) as fecha, SUM(p_saod.cantidad) as cantidad,SUM(p_saod.importe) as total, MAX(p_saod.um) as um, MONTH(MAX(p_saod.fecha)) as mes,DAY(MAX(p_saod.fecha)) as dia,");
		$this->db->join("p_saot","p_saod.salida=p_saot.salida");
		$this->db->group_by("p_saod.producto,p_saod.fecha");
		$this->db->where("year(p_saot.fecha) ", $ejercicio);
		$this->db->where_in("p_saot.clave", array('004','035') );
		if($linea!='T'){$this->db->where("p_saod.linea ", $linea);}
		$res = $this->db->get("p_saod");
		//formar arreglo con reporte
		$res = $res->result();
		$arreglo=array();
		foreach ($res as $r) { 
			if($tipo=='c')
				$arreglo[$r->mes][$r->dia][$r->producto]=$r->cantidad;
			if($tipo=='i')
				$arreglo[$r->mes][$r->dia][$r->producto]=$r->total;
		}
		//show_array($arreglo);
		return $arreglo;
	}
	//traer todas las lineas del año
	function merma_ano($ano,$sucursal,$linea){
		$this->db=$this->load->database($sucursal,true);
		$this->db->select("p_saod.producto,max(p_prod.desc1) as descripcion");
		$this->db->join("p_prod","p_saod.producto=p_prod.producto");
		$this->db->join("p_saot","p_saod.salida=p_saot.salida");
		$this->db->where("YEAR(p_saod.fecha)",$ano);
		if($linea!='T'){$this->db->where("p_saod.linea ", $linea);}
		$this->db->where_in("p_saot.clave", array('004','035') );
		$this->db->group_by("p_saod.producto");
		$res=$this->db->get("p_saod");
		//show_array();
		return $res->result();
	}

	//compras recibidas por proveedor
	function carga_usuarios($sucursal,$fecha_ini,$fecha_fin){
		$this->db=$this->load->database($sucursal,true);
		$r = $this->db->query("

			select fecha, max(usuario) as usuario,max(nombre) as nombre, count(*) as recibos, sum(elementos) as elementos,sum(unidades) as unidades,sum(pesos) as pesos,sum(dlls) as dlls
			from (
			select p_precomde.fecha,  p_precomde.id as usuario, count(*) as elementos, MAX(p_usua.nombre) nombre,  sum(cantidad) as unidades, sum(importe+impuestomn) as pesos, sum(importeus+impuestous) as dlls 
			from p_precomde join p_usua ON (p_precomde.id=usuario)
			where p_precomde.fecha between '".sql_fecha($fecha_ini)."' and '".sql_fecha($fecha_fin)."' group by precom, p_precomde.fecha, p_precomde.id
			) as sq group by fecha,usuario order by fecha
			
			");
		return $r->result();
	}
	function transferencias_externas($sucursal,$fecha){
		$this->db=$this->load->database($sucursal,true);
		$this->db->select("count(*) as movimientos, max(p_tiendas.nombre) as tienda, destino, sum(total) as total");
		$this->db->join("p_tiendas", "P_SAOT.destino = p_tiendas.clave");
		$this->db->where("fecha",sql_fecha($fecha));
		$this->db->where_in("P_SAOT.clave",array('043','43'));
		$this->db->group_by("destino");
		return $this->db->get('P_SAOT')->result();
	}
	function transferencias_externas_det($sucursal,$fecha,$destino){
		$this->db=$this->load->database($sucursal,true);
		$this->db->select("salida, total,id,id_hora as hora");
		$this->db->where("fecha",sql_fecha($fecha));
		$this->db->where("destino",$destino);
		$this->db->where_in("P_SAOT.clave",array('043','43'));
		$result = $this->db->get('P_SAOT')->result();
		foreach ($result as &$r) { $r->total = number_format($r->total,2);}
		return $result;
	}
}

/* End of file traspasos_model.php */
/* Location: ./application/models/Reportes/traspasos_model.php */