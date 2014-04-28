<?php

    require_once ('../comunes/xajax/xajax_core/xajax.inc.php');
    require_once("../librerias/db_postgresql.inc.php");
    include_once('aplicaciones.php');
    include_once('../librerias/funciones_ajax.php');

    $xajax= new xajax();
    $xajax->setFlag('debug',false);
    $xajax->configure('javascript URI', '../comunes/xajax/');

    $xajax->registerFunction('eliminarCaso');

    $xajax->processRequest();
    $xajax->printJavascript('../comunes/xajax/');

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

    function  respuesta()
    {
        //abrir_ventana('frm_casos.php?accion=nuevo', 'casos_infra');
    }

    function get_asignacion()
    {
        window.open("lst_asignacion_analistas.php","_self");
    }

    function get_filtro()
    {
        window.open("lst_asignacion_analistas.php?accion=buscar","_self");
    }


</script>

<?
    $xajax->printJavascript('../comunes/xajax/');
?>

<link href="../comunes/css/enlaces.css" rel="stylesheet" type="text/css" />
<link href="../comunes/css/general.css" rel="stylesheet" type="text/css" />

</head>

<body>

<form name="frmlista_casos" method="post">

	<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr>
            <td width="100%" class="menu_izq_titulo">
			<img src="../comunes/imagenes/folder_user_2.png" />
			Asignaci&oacute;n de Analista 
			</td>
	</tr>
	</table>

	<input type="hidden" id="idcaso_selec" name="idcaso_selec" />

	<table width="100%" border="0" cellspacing="0" cellpadding="0" style="padding-top:10px; padding-bottom:0px;">

	<tr class="encabezado_tablas" style="cursor:help" >
		<td>N&deg; Caso</td>
		<td>Remitente</td>
		<td>Solicitante</td>
		<td>Beneficiario</td>
		<td>Estatus</td>
		<td>Acci&oacute;n</td>
	</tr>

	<?

                require("datos_usuario.php");	
		$textout='';

                $sql="select idcaso, r.descripcion AS sremitente,
						s.razon_social as razon_social_solic, b.razon_social as razon_social_benef,
						idestatus, e.descripcion AS sestatus_caso 
						from casos_actuales ca 
						left join solicitantes_actuales s on ca.idsolicitante = s.idsolicitante
						LEFT JOIN solicitantes_actuales b ON ca.idbeneficiario = b.idsolicitante
						inner join maestro e on e.idmaestro = ca.idestatus
						left join maestro r on r.idmaestro = ca.idremitente
						where ca.idestatus in (61, 62)";

		if (isset($_REQUEST["accion"]) && $_REQUEST["accion"]=="buscar")
		{
                    if ($_SESSION["filtro_sql_casos"]<>'')
                    {
                        $sql.=$_SESSION["filtro_sql_casos"];
                    }
		}

                $sql.= " order by idcaso desc";

                //echo $sql;

		$Tabla=array
		(
			"campo1"=>array
			(
				"columna"=>"idcaso",
				"alineacion"=>"left",
				"destino"=>""
			),
			"campo2"=>array
			(
				"columna"=>"sremitente",
				"alineacion"=>"left",
				"destino"=>""
			),
			"campo4"=>array
			(
				"columna"=>"razon_social_solic",
				"alineacion"=>"center",
				"destino"=>""
			)
			,
			"campo5"=>array
			(
				"columna"=>"razon_social_benef",
				"alineacion"=>"center",
				"destino"=>""
			)
			,
			"campo6"=>array
			(
				"columna"=>"sestatus_caso",
				"alineacion"=>"center",
				"destino"=>""
			)
			,"campo7"=>array
			(
				"columna"=>"imagen_tabla",
				"alineacion"=>"center",
				"destino"=>"frm_asignacion_casos.php",
				"imagen_tabla"=>"../comunes/imagenes/script_go.png",
				"target"=>"contenido",
				"titulo_mensaje"=>"Asignar Caso"
			)
		);//Tabla

		//echo $dat->cargar_tabla_botones_Efectividad($sql, $Tabla, NULL, 15, "idcaso", false, true);
                echo $dat->cargar_tabla_asignacion_casos($sql, $Tabla, NULL, 15, "idcaso", "asignar_analista", $cusuario);

	?>
	</table>

        <div id="dvprueba" >                 </div>

</form>
</body>
</html>
