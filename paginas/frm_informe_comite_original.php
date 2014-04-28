<?

        require_once ('../comunes/xajax/xajax_core/xajax.inc.php');
        require_once("../librerias/db_postgresql.inc.php");
        require_once('../librerias/funciones_ajax.php');
        require_once('../cdatos/ccasos.php');
        ob_end_clean();

        $xajax= new xajax();
        $xajax->setFlag('debug',false);
        $xajax->configure('javascript URI', '../xajax/');

        $xajax->processRequest();
        $xajax->printJavascript('../comunes/xajax/');

        $ccaso=new ccasos();

        if ($_REQUEST["accion"]=="guardar")
        {
            
            $ccaso->set_idcaso($_REQUEST["idcaso"]);
            $ccaso->set_idtipo_proyecto($_REQUEST["tipo_proyecto"]);
            $ccaso->set_sanalisis($_REQUEST["analisis"]);
            $ccaso->set_ssugerencia($_REQUEST["sugerencias"]);
            $ccaso->set_sanexos($_REQUEST["anexos"]);
            $ccaso->set_idusuario_informe_comite($_SESSION["idusuario"]);
            
            if ($_REQUEST["idinforme"]>0)
            {
                $ccaso->set_idinforme_comite($_REQUEST["idinforme"]);
                $idinforme_pro=$ccaso->actualizar_informe_comite();

                $msg_info="Se ha Actualizado Satisfactoriamente el Informe del Comité";
                $msg_error="Han Ocurrido Errores al Intentar Actualizar el Informe del Comité";
            }
            else
            {
                $idinforme_pro=$ccaso->insertar_informe_comite();
                
                $msg_info="Se ha Creado Satisfactoriamente el Informe del Comité";
                $msg_error="Han Ocurrido Errores al Intentar Crear el Informe del Comité";
            }

            if (($_SESSION["idgrupo"]==PRESIDENTE || $_SESSION["idgrupo"]==COORDINADOR_GENERAL) && ($_REQUEST["idestatus_caso"]==PRE_APROBADO))
            {
                
                if ($_REQUEST["estatus_final"]>0)
                {                    
                   $ccaso->set_idcaso($_REQUEST["idcaso"]);
                   $ccaso->set_idestatus($_REQUEST["estatus_final"]);
                   $ccaso->set_idproveedor($_REQUEST["proveedor"]);
                   $ccaso->set_monto_aprobado($_REQUEST["monto_aprobado"]);
                   $ccaso->asignar_Estatus_Final();
                }
            }

            if ($idinforme_pro>0)
            {
                mensaje($msg_info);
                open_pag("lst_casos_comite.php", "contenido");
            }
            else
            {
                mensaje($msg_error);
            }

        }
        else if ($_REQUEST["accion"]=="enviar")
        {
    
            $ccaso->set_idcaso($_REQUEST["idcaso"]);
            $est_informe=$ccaso->enviar_Informe_Comite();

            if ($est_informe>0)
            {
                mensaje("Se ha Enviado Satisfactoriamente el Informe del Comité al Gerente");
                open_pag("lst_casos_comite.php", "contenido");
            }
            else
            {
                mensaje("Han Ocurrido Errores al Intentar Enviar el Informe del Comité al Gerente");
            }

        }

        $data_caso=new Recordset();
        $data_caso=$ccaso->getDataCaso($_REQUEST["idcaso"]);

        if ($data_caso)
        {
            $_REQUEST["solicitante"]=$data_caso->rowset["razon_social_solic"];
            $_REQUEST["beneficiario"]=$data_caso->rowset["razon_social_benef"];
            $_REQUEST["descripcion_caso"]=$data_caso->rowset["descripcion_caso"];
            $_REQUEST["idestatus_caso"]=$data_caso->rowset["idestatus"];
            $_REQUEST["idinforme"]=$ccaso->getInt("informe_comite", "idinforme", "idcaso=".$_REQUEST["idcaso"]);
            $_REQUEST["ninforme_social"]=$ccaso->Count("informe_social", "idsolicitante=".$data_caso->rowset["idsolicitante"]);

            if ($_REQUEST["idinforme"]>0)
            {
                $data_informe=new Recordset();
                $data_informe=$ccaso->getData_Informe_Comite($_REQUEST["idcaso"]);

                if ($data_informe)
                {
                    $_REQUEST["tipo_proyecto"]=$data_informe->rowset["idtipo_proyecto"];
                    $_REQUEST["analisis"]=$data_informe->rowset["analisis"];
                    $_REQUEST["sugerencias"]=$data_informe->rowset["sugerencia"];
                    $_REQUEST["anexos"]=$data_informe->rowset["anexos"];
                    $_REQUEST["sestatus_final"]=$data_informe->rowset["sestatus_final"];
                    $_REQUEST["sproveedor"]=$data_informe->rowset["sproveedor"];
                    $_REQUEST["monto_aprobado"]=moneda($data_informe->rowset["monto_aprobado"]);

                }
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
        <script src="../comunes/js/jquery.js" type="text/javascript"></script>
        <script src="../comunes/js/jquery.maskedinput.js" type="text/javascript"></script>
        <script type="text/javascript" src="../comunes/js/prototype.js"></script>
        <script type="text/javascript" src="../comunes/js/effects.js"></script>
        <script type="text/javascript" src="../comunes/js/scriptaculous.js"></script>

        <style>
            body {padding:0px;margin:0px;text-align:left;font:11px verdana, arial, helvetica, serif; background-color:#FFFFFF;}
        </style>
        <script language="javascript">          

            function ValidarObjetos(objX,tipoX)
            {

                var obj = document.getElementById(objX);
                var filter=/^[A-Za-z][A-Za-z0-9_.]*@[A-Za-z0-9_]+\.[A-Za-z0-9_.]+[A-za-z]$/;
                var filter2=/^[A-Z]*-[0-9]/;
                var filter3=/^([0-9\s\+\-])+$/;
                var filter4=/^([0-9])+$/;

                switch (tipoX) {
                        case 'combo':
                                obj.style.border = "1px solid #7f9db9";
                        break;

                        case 'email':
                            if (obj.value!='')
                            {
                                if (filter.test(obj.value))
                                {
                                    obj.style.border = "1px solid #7f9db9";
                                    return true;
                                }else
                                {
                                    alert("Ingrese una dirección de correo válida");
                                    obj.style.border = "1px solid #FF0000";
                                    return false;
                                }
                            }
                            else
                            {
                                 obj.style.border = "1px solid #7f9db9";
                                 return true;
                            }

                            break;

                        case 'cedrif':

                                if (filter4.test(obj.value))
                                {
                                    obj.style.border = "1px solid #7f9db9";
                                    return true;
                                }else
                                {
                                    alert("Ingrese una cédula o RIF válido");
                                    obj.style.border = "1px solid #FF0000";
                                    return false;
                                }

                                break;

                        case 'telefono':

                            if (filter3.test(obj.value))
                            {
                                    obj.style.border = "1px solid #7f9db9";
                                    return true;
                            }else{
                                    alert("Ingrese un número de teléfono válido");
                                    obj.style.border = "1px solid #FF0000";
                                    return false;
                            }
                            break;


                        case 'int4':
                                if (isNaN(parseInt(obj.value))){
                                        alert('Ingrese solo números enteros');
                                        obj.style.border = "1px solid #FF0000";return;
                                }else{
                                        obj.style.border = "1px solid #7f9db9";
                                }
                        break;

                        case 'date':
                                if (!isDate(obj.value)){
                                        obj.style.border = "1px solid #FF0000";return;
                                }else{
                                        obj.style.border = "1px solid #7f9db9";return;
                                }
                        break;

                        case 'time':
                            break;

                        case 'numerico':
                                if (isNaN(parseFloat(obj.value))){
                                        alert('Ingrese solo números');
                                        obj.style.border = "1px solid #FF0000";return;
                                }else{
                                        obj.style.border = "1px solid #7f9db9";return;
                                }
                        break;

                        case 'bool':
                                if ((obj.value!='Si') && (obj.value!='No')){
                                        alert('Ingrese solo Si o No');
                                        obj.style.border = "1px solid #FF0000";return;
                                }else{
                                        obj.style.border = "1px solid #7f9db9";return;
                                }
                        break;

                        default:
                        break;
                }
            }
           

            function ocultar(id, msj)
            {
                  var log = $(id);
                log.innerHTML= msj;
                log.style.backgroundColor= '#fff36f';
                log.style.padding= '5px';
                new Effect.Fade(id, {from: 1, to: 0, duration: 2.0});
                new Effect.SlideUp(id, {queue: 'parallel', duration: 2.0});
            }

            function guardar()
            {
                if (!validaSelect(document.frminforme.tipo_proyecto,'Tipo de Proyecto'))return false;
                if (!campoRequerido(document.frminforme.analisis,"Análisis")) return false;
                if (!campoRequerido(document.frminforme.sugerencias,"Sugerencias")) return false;
                
                window.document.getElementById('accion').value='guardar';
		document.frminforme.submit();

            }

            function enviar(idinforme, nsocial)
            {

                var resp
                resp=confirm('¿ Esta Seguro que Desea Enviar el Informe al Gerente ?');

                if ((resp)&& (idinforme>0))
                {
                    if (nsocial<=0)
                    {
                        alert('No es Posible Enviar el Informe al Gerente Debido a que No Existe un Informe Social Asociado al Caso');
                    }
                    else
                    {
                        if (!campoRequerido(document.frminforme.analisis,"Análisis")) return false;
                        if (!campoRequerido(document.frminforme.sugerencias,"Sugerencias")) return false;

                        window.document.getElementById('accion').value='enviar';
                        document.frminforme.submit();
                    }
                    
                }
                else
                {
                    alert('No es Posible Enviar el Informe al Gerente Debido a que No Existe un Informe de Comite Asociado al Caso');
                }

                
            }

            function cerrar()
            {
                window.open('lst_casos_comite.php','contenido')
            }

            function imprimir(idcaso)
            {
                window.open('../reportes/rpt_comite.php?idcaso='+idcaso,'_blank')
            }

        </script>
    </head>

    <?php
        $xajax->printJavascript('../comunes/xajax/')
    ?>

    <link href="../comunes/css/general.css" rel="stylesheet" type="text/css" />

    <body>
        <script src="../comunes/js/wz_tooltip/wz_tooltip.js" type="text/javascript"></script>
        <center>    

            <form name="frminforme" id="frminforme" method="post" action="frm_informe_comite.php">

            <input type="hidden" id="idcaso" name="idcaso" value="<?= $_REQUEST['idcaso'] ?>">
            <input type="hidden" id="idinforme" name="idinforme" value="<?= $_REQUEST['idinforme'] ?>">
            <input type="hidden" id="accion" name="accion" value="<?= $_REQUEST['accion'] ?>">
            <input type="hidden" id="idestatus_caso" name="idestatus_caso" value="<?= $_REQUEST['idestatus_caso'] ?>">
            <input type="hidden" id="ninforme_social" name="ninforme_social" value="<?= $_REQUEST['ninforme_social'] ?>">

            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                        <td width="65%" class="menu_izq_titulo"><img src="../comunes/imagenes/logo_form.gif" />Informe del Comit&eacute;</td>
                        <td width="20%" align="center" class="menu_izq_titulo">

                        <?  if (($_REQUEST["idinforme"]>0) && ($_REQUEST["idestatus_caso"]==EN_PROCESO || $_REQUEST["idestatus_caso"]==ESPERA_PRESUPUESTO || $_REQUEST["idestatus_caso"]==ESPERA_DOCUMENTACION))  {  ?>
                            <img src="../comunes/imagenes/asig_analista.gif" onmouseover="Tip('Enviar a Gerente')" onmouseout="UnTip()" border="0" onclick="javascript:enviar('<?=$_REQUEST["idinforme"]?>', '<?=$_REQUEST["ninforme_social"]?>')"/>
                        <? }  ?>

                        <?   if (($_REQUEST["accion"]!="consultar") && ($_REQUEST["idestatus_caso"]!=CERRADO)) {  ?>
                    
                        <img src="../comunes/imagenes/16_save.gif" onmouseover="Tip('Guardar')" onmouseout="UnTip()" border="0" onclick="javascript:guardar('<?=$_REQUEST["accion"]?>')"/>
                        
                        <?      }

                            if ($_REQUEST["idinforme"]>0)
                            {
                        ?>

                        <img src="../comunes/imagenes/printer.png" onmouseover="Tip('Imprimir Informe')" onmouseout="UnTip()" border="0" onclick="javascript:imprimir('<?=$_REQUEST["idcaso"]?>')"/>

                        <?  }   ?>

                        <img src="../comunes/imagenes/door_in.png" onmouseover="Tip('Cerrar')" onmouseout="UnTip()" border="0" onclick="javascript:cerrar('<?=$_REQUEST["idcaso"]?>')"/>

                        

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
                                        <strong>Datos Generales del Caso</strong>
                                    </div>
                                </td>
                            </tr>

                             <tr>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                            </tr>

                             <tr>
                                <td>&nbsp;</td>

                                <td>
                                    <strong>Solicitante:</strong>
                                </td>
                                <td colspan="3">
                                    <input name="solicitante" type="text" class="inputbox" id="solicitante" readonly style="width:464px;" value="<?= $_REQUEST['solicitante'] ?>">
                                </td>
                            </tr>

                             <tr>
                                <td>&nbsp;</td>

                                <td>
                                    <strong>Beneficiario:</strong>
                                </td>
                                <td colspan="3">
                                    <input name="beneficiario" type="text" class="inputbox" id="beneficiario" readonly style="width:464px;" value="<?= $_REQUEST['beneficiario'] ?>">
                                </td>
                            </tr>

                             <tr>
                                <td>&nbsp;</td>
                                <td>
                                    <strong>
                                        Planteamiento:
                                    </strong>
                                </td>


                                <td colspan="3">
                                    <textarea name="descripcion_caso" id="descripcion_caso" rows="5" class="inputbox" onkeypress="return validar_texto(this.form,this,event,'')"  style="width:466px; height:95px; margin-bottom:10px;" readonly ><?if(isset($_REQUEST["descripcion_caso"])){echo $_REQUEST["descripcion_caso"];}?></textarea>
                                </td>

                                </tr>

                                 <tr>
                                <td>&nbsp;</td>
                                <td><strong>
                                        Tipo de Proyecto:
                                    </strong></td>
                                <td><select name="tipo_proyecto" id="tipo_proyecto" style="width:160px;" class="inputbox">
                                    <option value>Seleccione...</option>
                                    <?php
                                    echo ($dat->Cargarlista("select idmaestro, descripcion from vtipo_proyectos where estatus=1 order by descripcion", $_REQUEST["tipo_proyecto"]));
                                    ?>
                                    </select></td>
                                </tr>

                                <tr>
                                <td>&nbsp;</td>
                                <td>
                                    <strong>
                                        An&aacute;lisis Realizado:
                                    </strong>
                                </td>


                                <td colspan="3">
                                   <textarea name="analisis" id="analisis" rows="5" class="inputbox" onkeypress="return validar_texto(this.form,this,event,'')"  style="width:466px; height:95px; margin-bottom:10px;" <?if($_REQUEST["accion"]=="consultar"){echo "readonly";}?>><?if(isset($_REQUEST["analisis"])){echo $_REQUEST["analisis"];}?></textarea>
                                </td>

                                </tr>

                                <tr>
                                <td>&nbsp;</td>
                                <td>
                                    <strong>
                                        Sugerencias y Conclusiones:
                                    </strong>
                                </td>


                                <td colspan="3">
                                   <textarea name="sugerencias" id="sugerencias" rows="5" class="inputbox" onkeypress="return validar_texto(this.form,this,event,'')"  style="width:466px; height:95px; margin-bottom:10px;" <?if($_REQUEST["accion"]=="consultar"){echo"readonly";}?>><?if(isset($_REQUEST["sugerencias"])){echo $_REQUEST["sugerencias"];}?></textarea>
                                </td>

                                </tr>

                                <tr>
                                <td>&nbsp;</td>
                                <td>
                                    <strong>
                                        Anexos Recibidos:
                                    </strong>
                                </td>


                                <td colspan="3">
                                   <textarea name="anexos" id="anexos" rows="5" class="inputbox" onkeypress="return validar_texto(this.form,this,event,'')"  style="width:466px; height:95px; margin-bottom:10px;" <?if($_REQUEST["accion"]=="consultar"){echo"readonly";}?>><?if(isset($_REQUEST["anexos"])){echo $_REQUEST["anexos"];}?></textarea>
                                </td>

                                </tr>

                                <?
                                    if (($_SESSION["idgrupo"]==PRESIDENTE || $_SESSION["idgrupo"]==COORDINADOR_GENERAL) && ($_REQUEST["idestatus_caso"]==PRE_APROBADO))
                                    {

                                 ?>


                                        <tr>
                                        <td colspan="6" style="border:#CCCCCC solid 1px;" bgcolor="#F8F8F8" >
                                        <div align="center" style="background-image: url('../comunes/imagenes/barra.png');">
                                            <strong>ASIGNACI&Oacute;N DEL ESTATUS FINAL</strong>
                                        </div>
                                        </td>
                                        </tr>

                                        <tr>
                                        <td>&nbsp;</td>
                                        <td>&nbsp;</td>
                                        <td>&nbsp;</td>
                                        </tr>
                                         <tr>
                                        <td>&nbsp;</td>
                                        <td>
                                        <strong>
                                        Estatus:
                                        </strong>
                                        </td>
                                        <td>
                                        <label>
                                        <select name="estatus_final" id="estatus_final" style="width:160px;" class="inputbox" >
                                        <option value>Seleccione...</option>
                                        <?php
                                        echo ($dat->Cargarlista("select idmaestro, descripcion from vestatus_casos where idmaestro in (77, 78, 79) order by descripcion", $_REQUEST["estatus_final"]));
                                        ?>
                                        </select>
                                        </label>
                                        </td>
                                        <td>
                                        <strong>Monto Aprobado:</strong>
                                        </td>
                                        <td>
                                        <input name="monto_aprobado" type="text" class="inputbox" maxlength="18" id="monto_aprobado" onkeypress="return validar_monto2(this.form,this,event,'')" value="<?= $_REQUEST['monto_aprobado'] ?>"></input>
                                        </td>
                                        </tr>

                                 <tr>
                                        <td>&nbsp;</td>
                                        <td>
                                        <strong>Proveedor:</strong>
                                        </td>
                                        <td>
                                        <label>
                                        <select name="proveedor" id="proveedor" style="width:160px;" class="inputbox" >
                                        <option value="0">Seleccione...</option>
                                        <?php
                                        echo ($dat->Cargarlista("select idmaestro, descripcion from vproveedores order by descripcion", $_REQUEST["proveedor"]));
                                        ?>
                                        </select>
                                        </label>
                                        </td>
                                        <td>&nbsp;
                                        </td>
                                        <td>&nbsp;</td>
                                        </tr>

                               <?
                                    }


                                    if ($_REQUEST["idestatus_caso"]==CERRADO)
                                    {
                                ?>
                                        <tr>
                                        <td colspan="6" style="border:#CCCCCC solid 1px;" bgcolor="#F8F8F8" >
                                        <div align="center" style="background-image: url('../comunes/imagenes/barra.png');">
                                        <strong>ESTATUS FINAL</strong>
                                        </div>
                                        </td>
                                        </tr>

                                        <tr>
                                        <td>&nbsp;</td>
                                        <td>&nbsp;</td>
                                        <td>&nbsp;</td>
                                        </tr>
                                         <tr>
                                        <td>&nbsp;</td>
                                        <td>
                                        <strong>
                                        Estatus:
                                        </strong>
                                        </td>
                                        <td>
                                        <strong><? echo $_REQUEST["sestatus_final"]; ?> </strong>
                                        </td>
                                        <td>
                                        <strong>Monto Aprobado:</strong>
                                        </td>
                                        <td><strong><? echo to_moneda($_REQUEST["monto_aprobado"]); ?> </strong>
                                        </td>
                                        </tr>

                                        <tr>
                                        <td>&nbsp;</td>
                                        <td>
                                        <strong>Proveedor:</strong>
                                        </td>
                                        <td>
                                        <strong><? echo $_REQUEST["sproveedor"]; ?></strong>
                                        </td>
                                        <td>&nbsp;
                                        </td>
                                        <td>&nbsp;</td>
                                        </tr>
                                <?
                                    }
                                ?>

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