<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class UCM_Model extends CI_Model {

	function conexion($parametros, $host = 'https://192.168.20.2', $user = 'cdrapi', $pass = 'deli3623', $port = '8443') {
	    $host=$host.":".$port."/cdrapi?format=csv";
	    echo $host."<br>".$port."<br>".$user."<br>".$pass."<br>";

	    $curl = curl_init();
		$cookie_jar = tempnam('tmp','cookie');
		/*curl_setopt($curl, CURLOPT_CAINFO, dirname(__FILE__)."/cacert.pem");*/
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_DIGEST);
	    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
	    curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);
	    curl_setopt($curl, CURLOPT_USERPWD, $user . ":" . $pass);
	    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
	    curl_setopt($curl, CURLOPT_COOKIEJAR, $cookie_jar);
	    curl_setopt($curl, CURLOPT_COOKIEFILE, $cookie_jar);
		curl_setopt($curl, CURLOPT_TIMEOUT, 50);
		curl_setopt($curl, CURLOPT_URL, $host);	
		return $curl;
	}
	function consulta_ucm($parametros){
		$curl = $this->conexion($parametros);
		$respuesta = curl_exec($curl);
		$httpcode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
		$message = curl_error($curl);
		echo $respuesta.$httpcode."Error --- $message ---";
		return json_decode($respuesta);
	}
}

/* End of file UCM_Model.php */
/* Location: ./application/models/UCM_Model.php */