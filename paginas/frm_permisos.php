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
		body {padding:0px;margin:0px;text-align:left;font:11px verdana, arial, helvetica, serif; background-color:#FFFFFF}
	</style>
	
<script src="../comunes/js/run2.js" type="text/javascript"></script>
<script src="../comunes/js/funciones.js" type="text/javascript"></script>

<script language="javascript">
	
	function guardar()
	{
		//alert (document.getElementById('accion').value);
		//document.getElementById('accion').value="guardar";
		document.frmpermisos.submit();
	}
	
</script>

</head>

<body>

<?

 	require_once("../librerias/db_postgresql.inc.php");

 	$sql="insert into sis_permisos (idgrupo, idobjeto, seleccionar, eliminar, actualizar, ejecutar, insertar, menu) 
	select vu.idmaestro as grupo, vo.idmaestro as objeto, '0', '0', '0', '0', '0', '0' from vgrupos_usuarios vu, vsis_objetos vo 
	where vo.idmaestro not in (select idobjeto from vsis_permisos)  or vu.idmaestro not in (select idgrupo from vsis_permisos)";

	$dat->Ejecutarsql($sql);


         if (isset($_REQUEST["accion"]) && $_REQUEST["accion"]=="guardar")
         {

                for ($i=1;$i<=$_SESSION["total_obj"];$i++)
                {

                        $swmenu=false;

                        if(!isset($_POST["seleccionar".$i]))
                        {
                                $_POST["seleccionar".$i]=0;
                                $swmenu=true;
                        }

                        if(!isset($_POST["eliminar".$i]))
                        {
                                $_POST["eliminar".$i]=0;
                                $swmenu=true;
                        }

                        if(!isset($_POST["actualizar".$i]))
                        {
                                $_POST["actualizar".$i]=0;
                                $swmenu=true;
                        }

                        if(!isset($_POST["ejecutar".$i]))
                        {
                                $_POST["ejecutar".$i]=0;
                                $swmenu=true;
                        }

                        if(!isset($_POST["insertar".$i]))
                        {
                                $_POST["insertar".$i]=0;
                                $swmenu=true;
                        }

                        if($swmenu==true)
                        {
                                $_POST["menu".$i]=1;
                        }
                        else
                        {
                                $_POST["menu".$i]=0;
                        }

                        $sql="UPDATE  sis_permisos  set seleccionar='".$_POST["seleccionar".$i]."', eliminar='".$_POST["eliminar".$i]."', actualizar='".$_POST["actualizar".$i]."', ejecutar='".$_POST["ejecutar".$i]."', insertar='".$_POST["insertar".$i]."', menu='".$_POST["menu".$i]."' where idpermiso=".$_POST["idpermiso".$i];

                        $dat->Ejecutarsql($sql);

                }//for

                $_REQUEST["accion"]="";

         }

?>

<form name="frmpermisos" action="frm_permisos.php" method="post">

	<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr>
	<td width="96%" class="menu_izq_titulo">
	<img src="../comunes/imagenes/key.png" />
	Permisología
	</td>
	 
	<td width="4%" align="center"><a href="javascript:guardar()"><img  alt="Guardar Permisos" title="Guardar Permisos" src="../comunes/imagenes/16_savecompleted.gif" border="0"/></a> </td>
	</tr>
	
	<tr style=" padding-top:20px;">
	<td colspan="2">Nota: En el &Iacute;tems Asignaci&oacute;n de Analistas la columna Insertar aplica para la asignaci&oacute;n y la columna actualizar aplica para Reasignar respectivamente.</td>
	</tr>
	</table>
	
	
	<table width="100%" cellpadding="0" cellspacing="0" border="0"  align="center" style="margin-bottom:15px; margin-top:15px;">
	<tr>	
	<td width="110" height="30"><strong>Grupo de Usuario:</strong></td>
	<td width="155">  <select name="idgrupo" id="idgrupo" onChange="javascript:document.frmpermisos.submit()"  style="width:250px;" class="combos2">
	<option value>Seleccione...</option>
	<?php
		echo ($dat->Cargarlista("select idmaestro, descripcion from vgrupos_usuarios where estatus=1 order by descripcion", $_REQUEST["idgrupo"]));
	?>
	</select></td>
	</tr>
	</table>
		
<table  border="0" width="100%"  align="center">
<tr  class="encabezado_tablas" >
<td width="50%" align="center">Menú</td>
<td width="10%" align="center">Consultar</td>
<td width="10%" align="center">Insertar</td>
<td width="10%" align="center">Actualizar</td>
<td width="10%" align="center">Eliminar</td>
<td width="10%" align="center">Ejecutar</td>
</tr>


<? 
	if (isset($_REQUEST["accion"]) ){
		echo "<input type=\"hidden\" name=\"accion\" id=\"accion\" value=".$_REQUEST["accion"]." >";
	}	
	
	if (isset($_REQUEST["modulo"]))
	{	
		if ($_REQUEST["modulo"]=='saris') $modulo_permiso="190";
		if ($_REQUEST["modulo"]=='madres') $modulo_permiso="191";
	}
	
	//print_r($_SESSION);
	
	
	$_SESSION["campos"]='';

    $dat->Conectar();
	$grupo='';
	
	if(isset($_REQUEST["idgrupo"]))
	{	
		$grupo=$_REQUEST["idgrupo"];
		$rs_permisos=new Recordset("select * from vsis_permisos where idgrupo=".$grupo,$dat->conn);
	}
		
	
	
	$swfondo=false;
	$textout="";
	$ind=0;
	$_SESSION["total_obj"]=0;
	
	while(@$rs_permisos->Mostrar())
	{
		
		if ($swfondo)
		{
			echo "<tr class=\"fila\" style=\"font-size: 12px; cursor:pointer;\" bgcolor='#eeeeee' onload=\"this.style.background='#eeeeee'\"  onMouseOver=\"this.style.background='#E1E1E1'; this.style.color='blue'\" onMouseOut=\"this.style.background='#eeeeee'; this.style.color='black'\" >";

			$swfondo=false;
		}
		else
		{
			echo "<tr class=\"fila\" style=\"font-size: 12px; cursor:pointer;\" bgcolor='#FFFFFF' onload=\"this.style.background='#FFFFFF'\" onMouseOver=\"this.style.background='#E1E1E1'; this.style.color='blue'\" onMouseOut=\"this.style.background='#FFFFFF'; this.style.color='black'\">";
			
			$swfondo=true;
		}
		
		$ind+=1;
		$_POST["idpermiso".$ind]=$rs_permisos->rowset["idpermiso"];
		$_POST["seleccionar"]=$rs_permisos->rowset["seleccionar"];
		$_POST["eliminar"]=$rs_permisos->rowset["eliminar"];
		$_POST["actualizar"]=$rs_permisos->rowset["actualizar"];
		$_POST["ejecutar"]=$rs_permisos->rowset["ejecutar"];
		$_POST["insertar"]=$rs_permisos->rowset["insertar"];
		$_POST["menu"]=$rs_permisos->rowset["menu"];
		$sobjeto=$rs_permisos->rowset["sobjeto"];		
		
		echo "<td align=\"left\">".$sobjeto."</td><td align=\"center\">		
		<input type=\"hidden\" name=\"idpermiso$ind\" value=".$rs_permisos->rowset["idpermiso"]." >		
		<input type=\"checkbox\"  name=\"seleccionar$ind\" value=\"1\""; if((isset($_POST["seleccionar"])) and ($_POST["seleccionar"]==1)) { echo "checked";} echo" "; if (isset($_SESSION["campos"])){ echo $_SESSION["campos"]; } echo"></td>		
		<td align=\"center\"><input type=\"checkbox\" name=\"insertar$ind\" value=\"1\"";  if((isset($_POST["insertar"])) and ($_POST["insertar"]==1)) { echo "checked";} echo" ";  if (isset($_SESSION["campos"])){ echo $_SESSION["campos"]; }echo"></td>
		<td align=\"center\"><input type=\"checkbox\" name=\"actualizar$ind\" value=\"1\""; if((isset($_POST["actualizar"])) and ($_POST["actualizar"]==1)) { echo "checked";} echo" ";  if (isset($_SESSION["campos"])){ echo $_SESSION["campos"]; }echo"></td>
		<td align=\"center\"><input type=\"checkbox\" name=\"eliminar$ind\" value=\"1\"";  if((isset($_POST["eliminar"])) and ($_POST["eliminar"]==1)) { echo "checked";}echo" "; if (isset($_SESSION["campos"])){ echo $_SESSION["campos"]; }echo"></td>
		<td align=\"center\"><input type=\"checkbox\" name=\"ejecutar$ind\" value=\"1\"";  if((isset($_POST["ejecutar"])) and ($_POST["ejecutar"]==1)) { echo "checked";} echo" ";  if (isset($_SESSION["campos"])){ echo $_SESSION["campos"]; }echo"></td>
		
		</tr>";

		$rs_permisos->Siguiente();
	
	}		
	
	$_SESSION["total_obj"]=$ind;	

?>

</table>

</form>
</body>
</html>
