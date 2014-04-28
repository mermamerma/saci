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
<script src="../comunes/js/prototype.js" type="text/javascript"></script>

<script language="javascript">

	function  nuevo()
	{
		abrir_ventana('frm_casos.php?accion=nuevo', 'contenido');
	}

	function  editar()
	{
		if (document.frmlista_casos.idcaso_selec.value>0)
		{
                    window.open('frm_casos.php?accion=editar&idcaso='+document.frmlista_casos.idcaso_selec.value,'contenido');
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

	function eliminar()
	{

                var resp
		resp=confirm('¿ Esta Seguro que Desea Eliminar el Caso Seleccionado ?');

		if ((resp)&& (document.frmlista_casos.idcaso_selec.value>0))
		{
                    xajax_eliminarCaso(document.frmlista_casos.idcaso_selec.value);
			//abrir_ventana('frm_casos.php?idtipocaso=16&accion=eliminar&idcaso='+document.frmlista_casos.idcaso_selec.value, 'casos_infra');
		}

	}

	function consultar()
	{
		if (document.frmlista_casos.idcaso_selec.value>0)
		{
                    window.open('frm_casos.php?accion=consultar&idcaso='+document.frmlista_casos.idcaso_selec.value,'contenido');
		}
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

<?
    $xajax->printJavascript('../comunes/xajax/');
?>

<link href="../comunes/css/general.css" rel="stylesheet" type="text/css" />
<link href="../comunes/css/enlaces.css" rel="stylesheet" type="text/css" />

</head>

<body>
<script src="../comunes/js/wz_tooltip/wz_tooltip.js" type="text/javascript"></script>
<form name="frmlista_casos" method="post">

	<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr>
	<td width="76%" class="menu_izq_titulo">Casos </td>


	 <?
         
            require_once("../librerias/db_postgresql.inc.php");
            require_once("../cdatos/ccasos.php");
            include_once("datos_usuario.php");
            
            if (validar_vacio($cusuario->get_idusuario())) redirect("login.php","_self");
            $idgrupo_usuario=$cusuario->get_idgrupo();
            
            $cusuario->set_objeto(SEGUIMIENTO_CASO);
            $cusuario->getPermisos();

            if ($cusuario->get_consultar()=='1') echo "<td width=\"4%\" align=\"center\"><a href=\"javascript:consultar()\"><img  alt=\"Consultar Caso\" title=\"Consultar Caso\" src=\"../comunes/imagenes/folder_explore.png\" style=\"width: 20px;\" border=\"0\"/></a> </td>";

            if ($cusuario->get_actualizar()=='1') echo "<td width=\"4%\" align=\"center\"><a href=\"javascript:editar()\"><img alt=\"Editar Caso\" title=\"Editar Caso\" src=\"../comunes/imagenes/folder_edit.png\" style=\"width: 20px;\" border=\"0\"/></a> </td>";

            if ($cusuario->get_eliminar()=='1') echo "<td width=\"4%\" align=\"center\"><a href=\"javascript:eliminar()\"><img  alt=\"Eliminar Caso Caso\" title=\"Eliminar Caso\" src=\"../comunes/imagenes/folder_delete_2.png\" style=\"width: 20px;\" border=\"0\"/></a> </td>";

            if ($cusuario->get_consultar()=='1') echo  "<td width=\"4%\" align=\"center\"><a href=\"javascript:buscar('dvBusqueda')\"><img alt=\"Buscar Caso\" title=\"Buscar Caso\" src=\"../comunes/imagenes/folder_find.png\" style=\"width: 20px;\" border=\"0\"/></a> </td>";

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
                    <td width="95"><strong>Remitente:</strong></td>
                    <td width="176">
                        <label>
                        <select name="remitente" id="remitente" style="width:166px;" class="inputbox" >
                        <option value="0">Seleccione...</option>
                        <?php
                        echo ($dat->Cargarlista("select idmaestro, descripcion from vremitentes where estatus=1 order by descripcion", $_REQUEST["remitente"]));
                        ?>
                        </select>
                        </label>
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
                    <td width="176"><label>
                    <input name="cedula_solic" type="text" class="inputbox" id="cedula_solic" onkeypress="return CedulaFormat(this,'Cédula de Identidad Invalida',-1,true,event)" onmouseout="UnTip()" maxlength="12" value="<?= $_REQUEST['cedula_solic'] ?>" ></input>
                    </label>
                    </td>
                    <td width="89"><strong>R.I.F:</strong></td>
                    <td width="199"><input name="rif_solic" type="text" class="inputbox" id="rif_solic" onkeypress="return RifFormat(this,'Rif del Solicitante Invalido',-1,true,event)" onmouseout="UnTip()" maxlength="12" value="<?= $_REQUEST['rif_solic'] ?>" ></input>
                    </td>
                </tr>


                <tr>
                <td width="1">&nbsp;</td>
                <td width="95">
                    <strong>Raz&oacute;n Social:</strong>
                </td>
                <td width="176">
                    <label>
                        <input name="razon_social_solic" type="text" class="inputbox" id="razon_social_solic" onkeypress="return validar_texto(this.form,this,event,'')" value="<?= $_REQUEST['razon_social_solic'] ?>"></input>
                    </label>
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
                    <td width="176"><label>
                    <input name="cedula_benef" type="text" class="inputbox" id="cedula_benef" onkeypress="return CedulaFormat(this,'Cédula de Identidad Invalida',-1,true,event)" onmouseout="UnTip()" maxlength="12" value="<?= $_REQUEST['cedula_benef'] ?>" ></input>
                    </label>
                    </td>
                    <td width="89"><strong>R.I.F:</strong></td>
                    <td width="199"><input name="rif_benef" type="text" class="inputbox" id="rif_benef" onkeypress="return RifFormat(this,'Rif del Beneficiario Invalido',-1,true,event)" onmouseout="UnTip()" maxlength="12" value="<?= $_REQUEST['rif_benef'] ?>" ></input>
                    </td>
                </tr>


                <tr>
                <td width="1">&nbsp;</td>
                <td width="95">
                    <strong>Raz&oacute;n Social:</strong>
                </td>
                <td width="176">
                    <label>
                        <input name="razon_social_benef" type="text" class="inputbox" id="razon_social_benef" onkeypress="return validar_texto(this.form,this,event,'')" value="<?= $_REQUEST['razon_social_benef'] ?>"></input>
                    </label>
                </td>
                <td width="89"><strong>Tipo de Beneficiario:</strong></td>
                    <td width="199">
                        <select name="tipo_beneficiario" id="tipo_beneficiario" style="width:166px;" class="inputbox">
                        <option value="0">Seleccione...</option>
                        <?php
                        echo ($dat->Cargarlista("select idmaestro, descripcion from vtipo_solicitantes where estatus=1 order by descripcion", $_REQUEST["tipo_beneficiario"]));
                        ?>
                        </select>
                    </td>
                </tr>




                 <tr>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                            </tr>

                            <tr>
                                <td colspan="5" align="center"><input type="button" id="btnFiltrar" name="btnFiltrar" value="Filtrar" onclick="filtrar();"> </td>
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
	</tr>

	<?

                $textout='';
            
                switch($idgrupo_usuario)
		{			
                    case "80":		//Transcriptor
                            $filtro=" where idestatus=61 ";
                            break;
                    default:
                            $filtro=" where idcaso in (select idcaso from casos_analistas where idanalista=".$cusuario->get_idusuario().") ";
                            break;
		}

                //$filtro=" where idcaso in (select idcaso from casos_analistas where idanalista=".$cusuario->get_idusuario().") ";

                $sql="select idcaso, sremitente, razon_social_solic, razon_social_benef, idestatus, sestatus_caso from vcasos ";
				
		if (isset($_REQUEST["accion"]) && $_REQUEST["accion"]=="buscar")
		{

                    if (!validar_id_vacio($_REQUEST["remitente"]))  $filtro.=" and idremitente=".$_REQUEST["remitente"];
                    if (!validar_id_vacio($_REQUEST["tipo_caso"]))  $filtro.=" and idtipocaso=".$_REQUEST["tipo_caso"];
                    if (!validar_id_vacio($_REQUEST["categoria"]))  $filtro.=" and idcategoria=".$_REQUEST["categoria"];
                    if (!validar_id_vacio($_REQUEST["subcategoria"]))   $filtro.=" and idcaso in (select idcaso from casos_categorias where idsubcategoria=".$_REQUEST["subcategoria"].")";
                    if (!validar_id_vacio($_REQUEST["estado"])) $filtro.=" and idestado=".$_REQUEST["estado"];
                    if (!validar_id_vacio($_REQUEST["municipio"]))  $filtro.=" and idmunicipio=".$_REQUEST["municipio"];
                    if (!validar_id_vacio($_REQUEST["parroquia"]))  $filtro.=" and idparroquia=".$_REQUEST["parroquia"];
                    if (!validar_id_vacio($_REQUEST["estatus"]))    $filtro.=" and idestatus=".$_REQUEST["estatus"];
                    if ($_REQUEST['cedula_solic']!="")  $filtro.=" and cedula_solic='".$_REQUEST["cedula_solic"]."'";
                    if ($_REQUEST['rif_solic']!="") $filtro.=" and rif_solic='".$_REQUEST["rif_solic"]."'";
                    if ($_REQUEST['razon_social_solic']!="")    $filtro.=" and upper(razon_social_solic) like '%".strtoupper($_REQUEST["razon_social_solic"])."%'";
                    if (!validar_id_vacio($_REQUEST["tipo_solicitante"]))   $filtro.=" and idtipo_solicitante_solic=".$_REQUEST["tipo_solicitante"];
                    if ($_REQUEST['cedula_benef']!="")  $filtro.=" and cedula_benef='".$_REQUEST["cedula_benef"]."'";
                    if ($_REQUEST['rif_benef']!="") $filtro.=" and rif_benef='".$_REQUEST["rif_benef"]."'";
                    if ($_REQUEST['razon_social_benef']!="")    $filtro.=" and upper(razon_social_benef) like '%".strtoupper($_REQUEST["razon_social_benef"])."%'";
                    if (!validar_id_vacio($_REQUEST["tipo_beneficiario"]))  $filtro.=" and idtipo_solicitante_benef=".$_REQUEST["tipo_beneficiario"];

		}

                $sql.= $filtro." order by idcaso desc";

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
				"destino"=>"",
				"imagen_tabla"=>"../comunes/imagenes/flag_green.png",
				"target"=>"",
				"titulo_mensaje"=>"Efectividad"
			)
		);//Tabla

		echo $dat->cargar_tabla_botones_Efectividad($sql, $Tabla, NULL, 15, "idcaso", true, true);

	?>
	</table>

        <div id="dvprueba" >                 </div>

</form>
</body>
</html>
