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
            window.document.getElementById('idusuario_selec').value=window.document.getElementById('usuario').value;
            window.document.getElementById('accion').value='guardar';
            document.form1.submit();
	}

        function eliminar(idusuario)
	{            
            window.document.getElementById('idusuario_selec').value=idusuario;
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
          <td width="75%" class="menu_izq_titulo"><img src="../comunes/imagenes/manager_user.gif" />Miembros del Comit&eacute; </td>
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

        $dat->Conectar();
        $rsusuarios=new Recordset("select idusuario, snombre_usuario, firma from vusuarios where idestatus='1' order by idusuario", $dat->conn);
        $rs_registros=new Recordset("select descripcion from maestro where idmaestro=139", $dat->conn);
        
        if ($rs_registros->Mostrar())
        {
            $usuarios_comite=$rs_registros->rowset["descripcion"];    
            $data_registros=  explode(",", $rs_registros->rowset["descripcion"]);
        }
	
	if (isset($_REQUEST["accion"])) 
	{
		if ($_REQUEST["accion"]=="guardar")
		{
			
					if ($data_registros)
					{
						$nelementos=count($data_registros);

						if($nelementos>3)
						{
							$msg_error="El Máximo de Miembros del Comite es tres (03) Usuarios";
							$error_respuesta=true;
						}
					}
					
			if (!$_REQUEST["usuario"]>0 && $error_respuesta==false)
			{
				$msg_error="Debe Seleccionar el Usuario";
				$error_respuesta=true;
			}		

			if ($error_respuesta==false)
			{                   
						$usuarios_comite.=$_REQUEST["idusuario_selec"].",";
						$dat->Ejecutarsql("update maestro set descripcion='".$usuarios_comite."' where idmaestro=139");
						mensaje("El Usuario del Comite ha sido Registrado con Exito");
			}//error_respuesta
					else
					{
						$_REQUEST["accion"]="";
						mensaje($msg_error);
					}

		}
			else if ($_REQUEST["accion"]=="eliminar")
		{
				
				$usuarios_comite="";

				foreach ($data_registros as $value)
				{
					if ($value!=$_REQUEST["idusuario_selec"])
					{
						$usuarios_comite.=$value.", ";
					}
				}
				
				$usuarios_comite=ltrim(rtrim($usuarios_comite));
				$nfinal=strlen($usuarios_comite)-1;
				if ($usuarios_comite<>"")   $usuarios_comite=substr($usuarios_comite, 0, $nfinal);
				$dat->Ejecutarsql("update maestro set descripcion='".$usuarios_comite."' where idmaestro=139");
				mensaje("El Usuario del Comite ha sido Eliminado con Exito");
				
		}
	}
?>


 <form name="form1" action="frm_miembros_comite.php" method="post">

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
            <input type="hidden" name="idusuario_selec" id="idusuario_selec" value="<? if(isset($_REQUEST["idusuario_selec"])){ echo $_REQUEST["idusuario_selec"]; } ?>" />

            <table width="550px;" cellpadding="0" cellspacing="0" border="0">
            <tr>
            <td width="100" height="30" class="celda_etiqueta">Usuario:</td>
            <td width="260"><select name="usuario"  id="usuario" class="inputbox_lectura"  style="width:160px;"><option value>Seleccione...</option>
            <?php
            echo ($dat->Cargarlista("select idusuario, snombre_usuario from vusuarios where idestatus='1'", $_REQUEST["usuario"]));
            ?>
            </select>
            <a href="javascript:guardar()"><img src="../comunes/imagenes/edit_add.png" width="16" height="16"  border="0" /></a>
            </td>
            <td width="15px;">&nbsp;</td>
            </tr>
            <tr>
                <td colspan="3">Nota: el Comité debe Ser integrado por tres (03) Usuarios del Sistema</td>
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
<td width="45%" align="center" height="30"><strong>Usuario</strong></td>
<td width="45%" align="center" height="30"><strong>Firma</strong></td>
<td width="10%" align="center"><strong>Acci&oacute;n</strong></td>
</tr>
<?

    $dat->Conectar();
    $rs_tabla=new Recordset("select descripcion from maestro where idmaestro=139", $dat->conn);
    

    $swfondo=true;
    $textout="";

    if ($rs_tabla->Mostrar())
    {
        
        $data_usuario=  explode(",", $rs_tabla->rowset["descripcion"]);
        
        if ($data_usuario)
        {

            foreach ($data_usuario as $valor)
            {
                
                $rsusuarios->Primero();
                
                while ($rsusuarios->Mostrar())
                {
                    
                    if ($valor==$rsusuarios->rowset["idusuario"])
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

                        $textout.="<td align=\"center\">".$rsusuarios->rowset["snombre_usuario"]."</td><td align=\"center\">".$rsusuarios->rowset["firma"]."</td><td align=\"center\" class='elemento'><a href=\"javascript:eliminar('".$rsusuarios->rowset["idusuario"]."')\"><img src='../comunes/imagenes/delete.png' width=\"16\" height=\"16\" title='Eliminar Usuario' border='0' /></a></td>";

                    }

                    $rsusuarios->Siguiente();

                }//while

            }//foreach
                        
        }//if data
  
    }//if

    echo $textout;


?>

</table>

</form>






</body>
</html>
