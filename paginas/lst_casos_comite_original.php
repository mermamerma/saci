<?php

    require_once ('../comunes/xajax/xajax_core/xajax.inc.php');
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

	function seleccionado(id, idcaso)
	{
		var concatenar

		if (id>0)
		{
			concatenar='document.frmlista_casos.opcion['+id+']';
		}
		else
		{
			concatenar='document.frmlista_casos.opcion';
		}

		box = eval(concatenar);
		box.checked=true;

		document.frmlista_casos.idcaso_selec.value=idcaso;

	}	

        

	function buscar()
	{
		abrir_ventana("buscar_casos.php","contenido");
	}

	function get_filtro()
	{
		window.open('lst_casos_comite.php?accion=buscar', 'contenido');
	}


        function crear_informe_comite()
        {
            if (document.frmlista_casos.idcaso_selec.value>0)
            {
                window.open('frm_informe_comite.php?idcaso='+document.frmlista_casos.idcaso_selec.value,'contenido');
            }
        }

        function crear_informe_social()
        {
            if (document.frmlista_casos.idcaso_selec.value>0)
            {
                window.open('frm_informe_social.php?idcaso='+document.frmlista_casos.idcaso_selec.value,'contenido');
            }
        }

</script>

<?
    $xajax->printJavascript('../comunes/xajax/');
?>

<link href="../comunes/css/general.css" rel="stylesheet" type="text/css" />
<link href="../comunes/css/enlaces.css" rel="stylesheet" type="text/css" />

</head>

<body>

<form name="frmlista_casos" method="post">

	<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr>
            <td width="76%" class="menu_izq_titulo">Comit&eacute; de Casos </td>


	 <?
                require_once("../librerias/db_postgresql.inc.php");
                require_once("datos_usuario.php");
            
                if (validar_vacio($cusuario->get_idusuario())) redirect("login.php","_self");
                $idgrupo_usuario=$cusuario->get_idgrupo();

                $cusuario->set_objeto(COMITE_CASO);
                $cusuario->getPermisos();

                if ($cusuario->get_insertar() =='1')
                {
                    echo "<td width=\"4%\" align=\"center\"><a href=\"javascript:crear_informe_comite()\"><img  alt=\"Crear Informe del Comité\" title=\"Crear Informe del Comité\" src=\"../comunes/imagenes/actividades.gif\" border=\"0\"/></a> </td>";
                    echo "<td width=\"4%\" align=\"center\"><a href=\"javascript:crear_informe_social()\"><img  alt=\"Crear Informe Social\" title=\"Crear Informe Social\" src=\"../comunes/imagenes/book.png\" border=\"0\"/></a> </td>";
                }
                
          ?>


	</tr>
	</table>

	<input type="hidden" id="idcaso_selec" name="idcaso_selec" />

	<table width="100%" border="0" cellspacing="0" cellpadding="0" style="padding-top:10px; padding-bottom:0px;">

	<tr class="encabezado_tablas" style="cursor:help" >
	<td>&nbsp;</td>
	<td>N&deg; Caso</td>
	<td>Remitente</td>
	<td>Solicitante</td>
	<td>Beneficiario</td>
	<td>Estatus</td>
	</tr>

	<?

		$textout='';


                switch($idgrupo_usuario)
		{
			case "70":		//administradores
				$filtro=" where idestatus not in (61, 68) and idcaso in (select idcaso from casos_analistas where idanalista=".$cusuario->get_idusuario()." and estatus_asignacion='0')";
				break;
			case "72":		//Gerentes
				$filtro=" where idestatus not in (61, 68) and idcaso in (select idcaso from casos_analistas where idanalista=".$cusuario->get_idusuario()." and estatus_asignacion='0')";
				break;
			case "81":		//Coordinador General
				$filtro=" where (idestatus not in (61, 68) and idcaso in (select idcaso from casos_analistas where idanalista=".$cusuario->get_idusuario()." and estatus_asignacion='0')) or (idestatus=76)";
				break;
			case "71":		//Analistas
				$filtro=" where idestatus not in (61, 68) and idcaso in (select idcaso from casos_analistas where idanalista=".$cusuario->get_idusuario()." and estatus_asignacion='0')";
				break;
                        case "75":		//Analistas Especial
				$filtro=" where idestatus not in (61, 68) and idcaso in (select idcaso from casos_analistas where idanalista=".$cusuario->get_idusuario()." and estatus_asignacion='0')";
				break;
			case "83":		//Presidente
				$filtro=" where (idestatus not in (61, 68) and idcaso in (select idcaso from casos_analistas where idanalista=".$cusuario->get_idusuario()." and estatus_asignacion='0')) or (idestatus=76)";
				break;
			case "82":		//Supervisor
				$filtro=" where idestatus not in (61, 68) and idcaso in (select idcaso from casos_analistas where idanalista=".$cusuario->get_idusuario()." and estatus_asignacion='0')";
				break;
		}


                $sql="select idcaso, sremitente, razon_social_solic, razon_social_benef, idestatus, sestatus_caso from vcasos ".$filtro;

		if ($_REQUEST["accion"]=="buscar")
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
			
		);//Tabla

		echo $dat->cargar_tabla_botones_Efectividad($sql, $Tabla, NULL, 15, "idcaso", true, true);

	?>
	</table>

        <div id="dvprueba" >                 </div>

</form>
</body>
</html>
