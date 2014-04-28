<?php

require_once("../librerias/db_postgresql.inc.php");

$conn		= pg_connect ($str_conex) or die ("Error de conexion.". pg_last_error());

$nombre_secretario	= pg_escape_string($_POST['nombre_secretario']);
$cargo_secretario	= pg_escape_string($_POST['cargo_secretario']);
$num_resolucion		= pg_escape_string($_POST['num_resolucion']);
$fecha_resolucion	= pg_escape_string($_POST['fecha_resolucion']);
$num_gaceta			= pg_escape_string($_POST['num_gaceta']);
$fecha_gaceta		= pg_escape_string($_POST['fecha_gaceta']);
$nombre_dir_ac		= pg_escape_string($_POST['nombre_dir_ac']);
$cargo_dir_ac		= pg_escape_string($_POST['cargo_dir_ac']);


$sql_update  = "UPDATE variables_globales SET ";
$sql_update .= "nombre_secretario	= '$nombre_secretario', ";
$sql_update .= "cargo_secretario	= '$cargo_secretario', ";
$sql_update .= "num_resolucion		= '$num_resolucion', ";
$sql_update .= "fecha_resolucion	= '$fecha_resolucion', ";
$sql_update .= "num_gaceta			= '$num_gaceta', ";
$sql_update .= "fecha_gaceta		= '$fecha_gaceta', ";
$sql_update .= "nombre_dir_ac		= '$nombre_dir_ac', ";
$sql_update .= "cargo_dir_ac		= '$cargo_dir_ac' ";
$sql_update .= "WHERE id 		= 1 ";
#echo $sql_update;
	
$update		= pg_query($conn, $sql_update);
$html = '<script>';
if ($update) {	
	$html .= "alert('¡Variables Globales Guardadas Satisfactoriamente...!')";	
	
}
else {
	$html .= "alert('¡Error al Guardar Variables Globales...!')";	
}
$html .= '</script>';
echo $html ;
pg_close($conn);

?>