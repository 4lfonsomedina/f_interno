<?php 
function dame_fecha($datetime){
	if($datetime!="")	return explode(" ", $datetime)[0];
	else 				return "";
  
}
function dame_hora($datetime){
	if($datetime!="")	explode(".",explode(" ", $datetime)[1])[0];
	else 				return "";
}
function folio_solicitud($folio){
  	return str_pad($folio, 6, "0", STR_PAD_LEFT);
}

function show_array($array){
	echo "<pre>";print_r($array);echo "</pre>";
	exit;
}
function show_array2($array){
	echo "<pre>";print_r($array);echo "</pre>";
}
function status_solicitud($status){
	$st = "PENDIENTE";
	if($status==1){$st = "PROCESADO";}
	return $st;
}
function contador_titulo($array,$columna,$buscar){
	$cont=0;
	foreach ($array as $a)
		if($a->$columna==$buscar)
			$cont++;
	return $cont;
}
function get_client_ip() {
    $ipaddress = '';
    if (getenv('HTTP_CLIENT_IP'))
        $ipaddress = getenv('HTTP_CLIENT_IP');
    else if(getenv('HTTP_X_FORWARDED_FOR'))
        $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
    else if(getenv('HTTP_X_FORWARDED'))
        $ipaddress = getenv('HTTP_X_FORWARDED');
    else if(getenv('HTTP_FORWARDED_FOR'))
        $ipaddress = getenv('HTTP_FORWARDED_FOR');
    else if(getenv('HTTP_FORWARDED'))
       $ipaddress = getenv('HTTP_FORWARDED');
    else if(getenv('REMOTE_ADDR'))
        $ipaddress = getenv('REMOTE_ADDR');
    else
        $ipaddress = 'UNKNOWN';
    return $ipaddress;
}
function descrip_mes($mes){
	if($mes==1){$resp="ENERO";}
	if($mes==2){$resp="FEBRERO";}
	if($mes==3){$resp="MARZO";}
	if($mes==4){$resp="ABRIL";}
	if($mes==5){$resp="MAYO";}
	if($mes==6){$resp="JUNIO";}
	if($mes==7){$resp="JULIO";}
	if($mes==8){$resp="AGOSTO";}
	if($mes==9){$resp="SEPTIEMBRE";}
	if($mes==10){$resp="OCTUBRE";}
	if($mes==11){$resp="NOVIEMBRE";}
	if($mes==12){$resp="DICIEMBRE";}
	return $resp;
}
function fecha_nice($fecha){
	$r=explode("/", $fecha);
	return $r[0]." ".descrip_mes($r[1]);
}
function formato_hora($hora){
	if($hora==''){return "";}
	$hora_temp=$hora;
	$hora = (explode(":", $hora)[0]+0);
	$formato = 'am'; 
	if($hora>12){$hora=$hora-12; $formato='pm';}
	return $hora.":".explode(":", $hora_temp)[1]." ".$formato;
}
function formato_fecha($fecha){
	if($fecha==''){return "";}
	$r=explode(" ", $fecha);
	$r=explode("-", $r[0]);
	return $r[2]."/".$r[1]."/".$r[0];
}
function formato_fecha2($fecha){
	if($fecha==''){return "";}
	$r=explode(" ", $fecha);
	$r=explode("-", $r[0]);
	$dia=dia_texto($r[2],$r[1],$r[0]);
	return $r[2]."/".$r[1]."/".$r[0]." ".$dia;
}
function resta_un_ano($fecha){
	if($fecha==''){return "";}
	$r=explode("/", $fecha);
	return $r[0]."/".$r[1]."/".($r[2]-1);
}
function sql_fecha($fecha){
	$r=explode("/", $fecha);
	if(count($r)==3)
		return $r[2]."-".$r[1]."-".$r[0];
	else
		return $fecha;
}
//funcion que resta meses, semanas, dias - segun sea el periodo
function periodos_fechas($fecha,$periodo){
	$fechas=array();
	//si el periodo es de dias
	if($periodo=='dia'){
		$fechas[]=$fecha;
		$fechas[]=resta_dias($fecha,1);
		$fechas[]=resta_dias($fecha,2);
	}
	//si el periodo es de semana
	if($periodo=='semana'){
		$fechas[]=$fecha;
		$fechas[]=resta_dias($fecha,7);
		$fechas[]=resta_dias($fecha,14);
	}
	//si el periodo es de mes
	if($periodo=='mes'){
		$fechas[]=$fecha;
		$fechas[]=resta_meses($fecha,1);
		$fechas[]=resta_meses($fecha,2);
	}
	return $fechas;
}
//traducir dias
function dia_texto($dia,$mes,$ano){
	$dia_f = date("l", mktime(0, 0, 0, $mes, $dia, $ano));
	$r="";
	if($dia_f=="Sunday"){$r="Domingo";}
	if($dia_f=="Monday"){$r="Lunes";}
	if($dia_f=="Tuesday"){$r="Martes";}
	if($dia_f=="Wednesday"){$r="Miercoles";}
	if($dia_f=="Thursday"){$r="Jueves";}
	if($dia_f=="Friday"){$r="Viernes";}
	if($dia_f=="Saturday"){$r="Sabado";}
	return $r;
}

