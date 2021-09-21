<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Sistemas_model extends CI_Model {

	function get_actividades($departamento,$estatus,$responsable,$solicitante){
		$this->db=$this->load->database("interno",true);

		$this->db->where('id_departamento',$departamento);

		if($estatus=='1'){
			$this->db->order_by("orden");
			$this->db->where('estatus !=',0);
			$this->db->where('estatus !=',3);
			$this->db->order_by("fecha_ini");
		} 	
		else{
			$this->db->order_by("fecha_fin", "DESC");
			$this->db->where_in('estatus',array(0,3));
			//$this->db->limit(100);
		}
		if($responsable!=0)
			$this->db->where('id_responsable',$responsable);

		if($solicitante!=0)
			$this->db->where('id_solicitante',$solicitante);

		$r = $this->db->get('actividades');
		//echo $this->db->last_query();
		return $r->result();
	}
	function get_recurrentes($id_departamento){
		$this->db->select("'' as imagen_64, recurrente.id_recurrente,MAX(recurrente.limite) as limite,MAX(recurrente.titulo) as titulo,MAX(recurrente.descripcion) as descripcion,MAX(recurrente_datos.lectura) as valor");
		$this->db->where("id_departamento",$id_departamento);
		$this->db->join("recurrente_datos","recurrente.id_recurrente=recurrente_datos.id_recurrente AND recurrente_datos.fecha='".date("Y-m-d")."'", "LEFT");
		$this->db->group_by("recurrente.id_recurrente");
		$this->db->order_by("MAX(recurrente.limite)");
		$recurrente = $this->db->get('recurrente')->result();

		foreach ($recurrente as &$r ) {
			$path = getcwd()."\\assets\\archivos\\recurrentes\\rec_adjunto_".$r->id_recurrente.'_'.date("Y-m-d").'.png';
			if(file_exists($path)){
          		$r->imagen_64 = 'data:image/' . pathinfo($path, PATHINFO_EXTENSION) . ';base64,' . base64_encode(file_get_contents($path));
			}
			$this->db->select("recurrente_campo.*, recurrente_datos.responsable, recurrente_datos.lectura, recurrente_datos.observacion, recurrente_datos.fecha as fecha2");
			$this->db->join("recurrente_datos","recurrente_campo.id_recurrente_campo=recurrente_datos.id_recurrente_campo AND recurrente_datos.fecha='".date("Y-m-d")."'", "LEFT");
			$this->db->where("recurrente_campo.id_recurrente",$r->id_recurrente);
			$this->db->order_by("fecha2");
			$r->campos=$this->db->get('recurrente_campo')->result();
		}

		return $recurrente;
	}

	function alta_recurrente($data){
		$this->db->insert("recurrente",$data);
		return $this->db->insert_id();
	}
	function editar_recurrente($id_recurrente,$data){
		$this->db->where("id_recurrente",$id_recurrente);
		$this->db->update("recurrente",$data);
	}
	function get_recurrente($id_recurrente){
		$this->db->select("recurrente.*, CONVERT(nvarchar(8), limite, 108) as hora_limite, '' as campos");
		$this->db->where("id_recurrente",$id_recurrente);
		$recurrente = $this->db->get('recurrente')->row();

		$this->db->select("recurrente_campo.*, recurrente_datos.lectura, recurrente_datos.observacion");
		$this->db->join("recurrente_datos","recurrente_campo.id_recurrente_campo=recurrente_datos.id_recurrente_campo AND recurrente_datos.fecha='".date("Y-m-d")."'", "LEFT");
		$this->db->where("recurrente_campo.id_recurrente",$id_recurrente);
		$recurrente->campos=$this->db->get('recurrente_campo')->result();

		return $recurrente;
	}
	function get_recurrente_periodo($departamento, $fecha1, $fecha2,$recurrente){

		$this->db->select("recurrente.*, CONVERT(nvarchar(8), limite, 108) as hora_limite, '' as campos");
		$this->db->where("id_departamento",$departamento);
		if($recurrente!=0){
			$this->db->where("id_recurrente",$recurrente);
		}
		$this->db->order_by("limite");
		$recurrente = $this->db->get('recurrente')->result();
		foreach ($recurrente as &$r ) {
			$this->db->select("recurrente_campo.*, recurrente_datos.responsable, recurrente_datos.lectura, recurrente_datos.observacion, recurrente_datos.fecha as fecha2");
			$this->db->join("recurrente_datos","recurrente_campo.id_recurrente_campo=recurrente_datos.id_recurrente_campo AND recurrente_datos.fecha between '".$fecha1."' AND '".$fecha2."'", "LEFT");
			$this->db->where("recurrente_campo.id_recurrente",$r->id_recurrente);
			$this->db->order_by("fecha2");
			$r->campos=$this->db->get('recurrente_campo')->result();
		}

		return $recurrente;
	}
	function alta_recurrente_campo($data){
		$this->db->insert_batch("recurrente_campo",$data);
	}
	function eliminar_recurrentes_campo($id_recurrente,$aun_existen){
		$this->db->where("id_recurrente",$id_recurrente);
		$this->db->where_not_in("id_recurrente_campo",$aun_existen);
		$this->db->delete('recurrente_campo');
	}
	function editar_recurrente_campo($data){
		$this->db->update_batch('recurrente_campo', $data, 'id_recurrente_campo');
	}
	function eliminar_recurrente($id_recurrente){
		$this->db->where("id_recurrente",$id_recurrente);
		$this->db->delete("recurrente");
		$this->db->where("id_recurrente",$id_recurrente);
		$this->db->delete("recurrente_campo");
		$this->db->where("id_recurrente",$id_recurrente);
		$this->db->delete("recurrente_datos");
	}
	function registrar_recurrente($data){
		$this->db->insert_batch('recurrente_datos', $data);
	}
	function refrescar_recurrente($id_recurrente,$fecha){
		$this->db->where("id_recurrente",$id_recurrente);
		$this->db->where("fecha",$fecha);
		$this->db->delete("recurrente_datos");
	}
	//envio de notificacion por actividad fuera de rango o no checkeada
	function notificacion_actividad($id_departamento,$titulo,$recurrentes){
		//construccion de reporte de actividad
		$envio = FALSE;
		$mensaje="
		<div style='
				width:100%;
				padding:20px;
				background-color:#404040;
				font-family: Arial, Helvetica, sans-serif;
		'><div style='
				padding:15px;
				background-color:white;
				border-radius:10px;
		'>".$titulo."<br>";
		foreach ($recurrentes as $r) {
			if($r['tipo']=="0"&&$r['lectura']=="0"){
				$envio= TRUE;
				$mensaje.="<br> <b style='color:red;'> X </b> ".$r['tarea'];
			}
			if($r['tipo']=="1"&&($r['lectura']<$r['min']||$r['lectura']>$r['max'])){
				$envio= TRUE;
				$mensaje.="<br> <b style='color:red;'>".$r['lectura']." Fuera de rango (".$r['min']."-".$r['max'].") </b> ".$r['tarea'];
			}
		}
		$mensaje.="</div></div>";
		if($envio){
			//consulta de correo de departamento
			$this->db->select("correo_alerta");
			$this->db->where("id_departamento",$id_departamento);
			echo $mensaje;

			
			$this->envio_recurrente(
				$this->db->get("departamentos")->row()->correo_alerta,
				"Incidencias durante revision",
				$mensaje
			);
			
		}
	}
	function envio_recurrente($correos,$desc,$mensaje){
		$this->load->library('email');
        $this->email->set_newline("\r\n");
        $config['protocol'] = 'smtp';
        $config['smtp_host'] = 'mail.ferbis.com';
        $config['smtp_port'] = '587';
        $config['smtp_user'] = 'notificaciones@ferbis.com';
        $config['smtp_from_name'] = 'Notificaciones ferbis';
        $config['smtp_pass'] = 'Deli.3623';
        $config['wordwrap'] = TRUE;
        $config['newline'] = "\r\n";
        $config['mailtype'] = 'html';                       
        $this->email->initialize($config);
        $this->email->from($config['smtp_user'], $config['smtp_from_name']);
        $this->email->to($correos);
        $this->email->cc("sistemas@ferbis.com");
        //$this->email->to("sistemas@ferbis.com");
        $this->email->subject($desc);
		$this->email->message($mensaje);
		
        if($this->email->send()) {
            echo "1";        
        } else {
            print_r($this->email);
        }       
	}
	function borrar_recurrente_datos($id_recurrente,$fecha){
		$this->db->where("id_recurrente",$id_recurrente);
		$this->db->where("fecha",$fecha);
		$this->db->delete("recurrente_datos");
	}
	function get_personal($departamento){
		$this->db=$this->load->database("interno",true);
		$this->db->where('id_departamento',$departamento);
		$this->db->order_by('nombre');
		return $this->db->get('personal')->result();
	}
	function get_actividad($id_actividad){
		$this->db=$this->load->database("interno",true);
		$this->db->where('id_actividad',$id_actividad);
		$r=$this->db->get('actividades');
		return $r->row();
	}
	function alta_actividad($actividad){
		$this->db=$this->load->database("interno",true);
		$this->db->insert('actividades',$actividad);
		return $this->db->insert_id();
	}
	function editar_actividad($id_actividad,$actividad){
		$this->db=$this->load->database("interno",true);
		$this->db->where('id_actividad',$id_actividad);
		$this->db->update('actividades',$actividad);
	}
	function baja_actividad($id_actividad){
		$this->db=$this->load->database("interno",true);
		$this->db->where('id_actividad',$id_actividad);
		$this->db->delete('actividades');
	}
	function orden_actividades($batch_update){
		$this->db=$this->load->database("interno",true);
		$this->db->update_batch('actividades', $batch_update, 'id_actividad'); 
	}
	function borrar_orden_departamento($departamento){
		$this->db=$this->load->database("interno",true);
		$this->db->where('id_departamento',$departamento);
		$this->db->update('actividades',array('orden' => '0'));
	}
	function cambiar_fecha_actividad($id_actividad,$fecha){
		$this->db=$this->load->database("interno",true);
		$this->db->where('id_actividad',$id_actividad);
		$this->db->update('actividades',array('fecha_ini' => $fecha));
	}
	function get_departamentos(){
		$this->db=$this->load->database("interno",true);
		$r=$this->db->get('departamentos');
		return $r->result();
	}
	function get_checks($departamento){
		$this->db=$this->load->database("interno",true);
		$this->db->where('id_departamento',$departamento);
		$r=$this->db->get('checklist');
		return $r->result();
	}
	function get_estatus(){
		$this->db=$this->load->database("interno",true);
		$r = $this->db->get('estatus');
		return $r->result();
	}
	function get_checkados(){
		$this->db=$this->load->database("interno",true);
		$this->db->where('id_departamento',$departamento);
		$r=$this->db->get('registro_checklist');
		return $r->result();
	}
	function borrar_checks($departamento){
		$this->db=$this->load->database("interno",true);
		$this->db->where('id_departamento',$departamento);
		$this->db->delete('checklist');
	}
	function guarda_checks($checks){
		$this->db=$this->load->database("interno",true);
		$this->db->insert_batch('checklist',$checks);
	}
	function borrar_reg_checks($departamento,$fecha){
		$this->db=$this->load->database("interno",true);
		$this->db->where('id_departamento',$departamento);
		$this->db->where('fecha',$fecha);
		$this->db->delete('registro_checklist');
	}
	function guarda_reg_checks($checks){
		$this->db=$this->load->database("interno",true);
		$this->db->insert_batch('registro_checklist',$checks);
	}
	function get_reg_checks($departamento,$fecha){
		$this->db=$this->load->database("interno",true);
		$this->db->where('id_departamento',$departamento);
		$this->db->where('fecha',$fecha);
		$r = $this->db->get('registro_checklist');
		return $r->result();
	}
	function consulta_producto($codigo,$sucursal){
		$this->db=$this->load->database($sucursal,true);
		$almacenes = $this->db->get('p_sucu')->result();

		$existencias = "";
		foreach($almacenes as $al){
			$existencias.="exis".$al->sucursal.",";
		}
		$this->db->select('producto,desc1, '.$existencias.' precio1 as precio,um');
		$this->db->where('producto',$codigo);
		$this->db->or_where('cbarras',$codigo);
		$this->db->or_where('cbarras2',$codigo);
		$this->db->or_where('cbarras3',$codigo);
		$r = $this->db->get('p_prod');
		return $r->row();
	}
	function consulta_producto2($codigo,$sucursal){
		$this->db=$this->load->database($sucursal,true);
		$almacenes = $this->db->get('p_sucu')->result();

		$existencias = "";
		foreach($almacenes as $al){
			$existencias.="exis".$al->sucursal.",";
		}
		$this->db->select('producto,desc1, '.$existencias.' precio1 as precio,um');
		$this->db->where('producto',$codigo);
		$this->db->or_where('cbarras',$codigo);
		$this->db->or_where('cbarras2',$codigo);
		$this->db->or_where('cbarras3',$codigo);
		$r = $this->db->get('p_prod');
		return $r->row_array();
	}
	function almacenes($sucursal){
		$this->db=$this->load->database($sucursal,true);
		return $this->db->get('p_sucu')->result();
	}
	function tarjeta_frecuente($frecuente){
		$clienteF = "";
		$sucursales=array("brasil","sanmarcos","gastroshop");
		foreach ($sucursales as $s) {
			$this->db=$this->load->database($s,true);
			$this->db->select('clave, nombre, tarjeta');
			$this->db->where('tarjeta',$frecuente);
			$rt = $this->db->get('p_ctesfrec');
			if($rt->num_rows()>0){
				$rt = $rt->row();
				$clienteF = $rt->clave." - ".$rt->nombre." - ".$rt->tarjeta;
			}
		return $clienteF;
		}
	}
	function cuncluir_actividad($id_actividad,$fecha){
		$this->db=$this->load->database("interno",true);
		$this->db->where('id_actividad',$id_actividad);
		$this->db->update('actividades',array('fecha_fin' => $fecha,'estatus' => '0'));
	}
	function validar_usuario($usuario,$clave){
		$this->db=$this->load->database("interno",true);
		$this->db->where('correo',$usuario);
		$this->db->where('clave',$clave);
		$r=$this->db->get('personal');
		if($r->num_rows()>0){
			return 1;
		}else{
			return 0;
		}
	}
	function get_usuario_nombre($base,$usuario){
		$this->db=$this->load->database($base,true);
		$this->db->where('usuario',$usuario);
		$r=$this->db->get('p_usua');
		return $r->row()->nombre;
	}
	function get_bloqueos(){
		$sucursales = array('brasil','sanmarcos','gastroshop');
		$r=array();
		foreach($sucursales as $base){
			$this->db=$this->load->database($base,true);
			$r[]=$this->db->query("
				SELECT
   [PID]    = s.session_id,
   [base_datos]    = '".$base."',
   [Process]  = CONVERT(CHAR(1), s.is_user_process),
   [Login]         = s.login_name,  
   [Database]      = ISNULL(db_name(p.dbid), N''),
   [Task_State]    = ISNULL(t.task_state, N''),
   [Command]       = ISNULL(r.command, N''),
   [Application]   = ISNULL(s.program_name, N''),
   [Wait_Time (ms)]     = ISNULL(w.wait_duration_ms, 0),
   [Wait_Type]     = ISNULL(w.wait_type, N''),
   [Wait_Resource] = ISNULL(w.resource_description, N''),
   [Blocked_By]    = ISNULL(CONVERT (varchar, w.blocking_session_id), ''),
   [Head_Blocker]  =
        CASE
            -- session has an active request, is blocked, but is blocking others or session is idle but has an open tran and is blocking others
            WHEN r2.session_id IS NOT NULL AND (r.blocking_session_id = 0 OR r.session_id IS NULL) THEN '1'
            -- session is either not blocking someone, or is blocking someone but is blocked by another party
            ELSE ''
        END,
   [Total_CPU (ms)] = s.cpu_time,
   [Total_Physical I/O (MB)]   = (s.reads + s.writes) * 8 / 1024,
   [Memory]  = s.memory_usage * 8192 / 1024,
   [Open_Transactions] = ISNULL(r.open_transaction_count,0),
   [Login_Time]    = s.login_time,
   [Last_Request Start Time] = s.last_request_start_time,
   [Host_Name]     = ISNULL(s.host_name, N''),
   [Net_Address]   = ISNULL(c.client_net_address, N''),
   [Execution_Context_ID] = ISNULL(t.exec_context_id, 0),
   [Request_ID] = ISNULL(r.request_id, 0),
   [Workload_Group] = ISNULL(g.name, N'')
FROM sys.dm_exec_sessions s LEFT OUTER JOIN sys.dm_exec_connections c ON (s.session_id = c.session_id)
LEFT OUTER JOIN sys.dm_exec_requests r ON (s.session_id = r.session_id)
LEFT OUTER JOIN sys.dm_os_tasks t ON (r.session_id = t.session_id AND r.request_id = t.request_id)
LEFT OUTER JOIN
(
    -- In some cases (e.g. parallel queries, also waiting for a worker), one thread can be flagged as
    -- waiting for several different threads.  This will cause that thread to show up in multiple rows
    -- in our grid, which we don't want.  Use ROW_NUMBER to select the longest wait for each thread,
    -- and use it as representative of the other wait relationships this thread is involved in.
    SELECT *, ROW_NUMBER() OVER (PARTITION BY waiting_task_address ORDER BY wait_duration_ms DESC) AS row_num
    FROM sys.dm_os_waiting_tasks
) w ON (t.task_address = w.waiting_task_address) AND w.row_num = 1
LEFT OUTER JOIN sys.dm_exec_requests r2 ON (s.session_id = r2.blocking_session_id)
LEFT OUTER JOIN sys.dm_resource_governor_workload_groups g ON (g.group_id = s.group_id)--TAKE THIS dmv OUT TO WORK IN 2005
LEFT OUTER JOIN sys.sysprocesses p ON (s.session_id = p.spid)
ORDER BY Head_Blocker; 
			")->result();
		}
		
	return $r;
	}

	function terminar_proceso($base,$spid){
		$this->db=$this->load->database($base,true);
		$this->db->query('kill '.$spid);
	}

	function get_sinc_prod(){
		$this->db=$this->load->database('brasil',true);
		$this->db->select('producto,costo_ulti');
		$p_br = $this->db->get('p_prod')->result();

		//merge costos
		/*
		foreach($p_br as &$pb) {

			$pb->c_gs='_NA_';
			$pb->c_sm='_NA_';
			foreach($p_gs as $pg)if($pb->producto==$pg->producto){
				$pb->c_gs=$pg->costo_ulti;
			}
			foreach($p_sm as $ps)if($pb->producto==$ps->producto){
				$pb->c_sm=$ps->costo_ulti;
			}

		}
		*/

		return $p_br;
	}


}


/* End of file modelName.php */
/* Location: ./application/models/modelName.php */