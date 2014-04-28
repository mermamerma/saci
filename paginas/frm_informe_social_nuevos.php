<?

    require_once ('../comunes/xajax/xajax_core/xajax.inc.php');
    require_once("../librerias/db_postgresql.inc.php");
    require_once('../librerias/funciones_ajax.php');
    require_once('../cdatos/csolicitantes.php');
    require_once('../cdatos/ccasos.php');

	$xajax= new xajax();
	

    $xajax->registerFunction('mostrar_misiones_nuevos');
    $xajax->registerFunction('mostrar_servicios_nuevos');
    $xajax->registerFunction('guardar_persona');
    $xajax->registerFunction('eliminar_persona');
    $xajax->registerFunction('editar_persona');
	
	$xajax->processRequest();
    $xajax->configure('javascript URI', '../xajax/');
	$xajax->setFlag('debug',false);

//var_dump($xajax);
?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta http-equiv="pragma" content="no-cache">
        <link rel="shortcut icon" href="../comunes/imagenes/favicon.ico" type="image/x-icon" >

        <link href="../comunes/css/general.css" rel="stylesheet" type="text/css" />
		<?php
			$xajax->printJavascript('../comunes/xajax/')
		?>
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

             document.oncontextmenu = function(){return false}
            var strSeperator = '/';
            var shift=false;
            var crtl=false; 
            var alt=false;
        
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

            function inicio()
            {
                if(self.gfPop)
                {
                        gfPop.fPopCalendar(document.frminforme.f_inicio);
                }
            }

            function cambio_inicio()
            {
                if (inicio=='')
                {
                    alert('Fecha Inv&aacute;lida');
                    document.frminforme.f_inicio.value='';
                }
                else
                {
                    document.frminforme.fecha_inicio.value=document.frminforme.f_inicio.value;
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
                window.document.getElementById('accion').value='guardar';
				document.frminforme.submit();
            }
      
            function mostrar_tablas(idsolicitante)
            {                
                xajax_mostrar_misiones_nuevos(idsolicitante);
                xajax_mostrar_servicios_nuevos(idsolicitante);
                xajax_guardar_persona(xajax.getFormValues('frminforme'), true);
            }

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

	function RifFormat(vRifName,mensaje,postab,escribo,evento) {

		tecla=getkey(evento);
		vRifName.value=vRifName.value.toUpperCase();
		vRifValue=vRifName.value;
		valor=vRifValue.substring(2,12);
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

		tam=vRifValue.length;
		if (escribo) {
		if ( tecla==8 || tecla==37)
		{
			if (tam>2)
				vRifName.value=vRifValue.substr(0,tam-1);
			else
				vRifName.value='';
				return false;
		}

		if (tam==0 && tecla==74) {
			vRifName.value='J-';
			return false;
		}

		if (tam==0 && tecla==86) {
			vRifName.value='V-';
			return false;
		}

		else if ((tam==0 && ! (tecla<14 || tecla==74 || tecla==86 || tecla==46)))
		return false;
		else if ((tam>1) && !(tecla<14 || tecla==16 || tecla==46 || tecla==8 || (tecla >= 48 && tecla <= 57) || (tecla>=96 && tecla<=105)))
		return false;
		}
		if (noerror)
		return true;

		alert('Debe ser un Rif Válido\nPor Favor Reescribalo');
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


        function nueva_persona()
        {
            xajax_guardar_persona(xajax.getFormValues('frminforme'), false);
        }
        
        function editar_persona(idsolicitante, idregistro)
        {
            if  (idregistro>0)
            {
                xajax_editar_persona(idsolicitante, idregistro);
            }
        }
        
        function eliminar_persona(idsolicitante, idregistro)
        {
            var resp
            resp=confirm('¿ Esta Seguro que Desea Eliminar la Persona Seleccionada ?');

            if ((resp)&& (idregistro>0))
            {
                xajax_eliminar_persona(idsolicitante, idregistro);
            }
            
        }

        function cerrar()
        {
            window.open('lst_casos_comite_nuevos.php','contenido')
        }

        function imprimir(idcaso)
        {
            window.open('../reportes/rpt_social_nuevos.php?idcaso='+idcaso,'_blank')
        }

        </script>
		
    </head>

     


    <?

        $csolic=new csolicitantes();
        $ccaso=new ccasos();

        if (isset($_REQUEST["accion"]) && $_REQUEST["accion"]=="guardar")
        {

            $csolic->set_idcaso_informe($_REQUEST["idcaso"]);
            $csolic->set_razon_social($_REQUEST["razon_social_solic"]);
            $csolic->set_cedula($_REQUEST["cedula"]);
            $csolic->set_sexo($_REQUEST["sexo"]);
            $csolic->set_fecha_nac($_REQUEST["fecha_inicio"]);
            $csolic->set_lugar_nac($_REQUEST["lugar_nac"]);
            $csolic->set_idnacionalidad($_REQUEST["nacionalidad"]);
            $csolic->set_idocupacion($_REQUEST["ocupacion"]);
            $csolic->set_telefonos($_REQUEST["telefonos"]);
            $csolic->set_idcivil($_REQUEST["civil"]);
            $csolic->set_idestado($_REQUEST["estado"]);
            $csolic->set_idmunicipio($_REQUEST["municipio"]);
            $csolic->set_idparroquia($_REQUEST["parroquia"]);
            $csolic->set_direccion($_REQUEST["direccion"]);
            $csolic->set_idusuario_informe($_SESSION["idusuario"]);
            $csolic->set_idgrado_instruccion($_REQUEST["grado_solic"]);
            $csolic->set_ingreso_mensual($_REQUEST["ingreso_solic"]);
            $csolic->set_idtipo_solicitante($_REQUEST["tipo_solicitante"]);
            $csolic->set_edad($_REQUEST["edad_solic"]);
            $csolic->set_comunidad($_REQUEST["comunidad"]);
            $csolic->set_idparentesco($_REQUEST["parentesco_solic"]);

            $csolic->set_idsolicitante($_REQUEST["idsolicitante"]);

            $nsolic_act=$csolic->Update_Solic_Benef_Caso_nuevos();

            if (!$nsolic_act>0)
            {
                mensaje("Han Ocurrido Errores al Intentar Actualizar el Solicitante");
            }

            $csolic->set_tipo_vivienda($_REQUEST["tipo_vivienda"]);
            $csolic->set_tenencia_vivienda($_REQUEST["tenencia_vivienda"]);
            $csolic->set_area_fisico($_REQUEST["area_fisico"]);
            $csolic->set_area_economica($_REQUEST["area_economica"]);
            $csolic->set_condiciones_salud($_REQUEST["salud"]);
            $csolic->set_observacion($_REQUEST["observacion"]);

            $smisiones="";
            if (isset($_REQUEST["idmision"]) && $_REQUEST["idmision"])
            {
                foreach ($_REQUEST["idmision"] as $valor)
                {
                    $smisiones.=$valor.",";
                }
            }
            $csolic->set_misiones($smisiones);

            $sservicio="";
            if ($_REQUEST["idservicio"])
            {
                foreach ($_REQUEST["idservicio"] as $valor)
                {
                    $sservicio.=$valor.",";
                }
            }
            
            $csolic->set_servicios_publicos($sservicio);

            if ($_REQUEST["idinforme"]>0)
            {
                $csolic->set_idinforme_social($_REQUEST["idinforme"]);
                $ninforme=$csolic->update_Informe_Social_nuevos();
                $msg_info="Se ha Actualizado Satisfactoriamente el Informe Social";
                $msg_error="Han Ocurrido Errores al Intentar Actualizar el Informe Social";
            }
            else
            {
                $ninforme=$csolic->insertar_Informe_Social_nuevos();
                $msg_info="Se ha Creado Satisfactoriamente el Informe Social";
                $msg_error="Han Ocurrido Errores al Intentar Crear el Informe Social";
            }

            if ($ninforme>0)
            {
				//print_r($_REQUEST);
                if ($_REQUEST["estatus_caso"]<>0)
                {
                    $ccaso->set_idcaso($_REQUEST["idcaso"]);
                    $ccaso->set_idestatus($_REQUEST["estatus_caso"]);
                    $actualizar=$ccaso->actualizar_estatus();
                }

                mensaje($msg_info);
                //open_pag("lst_casos_comite_nuevos.php", "contenido");
                //redirect("lst_casos_comite.php", "contenido");
            }
            else
            {
                mensaje($msg_error);
            }

        }//guardar

        $data_solic=new Recordset();

        $idsolicitante=$csolic->getInt("casos_actuales", "idsolicitante", "idcaso=".$_REQUEST["idcaso"]);
        $csolic->set_idsolicitante($idsolicitante);
        $data_solic=$csolic->getDataSolicitante();

        if ($data_solic)
        {
	
            $_REQUEST["idsolicitante"]=$idsolicitante;
            $_REQUEST["razon_social_solic"]=$data_solic->rowset["razon_social"];
            $_REQUEST["cedula"]=$data_solic->rowset["cedula"];
            $_REQUEST["sexo"]=$data_solic->rowset["sexo"];
            $_REQUEST["f_inicio"]=fecha($data_solic->rowset["fecha_nac"]);
            $_REQUEST["fecha_inicio"]=fecha($data_solic->rowset["fecha_nac"]);
            $_REQUEST["lugar_nac"]=$data_solic->rowset["lugar_nac"];
            $_REQUEST["telefonos"]=$data_solic->rowset["telefonos"];
            $_REQUEST["direccion"]=$data_solic->rowset["direccion"];
            $_REQUEST["ingreso_solic"]=to_moneda($data_solic->rowset["ingreso_mensual"]);
            $_REQUEST["edad_solic"]=$data_solic->rowset["edad"];
            $_REQUEST["comunidad"]=$data_solic->rowset["comunidad"];     
            
            $data_informe=new Recordset();
            $csolic->set_idcaso_informe($_REQUEST["idcaso"]);
            $csolic->set_idsolicitante($idsolicitante);
            $data_informe=$csolic->getData_Informe_Social_nuevo();

			$_REQUEST["idinforme"]=0;
            if ($data_informe)
            {
                $_REQUEST["idinforme"]=$data_informe->rowset["idinforme"];
                $_REQUEST["misiones"]=$data_informe->rowset["misiones"];
                $_REQUEST["tipo_vivienda"]=$data_informe->rowset["tipo_vivienda"];
                $_REQUEST["tenencia_vivienda"]=$data_informe->rowset["tenencia_vivienda"];
                $_REQUEST["servicios_publicos"]=$data_informe->rowset["servicios_publicos"];
                $_REQUEST["area_fisico"]=$data_informe->rowset["area_fisico"];
                $_REQUEST["area_economica"]=$data_informe->rowset["area_economica"];
                $_REQUEST["salud"]=$data_informe->rowset["condiciones_salud"];
                $_REQUEST["observacion"]=$data_informe->rowset["observacion"];
				
				if ($data_informe->rowset["misiones"]>0) $_REQUEST["misiones"]=$data_informe->rowset["misiones"];
				if ($data_informe->rowset["tipo_vivienda"]>0) $_REQUEST["tipo_vivienda"]=$data_informe->rowset["tipo_vivienda"];
				if ($data_informe->rowset["tenencia_vivienda"]>0) $_REQUEST["tenencia_vivienda"]=$data_informe->rowset["tenencia_vivienda"];
				if ($data_informe->rowset["servicios_publicos"]>0) $_REQUEST["servicios_publicos"]=$data_informe->rowset["servicios_publicos"];
            }

            if (@$_REQUEST["idinforme"]>0){}
			else
            {
                $_REQUEST["nacionalidad"]="66";
                $_REQUEST["ocupacion"]="9";
                $_REQUEST["civil"]="10";
                $_REQUEST["estado"]="0";
                $_REQUEST["municipio"]="0";
                $_REQUEST["parroquia"]="0";
                $_REQUEST["misiones"]="0";
                $_REQUEST["tipo_vivienda"]="0";
                $_REQUEST["tenencia_vivienda"]="0";
                $_REQUEST["tipo_solicitante"]="0";
                $_REQUEST["grado_solic"]="118";
                $_REQUEST["parentesco_solic"]="12";
            }

            if ($data_solic->rowset["idnacionalidad"]>0) $_REQUEST["nacionalidad"]=$data_solic->rowset["idnacionalidad"];
            if ($data_solic->rowset["idocupacion"]>0) $_REQUEST["ocupacion"]=$data_solic->rowset["idocupacion"];
            if ($data_solic->rowset["idcivil"]>0) $_REQUEST["civil"]=$data_solic->rowset["idcivil"];
            if ($data_solic->rowset["idestado"]>0) $_REQUEST["estado"]=$data_solic->rowset["idestado"];
            if ($data_solic->rowset["idmunicipio"]>0)$_REQUEST["municipio"]=$data_solic->rowset["idmunicipio"];
            if ($data_solic->rowset["idparroquia"]>0) $_REQUEST["parroquia"]=$data_solic->rowset["idparroquia"];
            if ($data_solic->rowset["idtipo_solicitante"]>0) $_REQUEST["tipo_solicitante"]=$data_solic->rowset["idtipo_solicitante"];
            if ($data_solic->rowset["idgrado_instruccion"]>0) $_REQUEST["grado_solic"]=$data_solic->rowset["idgrado_instruccion"];
            if ($data_solic->rowset["idparentesco"]>0) $_REQUEST["parentesco_solic"]=$data_solic->rowset["idparentesco"];

        }//if
        else
        {
            mensaje("No es Posible Crear el Informe Social, debe Existir un Solicitante Registrado en el Caso Seleccionado");
            redirect("lst_casos_comite.php", "contenido");
        }


        $data_caso=new Recordset();
        $data_caso=$ccaso->getDataCasoActual($_REQUEST["idcaso"]);

        if ($data_caso)
        {
            $_REQUEST["sremitente"]=$data_caso->rowset["sremitente"];
			$_REQUEST["responsable"]=$data_caso->rowset["responsable"];
            $_REQUEST["descripcion_caso"]=$data_caso->rowset["descripcion_caso"];
            $_REQUEST["fecha_registro"]=$data_caso->rowset["fecha_registro"];
            $_REQUEST["sestatus_actual"]=$data_caso->rowset["sestatus_caso"];
            $_REQUEST["idestatus_caso"]=$data_caso->rowset["idestatus"];
        }

    ?>
    
    <body onload="mostrar_tablas('<?=$_REQUEST["idsolicitante"]?>')">
    <script src="../comunes/js/wz_tooltip/wz_tooltip.js" type="text/javascript"></script>
    <center>     
            <form name="frminforme" id="frminforme" method="post" action="frm_informe_social_nuevos.php">
                <input type="hidden" id="idcaso" name="idcaso" value="<?= $_REQUEST['idcaso'] ?>">
                <input type="hidden" name="fecha_inicio" id="fecha_inicio"  value="<? echo $_REQUEST["fecha_inicio"];?>">
                <input type="hidden" id="accion" name="accion" value="<?= $_REQUEST['accion'] ?>">                
                <input type="hidden" id="idsolicitante" name="idsolicitante" value="<?= $_REQUEST['idsolicitante'] ?>">
                <input type="hidden" id="idinforme" name="idinforme" value="<?= $_REQUEST['idinforme'] ?>">
            
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                        <td width="65%" class="menu_izq_titulo"><img src="../comunes/imagenes/logo_form.gif" />Informe Social</td>
                        <td width="10%" align="center" class="menu_izq_titulo">
                        <?   if ((@$_REQUEST["accion"]!="consultar") && ($_REQUEST["idestatus_caso"]!=PRE_APROBADO || $_REQUEST["idestatus_caso"]!=CERRADO))  {  ?>
                        <img src="../comunes/imagenes/16_save.gif" onmouseover="Tip('Guardar')" onmouseout="UnTip()" border="0" onclick="javascript:guardar()"/>
                        <? }
                           if ($_REQUEST["idinforme"]>0){
                        ?>
                        <img src="../comunes/imagenes/printer.png" onmouseover="Tip('Imprimir Informe')" onmouseout="UnTip()" border="0" onclick="javascript:imprimir('<?=$_REQUEST["idcaso"]?>')"/>
                        <?  }   ?>
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

                            <table width="100%" border="1" class="tablaTitulo">

                                <tr>
                                <td width="1">&nbsp;</td>
                                <td width="90">&nbsp;</td>
                                <td width="170">&nbsp;</td>
                                <td width="50">&nbsp;</td>
                                <td width="195">&nbsp;</td>
                                </tr>

                            <tr>
                                <td colspan="5" style="border:#CCCCCC solid 1px;" bgcolor="#F8F8F8" >
                                    <div align="center" style="background-image: url('../comunes/imagenes/barra.png');">
                                        <strong>Datos del Caso</strong>
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
                                    <textarea name="descripcion_caso" id="descripcion_caso" rows="5" class="inputbox" onkeypress="return validar_texto(this.form,this,event,'')" readonly  style="width:474px; height:95px; margin-bottom:10px;"><?if(isset($_REQUEST["descripcion_caso"])){echo $_REQUEST["descripcion_caso"];}?></textarea>
                                </td>

                                </tr>

                                 <tr>
                                <td>&nbsp;</td>
                                <td>
                                    <strong>
                                        Estatus Actual:
                                    </strong>
                                </td>
                                <td>
                                   <strong>
                                        <? echo $_REQUEST["sestatus_actual"]; ?>
                                    </strong>
                                </td>
                                <td><strong>
                                        Asignar Estatus:
                                    </strong></td>
                                <td>
                                    <select name="estatus_caso" id="estatus_caso" style="width:160px;" class="inputbox" >
                                        <option value='0'>Seleccione...</option>
                                        <?php
										#$lista = '133,134,174,277,280,328,348,349,350,351,352,353,354,355,356,357,358,359,360,361,362,363,382' ;
                                        #echo ($dat->Cargarlista("select idmaestro, descripcion from vestatus_casos where idmaestro in ($lista) order by descripcion", $_REQUEST["estatus_caso"]));
										echo ($dat->Cargarlista("select idmaestro, descripcion from vestatus_casos order by descripcion", $_REQUEST["estatus_caso"]));
                                        ?>
                                        </select></td>
                            </tr>

                            <tr>

                                <td colspan="6" style="border:#CCCCCC solid 1px;" bgcolor="#F8F8F8" >
                                    <div align="center" style="background-image: url('../comunes/imagenes/barra.png');">
                                        <strong>Datos del Solicitante</strong>
                                    </div>
                                </td>
                            </tr>
                                 <tr>
                                <td>&nbsp;</td>

                                <td>
                                    <strong>Razon Social:</strong>
                                </td>
                                <td colspan="3">
                                    <input name="razon_social_solic" type="text" class="inputbox" id="razon_social_solic" onkeypress="return validar_texto(this.form,this,event,'')" style="width:474px;" maxlength="80" value="<?= $_REQUEST['razon_social_solic'] ?>">
                                </td>
                            </tr>

                            <tr>
                                <td>&nbsp;</td>
                                <td>
                                    <strong>
                                        C&eacute;dula:
                                    </strong>
                                </td>
                                <td>
                                    <label>
                                        <input name="cedula" type="text" class="inputbox" id="cedula" maxlength="12" onkeypress="return CedulaFormat(this,'Cédula de Identidad Invalida',-1,true,event)" onmouseout="UnTip()" value="<?= $_REQUEST['cedula'] ?>" ></input>
                                    </label>
                                </td>
                                <td>
                                    <strong>Sexo:</strong>
                                </td>
                                <td>
                                     <select name="sexo" id="sexo" style="width:160px;" class="inputbox">
                                            <option value="" <? if ($_REQUEST["sexo"]=="") echo "selected";   ?> >Seleccione...</option>
                                            <option value="M" <? if ($_REQUEST["sexo"]=="M") echo "selected";   ?>>Masculino</option>
                                            <option value="F" <? if ($_REQUEST["sexo"]=="F") echo "selected";   ?>>Femenino</option>
                                    </select>
                                </td>
                            </tr>


                            <tr>
                                <td>&nbsp;</td>
                                <td>
                                    <strong>
                                        Lugar de Nacimiento:
                                    </strong>
                                </td>
                                <td>
                                    <label>
                                        <input name="lugar_nac" type="text" class="inputbox" id="lugar_nac" maxlength="50" onkeypress="return validar_texto(this.form,this,event,'')" value="<?= $_REQUEST['lugar_nac'] ?>" ></input>
                                    </label>
                                </td>
                                <td>
                                    <strong>Fecha de Nacimiento:</strong>
                                </td>
                                <td>
                                    <input class="inputbox_fecha" name="f_inicio"  id="f_inicio"  onchange="cambio_inicio();" value="<? echo $_REQUEST["fecha_inicio"];?>" size="10"   readonly="true" />
                                    <a href="javascript:void(0)"  onclick="inicio();" hidefocus><img class="PopcalTrigger"  style="width:36px; height:19px;  margin-left:5px;" align="absbottom" src="../comunes/calendar/btn_dis_cal.gif"  border="0" alt="" /></a>
                                    <!--  Calendario  -->
                                    <iframe width=174 height=189 name="gToday:normal:agenda.js" id="gToday:normal:agenda.js" src="../comunes/calendar/ipopeng.htm" scrolling="no" frameborder="0" style="visibility:visible; z-index:999; position:absolute; top:-500px; left:-500px;"></iframe>
                                    <!--  Calendario  -->
                                </td>
                            </tr>

                            <tr>
                                <td>&nbsp;</td>
                                <td>
                                    <strong>
                                        Nacionalidad:
                                    </strong>
                                </td>
                                <td>
                                    <select name="nacionalidad" id="nacionalidad" style="width:160px;" class="inputbox">
                                    <option value="0">Seleccione...</option>
                                    <?php
                                    echo ($dat->Cargarlista("select idmaestro, descripcion from vnacionalidad where estatus=1 order by descripcion", $_REQUEST["nacionalidad"]));
                                    ?>
                                    </select>
                                </td>
                                <td>
                                    <strong>
                                        Ocupaci&oacute;n:
                                    </strong>
                                </td>
                                <td>
                                    <select name="ocupacion" id="ocupacion" style="width:160px;" class="inputbox">
                                    <option value="0">Seleccione...</option>
                                    <?php
                                    echo ($dat->Cargarlista("select idmaestro, descripcion from vocupacion where estatus=1 order by descripcion", $_REQUEST["ocupacion"]));
                                    ?>
                                    </select>
                                </td>
                            </tr>

                            <tr>
                                <td>&nbsp;</td>
                                <td>
                                    <strong>
                                        Grado de Instrucci&oacute;n:
                                    </strong>
                                </td>
                                <td>
                                    <select name="grado_solic" id="grado_solic" style="width:160px;" class="inputbox">
                                    <option value="0">Seleccione...</option>
                                    <?php
                                        echo ($dat->Cargarlista("select idmaestro, descripcion from vgrado_instruccion where estatus=1 order by descripcion", $_REQUEST["grado_solic"]));
                                    ?>
                                    </select>
                                </td>
                                <td>
                                    <strong>
                                        Ingreso Mensual:
                                    </strong>
                                </td>
                                <td>
                                    <input name="ingreso_solic" type="text" class="inputbox" id="ingreso_solic" maxlength="14" style="width:160px;" onkeypress="return validar_monto2(this.form,this,event,'')" value="<?= $_REQUEST['ingreso_solic'] ?>" ></input>
                                </td>
                            </tr>


                                <tr>
                                <td>&nbsp;</td>
                                <td>
                                    <strong>
                                        Parentesco:
                                    </strong>
                                </td>
                                <td>
                                    <select name="parentesco_solic" id="parentesco_solic" style="width:160px;" class="inputbox">
                                    <option value="0">Seleccione...</option>
                                    <?php
                                        echo ($dat->Cargarlista("select idmaestro, descripcion from vparentesco where estatus=1 order by descripcion", $_REQUEST["parentesco_solic"]));
                                    ?>
                                    </select>
                                </td>
                                <td>
                                    <strong>Telefono(s):</strong>
                                </td>
                                <td>
                                    <input name="telefonos" type="text" class="inputbox" id="telefonos" onkeypress="return validar_texto(this.form,this,event,'')" style="width:160px;" maxlength="100" value="<?= $_REQUEST['telefonos'] ?>">
                                </td>
                            </tr>

                            <tr>
                                <td>&nbsp;</td>
                                <td>
                                    <strong>
                                        Estado Civil:
                                    </strong>
                                </td>
                                <td>
                                    <select name="civil" id="civil" style="width:160px;" class="inputbox">
                                    <option value="0">Seleccione...</option>
                                    <?php
                                    echo ($dat->Cargarlista("select idmaestro, descripcion from vestado_civil where estatus=1 order by descripcion", $_REQUEST["civil"]));
                                    ?>
                                    </select>
                                </td>
                                <td>
                                    <strong>
                                        Estado:
                                    </strong>
                                </td>
                                <td>
                                    <select name="estado" id="estado" style="width:160px;" class="inputbox" onchange='cargaContenido_Estados(this.id)'>
                                    <option value="0">Seleccione...</option>
                                    <?php
                                    echo ($dat->Cargarlista("select idestado, descripcion from estados order by descripcion", $_REQUEST["estado"]));
                                    ?>
                                    </select>
                                </td>
                            </tr>


                            <tr>
                                <td>&nbsp;</td>
                                <td>
                                    <strong>
                                        Municipio:
                                    </strong>
                                </td>
                                <td>
                                    <select name="municipio" id="municipio" style="width:160px;" class="inputbox" onchange='cargaContenido_Estados(this.id)'>
                                    <option value="0">Seleccione...</option>
                                    <?php
                                    echo ($dat->Cargarlista("select idmunicipio, descripcion from municipios where idestado=".$_REQUEST["estado"]." order by descripcion", $_REQUEST["municipio"]));
                                    ?>
                                    </select>
                                </td>
                                <td>
                                    <strong>
                                        Parroquia:
                                    </strong>
                                </td>
                                <td>
                                    <select name="parroquia" id="parroquia" style="width:160px;" class="inputbox">
                                    <option value="0">Seleccione...</option>
                                    <?php
                                    echo ($dat->Cargarlista("select idparroquia, descripcion from parroquias where idmunicipio=".$_REQUEST["municipio"]." order by descripcion", $_REQUEST["parroquia"]));
                                    ?>
                                    </select>
                                </td>
                            </tr>

                           <tr>
                                <td>&nbsp;</td>
                                <td>
                                    <strong>
                                        Tipo de Solicitante:
                                    </strong>
                                </td>
                                <td>
                                     <select name="tipo_solicitante" id="tipo_solicitante" style="width:160px;" class="inputbox">
                                    <option value="0">Seleccione...</option>
                                    <?php
                                    echo ($dat->Cargarlista("select idmaestro, descripcion from vtipo_solicitantes where estatus=1 order by descripcion", $_REQUEST["tipo_solicitante"]));
                                    ?>
                                    </select>
                                </td>
                                <td><strong>
                                        Edad:
                                    </strong>
                                </td>
                                <td>
                                    <input name="edad_solic" type="text" class="inputbox" id="edad_solic" maxlength="2" style="width:70px;" onkeypress="return validar_num(this.form,this,event,'')" value="<?= $_REQUEST['edad_solic'] ?>" ></input>
                                </td>
                            </tr>

                            <tr>
                                <td>&nbsp;</td>

                                <td>
                                    <strong>Comunidad:</strong>
                                </td>
                                <td colspan="3">
                                    <input name="comunidad" type="text" class="inputbox" id="comunidad" onkeypress="return validar_texto(this.form,this,event,'')" style="width:474px;" maxlength="80" value="<?= $_REQUEST['comunidad'] ?>"></input>
                                </td>
                            </tr>
                                
                            <tr>
                                <td>&nbsp;</td>
                                <td>
                                    <strong>
                                        Direcci&oacute;n:
                                    </strong>
                                </td>


                                <td colspan="3">
                                   <textarea name="direccion" id="direccion" rows="5" class="inputbox" onkeypress="return validar_texto(this.form,this,event,'')"  style="width:474px; height:95px; margin-bottom:10px;" <?if(isset($_REQUEST["accion"]) && $_REQUEST["accion"]=="consultar"){echo"readonly='readonly'";}?>><?if(isset($_REQUEST["descripcion_caso"])){echo $_REQUEST["direccion"];}?></textarea>
                                </td>

                                </tr>
                                
                                <tr>
                                <td colspan="6" style="border:#CCCCCC solid 1px;" bgcolor="#F8F8F8" >
                                    <div align="center" style="background-image: url('../comunes/imagenes/barra.png');">
                                        <strong>Educaci&oacute;n</strong>
                                    </div>
                                </td>
                            </tr>

                            <tr>
                            <td>&nbsp;</td>
                            <td>&nbsp; </td>
                            <td colspan="4" width="100%">
                            <div id="dvMisiones" align="center"></div>
                            </td>
                            </tr>


                                <tr>
                                <td colspan="6" style="border:#CCCCCC solid 1px;" bgcolor="#F8F8F8" >
                                    <div align="center" style="background-image: url('../comunes/imagenes/barra.png');">
                                        <strong>Caracter&iacute;sticas de la Vivienda</strong>
                                    </div>
                                </td>
                            </tr>


                            <tr>
                                <td>&nbsp;</td>
                                <td>
                                    <strong>
                                        Tipo de Vivienda:
                                    </strong>
                                </td>
                                <td>
                                    <select name="tipo_vivienda" id="tipo_vivienda" style="width:160px;" class="inputbox">
                                    <option value="0">Seleccione...</option>
                                    <?php
                                    echo ($dat->Cargarlista("select idmaestro, descripcion from vtipo_vivienda where estatus=1 order by descripcion", $_REQUEST["tipo_vivienda"]));
                                    ?>
                                    </select>
                                </td>
                                <td>
                                    <strong>
                                        Tenencia de la Vivienda:
                                    </strong>
                                </td>
                                <td>
                                    <select name="tenencia_vivienda" id="tenencia_vivienda" style="width:160px;" class="inputbox">
                                    <option value="0">Seleccione...</option>
                                    <?php
                                    echo ($dat->Cargarlista("select idmaestro, descripcion from vtenencia_vivienda where estatus=1 order by descripcion", $_REQUEST["tenencia_vivienda"]));
                                    ?>
                                    </select>
                                </td>
                            </tr>

                            <tr>
                            <td>&nbsp;</td>
                            <td>&nbsp; </td>
                            <td colspan="4" width="100%">
                            <div id="dvServicios" align="center"></div>
                            </td>
                            </tr>

                                  <tr>
                                <td>&nbsp;</td>
                                <td>
                                    <strong>
                                        &Aacute;rea F&iacute;sico - Ambiental:
                                    </strong>
                                </td>


                                <td colspan="3">
                                   <textarea name="area_fisico" id="area_fisico" rows="5" class="inputbox" onkeypress="return validar_texto(this.form,this,event,'')"  style="width:474px; height:95px; margin-bottom:10px;" <?if(isset($_REQUEST["accion"]) && $_REQUEST["accion"]=="consultar"){echo"readonly='readonly'";}?>><?if(isset($_REQUEST["area_fisico"])){echo $_REQUEST["area_fisico"];}?></textarea>
                                </td>

                                </tr>

                                <tr>
                                <td colspan="6" style="border:#CCCCCC solid 1px;" bgcolor="#F8F8F8" >
                                    <div align="center" style="background-image: url('../comunes/imagenes/barra.png');">
                                        <strong>Perfil SocioEcon&oacute;mico del N&uacute;cleo Familiar</strong>
                                    </div>
                                </td>
                            </tr>

                             <tr>
                                <td>&nbsp;</td>
                                <td>
                                    <strong>
                                        &Aacute;rea Socio Econ&oacute;mica:
                                    </strong>
                                </td>


                                <td colspan="3">
                                   <textarea name="area_economica" id="area_economica" rows="5" class="inputbox" onkeypress="return validar_texto(this.form,this,event,'')"  style="width:474px; height:95px; margin-bottom:10px;" <?if(isset($_REQUEST["accion"]) && $_REQUEST["accion"]=="consultar"){echo"readonly='readonly'";}?>><?if(isset($_REQUEST["area_economica"])){echo $_REQUEST["area_economica"];}?></textarea>
                                </td>

                                </tr>

                              <tr>
                                <td>&nbsp;</td>
                                <td>
                                    <strong>
                                        Condiciones de Salud:
                                    </strong>
                                </td>


                                <td colspan="3">
                                   <textarea name="salud" id="salud" rows="5" class="inputbox" onkeypress="return validar_texto(this.form,this,event,'')"  style="width:474px; height:95px; margin-bottom:10px;" <?if(isset($_REQUEST["accion"]) && $_REQUEST["accion"]=="consultar"){echo"readonly='readonly'";}?>><?if(isset($_REQUEST["salud"])){echo $_REQUEST["salud"];}?></textarea>
                                </td>

                                </tr>

                                <tr>
                                <td>&nbsp;</td>
                                <td>
                                    <strong>
                                        Observaci&oacute;n
                                    </strong>
                                </td>


                                <td colspan="3">
                                   <textarea name="observacion" id="observacion" rows="5" class="inputbox" onkeypress="return validar_texto(this.form,this,event,'')"  style="width:474px; height:95px; margin-bottom:10px;" <?if(isset($_REQUEST["accion"]) && $_REQUEST["accion"]=="consultar"){echo"readonly='readonly'";}?>><?if(isset($_REQUEST["observacion"])){echo $_REQUEST["observacion"];}?></textarea>
                                </td>

                                </tr>
                             
                            <tr>
                                <td>&nbsp;</td>
                                <td>
                                    <strong>
                                        Razon Social:
                                    </strong>
                                </td>
                                <td>
                                    <label>
                                        <input name="razon_social_fami" type="text" class="inputbox" id="razon_social_fami" onkeypress="return validar_texto(this.form,this,event,'')" maxlength="50" value="<?= @$_REQUEST['razon_social_fami'] ?>" ></input>
                                        <input type="hidden" id="idpersona" name="idpersona" value="">
                                    </label>
                                </td>
                                <td>
                                    <strong>C&eacute;dula:</strong>
                                </td>
                                <td>
                                    <input name="cedula_fami" type="text" class="inputbox" id="cedula_fami" maxlength="12" onkeypress="return CedulaFormat(this,'Cédula de Identidad Invalida',-1,true,event)" onmouseout="UnTip()" value="<?= @$_REQUEST['cedula_fami'] ?>" ></input>
                                </td>
                            </tr>


                            <tr>
                                <td>&nbsp;</td>
                                <td>
                                    <strong>
                                        Edad:
                                    </strong>
                                </td>
                                <td>
                                    <label>
                                        <input name="edad_fami" type="text" class="inputbox" id="edad_fami" maxlength="2" onkeypress="return validar_num(this.form,this,event,'')" value="<?= @$_REQUEST['edad_fami'] ?>" ></input>
                                    </label>
                                </td>
                                <td>
                                    <strong>Parentesco:</strong>
                                </td>
                                <td>
                                   <select name="parentesco_fami" id="parentesco_fami" style="width:160px;" class="inputbox">
                                    <option value="0">Seleccione...</option>
                                    <?php
                                    echo ($dat->Cargarlista("select idmaestro, descripcion from vparentesco where estatus=1 order by descripcion", $_REQUEST["parentesco_fami"]));
                                    ?>
                                    </select>
                                </td>
                            </tr>


                            <tr>
                                <td>&nbsp;</td>
                                <td>
                                    <strong>
                                        Grado de Instrucci&oacute;n:
                                    </strong>
                                </td>
                                <td>
                                    <label>
                                       <select name="grado_fami" id="grado_fami" style="width:160px;" class="inputbox">
                                    <option value="0">Seleccione...</option>
                                    <?php
                                    echo ($dat->Cargarlista("select idmaestro, descripcion from vgrado_instruccion where estatus=1 order by descripcion", $_REQUEST["grado_fami"]));
                                    ?>
                                    </select>
                                    </label>
                                </td>
                                <td>
                                    <strong>Ocupaci&oacute;n:</strong>
                                </td>
                                <td>
                                   <select name="ocupacion_fami" id="ocupacion_fami" style="width:160px;" class="inputbox">
                                    <option value="0">Seleccione...</option>
                                    <?php
                                    echo ($dat->Cargarlista("select idmaestro, descripcion from vocupacion where estatus=1 order by descripcion", $_REQUEST["ocupacion_fami"]));
                                    ?>
                                    </select>
                                </td>
                            </tr>

                             <tr>
                                <td>&nbsp;</td>
                                <td><strong>Sexo:</strong></td>
                                <td>
                                    <label>
                                        <select name="sexo_fami" id="sexo_fami" style="width:160px;" class="inputbox">
                                            <option value="" <? if (@$_REQUEST["sexo_fami"]=="") echo "selected";   ?>>Seleccione...</option>
                                            <option value="M" <? if (@$_REQUEST["sexo_fami"]=="M") echo "selected";   ?>>Masculino</option>
                                            <option value="F" <? if (@$_REQUEST["sexo_fami"]=="F") echo "selected";   ?>>Femenino</option>
                                    </select>
                                    </label>
                                </td>
                                <td>
                                    <strong>Ingreso Mensual:</strong>
                                </td>
                                <td>
                                    <input name="ingreso_fami" type="text" class="inputbox" id="ingreso_fami" maxlength="14" style="width:130px;" onkeypress="return validar_monto2(this.form,this,event,'')" value="<?= @$_REQUEST['ingreso_fami'] ?>" ></input>
                                     <a  href="javascript:nueva_persona()"><img src="../comunes/imagenes/user_add.png" onmouseover="Tip('Nuevo Familiar')" onmouseout="UnTip()" style="margin-left:5px; margin-right:5px;" width="16" height="16" border="0" /></a>
                                </td>
                            </tr>



                            <tr>
                                <td colspan="6">
                                    <div id="capaFamiliar" style="overflow:auto">                                        
                                    </div>
									<br />
									<div align="center">
									 	<?   if ((@$_REQUEST["accion"]!="consultar") && ($_REQUEST["idestatus_caso"]!=PRE_APROBADO || $_REQUEST["idestatus_caso"]!=CERRADO))  {  ?>
										<img src="../comunes/imagenes/16_save.gif" onmouseover="Tip('Guardar')" onmouseout="UnTip()" border="0" onclick="javascript:guardar()"/>
										<? }
										   if ($_REQUEST["idinforme"]>0){
										?>
										<img src="../comunes/imagenes/printer.png" onmouseover="Tip('Imprimir Informe')" onmouseout="UnTip()" border="0" onclick="javascript:imprimir('<?=$_REQUEST["idcaso"]?>')"/>
										<?  }   ?>
										<img src="../comunes/imagenes/door_in.png" onmouseover="Tip('Cerrar')" onmouseout="UnTip()" border="0" onclick="javascript:cerrar()"/>
									</div>
                                </td>
                            </tr>

                            

                            <tr>
                                <td>&nbsp;</td>
                                <td align="right"></td>
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