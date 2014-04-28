<?

require_once("../cdatos/ccasos.php");
require_once("../cdatos/csolicitantes.php");

//ob_end_clean();

function nuevo_remitente()
{
    $respuesta= new xajaxResponse();

    $html= "<div id='div_r' align=\"left\">
    <table border='1' class='tablaTitulo' width='100%'>
    <tr bgcolor='#f8f8f8' style=\"margin-left:-20px;\"  onmouseover=\"this.style.background='#f0f0f0';this.style.color='blue';\" onmouseout=\"this.style.background='#f8f8f8';this.style.color='black'\" >
    <td width='86'><label id='lstrnombreb' style='celda_etiqueta'>Nuevo Remitente:</label></td>
    <td width='400' align='left'><input name=\"txtinstitucion\" id=\"txtinstitucion\" type=\"text\" class=\"inputbox\"   style=\"width:160px;\" value=''>
    <a  href=\"javascript:guardar_remitente();\"><img src=\"../comunes/imagenes/16_save.gif\" onmouseover=\"Tip('Guardar Remitente')\" onmouseout=\"UnTip()\" style=\"margin-left:5px; margin-right:5px;\" width=\"16\" height=\"16\" border=\"0\" /></a>
    </td>   
    </tr></table></div>";

    $respuesta->assign("dvRemitente","innerHTML",$html);
    return $respuesta;

}//nuevo_remitente

function guardar_remitente($formulario)
{

    $ccaso=new ccasos();
    
    $respuesta= new xajaxResponse();   

    if ($formulario['txtinstitucion'])
    {
        $ccaso->set_sremitente($formulario['txtinstitucion']);
        $ult_remitente=$ccaso->insertarRemitente();
    }

    if ($ult_remitente>0)
    {
       $respuesta->script("ocultar('div_r', '¡El Remitente se ha Guardado exitosamente!')");
    }
    else
    {
       $respuesta->script("ocultar('div_r', '¡Han Ocurrido Errores al Intentar Guardar el Remitente!')");
    }    

    $respuesta->script("xajax_mostrar_remitentes(".$ult_remitente.")");
    return $respuesta;

}

function mostrar_remitentes($idremitente)
{

    $ccaso=new ccasos();

    $respuesta= new xajaxResponse();

    $html="<select name='remitente' id='remitente' style='width:160px;' class='inputbox'>
            <option value='0'>Seleccione</option>";

    $html.=$ccaso->Cargarlista("select idmaestro, descripcion from vremitentes where estatus=1 order by descripcion", $idremitente);
    
    $html.="</select>";

    $html.="<a  href=\"javascript:nuevo_remitente()\"><img src=\"../comunes/imagenes/ico_16_8.gif\" onmouseover=\"Tip('Nuevo Remitente')\" onmouseout=\"UnTip()\" style=\"margin-left:5px; margin-right:5px;\" width=\"16\" height=\"16\" border=\"0\" /></a>";
    
    $respuesta->assign("capaRemitente","innerHTML",$html);
    return $respuesta;

}

function guardar_caso($formulario)
{
    $html = '';
    $ccaso=new ccasos();
    $respuesta= new xajaxResponse();
    $bnuevo=false;
    
 
    if ($formulario["idcaso"]>0)
    {
        $ccaso->set_idcaso($formulario["idcaso"]);
        $idcaso=$ccaso->update_caso($formulario);
    }
    else
    {
        $bnuevo=true;
        $idcaso=$ccaso->insertar_caso($formulario);
    }

    if ($idcaso>0)
    {

        $ccaso->set_idcaso($idcaso);
        $ccaso->insertar_casos_categorias($formulario);

        if ($bnuevo==true)  $respuesta->script("alert('El Caso fue Registrado con Exito');");
        else    $respuesta->script("alert('El Caso fue Actualizado con Exito');");
        
    }
    else
    {
        if ($bnuevo==true)  $respuesta->script("alert('Han Ocurrido Errores al Intentar Registrar el Caso');");
        else    $respuesta->script("alert('Han Ocurrido Errores al Intentar Actualizar el Caso');");
    }

    $respuesta->assign("capaMensajes","innerHTML",$html);
    if ($idcaso>0)  $respuesta->script("window.open('lst_casos.php', 'contenido');");
    return $respuesta;
}

