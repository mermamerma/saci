<?php

require_once("../librerias/db_postgresql.inc.php");
require_once ('../cdatos/cfuncionarios.php');

$data = array();
$funcionarios = new cfuncionarios();
$data['nombre_secretario']	= trim(pg_escape_string($_POST['nombre_secretario'])) ;
$data['sexo']				=  @$_POST['sexo'];
$data['cargo_secretario']	= trim(pg_escape_string($_POST['cargo_secretario'])) ;
$data['num_resolucion']		= trim(pg_escape_string($_POST['num_resolucion'])) ;
$data['fecha_resolucion']	= trim(pg_escape_string($_POST['fecha_resolucion'])) ;
$data['num_gaceta']			= trim(pg_escape_string($_POST['num_gaceta'])) ;
$data['fecha_gaceta']		= trim(pg_escape_string($_POST['fecha_gaceta'])) ;
$data['nombre_dir_ac']		= trim(pg_escape_string($_POST['nombre_dir_ac'])) ;
$data['cargo_dir_ac']		= trim(pg_escape_string($_POST['cargo_dir_ac'])) ;
$data['elab_pto_cta']		= trim(pg_escape_string($_POST['elab_pto_cta'])) ;

if ($funcionarios->actualizar($data)) {	
	
	mensaje('¡Datos de los Funcionarios Guardados Satisfactoriamente...!') ;
}
else {	
	mensaje('¡Error al Guardar Datos de los Funcionarios..!') ;
}



?>