<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class InventarioController extends CI_Controller {
	public function __construct(){
		parent::__construct();
		if(!$this->session->userdata('usuario')){ Redirect('Login');}
		$this->load->model('InventarioModel');
		$this->load->model('bizerba');
	}
	public function index(){
		$this->load->view('cabecera');
		$this->load->view('inventario/tablero');
		$this->load->view('pie');
	}
	function precios_basculas_fyv(){
		$this->load->view('cabecera');
		$this->load->view('inventario/fyv');
		$this->load->view('pie');
	}
	function get_bizerba(){
		$this->bizerba->cambiar_ip($_POST['ip']);
		$tabla="";
		$productos = $this->bizerba->get_productos();
		foreach ($productos as $p)if($p['DESCRIPCION']!=''){

			$pkg="";$ppza="";
			if($p['PESO']=='0'){$pkg='selected';}else{$ppza='selected';}

			$palta="";$pbaja="";
			if($p['ALTA']=='0'){$palta='selected';}else{$pbaja='selected';}

			//$p['PRECIO']

			$tabla.= "<tr>";
		    $tabla.= "<td><input type='hidden' class='bz_plu' value='".$p['PLU']."'>".$p['PLU']."</td>"; 			
		    $tabla.= "<td><input type='text' id='act_des_".$p['PLU']."' class='form-control bz_desc' value='".$p['DESCRIPCION']."' ></td>"; 	
		    $tabla.= "<td><select class='form-control bz_unidad' id='act_uni_".$p['PLU']."'>". 
		    				"<option value='0' ".$pkg.">KG</option>".
		    				"<option value='1' ".$ppza.">PZA</option>".
		    		 "</select></td>";
		    $tabla.= "<td><input type='text' id='act_pre_".$p['PLU']."' class='form-control bz_precio' value='".$p['PRECIO']."' style='text-align:right'></td>";
		    $tabla.= "<td><select class='form-control bz_alta'>". 
		    				"<option value='0' ".$palta.">ALTA</option>".
		    				"<option value='1' ".$pbaja.">BAJA</option>".
		    		 "</select></td>"; 
		    $tabla.= "</tr>";
		}
		echo $tabla;
	}
	function subir_bascula(){
		$data = Array();
		$plu = explode(",",  $_POST['plu']);
		$desc = explode(",",  $_POST['desc']);
		$unidad = explode(",",  $_POST['unidad']);
		$precio = explode(",",  $_POST['precio']);
		$alta = explode(",",  $_POST['alta']);

		for($i=0;$i<count($plu);$i++)if($plu[$i]!=''){
			$data[] = Array(
				'plu' => $plu[$i],
				'desc' => str_replace("Ñ", "N", $desc[$i]),
				'unidad' => $unidad[$i],
				'precio' => $precio[$i],
				'alta' => $alta[$i]
			);
		}
		$this->bizerba->cambiar_ip($_POST['ip']);
		$this->bizerba->actualizar_txt($data);
		$this->bizerba->alta_productos();
		echo "Alta de productos exitosa";
	}
	function sincronizar_avattia(){
		$this->load->model('api_model');
		echo json_encode($this->api_model->get_precio_bizerba($_POST['productos']));
	}
	function alta_producto_fyv(){
		$this->load->model('api_model');
		$this->api_model->asignacion_cbarras3($_POST['plu'],$_POST['producto']);
		$tabla="";
		$tabla.= "<tr>";
		    $tabla.= "<td><input type='hidden' class='bz_plu' value='".$_POST['plu']."'>".$_POST['plu']."</td>"; 			
		    $tabla.= "<td><input type='text' id='act_des_".$_POST['plu']."' class='form-control bz_desc' value='' ></td>"; 	
		    $tabla.= "<td><select class='form-control bz_unidad' id='act_uni_".$_POST['plu']."'>". 
		    				"<option value='0' >KG</option>".
		    				"<option value='1' >PZA</option>".
		    		 "</select></td>";
		    $tabla.= "<td><input type='text' id='act_pre_".$_POST['plu']."' class='form-control bz_precio' value='' style='text-align:right'></td>";
		    $tabla.= "<td><select class='form-control bz_alta'>". 
		    				"<option value='0' >ALTA</option>".
		    				"<option value='1' >BAJA</option>".
		    		 "</select></td>"; 
		    $tabla.= "</tr>";
		echo $tabla;
	}
	function get_solicitudes(){
		$data['solicitudes']=$this->InventarioModel->get_solicitudes($_POST['status']);
		$this->load->view('inventario/solicitudes', $data);
	}
	function nueva_solicitud(){
		$data=1;
		$this->load->view('cabecera', $data);
		$this->load->view('inventario/nueva', $data);
		$this->load->view('pie');
	}
	function cambio_estatus(){
		$this->InventarioModel->update_status($_POST['id_solicitud']);
		echo "1";
	}
	function imprimir_solicitud(){
		$data['solicitud']= $this->InventarioModel->get_solicitud($_GET['id_solicitud']);
		$this->load->view('inventario/imprimir', $data);
	}
	function buscar_producto(){
		echo json_encode($this->InventarioModel->get_producto_brasil($_POST['producto']));
	}
	function buscar_producto_desc(){
		echo json_encode($this->InventarioModel->get_producto_brasil_desc($_POST['desc']));
	}
	function procesar_solicitud(){
		//crear la solicitud
		$id_solicitud = $this->InventarioModel->crear_solicitud($_POST['solicitante']);

		$insertar = array();
		for($i=0;$i<count($_POST['producto']);$i++){
			$insertar[]=array(
				"producto" 		=> $_POST['producto'][$i],
				"descripcion" 	=> $_POST['descripcion'][$i],
				"um" 			=> $_POST['um'][$i],
				"cantidad" 		=> $_POST['cantidad'][$i],
				"id_solicitud" 	=> $id_solicitud
			);
		}

		//crear la solicitud
		$this->InventarioModel->crear_solicitud_det($insertar);
		$this->crear_txt($id_solicitud);

		Redirect("InventarioController");
	}
	function crear_txt($id_solicitud){
		$this->InventarioModel->crear_archivo($id_solicitud);
	}
}

/* End of file InventarioController.php */
/* Location: ./application/controllers/InventarioController.php */