function mostrar_subcategorias($idtipocaso, $idcategoria, $idcaso)
{
    
    $respuesta= new xajaxResponse();
    $ccaso=new ccasos();
    $html="";
	$idtipocaso = ($idtipocaso == false OR $idtipocaso == '' ) ? -1 : $idtipocaso ;
	$idcategoria = ($idcategoria == false OR $idcategoria == ''  ) ? -1 : $idcategoria ;
	#var_dump($idtipocaso) ;exit;
    $ccaso->Conectar();
 
    if ($idcaso>0)  
		$rs_categ_selec=new Recordset("select idregistro, idsubcategoria, monto, cantidad from casos_categorias where idcaso=".$idcaso, $ccaso->conn);
    else 
		$rs_categ_selec="";

    $rs_subcateg=new Recordset("select idsubcategoria, ssubcategoria from vtipocasos_categorias where idtipocaso=".$idtipocaso." and idcategoria=".$idcategoria, $ccaso->conn);

    if ($rs_subcateg)
    {
         $html= "<div id='div_s' align=\"left\">
            <table border='1' class='tablaTitulo' width='465px'>
            <tr bgcolor='#f8f8f8' style=\"margin-left:-20px;\"  onmouseover=\"this.style.background='#f0f0f0';this.style.color='blue';\" onmouseout=\"this.style.background='#f8f8f8';this.style.color='black'\" >
            <td width='40' align='center' colspan='2'><b>SubCategor&iacute;a</b></td>
            <td width='30' align='center'><b>Cantidad Solicitada</b></td>
            <td width='30' align='center'><b>Monto Solicitado</b></td>
            </tr>";

            while($rs_subcateg->Mostrar())
            {
                
                
                $ncantidad="";
                $nmonto="";
                $chk="";

                if ($rs_categ_selec)
                {

                    $rs_categ_selec->Primero();
                    
                    while($rs_categ_selec->Mostrar())
                    {
                        if ($rs_subcateg->rowset["idsubcategoria"]==$rs_categ_selec->rowset["idsubcategoria"])
                        {
                            $chk="checked";
                            $ncantidad=$rs_categ_selec->rowset["cantidad"];
                            $nmonto=to_moneda($rs_categ_selec->rowset["monto"]);
                        }

                        $rs_categ_selec->Siguiente();

                    }
                }

                if ($chk!="")
                {
                    $html.= "<tr bgcolor='#f8f8f8' style=\"margin-left:-20px;\"  onmouseover=\"this.style.background='#f0f0f0';this.style.color='blue';\" onmouseout=\"this.style.background='#f8f8f8';this.style.color='black'\" >
                    <td width='20' align='center'><input type='checkbox' id='idsubcateg[]' name='idsubcateg[]' onchange=\"hab_texto(this, '".$rs_subcateg->rowset["idsubcategoria"]."')\" checked value='".$rs_subcateg->rowset["idsubcategoria"]."'\"></td>
                    <td width='120' align='left'><b>".$rs_subcateg->rowset["ssubcategoria"]."</b></td>
                    <td width='30' align='center'><input name=\"txtcantidad".$rs_subcateg->rowset["idsubcategoria"]."\" id=\"txtcantidad".$rs_subcateg->rowset["idsubcategoria"]."\" maxlength=\"5\" type=\"text\" class=\"inputbox\" onkeypress=\"return validar_num(this.form,this,event,'')\"  style=\"width:60px;\" value=".$ncantidad."></td>
                    <td width='30' align='center'><input name=\"txtmonto".$rs_subcateg->rowset["idsubcategoria"]."\" id=\"txtmonto".$rs_subcateg->rowset["idsubcategoria"]."\" type=\"text\" maxlength=\"14\" class=\"inputbox\" onkeypress=\"return validar_monto2(this.form,this,event,'')\"  style=\"width:60px;\" value=".$nmonto."></td>
                    </tr>";
                }
                else
                {
                    $html.= "<tr bgcolor='#f8f8f8' style=\"margin-left:-20px;\"  onmouseover=\"this.style.background='#f0f0f0';this.style.color='blue';\" onmouseout=\"this.style.background='#f8f8f8';this.style.color='black'\" >
                    <td width='20' align='center'><input type='checkbox' id='idsubcateg[]' name='idsubcateg[]' onchange=\"hab_texto(this, '".$rs_subcateg->rowset["idsubcategoria"]."')\" value='".$rs_subcateg->rowset["idsubcategoria"]."'\"></td>
                    <td width='120' align='left'><b>".$rs_subcateg->rowset["ssubcategoria"]."</b></td>
                    <td width='30' align='center'><input name=\"txtcantidad".$rs_subcateg->rowset["idsubcategoria"]."\" id=\"txtcantidad".$rs_subcateg->rowset["idsubcategoria"]."\" maxlength=\"5\" type=\"text\" class=\"inputbox\" disabled onkeypress=\"return validar_num(this.form,this,event,'')\"  style=\"width:60px;\" value=".$ncantidad."></td>
                    <td width='30' align='center'><input name=\"txtmonto".$rs_subcateg->rowset["idsubcategoria"]."\" id=\"txtmonto".$rs_subcateg->rowset["idsubcategoria"]."\" type=\"text\" maxlength=\"14\" class=\"inputbox\" disabled onkeypress=\"return validar_monto2(this.form,this,event,'')\"  style=\"width:60px;\" value=".$nmonto."></td>
                    </tr>";
                }
                

                $rs_subcateg->Siguiente();
            }

        $html.= "</table></div>";

    }    

    $respuesta->assign("dvSubcategoria","innerHTML",$html);
    return $respuesta;

}//mostrar_subcategorias

