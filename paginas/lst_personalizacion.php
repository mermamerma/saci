<?php
    include('aplicaciones.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta http-equiv="pragma" content="no-cache">
<link rel="shortcut icon" href="../comunes/imagenes/favicon.ico" type="image/x-icon" >
<title>SACi - Sistema de Atención al Ciudadano</title>
<link href="../comunes/css/general.css" rel="stylesheet" type="text/css" />
	<style>
		body {padding:0px;margin:0px;text-align:left;font:11px verdana, arial, helvetica, serif; background-color:#FFFFFF;}
	</style>
<script src="../comunes/js/run2.js" type="text/javascript"></script>
<script src="../comunes/js/funciones.js" type="text/javascript"></script>

<script language="javascript">

	function  nuevo()
	{
		abrir_ventana('frm_casos_infra.php', 'gr_seg');
	}

</script>

</head>

<body>
<center>

	<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr height="40px;">
	  <td>&nbsp;</td>
	  <td class="menu_izq_titulo_2">&nbsp;</td>
	  </tr>
	<tr height="40px;">
	<td width="2%">
	<img src="../comunes/imagenes/bricks_2.png" />	</td>
	<td width="98%" class="menu_izq_titulo_2"><a href="javascript:window.open('frm_tipo_categorias.php', '_self')">Tipo de Caso - Categor&iacute;a  - Sub Categor&iacute;as</a></td>
	</tr>
	<!--
        <tr height="40px;">
	<td width="2%">
	<img src="../comunes/imagenes/18_settings.gif" />	</td>
            <td width="98%" class="menu_izq_titulo"><a href="javascript:window.open('frm_miembros_comite.php', '_self')">Miembros del Comit&eacute;</a></td>
	</tr>
	-->
	</table>
</center>
</body>
</html>
