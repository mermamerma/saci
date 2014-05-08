<?php

    require_once ('../comunes/xajax/xajax_core/xajax.inc.php');
    include_once('aplicaciones.php');
    include_once('../librerias/funciones_ajax.php');

	validar_sesion();
	
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
		window.open('lst_casos_comite_nuevos.php?accion=buscar', 'contenido');
	}


        function crear_pto_cta()
        {
            if (document.frmlista_casos.idcaso_selec.value>0)
            {
                window.open('frm_punto_cuenta.php?id_caso='+document.frmlista_casos.idcaso_selec.value,'contenido');
            }
			else 
				alert ('¡Debe Deleccionar el Caso Para Crear el Punto de Cuenta ó \n Tal vez No Tenga Casos Asignados...!');
        }

        function crear_informe_social()
        {
            if (document.frmlista_casos.idcaso_selec.value>0)
            {
                window.open('frm_informe_social_nuevos.php?idcaso='+document.frmlista_casos.idcaso_selec.value,'contenido');
            }
			else 
				alert ('¡Debe Deleccionar el Caso Para Crear el Informe Social ó \n Tal Vez No Tenga Casos Asignados...!');
        }

</script>

<?
    $xajax->printJavascript('../comunes/xajax/');
?>

<link href="../comunes/css/general.css" rel="stylesheet" type="text/css" />
<link href="../comunes/css/enlaces.css" rel="stylesheet" type="text/css" />

</head>

<body>

<form name="frmlista_casos" method="post" action="lst_casos_comite_nuevos.php?accion=buscar">

	<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr>
            <td width="76%" class="menu_izq_titulo">
			<img src="../comunes/imagenes/folder_heart.png" />
			Puntos de Cuenta e Informe Social
			</td>


	        <?
                require_once("../librerias/db_postgresql.inc.php");
                require_once("datos_usuario.php");
            
                if (validar_vacio($cusuario->get_idusuario())) redirect("login.php","_self");
                $idgrupo_usuario=$cusuario->get_idgrupo();

                $cusuario->set_objeto(COMITE_CASO);
                $cusuario->getPermisos();

                if ($cusuario->get_insertar() =='1')
                {                    
                    echo "<td width=\"4%\" align=\"center\"><a href=\"javascript:crear_informe_social()\"><img  alt=\"Crear Informe Social\" title=\"Crear Informe Social\" src=\"../comunes/imagenes/chart_curve_edit.png\" style=\"width: 20px;\" border=\"0\"/></a> </td>";
					echo "<td width=\"4%\" align=\"center\"><a href=\"javascript:crear_pto_cta()\"><img  alt=\"Crear Punto de Cuenta\" title=\"Crear Punto de Cuenta\" src=\"../comunes/imagenes/report_edit.png\" style=\"width: 20px;\" border=\"0\"/></a> </td>";
                }
                
          ?>


	</tr>
	</table>

	<input type="hidden" id="idcaso_selec" name="idcaso_selec" />

	
	<div id="dvBusqueda">

             <table width="100%" border="0" class="tablaTitulo" >
            	<tr>
					<td width="1">&nbsp;</td>
					<td width="95"><strong>Nº de Caso</strong></td>
					<td width="176">
						<input name="num_caso" type="text" class="inputbox" id="num_caso"  value=""></input>
					</td>
					<td>
						<input type="submit" id="btnFiltrar" name="btnFiltrar" value="Filtrar">
					</td>
				<tr>
					<td colspan="4" style="border:#CCCCCC solid 1px;">
						<div align="center" style="background-image: url('../comunes/imagenes/barra.png')">
							<br>
						</div>
					</td>
				</tr>
            </table>
  </div>
	
	<table width="100%" border="0" cellspacing="0" cellpadding="0" style="padding-top:10px; padding-bottom:0px;">
	
	<tr class="encabezado_tablas" style="cursor:help" >
	<td>&nbsp;</td>
	<td>N&deg; Caso </td>
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
				#$filtro=" where c.idestatus not in (61, 68) and c.idcaso in (select idcaso from casos_analistas_actuales where idanalista=".$cusuario->get_idusuario()." and estatus_asignacion='0')";
				$filtro=" where c.idestatus not in (61, 68) and c.idcaso in (select idcaso from casos_analistas_actuales where estatus_asignacion='0')";
				break;
			case "72":		//Gerentes
				$filtro=" where (c.idestatus not in (61, 68) and c.idcaso in (select idcaso from casos_analistas_actuales where estatus_asignacion='0')) or (c.idestatus=76)";
				#$filtro=" where (c.idestatus not in (61, 68) and c.idcaso in (select idcaso from casos_analistas_actuales where idanalista=".$cusuario->get_idusuario()." and estatus_asignacion='0')) or (c.idestatus=76)";
				break;
			case "81":		//Coordinador General
				$filtro=" where (c.idestatus not in (61, 68) and c.idcaso in (select idcaso from casos_analistas_actuales where idanalista=".$cusuario->get_idusuario()." and estatus_asignacion='0')) or (c.idestatus=76)";
				break;
			case "71":		//Analistas
				$filtro=" where c.idestatus not in (61, 68) and c.idcaso in (select idcaso from casos_analistas_actuales where idanalista=".$cusuario->get_idusuario()." and estatus_asignacion='0')";
				break;
                        case "75":		//Analistas Especial
				$filtro=" where c.idestatus not in (61, 68) and idcaso in (select idcaso from casos_analistas_actuales where idanalista=".$cusuario->get_idusuario()." and estatus_asignacion='0')";
				break;
			case "83":		//Presidente
				$filtro=" where (c.idestatus not in (61, 68) and idcaso in (select idcaso from casos_analistas_actuales where idanalista=".$cusuario->get_idusuario()." and estatus_asignacion='0')) or (c.idestatus=76)";
				break;
			case "82":		//Supervisor
				$filtro=" where c.idestatus not in (61, 68) and idcaso in (select idcaso from casos_analistas_actuales where idanalista=".$cusuario->get_idusuario()." and estatus_asignacion='0')";
				break;
			default :
				$filtro=" where c.idestatus not in (61, 68) and idcaso in (select idcaso from casos_analistas_actuales where idanalista=".$cusuario->get_idusuario()." and estatus_asignacion='0')";
		}


                

		if (isset($_REQUEST["accion"]) && $_REQUEST["accion"]=="buscar")
		{
		
					//echo $_REQUEST["accion"];
					//echo $_REQUEST['num_caso'];
					if ($_REQUEST['num_caso']!="")
                    {
                        $filtro.=" and c.idcaso=".$_REQUEST["num_caso"]; 
                    }
					
                    if (isset($_SESSION["filtro_sql_casos"]) && $_SESSION["filtro_sql_casos"]<>'')
                    {
                        $sql.=$_SESSION["filtro_sql_casos"];
                    }
		}
		
		$sql="select c.idcaso, c.idremitente,r.descripcion AS sremitente, 
			s.razon_social as razon_social_solic, b.razon_social as razon_social_benef, 
			c.idestatus, e.descripcion AS sestatus_caso
			from casos_actuales c
			left join solicitantes_actuales s on c.idsolicitante = s.idsolicitante
			LEFT JOIN solicitantes_actuales b ON c.idbeneficiario = b.idsolicitante
			inner join maestro e on e.idmaestro = c.idestatus
			left join maestro r on r.idmaestro = c.idremitente".$filtro;
        $sql.= " order by c.idcaso desc";

        #echo $sql;

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