function mostrar_subcategorias2($idtipocaso, $idcategoria, $idcaso)
{
    
    $respuesta= new xajaxResponse();
    $ccaso=new ccasos();
    $html="";

    $ccaso->Conectar();
 
    if ($idcaso>0)  
		$rs_categ_selec=new Recordset("select idcat, idsubcategoria, monto, cantidad from casos_categorias_nuevos where idcaso=".$idcaso, $ccaso->conn);
    else 
		$rs_categ_selec="";
	$idtipocaso = ($idtipocaso == '') ? -1 : $idtipocaso;
	$sentencia = "select idsubcategoria, ssubcategoria from vtipocasos_categorias where idtipocaso=".$idtipocaso." and idcategoria=".$idcategoria ;
	#die($sentencia);
    $rs_subcateg=new Recordset($sentencia, $ccaso->conn);

    if ($rs_subcateg)
    {
         $html= "<div id='div_s' align=\"left\">
            <table border='1' class='tablaTitulo' width='465px'>
            <tr bgcolor='#f8f8f8' style=\"margin-left:-20px;\"  onmouseover=\"this.style.background='#f0f0f0';this.style.color='blue';\" onmouseout=\"this.style.background='#f8f8f8';this.style.color='black'\" >
            <td width='40' align='center' colspan='2'><b>SubCategor&iacute;a</b></td>
            <td width='30' align='center'><b>Cantidad Solicitada</b></td>
            <td width='30' align='center'><b>Monto Solicitado</b></td>
            </tr>";

            while($rs_subcateg->Mostrar())
            {
                $ncantidad="";
                $nmonto="";
                $chk="";

                if ($rs_categ_selec)
                {

                    $rs_categ_selec->Primero();
                    
                    while($rs_categ_selec->Mostrar())
                    {
                        if ($rs_subcateg->rowset["idsubcategoria"]==$rs_categ_selec->rowset["idsubcategoria"])
                        {
                            $chk="checked";
                            $ncantidad=$rs_categ_selec->rowset["cantidad"];
                            $nmonto=to_moneda($rs_categ_selec->rowset["monto"]);
                        }

                        $rs_categ_selec->Siguiente();

                    }
                }

                if ($chk!="")
                {
                    $html.= "<tr bgcolor='#f8f8f8' style=\"margin-left:-20px;\"  onmouseover=\"this.style.background='#f0f0f0';this.style.color='blue';\" onmouseout=\"this.style.background='#f8f8f8';this.style.color='black'\" >
                    <td width='20' align='center'><input type='checkbox' id='idsubcateg[]' name='idsubcateg[]' onchange=\"hab_texto(this, '".$rs_subcateg->rowset["idsubcategoria"]."')\" checked value='".$rs_subcateg->rowset["idsubcategoria"]."'\"></td>
                    <td width='120' align='left'><b>".$rs_subcateg->rowset["ssubcategoria"]."</b></td>
                    <td width='30' align='center'><input name=\"txtcantidad".$rs_subcateg->rowset["idsubcategoria"]."\" id=\"txtcantidad".$rs_subcateg->rowset["idsubcategoria"]."\" maxlength=\"5\" type=\"text\" class=\"inputbox\" onkeypress=\"return validar_num(this.form,this,event,'')\"  style=\"width:60px;\" value=".$ncantidad."></td>
                    <td width='30' align='center'><input name=\"txtmonto".$rs_subcateg->rowset["idsubcategoria"]."\" id=\"txtmonto".$rs_subcateg->rowset["idsubcategoria"]."\" type=\"text\" maxlength=\"14\" class=\"inputbox\" onkeypress=\"return validar_monto2(this.form,this,event,'')\"  style=\"width:60px;\" value=".$nmonto."></td>
                    </tr>";
                }
                else
                {
                    $html.= "<tr bgcolor='#f8f8f8' style=\"margin-left:-20px;\"  onmouseover=\"this.style.background='#f0f0f0';this.style.color='blue';\" onmouseout=\"this.style.background='#f8f8f8';this.style.color='black'\" >
                    <td width='20' align='center'><input type='checkbox' id='idsubcateg[]' name='idsubcateg[]' onchange=\"hab_texto(this, '".$rs_subcateg->rowset["idsubcategoria"]."')\" value='".$rs_subcateg->rowset["idsubcategoria"]."'\"></td>
                    <td width='120' align='left'><b>".$rs_subcateg->rowset["ssubcategoria"]."</b></td>
                    <td width='30' align='center'><input name=\"txtcantidad".$rs_subcateg->rowset["idsubcategoria"]."\" id=\"txtcantidad".$rs_subcateg->rowset["idsubcategoria"]."\" maxlength=\"5\" type=\"text\" class=\"inputbox\" disabled onkeypress=\"return validar_num(this.form,this,event,'')\"  style=\"width:60px;\" value=".$ncantidad."></td>
                    <td width='30' align='center'><input name=\"txtmonto".$rs_subcateg->rowset["idsubcategoria"]."\" id=\"txtmonto".$rs_subcateg->rowset["idsubcategoria"]."\" type=\"text\" maxlength=\"14\" class=\"inputbox\" disabled onkeypress=\"return validar_monto2(this.form,this,event,'')\"  style=\"width:60px;\" value=".$nmonto."></td>
                    </tr>";
                }
                

                $rs_subcateg->Siguiente();
            }
        $html.= "</table></div>";
    }    

    $respuesta->assign("dvSubcategoria","innerHTML",$html);
    return $respuesta;

}//mostrar_subcategorias2


function mostrar_misiones($idsolicitante)
{

    $respuesta= new xajaxResponse();
    $ccaso=new ccasos();
    $html="";

    $ccaso->Conectar();
    if ($idsolicitante>0)
    {
        $rs_misiones_selec=new Recordset("select misiones from informe_social where idsolicitante=".$idsolicitante, $ccaso->conn);
        if ($rs_misiones_selec->Mostrar())
        {
            $data_mision=explode(",", $rs_misiones_selec->rowset["misiones"]);
        }
    }
    else
    {
        $rs_misiones_selec="";
        $data_mision="";
    }

    $rs_misiones=new Recordset("select idmaestro, descripcion from vmisiones where estatus=1", $ccaso->conn);

    if ($rs_misiones->Mostrar())
    {
         $html= "<div id='div_m' align=\"left\">
            <table border='1' class='tablaTitulo' width='465px'>
            <tr bgcolor='#f8f8f8' style=\"margin-left:-20px;\"  onmouseover=\"this.style.background='#f0f0f0';this.style.color='blue';\" onmouseout=\"this.style.background='#f8f8f8';this.style.color='black'\" >
            <td width='70%' align='center' colspan='2'><b>Misiones</b></td>  
            </tr>";


            while($rs_misiones->Mostrar())
            {

                $chk="";

                if (@$data_mision)
                {
                    foreach (@$data_mision as $valor)
                    {
                        if ($rs_misiones->rowset["idmaestro"]==$valor)
                        {
                            $chk="checked";
                        }
                    }
                }

                $html.= "<tr bgcolor='#f8f8f8' style=\"margin-left:-20px;\"  onmouseover=\"this.style.background='#f0f0f0';this.style.color='blue';\" onmouseout=\"this.style.background='#f8f8f8';this.style.color='black'\" >
                <td align='left'><b>".$rs_misiones->rowset["descripcion"]."</b></td>
                <td align='center'><input type='checkbox' id='idmision[]' name='idmision[]' ".$chk." value='".$rs_misiones->rowset["idmaestro"]."'\"></td>
                </tr>";
              
                $rs_misiones->Siguiente();
            }

        $html.= "</table></div>";

    }

    $respuesta->assign("dvMisiones","innerHTML",$html);
    return $respuesta;

}//mostrar_misiones

