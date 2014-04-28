<?php
    include_once('aplicaciones.php');
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta http-equiv="pragma" content="no-cache">
<link rel="shortcut icon" href="../comunes/imagenes/favicon.ico" type="image/x-icon" >
<title>SACi - Sistema de Atención al Ciudadano</title>

	<style>
		body {padding:0px;margin:0px;text-align:left;font:11px verdana, arial, helvetica, serif; background-color:#FFFFFF;}
	</style>
<script src="../comunes/js/run2.js" type="text/javascript"></script>
<script src="../comunes/js/funciones.js" type="text/javascript"></script>

<script language="javascript">

</script>

<link href="../comunes/css/general.css" rel="stylesheet" type="text/css" />
<link href="../comunes/css/enlaces.css" rel="stylesheet" type="text/css" />

</head>

<body>

<form name="frmsolic" method="post">

	<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr>
	<td width="76%" class="menu_izq_titulo">
		<img src="../comunes/imagenes/group_vzla.png" />
		Solicitantes y/o Beneficiarios
	</td>


	 <?

	 		require_once("../librerias/db_postgresql.inc.php");

	 ?>


	</tr>
	</table>

	<input type="hidden" id="idcaso_selec" name="idcaso_selec" />

	<table width="100%" border="0" cellspacing="0" cellpadding="0" style="padding-top:10px; padding-bottom:0px;">

	<tr class="encabezado_tablas" style="cursor:help" >
	<td>Id</td>
	<td>Razon Social</td>
	<td>Cedula</td>
	<td>Tipo</td>
	<td>Sexo</td>
	<td>Estado</td>
	</tr>

	<?

              $textout='';

              //$sql="select idsolicitante, razon_social, cedula, stipo_solicitante, case when sexo='M' then 'Masculino' when sexo='F' then 'Femenino' end as ssexo, sestado from vsolicitantes ";
			  $sql="SELECT s.idsolicitante, s.razon_social, s.cedula, case when s.sexo='M' then 'Masculino' when s.sexo='F' then 'Femenino' end as ssexo, 
					e.descripcion AS sestado,m.descripcion AS stipo_solicitante
					FROM solicitantes_actuales s, estados e, maestro m
					WHERE e.idestado = s.idestado
					AND m.idmaestro = s.idtipo_solicitante
					ORDER BY s.idsolicitante";

                //echo $sql;

		$Tabla=array
		(
			"campo1"=>array
			(
				"columna"=>"idsolicitante",
				"alineacion"=>"left",
				"destino"=>""
			),
			"campo2"=>array
			(
				"columna"=>"razon_social",
				"alineacion"=>"left",
				"destino"=>""
			),
			"campo4"=>array
			(
				"columna"=>"cedula",
				"alineacion"=>"center",
				"destino"=>""
			)
			,
			"campo5"=>array
			(
				"columna"=>"stipo_solicitante",
				"alineacion"=>"center",
				"destino"=>""
			)
			,
			"campo6"=>array
			(
				"columna"=>"ssexo",
				"alineacion"=>"center",
				"destino"=>""
			)
                        ,
			"campo7"=>array
			(
				"columna"=>"sestado",
				"alineacion"=>"center",
				"destino"=>""
			)			
		);//Tabla

		echo $dat->cargar_tabla_botones_Efectividad($sql, $Tabla, NULL, 15, "idsolicitante", false, true);

	?>
	</table>

        <div id="dvprueba" >                 </div>

</form>
</body>
</html>
