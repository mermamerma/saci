<?

        require_once("../librerias/db_postgresql.inc.php");
        require_once('../cdatos/ccasos.php');
     
        $ccaso=new ccasos();       
        
        if(isset($_REQUEST["accion"]) && $_REQUEST["accion"]=='guardar_salir')
        {            
            $tmp_fecha_asig=to_fecha_bd($_REQUEST["inicio"]);
            $tmp_fecha_resolucion=to_fecha_bd($_REQUEST["fin"]);
            $ncomp=comparar_fechas($tmp_fecha_asig, $tmp_fecha_resolucion);

            if ($ncomp>0)
            {
                mensaje("La Fecha de Estimada de Resolución No Puede Ser Mayor que la Fecha de Asignación");
                $ult_registro="0";
            }
            else
            {
                $ccaso->set_idanalista_asignado($_REQUEST["analista"]);
                $ccaso->set_idcaso($_REQUEST["idcaso"]);
                $ccaso->set_fecha_asignacion($_REQUEST["inicio"]);
                $ccaso->set_fecha_resolucion($_REQUEST["fin"]);

                if ($_REQUEST["tipo_proceso"]=="asignar_analista")
                {
                    $nasig=$ccaso->AsignarAnalista();
                }else if ($_REQUEST["tipo_proceso"]=="reasignar_analista")
                {
                    $ccaso->set_reasignacion('1');
                    $nasig=$ccaso->AsignarAnalista();
                }                

                if ($nasig>0)
                {
                    mensaje("El Caso ha Sido Asignado con Éxito");
                    open_pag("lst_asignacion_analistas.php", "contenido");
                }
                else
                {
                    mensaje("Han Ocurrido Errores al Intentar Asignar el Caso");
                }
            }

        }
        else
        {

                if($_REQUEST["idcaso"]>0)
                {

                        $_REQUEST["idcaso"]=$_REQUEST["idcaso"];
                        $_REQUEST["tipo_proceso"]=$_REQUEST["tipo_proceso"];

                        $data_caso=new Recordset();
                        $data_caso=$ccaso->getDataCasoActual($_REQUEST["idcaso"]);

                        if ($data_caso)
                        {
                            $_REQUEST['razon_social_solic']=$data_caso->rowset["razon_social_solic"];
                            $_REQUEST['razon_social_benef']=$data_caso->rowset["razon_social_benef"];
                            $_REQUEST["sremitente"]=$data_caso->rowset["sremitente"];
                            $_REQUEST["descripcion_caso"]=$data_caso->rowset["descripcion_caso"];
                            $_REQUEST["fecha_registro"]=$data_caso->rowset["fecha_registro"];
							$_REQUEST['responsable']=$data_caso->rowset["responsable"];
                        }

                        if ($_REQUEST["tipo_proceso"]=="asignar_analista")
                        {
                            $_REQUEST["inicio"]=fecha(gettime());
                        }
                        else if ($_REQUEST["tipo_proceso"]=="reasignar_analista")
                        {
                            $data_analista=new Recordset();
                            $data_analista=$ccaso->getAnalistaAsignadoActual($_REQUEST["idcaso"]);

                            if ($data_analista)
                            {
                                $_REQUEST["idanalista_asignado"]=$data_analista->rowset["idanalista"];
                                $_REQUEST["sanalista_asignado"]=$data_analista->rowset["sanalista"];                                
                            }

                        }

                }

        }//consulta

  ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta http-equiv="pragma" content="no-cache">
        <link rel="shortcut icon" href="../comunes/imagenes/favicon.ico" type="image/x-icon" >

        <link href="../comunes/css/general.css" rel="stylesheet" type="text/css" />
        <script src="../comunes/js/funciones.js" type="text/javascript"></script>

        <style>
            body {padding:0px;margin:0px;text-align:left;font:11px verdana, arial, helvetica, serif; background-color:#FFFFFF;}
        </style>
        <script language="javascript">

            function guardar_salir()
            {

                if (!campoRequerido(document.frmasignacion.f_inicio,"Fecha de Asignación")) return false;
                if (!campoRequerido(document.frmasignacion.f_fin,"Fecha Estimada de Resolución")) return false;
                if (!validaSelect(document.frmasignacion.analista,'Analista'))return false;

                document.getElementById('accion').value="guardar_salir";
                document.frmasignacion.submit();
            }

            function bloquear_botones()
            {
                document.getElementById('btn_guardar').style.visibility='hidden';
                document.getElementById('btn_guardar_salir').style.visibility='hidden';
            }

            function inicio()
            {
                if(self.gfPop)
                {
                    gfPop.fPopCalendar(document.frmasignacion.f_inicio);
                }
            }

            function cambio_inicio()
            {

                if (inicio=='')
                {
                    alert('Fecha Inv&aacute;lida');
                    document.frmasignacion.f_inicio.value='';
                }
                else
                {
                    document.frmasignacion.inicio.value=document.frmasignacion.f_inicio.value;
                }
            }

            function fin()
            {
                if(self.gfPop)
                {
                    gfPop.fPopCalendar(document.frmasignacion.f_fin);
                }
            }

            function cambio_fin()
            {

                if (fin=='')
                {
                    alert('Fecha Inv&aacute;lida');
                    document.frmasignacion.f_fin.value='';
                }
                else
                {
                    document.frmasignacion.fin.value=document.frmasignacion.f_fin.value;
                }
                
            }

        </script>
    </head>

    <body>
        <script src="../comunes/js/wz_tooltip/wz_tooltip.js" type="text/javascript"></script>
        <center>       


            <form name="frmasignacion" id="frmasignacion" method="post" action="frm_asignacion_casos.php">

                <input type="hidden" name="idcaso" id="idcaso" value="<? if(isset($_REQUEST["idcaso"])){ echo $_REQUEST["idcaso"]; } ?>" />                
                <input type="hidden" name="accion" id="accion" value="<? if(isset($_REQUEST["accion"])){ echo $_REQUEST["accion"]; } ?>" />
                <input type="hidden" name="tipo_proceso" id="tipo_proceso" value="<? if(isset($_REQUEST["tipo_proceso"])){ echo $_REQUEST["tipo_proceso"]; } ?>" />
                <input type="hidden" name="inicio" value="<? if(isset($_REQUEST["inicio"])){echo $_REQUEST["inicio"]; }?>"></input>
                <input type="hidden" name="fin" value="<? if(isset($_REQUEST["fin"])){echo $_REQUEST["fin"];}?>"></input>

                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                        <td width="65%" class="menu_izq_titulo"><img src="../comunes/imagenes/ico_downloadWebServiceDesc.gif" />
                            <?
                                if ($_REQUEST["tipo_proceso"]=="asignar_analista")      echo "Asignaci&oacute;n del Caso";
                                else    echo "Reasignaci&oacute;n del Caso";
                            ?>

                        </td>
                        <td width="10%" align="center" class="menu_izq_titulo">
                        <? if (@$_GET["accion"]!='consultar'){ ?>
                        <a href="#" onclick="javascript:guardar_salir()"><img src="../comunes/imagenes/16_saveclose.gif"  border="0" alt="Guardar y Cerrar" title="Guardar y Cerrar"/></a>
                        <? } ?>
                        <a  href="lst_asignacion_analistas.php" onclick=""><img src="../comunes/imagenes/door_in.png"  border="0" alt="Cerrar" title="Cerrar"/></a>
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
                                        <strong>Datos del Solicitante  /  Beneficiario</strong>
                                    </div>
                                </td>
                            </tr>
                                <tr>
                                <td width="1">&nbsp;</td>
                                <td width="95">
                                    <strong>Solicitante:</strong>
                                </td>
                                <td width="176">
                                    <label>
                                        <input name="razon_social_solic" type="text" class="inputbox" id="razon_social_solic" readonly value="<?= $_REQUEST['razon_social_solic'] ?>"></input>
                                    </label>
                                </td>
                                <td width="89">
                                    <strong>Beneficiario:</strong>
                                </td>
                                <td width="199">
                                    <input name="razon_social_benef" type="text" class="inputbox" id="razon_social_benef" readonly value="<?= $_REQUEST['razon_social_benef'] ?>">
                                </td>
                            </tr>                                                                                  
                                <tr>
                                <td colspan="6" style="border:#CCCCCC solid 1px;" bgcolor="#F8F8F8" >
                                    <div align="center" style="background-image: url('../comunes/imagenes/barra.png');">
                                        <strong>Datos Generales del Caso</strong>
                                    </div>
                                </td>
                            </tr>

                            <tr>
                                <td>&nbsp;</td>
                                <td>
                                    <strong>
                                        Remitente:
                                    </strong>
                                </td>
                                <td>
                                    <input name="sremitente" type="text" class="inputbox" id="sremitente" readonly maxlength="80" value="<?= $_REQUEST['sremitente'] ?>">
                                </td>
                                <td>
                                    <strong>
                                        Responsable:
                                    </strong>
                                </td>
                                <td>
                                    <input name="responsable" type="text" class="inputbox" id="responsable" readonly maxlength="80" value="<?= $_REQUEST['responsable'] ?>">
                                </td>
                            </tr>
                                <tr>
                                <td>&nbsp;</td>
                                <td>
                                    <strong>
                                        Descripci&oacute;n del Caso:
                                    </strong>
                                </td>

                                <td colspan="3">
                                    <textarea name="descripcion_caso" id="descripcion_caso" rows="5" class="inputbox" onkeypress="return validar_texto(this.form,this,event,'')" readonly  style="width:466px; height:95px; margin-bottom:10px;"><?if(isset($_REQUEST["descripcion_caso"])){echo $_REQUEST["descripcion_caso"];}?></textarea>
                                </td>

                                </tr>

                                <tr>
                                <td colspan="6" style="border:#CCCCCC solid 1px;" bgcolor="#F8F8F8" >
                                    <div align="center" style="background-image: url('../comunes/imagenes/barra.png');">
                                        <strong>Datos de la Asignaci&oacute;n del Caso</strong>
                                    </div>
                                </td>
                            </tr>

                                <tr>
                                <td>&nbsp;</td>
                                <td><strong>Fecha Asignaci&oacute;n:</strong>
                                </td>
                                <td>
                                    <input class="inputbox_fecha" name="f_inicio"  id="f_inicio"  onchange="cambio_inicio();" value="<? if(isset($_REQUEST["fecha_inicio"])){echo $_REQUEST["fecha_inicio"];}?>" size="10"   readonly="true" />
                                    <a href="javascript:void(0)"  onclick="inicio();" hidefocus><img class="PopcalTrigger"  style="width:36px; height:19px;  margin-left:5px;" align="absbottom" src="../comunes/calendar/btn_dis_cal.gif"  border="0" alt="" /></a>
                                </td>
                                <td><strong>Fecha Estimada de Resoluci&oacute;n:</strong>
                                </td>
                                <td>
                                    <input class="inputbox_fecha" name="f_fin"  id="f_fin"  onchange="cambio_fin();" value="<? if(isset($_REQUEST["fecha_fin"])){ echo $_REQUEST["fecha_fin"];}?>" size="10"   readonly="true" />
                                    <a href="javascript:void(0)"  onclick="fin();" hidefocus><img class="PopcalTrigger"  style="width:36px; height:19px;  margin-left:5px;" align="absbottom" src="../comunes/calendar/btn_dis_cal.gif"  border="0" alt="" /></a>
                                    <!--  Calendario  -->
                                    <iframe width=174 height=189 name="gToday:normal:agenda.js" id="gToday:normal:agenda.js" src="../comunes/calendar/ipopeng.htm" scrolling="no" frameborder="0" style="visibility:visible; z-index:999; position:absolute; top:-500px; left:-500px;"></iframe>
                                    <!--  Calendario  -->
                                </td>
                                </tr>

                                <?
                                    if ($_REQUEST["tipo_proceso"]=="asignar_analista")
                                    {                                   
                                ?>
                                        <tr>
                                        <td>&nbsp;</td>
                                        <td><strong>Analista:</strong></td>
                                        <td>
                                        <select name="analista" id="analista" style="width:160px;" class="inputbox">
                                        <option value="0">Seleccione...</option>
                                        <?php
                                        echo ($dat->Cargarlista("select idusuario, snombre_usuario from vusuarios order by snombre_usuario", $_REQUEST["analista"]));
                                        ?>
                                        </select>
                                        </td>
                                        <td>&nbsp;</td>
                                        <td>&nbsp;</td>
                                        </tr>
                                <?
                                    }
                                    else
                                    {
                                ?>

                                        <tr>
                                        <td>&nbsp;</td>
                                        <td><strong>Analista Asignado:</strong>
                                        </td>
                                        <td><strong><? echo @$_REQUEST["sanalista_asignado"]; ?></strong></td>
                                        <td><strong>Analista:</strong></td>
                                        <td>
                                        <select name="analista" id="analista" style="width:160px;" class="inputbox">
                                        <option value="0">Seleccione...</option>
                                        <?php
                                        echo ($dat->Cargarlista("select idusuario, snombre_usuario from vusuarios where idusuario<>".$_REQUEST["idanalista_asignado"]." order by snombre_usuario", $_REQUEST["analista"]));
                                        ?>
                                        </select>
                                        </td>
                                        </tr>
                                <?
                                    }
                                ?>

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