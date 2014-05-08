<?php

    include_once('aplicaciones.php');
    require_once("../cdatos/ccasos.php");
    $ccaso=new ccasos();
	
	validar_sesion();
   
	if (isset($_REQUEST["accion"])) 
	{
	   if ($_REQUEST["accion"]=="eliminar")
		{       
			$ccaso->Conectar();
			$nseg=$ccaso->Count("seguimientos", "idusuario=".$_REQUEST["idusuario"]);
			$nseg2="0";

			$rs_registros=new Recordset("select descripcion from maestro where idmaestro=139", $ccaso->conn);

			if ($rs_registros->Mostrar())
			{
				$usuarios_comite=$rs_registros->rowset["descripcion"];
				$data_registros=  explode(",", $rs_registros->rowset["descripcion"]);
			}

			$usuarios_comite="";

			foreach ($data_registros as $value)
			{
				if ($value==$_REQUEST["idusuario"])
				{
					$usuarios_comite.=$value.", ";
				}
			}

			if ($usuarios_comite<>"")   $nseg2="1";

			if ($nseg>0 || $nseg2>0)
			{
				//if ($nseg>0)    mensaje("No es Posible Eliminar el Usuario Seleccionado debido a que Posee Registros Asociados");
				//if ($nseg2>0)    mensaje("No es Posible Eliminar el Usuario Seleccionado debido a que esta Definido como Integrante del Comite");
				if (($nseg>0) || ($nseg2>0))
				{
					$ccaso->Ejecutarsql("update sis_usuarios set idestatus=2 where idusuario=".$_REQUEST["idusuario"]);
					if ($_REQUEST["idusuario"] == $_SESSION["idusuario"]) {
						mensaje("!Se ha Auto Desactivado su Usuario, se Cerrará su Sesión...!");
						redirect("cerrar_sesion.php", "_parent");
					}
					else
						mensaje("El Usuario ha Sido Desactivado con Exito");
				}
			}
			else
			{
				$ccaso->Ejecutarsql("delete from sis_usuarios where idusuario=".$_REQUEST["idusuario"]);
				mensaje("El Usuario ha Sido Eliminado con Exito");
			}

		}
		else if ($_REQUEST["accion"]=="resetear")
		{
			$ccaso->Conectar();
			$ccaso->Ejecutarsql("update sis_usuarios set clave='e10adc3949ba59abbe56e057f20f883e' where idusuario=".$_REQUEST["idusuario"]);
			mensaje("El Password del Usuario ha Sido Reseteado con Exito");
		}
		else if ($_REQUEST["accion"]=="activar")
		{
			$ccaso->Conectar();
			$ccaso->Ejecutarsql("update sis_usuarios set idestatus = 1 where idusuario=".$_REQUEST["idusuario"]);
			mensaje("El Usuario ha Sido Activado con Exito");
		}
	}
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


        document.oncontextmenu = function(){return false}
            var strSeperator = '/';
            var shift=false;
            var crtl=false;
            var alt=false;

            function CedulaFormat(vCedulaName,mensaje,postab,escribo,evento) {

		tecla=getkey(evento);
		vCedulaName.value=vCedulaName.value.toUpperCase();
		vCedulaValue=vCedulaName.value;
		valor=vCedulaValue.substring(2,12);
		var numeros='0123456789/';
		var digit;
		var noerror=true;

		if (shift && tam>1) {
			return false;
		}

		for (var s=0;s<valor.length;s++){
			digit=valor.substr(s,1);

			if (numeros.indexOf(digit)<0)
			{
				noerror=false;
				break;
			}
		}

		tam=vCedulaValue.length;
		if (escribo) {
		if ( tecla==8 || tecla==37)
		{
			if (tam>2)
				vCedulaName.value=vCedulaValue.substr(0,tam-1);
			else
				vCedulaName.value='';
				return false;
		}

		if (tam==0 && tecla==69) {
			vCedulaName.value='E-';
			return false;
		}

		if (tam==0 && tecla==86) {
			vCedulaName.value='V-';
			return false;
		}

		if (tam==0 && tecla==80) {
			vCedulaName.value='P-';
			return false;
		}

		else if ((tam==0 && ! (tecla<14 || tecla==69 || tecla==86 || tecla==46)))
		return false;
		else if ((tam>1) && !(tecla<14 || tecla==16 || tecla==46 || tecla==8 || (tecla >= 48 && tecla <= 57) || (tecla>=96 && tecla<=105)))
		return false;
		}
		if (noerror)
		return true;

		alert('Debe ser una Cédula Válida\nPor Favor Reescribala');
		return false;
	}

	function getkey(e)
	{
		if (window.event)
		{
			shift= event.shiftKey;
			ctrl= event.ctrlKey;
			alt=event.altKey;
			return window.event.keyCode;
		}
		else if (e)
		{
			var valor=e.which;
			if (valor>96 && valor<123)
			{
				valor=valor-32;
			}

			return valor;

		}
		else
		return null;
	}

	function  nuevo()
	{
		window.open('frm_usuarios.php?accion=nuevo', 'contenido');
	}

    function consultar()
	{
		if (document.frm_usuarios.idusuario_selec.value>0)
		{
                    window.open('frm_usuarios.php?accion=consultar&idusuario='+document.frm_usuarios.idusuario_selec.value,'contenido');
		}
		else
			alert('¡Debe Seleccionar un Usuario Primero..!');
	}

	function  editar()	{
		if (document.frm_usuarios.idusuario_selec.value > 0) {
			window.open('frm_usuarios.php?accion=editar&idusuario='+document.frm_usuarios.idusuario_selec.value,'contenido');
		}
		else
			alert('¡Debe Seleccionar un Usuario Primero..!');
	}

	function seleccionado(id, idusuario)
	{
		var concatenar

		if (id>0)
		{
			concatenar='document.frm_usuarios.opcion['+id+']';
		}
		else
		{
			concatenar='document.frm_usuarios.opcion';
		}

		box = eval(concatenar);
		box.checked=true;

		document.frm_usuarios.idusuario_selec.value=idusuario;

	}

	function eliminar()	{
		if (document.frm_usuarios.idusuario_selec.value > 0) {
            var resp
            resp=confirm('¿ Esta Seguro que Desea Eliminar el Usuario Seleccionado ?');

            if ((resp)&& (document.frm_usuarios.idusuario_selec.value>0)) {
                window.open('lst_usuarios.php?accion=eliminar&idusuario='+document.frm_usuarios.idusuario_selec.value,'contenido');
            }
		} else {
			alert('¡Debe Seleccionar un Usuario Primero..!');
		}

	}

    function activar(){
		if (document.frm_usuarios.idusuario_selec.value > 0) {
	    	var resp
    	    resp = confirm('¿ Esta Seguro que Desea Activar el Usuario Seleccionado ?');
	        if (resp) {
            	window.open('lst_usuarios.php?accion=activar&idusuario='+document.frm_usuarios.idusuario_selec.value,'contenido');
			}
		}
		else {
			alert('¡Debe Seleccionar un Usuario Primero..!');
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
            document.frm_usuarios.submit();
        }

	function get_filtro()
	{
		window.open('lst_usuarios.php?accion=buscar', '_self');
	}

        function resetear()
	{

            var resp
            resp=confirm('¿ Esta Seguro que Desea Resetear el Password del Usuario Seleccionado ?');

            if ((resp)&& (document.frm_usuarios.idusuario_selec.value>0))
            {
                window.open('lst_usuarios.php?accion=resetear&idusuario='+document.frm_usuarios.idusuario_selec.value,'contenido');
            }
            
	}


</script>

<link href="../comunes/css/general.css" rel="stylesheet" type="text/css" />
<link href="../comunes/css/enlaces.css" rel="stylesheet" type="text/css" />

</head>

<body>
<script src="../comunes/js/wz_tooltip/wz_tooltip.js" type="text/javascript"></script>
<form name="frm_usuarios" action="lst_usuarios.php?accion=buscar" method="post">

	<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr>
	<td width="76%" class="menu_izq_titulo">
		<img src="../comunes/imagenes/group_gear.png" />
		Usuarios del Sistema
	</td>
	 <?
	 		require_once("../librerias/db_postgresql.inc.php");
			require("datos_usuario.php");
                        
			if (validar_vacio($cusuario->get_idusuario())) redirect("login.php","_self");

	 		$cusuario->set_objeto(USUARIOS);
			$cusuario->getPermisos();

			if ($cusuario->get_consultar()=='1') echo "<td width=\"4%\" align=\"center\"><a href=\"javascript:consultar()\"><img  alt=\"Consultar Usuario\" title=\"Consultar Usuario\" src=\"../comunes/imagenes/user.png\" border=\"0\"/></a> </td>";

			if ($cusuario->get_insertar()=='1') echo "<td width=\"4%\" align=\"center\"><a href=\"javascript:nuevo()\"><img  alt=\"Nuevo Usuario\" title=\"Nuevo Usuario\" src=\"../comunes/imagenes/user_add.png\" border=\"0\"/></a> </td>";

			if ($cusuario->get_actualizar()=='1') echo "<td width=\"4%\" align=\"center\"><a href=\"javascript:editar()\"><img  alt=\"Editar Usuario\" title=\"Editar Usuario\" src=\"../comunes/imagenes/user_edit.png\" border=\"0\"/></a> </td>";

			if ($cusuario->get_eliminar()=='1') echo "<td width=\"4%\" align=\"center\"><a href=\"javascript:eliminar()\"><img  alt=\"Desactivar Usuario\" title=\"Desactivar Usuario\" src=\"../comunes/imagenes/user_delete.png\" border=\"0\"/></a> </td>";

			if ($cusuario->get_consultar()=='1') echo "<td width=\"4%\" align=\"center\"><a href=\"javascript:buscar('dvBusqueda')\"><img  alt=\"Buscar Usuario\" title=\"Buscar Usuario\" src=\"../comunes/imagenes/page_white_find.png\" border=\"0\"/></a> </td>";

                        if ($cusuario->get_actualizar()=='1') echo "<td width=\"4%\" align=\"center\"><a href=\"javascript:activar()\"><img  alt=\"Activar Usuario\" title=\"Activar Usuario\" src=\"../comunes//imagenes/user_go.png\" border=\"0\"/></a> </td>";

            		#if ($cusuario->get_actualizar()=='1') echo "<td width=\"4%\" align=\"center\"><a href=\"javascript:resetear()\"><img  alt=\"Resetear Usuario\" title=\"Resetear Usuario\" src=\"../comunes/imagenes/key_go.png\" border=\"0\"/></a> </td>";

	 ?>


	</tr>
	</table>

	<input type="hidden" id="idusuario_selec" name="idusuario_selec" />
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
                    <td width="95"><strong>C&eacute;dula:</strong></td>
                    <td width="176"><label>
                    <input name="cedula" type="text" class="inputbox" id="cedula" onkeypress="return CedulaFormat(this,'Cédula de Identidad Invalida',-1,true,event)" onmouseout="UnTip()" maxlength="12" value="<?= @$_REQUEST['cedula'] ?>" ></input>
                    </label>
                    </td>
                    <td width="89"><strong>Nombres</strong></td>
                    <td width="199">
                    <input name="nombres" type="text" class="inputbox" id="nombres" onkeypress="return validar_texto(this.form,this,event,'')" value="<?= @$_REQUEST['nombres'] ?>"></input>
                    </td>
                </tr>


                <tr>
                <td width="1">&nbsp;</td>
                <td width="95">
                    <strong>Nombre de Usuario:</strong>
                </td>
                <td width="176">
                    <label>
                        <input name="nombre_usuario" type="text" class="inputbox" id="nombre_usuario" onkeypress="return validar_texto(this.form,this,event,'')" value="<?= @$_REQUEST['nombre_usuario'] ?>"></input>
                    </label>
                </td>
                <td width="89"><strong>Grupo de Usuario:</strong></td>
                    <td width="199">
                         <select name="grupo" id="grupo" style="width:160px;" class="inputbox">
                        <option value>Seleccione...</option>
                        <?php
                        echo ($dat->Cargarlista("select idmaestro, descripcion from vgrupos_usuarios where estatus=1 order by descripcion", $_REQUEST["grupo"]));
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
	<td>Nombre</td>
	<td>Apellido</td>
	<td>Grupo</td>
	<td>Estatus</td>
	</tr>

	<?
		
		$textout='';
		$filtro='';
                
        #$sql="select idusuario, nombres, apellidos, sgrupo, idestatus, sestatus from vusuarios where idusuario > 0 AND idusuario != ".$_SESSION["idusuario"];
		$sql="select idusuario, nombres, apellidos, sgrupo, idestatus, sestatus from vusuarios where idusuario > 0 ";

		if (isset($_REQUEST["accion"])&&$_REQUEST["accion"]=="buscar")
		{
                   if ($_REQUEST['nombres']!="") $filtro.=" and upper(snombre_usuario) like '%".strtoupper($_REQUEST["nombres"])."%'";
                   if ($_REQUEST['nombre_usuario']!="") $filtro.=" and upper(login) like '%".strtoupper($_REQUEST["nombre_usuario"])."%'";
                   if ($_REQUEST['cedula']!="")   $filtro.=" and cedula='".$_REQUEST["cedula"]."'";
                   if (!validar_id_vacio($_REQUEST["grupo"]))   $filtro.=" and idgrupo=".$_REQUEST["grupo"];
				   
				   

		}

        $sql.= $filtro." order by nombres";

                //echo $sql;

		$dat->Conectar();
		$rs_tabla=new Recordset($sql, $dat->conn);
		$fila_tabla=1;
		$nreg=0;
	
		while ($rs_tabla->Mostrar())
		{

			if(($fila_tabla%2)==0) 	$textout.="<tr class=\"fila\" style=\"font-size: 12px; cursor:pointer;\" onclick=\"javascript:seleccionado('".$nreg."', '".$rs_tabla->rowset["idusuario"]."')\"  bgcolor='#eeeeee' onload=\"this.style.background='#eeeeee'\"  onMouseOver=\"this.style.background='#E1E1E1'; this.style.color='blue'\" onMouseOut=\"this.style.background='#eeeeee'; this.style.color='black'\">";

			else $textout.="<tr class=\"fila\" style=\"font-size: 12px; cursor:pointer;\" onclick=\"javascript:seleccionado('".$nreg."', '".$rs_tabla->rowset["idusuario"]."')\" bgcolor='#FFFFFF' onload=\"this.style.background='#FFFFFF'\" onMouseOver=\"this.style.background='#E1E1E1'; this.style.color='blue'\" onMouseOut=\"this.style.background='#FFFFFF'; this.style.color='black'\">";

			$textout.="<td><input type=\"radio\" name=\"opcion\" id=\"opcion\" value=\"".$rs_tabla->rowset["idusuario"]."\"></td>";
			$textout.="<td>".$rs_tabla->rowset["nombres"]."</td>";
			$textout.="<td>".$rs_tabla->rowset["apellidos"]."</td>";
			$textout.="<td>".$rs_tabla->rowset["sgrupo"]."</td>";

			if ($rs_tabla->rowset["idestatus"]=="1")
			{
				$imagen_user="../comunes/imagenes/activo.gif";
				$estilo_imagen ="width=\"14\" height=\"14\"";
			}
			else
			{
				$imagen_user="../comunes/imagenes/inactivo.gif";
				$estilo_imagen ="width=\"12\" height=\"12\"";
			}
			$textout.="<td><a href=\"javascript:void('0')\"><img  src=\"".$imagen_user."\" border=\"0\" ".$estilo_imagen." title=\"".$rs_tabla->rowset["sestatus"]."\"/></a></td>";

			$textout.="</tr>";
			$rs_tabla->Siguiente();
			$fila_tabla+=1;
			$nreg+=1;

		}//while

		echo $textout;

	?>
	</table>

        <div id="dvUsuarios" >                 </div>

</form>
</body>
</html>
