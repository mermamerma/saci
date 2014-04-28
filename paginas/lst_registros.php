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
<link href="../comunes/css/enlaces.css" rel="stylesheet" type="text/css" />
	
	<style>
		body {padding:0px;margin:0px;text-align:left;font:11px verdana, arial, helvetica, serif;}
	</style>
	
<script src="../comunes/js/run2.js" type="text/javascript"></script>
<script src="../comunes/js/funciones.js" type="text/javascript"></script>
<script language="javascript" src="../comunes/js/ajax_grid_registro.js"></script>

</head>

<body onLoad="getagents('idmaestro','')">
<center>

<table width="100%" border="0" cellspacing="0" cellpadding="0">
<tr>
<td width="90%" class="menu_izq_titulo">Mantenimiento de Registros de la Tabla : <? echo $_GET["nombre"];
$_SESSION["npadre"]=$_REQUEST["id"]?></td>
<td width="10%" align="right"></td>

</tr>
</table>

<div id="hiddenDIV" style="visibility:hidden; background-color:white; border: 0px solid black;"></div>

</center>
</body>
</html>
