<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>SACi - Sistema de Atención al Ciudadano</title>
<script src="../comunes/js/funciones.js" type="text/javascript"></script>
<link href="../comunes/css/general.css" rel="stylesheet" type="text/css" />

<style>
    body {padding:0px;margin:0px;text-align:left;font:11px verdana, arial, helvetica, serif; background-color:#FFFFFF}
</style>


<script language="javascript">

	function cerrar()
	{
		window.open("lst_personalizacion.php","_self");
	}

	function guardar()
	{
		window.document.getElementById('accion').value='guardar';
		document.form1.submit();
	}
        
        function eliminar(idregistro)
	{
                window.document.getElementById('idregistro').value=idregistro;
		window.document.getElementById('accion').value='eliminar';
		document.form1.submit();
	}

</script>



</head>

<body>

<table width="100%" border="0">
<tr>
<td>
<div class="contenedor_botones">
    <table width="100%" border="0" cellspacing="0" cellpadding="0">

      <tr>
        <td width="75%" class="menu_izq_titulo"><img src="../comunes/imagenes/ico_48_casos.gif" />Asignaci&oacute;n de Categor&iacute;as y SubCategor&iacute;as </td>
        <td width="20%" style="vertical-align:bottom" align="right">
		<a  href="#" onclick="javascript:cerrar()"><img src="../comunes/imagenes/door_in.png"  border="0" alt="Cerrar" title="Cerrar"/></a>
		</td>
		<td width="5%">
      </tr>
    </table>
  </div>
</td>
</tr>
</table>

<?

	require_once("../librerias/db_postgresql.inc.php");	
	$error_respuesta=false;
	$msg_error='';

	if (isset($_REQUEST["accion"])) 
	{
		if ($_REQUEST["accion"]=="guardar")
		{

			if (!$_REQUEST["tipo_caso"]>0)
			{
				$msg_error="Debe Seleccionar la Clasificación";
				$error_respuesta=true;
			}

			if (!$_REQUEST["categoria_caso"]>0)
			{
				$msg_error="Debe Seleccionar la Categoría";
				$error_respuesta=true;
			}

			if (!$_REQUEST["subcategoria"]>0)
			{
				$msg_error="Debe Seleccionar la SubCategoría";
				$error_respuesta=true;
			}

			if ($error_respuesta==false)
			{
				$existe=$dat->Count("tipocasos_categorias","idtipocaso=".$_REQUEST["tipo_caso"]." and idcategoria=".$_REQUEST["categoria_caso"]." and idsubcategoria=".$_REQUEST["subcategoria"]."");

				if ($existe > 0)
				{
					$msg_error="La Relación de las Categorías Seleccionadas Ya Existe Asignada en el Sistema";
					$error_respuesta=true;
				}
				else
				{
					$dat->Ejecutarsql("insert into tipocasos_categorias (idtipocaso, idcategoria, idsubcategoria, idusuario) values (".$_REQUEST["tipo_caso"].", ".$_REQUEST["categoria_caso"].", ".$_REQUEST["subcategoria"].", ".$_SESSION["idusuario"].")");

				}//existe

			}//error_respuesta
			else
			{
				$_REQUEST["accion"]="";
				mensaje($msg_error);
			}

		}
		
		else if ($_REQUEST["accion"]=="eliminar")
		{
				
				$sql="select count(c.*) from casos c inner join casos_categorias cg on c.idcaso=cg.idcaso inner join tipocasos_categorias tcg on c.idtipocaso=tcg.idtipocaso and c.idcategoria=tcg.idcategoria and cg.idsubcategoria=tcg.idsubcategoria where tcg.idregistro=".$_REQUEST["idregistro"];
				$ocasos=$dat->getValor_Campo($sql, "ncasos");

				if ($ocasos["ncasos"]>0)
				{
					$dat->Ejecutarsql("delete from tipocasos_categorias where idregistro=".$_REQUEST["idregistro"]);
				}
				else
				{
					mensaje("No es Posible Eliminar la Relación de Categorías Seleccionada Debido a que se Encuentra Asignada a un Caso Existente");
				}

		}
	}

?>


 <form name="form1" action="frm_tipo_categorias.php" method="post">

<table width="100%" height="100%" border="0">
<tr>

<td width="100%">

<!-- contenido formulario-->

<table style="height:100%; width:100%; margin-top:0px;"  border="0" cellspacing="0" cellpadding="0">
<tr>
<td>

	<div style="margin-bottom:0px; margin-top:0px;" align="center">
	<div class="box1"><div><div><img name="top" class="blank" id="top" /></div></div></div>
	<div class="box3">

            <input type="hidden" name="accion" id="accion" value="<? if(isset($_REQUEST["accion"])){ echo $_REQUEST["accion"]; } ?>" />
            <input type="hidden" name="idregistro" id="idregistro" value="<? if(isset($_REQUEST["idregistro"])){ echo $_REQUEST["idregistro"]; } ?>" />

            <table width="550px;" cellpadding="0" cellspacing="0" border="0">
            <tr>
            <td width="100" height="30" class="celda_etiqueta">Tipo de Caso:</td>
            <td width="160"><select name="tipo_caso"  id="tipo_caso" class="inputbox_lectura"  onchange="javascript:document.form1.submit()" style="width:160px;"><option value>Seleccione...</option>
            <?php
            echo ($dat->Cargarlista("select idmaestro, descripcion from vtipos_casos where estatus=1 order by descripcion", $_REQUEST["tipo_caso"]));
            ?>
            </select> </td>
            <td width="15px;">&nbsp;</td>
            <td width="100" class="celda_etiqueta">Categor&iacute;as:</td>
            <td width="160"><select name="categoria_caso" id="categoria_caso" onchange="javascript:document.form1.submit()" class="inputbox_lectura" style="width:160px;"><option value>Seleccione...</option>
            <?php
            echo ($dat->Cargarlista("select idmaestro, descripcion from vcategorias_casos where estatus=1 order by descripcion", $_REQUEST["categoria_caso"]));
            ?>
            </select></td>
			<td width="15px;">&nbsp;</td>
			</tr>
			<tr>
			<td width="100" class="celda_etiqueta">SubCategor&iacute;as:</td>
            <td width="160"><select name="subcategoria" id="subcategoria" class="inputbox_lectura" style="width:160px;"><option value>Seleccione...</option>
			<?php
			echo ($dat->Cargarlista("select idmaestro, descripcion from vsubcategorias where estatus=1 order by descripcion", $_REQUEST["subcategoria"]));
			?>
			</select></td>
			<td width="15px;"><a href="javascript:guardar()"><img src="../comunes/imagenes/edit_add.png" width="16" height="16"  border="0" /></a></td>

			<td width="100">&nbsp;</td>
			<td width="160">&nbsp;</td>
			<td width="15px;"></td>
            </tr>
			</table>

	</div>
	</div>
	<div class="box4"><div><div><img name="top" height="1" class="blank" id="top" /></div></div></div>

</td>
</tr>

</table>

</td>

</tr>


</table>




<table width="100%" style="margin-top:10px;">
<tr style="background:#999999;color:#FFFFFF;">
<td width="25%" align="center" height="30"><strong>Tipo de Caso</strong></td>
<td width="35%" align="center" height="30"><strong>Categor&iacute;a</strong></td>
<td width="35%" align="center" height="30"><strong>SubCategor&iacute;a</strong></td>
<td width="5%" align="center"><strong>Acci&oacute;n</strong></td>
</tr>
<?

	$filtro='';

	if (isset($_REQUEST["tipo_caso"])) 
	{

		if (!validar_vacio($_REQUEST["tipo_caso"]) && $_REQUEST["tipo_caso"]>0)
		{
			$filtro=" where idtipocaso=".$_REQUEST["tipo_caso"];
		}
	}

	if (isset($_REQUEST["tipo_caso"])) 
	{
		if (!validar_vacio($_REQUEST["categoria_caso"]) && $_REQUEST["categoria_caso"]>0)
		{
			$filtro.=" and idcategoria=".$_REQUEST["categoria_caso"];
		}
	}	

	if ($filtro<>'')
	{
        //echo "select idregistro, idtipocaso, idcategoria, idsubcategoria, stipo_caso, scategoria, ssubcategoria from vtipocasos_categorias ".$filtro;
		$dat->Conectar();
		$rs_tabla=new Recordset("select idregistro, idtipocaso, idcategoria, idsubcategoria, stipo_caso, scategoria, ssubcategoria from vtipocasos_categorias ".$filtro, $dat->conn);


		$swfondo=true;
		$textout="";

		while ($rs_tabla->Mostrar())
		{
			if ($swfondo)
			{
				$textout.= '<tr style="background:#CCCCCC;">';
				$swfondo=false;
			}
			else
			{
				$textout.= '<tr>';
				$swfondo=true;
			}

			$textout.="<td align=\"center\">".$rs_tabla->rowset["stipo_caso"]."</td><td align=\"center\">".$rs_tabla->rowset["scategoria"]."</td><td align=\"center\">".$rs_tabla->rowset["ssubcategoria"]."</td><td align=\"center\" class='elemento'><a href=\"javascript:eliminar('".$rs_tabla->rowset["idregistro"]."')\"><img src='../comunes/imagenes/delete.png' width=\"16\" height=\"16\" title='Eliminar Relación' border='0' /></a></td>";

			$rs_tabla->Siguiente();

			}//while

		echo $textout;

	}

?>
    
</table>

</form>






</body>
</html>
