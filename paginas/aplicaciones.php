<?php

function redirecciona($url,$target){
   	echo "<script>alert('Su sesión ha expirado. Inicie nuevamente..!');window.open('".$url."','".$target."');</script>";
} 

function validar_sesion() {
	if (!isset($_SESSION['idusuario']) OR $_SESSION['idusuario'] == '')
		redirecciona('cerrar_sesion.php', '_parent') ;
}

function to_minuscula($input) {
	return mb_strtolower($input,'UTF-8') ;
}


function to_mayuscula($input) {
	return mb_strtoupper($input,'UTF-8') ;
}

function date_to_db($date,$input = '/', $output = '-'){
	if ($date != '') 
		return  implode($output, array_reverse(explode($input,$date)));
	else 
		return NULL ;
		
}

//obtener fecha actual
$diahoy = getdate();
$anio_actual = $diahoy["year"];
$mes_actual  = $diahoy["mon"];
$dia_actual  = $diahoy["mday"];

//nombre del mes
function nombremes($m){
  switch($m) {
    case  1: $valor = "Enero";		break;
    case  2: $valor = "Febrero";	break;
    case  3: $valor = "Marzo";		break;
    case  4: $valor = "Abril";		break;
    case  5: $valor = "Mayo";		break;
    case  6: $valor = "Junio";		break;
    case  7: $valor = "Julio";		break;
    case  8: $valor = "Agosto";		break;
    case  9: $valor = "Septiembre"; break;
    case 10: $valor = "Octubre";	break;
    case 11: $valor = "Noviembre";	break;
    case 12: $valor = "Diciembre";	break;
  }
  return $valor;
}

//nombre del d�a de la semana
function diasemana($d,$m,$a){ 
  $f = getdate(mktime(0,0,0,$m,$d,$a)); 
  switch($f["wday"]) {
    case 1: $valor = "Lunes";		break;
    case 2: $valor = "Martes";		break;
    case 3: $valor = "Mi&eacute;rcoles";	break;
    case 4: $valor = "Jueves";		break;
    case 5: $valor = "Viernes";		break;
    case 6: $valor = "S&aacute;bado";		break;
    case 0: $valor = "Domingo";		break;
  }
  return $valor;
}

//buscar un archivo
function unafoto($uploadpath, $id) {
	$d = dir($uploadpath); // obtener fotos
	while (false !== ($files = $d -> read())) {
		$files = explode('.', $files);
		if ($files[0] == $id) {
			$foto = $files[0].'.'.$files[1];
		}	
	}
	return $foto;
}

function authenticateMailServer($username, $password){	
	$CONFIG['ldap_server'] = 'repldap.mppre.gob.ve';
	$conLDAP = ldap_connect($CONFIG['ldap_server']);
    if ($conLDAP){
		ldap_set_option($conLDAP,LDAP_OPT_PROTOCOL_VERSION,3);
		$ldapbin=@ldap_bind($conLDAP,"uid=$username,ou=people,dc=mppre,dc=gob,dc=ve", $password);
		
		if (!$ldapbin){
			$ldapbin=@ldap_bind($conLDAP,"uid=$username,ou=people,dc=mre,dc=gob,dc=ve", $password);
		}
		
		if (!$ldapbin){
			return FALSE;
		}
	}
	return TRUE;
}

?>