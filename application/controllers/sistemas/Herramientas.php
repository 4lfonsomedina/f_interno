<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Herramientas extends CI_Controller {
	public function __construct()
	{
		parent::__construct();
		$this->load->model('restmex_model');
		$this->load->model('Reportes/ventas_model');
		$this->load->model('UCM_Model');
	}
 	function monitor_cajas(){
		 $this->load->view('sistemas\restaurar_fecha');
	}

	

	function monitor_frecuentes(){
		$data['sucursal']='brasil';
		$data['ano']=date("Y");
		$data['mes']=date("m");
		if(isset($_POST['ano'])){
			$data['ventas']=$this->restmex_model->get_ventas_frecuentes($_POST['sucursal'],$_POST['ano'],$_POST['mes']);
			$data['sucursal']=$_POST['sucursal'];
			$data['ano']=$_POST['ano'];
			$data['mes']=$_POST['mes'];
		}
		$this->load->view('cabecera');
		$this->load->view('herramientas/monitor_frecuentes',$data);
		$this->load->view('pie');
	}
	function canjes_frec(){
		$canjes=$this->restmex_model->get_canjes($_POST['suc'],$_POST['frec']);
		if(count($canjes)>0)
			foreach($canjes as $c)
				echo "<tr><td>".$c->id."</td><td>".formato_fecha($c->fecha)."</td><td>".$c->ptoscan."</td></tr>";
		else
			echo "Sin Canjes";
	}
	//monitor de metas
	function monitor_metas2(){
		$data['bloqueo']='1';//bloqueo de menu
		$data['sucursal']='mexquite';
		$data['fecha']=date('d/m/Y');
		if(isset($_POST['fecha'])){
			$data['fecha']=$_POST['fecha'];
			$data['fecha0']=resta_un_ano($data['fecha']);
			$data['fecha0']=siguiente_dia_igual($data['fecha'],$data['fecha0']);
			$data['productos']=$this->ventas_model->get_ventas_vs_ventas($data['sucursal'],$data['fecha'],$data['fecha0']);
			//show_array($data['productos']);
		}
		$this->load->view('cabecera',$data);
		$this->load->view('herramientas/monitor_metas_view');
		$this->load->view('pie');
	}

	function encuestas(){
		$data['encuestas']=$this->restmex_model->get_encuestas();
		$this->load->view('herramientas/encuestas',$data);
	}
	function encuesta_mexquite(){
		$this->load->view('herramientas/encuesta_mexquite',$_POST);
	}
	function guardar_encuesta(){
		$this->restmex_model->guardar_encuesta($_POST);
		echo "<br><br><br><br><h1 align='center'> Muchas gracias!<br><br><br><br><br><br><br><br><a href='".site_url('sistemas/herramientas/encuestas')."'> < - Regresar</a> </h1>";
	}
	function encuesta($id_encuesta){
		$data['encuesta'] = $this->restmex_model->get_encuesta($id_encuesta);
		$this->load->view('herramientas/encuesta_view', $data);
	}
	function mover_mexquite(){

		$data['f1'] = date('d/m/Y');
		$data['f2'] = date('d/m/Y', strtotime('-1 day'));
		if(isset($_POST['f1'])){
			$data['f1']=$_POST['f1'];
			$data['f2']=$_POST['f2'];
			$f1=sql_fecha($_POST['f1']);
			$f2=sql_fecha($_POST['f2']);
			$data['query'] = "UPDATE p_vent SET id_fecha='".$f2." 00:00:00.000',pedido='".$f2." 00:00:00.000' where id_fecha='".$f1."'\n\n".
"UPDATE p_fact SET id_fecha='".$f2." 00:00:00.000',fecha='".$f2." 00:00:00.000',f_pago='".$f2." 00:00:00.000', vence='".$f2." 00:00:00.000' where id_fecha='".$f1."'\n\n".
"UPDATE p_vede SET fecha='".$f2." 00:00:00.000',id_fecha='".$f2." 00:00:00.000' where id_fecha='".$f1."'\n\n".
"UPDATE p_factdet SET id_fecha='".$f2." 00:00:00.000' where id_fecha='".$f1."'";
		}
		$this->load->view('cabecera');
		$this->load->view('herramientas/mover_mexquite_view',$data);
		$this->load->view('pie');
	}

	function levantamiento($sucursal){
		$sucursales=array("NA","brasil","sanmarcos","gastroshop");
		$data['sucursal']=$sucursal;
		if(isset($_POST['codigo'])){
			$data['sucursal']=$sucursal;
			//consultar datos de producto 
			$data['codigo']=$this->sistemas_model->consulta_producto($_POST['codigo'],$sucursales[$sucursal]);
			if(count($data['codigo'])<1){
				$data['codigo']=new stdClass();
				$data['codigo']->desc1='NO EXISTE';
				$data['codigo']->precio='0';
				$data['codigo']->exis='0';
			}
			//en caso de ya existir no agregar
			//Guardar
		}
		
		$this->load->view('sistemas/inventario2',$data);
	}

	function frecuente(){
		$data=array();
		if(isset($_POST['frecuente'])){
			$data['clienteF']=$this->sistemas_model->tarjeta_frecuente($_POST['frecuente']);
		}
		$this->load->view('cabecera');
		$this->load->view('sistemas/cliente_frecuente',$data);
		$this->load->view('pie');
	}

	//Consulta de bloqueos
	function get_procesos_b(){
		echo json_encode($this->sistemas_model->get_bloqueos());
	}
	function monitor_bloqueos(){
		$data['x']=1;
		if(isset($_GET['caja'])){$data['bloqueo']='1';}
		$this->load->view('cabecera',$data);
		$this->load->view('herramientas/monitor_block');
		$this->load->view('pie');
	}
	function kill_proceso($spid,$base){
		$this->sistemas_model->terminar_proceso($base,$spid);
		echo "Proceso Eliminado...";
	}
	function api_ucm(){
		$this->load->view('cabecera');
		$this->load->view('herramientas/api_ucm');
		$this->load->view('pie');
	}
	function consulta_ucm(){
		$resp = $this->UCM_Model->consulta_ucm("startTime=2020-04-24T00:00:00-06:00&endTime=2020-04-24T23:59:59-06:00");
		show_array($resp);
	}
	function sinc_ult_costo(){
		$data['productos']=$this->sistemas_model->get_sinc_prod();
		$this->load->view('cabecera');
		$this->load->view('herramientas/sinc_costo',$data);
		$this->load->view('pie');
	}
}

/* End of file Herramientas.php */
/* Location: ./application/controllers/sistemas/Herramientas.php */