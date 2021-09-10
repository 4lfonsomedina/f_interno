<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Bizerba extends CI_Model {

	function get_productos(){
		//$this->PsExecute('cmd.exe /c C:\inetpub\wwwroot\mexquite\ferbis-interno\application\libraries\traer.bat');
		$fp = fopen("C:\\inetpub\\wwwroot\\mexquite\\ferbis-interno\\application\\libraries\\bizerba\\plst.txt", "r");
		$productos = Array();
		while (!feof($fp)){
		    $linea = utf8_encode(fgets($fp));
		    $productos[]=Array(
		    	"PLU"			=>substr($linea,0,6),			
		    	"DESCRIPCION"	=>substr($linea,6,60),
		    	"PESO"			=>substr($linea,66,1),
		    	"PRECIO"		=>floatval(substr($linea,67,4)).".".substr($linea,71,2),
		    	"ALTA"			=>substr($linea,73,1),
		    );
		}
		fclose($fp);
		return $productos;
	}
	function cambiar_ip($ip){
		$this->verificar_conexion($ip);
		/* TRAER */
		$fp = fopen("C:\\inetpub\\wwwroot\\mexquite\\ferbis-interno\\application\\libraries\\bizerba\\Traer.anw", "w");
		fwrite($fp, "D 1,S,0,0,0,0,N,0,".$ip.",O,N,UHR,25,C,3,3,0,0,0,0,0,0,0,401,0,0" . PHP_EOL);
		fwrite($fp, "H PLST" . PHP_EOL);
		fwrite($fp, "H MDST" . PHP_EOL);
		fclose($fp);

		/* ENVIAR */
		$fp = fopen("C:\\inetpub\\wwwroot\\mexquite\\ferbis-interno\\application\\libraries\\bizerba\\Enviar.anw", "w");
		fwrite($fp, "D 1,S,0,0,0,0,N,0,".$ip.",O,N,UHR,25,C,3,3,0,0,0,0,0,0,0,401,0,0" . PHP_EOL);
		fwrite($fp, "S PLST" . PHP_EOL);
		fwrite($fp, "S MDST" . PHP_EOL);
		fclose($fp);
	}
	function verificar_conexion($ip){
		$ping = exec("ping ".$ip." -n 1");
		$posicion_coincidencia = strpos($ping, 'Lost = 1');
		//se puede hacer la comparacion con 'false' o 'true' y los comparadores '===' o '!=='
		if ($posicion_coincidencia === false){}
		else{
	        echo "0";
	        exit;
	    }
	}
	function actualizar_txt($data){
		$fp = fopen("C:\\inetpub\\wwwroot\\mexquite\\ferbis-interno\\application\\libraries\\bizerba\\plst.txt", "w");
		foreach($data as $d){
			$d['desc'] = utf8_encode(str_pad( utf8_decode($d['desc']) , 60));
			$precio = explode(".", $d['precio'])[0].explode(".", $d['precio'])[1];
			$linea = str_pad($d['plu'], 6).$d['desc'].str_pad($d['unidad'], 1).str_pad($precio, 6, "0", STR_PAD_LEFT).str_pad($d['alta'], 1);
			fwrite($fp, $linea . PHP_EOL);
		}
		fclose($fp);
		$fp = fopen("C:\\inetpub\\wwwroot\\mexquite\\ferbis-interno\\application\\libraries\\bizerba\\mdst.txt", "w");
		foreach($data as $d){
			fwrite($fp,"PLST".str_pad($d['plu'], 6)."001011".str_pad($d['plu'], 6).".jpg" . PHP_EOL);
		}
		fclose($fp);
	}
	function alta_productos(){
		$this->PsExecute('cmd.exe /c C:\inetpub\wwwroot\mexquite\ferbis-interno\application\libraries\enviar.bat');
	}

	function PsExecute($command, $timeout = 60, $sleep = 2) {
        // First, execute the process, get the process ID

        $pid = $this->PsExec($command);

        if( $pid === false )
            return false;

        $cur = 0;
        // Second, loop for $timeout seconds checking if process is running
        while( $cur < $timeout ) {
            sleep($sleep);
            $cur += $sleep;
            // If process is no longer running, return true;

           echo "\n ---- $cur ------ \n";

            if( !PsExists($pid) )
                return true; // Process must have exited, success!
        }

        // If process is still running after timeout, kill the process and return false
        $this->PsKill($pid);
        return false;
    }

    function PsExec($commandJob) {

        $command = $commandJob.' ';
        exec($command,$op);
        $pid = (int)$op[0];
        if($pid!="") return $pid;

        return false;
    }

    function PsExists($pid) {

        exec("ps ax | grep $pid 2>&1", $output);

        while( list(,$row) = each($output) ) {

                $row_array = explode(" ", $row);
                $check_pid = $row_array[0];

                if($pid == $check_pid) {
                        return true;
                }

        }

        return false;
    }

    function PsKill($pid) {
        exec("kill -9 $pid", $output);
    }

}

/* End of file bizerba.php */
/* Location: ./application/models/bizerba.php */