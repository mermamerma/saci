<?
    require_once('aplicaciones.php');
    require_once("datos_usuario.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="pragma" content="no-cache">
<link rel="shortcut icon" href="../comunes/imagenes/sos_red.png" type="image/x-icon" >
<script src="../comunes/js/run2.js" type="text/javascript"></script>
<title>SACi - Sistema de Atención al Ciudadano</title>
<link href="../comunes/css/general.css" rel="stylesheet" type="text/css" />
</head>
<style>
a
{
    text-decoration:none;
    color:#000000;
}

a:hover
{
    cursor:pointer;
    font-weight:bold;
}
</style>
<script type="text/javascript">
var pepe;
function ini() {
  pepe = setTimeout('location="cerrar_sesion.php"',10000); // 
}
function parar() {
  clearTimeout(pepe);
  pepe = setTimeout('location="cerrar_sesion.php"',10000); // 
}
</script>
<!-- <body onload="ini()" onkeypress="parar()" onclick="parar()"> -->
<body>
<script type="text/javascript" src="../comunes/js/wz_tooltip/wz_tooltip.js"></script>

<center>
<div class="contenedor_general">
<?php
include('cabecero.php');
if (validar_vacio($cusuario->get_idusuario())) redirect("login.php","_self");
?>
<div class="identificacion">
    <table width="100%" border="0" cellspacing="0" cellpadding="5">
    <tr>
    <td>
    <strong>Hola, </strong>
    <? echo $_SESSION["nombre_usuario"] ?> |
    <a href="cerrar_sesion.php" title="Cerrar Sesi&oacute;n">
    <strong>SALIR </strong> 
	<img src="../comunes/imagenes/exit.png" width="20" height="20" border="0"  style="cursor:pointer; vertical-align: sub; " />
    </a>
    </td>
    <td align="right">
    <strong>Caracas,</strong>
    <?php echo $dia_actual." de ".nombremes($mes_actual)." de ".$anio_actual?>
    </td>
    </tr>
    </table>
</div>

<div id="menu_izq" class="menu_izq_contenedor">
<div id="capa1" style='visibility:visible;display:inline;'>
<!-- MODIFICACION-->

<?

    $swmostrar_creacion=false;
    $swmostrar_seg=false;
    $swmostrar_analista=false;

    $cusuario->set_objeto(CREACION_CASO);
    $cusuario->getPermisos();    

    if ($cusuario->get_insertar() =='1')        $swmostrar_creacion=true;
   
    $cusuario->set_objeto(SEGUIMIENTO_CASO);
    $cusuario->getPermisos();

    if ($cusuario->get_ejecutar()=='1')     $swmostrar_seg=true;
  
    $cusuario->set_objeto(ASIGNACION_ANALISTA);
    $cusuario->getPermisos();

    if ($cusuario->get_ejecutar()=='1')     $swmostrar_analista=true;
  

    if ($swmostrar_creacion==true || $swmostrar_seg==true || $swmostrar_analista==true)
    {
        echo "<div class=\"menu_izq_superior\">&nbsp;</div>
        <div class=\"menu_izq_celda\">
        <div class=\"menu_izq_titulo\">
		CASOS
		<img src=\"../comunes/imagenes/folder.png\" width=\"17\" height=\17\" border=\"0\"  style=\"vertical-align: bottom; \" />
		</div>
        <div class=\"menu_izq_texto\">";
        
        if ($swmostrar_creacion==true)      echo "<a href=\"frm_casos_nuevos.php\" target=\"contenido\">Registro de Casos</a><br />";
        if ($swmostrar_analista==true)      echo "<a href=\"lst_asignacion_analistas.php\" target=\"contenido\">Asignaci&oacute;n de Analistas</a><br />";
		if ($swmostrar_seg==true)           echo "<a href=\"lst_casos_actuales.php\" target=\"contenido\">Seguimiento de Casos</a><br />";
        

        echo "</div>
        </div>
        <div class=\"menu_izq_inferior\">&nbsp;</div>";
    }

    $cusuario->set_objeto(COMITE_CASO);
    $cusuario->getPermisos();

?>
<div class="menu_izq_superior">&nbsp;</div>
<div class="menu_izq_celda">
	<!-- <div class="menu_izq_titulo">CONSULTAS Y REPORTES </div> -->
	<div class="menu_izq_titulo">
		Histórico
		<img src="../comunes/imagenes/book_open.png" width="18" height="18" border="0"  style="vertical-align: bottom;" />
	</div>
	<div class="menu_izq_texto">
		<?
		echo "<a href=\"lst_consultas_actuales.php\" target=\"contenido\">Casos Nuevos</a><br />";
		#echo "<a href=\"lst_consultas.php\" target=\"contenido\">Consultas 2012</a><br />";		
		?>
	</div>
</div>
<div class="menu_izq_inferior">&nbsp;</div>
<?php 

    if ($cusuario->get_ejecutar() =='1')
    {
        echo "<div class=\"menu_izq_superior\">&nbsp;</div>
        <div class=\"menu_izq_celda\">
        <div class=\"menu_izq_titulo\">
			Trámites
			<img src=\"../comunes/imagenes/tramite.png\" width=\"17\" height=\17\" border=\"0\"  style=\"vertical-align: bottom; \" />
		</div>
        <div class=\"menu_izq_texto\">
        <!-- <a href=\"lst_casos_comite.php\" target=\"contenido\">Comit&eacute;s de Casos </a><br /> -->
		<a href=\"lst_casos_comite_nuevos.php\" target=\"contenido\">Puntos de Cuenta e Informe Social</a><br />
        </div>
        </div>
        <div class=\"menu_izq_inferior\">&nbsp;</div>";
    }
    
?>





<div class="menu_izq_superior">&nbsp;</div>
<div class="menu_izq_celda">
<div class="menu_izq_titulo">
	SOLICITANTES
	<img src="../comunes/imagenes/solicitantes.png" width="19" height="19" border="0"  style="vertical-align: bottom;" />
</div>
<div class="menu_izq_texto">
		<?    echo "<a href=\"lst_solicitantes.php\" target=\"contenido\">Solicitantes</a><br />"; ?>
</div>
</div>
<div class="menu_izq_inferior">&nbsp; </div>

<?

    $cusuario->set_objeto(TABLAS_BASICAS);
    $cusuario->getPermisos();

    if ($cusuario->get_ejecutar() =='1')
    {
        echo "<div class=\"menu_izq_superior\">&nbsp;</div>
        <div class=\"menu_izq_celda\">
        <div class=\"menu_izq_titulo\">
		CONFIGURACI&Oacute;N 
		<img src=\"../comunes/imagenes/cog.png\" width=\"18\" height=\18\" border=\"0\"  style=\"vertical-align: bottom; \" />
		</div>
		
        <div class=\"menu_izq_texto\">";
		echo "<a href=\"lst_usuarios.php\" target=\"contenido\">Usuarios</a><br />";
		echo "<a href=\"frm_funcionarios.php\" target=\"contenido\">Funcionarios</a><br />";        
        echo "<a href=\"frm_permisos.php\" target=\"contenido\">Permisolog&iacute;a</a><br />";
		echo "<a href=\"lst_tablas.php\" target=\"contenido\">Tablas B&aacute;sicas</a><br />";
        echo "<a href=\"lst_personalizacion.php\" target=\"contenido\">Personalizaci&oacute;n</a><br />";        
        echo "</div>
        </div>
        <div class=\"menu_izq_inferior\">&nbsp;</div>";
    }

?>


</div>


</div>
<div class="desarrollo_superior">&nbsp;</div>
<div class="desarrollo_contenedor">
<iframe  id="contenido" name="contenido" src=blank.php scrolling="auto" frameborder="0" width="669" height="398"></iframe>
</div>
<div class="desarrollo_inferior">&nbsp;</div>
</div>
</center>

<?
//echo "-->".$cusuario->get_clave();
/*
if ($cusuario->get_clave()=="e10adc3949ba59abbe56e057f20f883e")
{
        javascript("window.open('cambio_clave.php','contenido');");
}
*/
?>

</body>
</html>
