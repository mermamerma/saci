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
<script src="../comunes/js/prototype.js" type="text/javascript"></script>

<script language="javascript">

	function exportar()
	{
		window.open('consulta_exportar.php', 'exportacion');
	}

    function consultar()
	{
		if (document.frmlista_casos.idcaso_selec.value>0)
		{
                    window.open('frm_casos.php?accion=consultar&idcaso='+document.frmlista_casos.idcaso_selec.value,'contenido');
		}
	}

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


	function buscar(id)
	{            
		div = $(id);
		div.toggle();
		if (div.innerHTML==''){
			div.update('<div align="center"><img src="../comunes/imagenes/ajax-loader.gif"></div>');
		}else{
			d = div.descendants();
		}
	}

	function filtrar()
	{
		window.document.getElementById('accion').value='buscar';
		document.frmlista_casos.submit();
	}
        
</script>
<link href="../comunes/css/general.css" rel="stylesheet" type="text/css" />
<link href="../comunes/css/enlaces.css" rel="stylesheet" type="text/css" />

</head>

<body>
<script src="../comunes/js/wz_tooltip/wz_tooltip.js" type="text/javascript"></script>
<form name="frmlista_casos" action="lst_consultas.php?accion=buscar" method="post">

	<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr>
	<td width="76%" class="menu_izq_titulo">Consulta General </td>


	 <?
            require_once("../librerias/db_postgresql.inc.php");
            echo "<td width=\"4%\" align=\"center\"><a href=\"javascript:consultar()\"><img  alt=\"Consultar Caso\" title=\"Consultar Caso\" src=\"../comunes/imagenes/folder_explore.png\" style=\"width: 20px;\" border=\"0\"/></a> </td>";
            echo "<td width=\"4%\" align=\"center\"><a href=\"javascript:buscar('dvBusqueda')\"><img  alt=\"Búsqueda Avanzada\" title=\"Búsqueda Avanzada\" src=\"../comunes/imagenes/folder_find.png\" style=\"width: 20px;\" border=\"0\"/></a> </td>";
            echo "<td width=\"4%\" align=\"center\"><a href=\"javascript:exportar()\"><img  alt=\"Exportar a Calc\" title=\"Exportar a Calc\" src=\"../comunes/imagenes/page_excel.png\" border=\"0\"/></a> </td>";
			
				$textout='';


                /*$sql="select idcaso, sremitente, razon_social_solic, razon_social_benef, idestatus, sestatus_caso,
                    (select vu.snombre_usuario from vusuarios vu inner join casos_analistas cs on vu.idusuario=cs.idanalista where cs.idcaso=vcasos.idcaso and cs.estatus_asignacion='0') as sanalista from vcasos ";*/
					
				$sql="select c.idcaso, c.idremitente,r.descripcion AS sremitente , 
								s.razon_social as razon_social_solic, b.razon_social as razon_social_benef, 
								c.idestatus, e.descripcion AS sestatus_caso,(u.nombres::text || ' '::text) || u.apellidos::text as sanalista
						from casos c
						left join solicitantes s on c.idsolicitante = s.idsolicitante
						LEFT JOIN solicitantes b ON c.idbeneficiario = b.idsolicitante
						inner join maestro e on e.idmaestro = c.idestatus
						left join maestro r on r.idmaestro = c.idremitente
						left join casos_analistas a on a.idcaso=c.idcaso and a.estatus_asignacion='0'
						left join sis_usuarios u on u.idusuario=a.idanalista";	
                $filtro=" where c.idcaso>0 ";
                $_SESSION["filtro_caso"]=" where idcaso>0 ";

		if (isset($_REQUEST["accion"]) && $_REQUEST["accion"]=="buscar") 
		{
                 
					if ($_REQUEST['num_caso']!="")
                    {
                        $filtro.=" and c.idcaso=".$_REQUEST["num_caso"]; 
                    }
					
                    if (!validar_id_vacio($_REQUEST["remitente"]))
                    {
                        $filtro.=" and c.idremitente=".$_REQUEST["remitente"];
                        $_SESSION["filtro_caso"].=" and vc.idremitente=".$_REQUEST["remitente"];
                    }

                    if (!validar_id_vacio($_REQUEST["tipo_caso"]))
                    {
                        $filtro.=" and c.idtipocaso=".$_REQUEST["tipo_caso"];
                        $_SESSION["filtro_caso"].=" and vc.idtipocaso=".$_REQUEST["tipo_caso"];
                    }

                    if (!validar_id_vacio(@$_REQUEST["categoria"]))
                    {
                        $filtro.=" and c.idcategoria=".$_REQUEST["categoria"];
                        $_SESSION["filtro_caso"].=" and vc.idcategoria=".$_REQUEST["categoria"];
                    }

                    if (!validar_id_vacio(@$_REQUEST["subcategoria"]))
                    {
                        $filtro.=" and c.idcaso in (select idcaso from casos_categorias where idsubcategoria=".$_REQUEST["subcategoria"].")";
                        $_SESSION["filtro_caso"].=" and vc.idcaso in (select idcaso from casos_categorias where idsubcategoria=".$_REQUEST["subcategoria"].")";
                    }

                    if (!validar_id_vacio($_REQUEST["estado"]))
                    {
                        $filtro.=" and c.idestado=".$_REQUEST["estado"];
                        $_SESSION["filtro_caso"].=" and vc.idestado=".$_REQUEST["estado"];
                    }

                    if (!validar_id_vacio($_REQUEST["municipio"]))
                    {
                        $filtro.=" and c.idmunicipio=".$_REQUEST["municipio"];
                        $_SESSION["filtro_caso"].=" and vc.idmunicipio=".$_REQUEST["municipio"];
                    }

                    if (!validar_id_vacio($_REQUEST["parroquia"]))
                    {
                        $filtro.=" and c.idparroquia=".$_REQUEST["parroquia"];
                        $_SESSION["filtro_caso"].=" and vc.idparroquia=".$_REQUEST["parroquia"];
                    }

                    if (!validar_id_vacio($_REQUEST["estatus"]))
                    {
                        $filtro.=" and c.idestatus=".$_REQUEST["estatus"];
                        $_SESSION["filtro_caso"].=" and vc.idestatus=".$_REQUEST["estatus"];
                    }

                    if ($_REQUEST['cedula_solic']!="")
                    {
                        $filtro.=" and s.cedula='".$_REQUEST["cedula_solic"]."'";
                        $_SESSION["filtro_caso"].=" and vc.cedula_solic='".$_REQUEST["cedula_solic"]."'";
                    }

                    if ($_REQUEST['rif_solic']!="")
                    {
                        $filtro.=" and s.rif='".$_REQUEST["rif_solic"]."'";
                        $_SESSION["filtro_caso"].=" and vc.rif_solic='".$_REQUEST["rif_solic"]."'";
                    }

                    if ($_REQUEST['razon_social_solic']!="")
                    {
                        $filtro.=" and upper(s.razon_social) like '%".strtoupper($_REQUEST["razon_social_solic"])."%'";
                        $_SESSION["filtro_caso"].=" and upper(vc.razon_social_solic) like '%".strtoupper($_REQUEST["razon_social_solic"])."%'";
                    }

                    if (!validar_id_vacio($_REQUEST["tipo_solicitante"]))
                    {
                        $filtro.=" and s.idtipo_solicitante=".$_REQUEST["tipo_solicitante"];
                        $_SESSION["filtro_caso"].=" and vc.idtipo_solicitante_solic=".$_REQUEST["tipo_solicitante"];
                    }

                    if ($_REQUEST['cedula_benef']!="")
                    {
                        $filtro.=" and b.cedula='".$_REQUEST["cedula_benef"]."'";
                        $_SESSION["filtro_caso"].=" and vc.cedula_benef='".$_REQUEST["cedula_benef"]."'";
                    }

                    if ($_REQUEST['rif_benef']!="")
                    {
                        $filtro.=" and b.rif='".$_REQUEST["rif_benef"]."'";
                        $_SESSION["filtro_caso"].=" and rif_benef='".$_REQUEST["rif_benef"]."'";
                    }

                    if ($_REQUEST['razon_social_benef']!="")
                    {
                        $filtro.=" and upper(b.razon_social) like '%".strtoupper($_REQUEST["razon_social_benef"])."%'";
                        $_SESSION["filtro_caso"].=" and upper(vc.razon_social_benef) like '%".strtoupper($_REQUEST["razon_social_benef"])."%'";
                    }

                    if (!validar_id_vacio($_REQUEST["tipo_beneficiario"]))
                    {
                        $filtro.=" and b.idtipo_solicitante=".$_REQUEST["tipo_beneficiario"];
                        $_SESSION["filtro_caso"].=" and vc.idtipo_solicitante_benef=".$_REQUEST["tipo_beneficiario"];
                    }
                     
		}
                
		$sql.= $filtro." order by c.idcaso desc";

		//echo $sql; //die();
	 ?>


	</tr>
	</table>

	<input type="hidden" id="idcaso_selec" name="idcaso_selec" />
        <input type="hidden" id="accion" name="accion" value="<?= $_REQUEST['accion'] ?>">


        <div id="dvBusqueda" style="display:none;">

             <table width="100%" border="0" class="tablaTitulo" >
                 
                <tr>
                <td colspan="6" style="border:#CCCCCC solid 1px;" bgcolor="#F8F8F8" >
                <div align="center" style="background-image: url('../comunes/imagenes/barra.png');">
                    <strong>B&uacute;squeda General</strong>
                </div>
                </td>
                </tr>
				<tr>
					<td width="1">&nbsp;</td>
					<td width="95"><strong>Nº de Caso</strong></td>
					<td width="176">
							<input name="num_caso" type="text" class="inputbox" id="num_caso"  value=""></input>
					</td>
					<td width="89"></td>
					<td width="199">&nbsp;	</td>
				</tr>
                <tr>
                    <td width="1">&nbsp;</td>
                    <td width="95"><strong>Remitente:</strong></td>
                    <td width="176">
                        <select name="remitente" id="remitente" style="width:166px;" class="inputbox" >
							<option value="0">Seleccione...</option>
							<?php
							echo ($dat->Cargarlista("select idmaestro, descripcion from vremitentes where estatus=1 order by descripcion", $_REQUEST["remitente"]));
							?>
                        </select>
                    </td>
                    <td width="89"><strong>Tipo de Caso:</strong></td>
                    <td width="199">
                        <select name="tipo_caso" id="tipo_caso" style="width:166px;" class="inputbox" onchange='cargaContenido_Categoria(this.id)' >
                        <option value="0">Seleccione...</option>
                        <?php
                        echo ($dat->Cargarlista("select idmaestro, descripcion from vtipos_casos order by descripcion", $_REQUEST["tipo_caso"]));
                        ?>
                        </select>
                    </td>
                </tr>

                <tr>
                    <td width="1">&nbsp;</td>
                    <td width="95"><strong>Categor&iacute;a del Caso:</strong></td>
                    <td width="176">
                        <label>
                        <select name="categoria" id="categoria" style="width:166px;" class="inputbox" onchange='cargaContenido_Categoria(this.id)' >
                        <option value="0">Seleccione...</option>
                        </select>
                        </label>
                    </td>
                    <td width="89"><strong>Subcategor&iacute;a:</strong></td>
                    <td width="199">
                        <select name="subcategoria" id="subcategoria" style="width:166px;" class="inputbox" >
                        <option value="0">Seleccione...</option>
                        </select>
                    </td>
                </tr>

                <tr>
                    <td width="1">&nbsp;</td>
                    <td width="95"><strong>Estado:</strong></td>
                    <td width="176"><label>
                    <select name="estado" id="estado" style="width:166px;" class="inputbox" onchange='cargaContenido_Estados(this.id)'>
                    <option value="0">Seleccione...</option>
                    <?php
                    echo ($dat->Cargarlista("select idestado, descripcion from estados order by descripcion", $_REQUEST["estado"]));
                    ?>
                    </select>
                    </label></td>
                    <td width="89"><strong>Municipio</strong></td>
                    <td width="199"><label>
                    <select name="municipio" id="municipio" style="width:166px;" class="inputbox" onchange='cargaContenido_Estados(this.id)'>
                    <option value="0">Seleccione...</option>
                    <?php
                    echo ($dat->Cargarlista("select idmunicipio, descripcion from municipios where idestado=".$_REQUEST["estado"]." order by descripcion", $_REQUEST["municipio"]));
                    ?>
                    </select>
                    </label></td>
                </tr>


                <tr>
                    <td width="1">&nbsp;</td>
                    <td width="95"><strong>Parroquia:</strong></td>
                    <td width="176"><label>
                    <select name="parroquia" id="parroquia" style="width:166px;" class="inputbox">
                    <option value="0">Seleccione...</option>
                    <?php
                    echo ($dat->Cargarlista("select idparroquia, descripcion from parroquias where idmunicipio=".$_REQUEST["municipio"]." order by descripcion", $_REQUEST["parroquia"]));
                    ?>
                    </select>
                    </label>
                    </td>
                    <td width="89"><strong>Estatus del Caso:</strong></td>
                    <td width="199"><select name="estatus" id="estatus" style="width:166px;" class="inputbox">
                    <option value="0">Seleccione...</option>
                    <?php
                    echo ($dat->Cargarlista("select idmaestro, descripcion from vestatus_casos order by descripcion", $_REQUEST["estatus"]));
                    ?>
                    </select>
                    </td>
                </tr>
                <tr>
					<td colspan="6" style="border:#CCCCCC solid 1px;" bgcolor="#F8F8F8" >
						<div align="center" style="background-image: url('../comunes/imagenes/barra.png');">
							<strong>Solicitante</strong>
						</div>
					</td>
                </tr>
                <tr>
                    <td width="1">&nbsp;</td>
                    <td width="95"><strong>C&eacute;dula:</strong></td>
                    <td width="176">
						<input name="cedula_solic" type="text" class="inputbox" id="cedula_solic" onkeypress="return CedulaFormat(this,'Cédula de Identidad Invalida',-1,true,event)" onmouseout="UnTip()" maxlength="12" value="" ></input>
                    </td>
                    <td width="89"><strong>R.I.F:</strong></td>
                    <td width="199">
						<input name="rif_solic" type="text" class="inputbox" id="rif_solic" onkeypress="return RifFormat(this.form,'Rif del Solicitante Invalido',-1,true,event)" onmouseout="UnTip()" maxlength="12" value="" ></input>
                    </td>
                </tr>
                <tr>
					<td width="1">&nbsp;</td>
					<td width="95">
						<strong>Raz&oacute;n Social:</strong>
					</td>
					<td width="176">
							<input name="razon_social_solic" type="text" class="inputbox" id="razon_social_solic" onkeypress="return validar_texto(this.form,this,event,'')" value=""></input>
					</td>
					<td width="89"><strong>Tipo de Solicitante:</strong></td>
					<td width="199">
						<select name="tipo_solicitante" id="tipo_solicitante" style="width:166px;" class="inputbox">
							<option value="0">Seleccione...</option>
							<?php
							echo ($dat->Cargarlista("select idmaestro, descripcion from vtipo_solicitantes where estatus=1 order by descripcion", $_REQUEST["tipo_solicitante"]));
							?>
						</select>
                    </td>
                </tr>
                <tr>
					<td colspan="6" style="border:#CCCCCC solid 1px;" bgcolor="#F8F8F8" >
						<div align="center" style="background-image: url('../comunes/imagenes/barra.png');">
							<strong>Beneficiario</strong>
						</div>
					</td>
                </tr>
                 <tr>
                    <td width="1">&nbsp;</td>
                    <td width="95"><strong>C&eacute;dula:</strong></td>
                    <td width="176">
						<input name="cedula_benef" type="text" class="inputbox" id="cedula_benef" onkeypress="return CedulaFormat(this,'Cédula de Identidad Invalida',-1,true,event)" onmouseout="UnTip()" maxlength="12" value="" ></input>
                    </td>
                    <td width="89"><strong>R.I.F:</strong></td>
                    <td width="199">
						<input name="rif_benef" type="text" class="inputbox" id="rif_benef" onkeypress="return RifFormat(this,'Rif del Beneficiario Invalido',-1,true,event)" onmouseout="UnTip()" maxlength="12" value="" ></input>
                    </td>
                </tr>
                <tr>
					<td width="1">&nbsp;</td>
					<td width="95">
						<strong>Raz&oacute;n Social:</strong>
					</td>
					<td width="176">
						<label>
							<input name="razon_social_benef" type="text" class="inputbox" id="razon_social_benef" onkeypress="return validar_texto(this.form,this,event,'')" value=""></input>
						</label>
					</td>
					<td width="89"><strong>Tipo de Beneficiario:</strong></td>
					<td width="199">
						<select name="tipo_beneficiario" id="tipo_beneficiario" style="width:166px;" class="inputbox">
						<option value="0">Seleccione...</option>
						<?php
							$s="select idmaestro, descripcion from vtipo_solicitantes where estatus=1 order by descripcion";
							echo ($dat->Cargarlista($s,$_REQUEST["tipo_beneficiario"]));
						?>
						</select>
                    </td>
                </tr>
                <tr>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
				</tr>
				<tr>
					<td colspan="5" align="center">
						<input type="button" id="btnFiltrar" name="btnFiltrar" value="Filtrar" onclick="filtrar();">
					</td>
				</tr>
					<td colspan="6" style="border:#CCCCCC solid 1px;">
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
		<td>N&deg; Caso</td>
		<td>Remitente</td>
		<td>Solicitante</td>
		<td>Beneficiario</td>
		<td>Estatus</td>
		<td>Analista</td>
	</tr>

	<?

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
                        ,
			"campo7"=>array
			(
				"columna"=>"sanalista",
				"alineacion"=>"center",
				"destino"=>""
			)

		);//Tabla

		echo $dat->cargar_tabla_botones_Efectividad($sql, $Tabla, NULL, 15, "idcaso", true, true);

	?>
	</table>
           
<iframe NAME="exportacion" id="exportacion" frameborder="0" style="display:none"  HEIGHT="100" WIDTH="100%" align="top"></iframe>

</form>
</body>
</html>
