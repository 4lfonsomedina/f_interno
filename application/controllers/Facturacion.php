<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Facturacion extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		
		if(!$this->session->userdata('usuario')){ Redirect('Login');}
		$this->load->model('factura_model');
		$this->load->model('Reportes/ventas_model');
	}

	function enviar_mexquite()
	{
		$datos['facturas']=$this->factura_model->facturas_mexquite();
		$this->load->view('cabecera.php',$datos);
		$this->load->view('factura/envio.php');
		$this->load->view('pie.php');
	}
	function enviar_brasil()
	{
		$datos['facturas']=$this->factura_model->facturas_brasil();

		$this->load->view('cabecera.php',$datos);
		$this->load->view('factura/envio.php');
		$this->load->view('pie.php');
	}
	//consultar los detalles de una factura
	function consulta_detalles(){
		$datos['folio']='';
		$datos['sucursal']='';
		if(isset($_POST['folio'])){
			$datos['folio']=$_POST['folio'];
			$datos['sucursal']=$_POST['sucursal'];
			$datos['detalles']=$this->factura_model->detalles_factura($datos['sucursal'],$datos['folio']);
			$datos['factura']=$this->factura_model->datos_factura($datos['sucursal'],$datos['folio']);
		}
		$this->load->view('cabecera.php',$datos);
		$this->load->view('factura/detalles.php');
		$this->load->view('pie.php');
	}
	function envio_factura(){
		$folio=$_POST['folio'];
		$nombre=$_POST['nombre'];
		$correo=$_POST['correo'];

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
        $this->email->to($correo);
        $this->email->cc("sistemas@ferbis.com");
        $this->email->subject('Factura electronica');
		$this->email->message('Estimado '.$nombre.'<br> Le hacemos llegar adjunto a este correo su Comprobante Fiscal Digital<br>');

		$this->email->attach('D:\Avattia\CFD\F-'.$folio.'.pdf');
		$this->email->attach('D:\Avattia\CFD\F-'.$folio.'.xml');
		
        if($this->email->send()) {
            echo "1";        
        } else {
            print_r($this->email);
        }       
	}
	function facturas_sin_timbrar(){
		//sucursales
		$data['sucursales'][0]['nombre']="BRASIL";
		$data['sucursales'][1]['nombre']="SAN MARCOS";
		$data['sucursales'][2]['nombre']="GASTROSHOP";
		$data['sucursales'][3]['nombre']="MEXQUITE";
		$data['sucursales'][0]['facturas']=$this->factura_model->facturas_sin_timbre("brasil");
		$data['sucursales'][1]['facturas']=$this->factura_model->facturas_sin_timbre("sanmarcos");
		$data['sucursales'][2]['facturas']=$this->factura_model->facturas_sin_timbre("gastroshop");
		$data['sucursales'][3]['facturas']=$this->factura_model->facturas_sin_timbre("mexquite");

		$this->load->view('cabecera.php',$data);
		$this->load->view('factura/factura_sin_timbre.php');
		$this->load->view('pie.php');
	}
	function anteriores(){
		$data['fecha_ini']=date('d/m/Y');
		$data['fecha_fin']=date('d/m/Y');
		$data['sucursal']='brasil';
		$data['sucursales']=array("BRASIL","SAN MARCOS","GASTROSHOP","MEXQUITE");
		if(isset($_POST['fecha_ini'])){
			$data['facturas']=$this->factura_model->anteriores($_POST['sucursal'],$_POST['fecha_ini'],$_POST['fecha_fin']);
			$data['fecha_ini']=$_POST['fecha_ini'];
			$data['fecha_fin']=$_POST['fecha_fin'];
			$data['sucursal']=$_POST['sucursal'];
		}
		$this->load->view('cabecera',$data);
		$this->load->view('factura/anterior_view');
		$this->load->view('pie');
	}
	function factura_diaria(){
		//sucursales
		$data['sucursales'][0]['nombre']="BRASIL";
		$data['sucursales'][1]['nombre']="SAN MARCOS";
		$data['sucursales'][2]['nombre']="GASTROSHOP";
		$data['sucursales'][3]['nombre']="MEXQUITE";
		$mes=date('m');
		if(isset($_POST['mes']))$mes=$_POST['mes'];
		$ano=date('Y');
		if(isset($_POST['ano']))$ano=$_POST['ano'];
		$data['sucursales'][0]['facturas']=$this->factura_model->factura_diaria("brasil",$mes,$ano);
		$data['sucursales'][1]['facturas']=$this->factura_model->factura_diaria("sanmarcos",$mes,$ano);
		$data['sucursales'][2]['facturas']=$this->factura_model->factura_diaria("gastroshop",$mes,$ano);
		$data['sucursales'][3]['facturas']=$this->factura_model->factura_diaria("mexquite",$mes,$ano);

		$data['mes']=$mes;
		$data['ano']=$ano;
		$this->load->view('cabecera.php',$data);
		$this->load->view('factura/factura_diaria.php');
		$this->load->view('pie.php');
	}
	function formas_pago(){
		$data['sucursal'] = "NA";
		$data['fecha1']=date('d/m/Y');
		$data['fecha2']=date('d/m/Y');
		$data['sucursales'] = array('brasil','sanmarcos','gastroshop');
		$data['suc']=array("BRASIL","SAN MARCOS","GASTROSHOP","MEXQUITE");
		if(isset($_POST['fecha1'])){
			$data['fecha1']=$_POST['fecha1'];
			$data['fecha2']=$_POST['fecha2'];
			$data['ventas'] = $this->ventas_model->get_formas_pago($data['sucursales'],$data['fecha1'],$data['fecha2']);
			$data['formas_pago']=$this->ventas_model->formas_pago();
			//formas de pago con su totalidad
			foreach($data['ventas'] as $vv)
				foreach($vv as $v)
					foreach($data['formas_pago'] as &$fp)
						if($fp->clave==$v->clave)
						{
							$fp->incr+=$v->importe;
						}
		}
		$this->load->view('cabecera.php');
		$this->load->view('Reportes/formas_pago_view.php',$data);
		$this->load->view('pie.php');
	}
}

/* End of file FacturaController.php */
/* Location: ./application/controllers/FacturaController.php */