function mostrar_misiones_nuevos($idsolicitante)
{

    $respuesta= new xajaxResponse();
    $ccaso=new ccasos();
    $html="";

    $ccaso->Conectar();
    if ($idsolicitante>0)
    {
        $rs_misiones_selec=new Recordset("select misiones from informe_social_actuales where idsolicitante=".$idsolicitante, $ccaso->conn);
        if ($rs_misiones_selec->Mostrar())
        {
            $data_mision=explode(",", $rs_misiones_selec->rowset["misiones"]);
        }
    }
    else
    {
        $rs_misiones_selec="";
        $data_mision="";
    }

    $rs_misiones=new Recordset("select idmaestro, descripcion from vmisiones where estatus=1", $ccaso->conn);

    if ($rs_misiones->Mostrar())
    {
         $html= "<div id='div_m' align=\"left\">
            <table border='1' class='tablaTitulo' width='465px'>
            <tr bgcolor='#f8f8f8' style=\"margin-left:-20px;\"  onmouseover=\"this.style.background='#f0f0f0';this.style.color='blue';\" onmouseout=\"this.style.background='#f8f8f8';this.style.color='black'\" >
            <td width='70%' align='center' colspan='2'><b>Misiones</b></td>  
            </tr>";


            while($rs_misiones->Mostrar())
            {

                $chk="";

                if (@$data_mision)
                {
                    foreach (@$data_mision as $valor)
                    {
                        if ($rs_misiones->rowset["idmaestro"]==$valor)
                        {
                            $chk="checked";
                        }
                    }
                }

                $html.= "<tr bgcolor='#f8f8f8' style=\"margin-left:-20px;\"  onmouseover=\"this.style.background='#f0f0f0';this.style.color='blue';\" onmouseout=\"this.style.background='#f8f8f8';this.style.color='black'\" >
                <td align='left'><b>".$rs_misiones->rowset["descripcion"]."</b></td>
                <td align='center'><input type='checkbox' id='idmision[]' name='idmision[]' ".$chk." value='".$rs_misiones->rowset["idmaestro"]."'\"></td>
                </tr>";
              
                $rs_misiones->Siguiente();
            }

        $html.= "</table></div>";

    }

    $respuesta->assign("dvMisiones","innerHTML",$html);
    return $respuesta;

}//mostrar_misiones_nuevos

function mostrar_servicios($idsolicitante)
{
    
    $respuesta= new xajaxResponse();
    $ccaso=new ccasos();
    $html="";
    
    $ccaso->Conectar();
    
    if ($idsolicitante>0)
    {
        $rs_servicios_selec=new Recordset("select servicios_publicos from informe_social where idsolicitante=".$idsolicitante, $ccaso->conn);
        if ($rs_servicios_selec->Mostrar())
        {
            $data_mision=explode(",", $rs_servicios_selec->rowset["servicios_publicos"]);
        }
    }
    else
    {
        $rs_servicios_selec="";
        $data_mision="";
    }

    $rs_servicios=new Recordset("select idmaestro, descripcion from vservicios_publicos where estatus=1", $ccaso->conn);

    if ($rs_servicios->Mostrar())
    {
         $html= "<div id='div_m' align=\"left\">
            <table border='1' class='tablaTitulo' width='465px'>
            <tr bgcolor='#f8f8f8' style=\"margin-left:-20px;\"  onmouseover=\"this.style.background='#f0f0f0';this.style.color='blue';\" onmouseout=\"this.style.background='#f8f8f8';this.style.color='black'\" >
            <td width='70%' align='center' colspan='2'><b>Servicios P&uacute;blicos</b></td>
            </tr>";


            while($rs_servicios->Mostrar())
            {

                $chk="";

                if (@$data_mision)
                {
                    foreach (@$data_mision as $valor)
                    {
                        if ($rs_servicios->rowset["idmaestro"]==$valor)
                        {
                            $chk="checked";
                        }
                    }
                }

                $html.= "<tr bgcolor='#f8f8f8' style=\"margin-left:-20px;\"  onmouseover=\"this.style.background='#f0f0f0';this.style.color='blue';\" onmouseout=\"this.style.background='#f8f8f8';this.style.color='black'\" >
                <td align='left'><b>".$rs_servicios->rowset["descripcion"]."</b></td>
                <td align='center'><input type='checkbox' id='idservicio[]' name='idservicio[]' ".$chk." value='".$rs_servicios->rowset["idmaestro"]."'\"></td>
                </tr>";

                $rs_servicios->Siguiente();
            }

        $html.= "</table></div>";

    }

    $respuesta->assign("dvServicios","innerHTML",$html);
    return $respuesta;

}//mostrar_servicios

function mostrar_servicios_nuevos($idsolicitante)
{
    
    $respuesta= new xajaxResponse();
    $ccaso=new ccasos();
    $html="";
    
    $ccaso->Conectar();
    
    if ($idsolicitante>0)
    {
        $rs_servicios_selec=new Recordset("select servicios_publicos from informe_social_actuales where idsolicitante=".$idsolicitante, $ccaso->conn);
        if ($rs_servicios_selec->Mostrar())
        {
            $data_mision=explode(",", $rs_servicios_selec->rowset["servicios_publicos"]);
        }
    }
    else
    {
        $rs_servicios_selec="";
        $data_mision="";
    }

    $rs_servicios=new Recordset("select idmaestro, descripcion from vservicios_publicos where estatus=1", $ccaso->conn);

    if ($rs_servicios->Mostrar())
    {
         $html= "<div id='div_m' align=\"left\">
            <table border='1' class='tablaTitulo' width='465px'>
            <tr bgcolor='#f8f8f8' style=\"margin-left:-20px;\"  onmouseover=\"this.style.background='#f0f0f0';this.style.color='blue';\" onmouseout=\"this.style.background='#f8f8f8';this.style.color='black'\" >
            <td width='70%' align='center' colspan='2'><b>Servicios P&uacute;blicos</b></td>
            </tr>";


            while($rs_servicios->Mostrar())
            {

                $chk="";

                if (@$data_mision)
                {
                    foreach (@$data_mision as $valor)
                    {
                        if ($rs_servicios->rowset["idmaestro"]==$valor)
                        {
                            $chk="checked";
                        }
                    }
                }

                $html.= "<tr bgcolor='#f8f8f8' style=\"margin-left:-20px;\"  onmouseover=\"this.style.background='#f0f0f0';this.style.color='blue';\" onmouseout=\"this.style.background='#f8f8f8';this.style.color='black'\" >
                <td align='left'><b>".$rs_servicios->rowset["descripcion"]."</b></td>
                <td align='center'><input type='checkbox' id='idservicio[]' name='idservicio[]' ".$chk." value='".$rs_servicios->rowset["idmaestro"]."'\"></td>
                </tr>";

                $rs_servicios->Siguiente();
            }

        $html.= "</table></div>";

    }

    $respuesta->assign("dvServicios","innerHTML",$html);
    return $respuesta;

}//mostrar_servicios

