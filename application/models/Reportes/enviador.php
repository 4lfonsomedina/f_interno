<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Enviador extends CI_Model {

	function envio_pdf($reporte,$desc,$correos){
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
		$this->email->message('Enviado desde Reporteador Ferbis');
		$this->email->attach('D:\Reportes\\'.$reporte);
		
        if($this->email->send()) {
            echo "1";        
        } else {
            print_r($this->email);
        }       
	}

}

/* End of file enviador.php */
/* Location: ./application/models/Reportes/enviador.php */