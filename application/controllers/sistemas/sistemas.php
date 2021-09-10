<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Sistemas extends CI_Controller {
	public function __construct()
	{
		parent::__construct();
		//if(!$this->session->userdata('usuario')){ Redirect('Login');}
		$this->load->model('sistemas_model');
	}
	function index()
	{
		$data['departamento'] = $_GET['d'];
		$data['responsable'] = 0;if(isset($_GET['p'])) $data['responsable'] = $_GET['p'];
		$data['solicitante'] = 0;if(isset($_GET['s'])) $data['solicitante'] = $_GET['s'];
		
		//if($_GET['d']!=1&&$_GET['d']!=3&&$_GET['d']!=11&&$_GET['d']!=9){$data['bloqueo']='1';}
		$data['actividades1']=$this->sistemas_model->get_actividades($data['departamento'],'1',$data['responsable'],$data['solicitante']);
		$data['actividades2']=$this->sistemas_model->get_actividades($data['departamento'],'0',$data['responsable'],$data['solicitante']);
		$data['recurrentes']=$this->sistemas_model->get_recurrentes($data['departamento']);
		$data['personal']=$this->sistemas_model->get_personal($data['departamento']);
		$data['departamentos']=$this->sistemas_model->get_departamentos();
		$data['estatus']=$this->sistemas_model->get_estatus();
		$this->load->view('cabecera.php',$data);
		$this->load->view('sistemas/actividades');
		$this->load->view('sistemas/actividades_script_calendario');
		$this->load->view('pie.php');
	}
	function alta_recurrente(){
		$data_recurrente = Array(
			"id_departamento"	=>	$_POST['id_departamento'],
			"limite"			=>	$_POST['limite'],
			"titulo"			=>	$_POST['titulo'],
			"descripcion"		=>	$_POST['descripcion']
		);
		$id_recurrente = $this->sistemas_model->alta_recurrente($data_recurrente);
		$data_campos = Array();
		if(isset($_POST["c_nombre"])){
			for($i=0;$i<count($_POST["c_nombre"]);$i++){
				$data_campos[]=Array(
					"id_recurrente"=>$id_recurrente,
					"titulo"=>$_POST["c_nombre"][$i],
					"subtitulo"=>$_POST["c_desc"][$i],
					"tipo"=>$_POST["c_tipo"][$i],
					"fecha"=>date('Y-m-d')
				);
			}
			$this->sistemas_model->alta_recurrente_campo($data_campos);
		}

		Redirect("sistemas/sistemas?d=".$_POST['id_departamento']);
	}
	function datos_recurrente(){
		echo json_encode($this->sistemas_model->get_recurrente($_POST['id_recurrente']));
	}
	function reporte_recurrente(){
		$data['recurrentes'] = $this->sistemas_model->get_recurrente_periodo(
			$_POST['departamento'],
			sql_fecha($_POST['fecha1']),
			sql_fecha($_POST['fecha2']),
			$_POST['recurrente']
		);
		$data['recurrentes_todos']=$this->sistemas_model->get_recurrente_periodo($_POST['departamento'],sql_fecha($_POST['fecha1']),sql_fecha($_POST['fecha2']),0);
		$data['departamento'] = $_POST['departamento'];
		$data['fecha1'] = $_POST['fecha1'];
		$data['fecha2'] = $_POST['fecha2'];
		$data['recurrente'] = $_POST['recurrente'];
		$this->load->view('sistemas/reporte_recurrente',$data);
	}
	function show_recurrente(){
		$data['recurrentes'] = $this->sistemas_model->get_recurrente_periodo(
			$_POST['departamento'],
			sql_fecha($_POST['fecha1']),
			sql_fecha($_POST['fecha2']),
			$_POST['recurrente']
		);
		$data['departamento'] = $_POST['departamento'];
		$data['fecha1'] = $_POST['fecha1'];
		$data['fecha2'] = $_POST['fecha2'];
		$data['recurrente'] = $_POST['recurrente'];
		$this->load->view('sistemas/reporte_recurrente_consulta',$data);
	}
	function editar_recurrente(){
		$data_recurrente = Array(
			"id_departamento"	=>	$_POST['id_departamento'],
			"limite"			=>	$_POST['limite'],
			"titulo"			=>	$_POST['titulo'],
			"descripcion"		=>	$_POST['descripcion']
		);
		$this->sistemas_model->editar_recurrente($_POST['id_recurrente'],$data_recurrente);
		
		if(isset($_POST["id_recurrente_campo"]))
			$this->sistemas_model->eliminar_recurrentes_campo($_POST['id_recurrente'], $_POST["id_recurrente_campo"]);

		if(isset($_POST["c_nombre"])){
			$data_campos = Array();
			for($i=0;$i<count($_POST["c_nombre"]);$i++){
				$data_campos[]=Array(
					"id_recurrente"=>$_POST['id_recurrente'],
					"titulo"=>$_POST["c_nombre"][$i],
					"subtitulo"=>$_POST["c_desc"][$i],
					"tipo"=>$_POST["c_tipo"][$i],
					"fecha"=>date('Y-m-d')
				);
			}
			$this->sistemas_model->alta_recurrente_campo($data_campos);
		}
		
		if(isset($_POST["c_e_nombre"])){
			$data_campos = Array();
			for($i=0;$i<count($_POST["c_e_nombre"]);$i++){
				$data_campos[]=Array(
					"id_recurrente_campo"	=>$_POST["id_recurrente_campo"][$i],
					"titulo"				=>$_POST["c_e_nombre"][$i],
					"subtitulo"				=>$_POST["c_e_desc"][$i],
					"tipo"					=>$_POST["c_e_tipo"][$i],
					"min"					=>$_POST["min"][$i],
					"max"					=>$_POST["max"][$i],
					"fecha"					=>date('Y-m-d')
				);
			}
			$this->sistemas_model->editar_recurrente_campo($data_campos);
		}

		Redirect("sistemas/sistemas?d=".$_POST['id_departamento']);
	}
	function registrar_recurrente(){
		var_dump($_POST);
		$data_recurrente = Array();
		$revision_campos = Array();
		for($i=0;$i<count($_POST["id_recurrente"]);$i++){
			$data_recurrente[]=Array(
				"id_recurrente"			=>$_POST["id_recurrente"][$i],
				"id_recurrente_campo"	=>$_POST["id_recurrente_campo"][$i],
				"lectura" 				=>$_POST["lectura"][$i],
				"observacion" 			=>$_POST["observacion"][$i],
				"responsable" 			=>$_POST["responsable"],
				"fecha"=>date('Y-m-d')
			);
			$revision_campos[]=Array(
				"id_recurrente_campo"	=>$_POST["id_recurrente_campo"][$i],
				"lectura" 				=>$_POST["lectura"][$i],
				"min" 					=>$_POST["min"][$i],
				"max" 					=>$_POST["max"][$i],
				"tipo" 					=>$_POST["tipo"][$i],
				"tarea"					=>$_POST["tarea"][$i]
			);
		}
		$this->sistemas_model->borrar_recurrente_datos($_POST["id_recurrente"][0],date('Y-m-d'));
		$this->sistemas_model->registrar_recurrente($data_recurrente);

		$titulo = "<b>".$_POST['limite']." - ".$_POST['titulo']."</b><br>".$_POST['descripcion_tarea'];
		$this->sistemas_model->notificacion_actividad($_POST['id_departamento'],$titulo,$revision_campos);
		Redirect("sistemas/sistemas?d=".$_POST['id_departamento']);
	}
	function eliminar_recurrente(){
		$this->sistemas_model->eliminar_recurrente($_POST['id_recurrente']);
	}
	function duplicar_recurrente(){
		//creo recurrente
		$recurrente1 = $this->sistemas_model->get_recurrente($_POST['id_recurrente']);
		$data_recurrente = Array(
			"id_departamento"	=>	$recurrente1->id_departamento,
			"limite"			=>	$recurrente1->limite,
			"titulo"			=>	$recurrente1->titulo."(copia)",
			"descripcion"		=>	$recurrente1->descripcion,
		);
		$id_recurrente = $this->sistemas_model->alta_recurrente($data_recurrente);

		$data_campos = Array();
		foreach($recurrente1->campos as $campo){
			$data_campos[]=Array(
				"id_recurrente"=>$id_recurrente,
				"titulo"=>$campo->titulo,
				"subtitulo"=>$campo->subtitulo,
				"tipo"=>$campo->tipo,
				"fecha"=>date('Y-m-d')
			);
		}
		$this->sistemas_model->alta_recurrente_campo($data_campos);

		Redirect("sistemas/sistemas?d=".$recurrente1->id_departamento);
	}

	function alta_actividad_view($departamento){
		$data['fecha']=date('d/m/Y');
		if(isset($_POST['fecha'])){$data['fecha']=formato_fecha($_POST['fecha']);}
		$data['departamento'] = $departamento;
		$data['personal']=$this->sistemas_model->get_personal($data['departamento']);
		$data['estatus']=$this->sistemas_model->get_estatus();
		$data['departamentos']=$this->sistemas_model->get_departamentos();
		$this->load->view('sistemas/nueva_actividad',$data);
	}
	function alta_actividad(){
		if($_POST['estatus']!='0'&&$_POST['estatus']!='3'){unset($_POST['fecha_fin']);} //actividad no concluida
		$_POST['fecha_ini']=sql_fecha($_POST['fecha_ini']);//arreglar fecha sql
		$id_actividad=$this->sistemas_model->alta_actividad($_POST);

		//subir archivo
		if(isset($_FILES['adjunto'])){
			$_FILES['adjunto']['name'] 	=  "act_adjunto_".$id_actividad.".png";
			$fichero_subido  =  'C:/inetpub/wwwroot/mexquite/ferbis-interno/assets/archivos/'.basename($_FILES['adjunto']['name']);
			if(file_exists($fichero_subido)){ unlink($fichero_subido); }
			move_uploaded_file($_FILES['adjunto']['tmp_name'], $fichero_subido);
		}
		Redirect('sistemas/sistemas?d='.$_POST['id_departamento']);
	}

	function borrar_adjunto(){
		$archivo='C:/inetpub/wwwroot/mexquite/ferbis-interno/assets/archivos/'.$_POST['archivo'];
		if(file_exists($archivo)){ unlink($archivo); }
	}
	function editar_actividad_view($actividad){
		$data['act'] = $this->sistemas_model->get_actividad($actividad);
		$data['personal']=$this->sistemas_model->get_personal($data['act']->id_departamento);
		$data['estatus']=$this->sistemas_model->get_estatus();
		$data['departamentos']=$this->sistemas_model->get_departamentos();
		$this->load->view('sistemas/editar_actividad',$data);
	}
	function editar_actividad(){

		if($_POST['estatus']!='0'&&$_POST['estatus']!='3'){unset($_POST['fecha_fin']);} //actividad no concluida
		$_POST['fecha_ini'] 	=  sql_fecha($_POST['fecha_ini']);//arreglar fecha sql
		$id_actividad 			=  $_POST['id_actividad'];
		unset($_POST['id_actividad']); 

		$this->sistemas_model->editar_actividad($id_actividad,$_POST);
		//subir archivo
		if(isset($_FILES['adjunto'])&&$_FILES['adjunto']['name']!=''){
			$_FILES['adjunto']['name'] 	=  "act_adjunto_".$id_actividad.".png";
			$fichero_subido  =  'C:/inetpub/wwwroot/mexquite/ferbis-interno/assets/archivos/'.basename($_FILES['adjunto']['name']);
			if(file_exists($fichero_subido)){ unlink($fichero_subido); }
			move_uploaded_file($_FILES['adjunto']['tmp_name'], $fichero_subido);
		}
		Redirect('sistemas/sistemas?d='.$_POST['id_departamento']);

	}
	function cuncluir_actividad($id_actividad){
		$fecha = date('Y-m-d');
		$this->sistemas_model->cuncluir_actividad($id_actividad,$fecha);
	}
	function fecha_actividad(){
		$fecha = sql_fecha($_POST['fecha']);
		$id_actividad=$_POST['id_actividad'];
		$this->sistemas_model->cambiar_fecha_actividad($id_actividad,$fecha);
	}
	function baja_actividad($actividad){
		$this->sistemas_model->baja_actividad($actividad);
		$this->load->view('sistemas/editar_actividad',$data);
	}
	function actualizar_prioridad(){
		$actividades = $_POST['act'];
		$orden = $_POST['orden'];
		$batch_update=array();
		for($i=0;$i<count($actividades);$i++){ 
			$batch_update[]=array(
				'id_actividad' => $actividades[$i],
				'orden' => $orden[$actividades[$i]]
			);
		}
		//reordenar
		$this->sistemas_model->borrar_orden_departamento($_POST['dep_act']);
		$this->sistemas_model->orden_actividades($batch_update);
	}
	function imprimir_actividades(){
		$data['departamento'] = $_GET['d'];
		$data['responsable'] = 0;if(isset($_GET['p'])) $data['responsable'] = $_GET['p'];
		$data['solicitante'] = 0;if(isset($_GET['s'])) $data['solicitante'] = $_GET['s'];
		if($_GET['d']==2){$data['bloqueo']='1';}
		$data['actividades1']=$this->sistemas_model->get_actividades($data['departamento'],'1',$data['responsable'],$data['solicitante']);
		$data['actividades2']=$this->sistemas_model->get_actividades($data['departamento'],'0',$data['responsable'],$data['solicitante']);
		$data['personal']=$this->sistemas_model->get_personal($data['departamento']);
		$data['departamentos']=$this->sistemas_model->get_departamentos();
		$data['checks']=$this->sistemas_model->get_checks($data['departamento']);
		$data['reg_ch']=$this->sistemas_model->get_reg_checks($data['departamento'],date('Y-m-d'));
		$data['estatus']=$this->sistemas_model->get_estatus();
		$this->load->view('sistemas/actividades_imp',$data);
		$this->load->view('sistemas/actividades_script_calendario');
	}
	function imprimir_actividad(){
		$actividad=$_GET['a'];
		$data['act'] = $this->sistemas_model->get_actividad($actividad);
		$data['personal']=$this->sistemas_model->get_personal($data['act']->id_departamento);
		$data['departamentos']=$this->sistemas_model->get_departamentos();
		$data['estatus']=$this->sistemas_model->get_estatus();
		$this->load->view('sistemas/imp_actividad',$data);
	}

	// check list de actividades
	function cargar_check(){
		$data['fecha'] = $_POST['fecha'];
		$data['departamento'] = $_POST['dep'];
		$data['checks']=$this->sistemas_model->get_checks($data['departamento']);
		$data['reg_ch']=$this->sistemas_model->get_reg_checks($data['departamento'],sql_fecha($data['fecha']));
		$this->load->view('sistemas/check_view',$data);
	}
	//editar checks
	function check_edit(){
		$data['departamento'] = $_POST['dep'];
		$data['checks']=$this->sistemas_model->get_checks($data['departamento']);
		$this->load->view('sistemas/check_edit',$data);
	}
	//guardar cambios check
	function guarda_check(){
		$this->sistemas_model->borrar_checks($_POST['dep']);
		if(!isset($_POST['checks'])){Redirect("sistemas/sistemas?d=".$_POST['dep']);}
		$arreglo = array();
		foreach ($_POST['checks'] as $ch){$arreglo[]= array('id_departamento'=>$_POST['dep'],'descripcion'=>$ch);}
		$this->sistemas_model->guarda_checks($arreglo);
		Redirect("sistemas/sistemas?d=".$_POST['dep']);
	}
	/*GUARDAR CAMBIOS CHECK*/
	function guarda_reg_check(){
		$_POST['fecha']=sql_fecha($_POST['fecha']);
		$this->sistemas_model->borrar_reg_checks($_POST['dep'],$_POST['fecha']);
		//if(!isset($_POST['checks'])){Redirect("sistemas/sistemas?d=".$_POST['dep']);}
		if(isset($_POST['checks'])){
			foreach ($_POST['checks'] as $ch){
				$arreglo[]= array(
					'id_check'=>$ch,
					'fecha'=>$_POST['fecha'],
					'observacion'=>$_POST['observacion'],
					'id_departamento'=>$_POST['dep']
				);
			}
		}else{
			$arreglo[]= array(
					'id_check'=>"",
					'fecha'=>$_POST['fecha'],
					'observacion'=>$_POST['observacion'],
					'id_departamento'=>$_POST['dep']
				);
		}
		$this->sistemas_model->guarda_reg_checks($arreglo);
		Redirect("sistemas/sistemas?d=".$_POST['dep']);
	}
	function levantamiento(){
		$data['sucursal']='brasil';
		if(isset($_POST['codigo'])){
			$data['sucursal']=$_POST['sucursal'];
			//consultar datos de producto 
			$data['codigo']=$this->sistemas_model->consulta_producto2($_POST['codigo'],$_POST['sucursal']);
			$data['almacenes']=$this->sistemas_model->almacenes($_POST['sucursal']);
			if(count($data['codigo'])<1){
				$data['codigo']=new stdClass();
				$data['codigo']->desc1='NO EXISTE';
				$data['codigo']->precio='0';
				$data['codigo']->exis='0';
			}
			//en caso de ya existir no agregar
			//Guardar
		}
		
		$this->load->view('sistemas/inventario3',$data);
	}
	function archivo_banco(){
		/*
		$config['upload_path'] = 'C:/inetpub/wwwroot/mexquite/ferbis-interno/assets/archivos';
        $config['allowed_types'] = 'txt';
        $config['max_size'] = '1024';
        $config['max_width']  = '1024';
        $config['max_height']  = '768';
        $this->load->library('upload', $config);
        if ( ! $this->upload->do_upload())
        {
            $error = array('error' => $this->upload->display_errors());

            $this->load->view('upload_form', $error);
        }
        else
        {
            $data = array('upload_data' => $this->upload->data());

            $this->load->view('upload_success', $data);
        }
        */
        
		$data['texto']="";
		if(isset($_FILES['archivo'])){
			$texto = file_get_contents($_FILES['archivo']['tmp_name']);
			//substr ( string $string , int $start [, int $length ] ) : string
			$arreglo=explode("\n", $texto);
			foreach($arreglo as &$t){
				$c1=substr($t,0,21);
				$c2=substr($t,21,3);
				$c3=substr($t,24,16);
				$c4=substr($t,40,30);
				$c5=substr($t,70,30);
				$c6=substr($t,102);
				$data['texto'].=$c1."\t".$c2."\t".$c3."\t".$c4."\t".$c5."\t".$c6."\n";
			}
		}
		
		$this->load->view('cabecera.php');
		$this->load->view('sistemas/analiza_archivo',$data);
		$this->load->view('pie.php');
		
		/*
		$fileTmpPath = $_FILES['uploadedFile']['tmp_name'];
		$fileName = $_FILES['uploadedFile']['name'];
		$fileSize = $_FILES['uploadedFile']['size'];
		$fileType = $_FILES['uploadedFile']['type'];
		$fileNameCmps = explode(".", $fileName);
		$fileExtension = strtolower(end($fileNameCmps));
		$fp = $fp = fopen("/apr2/fichero.txt", "r");
		*/
	}

	function test(){
		$this->load->view('test');
	}
	function solicitudes(){

	}
	function solicitar_factura(){
		echo "SOLICITAR FACTURA";
	}
}

/* End of file sistemas.php */
/* Location: ./application/controllers/sistemas/sistemas.php */