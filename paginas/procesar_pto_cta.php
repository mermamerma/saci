<?php

require_once("../librerias/db_postgresql.inc.php");
require_once ('../cdatos/cpuntos.php');

$id_caso	= $_POST['id_caso'] ;
$id_pto_cta	= $_POST['id_pto_cta'] ;
$response	= '';
$obj_pto = new cpuntos();
$data = array();	
$data['id_caso']			= $id_caso ;
$data['id_pto_cta']			= $id_pto_cta ;
$data['asunto']				= pg_escape_string($_POST['asunto']);
$data['argumentacion']		= trim(pg_escape_string($_POST['argumentacion']));
$data['carta_solicitud']	= (isset($_POST['carta_solicitud'])) ? 't' : 'f' ;
$data['informe_social']		= (isset($_POST['informe_social'])) ? 't' : 'f' ;
$data['informe_medico']		= (isset($_POST['informe_medico'])) ? 't' : 'f' ;
$data['presupuesto']		= (isset($_POST['presupuesto'])) ? 't' : 'f' ;
$data['copia_ci']			= (isset($_POST['copia_ci'])) ? 't' : 'f' ;
$data['monto']				= to_moneda_bd(pg_escape_string(($_POST['monto'])));
$data['razon_social']		= trim(pg_escape_string(mb_strtoupper($_POST['razon_social'],'UTF-8')));
$data['rif']				= trim(pg_escape_string(mb_strtoupper($_POST['rif'],'UTF-8')));
$data['concepto']			= trim(pg_escape_string($_POST['concepto'])) ;
$data['id_decision']		= pg_escape_string($_POST['id_decision']);
$data['observaciones']		= pg_escape_string($_POST['observaciones']);

if ($id_pto_cta != '') {	
	$obj_pto->actualizar($data);
	mensaje('¡Punto de Cuenta Modificado Satisfactoriamente...!') ;
}
else {	
	$last_id = $obj_pto->insertar($data);
	mensaje('¡Punto de Cuenta Registrado Satisfactoriamente...!') ;
	$response .= "$('#id_pto_cta').val('$last_id');";
	$response .= "$('#desc_pto_cta').html('Punto de Cuenta N° $last_id');";
	javascript($response) ;
}

?>