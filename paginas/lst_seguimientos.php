<?php
    include_once('aplicaciones.php');
    require_once("../librerias/db_postgresql.inc.php");
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
<link href="../comunes/css/general.css" rel="stylesheet" type="text/css" />
<link href="../comunes/css/enlaces.css" rel="stylesheet" type="text/css" />

<script language="javascript">

    function cerrar()
        {
            history.back(1);
        }
        
</script>

</head>

<body>

        <table width="100%" border="0" cellspacing="0" cellpadding="0">

        <tr>
            <td width="90%" class="menu_izq_titulo"><img src="../comunes/imagenes/ico_productCatalog.gif" />Seguimientos del Caso</td>
            <td width="10%" class="menu_izq_titulo" align="right"><img src="../comunes/imagenes/door_in.png" onmouseover="Tip('Cerrar')" onmouseout="UnTip()" border="0" onclick="javascript:cerrar()"/></td>
        </tr>

        </table>

        <table width="100%" border="0" style="margin-top:10px;">
	<tr class="encabezado_tablas">
	<td width="25%" align="center"><strong>Fecha y Hora</strong></td>
	<td width="75%" align="center"><strong>Acci&oacute;n</strong></td>
	</tr>

	<?            

            $swfondo=false;
            $textout="";

            $dat->Conectar();
            $rs_seg=new Recordset("select idseguimiento, descripcion, fecha_proceso  from seguimientos where idcaso=".$_REQUEST["idcaso"]." order by idseguimiento", $dat->conn);
            
            while ($rs_seg->Mostrar())
            {
                if ($swfondo)
                {
                    $textout.= "<tr class=\"fila\" style=\"font-size: 12px;\"  onload=\"this.style.background='#FFFFFF'\"  onMouseOver=\"this.style.background='#E1E1E1'; this.style.color='blue'\" onMouseOut=\"this.style.background='#eeeeee'; this.style.color='black'\" >";
                    $swfondo=false;
                }
                else
                {
                    $textout.= "<tr class=\"fila\" style=\"font-size: 12px;\" bgcolor='#FFFFFF' onload=\"this.style.background='#eeeeee'\"  onMouseOver=\"this.style.background='#E1E1E1'; this.style.color='blue'\" onMouseOut=\"this.style.background='#FFFFFF'; this.style.color='black'\">";
                    $swfondo=true;
                }

                $textout.= "<td> ".fecha_hora($rs_seg->rowset["fecha_proceso"])." </td>";
                $textout.= "<td align=\"center\"> ".trim($rs_seg->rowset["descripcion"]);

                $textout.="</td></tr>";
                $rs_seg->Siguiente();

            }//while

            echo $textout;
		
	?>
	</table>

</body>
</html>
