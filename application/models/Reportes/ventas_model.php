<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ventas_model extends CI_Model {

	function ventas_ano($ano,$sucursal){
		//traer los datos agrupados por dia BRASIL
		$this->db=$this->load->database($sucursal,true);
		//siempre ponerle los nombre a cada columna en un SQL
		$this->db->select("p_vede.linea, MONTH(MAX(p_vede.id_fecha)) as mes,DAY(MAX(p_vede.id_fecha)) as dia, SUM(importe) as total");
		$this->db->where("YEAR(p_vede.id_fecha)",$ano);
		$this->db->group_by("p_vede.id_fecha,p_vede.linea");
		$this->db->order_by("p_vede.id_fecha,p_vede.linea");
		$res = $this->db->get("p_vede");

		//formar arreglo con reporte
		$res = $res->result();
		$arreglo=array();
		foreach ($res as $r) { $arreglo[$r->mes][$r->dia][$r->linea]=$r->total;}
	
		return $arreglo;
	}
	function get_venta_ticket($sucursal,$ticket){
		$this->db=$this->load->database($sucursal,true);
		$this->db->select("total");
		$this->db->where("ticket",$ticket);
		$r = $this->db->get("p_fact");
		if($r->num_rows()>0){
			return $r->row()->total;
		}else{
			return "0";
		}
	}
	//mensual
	function ventas_mes($ano,$mes,$sucursal){
		//traer los datos agrupados por dia BRASIL
		$this->db=$this->load->database($sucursal,true);
		//siempre ponerle los nombre a cada columna en un SQL
		$this->db->select("p_vede.linea, MONTH(MAX(p_vede.id_fecha)) as mes,DAY(MAX(p_vede.id_fecha)) as dia, SUM(importe) as total");
		$this->db->where("YEAR(p_vede.id_fecha)",$ano);
		$this->db->where("MONTH(p_vede.id_fecha)",$ano);
		$this->db->group_by("p_vede.id_fecha,p_vede.linea");
		$this->db->order_by("p_vede.id_fecha,p_vede.linea");
		$res = $this->db->get("p_vede");
		echo $this->db->last_query();
		//formar arreglo con reporte
		$res = $res->result();
		$arreglo=array();
		foreach ($res as $r) { $arreglo[$r->mes][$r->dia][$r->linea]=$r->total;}
	
		return $arreglo;
	}
	function ventas_ano_producto($ano,$sucursal,$producto){
		//traer los datos agrupados por dia BRASIL
		$this->db=$this->load->database($sucursal,true);



		//siempre ponerle los nombre a cada columna en un SQL
		$this->db->select("month(p_vede.id_fecha) as mes, day(p_vede.id_fecha) as dia, p_vede.id_fecha, max(um) as um, sum(p_vede.cantidad) as cantidad, max(precio) as precio, sum(importe) as total");
		$this->db->where("YEAR(p_vede.id_fecha)",$ano);
		$this->db->where("p_vede.producto",$producto);
		$this->db->group_by("p_vede.id_fecha");
		$this->db->order_by("p_vede.id_fecha");
		$res = $this->db->get("p_vede");

		//formar arreglo con reporte
		$res = $res->result();
		$arreglo=array();
		foreach ($res as $r) { $arreglo[$r->mes][$r->dia]=$r;}
	
		return $arreglo;
	}

	//ventas anuales filtrado por linea
		function ventas_ano_departamento($ano,$sucursal,$linea,$subdep,$tipo){
		//traer los datos agrupados por dia BRASIL
		$this->db=$this->load->database($sucursal,true);

		//traer primero todos los productos del departamento
		$this->db->select("producto");
		if($linea!='T'){$this->db->where("linea",$linea);}
		if($subdep!='T'){$this->db->where("subdepto",$subdep);}
		$this->db->where("estatus","A");
		$prod = $this->db->get("p_prod");
		if(count($prod->result())==0) {return;}
		$prod = $prod->result();
		$array_prod = array();
		foreach($prod as $p){$array_prod[]=$p->producto;}

		//siempre ponerle los nombre a cada columna en un SQL
		$this->db->select("p_vede.producto, month(p_vede.id_fecha) as mes, day(p_vede.id_fecha) as dia, p_vede.id_fecha, max(um) as um, sum(p_vede.cantidad) as cantidad, max(precio) as precio, sum(importe) as total");
		$this->db->where("YEAR(p_vede.id_fecha)",$ano);
		$this->db->where_in("p_vede.producto",$array_prod);
		$this->db->group_by("p_vede.producto");
		$this->db->group_by("p_vede.id_fecha");
		$this->db->order_by("p_vede.id_fecha");
		$res = $this->db->get("p_vede");

		//formar arreglo con reporte
		$res = $res->result();
		$arreglo=array();
		if($tipo=='c'){foreach ($res as $r) { $arreglo[$r->mes][$r->dia][$r->producto]=$r->cantidad;}}
		if($tipo=='i'){foreach ($res as $r) { $arreglo[$r->mes][$r->dia][$r->producto]=$r->total;}}
		
	
		return $arreglo;
	}
	function get_productos_dep($sucursal,$linea,$subdep){
		//traer los datos agrupados por dia BRASIL
		$this->db=$this->load->database($sucursal,true);

		//traer primero todos los productos del departamento
		$this->db->select("producto,desc1");
		if($linea!='T'){$this->db->where("linea",$linea);}
		if($subdep!='T'){$this->db->where("subdepto",$subdep);}
		$this->db->where("estatus","A");
		$prod = $this->db->get("p_prod");
		return $prod->result();
	}
	//traer todas las lineas del año
	function lineas_ano($ano,$sucursal){
		$this->db=$this->load->database($sucursal,true);
		$this->db->select("p_vede.linea, MAX(p_line.nombre) as descripcion");
		$this->db->where("YEAR(p_vede.id_fecha)",$ano);
		$this->db->join("p_line", "p_vede.linea=p_line.linea");
		$this->db->group_by("p_vede.linea");
		$this->db->order_by("p_vede.linea");
		$res = $this->db->get("p_vede");
		return $res->result();
	}

	//traer todas las lineas del mes
	function lineas_mes($ano,$mes,$sucursal){
		$this->db=$this->load->database($sucursal,true);
		$this->db->select("p_vede.linea, MAX(p_line.nombre) as descripcion");
		$this->db->where("YEAR(p_vede.id_fecha)",$ano);
		$this->db->where("MONTH(p_vede.id_fecha)",$mes);
		$this->db->join("p_line", "p_vede.linea=p_line.linea");
		$this->db->group_by("p_vede.linea");
		$this->db->order_by("p_vede.linea");
		$res = $this->db->get("p_vede");
		echo $this->db->last_query();
		return $res->result();
	}

	//traer la lista de productos vendidos en el año
	function get_productos_mexquite($ano,$lineas){
		$this->db=$this->load->database("mexquite",true);
		$this->db->select("p_vede.producto, max(desc1) as descripcion");
		$this->db->where_in("p_vede.linea",$lineas);
		$this->db->where("year(fecha)",$ano);
		$this->db->join("p_prod", "p_vede.producto=p_prod.producto");
		$this->db->group_by("p_vede.producto");
		$res = $this->db->get("p_vede");
		return $res->result();
	}

	function get_ventas_vs_ventas($sucursal,$fecha,$fecha2){
		$this->db=$this->load->database($sucursal,true);
		
		//lista de productos
		$this->db->select("producto,max(descrip) as descripcion,max(linea) as linea");
		$this->db->where("fecha",sql_fecha($fecha));
		$this->db->or_where("fecha",sql_fecha($fecha2));
		$this->db->group_by("producto");
		$productos = $this->db->get("p_vede");
		$productos=$productos->result();
		//show_array($productos);
		//ventas actuales
		$this->db->select("p_vede.producto, max(descrip) as descripcion, sum(cantidad) as cantidad, '0' as cantidad2, '0' as venta2, (SUM(importe)+SUM(impuesto)) as venta");
		$this->db->where("fecha",sql_fecha($fecha));
		$this->db->group_by("p_vede.producto");
		$res = $this->db->get("p_vede");
		$res=$res->result();

		//ventas pasadas
		$this->db->select("p_vede.producto, max(descrip) as descripcion, sum(cantidad) as cantidad, '0' as cantidad2, '0' as venta2, (SUM(importe)+SUM(impuesto)) as venta");
		$this->db->where("fecha",sql_fecha($fecha2));
		$this->db->group_by("p_vede.producto");
		$res2 = $this->db->get("p_vede");
		$res2=$res2->result();

		//ciclo anidado
		foreach ($productos as &$p){
			$p->venta=0;
			$p->venta2=0;
			$p->cantidad=0;
			$p->cantidad2=0;
			foreach ($res2 as $r)if($p->producto==$r->producto){
				$p->venta=$r->venta;
				$p->cantidad=$r->cantidad;
			}
			foreach ($res as $r2)if($p->producto==$r2->producto){
				$p->venta2=$r2->venta;
				$p->cantidad2=$r2->cantidad;
			}
		}

		return $productos;
	}

	/* conglomerado de venta de tacos */
	function ventas_tacos($ano,$lineas){
		$this->db=$this->load->database("mexquite",true);
		$this->db->select("month(fecha) as mes,day(fecha) as dia, sum(cantidad) as vendidos, p_vede.producto");
		$this->db->where_in("p_vede.linea",$lineas);
		$this->db->where("year(fecha)",$ano);
		$this->db->group_by("month(fecha), day(fecha), p_vede.producto");
		$this->db->order_by("mes, dia, vendidos", "DESC");
		$res = $this->db->get("p_vede");
		$res = $res->result();
		$arreglo = array();

		foreach ($res as $r) {
			$arreglo[$r->mes][$r->dia][$r->producto]=$r->vendidos;
		}
		return $arreglo;
	}

	/*consultar las lineas de mexquite */
	function lineas_mexquite(){
		$this->db=$this->load->database("mexquite",true);
		$r = $this->db->get("p_line");
		return $r->result();
	}

	function get_costo_venta($sucursal,$fecha1,$fecha2){
		$this->db=$this->load->database($sucursal,true);
		$this->db->select("p_vede.producto,MAX(p_prod.desc1) as desc1,MAX(p_vede.um) as um,SUM(p_vede.ctoult*cantidad) as costo,SUM(importe) as importe, SUM(cantidad) as cantidad, MAX(p_vede.precio) as precio, MAX(p_vede.ctoult) as ctoult");
		$this->db->join("p_prod", "p_vede.producto=p_prod.producto");
		$this->db->where("p_vede.fecha >=",$fecha1);
		$this->db->where("p_vede.fecha <=",$fecha2);
		$this->db->where("p_vede.producto !=",'CANAL');
		$this->db->group_by("p_vede.producto");
		$r = $this->db->get("p_vede");
		return $r->result();
	}
	function get_costo_venta_integrado($sucursal,$marca){
		$this->db=$this->load->database($sucursal,true);
		$this->db->select("producto, um,desc1, costo_inte, precio1");
		if($marca!=0)
			$this->db->where("marca",$marca);
		$this->db->where("estatus","A");
		return $this->db->get("p_prod")->result();
		
	}
	function get_detallado_ventas($sucursal,$fecha1,$fecha2,$dep,$subdep){
		$this->db=$this->load->database($sucursal,true);
		$this->db->select("p_vede.producto,MAX(p_prod.desc1) as desc1,MAX(p_vede.um) as um,SUM(p_vede.ctoult*cantidad) as costo,SUM(importe) as importe, SUM(cantidad) as cantidad, MAX(p_vede.precio) as precio, MAX(p_vede.ctoult) as ctoult");
		$this->db->join("p_prod", "p_vede.producto=p_prod.producto");
		$this->db->where("p_vede.fecha >=",$fecha1);
		$this->db->where("p_vede.fecha <=",$fecha2);
		if($dep!='T')
			$this->db->where("p_vede.linea",$dep);
		if($subdep!='T')
			$this->db->where("p_vede.subdepto",$subdep);
		$this->db->where("p_vede.producto !=",'CANAL');
		$this->db->group_by("p_vede.producto");
		$r = $this->db->get("p_vede");
		//echo $this->db->last_query();
		//show_array($r->result());
		return $r->result();
	}
	function get_detallado_producto($sucursal,$fecha1,$fecha2,$producto){
		$this->db=$this->load->database($sucursal,true);
		$this->db->select("p_vede.producto,desc1,p_vede.um,p_vede.ctoult,(p_vede.ctoult*cantidad) as costo, importe, cantidad,p_vede.precio,p_vede.factura,p_vede.fecha");
		$this->db->join("p_prod", "p_vede.producto=p_prod.producto");
		$this->db->where("p_vede.fecha >=",$fecha1);
		$this->db->where("p_vede.fecha <=",$fecha2);
		$this->db->where("p_vede.producto",$producto);
		$r = $this->db->get("p_vede");
		//echo $this->db->last_query();
		//show_array($r->result());
		return $r->result();
	}
	function get_detalle_ticket($ticket,$sucursal){
		$this->db=$this->load->database($sucursal,true);
		$this->db->select("producto, descrip, um, importe, (importe+impuesto) as total, cantidad, precio, impuesto, venta ");
		$this->db->where("p_vede.factura",$ticket);
		return $this->db->get("p_vede")->result();
	}
	function get_venta($venta,$sucursal){
		$this->db=$this->load->database($sucursal,true);
		$this->db->where("venta",$venta);
		return $this->db->get("p_vent")->row();
	}
	function get_agrupado_ventas($sucursal,$fecha1,$fecha2){
		$this->db=$this->load->database($sucursal,true);
		$this->db->select("p_vede.linea,MAX(p_prod.desc1) as desc1,MAX(p_vede.um) as um,SUM(p_vede.ctoult*cantidad) as costo,SUM(importe) as importe,");
		$this->db->join("p_prod", "p_vede.producto=p_prod.producto");
		$this->db->where("p_vede.fecha >=",$fecha1);
		$this->db->where("p_vede.fecha <=",$fecha2);
		$this->db->where("p_vede.producto !=",'CANAL');
		$this->db->group_by("p_vede.linea");
		$r = $this->db->get("p_vede");
		//echo $this->db->last_query();exit();
		//show_array($r->result());
		return $r->result();
	}

	//diario de ventas
	function get_diario_ventas($mes,$ano,$sucursales){
		$array_ventas	= array();
		$dias_mes		= cal_days_in_month(CAL_GREGORIAN, $mes,$ano);
		$mes 			= str_pad($mes, 2, "0", STR_PAD_LEFT);

		foreach($sucursales as $suc){
			$this->db=$this->load->database($suc,true);
			//ventas
			$this->db->select('fecha, sum(total) as venta');
			$this->db->where('fecha >=',$ano.'-'.$mes.'-01');
			$this->db->where('fecha <=',$ano.'-'.$mes.'-'.$dias_mes);
			$this->db->where('max_depto',NULL);
			$this->db->group_by('fecha');
			$res=$this->db->get('p_fact');
			foreach ($res->result() as $r){ $array_ventas[$suc][$r->fecha]['venta']=$r->venta; }
			//echo $this->db->last_query()."<br>";
			//devoluciones
			$this->db->select('fecha, sum(total) as devolucion');
			$this->db->where('fecha >=',$ano.'-'.$mes.'-01');
			$this->db->where('fecha <=',$ano.'-'.$mes.'-'.$dias_mes);
			$this->db->group_by('fecha');
			$res=$this->db->get('p_devo');
			//echo $this->db->last_query()."<br>";

			foreach ($res->result() as $r){
				$venta=0;
				if(isset($array_ventas[$suc][$r->fecha]['venta'])){$venta=$array_ventas[$suc][$r->fecha]['venta'];}
				$array_ventas[$suc][$r->fecha]['venta']=$venta-$r->devolucion; }
		}
		//show_array($array_ventas);
		return $array_ventas;
	}
	//reporte dash
	function get_ventas_mensual($anos,$suc){
		$this->db=$this->load->database($suc,true);
		
		//ventas
		$this->db->select('year(fecha) as ano,month(fecha)as mes,sum(total) as venta');
		$this->db->where_in('year(fecha)',$anos);
		$this->db->where('max_depto',NULL);
		$this->db->group_by('month(fecha),year(fecha)');
		$res=$this->db->get('p_fact');
		foreach ($res->result() as $r){ $array_ventas[$r->ano][$r->mes]=$r->venta;}
		//devoluciones
		$this->db->select('year(fecha) as ano,month(fecha)as mes,sum(total) as devolucion');
		$this->db->where_in('year(fecha)',$anos);
		$this->db->group_by('month(fecha),year(fecha)');
		$res=$this->db->get('p_devo');
		//merch
		foreach ($res->result() as $r){
			$array_ventas[$r->ano][$r->mes]=$array_ventas[$r->ano][$r->mes]-$r->devolucion;
		}
		return $array_ventas;
	}

	function get_venta_dia($sucursal,$fecha){
		$this->db=$this->load->database($sucursal,true);
		$this->db->select('sum(total) as venta');
		$this->db->where('fecha',$fecha);
		$this->db->where('max_depto',NULL);
		$this->db->group_by('fecha');
		$res=$this->db->get('p_fact');
		$venta=0;if($res->num_rows()>0){$venta=$res->row()->venta;}
		
		$this->db->select('fecha, sum(total) as devolucion');
		$this->db->where('fecha',$fecha);
		$this->db->group_by('fecha');
		$res=$this->db->get('p_devo');
		$devolucion=0;if($res->num_rows()>0){$devolucion=$res->row()->devolucion;}
		return $venta-$devolucion;
		
	}
	//funcion de precortes, realizado por hora comparado con dias anteriores
	function get_pre_corte($sucursales,$fecha,$hora,$periodo){
		$resultado = array();
		//calculo de dias segun periodo
		$fechas=periodos_fechas($fecha,$periodo);
		foreach($sucursales as $s){
			$this->db=$this->load->database($s,true);
			$resultado[$s]['f1'] = $fechas[0];
			$resultado[$s]['f2'] = $fechas[1];
			$resultado[$s]['f3'] = $fechas[2];
			$resultado[$s]['v1'] = $this->db->query("select sum(total) as v1 from  p_fact where id_fecha='".sql_fecha($fechas[0])."' and id_hora<'".$hora."'")->row()->v1;
			//echo $this->db->last_query()."<br><br>";
			$resultado[$s]['v2'] = $this->db->query("select sum(total) as v2 from  p_fact where id_fecha='".sql_fecha($fechas[1])."' and id_hora<'".$hora."'")->row()->v2;
			//echo $this->db->last_query()."<br><br>";
			$resultado[$s]['v3'] = $this->db->query("select sum(total) as v3 from  p_fact where id_fecha='".sql_fecha($fechas[2])."' and id_hora<'".$hora."'")->row()->v3;
			//echo $this->db->last_query()."<br><br>";
		}
		return $resultado;
		/*
		
		select sum(total)  from  p_fact where id_fecha='2020-03-09' and id_hora<'16:00:00'
		select sum(total)  from  p_fact where id_fecha='2020-03-02' and id_hora<'16:00:00'
		*/
	}
	function get_formas_pago($sucursales,$fecha1,$fecha2){
		$resultado = array();
		foreach($sucursales as $s){
			$this->db=$this->load->database($s,true);
			$this->db->select('p_pagadet.id_fecha,importe,p_pagadet.clave,p_formapago.descrip');
			$this->db->join('p_formapago','p_pagadet.clave=p_formapago.clave');
			$this->db->where('p_pagadet.id_fecha >=', sql_fecha($fecha1));
			$this->db->where('p_pagadet.id_fecha <=', sql_fecha($fecha2));
			$this->db->order_by('id_fecha');
			$resultado[$s] = $this->db->get('p_pagadet')->result();
			//echo $this->db->last_query();
			//select p_pagadet.id_fecha,importe,p_pagadet.clave,p_formapago.descrip from p_pagadet JOIN p_formapago ON (p_pagadet.clave = p_formapago.clave) and p_pagadet.id_fecha = '2020-03-23'
		}
		return $resultado;
	}
	function formas_pago(){
		$this->db=$this->load->database("brasil",true);
		return $this->db->get('p_formapago')->result();
	}
	function get_ventas_sd($sucursal,$fecha1,$fecha2){
		$this->db=$this->load->database($sucursal,true);
		$r = $this->db->query("select id_fecha, count(*)as cantidad, sum(total)as total from p_vent where id_fecha between'".sql_fecha($fecha1)."' and '".sql_fecha($fecha2)."' and venta IN(
select venta from p_vede where id_fecha between'".sql_fecha($fecha1)."' and '".sql_fecha($fecha2)."' and producto IN ('ENVIO','VXEL') group by venta
) group by id_fecha order by id_fecha");
		return $r->result();

	}

	function get_ventas_sd2($sucursal,$fecha1,$fecha2){
		$this->db=$this->load->database($sucursal,true);
		$r = $this->db->query("select linea, count(*)as cantidad, sum(importe+impuesto)as total from p_vede where id_fecha between'".sql_fecha($fecha1)."' and '".sql_fecha($fecha2)."' and venta IN(select venta from p_vede where id_fecha between'".sql_fecha($fecha1)."' and '".sql_fecha($fecha2)."' and producto IN ('ENVIO','VXEL') group by venta) group by linea");
		return $r->result();

	}

	function get_ventas_detalladas($sucursal,$fecha1,$fecha2,$linea){
		$this->db=$this->load->database($sucursal,true);
		$query = $this->db->query("select id_fecha, factura, producto, descrip, um, cantidad from p_vede where linea='".$linea."' and fecha between '".$fecha1."' and '".$fecha2."' order by id_fecha");
		return $query->result();
	}
}

/* End of file ventas_model.php */
/* Location: ./application/models/Reportes/ventas_model.php */