function editar_persona($idsolicitante, $idpersona)
{
    $respuesta= new xajaxResponse();    
    $ccaso=new ccasos();
    
    $sql="select idregistro, razon_social, cedula, edad, idparentesco, idgrado_instruccion, idocupacion, ingreso_mensual, sexo from nucleo_familiar_nuevos where idregistro=".$idpersona;
    $ccaso->Conectar();
    
    $rs_persona=new Recordset($sql, $ccaso->conn);

    if($rs_persona->Mostrar())
    {    
        $respuesta->assign("idpersona", "value", $rs_persona->rowset["idregistro"]);
        $respuesta->assign("razon_social_fami", "value", $rs_persona->rowset["razon_social"]);
        $respuesta->assign("cedula_fami", "value", $rs_persona->rowset["cedula"]);
        $respuesta->assign("edad_fami", "value", $rs_persona->rowset["edad"]);
        $respuesta->assign("parentesco_fami", "value", $rs_persona->rowset["idparentesco"]);
        $respuesta->assign("grado_fami", "value", $rs_persona->rowset["idgrado_instruccion"]);
        $respuesta->assign("ocupacion_fami", "value", $rs_persona->rowset["idocupacion"]);
        $respuesta->assign("sexo_fami", "value", $rs_persona->rowset["sexo"]);
        $respuesta->assign("ingreso_fami", "value", to_moneda($rs_persona->rowset["ingreso_mensual"]));
    }      
    
    return $respuesta;
}

function guardar_persona($formulario, $mostrar)
{
    $respuesta= new xajaxResponse();
    $ccaso=new ccasos();
    $html="";

    $idcaso=$formulario["idcaso"];
    $swerror=false;

    if ($mostrar==false)
    {
        if(validar_vacio($formulario["razon_social_fami"])==true)
        {
            $respuesta->script("alert('Debe Introducir la Razon Social del Familiar');");
            $swerror=true;
        }else if (validar_vacio($formulario["ingreso_fami"])==true)
        {
            $respuesta->script("alert('Debe Introducir el Monto de Ingreso Mensual del Familiar');");
            $swerror=true;
        }

        if ($swerror==false)
        {
            if ($formulario["idpersona"]>0) $ccaso->actualizar_persona_informe($formulario);
            else    $ccaso->insertar_persona_informe($formulario);
        }
    }

    $html="<table width=\"100%\" border=\"1\" style=\"margin-top:10px;\">
    <tr class=\"encabezado_tablas\">
    <td align=\"center\"><strong>Raz&oacute;n Social</strong></td>
    <td align=\"center\"><strong>C.I.</strong></td>
    <td align=\"center\"><strong>Edad</strong></td>
    <td align=\"center\"><strong>Parentesco</strong></td>
    <td align=\"center\"><strong>Grado de Instrucci&oacute;n</strong></td>
    <td align=\"center\"><strong>Ocupaci&oacute;n</strong></td>
    <td align=\"center\"><strong>Sexo</strong></td>
    <td align=\"center\"><strong>Ingreso Mensual (Bs.f.)</strong></td>
    <td align=\"center\"><strong>Acci&oacute;n</strong></td>
    </tr>";

    $ccaso->Conectar();
    $sql="select idregistro, idsolicitante, razon_social, cedula, edad, idparentesco, (select descripcion from vparentesco where idmaestro=idparentesco) as sparentesco,idgrado_instruccion, (select descripcion from vgrado_instruccion where idmaestro=idgrado_instruccion) as sgrado_instruccion,idocupacion, (select descripcion from vocupacion where idmaestro=idocupacion) as socupacion,ingreso_mensual, sexo, case when sexo='M' then 'Masculino' when sexo='F' then 'Femenino' else '' end as ssexo from nucleo_familiar_nuevos where idsolicitante=".$formulario["idsolicitante"]." order by edad";
    
    $rs_familiar=new Recordset($sql, $ccaso->conn);
	//print_r($rs_familiar);

    while($rs_familiar->Mostrar())
    {
        $html.="<tr>
        <td align=\"left\">".$rs_familiar->rowset["razon_social"]."</td>
        <td align=\"left\">".$rs_familiar->rowset["cedula"]."</td>
        <td align=\"center\">".$rs_familiar->rowset["edad"]."</td>
        <td align=\"left\">".$rs_familiar->rowset["sparentesco"]."</td>
        <td align=\"left\">".$rs_familiar->rowset["sgrado_instruccion"]."</td>
        <td align=\"left\">".$rs_familiar->rowset["socupacion"]."</td>
        <td align=\"left\">".$rs_familiar->rowset["ssexo"]."</td>
        <td align=\"right\">".to_moneda($rs_familiar->rowset["ingreso_mensual"])."</td>
        <td align=\"center\">
            <a  href=\"javascript:editar_persona('".$formulario["idsolicitante"]."', '".$rs_familiar->rowset["idregistro"]."')\"><img src=\"../comunes/imagenes/user_edit.png\" onmouseover=\"Tip('Editar Persona')\" onmouseout=\"UnTip()\"  width=\"16\" height=\"16\" border=\"0\" /></a>
            <a  href=\"javascript:eliminar_persona('".$formulario["idsolicitante"]."', '".$rs_familiar->rowset["idregistro"]."')\"><img src=\"../comunes/imagenes/user_delete.png\" onmouseover=\"Tip('Eliminar Persona')\" onmouseout=\"UnTip()\"  width=\"16\" height=\"16\" border=\"0\" /></a>
        </td>
        </tr>";
        $rs_familiar->Siguiente();

    }    

    $html.="</table>";
    
    $respuesta->assign("razon_social_fami", "value", "");
    $respuesta->assign("cedula_fami", "value", "");
    $respuesta->assign("edad_fami", "value", "");
    $respuesta->assign("parentesco_fami", "value", "0");
    $respuesta->assign("grado_fami", "value", "0");
    $respuesta->assign("ocupacion_fami", "value", "0");
    $respuesta->assign("sexo_fami", "value", "");
    $respuesta->assign("ingreso_fami", "value", "");
    
    $respuesta->assign("capaFamiliar","innerHTML",$html);
    return $respuesta;

}

