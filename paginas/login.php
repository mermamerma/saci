<?php 
require_once('aplicaciones.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="pragma" content="no-cache">
<link rel="shortcut icon" href="../comunes/imagenes/sos_red.png" type="image/x-icon" >
<script src="../comunes/js/run2.js" type="text/javascript"></script>
 <script language="javascript" src="../comunes/js/funciones.js"></script>
<title>SACi - Sistema de Atención al Ciudadano</title>
<link href="../comunes/css/general.css" rel="stylesheet" type="text/css" />
<style type="text/css">
<!--
h1 {
	font-size: 22px;
	color: #CC0000;
	margin: 0px;
	padding: 0px;
}
h2 {
	color: #999900;
	font-size: 18px;
	font-weight: normal;
	margin: 0px;
	padding: 0px;
}
p {
	width: 300px;
}
ul {
	margin-top: 15px;
	margin-right: 0px;
	margin-bottom: 0px;
	margin-left: 0px;
	width: 300px;
	padding-top: 0px;
	padding-right: 0px;
	padding-bottom: 0px;
	padding-left: 15px;
}
li {
	margin-bottom: 15px;
}
a:link {
	color: #000000;
}
a:visited {
	color: #000000;
}
a:hover {
	text-decoration: none;
}
-->
</style>
</head>

<body onload="javascript:document.form1.usuario.focus()">
<center>
<div class="contenedor_general">
	<div class="cabecero_gobierno">
  		<img src="../comunes/imagenes/cabecerogob.png" width="900" height="61" />	</div>
	<div class="banner_superior">
		<img src="../comunes/imagenes/cabecero.png" width="900" height="90" />
		<!--<script type="text/javascript">runSWF("../animaciones/banner_superior.swf", "900", "84", "", "", "", "", "", "");</script>-->
	</div>
    <div class="fondo">
	<div class="identificacion">
	<table width="100%" border="0" cellspacing="0" cellpadding="5">
	  <tr>
		<td>&nbsp; </td>
		<td align="right"><strong>Caracas,</strong>
                 <?php echo $dia_actual." de ".nombremes($mes_actual)." de ".$anio_actual?>
                </td>
	  </tr>
	</table>
	</div>

       <?php

		require_once("../librerias/db_postgresql.inc.php");
		
		if (isset($_SESSION["idusuario"])) {redirect("principal.php", "_self"); exit;}
		
		if (isset($_REQUEST["accion"]) && $_REQUEST["accion"]=="validar")
		{
                    if (validar_vacio($_POST["usuario"]))
                    {
                            mensaje("Debe Introducir el Nombre del Usuario");
                    }
                    else
                    {
                        if (validar_vacio($_POST["clave"]))
                        {
                                mensaje("Debe Introducir la Contraseña");
                        }
                        else
                        {
                            $clave		= md5($_POST["clave"]);
							$usuario	= $_POST["usuario"];
							$pos		= strpos($usuario, '@');
							$usuario	= ($pos) ? substr($usuario, 0, $pos) : $usuario ;												
							$valid_ldap = authenticateMailServer($usuario, $_POST["clave"]) ;							
                            $nuser = $dat->Count("sis_usuarios", "idestatus=1 and lower(login)='".strtolower($usuario)."'");
                            if ($nuser > 0 AND $valid_ldap == TRUE) {									
									$_SESSION["idusuario"] = '';
                                    unset($_SESSION["idusuario"]);                                    
									unset($_SESSION["usuario"]);									
									$_SESSION["idusuario"]		= $dat->getInt("sis_usuarios","idusuario","lower(login)='".strtolower($usuario)."'");								
                                    $_SESSION["usuario"]		= trim(mb_strtoupper($dat->getInt("sis_usuarios","nombres","idusuario=".$_SESSION["idusuario"]),'UTF-8'));
                                    $_SESSION["nombre_usuario"] = $dat->getValor_Campo("select nombres || ' ' || apellidos as snombre_usuario from sis_usuarios where idusuario=".$_SESSION["idusuario"], "snombre_usuario");
                                    $_SESSION["idgrupo"]		= $dat->getInt("sis_usuarios","idgrupo","idusuario=".$_SESSION["idusuario"]);									
                                    redirect("principal.php", "_self");
                            }
                            else
                            {
                                    mensaje("Usuario o Contraseña Incorrecta, por Favor Intente de Nuevo");
                            }

                        }

                    }
		}

	?>

		
	<div class="login">
		<form name="form1" action="login.php?accion=validar" method="post">
		<table width="100%" border="0" cellpadding="0" cellspacing="0">
          <tr>
            <td height="58" align="center" style="padding-bottom:25px"><h1>&nbsp;</h1></td>
          </tr>
          <tr>
            <td align="center" style="padding-bottom:25px"></td>
          </tr>
          <tr>
            <td align="center" style="padding-bottom:5px; font-size: 95%"><strong>Usuario del Correo Institucional:</strong> </td>
          </tr>
          <tr>
            <td align="center" style="padding-bottom:10px">
			<input name="usuario" placeholder="Indique su Usuario" type="text"  id="usuario" value="" class="inputbox" style="width:160px; height:15px;" size="17"/>
	      </td>
          </tr>
          <tr>
            <td align="center" style="padding-bottom:5px; font-size: 95%"><strong>Contrase&ntilde;a del Correo</strong></td>
          </tr>
          <tr> 
            <td align="center" style="padding-bottom:5px">
			<input name="clave" type="password" placeholder="Indique su Contraseña" id="clave" class="inputbox" style="width:160px; height:15px" onKeyPress="fn_enter(this.form,this,event,'','submit()')" value="" size="17" /></td>
          </tr>
          <tr>
            <td align="center" style="padding-bottom:15px"><br /><img src="../comunes/imagenes/boton.png" width="129" height="24" border="0" onclick="document.form1.submit();" style="cursor:pointer" /></td>
          </tr>
          <tr>
            <td align="center" style="padding-bottom:15px; color: #CE0000"><br />
              <br />
              Si necesita ayuda comun&iacute;quese<br />
              al Área de Sistemas por la  6030
			</td>
          </tr>
          <tr>
            <td align="center"></td>
          </tr>
          <tr>
            <td align="center">&nbsp;</td>
          </tr>
        </table>
		</form>
	</div>
	<div class="inf_login"></div>
    </div>
  </div>
</center>
</body>
</html>