//traducir dias desde fecha 2019-09-23
function dia_texto2($fecha){
	$fecha=explode("/", formato_fecha($fecha));
	$dia_f = date("l", mktime(0, 0, 0, $fecha[1], $fecha[0], $fecha[2]));
	$r="";
	if($dia_f=="Sunday"){$r="Domingo";}
	if($dia_f=="Monday"){$r="Lunes";}
	if($dia_f=="Tuesday"){$r="Martes";}
	if($dia_f=="Wednesday"){$r="Miercoles";}
	if($dia_f=="Thursday"){$r="Jueves";}
	if($dia_f=="Friday"){$r="Viernes";}
	if($dia_f=="Saturday"){$r="Sabado";}
	return $r;
}

function extraer_solo_dia($fecha,$posicion){ //2019-09-23
	$fecha=explode("-", $fecha);
	return $fecha[2];
}

//traer 4 semanas atras diaxdia (d-m-Y)
function fechas_anteriores($fecha_ini){
	$fecha_ini = sql_fecha($fecha_ini);
	$fechas[]=sql_fecha(date("d/m/Y",strtotime("- 1 week",strtotime($fecha_ini)))); 
	$fechas[]=sql_fecha(date("d/m/Y",strtotime("- 2 week",strtotime($fecha_ini))));
	$fechas[]=sql_fecha(date("d/m/Y",strtotime("- 3 week",strtotime($fecha_ini))));
	$fechas[]=sql_fecha(date("d/m/Y",strtotime("- 4 week",strtotime($fecha_ini))));
	return $fechas;
}