function eliminar_persona($idsolicitante, $idregistro)
{
    $respuesta= new xajaxResponse();
    $ccaso=new ccasos();
    $html="";

    if ($idregistro>0)
    {
        $ccaso->Ejecutarsql("delete from nucleo_familiar_nuevos where idregistro=".$idregistro);      
    }

    $html="<table width=\"100%\" border=\"1\" style=\"margin-top:10px;\">
    <tr class=\"encabezado_tablas\">
    <td align=\"center\"><strong>Raz&oacute;n Social</strong></td>
    <td align=\"center\"><strong>C.I.</strong></td>
    <td align=\"center\"><strong>Edad</strong></td>
    <td align=\"center\"><strong>Parentesco</strong></td>
    <td align=\"center\"><strong>Grado de Instrucci&oacute;n</strong></td>
    <td align=\"center\"><strong>Ocupaci&oacute;n</strong></td>
    <td align=\"center\"><strong>Sexo</strong></td>
    <td align=\"center\"><strong>Ingreso Mensual (Bs.f.)</strong></td>
    <td align=\"center\"><strong>Acci&oacute;n</strong></td>
    </tr>";

    $ccaso->Conectar();
    $sql="select idregistro, idsolicitante, razon_social, cedula, edad, idparentesco, (select descripcion from vparentesco where idmaestro=idparentesco) as sparentesco,idgrado_instruccion, (select descripcion from vgrado_instruccion where idmaestro=idgrado_instruccion) as sgrado_instruccion,idocupacion, (select descripcion from vocupacion where idmaestro=idocupacion) as socupacion,ingreso_mensual, sexo, case when sexo='M' then 'Masculino' when sexo='F' then 'Femenino' else '' end as ssexo from nucleo_familiar_nuevos where idsolicitante=".$idsolicitante;
 
    
    $rs_familiar=new Recordset($sql, $ccaso->conn);
    
    if ($rs_familiar)
    {
        while($rs_familiar->Mostrar())
        {

            $html.="<tr>
            <td align=\"left\">".$rs_familiar->rowset["razon_social"]."</td>
            <td align=\"left\">".$rs_familiar->rowset["cedula"]."</td>
            <td align=\"center\">".$rs_familiar->rowset["edad"]."</td>
            <td align=\"left\">".$rs_familiar->rowset["sparentesco"]."</td>
            <td align=\"left\">".$rs_familiar->rowset["sgrado_instruccion"]."</td>
            <td align=\"left\">".$rs_familiar->rowset["socupacion"]."</td>
            <td align=\"left\">".$rs_familiar->rowset["ssexo"]."</td>
            <td align=\"right\">".to_moneda($rs_familiar->rowset["ingreso_mensual"])."</td>
            <td align=\"left\"><a  href=\"javascript:eliminar_persona('".$idsolicitante."', '".$rs_familiar->rowset["idregistro"]."')\"><img src=\"../comunes/imagenes/user_delete.png\" onmouseover=\"Tip('Eliminar Persona')\" onmouseout=\"UnTip()\" style=\"margin-left:5px; margin-right:5px;\" width=\"16\" height=\"16\" border=\"0\" /></a></td>
            </tr>";

            $rs_familiar->Siguiente();

        }
    }
    
    $html.="</table>";
    $respuesta->assign("capaFamiliar","innerHTML",$html);
    return $respuesta;

}//eliminar_persona

function buscar_casos()
{
    $respuesta= new xajaxResponse();

    $html= "<div id='div_b' align=\"left\">
    <table border='1' class='tablaTitulo' width='100%'>
    <tr bgcolor='#f8f8f8' style=\"margin-left:-20px;\"  onmouseover=\"this.style.background='#f0f0f0';this.style.color='blue';\" onmouseout=\"this.style.background='#f8f8f8';this.style.color='black'\" >
    <td width='86'><label id='lstrnombreb' style='celda_etiqueta'>Nuevo Remitente:</label></td>
    <td width='400' align='left'><input name=\"txtinstitucion\" id=\"txtinstitucion\" type=\"text\" class=\"inputbox\"   style=\"width:160px;\" value=''>
    <a  href=\"javascript:guardar_remitente();\"><img src=\"../comunes/imagenes/16_save.gif\" onmouseover=\"Tip('Guardar Remitente')\" onmouseout=\"UnTip()\" style=\"margin-left:5px; margin-right:5px;\" width=\"16\" height=\"16\" border=\"0\" /></a>
    </td>
    </tr></table></div>";

    $respuesta->assign("dvBusqueda","innerHTML",$html);
    return $respuesta;

}//buscar_casos

