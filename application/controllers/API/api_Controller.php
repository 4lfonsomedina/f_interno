
<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Api_Controller extends CI_Controller {
	public function __construct()
	{
		parent::__construct();
		$this->load->model('Reportes/ventas_model');
		$this->load->model('sistemas_model');
		$this->load->model('api_model');
	}
	function venta_dia_service(){
		echo $this->ventas_model->get_venta_dia($_POST['sucursal'],$_POST['fecha']);
	}
	function verificar(){
		echo $this->sistemas_model->validar_usuario($_POST['correo'],$_POST['clave']);
	}
	function get_productos_dep(){
		echo json_encode($this->api_model->productos_dep($_POST['dep']));
	}
	function get_productos_filtro(){
		echo json_encode($this->api_model->productos_desc($_POST['desc']));
	}
	function get_precio(){
		echo json_encode($this->api_model->get_precio($_POST['productos']));
	}
	function get_producto(){
		echo json_encode($this->api_model->get_producto($_POST['producto']));
	}
	function get_ticket(){
		echo $this->ventas_model->get_venta_ticket($_POST['sucursal'],$_POST['ticket']);
	}
	function test_curl(){
		echo "Prueba exitosa";
	}
	function get_empleado(){
		echo json_encode($this->api_model->get_empleado($_POST['numero'],$_POST['rfc']));
	}
	function get_personal(){
		echo json_encode($this->api_model->get_personal($_POST['usuario'],$_POST['clave']));
	}
	function get_actividades(){
		$fecha="";if(isset($_POST['fecha'])){$fecha=$_POST['fecha'];}
		$activo="";if(isset($_POST['activo'])){$activo=$_POST['activo'];}
		echo json_encode($this->api_model->get_actividades($_POST['id_responsable'],$fecha,$activo));
	}
	function get_actividad(){
		echo json_encode($this->api_model->get_actividad($_POST['id_actividad']));
	}
	function get_recurrentes(){
		echo json_encode($this->sistemas_model->get_recurrentes($_POST['id_departamento']));
	}
	function get_recurrente(){
		echo json_encode($this->sistemas_model->get_recurrente($_POST['id_recurrente']));
	}
	function actividad_edit(){
		$data_post = json_decode($_POST['data']);
		$img_base64="";
		if(isset($data_post->imagen64))
			$img_base64 = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', str_replace(" ", "+", $data_post->imagen64)));
		if(strlen($img_base64)>1){
			file_put_contents(getcwd()."\\assets\\archivos\\act_adjunto_".$data_post->id_actividad.'.png', $img_base64); 
		}
		/*formacion de array*/
		$insertar = Array();
		if(isset($data_post->observaciones)){ $insertar = Array("observaciones" =>$data_post->observaciones); }
		if(isset($data_post->estatus)){ $insertar = Array("estatus" =>$data_post->estatus, "fecha_fin"=>date('Y-m-d')); }
		echo $data_post->estatus;
		$this->api_model->actividad_edit($data_post->id_actividad, $insertar);
	}
	function actualizar_tarea(){
		$this->api_model->actividad_edit($_POST['id_actividad'], json_decode($_POST['data']));
	}
	function registrar_recurrente(){

		$_POST = json_decode(gzinflate(base64_decode(strtr($_POST['data'], '-_', '+/'))));
		//almacenamos imagen de recurrente con id_recurrente_fecha
		$img_base64="";
		if(strlen($_POST->imagen64)>1){
			$img_base64 = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', str_replace(" ", "+", $_POST->imagen64)));
		}
		if(strlen($img_base64)>1){
			file_put_contents(getcwd()."\\assets\\archivos\\recurrentes\\rec_adjunto_".$_POST->id_recurrente[0].'_'.date('Y-m-d').'.png', $img_base64);
		}

		$data_recurrente = Array();
		$revision_campos = Array();
		//show_array($_POST);
		for($i=0;$i<count($_POST->id_recurrente);$i++){
			$data_recurrente[]=Array(
				"id_recurrente"			=>$_POST->id_recurrente[$i],
				"id_recurrente_campo"	=>$_POST->id_recurrente_campo[$i],
				"lectura" 				=>$_POST->lectura[$i],
				"observacion" 			=>$_POST->observacion[$i],
				"responsable" 			=>$_POST->responsable,
				"fecha"=>date('Y-m-d')
			);
			$revision_campos[]=Array(
				"id_recurrente_campo"	=>$_POST->id_recurrente_campo[$i],
				"lectura" 				=>$_POST->lectura[$i],
				"min" 					=>$_POST->min[$i],
				"max" 					=>$_POST->max[$i],
				"tipo" 					=>$_POST->tipo[$i],
				"tarea"					=>$_POST->tarea[$i]
			);
		}
		$this->sistemas_model->borrar_recurrente_datos($_POST->id_recurrente[0],date('Y-m-d'));
		$this->sistemas_model->registrar_recurrente($data_recurrente);
		$titulo = "<b>".$_POST->limite." - ".$_POST->titulo."</b><br>".$_POST->descripcion_tarea;
		//$this->sistemas_model->notificacion_actividad($_POST->id_departamento,$titulo,$revision_campos);
	}
	function envio_sms(){
		$this->api_model->envio_sms($_POST['mensaje'],$_POST['telefono']);
	}
}

/* End of file api_Controller.php */
/* Location: ./application/controllers/API/api_Controller.php */
//AIzaSyA2qnB3FUjiZH_wgd-7dNhP4eFrWDqmrzM




