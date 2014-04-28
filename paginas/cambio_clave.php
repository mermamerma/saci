<?

       require_once("../librerias/db_postgresql.inc.php");
       require_once('../cdatos/cusuarios.php');
       $cusuario=new cusuarios();

       require_once("datos_usuario.php");

        if ((@$_REQUEST["accion"]=="guardar") && (!validar_vacio($_SESSION["idusuario"])))
        {

            if ($_POST["clave"]!=$_POST["confirmar"])
            {
                $_POST["clave"]='';
                $_POST["confirmar"]='';
                javascript("document.getElementById('clave').focus();");
            }
            else
            {
                $clave_md5=md5($_POST["clave"]);
                $cusuario->Ejecutarsql("update sis_usuarios set clave='".$clave_md5."' where idusuario=".$cusuario->get_idusuario());
                mensaje("La Contraseña se Ha Actualizado con Éxito");
                redirect("blank.php", "contenido");
            }
        }



?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta http-equiv="pragma" content="no-cache">
        <link rel="shortcut icon" href="../comunes/imagenes/favicon.ico" type="image/x-icon" >
        <script src="../comunes/js/funciones.js" type="text/javascript"></script>   
         <link href="../comunes/css/general.css" rel="stylesheet" type="text/css" />

        <style>
            body {padding:0px;margin:0px;text-align:left;font:11px verdana, arial, helvetica, serif; background-color:#FFFFFF;}
        </style>
        <script language="javascript">

            function guardar()
            {

                window.document.getElementById('accion').value='guardar';
		document.frmclave.submit();
                
            }

            function cerrar()
            {
                window.open("blank.php", "contenido");
            }

        </script>



    </head>

    <body>



            <script src="../comunes/js/wz_tooltip/wz_tooltip.js" type="text/javascript"></script>
            <center>
            <link href="../comunes/css/general.css" rel="stylesheet" type="text/css" />

            <form name="frmclave" id="frmusuario" method="post" action="cambio_clave.php">

                <input type="hidden" id="idusuario" name="idusuario" value="<?= $_REQUEST['idusuario'] ?>">
                <input type="hidden" id="accion" name="accion" value="<?= $_REQUEST['accion'] ?>">
                <input type="hidden" id="idestatus" name="idestatus" value="<?= $_REQUEST['idestatus'] ?>">

                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                        <td width="65%" class="menu_izq_titulo"><img src="../comunes/imagenes/manager_user.gif" />Usuarios</td>
                        <td width="10%" align="center" class="menu_izq_titulo">
                        <img src="../comunes/imagenes/16_save.gif" onmouseover="Tip('Guardar')" onmouseout="UnTip()" border="0" onclick="javascript:guardar()"/>
                        <img src="../comunes/imagenes/door_in.png" onmouseover="Tip('Cerrar')" onmouseout="UnTip()" border="0" onclick="javascript:cerrar()"/>
                        </td>
                    </tr>

                    <tr>
                        <td colspan="2">
                            <div id="capaMensajes"></div>
                        </td>
                    </tr>

                    <tr>
                        <td colspan="2">

                            <table width="100%" border="0"  class="tablaTitulo" >
                            <tr>
                                <td colspan="6" style="border:#CCCCCC solid 1px;" bgcolor="#F8F8F8" >
                                    <div align="center" style="background-image: url('../comunes/imagenes/barra.png');">
                                        <strong>Cambio de Contrase&ntilde;a</strong>
                                    </div>
                                </td>
                            </tr>

                            <tr>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                            </tr>

                                <tr>
                                <td width="1">&nbsp;</td>
                                <td width="95">
                                    <strong>Nueva Contrase&ntilde;a:</strong>
                                </td>
                                <td width="176">
                                    <label>
                                        <input type="password" name="clave"  id="clave" class="inputbox" maxlength="8" onkeypress="return validar_texto(this.form,this,event,'')" value=""></input>
                                    </label>
                                </td>
                                <td width="89">
                                    <strong>
                                        Confirmar Contrase&ntilde;a:
                                    </strong>
                                </td>
                                <td width="199">
                                    <input type="password" name="confirmar"  id="confirmar" class="inputbox"  maxlength="8" onkeypress="return validar_texto(this.form,this,event,'')" value=""></input>
                                </td>
                            </tr>
                           
                            <tr>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                            </tr>
                            <tr>
                                <td colspan="5"></td>
                            </tr>
                                <td colspan="6" style="border:#CCCCCC solid 1px;">
                                    <div align="center" style="background-image: url('../comunes/imagenes/barra.png')">
                                        <br>
                                    </div>
                                </td>
                            </tr>
                        </table>

                        </td>

                    </tr>
                </table>
             </form>
        </center>
    </body>
</html>