function  validar_solicitante($formulario, $swmostrar)
{
    $respuesta= new xajaxResponse();
    $ccaso=new ccasos();

    $razon_social_solic="";
    $telefonos_solic="";
    $tipo_solicitante="112";
    $parentesco="12";
    $filtro="";
    $cedula_solic="";
    $rif_solic="";

    if (@$formulario["idsolicitante"]>0)    $id_solicitante=$formulario["idsolicitante"];
    if (@$formulario["cedula_solic"])    $cedula_solic=@$formulario["cedula_solic"];
    if (@$formulario["rif_solic"])   $rif_solic=@$formulario["rif_solic"];

    if ($id_solicitante>0)
    {
        $filtro=" idsolicitante =".$id_solicitante;
    }
    
    if ($cedula_solic!="")
    {
        $filtro=" cedula ='".$cedula_solic."'";
    }

    if ($rif_solic!="")
    {
        if ($filtro!="")    $filtro.=" and rif ='".$rif_solic."'";
        $filtro=" rif ='".$rif_solic."'";
    }

    if ($filtro!="")
    {
        $ccaso->Conectar();
        $sql="select * from solicitantes where ".$filtro;
        $rs_solic=new Recordset($sql, $ccaso->conn);

        if($rs_solic->Mostrar())
        {
            $cedula_solic=$rs_solic->rowset["cedula"];
            $rif_solic=$rs_solic->rowset["rif"];
            $razon_social_solic=$rs_solic->rowset["razon_social"];
            $telefonos_solic=$rs_solic->rowset["telefonos"];
            $tipo_solicitante=$rs_solic->rowset["idtipo_solicitante"];
            $parentesco=$rs_solic->rowset["idparentesco"];

            //$respuesta->script("ocultar('dvMensaje', '¡El Solicitante se Encuentra Registrado en el Sistema!')");
            if ($swmostrar=='1')  $respuesta->script("alert('¡El Solicitante se Encuentra Registrado en el Sistema!');");
        }
        else
        {
            if ($swmostrar=='1')    $respuesta->script("alert('¡No Existe Registrado un Solicitante con los Datos Ingresados!');");

                //$respuesta->script("ocultar('dvMensaje', '¡No Existe Registrado un Solicitante con los Datos Ingresados!')");
        }

    }
    else
    {
        if ($swmostrar=='1')   $respuesta->script("alert('¡No Existe Registrado un Solicitante con los Datos Ingresados!');");
            //$respuesta->script("ocultar('dvMensaje', '¡No Existe Registrado un Solicitante con los Datos Ingresados!')");
    }

    $html="<table border='0' class='tablaTitulo' width='100%'>
    
    <tr>
    <td width=\"95\"><strong>C&eacute;dula:</strong></td>
    <td width=\"176\"><label><input name=\"cedula_solic\" type=\"text\" class=\"inputbox\" id=\"cedula_solic\" onkeypress=\"return CedulaFormat(this,'Cédula de Identidad Invalida',-1,true,event)\" onmouseout=\"UnTip()\" maxlength=\"12\" value=\"".$cedula_solic."\" ></input></label></td>
    <td width=\"89\"><strong>R.I.F:</strong></td><td width=\"199\"><label>
    <input name=\"rif_solic\" type=\"text\" class=\"inputbox\" id=\"rif_solic\" onkeypress=\"return RifFormat(this,'Rif del Solicitante Invalido',-1,true,event)\" onmouseout=\"UnTip()\" maxlength=\"12\" value=\"".$rif_solic."\" ></input>
    </label>
    <a  href=\"javascript:validar_solicitante()\"><img src=\"../comunes/imagenes/ico_16_assign.gif\" onmouseover=\"Tip('Validar Existencia del Solicitante')\" onmouseout=\"UnTip()\" style=\"margin-left:5px; margin-right:5px;\" width=\"16\" height=\"16\" border=\"0\" /></a>
	</td>
    </tr>

    <tr>
    <td><strong>Raz&oacute;n Social:</strong></td><td colspan=\"3\">
    <label><input name=\"razon_social_solic\" type=\"text\" class=\"inputbox\" id=\"razon_social_solic\" style=\"width:464px;\" onkeypress=\"return validar_texto(this.form,this,event,'')\" value=\"".$razon_social_solic."\"></input></label></td>
    </tr>
    <tr>
    <td><strong>Telefono(s):</strong></td><td colspan=\"3\">
    <input name=\"telefonos_solic\" type=\"text\" class=\"inputbox\" id=\"telefonos_solic\" onkeypress=\"return validar_telefono(this.form,this,event,'')\" style=\"width:464px;\" value=\"".$telefonos_solic."\"></td>
    </tr>

    <tr><td><strong>Tipo de Solicitante:</strong></td><td><select name=\"tipo_solicitante\" id=\"tipo_solicitante\" style=\"width:160px;\" class=\"inputbox\">
    <option value>Seleccione...</option>";
    $html.=$ccaso->Cargarlista("select idmaestro, descripcion from vtipo_solicitantes where estatus=1 order by descripcion", $tipo_solicitante);
    $html.="</select></td><td><strong>Parentesco:</strong></td><td><select name=\"parentesco\" id=\"parentesco\" style=\"width:160px;\" class=\"inputbox\"><option value>Seleccione...</option>";
    $html.=$ccaso->Cargarlista("select idmaestro, descripcion from vparentesco where estatus=1 order by descripcion", $parentesco);
    $html.="</select></td></tr></table>";

    $respuesta->assign("dvsolicitante","innerHTML",$html);
    return $respuesta;
    
}


