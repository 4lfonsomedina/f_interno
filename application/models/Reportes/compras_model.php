<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Compras_model extends CI_Model {

	//traer todos los proveedores de brasil
	function get_proveedores(){
		$this->db=$this->load->database("brasil",true);
		$res = $this->db->get("p_prov");
		return $res->result();
	}
	function get_productos(){
		$this->db=$this->load->database("brasil",true);
		$this->db->select("producto,desc1");
		$res = $this->db->get("p_prod");
		return $res->result();
	}

	function compras_lineas(){

	}
	function get_ventas_especial($sucursales,$fecha_ini,$fecha_fin,$filtro,$filtro2,$codigo){
		$result = array();
		$fecha_ini_2 = resta_un_ano($fecha_ini);
		$fecha_fin_2 = resta_un_ano($fecha_fin);
		$fecha_ini = sql_fecha($fecha_ini);
		$fecha_fin = sql_fecha($fecha_fin);
		$fecha_ini_2 = sql_fecha($fecha_ini_2);
		$fecha_fin_2 = sql_fecha($fecha_fin_2);

		$this->db=$this->load->database("brasil",true);
		//traer productos que entren dentro del filtro
		$this->db->select("producto,um,desc1 as descripcion,costo_ulti");
		if($filtro=='proveedor'){ $this->db->where("proveedor",$codigo);}
		if($filtro=='marca'){ $this->db->where("marca",$codigo);}
		if($filtro=='producto'){ $this->db->where("producto",$codigo);}
		if($filtro=='departamento'){ $this->db->where("linea",$codigo);}
		$productos = $this->db->get("p_prod")->result();

		
		//echo $this->db->last_query();
		$array_prod=array();
		$array_um=array();
		foreach($productos as $p){
			$array_prod[]=$p->producto;
			$result[$p->producto]['producto']=$p->producto;
			$result[$p->producto]['descrip']=$p->descripcion;
			$result[$p->producto]['um']=$p->um;
			$result[$p->producto]['costo_ulti']=$p->costo_ulti;
			$result[$p->producto]['localbrasil']=0;
			$result[$p->producto]['localsanmarcos']=0;
			$result[$p->producto]['localgastroshop']=0;
		}
		//show_array($result);


		//en caso de pedir conversion a ultima compra
		if($filtro2=="compra"){
			//ordenes de compra
			$this->db->select("max(compra) as compra");
			$this->db->where_in("producto",$array_prod);
			$this->db->group_by("producto");
			$compras = $this->db->get("p_compde")->result();
			$array_comp=array();
			foreach($compras as $c){$array_comp[]=$c->compra;}
			//echo $this->db->last_query()."<br><br>";

			if(count($array_comp)>0){
				//traer ultima unidad y factor de todos los productos
				$this->db->select("producto,um,(cantidad/cantfact)as factor, costofact");
				$this->db->where_in("compra",$array_comp);
				$this->db->where_in("producto",$array_prod);
				$r3 = $this->db->get("p_compde")->result();
				//echo $this->db->last_query()."<br><br>";
				//show_array($r3);
			}
		}


		if(count($array_prod)>0)foreach($sucursales as $s){
			$this->db=$this->load->database($s,true);
			
			//traigo las ventas del periodo
			$this->db->select("producto, SUM(cantidad) as cantidad");
			$this->db->group_by("producto");
			$this->db->where("fecha >=",$fecha_ini);
			$this->db->where("fecha <=",$fecha_fin);
			$this->db->where_in("producto",$array_prod);
			$this->db->group_by("producto");
			$r1 = $this->db->get("p_vede")->result();

			//traigo las ventas del periodo -1 año
			$this->db->select("producto, SUM(cantidad) as cantidad");
			$this->db->group_by("producto");
			$this->db->where("fecha >=",$fecha_ini_2);
			$this->db->where("fecha <=",$fecha_fin_2);
			$this->db->where_in("producto",$array_prod);
			$this->db->group_by("producto");
			$r2 = $this->db->get("p_vede")->result();
			//echo $this->db->last_query();

			if($s=='brasil'){$s='localbrasil';}
			if($s=='sanmarcos'){$s='localsanmarcos';}
			if($s=='gastroshop'){$s='localgastroshop';}

			foreach($r1 as $r){
				$result[$r->producto][$s]=$r->cantidad;
				if($filtro2=="compra"){
					foreach($r3 as $r_3)if("x".$r->producto=="x".$r_3->producto){
						$result[$r->producto]['umc']=$r_3->um;
						$result[$r->producto]['umf']=$r_3->factor;
						$result[$r->producto]['cf']=$r_3->costofact;
					}
				}	
				foreach($r2 as $r_2)if("x".$r->producto=="x".$r_2->producto){
					$result[$r_2->producto][$s."2"]=$r_2->cantidad;
				}
			}
			
		}
		return $result;
	}

	function tabla_busqueda_filtro($filtro){
		$this->db=$this->load->database("localbrasil",true);
		if($filtro=="proveedor"){
			$this->db->select("proveedor,nombre");
			return $this->db->get("p_prov")->result();
		}
		if($filtro=="marca"){
			$this->db->select("marca,nombre");
			return $this->db->get("p_marc")->result();
		}
		if($filtro=="producto"){
			$this->db->select("producto,desc1,um");
			$this->db->where("estatus","A");
			return $this->db->get("p_prod")->result();
		}
		if($filtro=="departamento"){
			$this->db->select("linea,nombre");
			return $this->db->get("p_line")->result();
		}
	}

	//traer todas las lineas del año
	function lineas_ano($ano,$sucursal){
		$this->db=$this->load->database($sucursal,true);
		$this->db->select("p_compde.linea, MAX(p_line.nombre) as descripcion");
		$this->db->where("YEAR(p_compde.id_fecha)",$ano);
		$this->db->join("p_line", "p_compde.linea=p_line.linea");
		$this->db->group_by("p_compde.linea");
		$this->db->order_by("p_compde.linea");
		$res = $this->db->get("p_compde");
		return $res->result();
	}
	//traer todas las compras del del año
	function compras_ano($ano,$sucursal){
		//traer los datos agrupados por dia BRASIL
		$this->db=$this->load->database($sucursal,true);
		//siempre ponerle los nombre a cada columna en un SQL
		$this->db->select("linea, MONTH(MAX(id_fecha)) as mes,DAY(MAX(id_fecha)) as dia,SUM(importe) as total");
		$this->db->where("YEAR(p_compde.id_fecha)",$ano);
		$this->db->group_by("id_fecha,linea");
		$this->db->order_by("id_fecha,linea");
		$res = $this->db->get("p_compde");

		//formar arreglo con reporte
		$res = $res->result();
		$arreglo=array();
		foreach ($res as $r) { $arreglo[$r->mes][$r->dia][$r->linea]=$r->total;}
	
		return $arreglo;
	}

	//traer todas las proveedores del año
	function proveedores_ano($ano,$sucursal){
		$this->db=$this->load->database($sucursal,true);
		$this->db->select("p_compde.proveedor, MAX(p_prov.nombre) as nombre");
		$this->db->where("YEAR(p_compde.id_fecha)",$ano);
		$this->db->join("p_prov", "p_compde.proveedor=p_prov.proveedor");
		$this->db->group_by("p_compde.proveedor");
		$this->db->order_by("p_compde.proveedor");
		$res = $this->db->get("p_compde");
		//echo $this->db->last_query();exit;
		return $res->result();
	}
	//traer todas las compras del del año por proveedor
	function compras_proveedores_ano($ano,$sucursal){
		//seleccion de sucursal
		$this->db=$this->load->database($sucursal,true);
		//siempre ponerle los nombre a cada columna en un SQL
		$this->db->select("proveedor, MONTH(MAX(id_fecha)) as mes,DAY(MAX(id_fecha)) as dia,SUM(importe) as total");
		$this->db->where("YEAR(p_compde.id_fecha)",$ano);
		$this->db->group_by("id_fecha,proveedor");
		$this->db->order_by("id_fecha,proveedor");
		$res = $this->db->get("p_compde");

		//formar arreglo con reporte
		$res = $res->result();
		$arreglo=array();
		foreach ($res as $r) { $arreglo[$r->mes][$r->dia][$r->proveedor]=$r->total;}
	
		return $arreglo;
	}

	//compras detalladas por proveedor todo el ejercicio
	function compras_det_proveedor($ano,$sucursal,$proveedor){
		//seleccion de sucursal
		$this->db=$this->load->database($sucursal,true);
		$this->db->where("YEAR(fecha)",$ano);
		$this->db->where("proveedor",$proveedor);
		$this->db->select("fecha,um,compra,producto,desc1 as desc,cantidad, costo, importe, impuestomn as impuesto");
		$this->db->order_by("fecha");
		$r = $this->db->get("p_compde");

		//echo $this->db->last_query();exit;
		return $r->result();
	}

	function compras_det_proveedor2($ano,$sucursal,$proveedor){
		//seleccion de sucursal
		$this->db=$this->load->database($sucursal,true);
		$this->db->select("proveedor, max(producto) as producto,max(desc1) as descripcion ,max(um) as um,sum(cantidad) as cantidad, sum(importe) as importe, sum(impuestomn) as impuesto, (sum(importe)+sum(impuestomn)) as total");
		$this->db->where("proveedor",$proveedor);
		$this->db->where("year(fecha)",$ano);
		$this->db->group_by('proveedor, producto');
		$r = $this->db->get('p_compde');
		//echo $this->db->last_query();exit;
		return $r->result();
	}

	//compras detalladas por productos todo el ejercicio
	function compras_det_producto($ano,$sucursal,$producto,$moneda){
		//seleccion de sucursal
		$this->db=$this->load->database($sucursal,true);
		
		$this->db->join("p_prov", "p_compde.proveedor=p_prov.proveedor");
		$this->db->where("YEAR(p_compde.fecha)",$ano);
		$this->db->where("p_compde.producto",$producto);
		//filtro de moneda para traer solo dolares o solo pesos
		if($moneda!=='todo'){
			$this->db->select("p_compde.fecha,p_compde.compra,p_compde.proveedor,p_prov.nombre,p_compde.cantidad,p_compde.costous as costo,p_compde.importeus as importe");
			$this->db->where("p_compde.moneda",$moneda);
		}else{
			$this->db->select("p_compde.fecha,p_compde.compra,p_compde.proveedor,p_prov.nombre,p_compde.cantidad,p_compde.costo,p_compde.importe");
		}
		$this->db->order_by("p_compde.fecha");
		$r = $this->db->get("p_compde");

		return $r->result();
	}

	//function que trae las compras aunado a los proveedores a los que se le compro
	//compras detalladas por productos todo el ejercicio
	function compras_det_producto2($ano,$sucursal,$linea,$subdep,$moneda){
		//seleccion de sucursal
		$this->db=$this->load->database($sucursal,true);

		//traer primero todos los productos del departamento
		$this->db->select("producto,desc1");
		if($linea!='T'){$this->db->where("linea",$linea);}
		if($subdep!='T'){$this->db->where("subdepto",$subdep);}
		$this->db->where("estatus","A");
		$prod = $this->db->get("p_prod");
		if(count($prod->result())==0) {return;}

		$prod = $prod->result();
		$array_prod = array();
		foreach($prod as $p){$array_prod[]=$p->producto;}
		$this->db->join("p_prov", "p_compde.proveedor=p_prov.proveedor");
		$this->db->where("YEAR(p_compde.fecha)",$ano);
		$this->db->where_in("p_compde.producto",$array_prod);
		//filtro de moneda para traer solo dolares o solo pesos
		if($moneda!=='todo'){
			$this->db->select("p_compde.producto,p_compde.fecha,p_compde.compra,p_compde.proveedor,p_prov.nombre,p_compde.cantidad,p_compde.costous as costo,p_compde.importeus as importe");
			$this->db->where("p_compde.moneda",$moneda);
		}else{
			$this->db->select("p_compde.producto,p_compde.fecha,p_compde.compra,p_compde.proveedor,p_prov.nombre,p_compde.cantidad,p_compde.costo,p_compde.importe");
		}
		$this->db->order_by("p_compde.producto");
		$this->db->order_by("p_compde.fecha");
		$res = $this->db->get("p_compde");
		$res = $res->result();

		foreach($prod as &$p){
			$p->proveedor=array();
			$contador=0;
			foreach ($res as $r)if($r->producto==$p->producto){
				$p->proveedor[$contador]['producto'] 	= $r->producto;
				$p->proveedor[$contador]['fecha'] 		= $r->fecha;
				$p->proveedor[$contador]['compra'] 		= $r->compra;
				$p->proveedor[$contador]['proveedor']	= $r->proveedor;
				$p->proveedor[$contador]['nombre'] 		= $r->nombre;
				$p->proveedor[$contador]['cantidad'] 	= $r->cantidad;
				$p->proveedor[$contador]['costo'] 		= $r->costo;
				$p->proveedor[$contador]['importe'] 	= $r->importe;
				$contador++;
			}
		}
		return $prod;
	}

	//reporte compras vs ventas todas las sucursales
	function get_comprasvsventas($tipo,$marca,$fecha1,$fecha2,$fecha3,$fecha4){
		//consultamos las compras echas en brasil
		$this->db=$this->load->database('brasil',true);
		$this->db->select("p_compde.producto,MAX(p_prod.desc1) as prod_descrip,MAX(p_prod.um) as prod_um,SUM(p_compde.cantidad) as cant_compra, SUM(p_compde.importe) as imp_compra");
		$this->db->join('p_prod',"p_compde.producto = p_prod.producto");
		$this->db->where('p_compde.proveedor !=', '000');
		$this->db->where('p_compde.fecha >=', $fecha1);
		$this->db->where('p_compde.fecha <=', $fecha2);
		if($marca!='T'){$this->db->where('p_prod.marca',$marca);}
		if($tipo==0){ $this->db->where('p_compde.linea', "005"); }
		elseif($tipo==1){ $this->db->where('p_compde.linea', "002"); }
		elseif($tipo==2){ $this->db->where('p_compde.linea', "001"); }
		elseif($tipo==3){ $this->db->where('p_compde.proveedor', "515"); }
		else{ $this->db->where('p_compde.linea', $tipo); }
		$this->db->group_by('p_compde.producto');
		$this->db->order_by('p_compde.producto');
		$resultado = $this->db->get('p_compde');
		//echo $this->db->last_query();
		////echo $this->db->last_query()."<br><br>";
		if($resultado->num_rows()==0) return array();
		$resultado=$resultado->result();

		//extraigo todos los numeros de cliente
		$productos=array();
		foreach($resultado as $r)
			$productos[]=$r->producto;

		//consulto las distribuciones entre las sucursales
		$this->db->select("p_saod.producto,SUM(p_saod.cantidad) salida,sum(p_saod.importe) as salida2,CASE WHEN max(p_saot.destino) in ('05') THEN 1 ELSE 0 END as cocina, CASE WHEN max(p_saot.destino) in ('02') THEN 1 ELSE 0 END as sanmarcos, CASE WHEN max(p_saot.destino) in ('04') THEN 1 ELSE 0 END as gastro, CASE WHEN max(p_saot.destino) in ('03') THEN 1 ELSE 0 END as mexquite,");
		$this->db->join("p_saot","p_saod.salida = p_saot.salida");
		$this->db->where('p_saot.fecha >=', $fecha1);
		$this->db->where('p_saot.fecha <=', $fecha2);
		$this->db->where("p_saod.clave NOT IN('004','005','007','009','026','027','032','033','344','035','049','050','051','052','053','003','007','056','019')");
		$this->db->where_in("p_saod.producto",$productos);
		$this->db->group_by("p_saod.producto, p_saot.destino");
		$transferencias = $this->db->get('p_saod');
		$transferencias = $transferencias->result();


		//consulto las ventas del producto en BRASIL
		$this->db=$this->load->database('brasil',true);
		$this->db->select("p_vede.producto, SUM(p_vede.cantidad) as ventas_BR, SUM(p_vede.importe) as importe_BR");
		$this->db->where('p_vede.fecha >=', $fecha3);
		$this->db->where('p_vede.fecha <=', $fecha4);
		$this->db->where_in("p_vede.producto",$productos);
		$this->db->group_by('p_vede.producto');
		$resultadoBR = $this->db->get('p_vede');
		////echo $this->db->last_query()."<br><br>";
		$resultadoBR=$resultadoBR->result();
		$this->db->select("p_saod.producto, sum(p_saod.cantidad) as salida,sum(p_saod.importe) as salida2, CASE WHEN max(p_saod.clave) in ('004','035') THEN 1 ELSE 0 END as merma, CASE WHEN max(p_saod.clave) in ('003') THEN 1 ELSE 0 END as donativo, CASE WHEN max(p_saod.clave) in ('056') THEN 1 ELSE 0 END as chef, CASE WHEN max(p_saod.clave) in ('019') THEN 1 ELSE 0 END as asador");
		$this->db->where("p_saod.fecha between '2019-02-25' AND '2019-03-01' and clave in ('004','005','007','009','026','027','032','033','344','035','049','050','051','052','053','003','007','056','019')");
		$this->db->where_in("p_saod.producto",$productos);
		$this->db->group_by("p_saod.producto,p_saod.clave");
		$movimientosBR = $this->db->get('p_saod');
		$movimientosBR=$movimientosBR->result();

		//consulto las ventas del producto en SanMarcos
		$this->db=$this->load->database('sanmarcos',true);
		$this->db->select("p_vede.producto, SUM(p_vede.cantidad) as ventas_SM, SUM(p_vede.importe) as importe_SM");
		$this->db->where('p_vede.fecha >=', $fecha3);
		$this->db->where('p_vede.fecha <=', $fecha4);
		$this->db->where_in("p_vede.producto",$productos);
		$this->db->group_by('p_vede.producto');
		$resultadoSM = $this->db->get('p_vede');
		$resultadoSM=$resultadoSM->result();
		$this->db->select("p_saod.producto, sum(p_saod.cantidad) as salida,sum(p_saod.importe) as salida2, CASE WHEN max(p_saod.clave) in ('004','035') THEN 1 ELSE 0 END as merma, CASE WHEN max(p_saod.clave) in ('003') THEN 1 ELSE 0 END as donativo, CASE WHEN max(p_saod.clave) in ('056') THEN 1 ELSE 0 END as chef, CASE WHEN max(p_saod.clave) in ('019') THEN 1 ELSE 0 END as asador");
		$this->db->where("p_saod.fecha between '2019-02-25' AND '2019-03-01' and clave in ('004','005','007','009','026','027','032','033','344','035','049','050','051','052','053','003','007','056','019')");
		$this->db->where_in("p_saod.producto",$productos);
		$this->db->group_by("p_saod.producto,p_saod.clave");
		$movimientosSM = $this->db->get('p_saod');
		$movimientosSM=$movimientosSM->result();

		//consulto las ventas del producto en Gastroshop
		$this->db=$this->load->database('gastroshop',true);
		$this->db->select("p_vede.producto, SUM(p_vede.cantidad) as ventas_GS, SUM(p_vede.importe) as importe_GS");
		$this->db->where('p_vede.fecha >=', $fecha3);
		$this->db->where('p_vede.fecha <=', $fecha4);
		$this->db->where_in("p_vede.producto",$productos);
		$this->db->group_by('p_vede.producto');
		$resultadoGS = $this->db->get('p_vede');
		////echo $this->db->last_query()."<br><br>";
		$resultadoGS=$resultadoGS->result();
		$this->db->select("p_saod.producto, sum(p_saod.cantidad) as salida,sum(p_saod.importe) as salida2, CASE WHEN max(p_saod.clave) in ('004','035') THEN 1 ELSE 0 END as merma, CASE WHEN max(p_saod.clave) in ('003') THEN 1 ELSE 0 END as donativo, CASE WHEN max(p_saod.clave) in ('056') THEN 1 ELSE 0 END as chef, CASE WHEN max(p_saod.clave) in ('019') THEN 1 ELSE 0 END as asador");
		$this->db->where("p_saod.fecha between '2019-02-25' AND '2019-03-01' and clave in ('004','005','007','009','026','027','032','033','344','035','049','050','051','052','053','003','007','056','019')");
		$this->db->where_in("p_saod.producto",$productos);
		$this->db->group_by("p_saod.producto,p_saod.clave");
		$movimientosGS = $this->db->get('p_saod');
		$movimientosGS=$movimientosGS->result();

		//consulto las ventas del producto en Mexquite
		$this->db=$this->load->database('mexquite',true);
		$this->db->select("p_vede.producto, SUM(p_vede.cantidad) as ventas_MX, SUM(p_vede.importe) as importe_MX");
		$this->db->where('p_vede.fecha >=', $fecha3);
		$this->db->where('p_vede.fecha <=', $fecha4);
		$this->db->where_in("p_vede.producto",$productos);
		$this->db->group_by('p_vede.producto');
		$resultadoMX = $this->db->get('p_vede');
		////echo $this->db->last_query()."<br><br>";
		$resultadoMX=$resultadoMX->result();
		$this->db->select("p_saod.producto, sum(p_saod.cantidad) as salida, CASE WHEN max(p_saod.clave) in ('004','035') THEN 1 ELSE 0 END as merma, CASE WHEN max(p_saod.clave) in ('003') THEN 1 ELSE 0 END as donativo, CASE WHEN max(p_saod.clave) in ('056') THEN 1 ELSE 0 END as chef, CASE WHEN max(p_saod.clave) in ('019') THEN 1 ELSE 0 END as asador");
		$this->db->where("p_saod.fecha between '2019-02-25' AND '2019-03-01' and clave in ('004','005','007','009','026','027','032','033','344','035','049','050','051','052','053','003','007','056','019')");
		$this->db->where_in("p_saod.producto",$productos);
		$this->db->group_by("p_saod.producto,p_saod.clave");
		$movimientosMX = $this->db->get('p_saod');
		$movimientosMX=$movimientosMX->result();

		//coloco los resultados dentro del arreglo principal
		foreach($resultado as &$r){
			$r->cocina=0;
			$r->sanmarcos=0;
			$r->gastro=0;
			$r->mexquite=0;
			$r->ventas_BR=0;
			$r->ventas_SM=0;
			$r->ventas_GS=0;
			$r->merma=0;
			$r->donativo=0;
			$r->chef=0;
			$r->asador=0;

			$r->cocina2=0;
			$r->sanmarcos2=0;
			$r->gastro2=0;
			$r->mexquite2=0;
			$r->ventas_BR2=0;
			$r->ventas_SM2=0;
			$r->ventas_GS2=0;
			$r->ventas_MX2=0;
			$r->merma2=0;
			$r->donativo2=0;
			$r->chef2=0;
			$r->asador2=0;
			//transferencias a otras sucursales
			foreach($transferencias as $tr){
				if($r->producto==$tr->producto){
					if($tr->cocina==1){		$r->cocina=$tr->salida;		$r->cocina2=$tr->salida2;		}
					if($tr->sanmarcos==1){	$r->sanmarcos=$tr->salida;	$r->sanmarcos2=$tr->salida2;	}
					if($tr->gastro==1){		$r->gastro=$tr->salida; 	$r->gastro2=$tr->salida2;		}
					if($tr->mexquite==1){	$r->mexquite=$tr->salida; 	$r->mexquite2=$tr->salida2;		}
				}
			}
			//ventas brasil
			foreach($resultadoBR as $br){
				if($r->producto==$br->producto){	$r->ventas_BR=$br->ventas_BR; 	$r->ventas_BR2=$br->importe_BR;	}
			}
			//movimientos de brasil
			foreach($movimientosBR as $mbr){
				if($r->producto==$mbr->producto){
					if($mbr->merma==1){		$r->merma+=$mbr->salida; 	$r->merma2+=$mbr->salida2;	}
					if($mbr->donativo==1){	$r->donativo+=$mbr->salida; $r->donativo2+=$mbr->salida2;	}
					if($mbr->chef==1){		$r->chef+=$mbr->salida; 	$r->chef2+=$mbr->salida2;		}
					if($mbr->asador==1){	$r->asador+=$mbr->salida; 	$r->asador2+=$mbr->salida2;	}
				}
			}
			//ventas san marcos
			foreach($resultadoSM as $sm){
				if($r->producto==$sm->producto){	$r->ventas_SM=$sm->ventas_SM; 	$r->ventas_SM2=$sm->importe_SM;	}
			}
			//movimientos san marcos
			foreach($movimientosSM as $msm){
				if($r->producto==$msm->producto){
					if($msm->merma==1){		$r->merma+=$msm->salida; 	$r->merma2+=$msm->salida2;	}
					if($msm->donativo==1){	$r->donativo+=$msm->salida; $r->donativo2+=$msm->salida2;	}
					if($msm->chef==1){		$r->chef+=$msm->salida; 	$r->chef2+=$msm->salida2;		}
					if($msm->asador==1){	$r->asador+=$msm->salida; 	$r->asador2+=$msm->salida2;	}
				}
			}
			//ventas gastro
			foreach($resultadoGS as $gs){
				if($r->producto==$gs->producto){	$r->ventas_GS=$gs->ventas_GS; $r->ventas_GS2=$gs->importe_GS;	}
			}
			//movimientos gastro
			foreach($movimientosGS as $mgs){
				if($r->producto==$mgs->producto){
					if($mgs->merma==1){		$r->merma+=$mgs->salida; 	$r->merma2+=$mgs->salida2;	}
					if($mgs->donativo==1){	$r->donativo+=$mgs->salida; $r->donativo2+=$mgs->salida2;	}
					if($mgs->chef==1){		$r->chef+=$mgs->salida; 	$r->chef2+=$mgs->salida2;		}
					if($mgs->asador==1){	$r->asador+=$mgs->salida; 	$r->asador2+=$mgs->salida2;	}
				}
			}
			//ventas mexquite
			foreach($resultadoMX as $mx){
				if($r->producto==$mx->producto){	$r->ventas_MX=$mx->ventas_MX; $r->ventas_MX2=$mx->importe_MX;	}
			}
			//movimientos mexquite
			foreach($movimientosMX as $mmx){
				if($r->producto==$mmx->producto){
					if($mmx->merma==1){		$r->merma+=$mmx->salida; 	$r->merma2+=$mmx->salida2;	}
					if($mmx->donativo==1){	$r->donativo+=$mmx->salida; $r->donativo2+=$mmx->salida2;	}
					if($mmx->chef==1){		$r->chef+=$mmx->salida; 	$r->chef2+=$mmx->salida2;		}
					if($mmx->asador==1){	$r->asador+=$mmx->salida; 	$r->asador2+=$mmx->salida2;	}
				}
			}


		}

		return $resultado;
	}

	//reporte compras vs ventas todas las sucursales
	function get_comprasvsventas3($tipo,$marca,$fecha3,$fecha4){
		//consultamos las compras echas en brasil
		$this->db=$this->load->database('brasil',true);
		$this->db->select("p_compde.producto,MAX(p_prod.desc1) as prod_descrip,MAX(p_prod.um) as prod_um,SUM(p_compde.cantidad) as cant_compra, SUM(p_compde.importe) as imp_compra");
		$this->db->join('p_prod',"p_compde.producto = p_prod.producto");
		$this->db->where('p_compde.proveedor !=', '000');
		$this->db->where('p_compde.fecha >=', $fecha3);
		$this->db->where('p_compde.fecha <=', $fecha4);
		if($marca!='T'){$this->db->where('p_prod.marca',$marca);}
		if($tipo==0){ $this->db->where('p_compde.linea', "005"); }
		elseif($tipo==1){ $this->db->where('p_compde.linea', "002"); }
		elseif($tipo==2){ $this->db->where('p_compde.linea', "001"); }
		elseif($tipo==3){ $this->db->where('p_compde.proveedor', "515"); }
		else{ $this->db->where('p_compde.linea', $tipo); }
		$this->db->group_by('p_compde.producto');
		$this->db->order_by('p_compde.producto');
		$resultado = $this->db->get('p_compde');
		// echo $this->db->last_query();
		// echo $this->db->last_query()."<br><br>";
		if($resultado->num_rows()==0) return array();
		$resultado=$resultado->result();

		//extraigo todos los numeros de cliente
		$productos=array();
		foreach($resultado as $r)
			$productos[]=$r->producto;

		//consulto las distribuciones entre las sucursales
		$this->db->select("p_saod.producto,SUM(p_saod.cantidad) salida,sum(p_saod.importe) as salida2,CASE WHEN max(p_saot.destino) in ('05') THEN 1 ELSE 0 END as cocina, CASE WHEN max(p_saot.destino) in ('02') THEN 1 ELSE 0 END as sanmarcos, CASE WHEN max(p_saot.destino) in ('04') THEN 1 ELSE 0 END as gastro, CASE WHEN max(p_saot.destino) in ('03') THEN 1 ELSE 0 END as mexquite,");
		$this->db->join("p_saot","p_saod.salida = p_saot.salida");
		$this->db->where('p_saot.fecha >=', $fecha3);
		$this->db->where('p_saot.fecha <=', $fecha4);
		$this->db->where("p_saod.clave NOT IN('004','005','007','009','026','027','032','033','344','035','049','050','051','052','053','003','007','056','019')");
		$this->db->where_in("p_saod.producto",$productos);
		$this->db->group_by("p_saod.producto, p_saot.destino");
		$transferencias = $this->db->get('p_saod');
		$transferencias = $transferencias->result();


		//consulto las ventas del producto en BRASIL
		$this->db=$this->load->database('brasil',true);
		$this->db->select("p_vede.producto, SUM(p_vede.cantidad) as ventas_BR, SUM(p_vede.importe) as importe_BR");
		$this->db->where('p_vede.fecha >=', $fecha3);
		$this->db->where('p_vede.fecha <=', $fecha4);
		$this->db->where_in("p_vede.producto",$productos);
		$this->db->group_by('p_vede.producto');
		$resultadoBR = $this->db->get('p_vede');
		////echo $this->db->last_query()."<br><br>";
		$resultadoBR=$resultadoBR->result();
		$this->db->select("p_saod.producto, sum(p_saod.cantidad) as salida,sum(p_saod.importe) as salida2, CASE WHEN max(p_saod.clave) in ('004','005','007','009','026','027','032','033','344','035','049','050','051','052','053') THEN 1 ELSE 0 END as merma, CASE WHEN max(p_saod.clave) in ('003','007') THEN 1 ELSE 0 END as donativo, CASE WHEN max(p_saod.clave) in ('056') THEN 1 ELSE 0 END as chef, CASE WHEN max(p_saod.clave) in ('019') THEN 1 ELSE 0 END as asador");
		$this->db->where("p_saod.fecha between '2019-02-25' AND '2019-03-01' and clave in ('004','005','007','009','026','027','032','033','344','035','049','050','051','052','053','003','007','056','019')");
		$this->db->where_in("p_saod.producto",$productos);
		$this->db->group_by("p_saod.producto,p_saod.clave");
		$movimientosBR = $this->db->get('p_saod');
		$movimientosBR=$movimientosBR->result();

		//consulto las ventas del producto en SanMarcos
		$this->db=$this->load->database('sanmarcos',true);
		$this->db->select("p_vede.producto, SUM(p_vede.cantidad) as ventas_SM, SUM(p_vede.importe) as importe_SM");
		$this->db->where('p_vede.fecha >=', $fecha3);
		$this->db->where('p_vede.fecha <=', $fecha4);
		$this->db->where_in("p_vede.producto",$productos);
		$this->db->group_by('p_vede.producto');
		$resultadoSM = $this->db->get('p_vede');
		$resultadoSM=$resultadoSM->result();
		$this->db->select("p_saod.producto, sum(p_saod.cantidad) as salida,sum(p_saod.importe) as salida2, CASE WHEN max(p_saod.clave) in ('004','005','007','009','026','027','032','033','344','035','049','050','051','052','053') THEN 1 ELSE 0 END as merma, CASE WHEN max(p_saod.clave) in ('003','007') THEN 1 ELSE 0 END as donativo, CASE WHEN max(p_saod.clave) in ('056') THEN 1 ELSE 0 END as chef, CASE WHEN max(p_saod.clave) in ('019') THEN 1 ELSE 0 END as asador");
		$this->db->where("p_saod.fecha between '2019-02-25' AND '2019-03-01' and clave in ('004','005','007','009','026','027','032','033','344','035','049','050','051','052','053','003','007','056','019')");
		$this->db->where_in("p_saod.producto",$productos);
		$this->db->group_by("p_saod.producto,p_saod.clave");
		$movimientosSM = $this->db->get('p_saod');
		$movimientosSM=$movimientosSM->result();

		//consulto las ventas del producto en Gastroshop
		$this->db=$this->load->database('gastroshop',true);
		$this->db->select("p_vede.producto, SUM(p_vede.cantidad) as ventas_GS, SUM(p_vede.importe) as importe_GS");
		$this->db->where('p_vede.fecha >=', $fecha3);
		$this->db->where('p_vede.fecha <=', $fecha4);
		$this->db->where_in("p_vede.producto",$productos);
		$this->db->group_by('p_vede.producto');
		$resultadoGS = $this->db->get('p_vede');
		////echo $this->db->last_query()."<br><br>";
		$resultadoGS=$resultadoGS->result();
		$this->db->select("p_saod.producto, sum(p_saod.cantidad) as salida,sum(p_saod.importe) as salida2, CASE WHEN max(p_saod.clave) in ('004','005','007','009','026','027','032','033','344','035','049','050','051','052','053') THEN 1 ELSE 0 END as merma, CASE WHEN max(p_saod.clave) in ('003','007') THEN 1 ELSE 0 END as donativo, CASE WHEN max(p_saod.clave) in ('056') THEN 1 ELSE 0 END as chef, CASE WHEN max(p_saod.clave) in ('019') THEN 1 ELSE 0 END as asador");
		$this->db->where("p_saod.fecha between '2019-02-25' AND '2019-03-01' and clave in ('004','005','007','009','026','027','032','033','344','035','049','050','051','052','053','003','007','056','019')");
		$this->db->where_in("p_saod.producto",$productos);
		$this->db->group_by("p_saod.producto,p_saod.clave");
		$movimientosGS = $this->db->get('p_saod');
		$movimientosGS=$movimientosGS->result();

		//consulto las ventas del producto en Mexquite
		$this->db=$this->load->database('mexquite',true);
		$this->db->select("p_vede.producto, SUM(p_vede.cantidad) as ventas_MX, SUM(p_vede.importe) as importe_MX");
		$this->db->where('p_vede.fecha >=', $fecha3);
		$this->db->where('p_vede.fecha <=', $fecha4);
		$this->db->where_in("p_vede.producto",$productos);
		$this->db->group_by('p_vede.producto');
		$resultadoMX = $this->db->get('p_vede');
		////echo $this->db->last_query()."<br><br>";
		$resultadoMX=$resultadoMX->result();
		$this->db->select("p_saod.producto, sum(p_saod.cantidad) as salida, CASE WHEN max(p_saod.clave) in ('004','005','007','009','026','027','032','033','344','035','049','050','051','052','053') THEN 1 ELSE 0 END as merma, CASE WHEN max(p_saod.clave) in ('003','007') THEN 1 ELSE 0 END as donativo, CASE WHEN max(p_saod.clave) in ('056') THEN 1 ELSE 0 END as chef, CASE WHEN max(p_saod.clave) in ('019') THEN 1 ELSE 0 END as asador");
		$this->db->where("p_saod.fecha between '2019-02-25' AND '2019-03-01' and clave in ('004','005','007','009','026','027','032','033','344','035','049','050','051','052','053','003','007','056','019')");
		$this->db->where_in("p_saod.producto",$productos);
		$this->db->group_by("p_saod.producto,p_saod.clave");
		$movimientosMX = $this->db->get('p_saod');
		$movimientosMX=$movimientosMX->result();

		//coloco los resultados dentro del arreglo principal
		foreach($resultado as &$r){
			$r->cocina=0;
			$r->sanmarcos=0;
			$r->gastro=0;
			$r->mexquite=0;
			$r->ventas_BR=0;
			$r->ventas_SM=0;
			$r->ventas_GS=0;
			$r->merma=0;
			$r->donativo=0;
			$r->chef=0;
			$r->asador=0;

			$r->cocina2=0;
			$r->sanmarcos2=0;
			$r->gastro2=0;
			$r->mexquite2=0;
			$r->ventas_BR2=0;
			$r->ventas_SM2=0;
			$r->ventas_GS2=0;
			$r->ventas_MX2=0;
			$r->merma2=0;
			$r->donativo2=0;
			$r->chef2=0;
			$r->asador2=0;
			//transferencias a otras sucursales
			foreach($transferencias as $tr){
				if($r->producto==$tr->producto){
					if($tr->cocina==1){		$r->cocina=$tr->salida;		$r->cocina2=$tr->salida2;		}
					if($tr->sanmarcos==1){	$r->sanmarcos=$tr->salida;	$r->sanmarcos2=$tr->salida2;	}
					if($tr->gastro==1){		$r->gastro=$tr->salida; 	$r->gastro2=$tr->salida2;		}
					if($tr->mexquite==1){	$r->mexquite=$tr->salida; 	$r->mexquite2=$tr->salida2;		}
				}
			}
			//ventas brasil
			foreach($resultadoBR as $br){
				if($r->producto==$br->producto){	$r->ventas_BR=$br->ventas_BR; 	$r->ventas_BR2=$br->importe_BR;	}
			}
			//movimientos de brasil
			foreach($movimientosBR as $mbr){
				if($r->producto==$mbr->producto){
					if($mbr->merma==1){		$r->merma+=$mbr->salida; 	$r->merma2+=$mbr->salida2;	}
					if($mbr->donativo==1){	$r->donativo+=$mbr->salida; $r->donativo2+=$mbr->salida2;	}
					if($mbr->chef==1){		$r->chef+=$mbr->salida; 	$r->chef2+=$mbr->salida2;		}
					if($mbr->asador==1){	$r->asador+=$mbr->salida; 	$r->asador2+=$mbr->salida2;	}
				}
			}
			//ventas san marcos
			foreach($resultadoSM as $sm){
				if($r->producto==$sm->producto){	$r->ventas_SM=$sm->ventas_SM; 	$r->ventas_SM2=$sm->importe_SM;	}
			}
			//movimientos san marcos
			foreach($movimientosSM as $msm){
				if($r->producto==$msm->producto){
					if($msm->merma==1){		$r->merma+=$msm->salida; 	$r->merma2+=$msm->salida2;	}
					if($msm->donativo==1){	$r->donativo+=$msm->salida; $r->donativo2+=$msm->salida2;	}
					if($msm->chef==1){		$r->chef+=$msm->salida; 	$r->chef2+=$msm->salida2;		}
					if($msm->asador==1){	$r->asador+=$msm->salida; 	$r->asador2+=$msm->salida2;	}
				}
			}
			//ventas gastro
			foreach($resultadoGS as $gs){
				if($r->producto==$gs->producto){	$r->ventas_GS=$gs->ventas_GS; $r->ventas_GS2=$gs->importe_GS;	}
			}
			//movimientos gastro
			foreach($movimientosGS as $mgs){
				if($r->producto==$mgs->producto){
					if($mgs->merma==1){		$r->merma+=$mgs->salida; 	$r->merma2+=$mgs->salida2;	}
					if($mgs->donativo==1){	$r->donativo+=$mgs->salida; $r->donativo2+=$mgs->salida2;	}
					if($mgs->chef==1){		$r->chef+=$mgs->salida; 	$r->chef2+=$mgs->salida2;		}
					if($mgs->asador==1){	$r->asador+=$mgs->salida; 	$r->asador2+=$mgs->salida2;	}
				}
			}
			//ventas mexquite
			foreach($resultadoMX as $mx){
				if($r->producto==$mx->producto){	$r->ventas_MX=$mx->ventas_MX; $r->ventas_MX2=$mx->importe_MX;	}
			}
			//movimientos mexquite
			foreach($movimientosMX as $mmx){
				if($r->producto==$mmx->producto){
					if($mmx->merma==1){		$r->merma+=$mmx->salida; 	$r->merma2+=$mmx->salida2;	}
					if($mmx->donativo==1){	$r->donativo+=$mmx->salida; $r->donativo2+=$mmx->salida2;	}
					if($mmx->chef==1){		$r->chef+=$mmx->salida; 	$r->chef2+=$mmx->salida2;		}
					if($mmx->asador==1){	$r->asador+=$mmx->salida; 	$r->asador2+=$mmx->salida2;	}
				}
			}


		}

		return $resultado;
	}

	//reporte compras vs ventas todas las sucursales
	function get_transferencias_cocina($fecha1,$fecha2,$fecha3,$fecha4){
		//conglomerado de detalles de salida agrupadas por producto
		$this->db=$this->load->database('cocina',true);
		$this->db->select("p_saod.producto,MAX(p_prod.desc1) as prod_descrip,MAX(p_prod.um) as prod_um,sum(p_saod.cantidad) as salida");
		$this->db->join('p_prod',"p_saod.producto = p_prod.producto");
		$this->db->where('p_saod.fecha >=', $fecha1);
		$this->db->where('p_saod.fecha <=', $fecha2);
		$this->db->where("p_prod.linea","007");
		$this->db->where("p_prod.estatus","A");
		$this->db->group_by('p_saod.producto');
		$this->db->order_by('p_saod.producto');
		$resultado = $this->db->get('p_saod');
		//echo $this->db->last_query();
		////echo $this->db->last_query()."<br><br>";
		$resultado=$resultado->result();
		//extraigo todos los numeros de cliente
		$productos=array();
		foreach($resultado as $r)
			$productos[]=$r->producto;

		//consulto las distribuciones entre las sucursales esta vez desde cocina
		$this->db->select("p_saod.producto,SUM(p_saod.cantidad) salida,CASE WHEN max(p_saot.destino) in ('01') THEN 1 ELSE 0 END as brasil, CASE WHEN max(p_saot.destino) in ('02') THEN 1 ELSE 0 END as sanmarcos, CASE WHEN max(p_saot.destino) in ('04') THEN 1 ELSE 0 END as gastro,CASE WHEN max(p_saot.destino) in ('03') THEN 1 ELSE 0 END as mexquite");
		$this->db->join("p_saot","p_saod.salida = p_saot.salida");
		$this->db->where('p_saot.fecha >=', $fecha1);
		$this->db->where('p_saot.fecha <=', $fecha2);
		$this->db->where("p_saod.clave NOT IN('004','005','007','009','026','027','032','033','344','035','049','050','051','052','053','003','007','056','019')");
		$this->db->where_in("p_saod.producto",$productos);
		$this->db->group_by("p_saod.producto, p_saot.destino");
		$transferencias = $this->db->get('p_saod');
		$transferencias = $transferencias->result();


		//consulto las ventas del producto en BRASIL
		$this->db=$this->load->database('brasil',true);
		$this->db->select("p_vede.producto, SUM(p_vede.cantidad) as ventas_BR");
		$this->db->where('p_vede.fecha >=', $fecha3);
		$this->db->where('p_vede.fecha <=', $fecha4);
		$this->db->where_in("p_vede.producto",$productos);
		$this->db->group_by('p_vede.producto');
		$resultadoBR = $this->db->get('p_vede');
		////echo $this->db->last_query()."<br><br>";
		$resultadoBR=$resultadoBR->result();
		$this->db->select("p_saod.producto, sum(p_saod.cantidad) as salida, CASE WHEN max(p_saod.clave) in ('004','005','007','009','026','027','032','033','344','035','049','050','051','052','053') THEN 1 ELSE 0 END as merma, CASE WHEN max(p_saod.clave) in ('003','007') THEN 1 ELSE 0 END as donativo, CASE WHEN max(p_saod.clave) in ('056') THEN 1 ELSE 0 END as chef, CASE WHEN max(p_saod.clave) in ('019') THEN 1 ELSE 0 END as asador");
		$this->db->where("p_saod.fecha between '2019-02-25' AND '2019-03-01' and clave in ('004','005','007','009','026','027','032','033','344','035','049','050','051','052','053','003','007','056','019')");
		$this->db->where_in("p_saod.producto",$productos);
		$this->db->group_by("p_saod.producto,p_saod.clave");
		$movimientosBR = $this->db->get('p_saod');
		$movimientosBR=$movimientosBR->result();

		//consulto las ventas del producto en SanMarcos
		$this->db=$this->load->database('sanmarcos',true);
		$this->db->select("p_vede.producto, SUM(p_vede.cantidad) as ventas_SM");
		$this->db->where('p_vede.fecha >=', $fecha3);
		$this->db->where('p_vede.fecha <=', $fecha4);
		$this->db->where_in("p_vede.producto",$productos);
		$this->db->group_by('p_vede.producto');
		$resultadoSM = $this->db->get('p_vede');
		$resultadoSM=$resultadoSM->result();
		$this->db->select("p_saod.producto, sum(p_saod.cantidad) as salida, CASE WHEN max(p_saod.clave) in ('004','005','007','009','026','027','032','033','344','035','049','050','051','052','053') THEN 1 ELSE 0 END as merma, CASE WHEN max(p_saod.clave) in ('003','007') THEN 1 ELSE 0 END as donativo, CASE WHEN max(p_saod.clave) in ('056') THEN 1 ELSE 0 END as chef, CASE WHEN max(p_saod.clave) in ('019') THEN 1 ELSE 0 END as asador");
		$this->db->where("p_saod.fecha between '2019-02-25' AND '2019-03-01' and clave in ('004','005','007','009','026','027','032','033','344','035','049','050','051','052','053','003','007','056','019')");
		$this->db->where_in("p_saod.producto",$productos);
		$this->db->group_by("p_saod.producto,p_saod.clave");
		$movimientosSM = $this->db->get('p_saod');
		$movimientosSM=$movimientosSM->result();

		//consulto las ventas del producto en Gastroshop
		$this->db=$this->load->database('gastroshop',true);
		$this->db->select("p_vede.producto, SUM(p_vede.cantidad) as ventas_GS");
		$this->db->where('p_vede.fecha >=', $fecha3);
		$this->db->where('p_vede.fecha <=', $fecha4);
		$this->db->where_in("p_vede.producto",$productos);
		$this->db->group_by('p_vede.producto');
		$resultadoGS = $this->db->get('p_vede');
		////echo $this->db->last_query()."<br><br>";
		$resultadoGS=$resultadoGS->result();
		$this->db->select("p_saod.producto, sum(p_saod.cantidad) as salida, CASE WHEN max(p_saod.clave) in ('004','005','007','009','026','027','032','033','344','035','049','050','051','052','053') THEN 1 ELSE 0 END as merma, CASE WHEN max(p_saod.clave) in ('003','007') THEN 1 ELSE 0 END as donativo, CASE WHEN max(p_saod.clave) in ('056') THEN 1 ELSE 0 END as chef, CASE WHEN max(p_saod.clave) in ('019') THEN 1 ELSE 0 END as asador");
		$this->db->where("p_saod.fecha between '2019-02-25' AND '2019-03-01' and clave in ('004','005','007','009','026','027','032','033','344','035','049','050','051','052','053','003','007','056','019')");
		$this->db->where_in("p_saod.producto",$productos);
		$this->db->group_by("p_saod.producto,p_saod.clave");
		$movimientosGS = $this->db->get('p_saod');
		////echo $this->db->last_query()."<br><br>";
		$movimientosGS=$movimientosGS->result();

		//consulto las ventas del producto en Mexquite
		$this->db=$this->load->database('mexquite',true);
		$this->db->select("p_vede.producto, SUM(p_vede.cantidad) as ventas_MX");
		$this->db->where('p_vede.fecha >=', $fecha3);
		$this->db->where('p_vede.fecha <=', $fecha4);
		$this->db->where_in("p_vede.producto",$productos);
		$this->db->group_by('p_vede.producto');
		$resultadoMX = $this->db->get('p_vede');
		////echo $this->db->last_query()."<br><br>";
		$resultadoMX=$resultadoMX->result();
		$this->db->select("p_saod.producto, sum(p_saod.cantidad) as salida, CASE WHEN max(p_saod.clave) in ('004','005','007','009','026','027','032','033','344','035','049','050','051','052','053') THEN 1 ELSE 0 END as merma, CASE WHEN max(p_saod.clave) in ('003','007') THEN 1 ELSE 0 END as donativo, CASE WHEN max(p_saod.clave) in ('056') THEN 1 ELSE 0 END as chef, CASE WHEN max(p_saod.clave) in ('019') THEN 1 ELSE 0 END as asador");
		$this->db->where("p_saod.fecha between '2019-02-25' AND '2019-03-01' and clave in ('004','005','007','009','026','027','032','033','344','035','049','050','051','052','053','003','007','056','019')");
		$this->db->where_in("p_saod.producto",$productos);
		$this->db->group_by("p_saod.producto,p_saod.clave");
		$movimientosMX = $this->db->get('p_saod');
		$movimientosMX=$movimientosMX->result();

		//coloco los resultados dentro del arreglo principal
		foreach($resultado as &$r){
			$r->brasil=0;
			$r->sanmarcos=0;
			$r->gastro=0;
			$r->mexquite=0;
			$r->ventas_BR=0;
			$r->ventas_SM=0;
			$r->ventas_GS=0;
			$r->merma=0;
			$r->donativo=0;
			$r->chef=0;
			$r->asador=0;
			foreach($transferencias as $tr){
				if($r->producto==$tr->producto){
					if($tr->brasil==1){		$r->brasil=$tr->salida;		}
					if($tr->sanmarcos==1){	$r->sanmarcos=$tr->salida;	}
					if($tr->gastro==1){		$r->gastro=$tr->salida;		}
					if($tr->mexquite==1){	$r->mexquite=$tr->salida;	}
				}
			}

			foreach($resultadoBR as $br){
				if($r->producto==$br->producto){	$r->ventas_BR=$br->ventas_BR;	}
			}

			foreach($movimientosBR as $mbr){
				if($r->producto==$mbr->producto){
					if($mbr->merma==1){		$r->merma+=$mbr->salida;	}
					if($mbr->donativo==1){	$r->donativo+=$mbr->salida;	}
					if($mbr->chef==1){		$r->chef+=$mbr->salida;		}
					if($mbr->asador==1){	$r->asador+=$mbr->salida;	}
				}
			}
			
			foreach($resultadoSM as $sm){
				if($r->producto==$sm->producto){	$r->ventas_SM=$sm->ventas_SM;	}
			}

			foreach($movimientosSM as $msm){
				if($r->producto==$msm->producto){
					if($msm->merma==1){		$r->merma+=$msm->salida;	}
					if($msm->donativo==1){	$r->donativo+=$msm->salida;	}
					if($msm->chef==1){		$r->chef+=$msm->salida;		}
					if($msm->asador==1){	$r->asador+=$msm->salida;	}
				}
			}

			foreach($resultadoGS as $gs){
				if($r->producto==$gs->producto){	$r->ventas_GS=$gs->ventas_GS;	}
			}
			foreach($movimientosGS as $mgs){
				if($r->producto==$mgs->producto){
					if($mgs->merma==1){		$r->merma+=$mgs->salida;	}
					if($mgs->donativo==1){	$r->donativo+=$mgs->salida;	}
					if($mgs->chef==1){		$r->chef+=$mgs->salida;		}
					if($mgs->asador==1){	$r->asador+=$mgs->salida;	}
				}
			}

			foreach($resultadoMX as $mx){
				if($r->producto==$mx->producto){	$r->ventas_MX=$mx->ventas_MX;	}
			}
			foreach($movimientosMX as $mmx){
				if($r->producto==$mmx->producto){
					if($mmx->merma==1){		$r->merma+=$mmx->salida;	}
					if($mmx->donativo==1){	$r->donativo+=$mmx->salida;	}
					if($mmx->chef==1){		$r->chef+=$mmx->salida;		}
					if($mmx->asador==1){	$r->asador+=$mmx->salida;	}
				}
			}

		}

		return $resultado;
	}
	//traer todos los departamentos de brasil
	function lineas(){
		$this->db=$this->load->database("brasil",true);
		$this->db->order_by("linea");
		$r = $this->db->get("p_line");
		return $r->result();
	}
	//todas las marcas
	function marcas(){
		$this->db=$this->load->database("brasil",true);
		$this->db->order_by("marca");
		$r = $this->db->get("p_marc");
		return $r->result();
	}
	//traer todos los departamentos de x sucursal
	function dep_suc($suc){
		$this->db=$this->load->database($suc,true);
		$this->db->select("linea,nombre");
		$this->db->order_by("linea");
		$r = $this->db->get("p_line");
		return $r->result();
	}
	//traer todos los departamentos de x sucursal
	function subdep_dep($suc,$dep){
		$this->db=$this->load->database($suc,true);
		$this->db->select("subdepto,descrip");
		$this->db->where("linea",$dep);
		$this->db->order_by("subdepto");
		$r = $this->db->get("p_subd");
		return $r->result();
	}
	//calculo de pedido por departamento
	function get_calculo_pedido($sucursal,$linea,$subdep,$fechas){
		$this->db=$this->load->database($sucursal,true);
		$this->db->select("p_vede.producto,p_vede.fecha, MAX(p_prod.desc1) as desc1");
		$this->db->select("CASE WHEN p_vede.fecha in ('".$fechas[0]."') THEN SUM(p_vede.cantidad) ELSE 0 END as cantidad0");
		$this->db->select("CASE WHEN p_vede.fecha in ('".$fechas[1]."') THEN SUM(p_vede.cantidad) ELSE 0 END as cantidad1");
		$this->db->select("CASE WHEN p_vede.fecha in ('".$fechas[2]."') THEN SUM(p_vede.cantidad) ELSE 0 END as cantidad2");
		$this->db->select("CASE WHEN p_vede.fecha in ('".$fechas[3]."') THEN SUM(p_vede.cantidad) ELSE 0 END as cantidad3");
		$this->db->join("p_vede","p_vede.producto = p_prod.producto","LEFT");
		$this->db->where_in("p_vede.fecha",$fechas);
		if($linea!="T"){$this->db->where("p_prod.linea",$linea);}
		if($subdep!="T"){$this->db->where("p_prod.subdepto",$subdep);}
		
		//
		//
		$this->db->where("p_prod.estatus !=","I");
		$this->db->group_by("p_vede.producto,p_vede.fecha");
		$res = $this->db->get("p_prod");
		$sub_query = $this->db->last_query();
		
		$this->db->select("p_prod.producto,max(p_prod.min) as min,max(p_prod.exis) as exis,max(p_prod.um) as um, max(p_prod.desc1) as descrip,sum(cantidad0) as cantidad0,sum(cantidad1) as cantidad1,sum(cantidad2) as cantidad2,sum(cantidad3) as cantidad3");
		$this->db->group_by("p_prod.producto");
		$this->db->join("(".$sub_query.") subq","p_prod.producto = subq.producto","LEFT");
		if($linea!="T"){$this->db->where("p_prod.linea",$linea);}
		if($subdep!="T"){$this->db->where("p_prod.subdepto",$subdep);}
		$this->db->where("p_prod.estatus !=","I");
		$res = $this->db->get("p_prod");

		//echo $this->db->last_query();
		//show_array($res->result());
		return $res->result();
	}

	//calcula las ventas en un periodo especificado por departamento
	function get_calculo_pedido_periodo($sucursal,$linea,$subdep,$fechas){
		$this->db=$this->load->database($sucursal,true);

		//productos que se consultaran
		$this->db->select("producto, desc1, um, min, exis");
		$this->db->where("estatus !=","I");
		if($linea!="T"){$this->db->where("linea",$linea);}
		if($subdep!="T"){$this->db->where("subdepto",$subdep);}
		$res = $this->db->get("p_prod");
		$res = $res->result();

		//arreglo con productos
		$productos=array();
		foreach($res as $r){$productos[]=$r->producto;}

		$this->db->select("p_vede.producto, sum(p_vede.cantidad) as cantidad, MAX(p_prod.desc1) as desc1, MAX(p_prod.um) as um, max(p_prod.min) as min,max(p_prod.exis) as exis");
		/**/
		$this->db->join("p_prod","p_vede.producto = p_prod.producto","LEFT");
		$this->db->where("p_vede.fecha between '".$fechas[0]."' and '".$fechas[1]."'");
		$this->db->where_in("p_vede.producto",$productos);
		$this->db->group_by("p_vede.producto");
		$res1 = $this->db->get("p_vede");
		$res1 = $res1->result();
		//echo $this->db->last_query()."<br><br>";

		foreach($res as &$r){
			$r->cantidad=0;
			foreach ($res1 as $r1) { if($r->producto==$r1->producto){
				$r->cantidad=$r1->cantidad;
			}}
		}

		return $res;
	}

	//Calcula las ventas en un periodo especificado por departamento
	function get_calculo_pedido_periodo2($sucursal,$linea,$subdep,$fechas){
		$this->db=$this->load->database($sucursal,true);

		//productos que se consultaran
		$this->db->select("producto, desc1, um, min, exis");
		$this->db->where("estatus !=","I");
		if($linea!="T"){$this->db->where("linea",$linea);}
		if($subdep!="T"){$this->db->where("subdepto",$subdep);}
		$res = $this->db->get("p_prod");
		$res = $res->result();

		//arreglo con productos
		$productos=array();
		foreach($res as $r){$productos[]=$r->producto;}

		//resultado1
		$this->db->select("producto, sum(cantidad) as cantidad");
		$this->db->where("p_vede.fecha between '".$fechas[0]."' and '".$fechas[1]."'");
		$this->db->where_in("producto",$productos);
		$this->db->group_by("producto");
		$res1 = $this->db->get("p_vede");
		//echo $this->db->last_query()."<br><br>";
		$res1 = $res1->result();
		
		//resultado2
		$this->db->select("producto, sum(cantidad) as cantidad");
		$this->db->where("p_vede.fecha between '".$fechas[2]."' and '".$fechas[3]."'");
		$this->db->where_in("producto",$productos);
		$this->db->group_by("producto");
		$res2 = $this->db->get("p_vede");
		//echo $this->db->last_query()."<br><br>";
		$res2 = $res2->result();

		//resultado3
		$this->db->select("producto, sum(cantidad) as cantidad");
		$this->db->where("p_vede.fecha between '".$fechas[4]."' and '".$fechas[5]."'");
		$this->db->where_in("producto",$productos);
		$this->db->group_by("producto");
		$res3 = $this->db->get("p_vede");
		//echo $this->db->last_query()."<br><br>";
		$res3 = $res3->result();

		//resultado4
		$this->db->select("producto, sum(cantidad) as cantidad");
		$this->db->where("p_vede.fecha between '".$fechas[6]."' and '".$fechas[7]."'");
		$this->db->where_in("producto",$productos);
		$this->db->group_by("producto");
		$res4 = $this->db->get("p_vede");
		//echo $this->db->last_query()."<br><br>";
		$res4 = $res4->result();

		//conglomerar
		foreach($res as &$r){
			$r->cantidad1=0;$r->cantidad2=0;$r->cantidad3=0;$r->cantidad4=0;
			foreach ($res1 as $r1) { if($r->producto==$r1->producto){$r->cantidad1=$r1->cantidad;}}
			foreach ($res2 as $r2) { if($r->producto==$r2->producto){$r->cantidad2=$r2->cantidad;}}
			foreach ($res3 as $r3) { if($r->producto==$r3->producto){$r->cantidad3=$r3->cantidad;}}
			foreach ($res4 as $r4) { if($r->producto==$r4->producto){$r->cantidad4=$r4->cantidad;}}
		}
		return $res;
	}

	//calculo las ventas de un proveedor especifico en un periodo establecido
	function get_calculo_pedido_proveedor($sucursal,$proveedores,$fechas){
		$this->db=$this->load->database($sucursal,true);
		$this->db->select("p_vede.producto, sum(p_vede.cantidad) as cantidad, MAX(p_prod.desc1) as desc1, MAX(p_prod.um) as um, max(p_prod.min) as min,max(p_prod.exis) as exis");
		$this->db->join("p_prod","p_vede.producto = p_prod.producto","LEFT");
		$this->db->where("p_vede.fecha between '".$fechas[0]."' and '".$fechas[1]."'");
		$this->db->where_in("p_vede.proveedor",$proveedores);
		//if($linea!="T"){$this->db->where("p_vede.linea",$linea);}
		//if($subdep!="T"){$this->db->where("p_vede.subdepto",$subdep);}
		$this->db->where("p_prod.estatus !=","I");
		$this->db->group_by("p_vede.producto");
		$res = $this->db->get("p_vede");

		return $res->result();
	}

	//Poliza de compras
	function get_compras_credito($sucursal,$mes,$ejercicio){
		$tienda='01';
		switch ($sucursal) {
			case 'brasil':
				$tienda='01';break;
			case 'sanmarcos':
				$tienda='02';break;
			case 'gastroshop':
				$tienda='04';break;
			case 'mexquite':
				$tienda='03';break;
		}
		$this->db=$this->load->database($sucursal,true);
		$this->db->select("p_compra.fecha, p_compra.factura, p_prov.ctacontamn, p_prov.ctacontaus, p_prov.ctacomple, p_prov.nombre, p_compra.moneda, p_prov.iva, p_compra.suma, p_compra.impuesto, p_compra.total,p_compra.sumaus, p_compra.impuestous, p_compra.totalus, p_compra.tc,tipo='1',p_prov.proveedor,p_compra.gravado, p_compra.tasacero");

		$this->db->where("( p_compra.proveedor = p_prov.proveedor ) and (p_prov.prov_int is null or ( p_prov.prov_int = '0') ) and ((year(p_compra.fecha)='".$ejercicio."' and  month(p_compra.fecha)='".$mes."' and p_compra.tienda='".$tienda."' and ( 'R' = 'R') ) or (p_compra.f_factura IS NULL and ( 'R' = 'F')) ) and ((p_compra.tipo_pago = 'CR') or ('CR' = 'AM'))");

		$this->db->order_by("p_compra.fecha, p_prov.nombre");
		$res = $this->db->get("p_compra,p_prov");
		//echo $this->db->last_query(); exit;
		$compras = $res->result();
		$array_facturas = array();

		$this->db->select("p_sadv.fecha, p_sadv.factura,p_prov.ctacontamn,p_prov.ctacontaus, p_prov.ctacomple, p_prov.nombre, p_sadv.moneda,p_prov.iva,p_sadv.suma,p_sadv.impuesto,p_sadv.total,p_sadv.sumaus, p_sadv.impuestous, p_sadv.totalus, p_sadv.tc,tipo='2',p_prov.proveedor,p_sadv.gravado, p_sadv.tasacero");

		$this->db->where("year(p_sadv.fecha)='".$ejercicio."' and  month(p_sadv.fecha)='".$mes."' and p_sadv.estatus='P'");
		$this->db->join("p_prov","p_sadv.proveedor=p_prov.proveedor", "LEFT");
		$res = $this->db->get("p_sadv");
		$devoluciones=$res->result();
		$compras = array_merge($compras,$devoluciones);
		usort($compras, function($a, $b){
		    return strcmp($a->fecha, $b->fecha);
		});
		return $compras;
	}

	function get_productos_sat(){
		$this->db=$this->load->database('brasil',true);
		return $this->db->query('select id_fecha, id, producto, desc1, precio1 from p_prod where producto_sat IS NULL')->result();
	}
}

/* End of file compras_model.php */
/* Location: ./application/models/Reportes/compras_model.php */