
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Untitled Document</title>

<script src="../js/funciones.js" type="text/javascript"></script>
<link href="../css/ventana.css" rel="stylesheet" type="text/css" />

<script language="javascript">

function guardar()
{
        window.document.getElementById('accion').value='ejecutar';
        document.frmejecutar.submit();
}

</script>

</head>

<body>

   
    
<form name="frmejecutar" action="ejecutar_script.php?accion=ejecutar" method="post">

<table width="100%" border="0">
<tr>
<td>
<div class="contenedor_botones">
    <table width="100%" border="0" cellspacing="0" cellpadding="0">

      <tr>
        <td width="75%" class="menu_izq_titulo"><img src="../imagenes/logo_form.gif" /> Ejecutar Script </td>
        <td width="20%" style="vertical-align:middle;" align="right">
        <td width="5%"></td>
      </tr>
    </table>
  </div>
</td>
</tr>
</table>


        <table style="width:550px; margin-top:20px;"  align="center" border="0" cellspacing="0" cellpadding="0">

        <tr>
        <td>

        <input type="hidden" name="accion" id="accion" value="<? if(isset($_REQUEST["accion"])){ echo $_REQUEST["accion"]; } ?>" />
    
       <table style="width:580px; margin-top:0px;" border="0" cellspacing="0" cellpadding="0">
            <tr>
            <td width="84" height="30" class="celda_etiqueta">Sentencia SQL:</td>
            <td colspan="4">
                 <textarea name="sentencia" id="sentencia" rows="5" onkeypress="return validar_texto(this.form,this,event,'')" style="width:700px; height:150px; margin-bottom:10px;" class="inputbox"  <?  if($_REQUEST["lectura"]=="1") { echo 'readonly=\"readonly\"'; } ?> ><? if(isset($_POST["sentencia"])){ echo $_POST["sentencia"]; } ?></textarea>

            </td>
            <td width="15">&nbsp;</td>
            </tr>




           <tr>
               <td colspan="3">
                  <a href="#" onclick="javascript:guardar()"><img src="../imagenes/16_save.gif"  border="0" alt="Guardar" title="Guardar"/></a>
               </td>
           </tr>
        </table>

</td>
</tr>
</table>




      <table style="width:550px; margin-top:20px;"  align="center" border="0" cellspacing="0" cellpadding="0">
          <?

            require_once("db_postgresql.inc.php");

            $error_respuesta=false;
            $msg_error='';
            $msg_info='';

            if ($_REQUEST["accion"]=="ejecutar")
            {

                if (!validar_vacio($_POST["sentencia"]))
                {
                    $table="vgerencias";
                    $_REQUEST["sentencia"] = 'SELECT a.attnum, a.attname, t.typname, a.attlen, a.atttypmod, a.attnotnull, a.atthasdef FROM pg_class as c, pg_attribute a, pg_type t WHERE a.attnum > 0 and a.attrelid = c.oid and c.relname = '."'$table'".' and a.atttypid = t.oid order by a.attnum'; 

                    echo $dat->Cargartabla($_REQUEST["sentencia"]);

                    /*
                      $ejecutado=$dat->Ejecutarsql($_POST["sentencia"]);


                    if (!validar_vacio($ejecutado))
                    {
                        $msg_info="Se ha Ejecutado el Script Satisfactoriamente";
                    }
                    else
                    {
                        $msg_error="Han Ocurrido Errores al Intentar Ejecutar el Script";
                        $error_respuesta=true;
                    }

                    */

                }
            }

             if ($error_respuesta==true)
            {
                    echo "<tr><td colspan=\"7\"><div class=\"mensajes\"><div class=\"mensajes_margen\">
                    <span class=\"mensajes_titulo\">Error: </span>
                    ".$msg_error."</div></div></td></tr>";
            }
            if ($msg_info<>'')
            {
                    echo "<tr><td colspan=\"7\"><div class=\"mensajes\"><div class=\"mensajes_margen\">
                    <span class=\"mensajes_titulo\">Error: </span>
                    ".$msg_info."</div></div></td></tr>";
            }

        ?>


      </table>
</form>

</body>
</html>