function  validar_solicitante_actual($formulario, $swmostrar)
{
    $respuesta= new xajaxResponse();
    $ccaso=new ccasos();

    $razon_social_solic="";
    $telefonos_solic="";
    $tipo_solicitante="";
    $parentesco="";
    $filtro="";
    $cedula_solic="";
    $rif_solic="";
	$id_solicitante="";

    if (@$formulario["idsolicitante"]>0)    $id_solicitante=@$formulario["idsolicitante"];
    if (@$formulario["cedula_solic"])    $cedula_solic=@$formulario["cedula_solic"];
    if (@$formulario["rif_solic"])   $rif_solic=@$formulario["rif_solic"];

    if ($id_solicitante>0)
    {
        $filtro=" idsolicitante =".$id_solicitante;
    }
    
    if ($cedula_solic!="")
    {
        $filtro=" cedula ='".$cedula_solic."'";
    }
	//echo $filtro;
    if ($rif_solic!="")
    {
        if ($filtro!="")    
			$filtro.=" and rif ='".$rif_solic."'";
		else	
			$filtro=" rif ='".$rif_solic."'";
    }

    if ($filtro!="")
    {
        $ccaso->Conectar();
        $sql="select * from solicitantes_actuales where ".$filtro;
		//echo $sql;
        $rs_solic=new Recordset($sql, $ccaso->conn);

        if($rs_solic->Mostrar())
        {
            $cedula_solic=$rs_solic->rowset["cedula"];
            $rif_solic=$rs_solic->rowset["rif"];
            $razon_social_solic=$rs_solic->rowset["razon_social"];
            $telefonos_solic=$rs_solic->rowset["telefonos"];
            $tipo_solicitante=$rs_solic->rowset["idtipo_solicitante"];
            $parentesco=$rs_solic->rowset["idparentesco"];

            if ($swmostrar=='1')  $respuesta->script("alert('¡El Solicitante se Encuentra Registrado en el Sistema!');");
        }
        else
        {
            if ($swmostrar=='1')    $respuesta->script("alert('¡No Existe Registrado un Solicitante con los Datos Ingresados!');");
        }

    }
    else
    {
        if ($swmostrar=='1')   $respuesta->script("alert('¡No Existe Registrado un Solicitante con los Datos Ingresados!');");
            //$respuesta->script("ocultar('dvMensaje', '¡No Existe Registrado un Solicitante con los Datos Ingresados!')");
    }

    $html="<table border='0' class='tablaTitulo' width='100%'>
    
    <tr>
    <td width=\"95\"><strong>C&eacute;dula:</strong></td>
    <td width=\"176\"><label><input name=\"cedula_solic\" type=\"text\" class=\"inputbox\" id=\"cedula_solic\" onkeypress=\"return CedulaFormat(this,'Cédula de Identidad Invalida',-1,true,event)\" onmouseout=\"UnTip()\" maxlength=\"12\" value=\"".$cedula_solic."\" ></input></label></td>
    <td width=\"89\"><strong>R.I.F:</strong></td><td width=\"199\"><label>
    <input name=\"rif_solic\" type=\"text\" class=\"inputbox\" id=\"rif_solic\" onkeypress=\"return RifFormat(this,'Rif del Solicitante Invalido',-1,true,event)\" onmouseout=\"UnTip()\" maxlength=\"12\" value=\"".$rif_solic."\" ></input>
    </label>
    <a  href=\"javascript:validar_solicitante_actual()\"><img src=\"../comunes/imagenes/ico_16_assign.gif\" onmouseover=\"Tip('Validar Existencia del Solicitante')\" onmouseout=\"UnTip()\" style=\"margin-left:5px; margin-right:5px;\" width=\"16\" height=\"16\" border=\"0\" /></a>
	</td>
    </tr>

    <tr>
    <td><strong>Raz&oacute;n Social:</strong></td><td colspan=\"3\">
    <label><input name=\"razon_social_solic\" type=\"text\" class=\"inputbox\" id=\"razon_social_solic\" style=\"width:464px;\" onkeypress=\"return validar_texto(this.form,this,event,'')\" value=\"".$razon_social_solic."\"></input></label></td>
    </tr>
	
    <tr>
    <td><strong>Telefono(s):</strong></td><td colspan=\"3\">
    <input name=\"telefonos_solic\" type=\"text\" class=\"inputbox\" id=\"telefonos_solic\" onkeypress=\"return validar_telefono(this.form,this,event,'')\" style=\"width:464px;\" value=\"".$telefonos_solic."\"></td>
    </tr>

    <tr><td><strong>Tipo de Solicitante:</strong></td><td><select name=\"tipo_solicitante\" id=\"tipo_solicitante\" style=\"width:160px;\" class=\"inputbox\">
    <option value>Seleccione...</option>";
    $html.=$ccaso->Cargarlista("select idmaestro, descripcion from vtipo_solicitantes where estatus=1 order by descripcion", $tipo_solicitante);
    $html.="</select>
		</td>
		<td>
		<strong>Parentesco:</strong>
		</td>
		<td><select name=\"parentesco\" id=\"parentesco\" style=\"width:160px;\" class=\"inputbox\"><option value>Seleccione...</option>";
    $html.=$ccaso->Cargarlista("select idmaestro, descripcion from vparentesco where estatus=1 order by descripcion", $parentesco);
	$html.="</select></td></tr></table>";
	$respuesta->assign("dvsolicitante","innerHTML",$html);
    return $respuesta;
    
}

function eliminarUsuario($idUsuario)
{
    $respuesta= new xajaxResponse();
    $ccaso=new ccasos();
    
/*
    $nseg=$cusuario->Count("seguimientos", "idusuario=".$idUsuario);

    if ($nseg>0)
    {
        $respuesta->script("alert('No es Posible Eliminar el Usuario Seleccionado debido a que Posee Registros Asociados');");
    }
    else
    {
        $cusuario->Ejecutarsql("delete from sis_usuarios where idusuario=".$idUsuario);
        $respuesta->script("alert('El Usuario ha Sido Eliminado con Exito');");
    }
*/
    $respuesta->script("alert('El Usuario ha Sido Eliminado con Exito');");
    $respuesta->script("window.open('lst_usuarios.php', 'contenido');");
    $respuesta->assign("dvUsuarios","innerHTML",$html);
    
    return $respuesta;

}

?>