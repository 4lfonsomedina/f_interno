<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Comprasvsventas_model extends CI_Model {
	
	function get_datos($tipo,$pvd,$pvh,$pcd,$pch){

		//seleccion de base brasil
		$this->db=$this->load->database('brasil',true);

		//$tipo=tipo de reporte
		if($tipo=0){ $tipo=" and p.linea = '005' "; }
		if($tipo=1){ $tipo=" and p.linea = '002' "; }
		if($tipo=2){ $tipo=" and p.linea = '001' "; }
		if($tipo=3){ $tipo=" and p.proveedor = '515' "; }

		//$pvd=periodo venta desde
		//$pvh=periodo venta hasta
		//$pcd=periodo compra desde
		//$pch=periodo compra hasta

		$query = "select 'COMPRA De ".$pcd." a ".$pch." | VENTA Y MERMA De ".$pvd." a ".$pvh."' as periodo, ".
           "c.proveedor, nombre, linea, producto, desc1, umprod, cantidad, ".
           "case when ventabr is null then 0 else ventabr end + case when ventasm is null then 0 else ventasm end + case when ventags is null then 0 else ventags end as ventas, ".
           "case when ventabr is null then 0 else ventabr end + case when ventasm is null then 0 else ventasm end + ".
           "case when ventags is null then 0 else ventags end + case when merma is null then 0 else merma end as vtamerma ".
           ", case when ventabr is null then 0 else ventabr end as ventabr, case when ventasm is null then 0 else ventasm end as ventasm ".

           ", case when ventags is null then 0 else ventags end as ventags, case when merma is null then 0 else merma end as merma ".
           ", case when donativo is null then 0 else donativo end as donativo ".

           ", case when asados is null then 0 else asados end as asados ".
           ", case when chef is null then 0 else chef end as chef ".
           ", case when cocina is null then 0 else cocina end as cocina".

           ", cantidad-(".
           " case when ventabr is null then 0 else ventabr end + case when ventasm is null then 0 else ventasm end + case when ventags is null then 0 else ventags end + ".
           " case when merma is null then 0 else merma end + ".
           " case when donativo is null then 0 else donativo end + ".
           " case when asados is null then 0 else asados end + ".
           " case when chef is null then 0 else chef end + ".
           " case when cocina is null then 0 else cocina end ) as diferencia".

           " from ( select c.proveedor, pv.nombre, d.linea, d.producto, p.desc1, p.um as umprod, sum(d.cantidad) as cantidad  , ".

           "( select sum(cantidad) from ( select cantidad from p_vede v where fecha BETWEEN '".$pvd."' and  '".$pvh."' and (case when v.producto = '688' then '67' else case when v.producto = '689' then '68' else v.producto end end)=d.producto ".
           " union all select cantidad*-1 from p_dede dd where dd.id_fecha BETWEEN '".$pvd."' and  '".$pvh."' and (case when dd.producto = '688' then '67' else case when dd.producto = '689' then '68' else dd.producto end end)=d.producto ) as v ) as ventabr, ".

           "( select sum(cantidad) from ( select cantidad from LOCALSANMARCOS.dbo.p_vede v where fecha BETWEEN '".$pvd."' and  '".$pvh."' and (case when v.producto = '688' then '67' else case when v.producto = '689' then '68' else v.producto end end)=d.producto ".
           "union all select cantidad*-1 from LOCALSANMARCOS.dbo.p_dede dd where dd.id_fecha BETWEEN '".$pvd."' and  '".$pvh."' and (case when dd.producto = '688' then '67' else case when dd.producto = '689' then '68' else dd.producto end end)=d.producto ) as v ) as ventasm, ".

           "( select sum(cantidad) from ( select cantidad from LOCALGASTROSHOP.dbo.p_vede v where fecha BETWEEN '".$pvd."' and  '".$pvh."' and (case when v.producto = '688' then '67' else case when v.producto = '689' then '68' else v.producto end end)=d.producto ".
           "union all select cantidad*-1 from LOCALGASTROSHOP.dbo.p_dede dd where dd.id_fecha BETWEEN '".$pvd."' and  '".$pvh."' and (case when dd.producto = '688' then '67' else case when dd.producto = '689' then '68' else dd.producto end end)=d.producto ) as v ) as ventags,  ".

           "(SELECT sum(sd.cantidad) as cantidad from p_saot s inner join p_saod sd on sd.salida=s.salida where s.fecha BETWEEN '".$pvd."' and  '".$pvh."' and destino in ('03','04') and (case when sd.producto = '688' then '67' else case when sd.producto = '689' then '68' else sd.producto end end) = sd.producto ) as salidasmxgs, ".

           "( SELECT sum(sd.cantidad) as cantidad from p_saot s inner join p_saod sd on sd.salida=s.salida where s.fecha BETWEEN '".$pvd."' and  '".$pvh."' and destino in ('05') and (case when sd.producto = '688' then '67' else case when sd.producto = '689' then '68' else sd.producto end end) = d.producto ) as cocina , ".

           "( SELECT sum(sd.cantidad) as cantidad from p_saot s inner join p_saod sd on sd.salida=s.salida where s.fecha BETWEEN '".$pvd."' and  '".$pvh."' and s.clave in ('019', '013') and (case when sd.producto = '688' then '67' else case when sd.producto = '689' then '68' else sd.producto end end) = d.producto 	) as asados , ".

           "( SELECT sum(sd.cantidad) as cantidad from p_saot s inner join p_saod sd on sd.salida=s.salida where s.fecha BETWEEN '".$pvd."' and  '".$pvh."' and s.clave in ('056') and (case when sd.producto = '688' then '67' else case when sd.producto = '689' then '68' else sd.producto end end) = d.producto 	) as chef , ".
           " ( select sum(suma) from ( ".
           "SELECT producto, sum(s.cantidad) as suma FROM p_saod s inner join p_movs m on m.clave=s.clave WHERE s.fecha BETWEEN '".$pvd."' and  '".$pvh."' ".
           "and m.descripcion like 'MERMA%' and s.producto = d.producto group by s.clave, m.descripcion, producto ".
           "UNION ALL ".
           "SELECT producto, sum(s.cantidad) as suma FROM LOCALSANMARCOS.dbo.p_saod s inner join p_movs m on m.clave=s.clave WHERE s.fecha BETWEEN '".$pvd."' and  '".$pvh."' ".
           "and m.descripcion like 'MERMA%' and s.producto = d.producto group by s.clave, m.descripcion, producto ".
           "UNION ALL  ".
           "SELECT producto, sum(s.cantidad) as suma FROM  LOCALGASTROSHOP.dbo.p_saod s inner join p_movs m on m.clave=s.clave WHERE s.fecha BETWEEN '".$pvd."' and  '".$pvh."' ".
           "and m.descripcion like 'MERMA%' and s.producto = d.producto group by s.clave, m.descripcion, producto ".
           ") as m ) as merma ".

           ", ( select sum(suma) from ( ".
           "SELECT producto, sum(s.cantidad) as suma FROM p_saod s inner join p_movs m on m.clave=s.clave WHERE s.fecha BETWEEN '".$pvd."' and  '".$pvh."' ".
           "and m.descripcion like 'DONATIVO%' and s.producto = d.producto group by s.clave, m.descripcion, producto ".
           "UNION ALL ".
           "SELECT producto, sum(s.cantidad) as suma FROM LOCALSANMARCOS.dbo.p_saod s inner join p_movs m on m.clave=s.clave WHERE s.fecha BETWEEN '".$pvd."' and  '".$pvh."' ".
           "and m.descripcion like 'DONATIVO%' and s.producto = d.producto group by s.clave, m.descripcion, producto ".
           "UNION ALL  ".
           "SELECT producto, sum(s.cantidad) as suma FROM  LOCALGASTROSHOP.dbo.p_saod s inner join p_movs m on m.clave=s.clave WHERE s.fecha BETWEEN '".$pvd."' and  '".$pvh."'".
           "and m.descripcion like 'DONATIVO%' and s.producto = d.producto group by s.clave, m.descripcion, producto ".
           ") as m ) as donativo ".

           " from p_compra c inner join p_compde d on d.compra=c.compra inner join p_prod p on p.producto=d.producto inner join p_prov pv on pv.proveedor=c.proveedor ".
           " where c.fecha BETWEEN ".$pcd." and  ".$pch.
           " ".$tipo."  ".
           //   "and c.proveedor = "263"   ".
           "group by pv.nombre, c.proveedor , d.producto, d.linea,p.desc1, p.um    ) as c order by proveedor, producto asc";

           echo $query;exit;
           $r=$this->db->query($query);

           return $r;
	}
	

	//funcion para traer todas las compras en un periodo de fechas indicado y sucursal indicada
	function get_ventas($sucursal,$fecha1,$fecha2,$productos){
		if($sucursal==1){$this->db=$this->load->database('brasil',true);}
		if($sucursal==2){$this->db=$this->load->database('sanmarcos',true);}
		if($sucursal==3){$this->db=$this->load->database('gastroshop',true);}
		if($sucursal==4){$this->db=$this->load->database('mexquite',true);}		
	}

}

/* End of file comprasvsventas_model.php */
/* Location: ./application/models/Reportes/comprasvsventas_model.php */