function calcular_mayor($numeros){
	$mayor=0;
	foreach($numeros as $n){ if($n>$mayor){$mayor=$n;} }
	return $mayor;
}
function calculo_pedido($top,$fisico,$stok){
	if($top+$stok-$fisico>0)
		return $top+$stok-$fisico;
	else
		return 0;
	/*if(no_negativo($top-$fisico)<$stok)
		return $stok;
	else return no_negativo($top-$fisico);
	*/
}
function no_negativo($numero){
	if($numero<0) return 0;
	else return $numero;
}
function extraer_sql_fecha($extraer,$fecha){//2019-04-13
	$fecha = explode("-", $fecha);
	if($extraer=='ano'){return $fecha[0];}
	if($extraer=='mes'){return $fecha[1];}
	if($extraer=='dia'){return $fecha[2];}
}
function dias_entre_fechas($fecha1,$fecha2){ //d/m/Y
	$date1 = new DateTime(sql_fecha($fecha1));
	$date2 = new DateTime(sql_fecha($fecha2));
	$diff = $date1->diff($date2);
	return $diff->days;
}
function resta_dias($fecha,$dias){ //d/m/Y
	$fecha = explode("/", $fecha);
	$fecha = $fecha[0]."-".$fecha[1]."-".$fecha[2];
	$fecha = date("d-m-Y",strtotime($fecha."- ".$dias." days"));
	$fecha = explode("-", $fecha);
	return $fecha[0]."/".$fecha[1]."/".$fecha[2];
}
function resta_meses($fecha,$meses){ //d/m/Y
	$fecha = explode("/", $fecha);
	$fecha = $fecha[0]."-".$fecha[1]."-".$fecha[2];
	$fecha = date("d-m-Y",strtotime($fecha."- ".$meses." months"));
	$fecha = explode("-", $fecha);
	return $fecha[0]."/".$fecha[1]."/".$fecha[2];
}
function resta_anos($fecha,$anos){ //d/m/Y
	$fecha = explode("/", $fecha);
	$fecha = $fecha[0]."-".$fecha[1]."-".$fecha[2];
	$fecha = date("d-m-Y",strtotime($fecha."- ".$anos." years"));
	$fecha = explode("-", $fecha);
	return $fecha[0]."/".$fecha[1]."/".$fecha[2];
}
function suma_dias($fecha,$dias){ //d/m/Y

	$fecha = explode("/", $fecha);
	$fecha = $fecha[0]."-".$fecha[1]."-".$fecha[2];
	$fecha = date("d-m-Y",strtotime($fecha."+ ".$dias." days"));
	$fecha = explode("-", $fecha);

	return $fecha[0]."/".$fecha[1]."/".$fecha[2];
}
function siguiente_dia_igual($fecha1,$fecha2){
	$dia1= nombre_dia(sql_fecha($fecha1));
	$dia2= nombre_dia(sql_fecha($fecha2));
	$dias=1;
	while($dia1!=$dia2){
		$fecha2 = suma_dias($fecha2,$dias);
		$dia2 = nombre_dia(sql_fecha($fecha2));
	}
	return $fecha2;
	//echo $dia1."-".$fecha1." ".$dia2."-".$fecha2." ".$dias; exit;
}
function nombre_dia($fecha){ //yyyy-mm-dd
   	$dias = array('DOM', 'LUN', 'MAR', 'MIE', 'JUE', 'VIE', 'SAB');
	$fechats = strtotime($fecha); 
	return $dias[date('w', $fechats)];
}
function mayus_suc($suc){
	$ret="";
	if($suc=='brasil'){$ret="BRASIL";}
	if($suc=='gastroshop'){$ret="GASTROSHOP";}
	if($suc=='sanmarcos'){$ret="SAN MARCOS";}
	if($suc=='mexquite'){$ret="MEXQUITE";}
	return $ret;
}
function redondeo_fecha($fecha){ //yyyy-mm-dd
	$fecha = explode("-", $fecha);
	return $fecha[0]."-".str_pad($fecha[1], 2, "0", STR_PAD_LEFT)."-".str_pad($fecha[2], 2, "0", STR_PAD_LEFT);
}
function ceros_izq($numero,$cantidad){
	return str_pad($numero, $cantidad, "0", STR_PAD_LEFT);
}
function texto_textarea($texto){
	return str_replace(array("\r\n", "\n\r", "\r", "\n"), "<br />", $texto);
}
function path_adjunto($id){
	return "C:/inetpub/wwwroot/mexquite/ferbis-interno/assets/archivos/act_adjunto_".$id.".png";
}
function existe_adjunto($id){
	if(file_exists("C:/inetpub/wwwroot/mexquite/ferbis-interno/assets/archivos/act_adjunto_".$id.".png")){
		return "1";
	}else{
		return "0";
	}
}
function resumen_miles($numero){
	return explode(',', number_format($numero,0))[0]."K";
}

function verificar_menu($usuario){
    $CI = get_instance();
    $CI->load->model('validar_model');
	return $CI->validar_model->permisos($usuario);
}
?>